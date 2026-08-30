<style>
    .panel-success .panel-heading {
        background-color: #6cccb9 !important;
        border-color: #6cccb9 !important;
    }
</style>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Riwayat Jabatan Pegawai</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'infoRiwayatJabatan-grid',
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
                    'header' => 'No. SK',
                    'type' => 'raw',
                    'value' => '$data->nomorkeputusanjabatan',
                ),
                array(
                    'header' => 'Tanggal Ditetapkan',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tglditetapkanjabatan)',
                ),
                array(
                    'header' => 'Tamat Jabatan',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tmtjabatan)',
                ),
                array(
                    'header' => 'Tanggal Akhir Jabatan',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tglakhirjabatan)',
                ),
                array(
                    'header' => 'Keterangan',
                    'type' => 'raw',
                    'value' => '$data->keterangan',
                ),
                array(
                    'header' => 'Pejabat yang menjabat',
                    'type' => 'raw',
                    'value' => '$data->pejabatygmemjabatan',
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
                'id' => 'infoRiwayatJabatan-info-search',
                'type' => 'horizontal',
            ));
            ?>

            <div class="row">
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'No. SK', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textField($model, 'nomorkeputusanjabatan', array('placeholder' => 'No SK', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class='control-group'>
                        <?php echo $form->labelEx($model, 'Tanggal Ditetapkan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php $model->tglditetapkanjabatan = $format->formatDateTimeForUser($model->tglditetapkanjabatan); ?>
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tglditetapkanjabatan',
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
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit')); ?>
            <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl('RencanaLemburT/Informasi'), array('class' => 'btn btn-default', 'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
            <?php
            // $content = $this->renderPartial('../tips/informasi_riwayatPekerjaan', array(), true);
            // $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>