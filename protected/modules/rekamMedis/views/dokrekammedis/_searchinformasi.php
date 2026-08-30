<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'rmdokrekammedisrm-t-search',
    'type' => 'horizontal',
)); ?>
<div class="row">
<div class="col-sm-12">
                    <div class="control-group">
                        <?php echo CHtml::label(CHtml::activeCheckBox($model, 'ceklis',array('checked'=>'checked')) . " <label for='RKDokrekammedisM_ceklis'>Tgl. Rekam Medik</label>", 'ceklis', array('class' => 'control-label')) ?>
                            <?php /*echo CHtml::label("Tgl. Rekam Medik", 'tgl_rekam', array('class' => 'control-label'))*/ ?>
                            <div class="controls">
                                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                                    <i class="entypo-calendar"></i>
                                    <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                                </div>
                            </div>
                        </div>
                    </div>
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'lokasirak_id', CHtml::listData($model->getLokasirakItems(), 'lokasirak_id', 'lokasirak_nama'), array('empty' => '-- Pilih --', 'class' => 'span4')); ?>
        <?php echo $form->dropDownListRow($model, 'subrak_id', CHtml::listData($model->getSubrakItems(), 'subrak_id', 'subrak_nama'), array('empty' => '-- Pilih --', 'class' => 'span4')); ?>
        <?php echo $form->textFieldRow($model, 'nodokumenrm', array('placeholder' => 'No. Dokumen RM', 'class' => 'span4 numbers-only', 'maxlength' => 11, 'autofocus' => true)); ?>
        <?php echo $form->textFieldRow($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4 hurufs-only')); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'nomortertier', array('placeholder' => '00', 'class' => 'numbers-only', 'style' => 'width:55px', 'maxlength' => 2)); ?>
        <?php echo $form->textFieldRow($model, 'nomorsekunder', array('placeholder' => '00', 'class' => 'numbers-only', 'style' => 'width:55px', 'maxlength' => 2)); ?>
        <?php echo $form->textFieldRow($model, 'nomorprimer', array('placeholder' => '00', 'class' => 'numbers-only', 'style' => 'width:55px', 'maxlength' => 2)); ?>
        <?php echo $form->dropDownListRow($model, 'statusrekammedis',  LookupM::getItems('statusrekammedis'), array('empty' => '-- Pilih --', 'class' => 'span2')) ?>
    </div>
</div>
<div class="form-actions">
    <?php
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    );
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/dokrekammedis/informasi'),
        array('title' => 'Ulang', 'class' => 'btn btn-default', 'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')
    );
    $tips = array(
        '0' => 'simpan',
        '1' => 'ulang',
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    // $content = $this->renderPartial('../tips/informasi', array(), true);
    // $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>
<!--======================== Begin Widget Dialog Login Pemakai =============================-->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPasien',
    'options' => array(
        'title' => 'Data Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 550,
        'resizable' => false,
    ),
));
?>
<?php
$modPasien = new PasienM();
$modPasien->unsetAttributes();
if (isset($_GET['LoginpemakaiK'])) {
    $modPasien->attributes = $_GET['PasienM'];
}
?>
<?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pasien-grid',
    'dataProvider' => $modPasien->search(),
    'filter' => $modPasien,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-check\"></i>","#",
                                            array(
                                                    "class"=>"btn-small",
                                                    "id" => "selectPasien",
                                                    "onClick" => "\$(\"#InformasipeminjamanrmV_nama_pasien\").val($data->nama_pasien);
                                                                          \$(\'#InformasipeminjamanrmV_no_rekam_medik\").val($data->no_rekam_medik);
                                                                          \$(\"#dialogPasien\").dialog(\"close\");"
                                             )
                             )',
        ),
        'nama_pasien',
        'no_rekam_medik',
        'jeniskelamin',
        'tanggal_lahir',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
)); ?>
<?php $this->endWidget(); ?>