<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'ppinfokartupasien-search',
    'type' => 'horizontal',
        ));
?>

<style>
    #ruangan label{
        width: 200px;
            display:inline-block;
        }
</style>
<fieldset>
    <legend class="rim"><i class="entypo-search"></i> Pencarian</legend>
    <table style="width: 100%; border: none;">
        <tbody>
            <tr>
                <td>
                    <?php //echo  $form->textFieldRow($model,'tgl_pendaftaran'); ?>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'tgl_pendaftaran', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tgl_awal',
                                'mode' => 'datetime',
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
                        <label class='control-label'>Sampai dengan</label>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tgl_akhir',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3'),
                            ));
                            ?>
                        </div>
                    </div>
                    <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('class' => 'span3', 'maxlength' => 10)); ?>

                    <?php echo $form->textFieldRow($model, 'nama_pasien', array('class' => 'span3', 'maxlength' => 50)); ?>
                </td>
                <td>
                    <?php echo $form->textFieldRow($model,'alamat_pasien',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'rt', array('class'=>'control-label inline')) ?>
                        <div class="controls">
                            <?php echo $form->textField($model,'rt', array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span1 numberOnly','maxlength'=>3)); ?>   / 
                            <?php echo $form->textField($model,'rw', array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span1 numberOnly','maxlength'=>3)); ?> 
                        </div>
                    </div>

                    <?php
                        echo $form->dropDownListRow(
                            $model, 'statusprintkartu',array(1 => 'Sudah', 0 => 'Belum'),array('empty'=>'-- Pilih --', 'options'=>array(1=>array('selected'=>false)))
                        ); ?>
                </td>
            </tr>
    </table>
</fieldset>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
		<?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), $this->createUrl('informasiPrintKartuPasien/index'), array('class'=>'btn btn-danger')); ?>
<?php 
$content = $this->renderPartial('pendaftaranPenjadwalan.views.tips.informasi',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); ?>	
		
</div>

<?php $this->endWidget(); ?>
