
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'kpsusunankel-m-form',
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
                        <th rowspan="2">Hubungan Keluarga *</th>
                        <th rowspan="2">Nama *</th>
                        <th rowspan="2">Jenis Kelamin *</th>
                        <th rowspan="2">Tempat Lahir</th>
                        <th rowspan="2">Tanggal Lahir *</th>
                        <th rowspan="2">Pekerjaan</th>
                        <th rowspan="2">Pendidikan</th>
                        <th rowspan="2">Tanggal Pernikahan</th>
                        <th rowspan="2">Tempat Pernikahan</th>
                        <th rowspan="2">NIP</th>
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
                        <?php echo CHtml::hiddenField('url', $this->createUrl('', array('idPegawai' =>$detail->pegawai_id)), array('readonly' => TRUE)); ?>
                            <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>
                            <?php echo $form->hiddenField($detail,'['.$i.']susunankel_id',array('class'=>'span1 pegawai', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                            <?php echo $form->hiddenField($detail,'['.$i.']pegawai_id',array('class'=>'span1 pegawai', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                            <?php //echo $form->hiddenField($model,'['.$i.']nama_pegawai',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        
                        <td style="padding-right: 0;">
                            
                            <?php echo $form->textField($detail,'['.$i.']nourutkel',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        </td>
                        <td>
                            <?php echo $form->dropDownList($detail, '['.$i.']hubkeluarga', LookupM::getItems('hubungankeluarga'), array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                            <?php //echo $form->textField($detail,'['.$i.']hubkeluarga',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($detail,'['.$i.']susunankel_nama',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?></td>
                        <td>
                            <?php echo $form->dropDownList($detail, '['.$i.']susunankel_jk', LookupM::getItems('jeniskelamin'), array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                            <?php // echo $form->textField($detail,'['.$i.']susunankel_jk',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($detail,'['.$i.']susunankel_tempatlahir',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                        </td>
                        <td>                 
                            <?php $this->widget('MyDateTimePicker',array(
                                                'model'=>$detail,
                                                'attribute'=>'['.$i.']susunankel_tanggallahir',
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
                            <?php echo $form->dropDownList($detail,'['.$i.']pekerjaan_nama',CHtml::listData(PekerjaanM::model()->findAll(), 'pekerjaan_nama', 'pekerjaan_nama'),array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                            <?php //echo $form->textField($detail,'['.$i.']pekerjaan_nama',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                        </td>
                        <td>
                            <?php echo $form->dropDownList($detail,'['.$i.']pendidikan_nama',CHtml::listData(PendidikanM::model()->findAll(), 'pendidikan_nama', 'pendidikan_nama'),array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                        </td>
                        <td>
                            <?php $this->widget('MyDateTimePicker',array(
                                                    'model'=>$detail,
                                                    'attribute'=>'['.$i.']susunankel_tanggalpernikahan',
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
                            <?php echo $form->textField($detail,'['.$i.']susunankel_tempatpernikahan',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($detail,'['.$i.']susunankeluarga_nip',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                        </td>
                        <td>
                                                      
                            <?php echo CHtml::link('<i class="icon-minus">&nbsp;</i>','#',array('style'=>'display:none;','title'=>'Hapus data','rel'=>'tooltip','id'=>'hapus','onclick'=>'hapusOrganisasi(this);return false','style'=>'cursor:pointer;')); ?>
                        </td>
                    </tr>
                    
                        
                    <?php endforeach;
                }
                $x = 0;?>
                
                <tr>
                        
                            <?php echo $form->hiddenField($model,'pegawai_id',array('class'=>'span1 pegawai', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                            <?php //echo $form->hiddenField($model,'['.$x.']nama_pegawai',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        
                        <td style="padding-right: 0;">
                            
                            <?php echo $form->textField($model,'['.$x.']nourutkel',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        </td>
                        <td>
                            <?php echo $form->dropDownList($model, '['.$x.']hubkeluarga', LookupM::getItems('hubungankeluarga'), array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                            <?php //echo $form->textField($model,'['.$x.']hubkeluarga',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($model,'['.$x.']susunankel_nama',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?></td>
                        <td>
                            <?php echo $form->dropDownList($model, '['.$x.']susunankel_jk', LookupM::getItems('jeniskelamin'), array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                            <?php //echo $form->textField($model,'['.$x.']susunankel_jk',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($model,'['.$x.']susunankel_tempatlahir',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                        </td>
                        <td>                 
                            <?php $this->widget('MyDateTimePicker',array(
                                                'model'=>$model,
                                                'attribute'=>'['.$x.']susunankel_tanggallahir',
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
                            <?php echo $form->dropDownList($model,'['.$x.']pekerjaan_nama',CHtml::listData(PekerjaanM::model()->findAll(), 'pekerjaan_nama', 'pekerjaan_nama'),array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                        </td>
                        <td>
                            <?php echo $form->dropDownList($model,'['.$x.']pendidikan_nama',CHtml::listData(PendidikanM::model()->findAll(), 'pendidikan_nama', 'pendidikan_nama'),array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                            <?php //echo $form->textField($model,'['.$x.']pendidikan_nama',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                        </td>
                        <td>
                            <?php $this->widget('MyDateTimePicker',array(
                                                    'model'=>$model,
                                                    'attribute'=>'['.$x.']susunankel_tanggalpernikahan',
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
                            <?php echo $form->textField($model,'['.$x.']susunankel_tempatpernikahan',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($model,'['.$x.']susunankeluarga_nip',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>30)); ?>
                        </td>
                        <td>
                            <?php echo CHtml::link('<i class="icon-plus">&nbsp;</i>','',array('title'=>'Tambah data','rel'=>'tooltip','onclick'=>'tambahOrganisasi(this);return false','id'=>'tambah','style'=>'cursor:pointer;')); ?>
                            <?php echo CHtml::link('<i class="icon-minus">&nbsp;</i>','#',array('style'=>'display:none;','title'=>'Hapus data','rel'=>'tooltip','id'=>'hapus','onclick'=>'hapusOrganisasi(this);return false','style'=>'cursor:pointer;')); ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                                array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/susunankelM/admin'), 
                        array('class' => 'btn btn-default',
                              'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
	</div>

<?php $this->endWidget(); ?>
<script type="text/javascript">
    var trPendidikanpegawai=new String(<?php echo CJSON::encode($this->renderPartial('_rowSusunanKelM',array('form'=>$form,'model'=>$model,),true));?>);
</script>
<?php
$urlGetSusunanKeluarga = Yii::app()->createUrl('actionAjax/GetSusunanKeluarga');
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
            $(this).parents('tr').find('[name*="KPSusunankelM"]').each(function(){
                var input = $(this).attr('name');
                var data = input.split('KPSusunankelM[]');
                if (typeof data[1] === 'undefined'){} else{
                    $(this).attr('name','KPSusunankelM['+nourut+']'+data[1]);
                    if (data[1] == '[susunankel_tanggallahir]'){
                        $(this).attr('id','KPSusunankelM_'+nourut+'_susunankel_tanggallahir');
                        jQuery('#KPSusunankelM_'+nourut+'_susunankel_tanggallahir').datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['id'], {'dateFormat':'yy-mm-dd','timeText':'Waktu','hourText':'Jam','minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold'}));
                    }
                    if (data[1] == '[susunankel_tanggalpernikahan]'){
                        $(this).attr('id','KPSusunankelM_'+nourut+'_susunankel_tanggalpernikahan');
                        jQuery('#KPSusunankelM_'+nourut+'_susunankel_tanggalpernikahan').datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['id'], {'dateFormat':'yy-mm-dd','timeText':'Waktu','hourText':'Jam','minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold'}));
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
                $.post("${urlGetSusunanKeluarga}", {pegawai_id:pegawai_id,},
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

<?php
$js = <<< JS

//===============Awal untu Mengecek Form Sudah DiUbah Atw Belum====================    
    $(":input").keyup(function(event){
            $('#berubah').val('Ya');
         });
    $(":input").change(function(event){
            $('#berubah').val('Ya');
         });  
    $(":input").click(function(event){
            $('#berubah').val('Ya');
         });  
//================Akhir untuk Mengecek  Form Sudah DiUbah Atw Belum===================         
JS;
Yii::app()->clientScript->registerScript('tableDiklatpegawai', $js, CClientScript::POS_READY);
?>

<?php
$js = <<< JS
//==================================================Validasi===============================================
//*Jangan Lupa untuk menambahkan hiddenField dengan id "berubah" di setiap form
//* hidden field dengan id "url"
//*Copas Saja hiddenfield di Line 34 dan 35
//* ubah juga id button simpannya jadi "btn_simpan"

function palidasiForm(obj)
   {
        var berubah = $('#berubah').val();
        if(berubah=='Ya') 
        {
           if(confirm('Apakah Anda Akan menyimpan Perubahan Yang Sudah Dilakukan?'))
               {
                    $('#url').val(obj);
                    $('#btn_simpan').click();
          
               }

        }      
   }
JS;
Yii::app()->clientScript->registerScript('validasi', $js, CClientScript::POS_HEAD);
?>   
