<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sakelompok-menu-k-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'kelmenu_nama'),
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'kelmenu_nama', array('placeholder' => 'Kelompok Menu', 'class' => 'span3', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return nextFocus(this,event,'SAKelompokMenuK_kelmenu_namalainnya','')", 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'kelmenu_namalainnya', array('placeholder' => 'Nama Lain', 'class' => 'span3', 'onkeypress' => "return nextFocus(this,event,'SAKelompokMenuK_kelmenu_key','SAKelompokMenuK_kelmenu_nama')", 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'kelmenu_key', array('placeholder' => 'Key', 'class' => 'span3', 'onkeypress' => "return nextFocus(this,event,'SAKelompokMenuK_kelmenu_url','SAKelompokMenuK_kelmenu_namalainnya')", 'maxlength' => 100)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'kelmenu_url', array('placeholder' => 'URL', 'class' => 'span3', 'onkeypress' => "return nextFocus(this,event,'SAKelompokMenuK_kelmenu_urutan','SAKelompokMenuK_kelmenu_key')", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'kelmenu_urutan', array('placeholder' => '00', 'class' => 'span1 numbers-only', 'onkeypress' => "return nextFocus(this,event,'SAKelompokMenuK_kelmenu_aktif','SAKelompokMenuK_kelmenu_url')")); ?>
        <div class="control-group">
            <?php echo CHtml::activeLabel($model, 'kelmenu_icon', array('class' => 'control-label',)); ?>
            <div class="input-append">
                <div class="controls">
                    <?php echo CHtml::activeTextField($model, 'kelmenu_icon', array('class' => 'span3', 'maxlength' => 100, 'readonly' => false)); ?>

                    <?php echo CHtml::link('<i class="entypo-search"></i>', '#', array('class' => 'btn btn-primary', 'onclick' => '$("#dialogIcon").dialog("open"); return false;')); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php //echo $form->checkBoxRow($model,'kelmenu_aktif', array('onkeypress'=>"return nextFocus(this,event,'btn_simpan','SAKelompokMenuK_kelmenu_urutan')")); 
?>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/kelompokMenuK/admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Kelompok Menu', array('{icon}' => '<i class="entypo-folder"></i>')),
        $this->createUrl('/sistemAdministrator/kelompokMenuK/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('../tips/tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogIcon',
    'options' => array(
        'title' => 'Pilih Icon',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'height' => 500,
        'resizable' => false,
    ),
));

$modIconDialog = new SALookupM('search');
$modIconDialog->unsetAttributes();
$lookup_type = 'kelmenu_icon';
$format = new MyFormatter();
if (isset($_GET['SALookupM'])) {
    $modIconDialog->attributes = $_GET['SALookupM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'lookup-m-grid',
    'dataProvider' => $modIconDialog->searchLookup($lookup_type),
    'filter' => $modIconDialog,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-check\"></i>","#",array("rel"=>"tooltip","title"=>"Pilih Obat/Alkes","class"=>"btn_small",
                "id"=>"selectObat",
                "onClick"=>"
                            $(\"#' . CHtml::activeId($model, 'kelmenu_icon') . '\").val(\"$data->lookup_name\");
                            $(\"#dialogIcon\").dialog(\"close\");
                            return false;
                ",
               ))'
        ),

        array(
            'header' => 'Icon',
            'value' => '"<i class=$data->lookup_name></i>"',
            'type' => 'raw',
        ),
        array(
            'header' => 'Nama Icon',
            'name' => 'lookup_name',
            'value' => '$data->lookup_name',
            'type' => 'raw',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
<script type="text/javascript">
    function namaLain(nama) {
        document.getElementById('SAKelompokMenuK_kelmenu_namalainnya').value = nama.value.toUpperCase();
        document.getElementById('SAKelompokMenuK_kelmenu_key').value = nama.value;
    }
</script>