<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type="text/javascript">

var is_signa_select = false;


function sortTable(){
    var rows = $('#table-obatalkespasien tbody  tr').get();
    rows.sort(function(a, b) {
        
        var A = parseInt((a).children('td').eq(1).html());
        var B = parseInt($(b).children('td').eq(1).html());

        if(A < B) {
            return -1;
        }

        if(A > B) {
            return 1;
        }

        return 0;

    });
    $.each(rows, function(index, row) {
        $('#table-obatalkespasien').children('tbody').append(row);
    });
}
function form_tambah_signa() {
    myPrompt("Tambah Signa Baru", "", "", function(r) {
        var v = r;

        if (v.trim() == "") return false;

        myConfirm("Anda yakin untuk menambah signa '" + r + "'?", "Peringatan", function(yes) {
            if (yes) {
                $.post('<?php echo $this->createUrl('/actionAjax/tambahSigna'); ?>', {signa: v.trim()}, function(data) {
                    myAlert(data.msg);
                }, 'json');
            }
        });
    });
}


function editObatAlkesPasienDetail(obj) {
    unformatNumberSemua();
    
    var satuan_permintaandosis = $(obj).parents('tr').find('input[name$="[satuan_permintaandosis]"]').val();
    var racikan_id = $(obj).parents('tr').find('input[name$="[racikan_id]"]').val();
    var obatalkes_id = $(obj).parents('tr').find('input[name$="[obatalkes_id]"]').val();
    var permintaan_dosis = $(obj).parents('tr').find('input[name$="[permintaan_dosis]"]').val();
    var jumlah = $(obj).parents('tr').find('input[name$="[jumlah]"]').val();
    var signa_oa = $(obj).parents('tr').find('input[name$="[signa_oa]"]').val();
    var etiket = $(obj).parents('tr').find('input[name$="[etiket]"]').val();
    var satuan_jmlpermintaan = $(obj).parents('tr').find('input[name$="[satuan_jmlpermintaan]"]').val();
    var sediaan = $(obj).parents('tr').find('input[name$="[sediaan]"]').val();
    var kodeObat = $(obj).parents('tr').find('span[name$="[obatalkes_kode]"]').html();
    var namaObat = $(obj).parents('tr').find('span[name$="[obatalkes_nama]"]').html();
    var obat = kodeObat + ' - ' + namaObat;
    var rke = $(obj).parents('tr').find('input[name$="[rke]"]').val();
    var satuansediaan = $(obj).parents('tr').find('input[name$="[satuansediaan]"]').val();
    var etiket = $(obj).parents('tr').find('input[name$="[etiket]"]').val();
    var pembilang = $(obj).parents('tr').find('input[name$="[permintaandosis_pembilang]"]').val();
    var penyebut = $(obj).parents('tr').find('input[name$="[permintaandosis_penyebut]"]').val();
    var jml_permintaan = $(obj).parents('tr').find('input[name$="[jml_permintaan]"]').val();

    formjenisresep(racikan_id);
    setTimeout(function() {
        explodeEtiket(etiket, racikan_id)
        if (racikan_id == <?= Params::RACIKAN_ID_RACIKAN ?>) {
            setEditRacikan(rke, obatalkes_id, obat, pembilang, penyebut, signa_oa, jml_permintaan, permintaan_dosis, satuansediaan, satuan_permintaandosis, sediaan, satuan_jmlpermintaan);
            $('#jenisresep').val(1);
        }else{
            setEditNonRacikan(signa_oa, jumlah, obatalkes_id, obat, rke);
            $('#jenisresep').val(0);
        }
    }, 800);

}

function explodeEtiket(etiket, racikan_id){
    var Etiket = etiket.split(" - ");

    if (racikan_id == 1) {
        $('#etiketracikan1').val(Etiket[0]);
        $('#etiketracikan2').val(Etiket[1]);
        $('#etiketracikan3').val(Etiket[2]);
        $('#etiketracikan4').val(Etiket[3]);
    }else{
        $('#etiketnonracikan1').val(Etiket[0]);
        $('#etiketnonracikan2').val(Etiket[1]);
        $('#etiketnonracikan3').val(Etiket[2]);
        $('#etiketnonracikan4').val(Etiket[3]);
    }
}

function setEditRacikan(rke, obatalkes_id, obat, pembilang, penyebut, signa_oa, jml_permintaan, permintaan_dosis, satuansediaan, satuan_permintaandosis, sediaan, satuan_jmlpermintaan){
    $("#form-racikan .add-on").hide();
    $("#form-racikan .icon-remove").hide();
    $("#form-racikan").find("#tombolracikanbaru").attr('disabled', true);
    $("#form-racikan").find("#racikanKe").attr('disabled', true);
    $("#form-racikan").find("#signaracikan").attr('readonly', false);
    $("#form-racikan").find("#satuansediaan").attr('disabled', false);
    $("#form-racikan").find("#namaObatRacik").attr('readonly', true);
    $("#form-racikan").find("#jmlKemasanObat").attr('readonly', true);
    $("#form-racikan").find('#racikanKe').val(rke);
    $("#form-racikan").find('#signaracikan').val(signa_oa);
    $("#form-racikan").find('#jmlKemasanObat').val(jml_permintaan);
    $("#form-racikan").find("#kekuatanObat").val(sediaan);
    $("#form-racikan").find("#satuansediaan").val(satuan_jmlpermintaan);
    $("#form-racikan").find('#obatalkes_id').val(obatalkes_id);
    $("#form-racikan").find("#namaObatRacik").val(obat);
    $("#form-racikan").find("#pembilang").val(pembilang);
    $("#form-racikan").find("#penyebut").val(penyebut);

    if(pembilang != '' && penyebut != ''){
        hasil = (parseFloat(pembilang) / parseFloat(penyebut)) * parseFloat(sediaan);
        $("#form-racikan").find("#permintaan").val(hasil);
    }else{
        $("#form-racikan").find("#permintaan").val(permintaan_dosis);
    }
    formatNumberSemua();
    // hitungJumlahObat();
}

function setEditNonRacikan(signa_oa, jumlah, obatalkes_id, obat, rke){
    $("#form-nonracikan .add-on").hide();
    $("#form-nonracikan .icon-remove").hide();
    $("#form-nonracikan").find("#namaObatNonRacik").attr('readonly', true);
    $("#form-nonracikan").find('#obatalkes_id').val(obatalkes_id);
    $("#form-nonracikan").find("#namaObatNonRacik").val(obat);
    $("#form-nonracikan").find("#qtyNonRacik").val(jumlah);
    $("#form-nonracikan").find("#signa").val(signa_oa);
    $("#form-nonracikan").find("#rke").val(rke);
    formatNumberSemua();
}

function enabledField(){
    $("#form-racikan").find("#tombolracikanbaru").attr('disabled', false);

    $("#form-racikan").find("#jmlKemasanObat").attr('readonly', false);
    $("#form-racikan").find("#namaObatRacik").attr('readonly', false);
    $("#form-racikan .add-on").show();
    $("#form-racikan .icon-remove").show();

    $("#form-nonracikan").find("#namaObatNonRacik").attr('readonly', false);
    $("#form-nonracikan .add-on").show();
    $("#form-nonracikan .icon-remove").show();
    $("#form-nonracikan").find("#rke").val('');
    $("#form-nonracikan").find('#qtyNonRacik').val(1);;

}

function replaceRacikan(rke, etiket, signa, satuansediaan){
    $('#table-obatalkespasien').find("tbody > tr").each(function(){
        var rke_field = $(this).find('input[name*="[rke]"]').val();

        if(rke == rke_field){
            $(this).find('input[name*="[signa_oa]"]').val(signa);
            $(this).find('input[name*="[etiket]"]').val(etiket);
            $(this).find('input[name*="[satuan_jmlpermintaan]"]').val(satuansediaan);
        }
    });
}

function tambahObatNonRacik(obj)
{
    var obatalkes_id = $(obj).parents('#form-nonracikan').find('#obatalkes_id').val();
    var obatalkes_kode = $('#obatalkes_kode').val();
    var jumlah = $(obj).parents('#form-nonracikan').find('#qtyNonRacik').val();
    var rke = $("#table-obatalkespasien tbody tr:last-child td").find('input[name*="[rke]"]').val();
    var namaObatNonRacik = $('#namaObatNonRacik').val();
    var isRacikan = 0;
    var instalasi_id = $("#instalasi_id").val();

    var rke_edit = $(obj).parents('#form-nonracikan').find('#rke').val();
    var obatlain = $(obj).parents('#form-nonracikan').find('.namaobatlain').val();
    
    const dosis = $(obj).parents('#form-nonracikan').find(".dosis").val();
    const etiketwaktu = $(obj).parents('#form-nonracikan').find(".etiketwaktu").val();
    const frekuensi = $(obj).parents('#form-nonracikan').find(".frekuensi").val();
    const keterangan = $(obj).parents('#form-nonracikan').find(".keterangan").val();

    if (jumlah == 0) {
        myAlert("Jumlah tidak boleh nol");
        return false;
    }

    if(rke==undefined){rke=1;}else{rke++;}
    if(obatalkes_id != '')
    {
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('setFormObatAlkesPasien'); ?>',
            data: {
                obatalkes_id:obatalkes_id,
                jumlah:jumlah,
                racikan: false,
                isRacikan: isRacikan,
                dosis:dosis,
                etiketwaktu:etiketwaktu,
                frekuensi:frekuensi,
                keterangan:keterangan,
                obatlain
            },
            dataType: "json",
            success:function(data){
                if(data.pesan !== ""){
                    myAlert(data.pesan);
                    var params = [];
                    params = {
                        instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>, 
                        modul_id:<?php echo Params::MODUL_ID_GUDANGFARMASI; ?>, 
                        judulnotifikasi:'Stok Obat Alkes Habis', 
                        isinotifikasi:obatalkes_kode+' '+namaObatNonRacik+'  di <?php echo Yii::app()->user->getState("ruangan_nama"); ?> telah habis'}; // 16
                    insert_notifikasi(params);
                    return false;
                }

                var tambahkandetail = true;
                // var obatalkesyangsama = $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']");
                // if(obatalkesyangsama.val()){ //jika ada obat sudah ada di table

                //     // myConfirm("Apakah anda akan input ulang obat ini?","Perhatian!",
                //     // function(r){
                //     //     if (r) {
                //     //         $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='" + obatalkes_id + "']").each(function() {
                //     //             rke = $(this).parents("tr").find(".rke").val();
                //     //             $(this).parents('tr').remove();

                //     myConfirm("Apakah anda akan menambahkan obat yang sama??","Perhatian!",
                //     function(r){
                //         if (r) {
                //             // $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='" + obatalkes_id + "']").each(function() {
                //             //     rke = $(this).parents("tr").find(".rke").val();
                //             //     $(this).parents('tr').remove();
                //             // });
                //             $('#table-obatalkespasien').find("tbody > tr").each(function(){
                //                 if(rke_edit != ''){
                //                     var rke_kolom = $(this).find(".rke").val();
                //                     var obat_id = $(this).find('input[name$="[obatalkes_id]"]').val();
                //                     rke = rke_edit;

                //                     if(rke_kolom == rke && obat_id == obatalkesyangsama.val()){
                //                         $(this).remove();
                //                     }
                //                 }
                //             });

                //             if (tambahkandetail) {
                //                 $('#table-obatalkespasien > tbody').append(data.form);

                //                 $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer2"]').maskMoney({
                //                     "symbol": "",
                //                     "defaultZero": true,
                //                     "allowZero": true,
                //                     "decimal": ",",
                //                     "thousands": "",
                //                     "precision": 0
                //                 });
                //                 $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer-decimal"]').maskMoney({
                //                     "symbol": "",
                //                     "defaultZero": true,
                //                     "allowZero": true,
                //                     "decimal": ",",
                //                     "thousands": ".",
                //                     "precision": 2
                //                 });

                //             //     addDataKeGridObat(obj, 'nonracik', rke);
                //             //     renameInputRowObatAlkes($("#table-obatalkespasien"));
                //             //     // hitungtotalHargaReseptur();
                //             // }

                //             // $(obj).parents('#form-nonracikan').find('#obatalkes_id').val('');
                //             // $(obj).parents('#form-nonracikan').find('#formulaobatkronis_id').val('');
                //             // $('#namaObatNonRacik').val('');
                //             // $('#qtyNonRacik').val(1);
                //             // // formatNumberSemua();
                //             // renameInputRowObatAlkes($("#table-obatalkespasien"));

                //                 addDataKeGridObat(obj, 'nonracik', rke, obatalkes_id);
                //                 renameInputRowObatAlkes($("#table-obatalkespasien"));
                //                 sortTable();
                //                 // hitungtotalHargaReseptur();
                //             }

                //             // $(obj).parents('#form-nonracikan').find('#obatalkes_id').val('');
                //             // $(obj).parents('#form-nonracikan').find('#formulaobatkronis_id').val('');
                //             // $('#namaObatNonRacik').val('');
                //             // $('#qtyNonRacik').val(1);
                //             // // formatNumberSemua();
                //             // renameInputRowObatAlkes($("#table-obatalkespasien"));



                //         } else {
                //             tambahkandetail = false;

                //             enabledField();
                //         }
                //     });
                // }else{
                    if(tambahkandetail){
                        $('#table-obatalkespasien > tbody').append(data.form);
                        $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer2"]').maskMoney(
                            {
                                "symbol":"",
                                "defaultZero":true,
                                "allowZero":true,
                                "decimal":".",
                                "thousands":",",
                                "precision":0}
                        );
                        $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer-decimal"]').maskMoney(
                            {
                                "symbol": "", 
                                "defaultZero": true, 
                                "allowZero": true, 
                                "decimal": ",", 
                                "thousands": ".",
                                "precision": 2
                            }
                      );

                        addDataKeGridObat(obj,'nonracik',rke, obatalkes_id);
                        renameInputRowObatAlkes($("#table-obatalkespasien"));
                    }
                // }
                setTimeout(function() {
                    $(obj).parents('#form-nonracikan').find('#obatalkes_id').val('');
                    $('#namaObatNonRacik').val('');
                    $('#qtyNonRacik').val(1);
                    $("#dosisnon, #etiketwaktunon, #keterangannon").val("");
                    // formatNumberSemua();
                    renameInputRowObatAlkes($("#table-obatalkespasien"));
                }, 1000);

        },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }else{
        myAlert("Silakan pilih obat / alkes terlebih dahulu!");
    }
    $("#namaObatNonRacik").focus();
}

function tambahObatRacik(obj)
{
    var obatalkes_id = $(obj).parents('#form-racikan').find('#obatalkes_id').val();
    var obatalkes_kode = $('#obatalkes_kode').val();
    var jumlah = $(obj).parents('#form-racikan').find('#qtyRacik').val();
    var rke = $(obj).parents('#form-racikan').find('#racikanKe').val();
    var rkelast = $("#table-obatalkespasien tbody tr:last-child td").find('input[name*="[rke]"]').val();
    var namaObatRacik = $('#namaObatRacik').val();
    var obatlain = $(obj).parents('#form-racikan').find('.namaobatlain').val();
    var indexrke = 0;
    var jmlrke = 0;
    var marginrke = 0;
    var statusmargin = 0;

    var pembilang = $(obj).parents('#form-racikan').find('#pembilang').val();
    var penyebut = $(obj).parents('#form-racikan').find('#penyebut').val();

    var instalasi_id = $("#instalasi_id").val();
    
    const dosis = $(obj).parents('#form-racikan').find(".dosis").val();
    const etiketwaktu = $(obj).parents('#form-racikan').find(".etiketwaktu").val();
    const frekuensi = $(obj).parents('#form-racikan').find(".frekuensi").val();
    const keterangan = $(obj).parents('#form-racikan').find(".keterangan").val();

    // if (jumlah == 0) {
    //     myAlert("Jumlah racik tidak boleh nol");
    //     return false;
    // }

    if(obatalkes_id != '')
    {

        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('setFormObatAlkesPasien'); ?>',
            data: {
                obatalkes_id:obatalkes_id,
                jumlah:jumlah,
                racikan: true,
                instalasi_id: instalasi_id,

                pembilang: pembilang,
                penyebut : penyebut,
                dosis:dosis,
                etiketwaktu:etiketwaktu,
                frekuensi:frekuensi,
                keterangan:keterangan,
                obatlain
            },
            dataType: "json",
            success:function(data){
                if(data.pesan !== ""){
                    myAlert(data.pesan);
                    var params = [];
                    params = {
                        instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, 
                        modul_id:<?php echo Params::MODUL_ID_GUDANGFARMASI; ?>, 
                        judulnotifikasi:'Stok Obat Alkes Habis', 
                        isinotifikasi:obatalkes_kode+' '+namaObatRacik+'  di <?php echo Yii::app()->user->getState("ruangan_nama"); ?> telah habis'}; // 16
                    insert_notifikasi(params);
                    return false;
                }
                var tambahkandetail = true;
                // var obatalkesyangsama = $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']");
                // if(obatalkesyangsama.val()){ //jika ada obat sudah ada di table

                //     myConfirm("Apakah anda akan menambahkan obat yang sama?","Perhatian!",
                //     function(r){
                //         if (r) {
                //             // $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='" + obatalkes_id + "']").each(function() {
                //             //     $(this).parents('tr').detach();
                //             // });
                //             $('#table-obatalkespasien').find("tbody > tr").each(function(){
                //                 if(rke != ''){
                //                     var rke_kolom = $(this).find(".rke").val();
                //                     var obat_id = $(this).find('input[name$="[obatalkes_id]"]').val();

                //                     if(rke_kolom == rke && obat_id == obatalkesyangsama.val()){
                //                         $(this).detach();
                //                     }
                //                 }

                //             });
                //             if (tambahkandetail) {
                //                 if (indexrke == 0) {
                //                     $('#table-obatalkespasien > tbody').append(data.form);
                //                 } else {
                //                     $('#table-obatalkespasien > tbody > tr:nth-child(' + (indexrke + marginrke) + ')').after(data.form);
                //                     $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='" + obatalkes_id + "']").parents('tr').find("#isi-r").hide();
                //                 }
                //                 $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer2"]').maskMoney({
                //                     "symbol": "",
                //                     "defaultZero": true,
                //                     "allowZero": true,
                //                     "decimal": ",",
                //                     "thousands": ".",
                //                     "precision": 0
                //                 });
                //                 $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer-decimal"]').maskMoney({
                //                     "symbol": "",
                //                     "defaultZero": true,
                //                     "allowZero": true,
                //                     "decimal": ",",
                //                     "thousands": ".",
                //                     "precision": 2
                //                 });

                //         //         addDataKeGridObat(obj, 'racik', rke);
                //         //         renameInputRowObatAlkes($("#table-obatalkespasien"));
                //         //         // hitungtotalHargaReseptur();
                //         //     }

                //         //     $(obj).parents('#form-racikan').find('#obatalkes_id').val('');
                //         //     $('#namaObatRacik').val('');
                //         //     $('#qtyNonRacik').val(1);
                //         // } else {
                //         //     tambahkandetail = false;


                //                 addDataKeGridObat(obj, 'racik', rke, obatalkes_id);
                //                 renameInputRowObatAlkes($("#table-obatalkespasien"));
                //                 sortTable();
                //                 // hitungtotalHargaReseptur();
                //             }
                //             // setTimeout(function() {
                //             //     $(obj).parents('#form-racikan').find('#obatalkes_id').val('');
                //             //     $('#namaObatRacik').val('');
                //             //     $('#qtyNonRacik').val(1);
                //             // }, 1000);
                //         } else {
                //             tambahkandetail = false;
                //             enabledField();

                //         }
                //     });
                // }else{
					$('#table-obatalkespasien > tbody > tr').each(function(){
						if($(this).find('input[name*="[rke]"]').val()==rke){
							if (marginrke==0) {
								if(statusmargin==0){
									marginrke=jmlrke;
									statusmargin = 1;
								}
							};
							indexrke++;
						}
						jmlrke++;
					});

					if(tambahkandetail){
						if (indexrke==0) {
                            $('#table-obatalkespasien > tbody').append(data.form);
						}else{
							$('#table-obatalkespasien > tbody > tr:nth-child('+(indexrke+marginrke)+')').after(data.form);
							$("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']").parents('tr').find("#isi-r").hide();
						}
						$("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer2"]').maskMoney(
							{
                                "symbol":"",
                                "defaultZero":true,
                                "allowZero":true,
                                "decimal":".",
                                "thousands":",",
                                "precision":0
                            }
						);
                        $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer-decimal"]').maskMoney(
                            {
                                "symbol": "", 
                                "defaultZero": true, 
                                "allowZero": true, 
                                "decimal": ",", 
                                "thousands": ".", 
                                "precision": 2
                            }
                        );


						addDataKeGridObat(obj,'racik',rke, obatalkes_id);
						renameInputRowObatAlkes($("#table-obatalkespasien"));
					}
				// }

                $(obj).parents('#form-racikan').find('#obatalkes_id').val('');

                $('#namaObatRacik').val('');
                $('#qtyNonRacik').val(1);

                // $('#namaObatRacik').val('');
                // $('#pembilang').val('');
                // $('#penyebut').val('');
                // $('#qtyNonRacik').val(1);
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }else{
        myAlert("Silakan pilih obat / alkes terlebih dahulu!");
    }
    $("#namaObatRacik").focus();
    

//     setTimeout(function() {
//         setTombolRacikanBaru();
//     }, 2000);
// }

// function addDataKeGridObat(obj,tipe,rke){
//     if(tipe=='racik'){
//         var obatalkes_id = $(obj).parents('#form-racikan').find('#obatalkes_id').val();

    // setTimeout(function() {
    //     setTombolRacikanBaru();
    // }, 2000);
}

function addDataKeGridObat(obj,tipe,rke, obatalkes_id){
    if(tipe=='racik'){
        // var obatalkes_id = $(obj).parents('#form-racikan').find('#obatalkes_id').val();
        var signa = $(obj).parents('#form-racikan').find('#signaracikan').val();
        var dosis = $(obj).parents('#form-racikan').find(".dosis").val();
        var etiketwaktu = $(obj).parents('#form-racikan').find(".etiketwaktu").val();
        var permintaan = $(obj).parents('#form-racikan').find('#permintaan').val();
        var kemasan = $(obj).parents('#form-racikan').find('#jmlKemasanObat').val();
        var kekuatan = $(obj).parents('#form-racikan').find('#kekuatanObat').val();
        // var etiket = setEtiket($(obj).parents('#form-racikan').find('#etiketracikan1').val(), $(obj).parents('#form-racikan').find('#etiketracikan2').val(), $(obj).parents('#form-racikan').find('#etiketracikan3').val(), $(obj).parents('#form-racikan').find('#etiketracikan4').val());
        var etiket = setEtiket(signa, dosis, etiketwaktu, "");
        var satuansediaan = $(obj).parents('#form-racikan').find('#satuansediaan').val();
        var satuan_permintaandosis = $(obj).parents('#form-racikan').find('#satuan_permintaandosis').val();
        var jumlah = $(obj).parents('#form-racikan').find('#qtyRacik').val();

        var pembilang = $(obj).parents('#form-racikan').find('#pembilang').val();
        var penyebut = $(obj).parents('#form-racikan').find('#penyebut').val();
        
        var input_temp_permintaan_dosis = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][temp_permintaan_dosis]"]');

        var input_jumlah = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][jml_permintaan]"]');
        input_jumlah.val(jumlah);
        var input_signa = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][signa_oa]"]');
        input_signa.val(signa);
        var input_permintaan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][permintaan_dosis]"]');
        input_permintaan.val(permintaan);
        var input_kemasan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][jml_permintaan]"]');
        input_kemasan.val(kemasan);
        var input_kekuatan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][sediaan]"]');
        input_kekuatan.val(kekuatan);
		var input_etiket = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][etiket]"]');
        // console.log(input_etiket);
        input_etiket.val(etiket);
		var input_satuansediaan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][satuan_jmlpermintaan]"]');
        input_satuansediaan.val(satuansediaan);
        var input_rke = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][rke]"]');
        input_rke.val(rke);
        var input_satuan_permintaandosis = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][satuan_permintaandosis]"]');
        input_satuan_permintaandosis.val(satuan_permintaandosis);

        var input_pembilang = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][permintaandosis_pembilang]"]');
        input_pembilang.val(pembilang);
        var input_penyebut = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][permintaandosis_penyebut]"]');
        input_penyebut.val(penyebut);

        // if(pembilang != '' && penyebut != ''){
        //     input_temp_permintaan_dosis.removeClass("integer-decimal");
        //     var temp = pembilang+' / '+penyebut;
        // }else{
        //     input_temp_permintaan_dosis.addClass("integer-decimal");
            var temp = permintaan;
        // }

        input_temp_permintaan_dosis.val(temp);
        
        var input_frekuensi = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][frekuensi]"]');
        input_frekuensi.val(signa);

        var span_satuankekuatan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="' + obatalkes_id + '"]').parents('tr').find('.satuankekuatan');
        span_satuankekuatan.text(satuan_permintaandosis);

        var span_rke = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="' + obatalkes_id + '"]').parents('tr').find('.resep_ke');
        span_rke.text(rke);

        replaceRacikan(rke, etiket, signa, satuansediaan);
        setTombolRacikanBaru();

        setTimeout(function() {
            setTitle(obatalkes_id, kemasan, permintaan, kekuatan);
        }, 3100);
    }else{

        // var obatalkes_id = $(obj).parents('#form-nonracikan').find('#obatalkes_id').val();
        // var signa = $(obj).parents('#form-nonracikan').find('#signa').val();
        // var etiket = setEtiket($(obj).parents('#form-nonracikan').find('#etiketnonracikan1').val(), $(obj).parents('#form-nonracikan').find('#etiketnonracikan2').val(), $(obj).parents('#form-nonracikan').find('#etiketnonracikan3').val(), $(obj).parents('#form-nonracikan').find('#etiketnonracikan4').val()); 

        // var obatalkes_id = $(obj).parents('#form-nonracikan').find('#obatalkes_id').val();
        // var signa = $(obj).parents('#form-nonracikan').find('#signa').val();
        var etiket = setEtiket($(obj).parents('#form-nonracikan').find('#etiketwaktunon').val(), $(obj).parents('#form-nonracikan').find('#etiketnonracikan2').val(), $(obj).parents('#form-nonracikan').find('#etiketnonracikan3').val(), $(obj).parents('#form-nonracikan').find('#etiketnonracikan4').val()); 
        var signa = $(obj).parents('#form-nonracikan').find('#signa').val();
        // var signa = $(obj).parents('#form-racikan').find('#signaracikan').val();
        var dosis = $(obj).parents('#form-racikan').find(".dosis").val();
        // var etiketwaktu = $(obj).parents('#form-racikan').find(".etiketwaktu").val();
        var dosis = $(obj).parents('#form-nonracikan').find(".dosis").val();
        var etiketwaktu = $(obj).parents('#form-nonracikan').find(".etiketwaktu").val();
        var frekuensi = $(obj).parents('#form-nonracikan').find(".frekuensi").val();
        var etiket = setEtiket(signa, dosis, etiketwaktu, "");


        var input_signa = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][signa_oa]"]');
        input_signa.val(signa);
        var input_frekuensi = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][frekuensi]"]');
        input_frekuensi.val(signa);
        var input_etiket = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][etiket]"]');
        input_etiket.val(etiket);
        var input_rke = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][rke]"]');
        input_rke.val(rke);
        var span_rke = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="' + obatalkes_id + '"]').parents('tr').find('.resep_ke');
        span_rke.text(rke);
        var input_etiket = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][etiket]"]');
        // console.log(input_etiket);
        input_etiket.val(etiket);
    }

    enabledField();
}

function gantiClass(){
    $('#table-obatalkespasien').find("tbody > tr").each(function(){
        var pembilang = $(this).find('input[name*="[permintaandosis_pembilang]"]').val();
        var penyebut = $(this).find('input[name*="[permintaandosis_penyebut]"]').val();
        var input_permintaan = $(this).find('input[name*="[temp_permintaan_dosis]"]');

        if(pembilang != '' && penyebut != ''){
            input_permintaan.removeClass("integer-decimal")
            input_permintaan.val(pembilang+'/'+penyebut);
        }
    });
}


function tambahObatReseptur(obatalkes_id,rke,rkelast,jumlah,signa,permintaan,kemasan,kekuatan,etiket){
    var indexrke = 0;
    var jmlrke = 0;
    var marginrke = 0;
    var statusmargin = 0;

    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('setFormObatAlkesPasien'); ?>',
        data: {
            obatalkes_id:obatalkes_id,
            jumlah:jumla
        },
        dataType: "json",
        success:function(data){
            if(data.pesan !== ""){
                myAlert(data.pesan);
                return false;
            }
            var tambahkandetail = true;
            var obatalkesyangsama = $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']");
            if(obatalkesyangsama.val()){ //jika ada obat sudah ada di table
                myConfirm("Apakah anda akan input ulang obat ini?","Perhatian!",
                function(r){
                    if(r){
                        $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']").each(function(){

                            $(this).parents('tr').detach();
                        });

                        sortTable();
                    }else{
                        tambahkandetail = false;
                    }
                });
            }
            $('#table-obatalkespasien > tbody > tr').each(function(){
                if($(this).find('input[name*="[rke]"]').val()==rke){
                    if (marginrke==0) {
                        if(statusmargin==0){
                            marginrke=jmlrke;
                            statusmargin = 1;
                        }
                    };
                    indexrke++;
                }
                jmlrke++;
            });

            if(tambahkandetail){
                if (indexrke==0) {
                        $('#table-obatalkespasien > tbody').append(data.form);
                }else{
                    $('#table-obatalkespasien > tbody > tr:nth-child('+(indexrke+marginrke)+')').after(data.form);
                    $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']").parents('tr').find("#isi-r").hide();
                }
                $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer2"]').maskMoney(
                    {"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
                );
                addDataKeGridObatReseptur(obatalkes_id,signa,permintaan,kemasan,kekuatan,etiket,rke);
                renameInputRowObatAlkes($("#table-obatalkespasien"));
            }
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

function addDataKeGridObatReseptur(obatalkes_id,signa,permintaan,kemasan,kekuatan,etiket,rke){
    input_signa = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][signa_oa]"]');
    input_signa.val(signa);
    input_permintaan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][permintaan_dosis]"]');
    input_permintaan.val(permintaan);
    input_kemasan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][jml_permintaan]"]');
    input_kemasan.val(kemasan);
    input_kekuatan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][sediaan]"]');
    input_kekuatan.val(kekuatan);
    input_rke = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][rke]"]');
    input_rke.val(rke);
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

/**
 * set form obat dari reseptur detail
 * @returns {undefined}
 */
function setFormObatReseptur(){
    $('#tabel-detailreseptur tbody').find('tr').each(function(){
        var obatalkes_id = $(this).find('input[name*="[obatalkes_id]"]').val();

        // var signa = $(this).find('input[name*="[signa_reseptur]"]').val();
        // var permintaan = $(this).find('input[name*="[permintaan_reseptur]"]').val();
        // var kemasan = $(this).find('input[name*="[jmlkemasan_reseptur]"]').val();
        // var kekuatan = $(this).find('input[name*="[sediaan]"]').val();
        // var jumlah = $(this).find('input[name*="[qty_reseptur]"]').val();

        var signa = $(this).find('input[name*="[signa_oa]"]').val();
        var permintaan = $(this).find('input[name*="[permintaan_dosis]"]').val();
        var kemasan = $(this).find('input[name*="[jml_permintaan]"]').val();
        var kekuatan = $(this).find('input[name*="[sediaan]"]').val();
        var jumlah = $(this).find('input[name*="[jumlah]"]').val();
        var rke = $(this).find('input[name*="[rke]"]').val();
        var etiket = $(this).find('input[name*="[etiket]"]').val();
        var rkelast = $("#table-obatalkespasien tbody tr:last-child td").find('input[name*="[rke]"]').val();
        tambahObatReseptur(obatalkes_id,rke,rkelast,jumlah,signa,permintaan,kemasan,kekuatan,etiket);
    });
}

function cekObat(){
    if(requiredCheck($("form"))){
        var is_cukup = true;
        var is_nol = false;

        $("#table-obatalkespasien tbody tr").each(function() {
            $(this).removeClass("yellow");

            var qty = parseFloat(unformatNumber($(this).find(".qty_jual").val()));
            var stok = parseFloat(unformatNumber($(this).find(".qty_stok").val()));

            if (qty > stok) {
                $(this).addClass("yellow");
                is_cukup = false;
            }

        });

        if (!is_cukup) {
            myAlert("Stok tidak mencukupi.");
            return false;
        }

        if (is_nol) {
            myAlert("Jumlah obat / alkes tidak boleh nol!");
            return false;
        }

        if ($("#FAPenjualanResepT_pegawai_id").val() == "") {
            myAlert("Dokter harus diisi");
            return false;
        }
        var jumlah_obat = $('#table-obatalkespasien tbody tr').length;
        if(jumlah_obat <= 0){
            myAlert('Isikan obat alkes terlebih dahulu.');
            return false;
        }else{
          $(".integer2, .float2, .integer-decimal").each(function(){
              $(this).val(unformatNumber($(this).val()));
          });
            $('#penjualanresep-form').submit();
        }

        $(".animation-loading").removeClass("animation-loading");
        $("form").find('.float2').each(function(){
            $(this).val(formatFloat(parseFloat($(this).val())));
        });
        $("form").find('.integer2').each(function(){
            $(this).val(formatNumber(parseFloat($(this).val())));
        });
        $("form").find('.integer-decimal').each(function(){
            $(this).val(formatThousandDecimal(parseFloat($(this).val())));
        });
    }
    return false;

}

/**
 * menghitung proporsi semua obat berdasarkan takaran
 * @returns {undefined}
 */
function proporsiTakaranResep(takaran){
	$('#table-obatalkespasien > tbody').addClass("animation-loading");
	$.ajax({
		type:'POST',
		url:'<?php echo $this->createUrl('SetProporsiTakaranResep'); ?>',
		data: {takaran : takaran, data:$("input[name*='FAObatalkesPasienT']").serialize()},//
		dataType: "json",
		success:function(data){
			$('#table-obatalkespasien > tbody tr').detach();
			$('#table-obatalkespasien > tbody').append(data.form);
			renameInputRowObatAlkes($("#table-obatalkespasien"));
			$('#table-obatalkespasien > tbody').removeClass("animation-loading");
		},
		error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	});
}

function clearInputan()
{
    $('#obatalkes_id').val('');
    $('#obatalkes_kode').val('');
    $('#ruanganapotek_id').val('');
    $('#namaObatNonRacik').val('');
}

function formjenisresep(jenisresep){
	$(".formjenisresep").addClass("animation-loading");
	setTimeout(function(){

		if(jenisresep==<?= Params::RACIKAN_ID_RACIKAN ?>){
			$("#form-nonracikan").hide();
			$("#form-racikan").show();
		}else{
			$("#form-nonracikan").show();
			$("#form-racikan").hide();
		}
		$(".formjenisresep").removeClass("animation-loading");
	},500);
}

// function hitungJumlahObat(){
// 	$("#qtyRacik").addClass("animation-loading-1");
// 	var jmlkemasanobat = parseFloat(unformatNumber($('#jmlKemasanObat').val()));
// 	var permintaan = parseFloat(unformatNumber($('#permintaan').val()));
// 	var kekuatanobat = parseFloat(unformatNumber($('#kekuatanObat').val()));
// 	setTimeout(function(){
// 		if((jmlkemasanobat != '')&&(permintaan != '')&&(kekuatanobat != '')){
//                 var jmlobat = permintaan*jmlkemasanobat/kekuatanobat;
//                 $("#tomboltambahracikan").attr("disabled",false);
//         }else{
//                 var jmlobat = 0;
// //                $("#tomboltambahracikan").attr("disabled",true);
//         }
//         $("#qtyRacik").val(formatFloat(jmlobat));
// 		$("#qtyRacik").removeClass("animation-loading-1");
// 	},500);
// }

function setTombolRacikanBaru(){
	$("#formanak").addClass("animation-loading-1");
	setTimeout(function(){
		$("#tombolracikanbaru").attr('disabled',false);
		$("#racikanKe").attr('disabled',true);
		// $("#signaracikan").attr('disabled',true);
		$("#etiketracikan").attr('disabled',true);
		$("#jmlKemasanObat").attr('disabled',true);
		$("#satuansediaan").attr('disabled',true);
		$("#permintaan").val('');
		$("#kekuatanObat").val('');

		$("#pembilang").val('');
		$("#penyebut").val('');
		$("#kekuatanObat").val('');
		$("#namaObatRacik").val('');
		$("#obatalkes_id").val('');
		// hitungJumlahObat();
		$("#formanak").removeClass("animation-loading-1");
	},1000);

}

function racikanBaru(){
	$("#formanak").addClass("animation-loading-1");
	setTimeout(function(){
		$("#tombolracikanbaru").attr('disabled',true);
		$("#racikanKe").attr('disabled',false);
		$("#signaracikan").attr('disabled',false);
		$("#etiketracikan").attr('disabled',false);
		$("#jmlKemasanObat").attr('disabled',false);
		$("#satuansediaan").attr('disabled',false);
		$("#jmlKemasanObat").val('');
		$("#permintaan").val('');
		$("#kekuatanObat").val('');

        $("#dosisracik").val("");
        $("#etiketwakturacik").val("");
        $("#keteranganracik").val("");
		$("#namaObatRacik").val('');
        $("#pembilang").val('');
		$("#penyebut").val('');
		$("#obatalkes_id").val('');
		$("#signaracikan").val('');
		// hitungJumlahObat();
		setDropDownRke();
		$("#formanak").removeClass("animation-loading-1");
	},500);
}

function setDropDownRke(){
	var rmax = $("#table-obatalkespasien tbody tr:last-child td").find('input[name*="[rke]"]').val();
	$.ajax({
		type:'POST',
		url:'<?php echo $this->createUrl('SetDropdownRke'); ?>',
		data: {rmax : rmax++},
		dataType: "json",
		success:function(data){
			$('#racikanKe').html(data);
		},
		error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	});
}

function setEtiket(etiket_1,etiket_2,etiket_3,etiket_4){
    var etiket_final = "";
    var count = 0;

    if(etiket_1==" " || etiket_1==""){
    }else{
        count++;
        etiket_final += etiket_1;
    }
    if(etiket_2==" " || etiket_2==""){
    }else{
        if(count==1)
            etiket_final += " - ";
        count++;
        etiket_final += etiket_2;
    }
    if(etiket_3==" " || etiket_3==""){
    }else{
        if(count==2 || count==1)
            etiket_final += " - ";
        count++;
        etiket_final += etiket_3;
    }
    if(etiket_4==" " || etiket_4==""){
    }else{
        if(count==3 || count==2 || count==1)
            etiket_final += " - ";
        count++;
        etiket_final += etiket_4;
    }

    return etiket_final;
}

/**
 * function ini harus tetap berada di bawah
 */
$(document).ready(function(){
    renameInputRowObatAlkes($("#table-obatalkespasien"));
    setFormObatReseptur();

    <?php if(isset($_GET['sukses'])) { ?>
        $("#table-obatalkespasien :input").removeAttr("readonly",true);
        $("#table-obatalkespasien .add-on").remove();
        $("#table-obatalkespasien .icon-remove").remove();

        $("#penjualanresep-form :input").attr("readonly",true);
        $("#penjualanresep-form .dtPicker3").attr("readonly",true);
        $("#penjualanresep-form .add-on").remove();
        $("#penjualanresep-form .btn-mini").remove();

        $("input, select, textarea").attr("disabled",true);
    <?php } ?>


    gantiClass();
	formjenisresep(0); // load awal form non racikan yang dimunculkan
});

function setTitle(obatalkes_id, kemasan, permintaan, kekuatan){
    var title = "Jumlah Permintaan = "+kemasan+" Permintaan Dosis = "+permintaan+" Sedian = "+kekuatan;
    
    var jumlah = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('.qty_stok');
    jumlah.attr('title', title)
}

function hitungPecahanDosisRacikan() {
    $("#dialogPecahanDosis").addClass('animation-loading');
    setTimeout(function() {
        var pembilang = $("#dosis_pembliang").val();
        var penyebut = $("#dosis_penyebut").val();
        var kekuatan = $("#kekuatanObat").val();

        $("#pembilang").val(pembilang);
        $("#penyebut").val(penyebut);
        
        var hasil = 0;
        
        if (penyebut == 0) {
            myAlert("Penyebut tidak boleh 0.");
            return false;
        }
        
        if (kekuatan.trim() == "") {
            myAlert("Kekuatan obat belum ada.");
            return false;
        }

        // hasil = Math.round((pembilang / penyebut) * parseFloat(kekuatan));

        
        hasil = (parseFloat(pembilang) / parseFloat(penyebut)) * parseFloat(kekuatan);


        $("#permintaan").val(formatFloat(hasil));
        $("#dialogPecahanDosis").removeClass('animation-loading');
        $("#dialogPecahanDosis").dialog("close");
        $("#dosis_pembliang").val("");
        $("#dosis_penyebut").val("");
        // hitungJumlahObat();
    }, 2000);
}

function setObat(obatalkes_id){
    $.ajax({
        type: 'POST',
        url: '<?php echo $this->createUrl('setTherapiobatid'); ?>',
        data: {
            obatalkes_id: obatalkes_id
        }, //
        dataType: "json",
        success: function(data) {
            if(obatalkes_id == 7862){
                $('.namaobatlain').removeClass('hidden');
            }else{
                $('.namaobatlain').addClass('hidden');
                $('.namaobatlain').val("");
            }
            renameInputRowObatAlkes($("#table-obatalkespasien"));
            if (data) {
                $("#therapiobat_id2").val(data);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
        }
    });
}
$('#tombolDialogOaRacikan').click(function() {
    // $("#permintaan").val('');
    $('.namaobatlain').val("");
    // var ruangantujuan_id = $('#ruanganapotek_id').val();
    // $.fn.yiiGridView.update('obatAlkesDialogRacikan-m-grid', {
    //     data: {
    //         "RJObatAlkesM[ruangan_id]": ruangantujuan_id,
    //     }
    // });
});
</script>
