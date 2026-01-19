<?php 
include('./pdflayer.class.php');
$html2pdf = new pdflayer();
$html2pdf->set_param();
//set the URL to convert
$html2pdf->set_param('test',1);
$html2pdf->set_param('document_url','https://pdflayer.com/downloads/invoice.html');
//start the conversion
$html2pdf->convert();
//display the PDF file
$html2pdf->download_pdf();
?>
<?php 
/*include('./pdflayer.class.php');
$html2pdf = new pdflayer();
//set the URL to convert
$html2pdf->set_param('test',1);
$htmlPDF = '<html><head><meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
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
						background: url("http://claimcharts.synpat.com/templates/survey/img/sprite-star.png") no-repeat scroll 0 0 transparent;
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

				</style></head><body><h3>LENOVO</h3></body></html>';
$html2pdf->set_param('document_html',$htmlPDF);
$html2pdf->convert();
//display the PDF file
$fileName = 'newapi.pdf';
file_put_contents($fileName, $html2pdf->pdf);*/
?>