<?php
// Include dependancy of the main controllerform class
jimport('joomla.application.component.controllerform');
class SurveyControllerApi extends JControllerForm
{
   function orderList(){
        $model  = $this->getModel('api');
        $getList = $model->getOrderList();
        echo json_encode($getList);
        die;
   }
   
    function projectList(){
        $model  = $this->getModel('api');
        $getList = $model->getProjectList();
        echo json_encode($getList);
        die;
   }
   
   function discountList(){
	   $getDiscountList = $this->getModel('api')->getDiscountList();
	   echo json_encode($getDiscountList);
	   die;	   
   }
   
   function add_discount(){
	   $getData = $this->getModel('api')->addDiscount();
	   echo $getData;
	   die;
   }
   
   
   function expertArea(){
	   $getData = $this->getModel('api')->getParentExpertise();
	   echo json_encode($getData);
	   die;
   }
   
   function surveyList($id=null){
    $model  = $this->getModel('api');
    $getList = $model->getSurveyList($id);
    echo json_encode($getList);
    die;
   }
   
   
   
   function NewExpert(){
    $model = $this->getModel('api');
    $getList = $model->NewExpertAdd();
    echo json_encode($getList);
    die;
   }
   function expert_publish($cid=null){
    $model  = $this->getModel('api');
    $getList = $model->publish_list($cid,1);
    echo json_encode($getList);
    die;
   }
   function expert_unpublish($cid=null){
    $model  = $this->getModel('api');
    $getList = $model->publish_list($cid,0);
    echo json_encode($getList);
    die;
   }
   
   function expert_see_list(){
	   $cid = JRequest::getVar('cid');
	   $t = JRequest::getVar('t');
	    $model  = $this->getModel('api');
		$getList = $model->expert_see_list($cid,$t);
		echo json_encode($getList);
		die;
   }
   
	function agreement(){
		$t = JRequest::getVar('p');
		$model  = $this->getModel('api');
		$getData = $model->agreement($t);
		echo json_encode($getData);
		die;
	}
	
	function save_agreement(){
		$model  = $this->getModel('api');
		$data = $_REQUEST;
		$getList = $model->updateAgreement($data);
		echo $getList;
		die;
	}
   
   function saveExpertDetail(){
    
    $model  = $this->getModel('api');
    $getList = $model->saveExpertDetail();
    echo json_encode($getList);
    die;
   }
   function saveUser(){		
		$model  = $this->getModel('api');
		$getList = $model->saveUser();
		echo json_encode($getList);
		die;
   }
   function deleteFeedback($cid){
    $cid = JRequest::getVar('cid');
    $model  = $this->getModel('api');
	$getList = $model->deleteFeedback($cid);
    echo json_encode($getList);
    die;
   }
   function expertEdit($id = null){
        $model = $this->getModel('api');
        $getList = $model->getExpertDetail($id);
        echo json_encode($getList);
        die;
   }
   
   function viewactivity(){
		$model  = $this->getModel('api');
		$post = JRequest::get('post');
		$expertID=$post['expertID'];
		$surveyID=$post['surveyID'];
		$target=$post['target'];
		$targetProduct=$post['target_product'];
		$reportType=$post['report_type'];
		$getList = $model->expertCombineActivityReportListData($expertID,$surveyID,$target,$targetProduct,$reportType);
		echo json_encode($getList);
        die;
   }
   
   function add_new_claims(){
		$count = 0;
	   $postData = JRequest::get('post');
	   $modelApi = $this->getModel('api');
	   $getSurveyList = $modelApi->getSurveyListByProjectID($postData['project_id']);
	   $getProjectData = $this->getModel('customer')->getProjectData($postData['project_id']);
	   if(count($getSurveyList)>0){
		   $findSurvey = (object) $getSurveyList[0];
		    $survey = array();
			$surveyCode = $this->getNewSerialNumber(0,$this->generateRandomString());
		    $survey[] = array('name' => $postData['claim'],
					'project_id' => $postData['project_id'], 
					'combine_name' => $postData['claim'],
					'exclude' => 2,
					'document_type'=>(int)1,
					'report_type'=>$findSurvey->report_type,
					'comment' => $findSurvey->comment,
					'target' =>$findSurvey->target,
					'avoided'=>$findSurvey->avoided,
					'deadline' => $findSurvey->deadline,'maximum_price_claim'=>$findSurvey->maximum_price_claim,
					'specific_expert'=>$findSurvey->specific_expert,'minimum_price_claim'=>0,
					'email_sms'=>$findSurvey->email_sms,
					'payment_type'=>$findSurvey->payment_type,
					'code'=>$surveyCode);
	    
			$insertSurveyBulk = $this->getModel('customer')->insertSurveyBulk($survey,$postData['project_id']);
			$count = $insertSurveyBulk->surveyCount;
	   }
	   echo $count;
	   die;
   }
   
   function getNewSerialNumber($flag=0,$serialNumber,$type=1){
		if($flag==1){
			$serialNumber = $this->generateRandomString(5);
		}		
		$checkSerialNumber = $this->getModel('customer')->findSerialNumber($serialNumber,$type);
		
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
   
	function expert_mass_payment(){
		$model = $this->getModel('api');
		$postData = JRequest::get('post');
		$data = array('message'=>'');
		if(isset($postData['user_payment_data']) && $postData['user_payment_data']!=''){
			try{
				$userList = json_decode($postData['user_payment_data'],true);
				if(count($userList)>0){
					$updateAll = 0;
					for($i=0;$i<count($userList);$i++){
						$insertID = $model->insertExpertMassPayment(array('expert_id'=>$userList[$i]['expert_id'],'survey_id'=>$userList[$i]['survey_id'],'report_id'=>$userList[$i]['report_id'],'amount'=>$userList[$i]['amount'],'busness_email'=>$userList[$i]['busness_email'],'message'=>$userList[$i]['message'],'error_code'=>$userList[$i]['error_code'],'create_date'=>$userList[$i]['create_date'],'payment_timestamp'=>$userList[$i]['payment_timestamp'],'correlationid'=>$userList[$i]['correlationid'],'build'=>$userList[$i]['build']));
						$update = 0;
						if($userList[$i]['payment_done']==1){
							/*Payment Successful, Change status of paid in report*/
							$update = $model->updateReportPaidStatus($userList[$i]['payment_done'],$userList[$i]['report_id'],$userList[$i]['expert_id']);
						}
						if($insertID==true){
							$updateAll++;
						}
					}
					if($updateAll==count($userList)){
						$data['message'] = "Amount paid successfully.";
					} else {
						$data['message'] = "Error allocating funds.";
					}
				} else {
					$data['message'] = "Data is not in a proper format.";
				}
			}catch(Exception $e){
				$data['message'] = "Data is not in a proper format.";
			}
		} else {
			$data['message'] = "Data is corrupted.";
		}
		echo json_encode($data);
		die;
	}
	
	
   function viewreport(){
    $model  = $this->getModel('api');
	$post = JRequest::get('post');
	$expert_id=$post['expertID'];
	$surveyID=$post['surveyID'];
	$target=$post['target'];
	$target_product=$post['target_product'];
	$getSurveDetail = $model->surveyDetail($surveyID);
	$fileName = "";
	$html="";
	if(count($getSurveDetail)>0){		
		$checkReport = $model->getPriceSetByExpertForSurvey($expert_id,$surveyID,$target,$target_product,$getSurveDetail->exclude);	
		if(count($checkReport)>0){
			if(trim($checkReport->file_name)!=''){
				$fileName = $checkReport->file_name;
				$pathInfo = pathinfo($fileName);
				$fileName = JUri::base()."components".DS."com_survey".DS."reports".DS.$pathInfo['basename'];
			} else {
				$getExpertDetail = $model->expertData($expert_id);
				$fileName = "";
				if(count($getExpertDetail)>0){
					$name = $getExpertDetail->name;
					$getExpertData = $model->expertData($expert_id);
					$username = $getExpertData->username;
					$emailAddress = $getExpertData->email;
					$fileName = $name.'_'.$getSurveDetail->combine_name.'_'.$target.' '.$target_product.'_'.$emailAddress;
					/*$fileName = $name.'_'.$getSurveDetail->combine_name.'_'.$target_product;    */
				}
				if(!empty($fileName)){
					if(!file_exists(JPATH_COMPONENT.DS."reports".DS.$fileName.".pdf")){
						$fileName="";
					} else {
						/*$fileName = JPATH_COMPONENT.DS."reports".DS.$fileName.".pdf";*/
						$fileName = JUri::base()."components".DS."com_survey".DS."reports".DS.$fileName.".pdf";
						$query = "UPDATE #__survey_amount_expert SET file_name='".$fileName."' WHERE expert_id=".(int)$expert_id." AND survey_id=".(int)$surveyID." AND target='".$target."' AND target_product='".$target_product."'";
						$db = JFactory::getDBO();
						$db->setQuery($query);
						 $db->query();
						 
					}
				}
			} 
		}
		if(empty($fileName)){			
			$getSurevyData = (object)array('survey_id'=>$surveyID,'expert_id'=>$expert_id,'target'=>$target,'target_product'=>$target_product);
			$getSurveyInfo = $getSurveDetail;
			
			if($getSurveyInfo->report_type==2){
				$getQueAnsData = $model->getQueAnsData($getSurevyData->survey_id, $getSurevyData->expert_id, $getSurevyData->target, $getSurevyData->target_product);
			} else {
				$getQueAnsData = $model->getQueAnsDataPrior($getSurevyData->survey_id, $getSurevyData->expert_id);
			}
            
            $getExpertData = $model->expertData($getSurevyData->expert_id);
            
		    $patentNumber = "";
            $claimNumber = "";
            if (count($getSurveyInfo) > 0) {
                $claimNumber = substr($getSurveyInfo->combine_name, strlen($getSurveyInfo->combine_name) - 3);
                $patentNumber = $getSurveyInfo->name;
				if(stripos(strtoUpper(strtolower($patentNumber)),"US")===false){
					$patentNumber = "US" . $getSurveyInfo->name;
				}
            }
            if((int)$getExpertData->expert_type==2){
				$name = $getExpertData->company_name;
			} else {
				$name = $getExpertData->name;
			}

			preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $getExpertData->profile_desc, $matches);
			$profileImage = $matches[1][0];
            if ($profileImage == "") {
                $profileImage = 'http://placehold.it/120x120';
            }
            $profileUrl = $getExpertData->linkedin_profile_url;
            if (count($getQueAnsData) > 0) {
                $expertRatingData = $model->expertRatingData($getSurevyData->expert_id);
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
					/*if((int)$getSurveyInfo->exclude==1){
						
						$saveData = $this->getModel()->insertDataToTempTable($getSurveyInfo,$getQueAnsData);
						if($saveData>0){
							$this->getModel()->deleteSurveyReports($getSurveyInfo);
						}						
						
						$flag = 1;
					}*/
					
                    $URL = JUri::base() . 'index.php/feedback?display=' . $urlQueryString;					
					
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
				</style>
				<style type="text/css">
					body {
						background-color: #ffffff;
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
											<img src="' . $profileImage . '" style="width: 120px;" /></td>
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
								<h3>Patent Number: ' . $patentNumber . '</h3>
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
			$file = JPATH_LIBRARIES . '/pdflayer.class.php';
			if (!JFile::exists($file)) {
				return false;
			}
			require_once($file);	
					try
					{
						$html2pdf = new pdflayer();
						$html2pdf->set_param('document_html',$html);
						$html2pdf->convert();
						$random = $name.'_'.$getSurveDetail->combine_name.'_'.$target.' '.$target_product.'_'.$getExpertData->email;						
						$fileName = JPATH_COMPONENT.DS."reports".DS.$random.".pdf";
						file_put_contents($fileName, $html2pdf->pdf);
						$query = "UPDATE #__survey_amount_expert SET file_name='".$fileName."' WHERE expert_id=".(int)$getSurevyData->expert_id." AND survey_id=".(int)$getSurevyData->survey_id." AND target='".$getSurevyData->target."' AND target_product='".$getSurevyData->target_product."'";
						$db = JFactory::getDBO();
						$db->setQuery($query);
						$db->query();
						$html2pdf->download_pdf();
						$fileName = JUri::base()."components".DS."com_survey".DS."reports".DS.$random.".pdf";
					}catch(Exception $e)
					{
						
					}
		}
			}
		}
	}
	/*$getList = $model->getViewReport($expert_id=null,$surveyID=null);*/
    /*echo json_encode(array('file_name'=>$fileName,'html'=>$html));*/
	
	echo $fileName;
    die;
   }
   function questionList($id=null){
        $model  = $this->getModel('api');
        $getList = $model->getQuestionList($id=null);
        echo json_encode($getList);
        die;
   }
   function feedback($id=null){
        $model  = $this->getModel('api');
        $getList = $model->getFeedback($id=null);
        echo json_encode($getList);
        die;
   }
   function emailView(){
        $model  = $this->getModel('api');
        $getList = $model->getEmail($surveyID=null);
        echo json_encode($getList);
        die;
   }
   function findExpertWithCode($code=null,$mode=null)
   {
        $model  = $this->getModel('api');
        $getList = $model->findExpertWithCode($code,$mode);
    //    echo json_encode($getList);
        //print_r($getList);
     //   die;
    
		if($data['mode']==2){
			echo json_encode($getList);
		} else {
			echo json_encode(array('count'=>$getList));	
		}
		die;
   }

   
   function deleteQuestionare($surveyID=null){
        $model = $this->getModel('api');
        $getList = $model->getDeleteQuestionare($surveyID=null);
        echo json_encode($getList);
        die;
   }
   
   function saveQus(){
        $model = $this->getModel('api');
        $getList = $model->getSaveQus();
        echo $getList;
		die;
    }
	
	function getPaypalData(){
		$getData = $this->getModel('api')->getPaypalData();
		echo json_encode($getData);
		die;
	}
	
	function getPaypalUpdate(){
		$this->getModel('api')->getPaypalUpdate();
		die;
	}
   
   function cancelQus(){
        $model = $this->getModel('api');
        $getList = $model->getCancelQus($surveyID=null);
        json_encode($getList);
        die;
   }
   
   function start_questionare($survey_id=null){
        $model = $this->getModel('api'); 
        $getList = $model->start_questionare($survey_id);
        echo json_encode($getList);
        die;
   }
   function emailSend($post= null){
		$model = $this->getModel('api');
        $getList = $model->emailSend();
        echo json_encode($getList);
        die;
   }
   
   function emailMSend($post= null){
		$model = $this->getModel('api');
        $getList = $model->emailMSend();
        echo json_encode($getList);
        die;
   }
   
   function addTemplate(){
	   $model = $this->getModel('api');
       $getList = $model->addTemplate();
       echo json_encode($getList);
       die;
   }
   function getAllTemplates(){
	   $model = $this->getModel('api');
       $getList = $model->getAllTemplates();
       echo json_encode($getList);
       die;
   }
   
   function expertList(){
        $model  = $this->getModel('api');
        $getList = $model->getExpertList();
        echo json_encode($getList);
        die;
   }
   
   function reportList(){
        $model  = $this->getModel('api');
        $getList = $model->getReportList(); 
		echo json_encode($getList);
        die;
   }
	function unpaid_expert_report_list(){
		 $model  = $this->getModel('api');
     $getList = $model->getUnpaidExpertReportList(); 
     echo json_encode($getList);
     die;
	}
   function update_report_price(){
	    $model  = $this->getModel('api');
		$getList = $model->update_report_price();
		echo json_encode($getList);
		die;
   }
   function show_report_price(){
	    $model  = $this->getModel('api');
		$getList = $model->show_report_price();
		echo json_encode($getList);
		die;
   }
   function findNewReports(){
	    $model  = $this->getModel('api');
		$getCount = $model->findNewReports();
		echo json_encode($getCount);
		die;
   }
}