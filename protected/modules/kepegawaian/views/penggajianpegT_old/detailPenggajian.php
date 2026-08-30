<div class="white-container">
    <legend class="rim2">Detail <b>Penggajian Pegawai</b></legend>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'sapegawai-m-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event)'),
            'focus'=>'#',
    )); ?>
    <fieldset>
        <table style="width: 100%; border: none;">
            <tr>
                <!--====================== kolom ke-1 ==============================================-->
                <td>
                    <?php echo $form->textFieldRow($modelpegawai,'nomorindukpegawai',array('id'=>'NIP', 'onkeypress'=>"if (event.keyCode == 13){setNip(this);}return $(this).focusNextInputField(event)", 'class'=>'span3')); ?>
                    <div class="control-group">
                        <?php echo CHtml::label('Nama Pegawai','namapegawai',array('class'=>'control-label')) ?>
                        <div class="controls">
                                <?php echo $form->hiddenField($modelpegawai,'pegawai_id',array('readonly'=>true,'id'=>'pegawai_id')) ?>
                                <?php echo $form->textField($modelpegawai,'nama_pegawai',array('readonly'=>true)); ?>
                        </div>
                    </div>
                    <?php echo $form->textFieldRow($modelpegawai,'tempatlahir_pegawai',array('readonly'=>true,'id'=>'tempatlahir_pegawai')); ?>
                    <?php echo $form->textFieldRow($modelpegawai, 'tgl_lahirpegawai',array('readonly'=>true,'id'=>'tgl_lahirpegawai')); ?>
                    <?php echo $form->textFieldRow($modelpegawai, 'jeniskelamin',array('readonly'=>true,'id'=>'jeniskelamin')); ?>
                    <?php echo $form->textFieldRow($modelpegawai,'jabatan_id',array('readonly'=>true,'id'=>'jabatan')); ?>
                </td>
                <!--=========================== kolom ke 2 ======================================-->
                <td>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'no_rekening',array('readonly'=>true,'class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($modelpegawai,'norekening',array('readonly'=>true,'class'=>'span2','id'=>'norek')); ?>
                            <?php echo $form->textField($modelpegawai,'banknorekening',array('readonly'=>true,'class'=>'span1','id'=>'banknorek', 'style'=>'width:70px;')); ?>
                        </div>
                    </div>
                    <?php echo $form->textFieldRow($modelpegawai,'npwp',array('readonly'=>true,'id'=>'npwp')); ?>
                    <div class="control-group">
                        <?php echo $form->labelEx($modelpegawai,'notelp_pegawai',array('readonly'=>true,'class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($modelpegawai,'notelp_pegawai',array('readonly'=>true,'id'=>'notelp', 'class'=>'span2')); ?>
                            <?php echo $form->textField($modelpegawai,'nomobile_pegawai',array('readonly'=>true,'id'=>'nomobile', 'class'=>'span1', 'style'=>'width:70px;')); ?>
                        </div>
                    </div>
                    <?php echo $form->textFieldRow($modelpegawai,'agama',array('readonly'=>true,'id'=>'agama')); ?>
                    <?php echo $form->textAreaRow($modelpegawai,'alamat_pegawai',array('readonly'=>true,'id'=>'alamat_pegawai')); ?>
                </td>
                <td>
                    <?php 
                        if(!empty($modelpegawai->photopegawai)){
                            echo CHtml::image(Params::urlPegawaiTumbsDirectory().'kecil_'.$modelpegawai->photopegawai, 'Foto pasien', array('id'=>'photo_pasien','width'=>150));
                        } else {
                            echo CHtml::image(Params::urlPegawaiDirectory().'no_photo.jpeg', 'Photo Pegawai', array('id'=>'photo_pasien','width'=>150));
                        }
                    ?> 
                </td>
            </tr>
        </table>
    </fieldset>
    <fieldset class="box">
        <legend class="rim">Data Penggajian Pegawai</legend>
        <table style="width: 100%; border: none;">
            <tr>
                <td>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'tglpenggajian', array('class' => 'control-label')); ?>
                        <div class="controls">
                        <?php  $model->tglpenggajian =  MyFormatter::formatDateTimeForUser($model->tglpenggajian); ?>
                        <?php $this->widget('MyDateTimePicker',array(
                                                'model'=>$model,
                                                'attribute'=>'tglpenggajian',
                                                'mode'=>'datetime',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                ),
                                                'htmlOptions'=>array('readonly'=>true,
                                                                      'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                                      'class'=>'dtPicker3',
                                                 ),
                        )); ?>
                        <?php  $model->tglpenggajian =  MyFormatter::formatDateTimeForDb($model->tglpenggajian); ?>
                        </div>
                    </div>
                    <?php echo $form->textFieldRow($model,'nopenggajian',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                    <?php echo $form->textAreaRow($model,'keterangan',array('rows'=>6, 'cols'=>50, 'class'=>'span5', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                </td>
                <td>
                    <div class="control-group">
                        <div class="controls">
                            <table class='table'>
                                <thead>
                                    <tr>
                                        <th>
                                            Deskripsi
                                        </th>
                                        <th>
                                            Gaji
                                        </th>
                                        <th>
                                            Potongan
                                        </th>
                                    </tr>
                                </thead>
                                </tbody>

                                <tbody>
                                <tfoot>
                                    <tr>
                                        <th style="text-align: right">
                                            Total
                                        </th>
                                        <th>
                                            <?php echo $form->textField($model,'totalterima',array('class'=>'span2', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                                        </th>
                                        <th>
                                            <?php echo $form->textField($model,'totalpotongan',array('class'=>'span2', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <?php //echo $form->textFieldRow($model,'mengetahui',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>     
    </fieldset>
    <table style="width: 100%; border: none;">
        <tr>
            <td>
                <?php echo $form->textFieldRow($model,'totalpajak',array('class'=>'span3 numbersOnly', 'onblur'=>'setHarga();','onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model,'penerimaanbersih',array('class'=>'span3 numbersOnly', 'readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            </td>
            <td>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'mengetahui',array('class'=>'control-label')) ?>
                    <div class="controls">
                            <?php echo $form->hiddenField($model,'pegawai_id',array('readonly'=>true,'id'=>'pegawai_id')) ?>
                            <?php echo $form->textField($model,'mengetahui',array('readonly'=>true)); ?>
                    </div>
                </div>
                <?php //echo $form->textFieldRow($model,'menyetujui',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'menyetujui',array('class'=>'control-label')) ?>
                    <div class="controls">
                            <?php echo $form->hiddenField($model,'menyetujui',array('readonly'=>true,'id'=>'pegawai_id')); ?>
                            <?php echo $form->textField($model,'menyetujui',array('readonly'=>true)); ?>
                    </div>
                </div>
            </td>
        </tr>
    </table>
    <div class="form-actions">
<table style="width: 100%; border: none;">
  <tr>
   <td width="100"> 
        <?php 
            $this->widget('bootstrap.widgets.BootButtonGroup', array(
                'type'=>'info', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'buttons'=>array(
                    array('label'=>'Print', 'icon'=>'entypo-print', 'url'=>'#', 'htmlOptions'=>array('onclick'=>'print(\'PRINT\')')),
                    array('label'=>'', 'items'=>array(
                        array('label'=>'Print','icon'=>'entypo-print', 'url'=>'', 'itemOptions'=>array('onclick'=>'print(\'PRINT\')')),
                        array('label'=>'PDF', 'icon'=>'icon-book', 'url'=>'', 'itemOptions'=>array('onclick'=>'print(\'PDF\')')),
                        array('label'=>'Excel','icon'=>'icon-pdf', 'url'=>'', 'itemOptions'=>array('onclick'=>'print(\'EXCEL\')')),
                    )),       
                ),
        //        'htmlOptions'=>array('class'=>'btn')
            )); 
        ?>	
   </td >
    <td>

        <?php
             $content = $this->renderPartial('../tips/master',array(),true);
             $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        ?>
    </td>

  </tr>
</table>
</div>
    <?php 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/PrintPenggajian&id='.$modelpegawai->pegawai_id);

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}   
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);  

?>
    
<?php $this->endWidget(); ?>
