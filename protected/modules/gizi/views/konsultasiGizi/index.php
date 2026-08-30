<?php
$this->breadcrumbs=array(
	'',
);
$this->widget('bootstrap.widgets.BootAlert');
?>
<?php  
$sukses = null;
if(isset($_GET['sukses'])){
    $sukses = $_GET['sukses'];
}
if($sukses > 0) 
    Yii::app()->user->setFlash('success',"Konsultasi Pasien Gizi berhasil disimpan!");

?>
<?php 
//    if(empty($pasienadmisi_id))
//        $this->renderPartial('/_ringkasDataPasienPendaftaran',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien));
//    else
//        $this->renderPartial('/_ringkasDataPasienPendaftaranRI',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien));
?>
<?php //$this->renderPartial('/_tabulasi', array('modPendaftaran'=>$modPendaftaran)); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'gztindakan-pelayanan-t-form',
    'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#GZTindakanPelayananT_0_daftartindakanNama',
        'htmlOptions'=>array(
            'onKeyPress'=>'return disableKeyPress(event)',
            'onSubmit'=>'return cekInput();'
        ),
)); ?>

    
    
<div class="formInputTab">
    <?php
        if(!empty($modViewTindakans)) {
            $this->renderPartial($this->path_view.'_listTindakanPasien',array('modTindakans'=>$modViewTindakans, 'modPendaftaran'=>$modPendaftaran,
                                                             'modViewBmhp'=>$modViewBmhp,
                                                             'removeButton'=>true));
        }
    ?>
    <p class="help-block">
        <?php echo CHtml::hiddenField('url',$this->createUrl('',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id)),array('readonly'=>TRUE));?>
        <?php echo CHtml::hiddenField('berubah','',array('readonly'=>TRUE));?>
        <?php //echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
    
    <?php
        echo $form->dropDownListRow(
            $modTindakan,'[0]tipepaket_id',
            Chtml::listData($modTindakan->getTipePaketItems($modPendaftaran->carabayar_id, $modPendaftaran->penjamin_id), 'tipepaket_id', 'tipepaket_nama'),
            array(
                'class'=>'span3',
                'onkeypress'=>"return $(this).focusNextInputField(event);",
//                'onchange'=>'loadTindakanPaket(this.value,"'.$modPendaftaran->kelaspelayanan_id.'","'.$modPendaftaran->kelompokumur_id.'")'
            )
        );
        
    ?>
    <?php
        // echo CHtml::hiddenField('tipepaket_id','',array());
        // echo CHtml::hiddenField('kelaspelayanan_id','',array());
    ?>
        <?php 
$kelaspelayanan_id = isset($modPendaftaran->kelaspelayanan_id) ? $modPendaftaran->kelaspelayanan_id : null;
$penjamin_id = isset($modPendaftaran->penjamin_id) ? $modPendaftaran->penjamin_id : null;
echo CHtml::hiddenField('GZPendaftaranT_kelaspelayanan_id',$kelaspelayanan_id,array('value'=>$modPendaftaran->kelaspelayanan_id)); 
echo CHtml::hiddenField('GZPendaftaranT_penjamin_id',$penjamin_id,array('value'=>$modPendaftaran->penjamin_id)); ?>
    <legend class="rim">Tabel Tindakan</legend>
    <table class="items table table-striped table-bordered table-condensed" id="tblInputTindakan">
        <thead>
            <tr>
                <th>Kategori Tindakan</th>
                <th rowspan="2">Uraian Tindakan</th>
               <th rowspan="2">Tarif Satuan</th> 
                <th rowspan="2">Jumlah</th>
                <!--<th rowspan="2">Tarif Satuan</th>-->
                <!--<th rowspan="2">Jumlah Tindakan</th>-->
                <th rowspan="2">Satuan<br>Tindakan</th>
                <th rowspan="2">Cyto </th>
                <th rowspan="2">Tarif Cyto</th>
     <th rowspan="2">Jumlah Tarif</th> 
                <th rowspan="2">&nbsp;</th>
            </tr>
            <tr>
                <th>Tanggal Tindakan</th>
            </tr>
        </thead>
        <?php 
            $trTindakan = $this->renderPartial($this->path_view.'_rowTindakanPasien',array('modTindakan'=>$modTindakan,'modTindakans'=>$modTindakans,'kelaspelayanan_id'=>$modPendaftaran->kelaspelayanan_id),true); 
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
                                    array('class' => 'btn btn-danger', 'type'=>'submit','id'=>'btn_simpan')); ?>
									      <?php 
           $content = $this->renderPartial('gizi.views.konsultasiGizi.tips.transaksi',array(),true);
			$this->widget('UserTips',array('type'=>'admin','content'=>$content));
        ?>
			
            <?php //echo CHtml::link('Test Update Stok', '#', array('onclick'=>'testUpdateStok(80,4);return false;','class'=>'btn')); ?>
    </div>
    
</div>

<?php $this->endWidget(); ?>

<?php $this->renderPartial($this->path_view.'_dialogPemeriksa',array('modTindakan'=>$modTindakan)); ?> 

<script type="text/javascript">
 
// the subviews rendered with placeholders
var trTindakan = new String(<?php echo CJSON::encode($this->renderPartial($this->path_view.'_rowTindakanPasien',array('modTindakan'=>$modTindakan,'removeButton'=>true),true));?>);
var trTindakanFirst = new String(<?php echo CJSON::encode($this->renderPartial($this->path_view.'_rowTindakanPasien',array('modTindakan'=>$modTindakan,'removeButton'=>false),true));?>);

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
    renameInput('GZTindakanpelayananT','tgl_tindakan');
    $('#tblInputTindakan tbody').each(function(){
        jQuery('input[name$="[tgl_tindakan]"]').datetimepicker(
            jQuery.extend(
                {
                    showMonthAfterYear:false
                }, 
                jQuery.datepicker.regional['id'],
                {
                    'dateFormat':'dd M yy',
                    'maxDate':'d',
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
        );
    });  
    
    jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT;?>"});
    jQuery('input[name$="[daftartindakanNama]"]').autocomplete(
        {
            'showAnim':'fold',
            'minLength':2,
            'focus':function(event, ui )
            {
                $(this).val( ui.item.label);
                return false;
            },
            'select':function( event, ui )
            {
                setTindakan(this, ui.item);
                return false;
            },
            'source':function(request, response)
            {
                $.ajax({
                    url: "<?php echo $this->createUrl('DaftarTindakan');?>",
                    dataType: "json",
                    data:{
                        term: request.term,
                        tipepaket_id: $("#GZTindakanPelayananT_0_tipepaket_id").val(),
                        kelaspelayanan_id: $("#GZPendaftaranT_kelaspelayanan_id").val(),
                    },
                    success: function (data) {
                        response(data);
                    }
                })
            }
        }
    );
    
      
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
            renameInput('GZTindakanpelayananT','tgl_tindakan');
        }
    }); 
}
 
function deleteTindakan(obj,idTindakanpelayanan)
{
    myConfirm('Apakah Anda yakin akan menghapus tindakan?','Perhatian!',
    function(r){
        if(r){
            $.post('<?php echo $this->createUrl('ajaxDeleteTindakanPelayanan') ?>', {idTindakanpelayanan: idTindakanpelayanan}, function(data){
                if(data.success)
                {
                    $(obj).parent().parent().detach();
                    myAlert('Data berhasil dihapus.');
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
        $(this).find('input[name^="tgl_tindakan["]').attr('name','tgl_tindakan['+i+']');
        $(this).find('input[name^="tgl_tindakan["]').attr('id','tgl_tindakan_'+i+'');
        $(this).find('a[id^="btnAddDokter_"]').attr('id','btnAddDokter_'+i+'');        
//        jQuery('input[name$="[daftartindakanNama]"]').datetimepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['id'], {'dateFormat':'dd M yy','maxDate':'d','timeText':'Waktu','hourText':'Jam','minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold','yearRange':'-80y:+20y'}));
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
    $('#'+idBtnAddDokter).parents('td').find('#tampilanDokterPemeriksa').html("Dokter Pemeriksa : "+item.nama_pegawai);
    // document.getElementById('tampilanDokterPemeriksa').innerHTML = "Dokter Pemeriksa : "+item.nama_pegawai;
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
    hargaTindakan = 0;
    subsidiAsuransi = 0;
    subsidiPemerintah = 0;
    subsidiRumahsakit = 0;
    
    var hargaTindakan = unformatNumber(item.harga_tariftindakan);
    var subsidiAsuransi = unformatNumber(item.subsidiasuransi);
    var subsidiPemerintah = unformatNumber(item.subsidipemerintah);
    var subsidiRumahsakit = unformatNumber(item.subsidirumahsakit);
   
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
    
    // var tombolAddDokter = $(obj).parents('tr').next().find('a');
    // addDokter(tombolAddDokter);
}

function tambahTindakanPemakaianBahan(value,label)
{
    $('#daftartindakanPemakaianBahan').append('<option value="'+value+'">'+label+'</option>');
}

function loadTindakanPaket(tipepaket_id,kelaspelayanan_id,kelompokumur_id)
{
//    myAlert(tipepaket_id);
    //var idNonPaket = <?php //echo Params::TIPEPAKET_ID_NONPAKET; ?>; 
//    var carabayar_id = $('#GZPendaftaranT_carabayar_id').val(); << ELEMENT TIDAK ADA DIDALAM IFRAME
    var carabayar_id = <?php echo $modPendaftaran->carabayar_id;?>
    
    /*    
    if(tipepaket_id == <?php echo Params::TIPEPAKET_ID_NONPAKET; ?>)
    {
        $('#tblInputTindakan > tbody').html(trTindakanNonPaket.replace());
    }else if(tipepaket_id == <?php echo Params::TIPEPAKET_ID_LUARPAKET; ?>)
    {
        $('#tblInputTindakan > tbody').html(trTindakanPaketLuar.replace());
    }else{
        
    }
    */
   
    $.post('<?php echo $this->createUrl(Yii::app()->controller->id.'/loadFormTindakanPaket') ?>',
        {
            tipepaket_id: tipepaket_id,
            kelaspelayanan_id:kelaspelayanan_id, 
            kelompokumur_id:kelompokumur_id, 
            carabayar_id:carabayar_id
        },
        function(data)
        {
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
            jQuery('input[name$="[daftartindakanNama]"]').autocomplete(
                {
                    'showAnim':'fold',
                    'minLength':2,
                    'focus':function( event, ui )
                    {
                        $(this).val( ui.item.label);
                        return false;
                    },
                    'select':function( event, ui )
                    {
                        setTindakan(this, ui.item);
                        return false;
                    },
                    'source':function(request, response)
                    {
                        $.ajax({
                            url: "<?php echo Yii::app()->createUrl('ActionAutoComplete/DaftarTindakan');?>",
                            dataType: "json",
                            data: {
                                term: request.term,
                                tipepaket_id: $("#GZTindakanPelayananT_0_tipepaket_id").val(),
                                kelaspelayanan_id: $("#GZPendaftaranT_kelaspelayanan_id").val(),
                            },
                            success: function (data) {
                                response(data);
                            }
                        })
                    }
                }
            ); 
            jQuery('input[name$="[tgl_tindakan]"]').datetimepicker(
                jQuery.extend(
                    {showMonthAfterYear:false},
                    jQuery.datepicker.regional['id'],
                    {
                        'dateFormat':'dd M yy',
                        'maxDate':'d',
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
            );
        },
        'json'
    );
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
//    $('.number').each(function(){this.value = formatNumber(this.value)});
}

function testUpdateStok(qty,obatalkes_id)
{
    $.post('<?php echo $this->createUrl('updateStok') ?>', {qty:qty, obatalkes_id:obatalkes_id}, function(data){
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
    $("#dialogpemeriksaan-m-grid").find("tr").removeClass("yellow_background");
    var tipepaket_id = $("#<?php echo CHtml::activeId($modTindakan,'[0]tipepaket_id'); ?>").val();
    var kelaspelayanan_id = <?php echo $modPendaftaran->kelaspelayanan_id; ?>;
    var penjamin_id = <?php echo $modPendaftaran->penjamin_id; ?>;
//    $.get('<?php echo Yii::app()->createUrl($this->route, array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id));?>',{'set_tindakan':1,tipepaket_id: tipepaket_id, kelaspelayanan_id:kelaspelayanan_id},function(data){
//        $("#tableDaftarTindakanPaket").html(data);
//    });
    $('#tipepaket_id').val(tipepaket_id);
    $('#kelaspelayanan_id').val(kelaspelayanan_id);
    $.fn.yiiGridView.update('giladiagnosa-m-grid2', {
        data: {
            "GZTarifTindakanPerdaRuanganV[kelaspelayanan_id]":kelaspelayanan_id,
            "GZTarifTindakanPerdaRuanganV[tipepaket_id]":tipepaket_id,
            "GZTarifTindakanPerdaRuanganV[penjamin_id]":penjamin_id,
        }
    });
    
    parent = $(obj).parents(".input-append").find("input").attr("id");
    dialog = "#dialogDaftarTindakanPaket";
    $(dialog).attr("parent-dialog",parent);
    $(dialog).dialog("open");
}
function setTindakanAuto(kelaspelayanan_id,daftartindakan_id){
    tipepaket_id = $("#<?php echo CHtml::activeId($modTindakan,'[0]tipepaket_id'); ?>").val();
    kelaspelayanan_id = <?php echo $modPendaftaran->kelaspelayanan_id; ?>;
    daftartindakan_id = daftartindakan_id;
    dialog = "#dialogDaftarTindakanPaket";
    /*
    if(idDlg != null)
    {
        dialog = idDlg;
    }
    */
    parent = $(dialog).attr("parent-dialog");
    obj = $("#"+parent);
    $.get('<?php echo Yii::app()->createUrl('ActionAutoComplete/daftarTindakan'); ?>',{tipepaket_id: tipepaket_id, kelaspelayanan_id:kelaspelayanan_id, daftartindakan_id:daftartindakan_id},function(data){
        $(obj).val(data[0].kategoritindakan_nama);
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
    $this->renderPartial($this->path_view.'_daftarTindakanPaket', array('modPendaftaran'=>$modPendaftaran));

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
            'onkeypress' => "return $(this).focusNextInputField(event)", 'id'=>'GZTindakanPelayananT_0_tgl_tindakan'),
    ));
?>
</div>

<?php
/* PAKET LUAR */
$this->beginWidget('zii.widgets.jui.CJuiDialog',
    array(
        'id'=>'dialogTindakanPaketLuar',
        'options'=>array(
            'title'=>'Daftar Tindakan',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>800,
            'height'=>500,
            'resizable'=>false,
        ),
    )
);

$tindakanPaketLuar = new PaketpelayananV;
if(Yii::app()->user->getState('tindakanruangan'))
    $tindakanPaketLuar->ruangan_id = Yii::app()->user->getState('ruangan_id');

if(Yii::app()->user->getState('tindakankelas'))
    //$tindakanPaketLuar->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
    $tindakanPaketLuar->kelaspelayanan_id = 2;

$tindakanPaketLuar->tipepaket_id = Params::TIPEPAKET_ID_LUARPAKET;

if (isset($_GET['PaketpelayananV']))
{
    $tindakanPaketLuar->attributes = $_GET['PaketpelayananV'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',
    array(
        'id'=>'tindakanLuarPaket',
        'dataProvider'=>$tindakanPaketLuar->search(),
        'filter'=>$tindakanPaketLuar,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'columns'=>array(
            array(
                'header'=>'Pilih',
                'type'=>'raw',
                'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small","id" => "selectObat","onClick" => "setTindakanAuto($data->kelaspelayanan_id,$data->daftartindakan_id);return false;"))',
            ),
            'kategoritindakan_nama',
            array(
                'header'=>'Uraian Tindakan',
                'name'=>'daftartindakan_nama',
            ),
        ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    )
);

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>



<?php
/* NON PAKET */
$this->beginWidget('zii.widgets.jui.CJuiDialog',
    array(
        'id'=>'dialogTindakanNonPaket',
        'options'=>array(
            'title'=>'Daftar Tindakan',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>800,
            'height'=>500,
            'resizable'=>false,
        ),
    )
);

if(Yii::app()->user->getState('tindakanruangan'))
{
    $tindakanPaketLuar = new TariftindakanperdaruanganV;
    $tindakanPaketLuar->ruangan_id = Yii::app()->user->getState('ruangan_id');
} else {
    $tindakanPaketLuar = new TariftindakanperdaV;
}

if(Yii::app()->user->getState('tindakankelas'))
    $tindakanPaketLuar->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;

if (isset($_GET['TariftindakanperdaruanganV']))
{
    $tindakanPaketLuar->attributes = $_GET['TariftindakanperdaruanganV'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',
    array(
        'id'=>'tindakanLuarPaket',
        'dataProvider'=>$tindakanPaketLuar->search(),
        'filter'=>$tindakanPaketLuar,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'columns'=>array(
            array(
                'header'=>'Pilih',
                'type'=>'raw',
                'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small","id" => "selectObat","onClick" => "setTindakanAuto($data->kelaspelayanan_id,$data->daftartindakan_id);return false;"))',
            ),
            'kategoritindakan_nama',
            array(
                'header'=>'Uraian Tindakan',
                'name'=>'daftartindakan_nama',
            ),
        ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    )
);

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>