
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'kpperjalanandinas-r-form',
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
                       
                        <th rowspan="2">No. Urut *</th>
                        <th rowspan="2">Tujuan Dinas</th>
                        <th rowspan="2">Tugas Dinas *</th>
                        <th rowspan="2">Keterangan</th>
                        <th rowspan="2">Alamat Tujuan</th>
                        <th rowspan="2">Propinsi</th>
                        <th rowspan="2">Kota</th>
                        <th rowspan="2">Tanggal Mulai *</th>
                        <th rowspan="2">Tanggal Akhir</th>
                        <th rowspan="2">Negara Tujuan</th>
                        <th rowspan="2">Tambah / Batal</th>
                    </tr>
                </thead>
                
                 <?php
                    $nourut_pend = 1;
                    $i = 0;
                ?>
                <tbody>
                    <?php 
                if (count((array)$details)>0){
                    foreach ($details as $i=>$detail) : 
                        $i++;
                        ?>
                    
                        <tr>
                        
                            <?php echo $form->hiddenField($detail,'['.$i.']perjalanandinas_id',array('class'=>'span1 pegawai', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                            <?php echo $form->hiddenField($detail,'['.$i.']pegawai_id',array('class'=>'span1 pegawai', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                            <?php //echo $form->hiddenField($detail,'['.$i.']nama_pegawai',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        
                            <td style="padding-right: 0;">

                                <?php echo $form->textField($detail,'['.$i.']nourutperj',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                            </td>
                            <td>
                                <?php echo $form->textField($detail,'['.$i.']tujuandinas',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                            </td>
                            <td>
                                <?php echo $form->textArea($detail,'['.$i.']tugasdinas',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                            </td>
                            <td>
                                <?php echo $form->textArea($detail,'['.$i.']descdinas',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                            </td>
                            <td>
                                <?php echo $form->textArea($detail,'['.$i.']alamattujuan',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                            </td>
                            <td>
                                <?php echo $form->dropDownList($detail,'['.$i.']propinsi_nama',CHtml::listData(PropinsiM::model()->findAll(), 'propinsi_nama', 'propinsi_nama'),array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                                <?php //echo $form->textField($detail,'['.$i.']propinsi_nama',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                            </td>
                            <td>
                                <?php echo $form->dropDownList($detail,'['.$i.']kotakabupaten_nama',CHtml::listData(KabupatenM::model()->findAll(), 'kabupaten_nama', 'kabupaten_nama'),array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                                <?php // echo $form->textField($detail,'['.$i.']kotakabupaten_nama',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                            </td>
                            <td>
                                <?php $this->widget('MyDateTimePicker',array(
                                                    'model'=>$detail,
                                                    'attribute'=>'['.$i.']tglmulaidinas',
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
                            <td>
                                <?php $this->widget('MyDateTimePicker',array(
                                                    'model'=>$detail,
                                                    'attribute'=>'['.$i.']sampaidengan',
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
                            <td>
                                <?php echo $form->textField($detail,'['.$i.']negaratujuan',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
                            </td>
                            <td>
                                <?php echo CHtml::link('<i class="icon-minus">&nbsp;</i>','#',array('style'=>'display:none;','title'=>'Hapus data','rel'=>'tooltip','id'=>'hapus','onclick'=>'hapusOrganisasi(this);return false','style'=>'cursor:pointer;')); ?>
                            </td>
                            <?php echo $form->hiddenField($detail,'['.$i.']create_time',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                            <?php echo $form->hiddenField($detail,'['.$i.']update_time',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                            <?php echo $form->hiddenField($detail,'['.$i.']create_loginpemakai_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                            <?php echo $form->hiddenField($detail,'['.$i.']update_loginpemakai_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                            <?php echo $form->hiddenField($detail,'['.$i.']create_ruangan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        </tr>
                    <?php endforeach;
                }
                $x = 0;?>
                        <tr>
                        
                            <?php echo $form->hiddenField($model,'pegawai_id',array('class'=>'span1 pegawai', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                            <?php //echo $form->hiddenField($model,'['.$x.']nama_pegawai',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        
                            <td style="padding-right: 0;">

                                <?php echo $form->textField($model,'['.$x.']nourutperj',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                            </td>
                            <td>
                                <?php echo $form->textField($model,'['.$x.']tujuandinas',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                            </td>
                            <td>
                                <?php echo $form->textArea($model,'['.$x.']tugasdinas',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                            </td>
                            <td>
                                <?php echo $form->textArea($model,'['.$x.']descdinas',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                            </td>
                            <td>
                                <?php echo $form->textArea($model,'['.$x.']alamattujuan',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                            </td>
                            <td>
                                <?php echo $form->dropDownList($model,'['.$x.']propinsi_nama',CHtml::listData(PropinsiM::model()->findAll(), 'propinsi_nama', 'propinsi_nama'),array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                                <?php //echo $form->textField($model,'['.$x.']propinsi_nama',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                            </td>
                            <td>
                                <?php echo $form->dropDownList($model,'['.$x.']kotakabupaten_nama',CHtml::listData(KabupatenM::model()->findAll(), 'kabupaten_nama', 'kabupaten_nama'),array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                                <?php //echo $form->textField($model,'['.$x.']kotakabupaten_nama',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                            </td>
                            <td>
                                <?php $this->widget('MyDateTimePicker',array(
                                                    'model'=>$model,
                                                    'attribute'=>'['.$x.']tglmulaidinas',
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
                            <td>
                                <?php $this->widget('MyDateTimePicker',array(
                                                    'model'=>$model,
                                                    'attribute'=>'['.$x.']sampaidengan',
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
                            <td>
                                <?php echo $form->textField($model,'['.$x.']negaratujuan',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
                            </td>
                            <td>
                                <?php echo CHtml::link('<i class="icon-plus">&nbsp;</i>','',array('title'=>'Tambah data','rel'=>'tooltip','onclick'=>'tambahOrganisasi(this);return false','id'=>'tambah','style'=>'cursor:pointer;')); ?>
                                <?php echo CHtml::link('<i class="icon-minus">&nbsp;</i>','#',array('style'=>'display:none;','title'=>'Hapus data','rel'=>'tooltip','id'=>'hapus','onclick'=>'hapusOrganisasi(this);return false','style'=>'cursor:pointer;')); ?>
                            </td>
                            <?php echo $form->hiddenField($model,'['.$x.']create_time',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                            <?php echo $form->hiddenField($model,'['.$x.']update_time',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                            <?php echo $form->hiddenField($model,'['.$x.']create_loginpemakai_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                            <?php echo $form->hiddenField($model,'['.$x.']update_loginpemakai_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                            <?php echo $form->hiddenField($model,'['.$x.']create_ruangan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        </tr>
                    
                </tbody>
            </table>
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                                array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/perjalanandinasR/admin'), 
                        array('class' => 'btn btn-default',
                              'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
	</div>

<?php $this->endWidget(); ?>
<script type="text/javascript">
    var trPendidikanpegawai=new String(<?php echo CJSON::encode($this->renderPartial('_rowPerjalanan',array('form'=>$form,'model'=>$model,),true));?>);
</script>
<?php
$urlGetPerjalananDinas = Yii::app()->createUrl('PegawaiM/GetPerjalananDinas');
$js= <<< JS
    function tambahOrganisasi(obj) {
        $("#hapus").show();
        $(obj).hide();
        $(obj).parents("table").children("tbody").append(trPendidikanpegawai.replace());
        renameInput();
    }
    
    function hapusOrganisasi(obj) {
        $("#tambah").show();
        $(obj).hide();
        $(obj).parents("tr").remove();
        renameInput();
    }
    
    function renameInput(){
        nourut = 0;
        $(".pegawai").each(function(){
            $(this).parents('tr').find('[name*="KPPerjalanandinasR"]').each(function(){
                var input = $(this).attr('name');
                var data = input.split('KPPerjalanandinasR[]');
                if (typeof data[1] === 'undefined'){} else{
                    $(this).attr('name','KPPerjalanandinasR['+nourut+']'+data[1]);
                    if (data[1] == '[tglmulaidinas]'){
                        $(this).attr('id','KPPerjalanandinasR_'+nourut+'_tglmulaidinas');
                        jQuery('#KPPerjalanandinasR_'+nourut+'_tglmulaidinas').datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['id'], {'dateFormat':'yy-mm-dd','timeText':'Waktu','hourText':'Jam','minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold'}));
                    }
                    if (data[1] == '[sampaidengan]'){
                        $(this).attr('id','KPPerjalanandinasR_'+nourut+'_sampaidengan');
                        jQuery('#KPPerjalanandinasR_'+nourut+'_sampaidengan').datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['id'], {'dateFormat':'yy-mm-dd','timeText':'Waktu','hourText':'Jam','minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold'}));
                    }
                }
            });            
            nourut++;
        });
    }
    
    function Pengorganisasidata()
        {
            pegawai_id = $('#pegawai_id').val();
            if(pegawai_id==''){
                myAlert('Anda belum memilih pegawai');
                return false;
            }else{
                $.post("${urlGetPerjalananDinas}", {pegawai_id:pegawai_id,},
                function(data){
                    $("#tableRiwayatJabatan").children("tbody").append(data.tr);
                }, "json");
            }   
        }

        function ViewRiwayatJabatan() {
            
            if ($("#cekRiwayatpegawai").is(":checked")) {
                Pengorganisasidata();
                $("#tableRiwayatJabatan").slideDown(60);
            } else {
                $("#tableRiwayatJabatan").children("tbody").children("tr").remove();
                $("#tableRiwayatJabatan").slideUp(60);
            }
        }

    $('#cekRiwayatpegawai').change(function(){
            $('#divRiwayatpendidikanpegawai').slideToggle(500);
    });
JS;
Yii::app()->clientScript->registerScript('pencatatanriwayat',$js,CClientScript::POS_HEAD);
?>
