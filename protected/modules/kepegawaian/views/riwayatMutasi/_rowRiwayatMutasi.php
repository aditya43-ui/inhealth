<style>
    .panel-success .panel-heading {
        background-color: #6cccb9 !important;
        border-color: #6cccb9 !important;
    }
</style>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Riwayat Mutasi Pegawai</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'infoRiwayatMutasi-grid',
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
                    'header' => 'No. Surat',
                    'type' => 'raw',
                    'value' => '$data->nomorsurat',
                ),
                array(
                    'header' => 'Jabatan',
                    'type' => 'raw',
                    'value' => '$data->jabatan_nama',
                ),
                array(
                    'header' => 'No. SK',
                    'type' => 'raw',
                    'value' => '$data->nosk',
                ),
                array(
                    'header' => 'Tanggal SK',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tglsk)',
                ),
                array(
                    'header' => 'Dokumen',
                    'type' => 'raw',
                    'value' => function ($data){
                        if(!empty($data->dokumen)){
                            return CHtml::link("<i class='icon-file-silver'></i>", Yii::app()->createUrl('kepegawaian/MutasiKerjaPegawai/download', array("pegmutasi_id"=>$data->pegmutasi_id)), array("id" => $data->pegmutasi_id, "rel" => "tooltip", "title" => "Klik untuk melihat dokumen", "data-placement" => "left"));
                        }else{
                            return CHtml::Link("<i class='icon-file-silver'></i>", '', array('disabled' => true, 'style' => 'opacity: 0.3', "class" => "", "rel" => "tooltip", "title" => "Tombol akan aktif jika sudah mengisi pegawai mutasi"));
                        }
                    },
                    'htmlOptions' => array('style' => 'text-align: center; width: 60px;')
                ),
                array(
                    'header' => 'Tamat SK',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tmtsk)',
                ),
                array(
                    'header' => 'Jabatan Baru',
                    'type' => 'raw',
                    'value' => '$data->jabatan_baru',
                ),
                array(
                    'header' => 'Mengetahui',
                    'type' => 'raw',
                    'value' => '$data->mengetahui_nama',
                ),
                array(
                    'header' => 'Pimpinan',
                    'type' => 'raw',
                    'value' => '$data->pimpinan_nama',
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
                'id' => 'infoRiwayatMutasi-info-search',
                'type' => 'horizontal',
            ));
            ?>

            <div class="row">
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'No. Surat', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($model, 'nomorsurat', array('placeholder' => 'No. Surat', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'Jabatan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($model, 'jabatan_nama', array('placeholder' => 'Jabatan', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class='control-group'>
                        <?php echo $form->labelEx($model, 'Tanggal SK', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php $model->tglsk = $format->formatDateTimeForUser($model->tglsk); ?>
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tglsk',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                ),
                                'htmlOptions' => array(
                                    'readonly' => true,
                                    'class' => "span3",
                                    'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'Jabatan Baru', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($model, 'jabatan_baru', array('placeholder' => 'Jabatan Baru', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
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
            // $content = $this->renderPartial('../tips/informasi_riwayatPekerjaan', array(), true);
            // $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>