<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
$getData = $this->rating;
if(count($getData)>0):
?>
<div class="row-fluid">
	<form action="index.php" method="post" name="customer-thanks" id="customer-thanks">
	<div class="span12 white solid-all dP-all-m tM dM">
		<div class="row-fluid">
			<div class="span12">
				<?php 
					if($getData['expert']->linkedin_pic!=""){
				?>
						<img src="<?php echo $getData['expert']->linkedin_pic;?>"/>
				<?php
					}
				?>
					<h2><?php echo $getData['expert']->name;?></h2>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12"> 
				<div class="displayB">
					<legend>Rating to Expert:</legend>
					<p>Please evaluate your experience with the evidence of use provided by the expert by choosing the rating below:-</p>
					<!--<div class="form-horizontal">
						<div class="control-group">
							<label class="control-label" for="project_name_multiple">Enter Digital Code:</label>
							<div class="controls">
								<input type="text" name="digital_code" id="digital_code" />
							</div>
						</div>
					</div>-->
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
											<td style="text-align:center;"><input type="radio" id="rating_0" name="rating" value="0"/></td>
											<td style="text-align:center"><input type="radio" id="rating_1" name="rating" value="1"/></td>
											<td style="text-align:center"><input type="radio" id="rating_2" name="rating" value="2"/></td>
											<td style="text-align:center"><input type="radio" id="rating_3" name="rating" value="3"/></td>
											<td style="text-align:center"><input type="radio" id="rating_4" name="rating" value="4"/></td>
											<td style="text-align:center"><input type="radio" id="rating_5" name="rating" value="5"/></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="form-horizontal">
						<div class="control-group">
							<p>Please provide any addition feedback or comment about your experience</p>
							<div class="controls" style="margin-left:0">
								<textarea style="width:900px;height:70px;" placeholder="Feedback" name="feedback" id="feedback"></textarea>
							</div>
						</div>
					</div>
					<div class="form-horizontal">
						<div class="control-group">
							
							<div class="controls" style="margin-left:0">
								<a href="javascript://"  onclick="submitForm();" class="btn btn-flat">Submit Rating</a> 
								<a href="<?php echo JUri::base();?>"   class="btn btn-flat">Cancel</a>
							</div>
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
	} else if(jQuery('input[name="rating"]').is(':checked')){
		document.forms["customer-thanks"].submit();	
	} else {
		alert('Error: Please select atleast one star to give rating to expert.');
	}
}
</script>
<?php else:?>
<div class="row-fluid">
	<div class="span12 white solid-all dP-all-m tM dM">
		<p>Opps page not found!</p>
	</div>
</div>
<?php endif;?>
