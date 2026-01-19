<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla modelitem library
jimport('joomla.application.component.modellist');
jimport('joomla.application.component.helper');


class SurveyModelCustomer extends JModelList
{
    /**
     * @var object item
     */
    protected $item;

    /**
     * Method to auto-populate the model state.
     *
     * This method should only be called once per instantiation and is designed
     * to be called on the first call to the getState() method unless the model
     * configuration flag to ignore the request is set.
     *
     * Note. Calling getState in this method will result in recursion.
     *
     * @return    void
     * @since    1.6
     */


    /**
     * Returns a reference to the a Table object, always creating it.
     *
     * @param    type    The table type to instantiate
     * @param    string    A prefix for the table class name. Optional.
     * @param    array    Configuration array for model. Optional.
     * @return    JTable    A database object
     * @since    1.6
     */
    public function getTable($type = 'Project', $prefix = 'SurveyTable', $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }

	
	
	function expertActivityData($expertID,$surveyID,$target,$targetProduct,$reportType){
		$db = JFactory::getDBO();
		if((int)$reportType==2){
			$query = "SELECT q.description,e.name, a.start_time,a.end_time, SEC_TO_TIME( SUM( TIME_TO_SEC(timediff(a.end_time, a.start_time)))) as  duration FROM `#__activity` as a INNER JOIN  `#__survey_question_answer` as qa ON qa.ques_id = a.ques_id LEFT JOIN #__question as q ON q.id = qa.ques_id LEFT JOIN #__survey as s ON s.id = q.survey_id LEFT JOIN #__projects as p ON p.id = s.project_id LEFT JOIN #__expert as e ON e.id = qa.expert_id WHERE s.report_type=2 AND a.expert_id=".(int)$expertID." AND a.survey_id=".(int)$surveyID." AND qa.target='".(string)$target."' AND qa.target_product='".(string)$targetProduct."'  AND a.target='".(string)$target."' AND a.target_product='".(string)$targetProduct."' GROUP by a.ques_id";
		}else{
			$query = "SELECT qa.*, a.start_time,a.end_time, SEC_TO_TIME( SUM( TIME_TO_SEC(timediff(a.end_time, a.start_time))))  as duration FROM `#__activity` as a INNER JOIN  `#__survey_question_answer` as qa ON qa.ques_id = a.ques_id LEFT JOIN #__question as q ON q.id = qa.ques_id LEFT JOIN #__survey as s ON s.id = q.survey_id LEFT JOIN #__projects as p ON p.id = s.project_id LEFT JOIN #__expert as e ON e.id = qa.expert_id WHERE s.report_type=1 AND a.expert_id=".(int)$expertID." AND a.survey_id=".(int)$surveyID." GROUP by a.ques_id";
		}
		$db->setQuery($query);
		$getActivityCombineData = $db->loadObjectList();
		
		if((int)$reportType==2){
			$query = "SELECT q.description,e.name, a.start_time,a.end_time, SEC_TO_TIME( TIME_TO_SEC(timediff(a.end_time, a.start_time))) as  duration FROM `#__activity` as a INNER JOIN  `#__survey_question_answer` as qa ON qa.ques_id = a.ques_id LEFT JOIN #__question as q ON q.id = qa.ques_id LEFT JOIN #__survey as s ON s.id = q.survey_id LEFT JOIN #__projects as p ON p.id = s.project_id LEFT JOIN #__expert as e ON e.id = qa.expert_id WHERE s.report_type=2 AND a.expert_id=".(int)$expertID." AND a.survey_id=".(int)$surveyID." AND qa.target='".(string)$target."' AND qa.target_product='".(string)$targetProduct."'  AND a.target='".(string)$target."' AND a.target_product='".(string)$targetProduct."'";
		}else{
			$query = "SELECT q.description,e.name, a.start_time,a.end_time, SEC_TO_TIME( TIME_TO_SEC(timediff(a.end_time, a.start_time))) as  duration FROM `#__activity` as a INNER JOIN  `#__survey_question_answer` as qa ON qa.ques_id = a.ques_id LEFT JOIN #__question as q ON q.id = qa.ques_id LEFT JOIN #__survey as s ON s.id = q.survey_id LEFT JOIN #__projects as p ON p.id = s.project_id LEFT JOIN #__expert as e ON e.id = qa.expert_id WHERE s.report_type=1 AND a.expert_id=".(int)$expertID." AND a.survey_id=".(int)$surveyID;
		}
		/*echo $query;*/
		$db->setQuery($query);
		$getActivityData = $db->loadObjectList();
		
		if((int)$reportType==2){
			$query = "SELECT SEC_TO_TIME( SUM( TIME_TO_SEC(timediff(a.end_time, a.start_time)))) as total_time_spend FROM `#__activity` as a INNER JOIN  `#__survey_question_answer` as qa ON qa.ques_id = a.ques_id LEFT JOIN #__question as q ON q.id = qa.ques_id LEFT JOIN #__survey as s ON s.id = q.survey_id LEFT JOIN #__projects as p ON p.id = s.project_id LEFT JOIN #__expert as e ON e.id = qa.expert_id WHERE s.report_type=2 AND a.expert_id=".(int)$expertID." AND a.survey_id=".(int)$surveyID." AND qa.target='".(string)$target."' AND qa.target_product='".(string)$targetProduct."'  AND a.target='".(string)$target."' AND a.target_product='".(string)$targetProduct."' GROUP BY a.target,a.target_product,qa.target,qa.target_product";
		}else{
			$query = "SELECT SEC_TO_TIME( SUM( TIME_TO_SEC(timediff(a.end_time, a.start_time)))) as total_time_spend FROM `#__activity` as a INNER JOIN  `#__survey_question_answer` as qa ON qa.ques_id = a.ques_id LEFT JOIN #__question as q ON q.id = qa.ques_id LEFT JOIN #__survey as s ON s.id = q.survey_id LEFT JOIN #__projects as p ON p.id = s.project_id LEFT JOIN #__expert as e ON e.id = qa.expert_id WHERE s.report_type=1 AND a.expert_id=".(int)$expertID." AND a.survey_id=".(int)$surveyID." GROUP BY p.id,a.survey_id,a.expert_id";
		}
		$db->setQuery($query);
		$getActivityTiming = $db->loadObject();
		return array('getActivityData'=>$getActivityData,'getActivityCombineData'=>$getActivityCombineData,'getActivityTiming'=>$getActivityTiming->total_time_spend);
	}
	
	function saveActivityData($data,$expertLoggedID){
		$newID = 0;
		if($data['expert_id']==$expertLoggedID){
			$decodeDataTo = base64_decode($data['inst']);
			$dataExplode = explode('_',$decodeDataTo);
			$getSurveyDetails = $this->surveyData($data['survey_id']);
			if(count($dataExplode)==2 && count($getSurveyDetails)>0){
				$ques_id  = $dataExplode[1];
				$expert_id= $data['expert_id'];
				$survey_id= $data['survey_id'];
				$target= $data['target'];
				$target_product= $data['target_product'];
				$start_time= $data['s'];
				$end_time= $data['e'];
				$str= $data['str'];
				$db = JFactory::getDBO();
				$sql = "INSERT INTO #__activity(`expert_id`,`survey_id`,`ques_id`,`target`,`target_product`,`start_time`,`end_time`,`history_string`)VALUES('" . $expert_id . "','" . $survey_id . "','" . $ques_id . "','" . $target . "','" . $target_product . "','" . $start_time . "','" . $end_time . "','" . $str . "')";
				$db->setQuery($sql);
				$db->query();
				$newID = $db->insertid();
			}
		}
		return $newID;
	}
	
	public function getRefferalData(){
		$db = JFactory::getDBO();
		$getUserSession = JFactory::getUser();
		if($getUserSession->id>0){
			$query = "SELECT * FROM #__refferal_data WHERE user_id=".$getUserSession->id;
			$db->setQuery($query);
			return $db->loadObjectList();
		} else {
			return array();
		}		
	}
	
	public function surveyData($surveyID){
		$db = JFactory::getDBO();
		$query = "SELECT * FROM #__survey WHERE id=".$surveyID;
		$db->setQuery($query);
		return $db->loadObject();
	}
	
	function getIllustrationData($name){
		$option = SurveyModelCustomer::getBackyardCredential();      
		$dbBackyard = JDatabase::getInstance( $option );
		$sqlIllustration = "select file from due_dilligence_illustrations WHERE patent_id='".$name."'";
		$dbBackyard->setQuery($sqlIllustration);
		$resultIllustration = $dbBackyard->loadObject();
		return $resultIllustration;
	}
	
	
	
    /**
     * Get the message
     * @return object The message to be displayed to the user
     */
    function getProjectList()
    {
        $db = JFactory::getDBO();
        $sql = "SELECT * FROM #__projects ORDER BY name ASC";
        $db->setQuery($sql);
        return $db->loadObjectList();
    }

    function surveyList($surveyID, $pr=0,$name='')
    {
        $db = JFactory::getDBO();
		if(empty($name) && $pr>0){
			$sql = "SELECT * FROM #__survey WHERE project_id='" . $surveyID . "' AND report_type='".$pr."' ORDER BY name ASC";
		} else if(!empty($name)) {
			$sql = "SELECT * FROM #__survey WHERE project_id='" . $surveyID . "' AND name='".$name."' ORDER BY name ASC";
		} else {
			$sql = "SELECT * FROM #__survey WHERE project_id='" . $surveyID . "' ORDER BY name ASC";
		}
		
        $db->setQuery($sql);
        return $db->loadObjectList();
    }
	
	function reEditReport($expertID,$target,$targetProduct){
		$query = "UPDATE #__survey_question_answer SET showed=1,notify=0,`show`=0 WHERE expert_id=".(int)$expertID." AND target='".$target."' AND target_product='".$targetProduct."'";
		$db = JFactory::getDBO();
		$db->setQuery($query);
		return $db->query();
	}
	
	function getMyClaimPrice($surveyID,$target_product,$target,$sessionEXpertID){
		$db = JFactory::getDBO();
		$amountSurvey = "SELECT sae.amount FROM #__survey_amount_expert as sae  LEFT JOIN #__survey as s ON s.id = sae.survey_id LEFT JOIN #__survey_question_answer as sqa ON sqa.target = sae.target WHERE sqa.showed=0 AND sae.survey_id='" . $surveyID . "' AND sae.target='" . $target . "' AND sae.target_product='" . $target_product . "' AND sae.expert_id='" . $sessionEXpertID . "'";
		$db->setQuery($amountSurvey);
		return $db->loadObject();
	}
	
	function getMyClaimPriceInProcess($surveyID,$target_product,$target,$sessionEXpertID){
		$db = JFactory::getDBO();
		$amountSurvey = "SELECT sae.amount FROM #__survey_amount_expert as sae  LEFT JOIN #__survey as s ON s.id = sae.survey_id LEFT JOIN #__survey_question_answer as sqa ON sqa.target = sae.target WHERE sqa.showed=1 AND sae.survey_id='" . $surveyID . "' AND sae.target='" . $target . "' AND sae.target_product='" . $target_product . "' AND sae.expert_id='" . $sessionEXpertID . "'";
		$db->setQuery($amountSurvey);
		return $db->loadObject();
	}
	
	function getReportID($surveyID,$target_product,$target,$sessionEXpertID){
		$db = JFactory::getDBO();
		$amountSurvey = "SELECT sae.id FROM #__survey_amount_expert as sae  LEFT JOIN #__survey as s ON s.id = sae.survey_id LEFT JOIN #__survey_question_answer as sqa ON sqa.target = sae.target WHERE sae.survey_id='" . $surveyID . "' AND sae.target='" . $target . "' AND sae.target_product='" . $target_product . "' AND sae.expert_id='" . $sessionEXpertID . "' ORDER BY sae.id DESC";
		$db->setQuery($amountSurvey);
		return $db->loadObject();
	}
	function getFullReport($surveyID,$target_product,$target,$sessionEXpertID){
		$db = JFactory::getDBO();
		$amountSurvey = "SELECT sae.file_name FROM #__survey_amount_expert as sae  LEFT JOIN #__survey as s ON s.id = sae.survey_id LEFT JOIN #__survey_question_answer as sqa ON sqa.target = sae.target WHERE sae.survey_id='" . $surveyID . "' AND sae.target='" . $target . "' AND sae.target_product='" . $target_product . "' AND sae.expert_id='" . $sessionEXpertID . "' AND sae.file_name<>'' ORDER BY sae.id DESC";
		$db->setQuery($amountSurvey);
		return $db->loadObject();
	}
	
	function updateSurveyAmountExpert($getSurveyID,$getExpertDataID,$target,$target_product,$runReport){
		$query = "UPDATE #__survey_amount_expert SET run_report=".$runReport." WHERE expert_id=".(int)$getExpertDataID." AND survey_id=".(int)$getSurveyID." AND target='".$target."' AND target_product='".$target_product."'";
		$db = JFactory::getDBO();
		$db->setQuery($query);
		return $db->query();
	}
	
	function getExpertBlog($expertID,$pageNo){
		$db = JFactory::getDBO();
		if($pageNo<=0){
			$pageNo = 1;
		}
		$pageNo = $pageNo - 1;
		$startRecord = $pageNo * 10;
		/*Update First Record*/
		$expertData = $this->expertData($expertID);
		$count = array();
		$records = array();
		if(count($expertData)>0){
			$sql = "UPDATE #__content SET state=1 WHERE state=0 AND created_by='".$expertData->user_id."'";
			$db->setQuery($sql);
			$db->query();
			/*Find User Blog Records*/
			$sql = "SELECT count(*) as blogCount FROM #__content as c INNER JOIN #__categories as cc ON cc.id = c.catid INNER JOIN #__users as u ON u.id = c.created_by WHERE c.created_by='".$expertData->user_id."' AND c.state<> -2 ";
			$db->setQuery($sql);
			$count = $db->loadObject();
			$sql = "SELECT c.*, cc.title as category_title, u.name as author FROM #__content as c INNER JOIN #__categories as cc ON cc.id = c.catid INNER JOIN #__users as u ON u.id = c.created_by WHERE c.created_by='".$expertData->user_id."' AND c.state<> -2 ORDER BY c.id DESC LIMIT ".$startRecord.",10";
			$db->setQuery($sql);
			$records = $db->loadObjectList();
		}
		return array('count'=>$count, 'blog'=>$records);
	}
	
	
    function quList($surveyID)
    {
        $db = JFactory::getDBO();    
		$sql = "SELECT q.* FROM #__question as q  WHERE  q.survey_id='" . $surveyID . "' ORDER BY q.question_order ASC";
        $db->setQuery($sql);
        $getList = $db->loadObjectList();
		$expertIDList = array();
        if (count($getList) > 0) {
			$targetProductsQuery = "SELECT qa.target, qa.target_product,qa.expert_id FROM #__survey_question_answer as qa LEFT JOIN #__question as q ON q.id = qa.ques_id LEFT JOIN #__survey as s ON s.id = q.survey_id WHERE qa.showed=0 AND qa.`show`=1 AND s.id= '" . $surveyID . "' GROUP By qa.target,qa.target_product,qa.expert_id";
			$db->setQuery($targetProductsQuery);
			$targetProducts = $db->loadObjectList();
			$question = array();
            $sID = "";
			if(count($targetProducts)>0){
				$expertIDs = array();	
				foreach($targetProducts as $tp){
					$expertIDs[] = $tp->expert_id;
				}
				if(count($expertIDs)>0){
					$queryExpertDNDReport = "SELECT e.id FROM #__expert as e INNER JOIN #__users as u ON u.id = e.user_id WHERE e.id IN (".implode(',',$expertIDs).") AND u.can_see=0";
					$db->setQuery($queryExpertDNDReport);
					$dndExperts = $db->loadObjectList();
					if(count($dndExperts)>0){
						foreach($dndExperts as $e){
							for($i=0;$i<count($targetProducts);$i++){
								if($targetProducts[$i]->expert_id == $e->id){
									$expertIDList[] = $e->id;
									unset($targetProducts[$i]);
								}
							}
							$targetProducts = array_values($targetProducts);
						}
					} 
				}
			}
			$targetProducts = array_values($targetProducts);
            for ($i = 0; $i < count($getList); $i++) {
                $answersAll = array();
				if(count($targetProducts)>0){
					for($tp=0;$tp<count($targetProducts);$tp++){
						$ansSql = "SELECT id,ques_id,expert_id,status,target,target_product FROM #__survey_question_answer as sqe WHERE  sqe.showed=0 AND `show`=1 AND publish=0 AND sqe.expert_id=".$targetProducts[$tp]->expert_id." AND sqe.ques_id='" . $getList[$i]->id . "' AND sqe.target='".$targetProducts[$tp]->target."' AND sqe.target_product='".$targetProducts[$tp]->target_product."'";
						$db->setQuery($ansSql);
						$getAnsList = $db->loadObject();
						array_push($answersAll,$getAnsList);
					}
				}
				$question[] = array('data' => $getList[$i], 'answer' => $answersAll);
            }
			$getAmountList = array();
			if(count($targetProducts)>0){
				for($tp=0;$tp<count($targetProducts);$tp++){
					$amountSurvey = "SELECT sae.*, s.payment_type FROM #__survey_amount_expert as sae LEFT JOIN #__survey as s ON s.id = sae.survey_id LEFT JOIN #__survey_question_answer as sqa ON sqa.target = sae.target  WHERE sqa.`show` = 1 AND sae.survey_id='" . $surveyID . "' AND sae.expert_id=".$targetProducts[$tp]->expert_id." AND sae.target='".$targetProducts[$tp]->target."' AND sae.target_product='".$targetProducts[$tp]->target_product."'  ORDER BY sae.target_product ASC";
					$db->setQuery($amountSurvey);
					$getAmount = $db->loadObject();
					array_push($getAmountList,$getAmount);
				}
			}
            $expertList = array();
			if(count($expertIDList)==0){
				$surveySql = "SELECT e.id , e.name, e.linkedin_profile_url,e.expert_type, e.company_name , ep.paypal_id , qa.target, qa.target_product FROM #__survey_question_answer as qa LEFT JOIN  #__expert as e ON e.id = qa.expert_id LEFT JOIN  #__question as q ON q.id = qa.ques_id LEFT JOIN  #__survey as s ON s.id = q.survey_id LEFT JOIN #__expert_payment as ep ON ep.expert_id = e.id  WHERE q.survey_id = '" . $surveyID . "' AND qa.`show` =1 AND qa.showed = 0 GROUP BY qa.target, qa.target_product ORDER BY e.name ASC";
			} else {
				$surveySql = "SELECT e.id , e.name, e.linkedin_profile_url,e.expert_type, e.company_name , ep.paypal_id , qa.target, qa.target_product FROM #__survey_question_answer as qa LEFT JOIN  #__expert as e ON e.id = qa.expert_id LEFT JOIN  #__question as q ON q.id = qa.ques_id LEFT JOIN  #__survey as s ON s.id = q.survey_id LEFT JOIN #__expert_payment as ep ON ep.expert_id = e.id  WHERE q.survey_id = '" . $surveyID . "' AND qa.`show` =1 AND qa.showed = 0 AND qa.expert_id NOT IN (".implode(',',$expertIDList).") GROUP BY qa.target, qa.target_product ORDER BY e.name ASC";
			}	

            $db->setQuery($surveySql);
            $expertList = $db->loadObjectList();
            return array('question' => $question, 'expert' => $expertList, 'survey' => $getAmountList);
        } else {
            return array('question' => array(),'expert'=>array(),'survey'=>'');
        }
    }
	
	function insertExpert($data)
    {
        $db =& JFactory::getDBO();
		if(isset($data['user_id']) && $data['user_id']>0){
			$expertData = SurveyModelCustomer::expertUserData($data['user_id']);
			if(count($expertData)>0){
				return $expertData->id;
			}
		} else {
			$item =& SurveyModelCustomer::getTable('Expert');
			if (!$item->bind($data)) {
				echo $item->getError() . ' - 1';
				return false;
			}
			if (!$item->check()) {
				echo $item->getError() . ' - 2';
				return false;
			}
			if (!$item->store()) {
				echo $item->getError() . ' - 3';
				return false;
			}
			return $item->id;
		}        
    }
	
	
	function findReportsPriceList($surveyID){
		$db = JFactory::getDBO(); 
		$targetProductsQuery = "SELECT qa.target, qa.target_product,qa.expert_id FROM #__survey_question_answer as qa LEFT JOIN #__question as q ON q.id = qa.ques_id LEFT JOIN #__survey as s ON s.id = q.survey_id WHERE qa.showed=0 AND `show`=1 AND s.id= '" . $surveyID . "' GROUP By qa.target,qa.target_product,qa.expert_id";
		$db->setQuery($targetProductsQuery);
		$targetProducts = $db->loadObjectList();
		$getAmountList = array();
		if(count($targetProducts)>0){
			for($tp=0;$tp<count($targetProducts);$tp++){
				$amountSurvey = "SELECT sae.*, s.payment_type FROM #__survey_amount_expert as sae LEFT JOIN #__survey as s ON s.id = sae.survey_id LEFT JOIN #__survey_question_answer as sqa ON sqa.target = sae.target  WHERE sqa.`show` = 1 AND sae.survey_id='" . $surveyID . "' AND sae.target='".$targetProducts[$tp]->target."' AND sae.target_product='".$targetProducts[$tp]->target_product."' AND sae.expert_id='".$targetProducts[$tp]->expert_id."' ORDER BY sae.target_product ASC";
				$db->setQuery($amountSurvey);
				$getAmount = $db->loadObject();
				array_push($getAmountList,$getAmount);
			}
		}
		return $getAmountList;
	}

    function quListExpert($surveyID, $expertID)
    {
        $db = JFactory::getDBO();


        $sql = "SELECT * FROM #__survey_question_answer WHERE showed=0 AND expert_id='" . $expertID . "' AND ques_id IN (SELECT id FROM #__question WHERE survey_id='" . $surveyID . "') GROUP BY ques_id";
        /*
        $sql = "SELECT q.* FROM #__question as q LEFT JOIN #__survey_question_answer as qa ON qa.ques_id = q.id  WHERE qa.showed=0 AND qa.expert_id='".$expertID."' AND q.survey_id='".$surveyID."' GROUP BY q.id ORDER BY q.id ASC";
        */
        $db->setQuery($sql);
        $getDummyData = $db->loadObjectList();
        if (count($getDummyData) > 0) {
            $sql = "SELECT q.* FROM #__question as q  WHERE  q.survey_id='" . $surveyID . "' ORDER BY q.question_order ASC";
        }
        $db->setQuery($sql);
        $getList = $db->loadObjectList();
		$targetProductsQuery = "SELECT qa.target, qa.target_product FROM #__survey_question_answer as qa LEFT JOIN #__question as q ON q.id = qa.ques_id LEFT JOIN #__survey as s ON s.id = q.survey_id WHERE qa.showed=0 AND qa.expert_id= '" . $expertID . "' AND s.id= '" . $surveyID . "' GROUP By qa.target,qa.target_product";
		$db->setQuery($targetProductsQuery);
        $targetProducts = $db->loadObjectList();
        if (count($getList) > 0) {
            $question = array();
            $sID = "";
            for ($i = 0; $i < count($getList); $i++) {
				$answersAll = array();
				if(count($targetProducts)>0){
					for($tp=0;$tp<count($targetProducts);$tp++){
						$ansSql = "SELECT id,ques_id,expert_id,status,target,target_product FROM #__survey_question_answer as sqe WHERE sqe.expert_id='" . $expertID . "' AND sqe.showed=0  AND publish=0 AND sqe.ques_id='" . $getList[$i]->id . "' AND sqe.target='".$targetProducts[$tp]->target."' AND sqe.target_product='".$targetProducts[$tp]->target_product."'";
						$db->setQuery($ansSql);
						$getAnsList = $db->loadObject();
						array_push($answersAll,$getAnsList);
					}
				}
                $question[] = array('data' => $getList[$i], 'answer' => $answersAll);
            }
            /*$amountSurvey = "SELECT * FROM #__survey_amount_expert WHERE survey_id='".$surveyID."' AND expert_id = '".$expertID."' ORDER BY survey_id ASC";*/
			$getAmountList = array();
			if(count($targetProducts)>0){
				for($tp=0;$tp<count($targetProducts);$tp++){
					$amountSurvey = "SELECT sae.*, s.payment_type FROM #__survey_amount_expert as sae LEFT JOIN #__survey as s ON s.id = sae.survey_id LEFT JOIN #__survey_question_answer as sqa ON sqa.target = sae.target  WHERE sae.expert_id=".$expertID." AND sae.survey_id='" . $surveyID . "' AND sae.target='".$targetProducts[$tp]->target."' AND sae.target_product='".$targetProducts[$tp]->target_product."'  ORDER BY sae.target_product ASC";
					$db->setQuery($amountSurvey);
					$getAmount = $db->loadObject();
					array_push($getAmountList,$getAmount);
				}
			}
            $expertList = array();
 		    $surveySql = "SELECT e.id , e.name, e.linkedin_profile_url, e.expert_type, e.company_name , ep.paypal_id , qa.target, qa.target_product, qa.created_date, qa.posted_date,u.can_see FROM #__survey_question_answer as qa LEFT JOIN  #__expert as e ON e.id = qa.expert_id LEFT JOIN  #__users as u ON e.user_id = u.id LEFT JOIN  #__question as q ON q.id = qa.ques_id LEFT JOIN  #__survey as s ON s.id = q.survey_id LEFT JOIN #__expert_payment as ep ON ep.expert_id = e.id  WHERE q.survey_id = '" . $surveyID . "' AND e.id = '" . $expertID . "' AND qa.showed = 0 GROUP BY qa.target, qa.target_product ORDER BY e.name ASC";

            $db->setQuery($surveySql);
            $expertList = $db->loadObjectList();

            return array('question' => $question, 'expert' => $expertList, 'survey' => $getAmountList);
        } else {
            return array('question' => array());
        }
    }
						
    function insertTrans($amt, $surveyID, $expertID, $discAmount ,$type = 0, $target = "",$target_product="")
    {

        $db = JFactory::getDBO();
        if ($type == 0) {
            $sql = "INSERT INTO #__transactions(`amount`,`success`,`create_date`,`message`,`survey_id`,`expert_id`,`type`,`discount_amt`,target,target_product) VALUES('" . $amt . "','unpaid','" . date('Y-m-d H:i:s', strtotime('now')) . "','Redirect to paypal','" . $surveyID . "','" . $expertID . "','" . $type . "','" . $discAmount . "','" . $target . "','" . $target_product . "')";
        } else {
            $sql = "INSERT INTO #__transactions(`amount`,`success`,`create_date`,`message`,`survey_id`,`expert_id`,`type`,`discount_amt`,target,target_product) VALUES('" . $amt . "','unpaid','" . date('Y-m-d H:i:s', strtotime('now')) . "','Redirect to paypal','" . $surveyID . "','" . $expertID . "','" . $type . "','" . $discAmount . "','" . $target . "','" . $target_product . "')";
        }
	    $db->setQuery($sql);
        $db->query();
        return $db->insertid();
    }
	
	function updateTrans($data,$trnsID){
		$querySt = "";
		foreach ($data as $key => $value) {
			$querySt .= "$key='$value',";
		}
		try{
			if(!empty($querySt)){
				$query = "UPDATE #__transactions SET ".substr($querySt,0,-1)." WHERE id=".(int) $trnsID;
				$db = JFactory::getDBO();
				$db->setQuery($query);
				$db->query();
			}
		} catch (Exception $ex){
			
		}
	}
	
	function checkTransUnPaid($transID){
		$db = JFactory::getDBO();
        $sql = "SELECT * FROM #__transactions WHERE id='" . $transID . "' AND success='unpaid'";
        $db->setQuery($sql);
        $transData = $db->loadObject();
		return $transData;
	}
	
	
    function checkTrans($transID)
    {
        $db = JFactory::getDBO();
        $sql = "SELECT * FROM #__transactions WHERE id='" . $transID . "' AND date_format(create_date,'%Y-%m-%d')='" . date('Y-m-d', strtotime('now')) . "'  ORDER BY id ASC";
        $sql = "SELECT * FROM #__transactions WHERE id='" . $transID . "' ORDER BY id ASC";
        $db->setQuery($sql);
        $transData = $db->loadObject();
        if (count($transData) > 0) {
            if ($transData->success == 'unpaid') {
                $updateSql = "UPDATE #__transactions SET success='Paid', message='Payment successfully done' WHERE id='" . $transID . "'";
                $db->setQuery($updateSql);
                $db->query();
            }
        }
        return $transData;
    }
	
	function getTransDetails($transID){
		$db = JFactory::getDBO();
        $sql = "SELECT * FROM #__transactions WHERE id='" . $transID . "'";
        $db->setQuery($sql);
        $transData = $db->loadObject();
		return $transData;
	}
	
    function getQueAnsData($surveyID, $expertID, $target, $target_product)
    {
        $db = JFactory::getDBO();
        $sql = "SELECT q.* , qa.id as answerID, qa.answer as answer, qa.supporting_document as supporting_document FROM #__question as q LEFT JOIN `#__survey_question_answer` qa ON q.id = qa.ques_id WHERE q.survey_id='" . $surveyID . "' AND qa.expert_id='" . $expertID . "' AND qa.target='" . $target . "' AND qa.target_product='" . $target_product . "' ORDER BY q.id ASC";
        $db->setQuery($sql);
        return $db->loadObjectList();
    }
	function getAllQuestion($surveyID)
    {
        $db = JFactory::getDBO();
        $sql = "SELECT q.description,q.id FROM #__question as q WHERE q.survey_id='" . $surveyID . "' ORDER BY q.id ASC";
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
	
	function checkProjectWithCodes($projectName){
		$db = JFactory::getDBO();
		$sql = "SELECT s.* FROM #__projects as p INNER JOIN #__survey as s ON s.project_id =  p.id INNER JOIN #__transactions as t ON t.survey_id = p.id WHERE p.name = '" . $projectName . "' AND t.success ='Paid' AND t.type=1";
		$db->setQuery($sql);
        return $db->loadObjectList();
	}

    function checkProjectWithName($projectName)
    {
        $db = JFactory::getDBO();
        $sql = "SELECT p.* FROM #__projects as p INNER JOIN #__survey as s ON s.project_id =  p.id LEFT JOIN #__question as q ON q.survey_id = s.id  INNER JOIN #__transactions as t ON t.survey_id = p.id WHERE p.name = '" . $projectName . "' AND t.success ='Paid' AND t.type=1 GROUP BY p.id";
        $db->setQuery($sql);
        return $db->loadObjectList();
    }


    function checkProjectWithSurveyName($surveyName)
    {
        $db = JFactory::getDBO();
        /*$sql = "SELECT p.* FROM #__projects as p INNER JOIN #__survey as s ON s.project_id =  p.id INNER JOIN #__question as q ON q.survey_id = s.id INNER JOIN  #__survey_question_answer as qa ON qa.ques_id = q.id INNER JOIN #__transactions as t ON t.survey_id = p.id WHERE qa.showed = 0 AND  s.combine_name LIKE '%" . $surveyName . "%' AND t.success ='Paid' AND t.type=1 GROUP BY p.id";*/
        $sql = "SELECT p.* FROM #__projects as p INNER JOIN #__survey as s ON s.project_id =  p.id LEFT JOIN #__question as q ON q.survey_id = s.id INNER JOIN #__transactions as t ON t.survey_id = p.id WHERE s.combine_name LIKE '%" . $surveyName . "%' AND t.success ='Paid' AND t.type=1 AND s.exclude=2 GROUP BY p.id";
        $db->setQuery($sql);
        return $db->loadObjectList();
    }

    function checkProjectWithExpertName($expertName)
    {
        $db = JFactory::getDBO();
        $sql = "SELECT p.* FROM #__projects AS p INNER JOIN #__survey AS s ON s.project_id = p.id INNER JOIN #__question AS q ON q.survey_id = s.id INNER JOIN #__survey_question_answer AS qa ON qa.ques_id = q.id INNER JOIN #__expert AS e ON e.id = qa.expert_id INNER JOIN #__transactions as t ON t.survey_id = p.id WHERE e.name LIKE '%" . $expertName . "%' AND t.success ='Paid' AND t.type=1 AND s.exclude=2  GROUP BY p.id";
        $db->setQuery($sql);
        return $db->loadObjectList();
    }
	
	function findSurveyDataFromLatestReportByProjectID($projectID){
		$db = JFactory::getDBO();
		$sql = "SELECT s.* FROM #__survey AS s INNER JOIN #__question AS q ON q.survey_id = s.id INNER JOIN #__survey_question_answer AS qa ON qa.ques_id = q.id WHERE qa.showed=0 AND s.project_id='".$projectID."' AND s.report_type=2 ORDER BY qa.created_date DESC LIMIT 0,1";
		$db->setQuery($sql);
		return $db->loadObject();
	}
	
	function getProjectNameFromLatestReport(){
		$db = JFactory::getDBO();
		$sql = "SELECT p.* FROM #__projects AS p INNER JOIN #__survey AS s ON s.project_id = p.id INNER JOIN #__question AS q ON q.survey_id = s.id INNER JOIN #__survey_question_answer AS qa ON qa.ques_id = q.id WHERE qa.showed=0 ORDER BY qa.created_date DESC LIMIT 0,1";
		$db->setQuery($sql);
		return $db->loadObjectList();
	}
    function expertRatingData($expertID)
    {
        $db = JFactory::getDBO();
        $sql = "SELECT sum(er.rating) as rating, count(er.survey_id) as countSurvey , s.id as surveyID , s.name as surveyName,e.id,e.name as expertName ,  e.linkedin_pic as linkedin_pic, e.linkedin_profile_url as linkedin_profile_url FROM #__expertrating as er LEFT JOIN #__expert as e ON e.id = er.expert_id LEFT JOIN #__survey as s ON s.id = er.survey_id WHERE er.expert_id='" . $expertID . "' GROUP BY er.survey_id";
        $db->setQuery($sql);
        return $db->loadObjectList();
    }

    function expertRatingDataDetail($expertID)
    {
        $db = JFactory::getDBO();
        $sql = "SELECT er.rating as rating,er.feedback, s.id as surveyID , s.combine_name as surveyName , p.name as projectName , er.created_date, er.digital_code FROM #__expertrating as er LEFT JOIN #__expert as e ON e.id = er.expert_id LEFT JOIN #__survey as s ON s.id = er.survey_id LEFT JOIN #__projects as p ON p.id = s.project_id WHERE er.expert_id='" . $expertID . "'";
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

    function generateDigiCode($code, $transID)
    {
        $db = JFactory::getDBO();
        $sql = "INSERT INTO #__digicode(`code_generate`,`trans_id`)VALUES('" . $code . "','" . $transID . "')";
        $db->setQuery($sql);
        $db->query();
        return $db->insertid();
    }
	
	function findSerialNumber($code,$type=1){
		$db = JFactory::getDBO();
		if($type==1){
			 $sql = "SELECT count(*) as code FROM #__survey as s WHERE s.code='" . $code . "'";
		} else if($type==2){
			$sql = "SELECT count(*) as code FROM #__projects as p WHERE p.code='" . $code . "'";
		}
       
        $db->setQuery($sql);
        return  $db->loadObject()->code;		
	}
    
    function saveEmailAlert($dataArray){
		$db = JFactory::getDBO();
        $sql = "INSERT INTO #__email_alert(`email_address`,`project_id`,`survey_id`)VALUES('" . $dataArray['email_address'] . "','" . $dataArray['project_id']. "','" . $dataArray['survey_id']. "')";
        $db->setQuery($sql);
        $db->query();
        return $db->insertid();
	}

    function expertSurveyExist($string)
    {
        /*Check Code Exist*/
        $db = JFactory::getDBO();
        $sttring = base64_decode($string);
        $stringExplode = explode('@', $sttring);
		 
        if (count($stringExplode) == 4) {
            $newString = base64_encode($stringExplode[0] . "@" . $stringExplode[1] . "@" . $stringExplode[2]);

			$sql = "SELECT * FROM `#__digicode` WHERE code_generate='" . $newString . "' AND status=0";
            $db->setQuery($sql);
            $getData = $db->loadObject();
            /*End Code Exist*/
            if (count($getData) > 0) {
                $decodeCode = base64_decode($string);
                $explodeCode = explode('@', $decodeCode);
                if (count($explodeCode) > 0 && $explodeCode[1] != "") {
                    $getExpert = $this->expertData($explodeCode[1]);
                    return array('digiCode' => $getData, 'expert' => $getExpert);
                }
            } else {
                /*return $getData;*/
                return array();
            }
        } else {
            return array();
        }
    }

    function checkDigiCodeGenerate($transID)
    {
        $db = JFactory::getDBO();
        $sql = "SELECT * FROM `#__digicode` WHERE trans_id='" . $transID . "' AND status=1";
        $db->setQuery($sql);
        return $db->loadObject();
    }

    function checkCode($digitalCode)
    {
        $db = JFactory::getDBO();
        $sql = "SELECT * FROM `#__digicode` WHERE code_generate='" . $digitalCode . "' AND status=0";
        $db->setQuery($sql);
        return $db->loadObject();
    }
	
	function checkCodeWithID($digitalCode,$ID)
    {
        $db = JFactory::getDBO();
        $sql = "SELECT * FROM `#__digicode` WHERE id=".$ID." and code_generate='" . $digitalCode . "' AND status=0";
        $db->setQuery($sql);
        return $db->loadObject();
    }

    function saveRating($rating, $surveyID, $expertID, $feedback,$string)
    {
        $db = JFactory::getDBO();
        $sql = "INSERT INTO #__expertrating(`expert_id`,`survey_id`,`rating`,`feedback`,`digital_code`,`created_date`)VALUES('" . $expertID . "','" . $surveyID . "','" . $rating . "','" . $feedback . "','" . $string . "','" . date('Y-m-d H:i:s', strtotime('now')) . "')";
        $db->setQuery($sql);
        $db->query();
        return $db->insertid();
    }
	
	function deleteOldRating($string){
		$db = JFactory::getDBO();
        $sql = "DELETE FROM #__expertrating WHERE `digital_code` = '" . $string . "'";
        $db->setQuery($sql);
        $db->query();       
	}
	
	function deleteNotification($sruveyID,$userID){
		$db = JFactory::getDBO();
        $sql = "DELETE FROM #__notification WHERE `survey_id` = '" . $sruveyID . "' AND expert_id= '".$userID."'";
        $db->setQuery($sql);
        if($db->query()){
			return 1;
		}  else {
			return 0;
		}
	}
	
    function updateDigiCode($code, $status)
    {
        $db = JFactory::getDBO();
        $decodeCode = base64_decode($code);
        $explodeCode = explode('@', $decodeCode);
        if (count($explodeCode) == 5) {
            $sql = "UPDATE `#__digicode` SET status='" . $status . "' WHERE id='" . $explodeCode[4] . "'";
            $db->setQuery($sql);
            $db->query();
        }
    }


    function deleteRecordClaimAndProject($transactionID)
    {
        $db = JFactory::getDBO();
        $sql = "SELECT * FROM #__transactions WHERE id='" . $transactionID . "'";
        $db->setQuery($sql);
        $getData = $db->loadObject();
        if (count($getData) > 0) {
            $sql = "DELETE FROM #__projects WHERE id='" . $getData->survey_id . "'";
            $db->setQuery($sql);
            $db->query();
            $sql = "DELETE FROM #__survey WHERE project_id='" . $getData->survey_id . "'";
            $db->setQuery($sql);
            $db->query();
        }
    }


    function deleteInProcessClaim($data)
    {
        $db = JFactory::getDBO();
        $flag = 0;
        $dataStringSend = explode(',', $data['string_send']);
        if (count($dataStringSend) > 0) {
            for ($i = 0; $i < count($dataStringSend); $i++) {
                $explodePostedVal = explode('@', $dataStringSend[$i]);
                if (count($explodePostedVal) == 4) {
					$sqlClaim = "SELECT report_type FROM #__survey WHERE id=".(int)$explodePostedVal[3];
					$db->setQuery($sqlClaim);
					$claimData = $db->loadObject();
					if(count($claimData)>0){
						$getQuestions = "SELECT id FROM #__question WHERE survey_id=".(int)$explodePostedVal[3];
						$db->setQuery($getQuestions);
						$questionsData = $db->loadObjectList();
						$questionIDs = array();
						if(count($questionsData)>0){
							foreach($questionsData as $ques){
								$questionIDs[] = $ques->id;
							}
						}
						if(count($questionIDs)>0){
							if($claimData->report_type == 2){
								 $sql = "DELETE FROM #__survey_question_answer WHERE expert_id='" . $explodePostedVal[2] . "' AND target ='" . $explodePostedVal[0] . "' AND target_product='".$explodePostedVal[1]."' AND ques_id IN (".implode(',',$questionIDs).")";
								 $db->setQuery($sql);
								 if ($db->query()) {
									 $sql = "DELETE FROM #__survey_amount_expert WHERE expert_id='" . $explodePostedVal[2] . "' AND target ='" . $explodePostedVal[0] . "'  AND target_product='".$explodePostedVal[1]."' AND survey_id = '" . $explodePostedVal[3] . "'";
									 $db->setQuery($sql);
									 $db->query();
									 $flag = 1;
								 }
							} else {
								$sql = "DELETE FROM #__survey_question_answer WHERE expert_id='" . $explodePostedVal[2] . "' AND target='' AND target_product='' AND ques_id IN (".implode(',',$questionIDs).")";
								$db->setQuery($sql);
								if ($db->query()) {
									 $sql = "DELETE FROM #__survey_amount_expert WHERE expert_id='" . $explodePostedVal[2] . "' AND target =''  AND target_product='' AND survey_id = '" . $explodePostedVal[3] . "'";
									 $db->setQuery($sql);
									 $db->query();
									 $flag = 1;
								 }
							}
						}						
					}
                } else {
                    $flag = 0;
                }
            }
        } else {
            $flag = 2;
        }
        return $flag;
    }
	
	function insertDataToTempTable($surveyData,$questionAnswerData){
		$db = JFactory::getDBO();
		$query = "INSERT INTO #__temp_survey_question_answer(project_id,survey_data,question_data) VALUES ('".$surveyData->project_id."','".json_encode($surveyData)."','".addslashes(json_encode($questionAnswerData))."')";
		$db->setQuery($query);
		if($db->query()){
			return $db->insertid();
		} else {
			return 0;
		}
	}
	
	function deleteSurveyReports($surveyData){
		$db = JFactory::getDBO();
		$query = "SELECT * FROM #__question WHERE survey_id=".(int)$surveyData->id;
		$db->setQuery($query);
		$getAllQuestions = $db->loadObjectList();
		$flag=0;
		if(count($getAllQuestions)>0){
			for($i=0;$i<count($getAllQuestions);$i++){
				$innerQuery = "DELETE FROM #__survey_question_answer WHERE ques_id=".(int)$getAllQuestions[$i]->id;
				$db->setQuery($innerQuery);
				if($db->query()){
					$questQuery = "DELETE FROM #__question WHERE id=".(int)$getAllQuestions[$i]->id;
					$db->setQuery($questQuery);
					if($db->query()){
						$flag=1;
					}
				}
			}
			if($flag==1){
				$surveyAnountQuery = "DELETE FROM #__survey_amount_expert WHERE survey_id=".(int)$surveyData->id;
				$db->setQuery($surveyAnountQuery);
				$db->query();
				$surveyQuery = "DELETE FROM #__survey WHERE id=".(int)$surveyData->id;
				$db->setQuery($surveyQuery);
				$db->query();
			}
		}
	}

    function getExpertReportsWithProject($expertID)
    {
        $db = JFactory::getDBO();
        $sql = "SELECT p.id as pID , p.name as projectName, p.type as pType FROM #__question as q LEFT JOIN #__survey as s ON s.id = q.survey_id LEFT JOIN #__projects as p ON p.id = s.project_id WHERE q.id IN(SELECT ques_id FROM `#__survey_question_answer` as qa WHERE showed=0 AND expert_id = '" . $expertID . "') GROUP BY p.id";
        $db->setQuery($sql);
        $getList = $db->loadObjectList();
        return $getList;
    }

    function getExpertReportsWithProjectName($projectName,$type)
    {
        $db = JFactory::getDBO();
        /*$sql = "SELECT p.id as pID , p.name as projectName FROM #__question as q LEFT JOIN #__survey as s ON s.id = q.survey_id LEFT JOIN #__projects as p ON p.id = s.project_id WHERE p.name='" . $projectName . "' GROUP BY p.id";
		*/
		$sql = "SELECT p.id as pID , p.name as projectName FROM #__projects as p WHERE p.name='" . $projectName . "' AND type=".$type;
        $db->setQuery($sql);
        $getData = $db->loadObject();
        return $getData;
    }

    function getAreaOfExpertise()
    {
        $db = JFactory::getDBO();
        $sql = "SELECT * FROM #__expertisearea ORDER BY name ASC";
        $db->setQuery($sql);
        return $db->loadObjectList();
    }

    function getExpertAreaOfExpertise($expertID)
    {
        $db = JFactory::getDBO();
        $sql = "SELECT ae.* , ea.name , ea.classification_description FROM #__map_area_expertise as ae INNER JOIN #__expertisearea as ea ON ea.id  = ae.area_id WHERE ae.expert_id='" . $expertID . "' ORDER BY ae.area_id ASC";
        $db->setQuery($sql);
        return $db->loadObjectList();
    }

    function deleteOldExpertArea($expertID)
    {
        $db = JFactory::getDBO();
        $sql = "DELETE FROM #__map_area_expertise WHERE expert_id='" . $expertID . "'";
        $db->setQuery($sql);
        $db->query();
    }

    function insertExpertArea($expertID, $areaID)
    {
        $db = JFactory::getDBO();
        $sql = "INSERT INTO #__map_area_expertise(`expert_id`,`area_id`)VALUES('" . $expertID . "','" . $areaID . "')";
        $db->setQuery($sql);
        $db->query();
    }
	
	function checkInsertExpertArea($expertID, $areaID, $type){
		if($expertID>0){
			$db = JFactory::getDBO();
			$sql = "SELECT * FROM #__map_area_expertise WHERE expert_id=".$expertID." AND area_id=".$areaID;
			$db->setQuery($sql);
			$getData = $db->loadObject();
			if($type==0){
				if(count($getData)==0){
					$sql = "INSERT INTO #__map_area_expertise(`expert_id`,`area_id`,`type`)VALUES('" . $expertID . "','" . $areaID . "','0')";
					$db->setQuery($sql);
					$db->query();
				} else {				
					echo $sql = "UPDATE #__map_area_expertise SET type='0' WHERE id='" . $getData->id . "'";
					$db->setQuery($sql);
					$db->query();
				}
			}
			$runChild = false;			
			if($type==1){
				$runChild = true;
				$sql = "DELETE FROM #__map_area_expertise WHERE area_id='" . $areaID . "'AND expert_id=".$expertID;
				$db->setQuery($sql);
				$db->query();
			}else if($type==2){
				$runChild = true;
				if(count($getData)>0){
					echo $sql = "UPDATE #__map_area_expertise SET type='1' WHERE id='" . $getData->id . "'";
					$db->setQuery($sql);
					$db->query();;
				} else {
					$sql = "INSERT INTO #__map_area_expertise(`expert_id`,`area_id`,`type`)VALUES('" . $expertID . "','" . $areaID . "','1')";
					$db->setQuery($sql);
					$db->query();
				}
			}
			if($runChild===true){
				$this->getChildListIDs(array($areaID));
				if(count($this->childIDs)>0){
					$sql = "DELETE FROM #__map_area_expertise  WHERE area_id IN (" . implode(',',$this->childIDs) . ") AND expert_id=".$expertID;
					$db->setQuery($sql);
					$db->query();
				}
			}			
		}		
	}
	public $childIDs = array();
	function getChildListIDs($ids){
		if(count($ids)>0){
			foreach($ids as $id){
				$getList = $this->getChildExpertise($id);
				if(count($getList)>0){
					$capNew = array();
					foreach($getList as $l){
						$capNew[] = $l->id;
						array_push($this->childIDs,$l->id);				
					}
					if(count($capNew)>0){
						$this->getChildListIDs($capNew);
					}
				}
			}
		}		
	}
	
	
	function checkDisplayInsertExpertArea($d){
		echo "<pre>";
		print_r($d);
		die;
	}

    function updateExpertDesc($data)
    {
        $db = JFactory::getDBO();
        $name = $data['f'] . " " . $data['l'];
		if((int) $data['pub']==1){
		/*
        $sql = 'UPDATE #__expert SET name="' . $name .
            '" , first_name="' . $data['f'] .
            '" , last_name = "' . $data['l'] .
            '" , company_name="' . $data['c'] .
            '" , description="' . addslashes($data['expl']) .
            '" , degree="' . $data['de'] .
            '" , phone="' . $data['p'] .
            '" , address="' . $data['a'] .
            '" , skype_name="' . $data['s'] .
            '" , hourly_rate="' . $data['h'] .
            '" , country="' . $data['co'] .
            '" , state="' . $data['st'] .
            '" , city="' . $data['ci'] .
            '" , zip="' . $data['zi'] .
            '" , membership="' . $data['me'] .
            '" , areas_of_expertise="' . $data['ae'] .
            '" , standards_groups="' . $data['sg'] .
            '" , cv="' . addslashes($data['cv']) .
            '" , profile_image_file_name="' . $data['img'] .
            '" , web="' . $data['w'] .
            '", email="' . $data['em'] .
            '" WHERE id="' . $data['d'] . '"';*/
		} else {
			//$sql = 'UPDATE #__expert SET text_data=';
		}
		$sql = "UPDATE #__expert SET text_data='".json_encode($data)."', pub='".$data['pub']."' WHERE id='" . $data['d'] . "'";
        $db->setQuery($sql);
        if ($db->query()) {
            if (!empty($data['pp'])) {
                $sql = "DELETE * FROM #__expert_payment WHERE expert_id='" . $data['d'] . "'";
                $db->setQuery($sql);
                $db->query();
                $sql = "INSERT INTO #__expert_payment(`expert_id`,`paypal_id`) VALUES ('" . $data['d'] . "','" . $data['pp'] . "')";
                $db->setQuery($sql);
                $db->query();
            }
            if (!empty($data['cu']) && !empty($data['pa'])) {
                $sql = "UPDATE #__expert SET password='" . md5($data['pa']) . "' WHERE password='" . md5($data['cu']) . "' AND expert_id='" . $data['d'] . "'";
                $db->setQuery($sql);
                if ($db->query()) {
                    $app = JFactory::getApplication();
                    $app->enqueueMessage('Password update successfully', 'message');
                } else {
                    $app = JFactory::getApplication();
                    $app->enqueueMessage('Current password not match', 'message');
                }
            }
            return 1;
        } else {
            return 0;
        }
    }
	
	function updateProfileUser($data){
		$db = JFactory::getDBO();
		$sql = "UPDATE #__expert SET description='".addslashes($data['expl'])."' WHERE id='" . $data['d'] . "'";
		$db->setQuery($sql);
		if ($db->query()) {
			return 1;
		} else {
            return 0;
        }
	}
	
	function update_user_nda($cid,$publish){
		if ($cid!=null){
			$query = 'UPDATE #__users'
               . ' SET nda = '.(int) $publish
               . ' WHERE id = ( '.$cid.' )';
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
	
	function updateExpertData($dataArray,$dataCondition){
		$updateField = "";
		$first_name = "";
		$last_name = "";
		foreach($dataArray as $key => $value){
			$updateField .= $key." ='".addslashes(trim($value))."',";
			if($key=="first_name"){
				$first_name = $value;
			}
			if($key=="last_name"){
				$last_name = $value;
			}
		}
		$updateField = substr($updateField,0,-1);
		$whereCondition ="";
		$i=0;
		foreach($dataCondition as $key => $value){
			if($i>0){
				$whereCondition .=" AND ";
			}
			$whereCondition .= $key." = '".$value."'";
			$i++;
		}
		if(!empty($whereCondition)){
			$sql = "UPDATE #__expert SET ".$updateField." WHERE ".$whereCondition;		
			$db = JFactory::getDBO();
			$db->setQuery($sql);
			if ($db->query()) {
				/*Check firstName and lastName and update in users*/
				/*echo $sql;*/
				if(!empty($first_name) && !empty($last_name)){
					$name = $first_name." ".$last_name;
					$sql = "UPDATE #__expert SET name='".addslashes($name)."' WHERE ".$whereCondition;	
					$db->setQuery($sql);
					$db->query();
					/*echo*/ $sql = "UPDATE #__users SET name='".addslashes($name)."' WHERE id=(SELECT user_id FROM #__expert WHERE ".$whereCondition.")";	
					$db->setQuery($sql);
					$db->query();
					/*echo*/ 
				}
				/*die;*/
				return 1;								
			} else {
				return 0;
			}
		} else {
			return 0;
		}
	}
	
	
    function getStateNameData($stateName)
    {
        $db = JFactory::getDBO();
        $sql = "SELECT * FROM #__countrystate WHERE parent = (SELECT id FROM #__countrystate WHERE name='" . $stateName . "')";
        $db->setQuery($sql);
        return $db->loadObjectList();
    }

    function getQuestionList($surveyID)
    {
        $db = JFactory::getDBO();
        $sql = "SELECT * FROM #__question WHERE survey_id='" . $surveyID . "' ORDER BY id ASC";
        $db->setQuery($sql);
        return $db->loadObjectList();
    }
	
	function retrieveProjectWithCode($code){
		 $db = JFactory::getDBO();
		 $sql = "SELECT s.* FROM #__survey as s WHERE s.project_id IN (SELECT p.id FROM #__projects as p INNER JOIN #__transactions as t ON p.id = t.survey_id WHERE p.code='" . $code . "' AND t.success='Paid' AND t.type=1)";
		$db->setQuery($sql);
		$list = $db->loadObjectList();
		if(count($list)>0){
			 return $list;
		 } else {
			  $sql = "SELECT s.* FROM #__survey as s INNER JOIN #__projects as p ON p.id = s.project_id INNER JOIN #__transactions as t ON p.id = t.survey_id  WHERE s.code='" . $code . "' AND t.success='Paid' AND t.type=1";
			  $db->setQuery($sql);
			  return $db->loadObjectList();
		 }		 
	}
	
	function insertNotification($surveyID,$expertID){
		$db = JFactory::getDBO();
		$sql = "INSERT INTO #__notification (`survey_id`,`expert_id`,`created_date`) VALUES ('".$surveyID."','".$expertID."','".date('Y-m-d H:i:s',strtotime('now'))."')";
		$db->setQuery($sql);
		$db->query();
	}
	
    function expertNotification($expertID)
    {
        $db = JFactory::getDBO();
        $sql = "SELECT n.* , s.name as surveyName , s.combine_name as combineName , s.id as surveyID,s.deadline,s.comment,s.target,s.avoided ,  p.name as projectName , p.id as pID,p.synpat_price, s.maximum_price_claim, s.minimum_price_claim, s.report_type, s.document_type,p.description as project_comment,s.document_evidence as supportingDocuments FROM `#__notification` as n INNER JOIN #__survey as s ON s.id = n.survey_id INNER JOIN #__projects as p ON p.id = s.project_id WHERE n.expert_id='" . $expertID . "' GROUP BY s.id ORDER BY n.id DESC";
        $db->setQuery($sql);
        return $db->loadObjectList();
    }
	
	

    function expertInProcessData($expertID)
    {
        $db = & JFactory::getDBO();
        $sql = "SELECT s.name as surveyName , s.combine_name as combineName , s.id as surveyID,s.deadline,s.comment,s.report_type,s.target,s.avoided,qa.created_date,qa.target as answerTarget,qa.target_product as answerTargetProduct ,  p.name as projectName , p.id as pID FROM #__survey as s LEFT JOIN #__projects as p ON p.id = s.project_id LEFT JOIN #__question as q ON q.survey_id = s.id LEFT JOIN #__survey_question_answer as qa ON qa.ques_id = q.id WHERE qa.expert_id='" . $expertID . "' AND qa.showed=1 GROUP BY qa.target,qa.target_product";
        $db->setQuery($sql);
        return $db->loadObjectList();
    }

    function getSurveyData($surveyID)
    {
        $db = & JFactory::getDBO();
        $sql = "SELECT * FROM #__survey WHERE id='" . $surveyID . "'";
        $db->setQuery($sql);
        return $db->loadObject();
    }

    function getClaimsFeedsItems()
    {
        $db = JFactory::getDBO();
        $getProjectID = JRequest::getVar('p_d');
        $sql = "";
        if (!empty($getProjectID)) {
            $sql = "SELECT p.* , s.combine_name as title , p.name as description, qa.target as target , qa.created_date as created , e.name as created_by_alias , e.name as author FROM #__projects as p INNER JOIN #__survey as s ON s.project_id = p.id INNER JOIN  #__question as q ON q.survey_id = s.id INNER JOIN #__survey_question_answer as qa ON qa.ques_id = q.id INNER JOIN #__expert as e ON e.id = qa.expert_id WHERE qa.showed = 0 AND e.published=1 AND p.id='" . $getProjectID . "' GROUP BY qa.expert_id, qa.target";
        } else {
            $sql = "SELECT p.* , s.combine_name as title , p.name as description, qa.target as target , qa.created_date as created , e.name as created_by_alias , e.name as author FROM #__projects as p INNER JOIN #__survey as s ON s.project_id = p.id INNER JOIN  #__question as q ON q.survey_id = s.id INNER JOIN #__survey_question_answer as qa ON qa.ques_id = q.id INNER JOIN #__expert as e ON e.id = qa.expert_id WHERE qa.showed = 0 AND e.published=1 GROUP BY qa.expert_id, qa.target";
        }
        $db->setQuery($sql);
        return $db->loadObjectList();
    }

    function getParentExpertise()
    {
        $db = JFactory::getDBO();
        $sql = "SELECT * FROM #__expertisearea WHERE parent=0 ORDER BY name ASC";
        $db->setQuery($sql);
        return $db->loadObjectList();
    }

    function getChildExpertise($parentID)
    {
        $db = JFactory::getDBO();
        $sql = "SELECT * FROM #__expertisearea WHERE parent='" . $parentID . "' ORDER BY name ASC";
        
		$db->setQuery($sql);
        return $db->loadObjectList();
    }

    function getCountryStateData($parent)
    {
        $db = JFactory::getDBO();
        if ($parent == 0) {
            $sql = "SELECT * FROM #__countrystate WHERE parent IS NULL ORDER BY name ASC";
        } else {
            $sql = "SELECT * FROM #__countrystate WHERE parent ='" . $parent . "' ORDER BY name ASC";
        }
        $db->setQuery($sql);
        return $db->loadObjectList();
    }

    function getExpertExpertiseArea($expertID)
    {
        $db = JFactory::getDBO();
        $sql = "SELECT * FROM #__map_area_expertise WHERE expert_id='" . $expertID . "'";
        $db->setQuery($sql);
        return $db->loadObjectList();
    }
	
	function getUserData($userID){
		$db = JFactory::getDBO();
		$sql = "SELECT * FROM #__users WHERE id='" . $userID. "'";
		$db->setQuery($sql);
		return $db->loadObject();
	}
	
	function expertUserData($expertID){
		$db = JFactory::getDBO();
		$sql = "SELECT * FROM #__expert WHERE user_id='" . $expertID. "'";
		$db->setQuery($sql);
		return $db->loadObject();
	}
	
	function expertUserDataWithID($ID){
		$db = JFactory::getDBO();
		$sql = "SELECT * FROM #__expert WHERE id='" . $ID. "'";
		$db->setQuery($sql);
		return $db->loadObject();
	}
	
	function getExpertPaypalData($expertID){
		$db =  JFactory::getDBO();
		$sql = "SELECT * FROM #__expert_payment WHERE expert_id='".$expertID."'";
		$db->setQuery($sql);
		return $db->loadObject();
	}
	
	function paymentData($paypalID,$expertID){
		$db =  JFactory::getDBO();
		$sql = "DELETE FROM #__expert_payment WHERE expert_id='".$expertID."'";
		$db->setQuery($sql);
		$db->query();		
		$sql = "INSERT INTO #__expert_payment (expert_id,paypal_id) VALUES ('".$expertID."','".$paypalID."')";
		$db->setQuery($sql);
		$db->query();		
	}
	
	function getPriorArtReport($expertID){
		$query = "SELECT sae.survey_id as id FROM #__survey_amount_expert as sae INNER JOIN #__survey as s ON s.id = sae.survey_id WHERE sae.expert_id='".$expertID."' AND sae.target='' AND sae.target_product='' AND s.report_type=1";
		$db =  JFactory::getDBO();
		$db->setQuery($query);
		return $db->loadObjectList();
	}

    function updateExpertLinkedInProfile($linkedin_profile_url, $linkedID, $profilePic, $expertID)
    {
        $db = JFactory::getDBO();
        $sql = "UPDATE #__expert SET linkedin_id='" . $linkedID . "' ,linkedin_pic = '" . $profilePic . "' ,linkedin_profile_url ='" . $linkedin_profile_url . "' WHERE id = '" . $expertID . "'";
        $db->setQuery($sql);
        if ($db->query()) {
            return 0;
        } else {
            return 1;
        }
    }
	
	function getExpertAreaFromParent($parentID){
		ini_set('max_execution_time', 360000);
		$items = array();		
		$getDataList = $this->getChildExpertise($parentID);			
		array_push($items, $parentID);			
		if(count($getDataList)>0){
			foreach($getDataList as $list) {
				$child_array = $this->getExpertAreaFromParent($list->id);							
				if(sizeof($child_array) >0) {
					array_push($items, array($child_array));
				}
			}			
		}
		return $items;
	}
	
	function getFirstMainAreaParent($userID){
		$db = JFactory::getDBO();
		$query = "SELECT * FROM #__map_area_expertise WHERE type=0 and expert_id=".(int) $userID ." ORDER BY area_id DESC LIMIT 0,1";
		$db->setQuery($query);
		$getData = $db->loadObject();
		if(count($getData)>0){
			$getData = $this->findExpertAreaParent($getData->area_id);
		}
		return $getData;
	}
	
	/*
		function getFirstMainAreaParent($userID,$childData){
		$db = JFactory::getDBO();
		$mainIds = array();
		if(is_array($childData) && count($childData)>0){
			foreach($childData as $child){
				array_push($mainIds,$child->id);
			}
		}

		if(count($mainIds)>0){
			echo $query = "SELECT * FROM #__map_area_expertise WHERE expert_id=".(int) $userID ." AND area_id IN(".implode(',',$mainIds).") ORDER BY area_id ASC LIMIT 0,1";
			$db->setQuery($query);
			$getData = $db->loadObjectList();
			return $getData;
		} else {
			return array();
		}		
	}
	*/
	
	function findExpert($searchData){
		$db = JFactory::getDBO();
		$conditions = array();
		if(!empty($searchData['first_name'])){
			$conditions['e.first_name']=' LIKE "%'.$searchData['first_name'].'%"';
			$conditions['u.name']=' LIKE "%'.$searchData['first_name'].'%"';
		}
		if(!empty($searchData['last_name'])){
			$conditions['e.last_name']= ' LIKE "%'.$searchData['last_name'].'%"';
			$conditions['u.name']=' LIKE "%'.$searchData['first_name'].'%"';
		}
		if(!empty($searchData['username'])){
			$conditions['u.username']= ' = "'.$searchData['username'].'"';
		}
		if(!empty($searchData['company_name'])){
			$conditions['e.company_name']= ' LIKE "%'.$searchData['company_name'].'%"';
		}
		$i=0;
		$condition = "";
		foreach($conditions as $key=>$value){
			$condition.= $key .$value;
			if($i<count($conditions)-1){
				$condition =$condition ." OR ";
			}
			$i++;
		}
		$sql = "SELECT count(*) as countData FROM #__expert as e INNER JOIN #__users as u ON u.id = e.user_id ";
		if(!empty($condition)){
			$sql = $sql." WHERE ".$condition;
		} 
		$db->setQuery($sql);
		$count = $db->loadObject();
		$sql = "SELECT e.*, u.username FROM #__expert as e INNER JOIN #__users as u ON u.id = e.user_id ";
		if(!empty($condition)){
			$sql = $sql." WHERE ".$condition;
		}
		$sql = $sql . " ORDER BY u.name ASC ";
		/*echo $sql;*/
		$db->setQuery($sql);
		$getList = $db->loadObjectList();
		return array('count'=>$count,'data'=>$getList);
	}
	
	public $cat = array();
	
	function findExpertAreaParent($areaID){
		$db = JFactory::getDBO();
		$query = "SELECT * FROM #__expertisearea WHERE id=".(int) $areaID ;
		$db->setQuery($query);
		$getData = $db->loadObject();
		if(count($getData)>0){
			array_push($this->cat,$getData->id);
			if((int)$getData->parent==0){
				return $this->cat;
			} else {				
				$query = "SELECT * FROM #__expertisearea WHERE id=".(int) $getData->parent ;
				$db->setQuery($query);
				$getData = $db->loadObject();
				if(count($getData)>0){
					array_push($this->cat,$getData->id);
					if((int)$getData->parent==0){						
						return $this->cat;
					} else {
						$getData = $this->findExpertAreaParent($getData->parent);
					}
				}				
			}
		}
		return $this->cat;
	}
	
	function getAgreementData($t){
		$db = JFactory::getDBO();
        $sql = "SELECT content FROM #__agreement WHERE type=".$t;
        $db->setQuery($sql);
        return $db->loadObject();
	}
	
	function search_ipc($search){
		$db = JFactory::getDBO();
		$query = "SELECT * FROM #__expertisearea WHERE classification_description LIKE '%".$search."%'" ;
		$db->setQuery($query);
		$getSearchResult =  $db->loadObjectList();
		if(count($getSearchResult)>0){
			$i=0;
			foreach($getSearchResult as $result){
				$this->cat = array();
				$getParentList = $this->findExpertAreaParent($result->id);
				if(count($getParentList)>0){
					$getParentData = array();
					foreach($getParentList as $p){
						$queryParentsData = "SELECT * FROM #__expertisearea WHERE id = ".$p ;
						$db->setQuery($queryParentsData);
						$getParentData[] =  $db->loadObject();
					}
					$getParentList = $getParentData;
				}
				/*Find Siblings*/ 
				$siblings = array();
				/*if($result->parent>0){
					$querySiblingsData = "SELECT * FROM #__expertisearea WHERE parent = ".$result->parent ;
					$db->setQuery($querySiblingsData);
					$siblings =  $db->loadObjectList();
				}*/
				$getSearchResult[$i]->parent_list = $getParentList;
				$getSearchResult[$i]->siblings_list = $siblings;
				$i++;
			}
		}
		return $getSearchResult;
	}
	
	function getProjectDataFromSurvey($surveyID){
		$db = JFactory::getDBO();
		$query = "SELECT * FROM #__projects WHERE id IN (SELECT project_id FROM #__survey WHERE id='".$surveyID."')" ;
		$db->setQuery($query);
		$getData = $db->loadObject();
		return $getData;
	}
	
	function updateAllSurveyByProjectID($deadline,$target,$avoided,$comment,$maxPriceClaim,$projectID){
		$db = JFactory::getDBO();
		$query = "UPDATE #__survey SET maximum_price_claim='".$maxPriceClaim."', deadline='".$deadline."', target='".addslashes($target)."',document_evidence='".$avoided."',comment='".addslashes($comment)."' WHERE project_id=".$projectID;
		$db->setQuery($query);
		if($db->query()){
			return 1;
		} else {
			return 0;
		}
	}
	
	function getProjectData($projectID){
		$db = JFactory::getDBO();
		$query = "SELECT * FROM #__projects WHERE id ='".$projectID."'" ;
		$db->setQuery($query);
		$getData = $db->loadObject();
		return $getData;
	}
	
	function getSurveyDataFromProject($projectID){
		$db = JFactory::getDBO();
		$query = "SELECT * FROM #__survey WHERE project_id='".$projectID."'" ;
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
	/*Backyard*/
	function getLeadData($leadID){
	   $option = $this->getBackyardCredential();
	   $db = JDatabase::getInstance( $option );
	   $query = "SELECT id, lead_name FROM litigations WHERE id=".$leadID;
	   $db->setQuery($query);
	   $getLeadData = $db->loadObject();
	   return $getLeadData;
	}
	
	function getPatentListFromBackyard($leadID){
		$option = $this->getBackyardCredential();
		$db = JDatabase::getInstance( $option );
		$query = "SELECT patent_number FROM lead_patent WHERE lead_id=".$leadID;
		$db->setQuery($query);
		$getLeadData = $db->loadObjectList();
		return $getLeadData;
	}
	
	function updateOrderName($orderName,$leadID,$type){
		$option = $this->getBackyardCredential();
		$db = JDatabase::getInstance( $option );
		$query = "UPDATE acquisition SET order_name='".$orderName."'  WHERE lead_id=".$leadID;
		$db->setQuery($query);
		if ($db->query()) {
            return 0;
        } else {
            return 1;
        }
	}
	
	function findSurveyDataByClaimNumber($patentNumber){
		$query = "SELECT count(id) as countClaims FROM #__survey WHERE name='".$patentNumber."'";
		$db = JFactory::getDbo();
		$db->setQuery($query);
		return $db->loadObject();
	}
	
	function insertSurveyBulk($surveyList,$projectID){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$columns = array();
		$columnValues = array();
		if(count($surveyList)>0){
			$i = 0;
			$stringName = array();
			foreach($surveyList as $list){
				$stringValue = array();
				foreach($list as $key=>$value){	
					if($i==0){
						$stringName[]= $key;
					}
					$stringValue[] = $db->quote($value);
				}
				$i++;
				$stringValue = implode(',',$stringValue);
				$columnValues[] = $stringValue;
			}
			$columns = implode(',',$stringName);
			$query->insert($db->quoteName('#__survey'));
			$query->columns($columns);
			$query->values($columnValues);
			$db->setQuery($query);
			$db->query();
		}
		$query = "SELECT count(*) as surveyCount FROM #__survey WHERE project_id=".$projectID;
		$db->setQuery($query);
		return $db->loadObject();
	}
	
	function deleteSurvey($surveyID){
		$query = "DELETE FROM #__survey WHERE id=".$surveyID;
		$db = JFactory::getDbo();
		$db->setQuery($query);
		try{
			$db->query();
		}catch(Exception $e){
			
		}
		return $db->getAffectedRows();
	}
	
	function deleteExpert($expertID){
		$query = "SELECT count(id) as reports FROM #__survey_amount_expert WHERE expert_id=".$expertID;
		$db = JFactory::getDbo();
		$db->setQuery($query);
		$data = array('affected'=>0,'error'=>'');
		try{
			$loadData = $db->loadObject();
			if($loadData->reports==null || $loadData->reports==0){
				$query = "SELECT user_id FROM #__expert WHERE id=".$expertID;
				$db->setQuery($query);
				$loadExpertData = $db->loadObject();
				if(count($loadExpertData)>0){
					$queryUserDelete = "DELETE FROM #__users WHERE id=".$loadExpertData->user_id;
					$db->setQuery($queryUserDelete);
					if($db->query()){
						$data['affected'] = $db->getAffectedRows();
						$queryExpertDelete = "DELETE FROM #__expert WHERE id=".$expertID;
						$db->setQuery($queryExpertDelete);
						$db->query();
					} else {
						$data['error'] = "System not able to delete user.";
					}
				} else {
					$data['error'] = "No user found.";
				}
			}else {
				$data['error'] = "Cannot delete this expert.";
			}
		}catch(Exception $e){
			$data['error'] = "Error in deletion function.";
		}
		return $data;
	}
	
	function getNotifcationData($allIDs,$userID){
		$db = JFactory::getDbo();
		$sql = "SELECT count(*) as notify FROM #__notification WHERE expert_id=".$userID." AND survey_id IN (".implode(',',$allIDs).")";
	    $db->setQuery($sql);
	    return $db->loadObject();
	}
	
	function insertNotificationBulk($allIDs,$userID){
		$queryInsert = "INSERT INTO #__notification (`survey_id`,`expert_id`,`created_date`) VALUES ";
		foreach($allIDs as $surveyID){
		   $queryInsert .="(".$surveyID.",".$userID.",'".date('Y-m-d H:i:s',strtotime('now'))."'), ";
		}
		$queryInsert = substr($queryInsert,0,-2);
		try{
		   $db = JFactory::getDbo();
		   $db->setQuery($queryInsert);
		   $db->query();
		}catch(Exception $e){}
		return $this->getNotifcationData($allIDs,$userID);
	}
	
	function addNotificationToAllExperts($projectID){
		$db = JFactory::getDbo();
		$query = "SELECT id FROM #__survey WHERE project_id=".$projectID;
		$db->setQuery($query);
		$allSurveyList = $db->loadObjectList();
		$getAllExperts = "SELECT u.id as userID FROM #__users as u INNER JOIN #__expert as e ON e.user_id = u.id";
		$db->setQuery($getAllExperts);
		$allExperts = $db->loadObjectList();
		if(count($allSurveyList)>0 && count($allExperts)>0){
			$date = date('Y-m-d H:i:s',strtotime('now'));
			$queryInsert = "INSERT INTO #__notification (`survey_id`,`expert_id`,`created_date`) VALUES ";
			foreach($allSurveyList as $survey){
				foreach($allExperts as $expert){
					$queryInsert .="(".$survey->id.",".$expert->userID.",'".$date."'), ";
				}
			}
			$queryInsert = substr($queryInsert,0,-2);
			try{
			   $db->setQuery($queryInsert);
			   $db->query();
			}catch(Exception $e){}
		}
	}
}
