
<fieldset id='fieldsetPasien'>
    <legend class="rim">Data Pasien</legend>
    <?php //echo $form->textFieldRow($modPasien,'no_rekam_medik'); ?>
	
	<table width="1039" border="0">
  <tr>
    <td>
<!--    <div class="control-group">
        <?php echo $form->labelEx($modPasien,'no_identitas_pasien', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($modPasien,'jenisidentitas', LookupM::getItems('jenisidentitas'),  
                                          array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2'
                                                )); ?>   
            <?php echo $form->textField($modPasien,'no_identitas_pasien', array('placeholder'=>'No Identitas','onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2')); ?>            
            <?php echo $form->error($modPasien, 'jenisidentitas'); ?><?php echo $form->error($modPasien, 'no_identitas'); ?>
        </div>
    </div>-->

    <?php //echo $form->dropDownListRow($modPasien,'jenisidentitas', LookupM::getItems('jenisidentitas'),array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
    <?php //echo $form->textFieldRow($modPasien,'no_identitas_pasien',array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
    <div class="control-group">
        <?php echo $form->labelEx($modPasien,'nama_pasien', array('class'=>'control-label')) ?>
        <div class="controls inline">
            
            <?php echo $form->dropDownList($modPasien,'namadepan', LookupM::getItems('namadepan'),  
                                          array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span1'
                                                )); ?>   
            <?php echo $form->textField($modPasien,'nama_pasien', array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span1')); ?>            

            <?php echo $form->error($modPasien, 'namadepan'); ?><?php echo $form->error($modPasien, 'nama_pasien'); ?>
        </div>
    </div>
    
    <?php //echo $form->dropDownListRow($modPasien,'namadepan', LookupM::getItems('namadepan'),array('empty'=>'-- Pilih --','class'=>'span1','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
    <?php //echo $form->textFieldRow($modPasien,'nama_pasien',array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
    <?php //echo $form->textFieldRow($modPasien,'nama_bin', array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
    <?php //echo $form->textFieldRow($modPasien,'tempat_lahir', array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
    <?php //echo $form->textFieldRow($modPasien,'tanggal_lahir'); ?>
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
                                        'yearRange'=> "-60:+0",
                                    ),
                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                    ),
            )); ?>
            <?php echo $form->error($modPasien, 'tanggal_lahir'); ?>
        </div>
    </div>
    
    <?php //echo $form->textFieldRow($model,'umur', array('onkeypress'=>"return $(this).focusNextInputField(event)",'onblur'=>'getTglLahir(this)')); ?>
    <div class="control-group">
        <?php echo $form->labelEx($model,'umur', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php
                $this->widget('CMaskedTextField', array(
                'model' => $model,
                'attribute' => 'umur',
                'mask' => '99 Thn 99 Bln 99 Hr',
                'htmlOptions' => array('onkeypress'=>"return $(this).focusNextInputField(event)",'onblur'=>'getTglLahir(this)')
                ));
                ?>
            <?php echo $form->error($model, 'umur'); ?>
        </div>
    </div>

    <?php //echo $form->dropDownListRow($modPasien,'kelompokumur', LookupM::getItems('kelompokumur'),array('empty'=>'-- Pilih --', 'class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
    <?php echo $form->radioButtonListInlineRow($modPasien, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
    <?php //echo $form->dropDownListRow($modPasien,'jeniskelamin', LookupM::getItems('jeniskelamin'),array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
    <?php //echo $form->dropDownListRow($modPasien,'statusperkawinan', LookupM::getItems('statusperkawinan'),array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
<!-- 
    <div class="control-group">
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
    </div>-->
    <?php //echo $form->dropDownListRow($modPasien,'golongandarah', LookupM::getItems('golongandarah'),array('empty'=>'-- Pilih --','class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
    
    <?php //echo $form->dropDownListRow($modPasien,'rhesus', LookupM::getItems('rhesus'),array('empty'=>'-- Pilih --','class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
    
    <?php echo $form->textAreaRow($modPasien,'alamat_pasien', array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
    <?php //echo $form->textFieldRow($modPasien,'rt',array('class'=>'span1','maxlength'=>3, 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
<!--    <div class="control-group">
        <?php echo $form->labelEx($modPasien,'rt', array('class'=>'control-label inline')) ?>
        
        <div class="controls">
            <?php echo $form->textField($modPasien,'rt', array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span1 numberOnly','maxlength'=>3)); ?>   / 
            <?php echo $form->textField($modPasien,'rw', array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span1 numberOnly','maxlength'=>3)); ?>            
            <?php echo $form->error($modPasien, 'rt'); ?>
            <?php echo $form->error($modPasien, 'rw'); ?>
        </div>
    </div>-->
	
	</td>
<!--    <td>
    <?php //echo $form->textFieldRow($modPasien,'rw',array('class'=>'span1','maxlength'=>3, 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
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
    
    <?php //echo $form->textFieldRow($modPasien,'tgl_meninggal'); ?>
    
	</td>-->
  </tr>
</table>
  
</fieldset>
<?php
$urlGetTglLahir = Yii::app()->createUrl('ActionAjax/GetTglLahir');
$urlGetUmur = Yii::app()->createUrl('ActionAjax/GetUmur');
$urlGetDaerah = Yii::app()->createUrl('ActionAjax/getListDaerahPasien');
$idTagUmur = CHtml::activeId($model,'umur');
$js = <<< JS
function enableInputPasien(obj)
{
    if(!obj.checked) {
        $('#fieldsetPasien input').removeAttr('disabled');
        $('#fieldsetPasien select').removeAttr('disabled');
        $('#fieldsetPasien textarea').removeAttr('disabled');
        $('#fieldsetPasien button').removeAttr('disabled');
        $('#fieldsetDetailPasien input').removeAttr('disabled');
        $('#fieldsetDetailPasien select').removeAttr('disabled');
        $('#controlNoRekamMedik button').attr('disabled','true');
        $('#noRekamMedik').attr('disabled','true');
        $('#detail_data_pasien').slideUp(500);
        $('#cex_detaildatapasien').removeAttr('checked','checked');
    }
    else {
        $('#fieldsetPasien input').attr('disabled','true');
        $('#fieldsetPasien select').attr('disabled','true');
        $('#fieldsetPasien textarea').attr('disabled','true');
        $('#fieldsetPasien button').attr('disabled','true');
        $('#fieldsetDetailPasien input').attr('disabled','true');
        $('#fieldsetDetailPasien select').attr('disabled','true');
        $('#controlNoRekamMedik button').removeAttr('disabled');
        $('#noRekamMedik').removeAttr('disabled');
        $('#detail_data_pasien').slideDown(500);
        $('#cex_detaildatapasien').attr('checked','checked');
    }
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

           $('#PPPendaftaranRj_umur').val(data.umur); 
           $('#PPPendaftaranMp_umur').val(data.umur); 
           $('#PPPendaftaranRd_umur').val(data.umur); 

           $("#${idTagUmur}").val(data.umur);
    },"json");
}

function loadUmur(tglLahir)
{
    $.post("${urlGetUmur}",{tglLahir: tglLahir},
        function(data){
           $("#${idTagUmur}").val(data.umur);
    },"json");
}

function setJenisKelaminPasien(jenisKelamin)
{
    $('input[name="PPPasienM[jeniskelamin]"]').each(function(){
            if(this.value == jenisKelamin)
                $(this).attr('checked',true);
        }
    );
}

function setRhesusPasien(rhesus)
{
    $('input[name="PPPasienM[rhesus]"]').each(function(){
            if(this.value == rhesus)
                $(this).attr('checked',true);
        }
    );
}

function loadDaerahPasien(idProp,idKab,idKec,idKel)
{
    $.post("${urlGetDaerah}", { idProp: idProp, idKab: idKab, idKec: idKec, idKel: idKel },
        function(data){
            $('#PPPasienM_propinsi_id').html(data.listPropinsi);
            $('#PPPasienM_kabupaten_id').html(data.listKabupaten);
            $('#PPPasienM_kecamatan_id').html(data.listKecamatan);
            $('#PPPasienM_kelurahan_id').html(data.listKelurahan);
    }, "json");
}

function clearKecamatan()
{
    $('#PPPasienM_kecamatan_id').find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
}

function clearKelurahan()
{
    $('#PPPasienM_kelurahan_id').find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
}
JS;
Yii::app()->clientScript->registerScript('formPasien',$js,CClientScript::POS_HEAD);

$enableInputPasien = ($model->isPasienLama) ? 1 : 0;
$js = <<< JS
if(${enableInputPasien}) {
    $('#fieldsetPasien input').attr('disabled','true');
    $('#fieldsetPasien select').attr('disabled','true');
    $('#fieldsetDetailPasien input').attr('disabled','true');
    $('#fieldsetDetailPasien select').attr('disabled','true');
    $('#PPPasienM_no_rekam_medik').removeAttr('disabled');
    $('#controlNoRekamMedik button').removeAttr('disabled');
    $('#fieldsetPasien button').attr('disabled','true');
}
else {
    $('#fieldsetPasien input').removeAttr('disabled');
    $('#fieldsetPasien select').removeAttr('disabled');
    $('#fieldsetDetailPasien input').removeAttr('disabled');
    $('#fieldsetDetailPasien select').removeAttr('disabled');
    $('#PPPasienM_no_rekam_medik').attr('disabled','true');
    $('#controlNoRekamMedik button').attr('disabled','true');
    $('#fieldsetPasien button').removeAttr('disabled');
}
JS;
Yii::app()->clientScript->registerScript('formPasien',$js,CClientScript::POS_READY);
?>

<?php 
//========= Dialog buat cari data pasien =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPasien',
    'options'=>array(
        'title'=>'Pencarian Data Pasien',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>400,
        'resizable'=>false,
    ),
));

$modDataPasien = new PPPasienM('searchWithDaerah');
$modDataPasien->unsetAttributes();
if(isset($_GET['PPPasienM'])) {
    $modDataPasien->attributes = $_GET['PPPasienM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pasien-m-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
	'dataProvider'=>$modDataPasien->searchWithDaerah(),
	'filter'=>$modDataPasien,
        'template'=>"{pager}{summary}\n{items}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                        array(
                            'header'=>'Pilih',
                            'type'=>'raw',
                            'value'=>'CHtml::Link("<i class=\"icon-check\"></i>","#",array("class"=>"btn-small", 
                                            "id" => "selectPasien",
                                            "onClick" => "
                                                $(\"#dialogPasien\").dialog(\"close\");
                                                $(\"#noRekamMedik\").val(\"$data->no_rekam_medik\");
                                                $(\"#'.CHtml::activeId($modPasien,'nama_pasien').'\").val(\"$data->nama_pasien\");
                                              
                                                setJenisKelaminPasien(\"$data->jeniskelamin\");
                                                setRhesusPasien(\"$data->rhesus\");
                                                loadDaerahPasien($data->propinsi_id,$data->kabupaten_id,$data->kecamatan_id,$data->kelurahan_id);
                                                $(\"#'.CHtml::activeId($modPasien,'jenisidentitas').'\").val(\"$data->jenisidentitas\");
                                                $(\"#'.CHtml::activeId($modPasien,'no_identitas_pasien').'\").val(\"$data->no_identitas_pasien\");
                                                $(\"#'.CHtml::activeId($modPasien,'namadepan').'\").val(\"$data->namadepan\");
                                                $(\"#'.CHtml::activeId($modPasien,'nama_pasien').'\").val(\"$data->nama_pasien\");
                                                $(\"#'.CHtml::activeId($modPasien,'nama_bin').'\").val(\"$data->nama_bin\");
                                                $(\"#'.CHtml::activeId($modPasien,'tempat_lahir').'\").val(\"$data->tempat_lahir\");
                                                $(\"#'.CHtml::activeId($modPasien,'tanggal_lahir').'\").val(\"$data->tanggal_lahir\");
                                                $(\"#'.CHtml::activeId($modPasien,'kelompokumur_id').'\").val(\"$data->kelompokumur_id\");
                                                $(\"#'.CHtml::activeId($modPasien,'jeniskelamin').'\").val(\"$data->jeniskelamin\");
                                                $(\"#'.CHtml::activeId($modPasien,'statusperkawinan').'\").val(\"$data->statusperkawinan\");
                                                $(\"#'.CHtml::activeId($modPasien,'golongandarah').'\").val(\"$data->golongandarah\");
                                                $(\"#'.CHtml::activeId($modPasien,'rhesus').'\").val(\"$data->rhesus\");
                                                $(\"#'.CHtml::activeId($modPasien,'alamat_pasien').'\").val(\"$data->alamat_pasien\");
                                                $(\"#'.CHtml::activeId($modPasien,'rt').'\").val(\"$data->rt\");
                                                $(\"#'.CHtml::activeId($modPasien,'rw').'\").val(\"$data->rw\");
                                                $(\"#'.CHtml::activeId($modPasien,'propinsi_id').'\").val(\"$data->propinsi_id\");
                                                $(\"#'.CHtml::activeId($modPasien,'kabupaten_id').'\").val(\"$data->kabupaten_id\");
                                                $(\"#'.CHtml::activeId($modPasien,'kecamatan_id').'\").val(\"$data->kecamatan_id\");
                                                $(\"#'.CHtml::activeId($modPasien,'kelurahan_id').'\").val(\"$data->kelurahan_id\");
                                                $(\"#'.CHtml::activeId($modPasien,'no_telepon_pasien').'\").val(\"$data->no_telepon_pasien\");
                                                $(\"#'.CHtml::activeId($modPasien,'no_mobile_pasien').'\").val(\"$data->no_mobile_pasien\");
                                                $(\"#'.CHtml::activeId($modPasien,'suku_id').'\").val(\"$data->suku_id\");
                                                $(\"#'.CHtml::activeId($modPasien,'alamatemail').'\").val(\"$data->alamatemail\");
                                                $(\"#'.CHtml::activeId($modPasien,'anakke').'\").val(\"$data->anakke\");
                                                $(\"#'.CHtml::activeId($modPasien,'jumlah_bersaudara').'\").val(\"$data->jumlah_bersaudara\");
                                                $(\"#'.CHtml::activeId($modPasien,'pendidikan_id').'\").val(\"$data->pendidikan_id\");
                                                $(\"#'.CHtml::activeId($modPasien,'pekerjaan_id').'\").val(\"$data->pekerjaan_id\");
                                                $(\"#'.CHtml::activeId($modPasien,'agama').'\").val(\"$data->agama\");
                                                $(\"#'.CHtml::activeId($modPasien,'warga_negara').'\").val(\"$data->warga_negara\");
                                                loadUmur(\"$data->tanggal_lahir\");
                                                $(\"dataPesan\").html(\'\');
                                                getRuanganberdasarkanRM(\"$data->no_rekam_medik\");
                                                $(\"#'.CHtml::activeId($model,'pasien_id').'\").val(\"$data->pasien_id\");
                                                $(\"#'.CHtml::activeId($modPasien,'no_rekam_medik').'\").val(\"$data->no_rekam_medik\");
                                            "))',
                        ),
                'no_rekam_medik',
                'nama_pasien',
                'nama_bin',
                'alamat_pasien',
                'rw',
                'rt',
                array(
                    'name'=>'propinsiNama',
                    'value'=>'$data->propinsi->propinsi_nama',
                ),
                array(
                    'name'=>'kabupatenNama',
                    'value'=>'$data->kabupaten->kabupaten_nama',
                ),
                array(
                    'name'=>'kecamatanNama',
                    'value'=>'$data->kecamatan->kecamatan_nama',
                ),
                array(
                    'name'=>'kelurahanNama',
                    'value'=>'$data->kelurahan->kelurahan_nama',
                ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
//========= end pasien dialog =============================
?>

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

<?php Yii::app()->clientScript->registerScript('detail_data_pasien',"
    $('#detail_data_pasien').hide();
    $('#cex_detaildatapasien').change(function(){
        if ($(this).is(':checked')){
                $('#fieldsetDetailPasien input').not('input[type=checkbox]').removeAttr('disabled');
                $('#fieldsetDetailPasien select').removeAttr('disabled');
        }else{
                $('#fieldsetDetailPasien input').not('input[type=checkbox]').attr('disabled','true');
                $('#fieldsetDetailPasien select').attr('disabled','true');
                $('#fieldsetDetailPasien input').attr('value','');
                $('#fieldsetDetailPasien select').attr('value','');
        }
        $('#detail_data_pasien').slideToggle(500);
    });
");
$js = <<< JS
$('.numberOnly').keyup(function() {
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