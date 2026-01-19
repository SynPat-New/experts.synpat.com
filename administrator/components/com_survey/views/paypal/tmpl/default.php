<?php
/**
 * @copyright   (C) 2010 iJoomla, Inc. - All rights reserved.
 * @license  GNU General Public License, version 2 (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author  iJoomla.com <webmaster@ijoomla.com>
 * @url   http://www.ijoomla.com/licensing/
 * the PHP code portions are distributed under the GPL license. If not otherwise stated, all images, manuals, cascading style sheets, and included JavaScript  *are NOT GPL, and are released under the IJOOMLA Proprietary Use License v1.0 
 * More info at http://www.ijoomla.com/licensing/
*/
defined ('_JEXEC') or die ("Go away.");


$data = $this->data;
$id=0;
$emailID = "";
$mode = 0;
if(count($data)>0){
	$emailID = $data->email_id;
	$mode = $data->mode;
	$id=$data->id;
}

?>

<form action="index.php" method="post" name="adminForm">	
	<table class="adminlist1 table table-bordered table-striped">
		<tr>
			<td><label>Paypal Email Id:</label></td>
			<td><input type="text" value="<?php echo $emailID;?>" name="email_id" id="email_id"/></td>
		</tr>
		<tr>
			<td><label>Mode:</label></td>
			<td><select name="mode">
				<option value="1" <?php if($mode==1){echo "SELECTED='SELECTED'";}?>>Live Mode</option>
				<option value="0" <?php if($mode==0){echo "SELECTED='SELECTED'";}?>>Testing Mode</option>
			</select></td>
		</tr>	
	</table>
	<input type="hidden" name="option" value="com_survey" />
	<input type="hidden" name="id" value="<?php echo $id;?>" />
	<input type="hidden" name="task" value="paypal.save" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="hidemainmenu" value="0" />
	<input type="hidden" name="controller" value="paypal" />
</form>
