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
        <div class="control-group">
            <?php echo CHtml::label("Kelompok Pemeriksaan <span class='required'>*</span>", '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'jenispemeriksaanlab_kelompok', CHtml::listData(LookupM::model()->findAllByAttributes(array('lookup_type' => 'jenispemeriksaanlab_kelompok', 'lookup_aktif' => true)), 'lookup_value', 'lookup_value'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Cara Ambil Sampel <span class='required'>*</span>", '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'caraambilsampel_nama', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <?php //echo $form->dropDownListRow($model, 'jenispemeriksaanlab_id', CHtml::listData(JenispemeriksaanlabM::model()->findAll(array('order' => 'jenispemeriksaanlab_urutan', 'condition' => 'jenispemeriksaanlab_aktif = true'), 'jenispemeriksaanlab_aktif = true'), 'jenispemeriksaanlab_id', 'jenispemeriksaanlab_nama'), array('empty' => '-- Pilih --', 'class' => 'span3 jenispemeriksaanlab_id', 'onkeyup' => "return $(this).focusNextInputField(event);")); 
        ?>
        <?php //echo $form->dropDownListRow($model, 'samplelab_id', CHtml::listData(SamplelabM::model()->findAllByAttributes(array('samplelab_aktif' => true)), 'samplelab_id', 'samplelab_nama'), array('class' => 'span3 samplelab_id', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); 
        ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'caraambilsampel_kode', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'caraambilsampel_urutan', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'caraambilsampel_aktif', array('id' => 'aktif')); ?> <label for="aktif">Aktif</label>
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
        Yii::t('mds', '{icon} Pengaturan Cara Ambil', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
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
<script>
    $(document).ready(function() {
        multi();
    });

    function multi() {
        var kelompoklab = jQuery('.jenispemeriksaanlab_kelompok');
        var samplelab = jQuery('.samplelab_id');
        var jenislab = jQuery('.jenispemeriksaanlab_id');

        jQuery(kelompoklab).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
        }).hide();

        jQuery(samplelab).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
        }).hide();

        jQuery(jenislab).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
        }).hide();
    }
</script>