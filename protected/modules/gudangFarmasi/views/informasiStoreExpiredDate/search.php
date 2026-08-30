<div id="divSearch-form">
    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'storeeddetail-t-search',
        'type' => 'horizontal',
        'focus' => '#' . CHtml::activeId($model, 'obatalkes_nama'),
    )); ?>
    <fieldset class="box">
        <legend class="rim"><i class="entypo-search"></i> Pencarian</legend>
        <table style="width: 100%; border: none;">
            <tr>
                <td>
                    <?php echo $form->textFieldRow($model, 'obatalkes_nama', array('placeholder' => 'Nama Obat')); ?>
                    <div class="control-group">
                        <?php echo CHtml::label('Tgl. Kedaluwarsa', 'tglkadaluarsa', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $model->tglkadaluarsa = $format->formatDateTimeForUser($model->tglkadaluarsa);
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tglkadaluarsa',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                ),
                                'htmlOptions' => array(
                                    'readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));
                            $model->tglkadaluarsa = $format->formatDateTimeForDb($model->tglkadaluarsa);
                            ?>
                        </div>
                    </div>
                </td>
                <td>
                    <?php echo $form->dropDownListRow(
                        $model,
                        'supplier_id',
                        CHtml::listData(SupplierM::model()->SupplierItems, 'supplier_id', 'supplier_nama'),
                        array(
                            'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                            'empty' => '-- Pilih --', 'style' => 'width:130px;'
                        )
                    ); ?>
                </td>
            </tr>
        </table>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Cari', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('class' => 'btn btn-default', 'type' => 'reset')); ?>
            <?php
            $content = $this->renderPartial('../tips/informasi_gudangfarmasi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </fieldset>
    <?php $this->endWidget(); ?>
</div>