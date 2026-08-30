
<div id="divPasien"  style="display: block;">
    
<fieldset id='fieldsetPasien'>
<div class="block-kioskmodule" id="buatjanji" name="buatjanji">
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="panel-title">Data Pasien</div>
			</div>
			<div class="panel-body">
                                <table width="100%">
                                  <tr>
                                    <td>
                                                    <div class="control-group ">

                                                     <?php echo $form->labelEx($modPasien,'no_identitas_pasien', array('class'=>'control-label')) ?>
                                                    <div class="controls">
                                                        <?php echo $form->dropDownList($modPasien,'jenisidentitas', LookupM::getItems('jenisidentitas'),  
                                                                                      array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2'
                                                                                            )); ?>   
                                                        <?php echo $form->textField($modPasien,'no_identitas_pasien', array('placeholder'=>'','onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2')); ?>            
                                                        <?php echo $form->error($modPasien, 'jenisidentitas'); ?><?php echo $form->error($modPasien, 'no_identitas'); ?>
                                                    </div>

                                                </div>    
                                                 <div class="control-group ">
                                                    <?php echo $form->labelEx($modPasien,'nama_pasien', array('class'=>'control-label')) ?>
                                                    <div class="controls inline">

                                        </div>
                                        <div class="control-group">
                                            <?php echo $form->labelEx($modPasien, 'nama_pasien', array('class' => 'control-label')) ?>
                                            <div class="controls inline">

                                                <?php echo $form->dropDownList(
                                                    $modPasien,
                                                    'namadepan',
                                                    LookupM::getItems('namadepan'),
                                                    array(
                                                        'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2'
                                                    )
                                                ); ?>
                                                <?php echo $form->textField($modPasien, 'nama_pasien', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2', 'placeholder' => '')); ?>

                                                <?php echo $form->error($modPasien, 'namadepan'); ?><?php echo $form->error($modPasien, 'nama_pasien'); ?>
                                            </div>
                                        </div>

                                        <?php echo $form->textFieldRow($modPasien, 'nama_bin', array('onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => '')); ?>
                                        <?php echo $form->textFieldRow($modPasien, 'tempat_lahir', array('onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => '')); ?>


                                                <?php echo $form->textFieldRow($modPasien,'nama_bin', array('onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'')); ?>
                                                <?php echo $form->textFieldRow($modPasien,'tempat_lahir', array('onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'')); ?>

                                                <div class="control-group ">
                                                    <?php echo $form->labelEx($modPasien,'tanggal_lahir', array('class'=>'control-label')) ?>
                                                    <div class="controls">
                                                        <?php   
                                                                $this->widget('MyDateTimePicker',array(
                                                                                'model'=>$modPasien,
                                                                                'attribute'=>'tanggal_lahir',
                                                                                'mode'=>'date',
                                                                                'options'=> array(
                                                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                                                    'maxDate' => 'd',
                                                                                    //
                                                                                    'onkeypress'=>"js:function(){getUmurP(this);}",
                                                                                    'onSelect'=>'js:function(){getUmurP(this);}',
                                                                                ),
                                                                                'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                                                ),
                                                        )); ?>
                                                        <?php echo $form->error($modPasien, 'tanggal_lahir'); ?>
                                                    </div>
                                                </div>

                                                <div class="control-group ">
                                                    <?php echo $form->labelEx($modPasien,'umur', array('class'=>'control-label')) ?>
                                                    <div class="controls">
                                                        <?php
                                                            $this->widget('CMaskedTextField', array(
                                                            'model' => $modPasien,
                                                            'attribute' => 'umur',
                                                            'mask' => '99 Thn 99 Bln 99 Hr',
                                                            'htmlOptions' => array('onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'')
                                                            ));
                                                            ?>
                                                        <?php echo $form->error($modPasien, 'umur',array('placeholder'=>'')); ?>
                                                    </div>
                                                </div>

                                    </td>
                                    <td>

                                        <div class="control-group">
                                            <label class="control-label"><i class="icon-user"></i>

                                                <?php // echo CHtml::checkBox('isPasienLama',false, array('rel'=>'tooltip','title'=>'Pilih Jika Pasien Lama', 'onkeypress'=>"return $(this).focusNextInputField(event)")) ?>
                                                No. Rekam Medik &nbsp; 
                                            </label>
                                            <div class="controls" id="controlNoRekamMedik">
                                                <?php echo $form->textField($modPasien, 'no_rekam_medik', array('placeholder' => '', 'onChange' => "return cek_data()", 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3')); ?>
                                            </div>
                                        </div>
                                        <?php echo $form->radioButtonListInlineRow($modPasien, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                                        <?php echo $form->dropDownListRow($modPasien, 'statusperkawinan', LookupM::getItems('statusperkawinan'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>

                                        <div class="control-group ">
                                            <?php echo $form->labelEx($modPasien,'golongandarah', array('class'=>'control-label')) ?>

                                            <div class="controls">

                                                <?php echo $form->dropDownList(
                                                    $modPasien,
                                                    'golongandarah',
                                                    LookupM::getItems('golongandarah'),
                                                    array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2')
                                                ); ?>
                                                <div class="radio inline">
                                                    <div class="form-inline">
                                                        <?php echo $form->radioButtonList($modPasien, 'rhesus', LookupM::getItems('rhesus'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                                                    </div>
                                                </div>
                                                <?php echo $form->error($modPasien, 'golongandarah'); ?>
                                                <?php echo $form->error($modPasien, 'rhesus'); ?>
                                            </div>
                                        </div>
                                        <?php echo $form->textAreaRow($modPasien, 'alamat_pasien', array('onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => '')); ?>


                                        <div class="control-group ">
                                            <?php echo $form->labelEx($modPasien,'rt', array('class'=>'control-label inline ')) ?>

                                            <div class="controls">
                                                <?php echo $form->textField($modPasien, 'rt', array('placeholder' => '', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span1 numbersOnly', 'maxlength' => 3)); ?> /
                                                <?php echo $form->textField($modPasien, 'rw', array('placeholder' => '', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span1 numbersOnly', 'maxlength' => 3)); ?>
                                                <?php echo $form->error($modPasien, 'rt'); ?>
                                                <?php echo $form->error($modPasien, 'rw'); ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    </fieldset>
</div>


<?php

// Dialog buat nambah data kabupaten =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogAddKabupaten',
    'options' => array(
        'title' => 'Menambah data Kabupaten',
        'autoOpen' => false,
        'modal' => true,
        'width' => 450,
        'height' => 440,
        'resizable' => false,
    ),
));

echo '<div class="divForFormKabupaten"></div>';


$this->endWidget();
//========= end kabupaten dialog =============================

// Dialog buat nambah data kecamatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogAddKecamatan',
    'options' => array(
        'title' => 'Menambah data Kecamatan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 450,
        'height' => 440,
        'resizable' => false,
    ),
));

echo '<div class="divForFormKecamatan"></div>';


$this->endWidget();
//========= end kecamatan dialog =============================

// Dialog buat nambah data kelurahan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogAddKelurahan',
    'options' => array(
        'title' => 'Menambah data Kelurahan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 450,
        'height' => 440,
        'resizable' => false,
    ),
));

echo '<div class="divForFormKelurahan"></div>';


$this->endWidget();
//========= end kelurahan dialog =============================
?>
<script type="text/javascript">
    // here is the magic
    $('#isPasienLama').click(function() {
        if ($(this).is(':checked')) {
            $('#PPPasienM_no_rekam_medik').removeAttr('disabled');
        } else {
            $('#PPPasienM_no_rekam_medik').attr('disabled', 'true');
            $('#PPPasienM_no_rekam_medik').val('');
        }
    });

    function cek_data() {
        var norm = "norm=" + $('#PPPasienM_no_rekam_medik').val();
        var rm = $('#PPPasienM_no_rekam_medik').val();
        if (rm == '' || rm == null) {} else {

            <?php
            echo CHtml::ajax(array(
                'url' => Yii::app()->createUrl('ActionAjax/GetPasienLama'),
                'data' => "js:norm",
                'type' => 'post',
                'dataType' => 'json',
                'success' => "function(data)
                {
                    if(data!=null){
                        $('#PPPasienM_jenisidentitas').val(data.jenisidentitas);
                        $('#PPPasienM_no_identitas_pasien').val(data.no_identitas_pasien); 
                        $('#PPPasienM_namadepan').val(data.namadepan); 
                        $('#PPPasienM_nama_pasien').val(data.nama_pasien); 
                        $('#PPPasienM_nama_bin').val(data.nama_bin); 
                        $('#PPPasienM_tempat_lahir').val(data.tempat_lahir); 
                        $('#PPPasienM_tanggal_lahir').val(data.tanggal_lahir);
                        UmurP(data.tanggal_lahir);
                        if(data.jeniskelamin=='PEREMPUAN'){
                            $('#PPPasienM_jeniskelamin_1').attr('checked', true);
                        }else if(data.jeniskelamin=='LAKI-LAKI'){
                            $('#PPPasienM_jeniskelamin_0').attr('checked', true);
                        }

                        if(data.rhesus=='RH+'){
                            $('#PPPasienM_rhesus_0').attr('checked', true);
                        }else if(data.rhesus=='RH-'){
                            $('#PPPasienM_rhesus_1').attr('checked', true);
                        }
                        
                        $('#PPPasienM_statusperkawinan').val(data.statusperkawinan);
                        $('#PPPasienM_golongandarah').val(data.golongandarah);
                        $('#PPPasienM_alamat_pasien').val(data.alamat_pasien);
                        $('#PPPasienM_rt').val(data.rt);
                        $('#PPPasienM_rw').val(data.rw);

                    }else{
                        myAlert('Maaf No. Rekamedik anda tidak terdaftar, silakan ulangi kembali');
                        $('#PPPasienM_no_rekam_medik').val('');
                        $('#PPPasienM_no_rekam_medik').focus();
                        clear();
                    }
                    
                    //myAlert(data.jenisidentitas);
                }",
            ));
            ?>
        }
        return false;
    }

    function clear() {
        $('#PPPasienM_jenisidentitas').val('');
        $('#PPPasienM_no_identitas_pasien').val('');
        $('#PPPasienM_namadepan').val('');
        $('#PPPasienM_nama_pasien').val('');
        $('#PPPasienM_nama_bin').val('');
        $('#PPPasienM_tempat_lahir').val('');
        $('#PPPasienM_tanggal_lahir').val('');
        $('#PPPasienM_statusperkawinan').val('');
        $('#PPPasienM_golongandarah').val('');
        $('#PPPasienM_alamat_pasien').val('');
        $('#PPPasienM_rt').val('');
        $('#PPPasienM_rw').val('');
    }

    function getUmurP(obj) {
        //myAlert(obj);
        $.post("<?php echo $this->createUrl('GetUmur'); ?>", {
                tglLahir: obj.value
            },
            function(data) {
                $('#PPPasienM_umur').val(data.umur);
            }, "json");
        //return false;
    }

    function UmurP(obj) {
        $.post("<?php echo $this->createUrl('GetUmur'); ?>", {
                tglLahir: obj
            },
            function(data) {
                $('#PPPasienM_umur').val(data.umur);
            }, "json");
        //return false;
    }

    function addPropinsi() {
        <?php echo CHtml::ajax(array(
            'url' => Yii::app()->createUrl('ActionAjax/addPropinsi'),
            'data' => "js:$(this).serialize()",
            'type' => 'post',
            'dataType' => 'json',
            'success' => "function(data)
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
 
            }",
        )) ?>;
        return false;
    }

    function addKabupaten() {
        <?php echo CHtml::ajax(array(
            'url' => $this->createUrl('addKabupaten'),
            'data' => "js:$(this).serialize()",
            'type' => 'post',
            'dataType' => 'json',
            'success' => "function(data)
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
        )) ?>;
        return false;
    }

    function addKecamatan() {
        <?php echo CHtml::ajax(array(
            'url' => $this->createUrl('addKecamatan'),
            'data' => "js:$(this).serialize()",
            'type' => 'post',
            'dataType' => 'json',
            'success' => "function(data)
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
        )) ?>;
        return false;
    }

    function addKelurahan() {
        <?php echo CHtml::ajax(array(
            'url' => $this->createUrl('addKelurahan'),
            'data' => "js:$(this).serialize()",
            'type' => 'post',
            'dataType' => 'json',
            'success' => "function(data)
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
        )) ?>;
        return false;
    }
</script>
<?php
$urlGetTglLahir = $this->createUrl('GetTglLahir');
$urlGetUmur = $this->createUrl('GetUmur');
$urlGetDaerah = Yii::app()->createUrl('ActionAjax/getListDaerahPasien');
$urlGetHari = $this->createUrl('GetHari');
$urlListDokterRuangan = $this->createUrl('listDokterRuangan');
$idTagUmur = CHtml::activeId($modPasien, 'umur');
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
    
function hariBaru()
    {
        var tanggal = $('#PPBuatJanjiPoliT_tgljadwal').val();
            $.post("${urlGetHari}",{tanggal: tanggal},
            function(data){

               $('#PPBuatJanjiPoliT_harijadwal').val(data.hari); 

       },"json");
       
    
    }

function listDokterRuangan(idRuangan)
{
    $.post("${urlListDokterRuangan}", { idRuangan: idRuangan },
        function(data){
            $('#PPBuatJanjiPoliT_pegawai_id').html(data.listDokter);
    }, "json");
}

function loadUmur(tglLahir)
{

    $.post("${urlGetUmur}",{tglLahir: tglLahir},
        function(data){
           $("#${idTagUmur}").val(data.umur);
    },"json");
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
JS;
Yii::app()->clientScript->registerScript('formPasien', $js, CClientScript::POS_HEAD);

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
Yii::app()->clientScript->registerScript('numberOnly', $js, CClientScript::POS_READY);



?>
