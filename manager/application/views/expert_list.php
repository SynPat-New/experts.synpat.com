<h2>Experts</h2>
<?php
$session_msg = $this->session->flashdata('expert_msg');
if(isset($session_msg)): echo $this->session->flashdata('expert_msg'); endif;
/*if(isset($session_msg))
{
    echo $this->session->flashdata('expert_msg');
}*/
?>
<style>
.slidebar {
    background: #ffffff;
    box-shadow: 0 0 3px #555;
    height: 100%;
    padding: 10px 0px 10px 10px;
    position: fixed;
    right: -59%;
    top: 0;
    width: 58%;
    z-index: 9999;
}
.slidebar-left{
	background: #ffffff;
    box-shadow: 0 0 3px #555;
    height: 100%;
    padding: 10px 0px 10px 10px;
    position: fixed;
    left: -56%;
    top: 0;
    width: 55%;
    z-index: 9999;
}
.slidebar-close {
    background: url(https://storage.googleapis.com/static.synpat.com/store/img/close.png) no-repeat;
    height: 22px;
    position: absolute;
    left: 2px;
    top: 2px;
    width: 22px;
}
</style>
<script type="text/javascript" src="<?php echo $Layout->baseUrl;?>public/widgets/datatable/datatable.js"></script>
<script type="text/javascript" src="<?php echo $Layout->baseUrl;?>public/widgets/datatable/datatable-fixedheader.js"></script>
<script type="text/javascript">
 
    /* Datatables basic */
	var expertsTable;
	function callExpertTable(){
		expertsTable = $('#expert_list').dataTable({
			fixedHeader: true,
			destroy:true,
			"scrollY": 500,
			paging:false ,
			searching:true ,
			"oLanguage": {
				"sEmptyTable": "No record found!"
			}
		});
	}
    $(document).ready(function() {
        callExpertTable();
    });
	$(window).on('resize',function() {
		expertsTable.fnDestroy();
        callExpertTable();
		changeSliderWidth();
    });
	function inactivateMe(o){
		var tap=0;
		if(o.is(':checked')){
			tap=1;
		}
		jQuery.ajax({
			url:'<?php echo $Layout->baseUrl;?>api/delete_experts',
			type:'POST',
			data:{experts:o.val(),t:tap},
			dataType:'json',
		}).done(function(d){
			if(d===true){
				var $tparent = o.parents('tr');
				_holder = $tparent.find('td').eq(0);
				/*if(tap==1){
					_holder.html('<a href="<?php echo $Layout->baseUrl;?>/api/expert_publish/'+o.val()+'"><img src="<?php echo $Layout->baseUrl;?>public/images/publish_x.png"></a>');
				} else {
					_holder.html('<a href="<?php echo $Layout->baseUrl;?>/api/expert_unpublish/'+o.val()+'"><img src="<?php echo $Layout->baseUrl;?>public/images/tick.png"></a>');
				}*/
			}
		})
	}
</script>
<table class="table" id="expert_list">
<thead>
    <tr>
		<th style="width:80px;" title="Log-in">Log-in</th>
        <th title="Post">Store</th>
        <th title="Name">Name</th>
        <th title="NDA">NDA</th>
        <th title="Username">Username</th>
		<th title="Email">Email</th>
		<th title="Joined" style='width:150px;'>Joined</th>
        <th title="Sent">Sent</th>
        <th title="Expertise">Expertise</th>
        <th title="Reports">Reports</th>
        <th title="Sold">Sold </th>
        <th title="Revenue">Revenue</th>
        <th title="Feedback">Feedback</th>
    </tr>
	</thead>
	<tbody>
    <?php
    $i = 1;
    $obj = json_decode($get_data);
    foreach($obj as $k=>$v)
    {   
   ?>
    <tr id="<?php echo $v->id;?>">
		<td style='width:80px'>
            <?php 
				if($v->published=='1'){
			?>
				<a href="<?php echo site_url() ?>api/expert_unpublish/<?php echo $v->id;?>">
					<img src="<?php echo site_url() ?>/public/images/tick.png"/>
				</a>
			<?php
				} else {
			?>
				<a href="<?php echo site_url() ?>api/expert_publish/<?php echo $v->id;?>">
					<img src="<?php echo site_url() ?>/public/images/publish_x.png"/>
				</a>
			<?php	
				}
				
			?>
        </td>
		<td>
		<input type="checkbox" <?php if($v->can_see==1):?>CHECKED='CHECKED' <?php endif;?> name="delete_users[]" value="<?php echo $v->id;?>" onclick="inactivateMe(jQuery(this))"/>
        </td>
         <td>			
			<?php 
				$display = $v->id; 
				$display = openssl_encrypt($display,"AES-128-ECB",'q20zkh9esXlg6gJt9ixgSnU1VlXOFNtSDqoL');
			?>
			<a href="javascript://" onclick='openExpertProfile("https://experts.synpat.com/component/survey/?task=customer.expertProfile&display=<?php echo $display;?>")' style='color:#025A8D;text-decoration:underline' target="_blank"><?php echo $v->name; ?></a>
			 <a href='javascript://' class='marg10L' onclick="deleteExpert(<?php echo $v->id;?>, jQuery(this))"><i class='glyph-icon icon-trash'></i></a>
        </td>
		<td class='username'>
           <?php echo ($v->nda > 0)?'<img src="'.site_url().'/public/images/tick.png"/>':''; ?> 
        </td>
		<td class='username'>
           <?php echo $v->username; ?> 
        </td>
		<td>
           <?php echo $v->email; ?> 
        </td>
		<td><?php echo date('Y-m-d',strtotime($v->registerDate)); ?></td>
        
         <td>
            <?php echo $v->Questionare_Sent; ?>
        </td>
         <td>
            <?php echo $v->Area_Of_Expertise; ?> 
        </td>
         <td>
            <?php echo $v->Reports_Submitted; ?>
        </td>
         <td>
            <?php echo $v->Of_Reports_Sold; ?>
        </td>
         <td>
            <?php echo $v->Revenue_Generated; ?> 
        </td>
        <td>
            <a href="<?php echo site_url(); ?>api/expert_feedback/<?php echo $v->id; ?>">Check</a>
        </td>
    </tr>
     <?php
     $i = $i+1;
     }
    ?>
	</tbody>
</table>
<div id="expertProfileSlider" class="slidebar" style="margin-top:3px;display:none;height:95%;">
	<a href="" class="slidebar-close" onclick="return closeSlidebar(jQuery(this))"></a>
	<iframe id='frame' align="center" class='hide' width="100%" height="100%" src="about:blank" frameborder="0" allowfullscreen=""></iframe>
</div>
<script>
jQuery(window).ready(function(){
	changeSliderWidth();
});
function changeSliderWidth(){
	_w  =jQuery(window).width();
	_l = jQuery('.username').eq(0).offset();
	_cal = 100 - ((_l.left/_w)*100);
	jQuery('#expertProfileSlider').css('width',_cal+'%');
}
function openExpertProfile(src){
	jQuery('#expertProfileSlider').css({display:''});		
	if(jQuery('#expertProfileSlider').css('right')) {
		jQuery('#expertProfileSlider').animate({ right: 0 }, 300, function() {
			jQuery('#expertProfileSlider').find("#frame").removeClass('hide').addClass('show');
			jQuery('#expertProfileSlider').find("#frame").attr('src',src);
		});
	}
}
function closeSlidebar(obj,t) {
	_parentW = obj.parent().css('width');
	_parentW= parseInt(_parentW)+1;
	if(typeof t=="undefined"){
		jQuery(obj).parent().animate({ right: '-'+_parentW+'px' }, 300,function(){
			obj.parent().css('display','none');jQuery(obj).parent().find('iframe').attr('src','about:blank').removeClass('show').addClass('hide');
		});
	} else {
		jQuery(obj).parent().animate({ left: '-'+_parentW+'px' }, 300,function(){
			obj.parent().css('display','none');jQuery(obj).parent().find('iframe').attr('src','about:blank').removeClass('show').addClass('hide');
		});
	}
	return false;
}
function deleteExpert(ID,o){
	conf = confirm("Are you sure?");
	if(conf){
		jQuery.ajax({
			url:'<?php echo site_url(); ?>api/remove_expert',
			type:'POST',
			cache:false,
			data:{id:ID},
			dataType:'json'
		}).done(function(d){
			if(d.affected>0){
				expertsTable
				.fnDeleteRow(o.parents('tr'))
				.fnDraw();
			} else {
				alert(d.error);
			}
		})
	}	
}
</script>