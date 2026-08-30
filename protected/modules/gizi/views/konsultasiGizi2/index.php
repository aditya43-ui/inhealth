<?php
    $this->breadcrumbs=array(
            'Tindakan',
    );
?>

<?php 
    if(empty($pasienadmisi_id))
        $this->renderPartial('/_ringkasDataPasienPendaftaran',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien));
    else
        $this->renderPartial('/_ringkasDataPasienPendaftaranRI',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien));
?>
<?php $this->renderPartial('/_tabulasi', array('modPendaftaran'=>$modPendaftaran)); ?>

<?php
$this->widget('application.extensions.moneymask.MMask',array(
    'element'=>'.currency',
    'currency'=>'PHP',
    'config'=>array(
        'symbol'=>'Rp ',
//        'showSymbol'=>true,
//        'symbolStay'=>true,
        'defaultZero'=>true,
        'allowZero'=>true,
        'decimal'=>',',
        'thousands'=>'.',
        'precision'=>0,
    )
));

$this->widget('application.extensions.moneymask.MMask',array(
    'element'=>'.number',
    'config'=>array(
        'defaultZero'=>true,
        'allowZero'=>true,
        'decimal'=>',',
        'thousands'=>'.',
        'precision'=>0,
    )
));
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'konsultasi-gizi-t-form',
    'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)',
                             'onsubmit'=>'return cekInput();'),
)); ?>

    
    <?php
        if(!empty($modViewTindakans)) {
            $this->renderPartial($this->path_view.'_listTindakanPasien',array('modTindakans'=>$modViewTindakans,
                                                             'modViewBmhp'=>$modViewBmhp,
                                                             'removeButton'=>true));
        }
    ?>
<div class="formInputTab">
    <p class="help-block">
        <?php echo CHtml::hiddenField('url',$this->createUrl('',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id)),array('readonly'=>TRUE));?>
        <?php echo CHtml::hiddenField('berubah','',array('readonly'=>TRUE));?>
        <?php //echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
    <div class="controls">
        <div class="control-group">
            <?php echo $form->dropDownList($modTindakan,'[0]tipepaket_id',Chtml::listData($modTindakan->getTipePaketItems($modPendaftaran->carabayar_id), 'tipepaket_id', 'tipepaket_nama'),
                            array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",
                                  'onchange'=>'loadTindakanPaket(this.value,"'.$modPendaftaran->kelaspelayanan_id.'","'.$modPendaftaran->kelompokumur_id.'")')); ?>
        </div>
    </div>
    
        
    <table class="items table table-striped table-bordered table-condensed" id="tblInputTindakan">
        <thead>
            <tr>
                <th>Kategori Tindakan</th>
                <th rowspan="2">Uraian Tindakan</th>
<!--<th rowspan="2">Tarif Satuan</th>-->
                <th rowspan="2">Jumlah</th>
                <!--<th rowspan="2">Tarif Satuan</th>-->
                <!--<th rowspan="2">Jumlah Tindakan</th>-->
                <th rowspan="2">Satuan<br>Tindakan</th>
                <th rowspan="2">Cyto </th>
                <th rowspan="2">Tarif Cyto</th>
<!--<th rowspan="2">Jml Tarif</th>-->
                <th rowspan="2">&nbsp;</th>
            </tr>
            <tr>
                <th>Tgl. Tindakan</th>
            </tr>
        </thead>
        <?php 
            $trTindakan = $this->renderPartial($this->path_view.'_rowTindakanPasien',array('modTindakan'=>$modTindakan,'modTindakans'=>$modTindakans),true); 
            echo $trTindakan;
        ?>
    </table>
    <?php echo $form->errorSummary($modTindakan); ?>
    
    <table>
        <tr>
            <td>
                <?php $this->renderPartial($this->path_view.'_formPemakaianBahan',array()); ?>
            </td>
            <td>
                <?php $this->renderPartial($this->path_view.'_formPaketBmhp',array('modViewBmhp'=>$modViewBmhp, 'modTindakan'=>$modTindakan)); ?>
            </td>
        </tr>
    </table>
    
    <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                    array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan')); ?>
									      <?php 
           $content = $this->renderPartial('gizi.views.tips.tips',array(),true);
			$this->widget('UserTips',array('type'=>'admin','content'=>$content));
        ?>
			
            <?php //echo CHtml::link('Test Update Stok', '#', array('onclick'=>'testUpdateStok(80,4);return false;','class'=>'btn')); ?>
    </div>
    
</div>

<?php $this->endWidget(); ?>

<?php $this->renderPartial($this->path_view.'_dialogPemeriksa',array('modTindakan'=>$modTindakan)); ?> 

<script type="text/javascript">
 
// the subviews rendered with placeholders
var trTindakan=new String(<?php echo CJSON::encode($this->renderPartial($this->path_view.'_rowTindakanPasien',array('modTindakan'=>$modTindakan,'removeButton'=>true),true));?>);
var trTindakanFirst=new String(<?php echo CJSON::encode($this->renderPartial($this->path_view.'_rowTindakanPasien',array('modTindakan'=>$modTindakan,'removeButton'=>false),true));?>);
 
function addRowTindakan(obj)
{
    $(obj).parents('table').children('tbody').append(trTindakan.replace());
    <?php 
        $attributes = $modTindakan->attributeNames(); 
        foreach($attributes as $i=>$attribute){
            echo "renameInput('GZTindakanpelayananT','$attribute');";
        }
    ?>
    renameInput('GZTindakanpelayananT','daftartindakanNama');
    renameInput('GZTindakanpelayananT','kategoriTindakanNama');
    renameInput('GZTindakanpelayananT','persenCyto');
    renameInput('GZTindakanpelayananT','jumlahTarif');
    jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT;?>"});
    jQuery('input[name$="[daftartindakanNama]"]').autocomplete({'showAnim':'fold','minLength':2,'focus':function( event, ui ) {
                                                                                    $(this).val( ui.item.label);
                                                                                    return false;
                                                                                },'select':function( event, ui ) {
                                                                                    setTindakan(this, ui.item);
                                                                                    return false;
                                                                                },'source':function(request, response) {
                                                                                                $.ajax({
                                                                                                    url: "<?php echo Yii::app()->createUrl('ActionAutoComplete/DaftarTindakan');?>",
                                                                                                    dataType: "json",
                                                                                                    data: {
                                                                                                        term: request.term,
                                                                                                        tipepaket_id: $("#GZTindakanpelayananT_0_tipepaket_id").val(),
                                                                                                        kelaspelayanan_id: $("#GZPendaftaranT_kelaspelayanan_id").val(),
                                                                                                    },
                                                                                                    success: function (data) {
                                                                                                        response(data);
                                                                                                    }
                                                                                                })
                                                                                            }
                                                                                });
jQuery('#tblInputTindakan tr:last .tanggal').datetimepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['id'], {'dateFormat':'dd M yy','maxDate':'d','timeText':'Waktu','hourText':'Jam','minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold','yearRange':'-80y:+20y'}));
}
 
function batalTindakan(obj)
{
    myConfirm('Apakah Anda yakin akan membatalkan tindakan?','Perhatian!',
    function(r){
        if(r){
            $(obj).parents('tr').next('tr').detach();
            $(obj).parents('tr').detach();
            
            <?php 
                foreach($attributes as $i=>$attribute){
                    echo "renameInput('GZTindakanpelayananT','$attribute');";
                }
            ?>
            renameInput('GZTindakanpelayananT','daftartindakanNama');
            renameInput('GZTindakanpelayananT','kategoriTindakanNama');
            renameInput('GZTindakanpelayananT','persenCyto');
            renameInput('GZTindakanpelayananT','jumlahTarif');
        }
    }); 
}
 
function deleteTindakan(obj,idTindakanpelayanan)
{
    myConfirm('Apakah Anda yakin akan menghapus tindakan?','Perhatian!',
    function(r){
        if(r){
            $.post('<?php echo $this->createUrl('ajaxDeleteTindakanPelayanan') ?>', {idTindakanpelayanan: idTindakanpelayanan}, function(data){
                if(data.success){
                    $(obj).parent().parent().detach();
                } else {
                    myAlert('Data Gagal dihapus');
                }
            }, 'json');
        }
    }); 
}

function renameListTindakan(modelName,attributeName)
{
    var trLength = $('#tblInputTindakan tr').length;
    var i = -1;
    $('#tblInputTindakan tr').each(function(){
        if($(this).has('input[name$="[tarif_satuan]"]').length){
            i++;
        }
        $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('input[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
        $(this).find('select[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('select[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
        $(this).find('input[name^="daftartindakanNama["]').attr('name','daftartindakanNama['+i+']');
        $(this).find('input[name^="daftartindakanNama["]').attr('id','daftartindakanNama_'+i+'');
        $(this).find('a[id^="btnAddDokter_"]').attr('id','btnAddDokter_'+i+'');
    });
}

function renameInput(modelName,attributeName)
{
    var trLength = $('#tblInputTindakan tr').length;
    var i = -1;
    $('#tblInputTindakan tr').each(function(){
        if($(this).has('input[name$="[daftartindakan_id]"]').length){
            i++;
        }
        $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('input[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
        $(this).find('select[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('select[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
        $(this).find('input[name^="daftartindakanNama["]').attr('name','daftartindakanNama['+i+']');
        $(this).find('input[name^="daftartindakanNama["]').attr('id','daftartindakanNama_'+i+'');
        $(this).find('a[id^="btnAddDokter_"]').attr('id','btnAddDokter_'+i+'');
    });
}
 
function addDokter(obj)
{
    $('#dialogPemeriksa').dialog('open');
    $('#dialogPemeriksa #rowTindakan').val($(obj).attr('id'));
}

function setParamedis()
{
    var idBtnAddDokter = $('#dialogPemeriksa #rowTindakan').val();
    $('#'+idBtnAddDokter).parents('td').find('input[name$="[dokterpemeriksa1_id]"]').val($('#dialogPemeriksa #dokterpemeriksa1').val());
    $('#'+idBtnAddDokter).parents('td').find('input[name$="[dokterpemeriksa2_id]"]').val($('#dialogPemeriksa #dokterpemeriksa2').val());
    $('#'+idBtnAddDokter).parents('td').find('input[name$="[dokterpendamping_id]"]').val($('#dialogPemeriksa #dokterpendamping').val());
    $('#'+idBtnAddDokter).parents('td').find('input[name$="[dokteranastesi_id]"]').val($('#dialogPemeriksa #dokterpemeriksa1').val());
    $('#'+idBtnAddDokter).parents('td').find('input[name$="[dokterdelegasi_id]"]').val($('#dialogPemeriksa #dokterdelegasi').val());
    $('#'+idBtnAddDokter).parents('td').find('input[name$="[bidan_id]"]').val($('#dialogPemeriksa #bidan').val());
    $('#'+idBtnAddDokter).parents('td').find('input[name$="[suster_id]"]').val($('#dialogPemeriksa #suster').val());
    $('#'+idBtnAddDokter).parents('td').find('input[name$="[perawat_id]"]').val($('#dialogPemeriksa #perawat').val());
}

function setDokterPemeriksa1(item)
{
    var idBtnAddDokter = $('#dialogPemeriksa #rowTindakan').val();
    $('#'+idBtnAddDokter).parents('td').find('input[name$="[dokterpemeriksa1_id]"]').val(item.pegawai_id);
    var gelardepan = "";
    var gelarbelakang_nama = "";
    if(item.gelardepan != null)
        gelardepan = item.gelardepan
    if(item.gelarbelakang_nama != null)
        gelarbelakang_nama = item.gelarbelakang_nama
    $('#'+idBtnAddDokter).parents('td').find('span[name$="[namadokter]"]').html(gelardepan+" "+item.nama_pegawai+" "+gelarbelakang_nama);
    
}

function setDokterPemeriksa2(item)
{
    var idBtnAddDokter = $('#dialogPemeriksa #rowTindakan').val();
    $('#'+idBtnAddDokter).parents('td').find('input[name$="[dokterpemeriksa2_id]"]').val(item.pegawai_id);
}

function setDokterPendamping(item)
{
    var idBtnAddDokter = $('#dialogPemeriksa #rowTindakan').val();
    $('#'+idBtnAddDokter).parents('td').find('input[name$="[dokterpendamping_id]"]').val(item.pegawai_id);
}

function setDokterAnastesi(item)
{
    var idBtnAddDokter = $('#dialogPemeriksa #rowTindakan').val();
    $('#'+idBtnAddDokter).parents('td').find('input[name$="[dokteranastesi_id]"]').val(item.pegawai_id);
}

function setDokterDelegasi(item)
{
    var idBtnAddDokter = $('#dialogPemeriksa #rowTindakan').val();
    $('#'+idBtnAddDokter).parents('td').find('input[name$="[dokterdelegasi_id]"]').val(item.pegawai_id);
}

function setBidan(item)
{
    var idBtnAddDokter = $('#dialogPemeriksa #rowTindakan').val();
    $('#'+idBtnAddDokter).parents('td').find('input[name$="[bidan_id]"]').val(item.pegawai_id);
}

function setSuster(item)
{
    var idBtnAddDokter = $('#dialogPemeriksa #rowTindakan').val();
    $('#'+idBtnAddDokter).parents('td').find('input[name$="[suster_id]"]').val(item.pegawai_id);
}

function setPerawat(item)
{
    var idBtnAddDokter = $('#dialogPemeriksa #rowTindakan').val();
    $('#'+idBtnAddDokter).parents('td').find('input[name$="[perawat_id]"]').val(item.pegawai_id);
} 

function setTindakan(obj,item)
{
    var hargaTindakan = unformatNumber(item.harga_tariftindakan);
    var subsidiAsuransi = unformatNumber(item.subsidiasuransi);
    var subsidiPemerintah = unformatNumber(item.subsidipemerintah);
    var subsidiRumahsakit = unformatNumber(item.subsidirumahsakit);
    if(isNaN(subsidiAsuransi))subsidiAsuransi=0;
    if(isNaN(subsidiPemerintah))subsidiPemerintah=0;
    if(isNaN(subsidiRumahsakit))subsidiRumahsakit=0;
    $(obj).parents('tr').find('input[name$="[kategoriTindakanNama]"]').val(item.kategoritindakan_nama);
    $(obj).parents('tr').find('input[name$="[daftartindakan_id]"]').val(item.daftartindakan_id);
    $(obj).parents('tr').find('input[name$="[tarif_satuan]"]').val(formatNumber(item.harga_tariftindakan));
    $(obj).parents('tr').find('input[name$="[qty_tindakan]"]').val('1');
    $(obj).parents('tr').find('input[name$="[persenCyto]"]').val(formatNumber(item.persencyto_tind));
    $(obj).parents('tr').find('input[name$="[jumlahTarif]"]').val(formatNumber(item.harga_tariftindakan));
    $(obj).parents('tr').find('input[name$="[subsidiasuransi_tindakan]"]').val(formatNumber(item.subsidiasuransi));
    $(obj).parents('tr').find('input[name$="[subsidipemerintah_tindakan]"]').val(formatNumber(item.subsidipemerintah));
    $(obj).parents('tr').find('input[name$="[subsisidirumahsakit_tindakan]"]').val(formatNumber(item.subsidirumahsakit));
    $(obj).parents('tr').find('input[name$="[iurbiaya_tindakan]"]').val(formatNumber(hargaTindakan - (subsidiAsuransi + subsidiPemerintah +subsidiRumahsakit)));
    //$(obj).parents('tr').find('input[name$="[iurbiaya_tindakan]"]').val(item.iurbiaya);
    tambahTindakanPemakaianBahan(item.daftartindakan_id,item.label);
    
    var tombolAddDokter = $(obj).parents('tr').next().find('a');
    addDokter(tombolAddDokter);
}

function tambahTindakanPemakaianBahan(value,label)
{
    $('#daftartindakanPemakaianBahan').append('<option value="'+value+'">'+label+'</option>');
}

function loadTindakanPaket(idTipePaket,idKelasPelayanan,idKelompokUmur)
{
    //myAlert(idTipePaket);
    //var idNonPaket = <?php //echo Params::TIPEPAKET_ID_NONPAKET; ?>; 
    
    var idCarabayar = $('#GZPendaftaranT_carabayar_id').val();
    
    $.post('<?php echo $this->createUrl('loadFormTindakanPaket') ?>', {idTipePaket: idTipePaket, idKelasPelayanan:idKelasPelayanan, idKelompokUmur:idKelompokUmur, idCarabayar:idCarabayar}, function(data){
        if(data.form == '')
            $('#tblInputTindakan > tbody').html(trTindakanFirst.replace());
        else
            $('#tblInputTindakan > tbody').html(data.form); 
        
        $("#tblInputTindakan > tbody .currency").maskMoney({"symbol":"Rp ","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0});
        $('.currency').each(function(){this.value = formatNumber(this.value)});
        $("#tblInputTindakan > tbody .number").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0,"symbol":null});
        $('.number').each(function(){this.value = formatNumber(this.value)});
        
        $('#tblInputPaketBhp > tbody').html(data.formPaketBmhp);
        $('#totHargaBmhp').val(formatNumber(data.totHargaBmhp));
        $('#tblInputPemakaianBahan > tbody').html('');
        $('#daftartindakanPemakaianBahan').html(data.optionDaftarttindakan);
        
    jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT;?>"});
    jQuery('input[name$="[daftartindakanNama]"]').autocomplete({'showAnim':'fold','minLength':2,'focus':function( event, ui ) {
                                                                                    $(this).val( ui.item.label);
                                                                                    return false;
                                                                                },'select':function( event, ui ) {
                                                                                    setTindakan(this, ui.item);
                                                                                    return false;
                                                                                },'source':function(request, response) {
                                                                                                $.ajax({
                                                                                                    url: "<?php echo Yii::app()->createUrl('ActionAutoComplete/DaftarTindakan');?>",
                                                                                                    dataType: "json",
                                                                                                    data: {
                                                                                                        term: request.term,
                                                                                                        idTipePaket: $("#GZTindakanpelayananT_0_tipepaket_id").val(),
                                                                                                        idKelasPelayanan: $("#GZPendaftaranT_kelaspelayanan_id").val(),
                                                                                                    },
                                                                                                    success: function (data) {
                                                                                                        response(data);
                                                                                                    }
                                                                                                })
                                                                                            }
                                                                                }); 
          jQuery('#tblInputTindakan .tanggal').datetimepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['id'], {'dateFormat':'dd M yy','maxDate':'d','timeText':'Waktu','hourText':'Jam','minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold','yearRange':'-80y:+20y'}));
    }, 'json');
    
}

function hitungCyto(obj)
{
    var tarifSatuan = unformatNumber($(obj).parents("#tblInputTindakan tr").find('input[name$="[tarif_satuan]"]').val());
    var qty = unformatNumber($(obj).parents("#tblInputTindakan tr").find('input[name$="[qty_tindakan]"]').val());
    var persenCyto = unformatNumber($(obj).parents("#tblInputTindakan tr").find('input[name$="[persenCyto]"]').val());
    var cyto = unformatNumber($(obj).parents("#tblInputTindakan tr").find('select[name$="[cyto_tindakan]"]').val());
    if(cyto == '0')
        persenCyto = 0;
    var tarifCyto = qty * tarifSatuan * persenCyto / 100;
    var subTotal = tarifSatuan * qty + tarifCyto;
    $(obj).parents("#tblInputTindakan tr").find('input[name$="[tarifcyto_tindakan]"]').val(formatNumber(tarifCyto));
    $(obj).parents("#tblInputTindakan tr").find('input[name$="[jumlahTarif]"]').val(formatNumber(subTotal));
    hitungTotal(); 
}

function hitungSubtotal(obj)
{
    var tarifSatuan = unformatNumber($(obj).parents("#tblInputTindakan tr").find('input[name$="[tarif_satuan]"]').val());
    var qty = unformatNumber($(obj).parents("#tblInputTindakan tr").find('input[name$="[qty_tindakan]"]').val());
    var persenCyto = unformatNumber($(obj).parents("#tblInputTindakan tr").find('input[name$="[persenCyto]"]').val());
    var cyto = unformatNumber($(obj).parents("#tblInputTindakan tr").find('select[name$="[cyto_tindakan]"]').val());
    if(cyto == '0')
        persenCyto = 0;
    var tarifCyto = qty * tarifSatuan * persenCyto / 100;
    var subTotal = tarifSatuan * qty + tarifCyto;
    $(obj).parents("#tblInputTindakan tr").find('input[name$="[tarifcyto_tindakan]"]').val(formatNumber(tarifCyto));
    $(obj).parents("#tblInputTindakan tr").find('input[name$="[jumlahTarif]"]').val(formatNumber(subTotal));
    hitungTotal(); 
    $('.currency').each(function(){this.value = formatNumber(this.value)});
    $('.number').each(function(){this.value = formatNumber(this.value)});
}

function testUpdateStok(qty,idObatAlkes)
{
    $.post('<?php echo $this->createUrl('updateStok') ?>', {qty:qty, idObatAlkes:idObatAlkes}, function(data){
            myAlert(data.input);
        }, 'json');
}

function cekInput()
{
    $('.currency').each(function(){this.value = unformatNumber(this.value)});
    $('.number').each(function(){this.value = unformatNumber(this.value)});
    return true;
}
function setDialog(obj){
    $("#giladiagnosa-m-grid").find("tr").removeClass("yellow_background");
    idTipePaket = $("#<?php echo CHtml::activeId($modTindakan,'[0]tipepaket_id'); ?>").val();
    idKelasPelayanan = $("#<?php echo CHtml::activeId($modPendaftaran,'kelaspelayanan_id'); ?>").val();
    $.get('<?php echo Yii::app()->createUrl($this->route, array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id));?>',{test:'aing',idTipePaket: idTipePaket, idKelasPelayanan:idKelasPelayanan},function(data){
        $("#tableDaftarTindakanPaket").html(data);
    });
    parent = $(obj).parents(".input-append").find("input").attr("id");
    dialog = "#dialogDaftarTindakanPaket";
    $(dialog).attr("parent-dialog",parent);
    $(dialog).dialog("open");
}
function setTindakanAuto(idKelasPelayanan, idDaftarTindakan){
    idTipePaket = $("#<?php echo CHtml::activeId($modTindakan,'[0]tipepaket_id'); ?>").val();
    dialog = "#dialogDaftarTindakanPaket";
    parent = $(dialog).attr("parent-dialog");
    obj = $("#"+parent);
    $.get('<?php echo Yii::app()->createUrl('ActionAutoComplete/daftarTindakan'); ?>',{tipepaket_id: idTipePaket, kelaspelayanan_id:idKelasPelayanan, daftartindakan_id:idDaftarTindakan},function(data){
        $(obj).val(data[0].daftartindakan_nama);
        setTindakan(obj,data[0]);
    },"json");
    $(dialog).dialog("close");
    
}
</script>

<?php 
//========= Dialog buat daftar tindakan  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogDaftarTindakan',
    'options'=>array(
        'title'=>'Daftar Tindakan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
        'height'=>400,
        'resizable'=>false,
    ),
));
    //echo $modPendaftaran->kelaspelayanan_id;
    $this->renderPartial($this->path_view.'_daftarTindakan');

$this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end daftar tindakan =============================
?> 
<?php 
//========= Dialog buat daftar tindakan  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogDaftarTindakanPaket',
    'options'=>array(
        'title'=>'Daftar Tindakan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
        'height'=>500,
        'resizable'=>false,
    ),
));

echo '<div id="tableDaftarTindakanPaket"></div>';
    //echo $modPendaftaran->kelaspelayanan_id;
    //$this->renderPartial($this->path_view.'_daftarTindakanPaket');

$this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end daftar tindakan =============================
?> 
<?php 
$js = <<< JS
//==================================================Validasi===============================================
//*Jangan Lupa untuk menambahkan hiddenField dengan id "berubah" di setiap form
//* hidden field dengan id "url"
//*Copas Saja hiddenfield di Line 36 dan 35
//* ubah juga id button simpannya jadi "btn_simpan"

function palidasiForm(obj)
{
    var berubah = $('#berubah').val();
    if(berubah=='Ya'){
        myConfirm('Apakah Anda Akan menyimpan Perubahan Yang Sudah Dilakukan?','Perhatian!',
        function(r){
            if(r){
                $('#url').val(obj);
                $('#btn_simpan').click();
            }
        }); 
    }      
}

JS;
Yii::app()->clientScript->registerScript('js',$js,CClientScript::POS_READY);
?>   
<div style='display:none;'>
<?php
    $this->widget('MyDateTimePicker', array(
        'name'=>'testingkktest',
        'mode' => 'datetime',
        'options' => array(
            'dateFormat' => Params::DATE_FORMAT,
            'maxDate' => 'd',
        ),
        'htmlOptions' => array('readonly' => true,
            'onkeypress' => "return $(this).focusNextInputField(event)", 'id'=>'GZTindakanpelayananT_0_tgl_tindakan'),
    ));
?>
</div>