<legend class="rim""><i class="entypo-search"></i> Pencarian</legend>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'gupembelianbarang-t-search',
        'type'=>'horizontal',
)); ?>
  
<table style="width: 100%; border: none;">
    <tr>
        <td>
        <?php //echo  $form->textFieldRow($model,'tgl_pendaftaran'); ?>

            <div class='control-group'>
        <?php $format= new MyFormatter; ?>
         <?php echo CHtml::label('Dari Tanggal', 'dari_tanggal', array('class' => 'control-label')) ?>
         <div class="controls">  
             <?php $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); ?>                     
            <?php
             $this->widget('MyDateTimePicker', array(
                 'model' => $model,
                 'attribute' => 'tgl_awal',
                 'mode' => 'date',
                 'options' => array(
                     'dateFormat' => Params::DATE_FORMAT,
                     'maxDate'=>'d',
                 ),
                 'htmlOptions' => array('readonly' => true, 'class' => "dtPicker3",
                     'onkeypress' => "return $(this).focusNextInputField(event)"),
             ));
             ?>
             <?php $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal); ?>                     
         </div> 
            </div>
        <div class="control-group">
             <?php $format= new MyFormatter; ?>
            <label for="namaPasien" class="control-label">
               Sampai dengan
            </label>
            <div class="controls">
          <?php $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir); ?> 
                      <?php      $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'tgl_akhir',
                                            'mode'=>'date',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
                                                'maxDate' => 'd',
                                            ),
                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                    )); ?>
                 <?php $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir); ?>
                </div>
            </div>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'nopembelian',array('class'=>'span3', 'maxlength'=>20)); ?>
            <?php echo $form->dropDownListRow($model,'sumberdana_id', CHtml::listData(SumberdanaM::model()->findAll('sumberdana_aktif = true'), 'sumberdana_id', 'sumberdana_nama'),array('empty'=>'-- Pilih --','class'=>'span3', 'maxlength'=>20)); ?>
        </td>
        <td>
            <?php echo $form->dropDownListRow($model,'supplier_id', CHtml::listData(SupplierM::model()->findAll('supplier_aktif = true'), 'supplier_id', 'supplier_nama'),array('empty'=>'-- Pilih --','class'=>'span3', 'maxlength'=>20)); ?>
            <?php echo $form->dropDownListRow($model,'peg_pemesanan_id', CHtml::listData(PegawaiM::model()->findAll('pegawai_aktif = true'), 'pegawai_id', 'nama_pegawai'),array('empty'=>'-- Pilih --','class'=>'span3', 'maxlength'=>20)); ?>
            <?php //echo $form->dropDownListRow($model,'sumberdanabhn', LookupM::getItems('sumberdanabahan'),array('empty'=>'-- Pilih --')); ?>
        </td>
    </tr>
</table>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                    Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                    array('class' => 'btn btn-default',
                          'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
    <?php
        $content = $this->renderPartial('../tips/informasi_pembelian_barang',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    ?>
</div>

<?php $this->endWidget(); ?>
