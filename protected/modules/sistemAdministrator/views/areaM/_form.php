<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sagolongan-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#' . CHtml::activeId($model, 'lemaribankjaringan_nama'),
        ));
?>
<div class="row-fluid">
    <p class="help-block" style="color:#333;"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
    <?php echo $form->errorSummary($model); ?>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model,'area_nama',array('class'=>'span3')); ?>
        <?php
        if (!$model->isNewRecord) {
            ?>
            <div class="control-group">
                <?php echo CHtml::label("", "", array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->checkBox($model, 'area_aktif', array()); ?> <label>Aktif</label>
                </div>
            </div>  
            <?php
        }
        ?>
        
    </div>
    <div class="col-sm-6">
       <?php echo $form->textFieldRow($model,'area_kode',array('class'=>'span3','onblur'=>'cekKode(this);')); ?>
        		
    </div>
</div>

<div class="form-actions">
    <?php
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit',));
    ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), '', array('class' => 'btn btn-default',
        'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
    ?>
    <?php echo $this->renderPartial($this->path_view . '_buttonPengaturan', ['model' => $model], true); ?>
    <?php
    $tips = array(
        '0' => 'simpan',
        '1' => 'ulang',
    );
    $content = $this->renderPartial($this->path_tips . 'detailTips', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));

    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);
    ?>
</div>
<?php $this->endWidget(); ?>

<script>
    var cekKode = (obj) => {
        var kd = $(obj).val();
        
        $.ajax({
            type: 'GET',
            url: '<?php echo $this->createUrl('cekKode'); ?>',
            data: {
                kode: kd,   
                area_id:'<?= $model->area_id ?>'
            },
            dataType: "json",
            success: function (data) {
                if (data.status == '0') {
                    toastr.error(data.pesan,"Perhatian!");
                    $(obj).val('');
                    return false;
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
                $(obj).val('');
            }
        });
    }
</script>
