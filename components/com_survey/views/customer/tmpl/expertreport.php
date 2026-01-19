<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
$getSession = JFactory::getUser();
$sessionEXpertID = 0;
$imageUrl="";
$name="";
$staticContent = "";
$userData = array();
if ($getSession->id > 0) {
	$getExpertData = SurveyModelCustomer::expertUserData($getSession->id);
    $sessionEXpertID = $getExpertData->id;
	if(!empty($getExpertData->profile_desc)){
		$staticContent.=stripslashes($getExpertData->profile_desc);
		preg_match_all('~<img.*?src=["\']+(.*?)["\']+~', $getExpertData->profile_desc, $urls);
		$imageUrl = $urls[1];
	}
	if((int)$getExpertData->expert_type==2){
		$name = $getExpertData->company_name;
	} else {
		$name = $getExpertData->name;
	}
	$userData = SurveyModelCustomer::getUserData($getSession->id);
}
$profileID = $this->profileID;
$displayID = $this->id;
if($sessionEXpertID==0){
	if($profileID>0){
		$getExpertData = SurveyModelCustomer::expertData($profileID);
		if(count($getExpertData)>0){
			if(!empty($getExpertData->profile_desc)){
				$staticContent.=stripslashes($getExpertData->profile_desc);
				preg_match_all('~<img.*?src=["\']+(.*?)["\']+~', $getExpertData->profile_desc, $urls);
				$imageUrl = $urls[1];
			}
			if((int)$getExpertData->expert_type==2){
				$name = $getExpertData->company_name;
			} else {
				$name = $getExpertData->name;
			}
		}		
	}	
}
$db = JFactory::getDBO();
$sql = "SELECT * FROM #__paypal_setting";
$db->setQuery($sql);
$getPaypalData = $db->loadObject();
$paypalEmail = $getPaypalData->email_id;
$paypalURL = "";
if($getPaypalData->mode==1){
	$paypalURL = "https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&notify_version=2.9&business=";		
} else {
	$paypalURL = "https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_xclick&notify_version=2.9&business=";
}
?>
<style>
#questionlist th,#expertList th{font-size:14px !important;}
.blockE{display:inline-block;width:100%;}
.cart{    padding: 4px 6px 1px;
    border-radius: 4px !important;
    width: 68px;float:none !important;}
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<dl class="article-info clearfix">
			<?php if($sessionEXpertID>0):?>
			<dd class="createdby"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertOpportunites&display='.$displayID)?>" >Projects</a></dd>
			
			<dd class="createdby"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertProcess&display='.$displayID)?>">In Process</a></dd>
			<?php endif;?>
			<dd class="createdby"><a style='color:#cd2122' href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertReport&display='.$displayID)?>">My Reports</a></dd>	
			<dd class="published"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertFeedback&display='.$displayID)?>">Feedback</a></dd>
			<?php if($sessionEXpertID>0):?>
			<dd class="createdby"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertArea&display='.$displayID)?>" >My Expertise</a></dd>
			
			<!--<dd class="published"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.blog&display='.$displayID)?>">My Blog</a></dd>-->
			
			<dd class="published"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.termsOfUse&display='.$displayID)?>">Terms of Use</a></dd>
			<dd class="published"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.privacyPolicy&display='.$displayID)?>">Privacy Policy</a></dd>
			<dd class="published"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.smeAgreement&display='.$displayID)?>">SME Agreement</a></dd>
			<?php endif;?>
			<?php if(count($userData)>0 && $userData->nda==1){?>
			<dd class="published"><a href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.smeNda&display='.$displayID)?>">NDA</a></dd>
			<?php } ?>
			<?php if($sessionEXpertID>0):?>
			<dd class="createdby" ><a href="<?php echo JRoute::_('index.php?option=com_users&task=user.logout&'.JUtility::getToken().'=1');?>" >Logout</a></dd>
			<?php endif;?>
			<dd style='float:right'>
				<a  style='color:#1a73e8;' href="<?php echo JRoute::_('index.php?option=com_survey&task=customer.expertProfile&display='.$displayID)?>"><?php if(is_array($imageUrl) && !empty($imageUrl[0])):?> <img src='<?php echo $imageUrl[0]?>' width="30px"/><?php else:?><img src='<?php echo JURI::root();?>templates/kallyas/images/user.png' width="30px"/> <?php endif;?>&nbsp;&nbsp;<?php echo $name;?></a>
			</dd>
			
		</dl>
<?php
$expertReports = SurveyModelCustomer::getExpertReportsWithProject($profileID);
	if (count($expertReports) > 0) {
?>
	 <div class="span2" style="width:90px;margin-left: 0px;">
		<legend style="font-size:14px;height:60px; font-weight:bold; color:#cd2122 !important; white-space:nowrap;"
				class="noMargin">Project
		</legend>
		<ul id="projectList" class="nav nav-tabs nav-stacked noMargin"
			style="margin-left:-10px !important;margin-top:15px !important">

<?php for ($i = 0; $i < count($expertReports); $i++) { ?>
				<li>
					<a href='javascript://' class="button-link" data-url=""
					   onclick="cData(jQuery(this),<?php echo $expertReports[$i]->pID ?>,<?php echo $profileID; ?>);"><?php echo $expertReports[$i]->projectName; ?><?php echo ($expertReports[$i]->pType==2)?'(CC)':'(PA)';?></a>
				</li>
<?php } ?>
		</ul>
	</div>

	<div class="span2" style=" margin-left:0px; width:124px;">
		<div id="survey" style="margin-left:-10px !important;">
			<div class="loader" style='display:none'>
				<img src="<?php echo JUri::base(); ?>components/com_survey/images/loader.gif"/>
			</div>
		</div>
	</div>
	<div class="span8" style='margin-left: -13px; /*width: 742px;*/' id="mdWS">
		<div class="row-fluid" id="question">
			<div class="loader1" style='display:none'>
				<img src="<?php echo JUri::base(); ?>components/com_survey/images/loader.gif"/>
			</div>
		</div>
	</div>
<?php } else { ?>
    <div style="margin-top: 43px;">
        <p class="alert alert-danger">No report submit by this expert.</p>
    </div>
<?php }?>
<script>
jQuery(document).ready(function() {
	jQuery('title').html('EXPERT REPORT');
	/*dragScrollTable()*/
});

function dragScrollTable(){
	(function (root, factory) {
	if (typeof define === 'function' && define.amd) {
		define(['exports'], factory);
	} else if (typeof exports !== 'undefined') {
		factory(exports);
	} else {
		factory((root.dragscroll = {}));
	}
	}(this, function (exports) {
		var _window = window;
		var _document = document;
		var mousemove = 'mousemove';
		var mouseup = 'mouseup';
		var mousedown = 'mousedown';
		var EventListener = 'EventListener';
		var addEventListener = 'add'+EventListener;
		var removeEventListener = 'remove'+EventListener;
		var newScrollX, newScrollY;

		var dragged = [];
		var reset = function(i, el) {
			for (i = 0; i < dragged.length;) {
				el = dragged[i++];
				el = el.container || el;
				el[removeEventListener](mousedown, el.md, 0);
				_window[removeEventListener](mouseup, el.mu, 0);
				_window[removeEventListener](mousemove, el.mm, 0);
			}

			// cloning into array since HTMLCollection is updated dynamically
			dragged = [].slice.call(_document.getElementsByClassName('dragscroll'));
			for (i = 0; i < dragged.length;) {
				(function(el, lastClientX, lastClientY, pushed, scroller, cont){
					(cont = el.container || el)[addEventListener](
						mousedown,
						cont.md = function(e) {
							if (!el.hasAttribute('nochilddrag') ||
								_document.elementFromPoint(
									e.pageX, e.pageY
								) == cont
							) {
								pushed = 1;
								lastClientX = e.clientX;
								lastClientY = e.clientY;

								e.preventDefault();
							}
						}, 0
					);

					_window[addEventListener](
						mouseup, cont.mu = function() {pushed = 0;}, 0
					);

					_window[addEventListener](
						mousemove,
						cont.mm = function(e) {
							if (pushed) {
								(scroller = el.scroller||el).scrollLeft -=
									newScrollX = (- lastClientX + (lastClientX=e.clientX));
								scroller.scrollTop -=
									newScrollY = (- lastClientY + (lastClientY=e.clientY));
								if (el == _document.body) {
									(scroller = _document.documentElement).scrollLeft -= newScrollX;
									scroller.scrollTop -= newScrollY;
								}
							}
						}, 0
					);
				 })(dragged[i++]);
			}
		}

		  
		if (_document.readyState == 'complete') {
			reset();
		} else {
			_window[addEventListener]('load', reset, 0);
		}

		exports.reset = reset;
	}));
}
Number.prototype.format = function(n, x) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
    return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
};	

                _siteURL = '<?php echo JUri::base(); ?>';
				_sessionEXpertID = '<?php echo $sessionEXpertID; ?>';
                function cData(object, pID, expertID) {
					jQuery("#projectList").find('a').removeClass('active');
                    object.addClass('active');
                    jQuery("#question").find('div.span6').remove();
                    /*jQuery("#question").find('div.span4').remove();*/
                    jQuery("#expertList").remove();
                    if (pID !== "") {
                        jQuery("#surveylist").remove();
                        jQuery("#survey").find('legend').remove();
                        jQuery(".loader").before('<legend class="noMargin" style="font-size: 14px; font-weight: bold; color: #cd2122 !important; white-space: nowrap; padding-left: 10px;height:60px">Patent</legend>');
                        jQuery('.loader').css('display', 'block');
                        jQuery.ajax({
                            url: _siteURL + 'index.php?option=com_survey&task=customer.expertClaim',
                            data: {p: pID, f: expertID, format: ''},
                            cache: false,
                            success: function(html) {
                                __data = jQuery.parseJSON(html);
                                jQuery("#surveylist").remove();
                                _HTML = jQuery('<ul/>').attr('id', 'surveylist').addClass('nav nav-tabs nav-stacked noMargin tMx');
                                if (__data.length > 0) {
                                    for (i = 0; i < __data.length; i++) {
                                        _LI = jQuery('<li/>').data('surveyID', __data[i].id).click(
                                                function() {
                                                    qu(jQuery(this), jQuery(this).data('surveyID'), <?php echo $profileID; ?>);
                                                }).append('<a style="width: 102px;border:0px" class="button-link" href="javascript://">' + __data[i].combine_name + '</a>');
                                        jQuery(_HTML).append(_LI);
                                    }
                                } else {
                                    jQuery(_HTML).append("<li>No record found</li>");
                                }
                                jQuery("#survey").append(_HTML);
                                jQuery('.loader').css('display', 'none');
                            }
                        });
                    }
                }

                function qu(object, su, expertID) {
                    __PPURL = "<?php echo $paypalURL?>";
                    __SU = parseInt(su);
                    jQuery("#surveylist li a").removeClass('active');
                    object.find('a').addClass('active');
                    if (__SU != 0 && __SU != 'NAN' && __SU != 'NAN') {
						_mW = jQuery("#question").parent().parent().width();
						_mDW=jQuery("#question").parent().parent().find('div.span2').eq(0).width();
						_mD2W=jQuery("#question").parent().parent().find('div.span2').eq(1).width();
						_cmDW = _mW - _mDW - _mD2W;
						jQuery("#mdWS").css('width',_cmDW+'px');
                        jQuery("#questionlist").parent().remove();
                        jQuery("#questionlist").remove();
                        jQuery("#expertList").parent().remove();
                        jQuery("#expertList").remove();
                        jQuery('.loader1').css('display', 'block');
                        jQuery.ajax({
                            url: _siteURL + 'index.php?option=com_survey&task=customer.quListExpert',
                            data: {ps: __SU, f: expertID, format: ''},
                            cache: false,
                            success: function(html) {
                                __data = jQuery.parseJSON(html);
                                jQuery("#questionlist").remove();
                                jQuery("#expertList").remove();
                                __GRID2Div = jQuery('<div/>').addClass('span6').css({marginLeft: '10px'});
                                __GRID5Div = jQuery('<div/>').addClass('grid_6 alpha omega');
                                __LegendGrid2 = jQuery('<legend/>').addClass('noMargin').append('Elements').css({height: '60px', fontSize: '14px', fontWeight: 'bold', color: '#cd2122', whiteSpace: 'wrap'});
                                jQuery(__GRID2Div).append(__LegendGrid2);
                                _HTML = jQuery('<table/>').attr('id', 'questionlist').addClass('table');
                                __ETable = jQuery("<table/>").attr('id', 'expertList').addClass('table result-table').css('background', 'none').css('margin-top', '4px');
                                __GRID10Div = jQuery('<div/>').addClass('span6 dragscroll').css({overflowX: 'scroll', margin: '0',cursor:'move'});
                                __GRID7Div = jQuery('<div/>').addClass('grid_6').css({overflowX: 'scroll', margin: '0'});
                                if (__data['question'].length > 0) {
                                    for (i = 0; i < __data['question'].length; i++) {
										_submittedDate = "";
										_postedDate = "";
                                        _QueThread = jQuery("<thead/>");
                                        if (i == (__data['question'].length - 1)) {
                                            _MAINTR = jQuery("<tr/>").css({borderBottom: '0px !important'}).data('quData', __data['question'][i]);
                                        } else {
                                            _MAINTR = jQuery("<tr/>").css({borderBottom: '0px !important'}).data('quData', __data['question'][i]);
                                        }
                                        _TH = jQuery("<th/>").css({borderBottom: '0px !important'}).append(__data['question'][i]['data'].description);
                                        jQuery(_MAINTR).append(_TH);
                                        jQuery(_QueThread).append(_MAINTR);
                                        jQuery(_HTML).append(_QueThread);
                                        if (i == 0) {

                                            _Thead = jQuery("<thead/>");
                                            _TR = jQuery("<tr/>");
                                            for (s = 0; s < __data['expert'].length; s++) {
                                                __name = __data['expert'][s].name;
												if(__data['expert'][s].expert_type==2){
													__name = __data['expert'][s].company_name;
												}
												jQuery(_TR).append("<th valign='top' class='" + __data['expert'][s].id + "' style='text-align:center;height:33px;border-bottom:1px solid #E5E5E5 !important;color:#cd2122 !important'><a target='_BLANK' href='" + _siteURL + "index.php?option=com_survey&task=customer.expertProfile&display=" + __data['expert'][s].id + "'>" + __name + "</a></th>");

                                                jQuery.ajax({
                                                    url: _siteURL + 'index.php?option=com_survey&task=customer.showExpertRating',
                                                    data: {expert_id: __data['expert'][s].id, format: ''},
                                                    type: 'POST',
                                                    cache: false,
                                                    success: function(html) {
                                                        _ratingData = jQuery.parseJSON(html);
                                                        if (_ratingData.data.length) {
                                                            expertID = 0;
                                                            totalProject = 0;
                                                            totalRate = 0;
                                                            for (r = 0; r < _ratingData.data.length; r++) {
                                                                if (r == 0) {
                                                                    expertID = _ratingData.data[r].id;
                                                                }
                                                                totalProject = totalProject + _ratingData.data[r].countSurvey;
                                                                totalRate = totalRate + _ratingData.data[r].rating;
                                                            }

                                                            if (totalProject > 0 && totalRate > 0) {
                                                                $calcRating = totalRate / totalProject;
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
                                                                if (jQuery("." + expertID).find('.swSprite').length == 0) {
                                                                    jQuery("." + expertID).append('<br/><span title="' + $calcRating + ' out of 5 stars" class="swSprite ' + $class + '"></span>');
                                                                }
                                                            } else {
                                                                _class = "s_star_0_0";
                                                                if (jQuery("." + expertID).find('.swSprite').length == 0) {
                                                                    jQuery("." + expertID).append('<br/><span title="0 out of 5 stars" class="swSprite ' + _class + '"></span>');
                                                                }
                                                            }
                                                        } else {
                                                            _class = "s_star_0_0";
                                                            if (jQuery("." + _ratingData.id).find('.swSprite').length == 0) {
                                                                jQuery("." + _ratingData.id).append('<br/><span title="0 out of 5 stars" class="swSprite ' + _class + '"></span>');
                                                            }
                                                        }
                                                    }
                                                });
                                            }
                                            jQuery(_Thead).append(_TR);
                                            jQuery(__ETable).append(_Thead);
                                        }
                                        __TR = jQuery("<tr/>");
                                        for (s = 0; s < __data['expert'].length; s++) {
                                            if (__data['question'][i]['answer'].length > 0) {
                                                __parseFlag = 0;
                                                __DipTo = 0;
                                                for (an = 0; an < __data['question'][i]['answer'].length; an++) {
                                                    if (__DipTo == 0 && !(__data['question'][i]['answer'][an]===null)) {
                                                        if (__data['expert'][s].id == __data['question'][i]['answer'][an].expert_id && (__data['expert'][s].target == __data['question'][i]['answer'][an].target) && (__data['expert'][s].target_product == __data['question'][i]['answer'][an].target_product)) {															
                                                            __DipTo = 1;
                                                            if (__data['question'][i]['answer'][an].status == 1) {
                                                                _TD = jQuery("<td/>").addClass('aCenter').append('<span><i class="icon-ok aCenter"> </i></span>');
                                                            } else {
                                                                _TD = jQuery("<td/>").addClass('aCenter').append('<span></span>');
                                                            }
                                                            __parseFlag = 1;
															jQuery(__TR).append(_TD);
                                                        }
                                                    }
                                                    
                                                }
                                                if (__parseFlag == 0) {
                                                    _TD = jQuery("<td/>").append("");
                                                    jQuery(__TR).append(_TD);
                                                }
                                            } else {
                                                _TD = jQuery("<td/>").append("");
                                                jQuery(__TR).append(_TD);
                                            }
                                        }
                                        jQuery(__ETable).append(__TR);
                                    }

                                    __TR = jQuery("<tr/>");
                                   /* if (__data['survey'].length > 0) {*/
                                        for (s = 0; s < __data['expert'].length; s++) {
                                            __DIP2 = 0;
											_TD = jQuery("<td/>");
											__A ="";
											__EDIT = "";
											if (__data['survey'].length > 0) {
                                            for (am = 0; am < __data['survey'].length; am++) {
                                                if (__DIP2 == 0) {													
                                                    if (__data['survey'][am]!=null && (__data['expert'][s].id == __data['survey'][am].expert_id) && (__data['expert'][s].target == __data['survey'][am].target) && (__data['expert'][s].target_product == __data['survey'][am].target_product)) {
                                                        __DIP2 = 1;
                                                        __SUR = __data['survey'][am].survey_id;
                                                        __EXP = __data['survey'][am].expert_id;
														_amountReport = __data['survey'][am].amount;
														__payalEmail = __data['expert'][s].paypal_id;
														if(__data['survey'][am].report_option_type=='2' && _sessionEXpertID==0){
															__payalEmail = '<?php echo $paypalEmail?>';
															_amountReport = __data['survey'][am].specific_amount;
														}
														if(_sessionEXpertID!=0){
															if(__data['expert'][s].created_date!='0000-00-00 00:00:00'){
																_submittedDate = "<span title='Submitted'>"+moment(new Date(__data['expert'][s].created_date)).format("MM-DD-YYYY")+'</span>';
															} else {
																_submittedDate = '';
															}
														}
																				
														if(_sessionEXpertID!=0){
															if(parseInt(__data['expert'][s].can_see)==1){
																if(__data['expert'][s].posted_date!='0000-00-00 00:00:00'){
																	_postedDate = "<span title='Posted'>"+moment(new Date(__data['expert'][s].posted_date)).format("MM-DD-YYYY")+'</span>';
																} else {
																	_postedDate = "";
																}
															} else {
																_postedDate = "Not Posted";
															}
														}
														
														_amountReport = parseInt(_amountReport);
                                                        _TD.css('background', 'none').addClass('aCenter').data('expertAmount', _amountReport).data('run', __data['survey'][am].run_report)
														_stringShow = '<span class="blockE"><b>' + __data['survey'][am].target + '</b></span><span class="blockE"><b>' + __data['survey'][am].target_product + '</b></span><span class="blockE">'+_submittedDate+'</span><span class="blockE">' + _postedDate + '</span>';
														_stringShow1 = '<span class=""><b>' + __data['survey'][am].target + '</b></span><br/><span class=""><b>' + __data['survey'][am].target_product + '</b></span><br/><span class="">'+_submittedDate+'</span><br/><span class="">' + _postedDate + '</span>';
														_TD.append(_stringShow);
														__A = jQuery("<a/>").addClass('btn btn-medium btn-flat cart').attr('data-target', __data['survey'][am].target).attr('data-target_product', __data['survey'][am].target_product).data('expertEmail', __payalEmail).click(function() {
															_TTHISS = jQuery(this);
															_TTHISS.attr('disabled', true);
															__cEM = jQuery(this).data('expertEmail');
															__target = jQuery(this).attr('data-target');
															__target_product = jQuery(this).attr('data-target_product');
															__amTT = jQuery(this).parent().data('expertAmount');
															jQuery.ajax({
																url: _siteURL + 'index.php?option=com_survey&task=customer.transaction',
																data: {amt: __amTT, su: __SUR, ex: __EXP, target: __target,target_product:__target_product, format: ''},
																cache: false,
																success: function(data) {
																	if (data > 0) {
																		__ram = data;
																		__PPURL = __PPURL + __cEM + "&lc=US&item_name=Report Purchase&amount=" + __amTT + "&currency_code=USD&item_number=" + __ram + "&notify_url=<?php echo urlencode(JUri::base() . 'index.php?option=com_survey&task=customer.notify&raw='); ?>" + __ram + "&return=<?php echo urlencode(JUri::base() . 'index.php?option=com_survey&task=customer.success&raw='); ?>" + __ram + "&cancel=<?php echo urlencode(JUri::base() . 'index.php?option=com_survey&task=customer.cancel&raw='); ?>" + __ram;
																		_TTHISS.removeAttr('disabled');
																		window.location.href = __PPURL;
																	}
																}
															});
														}).append('<span style="float:left;width:16px;margin-right:6px"><svg aria-hidden="true" data-prefix="fas" data-icon="shopping-cart" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="svg-inline--fa fa-shopping-cart fa-w-18 fa-2x"><path fill="currentColor" d="M528.12 301.319l47.273-208C578.806 78.301 567.391 64 551.99 64H159.208l-9.166-44.81C147.758 8.021 137.93 0 126.529 0H24C10.745 0 0 10.745 0 24v16c0 13.255 10.745 24 24 24h69.883l70.248 343.435C147.325 417.1 136 435.222 136 456c0 30.928 25.072 56 56 56s56-25.072 56-56c0-15.674-6.447-29.835-16.824-40h209.647C430.447 426.165 424 440.326 424 456c0 30.928 25.072 56 56 56s56-25.072 56-56c0-22.172-12.888-41.332-31.579-50.405l5.517-24.276c3.413-15.018-8.002-29.319-23.403-29.319H218.117l-6.545-32h293.145c11.206 0 20.92-7.754 23.403-18.681z" class=""></path></svg></span><span style="float:right">$'+_amountReport.format()+'</span>');
                                                        
															__run = __data['survey'][am].run_report;
															if(__run>0 && _sessionEXpertID!=0){
																__EDIT = jQuery("<a/>").addClass('btn').css({color:'#1a73e8',background:'none',border:'0px'}).attr('data-target', __data['survey'][am].target).attr('data-target_product', __data['survey'][am].target_product).data('expertEmail', __data['expert'][s].paypal_id).click(function() {
																	_TTHISS = jQuery(this);
																	_TTHISS.attr('disabled', true);
																	__cEM = jQuery(this).data('expertEmail');
																	__target = jQuery(this).attr('data-target');
																	 __target_product = jQuery(this).attr('data-target_product');
																	__amTT = jQuery(this).parent().data('expertAmount');
																	__run = jQuery(this).parent().data('run');
																	
																	window.location.href = _siteURL + 'index.php?option=com_survey&task=customer.reEditReport&target_product=' + __target_product + '&target=' + __target + '&su=' + __SUR + '&ex=' + __EXP;
																}).append('<span style="float:left;width:16px;margin-right:6px;margin-left:3px;"><svg aria-hidden="true" data-prefix="far" data-icon="edit" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="svg-inline--fa fa-edit fa-w-18 fa-2x"><path fill="currentColor" d="M402.3 344.9l32-32c5-5 13.7-1.5 13.7 5.7V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V112c0-26.5 21.5-48 48-48h273.5c7.1 0 10.7 8.6 5.7 13.7l-32 32c-1.5 1.5-3.5 2.3-5.7 2.3H48v352h352V350.5c0-2.1.8-4.1 2.3-5.6zm156.6-201.8L296.3 405.7l-90.4 10c-26.2 2.9-48.5-19.2-45.6-45.6l10-90.4L432.9 17.1c22.9-22.9 59.9-22.9 82.7 0l43.2 43.2c22.9 22.9 22.9 60 .1 82.8zM460.1 174L402 115.9 216.2 301.8l-7.3 65.3 65.3-7.3L460.1 174zm64.8-79.7l-43.2-43.2c-4.1-4.1-10.8-4.1-14.8 0L436 82l58.1 58.1 30.9-30.9c4-4.2 4-10.8-.1-14.9z" class=""></path></svg></span><span style="float:right">'+__run+'</span>');
															} else{
																__EDIT ='';
															}               
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
														if((__data['expert'][s].id == __data['question'][i]['answer'][an].expert_id) && (__data['expert'][s].target==__data['question'][i]['answer'][an].target) && (__data['expert'][s].target_product == __data['question'][i]['answer'][an].target_product)){
															_spDIP = 1;
															__SUR = __data['question'][i]['data'].survey_id;
															_TD.css('background','none').addClass('aCenter').append('<span class="dM"><b>'+__data['question'][i]['answer'][an].target+'</b></span><br/><span class="dM"><b>'+__data['question'][i]['answer'][an].target_product+'</b></span><br/>');	
															__A = jQuery("<a/>").addClass('btn btn-medium btn-flat').attr('data-target', __data['question'][i]['answer'][an].target).attr('data-target_product', __data['question'][i]['answer'][an].target_product).data('expertEmail', __data['expert'][s].paypal_id).click(function() {
																	_TTHISS = jQuery(this);
																	_TTHISS.attr('disabled', true);
																	__cEM = jQuery(this).data('expertEmail');
																	__target = jQuery(this).attr('data-target');
																	 __target_product = jQuery(this).attr('data-target_product');
																	window.location.href = _siteURL + 'index.php?option=com_survey&task=customer.reEditReport&target_product=' + __target_product + '&target=' + __target + '&su=' + __SUR + '&ex=' + __EXP;
																}).append('Edit');
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
								jQuery(_TD).append(__A).append(__EDIT);
								
								jQuery(__TR).append(_TD);
									_sp = jQuery('<span/>').attr('id','checkWidth').css('visibility','hidden').append(_stringShow1);
								
									jQuery('body').append(_sp);
									__width = jQuery("#checkWidth").width();
									jQuery("#checkWidth").remove();
									jQuery(_TD).css('width',__width+'px');
									jQuery(__ETable).find('tr').find('td').eq(s).find('span').css({'width':__width+'px',display:'inline-block'});
							
								}
                                        jQuery(__ETable).append(__TR);
                                   /* }*/
                                    jQuery(__GRID2Div).append(_HTML);
                                    jQuery(__GRID10Div).append(__ETable);
                                } else {
                                    jQuery(_HTML).append('<tr><td>No record found!</td></tr>');
                                    jQuery(__GRID2Div).append(_HTML);
                                    jQuery(__GRID10Div).css('display', 'none');
                                }
                                jQuery("#question").append(__GRID2Div).append(__GRID10Div);

                                /*Change height for the Questions*/
                                jQuery('#questionlist>thead').each(function(index) {
                                    _height = jQuery(this).height();
                                    jQuery("#expertList>tbody>tr").eq(index).css('height', _height + 'px');
                                });
                                /*End Change height for the Questions*/
                                jQuery('.loader1').css('display', 'none');
								dragScrollTable()
                            }
                        });
                    }
                }

            </script>
