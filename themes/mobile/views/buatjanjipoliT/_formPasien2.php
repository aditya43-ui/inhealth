<!--<div id="divPasien"  style="display: block;">-->
    <div class="control-group">
<!--        <label class="control-label"><i class="icon-user"></i>
            <?php echo CHtml::checkBox('isPasienLama',false, array('rel'=>'tooltip','title'=>'Pilih Jika Pasien Lama', 'onkeypress'=>"return $(this).focusNextInputField(event)")) ?>
            No Rekam Medik &nbsp; 
      </label>-->
<!--                <div class="controls" id="controlNoRekamMedik">
        
                          <?php 
//                          $this->widget('MyJuiAutoComplete',array(
//                                    'name'=>'no_rekam_medik',
//                                    'value'=>$model->noRekamMedik,
//                                    'sourceUrl'=> Yii::app()->createUrl('ActionAutoComplete/PasienLama'),
//                                    'options'=>array(
//                                       'showAnim'=>'fold',
//                                       'style'=>'height:20px;',
//                                       'minLength' => 4,
//                                       'focus'=> 'js:function( event, ui ) {
//                                            $("#noRekamMedik").val( ui.item.value );
//                                            return false;
//                                        }',
//                                       'select'=>'js:function( event, ui ) {
//                                            $(\'#PPBuatJanjiPoliT_pasien_id\').val(ui.item.pasien_id);
//                                            $(\'#no_rekam_medik\').val(ui.item.no_rekam_medik);
//                                            $("#'.CHtml::activeId($modPasien,'jenisidentitas').'").val(ui.item.jenisidentitas);
//                                            $("#'.CHtml::activeId($modPasien,'no_identitas_pasien').'").val(ui.item.no_identitas_pasien);
//                                            $("#'.CHtml::activeId($modPasien,'namadepan').'").val(ui.item.namadepan);
//                                            $("#'.CHtml::activeId($modPasien,'nama_pasien').'").val(ui.item.nama_pasien);
//                                            $("#'.CHtml::activeId($modPasien,'nama_bin').'").val(ui.item.nama_bin);
//                                            $("#'.CHtml::activeId($modPasien,'tempat_lahir').'").val(ui.item.tempat_lahir);
//                                            $("#'.CHtml::activeId($modPasien,'tanggal_lahir').'").val(ui.item.tanggal_lahir);
//                                            $("#'.CHtml::activeId($modPasien,'kelompokumur_id').'").val(ui.item.kelompokumur_id);
//                                            $("#'.CHtml::activeId($modPasien,'jeniskelamin').'").val(ui.item.jeniskelamin);
//                                            setJenisKelaminPasien(ui.item.jeniskelamin);
//                                            setRhesusPasien(ui.item.rhesus);
//                                            loadDaerahPasien(ui.item.propinsi_id, ui.item.kabupaten_id, ui.item.kecamatan_id, ui.item.kelurahan_id);
//                                            $("#'.CHtml::activeId($modPasien,'statusperkawinan').'").val(ui.item.statusperkawinan);
//                                            $("#'.CHtml::activeId($modPasien,'golongandarah').'").val(ui.item.golongandarah);
//                                            $("#'.CHtml::activeId($modPasien,'rhesus').'").val(ui.item.rhesus);
//                                            $("#'.CHtml::activeId($modPasien,'alamat_pasien').'").val(ui.item.alamat_pasien);
//                                            $("#'.CHtml::activeId($modPasien,'rt').'").val(ui.item.rt);
//                                            $("#'.CHtml::activeId($modPasien,'rw').'").val(ui.item.rw);
//                                            $("#'.CHtml::activeId($modPasien,'propinsi_id').'").val(ui.item.propinsi_id);
//                                            $("#'.CHtml::activeId($modPasien,'kabupaten_id').'").val(ui.item.kabupaten_id);
//                                            $("#'.CHtml::activeId($modPasien,'kecamatan_id').'").val(ui.item.kecamatan_id);
//                                            $("#'.CHtml::activeId($modPasien,'kelurahan_id').'").val(ui.item.kelurahan_id);
//                                            $("#'.CHtml::activeId($modPasien,'no_telepon_pasien').'").val(ui.item.no_telepon_pasien);
//                                            $("#'.CHtml::activeId($modPasien,'no_mobile_pasien').'").val(ui.item.no_mobile_pasien);
//                                            $("#'.CHtml::activeId($modPasien,'suku_id').'").val(ui.item.suku_id);
//                                            $("#'.CHtml::activeId($modPasien,'alamatemail').'").val(ui.item.alamatemail);
//                                            $("#'.CHtml::activeId($modPasien,'anakke').'").val(ui.item.anakke);
//                                            $("#'.CHtml::activeId($modPasien,'jumlah_bersaudara').'").val(ui.item.jumlah_bersaudara);
//                                            $("#'.CHtml::activeId($modPasien,'pendidikan_id').'").val(ui.item.pendidikan_id);
//                                            $("#'.CHtml::activeId($modPasien,'pekerjaan_id').'").val(ui.item.pekerjaan_id);
//                                            $("#'.CHtml::activeId($modPasien,'agama').'").val(ui.item.agama);
//                                            $("#'.CHtml::activeId($modPasien,'warga_negara').'").val(ui.item.warga_negara);
//                                            loadUmur(ui.item.tanggal_lahir);
//                                            return false;
//                                        }',
//
//                                    ),
//                                    'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3 numbersOnly','disabled'=>TRUE),
//										'tombolDialog'=>array('idDialog'=>'dialogPasien'),
//                            )); ?>
                         <?php //echo $form->hiddenField($modPasien,'pasien_id',array('placeholder'=>'No. Rekam Medik','onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                         <?php //echo CHtml::textField('no_rekam_medik','',array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                         <?php //echo CHtml::htmlButton('<i class="entypo-search"></i>',
                              //  array('onclick'=>'$("#dialogPasien").dialog("open");return false;',
                                     // 'class'=>'btn btn-primary',
                                     // 'onkeypress'=>"return $(this).focusNextInputField(event)",
                                     // 'rel'=>"tooltip",
                                     // 'title'=>"Klik untuk mencari pasien yang sudah terdaftar",
                                    //  'id'=>'buttonSearch',
                                    //  'disabled'=>TRUE
                                   // )); ?>
                          
      </div>-->
</div>    
<fieldset id='fieldsetPasien'>
<!--                            <legend class="rim">Masukan Data Pasien</legend>-->
<table border="0">
  <tr>
    <td>
<!--	 <div class="control-group">-->
<!--
	<?php echo $form->labelEx($modPasien,'no_identitas_pasien', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($modPasien,'jenisidentitas', LookupM::getItems('jenisidentitas'),  
                                                      array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span1'
                                                            )); ?>   
                        <?php echo $form->textField($modPasien,'no_identitas_pasien', array('placeholder'=>'No Identitas','onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2')); ?>            
                        <?php echo $form->error($modPasien, 'jenisidentitas'); ?><?php echo $form->error($modPasien, 'no_identitas'); ?>
                    </div>
      
            -->
                 <div class="control-group">
                    <?php echo $form->labelEx($modPasien,'nama_pasien', array('class'=>'control-label')) ?>
                    <div class="controls inline">

                        <?php echo $form->dropDownList($modPasien,'namadepan', LookupM::getItems('namadepan'),  
                                                      array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span1', 
                                                            )); ?>   
                        <?php echo $form->textField($modPasien,'nama_pasien', array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span1')); ?>            

                        <?php echo $form->error($modPasien, 'namadepan'); ?><?php echo $form->error($modPasien, 'nama_pasien'); ?>
                    </div>
                </div>

                <?php //echo $form->textFieldRow($modPasien,'nama_bin', array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                <?php //echo $form->textFieldRow($modPasien,'tempat_lahir', array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
               
                <div class="control-group">
                    <?php echo $form->labelEx($modPasien,'tanggal_lahir', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php   
                                $this->widget('MyDateTimePicker',array(
                                                'model'=>$modPasien,
                                                'attribute'=>'tanggal_lahir',
                                                'mode'=>'date',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT_MEDIUM,
                                                    'maxDate' => 'd',
                                                    //
                                                    'onkeypress'=>"js:function(){getUmur(this);}",
                                                    'onSelect'=>'js:function(){getUmur(this);}',
                                                ),
                                                'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                ),
                        )); ?>
                        <?php echo $form->error($modPasien, 'tanggal_lahir'); ?>
                    </div>
                </div>
                
                <div class="control-group">
                    <?php echo $form->labelEx($modPasien,'umur', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php
                            $this->widget('CMaskedTextField', array(
                            'model' => $modPasien,
                            'attribute' => 'umur',
                            'mask' => '99 Thn 99 Bln 99 Hr',
                            'htmlOptions' => array('onkeypress'=>"return $(this).focusNextInputField(event)",'onblur'=>'getTglLahir(this)')
                            ));
                            ?>
                        <?php echo $form->error($modPasien, 'umur'); ?>
                    </div>
                </div>
                <?php echo $form->radioButtonListInlineRow($modPasien,'jeniskelamin', LookupM::getItems('jeniskelamin'), array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                <?php //echo $form->dropDownListRow($modPasien,'statusperkawinan', LookupM::getItems('statusperkawinan'),array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
           
<!--                 <div class="control-group">
                        <?php echo $form->labelEx($modPasien,'golongandarah', array('class'=>'control-label')) ?>

                        <div class="controls">

                            <?php echo $form->dropDownList($modPasien,'golongandarah', LookupM::getItems('golongandarah'),  
                                                          array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2')); ?>   
                            <div class="radio inline">
                                <div class="form-inline">
                                <?php echo $form->radioButtonList($modPasien,'rhesus',LookupM::getItems('rhesus'), array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>            
                                </div>
                           </div>
                            <?php echo $form->error($modPasien, 'golongandarah'); ?>
                            <?php echo $form->error($modPasien, 'rhesus'); ?>
                        </div>
      </div> -->
                  <?php echo $form->textAreaRow($modPasien,'alamat_pasien', array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>

<!--                  <div class="control-group">
                    <?php echo $form->labelEx($modPasien,'rt', array('class'=>'control-label inline ')) ?>

                    <div class="controls">
                        <?php echo $form->textField($modPasien,'rt', array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span1 numbersOnly','maxlength'=>3)); ?>   / 
                        <?php echo $form->textField($modPasien,'rw', array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span1 numbersOnly','maxlength'=>3)); ?>            
                        <?php echo $form->error($modPasien, 'rt'); ?>
                        <?php echo $form->error($modPasien, 'rw'); ?>
                    </div>
                </div>
            -->
	</td>
<!--    <td class="hilangkan">
	  <div class="control-group">
                    <?php echo $form->labelEx($modPasien,'propinsi_id', array('class'=>'control-label')) ?>
                    <div class="controls">
                    <?php echo $form->dropDownList($modPasien,'propinsi_id', CHtml::listData($modPasien->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), 
                                                      array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 
                                                            'ajax'=>array('type'=>'POST',
                                                                          'url'=>Yii::app()->createUrl('ActionDynamic/GetKabupaten',array('encode'=>false,'namaModel'=>'PPPasienM')),
                                                                          'update'=>'#PPPasienM_kabupaten_id',),
                                                            'onchange'=>"clearKecamatan();clearKelurahan();",)); ?>
                   <?php echo $form->error($modPasien, 'propinsi_id'); ?>
                    </div>
                </div>
                
                <div class="control-group">
                    <?php echo $form->labelEx($modPasien,'kabupaten_id', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($modPasien,'kabupaten_id',CHtml::listData($modPasien->getKabupatenItems($modPasien->propinsi_id), 'kabupaten_id', 'kabupaten_nama'),
                                                          array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                                'ajax'=>array('type'=>'POST',
                                                                              'url'=>Yii::app()->createUrl('ActionDynamic/GetKecamatan',array('encode'=>false,'namaModel'=>'PPPasienM')),
                                                                              'update'=>'#PPPasienM_kecamatan_id'),
                                                                'onchange'=>"clearKelurahan();",)); ?>
                        <?php echo $form->error($modPasien, 'kabupaten_id'); ?>
                    </div>
                </div>
            
                <div class="control-group">
                    <?php echo $form->labelEx($modPasien,'kecamatan_id', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($modPasien,'kecamatan_id',CHtml::listData($modPasien->getKecamatanItems($modPasien->kabupaten_id), 'kecamatan_id', 'kecamatan_nama'),
                                                          array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                                'ajax'=>array('type'=>'POST',
                                                                              'url'=>Yii::app()->createUrl('ActionDynamic/GetKelurahan',array('encode'=>false,'namaModel'=>'PPPasienM')),
                                                                              'update'=>'#PPPasienM_kelurahan_id'))); ?>
                        <?php echo $form->error($modPasien, 'kecamatan_id'); ?>
                    </div>
                </div>
                
                 <div class="control-group">
                    <?php echo $form->labelEx($modPasien,'kelurahan_id', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($modPasien,'kelurahan_id',CHtml::listData($modPasien->getKelurahanItems($modPasien->kecamatan_id), 'kelurahan_id', 'kelurahan_nama'),
                                                          array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                        <?php echo $form->error($modPasien, 'kelurahan_id'); ?>
                    </div>
                </div>


                 <?php echo $form->dropDownListRow($modPasien,'agama', LookupM::getItems('agama'),array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                 <?php echo $form->dropDownListRow($modPasien,'pendidikan_id', CHtml::listData($modPasien->getPendidikanItems(), 'pendidikan_id', 'pendidikan_nama'),array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                 <?php echo $form->dropDownListRow($modPasien,'pekerjaan_id', CHtml::listData($modPasien->getPekerjaanItems(), 'pekerjaan_id', 'pekerjaan_nama'),array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                 <?php echo $form->dropDownListRow($modPasien,'warga_negara', LookupM::getItems('warganegara'),array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>

	</td>-->
  </tr>
</table>
  
	 
    </fieldset>
<!--</div>-->
                
              
<?php 
// Dialog buat nambah data propinsi =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogAddPropinsi',
    'options'=>array(
        'title'=>'Menambah data Propinsi',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>450,
        'height'=>350,
        'resizable'=>false,
    ),
));

echo '<div class="divForForm"></div>';


$this->endWidget();
//========= end propinsi dialog =============================

// Dialog buat nambah data kabupaten =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogAddKabupaten',
    'options'=>array(
        'title'=>'Menambah data Kabupaten',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>450,
        'height'=>440,
        'resizable'=>false,
    ),
));

echo '<div class="divForFormKabupaten"></div>';


$this->endWidget();
//========= end kabupaten dialog =============================

// Dialog buat nambah data kecamatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogAddKecamatan',
    'options'=>array(
        'title'=>'Menambah data Kecamatan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>450,
        'height'=>440,
        'resizable'=>false,
    ),
));

echo '<div class="divForFormKecamatan"></div>';


$this->endWidget();
//========= end kecamatan dialog =============================

// Dialog buat nambah data kelurahan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogAddKelurahan',
    'options'=>array(
        'title'=>'Menambah data Kelurahan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>450,
        'height'=>440,
        'resizable'=>false,
    ),
));

echo '<div class="divForFormKelurahan"></div>';


$this->endWidget();
//========= end kelurahan dialog =============================
?>
<script type="text/javascript">
// here is the magic
function addPropinsi()
{
    <?php echo CHtml::ajax(array(
            'url'=>Yii::app()->createUrl('ActionAjax/addPropinsi'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'create_form')
                {
                    $('#dialogAddPropinsi div.divForForm').html(data.div);
                    $('#dialogAddPropinsi div.divForForm form').submit(addPropinsi);
                }
                else
                {
                    $('#dialogAddPropinsi div.divForForm').html(data.div);
                    $('#PPPasienM_propinsi_id').html(data.propinsi);
                    setTimeout(\"$('#dialogAddPropinsi').dialog('close') \",1000);
                }
 
            } ",
    ))?>;
    return false; 
}

function addKabupaten()
{
    <?php echo CHtml::ajax(array(
            'url'=>Yii::app()->createUrl('ActionAjax/addKabupaten'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'create_form')
                {
                    $('#dialogAddKabupaten div.divForFormKabupaten').html(data.div);
                    $('#dialogAddKabupaten div.divForFormKabupaten form').submit(addKabupaten);
                }
                else
                {
                    $('#dialogAddKabupaten div.divForFormKabupaten').html(data.div);
                    $('#PPPasienM_kabupaten_id').html(data.kabupaten);
                    setTimeout(\"$('#dialogAddKabupaten').dialog('close') \",1000);
                }
 
            } ",
    ))?>;
    return false; 
}

function addKecamatan()
{
    <?php echo CHtml::ajax(array(
            'url'=>Yii::app()->createUrl('ActionAjax/addKecamatan'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'create_form')
                {
                    $('#dialogAddKecamatan div.divForFormKecamatan').html(data.div);
                    $('#dialogAddKecamatan div.divForFormKecamatan form').submit(addKecamatan);
                }
                else
                {
                    $('#dialogAddKecamatan div.divForFormKecamatan').html(data.div);
                    $('#PPPasienM_kecamatan_id').html(data.kecamatan);
                    setTimeout(\"$('#dialogAddKecamatan').dialog('close') \",1000);
                }
 
            } ",
    ))?>;
    return false; 
}

function addKelurahan()
{
    <?php echo CHtml::ajax(array(
            'url'=>Yii::app()->createUrl('ActionAjax/addKelurahan'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'create_form')
                {
                    $('#dialogAddKelurahan div.divForFormKelurahan').html(data.div);
                    $('#dialogAddKelurahan div.divForFormKelurahan form').submit(addKelurahan);
                }
                else
                {
                    $('#dialogAddKelurahan div.divForFormKelurahan').html(data.div);
                    $('#PPPasienM_kelurahan_id').html(data.kelurahan);
                    setTimeout(\"$('#dialogAddKelurahan').dialog('close') \",1000);
                }
 
            } ",
    ))?>;
    return false; 
}
</script>
<?php
$urlGetTglLahir = Yii::app()->createUrl('ActionAjax/GetTglLahir');
$urlGetUmur = Yii::app()->createUrl('ActionAjax/GetUmur');
$urlGetDaerah = Yii::app()->createUrl('ActionAjax/getListDaerahPasien');
$idTagUmur = CHtml::activeId($modPasien,'umur');
$js = <<< JS
function clearKecamatan()
{
    $('#PPPasienM_kecamatan_id').find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
}

function clearKelurahan()
{
    $('#PPPasienM_kelurahan_id').find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
}

function getTglLahir(obj)
{   
    var str = obj.value;
    obj.value = str.replace(/_/gi, "0");
    $.post("${urlGetTglLahir}",{umur: obj.value},
        function(data){
           $('#PPPasienM_tanggal_lahir').val(data.tglLahir); 
    },"json");
}
    
function getUmur(obj)
{
    //alert(obj.value);
    if(obj.value == '')
        obj.value = 0;
    $.post("${urlGetUmur}",{tglLahir: obj.value},
        function(data){

           $('#PPPasienM_umur').val(data.umur);
    },"json");
}
JS;
Yii::app()->clientScript->registerScript('formPasien',$js,CClientScript::POS_HEAD);

$js = <<< JS
$('.numbersOnly').keyup(function() {
var d = $(this).attr('numeric');
var value = $(this).val();
var orignalValue = value;
value = value.replace(/[0-9]*/g, "");
var msg = "Only Integer Values allowed.";

if (d == 'decimal') {
value = value.replace(/\./, "");
msg = "Only Numeric Values allowed.";
}

if (value != '') {
orignalValue = orignalValue.replace(/([^0-9].*)/g, "")
$(this).val(orignalValue);
}
});
JS;
Yii::app()->clientScript->registerScript('numberOnly',$js,CClientScript::POS_READY);
?>