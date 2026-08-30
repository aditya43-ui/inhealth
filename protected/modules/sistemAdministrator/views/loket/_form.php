<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'saloket-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">

    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'modelantrian_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'modelantrian_id', CHtml::listData(
                    ModelantrianM::model()->findAll('modelantrian_aktif = true order by modelantrian_nama'),
                    'modelantrian_id',
                    'modelantrian_nama'
                ), array('empty' => '-- Pilih --', 'class' => 'span3')); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'loket_nama', array('placeholder' => 'Nama loket', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'loket_namalain', array('placeholder' => 'Nama Lain', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <?php echo $form->textAreaRow($model, 'loket_fungsi', array('placeholder' => 'Fungsi', 'rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'loket_singkatan', array('placeholder' => 'Singkatan', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>

        <?php echo $form->textFieldRow($model, 'loket_nourut', array('placeholder' => 'No. urut', 'class' => 'span3 integer', 'onkeyup' => 'numberOnly(this);', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>

        <?php echo $form->textFieldRow($model, 'loket_formatnomor', array('placeholder' => 'Format nomor', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 5)); ?>
        <?php echo $form->textFieldRow($model, 'loket_maksantrian', array('placeholder' => 'Loket maks antrian', 'class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'carabayar_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'carabayar_id', CHtml::listData(
                    CarabayarM::model()->findAll('carabayar_aktif = true'),
                    'carabayar_id',
                    'carabayar_nama'
                ), array('empty' => '-- Pilih --', 'class' => 'span3')); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'filesuara', array('placeholder' => 'File suara', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 500)); ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'estimasiantrian', array('class' => 'control-label', 'label' => 'Estimasi Antrian')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'estimasiantrian', array('placeholder' => '00', 'class' => 'span1 numbers-only')); ?>
                <label> Menit</label>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'bukaloketantrian', array('class' => 'control-label', 'label' => 'Buka Loket Antrian')); ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'bukaloketantrian',
                    'mode' => 'time',
                    'htmlOptions' => array('class' => 'span2', 'readonly' => true, 'onclick' => "return $(this).focusNextInputField(event)"),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <?php echo $form->checkBox($model, 'ispendaftaran', array('id' => 'pendaftaran', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <label for="pendaftaran">Pendaftaran</label>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <?php echo $form->checkBox($model, 'is_penunjang', array('id' => 'penunjang', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <label for="penunjang">Penunjang</label>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <?php echo $form->checkBox($model, 'iskasir', array('id' => 'kasir', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <label for="kasir">Kasir</label>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <?php echo $form->checkBox($model, 'is_farmasi', array('id' => 'farmasi', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <label for="kasir">Farmasi</label>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <?php echo $form->checkBox($model, 'loket_aktif', array('id' => 'aktif', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <label for="aktif">Aktif</label>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('create'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Loket', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial($this->path_tips . 'tipsaddedit3a', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<?php
//========= Dialog buat cari Jenis Penjamin =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogCarabayar',
    'options' => array(
        'title' => 'Daftar Carabayar',
        'autoOpen' => false,
        'modal' => true,
        'width' => 980,
        'height' => 480,
        'resizable' => false,
    ),
));

$modCarabayar = new SACaraBayarM('search');
$modCarabayar->unsetAttributes();
if (isset($_GET['SACaraBayarM'])) {
    $modCarabayar->attributes = $_GET['SACaraBayarM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'carabayar-m-grid',
    'dataProvider' => $modCarabayar->search(),
    'filter' => $modCarabayar,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-check\"></i>",
							"#",
							array(
								"class"=>"btn-small", 
								"id" => "selectAlatmedis",
								"onClick" => "
								$(\"#' . CHtml::activeId($model, 'carabayar_id') . '\").val(\'$data->carabayar_id\');
								$(\"#' . CHtml::activeId($model, 'carabayar_nama') . '\").val(\'$data->carabayar_nama\');
								
								$(\'#dialogCarabayar\').dialog(\'close\');return false;"))'
        ),
        'carabayar_id',
        'carabayar_nama',
        'metode_pembayaran',
        'carabayar_loket',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>