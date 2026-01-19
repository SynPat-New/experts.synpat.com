<script type="text/javascript" src="<?php echo $Layout->baseUrl;?>public/widgets/datepicker/datepicker.js"></script>
<script type="text/javascript" src="<?php echo $Layout->baseUrl;?>public/widgets/datepicker-ui/datepicker.js"></script>
<script type="text/javascript">
    /* Datepicker bootstrap */

    $(function() { "use strict";
        $('.bootstrap-datepicker').bsdatepicker({
            format: 'yyyy-mm-dd'
        });
    });

</script>
<h2>Add Discount</h2>
<div class="panel">
	<div class="panel-body">
		<div class="example-box-wrapper">
			<?php echo form_open('api/add_discount',array('class'=>'form-horizontal bordered-row'));?>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Name</label> 
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id=""  name="discount[name]" required="required">
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-sm-3 control-label">Coupon Code</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id=""  name="discount[coupon_code]" required="required">
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-sm-3 control-label">Discount%</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id=""  name="discount[discount]" required="required">
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-sm-3 control-label">Start Date</label>
                    <div class="col-sm-6">
                        <input type="text" class="bootstrap-datepicker form-control" id=""  name="discount[start_date]" data-date-format="yyyy-mm-dd" required="required">
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-sm-3 control-label">End Date</label>
                    <div class="col-sm-6">
                        <input type="text" class="bootstrap-datepicker form-control" id=""  name="discount[end_date]" data-date-format="mm/dd/yy" required="required">
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-sm-3 control-label"></label>
                    <div class="col-sm-6">
                        <input type="submit" class="btn btn-primary mrg5R" value="Save"/>                        
                    </div>
                </div>
			<?php echo form_close();?>
		</div>
	</div>
</div>