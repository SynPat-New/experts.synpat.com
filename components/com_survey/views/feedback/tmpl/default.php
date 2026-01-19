<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
$getData = array();
$profileImage = "";
$expertName= "";
$feedback = "";
$star = "";
if(!empty($this->stringData)){

$getData = $this->rating;
preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $getData['expert']->profile_desc, $matches);
$profileImage = "";
if(isset($matches[1][0])){
	$profileImage = $matches[1][0];
} else {
	$profileImage = 'https://placehold.it/120x120';
}
$expertName = $getData['expert']->name;
$feedback = $getData['feedback']->feedback;
$star = $getData['feedback']->rating;
}


?>
<div class="row-fluid">
	<form action="index.php" method="post" name="customer-thanks" id="customer-thanks">
	<div class="span12 white solid-all dP-all-m tM dM">
		<div class="row-fluid">
			<div class="span12">
				<?php 
					if($profileImage!=""){
				?>
						<img src="<?php echo $profileImage;?>"/>
				<?php
					}
				?>
					<h2><?php echo $expertName;?></h2>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12"> 
				<div class="displayB">
					<legend> Your feedback to the Expert and the Report:</legend>
					<p>Your feedback on the report and the Expert performance is essential in maintaining and encouraging high quality output. Please share your experience regarding aspects such as accuracy, conservatism, clarity, price, follow up questions, etc:</p>
					
					<div class="form-horizontal">
						<div class="control-group">
							<div class="controls" style="margin-left:0">
								<table class="table">
									<thead>
										<th style="width:10%; text-align:center;">Completely Unsatisfied</th>
										<th style="width:10%; text-align:center;">Unsatisfied</th>
										<th style="width:10%; text-align:center;">Natural</th>
										<th style="width:10%; text-align:center;">Satisfied</th>
										<th style="width:10%; text-align:center;">Completely Satisfied</th>
										<th style="width:10%; text-align:center;">Exceeded Expectation</th>
									</thead>
									<tbody>
										<tr>
											<td style="text-align:center;"><input type="radio" <?php if($star=='0'):?>CHECKED='CHECKED' <?php endif;?> id="rating_0" name="rating" value="0"/></td>
											<td style="text-align:center"><input type="radio" <?php if($star=='1'):?>CHECKED='CHECKED' <?php endif;?> id="rating_1" name="rating" value="1"/></td>
											<td style="text-align:center"><input type="radio" <?php if($star=='2'):?>CHECKED='CHECKED' <?php endif;?> id="rating_2" name="rating" value="2"/></td>
											<td style="text-align:center"><input type="radio" <?php if($star=='3'):?>CHECKED='CHECKED' <?php endif;?> id="rating_3" name="rating" value="3"/></td>
											<td style="text-align:center"><input type="radio" <?php if($star=='4'):?>CHECKED='CHECKED' <?php endif;?> id="rating_4" name="rating" value="4"/></td>
											<td style="text-align:center"><input type="radio" <?php if($star=='5'):?>CHECKED='CHECKED' <?php endif;?> id="rating_5" name="rating" value="5"/></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="form-horizontal">
						<div class="control-group">
							<p>Please provide any addition feedback or comment about your experience:</p>
							<div class="controls" style="margin-left:0">
								<textarea style="width:900px;height:70px;" placeholder="Feedback" name="feedback" id="feedback"><?php echo $feedback;?></textarea>
							</div>
						</div>
					</div>
					<div class="form-horizontal">
						<div class="control-group">
							<label class="control-label" for="digital_code" style="cursor:default;font-size:13px;text-align:left;width:140px;">Enter Evaluation Code:<br/></label>
							<div class="controls" style='margin-left:140px'>
								<input type="text" name="digital_code" required="required" value="<?php echo $this->stringData;?>" id="digital_code" placeholder="Enter Evaluation Code" />
								<a href="javascript://"  onclick="submitForm();" class="btn btn-flat" style='margin-left:5px;'>Submit Feedback</a> 
								<a href="<?php echo JUri::base();?>"   class="btn btn-flat">Cancel</a>
							</div>
							<p>(located at the bottom left corner of your PDF report)</p>
						</div>
					</div>					
				</div>
			</div>
		</div>
	</div>
	<input type="hidden" name="option" value="com_survey"/>
	<input type="hidden" name="task" value="customer.submitRating"/>
	<input type="hidden" name="string" value="<?php echo $this->stringData;?>"/>
	</form>
</div>
<script>
function submitForm(){
	if(jQuery('#feedback').val()==""){
		alert('Please enter feedback.');
	} else if (jQuery('#digital_code').val()==""){
		alert('Please enter evaluation code.');
		jQuery('#digital_code').focus();
	} else if(jQuery('input[name="rating"]').is(':checked')){
		document.forms["customer-thanks"].submit();	
	} else {
		alert('Error: Please select atleast one star to give rating to expert.');
	}
}
</script>

