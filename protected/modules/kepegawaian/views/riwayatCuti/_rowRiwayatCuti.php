<style>
    .panel-success .panel-heading {
        background-color: #6cccb9 !important;
        border-color: #6cccb9 !important;
    }
</style>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Riwayat Cuti Pegawai</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'infoRiwayatCuti-grid',
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
                    'header' => 'Jenis Cuti',
                    'type' => 'raw',
                    'value' => '(isset($data->jeniscuti->jeniscuti_nama) ? $data->jeniscuti->jeniscuti_nama : "-")',
                ),
                array(
                    'header' => 'Tanggal Cuti',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($data->tglmulaicuti)))." s/d ".MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($data->tglakhircuti)))',
                ),
                array(
                    'header' => 'Lama Cuti',
                    'type' => 'raw',
                    'value' => '$data->lamacuti." hari."',
                ),
                array(
                    'header' => 'No. SK',
                    'type' => 'raw',
                    'value' => '$data->noskcuti',
                ),
                array(
                    'header' => 'Tanggal Ditetapkan',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tglditetapkanskcuti)',
                ),
                array(
                    'header' => 'Keperluan',
                    'type' => 'raw',
                    'value' => '$data->keperluancuti',
                ),
                array(
                    'header' => 'Keterangan',
                    'type' => 'raw',
                    'value' => '$data->keterangan',
                ),
                array(
                    'header' => 'Pejabat Mengetahui',
                    'type' => 'raw',
                    'value' => '$data->pejabatmengetahui',
                ),
                array(
                    'header' => 'Pejabat Menyetujui',
                    'type' => 'raw',
                    'value' => '$data->pejabatmenyetujui',
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
                'id' => 'infoRiwayatCuti-info-search',
                'type' => 'horizontal',
            ));
            ?>

            <div class="row">
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'Jenis Cuti', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($model, 'jeniscuti_id', CHtml::listData(JeniscutiM::model()->findAllByAttributes(array('jeniscuti_aktif' => true), array('order' => 'jeniscuti_nama')), 'jeniscuti_id', 'jeniscuti_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'No. SK', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($model, 'noskcuti', array('placeholder' => 'No. SK', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class='control-group'>
                        <?php echo $form->labelEx($model, 'Tanggal Mulai Cuti', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php $model->tglmulaicuti = $format->formatDateTimeForUser($model->tglmulaicuti); ?>
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tglmulaicuti',
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
                        <?php echo $form->labelEx($model, 'Tanggal Akhir Cuti', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php $model->tglakhircuti = $format->formatDateTimeForUser($model->tglakhircuti); ?>
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tglakhircuti',
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