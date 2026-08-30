<legend class='rim'><i class="entypo-search"></i> Pencarian</legend>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'rjrinciantagihanpasien-v-search',
    'type' => 'horizontal',
        ));
?>
<table style="width: 100%; border: none;">
    <tr>
        <td>
            <div class="control-group">
                    <?php echo $form->labelEx($model, 'tgl_pendaftaran', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    $model->tgl_awal = MyFormatter::formatDateTimeForUser($model->tgl_awal);
                    $model->tgl_akhir = MyFormatter::formatDateTimeForUser($model->tgl_akhir);
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tgl_awal',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3'),
                    ));
                    ?>
                </div>
            </div>
            <div class="control-group">
                    <?php echo $form->labelEx($model, 'tgl_akhir', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tgl_akhir',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3'),
                    ));
                    ?>    
                </div>
            </div>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'no_rekam_medik',array('class'=>'span3 numbers-only','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50, 'autofocus'=>true, 'placeholder'=>'No. rekam medik')); ?>
            <?php echo $form->textFieldRow($model,'no_pendaftaran',array('class'=>'span3 angkahuruf-only','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50, 'placeholder'=>'No. Pendaftaran')); ?>
            <?php echo $form->textFieldRow($model,'nama_pasien',array('class'=>'span3 hurufs-only','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50, 'placeholder'=>'nama pasien')); ?>
        </td>
        <td>            
            <?php echo $form->dropDownListRow($model, 'statusBayar', LookupM::getItems('statusbayar'), array('empty' => '-- Pilih --', 'class' => 'span3', 'maxlength' => 20)); ?>
            <?php echo $form->dropDownListRow($model,'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",
                                                'ajax' => array('type'=>'POST',
                                                    'url'=> Yii::app()->createUrl('ActionDynamic/GetPenjaminPasien',array('encode'=>false,'namaModel'=>get_class($model))), 
                                                    'update'=>'#'.CHtml::activeId($model,'penjamin_id').''  //selector to update
                                                ),
                        )); ?>

            <?php echo $form->dropDownListRow($model,'penjamin_id', CHtml::listData($model->getPenjaminItems($model->carabayar_id), 'penjamin_id', 'penjamin_nama') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",)); ?>
        </td>
    </tr>
</table>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            array('title' => 'Ulang', 'class' => 'btn btn-default', 'onclick' => 'konfirmasi()', 'onKeypress' => 'return formSubmit(this,event)')
        );
    ?>          
    <?php
    $content = $this->renderPartial('gizi.views.tips.informasiPembayaranGizi', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>
