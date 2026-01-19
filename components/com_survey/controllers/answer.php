<?php

// No direct access.
defined('_JEXEC') or die;

// Include dependancy of the main controllerform class
jimport('joomla.application.component.controllerform');

class SurveyControllerAnswer extends JControllerForm
{
	
	
	public function getModel($name = 'Answer', $prefix = '', $config = array('ignore_request' => true))
	{
		return parent::getModel($name, $prefix, array('ignore_request' => false));
	}

	public function save()
	{
		// Check for request forgeries.
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));;
		// Initialise variables.
		$app	= JFactory::getApplication();
		$model	= $this->getModel();
		// Get the data from the form POST
		$data = JRequest::get('post');	

		$getSurveyDetails = $model->surveyData($data['survey_id']);
		$extenstion = array('jpg','jpeg','png');
		$alQuestion = base64_decode($data['to_data']);
		$questions = explode(',',$alQuestion );
		$error = 0;
		$rr=1;
		$showedAns = 1;
		if(isset($data['ans_status'])){
			$showedAns = $data['ans_status'];
		}
		$allIDs = array();
		if(count($questions)>0){
			for($i=0;$i<count($questions);$i++){
				if((int)$questions[$i]!=0){
					/* Checking answer given by the expert in past*/
					$variable = base64_encode('data_'.$questions[$i]);
					$answer = array();
					$answer['answer']  =JRequest::getVar( $variable, '', 'post', 'string', JREQUEST_ALLOWRAW );
					/*
					$answer['answer']  =$data[$variable];*/
					$answer['ques_id']  =$questions[$i];
					$answer['expert_id']=$data['expert_id'];
					$answer['target'] = trim($data['target']);
					$answer['showed'] = $showedAns;
					/*Check supporting Document*/
					jimport('joomla.filesystem.file');
					$docFile = JRequest::getVar('file_'.$questions[$i], null, 'files','array');									
					if(JFile::makeSafe($docFile['name'])!=""){
						$filename = JFile::makeSafe($docFile['name']);
						$src = $docFile['tmp_name'];
						$ext =  JFile::getExt($filename);
						if(in_array($ext,$extenstion)){
							$timeR = time().rand(100000,1000000000);
							$newname = str_replace($ext,$timeR,$filename).".".$ext;
							$dest = JPATH_COMPONENT.DS."document".DS.$newname;
							if ( JFile::upload($src, $dest) ) {
								$answer['supporting_document']= $newname;
							}
						}								
					}
					if(isset($data['publish_'.$questions[$i]]) && (int)$data['publish_'.$questions[$i]]==1){
						$answer['status']= 1;
					} else {
						$answer['status']= 0;
					}
					/*End Checking Supporting Document*/
					if($getSurveyDetails->report_type==2){
						$dataCheck  = $model->checkAnswerByExpert($questions[$i],$data['expert_id'],trim($data['target']),trim($data['target_product']));
					} else {
						$dataCheck  = $model->checkAnswerByExpertPrior($questions[$i],$data['expert_id']);
					}
					/* End checking*/
					if(count($dataCheck)>0){							
						$answer['id']= $dataCheck->id;
					} else {
						$answer['id']=0;
					}
					
					if($data['ans_status']==0){
						$answer['notify'] = 1;
						if($data['report_option_type']==1){
							$answer['show'] = 1;
						}						
					} else {
						$answer['show'] = 0;
					}
					$answer['created_date'] = date('Y-m-d H:i:s',strtotime('now'));
					$answer['posted_date'] = date('Y-m-d H:i:s',strtotime('now'));
					$answer['target_product'] = trim($data['target_product']); 
					$savedID = $model->save($answer);
					/* Save Survey Amount and Paypal ID*/
					/* End Save*/
					if($savedID>0){
						$allIDs[] = $savedID;
						/**/
						if($i==0){
							if($answer['showed']=="0"){
								$rr=0;
							}
						}						
						$error =1;
					}		
				}				
			}
		}
		/*die;*/
		/*if(!empty($data['paypal_id'])){
			$model->paymentData($data['paypal_id'],$data['expert_id']);
		}*/
		if(!empty($data['amount']) && (int) $data['amount']){
			$runReport=3;
			$reportOptionType = $data['report_option_type'];
			if($reportOptionType==2){
				/*Get price set by synpat*/
				 $projectData = $this->getModel()->getProjectDetailFromSurvey($data['survey_id']);
				 $data['amount'] = $projectData->synpat_price;
			}
			$amount = $data['amount'];
			$nf = new NumberFormatter("en_EN", NumberFormatter::DECIMAL);
			$amount = $nf->parse($amount, NumberFormatter::TYPE_INT32);
			$data['amount'] = $amount;
			$surveyData = $this->getModel()->surveyData($data['survey_id']);
			if($surveyData->report_type==2){
				$surveyAmtData= $this->getModel()->surveyAmtData($data['expert_id'],(int)$data['survey_id'], trim($data['target']),trim($data['target_product']));
			} else {
				$surveyAmtData= $this->getModel()->surveyAmtDataPrior($data['expert_id'],(int)$data['survey_id']);
			}			
			/*if(count($surveyAmtData)>0){
				if($surveyAmtData->run_report>0){				
					$runReport= $surveyAmtData->run_report-1;					
				} else{					
					$runReport=$surveyAmtData->run_report;
				}
			}*/
			$getLastID = $model->surveyAmount((int)$data['amount'],$data['expert_id'],$data['survey_id'],trim($data['target']),trim($data['target_product']),$runReport,$reportOptionType);
			if((int)$data['ans_status']==0){
				/*send Notification to backyard*/
				$this->sendNotificationToBackyard(array('action'=>'claimchart_new_report','id'=>0,'d_d'=>'New Report','type'=>0));
				/**/
				/*echo "<pre>";
				print_r($surveyAmtData);
				echo "</pre>";*/
				if(count($surveyAmtData)>0){
					if($surveyAmtData->run_report>0){	
						$runReport = (int)$surveyAmtData->run_report-1;	
					} else {
						$runReport=$surveyAmtData->run_report;
					}
					if($getLastID>0){
						$model->updateEditReport($runReport,$getLastID);
					}
				}
			}
			/*die;*/
			if(count($surveyAmtData)>0){
				if((int)$surveyAmtData->specific_amount>0){
					$model->updateEditReportSpecificAmount($surveyAmtData->specific_amount,$getLastID);
				}
			}
		}	
        $getProjectData = $model->getProjectDetailFromSurvey($data['survey_id']);       
        if ($error==1) {
			$ps ="";
            $message = "";
			
			
			
			$config = JFactory::getConfig();
			$encryptPassword = $config->getValue( 'synpat_symbol' );
			$display = openssl_encrypt($data['expert_id'],"AES-128-ECB",$encryptPassword);
			
            if((int)$data['ans_status']==0){
				/*Notify to admin*/
				$fileReturn ='';
				if(count($getProjectData)>0){
					if($getProjectData->report_type==2){
						$fileReturn = $this->downloadReport($data['survey_id'],$data['expert_id'],trim($data['target']),trim($data['target_product']));
					} else {
						$fileReturn = $this->downloadReport($data['survey_id'],$data['expert_id']);
					}					
				}
				$message = "Thank you for submit your report";
				if(count($allIDs)>0 && $showedAns==0){
					sleep(3);
					$model->allAnswerChangeToReport($allIDs,$showedAns);
				}
				/*$app->redirect('index.php?option=com_survey&task=customer.expertReport&display='.$data['expert_id'].'&show=5&sla='.base64_encode($fileReturn),$message,'success');*/
				$app->redirect('index.php?option=com_survey&task=customer.expertReport&display='.$display.'&show=5&sla='.base64_encode($fileReturn));
			}  else {
				/*$app->redirect('index.php?option=com_survey&task=customer.expertProcess&display='.$data['expert_id'].'&show=5',$message,'success');*/
				$app->redirect('index.php?option=com_survey&task=customer.expertProcess&display='.$display.'&show=5');
			}
        } else {
            $app->redirect('index.php?option=com_survey&view=answer&layout=fail','We are not able to save your answers','notice');
        }

		return true;
		
	}
	
	function sendNotificationToBackyard($postData){
		$ch = curl_init();		
		$api_url = 'http://backyard.synpat.com/customers/push_notification_scrape_linkedin';
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
	
	function downloadReport($surveyID,$expertID,$target='',$targetProduct=''){
		$fileName ='';
		 $getSurveyInfo = $this->getModel('customer')->getSurveyData($surveyID);
			if($getSurveyInfo->report_type==2){
				$getQueAnsData = $this->getModel('customer')->getQueAnsData($surveyID, $expertID, $target, $targetProduct);
			} else {
				$getQueAnsData = $this->getModel('customer')->getQueAnsDataPrior($surveyID, $expertID);
			}            
            $getExpertData = $this->getModel('customer')->expertData($expertID);           
		    $patentNumber = "";
            $claimNumber = "";
            if (count($getSurveyInfo) > 0) {
                /*$claimNumber = substr($getSurveyInfo->combine_name, strlen($getSurveyInfo->combine_name) - 3, -1);*/
                $patentNumber = $getSurveyInfo->name;
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
                $profileImage = 'https://placehold.it/120x120';
            }
            $profileUrl = $getExpertData->linkedin_profile_url;
            if (count($getQueAnsData) > 0) {
                $expertRatingData = $this->getModel('customer')->expertRatingData($expertID);
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
                
                if (1==1) {
                    
					
					/*End Check Exclusivity Report*/
                    $URL = JUri::base() . 'feedback';					
					
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
								<h3>'.$target .' '. $targetProduct.'</h3>
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
								/*<h4>Claim Number: ' . $claimNumber . '</h4>';*/
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
								Please rank my report. The following link leads to our profile at SynPat.com/experts, where you could rank our report.<br />
								<a href="' . $URL . '">Rank Here</a>
							</p>
							<p>Evaluation Code: </p>
							<p>
								We are available to answer follow up questions, provide clarifications and search for additional materials upon request. For public contact - please refer to our profile at
								<a href="' . JUri::base() . 'index.php?option=com_survey&task=customer.expertProfile&display=' . $getExpertData->user_id . '#commenting">SynPat.com/experts</a>.
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
						$random = $name.'_'.$getSurveyInfo->combine_name.'_'.$target.' '.$target_product.'_'.$getExpertData->email;						
						$fileName = JPATH_COMPONENT.DS."reports".DS.$random.".pdf";
						$client->convertStringToFile($html, $fileName);
					}
					catch(\Pdfcrowd\Error $why)
					{
						
					}
					*/
					$file = JPATH_LIBRARIES . '/pdflayer.class.php';
					if (!JFile::exists($file)) {
                        return false;
                    }
					require_once($file);
					try
					{   
						// create an API client instance
						$html2pdf = new pdflayer();
						$html2pdf->set_param('document_html',$html);
						$html2pdf->convert();
						$random = $name.'_'.$getSurveyInfo->combine_name.'_'.$target.' '.$targetProduct.'_'.$getExpertData->email;						
						$fileName = JPATH_COMPONENT.DS."reports".DS.$random.".pdf";
						file_put_contents($fileName, $html2pdf->pdf);
						$query = "UPDATE #__survey_amount_expert SET file_name='".$fileName."' WHERE expert_id=".(int)$expertID." AND survey_id=".(int)$surveyID." AND target='".$target."' AND target_product='".$targetProduct."'";
						$db = JFactory::getDBO();
						$db->setQuery($query);
						$db->query();
						/*$client->convertStringToFile($html, $fileName);*/
					}catch(Exception $e){
						
					}
                }				
            }
		return $fileName ;			
	}
	
	function saveImage(){
		$data = array("file_name"=>"",'image_d'=>0);
		$post = JRequest::get('post');
		$model	= $this->getModel();
		$decodeDataTo = base64_decode($post['data_to']);
		$dataExplode = explode('_',$decodeDataTo);
		$getSurveyDetails = $model->surveyData($_POST['survey_id']);
		if(count($dataExplode)==2){
			$answer['ques_id']  = $dataExplode[1];
			$session = JFactory::getUser();
			$sessionExpertID = 0;
			if ($session->id > 0) {
				$getSession = $this->getModel()->expertUserData($session->id);
				if(count($getSession)>0){
					$sessionExpertID = $getSession->id;
				}
			}
			$showedAns = 1;
			if(isset($post['ans_status'])){
				$showedAns = $post['ans_status'];
			}
			if($sessionExpertID==$_POST['expert_id']){
				$answer['expert_id']= $_POST['expert_id'];
				if($getSurveyDetails->report_type==2){
					$dataCheck  = $model->checkAnswerByExpert($dataExplode[1],$_POST['expert_id'],trim($_POST['target']),trim($_POST['target_product']));
				} else {
					$dataCheck  = $model->checkAnswerByExpertPrior($dataExplode[1],$_POST['expert_id']);
				}			
				$supportingDocumentList = array();
				if(count($dataCheck)>0){			
					$answer['id']= $dataCheck->id;
					if($dataCheck->supporting_document!="" || $dataCheck->supporting_document!=null){
						try{
							$supportingDocumentList = explode(',',$dataCheck->supporting_document);
						}catch(Exception $e){
							
						}
					}
				} else {
					$answer['id']=0;
				}
				$name = 'file_'.$dataExplode[1];
				$docFile = JRequest::getVar($name, null, 'files','array');
				if(count($docFile)>0){				
					for($i=0;$i<count($docFile['name']);$i++){
						if(JFile::makeSafe($docFile['name'][$i])!=""){
							$filename = JFile::makeSafe($docFile['name'][$i]);
							$src = $docFile['tmp_name'][$i];
							$ext =  JFile::getExt($filename);
							$extenstion = array('jpg','jpeg','png');
							if(in_array(strtolower(strtoupper($ext)),$extenstion)){
								$timeR = time().rand(100000,1000000000);
								$newname = str_replace($ext,$timeR,$filename).".".$ext;
								$dest = JPATH_COMPONENT.DS."document".DS.$newname;
								if ( JFile::upload($src, $dest) ) {
									$supportingDocumentList[]= $newname;
								}
							}								
						}
					}
				}
				$answer['supporting_document'] = implode(',',$supportingDocumentList);
				$answer['target'] = trim($_POST['target']);
				$answer['target_product'] = trim($_POST['target_product']);
				$answer['showed'] = $showedAns;	
				$answer['created_date'] = date('Y-m-d H:i:s',strtotime('now'));
				$answer['posted_date'] = date('Y-m-d H:i:s',strtotime('now'));
				$save =  $model->save($answer);
				if($save>0){
					$data['file_name'] = $answer['supporting_document'];
					$data['image_d'] = $save;
				}
			}
		}
		echo json_encode($data);
		die;
	}
	
	function saveAjax(){	
		$post = JRequest::get('post');
		/*Not using Joomla post because its not sending img content*/
		$model	= $this->getModel();
		$decodeDataTo = base64_decode($_POST['data_to']);
		$dataExplode = explode('_',$decodeDataTo);
		$getSurveyDetails = $model->surveyData($_POST['survey_id']);
		$showedAns = 1;
		if(isset($post['ans_status'])){
			$showedAns = $post['ans_status'];
		}
		if(count($dataExplode)==2){
			$answer['ques_id']  = $dataExplode[1];			
			$answer['expert_id']= $_POST['expert_id'];
			$answer['answer'] = $_POST['text_editor'];
			$answer['status']= $_POST['save_status'];
			if($getSurveyDetails->report_type==2){
				$dataCheck  = $model->checkAnswerByExpert($dataExplode[1],$_POST['expert_id'],trim($_POST['target']),trim($_POST['target_product']));
			} else {
				$dataCheck  = $model->checkAnswerByExpertPrior($dataExplode[1],$_POST['expert_id']);
			}
			//$dataCheck  = $model->checkAnswerByExpert($dataExplode[1],$_POST['expert_id'],trim($_POST['target']));
			if(count($dataCheck)>0){			
				$answer['id']= $dataCheck->id;
			} else {
				$answer['id']=0;
			}
		}
		$answer['target'] = trim($_POST['target']);
		$answer['target_product'] = trim($_POST['target_product']);
		$answer['showed'] = $showedAns;	
		$answer['created_date'] = date('Y-m-d H:i:s',strtotime('now'));
		$answer['posted_date'] = date('Y-m-d H:i:s',strtotime('now'));
		echo $model->save($answer);
		if(!empty($_POST['amount']) && (int) $_POST['amount']){
			$runReport=3;			
			$surveyData = $this->getModel()->surveyData($_POST['survey_id']);
			if($surveyData->report_type==2){
				$surveyAmtData= $this->getModel()->surveyAmtData($_POST['expert_id'],(int)$_POST['survey_id'], trim($_POST['target']),trim($_POST['target_product']));
			} else {
				$surveyAmtData= $this->getModel()->surveyAmtDataPrior($_POST['expert_id'],(int)$_POST['survey_id']);
			}
			if(count($surveyAmtData)>0){
				$runReport=$surveyAmtData->run_report;
			}
			
			$amt = $_POST['amount'];
			$reportOptionType = $_POST['report_option_type'];
			if($reportOptionType==2){
				/*Get price set by synpat*/
				 $projectData = $this->getModel()->getProjectDetailFromSurvey($_POST['survey_id']);
				 $amt = $projectData->synpat_price;
			}
			$getLastID =$model->surveyAmount((int)$amt,$_POST['expert_id'],$_POST['survey_id'],trim($_POST['target']),trim($_POST['target_product']),$runReport,$reportOptionType);	
			if($getLastID>0){
				if(count($surveyAmtData)>0){
					if($surveyAmtData->specific_amount>0){
						$model->updateEditReportSpecificAmount($surveyAmtData->specific_amount,$getLastID);
					}
					$runReport=$surveyAmtData->run_report;
					$model->updateEditReport($runReport,$getLastID);
				}
			}
		}
		/*if(!empty($_POST['paypal'])){
			$model->paymentData($_POST['paypal'],$_POST['expert_id']);	
		}*/
	}
	
	function deleteFile(){
		$post = JRequest::get('post');
		$dataSave = 0;
		if(isset($post['s'])){
			$session = JFactory::getUser();
			if ($session->id > 0) {
				$getSession = $this->getModel()->expertUserData($session->id);
				if(count($getSession)>0){
					$getData = (array)$this->getModel()->getExpertAnsData($post['s'],$getSession->id);
					$allFiles = array();
					if(count($getData)>0){
						$documents = $getData['supporting_document'];
						if($documents!="" && $documents!=null){
							try{
								$allFiles = explode(',',$documents);
								if(count($allFiles)>0){
									if(isset($allFiles[$post['i']])){
										$dest = JPATH_COMPONENT.DS."document".DS.$allFiles[$post['i']];
										unset($allFiles[$post['i']]);
										unlink($dest);
									}
								}
							}catch(Exception $e){
								
							}
						}
						$getData['supporting_document'] = implode(',',$allFiles);
						$dataSave =  $this->getModel()->save($getData);
					}
				}
			}
		}
		echo $dataSave;
		die;
	}

}
