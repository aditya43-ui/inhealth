<div class="control-group ">
        <div class="controls">
            <?php 
	            echo CHtml::checkBoxList('tujuansms',$modSmsgateway, CHtml::listData($modSmsgateway,'tujuansms','tujuansms'), array('style'=>'float:left'));
			?>
        </div>
    </div>
<script type="text/javascript">
    $(document).ready(function() {
        <?php foreach ($modSmsgateway as $i => $smsgateway) {   ?>
           $("#tujuansms").find("input[value*='<?php echo $smsgateway->tujuansms ?>']").prop( "checked", true );
        <?php } ?>
    });
</script>