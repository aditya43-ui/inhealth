
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'kpkenaikanpangkat-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); ?>

	<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->

	<?php echo $form->errorSummary($model); ?>
        
            <div id="formOrganisasi">
            <table class="table table-bordered table-striped table-condensed" id="tableOrganisasipegawai" style="padding-left: 0; padding-right: 0;">
                <thead>
                    <tr>
                       
                        <th rowspan="2">Jabatan</th>
                        <th rowspan="2">Pangkat</th>
                        <th rowspan="2">Tahun</th>
                        <th rowspan="2">Bulan</th>
                        <th rowspan="2">Gaji Pokok</th>
                        <th rowspan="2">No. SK</th>
                        <th rowspan="2">Tanggal SK</th>
<!--<th rowspan="2">Keterangan</th>-->
                        <th rowspan="2">Mengetahui</th>
                        
                    </tr>
                </thead>
                    <tr>
                        
                            <?php echo $form->hiddenField($model,'pegawai_id',array('class'=>'span1 pegawai', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                            <?php //echo $form->hiddenField($model,'['.$x.']nama_pegawai',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                            <?php echo $form->hiddenField($model,'realisasikenpangkat_id',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                            <?php echo $form->hiddenField($model,'uskenpangkat_id',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        
                        <td>
                            <?php echo $form->dropDownList($model,'jabatan',CHtml::listData(JabatanM::model()->findAll(), 'jabatan_id', 'jabatan_nama'),array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                            <?php // echo $form->textField($model,'jabatan',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                        </td>
                        <td>
                            <?php echo $form->dropDownList($model,'pangkat',CHtml::listData(PangkatM::model()->findAll(), 'pangkat_id', 'pangkat_nama'),array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                            <?php //echo $form->textField($model,'pangkat',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($modUsulan,'uskenpangkat_masakerjatahun',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($modUsulan,'uskenpangkat_masakerjabulan',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($modUsulan,'uskenpangkat_gajipokok',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($modUsulan,'uskenpangkat_nosk',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                        </td>
                        <td>
                            <?php $this->widget('MyDateTimePicker',array(
                                                'model'=>$modUsulan,
                                                'attribute'=>'uskenpangkat_tglsk',
                                                'mode'=>'date',
                                                'options'=> array(
                                                    'dateFormat'=>'yy-mm-dd',
                                                ),
                                                'htmlOptions'=>array('readonly'=>true,
                                                                      'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                                      'class'=>'dtPicker1',
                                                    ),
                        )); ?> 
                        </td>
<!--<td>
                            <?php //echo $form->textArea($model,'keterangan',array('rows'=>6, 'cols'=>50, 'class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        </td>-->
                        <td>
                            <?php echo $form->dropDownList($model,'pimpinannama',CHtml::listData(PegawaiM::model()->findAll(), 'nama_pegawai', 'nama_pegawai'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                            <?php //echo $form->textField($model,'pimpinannama',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                        </td>
                        
                    </tr>
                </tbody>
            </table>
<fieldset id="divRiwayatPendidikanpegawai">
    <div>
        <legend class="accord1" style="width:460px;"><?php echo CHtml::checkBox('cekRiwayatpegawai',false, array('onkeypress'=>"return $(this).focusNextInputField(event)",'onclick'=>'$("#realisasi").slideToggle();')) ?> Realisasi</legend>
        <div class='hide' id="realisasi">
        <table>
    <tr>
        <td>
            <?php echo $form->hiddenField($modRealisasi,'kenaikanpangkat_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo CHtml::label('Tgl. SK', ' ', array('class' => 'control-label')) ?>
                    <div class="controls">  
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modRealisasi,
                            'attribute' => 'realisasikenpangkat_tglsk',
                            'mode' => 'datetime',
//                                         'maxdate'=>'d',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true,
                                'onkeypress' => "return $(this).focusNextInputField(event)"),
                        ));
                        ?>
                    </div>
            <?php echo $form->textFieldRow($modRealisasi,'realisasikenpangkat_nosk',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?> 
             <?php echo CHtml::label('Masa Kerja', ' ', array('class' => 'control-label')) ?>
                    <div class="controls">  
            <?php echo $form->textField($modRealisasi,'realisasikenpangkat_masakerjath',array('class'=>'span1', 'placeholder'=>$modRealisasi->getAttributeLabel('realisasikenpangkat_masakerjath'))); ?>
            <?php echo $form->textField($modRealisasi,'realisasiken_masakerjabln',array('class'=>'span1', 'placeholder'=>$modRealisasi->getAttributeLabel('realisasiken_masakerjabln'))); ?>
                        <div>
        </td>
        <td>
            
            <?php echo $form->textFieldRow($modRealisasi,'realisasiken_gajipokok',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->dropDownListRow($modRealisasi,'realisasiken_pejabatygberwenang',CHtml::listData(PegawaiM::model()->findAll(), 'nama_pegawai', 'nama_pegawai'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
            <?php //echo $form->textFieldRow($modRealisasi,'realisasiken_pejabatygberwenang',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
<td></tr></table>   
        </div>
    </div>
</fieldset>            
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                                array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/'.kenaikanpangkatT.'/admin'), 
                        array('class' => 'btn btn-default',
                              'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
	</div>

<?php $this->endWidget(); ?>

<?php
$urlGetPangkat = Yii::app()->createUrl('PegawaiM/GetPangkat');
$urlGetTahun = $this->createUrl('GetTahun');
$js= <<< JS
        
    function Pangkatdata()
        {
            pegawai_id = $('#pegawai_id').val();
            if(pegawai_id==''){
                myAlert('Anda belum memilih pegawai');
                return false;
            }else{
                $.post("${$urlGetPangkat}", {pegawai_id:pegawai_id,},
                function(data){
                    $("#tableRiwayatPangkat").children("tbody").append(data.tr);
                }, "json");
            }   
        }

        function ViewRiwayatPangkat() {
            
            if ($("#cekRiwayatpegawai").is(":checked")) {
                Pangkatdata();
                $("#tableRiwayatPangkat").slideDown(60);
            } else {
                $("#tableRiwayatPangkat").children("tbody").children("tr").remove();
                $("#tableRiwayatPangkat").slideUp(60);
            }
        }
        
        function kurangiTanggal(tahun)
        {
            $.post("${urlGetTahun}", {tahun:tahun}, function(hasil){
                $("#UskenpangkatR_uskenpangkat_masakerjatahun").val(hasil.tahun);
                $("#UskenpangkatR_uskenpangkat_masakerjabulan").val(hasil.bulan);
                $("#RealisasikenpangkatR_realisasikenpangkat_masakerjath").val(hasil.tahun);
                $("#RealisasikenpangkatR_realisasiken_masakerjabln").val(hasil.bulan);
            },"json");
        
        }

    $('#cekRiwayatpegawai').change(function(){
            $('#divRiwayatpendidikanpegawai').slideToggle(500);
    });
    

JS;
Yii::app()->clientScript->registerScript('pencatatanriwayat',$js,CClientScript::POS_HEAD);
?>
