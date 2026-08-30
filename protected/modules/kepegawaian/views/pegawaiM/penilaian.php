<fieldset>
    <legend class="rim2">Informasi Penilaian Pegawai</legend>
</fieldset>
<?php
$this->breadcrumbs=array(
	'Sapegawai Ms'=>array('index'),
	'Create',
);

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sapegawai-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); ?>

<fieldset>
    <legend> Data Pegawai </legend>
    <table class="table">
        <tr>
            <!--====================== kolom ke-1 ==============================================-->
            <td>
                <?php echo $form->textFieldRow($modelpegawai,'nomorindukpegawai',array('readonly'=>true,'id'=>'NIP')); ?>
                <div class="control-group">
                    <?php echo CHtml::label('Nama Pegawai','namapegawai',array('class'=>'control-label')) ?>
                    <div class="controls">
                            <?php echo $form->hiddenField($modelpegawai,'pegawai_id',array('readonly'=>true,'id'=>'pegawai_id')) ?>
                            <?php $this->widget('MyJuiAutoComplete',array(
                                        'model'=>$modelpegawai, 
//                                        'name'=>'namapegawai',
                                        'attribute'=>'nama_pegawai',
                                        'value'=>$namapegawai,
                                        'sourceUrl'=> Yii::app()->createUrl('ActionAutoComplete/Pegawairiwayat'),
                                        'options'=>array(
                                           'showAnim'=>'fold',
                                           'minLength' => 4,
                                           'focus'=> 'js:function( event, ui ) {
                                                $("#pegawai_id").val( ui.item.value );
                                                $("#namapegawai").val( ui.item.nama_pegawai );
                                                return false;
                                            }',
                                           'select'=>'js:function( event, ui ) {
                                                $("#pegawai_id").val( ui.item.value );
                                                $("#NIP").val( ui.item.nomorindukpegawai);
                                                $("#tempatlahir_pegawai").val( ui.item.tempatlahir_pegawai);
                                                $("#tgl_lahirpegawai").val( ui.item.tgl_lahirpegawai);
                                                $("#namapegawai").val( ui.item.nama_pegawai);
                                                $("#jeniskelamin").val( ui.item.jeniskelamin);
                                                $("#statusperkawinan").val( ui.item.statusperkawinan);
                                                $("#jabatan").val( ui.item.jabatan_nama);
                                                $("#alamat_pegawai").val( ui.item.alamat_pegawai);
                                                if(ui.item.photopegawai != null){
                                                    $("#photo_pasien").attr(\'src\',\''.Params::urlPegawaiTumbsDirectory().'kecil_\'+ui.item.photopegawai);
                                                } else {
                                                    $("#photo_pasien").attr(\'src\',\'http://localhost/simrs/data/images/pasien/no_photo.jpeg\');
                                                }
                                                return false;
                                            }',

                                        ),
                                        'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2 '),
                                        'tombolDialog'=>array('idDialog'=>'dialogPegawai','idTombol'=>'tombolPasienDialog'),
                            )); ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($modelpegawai,'tempatlahir_pegawai',array('readonly'=>true,'id'=>'tempatlahir_pegawai')); ?>
                <?php echo $form->textFieldRow($modelpegawai, 'tgl_lahirpegawai',array('readonly'=>true,'id'=>'tgl_lahirpegawai')); ?>
                <?php echo $form->textFieldRow($modelpegawai, 'jeniskelamin',array('readonly'=>true,'id'=>'jeniskelamin')); ?>
                <?php echo $form->textFieldRow($modelpegawai,'statusperkawinan',array('readonly'=>true,'id'=>'statusperkawinan')); ?>
            </td>
            <!--=========================== kolom ke 2 ======================================-->
            <td>
<!--<div class="control-group">
                    <?php //echo $form->labelEx($model, 'jabatan_id',array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php //echo $form->textFieldRow($model,'jabatan_id',array('readonly'=>true,'id'=>'jabatan')); ?>
                    </div>
                </div>-->
                <?php echo $form->textFieldRow($modelpegawai,'jabatan_id',array('readonly'=>true,'id'=>'jabatan')); ?>
                <?php echo $form->textFieldRow($modelpegawai,'pangkat_id',array('readonly'=>true,'id'=>'pangkat')); ?>
                <?php echo $form->textFieldRow($modelpegawai,'kategoripegawai',array('readonly'=>true,'id'=>'kategoripegawai')); ?>
                <?php echo $form->textFieldRow($modelpegawai,'kategoripegawaiasal',array('readonly'=>true,'id'=>'kategoripegawaiasal')); ?>
                <?php echo $form->textFieldRow($modelpegawai,'kelompokpegawai_id',array('readonly'=>true,'id'=>'kelompokpegawai')); ?>
                <?php echo $form->textFieldRow($modelpegawai,'pendidikan_id',array('readonly'=>true,'id'=>'pendidikan')); ?>
                <?php //echo $form->textAreaRow($model,'alamat_pegawai',array('readonly'=>true,'id'=>'alamat_pegawai')); ?>
            </td>
            <td>
                <?php 
                    if(!empty($modelpegawai->photopegawai)){
                        echo CHtml::image(Params::urlPegawaiTumbsDirectory().'kecil_'.$modelpegawai->photopegawai, 'Foto pasien', array('id'=>'photo_pasien','width'=>150));
                    } else {
                        echo CHtml::image(Params::urlPegawaiDirectory().'no_photo.jpeg', 'Foto pasien', array('id'=>'photo_pasien','width'=>150));
                    }
                ?> 
            </td>
        </tr>
    </table>
</fieldset>
 <fieldset>
<legend> Data Penilaian Pegawai </legend>
<table>
    <tbody>
        <tr>
            <td colspan ="2">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'tglpenilaian', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php $this->widget('MyDateTimePicker',array(
                                                'model'=>$model,
                                                'attribute'=>'tglpenilaian',
                                                'mode'=>'datetime',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                ),
                                                'htmlOptions'=>array('readonly'=>true,
                                                                      'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                                      'class'=>'dtPicker3',
                                                 ),
                        )); ?> 
                    </div>
                </div>
                
            </td>
        </tr>
        <tr>
            <td>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'periodepenilaian', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php $this->widget('MyDateTimePicker',array(
                                                'model'=>$model,
                                                'attribute'=>'periodepenilaian',
                                                'mode'=>'date',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                ),
                                                'htmlOptions'=>array('readonly'=>true,
                                                                      'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                                      'class'=>'dtPicker3',
                                                 ),
                        )); ?> 
                    </div>
                </div>
            </td>
            <td>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'sampaidengan', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php $this->widget('MyDateTimePicker',array(
                                                'model'=>$model,
                                                'attribute'=>'sampaidengan',
                                                'mode'=>'date',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                ),
                                                'htmlOptions'=>array('readonly'=>true,
                                                                      'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                                      'class'=>'dtPicker3',
                                                 ),
                        )); ?> 
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo $form->textFieldRow($model, 'kesetiaan', array('class' => 'span3 numbersOnly pointNilai', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model, 'prestasikerja', array('class' => 'span3 numbersOnly pointNilai', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model, 'tanggungjawab', array('class' => 'span3 numbersOnly pointNilai', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model, 'ketaatan', array('class' => 'span3 numbersOnly pointNilai', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </td>
            <td>
                <?php echo $form->textFieldRow($model, 'kejujuran', array('class' => 'span3 numbersOnly pointNilai', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model, 'kerjasama', array('class' => 'span3 numbersOnly pointNilai', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model, 'prakarsa', array('class' => 'span3 numbersOnly pointNilai', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model, 'kepemimpinan', array('class' => 'span3 numbersOnly pointNilai', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>
                </td>
            <td>
                <?php echo $form->textFieldRow($model, 'jumlahpenilaian', array('class' => 'span3 totalNilai', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>
                 <?php echo $form->textFieldRow($model,'nilairatapenilaian',array('class'=>'span3 rataNilai', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'readonly'=>True)); ?>
            <?php echo $form->textFieldRow($model,'performanceindex',array('class'=>'span3 numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            </td>
        </tr>
    </tfoot>
</table>

<table>
    <tr>
        <td>
            <?php echo $form->textAreaRow($model,'penilaianpegawai_keterangan',array('rows'=>6, 'cols'=>50, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'tanggal_keberatanpegawai', array('class'=>'control-label'));?>
                <div class="controls">  
                  <?php $this->widget('MyDateTimePicker',array(
                                        'model'=>$model,
                                        'attribute'=>'tanggal_keberatanpegawai',
                                        'mode'=>'date',
                                        'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                        ),
                                        'htmlOptions'=>array('readonly'=>true,
                                                              'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                              'class'=>'dtPicker3',
                                            ),
                )); ?> 
                 <?php echo $form->textArea($model,'keberatanpegawai',array('rows'=>6, 'cols'=>50, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'diterimatanggalpegawai', array('class'=>'control-label'));?>
                <div class="controls">  
                  <?php $this->widget('MyDateTimePicker',array(
                                        'model'=>$model,
                                        'attribute'=>'diterimatanggalpegawai',
                                        'mode'=>'date',
                                        'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                        ),
                                        'htmlOptions'=>array('readonly'=>true,
                                                              'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                              'class'=>'dtPicker3',
                                            ),
                )); ?> 
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'diterimatanggalatasan', array('class'=>'control-label'));?>
                <div class="controls">  
                  <?php $this->widget('MyDateTimePicker',array(
                                        'model'=>$model,
                                        'attribute'=>'diterimatanggalatasan',
                                        'mode'=>'date',
                                        'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                        ),
                                        'htmlOptions'=>array('readonly'=>true,
                                                              'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                              'class'=>'dtPicker3',
                                            ),
                )); ?> 
                </div>
            </div>
        </td>
        <td>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'tanggapanpejabat', array('class'=>'control-label'));?>
                <div class="controls">  
                  <?php $this->widget('MyDateTimePicker',array(
                                        'model'=>$model,
                                        'attribute'=>'tanggal_tanggapanpejabat',
                                        'mode'=>'date',
                                        'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                        ),
                                        'htmlOptions'=>array('readonly'=>true,
                                                              'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                              'class'=>'dtPicker3',
                                            ),
                )); ?> 
                 <?php echo $form->textArea($model,'tanggapanpejabat',array('rows'=>6, 'cols'=>50, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'keputusanatasan', array('class'=>'control-label'));?>
                <div class="controls">  
                  <?php $this->widget('MyDateTimePicker',array(
                                        'model'=>$model,
                                        'attribute'=>'tanggal_keputusanatasan',
                                        'mode'=>'date',
                                        'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                        ),
                                        'htmlOptions'=>array('readonly'=>true,
                                                              'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                              'class'=>'dtPicker3',
                                            ),
                )); ?> 
                 <?php echo $form->textArea($model,'keputusanatasan',array('rows'=>6, 'cols'=>50, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
        </td>
    </tr>
</table>

            
<table>
    <tr>
        <td>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'penilainama', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    $this->widget('MyJuiAutoComplete', array(
                        'model'=>$model,
                        'attribute' => 'penilainama',
                        'source' => 'js: function(request, response) {
                                           $.ajax({
                                               url: "' . Yii::app()->createUrl('ActionAutoComplete/getPegawai') . '",
                                               dataType: "json",
                                               data: {
                                                   term: request.term,
                                               },
                                               success: function (data) {
                                                       response(data);
                                               }
                                           })
                                        }',
                        'options' => array(
                            'showAnim' => 'fold',
                            'minLength' => 2,
                            'focus' => 'js:function( event, ui ) {
                                                                        $(this).val( ui.item.label);
                                                                        return false;
                                                                    }',
                            'select' => 'js:function( event, ui ) {
                                                                        $("#'.Chtml::activeId($model, 'penilainama') . '").val(nama_pegawai); 
                                                                        return false;
                                                                    }',
                        ),
                        'htmlOptions' => array(
                            'onkeypress' => "return $(this).focusNextInputField(event)",
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogPenilai'),
                    ));
                    ?>
                    <?php echo $form->error($model, 'penilainama'); ?>
                </div>
            </div>
            <?php echo $form->textFieldRow($model,'penilainip',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
            <?php echo $form->textFieldRow($model,'penilaipangkatgol',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
            <?php echo $form->textFieldRow($model,'penilaijabatan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
            <?php echo $form->textFieldRow($model,'penilaiunitorganisasi',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
        </td>
        <td>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'pimpinannama', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    $this->widget('MyJuiAutoComplete', array(
                        'model'=>$model,
                        'attribute' => 'pimpinannama',
                        'source' => 'js: function(request, response) {
                                           $.ajax({
                                               url: "' . Yii::app()->createUrl('ActionAutoComplete/getPegawai') . '",
                                               dataType: "json",
                                               data: {
                                                   term: request.term,
                                               },
                                               success: function (data) {
                                                       response(data);
                                               }
                                           })
                                        }',
                        'options' => array(
                            'showAnim' => 'fold',
                            'minLength' => 2,
                            'focus' => 'js:function( event, ui ) {
                                                                        $(this).val( ui.item.label);
                                                                        return false;
                                                                    }',
                            'select' => 'js:function( event, ui ) {
                                                                        $("#'.Chtml::activeId($model, 'pimpinannama') . '").val(nama_pegawai); 
                                                                        return false;
                                                                    }',
                        ),
                        'htmlOptions' => array(
                            'onkeypress' => "return $(this).focusNextInputField(event)",
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogPimpinan'),
                    ));
                    ?>
                    <?php echo $form->error($model, 'pimpinannama'); ?>
                </div>
            </div>
            <?php echo $form->textFieldRow($model,'pimpinannip',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
            <?php echo $form->textFieldRow($model,'pimpinanpangkatgol',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
            <?php echo $form->textFieldRow($model,'pimpinanjabatan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
            <?php echo $form->textFieldRow($model,'pimpinanunitorganisasi',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
        </td>
    </tr>
</table>
 </fieldset>

<?php 
 
        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
        $content = $this->renderPartial('kepegawaian.views.tips/master',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/PrintDetailPenilaian&id='.$modelpegawai->pegawai_id);

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}   
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>
<?php $this->endWidget(); ?>
    