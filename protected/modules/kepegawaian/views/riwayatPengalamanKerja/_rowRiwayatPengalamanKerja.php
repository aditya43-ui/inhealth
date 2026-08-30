<style>
    .panel-success .panel-heading {
        background-color: #6cccb9 !important;
        border-color: #6cccb9 !important;
    }
</style>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Riwayat Pengalaman Kerja</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'infoRiwayatPengalamanKerja-grid',
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
                    'header' => 'Nama perusahaan',
                    'type' => 'raw',
                    'value' => '$data->namaperusahaan',
                ),
                array(
                    'header' => 'Bidang usaha',
                    'type' => 'raw',
                    'value' => '$data->bidangperusahaan',
                ),
                array(
                    'header' => 'Jabatan',
                    'type' => 'raw',
                    'value' => '$data->jabatanterahkir',
                ),
                array(
                    'header' => 'Tanggal Masuk',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tglmasuk)',
                ),
                array(
                    'header' => 'Tanggal Keluar',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tglkeluar)',
                ),
                array(
                    'header' => 'Lama Kerja',
                    'type' => 'raw',
                    'value' => '$data->lama_tahun." tahun ".$data->lama_bulan." bulan."',
                ),
                array(
                    'header' => 'Alasan Berhenti',
                    'type' => 'raw',
                    'value' => '$data->alasanberhenti',
                ),
                array(
                    'header' => 'Keterangan',
                    'type' => 'raw',
                    'value' => '$data->keterangan',
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
        <div class="search-form" style="display:true">
            <?php
            $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                'action' => Yii::app()->createUrl($this->route),
                'method' => 'get',
                'id' => 'infoRiwayatPengalamanKerja-info-search',
                'type' => 'horizontal',
            ));
            ?>

            <div class="row">
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'Nama Perusahaan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($model, 'namaperusahaan', array('placeholder' => 'Nama Perusahaan', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'Bidang Usaha', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($model, 'bidangperusahaan', array('placeholder' => 'Bidang Usaha', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'Jabatan Terakhir', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($model, 'jabatanterahkir', array('placeholder' => 'Jabatan Terakhir', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'Alasan Berhenti', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($model, 'alasanberhenti', array('placeholder' => 'Alasan Berhenti', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>
                    <?php echo $form->hiddenField($model, 'pegawai_id', array('value' => $pegawai, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
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