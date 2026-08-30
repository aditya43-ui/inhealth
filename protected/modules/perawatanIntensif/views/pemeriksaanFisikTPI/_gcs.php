<?php 
            
$crit = new CDbCriteria();
$crit->addCondition("LOWER(metodegcs_singkatan) = :singkatan");
$crit->addCondition('metodegcs_nilai is not null');
$crit->order = 'metodegcs_nilai ASC';

$crit->params = array(":singkatan"=>"e");
$list_gcs_eye = CHtml::listData(PIMetodeGCSM::model()->findAll($crit), 'metodegcs_nilai', 'textMetodeGCSM');
$crit->params = array(":singkatan"=>"v");
$list_gcs_verbal = CHtml::listData(PIMetodeGCSM::model()->findAll($crit), 'metodegcs_nilai', 'textMetodeGCSM');
$crit->params = array(":singkatan"=>"m");
$list_gcs_motorik = CHtml::listData(PIMetodeGCSM::model()->findAll($crit), 'metodegcs_nilai', 'textMetodeGCSM');
$crit->params = array(":singkatan"=>"be");
$list_gcs_eye_bayi = CHtml::listData(PIMetodeGCSM::model()->findAll($crit), 'metodegcs_nilai', 'textMetodeGCSM');
$crit->params = array(":singkatan"=>"bv");
$list_gcs_verbal_bayi = CHtml::listData(PIMetodeGCSM::model()->findAll($crit), 'metodegcs_nilai', 'textMetodeGCSM');
$crit->params = array(":singkatan"=>"bm");
$list_gcs_motorik_bayi = CHtml::listData(PIMetodeGCSM::model()->findAll($crit), 'metodegcs_nilai', 'textMetodeGCSM');

?>
<div class="gcs_dewasa gcs_panel">
    <div class="control-group">
        <?php echo $form->labelEx($modPemeriksaanFisik,'gcs_eye', array('class'=>'control-label')) ?>
        <div class="controls base_gcs">
            <?php echo $form->dropDownList($modPemeriksaanFisik,'gcs_eye',$list_gcs_eye,array('empty'=>'-- Pilih --', 'class'=>'span3 input_gcs', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>

        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($modPemeriksaanFisik,'gcs_verbal',array('class'=>'control-label')); ?>
        <div class="controls base_gcs">
            <?php echo $form->dropDownList($modPemeriksaanFisik,'gcs_verbal',$list_gcs_verbal,array('empty'=>'-- Pilih --', 'class'=>'span3 input_gcs', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>

        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($modPemeriksaanFisik,'gcs_motorik',array('class'=>'control-label')); ?>
        <div class="controls base_gcs">
            <?php echo $form->dropDownList($modPemeriksaanFisik,'gcs_motorik',$list_gcs_motorik,array('empty'=>'-- Pilih --', 'class'=>'span3 input_gcs', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>

        </div>
    </div>
</div>

<div class="gcs_bayi gcs_panel">
    <div class="control-group">
        <?php echo $form->labelEx($modPemeriksaanFisik,'gcs_eye',array('class'=>'control-label')); ?>
        <div class="controls base_gcs">
            <?php echo $form->dropDownList($modPemeriksaanFisik,'gcs_eye',$list_gcs_eye_bayi,array('empty'=>'-- Pilih --', 'class'=>'span3 input_gcs', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($modPemeriksaanFisik,'gcs_verbal',array('class'=>'control-label')); ?>
        <div class="controls base_gcs">
            <?php echo $form->dropDownList($modPemeriksaanFisik,'gcs_verbal',$list_gcs_verbal_bayi,array('empty'=>'-- Pilih --', 'class'=>'span3 input_gcs', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelEx($modPemeriksaanFisik,'gcs_motorik',array('class'=>'control-label')); ?>
        <div class="controls base_gcs">
            <?php echo $form->dropDownList($modPemeriksaanFisik,'gcs_motorik',$list_gcs_motorik_bayi,array('empty'=>'-- Pilih --', 'class'=>'span3 input_gcs', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
</div>


  

<script>

var singkatan = "";
var obj_input = null;

function setFormGCS(obj, sing) {
    obj_input = obj;
    singkatan = sing;
    
    $("#form_gcs :input").val("");
    $("#dialogGcs").dialog("open");
    $("#form_gcs_metodegcs_singkatan").val(sing);
}

function tambahGCS() {
    $("#form_gcs_submit").prop("disabled", true);
    $.post('<?php echo $this->createUrl('simpanGCS'); ?>', $("#form_gcs").serialize(), function(data) {
        if (data.ok == 1) {
            $("#dialogGcs").dialog("close");
            myAlert(data.msg);
            $(obj_input).parents(".base_gcs").find(".input_gcs").html(data.option);
        } else {
            myAlert(data.msg);
        }
        $("#form_gcs_submit").prop("disabled", false);
    }, 'json');
}

</script>
    
    

