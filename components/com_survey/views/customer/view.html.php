<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * HTML View class for the HelloWorld Component
 */
class SurveyViewCustomer extends JView
{
	// Overwriting JView display method
	function display($tpl = null) 
	{
		// Assign data to the view
		$user = JFactory::getUser();
		$app	= JFactory::getApplication();
		if($user->id==0){
			$app->redirect('index.php/profile');
			exit;
		} else {
			$display = JRequest::getInt('display');
			$getSession = $this->getModel()->expertUserData($user->id);
			if(count($getSession)==0){
				$app->redirect('index.php/profile');
				exit;
			} else if((int)$display != $getSession->id){
				$app->redirect('component/survey/?task=customer.expertOpportunites&display='.$getSession->id);
				exit;
			}
		}
		// Display the view
		parent::display($tpl);
	}
	
	function projectlist($tpl=null){
		$getProjectList = $this->get('ProjectList');
		$this->assignRef('projectList',$getProjectList);
		parent::display($tpl);
	}
	
	function thanks($tpl=null){
		$getRawID = JRequest::getVar('raw');
		$this->assignRef('id',$getRawID);
		parent::display($tpl);
	}
	
	function nopage($tpl=null){
		parent::display($tpl);
	}
	
	function expertProfile($tpl=null){
		$getID = JRequest::getVar('display','');
		$getID = str_replace(' ','+',$getID);
		$profileID = $getID;
		if($getID==''){
			$user = JFactory::getUser();
			if($user->id==0){
				$app	= JFactory::getApplication();
				$app->redirect('index.php');	
				exit;
			}
		} else {
			if(is_numeric($getID)){
				$app	= JFactory::getApplication();
				$app->redirect('index.php');	
				exit;
			} else {
				$config = JFactory::getConfig();
				$encryptPassword = $config->getValue( 'synpat_symbol' );
				$getID = openssl_decrypt($getID,"AES-128-ECB",$encryptPassword);
				
			}	
		}
		$this->assignRef('id',$getID);
		$this->assignRef('profileID',$profileID);
		$getData = $this->getModel()->expertData($getID);
		$getRatingData = $this->getModel()->expertRatingData($getID);		
		$this->assignRef('expert',$getData);
		$this->assignRef('rating',$getRatingData);				
		parent::display($tpl);
	}
	
	function expertFeedback($tpl=null){
		$user = JFactory::getUser();
		$app	= JFactory::getApplication();
		if($user->id==0){
			$display = JRequest::get('display');
			if($display==""){
				$app->redirect('index.php');
				exit;
			} 
		} else {
			$display = JRequest::getVar('display','');
			$display = str_replace(' ','+',$display);
			$profileID = $display;
			if($display==''){
				$app->redirect('index.php');
				exit;
			} else {
				if(is_numeric($display)){
					$app->redirect('index.php');	
					exit;
				} else {
					$config = JFactory::getConfig();
					$encryptPassword = $config->getValue( 'synpat_symbol' );
					$display = openssl_decrypt($display,"AES-128-ECB",$encryptPassword);
					$getSession = $this->getModel()->expertUserData($user->id);
					if(count($getSession)==0){
						$app->redirect('index.php');
						exit;
					} else if((int)$display != $getSession->id){
						$display = openssl_encrypt($getSession->id,"AES-128-ECB",$encryptPassword);
						$app->redirect('component/survey/?task=customer.expertFeedback&display='.$display);
						exit;
					}
				}
			}
			$this->assignRef('id',$profileID);
			$this->assignRef('profileID',$display);
		}
		parent::display($tpl);
	}
	
	function termsOfUse($tpl=null){
		$user = JFactory::getUser();
		$app	= JFactory::getApplication();
		if($user->id==0){
			if($display==""){
				$app->redirect('index.php');
				exit;
			} 
		} else {
			$display = JRequest::getVar('display','');
			$display = str_replace(' ','+',$display);
			$profileID = $display;
			if($display==''){
				$app->redirect('index.php');
				exit;
			} else {
				if(is_numeric($display)){
					$app->redirect('index.php');	
					exit;
				} else {
					$config = JFactory::getConfig();
					$encryptPassword = $config->getValue( 'synpat_symbol' );
					$display = openssl_decrypt($display,"AES-128-ECB",$encryptPassword);
					$getSession = $this->getModel()->expertUserData($user->id);
					if(count($getSession)==0){
						$app->redirect('index.php');
						exit;
					} else if((int)$display != $getSession->id){
						$display = openssl_encrypt($getSession->id,"AES-128-ECB",$encryptPassword);
						$app->redirect('component/survey/?task=customer.termsOfUse&display='.$display);
						exit;
					}
				}
			}
			$this->assignRef('id',$profileID);
			$this->assignRef('profileID',$display);
		}
		parent::display($tpl);
	}
	
	function privacyPolicy($tpl=null){
		$user = JFactory::getUser();
		$app	= JFactory::getApplication();
		if($user->id==0){
			if($display==""){
				$app->redirect('index.php');
				exit;
			} 
		} else {
			$display = JRequest::getVar('display','');
			$display = str_replace(' ','+',$display);
			$profileID = $display;
			if($display==''){
				$app->redirect('index.php');
				exit;
			} else {
				if(is_numeric($display)){
					$app->redirect('index.php');	
					exit;
				} else {
					$config = JFactory::getConfig();
					$encryptPassword = $config->getValue( 'synpat_symbol' );
					$display = openssl_decrypt($display,"AES-128-ECB",$encryptPassword);
					$getSession = $this->getModel()->expertUserData($user->id);
					if(count($getSession)==0){
						$app->redirect('index.php');
						exit;
					} else if((int)$display != $getSession->id){
						$display = openssl_encrypt($getSession->id,"AES-128-ECB",$encryptPassword);
						$app->redirect('component/survey/?task=customer.privacyPolicy&display='.$display);
						exit;
					}
				}
			}
			$this->assignRef('id',$profileID);
			$this->assignRef('profileID',$display);
		}
		parent::display($tpl);
	}
	
	function smeAgreement($tpl=null){
		$user = JFactory::getUser();
		$app	= JFactory::getApplication();
		if($user->id==0){
			if($display==""){
				$app->redirect('index.php');
				exit;
			} 
		} else {
			$display = JRequest::getVar('display','');
			$display = str_replace(' ','+',$display);
			$profileID = $display;
			if($display==''){
				$app->redirect('index.php');
				exit;
			} else {
				if(is_numeric($display)){
					$app->redirect('index.php');	
					exit;
				} else {
					$config = JFactory::getConfig();
					$encryptPassword = $config->getValue( 'synpat_symbol' );
					$display = openssl_decrypt($display,"AES-128-ECB",$encryptPassword);
					$getSession = $this->getModel()->expertUserData($user->id);
					if(count($getSession)==0){
						$app->redirect('index.php');
						exit;
					} else if((int)$display != $getSession->id){
						$display = openssl_encrypt($getSession->id,"AES-128-ECB",$encryptPassword);
						$app->redirect('component/survey/?task=customer.smeAgreement&display='.$display);
						exit;
					}
				}
			}
			$this->assignRef('id',$profileID);
			$this->assignRef('profileID',$display);
		}
		parent::display($tpl);
	}
	
	function smeNda($tpl=null){
		$user = JFactory::getUser();
		$app	= JFactory::getApplication();
		if($user->id==0){
			if($display==""){
				$app->redirect('index.php');
				exit;
			} 
		} else {
			$display = JRequest::getVar('display','');
			$display = str_replace(' ','+',$display);
			$profileID = $display;
			if($display==''){
				$app->redirect('index.php');
				exit;
			} else {
				if(is_numeric($display)){
					$app->redirect('index.php');	
					exit;
				} else {
					$config = JFactory::getConfig();
					$encryptPassword = $config->getValue( 'synpat_symbol' );
					$display = openssl_decrypt($display,"AES-128-ECB",$encryptPassword);
					$getSession = $this->getModel()->expertUserData($user->id);
					if(count($getSession)==0){
						$app->redirect('index.php');
						exit;
					} else if((int)$display != $getSession->id){
						$display = openssl_encrypt($getSession->id,"AES-128-ECB",$encryptPassword);
						$app->redirect('component/survey/?task=customer.smeNda&display='.$display);
						exit;
					}
				}
			}
			$this->assignRef('id',$profileID);
			$this->assignRef('profileID',$display);
		}
		parent::display($tpl);
	}
	
	function getExpertReport($tpl=null){
		$user = JFactory::getUser();
		$app	= JFactory::getApplication();
		if($user->id==0){
			$display = JRequest::getVar('display','');
			$display = str_replace(' ','+',$display);
			if($display==''){
				$app->redirect('index.php');
				exit;
			} else {
				if(is_numeric($display)){
					$app->redirect('index.php');	
					exit;
				} else {
					$config = JFactory::getConfig();
					$getID = $display;
					$encryptPassword = $config->getValue( 'synpat_symbol' );
					$display = openssl_decrypt($display,"AES-128-ECB",$encryptPassword);
					$this->assignRef('id',$getID);
					$this->assignRef('profileID',$display);
				}
			} 
		} else {
			$display = JRequest::getVar('display','');
			$display = str_replace(' ','+',$display);
			$getID = $display;
			if(is_numeric($display)){
				$app->redirect('index.php');	
				exit;
			} else {
				$config = JFactory::getConfig();
				$encryptPassword = $config->getValue( 'synpat_symbol' );
				$display = openssl_decrypt($display,"AES-128-ECB",$encryptPassword);
				$getSession = $this->getModel()->expertUserData($user->id);
				if(count($getSession)==0){
					$app->redirect('index.php');
					exit;
				} else if((int)$display != $getSession->id){
					$display = openssl_encrypt($getSession->id,"AES-128-ECB",$encryptPassword);
					$app->redirect('component/survey/?task=customer.expertReport&display='.$display);
					exit;
				}
				$this->assignRef('id',$getID);
				$this->assignRef('profileID',$display);
			}
		}
		parent::display($tpl);
	}
	function expertProcess($tpl=null){
		$user = JFactory::getUser();
		$app	= JFactory::getApplication();
		if($user->id==0){
			$app->redirect('index.php');
			exit;
		} else {
			$display = JRequest::getVar('display','');
			$display = str_replace(' ','+',$display);
			$profileID = $display;
			if($display==''){
				$app->redirect('index.php');
				exit;
			} else {
				if(is_numeric($display)){
					$app->redirect('index.php');	
					exit;
				} else {
					$config = JFactory::getConfig();
					$encryptPassword = $config->getValue( 'synpat_symbol' );
					$display = openssl_decrypt($display,"AES-128-ECB",$encryptPassword);
					$getSession = $this->getModel()->expertUserData($user->id);
					if(count($getSession)==0){
						$app->redirect('index.php');
						exit;
					} else if((int)$display != $getSession->id){
						$display = openssl_encrypt($getSession->id,"AES-128-ECB",$encryptPassword);
						$app->redirect('component/survey/?task=customer.expertProcess&display='.$display);
						exit;
					}
				}
			}
			$this->assignRef('id',$display);
			$this->assignRef('profileID',$profileID);
		}
		parent::display($tpl);
	}
	function expertOpportunites($tpl=null){
		$user = JFactory::getUser();
		$app	= JFactory::getApplication();
		if($user->id==0){
			$app->redirect('index.php');
			exit;
		} else {
			$display = JRequest::getVar('display','');
			$display = str_replace(' ','+',$display);
			$profileID = $display;
			if($display==''){
				$app->redirect('index.php');
				exit;
			} else {
				if(is_numeric($display)){
					$app->redirect('index.php');	
					exit;
				} else {					
					$config = JFactory::getConfig();
					$encryptPassword = $config->getValue( 'synpat_symbol' );
					$display = openssl_decrypt($display,"AES-128-ECB",$encryptPassword);
					$getSession = $this->getModel()->expertUserData($user->id);
					if(count($getSession)==0){
						$app->redirect('index.php');
						exit;
					} else if((int)$display != $getSession->id){
						$display = openssl_encrypt($getSession->id,"AES-128-ECB",$encryptPassword);
						$app->redirect('component/survey/?task=customer.expertOpportunites&display='.$display);
						exit;
					}
				}
			}
			$this->assignRef('id',$display);
			$this->assignRef('profileID',$profileID);
			
			
			
		}
		parent::display($tpl);
	}
	
	function myactivity($tpl=null){
		$getSessionID = JRequest::getVar('p');
		$reportType = JRequest::getVar('report_type');
		$target = JRequest::getVar('target');
		$targetProduct = JRequest::getVar('target_product');
		$getPrams = JRequest::getVar('param');
		$decodePrams = explode('@',base64_decode($getPrams));
		$expertID = (int)$decodePrams[2];			
		$surveyData = $this->getModel()->surveyData((int)$decodePrams[1]);
		if($getSessionID>0 && $getSessionID==$expertID && count($surveyData)>0){
			$getActivityData = $this->getModel()->expertActivityData($getSessionID,$surveyData->id,$target,$targetProduct,$reportType);
			$this->assignRef('user_activity',$getActivityData);
		}
		parent::display($tpl);
	}
	
	function expertRating($tpl=null){
		$getRawID = JRequest::getVar('display');
		$this->assignRef('stringData',$getRawID);
		$getData = $this->getModel()->expertSurveyExist($getRawID);
		$this->assignRef('rating',$getData);
		parent::display($tpl);
	}
	function notification($tpl=null){
		$getUserSession = JFactory::getUser();
		if($getUserSession->id==0){
			$app = JFactory::getApplication();
			$re = JRequest::getVar('ps');
			$app->redirect('index.php?option=com_survey&task=survey.login&re='.$re);
		}
		$getExpertData = $this->getModel()->expertUserData($getUserSession->id);
		$getList = $this->getModel()->expertNotification($getExpertData->id);
		$this->assignRef('notification',$getList);
		$this->assignRef('expertID',$getExpertData->id);
		parent::display($tpl);
	}
	
	function expert($tpl=null){
		$data = JRequest::get('post');
		$findExpert = $this->getModel()->findExpert($data);		
		$this->assignRef('expertData',$findExpert);		
		parent::display($tpl);
	}
	
	function expertReport($tpl=null){
		$getUserSession = JFactory::getUser();
		$app	= JFactory::getApplication();
		if($getUserSession->id==0){
			$app->redirect('index.php?option=com_survey&task=survey.login');
			exit;
		}
		$target = JRequest::getVar('target');
		$targetProduct = JRequest::getVar('target_product');
		$report_type = JRequest::getVar('report_type');
		$param = JRequest::getVar('param');
		$decodeParam = base64_decode($param);
		$explodeParam = explode('@',$decodeParam);
		if(count($explodeParam)==3){
			if($report_type==2){
				$getList = $this->getModel()->getQueAnsData($explodeParam[1],$explodeParam[2],$target,$targetProduct);
			} else {
				$getList = $this->getModel()->getQueAnsDataPrior($explodeParam[1],$explodeParam[2]);
			}
			$getAllQuestion = $this->getModel()->getAllQuestion($explodeParam[1]);
			$this->assignRef('all_questions',$getAllQuestion);
			$getExpertData = $this->getModel()->expertData($explodeParam[2]);
			$getSurveyInfo = $this->getModel()->getSurveyData($explodeParam[1]);
			$expertRatingData = $this->getModel()->expertRatingData($explodeParam[2]);
			$this->assignRef('target',$target);
			$this->assignRef('target_product',$targetProduct);
			$this->assignRef('report',$getList);
			$this->assignRef('expertData',$getExpertData);
			$this->assignRef('surveyInfo',$getSurveyInfo);
			$this->assignRef('expertRatingData',$expertRatingData);
			parent::display($tpl);
		} else {
			$app = JFactory::getApplication();
			$app->redirect('index.php');
			exit;
		}		
	}
	
	function generateClientRequest($tpl=null){
		parent::display($tpl);
	}
	
	function blog($tpl=null){
		$expertID = JRequest::getInt('display');
		$getList = array();
		$getExpertData = array();
		if($expertID>0){
			$getList  = $this->getModel()->getExpertBlog($expertID,JRequest::getInt('p'));
			$getUserSession = JFactory::getUser();
			$getExpertData = $this->getModel()->expertUserData($getUserSession->id);
						
		} else {
			$app = JFactory::getApplication();
			$app->redirect('index.php','Please login first.','Error');
		}
		$this->assignRef('blogList',$getList);
		$this->assignRef('expert',$getExpertData);
		parent::display($tpl);
	}
	
	function referral(){
		$getUserSession = JFactory::getUser();
		if($getUserSession->id==0){
			$app = JFactory::getApplication();
			$app->redirect('index.php','Please login first.','Error');
		}
		$refferalData = $this->getModel()->getRefferalData();
		$this->assignRef('refferal_data',$refferalData);
		parent::display($tpl);
	}
	
	function expertArea($tpl=null){
		$getUserSession = JFactory::getUser();
		$app = JFactory::getApplication();
		if($getUserSession->id==0){
			$app->redirect('index.php','Please login first.','Error');
			exit;
		} else {
			$display = JRequest::getVar('display','');
			$display = str_replace(' ','+',$display);
			$profileID = $display;
			if($display==''){
				$app->redirect('index.php');
				exit;
			} else {
				if(is_numeric($display)){
					$app->redirect('index.php');	
					exit;
				} else {
					$config = JFactory::getConfig();
					$encryptPassword = $config->getValue( 'synpat_symbol' );
					$display = openssl_decrypt($display,"AES-128-ECB",$encryptPassword);
					$getExpertData = $this->getModel()->expertUserData($getUserSession->id);
					if(count($getExpertData)==0){
						$app->redirect('index.php');
						exit;
					} else if((int)$display != $getExpertData->id){
						$display = openssl_encrypt($getExpertData->id,"AES-128-ECB",$encryptPassword);
						$app->redirect('component/survey/?task=customer.expertArea&display='.$display);
						exit;
					}					
					$parentData = $this->getModel()->getParentExpertise();		
					$childData = "";
					if(count($parentData)>0){
						$childData = $this->getModel()->getChildExpertise($parentData[0]->id);
					}
					
					$expertExpertiseArea = $this->getModel()->getExpertExpertiseArea($getExpertData->id);
					$firstMainAreaParent = $this->getModel()->getFirstMainAreaParent($getExpertData->id);
					/*$firstMainAreaParent = $this->getModel()->getFirstMainAreaParent($getSession->id,$childData);*/
					$this->assignRef('parentData',$parentData);
					$this->assignRef('childData',$childData);
					$this->assignRef('expert',$getExpertData);
					$this->assignRef('expertExpertiseArea',$expertExpertiseArea);
					$this->assignRef('firstMainAreaParent',$firstMainAreaParent);
				}
			}
			$this->assignRef('id',$profileID);
			$this->assignRef('profileID',$display);
								
		}
		
		parent::display($tpl);
	}
	
	function ipccodes($tpl=null){
		$parentData = $this->getModel()->getParentExpertise();		
		$this->assignRef('parentData',$parentData);		
		parent::display($tpl);
	}
}
