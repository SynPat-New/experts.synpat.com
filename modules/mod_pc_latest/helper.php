<?php

defined( '_JEXEC' ) or die( 'Restricted access' );
require_once( JPATH_ROOT.DS."components".DS."com_survey".DS."models".DS."customer.php" );
class mod_pc_latestHelper{	
	
	function getPCLModData($projectName){		
		$getAllData = array();
		$customer = new SurveyModelCustomer();
		//$projectName ="";
		if(!empty($projectName)){	
			$projectData = $customer->checkProjectWithName($projectName);
		} else {	
			$projectData = $customer->getProjectNameFromLatestReport();
		}
		if(count($projectData)>0 && isset($projectData[0]->id)){	
			$getSurveyData = $customer->findSurveyDataFromLatestReportByProjectID($projectData[0]->id);	
			$getRemainingData = array();
			if(count($getSurveyData)){	
				$getRemainingData = $customer->quList($getSurveyData->id);	
				if(count($getRemainingData)>0){		
					$getAllData = array('Project'=>$projectData[0],'Survey'=>$getSurveyData,'Question'=>$getRemainingData['question'],'Expert'=>$getRemainingData['expert'],'SurveyAmount'=>$getRemainingData['survey']);
				}
			}
		}
		return $getAllData;
	}
	
	function expertRatingData($expertID){	
		$customer = new SurveyModelCustomer();	
		return $customer->expertRatingData($expertID);
	}
}
?>
