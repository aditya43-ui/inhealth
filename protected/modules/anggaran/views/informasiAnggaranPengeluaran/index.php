<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'id' => 'infoanggaranpeng-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'noren_penerimaan'),
    'method' => 'get',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
));
Yii::app()->clientScript->registerScript('cariPasien', "
    $('#infoanggaranpeng-form').submit(function(){
            $.fn.yiiGridView.update('infoanggaranpeng-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    "); ?>
<div class="white-container">
    <legend class="rim2">Informasi <b>Anggaran Pengeluaran</b></legend>
    <?php
    $sukses = null;
    if (isset($_GET['sukses'])) {
        $sukses = $_GET['sukses'];
    }
    if ($sukses > 0) {
        Yii::app()->user->setFlash('success', "Data berhasil disimpan!");
    }

    $this->widget('bootstrap.widgets.BootAlert');
    ?>
    <div class="block-tabel">
        <h6>Tabel <b>Anggaran Pengeluaran</b></h6>
        <?php
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'infoanggaranpeng-grid',
            'dataProvider' => $model->search(),
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-striped table-condensed',
            'columns' => array(
                array(
                    'header' => 'No.',
                    'value' => '($this->grid->dataProvider->pagination) ? 
										($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
										: ($row+1)',
                    'type' => 'raw',
                    'htmlOptions' => array('style' => 'text-align:left; width:5px;'),
                ),
                array(
                    'name' => 'Nomor Pengeluaran',
                    'type' => 'raw',
                    'value' => '$data->rencanggaranpeng_no',
                ),
                array(
                    'header' => 'Periode Anggaran',
                    'type' => 'raw',
                    'name' => 'konfiganggaran_id',
                    'value' => '$data->konfiganggaran->deskripsiperiode',
                ),
                array(
                    'header' => 'Unit',
                    'type' => 'raw',
                    'name' => 'unitkerja_id',
                    'value' => '$data->unitkerja->namaunitkerja',
                ),
                array(
                    'header' => 'Total Pengeluaran',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatNumberForUser($data->TotalPengeluaran)',
                ),
                array(
                    'header' => 'Pegawai Mengetahui',
                    'type' => 'raw',
                    'value' => '(isset($data->mengetahui_id)? $data->mengetahui->nama_pegawai : "-").
								(isset($data->tglmengetahui) ? "<br>".MyFormatter::formatDateTimeForUser($data->tglmengetahui) : "")',
                ),
                array(
                    'header' => 'Pegawai Menyetujui',
                    'type' => 'raw',
                    'value' => '(isset($data->menyetujui_id)? $data->menyetujui->nama_pegawai : "-").
								(isset($data->tglmenyetujui) ? "<br>".MyFormatter::formatDateTimeForUser($data->tglmenyetujui) : "")',
                ),
                array(
                    'header' => 'Rincian',
                    'type' => 'raw',
                    'value' => 'CHtml::link("<icon class=\'icon-form-detail\'></icon> ", Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/Rincian", array("rencanggaranpeng_id"=>$data->rencanggaranpeng_id,"frame"=>true)), array("target"=>"frameRincian","rel"=>"tooltip", "title"=>"Klik untuk rincian", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');"))',
                    'htmlOptions' => array('style' => 'text-align: left;'),
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
        ?>
    </div>
    <fieldset class="box">
        <legend class="rim"><i class="entypo-search"></i> Pencarian</legend>
        <div class="row">
            <div class="col-sm-4">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'Nomor Pengeluaran', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'rencanggaranpeng_no', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",)); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'Periode Anggaran', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'konfiganggaran_id', CHtml::listData(AGKonfiganggaranK::model()->findAll(), 'konfiganggaran_id', 'deskripsiperiode'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'Unit Kerja', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'unitkerja_id', CHtml::listData(AGUnitkerjaM::model()->findAll(), 'unitkerja_id', 'namaunitkerja'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>

    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
        ); ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            $this->createUrl($this->id . '/index'),
            array(
                'class' => 'btn btn-default',
                'onclick' => 'myConfirm("Apakah Anda ingin mengulang pencarian ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('index') . '";} ); return false;'
            )
        ); ?>
        <?php
        $content = $this->renderPartial('pendaftaranPenjadwalan.views.tips.informasi', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>

    </div>

    <?php
    $this->endWidget();
    ?>
</div>
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRincian',
    'options' => array(
        'title' => 'Detail Rencana Anggaran Pengeluaran',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'resizable' => false,
    ),
));
?>
<iframe name='frameRincian' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>