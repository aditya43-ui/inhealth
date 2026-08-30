<div class="control-group">
        <?php //echo $form->labelEx($modSmsgateway,'tujuansms', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php 
                foreach ($modSmsgateway as $idx=>$item) {
                    echo CHtml::checkBox('tujuansms['.$idx."]", $item->tujuansms == Params::TUJUANSMS_PASIEN, array('value'=>$item->tujuansms, 'uncheckValue'=>null))." ".$item->tujuansms."<br>";
                }
	            //echo CHtml::checkBoxList('tujuansms',$modSmsgateway, CHtml::listData($modSmsgateway,'tujuansms','tujuansms'), array('style'=>'float:left'));
            ?>
        </div>
    </div>
<script type="text/javascript">
    $(document).ready(function() {
        <?php foreach ($modSmsgateway as $i => $smsgateway) {   ?>
           $("#tujuansms").find("input[value*='<?php echo $smsgateway->tujuansms ?>']").prop( "checked", "" );
        <?php } ?>
        
    });
</script>