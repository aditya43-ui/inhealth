<style>
    .panel-success .panel-heading {
        background-color: #6cccb9 !important;
        border-color: #6cccb9 !important;
    }
</style>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Riwayat Pribadi</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'infoRiwayatSusunanKeluarga-grid',
            'dataProvider' => $model->searchInfo($pegawai),
            //	'filter'=>$model,
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
            'columns' => array(
                array(
                    'header' => 'No.',
                    'value' => '($this->grid->dataProvider->pagination) ? 
                        ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                        : ($row+1)',
                    'type' => 'raw',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                array(
                    'header' => 'No. Urut Keluarga',
                    'type' => 'raw',
                    'value' => '$data->nourutkel',
                ),
                array(
                    'header' => 'Tanggung BPJS',
                    'type' => 'raw',
                    'value' => '(($data->istanggungan==true)?"Ya":"Tidak")',
                ),
                array(
                    'header' => 'No. Peserta BPJS',
                    'type' => 'raw',
                    'value' => '$data->nopesertabpjs',
                ),
                array(
                    'header' => 'No. Kartu Keluarga',
                    'type' => 'raw',
                    'value' => '$data->no_kartu_keluarga',
                ),
                array(
                    'header' => 'Hubungan Keluarga',
                    'type' => 'raw',
                    'value' => '$data->hubkeluarga',
                ),
                array(
                    'header' => 'Nama Susunan Keluarga',
                    'type' => 'raw',
                    'value' => '$data->susunankel_nama',
                ),
                array(
                    'header' => 'Jenis Kelamin',
                    'type' => 'raw',
                    'value' => '$data->susunankel_jk',
                ),
                array(
                    'header' => 'Tempat Lahir',
                    'type' => 'raw',
                    'value' => '$data->susunankel_tempatlahir',
                ),
                array(
                    'header' => 'Tanggal Lahir',
                    'type' => 'raw',
                    'value' => '$data->susunankel_tanggallahir',
                ),
                array(
                    'header' => 'Pekerjaan',
                    'type' => 'raw',
                    'value' => '$data->pekerjaan_nama',
                ),
                array(
                    'header' => 'Pendidikan',
                    'type' => 'raw',
                    'value' => '$data->pendidikan_nama',
                ),
                array(
                    'header' => 'Tanggal Pernikahan',
                    'type' => 'raw',
                    'value' => '$data->susunankel_tanggalpernikahan',
                ),
                array(
                    'header' => 'Tempat Pernikahan',
                    'type' => 'raw',
                    'value' => '$data->susunankel_tempatpernikahan',
                ),
                array(
                    'header' => 'NIP',
                    'type' => 'raw',
                    'value' => '$data->susunankeluarga_nip',
                ),
                array(
                    'header' => 'Hapus',
                    'class' => 'bootstrap.widgets.BootButtonColumn',
                    'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                    'template' => '{delete}',
                    'buttons' => array(
                        'delete' => array(),
                    )
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        )); ?>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> Pencarian
        </div>
    </div>
    <div class="panel-body">
        <div class="search-form">
            <?php
            $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                'action' => Yii::app()->createUrl($this->route),
                'method' => 'get',
                'id' => 'susunankeluarga-info-search',
                'type' => 'horizontal',
            ));
            ?>

            <div class="row">
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'NIP', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($model, 'susunankeluarga_nip', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>    
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'Nama', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($model, 'susunankel_nama', array('placeholder' => 'Nama', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'Jenis Kelamin', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($model, 'susunankel_jk', CHtml::ListData(LookupM::model()->findAllByAttributes(array('lookup_type' => 'jeniskelamin'), array('order' => 'lookup_urutan')), 'lookup_value', 'lookup_value'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'Hubungan Keluarga', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($model, 'hubkeluarga', array('placeholder' => 'Hubungan Keluarga', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('No. Peserta BPJS', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($model, 'nopesertabpjs', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>
                    <?php echo $form->hiddenField($model, 'pegawai_id', array('placeholder' => 'NIP', 'value' => $pegawai, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl('RencanaLemburT/Informasi'),
                array('title' => 'Ulang', 'class' => 'btn btn-default', 'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')
            ); ?>
            <?php
            // $content = $this->renderPartial('../tips/informasi_riwayatPribadi', array(), true);
            // $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>