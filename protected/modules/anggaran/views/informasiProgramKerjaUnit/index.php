<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'id' => 'infoprogramkerjaunit-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'noren_penerimaan'),
    'method' => 'get',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
));
Yii::app()->clientScript->registerScript('cariPasien', "
    $('#infoprogramkerjaunit-form').submit(function(){
            $.fn.yiiGridView.update('infoprogramkerjaunit-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    "); ?>
<div class="white-container">
    <legend class="rim2">Informasi <b>Program Kerja Unit</b></legend>
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
        <h6>Tabel <b>Program Kerja Unit</b></h6>
        <?php
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'infoprogramkerjaunit-grid',
            'dataProvider' => $model->searchInformasi(),
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-striped table-condensed',
            'columns' => array(
                array(
                    'header' => 'No.',
                    'value' => '($this->grid->dataProvider->pagination) ? 
										($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
										: ($row+1)',
                    'type' => 'raw',
                    'htmlOptions' => array('style' => 'text-align:center; width:5px;'),
                ),
                array(
                    'name' => 'Periode',
                    'type' => 'raw',
                    'value' => '$data->deskripsiperiode',
                    'htmlOptions' => array('style' => 'width:180px')
                ),
                array(
                    'name' => 'Unit',
                    'type' => 'raw',
                    'value' => '$data->namaunitkerja',
                    'htmlOptions' => array('style' => 'width:100px')
                ),
                array(
                    'name' => 'Kode Program',
                    'type' => 'raw',
                    'value' => '$data->programkerja_kode.".".$data->subprogramkerja_kode.".".$data->kegiatanprogram_kode.".".$data->subkegiatanprogram_kode',
                    'htmlOptions' => array('style' => 'width:100px')
                ),
                array(
                    'name' => 'Program Kerja',
                    'type' => 'raw',
                    'value' => '$data->programkerja_nama',
                ),
                array(
                    'name' => 'Sub Program Kerja',
                    'type' => 'raw',
                    'value' => '$data->subprogramkerja_nama',
                ),
                array(
                    'name' => 'Kegiatan Program Kerja',
                    'type' => 'raw',
                    'value' => '$data->kegiatanprogram_nama',
                ),
                array(
                    'name' => 'Sub Kegiatan Program Kerja',
                    'type' => 'raw',
                    'value' => '$data->subkegiatanprogram_nama',
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
                    <?php echo $form->labelEx($model, 'Periode Anggaran', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'konfiganggaran_id', CHtml::listData(AGKonfiganggaranK::model()->findAll(), 'konfiganggaran_id', 'deskripsiperiode'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange' => 'periodeAnggaran();')); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'Unit Kerja', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'unitkerja_id', CHtml::listData(AGUnitkerjaM::model()->findAll(), 'unitkerja_id', 'namaunitkerja'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange' => 'periodeAnggaran();')); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'Program Kerja', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'programkerja_nama', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",)); ?>
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