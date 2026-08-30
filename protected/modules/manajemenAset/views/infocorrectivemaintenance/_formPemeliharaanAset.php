<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?> 
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js'); ?>  
<?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
        array(
            'id'=>'pemeliharaanaset-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'focus'=>'#',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        )
    );
    
    $look_tek = LookupM::getItemsUrutan('jenisteknisi');
?>
<?php echo $form->errorSummary(array($model)); ?>

                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"> <i class="entypo-credit-card"></i> Pemeliharaan Aset</div>
                    </div>
                    <div class="panel-body">
                    <div class="col-sm-12">
                        <div class="control-group">
                            <?php echo CHtml::label('','sterilisasi_id',array('class'=>'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->hiddenField($model,'korektifmainten_id',array('class'=>'span3')); ?>
                                </div>
                        </div> 
                        <div class="control-group ">
			   <?php echo CHtml::label('Tanggal Pemeliharaan','',array('class'=>'control-label')); ?>
			        <div class="controls">
				    <?php
				    $this->widget('MyDateTimePicker', array(
					'model' => $model,
					'attribute' => 'korektifmainten_tglpawal',
					'mode' => 'datetime',
					'options' => array(
						'dateFormat' => Params::DATE_FORMAT,
					),
					'htmlOptions' => array('class' =>'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
				    )); ?>
                               </div> 
                                <div class="controls">
				    <?php
				    $this->widget('MyDateTimePicker', array(
					'model' => $model,
					'attribute' => 'korektifmainten_tglpakhir',
					'mode' => 'datetime',
					'options' => array(
						'dateFormat' => Params::DATE_FORMAT,
					),
					'htmlOptions' => array('class' =>'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
				    )); ?>
                                </div>
		        </div>
                        <div class="control-group">
                            <label class="control-label">Teknisi</label>
                            <div class="controls">
                                <table width="100%" class="table table-striped table-condensed table-bordered form-utama" id="tabel-teknisi" del="row_teknisi">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Jenis Teknisi</th>
                                            <th>Nama Teknisi</th>
                                            <th align="center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="form-body">
                                        <?php
                                        
                                            $cri = new CDbCriteria();
                                            $cri->addCondition(" pegawai_aktif = TRUE ");
                                            $cri->addCondition(" unitkerja_id IN (SELECT lookup_value::int FROM lookup_m where lookup_type = 'teknisicm') ");
                                            $cri->order = " nama_pegawai ASC ";
                                            $drop_ins = CHtml::listData(PegawaiV::model()->findAll($cri),'pegawai_id','namaLengkap');
                                            
                                            $drop_eks = CHtml::listData(TeknisiperalatanM::model()->findAllByAttributes([],['order'=>'namateknisi ASC']), 'teknisiperalatan_id', 'namateknisi');
                                        
                                            $tek = MATeknisipemeliharaanasetT::model()->findAllByAttributes([
                                                'korektifmainten_id' => $model->korektifmainten_id
                                            ]);
                                            
                                            if (!empty($tek)){
                                                foreach($tek as $i => $det){                                                      
                                                    $this->renderPartial($this->path_view.'ubahStatus/_row_teknisi',['model'=>$det, 'i'=>$i,'look_tek'=>$look_tek, 'drop_ins'=>$drop_ins, 'drop_eks'=>$drop_eks]);
                                                }
                                            }else{
                                                $this->renderPartial($this->path_view.'ubahStatus/_row_teknisi',['model'=>$modT, 'i'=>0, 'look_tek'=>$look_tek, 'drop_ins'=>$drop_ins, 'drop_eks'=>$drop_eks]);
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Kondisi Barang','',array('class'=>'control-label')); ?>
                                   <div class="controls">    
                                <?php echo $form->dropDownList($model, 'kondisi_barang', LookupM::getItems('kondisi_barang'), array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                        
                                   </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Catatan Perbaikan', '', array('class' => 'control-label')) ?>
                                    <div class="controls">
                                <?php echo $form->textArea($model, 'korektifmainten_catatan', array('class'=>'span3', 'placeholder'=>'Ketik Keterangan','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                                    </div>
                        </div>
                    </div>
                         
                   
                    </div>
                    <div class="form-actions">
    <?php
        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-danger submit', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)'));
    ?>
	<?php
        echo CHtml::htmlButton(
			Yii::t('mds','{icon} Cancel', array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
			array('class'=>'btn btn-default', 'type'=>'button','onClick'=>'closeDialog();')
		);
    ?>
</div>
                </div>
             
                         

            
<?php $this->endWidget(); ?>

<script type="text/javascript">
    
    var setNama = (obj) => {        
        var nama_teknisi = $(obj).select2('data');            
        $(obj).parents(".baris").find('.nama_teknisi').val(nama_teknisi.text);  
    }
    
   function loadDataPendaftaran()
    {
        var korektifmainten_id = $('#temp_dialogPemeliharaan').val();
        $('#KorektifmaintenT_korektifmainten_id').val(korektifmainten_id);
        
       
    }
    loadDataPendaftaran(); 
    function closeDialog(){
		window.parent.$('#temp_dialogPemeliharaan').dialog('close');
    }
    
    function generatePicker(){
    jQuery('input[name$="[korektifmainten_tglpawal]"]').datepicker(
                jQuery.extend(
                    {
                        showMonthAfterYear:false
                    }, 
                    jQuery.datepicker.regional['id'],
                    {
    
                        'minDate':'d',
                        'timeText':'Waktu',
                        'hourText':'Jam',
                        'minuteText':'Menit',
                        'secondText':'Detik',
                        'showSecond':true,
                        'timeOnlyTitle':'Pilih Waktu',
                        'timeFormat':'hh:mm:ss',
                        'changeYear':true,
                        'changeMonth':true,
                        'showAnim':'fold',
                        'yearRange':'-80y:+20y'
                    }
                )
            );//mask("99/99/9999 99:99:99")
     jQuery('input[name$="[korektifmainten_tglpakhir]"]').datepicker(
                jQuery.extend(
                    {
                        showMonthAfterYear:false
                    }, 
                    jQuery.datepicker.regional['id'],
                    {
    
                        'minDate':'d',
                        'timeText':'Waktu',
                        'hourText':'Jam',
                        'minuteText':'Menit',
                        'secondText':'Detik',
                        'showSecond':true,
                        'timeOnlyTitle':'Pilih Waktu',
                        'timeFormat':'hh:mm:ss',
                        'changeYear':true,
                        'changeMonth':true,
                        'showAnim':'fold',
                        'yearRange':'-80y:+20y'
                    }
                )
            );//mask("99/99/9999 99:99:99")
    }    
    
    var cekJenisTeknisi = () => {
        $("#tabel-teknisi > .form-body > .baris").each(function(){
            var jenis = $(this).find('.jenis_teknisi').val();
            
            $(this).find('.pegawai-ins').addClass('hide');
            $(this).find('.pegawai-eks').addClass('hide');
            if (jenis == 'Internal'){
                $(this).find('.pegawai-ins').removeClass('hide');
            }else{
                $(this).find('.pegawai-eks').removeClass('hide');
            }
        });
    }
    
    var set_action = (obj,jenis) => {
        var id_attr = $(obj).parents(".form-utama").attr('id');
        var set_obj = $("#"+id_attr);             

        if (jenis == 'tambah'){                    

            tambah_data_baris($(obj));                                 
                     
            $("#"+id_attr+" > .form-body > .baris:last").find('.select2-container').remove();
            $("#"+id_attr+" > .form-body > .baris:last").find('.internal_id,.eksternal_id').removeClass('select2-offscreen');
            $("#"+id_attr+" > .form-body > .baris:last").find('.internal_id,.eksternal_id').removeAttr('tabindex');
//            $("#"+id_attr+" > .form-body > .baris:last").find('.teknisiperalatan_id').removeAttr('id');
                     
            $("#"+id_attr+" > .form-body > .baris:last").find('input,select').val("");            
            
            renameInputRow(set_obj);
            
            $("#"+id_attr+" > .form-body > .baris:last").find('.internal_id, .eksternal_id').select2({
                allowClear:true,                    
                placeholder:'-- Pilih --',     
            });
            cekJenisTeknisi();
        }else if (jenis == 'hapus'){
            hapus_data_baris($(obj),function(){
                    renameInputRow(set_obj);
                    cekJenisTeknisi();
            });
        }                                                
    }
    
    var renameInputRow = (obj_table) => {
            var row = 0;
            var form_body = $(obj_table).find(".baris")
            var count = form_body.length;                 
            
                
            form_body.each(function(){                             
                $(this).find(".nomor").html(row+1);
                $(this).attr("row-data",row);
                $(this).find('input,select,textarea').each(function(){ //element <input>
                    if (typeof $(this).attr("name") !== 'undefined'){
                        var old_name = $(this).attr("name").replace(/]/g,"");
                        var old_name_arr = old_name.split("[");

                        if(old_name_arr.length == 3){
                            $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                            $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
                        }
                    }
                });
                
                $(this).find('.btn-tambah').removeClass('hide');
                $(this).find('.btn-hapus').removeClass('hide');
                if (row == 0) {
                    if (count == 1){                
                        $(this).find('.btn-hapus').addClass('hide');                    
                    }else{
                        $(this).find('.btn-tambah').addClass('hide');
                    }
                }else{                
                    if (count != (row+1)){
                        $(this).find('.btn-tambah').addClass('hide');  
                    }
                }
                
                row++;
            });

    }
    
    $(document).ready(function(){                
        setTimeout("generatePicker();",1000);
        renameInputRow($("#tabel-teknisi"));
        cekJenisTeknisi();
        $('.internal_id, .eksternal_id').select2({
            allowClear:true,
            width:'200px',
            placeholder:'-- Pilih --'
        }); 
    });   
</script>
