<?php
// No direct access to this file 
defined('_JEXEC') or die('Restricted access');
$getProjectName = JRequest::getVar('client_id');
$tap = JRequest::getVar('tap');
$name = JRequest::getVar('name','');
$expertReports = SurveyModelCustomer::getExpertReportsWithProjectName($getProjectName,$tap);
$surveyData = array();
if($name!='' && count($expertReports)>0){
	$surveyData = SurveyModelCustomer::surveyList($expertReports->pID, 0,$name);
}

$db = JFactory::getDBO();
$sql = "SELECT * FROM #__paypal_setting";
$db->setQuery($sql);
$getPaypalData = $db->loadObject();
$paypalEmail = $getPaypalData->email_id;
$paypalURL = "";
if($getPaypalData->mode==1){ 
	$paypalURL = "https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&notify_version=2.9";		
} else {
	$paypalURL = "https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_xclick&notify_version=2.9";
}

$containerHeight = JRequest::getVar('container_height','');
?>


  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,700&amp;v1&amp;subset=latin,latin-ext" type="text/css" media="screen"  id="google_font" />
  <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700,600italic' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900&amp;v1&amp;subset=latin,latin-ext" type="text/css" media="screen"  id="google_font_elems" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js" type="text/javascript"></script>
  <script src="<?php echo JUri::base(true);?>templates/kallyas/js/bootstrap.min.js" type="text/javascript"></script>
  <script src="<?php echo JUri::base(true);?>plugins/system/jquery/jquery.noconflict.js" type="text/javascript"></script>
<style>
.loader , .loader1{
	display:none;
	margin:0 auto;
	width:50px;
	height:50px;
}
table.result-table tr td{
	/*padding:10px !important;*/
}
/*
.nav-tabs > li > a{
	  padding-left: 10px !important;
	  padding-right: 10px !important;
}*/
#questionlist thead tr th , #expertList tbody tr td, #questionlist tbody tr th {
	border-top:0px !important;
	}
	#surveylist{
		margin-top:0px !important;
	}
	.nav-tabs.nav-stacked > li a.active{
		background:none !important;
		color:red !important;
		}
.nav-tabs > li > a:hover,.nav-tabs > li > a:focus{
background:none !important;
}
#questionlist th{
font-size:14px !important;
font-weight:normal !important;
}

.table th, .table td{border-top:1px solid #DDDDDD;}
#header{background:rgba(0,0,0,0.5);}
nav#main_menu > ul.sf-menu > li > a{color:#fff;}
.topnav > li > a, .topnav li .menu li a{color:#fff;}
.smallm_title{border-bottom:1px solid #e5e5e5;}
.nav-tabs.nav-stacked>li>a{border:0px !important;}
body.component{
	padding-top:0px !important;
}


/** Scroll top */
.expertsList-top-scroll-wrapper {
    height: 20px;
    overflow-x: scroll;
    overflow-y: hidden;
}
.expertsList-top-scroll {
	height: 20px;
}
.expertsList-bottom-scroll-wrapper {
    overflow-x: scroll;
}
@media (max-width: 767px) {
    #surveylist>li>a{word-wrap:break-word;}
}
@media only screen and (min-height:2050px){
	body{zoom:2.597;}
}
@media only screen and (min-height:1890px) and (max-height:2049px){
	body{zoom:2.588;}
}
@media only screen and (min-height:1690px) and  (max-height:1889px){
	body{zoom:2.417;}
}
@media only screen and (min-height:1490px) and (max-height:1689px){
	body{zoom:2.203;}
}
@media only screen and (min-height:1426px) and (max-height:1489px){
	body{zoom:1.99;}
}
@media only screen and (min-height:1330px) and (max-height:1425px){
	body{zoom:1.921;}
}
@media only screen and (min-height:1090px) and (max-height:1329px){
	body{zoom:1.818;}
}
@media only screen and (min-height:937px) and (max-height:1089px){
	body{zoom:1.562;}
}
@media only screen and (min-height:907px) and (max-height:936px){
	body{zoom:1.397;}
}
@media only screen and (min-height:881px) and (max-height:906px){
	body{zoom:1.366;}
}
@media only screen and (min-height:817px) and (max-height:880px){
	body{zoom:1.338;}
}
@media only screen and (min-height:757px) and (max-height:816px){
	body{zoom:1.27;}
}
@media only screen and (min-height:721px) and (max-height:756px){
	body{zoom:1.206;}
}
@media only screen and (min-height:711px) and (max-height:720px){
	body{zoom:1.167;}
}
@media only screen and (min-height:657px) and (max-height:710px){
	body{zoom:1.157;}
}
@media only screen and (min-height:625px) and (max-height:656px){
	/*body{zoom:0.702;}*/
	body{zoom:1;}
}
@media only screen and (min-height:577px) and (max-height:624px){
	body{zoom:0.867;}
}
@media only screen and (min-height:457px) and (max-height:576px){
	body{zoom:0.756;}
}
@media only screen and (min-height:401px) and (max-height:456px){
	body{zoom:0.688;}
}
@media only screen and (max-height:400px){
	body{zoom:0.488;}
}
</style>
<?php 
	/*if(empty($containerHeight)):
?>
<div id="overall">
<?php else:?>
<div id="overall"  style="height: <?php echo (int) $containerHeight - 30?>px; overflow-y: auto;">
<?php 
	endif;*/
?>
<div class="row-fluid">
	<div class="span12">
		<?php  
			if(count($expertReports)>0){
		?>
			<script>
				jQuery(document).ready(function(){
					<?php 
						if(count($surveyData)==0){
					?>
					su(<?php echo $expertReports->pID?>);	
					<?php } else {?>
					_snn=false;
						qu(jQuery("#surveylist"),<?php echo $surveyData[0]->id;?>);
						<?php } ?>
				});
				
			</script>
			<!--
			<div class="span2" style="width:65px;" >
				<legend style="font-size:14px; font-weight:bold; color:#005580; padding-left:10px !important; border:none; white-space:nowrap;" class="noMargin">Project</legend>
				<ul id="projectList" class="nav nav-tabs nav-stacked noMargin">
					<li>
						<a href='javascript://' style="padding-top:8px !important" class="button-link" onclick="su(jQuery(this),<?php echo $expertReports->pID?>);"><?php echo $expertReports->projectName;?></a>
					</li>
				</ul>
			</div>-->
			<div class="span12 noMargin">
			<h4 class=' m_title' style='display:none;' id="heading_reports"></h4>
			<?php 
				$ds = "";
				if($name!="" && count($surveyData)>0){
					$ds = "display:none;";
				}
			?>
			<div class="span2 noMarginLeft" style="margin-top:20px;<?php echo $ds;?>">
				<div id="survey" <?php if(count($expertReports)==0  ):?> style='display:none;' <?php endif;?>>
					<?php 
						if(count($expertReports)==0):
					?>
					<div class="loader">
						<img src="<?php echo JUri::base();?>components/com_survey/images/loader.gif"/>
					</div><?php endif;?>
				</div>
			</div>					
			<div class="span10" style="">
				<div class="row-fluid" id="question">
					<div class="loader1">
						<img src="<?php echo JUri::base();?>components/com_survey/images/loader.gif"/>
					</div>
				</div>
			</div>
			
			</div>
		<?php } else { ?>
			<div class="displayB" style="min-height:100px;">
				<p class="alert alert-info">Invalid client id</p>
			</div>
		<?php } ?>
	</div>
</div>
</div>
<script>	
			__SiteURL = '<?php echo JUri::base();?>';		
			_pr = '<?php echo JRequest::getInt('tap',0);?>';
			_pn = '<?php echo JRequest::getVar('name','');?>';
			_snn=false;
			function su(d,n,t){
			jQuery("#projectList li a").removeClass('active');
			jQuery("#rssFeed").attr('href',__SiteURL+'index.php?option=com_survey&view=customer&p_d='+d+'&format=feed&type=rss');
			//object.addClass('active');
			jQuery("#questionlist").parent().remove();
			jQuery("#questionlist").remove();
			jQuery("#expertList").parent().remove();
			jQuery("#expertList").remove();
		if(d!=""){
			jQuery("#surveylist").remove();
			jQuery("#survey").find('legend').remove();									
			jQuery(".loader").before('<legend class="noMargin smallm_title" style="font-size: 14px; margin-left: 5px; margin-bottom: 8px; font-weight: bold; white-space: nowrap; width: 100%; display: block; border-bottom: 1px solid #e5e5e5; padding-bottom: 16px;">Claim Numbers</legend>');
			jQuery('.loader').css('display','block');									
			jQuery.ajax({
			url:__SiteURL+'index.php?option=com_survey&task=customer.surveyListAnother',
			data:{ps:d,pr:_pr,pn:_pn,format:''},
			cache:false,
			success:function(html){
				__data = jQuery.parseJSON(html);
				jQuery("#surveylist").remove();
				
				_HTML = jQuery('<ul/>').attr('id','surveylist').addClass('nav nav-tabs nav-stacked');
				if(__data.length>0){
					for(i=0;i<__data.length;i++){
						_combineName = __data[i].combine_name;
						if(_pr==0 && _pn==''){
							if(__data[i].report_type==2){
								_combineName +=" <b>C</b>";
							} else if(__data[i].report_type==1){
								_combineName +=" <b>P</b>";
							}
						}
						_LI = jQuery('<li/>').data('surveyID',__data[i].id).click(function(){
																				qu(jQuery(this),jQuery(this).data('surveyID'));
																			}).append('<a style="color:#15C;padding-left:0px;padding-right:0px;" href="javascript://">'+_combineName+'</a>');
					
						<?php 
							$param = JRequest::getVar('awse','');
							if(!empty($param)){
								$explodeParam = explode('@',base64_decode($param));
								if(isset($explodeParam[1]) && !empty($explodeParam[1])){
						?>
									if(__data[i].combine_name=='<?php echo $explodeParam[1]?>'){
										_snn = true;
										qu(jQuery("#surveylist>li").eq(i),__data[i].id);
									}
						<?php
								}
							}
						?>
						if(_pn!='' && __data[i].name==_pn){
							_snn = true;
										qu(jQuery("#surveylist>li").eq(i),__data[i].id);
										jQuery("#survey").parent().hide();
										
									}
									
						jQuery(_HTML).append(_LI);
						if(_snn===false && i==0){	
							
							setTimeout(function(){
								jQuery("#surveylist>li").eq(0).trigger("click");
							},300);
							
							/*qu(jQuery("#surveylist>li").eq(i),__data[i].id);*/
						}
					}
					
				} else {
					jQuery(_HTML).append("<li>No record found</li>");
					
				}
				if(_pr!=0){
					if(_pr==2){
						jQuery("#heading_reports").css('display','none').html('');
					}else if(_pr==1){
						jQuery("#heading_reports").css('display','none').html('');
					}					
				} else 	if(_pr==0 &&  _pn=='')	{
					jQuery("#heading_reports").css('display','none').html('');
				}
				domain = extractDomain(document.referrer);
				if(domain=="claimcharts.synpat.com" || domain=="www.claimcharts.synpat.com"){
					if (parent !== window){
						window.parent.changeWidthIframe();
					} 
				}
				
				
				jQuery("#survey").append(_HTML);
				jQuery('.loader').css('display','none');
			}	
			});
		}
	}
								
	function extractDomain(url) {
		var domain;
		//find & remove protocol (http, ftp, etc.) and get domain
		if (url.indexOf("://") > -1) {
			domain = url.split('/')[2];
		}
		else {
			domain = url.split('/')[0];
		}

		//find & remove port number
		domain = domain.split(':')[0];

		return domain;
}							
	_mainData = "";						
	function qu(object,su){
		/*__PPURL ="https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_xclick&notify_version=2.9&business=";*/
		__PPURL ="<?php echo $paypalURL;?>&business=";
		__SU = parseInt(su);
		if(object.find('a').hasClass('active')===false){
		jQuery("#surveylist li a").removeClass('active');
		object.find('a').addClass('active');
		
		if(__SU!=0 && __SU!='NAN' &&  __SU!='NAN'){
		
			jQuery("#questionlist").parent().remove();
			jQuery("#questionlist").remove();
			jQuery("#expertList").parent().remove();
			jQuery("#expertList").remove();		
			jQuery('.loader1').css('display','block');
			jQuery.ajax({
			url:__SiteURL+'index.php?option=com_survey&task=customer.quList',	
			data:{ps:__SU,format:''},
			cache:false,
			success:function(html){
				__data = jQuery.parseJSON(html);
				_mainData = __data;
				jQuery("#question").parent().css('width','');
				jQuery("#questionlist").parent().remove();
				if(jQuery("#expertList").length>0){
					jQuery("#expertList").parent().remove();
				} else {
					jQuery("#question").find('.span7').remove();
				}
				/*__GRID2Div = jQuery('<div/>').addClass('span5 noMarginLeft').css({marginTop: '20px'});*/
				__GRID2Div = jQuery('<div/>').addClass('span5 noMarginLeft');
				__GRID5Div = jQuery('<div/>').addClass('grid_6 alpha omega');
				__LegendGrid2 = jQuery('<legend/>').addClass('noMargin smallm_title').append('ELEMENTS').css({height:'56px',fontWeight:'bold',whiteSpace:'wrap',paddingLeft:'8px',borderBottom:'1px solid #e5e5e5'});
				
				jQuery(__GRID2Div).append(__LegendGrid2);
				
				_HTML = jQuery('<table/>').attr('id','questionlist').addClass('table');
				__ETable = jQuery("<table/>").attr('id','expertList').addClass('table result-table').css('background','none').css('margin-top','0px');
				__GRID10Div = jQuery('<div/>').addClass('span7').css({/*overflowX:'scroll',*/margin:'0'});
				__GRID7Div = jQuery('<div/>').addClass('grid_6').css({overflowX:'scroll',margin:'0'});
				if(__data['question'].length>0){
					if(jQuery("#projectList li a.active").length>0){						
						jQuery("#rssFeed").attr('href',__SiteURL+'index.php?option=com_survey&view=customer&p_d='+jQuery("#projectList li a.active").attr('data-id')+'&format=feed&type=rss');
						jQuery("#myModal").find('.modal-body').find('textarea').val('<iframe src="'+__SiteURL+'index.php/component/survey/?&tmpl=component&task=customer.generateClientRequest&client_id='+jQuery("#projectList li a.active").attr('data-name')+'" width="950" height="600" frameborder="0" scrolling="no"></iframe>');
						jQuery("#embedCode").css('display','block');
					}
					jQuery('.help-block').css('display','block');
					for(i=0;i<__data['question'].length;i++){
						_QueThread = jQuery("<thead/>");							
						if(i==(__data['question'].length-1)){
							_MAINTR = jQuery("<tr/>").data('quData',__data['question'][i]);
						} else {
							_MAINTR = jQuery("<tr/>").data('quData',__data['question'][i]);
						}							
						_TH = jQuery("<th/>").append(__data['question'][i]['data'].description);
						jQuery(_MAINTR).append(_TH);
						jQuery(_QueThread).append(_MAINTR);
						jQuery(_HTML).append(_QueThread);
						if(i==0){ 
							
							_Thead = jQuery("<thead/>");
							/*_TR = jQuery("<tr/>").css({borderBottom:'1px solid #E5E5E5'});	*/							
							_TR = jQuery("<tr/>").css('height', '42px');								
							for(s=0;s<__data['expert'].length;s++){
								if(__data['expert'][s].linkedin_profile_url==""){
									jQuery(_TR).append("<th valign='top' class=' smallm_title "+__data['expert'][s].id+"' style='text-align:center;height:42px;'><a data-target='"+__data['expert'][s].target+"' data-target-product='"+__data['expert'][s].target_product+"' target='_BLANK' href='"+__SiteURL+"pexpert?display="+__data['expert'][s].id+"'>"+__data['expert'][s].name+"</a></th>");
								} else {
									jQuery(_TR).append("<th valign='top' class='smallm_title "+__data['expert'][s].id+"' style='text-align:center;height:42px;'><a data-target='"+__data['expert'][s].target+"' data-target-product='"+__data['expert'][s].target_product+"' target='_BLANK' href='"+__SiteURL+"pexpert?display="+__data['expert'][s].id+"'>"+__data['expert'][s].name+"</a></th>");
								}
								
								jQuery.ajax({
									url:__SiteURL+'index.php?option=com_survey&task=customer.showExpertRating',	
									data:{expert_id:__data['expert'][s].id,format:''},
									type:'POST',
									cache:false,
									success:function(html){
										_ratingData = jQuery.parseJSON(html);
										if(_ratingData.data.length){
											expertID = 0;
											totalProject = 0;
											totalRate = 0;
											for(r=0;r<_ratingData.data.length;r++){													
												if(r==0){
													expertID = _ratingData.data[r].id;
												}
												totalProject = totalProject+_ratingData.data[r].countSurvey;
												   totalRate = totalRate+_ratingData.data[r].rating;
											}
											
											if(totalProject>0 && totalRate>0){
												$calcRating = totalRate/totalProject;
												if($calcRating==1){
													__class="s_star_1_0";
												} else if(($calcRating>1 && $calcRating<1.5) || ($calcRating>1.5 && $calcRating<2)){
													__class="s_star_1_5";
												} else if($calcRating==2){
													__class="s_star_2_0";
												} else if(($calcRating>2 && $calcRating<2.5) || ($calcRating>2.5 && $calcRating<3)){
													__class="s_star_2_5";
												} else if($calcRating==3){
													__class="s_star_3_0";
												} else if(($calcRating>3 && $calcRating<3.5) || ($calcRating>3.5 && $calcRating<4)){
													__class="s_star_3_5";
												} else if($calcRating==4){
													__class="s_star_4_0";
												} else if(($calcRating>4 && $calcRating<4.5) || ($calcRating>4.5 && $calcRating<5)){
													__class="s_star_4_5";
												} else if($calcRating==5){
													__class="s_star_5_0";
												}
												if(jQuery("."+expertID).find('.swSprite').length==0){
													jQuery("."+expertID).append('<br/><label title="'+$calcRating+' out of 5 stars" class="swSprite '+__class+'"></label>');
												}
											} else {
												_class="s_star_0_0";
												if(jQuery("."+expertID).find('.swSprite').length==0){
													jQuery("."+expertID).append('<br/><label title="0 out of 5 stars" class="swSprite '+_class+'"></label>');
												}
											}
										} else {
											_class="s_star_0_0";
											if(jQuery("."+_ratingData.id).find('.swSprite').length==0){
												jQuery("."+_ratingData.id).append('<br/><label title="0 out of 5 stars" class="swSprite '+_class+'"></label>');
											}
										}
									}
								});
							}
							jQuery(_Thead).append(_TR);
							jQuery(__ETable).append(_Thead);
						}
						__TR = jQuery("<tr/>");
						for(s=0;s<__data['expert'].length;s++){
							if(__data['question'][i]['answer'].length>0){
								__parseFlag = 0;
								__DipTo = 0;
								for(an=0;an<__data['question'][i]['answer'].length;an++){
									if (__DipTo == 0 && !(__data['question'][i]['answer'][an]===null)) {
										 if (__data['expert'][s].id == __data['question'][i]['answer'][an].expert_id && (__data['expert'][s].target == __data['question'][i]['answer'][an].target) && (__data['expert'][s].target_product == __data['question'][i]['answer'][an].target_product)) {
											__DipTo = 1;
											if(__data['question'][i]['answer'][an].status==1){
												_TD = jQuery("<td/>").addClass('aCenter').append('<i class="icon-ok aCenter"> </i>').attr('data-target',__data['question'][i]['answer'][an].target).attr('data-target-product',__data['question'][i]['answer'][an].target_product);
											} else {
												_TD = jQuery("<td/>").addClass('aCenter').attr('data-target',__data['question'][i]['answer'][an].target).attr('data-target-product',__data['question'][i]['answer'][an].target_product);
											}
											__parseFlag = 1;
											jQuery(__TR).append(_TD);
										}
									}
									
								}
								if(__parseFlag==0){
									_TD = jQuery("<td/>").append("");
									jQuery(__TR).append(_TD);
								}
							} else{
								_TD = jQuery("<td/>").append("");
								jQuery(__TR).append(_TD);
							}
						}
						jQuery(__ETable).append(__TR);
					}						
						__TR = jQuery("<tr/>");
						/*if(__data['survey'].length>0){*/
							for(s=0;s<__data['expert'].length;s++){
								__DIP2=0;
								_TD = jQuery("<td/>");
								__A = "";
								if(__data['survey'].length>0){
								for(am=0;am<__data['survey'].length;am++){
									if(__DIP2==0){
										if(__data['survey'][am]!=null && (__data['expert'][s].id==__data['survey'][am].expert_id) && (__data['expert'][s].target==__data['survey'][am].target) && (__data['expert'][s].target_product == __data['survey'][am].target_product)){
											__DIP2 = 1;
											__SUR = __data['survey'][am].survey_id;
											__EXP = __data['expert'][s].id;
											_amountReport = __data['survey'][am].amount;
											__payalEmail = __data['expert'][s].paypal_id;
											if(__data['survey'][am].report_option_type=='2'){
												__payalEmail = '<?php echo $paypalEmail?>';
												_amountReport = __data['survey'][am].specific_amount;
											}
											_amountReport = parseInt(_amountReport);
											_TD.css('background','none').addClass('aCenter').data('expertAmount',_amountReport).append('<span class="dM"><b>'+__data['survey'][am].target+'</b></span><br/><span class="dM"><b>'+__data['survey'][am].target_product+'</b></span><br/><span class="dM"><b>$'+_amountReport+'</b></span><br/>');	
											__A = jQuery("<a/>").addClass('btn btn-flat').data('expertID',__data['expert'][s].id).data('target',__data['survey'][am].target).data('target_product', __data['survey'][am].target_product).data('expertEmail',__payalEmail).click(function(){
																																					
		var importantStuff = window.open('https://claimcharts.synpat.com/processing.html', '_blank');																																			
																																						_TTHISS = jQuery(this);
																																						_TTHISS.attr('disabled',true);
																																						__cEM = jQuery(this).data('expertEmail');
																																						
																																						__target = jQuery(this).data('target');
																																						 __target_product = jQuery(this).data('target_product');
																																						__expertID = jQuery(this).data('expertID');
																																						__amTT = jQuery(this).parent().data('expertAmount');

																																						jQuery.ajax({
																																						url:__SiteURL+'index.php?option=com_survey&task=customer.transaction',
																																						data:{amt:__amTT,su:__SUR,ex:__expertID,target:__target,target_product:__target_product,format:''},
																																						cache:false,
																																						success:function(data){
																																							if(data>0){
																																								__ram = data;
																																								__PPURL = __PPURL+__cEM+"&lc=US&item_name=Report Purchase&amount="+__amTT+"&currency_code=USD&item_number="+__ram+"&notify_url=<?php echo urlencode(JUri::base().'index.php?option=com_survey&task=customer.notify&raw=');?>"+__ram+"&return=<?php echo urlencode(JUri::base().'index.php?option=com_survey&task=customer.success&raw=');?>"+__ram+"&cancel=<?php echo urlencode(JUri::base().'index.php?option=com_survey&task=customer.cancel&raw=');?>"+__ram; console.log(__PPURL);
																																								_TTHISS.removeAttr('disabled');
																																								
				
				importantStuff.location = 	__PPURL;
																																								/*if (parent.location.href != self.location.href){
					window.parent.location.href=__PPURL;
				} else {
					window.location = __PPURL;
				}*/
																																							}
																																						}
																																						});
																																					}).append('Buy');
											
										}
									}
								}
								}
								if(__DIP2==0){									
									if(__data['question'].length>0){
										for(i=0;i<__data['question'].length;i++){
											_spDIP=0;
											if(__data['question'][i]['answer'].length>0){
												for(an=0;an<__data['question'][i]['answer'].length;an++){
													if(_spDIP==0){
														if((__data['expert'][s].target==__data['question'][i]['answer'][an].target) && (__data['expert'][s].target_product == __data['question'][i]['answer'][an].target_product)){
															_spDIP = 1;
															_TD.css('background','none').addClass('aCenter').append('<span class="dM"><b>'+__data['question'][i]['answer'][an].target+'</b></span><br/><span class="dM"><b>'+__data['question'][i]['answer'][an].target_product+'</b></span>');	
														}
													}
												}
												if(_spDIP==1){
													break;
												}
											}
										}
									}									
								}
								jQuery(_TD).append(__A);
								jQuery(__TR).append(_TD);
							}
							jQuery(__ETable).append(__TR);								
					/*	}*/
				} else {
					jQuery(_HTML).append('<tr><th>In proccess.</th></tr>');		
					__ETable ='';
					__GRID10Div = jQuery('<div/>');
				}
				
				jQuery(__GRID2Div).append(_HTML);

				jQuery(__GRID10Div).append(__ETable);
				jQuery("#question").append(__GRID2Div).append(__GRID10Div);
				_WIDTH = jQuery("#question").width();
				if(_WIDTH==0){
					_mainWIDTH = jQuery("#question").parent().parent().width();
					_siblingWidth = jQuery("#survey").parent().width();
					_WIDTH = _mainWIDTH - _siblingWidth;	
					if(_WIDTH==0){
						_WIDTH = 1170-30;
						_cWi = _WIDTH*14.893617021276595/100;
						_WIDTH = _WIDTH - _cWi;
					}
				}
				if(_snn===true){
					_WIDTH = 1027;
					jQuery('body').css('padding-left','0px');
					jQuery('#question').parent().css('margin-left','0px');
				}
				// Scroll top
				if(__ETable.length>0) {
					/*__ETable.wrap('<div class="expertsList-bottom-scroll-wrapper"></div>');
					if(__GRID10Div.find('.expertsList-top-scroll-wrapper').length==0){
						jQuery('.expertsList-bottom-scroll-wrapper').before('<div class="expertsList-top-scroll-wrapper"><div class="expertsList-top-scroll"></div></div>');
					}
					
					
					jQuery('.expertsList-top-scroll').width(jQuery('#expertList').outerWidth() + 20);
					jQuery(".expertsList-top-scroll-wrapper").off('scroll').on('scroll', function(){
				        jQuery(".expertsList-bottom-scroll-wrapper")
				            .scrollLeft(jQuery(".expertsList-top-scroll-wrapper").scrollLeft());
				    });
				    jQuery(".expertsList-bottom-scroll-wrapper").off('scroll').on('scroll', function(){
				        jQuery(".expertsList-top-scroll-wrapper")
				            .scrollLeft(jQuery(".expertsList-bottom-scroll-wrapper").scrollLeft());
				    });*/
				}
				
				
				_questionWidth = _WIDTH * 40.17094017094017/100;
				_ansWidth = _WIDTH * 57.26495726495726/100;
				jQuery("#question").parent().css('width',(_questionWidth+ _ansWidth)+'px');
				jQuery("#question").find('.span5').css({width:_questionWidth+'px',float:'left'});
				jQuery("#question").find('.span7').css({width:_ansWidth+'px',float:'left'});
				/*Change height for the Questions*/
					jQuery('#questionlist>thead').each(function(index){
							_height = jQuery(this).height();	
							console.log(_height);							
							jQuery("#expertList>tbody>tr").eq(index).css('height',_height+'px');		
					});
					/*End Change height for the Questions*/
				jQuery('.loader1').css('display','none');
				domain = extractDomain(document.referrer);
				if(domain=="claimcharts.synpat.com" || domain=="www.claimcharts.synpat.com"){
					if (parent !== window){
						_location = window.location.href;
						spt = _location.split('&');
						mesg=2;
						if(spt.length>0){
							pr = spt[spt.length-1];
							if(pr!=""){
								rep = pr.split('=');
								if(rep.length==2 && typeof rep[0]!=undefined && rep[0]=='pr'){
									mesg=rep[1];
								}
							}
						}
						window.parent.changeWidthIframe(mesg);
					} 
				} 
			}
			});
		}
		}else {
			jQuery("#question").empty();
			jQuery("#surveylist li a").removeClass('active');
			domain = extractDomain(document.referrer);
				if(domain=="claimcharts.synpat.com" || domain=="www.claimcharts.synpat.com"){
					if (parent !== window){
						_location = window.location.href;
						spt = _location.split('&');
						mesg=2;
						if(spt.length>0){
							pr = spt[spt.length-1];
							if(pr!=""){
								rep = pr.split('=');
								if(rep.length==2 && typeof rep[0]!=undefined && rep[0]=='pr'){
									mesg=rep[1];
								}
							}
						}
						window.parent.changeWidthIframe(mesg);
					} 
				} 
		}
	}
</script>
