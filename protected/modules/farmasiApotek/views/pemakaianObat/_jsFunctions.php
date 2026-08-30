<script type="text/javascript">
function tambahObat(obj)
{
    // var obatalkes_id = $(obj).parents('fieldset').find('#obatalkes_id').val();
    var obatalkes_id = $('#obatalkes_id').val();
    var obatalkes_kode = $('#obatalkes_kode').val();
    // var jumlah = $(obj).parents('fieldset').find('#qtyNonRacik').val();
    var jumlah = $('#qtyNonRacik').val();
    var rke = $("#table-obatalkespasien tbody tr:last-child td").find('input[name*="[rke]"]').val();
    var namaObatNonRacik = $('#namaObatNonRacik').val();
    if(rke==undefined){rke=1;}else{rke++;}
    if(obatalkes_id != '')
    {
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('setFormObatAlkesPasien'); ?>',
            data: {obatalkes_id:obatalkes_id,jumlah:jumlah},//
            dataType: "json",
            success:function(data){
                if(data.pesan !== ""){
                    myAlert(data.pesan);
                    var params = [];
                    params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_GUDANGFARMASI; ?>, judulnotifikasi:'Stok Obat Alkes Habis', isinotifikasi:obatalkes_kode+' '+namaObatNonRacik+'  di <?php echo Yii::app()->user->getState("ruangan_nama"); ?> telah habis'}; // 16 
                    insert_notifikasi(params);
                    return false;
                }
                var tambahkandetail = true;
                var obatalkesyangsama = $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']");
                if(obatalkesyangsama.val()){ //jika ada obat sudah ada di table
                    myConfirm("Apakah Anda yakin ingin menginput ulang obat ini?","Perhatian!",
                    function(r){
                        if(r){
                            $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']").each(function(){
                                $(this).parents('tr').detach();
                            });
				if(tambahkandetail){
					$('#table-obatalkespasien > tbody').append(data.form);
					$("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer"]').maskMoney(
						{"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
					);
					addDataKeGridObat(obj,'nonracik',rke);
					renameInputRowObatAlkes($("#table-obatalkespasien"));                    
					hitungTotal();
				}
                        }else{
                            tambahkandetail = false;
                        }
                    }); 
                }else{
			if(tambahkandetail){
				$('#table-obatalkespasien > tbody').append(data.form);
				$("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer"]').maskMoney(
					{"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
				);
				addDataKeGridObat(obj,'nonracik',rke);
				renameInputRowObatAlkes($("#table-obatalkespasien"));                    
				hitungTotal();
			}
		}
		$(obj).parents('fieldset').find('#obatalkes_id').val('');
		$('#namaObatNonRacik').val('');
		$('#qtyNonRacik').val(1);
		formatNumberSemua();
		renameInputRowObatAlkes($("#table-obatalkespasien")); 
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
    var obatalkes_id = $(obj).parents('fieldset').find('#obatalkes_id').val();
    var obatalkes_kode = $('#obatalkes_kode').val();
    var jumlah = $(obj).parents('fieldset').find('#qtyRacik').val();
    var rke = $(obj).parents('fieldset').find('#racikanKe').val();
    var rkelast = $("#table-obatalkespasien tbody tr:last-child td").find('input[name*="[rke]"]').val();
    var namaObatRacik = $('#namaObatRacik').val();
    var indexrke = 0;
    var jmlrke = 0;
    var marginrke = 0;
    var statusmargin = 0;
    
    if(obatalkes_id != '')
    {
        
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('setFormObatAlkesPasien'); ?>',
            data: {obatalkes_id:obatalkes_id,jumlah:jumlah},//
            dataType: "json",
            success:function(data){
                if(data.pesan !== ""){
                    myAlert(data.pesan);
                    var params = [];
                    params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_GUDANGFARMASI; ?>, judulnotifikasi:'Stok Obat Alkes Habis', isinotifikasi:obatalkes_kode+' '+namaObatRacik+'  di <?php echo Yii::app()->user->getState("ruangan_nama"); ?> telah habis'}; // 16 
                    insert_notifikasi(params);
                    return false;
                }
                var tambahkandetail = true;
                var obatalkesyangsama = $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']");
                if(obatalkesyangsama.val()){ //jika ada obat sudah ada di table
                    myConfirm("Apakah Anda yakin ingin menginput ulang obat ini?","Perhatian!",
                    function(r){
                        if(r){
                            $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']").each(function(){
                                $(this).parents('tr').detach();
                            });
						if(tambahkandetail){
							if (indexrke==0) {
									$('#table-obatalkespasien > tbody').append(data.form);
							}else{
								$('#table-obatalkespasien > tbody > tr:nth-child('+(indexrke+marginrke)+')').after(data.form);
								$("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']").parents('tr').find("#isi-r").hide();
							}
							$("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer"]').maskMoney(
								{"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
							);
							addDataKeGridObat(obj,'racik',rke);
							renameInputRowObatAlkes($("#table-obatalkespasien"));                    
							hitungTotal();
						}
                        }else{
                            tambahkandetail = false;
                        }
                    }); 
                }else{
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
						$("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer"]').maskMoney(
							{"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
						);
						addDataKeGridObat(obj,'racik',rke);
						renameInputRowObatAlkes($("#table-obatalkespasien"));                    
						hitungTotal();
					}
				}
                
                $(obj).parents('fieldset').find('#obatalkes_id').val('');
                $('#namaObatRacik').val('');
                $('#qtyNonRacik').val(1);
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }else{
        myAlert("Silakan pilih obat / alkes terlebih dahulu!");
    }
    $("#namaObatRacik").focus();   
}

function addDataKeGridObat(obj,tipe,rke){
    if(tipe=='racik'){
        var obatalkes_id = $(obj).parents('fieldset').find('#obatalkes_id').val();
        var signa = $(obj).parents('fieldset').find('#signa_racik').val();
		var iterRacik = $(obj).parents('fieldset').find('#iterRacik').val();
        var permintaan = $(obj).parents('fieldset').find('#permintaan').val();
        var kemasan = $(obj).parents('fieldset').find('#jmlKemasanObat').val();
        var kekuatan = $(obj).parents('fieldset').find('#kekuatanObat').val();
        input_signa = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][signa_oa]"]');
        input_signa.val(signa);
        input_permintaan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][permintaan_oa]"]');
        input_permintaan.val(permintaan);
        input_kemasan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][jmlkemasan_oa]"]');
        input_kemasan.val(kemasan);
        input_kekuatan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][kekuatan_oa]"]');
        input_kekuatan.val(kekuatan);
		input_iter = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][iter]"]');
        input_iter.val(iterRacik);

        input_rke = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][rke]"]');
        input_rke.val(rke);
    }else{
        var obatalkes_id = $(obj).parents('fieldset').find('#obatalkes_id').val();
        var signa = $(obj).parents('fieldset').find('#signa').val();
		var iterNonRacik = $(obj).parents('fieldset').find('#iterNonRacik').val();
        input_signa = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][signa_oa]"]');
        input_signa.val(signa);
		input_iter = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][iter]"]');
        input_iter.val(iterNonRacik);
        
        input_rke = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][rke]"]');
        input_rke.val(rke);

    }
}

function tambahObatReseptur(obatalkes_id,rke,rkelast,jumlah,signa,permintaan,kemasan,kekuatan,etiket){
    var indexrke = 0;
    var jmlrke = 0;
    var marginrke = 0;
    var statusmargin = 0;

    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('setFormObatAlkesPasien'); ?>',
        data: {obatalkes_id:obatalkes_id,jumlah:jumlah},//
        dataType: "json",
        success:function(data){
            if(data.pesan !== ""){
                myAlert(data.pesan);
                return false;
            }
            var tambahkandetail = true;
            var obatalkesyangsama = $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']");
            if(obatalkesyangsama.val()){ //jika ada obat sudah ada di table
                myConfirm("Apakah Anda yakin ingin menginput ulang obat ini?","Perhatian!",
                function(r){
                    if(r){
                        $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']").each(function(){
                            $(this).parents('tr').detach();
                        });
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
                $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer"]').maskMoney(
                    {"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
                );
                addDataKeGridObatReseptur(obatalkes_id,signa,permintaan,kemasan,kekuatan,etiket,rke);
                renameInputRowObatAlkes($("#table-obatalkespasien"));                    
                hitungTotal();
            }
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

function addDataKeGridObatReseptur(obatalkes_id,signa,permintaan,kemasan,kekuatan,etiket,rke){
    input_signa = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][signa_oa]"]');
    input_signa.val(signa);
    input_permintaan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][permintaan_oa]"]');
    input_permintaan.val(permintaan);
    input_kemasan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][jmlkemasan_oa]"]');
    input_kemasan.val(kemasan);
    input_kekuatan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][kekuatan_oa]"]');
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
 * refresh dialog kunjungan
 * @returns {undefined}
 */
function refreshDialogInfoPasien(){
    var instalasi_id = $("#instalasi_id").val();
    var instalasi_nama = $("#instalasi_id option:selected").text();
    $.fn.yiiGridView.update('datakunjungan-grid', {
        data: {
            "FAPasienM[idInstalasi]":instalasi_id,
            // "FAPasienM[instalasi_nama]":instalasi_nama,
        }
    });
}

/**
 * menghapus detail obat alkes pasien berdasarkan obatalkes_id
 * @param {type} caraPrint
 * @returns {undefined} */
function batalObatAlkesPasienDetail(obj){
    myConfirm("Apakah Anda yakin ingin membatalkan penjualan obat alkes ini?","Perhatian!",
    function(r){
        if(r){
            var obatalkes_id = $(obj).parents('tr').find('input[name$="[obatalkes_id]"]').val();
            $(obj).parents('tbody').find('input[name$="[obatalkes_id]"][value="'+obatalkes_id+'"]').each(function(){
                $(this).parents('tr').detach();
            });
            hitungTotal();
			renameInputRowObatAlkes($("#table-obatalkespasien")); 
        }
    }); 
}
//TIDAK DIGUNAKAN ?
function hitungSubTotal(obj){
    unformatNumberSemua();
    harga = parseInt($(obj).parents('tr').find('input[name$="[hargasatuan_oa]"]').val());
    qty = parseInt($(obj).parents('tr').find('input[name$="[qty_oa]"]').val());
    diskon = parseInt($(obj).parents('tr').find('input[name$="[discount]"]').val());
    
    totaliurbiaya = ((harga*qty) - ((harga*qty) * (diskon/100)));
    iurbiaya = $(obj).parents('tr').find('input[name$="[iurbiaya]"]');
        
    subtotal = $(obj).parents('tr').find('input[name$="[hargajual_oa]"]');
    totalsubtotal = ((harga*qty) - ((harga*qty) * (diskon/100)));
    if(totaliurbiaya <=0 ){
        totaliurbiaya = 0;
    }
    
    if(totalsubtotal <= 0){
        totalsubtotal = 0;
    }
    
    subtotal.val(totalsubtotal);
    iurbiaya.val(totaliurbiaya);
    
    hitungTotal();
    formatNumberSemua();
}

function hitungTotal(){
    unformatNumberSemua();
    obj_totalharga =  $('#<?php echo CHtml::activeId($model,"totalharga") ?>');
    totalharga = 0;
	var asd = $(obj_totalharga).parents('th');
	$(asd).addClass("animation-loading-1");
    $('#table-obatalkespasien > tbody > tr').each(function(){
        totalharga += parseFloat( $(this).find('input[name*="[subtotal]"]').val());
    });
    obj_totalharga.val(totalharga);
	setTimeout(function(){
		$(asd).removeClass("animation-loading-1");
	},300);
    formatNumberSemua();
}

/**
 * class integer di unformat 
 * @returns {undefined}
 */
function unformatNumberSemua(){
    $(".integer").each(function(){
        $(this).val(parseInt(unformatNumber($(this).val())));
    });
}
/**
 * class integer di format kembali
 * @returns {undefined}
 */
function formatNumberSemua(){
    $(".integer").each(function(){
        $(this).val(formatInteger($(this).val()));
    });
}

/**
* untuk print penjualan dokter
 */
function print(caraPrint)
{
    var pemakaianobat_id = '<?php echo isset($model->pemakaianobat_id) ? $model->pemakaianobat_id : null ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&id='+pemakaianobat_id+'&caraPrint='+caraPrint+'&sukses=1','printwin','left=100,top=100,width=1000,height=640');
}

/**
 * set form obat dari reseptur detail
 * @returns {undefined}
 */
function setFormObatReseptur(){
    $('#tabel-detailreseptur tbody').find('tr').each(function(){
        var obatalkes_id = $(this).find('input[name*="[obatalkes_id]"]').val();
        var signa = $(this).find('input[name*="[signa_reseptur]"]').val();
        var permintaan = $(this).find('input[name*="[permintaan_reseptur]"]').val();
        var kemasan = $(this).find('input[name*="[jmlkemasan_reseptur]"]').val();
        var kekuatan = $(this).find('input[name*="[kekuatan_reseptur]"]').val();
        var jumlah = $(this).find('input[name*="[qty_reseptur]"]').val();
        var rke = $(this).find('input[name*="[rke]"]').val();
        var etiket = $(this).find('input[name*="[etiket]"]').val();
        var rkelast = $("#table-obatalkespasien tbody tr:last-child td").find('input[name*="[rke]"]').val();
        tambahObatReseptur(obatalkes_id,rke,rkelast,jumlah,signa,permintaan,kemasan,kekuatan,etiket);
    });
}

function cekObat(){
    if(requiredCheck($("form"))){
        var jumlah_obat = $('#table-obatalkespasien tbody tr').length;
        if(jumlah_obat <= 0){
                myAlert('Silakan isikan obat alkes terlebih dahulu!');
            return false;
        }else{
            $('#fapemakaianobat-t-form').submit();
        }
        
        $(".animation-loading").removeClass("animation-loading");
        $("form").find('.float').each(function(){
            $(this).val(formatFloat($(this).val()));
        });
        $("form").find('.integer').each(function(){
            $(this).val(formatInteger($(this).val()));
        });
    }
    return false;
    
}
/**
 * ubah takaran resep
 * @returns {undefined}
 */
function ubahTakaranResep(obj){
	var takaran = $(obj).val();
	var takarantext = $(obj).find("[value='"+takaran+"']").text();
	myConfirm('Proses perhitungan takaran resep hanya bisa dilakukan satu kali. Apakah Anda yakin ingin mengubah takaran semua obat menjadi '+takarantext+' dari resep?', 'Perhatian!', function(r){
		if(r){
			proporsiTakaranResep(takaran);
			$(obj).attr('readonly',true);
			$(obj).click(function(){
				$('#<?php // echo CHtml::activeId($modPenjualan,"totalhargajual") ?>').focus();
			});
		}else{
			$(obj).val(1);
		}
	});
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
			hitungTotal();
			$('#table-obatalkespasien > tbody').removeClass("animation-loading");
		},
		error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	});
}


/**
 * function ini harus tetap berada di bawah
 */
$(document).ready(function(){
    renameInputRowObatAlkes($("#table-obatalkespasien")); 
    hitungTotal();
    var seconds = 0;
    setInterval(function()
    {
        seconds++;
        if(seconds >= 999999) {
            seconds = 0;
        }
        $('#<?php // echo CHtml::activeId($modPenjualan,"lamapelayanan") ?>').val(seconds);
    }, 1000);
    
    <?php if(isset($_GET['reseptur_id'])){ ?>
    var reseptur_id = <?php echo isset($_GET['reseptur_id'])?$_GET['reseptur_id']:'' ?>;
    var pendaftaran_id = <?php echo isset($modReseptur->pendaftaran_id)?$modReseptur->pendaftaran_id:'' ?>;

    if(reseptur_id != ''){
        if(pendaftaran_id != ''){
            setInfoPasien(pendaftaran_id,'','','');
            setFormObatReseptur();
        }
    }
    <?php } ?>
    <?php if(isset($_GET['pendaftaran_id'])){ ?>
        var pendaftaran_id = <?php echo isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id']:'' ?>;
        var instalasi_id = <?php echo isset($_GET['instalasi_id']) ? $_GET['instalasi_id']:'' ?>;
        $('#instalasi_id').val(instalasi_id);
        if(pendaftaran_id != ''){
            setInfoPasien(pendaftaran_id,'','','');
        }
    <?php } ?>
        
    <?php if(isset($_GET['penjualanresep_id']) && isset($_GET['sukses'])){ ?>
        var penjualanresep_id = <?php echo isset($_GET['penjualanresep_id']) ? $_GET['penjualanresep_id']:'' ?>;
        $("#table-obatalkespasien :input").removeAttr("readonly",true);
        $("#table-obatalkespasien .add-on").remove();
        $("#table-obatalkespasien .icon-remove").remove();        
        
        $("#penjualanresep-form :input").attr("readonly",true);
        $("#penjualanresep-form .dtPicker3").attr("readonly",true);
        $("#penjualanresep-form .add-on").remove();
        $("#penjualanresep-form .btn-mini").remove();
        
        $("input, select, textarea").attr("disabled",true);  
    <?php } ?>
});
// function cekInput(){
//     var kosong = 0;
//     if($('#pendaftaran_id').val()==''){
//         myAlert('Input data pasien terlebih dahulu!');
//         kosong++;
//     }
//     if($('#<?php // echo CHtml::activeId($modPenjualan,"pegawai_id");?>').val()==''){
//         myAlert('Input data dokter reseptur terlebih dahulu!');
//         kosong++;
//     }
//     if(kosong>0){
//         return false;
//     }else{
//         return true;
//     }
// }
</script>