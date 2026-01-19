<?php
//$user = $this->user;
?>
<!--<form action="<?php  echo site_url() ?>api/saveUser/" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data"  onsubmit="return check_validation();">	-->
<form action="" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">	
	<table class="adminform">
		<tr>
			<td width="15%">
				First Name
				<span style="color:#FF0000">*</span>
			</td>
			<td>
				<input type="text" required="required" name="first_name" value="" class="inputbox" size="40" />
				<span class="editlinktip hasTip" title="Expert First Name" >
					<img border="0" src="<?php echo site_url() ?>/public/images/tooltip.png">
				</span>
			</td>
	  	</tr>	
	  	<tr>
			<td width="15%">
				Last Name
				<span style="color:#FF0000">*</span>
			</td>
			<td>
				<input type="text" required="required" name="last_name" value="" class="inputbox" size="40" />
				<span class="editlinktip hasTip" title="Expert Last Name" >
					<img border="0" src="<?php echo site_url() ?>/public/images/tooltip.png">
				</span>
			</td>
	  	</tr>	
		<tr>
			<td width="15%">
				Company Name
				<span style="color:#FF0000">*</span>
			</td>
			<td>
				<input type="text" name="company_name" value="" class="inputbox" size="40" />
				<span class="editlinktip hasTip" title="Expert Company Name" >
					<img border="0" src="<?php echo site_url() ?>/public/images/tooltip.png">
				</span>
			</td>
	  	</tr>	
		<tr>
			<td width="15%">
				Street
				<span style="color:#FF0000">*</span>
			</td>
			<td>
				<input type="text" name="address" value="" class="inputbox" />
				<span class="editlinktip hasTip" title="Expert Street Address" >
					<img border="0" src="<?php echo site_url() ?>/public/images/tooltip.png">
				</span>
			</td>
	  	</tr>	
		<tr>
			<td width="15%">
				City
				<span style="color:#FF0000">*</span>
			</td>
			<td>
				<input type="text" name="city" value="" class="inputbox" size="40" />
				<span class="editlinktip hasTip" title="Expert City" >
					<img border="0" src="<?php echo site_url() ?>/public/images/tooltip.png">
				</span>
			</td>
	  	</tr>	
		<tr>
			<td width="15%">
				State
				<span style="color:#FF0000">*</span>
			</td>
			<td>
				<input type="text" name="state" value="" class="inputbox" size="40" />
				<span class="editlinktip hasTip" title="Expert State" >
					<img border="0" src="<?php echo site_url() ?>/public/images/tooltip.png">
				</span>
			</td>
	  	</tr>
		<tr>
			<td width="15%">
				Zip/Postal Code
				<span style="color:#FF0000">*</span>
			</td>
			<td>
				<input type="text" name="zip" value="" class="inputbox" size="40" />
				<span class="editlinktip hasTip" title="Expert Zip/Postal Code" >
					<img border="0" src="<?php echo site_url() ?>/public/images/tooltip.png">
				</span>
			</td>
	  	</tr>	
	  	<tr>
			<td width="15%">
				Country
				<span style="color:#FF0000">*</span>
			</td>
			<td>
				<input type="text" name="country" value="" class="inputbox" size="40" />
				<span class="editlinktip hasTip" title="Expert Country" >
					<img border="0" src="<?php echo site_url() ?>/public/images/tooltip.png">
				</span>
			</td>
	  	</tr>	
		<tr>
			<td width="15%">
				Email
				<span style="color:#FF0000">*</span>
			</td>
			<td>
				<input type="text" name="email" required="required" value="" class="inputbox" size="40" />
				<span class="editlinktip hasTip" title="Expert Email Address" >
					<img border="0" src="<?php echo site_url() ?>/public/images/tooltip.png">
				</span>
			</td>
	  	</tr>	
		<tr>
			<td width="15%">
				Phone Number
				<span style="color:#FF0000">*</span>
			</td>
			<td>
				<input type="text" name="phone" value="" class="inputbox" size="40" />
				<span class="editlinktip hasTip" title="Expert Phone Number" >
					<img border="0" src="<?php echo site_url() ?>/public/images/tooltip.png">
				</span>
			</td>
	  	</tr>	
		<tr>
			<td width="15%">
				Website Address
				<span style="color:#FF0000">*</span>
			</td>
			<td>
				<input type="text" name="web" value="" class="inputbox" size="40" />
				<span class="editlinktip hasTip" title="Expert Website Address" >
					<img border="0" src="<?php echo site_url() ?>/public/images/tooltip.png">
				</span>
			</td>
	  	</tr>	
	</table>
		<input type="hidden" name="id" value="" />
        <a href="#" onclick="form_submit();">Publish</a> | <a href="<?php  echo site_url() ?>api/expert_list/">Cancel</a>
</form>
<script language="javascript" type="text/javascript">		

	
		function form_submit(){
		  jQuery('#adminForm').get('0').submit();
		}
		
	
</script>