<div class="col-lg-2 left-assets">
	<table class="table" id="<?php echo $IDPatentNUmber;?>">
		<thead>
			<tr>
				<th style="text-align: left; padding-bottom: 5px; padding-top: 3px"><strong class="" style="font-size: 14px; color: #fff; margin-top: 11px;"><?php echo (count($getPatentData)>1)?count($getPatentData).'&nbsp;&nbsp;Families':count($getPatentData).'&nbsp;&nbsp;Family';?></strong></th>
			</tr>
		</thead>
	</table>
	<div class="assetsNav" style="height: 669px; overflow-y: auto;  /* overflow-y: scroll; overflow-x: hidden; */">
		<ul style='margin-top: 5px;' id="<?php echo $IDEnable;?>">
			<?php 
				for($i=0;$i<count($getPatentData);$i++){
			?>
				<li class="<?php if($i==0):?>active<?php endif;?> ">
					<?php if(strpos($getPatentData[$i]->patent_number,'Expired')===false):?>
					<?php 
						if(!empty($IDEnable)){
					?>
					<a data-id="<?php echo $getPatentData[$i]->id?>" href='javascript:void(0);' class="<?php if($i==0):?>active<?php endif;?> call-number" onclick='enableData("<?php echo $IDEnable;?>",jq(this),<?php echo $getPatentData[$i]->id?>,"<?php echo $getPatentData[$i]->patent_number ;?>")'><?php echo $getPatentData[$i]->patent_number ;?></a>
					<?php } else {?>
					<a data-id="<?php echo $getPatentData[$i]->id?>" href='javascript:void(0);' class="<?php if($i==0):?>active<?php endif;?> call-number" onclick='enableData(jQuery(this),<?php echo $getPatentData[$i]->id?>,"<?php echo $getPatentData[$i]->patent_number ;?>")'><?php echo $getPatentData[$i]->patent_number ;?></a>
				    <?php } ?>
					<?php else:?>
					<span style='color:#ccc;font-size:14px;font-weight:bold;padding-left:13px'><?php echo $getPatentData[$i]->patent_number ;?></span>
					<?php endif;?>
				</li>
			<?php
				}
			?>
		</ul>
	</div>
</div>