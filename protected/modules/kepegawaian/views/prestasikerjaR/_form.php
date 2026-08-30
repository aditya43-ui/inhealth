
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'kpprestasikerja-r-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); ?>

	<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->

	<?php echo $form->errorSummary($model); ?>
        <fieldset id="divRiwayatPendidikanpegawai">
</fieldset>
            <div id="formOrganisasi">
            <table class="table table-bordered table-striped table-condensed" id="tableOrganisasipegawai" style="padding-left: 0; padding-right: 0;">
                <thead>
                    <tr>
                       
                        <th rowspan="2">No. Urut *</th>
                        <th rowspan="2">Tanggal Perolehan *</th>
                        <th rowspan="2">Instansi Pemberi</th>
                        <th rowspan="2">Penjabat Pemberi</th>
                        <th rowspan="2">Nama Penghargaan</th>
                        <th rowspan="2">Keterangan</th>
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
                            <?php echo $form->hiddenField($detail,'['.$i.']prestasikerja_id',array('class'=>'span1 pegawai', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                            <?php echo $form->hiddenField($detail,'['.$i.']pegawai_id',array('class'=>'span1 pegawai', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                            <?php //echo $form->hiddenField($detail,'['.$x.']nama_pegawai',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        <td>
                            <?php echo $form->textField($detail,'['.$i.']nourutprestasi',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        </td>
                        <td style="padding-right: 0;">
                            
                            <?php $this->widget('MyDateTimePicker',array(
                                                'model'=>$detail,
                                                'attribute'=>'['.$i.']tglprestasidiperoleh',
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
                            <?php echo $form->textField($detail,'['.$i.']instansipemberi',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($detail,'['.$i.']pejabatpemberi',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($detail,'['.$i.']namapenghargaan',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($detail,'['.$i.']keteranganprestasi',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                        </td>
                        <td>
                            <?php echo CHtml::link('<i class="icon-plus">&nbsp;</i>','',array('title'=>'Tambah data','rel'=>'tooltip','onclick'=>'tambahOrganisasi(this);return false','id'=>'tambah','style'=>'cursor:pointer;')); ?>
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
                        <td>
                            <?php echo $form->textField($model,'['.$x.']nourutprestasi',array('class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        </td>
                        <td style="padding-right: 0;">
                            
                            <?php $this->widget('MyDateTimePicker',array(
                                                'model'=>$model,
                                                'attribute'=>'['.$x.']tglprestasidiperoleh',
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
                            <?php echo $form->textField($model,'['.$x.']instansipemberi',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($model,'['.$x.']pejabatpemberi',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($model,'['.$x.']namapenghargaan',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($model,'['.$x.']keteranganprestasi',array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
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
                        Yii::app()->createUrl($this->module->id.'/prestasikerjaR/admin'), 
                        array('class' => 'btn btn-default',
                              'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
	</div>

<?php $this->endWidget(); ?>
<script type="text/javascript">
    var trPendidikanpegawai=new String(<?php echo CJSON::encode($this->renderPartial('_rowPrestasi',array('form'=>$form,'model'=>$model,),true));?>);
</script>
<?php
$urlGetPrestasikerja = Yii::app()->createUrl('PegawaiM/GetPrestasiKerja');
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
            $(this).parents('tr').find('[name*="KPPrestasikerjaR"]').each(function(){
                var input = $(this).attr('name');
                var data = input.split('KPPrestasikerjaR[]');
                if (typeof data[1] === 'undefined'){} else{
                    $(this).attr('name','KPPrestasikerjaR['+nourut+']'+data[1]);
                    if (data[1] == '[tglprestasidiperoleh]'){
                        $(this).attr('id','KPPrestasikerjaR_'+nourut+'_tglprestasidiperoleh');
                        jQuery('#KPPrestasikerjaR_'+nourut+'_tglprestasidiperoleh').datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['id'], {'dateFormat':'yy-mm-dd','timeText':'Waktu','hourText':'Jam','minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold'}));
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
                $.post("${urlGetPrestasikerja}", {pegawai_id:pegawai_id,},
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
