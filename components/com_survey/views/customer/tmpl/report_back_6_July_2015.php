<?php
	$getExpertData = $this->expertData;
	$getSurveyInfo = $this->surveyInfo;
	$expertRatingData = $this->expertRatingData;
	$getQueAnsData = $this->report;
	$patentNumber = "";
	$claimNumber ="";
	if(count($getSurveyInfo)>0){
		/*$claimNumber = substr($getSurveyInfo->combine_name,strlen($getSurveyInfo->combine_name)-2 , -1);*/	
		$patentNumber = $getSurveyInfo->name;
		$claimNumber = str_replace($patentNumber,"",$getSurveyInfo->combine_name);
		if(strpos(strtolower($getSurveyInfo->name),"us")===false){
			$patentNumber = "US".$patentNumber;
		}
	}
	$name = $getExpertData->name;
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
		$URL = JUri::base() . 'index.php/feedback&display=';


$html .= '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>PDF Report</title>
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,400italic,700&amp;v1&amp;subset=latin,latin-ext" type="text/css" media="screen" />
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
            background: url("' . JUri::base() . 'templates/survey/img/sprite-star.png") no-repeat scroll 0 0 transparent;
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
            background-color: #cccccc;
        }

        .report-container {
            background-color: #ffffff;
            box-shadow: 0 0 7px #555;
            color: #535353;
            font-family: "Open Sans", Helvetica, Arial, serif;
            font-size: 13px;
            line-height: 1.4;
            margin: 5px auto;
            padding: 50px 71px;
            /*width: 816px;*/
            position: relative;
            width: 674px;
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

        .report-container h1,
        .report-container h2,
        .report-container h3,
        .report-container h4,
        .report-container h5,
        .report-container h6 {
            color: #b90022;
            font-family: Arial;
            margin-top: 20px;
        }

        .report-container h1 {
            font-size: 36px;
            margin-bottom: 20px;
            margin-top: 10px;
        }
        .report-container h2 {
            font-size: 30px;
            margin-bottom: 20px;
        }
        .report-container h3 {
            border-bottom: 1px solid #b90022;
            font-size: 24px;
            margin-bottom: 15px;
        }
        .report-container h4 {
            font-size: 18px;
            margin-bottom: 15px;
        }
        .report-container h5 {
            font-size: 16px;
            margin-bottom: 10px;
        }
        .report-container h6 {
            font-size: 14px;
            margin-bottom: 10px;
        }

        .report-container p {
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 674px;
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

        .report-container pre {
            background: #f4f4f4;
            border: 1px solid #e5e5e5;
            margin: 0;
            padding: 20px 0;
        }
        .report-container code {
            background: #f4f4f4;
            border: 1px solid #e5e5e5;
            padding: 1px 5px;
        }
        .report-container code a {
            text-decoration: none;
        }

        .report-container .table {
            border-collapse: collapse;
        }
        .report-container .table th,
        .report-container .table td {
            border: 1px solid #e5e5e5;
            padding: 5px 7px;
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
                <table cellspacing="0" cellpadding="0" border="0" align="left" width="100%">
                    <tr>
                        <td width="200">
                            <h1>ClaimCharts.info</h1>
                        </td>
                        <td align="right">
                            <a href="" class="button button-pdf">
                                <i class="fa fa-file-pdf-o"></i>
                                Convert to PDF and Submit to Clients
                            </a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
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
							<p>
								' . $getQueAnsData[$i]->description . '
							</p>
							<div>' . preg_replace('#(<[a-z ]*)(style=("|\')(.*?)("|\'))([a-z ]*>)#', '\\1\\6', $getQueAnsData[$i]->answer) . ' </div>
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
    </table>


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
if(JRequest::getVar('show','0')=="1"):
						$file = JPATH_LIBRARIES . '/pdfcrowd.php';
						if (!JFile::exists($file)) {
							return false;
						}
						require_once($file);	
						try
						{   
							// create an API client instance
							$client = new Pdfcrowd("vivek2512", "311c7da7e8fef591a5ceed80d295efcb");
							$client->setHorizontalMargin("1in");
							$client->setVerticalMargin("1in");
							$pdf = $client->convertHtml($html);
							$random = time();     
							
							/* $out_file = fopen($random.".pdf", "wb");
								$client->convertHtml($html, $out_file);
								fclose($out_file);*/
							// set HTTP response headers
							header("Content-Type: application/pdf");
							header("Cache-Control: max-age=0");
							header("Accept-Ranges: none");
							/*header("Content-Disposition: attachment; filename=".$random . ".pdf");*/

							// send the generated PDF 
							echo $pdf;
						}
						catch(PdfcrowdException $why)
						{
							echo "Pdfcrowd Error: " . $why;
						}
					else:
						echo $html;
					endif;
						die;
					
					/*
					echo "<textarea>".$html."</textrea>";die;$file = JPATH_LIBRARIES . '/html2pdf_v4.03/html2pdf.class.php';
					if (!JFile::exists($file)) {
                        return false;
                    }
					require_once($file);
					$random = time();      
					$html2pdf = new HTML2PDF("P", "A4", "en", array(10, 10, 10, 10));
					$html2pdf->WriteHTML($html);
					$html2pdf->Output($random . ".pdf");
					die;
					
					$file = JPATH_LIBRARIES . '/dompdf/dompdf_config.inc.php';
                    if (!JFile::exists($file)) {
                        return false;
                    }
                    if (!defined('DOMPDF_ENABLE_REMOTE')) {
                        define('DOMPDF_ENABLE_REMOTE', true);
                    }
                    $random = time();                  
                    require_once($file);
                    $dompdf = new DOMPDF();
                    $dompdf->load_html($html);
                    $dompdf->render();
                    $dompdf->stream($random . ".pdf", array("Attachment" => 0));	
                	*/
            }	
		die;	
		
        
  ?>
