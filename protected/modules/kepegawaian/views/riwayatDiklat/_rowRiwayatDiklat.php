<style>
    .panel-success .panel-heading {
        background-color: #6cccb9 !important;
        border-color: #6cccb9 !important;
    }
</style>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Riwayat Pegawai Diklat</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
            'id' => 'infoRiwayatDiklat-grid',
            'dataProvider' => $model->searchInfo($pegawai),
            //	'filter'=>$model, 
            'mergeHeaders' => array(
                0 => array(
                    'start' => 6,
                    'end' => 8,
                    'name' => 'Keputusan diklat',
                )
            ),
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
                    'header' => 'Jenis Diklat',
                    'type' => 'raw',
                    'value' => '(isset($data->jenisdiklat->jenisdiklat_nama) ? $data->jenisdiklat->jenisdiklat_nama : "-")',
                ),
                array(
                    'header' => 'Nama Diklat',
                    'type' => 'raw',
                    'value' => '$data->pegawaidiklat_nama',
                ),
                array(
                    'header' => 'Tanggal Mulai Diklat',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatDateTimeForUser(date("Y-m-d",strtotime($data->pegawaidiklat_tahun)))',
                ),
                array(
                    'header' => 'Lama Diklat',
                    'type' => 'raw',
                    'value' => '$data->pegawaidiklat_lamanya',
                ),
                array(
                    'header' => 'Tempat',
                    'type' => 'raw',
                    'value' => '$data->pegawaidiklat_tempat',
                ),
                array(
                    'header' => 'No.',
                    'type' => 'raw',
                    'value' => '$data->nomorkeputusandiklat',
                ),
                array(
                    'header' => 'Tanggal Penetapan',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatDateTimeForUser(date("Y-m-d",strtotime($data->tglditetapkandiklat)))',
                ),
                array(
                    'header' => 'Nama Pimpinan',
                    'type' => 'raw',
                    'value' => '$data->pejabatygmemdiklat',
                ),
                array(
                    'header' => 'Keterangan',
                    'type' => 'raw',
                    'value' => '$data->pegawaidiklat_keterangan',
                ),
                array(
                    'header' => 'Sertifikat',
                    'type' => 'raw',
                    'value' => function ($data){
                        if(!empty($data->sertifikat)){
                            return CHtml::link("<i class='icon-file-silver'></i>", Yii::app()->createUrl('kepegawaian/RealisasiPelatihanT/downloadSertifikat', array("pegawaidiklat_id"=>$data->pegawaidiklat_id)), array("id" => $data->pegawaidiklat_id, "rel" => "tooltip", "title" => "Klik untuk melihat sertifikat", "data-placement" => "left"));
                        }else{
                            return CHtml::Link("<i class='icon-file-silver'></i>", '', array('disabled' => true, 'style' => 'opacity: 0.3', "class" => "", "rel" => "tooltip", "title" => "Tombol akan aktif jika sudah mengisi realisasi pegawai"));
                        }
                    },
                    'htmlOptions' => array('style' => 'text-align: center; width: 60px;')
                ),
                array(
                    'header' => 'Masa Berlaku Sertifikat',
                    'type' => 'raw',
                    'value' => '(!empty($data->masaberlakusertifikat) ? MyFormatter::formatDateTimeForUser($data->masaberlakusertifikat) : "")',
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
                'id' => 'infoRiwayatDiklat-info-search',
                'type' => 'horizontal',
            ));
            ?>

            <div class="row">
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'Jenis Diklat', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($model, 'jenisdiklat_id', CHtml::listData(JenisdiklatM::model()->findAllByAttributes(array('jenisdiklat_aktif' => true), array('order' => 'jenisdiklat_nama')), 'jenisdiklat_id', 'jenisdiklat_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'Nama Diklat', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($model, 'pegawaidiklat_nama', array('placeholder' => 'Nama Diklat', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class='control-group'>
                        <?php echo $form->labelEx($model, 'Tanggal Mulai Diklat', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php $model->pegawaidiklat_tahun = $format->formatDateTimeForUser($model->pegawaidiklat_tahun); ?>
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'pegawaidiklat_tahun',
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
                        <?php echo $form->labelEx($model, 'Tempat', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($model, 'pegawaidiklat_tempat', array('placeholder' => 'Tempat', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                            <?php echo $form->hiddenField($model, 'pegawai_id', array('value' => $pegawai, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>
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