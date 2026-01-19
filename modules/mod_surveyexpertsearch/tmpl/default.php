<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_whosonline
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
// no direct access
defined('_JEXEC') or die;

$db = JFactory::getDBO();
$sql = "SELECT * FROM #__paypal_setting";
$db->setQuery($sql);
$getPaypalData = $db->loadObject();
$paypalEmail = $getPaypalData->email_id;
$paypalURL = "";
if ($getPaypalData->mode == 1) {
   $paypalURL = "https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&notify_version=2.9";
} else {
   $paypalURL = "https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_xclick&notify_version=2.9";
}
?>
<script>
        __siteURL = '<?php echo JUri::base(); ?>';
        function findExpert() {
            //debugger;
            if (jQuery("#expert_search_name").val() === "") {
                alert('Please enter Search Term(s) and try again.');
                return false;
            }
            jQuery("#expertSearchResults").html('').css('display', 'block');
            jQuery("#expert_search_submit").attr('disabled', true);
            jQuery('#expertSearchLoader').css('display', 'block');

            jQuery.ajax({
                url: __siteURL + 'index.php?option=com_survey&task=survey.searchExpertsWithReports',
                type: 'POST',
                data: {name: jQuery("#expert_search_name").val()},
                dataType: 'json',
                cache: false,
                success: function(response) {
                   // debugger;
                    jQuery("#expert_search_submit").removeAttr('disabled');
                    if (response.status === true) {

                        jQuery('#expertSearchResultsList').html('');
                        jQuery('#expertSearchResultsList').append(
                                "<div class='row-fluid'>" +
                                "<div class='span2'><strong>Expert</strong></div>" +
                                "<div class='span10'><strong>Project(s)</strong></div>" +
                                "</div>");
                        if (response.data!=null && response.data.length > 0) {
                            for (i = 0; i < response.data.length; i++) {
                                var expert = response.data[i].expert_name;
                                var expertID = response.data[i].expert_id;
                                var projects = response.data[i].projects;
                                if (projects === null) {
                                    projects = '';
                                }
                                jQuery('#expertSearchResultsList').append(
                                        "<div class='row-fluid'>" +
                                        "<div class='span2'><a href='"+__siteURL+"index.php?option=com_survey&task=customer.expertProfile&display="+expertID+"'>" + expert + "</a></div>" +
                                        "<div class='span10'>" + projects + "</div>" +
                                        "</div>");
                            }
                        } else {
                            jQuery('#expertSearchResultsList').html('<strong>Sorry, this expert name was not found, please try another name.</strong>');
                        }
                    } else {
                        alert('No data found!');
                    }
                    jQuery('#expertSearchLoader').css('display', 'none');
                },
                error: function(error) {
                  //  debugger;
                    //alert(error);
                    jQuery('#expertSearchLoader').css('display', 'none');
                }
            });
        }
    </script>
<div class="visible-desktop visible-tablet visible-phone">
    <div class="control-group">
        <div class="controls">
            <input type="text" placeholder="Enter Expert Name" name="expert_search_name" id="expert_search_name"  class="input-block-level" >
        </div>
    </div>								
    <div class="control-group">
        <div class="controls">
            <div class="visible-desktop visible-tablet visible-phone">
                <a href="#expertSearch" id="expert_search_submit" onclick="findExpert();"   class="btn btn-flat" >Find</a>
            </div>
        </div>
    </div>
	<!--SEARCH RESULTS AREA START-->
    <section id="expertSearchResults" style="display:none;">
        <div id="expertSearchLoader" name="expertSearchLoader">
            <img src="<?php echo JUri::base(); ?>components/com_survey/images/loader.gif"/>
        </div>
        <div id="expertSearchResultsList"  class="container contCustom">
            <p>Searching...</p>
        </div>
    </section>

    <!--SEARCH RESULTS AREA END-->
</div>
