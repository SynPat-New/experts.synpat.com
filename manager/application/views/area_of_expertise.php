<style>
.table tbody tr td label a{ color: hsl(3, 95%, 38%) !important; padding-top: 0 !important; }
.table tbody tr td p{text-align:left !important;}
.table thead tr th p{font-weight: bold; text-align:left !important;}
.table tbody tr td label{font-size: 13px; margin:0px; line-height:normal}
.table tbody tr td{
	background:none !important; 
	border-bottom: 1px solid hsl(210, 3%, 77%);
	line-height:14px !important;
	padding: 8px 0px;
}
.table tbody tr td:last-child,
.table thead tr th:last-child {
	padding-left: 8px;
}
.table tbody tr td:first-child,
.table thead tr th:first-child {
	padding-left: 0px;
}
.table .table {
	margin-bottom: -9px;
	margin-top: -8px;
}

.table thead tr th{
	background: #ffffff;
  	border-bottom: 1px solid #DDDDDD;
	padding: 8px 0px;
}
.table thead tr th p {
  	color: #cd2122 !important;
  	font-family: 'Open Sans', Helvetica, Arial, serif;;
  	font-size: 13px;
}
.check-align {
	width: 30px !important;
}
.check-align input {
	margin-right: 5px !important;
}
.check-align + td {
	width: 100px !important;
}

td.dot{font-weight:bold; font-size:14px; color:#000; padding-left:2px !important; padding-right:2px !important; padding-top:6px !important;}
table.customTable tbody tr td{border:0px solid #fff !important;}
table.customTable tbody tr td{padding-top:0px !important; padding-bottom:0px}
.table tbody tr td.arrow{background:#3A414D url(../img/arrowTop.png) no-repeat 4px 7px !important; width:2%}
.table tbody tr td.arrow2{background:#ffffff url(../img/aow.jpg) no-repeat 4px 7px !important; width:2%}
table.table.table > tbody > tr.hover1:hover > td{ border-top:1px solid #DDDDDD !important; border-bottom:1px solid #DDDDDD !important;}

table tbody tr td.check-align{
	padding-left:10px !important;
	text-align:right !important;
}
.classitemFocus{ 
	background-color:#EFEFEF !important;
	color:#0E2034 !important;
}
span.dot{
	display:inlin-block;
	font-size:150%;
	line-height:50%;
	padding-top:0.15em;
	margin-right:3px;
}
</style>
<div class="span12" style="background:#fff;">
	<table class="table table-striped" id="patent">						
			<thead>
				<tr style="background:#BDC2C7;">
					<th></th>
					<th style="text-align:center;"><p class="noMargin">Symbol</p></th>
					<th><p class="noMargin">Classification and description</p></th>
				</tr>
			</thead>
			<tbody>
			<?php 
				$parent = json_decode($experts_area);
				if(count($parent)>0){
					for($p=0;$p<count($parent);$p++){
			?>
				<tr class="classitemFocus">
					<td class="check-align"><input type="checkbox" name="parent_checked[]" value="<?php echo $parent[$p]->id;?>" onclick="checkBoxClick(jQuery(this),0);"></td>
					<td>	
						<label>									
							<a href="javascript:void(0);" onclick="getChildData(jQuery(this),0)" rel="<?php echo $parent[$p]->id;?>" style="padding-top:3px; display:inline-block;"><?php echo $parent[$p]->name;?></a>
						 </label>
					</td>
					<td>
						<p class="noMargin" style="margin-top:4px !important;"><?php echo $parent[$p]->classification_description;?></p>
					</td>
				</tr>
			<?php
					}
				}
			?>
		</tbody>
	</table>
</div>
<script>
	_siteURL = '<?php echo site_url(); ?>';
	_expertArea =[];
	_selectedAreaVal = [];
	_selectedAreaName = [];
	function checkBoxClick(o,l){
		if(o.is(':checked')){
			_push = true;
			jQuery.each(_selectedAreaVal,function(index,area){
				if(area==o.val()){
					_push = false;
				}
			});
			if(_push===true){
				_selectedAreaVal.push(o.val());
				console.log(o.parent().parent().html());
				console.log(o.parent().parent().find('td').html());
				_selectedAreaName.push(o.parent().parent().find('td').eq(1).find('a').text());
			}
		} else {
			jQuery.each(_selectedAreaVal,function(index,area){
				if(area==o.val()){
					_selectedAreaVal.splice(index,1);
					_selectedAreaName.splice(index,1);
				}
			});
		}
		console.log(_selectedAreaName);
		window.parent.jQuery("#expertise_code").val(_selectedAreaName.join(','));
	}
	
	function checkBoxClickWithParent(o,l){
		checkBoxClick(o,l);
	}
	
	function getChildData(object,level){					
		_getParentID = object.attr('rel');					
		object.addClass('active');
		_parentObject = object.parent().parent().parent().index();
		_PARENTOBJECT = object.parent().parent().parent().parent();
		
		jQuery("#patent>tbody>tr").each(function(index){
			if(index>0){
				jQuery(this).removeClass('classitemFocus');
			}		 					
		});	
		jQuery('#childTable>tbody>tr').each(function(index){
			jQuery(this).removeClass('classitemFocus');
		});	
		jQuery('#child1Table>tbody>tr').each(function(index){
			jQuery(this).removeClass('classitemFocus');
		});	
		jQuery('#child2Table>tbody>tr').each(function(index){
			jQuery(this).removeClass('classitemFocus');
		});						
		object.parent().parent().parent().addClass('classitemFocus');
		if(parseInt(_getParentID)>0){
			jQuery.ajax({
				url:_siteURL+'api/childData',
				type:'POST',
				data:{pat:_getParentID,l:level,format:''},
				cache:false,
				success:function(data){
					_parsingData = jQuery.parseJSON(data);
					if(_parsingData.length>0){															
						switch(parseInt(level)){
							case 0:
								if(jQuery('#patent>tbody>tr').eq(_parentObject).next().attr('class')=='relatedData'){
									if(jQuery('#patent>tbody>tr').eq(_parentObject).next().css('display')=='none'){
										jQuery('#patent>tbody>tr').eq(_parentObject).next().css('display','table-row');
									} else {
										jQuery('#patent>tbody>tr').eq(_parentObject).next().css('display','none');
									}
								} else {		
									appendTr = jQuery('<tr/>').addClass('relatedData').css('display','table-row').attr('parent-rel',_getParentID);
									appendTd = jQuery('<td/>').attr('colspan','3');
									appendTable = jQuery('<table/>').addClass('table table-striped').attr('id','childTable');
									_checkCheckBox = object.parent().parent().parent().find('input[name="parent_checked"]').is(':checked');
									_checkString = "";												
									if(_checkCheckBox==true){
										_checkString = 'CHECKED="CHECKED"';
									}
									_flag=0;												
									for(i=0;i<_parsingData.length;i++){
										if(_checkString==""){
											if(_expertArea.length>0){
												_checkString = '';														
												if(jQuery.inArray(parseInt(_parsingData[i].id),_expertArea)>=0){														
													_flag=1;
													_checkString = 'CHECKED="CHECKED"';
												}else {
													_checkString = '';
												}
											}
										}
										appendChildTr = jQuery('<tr/>').addClass('child');
										jQuery(appendChildTr).append('<td class="check-align"><input '+_checkString+' type="checkbox" name="child_1[]" onclick="checkBoxClick(jQuery(this),1)" value="'+_parsingData[i].id+'" style=""/></td><td><label><a style="padding-top:3px; display:inline-block;" rel="'+_parsingData[i].id+'" href="javascript:void(0);" onclick="getChildData(jQuery(this),1)">'+_parsingData[i].name+'</a></label></td><td><p style="margin-top:4px !important;" class="noMargin">'+_parsingData[i].classification_description+'</p></td>');
										jQuery(appendTable).append(appendChildTr);
										if(_flag==1){
											_checkString = '';
										}
									}
									jQuery(appendTd).append(appendTable);
									jQuery(appendTr).append(appendTd);
									jQuery('#patent>tbody>tr').eq(_parentObject).after(appendTr);
								}											
							break;
							case 1:		
								//alert(_PARENTOBJECT.html());
								if(object.parent().parent().parent().next().attr('class')=='relatedData'){
									
									if(object.parent().parent().parent().next().css('display')=='none'){
										
										object.parent().parent().parent().next().css('display','table-row');
									} else {
										
										object.parent().parent().parent().next().css('display','none');
									}
								} else {
								
								appendTr = jQuery('<tr/>').addClass('relatedData').css('display','table-row').attr('parent-rel',_getParentID);
								appendTd = jQuery('<td/>').attr('colspan','3');
								appendTable = jQuery('<table/>').addClass('table table-striped').attr('id','child1Table');		 		
								_checkCheckBox = object.parent().parent().parent().find('input[name="child_1[]"]').is(':checked');
								_checkString = "";												
								if(_checkCheckBox==true){
									_checkString = 'CHECKED="CHECKED"';
								} 
								_flag=0;
								for(i=0;i<_parsingData.length;i++){
									if(_checkString==""){
										if(_expertArea.length>0){
											_checkString = '';							
											if(jQuery.inArray(parseInt(_parsingData[i].id),_expertArea)>=0){									
												
												_flag=1;
												_checkString = 'CHECKED="CHECKED"';
											}else {
												_checkString = '';
											}
										}
									}
									appendChildTr = jQuery('<tr/>');
									jQuery(appendChildTr).append('<td class="check-align"><input '+_checkString+' type="checkbox" name="child_2[]" onclick="checkBoxClick(jQuery(this),2)" value="'+_parsingData[i].id+'" style=""/></td><td><label><a style="padding-top:3px; display:inline-block;" rel="'+_parsingData[i].id+'" href="javascript:void(0);" onclick="getChildData(jQuery(this),2)">'+_parsingData[i].name+'</a></label></td><td><p style="margin-top:4px !important;" class="noMargin">'+_parsingData[i].classification_description+'</p></td>');
									jQuery(appendTable).append(appendChildTr);
									if(_flag==1){
										_checkString = '';
									}
								}
								jQuery(appendTd).append(appendTable);
								jQuery(appendTr).append(appendTd);
								object.parent().parent().parent().after(appendTr);
								}
							break;
							case 2:		
								if(object.parent().parent().parent().next().attr('class')=='relatedData1'){
									if(object.parent().parent().parent().next().css('display')=='none'){
										object.parent().parent().parent().next().css('display','table-row');
									} else {
										object.parent().parent().parent().next().css('display','none');
									}
								} else {
								appendTr = jQuery('<tr/>').addClass('relatedData1').css('display','table-row').attr('parent-rel',_getParentID);
								appendTd = jQuery('<td/>').attr('colspan','3');
								appendTable = jQuery('<table/>').addClass('table table-striped').attr('id','child2Table');		
								_checkCheckBox = object.parent().parent().parent().find('input[name="child_2[]"]').is(':checked');
								_checkString = "";												
								if(_checkCheckBox==true){
									_checkString = 'CHECKED="CHECKED"';
								}
								_flag=0;
								for(i=0;i<_parsingData.length;i++){
									if(_checkString==""){
										if(_expertArea.length>0){
											_checkString = '';														
											if(jQuery.inArray(parseInt(_parsingData[i].id),_expertArea)>=0){														
												_flag=1;
												_checkString = 'CHECKED="CHECKED"';
											}else {
												_checkString = '';
											}
										}
									}
									appendChildTr = jQuery('<tr/>').css({background:'#ffffff'});
									jQuery(appendChildTr).append('<td class="check-align"><input '+_checkString+' type="checkbox" name="child_3[]" onclick="checkBoxClick(jQuery(this),3)" value="'+_parsingData[i].id+'" style=""/></td><td><label><a style="padding-top:3px; display:inline-block;"  rel="'+_parsingData[i].id+'" href="javascript:void(0);" onclick="getChildData(jQuery(this),3)">'+_parsingData[i].name+'</a></label></td><td><p style="margin-top:4px !important;" class="noMargin">'+_parsingData[i].classification_description+'</p></td>');
									jQuery(appendTable).append(appendChildTr);
									if(_flag==1){
										_checkString = '';
									}
								}
								jQuery(appendTd).append(appendTable);
								jQuery(appendTr).append(appendTd);
								object.parent().parent().parent().after(appendTr);
								}
							break;
							case 3:											
								if(object.parent().parent().parent().next().attr('class')=='relatedData2'){
									if(object.parent().parent().parent().next().css('display')=='none'){
										object.parent().parent().parent().next().css('display','table-row');
									} else {
										object.parent().parent().parent().next().css('display','none');
									}
								} else {
								appendTr = jQuery('<tr/>').addClass('relatedData2').css('display','table-row').attr('parent-rel',_getParentID);							
								appendTd = jQuery('<td/>').attr('colspan','3');
								appendTable = jQuery('<table/>').addClass('table table-striped').attr('id','child3Table');		
								_checkCheckBox = object.parent().parent().find('input[name="child_3[]"]').is(':checked');
								_checkString = "";												
								if(_checkCheckBox==true){
									_checkString = 'CHECKED="CHECKED"';
								}
								_flag=0;
								for(i=0;i<_parsingData.length;i++){
									appendChildTr = jQuery('<tr/>').css({background:'#FFF'});
									_stringDot = '';
									if(parseInt(_parsingData[i].level)>0){
										for(st=0;st<parseInt(_parsingData[i].level);st++){
											_stringDot+="<span class='dot'>&#8226;</span>";
										}
									}
									if(_checkString==""){
										if(_expertArea.length>0){
											_checkString = '';
											if(jQuery.inArray(parseInt(_parsingData[i].id),_expertArea)>=0){												
												_flag=1;
												_checkString = 'CHECKED="CHECKED"';
											}else {
												_checkString = '';
											}
										}
									}
									jQuery(appendChildTr).append('<td class="check-align"><input '+_checkString+' type="checkbox" name="child_4[]" onclick="checkBoxClickWithParent(jQuery(this),'+_parsingData[i].id+')" big_parent="'+_parsingData[i].big_parent+'" parent="'+_parsingData[i].parent+'" value="'+_parsingData[i].id+'" style=""/></td><td><label><a style="padding-top:3px; display:inline-block;"  href="javascript:void(0);" >'+_parsingData[i].name+'</a></label></td><td><p style="margin-top:4px !important;" class="noMargin">'+_stringDot+' '+_parsingData[i].classification_description+'</p></td>');
									jQuery(appendTable).append(appendChildTr);
									if(_flag==1){
										_checkString = '';
									}
								}
								jQuery(appendTd).append(appendTable);
								jQuery(appendTr).append(appendTd);
								object.parent().parent().parent().after(appendTr);
								}
							break;
						}
						
					}
				}
			});
		}
	}
</script>