<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
 

class SurveyModelApi extends JModelItem
{   
	function getParentExpertise(){
        $db = JFactory::getDBO();
        $sql = "SELECT * FROM #__expertisearea WHERE parent=0 ORDER BY name ASC";
        $db->setQuery($sql);
        return $db->loadObjectList();
    }
	
	function agreement($t){
        $db = JFactory::getDBO();
        $sql = "SELECT * FROM #__agreement WHERE type=".$t;
        $db->setQuery($sql);
        return $db->loadObject();
    }

	function getAreaOfExpertise()
    {
        $db = JFactory::getDBO();
        $sql = "SELECT * FROM #__expertisearea ORDER BY name ASC";
        $db->setQuery($sql);
        return $db->loadObjectList();
    }
	function getSurveyListByProjectID($projectID){
		$sqlSurvey = "SELECT s.* FROM #__survey as s WHERE s.project_id ='".$projectID."' ORDER BY s.`name` ASC ";
		$db = JFactory::getDBO();
		$db->setQuery($sqlSurvey);
		$db->query();		
		return $db->loadAssocList(); 		
	}
    function getSurveyList($id=null)
    {
        $db =& JFactory::getDBO();
		$sql = "";
		$sqlSurvey = "";
		$getProjectID = JRequest::getVar('project_id',$id);
        if(empty($getProjectID) || $getProjectID==null){
			$sql =  "SELECT count(*) FROM #__survey ORDER BY `name` ASC ";
			$sqlSurvey = "SELECT s.* , p.name as project_name FROM #__survey as s LEFT JOIN #__projects as p ON p.id = s.project_id  ORDER BY s.`name` ASC ";				
		} else {
			$sql =  "SELECT count(*) FROM #__survey ORDER BY `name` WHERE project_id ='".$getProjectID."' ASC ";
			$sqlSurvey = "SELECT s.* , p.name as project_name FROM #__survey as s LEFT JOIN #__projects as p ON p.id = s.project_id  WHERE s.project_id ='".$getProjectID."' ORDER BY s.`name` ASC ";				
		}
        $db->setQuery($sql);
		$db->query();
		$this->_total = $db->loadResult();
		$db->setQuery($sqlSurvey);
		$db->query();		
		$data = $db->loadAssocList();        
        if(count($data) > 0) {
            for($i=0;$i<count($data);$i++) {
                $row = $data[$i];
                $getClaimOrderedDate = SurveyModelApi::getSurveyOrderedDate($row['id']);
    			if(count($getClaimOrderedDate)>0){
    				$data[$i]['create_date'] = date('M d, Y',strtotime($getClaimOrderedDate['create_date']));
    			}                
                $data[$i]['deadline'] = date('M d, Y',strtotime($row['deadline']));                
                $getCreatedDate = SurveyModelApi::getLastQuestionClaim($row['id']);
				if(count($getCreatedDate)>0){
					$data[$i]['Questionare_Created'] =  date('M d, Y',strtotime($getCreatedDate->created_date));
				} else {
					$data[$i]['Questionare_Created'] = '';
				}                
                $sendToExpertData = SurveyModelApi::getClaimDateToExpert($row['id']);
				if(count($sendToExpertData)>0){
					$data[$i]['Sent_to_Expert'] =   date('M d, Y',strtotime($sendToExpertData->send_date ));
				}  else  {
                    $data[$i]['Sent_to_Expert'] = '';
                }
                //echo 'arr '.$row['id'];
                $successSend = SurveyModelApi::getClaimsSendToExpertSuccess($row['id']);
				$data[$i]['of_Experts'] =  $successSend->emailSend;
                
                $failedSend = SurveyModelApi::getClaimsSendToExpertFailed($row['id']);
				$data[$i]['Failed'] =  $failedSend->emailSend;
                
                $inProcessClaim = SurveyModelApi::getInProcessClaim($row['id']);
				$data[$i]['CC_InProcess'] =  (count($inProcessClaim)>0)?$inProcessClaim->inProcess:'0';
                
                $getExpertList = $this->getExpertListBySurveyAns($row['id']);
				$data[$i]['CC_Submitted'] = count($getExpertList);
                
                $noOfReportSold = SurveyModelApi::claimSoldReport($row['id']);
                $data[$i]['sold'] = count($noOfReportSold );
            }
        }
        return $data;
    }
	function expertRatingData($expertID)
    {
        $db = JFactory::getDBO();
        $sql = "SELECT sum(er.rating) as rating, count(er.survey_id) as countSurvey , s.id as surveyID , s.name as surveyName,e.id,e.name as expertName ,  e.linkedin_pic as linkedin_pic, e.linkedin_profile_url as linkedin_profile_url FROM #__expertrating as er LEFT JOIN #__expert as e ON e.id = er.expert_id LEFT JOIN #__survey as s ON s.id = er.survey_id WHERE er.expert_id='" . $expertID . "' GROUP BY er.survey_id";
        $db->setQuery($sql);
        return $db->loadObjectList();
    }
	function expertData($expertID) 
    {
        $db = JFactory::getDBO();
        $sql = "SELECT e.* , p.paypal_id,u.username FROM #__expert as e INNER JOIN #__users as u ON e.user_id = u.id LEFT JOIN #__expert_payment as p ON p.expert_id = e.id WHERE e.id='" . $expertID . "'";
        $db->setQuery($sql);
        return $db->loadObject();
    }
	function getQueAnsData($surveyID, $expertID, $target, $target_product)
    {
        $db = JFactory::getDBO();
        $sql = "SELECT q.* , qa.id as answerID, qa.answer as answer, qa.supporting_document as supporting_document FROM #__question as q LEFT JOIN `#__survey_question_answer` qa ON q.id = qa.ques_id WHERE q.survey_id='" . $surveyID . "' AND qa.expert_id='" . $expertID . "' AND qa.target='" . $target . "' AND qa.target_product='" . $target_product . "' ORDER BY q.id ASC";
        $db->setQuery($sql);
        return $db->loadObjectList();
    }
	function getQueAnsDataPrior($surveyID, $expertID)
    {
        $db = JFactory::getDBO();
        $sql = "SELECT q.* , qa.id as answerID, qa.answer as answer, qa.supporting_document as supporting_document FROM #__question as q LEFT JOIN `#__survey_question_answer` qa ON q.id = qa.ques_id WHERE q.survey_id='" . $surveyID . "' AND qa.expert_id='" . $expertID . "' ORDER BY q.id ASC";
        $db->setQuery($sql);
        return $db->loadObjectList();
    }
    function getExpertDetail($id){
        $db =& JFactory::getDBO();
		$expert_id = "";
		$id_val = JRequest::getVar("cid", "", "post", "array");
		if(is_array($id_val) && count($id_val) > 0 && $id_val["0"] != ""){
			$cids = JRequest::getVar("cid", "", "post", "array");
			$expert_id = $cids[0];
		} else{
			$expert_id = JRequest::getVar("id", "0", "", "int");		
		}		
		$result = new StdClass();		
		if($expert_id > 0){
			$sql = "SELECT * FROM #__expert WHERE id=".$expert_id;
			$db->setQuery($sql);
			$db->query();
			$result = $db->loadObject();			
			$result->id = $expert_id;					
		} else{
			$get = JRequest::get();
			foreach($get as $key => $val){
				$result->$key = $val;
			}
		}
		if(!isset($result->id)){
			$result->id = 0;
		}
		if(!isset($result->name)){
			$result->name = "";
		}		
		if(!isset($result->description)){
			$result->description = "";
		}
      	return $result;
    }
    function saveUser(){
		/*$dataPost = JRequest::get('post');
		if($dataPost['id']=="0"){
			$dataPost['username'] = $dataPost['email'];
			$dataPost['password'] = "claim123";
			$dataPost['password2'] = "claim123";
		}
		function addJoomlaUser($name, $username, $password, $email) {
        $data = array(
            "name"=>$name, 
            "username"=>$username, 
            "password"=>$password,
            "password2"=>$password,
            "email"=>$email
        );

        $user = clone(JFactory::getUser());
        //Write to database
        if(!$user->bind($data)) {
            throw new Exception("Could not bind data. Error: " . $user->getError());
        }
        if (!$user->save()) {
            throw new Exception("Could not save user. Error: " . $user->getError());
        }

        return $user->id;
}
		*/
	}
	
	function update_report_price(){
		$data = JRequest::get('post');
		$query = "UPDATE #__survey_amount_expert SET run_report=0, specific_amount=".$data['v']." WHERE id=".$data['p'];
		$db = JFactory::getDBO();
        $db->setQuery( $query );
		if (!$db->query()) {
			return array('id'=>0);
		} else {
			return array('id'=>1);
		}
	}
	
	function show_report_price(){
		$data = JRequest::get('post');
		$updatedRecords = array('id'=>"");
		$query = "SELECT expert_id,survey_id,target,target_product,report_option_type FROM #__survey_amount_expert WHERE id=".$data['p'];
		$db = JFactory::getDBO();
        $db->setQuery( $query );
		$getData = $db->loadObject();
		if(count($getData)>0){
			if($getData->report_option_type==2){
				if($show==1){
					$updateQuery = "UPDATE #__survey_question_answer SET notify=2,posted_date='".date('Y-m-d H:i:s')."' , `show` =".$data['s'];
				} else {
					$updateQuery = "UPDATE #__survey_question_answer SET notify=2 , `show` =".$data['s'];
				}
				$updateQuery .= " WHERE target='".$getData->target."' AND target_product='".$getData->target_product."' AND expert_id=".$getData->expert_id." AND ques_id IN (SELECT id FROM #__question WHERE survey_id=".$getData->survey_id.")";
			}else if($getData->report_option_type==1){
				if($show==1){
					$updateQuery = "UPDATE #__survey_question_answer SET notify=2,posted_date='".date('Y-m-d H:i:s')."' , `show` =".$data['s'];
				} else {
					$updateQuery = "UPDATE #__survey_question_answer SET notify=2 , `show` =".$data['s'];
				}
				$updateQuery .= " WHERE target='".$getData->target."' AND expert_id=".$getData->expert_id." AND ques_id IN (SELECT id FROM #__question WHERE survey_id=".$getData->survey_id.")";
			}
			if(isset($updateQuery)){
				$db->setQuery( $updateQuery );
				if (!$db->query()) {
					$updatedRecords = array('id'=>0);
				} else {
					$updatedRecords = array('id'=>1);
					$this->sendNotificationToBackyard(array('action'=>'claimchart_new_report','id'=>0,'d_d'=>'New Report','type'=>0));
				}
			}
		}
		return $updatedRecords;
	}
	
	function sendNotificationToBackyard($postData){
		$ch = curl_init();		
		$api_url = 'https://backyard.synpat.com/customers/push_notification_scrape_linkedin';
		curl_setopt($ch, CURLOPT_URL, $api_url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$postData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3000);
		curl_setopt($ch, CURLOPT_TIMEOUT, 3000);
		$response = curl_exec($ch); 
		curl_close($ch);
		return $response;
	}
	
	function findNewReports(){
		$db = JFactory::getDBO();
		$targetProductsQuery = "SELECT qa.target,qa.target_product FROM #__survey_question_answer as qa LEFT JOIN #__question as q ON q.id = qa.ques_id LEFT JOIN #__survey as s ON s.id = q.survey_id WHERE qa.showed=0 AND `notify`=1 GROUP By qa.target,qa.target_product";
		$db->setQuery($targetProductsQuery);
		$getList = $db->loadObjectList();
		return count($getList);
	}
	
	function insertExpertMassPayment($data){
		$db = JFactory::getDBO();
		$sql = "INSERT INTO #__expert_mass_payment(expert_id,survey_id,report_id,amount,busness_email,message,error_code,create_date,payment_timestamp,correlationid,build  )VALUES('".$data['expert_id']."','".$data['survey_id']."','".$data['report_id']."','".$data['amount']."','".$data['busness_email']."','".$data['message']."','".$data['error_code']."','".$data['create_date']."','".$data['payment_timestamp']."','".$data['correlationid']."','".$data['build']."')";
		$db->setQuery($sql);
		if($db->query()){
			return true;
		} else {
			return false;
		}
	}
	
	function updateReportPaidStatus($paidStatus,$reportID,$exportID){
		 $query = 'UPDATE #__survey_amount_expert'
               . ' SET paid = '.(int) $paidStatus
               . ' WHERE id = '.$reportID.' AND expert_id = '.$exportID;
              
		$db = JFactory::getDBO();
		$db->setQuery( $query );
		if (!$db->query()) {	
			return 0;
	 	} else {
			return 1;
		}
	}
	
	function updateAgreement($data){
		$db =& JFactory::getDBO();
		$item =& $this->getTable('agreement');		
		if (!$item->bind($data)){
			echo $item->getError().' - 1';
			return false;
		}
		if (!$item->check()) {
			echo $item->getError().' - 2';
			return false;
		}			
		if (!$item->store()) {
			echo $item->getError().' - 3';
			return false;
		}
        //echo $item->id;
		return $item->id;
	}
	
    function saveExpertDetail(){
		//$app = JFactory::getApplication('administrator');
		$data = $_REQUEST;	
		if(count($data)>0){
			$getData = SurveyModelApi::getExpertData($data['id']);
			if(count($getData)>0){
				$textData  = json_decode($getData->text_data);
				$newData = array();
				$newData['first_name'] = (isset($textData->f))?$textData->f:$getData->first_name;
				$newData['last_name'] = (isset($textData->l))?$textData->l:$getData->first_name;
				$newData['name'] = $newData['first_name']." ".$newData['last_name'];
				$newData['email'] = (isset($textData->em))?$textData->em:$getData->email;
				$newData['company_name'] = (isset($textData->c))?$textData->c:$getData->company_name;
				$newData['description'] = (isset($textData->expl))?$textData->expl:$getData->description;
				$newData['phone'] = (isset($textData->p))?$textData->p:$getData->phone;
				$newData['address'] = (isset($textData->a))?$textData->a:$getData->address;
				$newData['web'] = (isset($textData->w))?$textData->w:$getData->web;
				$newData['state'] = (isset($textData->st))?$textData->st:$getData->state;
				$newData['city'] = (isset($textData->ci))?$textData->ci:$getData->city;
				$newData['zip'] = (isset($textData->zi))?$textData->zi:$getData->zip;
				$newData['membership'] = (isset($textData->me))?$textData->me:$getData->membership;
				$newData['areas_of_expertise'] = (isset($textData->ae))?$textData->ae:$getData->areas_of_expertise;
				$newData['standards_groups'] = (isset($textData->sg))?$textData->sg:$getData->standards_groups;
				$newData['standards_groups'] = (isset($textData->cv))?$textData->cv:$getData->cv;
				$newData['profile_image_file_name'] = (isset($textData->img))?$textData->img:$getData->profile_image_file_name;
				$newData['pub'] = 0;
				$newData['text_data'] = '';
				$newData['id'] = $data['id'];
				if(SurveyModelApi::save($newData)){
					$msg ='Expert details published';
				//	$this->setRedirect( 'index.php?option=com_survey&task=expert.list', $msg );
              //  return true;
				}else{
					$msg = 'Error in published expert details';
					//$this->setRedirect( 'index.php?option=com_survey&task=expert.list', $msg, "notice");
                //    return false;
				}
			} else {
                    $msg = 'Expert not found!';
                  //  $this->setRedirect( 'index.php?option=com_survey&task=expert.list', $msg, "notice");
			}
		} else {
			$msg = 'Not able to find data';
		//	$this->setRedirect( 'index.php?option=com_survey&task=expert.list', $msg, "notice");
		}
        return $msg;
	}
    function publish_list($cid=null,$publish){
    $cid = JRequest::getVar("cid", $cid);
    if (count( $cid ))
        {
       //  JArrayHelper::toInteger($cid,$publish);
        // $cids = implode( ',', $cid );
         $query = 'UPDATE #__expert'
               . ' SET published = '.(int) $publish
               . ' WHERE id IN ( '.$cid.' )';
              
          $db = JFactory::getDBO();
          $db->setQuery( $query );
            if (!$db->query()) {
                $this->setError($db->getErrorMsg());
                return false;
             }
        }
           return true;
   }
   
   function expert_see_list($cid=null,$publish){
		$cid = JRequest::getVar("cid", $cid);
		if ($cid!=null){
			$getExpertData = $this->getExpertData($cid);
			if(count($getExpertData)>0){
				$query = 'UPDATE #__users'
               . ' SET can_see = '.(int) $publish
               . ' WHERE id IN ( '.$getExpertData->user_id.' )';
			    $db = JFactory::getDBO();
				$db->setQuery( $query );
				if ($db->query()) {
					return true;
				 } else {
					$this->setError($db->getErrorMsg());
					return false;
				 }
			}
        }  
   }
   
   
    function deleteFeedback($cid){
        if (count( $cid ))
         {
            // JArrayHelper::toInteger($cid);
             $cids = implode( ',', $cid );
			 $query = 'DELETE FROM #__expertrating WHERE id IN ( '.$cids.' )';
             $db = JFactory::getDBO();
             $db->setQuery( $query );
                if (!$db->query()) {
                    $this->setError($db->getErrorMsg());
                    return false;
                 }
           }
           return true;
    }
    function save($data){
		$db =& JFactory::getDBO();
		$item =& $this->getTable('Expert');		
		if (!$item->bind($data)){
			echo $item->getError().' - 1';
			return false;
		}
		if (!$item->check()) {
			echo $item->getError().' - 2';
			return false;
		}			
		if (!$item->store()) {
			echo $item->getError().' - 3';
			return false;
		}
        //echo $item->id;
		return $item->id;
	}
	
	function saveQuestion($data){
		$db =& JFactory::getDBO();
		$item =& $this->getTable('Question');		
		if (!$item->bind($data)){
			echo $item->getError().' - 1';
			return false;
		}
		if (!$item->check()) {
			echo $item->getError().' - 2';
			return false;
		}			
		if (!$item->store()) {
			echo $item->getError().' - 3';
			return false;
		}
        //echo $item->id;
		return $item->id;
	}
    function getExpertData($expertID){
		$db = JFactory::getDBO();
		$sql = "SELECT * FROM #__expert WHERE id=".$expertID;
		$db->setQuery($sql);
		return $db->loadObject();
	}
    function surveyDetail($surveyID){
		$db = JFactory::getDBO();
		$sql = "SELECT * FROM #__survey WHERE id = '".$surveyID."'";
		$db->setQuery($sql);
		return $db->loadObject();
	}
	function getReportDetail($type,$expertID,$surveyID,$target=null,$targetProduct=null){
		if((int)$type==2){
			
		}
	}
    function getQuestionList($id=null){        
        $db =& JFactory::getDBO();
		$sql = "";
		$sqlQuestion = "";
		$getSurveyID = JRequest::getVar('survey_id',$id);
        if(empty($getSurveyID)){
			$sql =  "SELECT count(*) FROM #__question ORDER BY `question_order` ASC ";
			$sqlQuestion = "SELECT q.* , s.name as survey_name FROM #__question as q LEFT JOIN #__survey as s ON s.id = q.survey_id ORDER BY q.`question_order` ASC ";
		} else {
			$sql =  "SELECT count(*) FROM #__question as q LEFT JOIN #__survey as s ON s.id = q.survey_id WHERE  q.survey_id='".$getSurveyID."' ORDER BY q.`question_order` ASC  ";
			$sqlQuestion = "SELECT q.* , s.name as survey_name FROM #__question as q LEFT JOIN #__survey as s ON s.id = q.survey_id WHERE q.survey_id='".$getSurveyID."' ORDER BY q.`question_order` ASC ";
		}           
		$db->setQuery($sql);
		$db->query();
		$this->_total = $db->loadResult();	    
		$db->setQuery($sqlQuestion);
		$db->query();
		$data = $db->loadAssocList();
        if(count($data) > 0) {
            for($i = 0;$i<count($data);$i++)  {
                $data[$i]['survey_detail'] = SurveyModelApi::surveyDetail($getSurveyID);
            }
        }
        return $data;
    }
    function getFeedback($id=null){
        $db = JFactory::getDBO();
        $getSurveyID = JRequest::getVar('id',$id);
		$sql = "SELECT er.* , s.combine_name as combineName FROM #__expertrating as er LEFT JOIN #__survey as s ON s.id = er.survey_id WHERE er.expert_id = '".$getSurveyID."' ORDER BY er.id DESC";
		$db->setQuery($sql);
		$data = $db->loadAssocList();
        return $data;
    }
    function claimSoldReport($surveyID){
		$db = JFactory::getDBO();
		$sql = "SELECT * FROM #__transactions WHERE survey_id = '".$surveyID."' AND type= 0 AND success = 'Paid'";		
		$db->setQuery($sql);
		return $db->loadObjectList();
	}
    function getExpertListBySurveyAns($surveyID){
		$db =& JFactory::getDBO();
		$sql = "SELECT e.id , e.name FROM s1b9p_survey_question_answer as qa LEFT JOIN  s1b9p_expert as e ON e.id = qa.expert_id LEFT JOIN  s1b9p_question as q ON q.id = qa.ques_id LEFT JOIN  s1b9p_survey as s ON s.id = q.survey_id WHERE qa.showed = 0 AND q.survey_id = '".$surveyID."' GROUP BY qa.target , e.name ORDER BY e.name ASC";
		$db->setQuery($sql);
		return $db->loadObjectList();
	}
    function getInProcessClaim($surveyID){
		$db = JFactory::getDBO();
		$sql = "SELECT count(*) as inProcess FROM `#__survey_question_answer` as qa LEFT JOIN #__question as q ON q.id = qa.ques_id LEFT JOIN #__survey as s ON s.id = q.survey_id WHERE qa.showed=1 AND s.id = '".$surveyID."' GROUP BY qa.target";
		$db->setQuery($sql);
		return $db->loadObject();
	}
    function getClaimsSendToExpertFailed($claimID){
		/*Email Or Notification Send to An Expert*/
		$db = JFactory::getDBO();
		$sql = "SELECT count(*) as emailSend FROM #__expert WHERE id IN(SELECT es.expert_id FROM `#__email_send` as es LEFT JOIN #__survey as s ON s.id = es.survey_id WHERE s.id = '".$claimID."' AND es.status = 1 GROUP BY es.expert_id ,es.survey_id)";		
		$db->setQuery($sql);
		return $db->loadObject();
	}
	
    function getClaimsSendToExpertSuccess($claimID){
		/*Email Or Notification Send to An Expert*/
		$db = JFactory::getDBO();
		$sql = "SELECT count(*) as emailSend FROM #__expert WHERE user_id IN(SELECT es.expert_id FROM `#__email_send` as es LEFT JOIN #__survey as s ON s.id = es.survey_id WHERE s.id = '".$claimID."' AND es.status = 0 GROUP BY es.expert_id ,es.survey_id)";		
		$db->setQuery($sql);
		return $db->loadObject();
	}
    function getLastQuestionClaim($surveyID){
		$db = JFactory::getDBO();
		$sql = "SELECT * FROM #__question WHERE survey_id = '".$surveyID."' ORDER BY id DESC";		
		$db->setQuery($sql);
		return $db->loadObject();
	}
    function getSurveyOrderedDate($surveyID){
		$db = JFactory::getDBO();
		$sql = "SELECT t.* FROM #__projects as p  LEFT JOIN #__survey as s ON s.project_id = p.id LEFT JOIN #__transactions as t ON t.survey_id = p.id WHERE s.id = '".$surveyID."' AND t.type= 1 AND t.success='Paid'";		
		$db->setQuery($sql);
		return $db->loadAssoc();
	}
    function getApplyQus(){
        $db = & JFactory::getDBO();
        $data = JRequest::get('post');
        $data["description"] = JRequest::getVar("description", "", "post", "string", JREQUEST_ALLOWRAW);
        $result = SurveyModelApi::getSaveQus($data);
        if (isset($result) && $result != false) {
            $msg = JText::_('QUESTION_DETAILS_SAVED');
           // $this->setRedirect('index.php?option=com_survey&task=question.edit&id=' . $result . '&hidemainmenu=1', $msg);
        } else {
            $author_type = JRequest::getVar("author_type", "0");
        //    $this->setRedirect("index.php?option=com_survey&task=question.new", JText::_('QUESTION_DETAILS_SAVED_ERROR'));
        }
    }
	function getPatentList($projectID){
		$db =& JFactory::getDBO();
		$sql = "SELECT * FROM #__survey WHERE project_id='".$projectID."' ORDER BY name ASC";
		$db->setQuery($sql);
		return count($db->loadObjectList());
		
	}  

	function getDiscountList(){
		$db = JFactory::getDBO();
		$query = "SELECT * FROM #__discount ORDER BY `id` DESC ";
		$db->setQuery($query);
		return $db->loadObjectList();
	}
	
	function getBackyardCredential(){
		$config = JFactory::getConfig();
		$option = array();
	    $option['driver']   = $config->getValue( 'backyarddriver' );
	    $option['host']     = $config->getValue( 'backyardhost' );
	    $option['user']     = $config->getValue( 'backyarduser' );
	    $option['password'] = $config->getValue( 'backyardpassword' );
	    $option['database'] = $config->getValue( 'backyarddatabase' );
	    $option['prefix']   = $config->getValue( '' );
		return $option;
	}
	
	function getLeadData($leadID){
		$option = $this->getBackyardCredential();
		$db = JDatabase::getInstance( $option );
		$query = "SELECT id, lead_name FROM litigations WHERE id=".$leadID;
		$db->setQuery($query);
		return $db->loadObject();
	}
	
	function getOrderList(){
        	$db =& JFactory::getDBO();
            $sql = "SELECT t.* , p.name as projectName,p.description , p.id as projectID,p.code as code,p.lead_id as leadID,p.type as projectType,p.synpat_price , s.id as surveyID , s.name as surveyName , s.combine_name as combineName , s.deadline, s.specific_expert  FROM #__transactions as t LEFT JOIN #__projects as p ON p.id = t.survey_id  LEFT JOIN #__survey as s ON s.project_id = p.id WHERE t.type=1  AND p.id NOT IN (17,30,31,16,36) GROUP BY projectID ORDER BY id DESC ";
            $data = $db->setQuery($sql);
            $data = $db->loadAssocList();
            if(count($data)>0){
				for($i=0;$i<count($data);$i++) {
					$row = $data[$i];  
					$getLeadData = array();						
					if($row['leadID']>0){
						$getLeadData = $this->getLeadData($row['leadID']);
					} 
					$data[$i]['lead_data'] = $getLeadData;
					$getQuestionaresPrepared = SurveyModelApi::getQuestionaresPreparedCount($row['projectID']);			
					 if($getQuestionaresPrepared>0)
					 {
						$data[$i]['Questionares_prepared'] = $getQuestionaresPrepared; 
					 } else {
						 $data[$i]['Questionares_prepared'] = 0; 
					 }
					$getReportsData = SurveyModelApi::getReportsCreatedByExpert($row['projectID']);
					
					$data[$i]['cc_submitted'] = count($getReportsData);
					$data[$i]['claim_order'] = $this->getPatentList($row['projectID']);
					$getCCInProcess = SurveyModelApi::getCCInProcess($row['projectID']);
					
					if(count($getCCInProcess)>0){
						if($getCCInProcess->inProcess>0){
							$data[$i]['cc_in_process'] = $getCCInProcess->inProcess;
					
						} else {
							$data[$i]['cc_in_process'] =  0;
						}
					}
					else
					{
						$data[$i]['cc_in_process'] =  0;
					}
					$getEmailSendData = SurveyModelApi::getClaimsSendToExpert($row['projectID']);
					$data[$i]['Questionares_sent'] =   (count($getEmailSendData)>0)?$getEmailSendData->emailSend:'';
				}                
            }
            return $data;
     }
     
     function getProjectList(){
        	$db =& JFactory::getDBO();
            $sql = "SELECT * FROM #__projects ORDER BY `name` ASC";
            $db->setQuery($sql);
            return $db->loadObjectList();
     }
     
     function getExpertList(){
        	$db =& JFactory::getDBO();
            $sql = "SELECT e.*, u.registerDate, u.can_see, u.nda FROM #__expert as e JOIN #__users as u ON u.id = e.user_id ORDER BY e.`name` ASC";
            $db->setQuery($sql);
            $data = $db->loadObjectList();
            
            if(count($data) > 0)
            {
                for($k=0;$k<count($data);$k++)
                {
                    $row = $data[$k];
                    $calcRating = 0;
					$overAllRating = 0; 
					$totalProject = 0;
					$rating = SurveyModelApi::expertRatingData($row->id);
					if(count($rating)>0)
                    {
						for($i=0;$i<count($rating);$i++){
							$overAllRating = $overAllRating+$rating[$i]->rating;
							$totalProject = $totalProject + $rating[$i]->countSurvey;
						}
						$calcRating = round($overAllRating/$totalProject,1);
                       
                        $data[$k]->rate=$calcRating .' out of 5 stars';
					}
                    else
                    {
                        $data[$k]->rate = '0 out of 5 stars';
                    }
                    
                    $noOfSurvey = $this->getExpertSurveySent($row->user_id);
					if(count($noOfSurvey)>0){
						$data[$k]->Questionare_Sent = $noOfSurvey->noOfSurveySend;
					} else {
						$data[$k]->Questionare_Sent = "0";
					}
                    
                    $noOfExpertArea = SurveyModelApi::getExpertAreaExpertise($row->id);
					$data[$k]->Area_Of_Expertise = count($noOfExpertArea);
                    
                    $reportSubmit = SurveyModelApi::getNoOfReportSubmit($row->id);
					if(count($reportSubmit))
                    {
					   $data[$k]->Reports_Submitted =  $reportSubmit->surveyCount;
					} 
                    else 
                    {
						$data[$k]-> Reports_Submitted =  "0";
					}
                    $reportSold = SurveyModelApi::getNoOfReportSold($row->id);
					if(count($reportSold)){
						$data[$k]->Of_Reports_Sold =   $reportSold->reportSold;
					} else {
						$data[$k]->Of_Reports_Sold =   "0";
					}
                    $revenueGenerate = SurveyModelApi::getRevenueGenerate($row->id);
					if(count($revenueGenerate)){							
						$data[$k]->Revenue_Generated =  ($revenueGenerate->revenueGenerate!="")?'$'.$revenueGenerate->revenueGenerate:'$0';
					} 
                }
                
            }
            return $data;
     }
     
     function getRevenueGenerate($expertID){
		$db = JFactory::getDBO();
		$sql = "SELECT sum(`amount`) as revenueGenerate FROM `#__transactions` WHERE expert_id = '".$expertID."' AND type=0 AND success='Paid' ";
		$db->setQuery($sql);
		return $db->loadObject();
	}
     function getNoOfReportSold($expertID){
		$db = JFactory::getDBO();
		$sql = "SELECT count(*) as reportSold FROM `#__transactions` WHERE expert_id = '".$expertID."' AND type=0 AND success='Paid' GROUP BY survey_id";
		$db->setQuery($sql);
		return $db->loadObject();
	}
     function getNoOfReportSubmit($expertID){
		$db = JFactory::getDBO();
		$sql = "SELECT COUNT(*) as surveyCount FROM #__survey as s WHERE id IN (SELECT q.survey_id FROM #__survey_question_answer as qa LEFT JOIN #__question as q ON q.id = qa.ques_id WHERE qa.expert_id ='".$expertID."' Group by q.survey_id)";
		$db->setQuery($sql);
		return $db->loadObject();
	}
	
     function getExpertAreaExpertise($expertID){
		$db = Jfactory::getDBO();
		$sql = "SELECT ma.* , ea.name FROM #__map_area_expertise as ma LEFT JOIN #__expertisearea as ea ON ea.id = ma.area_id WHERE ma.expert_id = '".$expertID."'";
		$db->setQuery($sql);
		return $db->loadObjectList();
	}
	
     function getExpertSurveySent($expertID){
		$db = JFactory::getDBO();
		$sql = "SELECT count(*) as noOfSurveySend FROM #__email_send as es WHERE es.expert_id ='".$expertID."' Group by survey_id";
		$db->setQuery($sql);
		return $db->loadObject();
	}
	
	
     function getReportList(){
        	$db =& JFactory::getDBO();
            $sql = "SELECT p.name as ProjectName , p.id as projectID , s.id as surveyID,s.report_type as report_type, s.combine_name as combineName ,qa.target as target,qa.target_product as target_product, qa.expert_id as expertID,qa.show,qa.notify,qa.created_date as create_date, e.name as expertName,s.payment_type FROM `#__survey_question_answer` as qa LEFT JOIN #__question as q ON q.id = qa.ques_id LEFT JOIN #__survey as s ON s.id = q.survey_id LEFT JOIN #__projects as p ON p.id = s.project_id LEFT JOIN #__expert as e ON e.id = qa.expert_id WHERE qa.showed=0 AND s.report_type=2 GROUP BY qa.target,qa.target_product";
            $db->setQuery($sql);
            $data = $db->loadAssocList();
    		if(count($data)>0)
            {
					 $sql = "SELECT p.name as ProjectName , p.id as projectID , s.id as surveyID,s.report_type as report_type, s.combine_name as combineName ,qa.target as target,qa.target_product as target_product, qa.expert_id as expertID,qa.show,qa.notify,qa.created_date as create_date, e.name as expertName,s.payment_type FROM `#__survey_question_answer` as qa LEFT JOIN #__question as q ON q.id = qa.ques_id LEFT JOIN #__survey as s ON s.id = q.survey_id LEFT JOIN #__projects as p ON p.id = s.project_id LEFT JOIN #__expert as e ON e.id = qa.expert_id WHERE qa.showed=0 AND s.report_type=1 GROUP BY projectID,surveyID,expertID";
					$db->setQuery($sql);
					$priordata = $db->loadAssocList();
					if(count($priordata)>0){
						/*foreach($priordata as $p){
							array_push($data,$p);
						}*/
						$data = array_merge($data,$priordata);
					}					
                    for($i=0;$i<count($data);$i++) 
                    {
                        $row = $data[$i];
                        /*$getData = SurveyModelApi::getClaimOrderDate($row['projectID']);
                        if(count($getData)>0)
                        {
                        	$data[$i]['create_date'] = date('M d, Y',strtotime($getData->create_date));
                        } 
                        else 
                        {
                            $data[$i]['create_date'] ="";
                        }*/
          
                        $getData = SurveyModelApi::getClaimDateToExpert($row['surveyID']);
												if(count($getData)>0){
													$data[$i]['Ordered'] = date('M d, Y',strtotime($getData->send_date));
												}  else  {
                            $data[$i]['Ordered'] = '';
                        }
                        $getAnswerList = SurveyModelApi::getQuestionAnswerList($row['surveyID'],$row['expertID'], $row['target'], $row['target_product'], $row['report_type']);
                        //echo count($getAnswerList);
                       
                        if(count($getAnswerList)==0){
        									$data[$i]['count_answer'] = "0/0";
                          $data[$i]['created'] = "";
        								} else {
               	            $data[$i]['created'] = date('M d, Y', strtotime($getAnswerList[0]->created_date));
        										$answerCount = 0;
														for($qa=0;$qa<count($getAnswerList);$qa++){
															// echo $getAnswerList[$qa]->qaID;
															if(!empty($getAnswerList[$qa]->qaID)){
															 // echo 'testt';
																$answerCount = $answerCount + 1;                                    
															}
														}
        										$data[$i]['count_answer'] =  $answerCount."/".count($getAnswerList);
        								}
                      //  echo $data[$i]['count_answer'];
                       // die;
                        $getData = SurveyModelApi::getPriceSetByExpertForSurvey($row['expertID'],$row['surveyID'], $row['target'],$row['target_product'],$row['report_type']);
        				if(count($getData)>0 && isset($getData->amount)){
        					$data[$i]['price'] = $getData->amount;
        					$data[$i]['report_option_type'] = $getData->report_option_type;
        					$data[$i]['specific_amount'] = $getData->specific_amount;
        					$data[$i]['specific_amount_id'] = $getData->id;
									$data[$i]['paid'] = $getData->paid;
        				} else {
                   $data[$i]['price']='';
                   $data[$i]['specific_amount']='';
				   $data[$i]['report_option_type'] = 1;
									 $data[$i]['specific_amount_id'] = 0;
									 $data[$i]['paid'] = 0;
                }
                $getData = SurveyModelApi::getSurveyPurchaseTransaction($row['surveyID']);
        				$data[$i]['sold'] = count($getData);
								$activityTime="";
								if((int)$data[$i]['payment_type']==1 && (int)$data[$i]['specific_amount_id']>0){
									$activityTime = $this->expertCombineActivityReportData($row['expertID'],$row['surveyID'], $row['target'],$row['target_product'],$row['report_type']);
								}
								$data[$i]['acitivity_time'] = $activityTime;
            		}                               
                return $data;
            }
     }
	
	public function getUnpaidExpertReportList(){
	$db = JFactory::getDBO();
	$sql = "SELECT p.name as ProjectName, p.id as projectID , s.id as surveyID,s.report_type as report_type, s.combine_name as combineName, e.name as expertName,s.payment_type, sae.expert_id as expertID,sae.amount as expertSetAmount,sae.survey_id,sae.target,sae.target_product,sae.id as specific_amount_id FROM #__survey_amount_expert as sae LEFT JOIN #__survey as s ON s.id = sae.survey_id LEFT JOIN #__projects as p ON p.id = s.project_id LEFT JOIN #__expert as e ON e.id = sae.expert_id WHERE sae.paid=0 AND sae.amount>0 AND sae.survey_id>0 AND s.payment_type=1  ORDER BY sae.id DESC" ;
	$db->setQuery($sql);
	$reportList = $db->loadObjectList();
	$reportDataList = array();
	if(count($reportList)>0){
		foreach($reportList as $report){
			$query = "";
			if($report->report_type==1){
				$query = "SELECT qa.showed,q.survey_id as surveyID,qa.expert_id as expertID,qa.target,qa.target_product FROM `#__survey_question_answer` as qa LEFT JOIN #__question as q ON q.id = qa.ques_id LEFT JOIN #__expert as e ON e.id = qa.expert_id WHERE q.survey_id=".$report->surveyID." AND expert_id=".$report->expertID." GROUP BY surveyID,expertID ORDER BY qa.showed DESC LIMIT 0,1 ";
			} else if($report->report_type==2){
				$query = "SELECT qa.showed,q.survey_id as surveyID,qa.expert_id as expertID, qa.target,qa.target_product  FROM `#__survey_question_answer` as qa LEFT JOIN #__question as q ON q.id = qa.ques_id LEFT JOIN #__expert as e ON e.id = qa.expert_id WHERE q.survey_id=".$report->surveyID." AND expert_id=".$report->expertID." AND qa.target ='".$report->target."' AND qa.target_product ='".$report->target_product."' GROUP BY qa.target,qa.target_product  ORDER BY qa.showed DESC LIMIT 0,1 ";
			}
			if($query!=""){
				$db->setQuery($query);
				$submitReport = $db->loadObject();
				if(count($submitReport)>0){
					if($submitReport->showed=='0'){
						/*Get Expert PaypalID*/
						$expertBusinessIDQuery = "SELECT paypal_id FROM #__expert_payment WHERE expert_id='" .$report->expertID . "'";
						$db->setQuery($expertBusinessIDQuery);
        		$getBusinessDetails =  $db->loadObject();
						if(count($getBusinessDetails )>0){
							$report->business_id = $getBusinessDetails->paypal_id;
						} else {
							$report->business_id = '';
						}
						$getData = SurveyModelApi::getClaimOrderDate($report->projectID);
						if(count($getData)>0){
							$report->create_date = date('M d, Y',strtotime($getData->create_date));
						} else {
							$report->create_date ="";
						}			  
						$getData = SurveyModelApi::getClaimDateToExpert($report->surveyID);
						if(count($getData)>0){
							$report->Ordered = date('M d, Y',strtotime($getData->send_date));
						}  else  {
							$report->Ordered = '';
						}
						$getAnswerList = SurveyModelApi::getQuestionAnswerList($report->surveyID,$report->expertID, $report->target, $report->target_product, $report->report_type);
						if(count($getAnswerList)==0){
							$report->count_answer = "0/0";
							$report->created = "";
						} else {
							$report->created = date('M d, Y', strtotime($getAnswerList[0]->created_date));
							$answerCount = 0;
							for($qa=0;$qa<count($getAnswerList);$qa++){
								// echo $getAnswerList[$qa]->qaID;
								if(!empty($getAnswerList[$qa]->qaID)){
								 // echo 'testt';
									$answerCount = $answerCount + 1;                                    
								}
							}
							$report->count_answer =  $answerCount."/".count($getAnswerList);
						}
						$reportDataList[] = $report;
					}
				}
			}			
		}
	}
	return $reportDataList;
}
	 
	 function expertCombineActivityReportData($expertID,$surveyID,$target,$targetProduct,$reportType){
		$db = JFactory::getDBO();
		if((int)$reportType==2){
			$query = "SELECT SEC_TO_TIME( SUM( TIME_TO_SEC(timediff(a.end_time, a.start_time)))) as total_time_spend FROM `#__activity` as a INNER JOIN  `#__survey_question_answer` as qa ON qa.ques_id = a.ques_id LEFT JOIN #__question as q ON q.id = qa.ques_id LEFT JOIN #__survey as s ON s.id = q.survey_id LEFT JOIN #__projects as p ON p.id = s.project_id LEFT JOIN #__expert as e ON e.id = qa.expert_id WHERE  qa.showed=0 AND s.report_type=2 AND a.expert_id=".(int)$expertID." AND a.survey_id=".(int)$surveyID." AND qa.target='".(string)$target."' AND qa.target_product='".(string)$targetProduct."'  AND a.target='".(string)$target."' AND a.target_product='".(string)$targetProduct."' GROUP BY a.target,a.target_product,qa.target,qa.target_product";
		}else{
			$query = "SELECT SEC_TO_TIME( SUM( TIME_TO_SEC(timediff(a.end_time, a.start_time)))) as total_time_spend FROM `#__activity` as a INNER JOIN  `#__survey_question_answer` as qa ON qa.ques_id = a.ques_id LEFT JOIN #__question as q ON q.id = qa.ques_id LEFT JOIN #__survey as s ON s.id = q.survey_id LEFT JOIN #__projects as p ON p.id = s.project_id LEFT JOIN #__expert as e ON e.id = qa.expert_id WHERE qa.showed=0 AND s.report_type=1 AND a.expert_id=".(int)$expertID." AND a.survey_id=".(int)$surveyID." GROUP BY p.id,a.survey_id,a.expert_id";
		}
		$db->setQuery($query);
		$getActivityData = $db->loadObject();
		if(count($getActivityData)>0){
			return $getActivityData->total_time_spend;
		} else {
			return '00:00:00';
		}
	}
	
	function expertCombineActivityReportListData($expertID,$surveyID,$target,$targetProduct,$reportType){
		$db = JFactory::getDBO();
		if((int)$reportType==2){
			$query = "SELECT q.description,e.name, a.start_time,a.end_time, SEC_TO_TIME( SUM( TIME_TO_SEC(timediff(a.end_time, a.start_time)))) as  duration FROM `#__activity` as a INNER JOIN  `#__survey_question_answer` as qa ON qa.ques_id = a.ques_id LEFT JOIN #__question as q ON q.id = qa.ques_id LEFT JOIN #__survey as s ON s.id = q.survey_id LEFT JOIN #__projects as p ON p.id = s.project_id LEFT JOIN #__expert as e ON e.id = qa.expert_id WHERE  qa.showed=0 AND s.report_type=2 AND a.expert_id=".(int)$expertID." AND a.survey_id=".(int)$surveyID." AND qa.target='".(string)$target."' AND qa.target_product='".(string)$targetProduct."'  AND a.target='".(string)$target."' AND a.target_product='".(string)$targetProduct."' ";
		}else{
			$query = "SELECT qa.*, a.start_time,a.end_time, SEC_TO_TIME( SUM( TIME_TO_SEC(timediff(a.end_time, a.start_time))))  as duration FROM `#__activity` as a INNER JOIN  `#__survey_question_answer` as qa ON qa.ques_id = a.ques_id LEFT JOIN #__question as q ON q.id = qa.ques_id LEFT JOIN #__survey as s ON s.id = q.survey_id LEFT JOIN #__projects as p ON p.id = s.project_id LEFT JOIN #__expert as e ON e.id = qa.expert_id WHERE qa.showed=0 AND s.report_type=1 AND a.expert_id=".(int)$expertID." AND a.survey_id=".(int)$surveyID;
		}
		$db->setQuery($query);
		$getActivityData = $db->loadObjectList();
		return $getActivityData;
	}
     
     function getViewReport($expert_id=null,$surveyID=null){
        $db = JFactory::getDBO();
        $getExpertID = JRequest::getVar('expertID',$expertID);
        $getSurveyID = JRequest::getVar('surveyID',$surveyID);
		$sql = "SELECT qa.* , q.id as quesID , q.description as description FROM #__question as q LEFT JOIN #__survey_question_answer as qa ON qa.ques_id = q.id WHERE q.survey_id = '".$getSurveyID."' AND qa.expert_id = '".$getExpertID."'";
        $db->setQuery($sql);
		$data = $db->loadAssocList();	
        return $data;
     }
     function getEmail($surveyID = null){
        $db = JFactory::getDBO();
        $getProjectID = JRequest::getVar('surveyID',$surveyID);
		$sql = "SELECT * FROM #__survey WHERE id = '".$getProjectID."'";
        //echo $sql;
		$db->setQuery($sql);
		$data = $db->loadAssocList();
        if(count($data) > 0)
        {
            for($i=0;$i<count($data);$i++)
            {
                $row = $data[$i];
                $data[$i]['findExpert'] = SurveyModelApi::findExpertFromUserName($row->specific_expert);
            }   
        }
        return $data;
      //  echo '<pre>';
      //  print_r($data);
       // die;
     }
     function getSingleExpert($id){
		$db = JFactory::getDBO();
		$sql = "SELECT * FROM #__users WHERE id IN (SELECT user_id FROM #__expert WHERE id = $id)";
		$db->setQuery($sql);
		return $db->loadObject();
	}
	
	function addDiscount(){
		$data = JRequest::get('post');
		$getCodeExist = $this->findDiscountCouponCode($data['coupon_code']);
		if($getCodeExist->countDiscount==0){
			unset($data['option']);
			unset($data['task']);
			$id = $this->saveDiscount($data);
			return $id;
		} else {
			return -1;
		}
	}
	
	function saveDiscount($data){
		$db =& JFactory::getDBO();
		$item =& $this->getTable('Discount');		
		if (!$item->bind($data)){
			echo $item->getError().' - 1';
			return false;
		}
		if (!$item->check()) {
			echo $item->getError().' - 2';
			return false;
		}			
		if (!$item->store()) {
			echo $item->getError().' - 3';
			return false;
		}
		return $item->id;
	}
	
	function findDiscountCouponCode($couponCode){
		$db = JFactory::getDBO();
		$sql = "SELECT count(*) as countDiscount FROM #__discount WHERE coupon_code='".$couponCode."'";
		$db->setQuery($sql);
		return $db->loadObject();		
	}
	
    function getProjectSurveyData($surveyID){
		$db =& JFactory::getDBO();
		$sql = "SELECT p.*, s.name as claimName FROM #__survey as s LEFT JOIN #__projects as p ON p.id = s.project_id WHERE s.id='".$surveyID."'";
		$db->setQuery($sql);
		return $db->loadObject();
	}
	
	function addTemplate(){
		$msg = "";
		$te = JRequest::getVar('te', '', 'post','',JREQUEST_ALLOWHTML);
        $s = JRequest::getVar('s', '', 'post','',JREQUEST_ALLOWHTML);
		$db =& JFactory::getDBO();
		$sql = "INSERT INTO #__template (`subject`,`templates`) VALUES ('".$s."','".$te."') ";				
		$db->setQuery($sql);
		$db->query();
		return SurveyModelApi::getAllTemplates();
	}
	
	function getAllTemplates(){
		$db = JFactory::getDBO();
		$sql = "SELECT * FROM #__template ";
		$db->setQuery($sql);
		return $db->loadObjectList();
	}
    function emailSend($post= null) {
        $msg = "";
        $post = JRequest::get('post');
        $msg = "";
        $type = "";
		try {
			$getAllExpert = array();
            $post['selected_expert']  = explode(',',$post['selected_expert']);
			if(isset($post['selected_expert']) && count($post['selected_expert'])>0){				
                foreach ($post['selected_expert'] as $id => $value) {
                    $expert = SurveyModelApi::getSingleExpert($value);
                    array_push($getAllExpert, $expert);
                }
			} else {
				$getAllExpert = SurveyModelApi::findExpertWithCode($post['expertise_code'],2);
			}

            if (count($getAllExpert) > 0) {
                for ($i = 0; $i < count($getAllExpert); $i++) {
						if(!empty($getAllExpert[$i]->id)){
                        $getProjectSurveyData = SurveyModelApi::getProjectSurveyData($post['survey_id']);
						jimport( 'joomla.utilities.utility' );
                        $mailer = & JFactory::getMailer();
                        $config = & JFactory::getConfig();
						$mailer->SMTPDebug = true;
                        $sender = array(
						$config->getValue('config.mailfrom'),
						$config->getValue('config.fromname'));
                        $mailer->setSender($sender);
                        $encodeData = base64_encode($getProjectSurveyData->name . "@" . $getProjectSurveyData->id . "@" . $getAllExpert[$i]->id);
                        $mailer->addRecipient($getAllExpert[$i]->email);
						$body = "<table><tr><td><h1 style='text-align: left; color: #cd2122;'>ClaimCharts.info</h1></td></tr><tr><td>";
                        $body .= "Hi " . $getAllExpert[$i]->name . ",<br/><p>" . $post['email_message'] . "</p><p><a href='" . JUri::root() . "index.php?option=com_survey&task=survey.surveylist&ps=" . $encodeData . "'>" . JUri::root() . "index.php?option=com_survey&task=survey.surveylist&ps=" . $encodeData . "</a></p>";
                        $body .="</td></tr><tr><td>Vivek Kapoor</td></tr><tr><td>Account Manager</td></tr><tr><td>ClaimCharts.info</td></tr><tr><td>One Market - Spear Tower, 36 Floor</td></tr><tr><td>San Francisco, CA 94105</td></tr><tr><td style='height:20px;'></td></tr><tr><td>T +1-415-935-5272</td></tr><tr><td><a href='mailto:vivek@claimcharts.info'>vivek@claimcharts.info</a></td></tr><tr><td><a href='http://www.claimcharts.info' target='_blank'>www.ClaimCharts.info</a></td></tr><tr><td style='height:20px;'></td></tr><tr><td><p>This message is intended only for the individual or entity to which it is addressed. It may contain information that is confidential or privileged. If the reader of this message is not the intended recipient, you are hereby notified that any dissemination, sharing or copying of this e-mail is strictly prohibited. If you receive this e-mail in error, please notify Syndicated Patent Acquisitions Corp. immediately by telephone or email, and delete the material from any computer. Thank you.</p></td></tr></table>";
						$mailer->setSubject('New survey is waiting');
                        $mailer->setBody($body);
                        $mailer->isHTML(true);
                        $mailer->Encoding = 'base64';
                        if ($mailer->Send()) {							
                            SurveyModelApi::insertEmailSend($post['survey_id'], $getAllExpert[$i]->id, 0);
                        } else {
                            SurveyModelApi::insertEmailSend($post['survey_id'], $getAllExpert[$i]->id, 1);
                        }
                        /* Insert Notification */
                        SurveyModelApi::insertNotification($post['survey_id'], $getAllExpert[$i]->id);
                        /* End Notification */
						}
                    }
                    SurveyModelApi::insertMessageSend($post['survey_id']);
                } else {
                    $msg = "No expert found!";
                    $type = "Notice";
                }
                //}
//            } else {
//                $msg = "Please select expertise area.";
//                $type = "Error";
//            }

        } catch (Exception $e) {
            $msg = 'Caught exception: ' + $e->getMessage() + "\n";
            $type = "Error";
        }
        
        /*$link = "index.php?option=com_survey&task=question.list&survey_id=" . $post['survey_id'];*/
      //  $link = site_url().'api/order_list';
       // $this->setRedirect($link, $msg, $type);
        $data = array('msg'=>$msg,'type'=>$type);
        return $data;
    }
	
	
	function emailMSend($post= null) {
        $msg = "";
        $post = JRequest::get('post');
        $msg = "";
        $type = "";
		try {
			$getAllExpert = array();
            $post['selected_expert']  = explode(',',$post['selected_expert']);
			if(isset($post['selected_expert']) && count($post['selected_expert'])>0){				
                foreach ($post['selected_expert'] as $id => $value) {
                    $expert = SurveyModelApi::getSingleExpert($value);
                    array_push($getAllExpert, $expert);
                }
			} else {
				$getAllExpert = SurveyModelApi::findExpertWithCode($post['expertise_code'],2);
			}

            if (count($getAllExpert) > 0) {
                for ($i = 0; $i < count($getAllExpert); $i++) {
						if(!empty($getAllExpert[$i]->id)){
                       
						jimport( 'joomla.utilities.utility' );
                        $mailer = & JFactory::getMailer();
                        $config = & JFactory::getConfig();
						$mailer->SMTPDebug = true;
                        $sender = array(
						$config->getValue('config.mailfrom'),
						$config->getValue('config.fromname'));
                        $mailer->setSender($sender);
                        
                        $mailer->addRecipient($getAllExpert[$i]->email);
						$email = JRequest::getVar('email_message', '', 'post','',JREQUEST_ALLOWHTML);
						$email = str_replace("#NAME#",$getAllExpert[$i]->name,$email);
						$getProjectSurveyData = array();
						if(isset($post['survey_id'])){
							$getProjectSurveyData = SurveyModelApi::getProjectSurveyData($post['survey_id']);
							$encodeData = base64_encode($getProjectSurveyData->name . "@" . $getProjectSurveyData->id . "@" . $getAllExpert[$i]->id);
							$claimElementName = $getProjectSurveyData->claimName;
							$email = str_replace("#LINK#","<p><a href='" . JUri::root() . "index.php?option=com_survey&task=survey.surveylist&ps=" . $encodeData . "'>" . $claimElementName . "</a></p>",$email);
						}
						
						
						$body = "<table><tr><td><h1 style='text-align: left; color: #cd2122;'>ClaimCharts.info</h1></td></tr><tr><td>";
                        $body .= $email;
                        $body .="</td></tr><tr><td>Vivek Kapoor</td></tr><tr><td>Account Manager</td></tr><tr><td>ClaimCharts.info</td></tr><tr><td>One Market - Spear Tower, 36 Floor</td></tr><tr><td>San Francisco, CA 94105</td></tr><tr><td style='height:20px;'></td></tr><tr><td>T +1-415-935-5272</td></tr><tr><td><a href='mailto:vivek@claimcharts.info'>vivek@claimcharts.info</a></td></tr><tr><td><a href='http://www.claimcharts.info' target='_blank'>www.ClaimCharts.info</a></td></tr><tr><td style='height:20px;'></td></tr><tr><td><p>This message is intended only for the individual or entity to which it is addressed. It may contain information that is confidential or privileged. If the reader of this message is not the intended recipient, you are hereby notified that any dissemination, sharing or copying of this e-mail is strictly prohibited. If you receive this e-mail in error, please notify Syndicated Patent Acquisitions Corp. immediately by telephone or email, and delete the material from any computer. Thank you.</p></td></tr></table>";
						$subject = $post['subject'];
						if(count($getProjectSurveyData)>0){
							$subject = str_replace("#LINK#",$getProjectSurveyData->claimName,$subject);
						}						
						$mailer->setSubject($post['subject']);
                        $mailer->setBody($body);
                        $mailer->isHTML(true);
                        $mailer->Encoding = 'base64';
                        if ($mailer->Send()) {	
							$msg = "Email send Successfully";
							$type = "Success";
							if(isset($post['survey_id'])){
								SurveyModelApi::insertEmailSend($post['survey_id'], $getAllExpert[$i]->id, 0);
							}
                        } else {
							if(isset($post['survey_id'])){
								SurveyModelApi::insertEmailSend($post['survey_id'], $getAllExpert[$i]->id, 1);
							}
                        }
                        /* Insert Notification */
						if(isset($post['survey_id'])){
							SurveyModelApi::insertNotification($post['survey_id'], $getAllExpert[$i]->id);
						}
                        /* End Notification */
						}
                    }
					if(isset($post['survey_id'])){
						SurveyModelApi::insertMessageSend($post['survey_id']);
					}
                } else {
                    $msg = "No expert found!";
                    $type = "Notice";
                }
                //}
//            } else {
//                $msg = "Please select expertise area.";
//                $type = "Error";
//            }

        } catch (Exception $e) {
            $msg = 'Caught exception: ' . $e->getMessage() . "\n";
            $type = "Error";
        }
        
        /*$link = "index.php?option=com_survey&task=question.list&survey_id=" . $post['survey_id'];*/
      //  $link = site_url().'api/order_list';
       // $this->setRedirect($link, $msg, $type);
        $data = array('msg'=>$msg,'type'=>$type);
        return $data;
    }
	
	
    function getSaveQus() {
        $app = JFactory::getApplication('administrator');
        $postData = JRequest::get('post');
		$data = (array) json_decode($postData['postData']);
		$flag = 0;
		$getSurveyData = array();
		$reportType = 2;	
		$oldSurveyData = $this->getSurveyData($data['survey_id']);
		if(count($oldSurveyData)>0){
			$reportType = $oldSurveyData->report_type;
			if($reportType==1){
				$reportType = 2;
			} else if($reportType==2){
				$reportType = 1;
			}
			$projectQuery = "SELECT name FROM #__projects WHERE id=".$oldSurveyData->project_id;
			$db =& JFactory::getDBO();
			$db->setQuery($projectQuery);
			$getProjectData = $db->loadObject();
			if(count($getProjectData)>0){
				$getSurveyData = $this->getSurveyDataByNameAndReport($oldSurveyData->name,$getProjectData->name,$reportType);
			}			
		}
        if ((int) $data['oldQuestion'] > 0) {
            $allQuestionIDs = explode(',', $data['oldQuestionID']);
            if (count($allQuestionIDs) > 0 && $allQuestionIDs[0] != ""){
                for ($i = 0; $i < count($allQuestionIDs); $i++) {
                    if ($data['question_' . $allQuestionIDs[$i]] != ""){
                        $getQuestionData = $this->getQuestionData($allQuestionIDs[$i]);
   					    $oldData = array();
                        $oldData['description'] = $data['question_' . $allQuestionIDs[$i]];
                        $oldData['id'] = $allQuestionIDs[$i];
						$oldData['original_text'] = $data['original_patent_content'];
                        $oldData['survey_id'] = $getQuestionData->survey_id;
                        $oldData['created_date'] = date('Y-m-d H:i:s', strtotime('now'));
                        $oldData['question_order'] = $data['question_order_' . $allQuestionIDs[$i]];
						
						if(count($getQuestionData)>0 && count($getSurveyData)>0){
							$newQuestion = $this->getQuestionDataByDescription($getQuestionData->description,$getSurveyData->id);
							$result = SurveyModelApi::saveQuestion($oldData);
							$flag = 1;
							if(count($newQuestion)>0){
								$oldData['id'] = $newQuestion->id;
							}
							
							$oldData['survey_id'] = $getSurveyData->id;
							$result = SurveyModelApi::saveQuestion($oldData);
							$flag = 1;
						}
                    }
                }
            }
        }
        if ((int) $data['newQuestions'] > 0) {
            for ($i = 1; $i <= $data['newQuestions']; $i++) {
                if ($data['question_new_' . $i] != "") {
                    $newData = array();
                    $newData['description'] = $data['question_new_' . $i];
                    $newData['original_text'] = $data['original_patent_content'];
                    $newData['id'] = 0;
                    $newData['survey_id'] = $data['survey_id'];
                    $newData['created_date'] = date('Y-m-d H:i:s', strtotime('now'));
                    $newData['question_order'] = $data['question_new_order_' . $i];
                    $result = SurveyModelApi::saveQuestion($newData);
					if($result>0){
						$flag = 1;
					}			
					if(count($getSurveyData)>0){
						$newData['survey_id'] = $getSurveyData->id;
						$result = SurveyModelApi::saveQuestion($newData);
					}
                }
            }
        }
        if ($flag == 1) {
            return true;       
        } else {
            return false;
        }
    }	
    
    public function getTable($type = 'Question', $prefix = 'SurveyTable', $config = array()) {
		return JTable::getInstance($type, $prefix, $config);
	}
    
    function getDeleteQuestionare($surveyID=null) {
        $surveyID = JRequest::getInt('survey_id',$surveyID);
        $getAction = SurveyModelApi::getDeleteQuestionare($surveyID);
        if ($getAction == 1) {
            $app->redirect('index.php?option=com_survey&task=question.new&survey_id=' . $surveyID, 'Clear questionare', 'success');
        } else {
            $app->redirect('index.php?option=com_survey&task=question.new&survey_id=' . $surveyID, 'Unable to delete questionare', 'success');
        }
    }
    
    function start_questionare($survey_id=null){
        $survey_id = JRequest::getVar("survey_id",$survey_id);
        
        $data['surveyData'] = SurveyModelApi::getSurveyData($survey_id);
        
        $data['QuestionList'] = SurveyModelApi::getQuestionList($survey_id);
        
        $data['areaExpertiseSelect'] = SurveyModelApi::getAreaExpertiseForSurvey($survey_id);
        
        $data['checkClaimSend'] = SurveyModelApi::getClaimSendReport($survey_id);
        
        return $data;
    }
    
    function getQuestionData($id){
		$db =& JFactory::getDBO();
		$sql = "SELECT * FROM #__question WHERE id='".$id."'";
		$db->setQuery($sql);
		return $db->loadObject();
	}
	
	function getQuestionDataByDescription($description,$survey_id){
		$db =& JFactory::getDBO();
		$sql = 'SELECT * FROM #__question WHERE survey_id="'.$survey_id.'" and description="'.$description.'"';
		$db->setQuery($sql);
		return $db->loadObject();
	}
	
	function getSurveyData($ID){
		$db =& JFactory::getDBO();
		$sql = "SELECT * FROM #__survey WHERE id='".$ID."'";
		$db->setQuery($sql);
		return $db->loadObject();
	}
	
	function getSurveyDataByNameAndReport($name,$projectName,$type){
		$db =& JFactory::getDBO();
		$sql = "SELECT s.* FROM #__survey as s INNER JOIN #__projects as p ON p.id = s.project_id WHERE s.name='".$name."' AND p.name='".$projectName."' AND report_type=".$type;
		$db->setQuery($sql);
		return $db->loadObject();
	}
	
	function getPaypalData(){
		$db = JFactory::getDBO();
		$sql = "SELECT * FROM #__paypal_setting";
		$db->setQuery($sql);
		return $db->loadObject();
	}
	
	function getPaypalUpdate(){
		$post = JRequest::get('post');
		$dataPost = json_decode($post['postData']);
		if(!empty($dataPost->email_id)){
			$sql = "UPDATE #__paypal_setting SET email_id='".$dataPost->email_id."', mode='".$dataPost->mode."'";
			$db = JFactory::getDBO();
			$db->setQuery($sql);
			$db->query();
		}		
	}
    
    function getQuestionDetails(){
		$db =& JFactory::getDBO();
		$question_id = "";
		$id_val = JRequest::getVar("cid", "", "post", "array");
		if(is_array($id_val) && count($id_val) > 0 && $id_val["0"] != ""){
			$cids = JRequest::getVar("cid", "", "post", "array");
			$question_id = $cids[0];
		}
		else{
			$question_id = JRequest::getVar("id", "0", "", "int");		
		}		
		$result = new StdClass();
		if($question_id > 0){
			$sql = "SELECT q.* , s.name as survey_name , s.id as survey_id FROM #__question as q LEFT JOIN #__survey as s ON s.id = q.survey_id WHERE q.id=".$question_id;
			$db->setQuery($sql);
			$db->query();
			$result = $db->loadObject();			
			$result->id = $question_id;					
		} else{
			$get = JRequest::get();
			foreach($get as $key => $val){
				$result->$key = $val;
			}
		}
		if(!isset($result->id)){
			$result->id = 0;
		}
		if(!isset($result->survey_id)){
			$result->survey_id = "";
		}
		
		if(!isset($result->description)){
			$result->description = "";
		}					
		return $result;
	}
    
    function getAreaExpertiseForSurvey($surveyID){
		$db = JFactory::getDBO();
		$sql = "SELECT * FROM #__area_survey WHERE survey_id='".$surveyID."'";
		$db->setQuery($sql);
		return $db->loadObjectList();
	}
    
    function getClaimSendReport($surveyID){
		$db = JFactory::getDBO();
		$sql = "SELECT count(*) as count FROM #__email_send WHERE survey_id='".$surveyID."'";
		$db->setQuery($sql);
		return $db->loadObject();
	}
	    
    
    function insertMessageSend($surveyID){
		$db = JFactory::getDBO();
		$sql = "SELECT * FROM #__message_send WHERE survey_id ='".$surveyID."'";
		$db->setQuery($sql);
		$getData = $db->loadObject();
		if(count($getData)==0){
		 	$sql = "INSERT INTO #__message_send(survey_id ,send_date  )VALUES('".$surveyID."','".date('Y-m-d H:i:s',strtotime('now'))."')";
			$db->setQuery($sql);
			$db->query();
		}
	}
    
    	function insertNotification($surveyID,$expertID){
		$db = JFactory::getDBO();
		$sql = "INSERT INTO #__notification (`survey_id`,`expert_id`,`created_date`) VALUES ('".$surveyID."','".$expertID."','".date('Y-m-d H:i:s',strtotime('now'))."')";
		$db->setQuery($sql);
		$db->query();
	}
    function insertEmailSend($surveyID,$expertID,$status){
		$db = JFactory::getDBO();
		$sql = "INSERT INTO #__email_send (`survey_id`,`expert_id`,`status`,`send_date`) VALUES ('".$surveyID."','".$expertID."','".$status."','".date('Y-m-d H:i:s',strtotime('now'))."') ";
		$db->setQuery($sql);
		$db->query();		
	}
	
     function findExpertWithCode($code=null,$mode=null){
		$db = JFactory::getDBO();
        $getCode = JRequest::getVar('code',$code);
        $getmode = JRequest::getVar('mode',$mode);
		$codeLength = strlen($getCode);
		if($getmode==2){			
			if($codeLength<5){
				$sql = "SELECT distinct(ma.expert_id),u.email,e.name, e.id FROM #__expertisearea as ea INNER JOIN #__map_area_expertise as ma ON ma.area_id = ea.id INNER JOIN #__expert as e ON e.id = ma.expert_id INNER JOIN #__users as u ON u.id = e.user_id  WHERE ea.name LIKE '%".$getCode."%'";
			} else {
				$sql = "SELECT distinct(ma.expert_id),u.email,e.name, e.id FROM #__expertisearea as ea INNER JOIN #__map_area_expertise as ma ON ma.area_id = ea.id INNER JOIN #__expert as e ON e.id = ma.expert_id INNER JOIN #__users as u ON u.id = e.user_id  WHERE ea.name LIKE '%".$getCode."%' OR ea.name ='".substr($getCode,0,4)."' OR ea.name ='".substr($getCode,0,3)."' OR ea.name ='".substr($getCode,0,1)."'";
			}
		
		} else {
			if($codeLength<5){
			$sql = "SELECT count(distinct(ma.expert_id)) as countData FROM #__expertisearea as ea INNER JOIN #__map_area_expertise as ma ON ma.area_id = ea.id INNER JOIN #__expert as e ON e.id = ma.expert_id INNER JOIN #__users as u ON u.id = e.user_id  WHERE ea.name LIKE '%".$getCode."%'";
			} else {
				$sql = "SELECT count(distinct(ma.expert_id)) as countData FROM #__expertisearea as ea INNER JOIN #__map_area_expertise as ma ON ma.area_id = ea.id INNER JOIN #__expert as e ON e.id = ma.expert_id INNER JOIN #__users as u ON u.id = e.user_id  WHERE ea.name LIKE '%".$getCode."%' OR ea.name ='".substr($getCode,0,4)."' OR ea.name ='".substr($getCode,0,3)."' OR ea.name ='".substr($getCode,0,1)."'";
			}
		} 
		/*echo $sql;*/
		$db->setQuery($sql);
		if($getmode==2){
		      //echo 'list ';
			$list = $db->loadObjectList();
            return $list;
           // print_r($list);	
            //die;		
		} else {
			$getData = $db->loadObject();				
			return $getData->countData;
		}
	}
     	function findExpertFromUserName($userName){
		$db = jFactory::getDBO();
		$sql = "SELECT e.* FROM #__expert as e INNER JOIN #__users as u ON u.id = e.user_id WHERE u.username='".$userName."'";
		$db->setQuery($sql);
		return $db->loadObjectList();
	}
    
     
    
     function getClaimsSendToExpert($projectID){
		/*Email Or Notification Send to An Expert*/
		$db = JFactory::getDBO();
		$sql = "SELECT count(*) as emailSend  FROM `#__email_send` as es LEFT JOIN #__survey as s ON s.id = es.survey_id WHERE s.project_id = '".$projectID."' AND es.status = 0 ";		
		$db->setQuery($sql);
		return $db->loadObject();
	}
     
     function getCCInProcess($projectID){
		$db = JFactory::getDBO();
		$sql = "SELECT q.survey_id,qa.target,qa.target_product,qa.expert_id FROM `#__survey_question_answer` as qa LEFT JOIN #__question as q ON q.id = qa.ques_id LEFT JOIN #__survey as s ON s.id = q.survey_id WHERE qa.showed=1 AND s.project_id = '".$projectID."' GROUP by  qa.target,qa.target_product,qa.expert_id, q.survey_id";
		$db->setQuery($sql);
		$getList = $db->loadObjectList();
		return (object) array('inProcess'=>count($getList));
	}
     function getReportsCreatedByExpert($projectID){
		/* Answer by Expert for each Claim under Project*/
		$db = JFactory::getDBO();
		$sql = "SELECT qa.expert_id FROM `#__survey_question_answer` as qa LEFT JOIN #__question as q ON q.id = qa.ques_id LEFT JOIN #__survey as s ON s.id = q.survey_id WHERE qa.showed=0 AND s.project_id = '".$projectID."' GROUP BY qa.target,s.project_id";
		$db->setQuery($sql);
		return $db->loadObjectList();
	}
	
	function getQuestionaresPreparedCount($projectID){
		$surveyList = $this->getSurveyListByProjectID($projectID);
		$questionCount = 0;
		if(count($surveyList)>0){
			$db = JFactory::getDBO();
			foreach($surveyList as $s){
				$sql = "SELECT count(*) as countQuestionare FROM #__question as q WHERE q.survey_id='".$s['id']."'";
				$db->setQuery($sql);
				$getData = $db->loadObject();	
				if($getData->countQuestionare>0){
					$questionCount ++;
				}
			}			
		}
		return $questionCount;
	}
	
     function getQuestionaresPrepared($projectID){
        
		$db = JFactory::getDBO();
		$sql = "SELECT count(*) as countQuestionare FROM #__question as q LEFT JOIN #__survey as s ON s.id = q.survey_id LEFT JOIN #__projects as p ON p.id = s.project_id WHERE p.id='".$projectID."' GROUP BY s.project_id";
		$db->setQuery($sql);        
		return $db->loadObject();		
	}
    function checkDigiCodeGenerate($transID)
    {
        $db = JFactory::getDBO();
        $sql = "SELECT * FROM `#__digicode` WHERE trans_id='" . $transID . "' AND status=1";
        $db->setQuery($sql);
        return $db->loadObject();
    }
	function generateDigiCode($code, $transID)
    {
        $db = JFactory::getDBO();
        $sql = "INSERT INTO #__digicode(`code_generate`,`trans_id`)VALUES('" . $code . "','" . $transID . "')";
        $db->setQuery($sql);
        $db->query();
        return $db->insertid();
    }	
	function getSurveyPurchaseTransaction($surveyID){
		$db = JFactory::getDBO();
		$sql = "SELECT * FROM #__transactions WHERE survey_id = '".$surveyID."' AND type=0 AND success='Paid'";
		$db->setQuery($sql);
		return $db->loadObjectList();	
	}
	function getReportID($surveyID,$target_product,$target,$sessionEXpertID){
		$db = JFactory::getDBO();
		$amountSurvey = "SELECT sae.id FROM #__survey_amount_expert as sae  LEFT JOIN #__survey as s ON s.id = sae.survey_id LEFT JOIN #__survey_question_answer as sqa ON sqa.target = sae.target WHERE sae.survey_id='" . $surveyID . "' AND sae.target='" . $target . "' AND sae.target_product='" . $target_product . "' AND sae.expert_id='" . $sessionEXpertID . "' ORDER BY sae.id DESC";
		$db->setQuery($amountSurvey);
		return $db->loadObject();
	}
	function getFullReport($surveyID,$target_product,$target,$sessionEXpertID){
		$db = JFactory::getDBO();
		$amountSurvey = "SELECT sae.file_name FROM #__survey_amount_expert as sae  LEFT JOIN #__survey as s ON s.id = sae.survey_id LEFT JOIN #__survey_question_answer as sqa ON sqa.target = sae.target WHERE sae.survey_id='" . $surveyID . "' AND sae.target='" . $target . "' AND sae.target_product='" . $target_product . "' AND sae.expert_id='" . $sessionEXpertID . "' ORDER BY sae.id DESC";
		$db->setQuery($amountSurvey);
		return $db->loadObject();
	}
     function getPriceSetByExpertForSurvey($expertID,$surveyID,$target,$target_product,$report_type){
		$db = JFactory::getDBO();
		if($report_type=='1'){
			/*$sql = "SELECT *  FROM #__survey_amount_expert WHERE survey_id='".$surveyID."' AND expert_id='".$expertID."' AND target ='".$target."'";*/
			$sql = "SELECT *  FROM #__survey_amount_expert WHERE survey_id='".$surveyID."' AND expert_id='".$expertID."'";
			$db->setQuery($sql);
			return $db->loadObject();
		} else if($report_type=='2'){
			
			$sql = "SELECT *  FROM #__survey_amount_expert WHERE survey_id='".$surveyID."' AND expert_id='".$expertID."' AND target ='".$target."' AND target_product ='".$target_product."'";
			$db->setQuery($sql);
			return $db->loadObject();
		} else {
			return (object) array();
		}
		
	}
  function getQuestionAnswerList($surveyID , $expertID , $target,$targetProduct,$reportType){
		$db = JFactory::getDBO();
		 $sql ="";
		 if($reportType==2){
			 	$sql = "SELECT q.id as qID , qa.id as qaID , qa.created_date as created_date FROM #__question as q LEFT JOIN #__survey_question_answer as qa ON qa.ques_id = q.id WHERE q.survey_id='".$surveyID."' AND qa.showed=0 AND qa.expert_id='".$expertID."' AND qa.target='".$target."' AND  qa.target_product='".$targetProduct."'  ORDER BY qa.id" ;
		 } else if($reportType==1){
			 $sql = "SELECT q.id as qID , qa.id as qaID , qa.created_date as created_date FROM #__question as q LEFT JOIN #__survey_question_answer as qa ON qa.ques_id = q.id WHERE q.survey_id='".$surveyID."' AND qa.showed=0 AND qa.expert_id='".$expertID."'  ORDER BY qa.id" ;
		 }
	 	if(!empty($sql )){
			$db->setQuery($sql);
			return $db->loadObjectList();
		} else {
			return array();
		}	
	}
      function getClaimOrderDate($projectID){
		$db = JFactory::getDBO();
		$sql = "SELECT * FROM #__transactions WHERE survey_id = '".$projectID."' AND type=1 AND success='Paid'";
		$db->setQuery($sql);
		return $db->loadObject();
	}
    function getClaimDateToExpert($claimID){
		$db = JFactory::getDBO();
		$sql = "SELECT *  FROM #__message_send WHERE survey_id='".$claimID."'";
		$db->setQuery($sql);
		return $db->loadObject();
	}
     
}
?>