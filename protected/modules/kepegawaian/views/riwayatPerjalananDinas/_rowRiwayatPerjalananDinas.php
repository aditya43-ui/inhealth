<style>
    .panel-success .panel-heading {
        background-color: #6cccb9 !important;
        border-color: #6cccb9 !important;
    }
</style>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Riwayat Perjalanan Dinas</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'infoRiwayatPerjalanDinas-grid',
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
                    'header' => 'No. Urut',
                    'type' => 'raw',
                    'value' => '$data->nourutperj',
                ),
                array(
                    'header' => 'Tujuan Dinas',
                    'type' => 'raw',
                    'value' => '$data->tujuandinas',
                ),
                array(
                    'header' => 'Tugas Dinas',
                    'type' => 'raw',
                    'value' => '$data->tugasdinas',
                ),
                array(
                    'header' => 'Keterangan',
                    'type' => 'raw',
                    'value' => '$data->descdinas',
                ),
                array(
                    'header' => 'Alamat Tujuan',
                    'type' => 'raw',
                    'value' => '$data->alamattujuan',
                ),
                array(
                    'header' => 'Provinsi',
                    'type' => 'raw',
                    'value' => '$data->propinsi_nama',
                ),
                array(
                    'header' => 'Kota',
                    'type' => 'raw',
                    'value' => '$data->kotakabupaten_nama',
                ),
                array(
                    'header' => 'Tanggal Mulai',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tglmulaidinas)',
                ),
                array(
                    'header' => 'Tanggal Akhir',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->sampaidengan)',
                ),
                array(
                    'header' => 'Negara Tujuan',
                    'type' => 'raw',
                    'value' => '$data->negaratujuan',
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
                'id' => 'infoRiwayatPerjalanDinas-info-search',
                'type' => 'horizontal',
            ));
            ?>

            <div class="row">
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'Tujuan Dinas', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($model, 'tujuandinas', array('placeholder' => 'Tujuan Dinas', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'Tugas Dinas', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($model, 'tugasdinas', array('placeholder' => 'Tugas Dinas', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'Keterangan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($model, 'descdinas', array('placeholder' => 'Keterangan', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'Alamat Tujuan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($model, 'alamattujuan', array('placeholder' => 'Alamat Tujuan', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'Provinsi', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($model, 'propinsi_nama', array('placeholder' => 'Provinsi', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'Kota', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($model, 'kotakabupaten_nama', array('placeholder' => 'Kota', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>
                    <div class='control-group'>
                        <?php echo $form->labelEx($model, 'Tanggal Mulai Dinas', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php $model->tglmulaidinas = $format->formatDateTimeForUser($model->tglmulaidinas); ?>
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tglmulaidinas',
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
                    <div class='control-group'>
                        <?php echo $form->labelEx($model, 'Tanggal Akhir Dinas', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php $model->sampaidengan = $format->formatDateTimeForUser($model->sampaidengan); ?>
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'sampaidengan',
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
                        <?php echo $form->labelEx($model, 'Negara Tujuan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($model, 'negaratujuan', array('placeholder' => 'Negara Tujuan', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
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