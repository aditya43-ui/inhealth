<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sajeniskegiatanlab-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#' . CHtml::activeId($model, 'jeniskegiatanlab_kode'),
));
?>

<div class="row">
    <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                ?></p>-->
    <?php echo $form->errorSummary($model); ?>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'jeniskegiatanlab_kode', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'placeholder' => 'Kode')); ?>
        <?php echo $form->textFieldRow($model, 'jeniskegiatanlab1', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'jeniskegiatanlab2', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'jeniskegiatanlab3', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'jeniskegiatanlab_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'jeniskegiatanlab_aktif', array('id' => 'aktif')); ?> <label for="aktif">Aktif</label>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'title' => 'Simpan')
    ); ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('create'),
        array(
            'class' => 'btn btn-default',
            'title' => 'Ulang',
            'onclick' => 'return refreshForm(this);'
        )
    );
    ?>
    <?php //echo CHtml::link(Yii::t('mds','{icon} Pengaturan Pemeriksaan Lab',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',)); 
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Jenis Kegiatan Lab', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial($this->path_view . 'tips/tipsCreate', array(), true);
    $this->widget('UserTips', array('type' => 'create', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<?php
//========= Dialog buat cari data Bidang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogTindakan',
    'options' => array(
        'title' => 'Daftar Tindakan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 480,
        'resizable' => true,
    ),
));

$modTindakan = new SADaftarTindakanM('search');
$modTindakan->unsetAttributes();
if (isset($_GET['SADaftarTindakanM'])) {
    $modTindakan->attributes = $_GET['SADaftarTindakanM'];
    $modTindakan->daftartindakan_nama = $_GET['SADaftarTindakanM']['daftartindakan_nama'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'sainstalasi-m-grid',
    'dataProvider' => $modTindakan->searchDialog(),
    'filter' => $modTindakan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>",
							"#",
							array(
								"class"=>"btn-small", 
								"id" => "selectTindakan",
								"onClick" => "
								$(\"#' . CHtml::activeId($model, 'daftartindakan_id') . '\").val(\'$data->daftartindakan_id\');
								$(\"#daftartindakan_nama\").val(\'$data->daftartindakan_nama\');
								$(\'#dialogTindakan\').dialog(\'close\');return false;"))'
        ),
        'kategoritindakan_nama',
        'kelompoktindakan_nama',
        'daftartindakan_kode',
        'daftartindakan_nama',

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>