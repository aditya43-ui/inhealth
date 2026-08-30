<script type="text/javascript">
var row_tindakan_first = new String(<?php echo CJSON::encode($this->renderPartial($this->path_view.'_rowTindakan',array('form'=>$form,'modTindakan'=>$modTindakan,'is_adatombolhapus'=>false),true));?>);
var row_tindakan = new String(<?php echo CJSON::encode($this->renderPartial($this->path_view.'_rowTindakan',array('form'=>$form,'modTindakan'=>$modTindakan,'is_adatombolhapus'=>true),true));?>);
function tambahTindakan(obj=null,first = false){
    var table = $('#table_tindakanpelayanan');
    if(first == true){
        $(table).children('tbody').append(row_tindakan_first.replace());
    }else{
        $(table).children('tbody').append(row_tindakan.replace());
    }
    
    renameInputRow($(table));
    //masking input
    $(table).find(".un-integer").maskMoney(
        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
    ).removeClass("un-integer").addClass("integer");
    
    //set input datetime
    var inputdatetime = $(table).find('tbody tr:last').find('.datetimemask');
    $(inputdatetime).datetimepicker(
        jQuery.extend(
            {
                showMonthAfterYear:false
            }, 
            jQuery.datepicker.regional['id'],
            {
                'dateFormat':'dd/mm/yy',
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
                'yearRange':'-80y:+20y',
                'showOn': 'button',
            }
        )
    );
    $(inputdatetime).parent().find('.add-on').on('click',function(){$(inputdatetime).datetimepicker('show');});
    $(inputdatetime).parent().find('button').hide();
    $(inputdatetime).mask("99/99/9999 99:99:99");
    //== end set input datetime
    //== set autocomplete daftartindakan
    $(table).find('input[name$="[daftartindakan_nama]"]').each(function(){
        $(this).autocomplete(
            {
                'showAnim':'fold',
                'minLength':3,
                'focus':function(event, ui )
                {
                    $(this).val("");
                    return false;
                },
                'select':function( event, ui )
                {
                    $(this).val(ui.item.value);
                    $(this).parents('tr').find('input[name$="[kategoritindakan_nama]"]').val(ui.item.kategoritindakan_nama);
                    $(this).parents('tr').find('input[name$="[daftartindakan_id]"]').val(ui.item.daftartindakan_id);
                    $(this).parents('tr').find('input[name$="[tarif_satuan]"]').val(ui.item.harga_tariftindakan);
                    $(this).parents('tr').find('input[name$="[jenistarif_id]"]').val(ui.item.jenistarif_id);
                    $(this).parents('tr').find('input[name$="[persencyto_tindakan]"]').val(ui.item.persencyto_tind);
                    formatNumberSemua();
                    hitungTarifTindakan();
                    tambahTindakanPemakaianBahan(ui.item.daftartindakan_id, ui.item.daftartindakan_nama);
                    return false;
                },
                'source':function(request, response)
                {
                    $.ajax({
                        url: "<?php echo $this->createUrl('AutocompleteDaftarTindakan');?>",
                        dataType: "json",
                        data:{
                            daftartindakan_nama: request.term,
                            tipepaket_id: $("#tipepaket_id").val(),
                            kelaspelayanan_id: $("#<?php echo CHtml::activeId($modPendaftaran,'kelaspelayanan_id') ;?>").val(),
                            penjamin_id: $("#<?php echo CHtml::activeId($modPendaftaran,'penjamin_id') ;?>").val(),
                        },
                        success: function (data) {
                            response(data);
                        }
                    })
                },
            }
        );
    });
    $(table).find('.autocomplete-dokter').autocomplete(
        {
            'showAnim':'fold',
            'minLength':3,
            'focus':function(event, ui )
            {
                $(this).val("");
                return false;
            },
            'select':function( event, ui )
            {
                $(this).val(ui.item.value);
                $(this).parent().next('input').val(ui.item.pegawai_id);
                return false;
            },
            'source':function(request, response)
            {
                $.ajax({
                    url: "<?php echo $this->createUrl('AutocompleteDokterPemeriksa');?>",
                    dataType: "json",
                    data:{
                        nama_pegawai: request.term,
                    },
                    success: function (data) {
                        response(data);
                    }
                })
            }
        }
    );
    //== end set autocomplete
    $(table).find('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
    window.scrollBy(0,2000);
}
/**
 * reset tabel tindakan
 */
function setTabelTindakanReset(){
    $('#table_tindakanpelayanan > tbody tr').detach();
    tambahTindakan(true);
}
/**
 * reset baris (tr)
 */
function setRowReset(obj){
    $(obj).parents('tr').find('input[name$="[kategoritindakan_nama]"]').val("");
    $(obj).parents('tr').find('input[name$="[daftartindakan_id]"]').val("");
    $(obj).parents('tr').find('input[name$="[daftartindakan_nama]"]').val("");
    $(obj).parents('tr').find('input[name$="[tarif_satuan]"]').val(0);
    $(obj).parents('tr').find('input[name$="[jenistarif_id]"]').val("");
    $(obj).parents('tr').find('input[name$="[tarifcyto_tindakan]"]').val(0);
    $(obj).parents('tr').find('input[name$="[subtotal]"]').val(0);
    
    $(obj).parents('tr').next('tr').find('input[name$="[dokterpemeriksa1_nama]"]').val("");
    $(obj).parents('tr').next('tr').find('input[name$="[dokterpemeriksa1_id]"]').val("");
    $(obj).parents('tr').next('tr').find('input[name$="[dokterpemeriksa2_nama]"]').val("");
    $(obj).parents('tr').next('tr').find('input[name$="[dokterpemeriksa2_id]"]').val("");
    $(obj).parents('tr').next('tr').find('input[name$="[keterangantindakan]"]').val("");
    
}
/**
 * menentukan tujuan baris dari button dialog 
 **/
function setDialogTindakan(obj){
    var tindakan_untuk = $(obj).parent().parent().find('input').attr('id');
    $("#tindakan_untuk").val(tindakan_untuk);
    var ruangan_id = $(obj).parents('tr').find('select[name$="[ruangan_id]"]').val();
    var ruangan_nama = $(obj).parents('tr').find('select[name$="[ruangan_id]"] option:selected').text();
//    var kelaspelayanan_id = '<?php // echo PARAMS::KELASPELAYANAN_ID_TANPA_KELAS; ?>';
//    var kelaspelayanan_id = $("#<?php // echo CHtml::activeId($modPendaftaran,'kelaspelayanan_id'); ?>").val();
    var kelaspelayanan_id = $("#kelaspelayanan_idNew").val();
    var tipepaket_id = $("#tipepaket_id").val();
    var penjamin_id = $("#<?php echo CHtml::activeId($modPendaftaran,'penjamin_id'); ?>").val();
    
    if(kelaspelayanan_id == ''){
        myAlert('Mohon pilih pasien dulu!');
        return false;
    }
    
    $("#dialog_tindakan > div").addClass("animation-loading");
    $("#ui-dialog-title-dialog_tindakan").html("Daftar Tindakan "+ruangan_nama);
    $("#dialog_tindakan").dialog("open");
    $.fn.yiiGridView.update('daftartindakan-grid', {
        data:{
            "PJTarifTindakanPerdaRuanganV[ruangan_id]":ruangan_id,
            "PJTarifTindakanPerdaRuanganV[tipepaket_id]":tipepaket_id,
            "PJTarifTindakanPerdaRuanganV[kelaspelayanan_id]":kelaspelayanan_id,
            "PJTarifTindakanPerdaRuanganV[penjamin_id]":penjamin_id,
        }
    });
}
/**
 * menentukan tujuan baris dari button dialog 
 **/
function setDialogObatAlkes(obj){
    var ruangan_id = '<?php echo Yii::app()->user->getState('ruangan_id'); ?>';
   
    $("#dialogObatAlkes > div").addClass("animation-loading");
    $("#dialogObatAlkes").dialog("open");
    $.fn.yiiGridView.update('obatalkes-m-grid', {
        data:{
            "PJInformasistokobatalkesV[ruangan_id]":ruangan_id,
        }
    });
}
/**
 * menentukan tujuan baris dari button dialog 
 **/
function setDialogDokter(obj,judul){
    var row = $(obj).parents('tr').prev('tr').find('input[name$="row"]').val();
    $("#untuk_row").val(row);
    var dokter_untuk = $(obj).parent().parent().find('input').attr('id');
    $("#dialog_dokter #dokter_untuk").val(dokter_untuk);
    var ruangan_id = $(obj).parents('tr').prev('tr').find('select[name$="[ruangan_id]"]').val();
    $("#ui-dialog-title-dialog_dokter").html(judul);
    $("#dialog_dokter > div").addClass("animation-loading");
    $("#dialog_dokter").dialog("open");
    $.fn.yiiGridView.update('dokter-grid', {
        data:{
            "PJ[ruangan_id]":ruangan_id,
        }
    });
}



function setDialogPPDS(obj,judul){
    var row = $(obj).parents('tr').prev('tr').find('input[name$="row"]').val();
    $("#untuk_row").val(row);
    var ppds_untuk = $(obj).parent().parent().find('input').attr('id');
    $("#dialog_ppds #ppds_untuk").val(ppds_untuk);
    var ruangan_id = $(obj).parents('tr').prev('tr').find('select[name$="[ruangan_id]"]').val();
    $("#ui-dialog-title-dialog_ppds").html(judul);
    $("#dialog_ppds > div").addClass("animation-loading");
    $("#dialog_ppds").dialog("open");
    $.fn.yiiGridView.update('ppds-grid', {
        data:{
            "PJ[ruangan_id]":ruangan_id,
        }
    });
}

function setDialogPerawat(obj,judul){
    
    var row = $(obj).parents('tr').prev('tr').find('input[name$="row"]').val();
    $("#untuk_row").val(row);
    var dokter_untuk = $(obj).parent().parent().find('input').attr('id');
    $("#dialog_perawat #perawat_untuk").val(dokter_untuk);
    var ruangan_id = $(obj).parents('tr').prev('tr').find('select[name$="[ruangan_id]"]').val();
    $("#ui-dialog-title-dialog_perawat").html(judul);
    $("#dialog_perawat > div").addClass("animation-loading");
    $("#dialog_perawat").dialog("open");
    
    $.fn.yiiGridView.update('perawat-grid', {
        data:{
            "PJ[ruangan_id]":ruangan_id,
        }
    });
}

function batalTindakan(obj){
    myConfirm("Apakah Anda akan membatalkan tindakan ini?",
    "Perhatian!",
    function(r){
        if(r){
            $(obj).parents('tr').next('tr').detach();
            $(obj).parents('tr').detach();
            renameInputRow($(obj).parents('table'));
        }
    }); 
}
/**
 * hapus tindakan dari database
 */
function hapusTindakan(obj){
    myConfirm('Apakah Anda akan menghapus tindakan dan pemakaian bahan ini?', 'Perhatian!', function(r)
    {
        if(r){
            var tindakanpelayanan_id = $(obj).parents('tr').find('input[name$="[tindakanpelayanan_id]"]').val();
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('HapusTindakanPelayanan'); ?>',
                data: {tindakanpelayanan_id:tindakanpelayanan_id},
                dataType: "json",
                success:function(data){
                    if(data.sukses){
                        $(obj).parents('tr').detach();
                    }
                    myAlert(data.pesan);
                },
                error: function (jqXHR, textStatus, errorThrown) { 
                    console.log(errorThrown);
                }
            });
        }
    });
    // if(confirm("Apakah Anda akan menghapus tindakan dan pemakaian bahan ini?")){
    //     var tindakanpelayanan_id = $(obj).parents('tr').find('input[name$="[tindakanpelayanan_id]"]').val();
    //     $.ajax({
    //         type:'POST',
    //         url:'<?php echo $this->createUrl('HapusTindakanPelayanan'); ?>',
    //         data: {tindakanpelayanan_id:tindakanpelayanan_id},
    //         dataType: "json",
    //         success:function(data){
    //             if(data.sukses){
    //                 $(obj).parents('tr').detach();
    //             }
    //             myAlert(data.pesan);
    //         },
    //         error: function (jqXHR, textStatus, errorThrown) { 
    //             console.log(errorThrown);
    //         }
    //     });
    // }
}
/**
 * rename input row yang terakhir di tambahkan
 * @param {type} obj_table
 */
function renameInputRow(obj_table){
    var row = 0;
    $(obj_table).find("tbody tr").each(function(){
        $(this).find("#no_urut").val(row+1);
        $(this).find("#row").val(row);
        $(this).find('span[name*="[ii]"]').each(function(){ //element <span>
            var new_name = $(this).attr("name").replace("ii",(row));
            $(this).attr("name",new_name);
        });
        $(this).find('input,select,textarea').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
            }
        });
        row++;
        if($(this).find("#row").length){ //untuk index tr baris ke-2 dianggap 1 baris dengan atasnya (karena berisi keterangan lanjutan)
            row--; 
        }
    });
    
}
/**
 * jika dipilih dari dialogbox
 */
function pilihTindakan(daftartindakan_id, daftartindakan_nama, kategoritindakan_nama, harga_tariftindakan, jenistarif_id, persencyto_tindakan){
    var tindakan_untuk = $("#tindakan_untuk").val();
    $("#"+tindakan_untuk).val(daftartindakan_nama);
    $("#"+tindakan_untuk).parents('tr').find('input[name$="[daftartindakan_id]"]').val(daftartindakan_id);
    $("#"+tindakan_untuk).parents('tr').find('input[name$="[kategoritindakan_nama]"]').val(kategoritindakan_nama);
    $("#"+tindakan_untuk).parents('tr').find('input[name$="[tarif_satuan]"]').val(harga_tariftindakan);
    $("#"+tindakan_untuk).parents('tr').find('input[name$="[jenistarif_id]"]').val(jenistarif_id);
    $("#"+tindakan_untuk).parents('tr').find('input[name$="[persencyto_tindakan]"]').val(persencyto_tindakan);
    tambahTindakanPemakaianBahan(daftartindakan_id,daftartindakan_nama);
    formatNumberSemua();
    hitungTarifTindakan();
}

/**
* untuk menambahkan daftar tindakan pada pemakaian bahan
*/
function tambahTindakanPemakaianBahan(value,label)
{
    if ($("#daftartindakanPemakaianBahan option[value='" + value + "']").length == 0) {
        $('#daftartindakanPemakaianBahan').append('<option value="'+value+'">'+label+'</option>');
    }
}

/**
 * jika dipilih dari dialogbox
 */
function pilihDokter(pegawai_id, nama_pegawai){
    var untuk_id = $("#dokter_untuk").val();
    $("#"+untuk_id).val(nama_pegawai);
    $("#"+untuk_id).parent().next('input').val(pegawai_id);
}


function pilihPPDS(ppds_id, ppds_nama){
    var untuk_id = $("#ppds_untuk").val();
    $("#"+untuk_id).val(ppds_nama);
    $("#"+untuk_id).parent().next('input').val(ppds_id);
}

function pilihPerawat(pegawai_id, nama_pegawai){
    var untuk_id = $("#perawat_untuk").val();
    $("#"+untuk_id).val(nama_pegawai);
    $("#"+untuk_id).parent().next('input').val(pegawai_id);
}

/**
 * hitung tarif tindakan dan total 
 **/
function hitungTarifTindakan(){
    unformatNumberSemua();
    var totaltarif = 0;
    $("#table_tindakanpelayanan > tbody input[name$='[qty_tindakan]']").each(function(){
        var qty_tindakan = $(this).val();
        var tarif_satuan = $(this).parents('tr').find("input[name$='[tarif_satuan]']").val();
        var persencyto_tindakan = $(this).parents('tr').find("input[name$='[persencyto_tindakan]']").val();
        var tarifcyto_tindakan = 0;
        if($(this).parents('tr').find("select[name$='[cyto_tindakan]']").val() == 1){
            tarifcyto_tindakan = (qty_tindakan * tarif_satuan * persencyto_tindakan / 100);
        }
        var subtotal = (qty_tindakan * tarif_satuan) + tarifcyto_tindakan;
        $(this).parents('tr').find("input[name$='[subtotal]']").val(subtotal);
        $(this).parents('tr').find("input[name$='[tarifcyto_tindakan]']").val(tarifcyto_tindakan);
        totaltarif += subtotal;
    });
    $("#table_tindakanpelayanan > tfoot").find("#totaltariftindakan").val(totaltarif);
    formatNumberSemua();
}
/**
 * untuk menampilkan dokter / pemeriksa lengkap
 */
function tampilkanPemeriksaLain(obj){
    $(obj).parents('tr').find(".dokter-lengkap").toggle('500');
    $(obj).parents('tr').find(".ppds-lengkap").toggle('500');
}
    
/**
*  untuk transaksi input pemakaian bahan
*/
$('#alatMedis').parent().addClass('hide');
function pilihAlkesMedis(obj)
{
    $('#tblInputPemakaianBahan > tbody').html('');
    $('#totPemakaianBahan').val('0');
    if(obj.value=='bahan'){
        $('#alatMedis').parent().addClass('hide');
        $('#pakaiBahan').parent().removeClass('hide');
    } else if(obj.value=='medis') {
        $('#pakaiBahan').parent().addClass('hide');
        $('#alatMedis').parent().removeClass('hide');
    }
} 

function inputPemakaianBahan(obj)
{
    var daftartindakan_id = $('#daftartindakanPemakaianBahan option:selected').val();
    var pendaftaran_id = $('#PendaftaranT_pendaftaran_id').val();
    var penjamin_id = $('#PendaftaranT_penjamin_id').val();
    var obatalkes_kode = $('#obatalkes_kode').val();
    var obatalkes_nama = $('#obatalkes_nama').val();
    var obatalkes_id = $('#obatalkes_id').val();
    if(daftartindakan_id == ''){
        myAlert('Belum ada Tindakan');
        return false;
    } 
    if(obatalkes_id != '')
    {            
		$.ajax({
			type:'POST',
			url:'<?php echo $this->createUrl('setFormPemakaianBahan'); ?>',
			data: {obatalkes_id:obatalkes_id, daftartindakan_id:daftartindakan_id,pendaftaran_id:pendaftaran_id,penjamin_id:penjamin_id},//
			dataType: "json",
			success:function(data){
				if(data.pesan !== ""){
					myAlert(data.pesan);
					var params = [];
					params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_GUDANGFARMASI; ?>, judulnotifikasi:'Stok Obat Alkes Habis', isinotifikasi:obatalkes_kode+' '+obatalkes_nama+'  di <?php echo Yii::app()->user->getState("ruangan_nama"); ?> telah habis'}; // 16 
					simpanNotifikasi(params);
					return false;
				}
				var tambahkandetail = true;
				var obatalkesyangsama = $("#tblInputPemakaianBahan input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']");
				if(obatalkesyangsama.val()){ //jika ada obat sudah ada di table
					myConfirm("Apakah Anda akan input ulang obat ini?",
					"Perhatian!",
					function(r){
						if(r){
							$("#tblInputPemakaianBahan input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']").each(function(){
								$(this).parents('tr').detach();
							});
						}else{
							tambahkandetail = false;
						}
					}); 
				}
				if(tambahkandetail){
					$('#tblInputPemakaianBahan > tbody').append(data.form);
					$("#tblInputPemakaianBahan").find('input[name*="[ii]"][class*="integer"]').maskMoney(
						{"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
					);
					renameInputRowObatAlkes($("#tblInputPemakaianBahan"));  
				}
				$(obj).parents('fieldset').find('#obatalkes_id').val('');
				$('#pakaiBahan').val('');
				hitungTotal();
				formatNumberSemua();
				renameInputRowObatAlkes($("#tblInputPemakaianBahan")); 
			},
			error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
		});
    }else{
        myAlert("Silakan pilih pemakaian bahan terlebih dahulu!");
    }
}
    
/**
* rename input grid
*/ 
function renameInputRowObatAlkes(obj_table){
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){
        $(this).find("#no_urut").val(row+1);
        $(this).find('span').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("name","["+row+"]["+old_name_arr[2]+"]");
            }
        });
        $(this).find('input,select,textarea').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
            }
        });
        row++;
    });
}

function renameInput(modelName,attributeName)
{
    var i = -1;
    $('#tblInputPemakaianBahan tr').each(function(){
        if($(this).has('input[name$="[obatalkes_id]"]').length){
            i++;
        }
        $(this).find('input[id='+modelName+'_0_'+attributeName+']').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('input[id='+modelName+'_0_'+attributeName+']').attr('id',modelName+'_'+i+'_'+attributeName+'');
        $(this).find('select[id='+modelName+'_0_'+attributeName+']').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('select[id='+modelName+'_0_'+attributeName+']').attr('id',modelName+'_'+i+'_'+attributeName+'');
    });
}

function hitungSubTotal(obj)
{
    var qty = unformatNumber(obj.value);
    var harga = unformatNumber($(obj).parents("#tblInputPemakaianBahan tr").find('input[name$="[hargajual]"]').val());
    var subtotal = qty * harga;
    $(obj).parents("#tblInputPemakaianBahan tr").find('input[name$="[subtotal]"]').val(formatNumber(subtotal));
    hitungTotal(); 
}
    
function hitungTotal()
{
    var total = 0;
    $('#tblInputPemakaianBahan').find('input[name$="[subtotal]"]').each(function(){
        total = total + unformatNumber(this.value);
    });
    $('#totPemakaianBahan').val(formatNumber(total));
}

function inputAlatmedis(alatmedis_id)
{
    var daftartindakan_id = $('#daftartindakanPemakaianBahan option:selected').val();
    if(daftartindakan_id == ''){
        myAlert('Belum ada Tindakan');
        return false;
    }
    
    jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('pemulasaranJenazah/TindakanPelayanan/addFormPemakaianAlat')?>',
			'data':{alatmedis_id:alatmedis_id, daftartindakan_id:daftartindakan_id},
			'type':'post',
			'dataType':'json',
			'success':function(data) {
				if(!sudahAdaAlat(alatmedis_id)){
					$('#tblInputPemakaianBahan #trPemakaianBahan').detach();
					$('#tblInputPemakaianBahan > tbody').append(data.form);
					renameInput('pemakaianAlat', 'alatmedis_id');
					renameInput('pemakaianAlat', 'hargajual');
					renameInput('pemakaianAlat', 'hargasatuan');
					renameInput('pemakaianAlat', 'harganetto');
					renameInput('pemakaianAlat', 'qty');
					renameInput('pemakaianAlat', 'subtotal');
					renameInput('pemakaianAlat', 'daftartindakan_id');
					renameInput('pemakaianAlat', 'sumberdana_id');
					hitungTotal();
				}

				   $("#tblInputPemakaianBahan > tbody tr:last .currency").maskMoney({"symbol":"Rp ","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0});
				   $('.currency').each(function(){this.value = formatNumber(this.value)});
				   $("#tblInputPemakaianBahan > tbody tr:last .number").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0,"symbol":null});
				   $('.number').each(function(){this.value = formatNumber(this.value)});
			} ,
			'cache':false});
        function sudahAdaAlat(alatmedis_id)
        {
             var ada;
             $('#tblInputPemakaianBahan').find('input[name$="[alatmedis_id]"]').each(function(){
                 var cek = true;
                 if(this.value!=alatmedis_id){
                     ada = cek && ada;
                 } else {
                     myAlert('Sudah ada!');
                     ada = cek && true;
                 }
             });

            return ada;
        }

        function renameInput(modelName,attributeName)
        {
            var i = -1;
            $('#tblInputPemakaianBahan tr').each(function(){
                if($(this).has('input[name$="[alatmedis_id]"]').length){
                    i++;
                }
                $(this).find('input[id='+modelName+'_0_'+attributeName+']').attr('name',modelName+'['+i+']['+attributeName+']');
                $(this).find('input[id='+modelName+'_0_'+attributeName+']').attr('id',modelName+'_'+i+'_'+attributeName+'');
                $(this).find('select[id='+modelName+'_0_'+attributeName+']').attr('name',modelName+'['+i+']['+attributeName+']');
                $(this).find('select[id='+modelName+'_0_'+attributeName+']').attr('id',modelName+'_'+i+'_'+attributeName+'');
            });
        }
}
//	RND-8754
///**
// * untuk transaksi input bmhp
// */
//function inputBMHP(daftartindakan_id)
//{
//    var ketemu = false;
//    var kelompokumur_id = $('#kelompokumur_id').val();
//    $('#tblInputTindakan').find('input[name$="[daftartindakan_id]"]').each(function(){
//        if($(this).val() == daftartindakan_id){
//            ketemu = true;
//            jQuery.ajax({'url':'<?php // echo Yii::app()->createUrl('pemulasaranJenazah/TindakanPelayanan/addFormPaketBmhp')?>',
//                 'data':{daftartindakan_id:daftartindakan_id, kelompokumur_id:kelompokumur_id},
//                 'type':'post',
//                 'dataType':'json',
//                 'success':function(data) {
//                         $('#tblInputPaketBhp').append(data.form);
//                         urutkanInputBMHP();
//                         hitungTotalBMHP();
//                 } ,
//                 'cache':false});
//        } 
//    });
//    if(!ketemu) {
//        myAlert('Tidak ada tindakan yang dimaksud.');
//    }
//}

function inputBMHP(daftartindakan_id,kelumur_id)
{
    var ketemu = false;
    var pendaftaran_id = $("#PendaftaranT_pendaftaran_id").val();
    var penjamin_id = $("#PendaftaranT_penjamin_id").val();
	if(pendaftaran_id == ''){
        myAlert('Belum ada Pasien yang dipilih!');
        return false;
    }
    $('#tblInputPemakaianBahan').find('input[name$="[daftartindakan_id]"]').each(function(){
//     DISABLE SEMENTARA KARENA ADA BMHP YG TDK BERDASARKAN TINDAKAN >> if($(this).val() == daftartindakan_id){
            ketemu = true;
            jQuery.ajax({'url':'<?php echo $this->createUrl(Yii::app()->controller->id.'/addFormPaketBmhp')?>',
                 'data':{daftartindakan_id:daftartindakan_id, kelumur_id:kelumur_id, pendaftaran_id:pendaftaran_id,penjamin_id:penjamin_id},
                 'type':'post',
                 'dataType':'json',
                 'success':function(data) {
						if(data.pesan !== ""){
							myAlert(data.pesan);
							return false;
						}
						$('#tblInputPaketBhp > tbody').append(data.form);
						$("#tblInputPaketBhp").find('input[name*="[ii]"][class*="integer"]').maskMoney(
							{"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
						);
//						renameInputRowPemakaianBahan($("#tblInputPaketBhp"));  
						urutkanInputBMHP();
						
						$('#obatalkes_id').val('');
						$('#paketBMHP').val('');
						formatNumberSemua();
//						renameInputRowPaketBmhp($("#tblInputPaketBhp")); 
						hitungTotalBMHP();
                 } ,
                 'cache':false});
//        } 
    });
    if(!ketemu) {
        myAlert('Tidak ada tindakan yang dimaksud.');
    }
}
    
function hitungTotalBMHP()
{ 
    var total = 0;
    $('#tblInputPaketBhp').find('input[name$="[hargapemakaian]"]').each(function(){
        total = total + unformatNumber(this.value);
    });
    $('#totHargaBmhp').val(formatNumber(total));
}

function urutkanInputBMHP()
{
    renameInputBMHP('paketBmhp', 'daftartindakan_id');
    renameInputBMHP('paketBmhp', 'obatalkes_id');
    renameInputBMHP('paketBmhp', 'satuankecil_id');
    renameInputBMHP('paketBmhp', 'sumberdana_id');
    renameInputBMHP('paketBmhp', 'qtypemakaian');
    renameInputBMHP('paketBmhp', 'hargasatuan');
    renameInputBMHP('paketBmhp', 'harganetto');
    renameInputBMHP('paketBmhp', 'hargajual');
    renameInputBMHP('paketBmhp', 'hargapemakaian');
}

function renameInputBMHP(modelName,attributeName)
{
    var i = -1;
    $('#tblInputPaketBhp tr').each(function(){
        if($(this).has('input[name$="[obatalkes_id]"]').length){
            i++;
        }
        $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('input[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
        $(this).find('select[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('select[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
    });
}

<?php
//komen karena muncul error
/*$gets = "";
if(isset($_GET)){
    foreach($_GET AS $name => $get){
        if($name != "r")
            $gets .= "&".$name."=".$get;
    }
}*/
?>
<?php $baseUrl = Yii::app()->createUrl("/");?>
<?php $riwayatPasien = Yii::app()->createUrl('rawatJalan/daftarPasien/getRiwayatPasien&id='.$modPendaftaran->pasien_id); ?>

function setRiwayatPasien(){
    var frameObj = document.getElementById("riwayatPasien");
    $(frameObj).attr("src","<?php echo $riwayatPasien;?>");
    $(frameObj).parent().addClass("animation-loading");
    $(frameObj).load(function(){
        resizeIframe(frameObj);
        $(frameObj).parent().removeClass("animation-loading");
        $("#divRiwayatPasien").slideToggle(500);
    });
    return false;
}
function resetIframe(obj) {
    obj.style.height = 128 + 'px';
}
function resizeIframe(obj) {
    obj.style.height = (obj.contentWindow.document.body.scrollHeight) + 'px';
}
$("#cekRiwayatPasien").change(function(){
    $('#divRiwayatPasien').slideToggle(500);
});
<?php
Yii::app()->clientScript->registerScript('onLoadJs','
    setRiwayatPasien();
', CClientScript::POS_READY);
?>

/**
 * fungsi ready ini posisinya harus tetap paling bawah
 */
$(document).ready(function(){
    renameInputRow($("#table_tindakanpelayanan"));
    setTimeout(function(){tambahTindakan(null,true);},1000); 
     cekDisabled($('#tindakan-pelayanan-t-form')); 
     
     $('form').bind('click keyup select change', function(event) {
   cekDisabled(this);
});
$(document).on('click keyup select change',function(){
   cekDisabled('form');
});
});
</script>