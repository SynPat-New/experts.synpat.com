<?php

// No direct access. 
defined('_JEXEC') or die;

// Include dependancy of the main controllerform class
jimport('joomla.application.component.controllerform');

class SurveyControllerCustomer extends JControllerForm
{

    public function __construct()
    {
        parent::__construct(); 
    }

    public function getModel($name = 'Customer', $prefix = 'SurveyModel', $config = array('ignore_request' => true))
    {
        return parent::getModel($name, $prefix, array('ignore_request' => false));
    }
	
	public function patent(){
		$getPatentNumber = JRequest::getVar("p");
		if(!empty($getPatentNumber)){
			$content = "";
			$url = "http://webdriverforscrape.site/pagesource.php?patent=".$getPatentNumber;
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
			curl_setopt($ch, CURLOPT_TIMEOUT, 60);
			$content = curl_exec($ch);
			curl_close($ch);
			/*
			$url = "https://www.google.com/patents/".$getPatentNumber;
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
			curl_setopt($ch, CURLOPT_TIMEOUT, 60);
			$content = curl_exec($ch);
			curl_close($ch);
			$content = str_replace("/patents/css/","http://www.google.co.in/patents/css/",$content);
			$content = str_replace("/books/javascript/","http://www.google.co.in/books/javascript/",$content);
			$content = str_replace("/googlebooks/images/kennedy/page_left.png","http://www.google.co.in/googlebooks/images/kennedy/page_left.png",$content);
			$content = str_replace("/googlebooks/images/kennedy/page_right.png","http://www.google.co.in/googlebooks/images/kennedy/page_right.png",$content);*/
		
		}
		echo $content;
		die;
	}
	
	
	function show_list(){
		$start = JRequest::getVar('tap','');
		$app = JFactory::getApplication();
		if(!empty($start)){
			$user = JFactory::getUser();
			if($user->id>0){
				$getExpertData = SurveyModelCustomer::expertUserData($user->id);
				$config = JFactory::getConfig();
			$encryptPassword = $config->getValue( 'synpat_symbol' );
			$display = openssl_encrypt($getExpertData->id,"AES-128-ECB",$encryptPassword);
				$getProject = $this->getModel()->checkProjectWithName($start);
				if(count($getProject)>0){
				   $checkDataList = $this->getModel()->retrieveProjectWithCode($getProject[0]->code);
				   if(count($checkDataList)>0){
					   $send = 0;
					    $allIds = array();
					   foreach($checkDataList as $checkData){
						   $allIds[] = $checkData->id;
					   }
					   $findNotification = $this->getModel()->getNotifcationData($allIds,$user->id);
					   if($notficationData->notify==null || $notficationData->notify==0){
						   $insertNotification = $this->getModel()->insertNotificationBulk($allIds,$user->id);
						   if($insertNotification>0){
							   $app->redirect(JRoute::_('component/survey/?task=customer.expertOpportunites&display='.$display, false));
						   } else {
							   $app->redirect(JRoute::_('index.php', false));
						   }						   
					   } else {
						   $app->redirect(JRoute::_('component/survey/?task=customer.expertOpportunites&display='.$display, false));
					   }					   
				   } else {
					   $app->redirect(JRoute::_('index.php', false));
				   }
				} else {
				   $app->redirect(JRoute::_('index.php', false));
			   }
			} else {
			   $app->redirect(JRoute::_('index.php', false));
		   }
		} else {
		   $app->redirect(JRoute::_('index.php', false));
	   }
	}
	
	function start_report(){
		$start = JRequest::getVar('start','');
		$app = JFactory::getApplication();
		if(!empty($start)){
			$user = JFactory::getUser();
			if($user->id>0){
				$getExpertData = SurveyModelCustomer::expertUserData($user->id);
				$config = JFactory::getConfig();
				$encryptPassword = $config->getValue( 'synpat_symbol' );
				$display = openssl_encrypt($getExpertData->id,"AES-128-ECB",$encryptPassword);
				$getProject = $this->getModel()->checkProjectWithName($start);
				if(count($getProject)>0){
				   $checkDataList = $this->getModel()->retrieveProjectWithCode($getProject[0]->code);
				   if(count($checkDataList)>0){
					   $send = 0;
					   foreach($checkDataList as $checkData){
						   $this->getModel()->insertNotification($checkData->id,$user->id);
						   $send = 1;
					   }
					   if($send==1){
						   $app->redirect(JRoute::_('component/survey/?task=customer.expertOpportunites&display='.$display, false));						   
					   } else {
						   $app->redirect(JRoute::_('index.php', false));
					   }
				   } else {
					   $app->redirect(JRoute::_('index.php', false));
				   }
				} else {
					$app->redirect(JRoute::_('index.php', false));
				}			   
			} else {
				$app->redirect(JRoute::_('index.php', false));
			}
		} else {
			$app->redirect(JRoute::_('index.php', false));
		}		
	}

    function childData()
    {
        $parentID = JRequest::getInt('pat');
        $level = JRequest::getInt('l');
        if ($level == 1 || $level == 2 || $level == 0) {
            $getData = $this->getModel()->getChildExpertise($parentID);
            echo json_encode($getData);
        } else if ($level == 3) {
            $getData = $this->getModel()->getChildExpertise($parentID);
            $newArray = array();
            if (count($getData) > 0) {
                for ($i = 0; $i < count($getData); $i++) {
                    $newArray[] = array('id' => $getData[$i]->id, 'name' => $getData[$i]->name, 'classification_description' => $getData[$i]->classification_description, 'parent' => 0, 'level' => 1, 'big_parent' => 0);
                    $checkData = $this->getModel()->getChildExpertise($getData[$i]->id);
                    if (count($checkData) > 0) {
                        for ($s = 0; $s < count($checkData); $s++) {
                            $newArray[] = array('id' => $checkData[$s]->id, 'name' => $checkData[$s]->name, 'classification_description' => $checkData[$s]->classification_description, 'parent' => $getData[$i]->id, 'level' => 2, 'big_parent' => $getData[$i]->id);
                            $checkData1 = $this->getModel()->getChildExpertise($checkData[$s]->id);
                            if (count($checkData1) > 0) {
                                for ($h = 0; $h < count($checkData1); $h++) {
                                    $newArray[] = array('id' => $checkData1[$h]->id, 'name' => $checkData1[$h]->name, 'classification_description' => $checkData1[$h]->classification_description, 'parent' => $checkData[$s]->id, 'level' => 3, 'big_parent' => $getData[$i]->id);
                                    $checkData2 = $this->getModel()->getChildExpertise($checkData1[$h]->id);
                                    if (count($checkData2) > 0) {
                                        for ($m = 0; $m < count($checkData2); $m++) {
                                            $newArray[] = array('id' => $checkData2[$m]->id, 'name' => $checkData2[$m]->name, 'classification_description' => $checkData2[$m]->classification_description, 'parent' => $checkData1[$h]->id, 'level' => 4, 'big_parent' => $getData[$i]->id);
                                            $checkData3 = $this->getModel()->getChildExpertise($checkData2[$m]->id);
                                            if (count($checkData3) > 0) {
                                                for ($n = 0; $n < count($checkData3); $n++) {
                                                    $newArray[] = array('id' => $checkData3[$n]->id, 'name' => $checkData3[$n]->name, 'classification_description' => $checkData3[$n]->classification_description, 'parent' => $checkData2[$m]->id, 'level' => 5, 'big_parent' => $getData[$i]->id);
                                                    $checkData4 = $this->getModel()->getChildExpertise($checkData3[$n]->id);
                                                    if (count($checkData4) > 0) {
                                                        for ($a = 0; $a < count($checkData4); $a++) {
                                                            $newArray[] = array('id' => $checkData4[$a]->id, 'name' => $checkData4[$a]->name, 'classification_description' => $checkData4[$a]->classification_description, 'parent' => $checkData3[$n]->id, 'level' => 6, 'big_parent' => $getData[$i]->id);
                                                            $checkData5 = $this->getModel()->getChildExpertise($checkData4[$a]->id);
                                                            if (count($checkData5) > 0) {
                                                                for ($j = 0; $j < count($checkData5); $j++) {
                                                                    $newArray[] = array('id' => $checkData5[$j]->id, 'name' => $checkData5[$j]->name, 'classification_description' => $checkData5[$j]->classification_description, 'parent' => $checkData4[$a]->id, 'level' => 7, 'big_parent' => $getData[$i]->id);
                                                                    //$checkData6 = $this->getModel()->getChildExpertise($checkData5[$j]->id);
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }                
            }
			echo json_encode($newArray);
        }
    }

    function checklist()
    {
        JRequest::setVar("view", "customer");
        $view = $this->getView("customer", "html");
        $view->setLayout("default");
        $view->setModel($this->getModel(), true);
        $view->projectlist();
    }

    function expertArea()
    {
        JRequest::setVar("view", "customer");
        $view = $this->getView("customer", "html");
        $view->setLayout("expertarea");
        $view->setModel($this->getModel(), true);
        $view->expertArea();
    }
	
	function referral(){
		JRequest::setVar("view", "customer");
        $view = $this->getView("customer", "html");
        $view->setLayout("referral");
        $view->setModel($this->getModel(), true);
        $view->referral();
	}
	
	function ipccodes()
    {
        JRequest::setVar("view", "customer");
        $view = $this->getView("customer", "html");
        $view->setLayout("ipccodes");
        $view->setModel($this->getModel(), true);
        $view->ipccodes();
    }
	
    function expertFeedback(){
		 JRequest::setVar("view", "customer");
		 $view = $this->getView("customer", "html");
		 $view->setLayout("expertfeedback");
		 $view->setModel($this->getModel(), true);
         $view->expertFeedback();
	}
	
	function termsOfUse(){
		 JRequest::setVar("view", "customer");
		 $view = $this->getView("customer", "html");
		 $view->setLayout("termsofuse");
		 $view->setModel($this->getModel(), true);
         $view->termsOfUse();
	}
	
	function privacyPolicy(){
		 JRequest::setVar("view", "customer");
		 $view = $this->getView("customer", "html");
		 $view->setLayout("privacypolicy");
		 $view->setModel($this->getModel(), true);
         $view->privacyPolicy();
	}
	
	function smeAgreement(){
		 JRequest::setVar("view", "customer");
		 $view = $this->getView("customer", "html");
		 $view->setLayout("smeagreement");
		 $view->setModel($this->getModel(), true);
         $view->smeAgreement();
	}
	
	function smeNda(){
		 JRequest::setVar("view", "customer");
		 $view = $this->getView("customer", "html");
		 $view->setLayout("smenda");
		 $view->setModel($this->getModel(), true);
         $view->smeNda();
	}

    function expertRating()
    {
        JRequest::setVar("view", "customer");
        $view = $this->getView("customer", "html");
        $view->setLayout("rating");
        $view->setModel($this->getModel(), true);
        $view->expertRating();
    }

    function viewReport()
    {
        JRequest::setVar("view", "customer");
        $view = $this->getView("customer", "html");
        $view->setLayout("report");
        $view->setModel($this->getModel(), true);
        $view->expertReport();
    }
    
    function expertReport(){
		 JRequest::setVar("view", "customer");
		 $view = $this->getView("customer", "html");
		 $view->setLayout("expertreport");
		 $view->setModel($this->getModel(), true);
		 $view->getExpertReport();
	}
	
	function expertProcess(){
		 JRequest::setVar("view", "customer");
		 $view = $this->getView("customer", "html");
		 $view->setLayout("expertprocess");
		 $view->setModel($this->getModel(), true);
		 $view->expertProcess();
	}
	
	function expertOpportunites(){
		JRequest::setVar("view", "customer");
		 $view = $this->getView("customer", "html");
		 $view->setLayout("expertopportunites");
		 $view->setModel($this->getModel(), true);
		 $view->expertOpportunites();
	}
    function generateClientRequest()
    {
        JRequest::setVar("view", "customer");
        $view = $this->getView("customer", "html");
        $view->setLayout("generateclientrequest");
        $view->setModel($this->getModel(), true);
        $view->generateClientRequest();
    }
	
	function blog(){
		JRequest::setVar("view", "customer");
		$view = $this->getView("customer", "html");
		$view->setLayout("blog");
		$view->setModel($this->getModel(), true);
		$view->blog();
	}

    function surveyList()
    {
        $surveyParam = base64_decode(JRequest::getVar('ps', ''));
        if (!empty($surveyParam)) {
            $surveyData = explode('@', $surveyParam);
            if (count($surveyData) == 2) {
                $getList = $this->getModel()->surveyList($surveyData[1]);
                echo json_encode($getList);
            } else {
                echo json_encode(array());
            }
        } else {
            echo json_encode(array());
        }
    }

    function notification()
    {
        JRequest::setVar("view", "customer");
        $view = $this->getView("customer", "html");
        $view->setLayout("notification");
        $view->setModel($this->getModel(), true);
        $view->notification();
    }
	
	function search_pexpert(){		
		JRequest::setVar("view", "customer");
		$view = $this->getView("customer", "html");
		$view->setLayout("expert");
		$view->setModel($this->getModel(), true);
		$view->expert();
	} 
	
	function search_ipc(){
		$data = JRequest::get('post');
		$getSearchResult = array();
		if(strlen($data['s'])>1){
			$getSearchResult = $this->getModel()->search_ipc($data['s']);
		}
		echo json_encode($getSearchResult);
		die;
	}
	
	function user_log_activity(){
		$data = JRequest::get('post');
		$session = JFactory::getUser();
		$getSession = $this->getModel()->expertUserData($session->id);
		$userData = $this->getModel()->saveActivityData($data,$getSession->id);
		echo $userData;
		die;
	}
	
	function deleteNotification(){
		$data = JRequest::get('post');
		$session = JFactory::getUser();
		$userData = $this->getModel()->deleteNotification($data['d'],$session->id);
		echo $userData;
		die;
	}
	
	function myactivity(){
		JRequest::setVar("view", "customer");
		$view = $this->getView("customer", "html");
		$view->setLayout("myactivity");
		$view->setModel($this->getModel(), true);
		$view->myactivity();
	}
	
	function sendAlert(){
		$p = JRequest::getVar('p', '0');
		$t = JRequest::getVar('t', '');
		$email = JRequest::getVar('e', '');
		$c = JRequest::getVar('c', '0');
		$saveData = $this->getModel()->saveEmailAlert(array('project_id'=>$p,'email_address'=>$email,'survey_id'=>$c));
		echo $saveData;
	}
	
	
    function surveyListAnother()
    {
        $surveyParam = JRequest::getVar('ps', '');
        $pr = JRequest::getInt('pr', 0);
        $pn = JRequest::getVar('pn', '');
        if (!empty($surveyParam)) {
            $getList = $this->getModel()->surveyList($surveyParam,$pr,$pn);
            echo json_encode($getList);
        } else {
            echo json_encode(array());
        }
    }

    function quList()
    {
        $quParam = JRequest::getVar('ps', '');
        if (!empty($quParam)) {
            $getList = $this->getModel()->quList($quParam);
            echo json_encode($getList);
        } else {
            echo json_encode(array('question' => array()));
        }
    }

    function quListExpert()
    {
        $quParam = JRequest::getVar('ps', '');
        $expertID = JRequest::getInt('f');
        if (!empty($quParam)) {
            $getList = $this->getModel()->quListExpert($quParam, $expertID);
            echo json_encode($getList);
        } else {
            echo json_encode(array('question' => array()));
        }
    }

    function notify()
    {
        /*echo $_SERVER['QUERY_STRING'];*/
		$mailer = JFactory::getMailer();
		$from   = "webmaster@synpat.com";
		$fromname = "Vivek Kapoor"; 
		$body = 'cmd=_notify-validate';
		foreach ($_POST as $key => $value) {
			$value = urlencode(stripslashes($value));
			$body .= "&$key=$value";
		}
		if(!empty($_POST['txn_id']) && !empty($_POST['custom'])){
			$updateTransaction = $this->getModel()->updateTrans(array('txn_id'=>$_POST['txn_id']),$_POST['custom']);
		}
		/*$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-Length: " . strlen($body) . "\r\n\r\n";
		$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);
		$fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);		
		if (!$fp) {
			// HTTP ERROR
		} else {
			fputs ($fp, $header . $body);
			while (!feof($fp)) {
				$res = fgets ($fp, 1024);
				$return = JFactory::getMailer()->sendMail($from,$fromname,"webmaster@synpat.com", "VERIFIED URL", $res,true);
				if (strcmp ($res, "VERIFIED") == 0) {
					$return = JFactory::getMailer()->sendMail($from,$fromname,"webmaster@synpat.com", "VERIFIED URL", $body,true);
				} else if (strcmp ($res, "INVALID") == 0) {
					$return = JFactory::getMailer()->sendMail($from,$fromname,"webmaster@synpat.com", "INVALID URL", $body,true);
				}
			}
			fclose ($fp);
		}
		*/
		$updateTransaction = $this->getModel()->updateTrans(array('txn_id'=>$_POST['txn_id']),$_POST['custom']);
		$db = JFactory::getDBO();
		$sql = "SELECT * FROM #__paypal_setting";
		$db->setQuery($sql);
		$getPaypalData = $db->loadObject();
		$paypalEmail = $getPaypalData->email_id;
		$paypal_url = "";
		if ($getPaypalData->mode == 1) {
			$paypal_url = "https://www.paypal.com/cgi-bin/webscr";
		} else {
			$paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
		}
		$ch = curl_init($paypal_url);
		if ($ch == FALSE) {
			return FALSE;
		}
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
		$res = curl_exec($ch);
		$tokens = explode("\r\n\r\n", trim($res));
		$res = trim(end($tokens));
		if (strcmp ($res, "VERIFIED") == 0) {
			if($_POST['payment_status']=="Completed"){
				$getData = $this->getModel()->checkTransUnPaid($_POST['custom']);
				if(count($getData)==0){
					$this->getModel()->updateTrans(array('success'=>'Paid','message'=>'Payment successfully done'),$_POST['custom']);
					JFactory::getMailer()->sendMail($from,$fromname,"webmaster@synpat.com", "VERIFIED URL DOWNLOAD", $res,true);
				}
			} else {
				$return = JFactory::getMailer()->sendMail($from,$fromname,"webmaster@synpat.com", "Pending URL", $body,true);
			}
		} else { 
			$updateTransaction = $this->getModel()->updateTrans(array('txn_id'=>$_POST['txn_id'],'success'=>'unpaid'),$_POST['custom']);
			$return = JFactory::getMailer()->sendMail($from,$fromname,"webmaster@synpat.com", "INVALID URL claimcharts", $body,true);
		}
		/*$return = JFactory::getMailer()->sendMail($data['mailfrom'], $data['fromname'], $data['mailto'], $emailSubject, $emailBody,true);*/
		
		/*echo $return;*/
        die;
    }

    function orderNotify()
    {
        /*echo $_SERVER['QUERY_STRING'];*/
		$mailer = JFactory::getMailer();
		$from   = "webmaster@synpat.com";
		$fromname = "Vivek Kapoor"; 
		$body = 'cmd=_notify-validate';
		foreach ($_POST as $key => $value) {
			$value = urlencode(stripslashes($value));
			$body .= "&$key=$value";
		}
		if(!empty($_POST['txn_id']) && !empty($_POST['custom'])){
			$updateTransaction = $this->getModel()->updateTrans(array('txn_id'=>$_POST['txn_id']),$_POST['custom']);
		}
		/*$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-Length: " . strlen($body) . "\r\n\r\n";
		$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);
		$fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);		
		if (!$fp) {
			// HTTP ERROR
		} else {
			fputs ($fp, $header . $body);
			while (!feof($fp)) {
				$res = fgets ($fp, 1024);
				$return = JFactory::getMailer()->sendMail($from,$fromname,"webmaster@synpat.com", "VERIFIED URL", $res,true);
				if (strcmp ($res, "VERIFIED") == 0) {
					$return = JFactory::getMailer()->sendMail($from,$fromname,"webmaster@synpat.com", "VERIFIED URL", $body,true);
				} else if (strcmp ($res, "INVALID") == 0) {
					$return = JFactory::getMailer()->sendMail($from,$fromname,"webmaster@synpat.com", "INVALID URL", $body,true);
				}
			}
			fclose ($fp);
		}
		*/
		$updateTransaction = $this->getModel()->updateTrans(array('txn_id'=>$_POST['txn_id']),$_POST['custom']);
		$db = JFactory::getDBO();
		$sql = "SELECT * FROM #__paypal_setting";
		$db->setQuery($sql);
		$getPaypalData = $db->loadObject();
		$paypalEmail = $getPaypalData->email_id;
		$paypal_url = "";
		if ($getPaypalData->mode == 1) {
			$paypal_url = "https://www.paypal.com/cgi-bin/webscr";
		} else {
			$paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
		}
		$ch = curl_init($paypal_url);
		if ($ch == FALSE) {
			return FALSE;
		}
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
		$res = curl_exec($ch);
		$tokens = explode("\r\n\r\n", trim($res));
		$res = trim(end($tokens));
		if (strcmp ($res, "VERIFIED") == 0) {
			if($_POST['payment_status']=="Completed"){
				$getData = $this->getModel()->checkTransUnPaid($_POST['custom']);
				if(count($getData)==0){
					$this->getModel()->updateTrans(array('success'=>'Paid','message'=>'Payment successfully done'),$_POST['custom']);
					JFactory::getMailer()->sendMail($from,$fromname,"webmaster@synpat.com", "VERIFIED URL ORDER", $res,true);
				}
			} else {
				$return = JFactory::getMailer()->sendMail($from,$fromname,"webmaster@synpat.com", "Pending URL", $body,true);
			}
		} else {
			$updateTransaction = $this->getModel()->updateTrans(array('txn_id'=>$_POST['txn_id'],'success'=>'unpaid'),$_POST['custom']);
			$return = JFactory::getMailer()->sendMail($from,$fromname,"webmaster@synpat.com", "INVALID URL Claimcharts", $body,true);
		}
		/*$return = JFactory::getMailer()->sendMail($data['mailfrom'], $data['fromname'], $data['mailto'], $emailSubject, $emailBody,true);*/
		
		/*echo $return;*/
        die;
    }

    function success()
    {
        $getRawID = JRequest::getVar('raw');
        $checkID = $this->getModel()->checkTrans($getRawID);
		if (count($checkID) > 0) {
            JRequest::setVar("view", "customer");
            $view = $this->getView("customer", "html");
            $view->setLayout("thanks");
            $view->setModel($this->getModel(), true);
            $view->thanks();
        } else {
            JRequest::setVar("view", "customer");
            $view = $this->getView("customer", "html");
            $view->setLayout("nopage");
            $view->setModel($this->getModel(), true);
            $view->nopage();
        }
    }

    function orderSuccess()
    {
        $getRawID = JRequest::getVar('raw');
        $checkID = $this->getModel()->checkTrans($getRawID);
        if (count($checkID) > 0) {
            $app = JFactory::getApplication();
			/*Create Embedding Code*/
			$message = "<p>Thank you for completing the order. Our team will now break the claim in your order into their elements and send proposals to work on your order to our list of technical experts. If you like to invite additional experts, you may use the form below to edit an email or a post on LinkedIn, Twitter or Facebook</p>";
			$getProjectData = $this->getModel()->getProjectData($checkID->survey_id);			
            JFactory::getApplication()->enqueueMessage($message, 'message');
            $app->redirect('index.php/download/?awse='.base64_encode($getProjectData->name));
        } else {
            JRequest::setVar("view", "customer");
            $view = $this->getView("customer", "html");
            $view->setLayout("nopage");
            $view->setModel($this->getModel(), true);
            $view->nopage();
        }
    }
	
	function reportView(){
		$post = JRequest::get('post');
		$param = $post['p'];
		$runReport = $post['r'];
		$target = $post['t'];
		$target_product = $post['t_p'];
		$decodeParam = base64_decode($param);
		$explodeParam = explode('@',$decodeParam);
		if(count($explodeParam)==3){
			$getExpertData = $this->getModel()->expertData($explodeParam[2]);
			$getSurveyInfo = $this->getModel()->getSurveyData($explodeParam[1]);
			if(count($getSurveyInfo)>0 && count($getExpertData)>0){
				$this->getModel()->updateSurveyAmountExpert($getSurveyInfo->id,$getExpertData->id,$target,$target_product,$runReport);
			}
		}
		die;
	}
	
	
    function cancel()
    {
        $app = JFactory::getApplication();
        $app->redirect('index.php', "You have cancel your payment.", 'message');
    }

    function orderCancel()
    {
        /*Payment Cancelled, Now Delete Every Survey && Project*/
        $transactionID = JRequest::getInt('raw');
        if ($transactionID > 0) {
            $this->getModel('Customer')->deleteRecordClaimAndProject($transactionID);
        }
        $app = JFactory::getApplication();
        $app->redirect('index.php', "You have cancel your payment.", 'message');
    }

    function transaction()
    {
        $random = JRequest::getVar('amt');
        $surveyID = JRequest::getVar('su');
        $expertID = JRequest::getVar('ex');
        $target = JRequest::getVar('target');
        $target_product = JRequest::getVar('target_product');
        if ($random != "" && $target!="" && $target_product!="") {
            $getList = $this->getModel()->insertTrans($random, $surveyID, $expertID,0, 0, $target,$target_product);
            echo $getList;
        } else {
            echo "0";
        }
		die;
    }

    function reEditReport()
    {
        $expertID = JRequest::getVar('ex');
        $surveyID = JRequest::getVar('su');
        $target = JRequest::getVar('target');
        $target_product = JRequest::getVar('target_product');
        $getSurveyData = $this->getModel()->getSurveyData($surveyID);
        $app = JFactory::getApplication();
        if (count($getSurveyData) > 0) {
			$this->getModel()->reEditReport($expertID,$target,$target_product);
            $app->redirect('index.php?option=com_survey&view=answer&target_product='.$target_product.'&target=' . $target . '&param=' . base64_encode($getSurveyData->name . '@' . $surveyID . '@' . $expertID));
        } else {
			$config = JFactory::getConfig();
			$encryptPassword = $config->getValue( 'synpat_symbol' );
			$display = openssl_encrypt($expertID,"AES-128-ECB",$encryptPassword);
            $app->redirect('index.php?option=com_survey&task=customer.expertProfile&display=' . $display);
        }
    }

    function expertProfile()
    {
		
        JRequest::setVar("view", "customer");
        $view = $this->getView("customer", "html");
        $view->setLayout("profile");
        $view->setModel($this->getModel(), true);
        $view->expertProfile();
    }

    function submitRating()
    {
        $post = JRequest::get('post');
        $app = JFactory::getApplication();
        $dataDecode = base64_decode($post['digital_code']);
        $explodeCode = explode('@', $dataDecode);		
        if (count($explodeCode) == 5) {
			$newCode = base64_encode($explodeCode[0].'@'.$explodeCode[1].'@'.$explodeCode[2].'@'.$explodeCode[3]);
			$checkCode = $this->getModel('Customer')->checkCodeWithID($newCode,$explodeCode[4]);

			if(count($checkCode)>0 && $checkCode->trans_id>0){
				/*$this->getModel('Customer')->deleteOldRating($post['digital_code']);*/
				$rating = $this->getModel('Customer')->saveRating($post['rating'], $explodeCode[0], $explodeCode[1], $post['feedback'],$post['digital_code']);
				if ($rating > 0) {
					/*Delete Code for rating*/
					$this->getModel('Customer')->updateDigiCode($post['digital_code'], 1);
					$app->redirect('feedback', 'Thankyou for submit rating for expert.', 'message');
					/*End Delete Code*/
				} else {
					$app->redirect('feedback?display='.$post['digital_code'], 'Error while adding.', 'message');
					//$this->expertRating();
				}
			} else {
				$app->redirect('feedback', 'Wrong input: Please try after some time', 'message');
			}			
        } else {
            $app->redirect('feedback', 'Wrong input: Please try after some time', 'message');
        }
    }
	
	function getNewSerialNumber($flag=0,$serialNumber,$type=1){
		if($flag==1){
			$serialNumber = $this->generateRandomString(5);
		}		
		$checkSerialNumber = $this->getModel()->findSerialNumber($serialNumber,$type);
		
		if($checkSerialNumber==0){
			return $serialNumber;
		} else {
			return $this->getNewSerialNumber(1,$serialNumber,$type);
		}
	}
	
	public function generateRandomString($length = 5) {
		/*$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';*/
		$characters = '0123456789';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

    function downloadSurvey(){
        $post = JRequest::get('post');
        $flag = 0;		
		$getSurevyData = $this->getModel()->checkTrans($post['date_status']);	
        if (count($getSurevyData) > 0) {	
			$getReport =   $this->getModel()->getFullReport((int)$getSurevyData->survey_id,$getSurevyData->target_product,$getSurevyData->target,(int)$getSurevyData->expert_id);
			if(count($getReport)==0){
				
		
			$getSurveyInfo = $this->getModel()->getSurveyData($getSurevyData->survey_id);
			if($getSurveyInfo->report_type==2){
				$getQueAnsData = $this->getModel()->getQueAnsData($getSurevyData->survey_id, $getSurevyData->expert_id, $getSurevyData->target, $getSurevyData->target_product);
			} else {
				$getQueAnsData = $this->getModel()->getQueAnsDataPrior($getSurevyData->survey_id, $getSurevyData->expert_id);
			}
            
            $getExpertData = $this->getModel()->expertData($getSurevyData->expert_id);
            
		    $patentNumber = "";
            $claimNumber = "";
            if (count($getSurveyInfo) > 0) {
                /*$claimNumber = substr($getSurveyInfo->combine_name, strlen($getSurveyInfo->combine_name) - 3);*/
				$patentNumber = $getSurveyInfo->name;
				/*if(stripos(strtoUpper(strtolower($patentNumber)),"US")===false){
					$patentNumber = "US" . $getSurveyInfo->name;
				}*/
            }
            if((int)$getExpertData->expert_type==2){
				$name = $getExpertData->company_name;
			} else {
				$name = $getExpertData->name;
			}
			//$username = $getExpertData->username;
			//$emailAddress = $username."@claimcharts.info";
			//$showWebaddress = str_replace('.','__',$username);
			//$web = JUri::base().$showWebaddress;
            //$profileImage = $getExpertData->linkedin_pic;
			
			preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $getExpertData->profile_desc, $matches);
			$profileImage = $matches[1][0];
            if ($profileImage == "") {
                $profileImage = 'https://placehold.it/120x120';
            }
            $profileUrl = $getExpertData->linkedin_profile_url;
			
            if (count($getQueAnsData) > 0) {
                $expertRatingData = $this->getModel()->expertRatingData($getSurevyData->expert_id);
                $overAllRating = 0;
                $totalProject = 0;
                $calcRating = 0;
                for ($i = 0; $i < count($expertRatingData); $i++) {
                    if ($i == 0) {

                    }
                    $overAllRating = $overAllRating + $expertRatingData[$i]->rating;
                    $totalProject = $totalProject + $expertRatingData[$i]->countSurvey;
                }
                if ($totalProject > 0 && $overAllRating > 0) {
                    $calcRating = round($overAllRating / $totalProject, 1);
                }
                $class = "";
                if ($calcRating > 0) {
                    if ($calcRating == 1) {
                        $class = "s_star_1_0";
                    } else if (($calcRating > 1 && $calcRating < 1.5) || ($calcRating > 1.5 && $calcRating < 2)) {
                        $class = "s_star_1_5";
                    } else if ($calcRating == 2) {
                        $class = "s_star_2_0";
                    } else if (($calcRating > 2 && $calcRating < 2.5) || ($calcRating > 2.5 && $calcRating < 3)) {
                        $class = "s_star_2_5";
                    } else if ($calcRating == 3) {
                        $class = "s_star_3_0";
                    } else if (($calcRating > 3 && $calcRating < 3.5) || ($calcRating > 3.5 && $calcRating < 4)) {
                        $class = "s_star_3_5";
                    } else if ($calcRating == 4) {
                        $class = "s_star_4_0";
                    } else if (($calcRating > 4 && $calcRating < 4.5) || ($calcRating > 4.5 && $calcRating < 5)) {
                        $class = "s_star_4_5";
                    } else if ($calcRating == 5) {
                        $class = "s_star_5_0";
                    }
                } else {
                    $class = "s_star_0_0";
                }
                
                $urlQueryString = "";
				$urlQueryString = base64_encode($getSurevyData->survey_id . "@" . $getSurevyData->expert_id . "@" . $getSurevyData->target."@". $getSurevyData->target_product);
				$getReport = $this->getModel('Customer')->getReportID($getSurevyData->survey_id,$getSurevyData->target_product,$getSurevyData->target,$getSurevyData->expert_id);
				$checkCodeGenerate = array();
				if(count($getReport)>0){
					$checkCodeGenerate = $this->getModel('Customer')->checkDigiCodeGenerate($getReport->id);
				}
				if(count($checkCodeGenerate)==0 && count($getReport)>0){
					$getDigiID = $this->getModel('Customer')->generateDigiCode($urlQueryString, $getReport->id);
				} else {
					$getDigiID = $checkCodeGenerate->id;
				}
                if ($getDigiID > 0) {
                    if (count($checkCodeGenerate) == 0) {
                        $urlQueryString = base64_encode($getSurevyData->survey_id . "@" . $getSurevyData->expert_id . "@" . $getSurevyData->target."@". $getSurevyData->target_product . "@" . $getDigiID);
                    } else {
                        $urlQueryString = $checkCodeGenerate->code_generate;
                        $urlQueryString = base64_decode($urlQueryString);
                        $urlQueryString .= "@" . $getDigiID;
                        $urlQueryString = base64_encode($urlQueryString);
                    }
					/*Check Exclusivity Report*/
					if((int)$getSurveyInfo->exclude==1){
						/*Transfer data to temporary table and Delte from Main Table*/
						$saveData = $this->getModel()->insertDataToTempTable($getSurveyInfo,$getQueAnsData);
						if($saveData>0){
							$this->getModel()->deleteSurveyReports($getSurveyInfo);
						}						
						/*End Transfer data to temporary table*/
						$flag = 1;
					}
					/*End Check Exclusivity Report*/
                    $URL = JUri::base() . 'feedback?display=' . $urlQueryString;					
					
                    $html = "";
                    $html .= '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
			<html>
			<head>
				<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
				<title>PDF Report</title>
				<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,700&amp;v1&amp;subset=latin,latin-ext" type="text/css" media="screen" />
				<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
			   
			   <style type="text/css">
					body {
						font-family: arial,Serif;
						font-size: 12px;
					}

					a:hover {
						text-decoration: underline !important;
					}

					.s_star_1_0 {
						background-position: -82px 0 !important;
						height: 13px;
						width: 65px;
					}

					.s_star_1_5 {
						background-position: -69px -20px !important;
						height: 13px;
						width: 65px;
					}

					.s_star_2_0 {
						background-position: -69px 0 !important;
						height: 13px;
						width: 65px;
					}

					.s_star_2_5 {
						background-position: -56px -20px !important;
						height: 13px;
						width: 65px;
					}

					.s_star_3_0 {
						background-position: -56px 0 !important;
						height: 13px;
						width: 65px;
					}

					.s_star_3_5 {
						background-position: -43px -20px !important;
						height: 13px;
						width: 65px;
					}

					.s_star_4_0 {
						background-position: -43px 0 !important;
						height: 13px;
						width: 65px;
					}

					.s_star_4_5 {
						background-position: -30px -20px !important;
						height: 13px;
						width: 65px;
					}

					.s_star_5_0 {
						background-position: -30px 0 !important;
						height: 13px;
						width: 65px;
					}

					.s_star_0_0 {
						background-position: -95px 0 !important;
						height: 13px;
						width: 65px;
					}

					.swSprite {
						background: url("https://claimcharts.synpat.com/templates/survey/img/sprite-star.png") no-repeat scroll 0 0 transparent;
						display: inline-block;
						margin: 0;
						overflow: hidden;
						padding: 0;
						position: relative;
						vertical-align: middle;
					}

						.swSprite span {
							left: -9999px;
						}
				</style>


				<style type="text/css">
					body {
						background-color: #ffffff;
					}

					.report-container {
						background-color: #ffffff;
						box-shadow: 0 0 7px #555;
						color: #535353;
						font-family: Open Sans, Helvetica, Arial, serif;
						font-size: 13px;
						line-height: 1.4;
						margin: 5px auto;
						padding: 50px 71px;
						padding: 15px 30px;
						/*width: 816px;*/
						position: relative;
						width: 674px;
						width: 620px;
					}

					.report-container h1,
					.report-container h2,
					.report-container h3,
					.report-container h4,
					.report-container h5,
					.report-container h6 {
						color: #b90022;
						font-family: Open Sans, Helvetica, Arial, serif !important;
						margin-top: 20px !important;
					}

					.report-container .button-pdf {
						position: relative;
						top: -7px;
					}

					.report-container img {
						display: inline-block;
						height: auto;
						max-width: 100%;
					}

					.report-container h1 {
						font-size: 36px;
						margin-bottom: 20px;
						margin-top: 10px;
						width:100% !important;
					}

					.report-container h2 {
						font-size: 30px;
						margin-bottom: 20px;
						width:100% !important;
					}

					.report-container h3 {
						border-bottom: 1px solid #b90022;
						font-size: 24px;
						margin-bottom: 15px;
						width:100% !important;
					}

					.report-container h4 {
						font-size: 18px;
						margin-bottom: 15px;
						width:100% !important;
					}

					.report-container h5 {
						font-size: 16px;
						margin-bottom: 10px;
						width:100% !important;
					}

					.report-container h6 {
						font-size: 14px;
						margin-bottom: 10px;
						width:100% !important;
					}

					.report-container p {
						overflow: hidden !important;
						text-overflow: ellipsis !important;
						max-width: 580px !important;
					}

					.report-container a {
						color: #535353;
						text-decoration: underline;
					}

						.report-container a:hover,
						.report-container a:focus {
							color: #535353;
							text-decoration: none !important;
						}

					.report-container .button {
						background: #cd2122;
						border: 0;
						border-radius: 3px;
						box-shadow: none;
						color: #fff;
						display: inline-block;
						font-size: 14px;
						line-height: 20px;
						margin-bottom: 0;
						padding: 4px 12px;
						position: relative;
						text-decoration: none;
						text-shadow: 0 1px 0 rgba(0,0,0,.8);
					}

						.report-container .button:hover,
						.report-container .button:focus {
							background: #333333;
							color: #fff;
						}

					.report-container hr {
						background: none;
						border: none;
						border-top: 1px solid #e5e5e5;
						height: 1px;
						margin-bottom: 20px;
						margin-top: 20px;
					}

					.report-answer table {
						border-collapse: collapse !important;
					}

						.report-answer table[align=right] {
							margin-left: 20px;
						}

						.report-answer table[align=left] {
							margin-right: 20px;
						}

						.report-answer table th,
						.report-answer table td {
							border: 1px solid #e5e5e5;
							padding: 5px 7px;
						}

						.report-answer table ul,
						.report-answer table ol {
							margin-bottom: 10px;
							margin-top: 10px;
						}

						.report-answer table h1,
						.report-answer table h2,
						.report-answer table h3,
						.report-answer table h4,
						.report-answer table h5,
						.report-answer table h6 {
							margin-bottom: 10px;
							margin-top: 0;
						}

					.report-container .training-nav-top {
						border: 1px solid #e5e5e5;
						float: right;
						margin-left: 30px;
						padding-left: 10px;
						padding-right: 10px;
						width: 230px;
					}

					.report-container .training-nav-top-title {
						margin-left: -10px;
						margin-right: -10px;
						padding: 10px 10px;
						text-align: center;
					}

					.report-container .training-nav-top h6 {
						border-top: 1px solid #e5e5e5;
						margin-bottom: 5px;
						margin-left: -10px;
						margin-right: -10px;
						margin-top: 0;
						padding: 6px 10px 0;
					}

					.report-container .training-nav-top ul {
						margin-top: 0;
						padding-left: 25px;
					}

					.report-container .training-nav-top .button {
						margin-top: -5px;
					}

					.report-container-question {
						font-size: 14px;
						font-weight: 600;
					}
					.report-container-question p {
						margin-bottom: 15px !important;
					}

					.report-container-answer {
						font-family: Open Sans, Helvetica, Arial, serif !important;
						font-size: 13px;
					}
					.report-container-answer * {
						font-family: Open Sans, Helvetica, Arial, serif !important;
					}
					.report-container-answer p {
						color: #535353 !important;
						font-size: 13px !important;
						line-height: 1.4 !important;
						margin-bottom: 15px !important;
					}
					.report-container-answer div {
						color: #535353 !important;
						font-size: 13px !important;
						line-height: 1.4 !important;
					}
					.report-container-answer ul {
						padding-left: 25px;
					}

					.report-container-answer pre {
						background: #f4f4f4;
						border: 1px solid #e5e5e5;
						font-family: monospace !important;
						font-size: 13px !important;
						line-height: 1.4 !important;
						margin: 0 !important;
						padding: 20px 0 !important;
					}

					.report-container-answer code {
						background: #f4f4f4 !important;
						border: 1px solid #e5e5e5 !important;
						padding: 1px 5px !important;
					}

						.report-container-answer code a {
							text-decoration: none;
						}

				</style>
					<script>
						var message="Function Disabled!"; 
						function clickIE4(){ 
							if (event.button==2){ alert(message);
								return false; 
							} 
						} 
						function clickNS4(e){ 
							if (document.layers||document.getElementById&&!document.all){ 
								if (e.which==2||e.which==3){
									alert(message);
									return false;
								}
							} 
						}
						if (document.layers){
							document.captureEvents(Event.MOUSEDOWN);
							document.onmousedown=clickNS4; 
						} else if (document.all&&!document.getElementById){
							document.onmousedown=clickIE4; 
						}
						document.oncontextmenu=new Function("return false");	
					</script>
				<style type="text/css" media="print">
					* { display: none; }
				</style>
				</head>

				<body marginheight="0" topmargin="0" marginwidth="0" style="margin: 0px; margin-left: 0px" ondragstart="return false" onselectstart="return false">
				<div class="report-container">
					<table width="100%">
						<tr>
							<td>
								<table border="0" cellspacing="0" cellpadding="0" align="center" width="100%">
									<tr>
										<td valign="top" width="150">
											<img src="' . $profileImage . '" style="width: 120px;margin-top:5px;" /></td>
										<td width="10"></td>
										<td valign="top" >
											<p style="display: block;margin:0px;">
												' . $name . '&nbsp;<span class="swSprite ' . $class . '"></span><br /> ' ;
												if(!empty($getExpertData->address)){
													$html .= $getExpertData->address . ',<br /> ';
												}
												if(!empty($getExpertData->email)){
													$html .= $getExpertData->email . ',<br /> ';
												}
												
												if(!empty($getExpertData->phone)){
													$html .= $getExpertData->phone . ',<br /> ';
												}
												if(!empty($getExpertData->web)){
													$html .= $getExpertData->web . ',<br /> ';
												}
												
											$html .= '
											</p>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>

					<div style="margin: 0 auto; border-bottom: 4px solid #b90022;">&nbsp;</div>
					<div style="margin: 0 auto; margin-top: 1px; border-bottom: 1px solid #b90022;">&nbsp;</div>

					<table cellspacing="0" border="0" cellpadding="0" width="100%">
						<tr>
							<td valign="top" align="left">
								<h3>'.$getSurevyData->target .' '. $getSurevyData->target_product.'</h3>
								<h2>Report of Evidence of Use</h2>
								<p>
									The views presented here are of the author only and do not necessarily reflect the views of others. The author is an independent contractor that acts on behalf of neither the patent owner nor any other third party, including SynPat.com/experts. We would like to thank SynPat.com/experts for introducing to us the opportunity to prepare this report.  For comments and questions, please feel free to contact us directly, or via my profile at SynPat.com/experts.
								</p>
							</td>
						</tr>
					</table>

					<table cellspacing="0" border="0" cellpadding="0" width="100%">
						<tr>
							<td valign="top" align="left">
								<h3>Patent Number: ' . $patentNumber . '</h3>';								
								$html .='<p>';
									$textShow = "";
									for ($i = 0; $i < count($getQueAnsData); $i++) {
										$textShow .= $getQueAnsData[$i]->description . " ";
									}


									$html .= $textShow . '
								</p>
							</td>
						</tr>
					</table>';
					$d = 1;
					for ($i = 0; $i < count($getQueAnsData); $i++) {
						$html .= '<table cellspacing="0" border="0" cellpadding="0" width="100%">
									<tr>
										<td valign="top" align="left">
											<h3>Element ' . $d . ':</h3>
											<div class="report-container-question"><p>
												' . $getQueAnsData[$i]->description . '
											</div></p>
											<div class="report-container-answer"><div>' . preg_replace('#(<[a-z ]*)(style=("|\')(.*?)("|\'))([a-z ]*>)#', '\\1\\6', $getQueAnsData[$i]->answer) . ' </div></div>
										</td>
									</tr>';
									if ($getQueAnsData[$i]->supporting_document != "") {
										$allFiles = explode(',',$getQueAnsData[$i]->supporting_document);
										foreach($allFiles as $file){
											if($file!=""){
												$html .= ' <tr>
																<td valign="top">
																	<p>Supporting Evidence:</p>
																	<img src="' . JUri::base() . 'components/com_survey/document/' . $file . '"/>
																</td>
															  </tr>';
											}
										}
									}
								$html .= '</table>';
						$d++;
					}

    


				$html .= '<table cellspacing="0" border="0" cellpadding="0" width="100%">
					<tr>
						<td align="center">*&nbsp;&nbsp;*&nbsp;&nbsp;*&nbsp;&nbsp;*&nbsp;&nbsp;*</td>
					</tr>
					<tr>
						<td height="20" align="center">
							<p>End of Report</p>
						</td>
					</tr>
				</table><div style="page-break-before:always"></div>


				<table cellspacing="0" border="0" cellpadding="0" width="100%">
					<tr>
						<td valign="top" align="left">
							<p>
								Please rank my report. The following link leads to our profile at ClaimCharts.info, where you could rank our report.<br />
								<a href="' . $URL . '">Rank Here</a>
							</p>
							<p>Evaluation Code: '.$urlQueryString.'</p>
							<p>
								We are available to answer follow up questions, provide clarifications and search for additional materials upon request. For public contact - please refer to our profile at
								<a href="' . JUri::base() . 'index.php?option=com_survey&task=customer.expertProfile&display=' . $getSurevyData->expert_id . '#commenting">ClaimCharts.synpat.com</a>.
								For private contact - please call/email us.
							</p>
							<p>
								Our hourly rate is: $' . $getExpertData->hourly_rate . '
							</p>
							<h4>Non-Disclosure Agreement:</h4>
							<p>
								We understand that for the purpose of assisting you in collecting data, you may disclose to us certain confidential information that you want to keep confidential; therefore, for good and valuable consideration, the receipt and sufficiency of which is hereby acknowledged, we agree as follows:
							</p>
							<p>
								1. For a period of twelve (36) months from the date we receive your confidential information ("Effective Date"), we will not use or disclose the information, except: (a) in the event that such information (i) comes into the public domain not through us; (ii) is already known to us at the time of disclosure; (iii) is lawfully otherwise learnt or independently developed by us; or (iv) is required to be disclosed by law.
							</p>
							<p>
								2. Since a breach of our obligations hereunder may result in irreparable harm to you, we agree that upon such breach or threat thereof, you shall be entitled to specific performance and other injunctive relief without posting a bond, and in the event of disclosures required by court order, we shall promptly notify you of the proceeding.
							</p>
							<p>
								3. This agreement supersedes all prior discussions and writings and constitutes the entire agreement between you and us with respect to the subject matter hereof.  This Agreement shall be binding upon the successors and assigns of the respective parties, and may not be modified except by an instrument executed by both parties.
							</p>
							<p>
								' . $name . '<br />' . $getExpertData->company_name . '
							</p>
						</td>
					</tr>
				</table>

			</div>

			</body>
			</html>';
			
					/*$file = JPATH_LIBRARIES . '/pdfcrowd.php';
					if (!JFile::exists($file)) {
                        return false;
                    }
					require_once($file);	
					try
					{   
						
						// create an API client instance
						$client = new \Pdfcrowd\HtmlToPdfClient("vivekwebmaster", "40d98906f7c433d915148346461140c4");
						$random = $name.'_'.$getSurveDetail->combine_name.'_'.$getSurevyData->target.' '.$getSurevyData->target_product.'_'.$getExpertData->email;						
						$fileNAME = JPATH_COMPONENT.DS."reports".DS.$random.".pdf";
						$client->convertStringToFile($html, $fileNAME);
						$query = "UPDATE #__survey_amount_expert SET file_name='".$fileNAME."' WHERE expert_id=".(int)$getSurevyData->expert_id." AND survey_id=".(int)$getSurevyData->survey_id." AND target='".$getSurevyData->target."' AND target_product='".$getSurevyData->target_product."'";
						$db = JFactory::getDBO();
						$db->setQuery($query);
						$db->query();		
						// set HTTP response headers
						header("Content-Type: application/pdf");
						header('Content-Disposition: attachment; filename="'.basename($fileNAME).'"');
						header('Expires: 0');
						header('Cache-Control: must-revalidate');
						header('Pragma: public');
						header('Content-Length: ' . filesize($fileNAME));
						readfile($fileNAME);
						// send the generated PDF 
						if($flag==1){
							die("Thank you for download report exclusive only for you.<a href='".JUri::base()."'>Click here to return </a>");
						} else {
							exit(0);
						}
					}
					catch(\Pdfcrowd\Error $why)
					{
						echo  $why;
						exit(0);
					}*/
					$file = JPATH_LIBRARIES . '/pdflayer.class.php';
					if (!JFile::exists($file)) {
                        return false;
                    }
					require_once($file);
					try{
						$html2pdf = new pdflayer();
						$html2pdf->set_param('document_html',$html);
						$html2pdf->convert();
						$random = $name.'_'.$getSurveDetail->combine_name.'_'.$target.' '.$target_product.'_'.$getExpertData->email;						
						$fileNAME = JPATH_COMPONENT.DS."reports".DS.$random.".pdf";
						file_put_contents($fileNAME, $html2pdf->pdf);						
						$query = "UPDATE #__survey_amount_expert SET file_name='".$fileNAME."' WHERE expert_id=".(int)$getSurevyData->expert_id." AND survey_id=".(int)$getSurevyData->survey_id." AND target='".$getSurevyData->target."' AND target_product='".$getSurevyData->target_product."'";
						$db = JFactory::getDBO();
						$db->setQuery($query);
						$db->query();
						$html2pdf->download_pdf();
					}catch(Exception $e){
						print_r($e);
						exit(0);
					}
					die;
					
                }else {		
					$app = JFactory::getApplication();
					$app->redirect('index.php','Invalid report','error');		
				}				
            }else {		
				$app = JFactory::getApplication();
				$app->redirect('index.php','Invalid report','error');		
			}

			} else {
				$fileName = $getReport->file_name;
				header("Content-Type: application/pdf");
				header('Content-Disposition: attachment; filename="'.basename($fileName).'"');
				header('Expires: 0');
				header('Cache-Control: must-revalidate');
				header('Pragma: public');
				header('Content-Length: ' . filesize($fileName));
				readfile($fileName);
				die;
			}
        } else {		
			$app = JFactory::getApplication();
			$app->redirect('index.php','Invalid report','error');		
		}
    }

    function downloadSurvey1()
    {
        $post = JRequest::get('post');
        $flag = 0;
		$getSurevyData = $this->getModel()->checkTrans($post['date_status']);			
        if (count($getSurevyData) > 0) {			
           /* $getQueAnsData = $this->getModel()->getQueAnsData($getSurevyData->survey_id, $getSurevyData->expert_id, $getSurevyData->target);*/
			if($getSurveyData->report_type==2){
				$getQueAnsData = $this->getModel()->getQueAnsData($getSurevyData->survey_id, $getSurevyData->expert_id, $getSurevyData->target, $getSurevyData->target_product);
			} else {
				$getQueAnsData = $this->getModel()->getQueAnsDataPrior($getSurevyData->survey_id, $getSurevyData->expert_id);
			}
            $getExpertData = $this->getModel()->expertData($getSurevyData->expert_id);
            $getSurveyInfo = $this->getModel()->getSurveyData($getSurevyData->survey_id);
		    $patentNumber = "";
            $claimNumber = "";
            if (count($getSurveyInfo) > 0) {
                $claimNumber = substr($getSurveyInfo->combine_name, strlen($getSurveyInfo->combine_name) - 3, -1);
                $patentNumber = "US" . $getSurveyInfo->name;
            }
            if((int)$getExpertData->expert_type==2){
				$name = $getExpertData->company_name;
			} else {
				$name = $getExpertData->name;
			}
            //$profileImage = $getExpertData->linkedin_pic;
			
			preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $getExpertData->profile_desc, $matches);
			$profileImage = $matches[1][0];
            if ($profileImage == "") {
                $profileImage = 'http://placehold.it/120x120';
            }
            $profileUrl = $getExpertData->linkedin_profile_url;
            if (count($getQueAnsData) > 0) {
                $expertRatingData = $this->getModel()->expertRatingData($getSurevyData->expert_id);
                $overAllRating = 0;
                $totalProject = 0;
                $calcRating = 0;
                for ($i = 0; $i < count($expertRatingData); $i++) {
                    if ($i == 0) {

                    }
                    $overAllRating = $overAllRating + $expertRatingData[$i]->rating;
                    $totalProject = $totalProject + $expertRatingData[$i]->countSurvey;
                }
                if ($totalProject > 0 && $overAllRating > 0) {
                    $calcRating = round($overAllRating / $totalProject, 1);
                }
                $class = "";
                if ($calcRating > 0) {
                    if ($calcRating == 1) {
                        $class = "s_star_1_0";
                    } else if (($calcRating > 1 && $calcRating < 1.5) || ($calcRating > 1.5 && $calcRating < 2)) {
                        $class = "s_star_1_5";
                    } else if ($calcRating == 2) {
                        $class = "s_star_2_0";
                    } else if (($calcRating > 2 && $calcRating < 2.5) || ($calcRating > 2.5 && $calcRating < 3)) {
                        $class = "s_star_2_5";
                    } else if ($calcRating == 3) {
                        $class = "s_star_3_0";
                    } else if (($calcRating > 3 && $calcRating < 3.5) || ($calcRating > 3.5 && $calcRating < 4)) {
                        $class = "s_star_3_5";
                    } else if ($calcRating == 4) {
                        $class = "s_star_4_0";
                    } else if (($calcRating > 4 && $calcRating < 4.5) || ($calcRating > 4.5 && $calcRating < 5)) {
                        $class = "s_star_4_5";
                    } else if ($calcRating == 5) {
                        $class = "s_star_5_0";
                    }
                } else {
                    $class = "s_star_0_0";
                }
                $checkCodeGenerate = $this->getModel('Customer')->checkDigiCodeGenerate($post['date_status']);
                $urlQueryString = "";
				$urlQueryString = base64_encode($getSurevyData->survey_id . "@" . $getSurevyData->expert_id . "@" . $post['date_status']);
				if(count($checkCodeGenerate)==0){					
					$getDigiID = $this->getModel('Customer')->generateDigiCode($urlQueryString, $post['date_status']);
				} else {
					$getDigiID = $checkCodeGenerate->id;
				}
				
                if ($getDigiID > 0) {
                    /*if (count($checkCodeGenerate) == 0) {
                        $urlQueryString = base64_encode($getSurevyData->survey_id . "@" . $getSurevyData->expert_id . "@" . $post['date_status'] . "@" . $getDigiID);
                    } else {
                        $urlQueryString = $checkCodeGenerate->code_generate;
                        $urlQueryString = base64_decode($urlQueryString);
                        $urlQueryString .= "@" . $checkCodeGenerate->id;
                        $urlQueryString = base64_encode($urlQueryString);
                    }*/
					/*Check Exclusivity Report*/
					if((int)$getSurveyInfo->exclude==1){
						/*Transfer data to temporary table and Delte from Main Table*/
						$saveData = $this->getModel()->insertDataToTempTable($getSurveyInfo,$getQueAnsData);
						if($saveData>0){
							$this->getModel()->deleteSurveyReports($getSurveyInfo);
						}						
						/*End Transfer data to temporary table*/
						$flag = 1;
					}
					/*End Check Exclusivity Report*/
                    $URL = JUri::base() . 'feedback?display=' . $urlQueryString;					
					
                    $html = "";

                   $html .= '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
			<html>
			<head>
				<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
				<title>PDF Report</title>
				<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:400,400italic,700&amp;v1&amp;subset=latin,latin-ext" type="text/css" media="screen" />
				<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
			   
			   <style type="text/css">
					body {
						font-family: arial,Serif;
						font-size: 12px;
					}

					a:hover {
						text-decoration: underline !important;
					}

					.s_star_1_0 {
						background-position: -82px 0 !important;
						height: 13px;
						width: 65px;
					}

					.s_star_1_5 {
						background-position: -69px -20px !important;
						height: 13px;
						width: 65px;
					}

					.s_star_2_0 {
						background-position: -69px 0 !important;
						height: 13px;
						width: 65px;
					}

					.s_star_2_5 {
						background-position: -56px -20px !important;
						height: 13px;
						width: 65px;
					}

					.s_star_3_0 {
						background-position: -56px 0 !important;
						height: 13px;
						width: 65px;
					}

					.s_star_3_5 {
						background-position: -43px -20px !important;
						height: 13px;
						width: 65px;
					}

					.s_star_4_0 {
						background-position: -43px 0 !important;
						height: 13px;
						width: 65px;
					}

					.s_star_4_5 {
						background-position: -30px -20px !important;
						height: 13px;
						width: 65px;
					}

					.s_star_5_0 {
						background-position: -30px 0 !important;
						height: 13px;
						width: 65px;
					}

					.s_star_0_0 {
						background-position: -95px 0 !important;
						height: 13px;
						width: 65px;
					}

					.swSprite {
						background: url("https://claimcharts.synpat.com/templates/survey/img/sprite-star.png") no-repeat scroll 0 0 transparent;
						display: inline-block;
						margin: 0;
						overflow: hidden;
						padding: 0;
						position: relative;
						vertical-align: middle;
					}

						.swSprite span {
							left: -9999px;
						}				
					body {
						background-color: #fff;
					}

					.report-container {
						background-color: #ffffff;
						box-shadow: 0 0 7px #fff;
						color: #535353;
						font-family: Open Sans, Helvetica, Arial, serif;
						font-size: 13px;
						line-height: 1.4;
						margin: 5px auto;
						padding: 50px 71px;
						padding: 15px 30px;
						/*width: 816px;*/
						position: relative;
						width: 674px;
						width: 620px;
					}

					.report-container h1,
					.report-container h2,
					.report-container h3,
					.report-container h4,
					.report-container h5,
					.report-container h6 {
						color: #b90022;
						font-family: Open Sans, Helvetica, Arial, serif !important;
						margin-top: 20px !important;
					}

					.report-container .button-pdf {
						position: relative;
						top: -7px;
					}

					.report-container img {
						display: inline-block;
						height: auto;
						max-width: 100%;
					}

					.report-container h1 {
						font-size: 36px;
						margin-bottom: 20px;
						margin-top: 10px;
						width:100% !important;
					}

					.report-container h2 {
						font-size: 30px;
						margin-bottom: 20px;
						width:100% !important;
					}

					.report-container h3 {
						border-bottom: 1px solid #b90022;
						font-size: 24px;
						margin-bottom: 15px;
						width:100% !important;
					}

					.report-container h4 {
						font-size: 18px;
						margin-bottom: 15px;
						width:100% !important;
					}

					.report-container h5 {
						font-size: 16px;
						margin-bottom: 10px;
						width:100% !important;
					}

					.report-container h6 {
						font-size: 14px;
						margin-bottom: 10px;
						width:100% !important;
					}

					.report-container p {
						overflow: hidden !important;
						text-overflow: ellipsis !important;
						max-width: 580px !important;
					}

					.report-container a {
						color: #535353;
						text-decoration: underline;
					}

						.report-container a:hover,
						.report-container a:focus {
							color: #535353;
							text-decoration: none !important;
						}

					.report-container .button {
						background: #cd2122;
						border: 0;
						border-radius: 3px;
						box-shadow: none;
						color: #fff;
						display: inline-block;
						font-size: 14px;
						line-height: 20px;
						margin-bottom: 0;
						padding: 4px 12px;
						position: relative;
						text-decoration: none;
						text-shadow: 0 1px 0 rgba(0,0,0,.8);
					}

						.report-container .button:hover,
						.report-container .button:focus {
							background: #333333;
							color: #fff;
						}

					.report-container hr {
						background: none;
						border: none;
						border-top: 1px solid #e5e5e5;
						height: 1px;
						margin-bottom: 20px;
						margin-top: 20px;
					}

					.report-answer table {
						border-collapse: collapse !important;
					}

						.report-answer table[align=right] {
							margin-left: 20px;
						}

						.report-answer table[align=left] {
							margin-right: 20px;
						}

						.report-answer table th,
						.report-answer table td {
							border: 1px solid #e5e5e5;
							padding: 5px 7px;
						}

						.report-answer table ul,
						.report-answer table ol {
							margin-bottom: 10px;
							margin-top: 10px;
						}

						.report-answer table h1,
						.report-answer table h2,
						.report-answer table h3,
						.report-answer table h4,
						.report-answer table h5,
						.report-answer table h6 {
							margin-bottom: 10px;
							margin-top: 0;
						}

					.report-container .training-nav-top {
						border: 1px solid #e5e5e5;
						float: right;
						margin-left: 30px;
						padding-left: 10px;
						padding-right: 10px;
						width: 230px;
					}

					.report-container .training-nav-top-title {
						margin-left: -10px;
						margin-right: -10px;
						padding: 10px 10px;
						text-align: center;
					}

					.report-container .training-nav-top h6 {
						border-top: 1px solid #e5e5e5;
						margin-bottom: 5px;
						margin-left: -10px;
						margin-right: -10px;
						margin-top: 0;
						padding: 6px 10px 0;
					}

					.report-container .training-nav-top ul {
						margin-top: 0;
						padding-left: 25px;
					}

					.report-container .training-nav-top .button {
						margin-top: -5px;
					}

					.report-container-question {
						font-size: 14px;
						font-weight: 600;
					}
					.report-container-question p {
						margin-bottom: 15px !important;
					}

					.report-container-answer {
						font-family: Open Sans, Helvetica, Arial, serif !important;
						font-size: 13px;
					}
					.report-container-answer * {
						font-family: Open Sans, Helvetica, Arial, serif !important;
					}
					.report-container-answer p {
						color: #535353 !important;
						font-size: 13px !important;
						line-height: 1.4 !important;
						margin-bottom: 15px !important;
					}
					.report-container-answer div {
						color: #535353 !important;
						font-size: 13px !important;
						line-height: 1.4 !important;
					}
					.report-container-answer ul {
						padding-left: 25px;
					}

					.report-container-answer pre {
						background: #f4f4f4;
						border: 1px solid #e5e5e5;
						font-family: monospace !important;
						font-size: 13px !important;
						line-height: 1.4 !important;
						margin: 0 !important;
						padding: 20px 0 !important;
					}

					.report-container-answer code {
						background: #f4f4f4 !important;
						border: 1px solid #e5e5e5 !important;
						padding: 1px 5px !important;
					}

						.report-container-answer code a {
							text-decoration: none;
						}

				</style>
					<script>
						var message="Function Disabled!"; 
						function clickIE4(){ 
							if (event.button==2){ alert(message);
								return false; 
							} 
						} 
						function clickNS4(e){ 
							if (document.layers||document.getElementById&&!document.all){ 
								if (e.which==2||e.which==3){
									alert(message);
									return false;
								}
							} 
						}
						if (document.layers){
							document.captureEvents(Event.MOUSEDOWN);
							document.onmousedown=clickNS4; 
						} else if (document.all&&!document.getElementById){
							document.onmousedown=clickIE4; 
						}
						document.oncontextmenu=new Function("return false");	
					</script>
				<style type="text/css" media="print">
					* { display: none; }
				</style>
				</head>

				<body marginheight="0" topmargin="0" marginwidth="0" style="margin: 0px; margin-left: 0px" ondragstart="return false" onselectstart="return false">
				<div class="report-container">
					<table width="100%">
						<tr>
							<td>
								<table border="0" cellspacing="0" cellpadding="0" align="center" width="100%">
									<tr>
										<td valign="top" width="150">
											<img src="' . $profileImage . '" style="width: 120px;margin-top:5px;margin:0px;" /></td>
										<td width="10"></td>
										<td valign="top" >
											<p style="display: block;">
												' . $name . '&nbsp;<span class="swSprite ' . $class . '"></span><br /> ' ;
												if(!empty($getExpertData->address)){
													$html .= $getExpertData->address . ',<br /> ';
												}
												if(!empty($getExpertData->email)){
													$html .= $getExpertData->email . ',<br /> ';
												}
												if(!empty($getExpertData->phone)){
													$html .= $getExpertData->phone . ',<br /> ';
												}
												if(!empty($getExpertData->web)){
													$html .= $getExpertData->web . ',<br /> ';
												}						
											$html .= '
											</p>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>

					<div style="margin: 0 auto; border-bottom: 4px solid #b90022;">&nbsp;</div>
					<div style="margin: 0 auto; margin-top: 1px; border-bottom: 1px solid #b90022;">&nbsp;</div>

					<table cellspacing="0" border="0" cellpadding="0" width="100%">
						<tr>
							<td valign="top" align="left">
								<h2>Report of Evidence of Use</h2>
								<p>
									The views presented here are of the author only and do not necessarily reflect the views of others. The author is an independent contractor that acts on behalf of neither the patent owner nor any other third party, including ClaimCharts.info. We would like to thank ClaimCharts.info for introducing to us the opportunity to prepare this report.  For comments and questions, please feel free to contact us directly, or via my profile at ClaimCharts.info.
								</p>
							</td>
						</tr>
					</table>

					<table cellspacing="0" border="0" cellpadding="0" width="100%">
						<tr>
							<td valign="top" align="left">
								<h3>Patent Number: ' . $patentNumber . '</h3>
								<h4>Claim Number: ' . $claimNumber . '</h4>
								<p>';
									$textShow = "";
									for ($i = 0; $i < count($getQueAnsData); $i++) {
										$textShow .= $getQueAnsData[$i]->description . " ";
									}


									$html .= $textShow . '
								</p>
							</td>
						</tr>
					</table>';
					$d = 1;
					for ($i = 0; $i < count($getQueAnsData); $i++) {
						$html .= '<table cellspacing="0" border="0" cellpadding="0" width="100%">
									<tr>
										<td valign="top" align="left">
											<h3>Element ' . $d . ':</h3>
											<div class="report-container-question"><p>
												' . $getQueAnsData[$i]->description . '
											</div></p>
											<div class="report-container-answer"><div>' . preg_replace('#(<[a-z ]*)(style=("|\')(.*?)("|\'))([a-z ]*>)#', '\\1\\6', $getQueAnsData[$i]->answer) . ' </div></div>
										</td>
									</tr>';
									if ($getQueAnsData[$i]->supporting_document != "") {
										$html .= ' <tr>
																<td valign="top">
																	<p>Supporting Evidence:</p>
																	<img src="' . JUri::base() . 'components/com_survey/document/' . $getQueAnsData[$i]->supporting_document . '"/>
																</td>
															  </tr>';
									}
								$html .= '</table>';
						$d++;
					}

    


				$html .= '<table cellspacing="0" border="0" cellpadding="0" width="100%">
					<tr>
						<td align="center">*&nbsp;&nbsp;*&nbsp;&nbsp;*&nbsp;&nbsp;*&nbsp;&nbsp;*</td>
					</tr>
					<tr>
						<td height="20" align="center">
							<p>End of Report</p>
						</td>
					</tr>
				</table><div style="page-break-before:always"></div>


				<table cellspacing="0" border="0" cellpadding="0" width="100%">
					<tr>
						<td valign="top" align="left">
							<p>
								Please rank my report. The following link leads to our profile at ClaimCharts.info, where you could rank our report.<br />
								<a href="' . $URL . '">Rank Here</a>
							</p>
							<p>Evaluation Code: '.$urlQueryString.'</p>
							<p>
								We are available to answer follow up questions, provide clarifications and search for additional materials upon request. For public contact - please refer to our profile at
								<a href="' . JUri::base() . 'index.php?option=com_survey&task=customer.expertProfile&display=' . $getSurevyData->expert_id . '#commenting">ClaimCharts.info</a>.
								For private contact - please call/email us.
							</p>
							<p>
								Our hourly rate is: $' . $getExpertData->hourly_rate . '
							</p>
							<h4>Non-Disclosure Agreement:</h4>
							<p>
								We understand that for the purpose of assisting you in collecting data, you may disclose to us certain confidential information that you want to keep confidential; therefore, for good and valuable consideration, the receipt and sufficiency of which is hereby acknowledged, we agree as follows:
							</p>
							<p>
								1. For a period of twelve (36) months from the date we receive your confidential information ("Effective Date"), we will not use or disclose the information, except: (a) in the event that such information (i) comes into the public domain not through us; (ii) is already known to us at the time of disclosure; (iii) is lawfully otherwise learnt or independently developed by us; or (iv) is required to be disclosed by law.
							</p>
							<p>
								2. Since a breach of our obligations hereunder may result in irreparable harm to you, we agree that upon such breach or threat thereof, you shall be entitled to specific performance and other injunctive relief without posting a bond, and in the event of disclosures required by court order, we shall promptly notify you of the proceeding.
							</p>
							<p>
								3. This agreement supersedes all prior discussions and writings and constitutes the entire agreement between you and us with respect to the subject matter hereof.  This Agreement shall be binding upon the successors and assigns of the respective parties, and may not be modified except by an instrument executed by both parties.
							</p>
							<p>
								' . $name . '<br />' . $getExpertData->company_name . '
							</p>
						</td>
					</tr>
				</table>

			</div>

			</body>
			</html>';


                  /*
                    $file = JPATH_LIBRARIES . '/dompdf/dompdf_config.inc.php';
                    if (!JFile::exists($file)) {
                        return false;
                    }
                    if (!defined('DOMPDF_ENABLE_REMOTE')) {
                        define('DOMPDF_ENABLE_REMOTE', true);
                    }                    
                    $random = $name.'_'.$getSurveyInfo->combine_name;
                    require_once($file);
                    $dompdf = new DOMPDF();
                    $dompdf->load_html($html);  
                    $dompdf->render();
                    $dompdf->stream($random . ".pdf", array("Attachment" => true));	
					*/
					$file = JPATH_LIBRARIES . '/pdfcrowd.php';
					if (!JFile::exists($file)) {
                        return false;
                    }
					require_once($file);	
					try
					{   
						// create an API client instance
						$client = new Pdfcrowd("vivek2512", "311c7da7e8fef591a5ceed80d295efcb");

						// convert a web page and store the generated PDF into a $pdf variable
						$pdf = $client->convertHtml($html);
						$random = $name.'_'.$getSurveyInfo->combine_name;    
						// set HTTP response headers
						header("Content-Type: application/pdf");
						header("Cache-Control: max-age=0");
						header("Accept-Ranges: none");
						header("Content-Disposition: attachment; filename=".$random . ".pdf");
						// send the generated PDF 
						echo $pdf;
						if($flag==1){
							die("Thank you for download report exclusive only for you.<a href='".JUri::base()."'>Click here to return </a>");
						} else {
							exit(0);
						}
					}
					catch(PdfcrowdException $why)
					{
						/*echo "Pdfcrowd Error: " . $why;*/
						exit(0);
					}
					
					
                }else {		
					$app = JFactory::getApplication();
					$app->redirect('index.php','Invalid report','error');		
				}				
            }else {		
				$app = JFactory::getApplication();
				$app->redirect('index.php','Invalid report','error');		
			}			
        } else {		
			$app = JFactory::getApplication();
			$app->redirect('index.php','Invalid report','error');		
		}
    }

    function projectSurveyQuestion()
    {
        $data = JRequest::get('post');
        $checkData = $this->getModel()->checkProjectWithName($data['p']);
        if (count($checkData) == 0) {
            $project = array('name' => $data['p'], 'exclusive' => $data['e']);
            $projectID = $this->getModel('Project')->save($project);
            if ($projectID > 0) {
                $survey = array('name' => $data['s'], 'project_id' => $projectID);
                $surveyID = $this->getModel('Survey')->save($survey);
                if ($surveyID > 0) {
                    $description = ($data['q'] != "") ? $data['q'] : '1';
                    $question = array('description' => $description, 'survey_id' => $surveyID);
                    $questionID = $this->getModel('Question')->save($question);
                    if ($questionID > 0) {
                        /*Now enter the data to transaction table for order*/
                        $type = 1; // For Order
                        $amount = 500;
                        $transactionID = $this->getModel()->insertTrans($amount, $surveyID, 0, $type);
                        echo json_encode(array('error' => '', 'id' => $transactionID));
                        /*End enter transaction*/
                    } else {
                        /* Delete Project and Survey*/
                        $this->getModel('Project')->delete($projectID);
                        $this->getModel('Survey')->delete($surveyID);
                        echo json_encode(array('error' => 'Project not saved, Please try after sometime.', 'id' => 0));
                    }
                } else {
                    /*Delete Save Project*/
                    $this->getModel('Project')->delete($projectID);
                    echo json_encode(array('error' => 'Project not saved, Please try after sometime.', 'id' => 0));
                }
            } else {
                echo json_encode(array('error' => 'Project not saved, Please try after sometime.', 'id' => 0));
            }
        } else {
            echo json_encode(array('error' => 'Project name already used.', 'id' => 0));
        }
    }
	
	function retrieve_project(){
	   $app = JFactory::getApplication();
       $post = JRequest::get('post');
	   $send = 0;
	   if(count($post)>0 && !empty($post['c']) && strlen($post['c'])==5){
		   $checkDataList = $this->getModel()->retrieveProjectWithCode($post['c']);
		   if(count($checkDataList)>0){
			   foreach($checkDataList as $checkData){
				   $this->getModel()->insertNotification($checkData->id,$post['s']);
				   $send = 1;
			   }			   
		   }
	   }
	   echo $send ;
	   die;
	}
	
	function delete_claim(){
		$app = JFactory::getApplication();
		$post = JRequest::get('post');
		$send = 0;
		if(count($post)>0 && $post['p']>0){
			$send = $this->getModel()->deleteSurvey($post['p']);
		}
		echo $send;
		die;
	}
	
	function delete_expert(){
		$post = JRequest::get('post');
		$send = array('affected'=>0,'error'=>'');
		if(count($post)>0 && $post['p']>0){
			$send = $this->getModel()->deleteExpert($post['p']);
		}
		echo json_encode($send);
		die;
	}
	
	function update_project_claims(){
		$app = JFactory::getApplication();
		$post = JRequest::get('post');
		if(count($post)>0 && $post['project_id']>0){
			$getProjectData = $this->getModel()->getProjectData($post['project_id']);
			if(count($getProjectData)>0){
				if($getProjectData->lead_id>0){
					/*Find List*/
					$getAllClaimList = $this->getModel()->getSurveyDataFromProject($getProjectData->id);
					$getPatentList = $this->getModel()->getPatentListFromBackyard($getProjectData->lead_id);
					if(count($getPatentList)>0){
						$survey = array();
						foreach($getPatentList as $patent){
							$checkPatent = $this->getModel->findSurveyDataByClaimNumber($patent->patent_number);
							if($checkPatent->countClaims ==0 || $checkPatent->countClaims==null){
								/*Add Claim*/								
								$claimComment = "";
								$target = "";
								$deadline = "";
								$maximum_price_claim = "";
								$specific_expert = "";
								$email_sms= "";
								$payment_type = "";
								if(count($getAllClaimList)>0){
									$claimComment = $getAllClaimList[0]->comment;
									$target = $getAllClaimList[0]->target;
									$deadline = $getAllClaimList[0]->deadline;
									$maximum_price_claim = $getAllClaimList[0]->maximum_price_claim;
									$specific_expert = $getAllClaimList[0]->specific_expert;
									$email_sms= $getAllClaimList[0]->email_sms;
									$payment_type = $getAllClaimList[0]->payment_type;
								}
								$combineName =$patent->patent_number;
												$surveyCode = $this->getNewSerialNumber(0,$this->generateRandomString());
						$survey[] = array('name' => $patent->patent_number,
										'project_id' => $post['project_id'], 
										'combine_name' => $combineName,
										'exclude' => 2,
										'document_type'=>(int)1,
										'report_type'=>1,
										'comment' => $claimComment,
										'target' =>$target,
										'avoided'=>'',
										'deadline' => $deadline,'maximum_price_claim'=>$maximum_price_claim,'specific_expert'=>$specific_expert,'minimum_price_claim'=>0,
										'email_sms'=>$email_sms,
										'payment_type'=>$payment_type,
										'code'=>$surveyCode);
								$combineName = $patent->patent_number;
								$surveyCode = $this->getNewSerialNumber(0,$this->generateRandomString());
	$survey[] = array('name' => $patent->patent_number,
					'project_id' => $post['project_id'],
					'combine_name' => $combineName,
					'exclude' => 2,
					'document_type'=>1,
					'report_type'=>2,
					'comment' => $claimComment,
					'target' => $target,
					'avoided' =>'',
					'deadline' => $deadline,'maximum_price_claim'=>$maximum_price_claim,'specific_expert'=>$specific_expert,'minimum_price_claim'=>0,
					'email_sms'=>$email_sms,
					'payment_type'=>$payment_type,
					'code'=>$surveyCode);
							}
						}
						if(count($survey)>0){
							$insertSurveyBulk = $this->getModel()->insertSurveyBulk($survey,$post['project_id']);
						}
					}
				}
			}
		}
		die;
	}
	
	function getRString(){
		$str = $this->generateRandomString(3);
		if(strlen($str)==3){
			return $str;
		} else {
			return $this->getRString();
		}
	}
	function projectSurveyQuestionMultipleUpdate(){
		$app = JFactory::getApplication();
		$data = JRequest::get('post');
		$error = 0;
		$errorMessage = "";
		$errorType = "";
		$redirectUrl = "order";
		/*Claimchart*/
		if($data['project_id']>0){
			$getProjectData = $this->getModel()->getProjectData($data['project_id']);
			if(count($getProjectData)>0){
				$updateData = $this->getModel('Project')->save(array('id'=>$getProjectData->id,'synpat_price'=>$data['synpat_price'],'description'=>$data['comment']));
				if($updateData>0){
					$updateSurvey = $this->getModel()->updateAllSurveyByProjectID($data['project_deadline_multiple'],$data['target'],$data['document_evidence'],$data['claim_comment'],$data['maximum_price_claim'],$getProjectData->id);
					if($updateSurvey>0){
						$errorMessage = 'Order updated';
						$errorType = 'message';
						$redirectUrl = 'order?rod='.$data['rod'];
					} else {
						$errorMessage = 'Error: Order not updated';
						$errorType = 'error';
						$redirectUrl = 'order?rod='.$data['rod'];
					}
				} else {
					$errorMessage = 'Error: Order not updated';
					$errorType = 'error';
					$redirectUrl = 'order?rod='.$data['rod'];
				}
			} else {
				$errorMessage = 'Order not found!';
				$errorType = 'error';
				$redirectUrl = 'order?rod='.$data['rod'];
			}
		} else {
			$errorMessage = 'Error: Missing information';
			$errorType = 'error';
			$redirectUrl = "order";
		}
		/*Prior Art*/
		if($data['priorproject_id']>0){
			$getProjectData = $this->getModel()->getProjectData($data['priorproject_id']);
			if(count($getProjectData)>0){
				$updateData = $this->getModel('Project')->save(array('id'=>$getProjectData->id,'synpat_price'=>$data['prior_synpat_price'],'description'=>$data['prior_comment']));
				if($updateData>0){
					$updateSurvey = $this->getModel()->updateAllSurveyByProjectID($data['prior_project_deadline_multiple'],'',$data['prior_document_evidence'],$data['prior_claim_comment'],$data['prior_maximum_price_claim'],$getProjectData->id);
					if($updateSurvey>0){
						$errorMessage = 'Order updated';
						$errorType = 'message';
						$redirectUrl = 'order?rod='.$data['rod'];
					} else {
						$errorMessage = 'Error: Order not updated';
						$errorType = 'error';
						$redirectUrl = 'order?rod='.$data['rod'];
					}
				} else {
					$errorMessage = 'Error: Order not updated';
					$errorType = 'error';
					$redirectUrl = 'order?rod='.$data['rod'];
				}
			} else {
				$errorMessage = 'Order not found!';
				$errorType = 'error';
				$redirectUrl = 'order?rod='.$data['rod'];
			}
		} else {
			$errorMessage = 'Error: Missing information';
			$errorType = 'error';
			$redirectUrl = "order";
		}
		$app->redirect($redirectUrl,$errorMessage,$errorType);
	}
    function projectSurveyQuestionMultiple()
    {
		/*Saving Multiple Project Data*/
		$app = JFactory::getApplication();
		$data = JRequest::get('post');
		$message = "";$messageType="";
		$projectID = 0;
		$transactionID = 0;
		$orderName = "";
		$getBackyardLeadID = $data['order_smp'];
		if((int)$getBackyardLeadID>0){
			$getLeadData = $this->getModel()->getLeadData($getBackyardLeadID);
			if(count($getLeadData)>0){
				$leadNameWithFirstFour = substr($getLeadData->lead_name,0,4);
				$getRandomString = $this->getRString();
				$projectName = $leadNameWithFirstFour.$getRandomString;
				$projectDeadLine = $data['project_deadline_multiple'];
				if($projectName!=""){
					$checkData = $this->getModel()->checkProjectWithName($projectName);
					if (count($checkData) == 0) {
						/*Saving Project Data*/
						$project = array('name' => $projectName,'description'=>$data['comment'],'lead_id'=>$getLeadData->id,'synpat_price'=>$data['synpat_price'],'type'=>2);
						$project['code'] = $this->getNewSerialNumber(0,$this->generateRandomString(),2);
						$projectID = $this->getModel('Project')->save($project);
						if($projectID > 0) {
							$orderName = $projectName;
							$countNumberPatent = 0;
							$claimExclusive = 0;
							$claimNonExclusive = 0;
							$priorExclusive = 0;
							$priorNonExclusive = 0;
							$flag = 0;
							$reportsType = 2;
							$getPatentList = $this->getModel()->getPatentListFromBackyard($getLeadData->id);
							if(count($getPatentList)>0){
								$survey = array();
								$inc = 1;
								foreach($getPatentList as $patents){
									$combineName =$patents->patent_number;
									$surveyCode = $this->getNewSerialNumber(0,$this->generateRandomString());
					$survey[] = array('name' => $patents->patent_number,
									'project_id' => $projectID,
									'combine_name' => $combineName,
									'exclude' => 2,
									'document_type'=>1,
									'report_type'=>$reportsType,
									'comment' => $data['claim_comment'],
									'target' => $data['target'],
									'avoided' =>$data['avoided'],
									'deadline' => $data['project_deadline_multiple'],'maximum_price_claim'=>$data['maximum_price_claim'],'specific_expert'=>$data['specific_expert'],'minimum_price_claim'=>0,
									'email_sms'=>$data['email_sms'],
									'payment_type'=>$data['payment_type'],
									'code'=>$surveyCode);
								}
								if(count($survey)>0){
									$insertSurveyBulk = $this->getModel()->insertSurveyBulk($survey,$projectID);
									if($insertSurveyBulk->surveyCount!=null && count($survey)== $insertSurveyBulk->surveyCount){
										/*All Patents claimcharts and prior art added*/
										$total = 700 * (2 * count($survey));
										if($total>0){
											$total = number_format((float)$total, 2, '.', '');
										}
										$type = 1;
										$transactionID = $this->getModel()->insertTrans($total, $projectID, 0, 0, $type);
										if($transactionID>0){
											$this->getModel()->updateTrans(array('success'=>'Paid','txn_id'=>'955789418D2713700','message'=>'Payment successfully done'),$transactionID);
											/*Update Order name back to BackyardCRM*/
											$this->getModel()->updateOrderName($projectName,$getLeadData->id,2);
											/*Add notification to all*/
											$this->getModel()->addNotificationToAllExperts($projectID);
										}
									}
								}
							}							
						}
						/*Prior Art*/
						$project = array('name' => $projectName,'description'=>$data['prior_comment'],'lead_id'=>$getLeadData->id,'synpat_price'=>$data['prior_synpat_price'],'type'=>1);
						$project['code'] = $this->getNewSerialNumber(0,$this->generateRandomString(),2);
						$projectID = $this->getModel('Project')->save($project);
						if($projectID > 0) {
							$orderName = $projectName;
							$countNumberPatent = 0;
							$claimExclusive = 0;
							$claimNonExclusive = 0;
							$priorExclusive = 0;
							$priorNonExclusive = 0;
							$flag = 0;
							$reportsType = 1;
							$getPatentList = $this->getModel()->getPatentListFromBackyard($getLeadData->id);
							if(count($getPatentList)>0){
								$survey = array();
								$inc = 1;
								foreach($getPatentList as $patents){
									$combineName =$patents->patent_number;
									$surveyCode = $this->getNewSerialNumber(0,$this->generateRandomString());
					$survey[] = array('name' => $patents->patent_number,
									'project_id' => $projectID,
									'combine_name' => $combineName,
									'exclude' => 2,
									'document_type'=>1,
									'report_type'=>$reportsType,
									'comment' => $data['prior_claim_comment'],
									'target' => $data['prior_target'],
									'avoided' =>'',
									'deadline' => $data['prior_project_deadline_multiple'],'maximum_price_claim'=>$data['prior_maximum_price_claim'],'specific_expert'=>$data['specific_expert'],'minimum_price_claim'=>0,
									'email_sms'=>$data['email_sms'],
									'payment_type'=>$data['payment_type'],
									'code'=>$surveyCode);
								}
								if(count($survey)>0){
									$insertSurveyBulk = $this->getModel()->insertSurveyBulk($survey,$projectID);
									if($insertSurveyBulk->surveyCount!=null && count($survey)== $insertSurveyBulk->surveyCount){
										/*All Patents claimcharts and prior art added*/
										$total = 700 * (2 * count($survey));
										if($total>0){
											$total = number_format((float)$total, 2, '.', '');
										}
										$type = 1;
										$transactionID = $this->getModel()->insertTrans($total, $projectID, 0, 0, $type);
										if($transactionID>0){
											$this->getModel()->updateTrans(array('success'=>'Paid','txn_id'=>'955789418D2713701','message'=>'Payment successfully done'),$transactionID);
											/*Update Order name back to BackyardCRM*/
											$this->getModel()->updateOrderName($projectName,$getLeadData->id,1);
											/*Add notification to all*/
											$this->getModel()->addNotificationToAllExperts($projectID);
										}
									}
								}
							}							
						}
						
						
						
					}
				}
			}
			if($projectID>0 && $transactionID>0){
				$message = "Order created successfully. Order name: ".$orderName;   
				$messageType = "message";
			} else {
				$message = "Error: Not able to find lead data";  
				$messageType = "error";
			}		  	
	    } else {		   
		   $message = "Error: Invalid leadID";  
		   $messageType = "error";
	    }
	   $app->redirect('order?smp='.$getBackyardLeadID,$message,$messageType);
       /*End Saving*/
    }
	
	function testBulk(){
		$this->getModel()->addNotificationToAllExperts(52);
		die;
	}
	
	function sucess_payment(){
		$data = JRequest::get('post');
		if(!empty($data['p'])){
			$getList = $this->getModel()->checkProjectWithCodes($data['p']);
            echo json_encode(array('data' => $getList));
		} else {
			  echo json_encode(array('data' => array()));
		}
		die;
	}
	
    function search()
    {
        $data = JRequest::get('post');
        if ($data['p'] != "") {
            $getList = $this->getModel()->checkProjectWithName($data['p']);
            echo json_encode(array('data' => $getList));
        } else if ($data['s'] != "") {
            $getList = $this->getModel()->checkProjectWithSurveyName($data['s']);
            echo json_encode(array('data' => $getList));
        } else if ($data['e'] != "") {
            $getList = $this->getModel()->checkProjectWithExpertName($data['e']);
            echo json_encode(array('data' => $getList));
        } else {
            echo json_encode(array('data' => array()));
        }
    }

    function expertClaim()
    {
        $pID = JRequest::getInt('p');
        $expertID = JRequest::getInt('f');
        $db = JFactory::getDBo();
        $sql = "SELECT s.* FROM #__question as q LEFT JOIN #__survey as s ON s.id = q.survey_id WHERE s.project_id = '" . $pID . "' AND q.id IN(SELECT ques_id FROM `#__survey_question_answer` as qa WHERE expert_id = '" . $expertID . "') GROUP BY s.id";
        $db->setQuery($sql);
        $getList = $db->loadObjectList();
        echo json_encode($getList);
    }

    function showExpertRating()
    {
        $data = JRequest::get('post');
        $getList = $this->getModel()->expertRatingData($data['expert_id']);
        echo json_encode(array("data" => $getList, "id" => $data['expert_id']));
    }
	
	function array_flatten($array) { 
		if (!is_array($array)) { 
			return FALSE; 
		} 
		$result = array(); 
		foreach ($array as $key => $value) { 
			if (is_array($value)) { 
			  $result = array_merge($result, $this->array_flatten($value)); 
			} 
			else { 
			  $result[$key] = $value; 
			} 
		} 
		return $result; 
	} 
	
	function addAreaExpertise($getSingleData,$data){
		if(count($getSingleData)>0){
			foreach($getSingleData as $singleData){
				if(count($singleData)>0){							
					foreach($singleData as $value){
						$this->getModel()->insertExpertArea($data['e'], $value);
					}
				}
			}
		}
	}
	
	function saveExpertCodeData(){
		$data = JRequest::get('post');
		$this->getModel()->insertExpertArea($data['e'], $data['c']);
		die;
	}
	
	function save_expert_selection(){
		$data = JRequest::get('post');
		$this->getModel()->checkInsertExpertArea($data['e'],$data['a'],$data['t']);
		die;
	}
	
	function display_expert_selection(){
		$data = JRequest::get('post');
		$this->getModel()->checkDisplayInsertExpertArea($data);
		die;
	}
	
	function deleteOldExperCode(){
		$data = JRequest::get('post');
		$this->getModel()->deleteOldExpertArea($data['e']);
		die;
	}
	
	function deleteAreaExpertise(){
		$data = JRequest::get('post');
        $app = JFactory::getApplication();  
		if($data['e']>0){
			$deleteOldArea = $this->getModel()->deleteOldExpertArea($data['e']);
		}
		die;
	}
	
    function updateAreaExpertise()
    {
        $data = JRequest::get('post');
        $app = JFactory::getApplication();       
		ini_set("safe_mode", false);
		ini_set("max_execution_time", 144000000);
		$mainArrayForALL = array();
        if (isset($data['parent_checked']) || isset($data['child_1']) || isset($data['child_2']) || isset($data['child_3']) || isset($data['child_4'])) {
            $deleteOldArea = $this->getModel()->deleteOldExpertArea($data['e']);
            if (isset($data['parent_checked']) && count($data['parent_checked']) > 0) {
				$getSingleData = array();
				for ($i = 0; $i < count($data['parent_checked']); $i++) {
					$getData = $this->getModel()->getExpertAreaFromParent($data['parent_checked'][$i]);
					$getSingleData[] = $this->array_flatten($getData);					
				}               		
				array_values($getSingleData);
				if(count($mainArrayForALL)>0){
					array_merge($mainArrayForALL,$getSingleData);
				}else {
					$mainArrayForALL = $getSingleData;
				}
				
				//$this->addAreaExpertise($getSingleData,$data);
            } else {
				if (isset($data['child_1']) && count($data['child_1']) > 0) {
					$getSingleData = array();
					for ($i = 0; $i < count($data['child_1']); $i++) {
						$getData = $this->getModel()->getExpertAreaFromParent($data['child_1'][$i]);
						$getSingleData[] = $this->array_flatten($getData);					
					}
					array_values($getSingleData);
					if(count($mainArrayForALL)>0){
						array_merge($mainArrayForALL,$getSingleData);
					}else {
						$mainArrayForALL = $getSingleData;
					}
					//$this->addAreaExpertise($getSingleData,$data);
				}
				if (isset($data['child_2']) && count($data['child_2']) > 0) {
					$getSingleData = array();
					for ($i = 0; $i < count($data['child_2']); $i++) {
						$getData = $this->getModel()->getExpertAreaFromParent($data['child_2'][$i]);
						$getSingleData[] = $this->array_flatten($getData);
					}
					array_values($getSingleData);			
					if(count($mainArrayForALL)>0){
						array_merge($mainArrayForALL,$getSingleData);
					}else {
						$mainArrayForALL = $getSingleData;
					}				
					//$this->addAreaExpertise($getSingleData,$data);
				}
				if (isset($data['child_3']) && count($data['child_3']) > 0) {
					$getSingleData = array();
					for ($i = 0; $i < count($data['child_3']); $i++) {
						$getData = $this->getModel()->getExpertAreaFromParent($data['child_3'][$i]);
						$getSingleData[] = $this->array_flatten($getData);
					}
					array_values($getSingleData);
					if(count($mainArrayForALL)>0){
						array_merge($mainArrayForALL,$getSingleData);
					}else {
						$mainArrayForALL = $getSingleData;
					}
					//$this->addAreaExpertise($getSingleData,$data);
				}
				if (isset($data['child_4']) && count($data['child_4']) > 0) {
					$getSingleData = $data['child_4'];
					if(count($mainArrayForALL)>0){
						array_merge($mainArrayForALL,$getSingleData);
					}else {
						$mainArrayForALL = $getSingleData;
					}
					//$this->addAreaExpertise($data['child_4'],$data);
				}
			}
           /* $app->redirect('index.php?option=com_survey&task=customer.expertProfile&display=' . $data['e'], 'Expert area updated successfully', 'Success');*/
        }/* else {
            $app->redirect('index.php?option=com_survey&task=customer.expertProfile&display=' . $data['e'], 'No expert area is been selected', 'notice');
        }*/
		echo json_encode($mainArrayForALL);
		die;
    }


    /*
     * updateDesc - Called when Expert Profile is Updated/Submitted.
     * Handles Rich Text Fields
     * Handles File/Profile Picture Upload
     */
    function updateDesc()
    {
        $data = JRequest::get('post');
		$meData = array();
		if(is_array($data['me']) && count($data['me'])>0){
			for($i=0;$i<count($data['me']) ;$i++){
				$meData[] = $data['me'][$i]['value'];
			}
		}
		$meData = implode(',',$meData);
		$aeData = array();
		if(is_array($data['ae']) && count($data['ae'])>0){
			for($i=0;$i<count($data['ae']) ;$i++){
				$aeData[] = $data['ae'][$i]['value'];
			}
		}
		$aeData = implode(',',$aeData);
       	$sgData = array();
		if(is_array($data['sg']) && count($data['sg'])>0){
			for($i=0;$i<count($data['sg']) ;$i++){
				$sgData[] = $data['sg'][$i]['value'];
			}
		}
		$sgData = implode(',',$sgData);
		$data['me'] = $meData;
		$data['ae'] = $aeData;
		$data['sg'] = $sgData;
        // Parse raw data from rich editor controls
        $data['expl'] = JRequest::getVar('expl', '', 'post', 'string', JREQUEST_ALLOWHTML);
        $update = $this->getModel()->updateExpertDesc($data);
        echo $update;
    }
    
    
    /*
     * Update Expert Big HTML Text
     * 
     * */
    
    function updateProfileUser(){
		$session = JFactory::getSession();
		$getSession = $session->get('expertSession', '');
		$app = JFactory::getApplication();
		if(is_object($getSession) && count($getSession) > 0){
			$user_description = JRequest::getVar('descriptionEditor', '', 'post', 'string', JREQUEST_ALLOWHTML);
			$update = $this->getModel()->updateProfileUser(array('expl'=>$user_description,'d'=>$getSession->id));
			$config = JFactory::getConfig();
			$encryptPassword = $config->getValue( 'synpat_symbol' );
			$display = openssl_encrypt($getSession->id,"AES-128-ECB",$encryptPassword);
			if($update){
				$app->redirect('index.php?option=com_survey&task=customer.expertProfile&display=' . $display, 'Update data', 'success');
			} else {
				$app->redirect('index.php?option=com_survey&task=customer.expertProfile&display=' . $display, 'No expert area is been selected', 'notice');
			}
		} else {
			$app->redirect('index.php', 'Please login first', 'warning');
		}
	}
    
    /*
     * Method for uploading profile CV/Resume using AJAX
     * Returns json response.
     */
    function uploadProfileResume()
    {
        $result = false;
        
        // Get Expert's ID for filename
        $data = JRequest::get('post');
        $id = $data['profileId'];
        
        // Handle File Upload
        jimport('joomla.filesystem.file');
        jimport('joomla.filesystem.folder');
        $filename = $_FILES["profileResume"]['name'];
        $fileExtension = pathinfo($filename, PATHINFO_EXTENSION);
        $fileTempPath = $_FILES["profileResume"]['tmp_name'];
         $fileNewPath = $id .'_'. $filename.'_'.time().'.' . $fileExtension;
        $uploadPath = JPATH_SITE.DS.'media'.DS.'com_survey'.DS.'profile_resumes'.DS.$fileNewPath;
        
        if(JFile::upload($fileTempPath, $uploadPath)){
            $result = true;
        }
        
        // Return JSON Response to ajax caller.
        $response = array( 'status' => $result, 'filename' => $fileNewPath ); 
        echo json_encode($response);
        jexit(); // to only return json.
    }
    
    /*
     * Method for uploading profile image using AJAX
     * Returns json response.
     */
	 
	 
	
	 
    function uploadProfileImage()
    {
        $result = false;
        
        // Get Expert's ID for filename
        $data = JRequest::get('post');
        $id = $data['profileId'];
        
        // Handle File Upload
        jimport('joomla.filesystem.file');
        jimport('joomla.filesystem.folder');
        $filename = $_FILES["profileImage"]['name'];
        $fileExtension = pathinfo($filename, PATHINFO_EXTENSION);
        $fileTempPath = $_FILES["profileImage"]['tmp_name'];
        $fileNewPath = $id .'_'. $filename.'_'.time().'.' . $fileExtension;
        $uploadPath = JPATH_SITE.DS.'media'.DS.'com_survey'.DS.'profile_images'.DS.$fileNewPath;
        
        if(JFile::upload($fileTempPath, $uploadPath)){
            $result = true;
        }
        
        // Return JSON Response to ajax caller.
        $response = array( 'status' => $result, 'filename' => $fileNewPath ); 
        echo json_encode($response);
        jexit(); // to only return json.
    }
	
	function getPriorArtReport($expertID){
		return $this->getModel()->getPriorArtReport($expertID);
	}
	
	function profileUpdate(){
		$data = JRequest::get('post');
		$getSession = JFactory::getUser();
		$sessionEXpertID = 0;
		$app = JFactory::getApplication();
		if ($getSession->id==0) {
			
			$app->redirect('index.php', 'Please Login First', 'Error');
		}
		$getSession = $this->getModel()->expertUserData($getSession->id);	
		$config = JFactory::getConfig();
		$encryptPassword = $config->getValue( 'synpat_symbol' );
		$display = openssl_encrypt($getSession->id,"AES-128-ECB",$encryptPassword);
		switch($data['default_type']){
			case 1:
				/*profile*/
				$image_file ="aboutus.jpg";
				if(!empty($data['old_image'])){
					$pathInfo = pathinfo($data['old_image']);
					$image_file = $pathInfo['basename'];
				}
				/*$image_file = $data['old_image'];*/
				if(isset($_FILES['file_image']) && !empty($_FILES['file_image']['name'])){
					/*Upload Image File*/
					jimport('joomla.filesystem.file');
					jimport('joomla.filesystem.folder');
					$filename = $_FILES["file_image"]['name'];
					$fileExtension = pathinfo($filename, PATHINFO_EXTENSION);
					if(in_array(strtoUpper($fileExtension),array('PNG','JPG','JPEG','BMP'))){
						$fileTempPath = $_FILES["file_image"]['tmp_name'];
						$fileNewPath = $id .'_'. $filename.'_'.time().'.' . $fileExtension;
						$uploadPath = JPATH_SITE.DS.'images'.DS.'kallyas_images'.DS.$fileNewPath;					
						if(JFile::upload($fileTempPath, $uploadPath)){
							$image_file = $fileNewPath;
						}
					}					
				}
				$description = "<p>". $data['profile_desc'] ."</p>";
				
				$returnData = $this->getModel()->updateExpertData(array('profile_desc'=>"<img src='".JUri::base()."images/kallyas_images/".$image_file."' class='alignleftborder' style='width:200px;'/>".$description),array('id'=>$getSession->id));
				if($returnData==1){
					$app->redirect('index.php?option=com_survey&task=customer.expertProfile&display='.$display, '', 'Success');
				} else {
					$app->redirect('index.php?option=com_survey&task=customer.expertProfile&display='.$display, 'Try after sometime', 'Error');
				}
			break;
			case 2:
				/*Choose Us*/
				$heading = "<h4 style='text-align:left;' class='m_title'>".trim($data['field_choose_heading'])."</h4>";
				$elementChoose = "";
				foreach($data['field_choose_us'] as $choose){
					$elementChoose .="<li data-char='190'>".$choose."</li>";
				}	
				
				$returnData = $this->getModel()->updateExpertData(array('choose_us'=>$heading.'<ul style="margin-bottom: 20px;" class="list-style1">'.$elementChoose.'</ul>'),array('id'=>$getSession->id));
				if($returnData==1){
					$app->redirect('index.php?option=com_survey&task=customer.expertProfile&display='.$display, '', 'Success');
				} else {
					$app->redirect('index.php?option=com_survey&task=customer.expertProfile&display='.$display, 'Try after sometime', 'Error');
				}
			break;
			case 3:
				/*Testimonial*/
				$testimonialData = trim($data['testimonial']);
				$testimonialBy = $data['testimonial_by'];
				$testiContent = "<blockquote><p>".$testimonialData."</p><small>".$testimonialBy."</small></blockquote>";
				$returnData = $this->getModel()->updateExpertData(array('testimonial'=>$testiContent),array('id'=>$getSession->id));
				if($returnData==1){
					$app->redirect('index.php?option=com_survey&task=customer.expertProfile&display='.$display, '', 'Success');
				} else {
					$app->redirect('index.php?option=com_survey&task=customer.expertProfile&display='.$display, 'Try after sometime', 'Error');
				}
			break;
			case 4:
				/*Main Area*/
				$mainAreaContent = 	JRequest::getVar('main_area_description', '', 'post', 'string', JREQUEST_ALLOWRAW);
				$returnData = $this->getModel()->updateExpertData(array('main_area'=>$mainAreaContent),array('id'=>$getSession->id));
				if($returnData==1){
					$app->redirect('index.php?option=com_survey&task=customer.expertProfile&display='.$display, '', 'Success');
				} else {
					$app->redirect('index.php?option=com_survey&task=customer.expertProfile&display='.$display, 'Try after sometime', 'Error');
				}
			break;
			case 5:
				/*Standard Area*/
				$mainAreaContent = 	JRequest::getVar('main_standard_area_description', '', 'post', 'string', JREQUEST_ALLOWRAW);				
				$returnData = $this->getModel()->updateExpertData(array('standard_area'=>$mainAreaContent),array('id'=>$getSession->id));
				if($returnData==1){
					$app->redirect('index.php?option=com_survey&task=customer.expertProfile&display='.$display, '', 'Success');
				} else {
					$app->redirect('index.php?option=com_survey&task=customer.expertProfile&display='.$display, 'Try after sometime', 'Error');
				}
			break;
			case 6:
				/*Membership*/
				$mainAreaContent = 	JRequest::getVar('main_membership_description', '', 'post', 'string', JREQUEST_ALLOWRAW);
				$returnData = $this->getModel()->updateExpertData(array('new_membership'=>$mainAreaContent),array('id'=>$getSession->id));
				if($returnData==1){
					$app->redirect('index.php?option=com_survey&task=customer.expertProfile&display='.$display, '', 'Success');
				} else {
					$app->redirect('index.php?option=com_survey&task=customer.expertProfile&display='.$display, 'Try after sometime', 'Error');
				}
			break;
			case 7:
				/*Standard Group*/				
				$mainAreaContent = 	JRequest::getVar('main_standard_group_description', '', 'post', 'string', JREQUEST_ALLOWRAW);				
				$returnData = $this->getModel()->updateExpertData(array('standard_group'=>$mainAreaContent),array('id'=>$getSession->id));
				if($returnData==1){
					$app->redirect('index.php?option=com_survey&task=customer.expertProfile&display='.$display, '', 'Success');
				} else {
					$app->redirect('index.php?option=com_survey&task=customer.expertProfile&display='.$display, 'Try after sometime', 'Error');
				}
			break;
			case 8:
				/*CV Resume*/
				$mainAreaContent = 	JRequest::getVar('main_cvresume', '', 'post', 'string', JREQUEST_ALLOWRAW);					
				$returnData = $this->getModel()->updateExpertData(array('cv_resume'=>$mainAreaContent),array('id'=>$getSession->id));
				if($returnData==1){
					$app->redirect('index.php?option=com_survey&task=customer.expertProfile&display='.$display, '', 'Success');
				} else {
					$app->redirect('index.php?option=com_survey&task=customer.expertProfile&display='.$display, 'Try after sometime', 'Error');
				}
			break;
			case 16:
				/*CV Resume*/
				$mainAreaContent = 	JRequest::getVar('main_professtional_membership', '', 'post', 'string', JREQUEST_ALLOWRAW);
				$returnData = $this->getModel()->updateExpertData(array('professtional_membership'=>$mainAreaContent),array('id'=>$getSession->id));
				if($returnData==1){
					$app->redirect('index.php?option=com_survey&task=customer.expertProfile&display='.$display, '', 'Success');
				} else {
					$app->redirect('index.php?option=com_survey&task=customer.expertProfile&display='.$display, 'Try after sometime', 'Error');
				}
			break;
			case 17:
				/*CV Resume*/
				$mainAreaContent = 	JRequest::getVar('main_clients', '', 'post', 'string', JREQUEST_ALLOWRAW);
				$returnData = $this->getModel()->updateExpertData(array('main_clients'=>$mainAreaContent),array('id'=>$getSession->id));
				if($returnData==1){
					$app->redirect('index.php?option=com_survey&task=customer.expertProfile&display='.$display, '', 'Success');
				} else {
					$app->redirect('index.php?option=com_survey&task=customer.expertProfile&display='.$display, 'Try after sometime', 'Error');
				}
			break;
			case 18:
				/*CV Resume*/
				$mainAreaContent = 	JRequest::getVar('main_other_area', '', 'post', 'string', JREQUEST_ALLOWRAW);
				$returnData = $this->getModel()->updateExpertData(array('other_area'=>$mainAreaContent),array('id'=>$getSession->id));
				
				if($returnData==1){
					$app->redirect('index.php?option=com_survey&task=customer.expertProfile&display='.$display, '', 'Success');
				} else {
					$app->redirect('index.php?option=com_survey&task=customer.expertProfile&display='.$display, 'Try after sometime', 'Error');
				}
			break;
			case 9:
				/*Skills*/
				$skillsContent="";
				$skillsContent .='<li style="background-color:#97BE0D;" data-percent="'.$data['field_skill_value'][0].'">'.$data['field_skill_name'][0].'</li>';
				$skillsContent .='<li style="background-color:#D84F5F;" data-percent="'.$data['field_skill_value'][1].'">'.$data['field_skill_name'][1].'</li>';
				$skillsContent .='<li style="background-color:#88B8E6;" data-percent="'.$data['field_skill_value'][2].'">'.$data['field_skill_name'][2].'</li>';
				$skillsContent .='<li style="background-color:#BEDBE9;" data-percent="'.$data['field_skill_value'][3].'">'.$data['field_skill_name'][3].'</li>';
				$skillsContent .='<li style="background-color:#EDEBEE;" data-percent="'.$data['field_skill_value'][4].'">'.$data['field_skill_name'][4].'</li>';
				$returnData = $this->getModel()->updateExpertData(array('skills'=>'<ul class="skills">'.$skillsContent.'</ul>'),array('id'=>$getSession->id));
				if($returnData==1){
					$app->redirect('index.php?option=com_survey&task=customer.expertProfile&display='.$display, '', 'Success');
				} else {
					$app->redirect('index.php?option=com_survey&task=customer.expertProfile&display='.$display, 'Try after sometime', 'Error');
				}
			break;
			case 10:
				/*Address*/	
				$profileData = array('free_text'=>$data['free_text'],'address'=>$data['address'],'phone'=>$data['phone_number'],'web'=>$data['web_address'],'contact_email'=>$data['display_email']);
				if(!empty($data['first_name'])){
					$profileData['first_name'] = $data['first_name'];
				}
				if(!empty($data['last_name'])){
					$profileData['last_name'] = $data['last_name'];
				}
				if((int)$getSession->expert_type==2){
					if(!empty($data['company_name'])){
						$profileData['company_name'] = $data['company_name'];
					}
				}				
				$returnData = $this->getModel()->updateExpertData($profileData,array('id'=>$getSession->id));
				if($returnData==1){
					if(!empty($data['display_paypal'])){
						$this->getModel()->paymentData($data['display_paypal'],$getSession->id);
					}
					$app->redirect('index.php?option=com_survey&task=customer.expertProfile&display='.$display, '', 'Success');
				} else {
					$app->redirect('index.php?option=com_survey&task=customer.expertProfile&display='.$display, 'Error while saving your data', 'Error');
				}
			break;
			case 11:
				/*Completed Claim*/
				$completeClaimNumber = $data['completed_claim'];
				$returnData = $this->getModel()->updateExpertData(array('completed_claim'=>$completeClaimNumber),array('id'=>$getSession->id));
				if($returnData==1){
					$app->redirect('index.php?option=com_survey&task=customer.expertProfile&display='.$display, '', 'Success');
				} else {
					$app->redirect('index.php?option=com_survey&task=customer.expertProfile&display='.$display, 'Try after sometime', 'Error');
				}
			break;
			case 12:
				/*Completed PriorArts*/
				$completeClaimNumber = $data['completed_priorart'];
				$returnData = $this->getModel()->updateExpertData(array('completed_priorart'=>$completeClaimNumber),array('id'=>$getSession->id));
				if($returnData==1){
					$app->redirect('index.php?option=com_survey&task=customer.expertProfile&display='.$display, '', 'Success');
				} else {
					$app->redirect('index.php?option=com_survey&task=customer.expertProfile&display='.$display, 'Try after sometime', 'Error');
				}
			break;
			case 13:
				/*Sold Reports*/
				$completeClaimNumber = $data['sold_report'];
				$returnData = $this->getModel()->updateExpertData(array('sold_report'=>$completeClaimNumber),array('id'=>$getSession->id));
				if($returnData==1){
					$app->redirect('index.php?option=com_survey&task=customer.expertProfile&display='.$display, '', 'Success');
				} else {
					$app->redirect('index.php?option=com_survey&task=customer.expertProfile&display='.$display, 'Try after sometime', 'Error');
				}
			break;
			case 14:
				/*Working Hours This Year*/
				$completeClaimNumber = $data['working_hour'];
				$returnData = $this->getModel()->updateExpertData(array('working_hour'=>$completeClaimNumber),array('id'=>$getSession->id));
				if($returnData==1){
					$app->redirect('index.php?option=com_survey&task=customer.expertProfile&display='.$display, '', 'Success');
				} else {
					$app->redirect('index.php?option=com_survey&task=customer.expertProfile&display='.$display, 'Try after sometime', 'Error');
				}
			break;
			case 15:
				/*Sub Title*/
				$completeClaimNumber = $data['sub_title'];
				$returnData = $this->getModel()->updateExpertData(array('sub_title'=>"<p style='margin:0px'>".$completeClaimNumber."</p>"),array('id'=>$getSession->id));
				if($returnData==1){
					$app->redirect('index.php?option=com_survey&task=customer.expertProfile&display='.$display, '', 'Success');
				} else {
					$app->redirect('index.php?option=com_survey&task=customer.expertProfile&display='.$display, 'Try after sometime', 'Error');
				}
			break;
		}	
		$app->redirect('index.php?option=com_survey&task=customer.expertProfile&display='.$display);
	}
	
	function nda(){
		$data = JRequest::get('post');
		$getSession = JFactory::getUser();
		$sessionEXpertID = 0;
		$app = JFactory::getApplication();
		if ($getSession->id==0) {
			$app->redirect('index.php', 'Please Login First', 'Error');
		}
		$getSession = $this->getModel()->expertUserData($getSession->id);	
		if(count($getSession)>0){
			$returnData = $this->getModel()->update_user_nda($getSession->user_id,$data['default_type']);
			$config = JFactory::getConfig();
			$encryptPassword = $config->getValue( 'synpat_symbol' );
			$display = openssl_encrypt($getSession->id,"AES-128-ECB",$encryptPassword);
			$app->redirect('index.php?option=com_survey&task=customer.expertOpportunites&display='.$display);
		}else {
			$app->redirect('index.php', 'Please Login First', 'Error');
		}
	}
	
	
    function deleteInProcessClaim()
    {
        $post = JRequest::get('post');
        echo $this->getModel()->deleteInProcessClaim($post);
    }
    
    
    function contact_us(){
		$app = JFactory::getApplication();
		$post = JRequest::get('post');
		$CORRECT_SUBJECT = htmlentities($post["rp_subject"], ENT_COMPAT, "UTF-8");
		$CORRECT_MESSAGE = htmlentities($post["rp_message"], ENT_COMPAT, "UTF-8");
		// check email
		if ($post["rp_email"] === "") {
			$app->redirect('index.php?option=com_survey&task=customer.expertProfile&display='.$post['form_usage'],'Please enter email address','error');
		}
		if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/", strtolower($post["rp_email"]))) {
			$config = JFactory::getConfig();
			$encryptPassword = $config->getValue( 'synpat_symbol' );
			$display = openssl_encrypt($post['form_usage'],"AES-128-ECB",$encryptPassword);
			$app->redirect('index.php?option=com_survey&task=customer.expertProfile&display='.$display,'Please enter correct email address','error');
		} else {
			$CORRECT_EMAIL = htmlentities($post["rp_email"], ENT_COMPAT, "UTF-8");
		}
		$getData = $this->getModel()->expertData($post["form_usage"]);
		$recipient = "";
		if(count($getData)>0){
			$recipient = $getData->email;
		}
		$mySubject = $post["rp_subject"];
		$myMessage = 'You received a message from'.$fromName. '('. $post["rp_email"].')' ."\n\n". $CORRECT_MESSAGE;
		$mailSender = JFactory::getMailer();
		$mailSender->addRecipient($recipient);
		$mailSender->setSender(array($fromEmail,$fromName));
		$mailSender->addReplyTo(array( $post["rp_email"], '' ));
		$mailSender->setSubject($CORRECT_SUBJECT);
		$mailSender->setBody($myMessage);
		$config = JFactory::getConfig();
		$encryptPassword = $config->getValue( 'synpat_symbol' );
		$display = openssl_encrypt($post['form_usage'],"AES-128-ECB",$encryptPassword);
		if ($mailSender->Send() !== true) {
			$app->redirect('index.php?option=com_survey&task=customer.expertProfile&display='.$display,'Please try after sometime','error');
		}
		else {
			$app->redirect('index.php?option=com_survey&task=customer.expertProfile&display='.$display,'Email send to expert','success');
		}
	}

    function getCountryStateData()
    {
        $post = JRequest::get('post');
        $getList = $this->getModel()->getCountryStateData($post['p']);
        echo json_encode($getList);
    }

    function updateLinkedProfile()
    {
        $app = JFactory::getApplication();
        $session = JFactory::getSession();
        $getSession = $session->get('expertSession', '');
        if (count($getSession) > 0) {
            $this->getAuthenticateUser();

			$session = JFactory::getSession();
			$getSession = $session->get('expertSession', '');
			$config = JFactory::getConfig();
			$encryptPassword = $config->getValue( 'synpat_symbol' );
			$display = openssl_encrypt($getSession->id,"AES-128-ECB",$encryptPassword);
            if ($_SESSION['state'] == JRequest::getVar('state')) {
				$config = JFactory::getConfig();
				$encryptPassword = $config->getValue( 'synpat_symbol' );
				$display = openssl_encrypt($getSession->id,"AES-128-ECB",$encryptPassword);
                if ($this->getAccessToken()) {
                    $user = $this->fetch('GET', '/v1/people/~:(id,first-name,last-name,email-address,picture-url,public-profile-url)');
                    $firstname = $user->firstName;
                    $lastname = $user->lastName;
                    $emailaddress = $user->emailAddress;
                    $profilePic = $user->pictureUrl;
                    $linkedin_profile_url = $user->publicProfileUrl;
                    $linkedID = $user->id;
                    if (count($getSession) > 0) {
                        $updateData = $this->getModel()->updateExpertLinkedInProfile($linkedin_profile_url, $linkedID, $profilePic, $getSession->id);
                        if ($updateData == 0) {
                            $app->redirect('index.php?option=com_survey&task=customer.expertProfile&display=' . $display, 'Profile updated successfully.', 'Message');
                        } else {
                            $app->redirect('index.php?option=com_survey&task=customer.expertProfile&display=' . $display, 'Unable to update profile.', 'Error');
                        }
                    }
                } else {
                    $app->redirect('index.php?option=com_survey&task=customer.expertProfile&display=' . $display, 'Unable to retrive data from LinkedIn, Please try after some time.', 'Error');
                }
            } else {
                $app->redirect('index.php?option=com_survey&task=customer.expertProfile&display=' . $getSession->id, 'Unable to retrive data from LinkedIn, Please try after some time.', 'Error');
            }
        } else {
            $app->redirect('index.php#create', 'Session expired', 'Error');
        }
    }
	
	function feedback(){
		JSession::checkToken('post') or jexit(JText::_('JInvalid_Token'));
		$post = JRequest::get('post');
		$config	= JFactory::getConfig();
		$emailSubject = "Feedback";
		$data['fromname'] = $config->get('fromname');
		$data['mailfrom'] = $post['email'];
		$data['mailto'] = $config->get('mailfrom');
		$data['sitename'] = 'SynPat.com/experts';
		$emailBody = $post['message']."<br/> Thanks <br/>".$post['name'];
		$return = JFactory::getMailer()->sendMail($data['mailfrom'], $post['name'], $data['mailto'], $emailSubject, $emailBody,true);
		$return1 = JFactory::getMailer()->sendMail($data['mailto'], 'SynPat.com/experts', $data['mailfrom'], $emailSubject, 'Thank you for your feedback, we will get back to you shortly.<br/>Team<br/> SynPat.com/experts',true);
		$message = "";
		$type="";
		if ($return !== true) {
			$message = "Sorry we are not able to send message, Please try after sometime or send mailto:".$data['mailto'].".";
			$type ="error";
		} else {
			$message = "Thank you for your feedback, we will get back to you shortly.";
			$type ="success";
		}
		$app = JFactory::getApplication();
		$app->redirect('index.php', $message, $type);
	}

    function getAuthenticateUser()
    {
        // Change these
        define('API_KEY', '03un4sib96jz');
        define('API_SECRET', 'JisA5yo9TH0CNC0J');
        /*define('REDIRECT_URI', 'http://oscuz.com/survey/index.php?option=com_survey&task=survey.register&tab=auth&l=register');*/
        define('REDIRECT_URI', 'http://claimcharts.info/index.php?option=com_survey&task=customer.updateLinkedProfile');
        define('SCOPE', 'r_fullprofile r_emailaddress rw_nus');
        session_name('linkedin');
        session_start();
    }

    function getAccessToken()
    {

        $params = array('grant_type' => 'authorization_code',
            'client_id' => API_KEY,
            'client_secret' => API_SECRET,
            'code' => $_GET['code'],
            'redirect_uri' => REDIRECT_URI,
        );

        // Access Token request
        $url = 'https://www.linkedin.com/uas/oauth2/accessToken?' . http_build_query($params);
        // Tell streams to make a POST request
        $context = stream_context_create(
            array('http' =>
                array('method' => 'POST',
                )
            )
        );


        // Retrieve access token information
        if (file_get_contents($url, false, $context)) {
            $response = file_get_contents($url, false, $context);
        } else {
            unset($_SESSION['access_token']);
            return false;
            //$app = JFactory::getApplication();
            //$app->redirect('index.php?option=com_survey&task=survey.register');
        }
        // Native PHP object, please
        $token = json_decode($response);
        // Store access token and expiration time
        $_SESSION['access_token'] = $token->access_token; // guard this!
        $_SESSION['expires_in'] = $token->expires_in; // relative time (in seconds)
        $_SESSION['expires_at'] = time() + $_SESSION['expires_in']; // absolute time
        return true;
    }

    function getAuthorizationCode()
    {
        $params = array('response_type' => 'code',
            'client_id' => API_KEY,
            'scope' => SCOPE,
            'state' => uniqid('', true), // unique long string
            'redirect_uri' => REDIRECT_URI,
        );
        // Authentication request
        $url = 'https://www.linkedin.com/uas/oauth2/authorization?' . http_build_query($params);
        // Needed to identify request when it returns to us
        $_SESSION['state'] = $params['state'];
        return $url;
    }

    function fetch($method, $resource, $body = '')
    {
        $params = array('oauth2_access_token' => $_SESSION['access_token'],
            'format' => 'json',
        );
        // Need to use HTTPS
        $url = 'https://api.linkedin.com' . $resource . '?' . http_build_query($params);

        // Tell streams to make a (GET, POST, PUT, or DELETE) request
        $context = stream_context_create(
            array('http' =>
                array('method' => $method,
                )
            )
        );
        // Hocus Pocus
        $response = file_get_contents($url, false, $context);
        // Native PHP object, please
        return json_decode($response);
    }


    function getCaptcha()
    {

        //Settings: You can customize the captcha here
        $image_width = 90;
        $image_height = 30;
        $characters_on_image = 4;
        $font = JPATH_COMPONENT . '/monofont.ttf';
        //The characters that can be used in the CAPTCHA code.
        //avoid confusing characters (l 1 and i for example)
        $possible_letters = '23456789bcdfghjkmnpqrstvwxyz';
        $random_dots = 10;
        $random_lines = 5;
        $captcha_text_color = "0x142864";
        $captcha_noice_color = "0x142864";
        $code = '';
        $i = 0;
        while ($i < $characters_on_image) {
            $code .= substr($possible_letters, mt_rand(0, strlen($possible_letters) - 1), 1);
            $i++;
        }
        if (session_id() != '') {
            session_start();
        }
        $_SESSION['6_letters_code'] = $code;
        $font_size = $image_height * 0.75;
        $image = @imagecreate($image_width, $image_height);


        /* setting the background, text and noise colours here */
        $background_color = imagecolorallocate($image, 255, 255, 255);

        $arr_text_color = $this->hexrgb($captcha_text_color);
        $text_color = imagecolorallocate($image, $arr_text_color['red'],
            $arr_text_color['green'], $arr_text_color['blue']);

        $arr_noice_color = $this->hexrgb($captcha_noice_color);
        $image_noise_color = imagecolorallocate($image, $arr_noice_color['red'],
            $arr_noice_color['green'], $arr_noice_color['blue']);


        /* generating the dots randomly in background */
        for ($i = 0; $i < $random_dots; $i++) {
            imagefilledellipse($image, mt_rand(0, $image_width),
                mt_rand(0, $image_height), 2, 3, $image_noise_color);
        }


        /* generating lines randomly in background of image */
        for ($i = 0; $i < $random_lines; $i++) {
            imageline($image, mt_rand(0, $image_width), mt_rand(0, $image_height),
                mt_rand(0, $image_width), mt_rand(0, $image_height), $image_noise_color);
        }


        /* create a text box and add 6 letters code in it */
        $textbox = imagettfbbox($font_size, 0, $font, $code);
        $x = ($image_width - $textbox[4]) / 2;
        $y = ($image_height - $textbox[5]) / 2;
        imagettftext($image, $font_size, 0, $x, $y, $text_color, $font, $code);
        /*
        $session = JFactory::getSession();
        $session->set('6_letters_code',$code);
        */

        /* Show captcha image in the page html page */
        //header('Content-Type: image/jpeg'); // defining the image type to be shown in browser widow
        $doc =& JFactory::getDocument();
        $doc->setMimeEncoding('image/jpeg');
        imagejpeg($image); //showing the image
        //imagedestroy($image);//destroying the image instance
    }

    function hexrgb($hexstr)
    {
        $int = hexdec($hexstr);

        return array("red" => 0xFF & ($int >> 0x10),
            "green" => 0xFF & ($int >> 0x8),
            "blue" => 0xFF & $int);
    }

    function getCaptcha1()
    {

        //Settings: You can customize the captcha here
        $image_width = 90;
        $image_height = 30;
        $characters_on_image = 4;
        $font = JPATH_COMPONENT . '/monofont.ttf';
        //The characters that can be used in the CAPTCHA code.
        //avoid confusing characters (l 1 and i for example)
        $possible_letters = '23456789bcdfghjkmnpqrstvwxyz';
        $random_dots = 10;
        $random_lines = 5;
        $captcha_text_color = "0x142864";
        $captcha_noice_color = "0x142864";
        $code = '';
        $i = 0;
        while ($i < $characters_on_image) {
            $code .= substr($possible_letters, mt_rand(0, strlen($possible_letters) - 1), 1);
            $i++;
        }
        if (session_id() != '') {
            session_start();
        }
        $_SESSION['6_letters_code_register'] = $code;

        $font_size = $image_height * 0.75;
        $image = @imagecreate($image_width, $image_height);


        /* setting the background, text and noise colours here */
        $background_color = imagecolorallocate($image, 255, 255, 255);

        $arr_text_color = $this->hexrgb($captcha_text_color);
        $text_color = imagecolorallocate($image, $arr_text_color['red'],
            $arr_text_color['green'], $arr_text_color['blue']);

        $arr_noice_color = $this->hexrgb($captcha_noice_color);
        $image_noise_color = imagecolorallocate($image, $arr_noice_color['red'],
            $arr_noice_color['green'], $arr_noice_color['blue']);


        /* generating the dots randomly in background */
        for ($i = 0; $i < $random_dots; $i++) {
            imagefilledellipse($image, mt_rand(0, $image_width),
                mt_rand(0, $image_height), 2, 3, $image_noise_color);
        }


        /* generating lines randomly in background of image */
        for ($i = 0; $i < $random_lines; $i++) {
            imageline($image, mt_rand(0, $image_width), mt_rand(0, $image_height),
                mt_rand(0, $image_width), mt_rand(0, $image_height), $image_noise_color);
        }


        /* create a text box and add 6 letters code in it */
        $textbox = imagettfbbox($font_size, 0, $font, $code);
        $x = ($image_width - $textbox[4]) / 2;
        $y = ($image_height - $textbox[5]) / 2;
        imagettftext($image, $font_size, 0, $x, $y, $text_color, $font, $code);
        /*
        $session = JFactory::getSession();
        $session->set('6_letters_code_register',$code);
        */
        /* Show captcha image in the page html page */
        //header('Content-Type: image/jpeg');// defining the image type to be shown in browser widow
        $doc =& JFactory::getDocument();
        $doc->setMimeEncoding('image/jpeg');
        imagejpeg($image); //showing the image
        //imagedestroy($image);//destroying the image instance
    }

    function getCaptcha2()
    {

        //Settings: You can customize the captcha here
        $image_width = 90;
        $image_height = 30;
        $characters_on_image = 4;
        $font = JPATH_COMPONENT . '/monofont.ttf';
        //The characters that can be used in the CAPTCHA code.
        //avoid confusing characters (l 1 and i for example)
        $possible_letters = '23456789bcdfghjkmnpqrstvwxyz';
        $random_dots = 10;
        $random_lines = 5;
        $captcha_text_color = "0x142864";
        $captcha_noice_color = "0x142864";
        $code = '';
        $i = 0;
        while ($i < $characters_on_image) {
            $code .= substr($possible_letters, mt_rand(0, strlen($possible_letters) - 1), 1);
            $i++;
        }
        if (session_id() != '') {
            session_start();
        }
        $_SESSION['6_letters_code_register_2'] = $code;

        $font_size = $image_height * 0.75;
        $image = @imagecreate($image_width, $image_height);


        /* setting the background, text and noise colours here */
        $background_color = imagecolorallocate($image, 255, 255, 255);

        $arr_text_color = $this->hexrgb($captcha_text_color);
        $text_color = imagecolorallocate($image, $arr_text_color['red'],
            $arr_text_color['green'], $arr_text_color['blue']);

        $arr_noice_color = $this->hexrgb($captcha_noice_color);
        $image_noise_color = imagecolorallocate($image, $arr_noice_color['red'],
            $arr_noice_color['green'], $arr_noice_color['blue']);


        /* generating the dots randomly in background */
        for ($i = 0; $i < $random_dots; $i++) {
            imagefilledellipse($image, mt_rand(0, $image_width),
                mt_rand(0, $image_height), 2, 3, $image_noise_color);
        }


        /* generating lines randomly in background of image */
        for ($i = 0; $i < $random_lines; $i++) {
            imageline($image, mt_rand(0, $image_width), mt_rand(0, $image_height),
                mt_rand(0, $image_width), mt_rand(0, $image_height), $image_noise_color);
        }


        /* create a text box and add 6 letters code in it */
        $textbox = imagettfbbox($font_size, 0, $font, $code);
        $x = ($image_width - $textbox[4]) / 2;
        $y = ($image_height - $textbox[5]) / 2;
        imagettftext($image, $font_size, 0, $x, $y, $text_color, $font, $code);
        /*
        $session = JFactory::getSession();
        $session->set('6_letters_code_register',$code);
        */
        /* Show captcha image in the page html page */
        //header('Content-Type: image/jpeg');// defining the image type to be shown in browser widow
        $doc =& JFactory::getDocument();
        $doc->setMimeEncoding('image/jpeg');
        imagejpeg($image); //showing the image
        //imagedestroy($image);//destroying the image instance
    }

    function getCaptcha3()
    {

        //Settings: You can customize the captcha here
        $image_width = 90;
        $image_height = 30;
        $characters_on_image = 4;
        $font = JPATH_COMPONENT . '/monofont.ttf';
        //The characters that can be used in the CAPTCHA code.
        //avoid confusing characters (l 1 and i for example)
        $possible_letters = '23456789bcdfghjkmnpqrstvwxyz';
        $random_dots = 10;
        $random_lines = 5;
        $captcha_text_color = "0x142864";
        $captcha_noice_color = "0x142864";
        $code = '';
        $i = 0;
        while ($i < $characters_on_image) {
            $code .= substr($possible_letters, mt_rand(0, strlen($possible_letters) - 1), 1);
            $i++;
        }
        if (session_id() != '') {
            session_start();
        }
        $_SESSION['6_letters_code_register_3'] = $code;

        $font_size = $image_height * 0.75;
        $image = @imagecreate($image_width, $image_height);


        /* setting the background, text and noise colours here */
        $background_color = imagecolorallocate($image, 255, 255, 255);

        $arr_text_color = $this->hexrgb($captcha_text_color);
        $text_color = imagecolorallocate($image, $arr_text_color['red'],
            $arr_text_color['green'], $arr_text_color['blue']);

        $arr_noice_color = $this->hexrgb($captcha_noice_color);
        $image_noise_color = imagecolorallocate($image, $arr_noice_color['red'],
            $arr_noice_color['green'], $arr_noice_color['blue']);


        /* generating the dots randomly in background */
        for ($i = 0; $i < $random_dots; $i++) {
            imagefilledellipse($image, mt_rand(0, $image_width),
                mt_rand(0, $image_height), 2, 3, $image_noise_color);
        }


        /* generating lines randomly in background of image */
        for ($i = 0; $i < $random_lines; $i++) {
            imageline($image, mt_rand(0, $image_width), mt_rand(0, $image_height),
                mt_rand(0, $image_width), mt_rand(0, $image_height), $image_noise_color);
        }


        /* create a text box and add 6 letters code in it */
        $textbox = imagettfbbox($font_size, 0, $font, $code);
        $x = ($image_width - $textbox[4]) / 2;
        $y = ($image_height - $textbox[5]) / 2;
        imagettftext($image, $font_size, 0, $x, $y, $text_color, $font, $code);
        /*
        $session = JFactory::getSession();
        $session->set('6_letters_code_register',$code);
        */
        /* Show captcha image in the page html page */
        //header('Content-Type: image/jpeg');// defining the image type to be shown in browser widow
        $doc =& JFactory::getDocument();
        $doc->setMimeEncoding('image/jpeg');
        imagejpeg($image); //showing the image
        //imagedestroy($image);//destroying the image instance
    }
}
