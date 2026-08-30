<div id="divSearch-form">
    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'rencana-t-search',
        'type' => 'horizontal',
        'focus' => '#' . CHtml::activeId($model, 'nofaktur'),
    )); ?>

    <div class="row">
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label('Tgl. Faktur', 'tglfaktur', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tgl_awal',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                        ),
                        'htmlOptions' => array(
                            'readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                        ),
                    ));
                    $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal);
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Sampai Dengan', 'sampaiDengan', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tgl_akhir',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                        ),
                        'htmlOptions' => array(
                            'readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                        ),
                    ));
                    $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir);
                    ?>
                </div>
            </div>
            <?php echo $form->textFieldRow($model, 'nofaktur', array('placeholder' => 'No. Faktur Pembelian', 'class' => 'numberOnly')); ?>
        </div>
        <div class="col-sm-6">
            <?php echo $form->dropDownListRow(
                $model,
                'ruangan_id',
                CHtml::listData(RuanganM::model()->getRuanganByInstalasi(Yii::app()->user->getState('instalasi_id')), 'ruangan_id', 'ruangan_nama'),
                array(
                    'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                    'empty' => '-- Pilih --',
                )
            ); ?>
            <?php echo $form->dropDownListRow(
                $model,
                'supplier_id',
                CHtml::listData(SupplierM::model()->getSupplierFarmasiItems(), 'supplier_id', 'supplier_nama'),
                array(
                    'class' => 'span3 isRequired', 'onkeypress' => "return $(this).focusNextInputField(event)",
                    'empty' => '-- Pilih --',
                )
            ); ?>

            <div class="control-group">
                <?php echo $form->labelEx($model, 'statuspenerimaan', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'statuspenerimaan', LookupM::getItems('statuspenerimaan'), array('empty' => '-- Pilih --', 'class' => 'span3',)); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
        ); ?>
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            array(
                'title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset',
                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
            )
        ); ?>
        <?php
        $content = $this->renderPartial('../tips/informasi_gudangfarmasi', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>
    </div>

    <?php $this->endWidget(); ?>
</div>