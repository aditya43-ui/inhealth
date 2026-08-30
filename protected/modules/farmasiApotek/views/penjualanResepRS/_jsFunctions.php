<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type="text/javascript">
    $('.number-char').on('keypress', function(event) {
        var karakter = String.fromCharCode(event.which);

        // Regular expression untuk memeriksa apakah karakter adalah titik, koma, atau slash
        var pattern = /^[0-9.\/]+$/;

        if (!pattern.test(karakter)) {
            event.preventDefault();
        }
    });
    
     // untuk fungsi pencarian pada dialog obat dari api
     const debounceDelay = 600; // setel  untuk jeda

    // Inisialisasi variabel timeout
    let debounceTimeout;

    function searchOA(obj, idGrid) {
        
        clearTimeout(debounceTimeout);
        
        // Setel timeout baru
        debounceTimeout = setTimeout(function() {
            // Kode pencarian yang akan dijalankan setelah jeda
            
            var cariNama = $(obj).val();
            console.log('nama dicari', cariNama);
            
            $.fn.yiiGridView.update(idGrid, {
                'ObatAPI[Nama]': cariNama
            }); //  fungsi pencarian dengan teks yang dimasukkan
            
        }, debounceDelay);

    }
    // end
    
    function hitungJumlahPermintaan(obj) {
        var hari = $('#dosisracik').val();
        var signa_b = $('#signa_b').val();
        var signa_a = $('#signa_a').val();

        if(signa_b == '') {
            signa_b = 0;
        }
        if(hari == '') {
            hari = 0;
        }
        if(signa_a == '') {
            signa_a = 0;
        }
        $('#jumlahpermintaan_obatracikan').val(hari * signa_b * signa_a);

    } 

    function setObatDariApi(kode_obat, sumberdana, stfornas, harga_jual, satuan, nama, HPP) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('/rawatJalan/reseptur/getObat'); ?>',
            data: {
                kode_obat: kode_obat,
                sumberdana: sumberdana,
                stfornas:stfornas,
                harga_jual:harga_jual,
                satuan:satuan,
                nama:nama,
                HPP:HPP
            },
            dataType: "json",
            success: function(data) {
                console.log(data);
                if(data.sukses == 1) {
                    if(data.obatalkes.sukses == 1) {
                        $("#form-nonracikan #obatalkes_id").val(data.obatalkes.id);
                        $("#form-nonracikan #st_fornas").val(stfornas);
                        $("#obatalkes_kode").val(data.obatalkes.kode);
                        $("#obatalkes_nama").val(data.obatalkes.nama);
                        $("#sumberdana_id").val(data.sumberdana.id);
                        $("#form-nonracikan #signa").val(data.obatalkes.signa);
                        $("#dialogObatDariApi").dialog("close");
                    } else {
                        myAlert(data.pesan);
                    }
                } else {
                    myAlert(data.pesan);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function setObatRacikanDariApi(kode_obat, sumberdana, stfornas, harga_jual, satuan, nama, HPP) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('/rawatJalan/reseptur/getObat'); ?>',
            data: {
                kode_obat: kode_obat,
                sumberdana: sumberdana,
                stfornas:stfornas,
                harga_jual:harga_jual,
                satuan:satuan,
                nama:nama,
                HPP:HPP
            },
            dataType: "json",
            success: function(data) {
                console.log(data);
                if(data.sukses == 1) {
                    if(data.obatalkes.sukses == 0) {
                        $("#form-racikan #namaObatRacikDariApi").val('');
                        myAlert(data.pesan);
                    } else {
                        $("#form-racikan #obatalkes_id").val(data.obatalkes.id);
                        $("#form-racikan #st_fornas").val(stfornas);
                        $("#form-racikan #sumberdana_id").val(data.sumberdana.id);
                        $("#obatalkes_kode").val(data.obatalkes.kode);
                        $("#form-nonracikan #kekuatanObat").val(data.obatalkes.kekuatanObat);
                    }
                    $("#dialogRacikanObatDariApi").dialog("close");
                } else {
                    myAlert(data.pesan);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

function set_kie_pilih_semua() {
    $(".kie_item").prop("checked", $(".kie_pilih_semua").is(":checked"));
}

var is_signa_select = false;

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

function tambahObatNonRacik(obj)
{

    console.log('tambah obat non racikan')
    var obatalkes_id = $(obj).parents('#form-nonracikan').find('#obatalkes_id').val();
    var obatalkes_kode = $('#obatalkes_kode').val();
    var jumlah = $(obj).parents('#form-nonracikan').find('#qtyNonRacik').val();
    var rke = $("#table-obatalkespasien tbody tr:last-child td").find('input[name*="[rke]"]').val();
    var namaObatNonRacik = $('#namaObatNonRacik').val();
	var therapiobat_id = $(obj).parents('#form-nonracikan').find('#therapiobat_id2').val();
	var penggunaan_oa = $(obj).parents('#form-nonracikan').find('#penggunaan_oa').val();
    var is_kronis = $(obj).parents('#form-nonracikan').find('.is_kronis').val();
    var keterangan = $(obj).parents('#form-nonracikan').find('#keterangannon').val();
    var formulaobatkronis_id = $(obj).parents('#form-nonracikan').find('#formulaobatkronis_id').val();
    var obatlain = $(".namaobatlain").val();

    var st_fornas = $('#st_fornas').val();
    var sumberdana_id = $('#sumberdana_id').val();
    var hargasatuan_reseptur = $('#hargasatuan_reseptur').val();
    var satuansediaan = $('#sediaanobatnonracikan').val();
    if(is_kronis == undefined){
        is_kronis = '';
    }

    if(formulaobatkronis_id == undefined){
        formulaobatkronis_id = '';
    }
    

    var instalasi_id = $("#instalasi_id").val();
    var penjamin_id = $("#penjamin_id").val();
    
    if($("#<?php echo CHtml::activeId($modPenjualan,'penjamin_id'); ?>").val() != undefined && $("#<?php echo CHtml::activeId($modPenjualan,'penjamin_id'); ?>").val() != ''){
        penjamin_id = $("#<?php echo CHtml::activeId($modPenjualan,'penjamin_id'); ?>").val();
    }
    
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
                therapiobat_id:therapiobat_id,
                penggunaan_oa:penggunaan_oa,
                racikan: false,
                instalasi_id:instalasi_id,
                penjamin_id: penjamin_id,
                is_kronis: is_kronis,
                keterangan: keterangan,
                formulaobatkronis_id: formulaobatkronis_id,
                obatlain:obatlain,
                st_fornas:st_fornas,
                sumberdana_id:sumberdana_id,
                hargasatuan_reseptur:hargasatuan_reseptur,
                satuansediaan:satuansediaan
            },//
            dataType: "json",
            success:function(data){
                if(data.pesan !== ""){
                    myAlert(data.pesan);
                    var params = [];
                    params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_GUDANGFARMASI; ?>, judulnotifikasi:'Stok Obat Alkes Habis', isinotifikasi:obatalkes_kode+' '+namaObatNonRacik+'  di <?php echo Yii::app()->user->getState("ruangan_nama"); ?> telah habis'}; // 16
                    insert_notifikasi(params);
                    return false;
                }
				var therapiobatyangsama = $("#table-obatalkespasien input[name$='[therapiobat_id]'][value='"+therapiobat_id+"']");
				if(therapiobatyangsama.val()){ //jika ada therapi obat sudah ada
					myAlert('Obat ini memiliki kelas therapi yang sama dengan pilihan obat sebelumnya');
				}
                var tambahkandetail = true;
                var obatalkesyangsama = $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']");
                
                if(tambahkandetail){
                    $('#table-obatalkespasien > tbody').append(data.form);
                    $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer2"]').maskMoney(
                        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
                    );
                    $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer-decimal"]').maskMoney(
                            {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ",", "thousands": ".", "precision": 2}
                    );
                    jQuery('.exp_date:last').datepicker(
                        jQuery.extend({showMonthAfterYear: false},
                            jQuery.datepicker.regional['id'], {
                                'dateFormat': 'dd/mm/yy', 
                                'timeText': 'Waktu', 
                                'hourText': 'Jam',
                                'minuteText': 'Menit', 
                                'secondText': 'Detik', 
                                'showSecond': true, 
                                'timeOnlyTitle': 'Pilih   Waktu', 
                                'timeFormat': 'hh:mm:ss', 
                                'changeYear': true, 
                                'changeMonth': true, 
                                'showAnim': 'fold'
                            }
                        )
                    );


                    addDataKeGridObat(obj,'nonracik',rke);
                    renameInputRowObatAlkes($("#table-obatalkespasien"));
                    hitungTotal();
                }
                jQuery('.exp_date:last').datepicker(
                    jQuery.extend({showMonthAfterYear: false},
                        jQuery.datepicker.regional['id'], {
                            'dateFormat': 'dd/mm/yy', 
                            'timeText': 'Waktu', 
                            'hourText': 'Jam',
                            'minuteText': 'Menit', 
                            'secondText': 'Detik', 
                            'showSecond': true, 
                            'timeOnlyTitle': 'Pilih   Waktu', 
                            'timeFormat': 'hh:mm:ss', 
                            'changeYear': true, 
                            'changeMonth': true, 
                            'showAnim': 'fold'
                        }
                    )
                );
                resetInput(obj);
                changeKronisObat($('#form-nonracikan').find('.is_kronis'));
                // formatNumberSemua();
                renameInputRowObatAlkes($("#table-obatalkespasien"));

                
            admisi = $('#pasienadmisi_id').val();

            console.log('pasienadmisinya ada nggak? ' + (admisi != ''));

                if(admisi !== '') {
                    // setTimeout(() => {
                    $('.waktu-ri').removeClass('hide');
                    $('.wakturanap').last().val($('#tempWaktu').val());

                    cek = $('#tempWaktu').val().split(', ');

                    $('.wakturanap').last().find('.cb-waktu').prop('checked', false);

                    if(cek.length > 0) {
                        cek.forEach(function(val, idx) {

                            console.log('cek ------------------ '+idx);
                            console.log($('.wakturanap').last().closest('.waktu-ri').find('.cb-waktu[data-val="'+val+'"]'));
                            console.log('cek val: '+val);

                            $('.wakturanap').last().closest('.waktu-ri').find('.cb-waktu[data-val="'+val+'"]').prop('checked', 'checked');

                        });
                    }
                // }, 1500);
                } else {
                    // setTimeout(() => {
                    $('.waktu-ri').addClass('hide');
                    $('.wakturanap').last().val('');

                // }, 1500);
            }

        },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }else{
        myAlert("Silakan pilih obat / alkes terlebih dahulu!");
    }
    $("#namaObatNonRacik").focus();
}

$(function(){
    var sediaan  = jQuery('#sediaanobatnonracikan');

    jQuery(sediaan).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '102px',
            enableCaseInsensitiveFiltering: true
    }).hide();
});

function resetInput(obj) {
    $('#sediaanobatnonracikan').val('');
    $('.etiketwaktu').val('');
    $('.keterangan').val('');
    var sediaan  = jQuery('#sediaanobatnonracikan');
    jQuery(sediaan).multiselect('rebuild');
    $(obj).parents('#form-nonracikan').find('#obatalkes_id').val('');
    $(obj).parents('#form-nonracikan').find('.keterangan_oa').val('');
    $('#namaObatNonRacikDariApi').val('');
    $('#signa').val('');
    $('#qtyNonRacik').val(1);
    $(obj).parents('#form-nonracikan').find('.is_kronis').attr('checked',false);
}

function tambahObatRacik(obj)
{
    console.log('tambah obat racikan')
    var obatalkes_id = $(obj).parents('#form-racikan').find('#obatalkes_id').val();
    var obatalkes_kode = $('#obatalkes_kode').val();
    var jumlah = $(obj).parents('#form-racikan').find('#jumlahpermintaan_obatracikan').val();
    var rke = $(obj).parents('#form-racikan').find('#racikanKe').val();
	var penggunaan_oa = $(obj).parents('#form-racikan').find('#penggunaan_oa').val();
    var rkelast = $("#table-obatalkespasien tbody tr:last-child td").find('input[name*="[rke]"]').val();
    var namaObatRacik = $('#namaObatRacik').val();
    var satuansediaan = $('#form-racikan').find('#satuansediaan').val();
    var jmlKemasanObat = 0;
    var keterangan = $(obj).parents('#form-racikan').find('.keterangan').val();

    var st_fornas = $('#form-racikan #st_fornas').val();
    var sumberdana_id = $('#form-racikan #sumberdana_id').val();
    var hargasatuan_reseptur = $('#form-racikan #hargasatuan_reseptur').val();

    var dosispermintaan = $('#form-racikan #permintaan').val();
    
    var indexrke = 0;
    var jmlrke = 0;
    var marginrke = 0;
    var statusmargin = 0;


    var instalasi_id = $("#instalasi_id").val();
    var penjamin_id = $("#penjamin_id").val();
    if($("#<?php echo CHtml::activeId($modPenjualan,'penjamin_id'); ?>").val() != undefined && $("#<?php echo CHtml::activeId($modPenjualan,'penjamin_id'); ?>").val() != ''){
        penjamin_id = $("#<?php echo CHtml::activeId($modPenjualan,'penjamin_id'); ?>").val();
    }

    if (jumlah == 0) {
        myAlert("Jumlah racik tidak boleh nol");
        return false;
    }

    if(obatalkes_id != '')
    {

        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('setFormObatAlkesPasien'); ?>',
            data: {
                obatalkes_id:obatalkes_id,
                jumlah:jumlah,
                penggunaan_oa:penggunaan_oa,
                racikan: true,
                instalasi_id: instalasi_id,
                penjamin_id: penjamin_id,
                satuansediaan:satuansediaan,
                keterangan: keterangan,
                jmlkemasan:jmlKemasanObat,
                st_fornas:st_fornas,
                sumberdana_id:sumberdana_id,
                hargasatuan_reseptur:hargasatuan_reseptur,
                dosispermintaan:dosispermintaan
            },//
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
                        $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']").parents('tr').find("input[name$='[jasapelayanan_farmasi]']").val(formatThousandDecimal(0));
                        $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']").parents('tr').find("input[name$='[total_embalase]']").val('');
                    }
                    $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer2"]').maskMoney(
                        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
                    );
                    $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer-decimal"]').maskMoney(
                            {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ",", "thousands": ".", "precision": 2}
                    );
                    
                    addDataKeGridObat(obj,'racik',rke);
                    renameInputRowObatAlkes($("#table-obatalkespasien"));
                    hitungTotal();
                }
                jQuery('.exp_date:last').datepicker(
                    jQuery.extend({showMonthAfterYear: false},
                        jQuery.datepicker.regional['id'], {
                            'dateFormat': 'dd/mm/yy', 
                            'timeText': 'Waktu', 
                            'hourText': 'Jam',
                            'minuteText': 'Menit', 
                            'secondText': 'Detik', 
                            'showSecond': true, 
                            'timeOnlyTitle': 'Pilih   Waktu', 
                            'timeFormat': 'hh:mm:ss', 
                            'changeYear': true, 
                            'changeMonth': true, 
                            'showAnim': 'fold'
                        }
                    )
                );

                $(obj).parents('#form-racikan').find('#obatalkes_id').val('');
                $('#namaObatRacikDariApi').val('');
                $('#namaObatRacik').val('');
                $('#qtyNonRacik').val(1);

                admisi = $('#pasienadmisi_id').val();

                console.log('pasienadmisinya ada nggak? ' + (admisi != ''));

                if(admisi !== '') {
                    // setTimeout(() => {
                    $('.waktu-ri').removeClass('hide');
                    $('.wakturanap').last().val($('#tempWaktuRacikan').val());

                    cek = $('#tempWaktuRacikan').val().split(', ');

                    $('.wakturanap').last().find('.cb-waktu').prop('checked', false);

                    if(cek.length > 0) {
                        cek.forEach(function(val, idx) {

                            console.log('cek ------------------ '+idx);
                            console.log($('.wakturanap').last().closest('.waktu-ri').find('.cb-waktu[data-val="'+val+'"]'));
                            console.log('cek val: '+val);

                            $('.wakturanap').last().closest('.waktu-ri').find('.cb-waktu[data-val="'+val+'"]').prop('checked', 'checked');

                        });
                    }
                // }, 1500);
                } else {
                    // setTimeout(() => {
                    $('.waktu-ri').addClass('hide');
                    $('.wakturanap').last().val('');

                // }, 1500);
            }
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }else{
        myAlert("Silakan pilih obat / alkes terlebih dahulu!");
    }
    $("#namaObatRacik").focus();
	setTombolRacikanBaru();
}

function addDataKeGridObat(obj,tipe,rke){
    if(tipe=='racik'){
        // var signa = $(obj).parents('#form-racikan').find('#signa').val();
        var signa_a = $(obj).parents('#form-racikan').find('#signa_a').val();
        var signa_b = $(obj).parents('#form-racikan').find('#signa_b').val();
        var signa = signa_a + ' x ' + signa_b;
        var dosis = $(obj).parents('#form-racikan').find(".dosis").val();
        var etiketwaktu = $(obj).parents('#form-racikan').find(".etiketwaktu").val();
        var obatalkes_id = $(obj).parents('#form-racikan').find('#obatalkes_id').val();
        // var signa = $(obj).parents('#form-racikan').find('#signaracikan').val();
		var iterRacik = $('#iter').val();
        var permintaan = $(obj).parents('#form-racikan').find('#permintaan').val();
        var kemasan = $(obj).parents('#form-racikan').find('#jmlKemasanObat').val();
        var kekuatan = $(obj).parents('#form-racikan').find('#kekuatanObat').val();
        var etiket = $(obj).parents('#form-racikan').find('#etiketracikan').val();
        // var etiket = setEtiket($(obj).parents('#form-nonracikan').find('#etiketnonracikan1').val(), $(obj).parents('#form-nonracikan').find('#etiketnonracikan2').val(), $(obj).parents('#form-nonracikan').find('#etiketnonracikan3').val(), $(obj).parents('#form-nonracikan').find('#etiketnonracikan4').val());
        var satuansediaan = $(obj).parents('#form-racikan').find('#satuansediaan').val();
        var input_signa = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][signa_oa]"]');
        var etiket = setEtiket(signa, satuansediaan, etiketwaktu, "");
        input_signa.val(signa);
        var input_permintaan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][permintaan_oa]"]');
        input_permintaan.val(permintaan);
        var input_kemasan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][jmlkemasan_oa]"]');
        input_kemasan.val(kemasan);
        var input_kekuatan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][kekuatan_oa]"]');
        input_kekuatan.val(kekuatan);
		var input_iter = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][iter]"]');
        input_iter.val(iterRacik);
		var input_etiket = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][etiket]"]');
        input_etiket.val(etiket);
		var input_satuansediaan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][satuansediaan]"]');
        input_satuansediaan.val(satuansediaan);

        var input_rke = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][rke]"]');
        input_rke.val(rke);
        var input_etiket = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][etiket]"]');
        // console.log(input_etiket);
        input_etiket.val(etiket);
    }else{
        var signa = $(obj).parents('#form-nonracikan').find('#signa').val();
        var dosis = $(obj).parents('#form-nonracikan').find(".dosis").val();
        var sediaan = $('#sediaanobatnonracikan').val();
        var etiketwaktu = $(obj).parents('#form-nonracikan').find(".etiketwaktu").val();
        var obatalkes_id = $(obj).parents('#form-nonracikan').find('#obatalkes_id').val();
        var signa = $(obj).parents('#form-nonracikan').find('#signa').val();
		var iterNonRacik = $('#iter').val();
        var etiketnon1 = $(obj).parents('#form-nonracikan').find('#etiketnonracikan1').val();
        var etiketnon2 = $(obj).parents('#form-nonracikan').find('#etiketnonracikan2').val();
        var etiketnon3 = $(obj).parents('#form-nonracikan').find('#etiketnonracikan3').val();
        var etiketnon4 = $(obj).parents('#form-nonracikan').find('#etiketnonracikan4').val();
        var etiket = setEtiket(signa, sediaan, etiketwaktu, "");
           
        if(etiketnon1 =='null' || etiketnon1 == '' || etiketnon1 == undefined){
            etiketnon1 = "";
        }
        if(etiketnon2 =='null' || etiketnon2 == '' || etiketnon2 == undefined){
            etiketnon2 = "";
        }
        if(etiketnon3 =='null' || etiketnon3 == '' || etiketnon3 == undefined){
            etiketnon3 = "";
        }
        if(etiketnon4 =='null' || etiketnon4 == '' || etiketnon4 == undefined){
            etiketnon4 = "";
        }
	// var etiket = setEtiket(etiketnon1, etiketnon2, etiketnon3, etiketnon4); 

        var input_signa = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][signa_oa]"]');
        input_signa.val(signa);
		var input_iter = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][iter]"]');
        input_iter.val(iterNonRacik);
        var input_etiket = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][etiket]"]');
        input_etiket.val(etiket);

        var input_rke = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][rke]"]');
        input_rke.val(rke);

        var input_etiket = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][etiket]"]');
        // console.log(input_etiket);
        input_etiket.val(etiket);

        console.log(obatalkes_id, signa, iterNonRacik, etiket, input_signa, input_iter, input_rke, 'test');

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
            /*
            if(obatalkesyangsama.val()){ //jika ada obat sudah ada di table
                myConfirm("Apakah anda akan input ulang obat ini?","Perhatian!",
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
            */
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
            if($(this).attr("name") !== undefined) {
                var old_name = $(this).attr("name").replace(/]/g,"");
                var old_name_arr = old_name.split("[");
                if(old_name_arr.length == 3){
                    $(this).attr("name","["+row+"]["+old_name_arr[2]+"]");
                }
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
 * set form info pasien
 * @returns {undefined}
 */
function setInfoPasien(pendaftaran_id, no_pendaftaran, no_rekam_medik, pasienadmisi_id){
    $("#form-infopasien > div").addClass("animation-loading");
    var instalasi_id = $("#instalasi_id").val();
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetDataInfoPasien'); ?>',
        data: {instalasi_id:instalasi_id, pendaftaran_id:pendaftaran_id, no_pendaftaran:no_pendaftaran, no_rekam_medik:no_rekam_medik, pasienadmisi_id:pasienadmisi_id},
        dataType: "json",
        success:function(data){
			// if (data.lanjut_transaksi == true){
			// 	alert("Tagihan Pasien Sudah Dilunaskan. Anda tidak dapat melakukan Penjualan Resep pada Pasien Ini.");
			// 	setInfoPasienReset();
			// 	$("#form-infopasien > div").removeClass("animation-loading");
			// 	$("#instalasi_id").focus();
			// 	return false;
			// }
            console.log(data);
            $("#cari_pendaftaran_id").val(data.pendaftaran_id);
            $("#pendaftaran_id").val(data.pendaftaran_id);
            $("#pasien_id").val(data.pasien_id);
            $("#pasienadmisi_id").val(data.pasienadmisi_id);
            $("#jeniskasuspenyakit_id").val(data.jeniskasuspenyakit_id);
            $("#carabayar_id").val(data.carabayar_id);
            $("#penjamin_id").val(data.penjamin_id);
            $("#penanggungjawab_id").val(data.penanggungjawab_id);
            $("#kelaspelayanan_id").val(data.kelaspelayanan_id);
            $("#ruangan_id").val(data.ruangan_id);
            $("#no_pendaftaran").val(data.no_pendaftaran);
            $("#tgl_pendaftaran").val(data.tgl_pendaftaran);
            $("#ruangan_nama").val(data.ruangan_nama);
            $("#jeniskasuspenyakit_nama").val(data.jeniskasuspenyakit_nama);
            $("#carabayar_nama").val(data.carabayar_nama);
            $("#penjamin_nama").val(data.penjamin_nama);
            $("#no_rekam_medik").val(data.no_rekam_medik);
            $("#namadepan").val(data.namadepan);
            $("#nama_pasien").val(data.nama_pasien);
            $("#nama_bin").val(data.nama_bin);
            $("#tanggal_lahir").val(data.tanggal_lahir);
            $("#umur").val(data.umur);
            $("#jeniskelamin").val(data.jeniskelamin);
            $("#nama_pj").val(data.nama_pj);
            $("#pengantar").val(data.pengantar);
            $("#kelaspelayanan_nama").val(data.kelaspelayanan_nama);
            $("#alamat_pasien").val(data.alamat_pasien);
            $("#FAPenjualanResepT_pegawai_id").val(data.pegawai_id);
            $("#FAResepturT_dokter").val(data.nama_pegawai);
            $("#kamarruangan_nokamar").val(data.kamarruangan_nokamar);
            $("#kamarruangan_nobed").val(data.kamarruangan_nobed);
            $("#instalasi_id").val(data.instalasi_id);
            $("#nama_pegawai").val(data.nama_pegawai);

            if(data.photopasien === null || data.photopasien === ""){ //set photo
                $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
            }else{
                $('#photo-preview').attr('src','<?php echo Params::urlPasienTumbsDirectory()."kecil_"?>'+data.photopasien);
            }

            $("#form-infopasien > legend > .judul").html('Data Pasien '+data.no_pendaftaran+' ');
            $("#form-infopasien > legend > .tombol").attr('style','display:true;');
            $("#form-infopasien > .box").addClass("well").removeClass("box");

            $("#form-infopasien > div").removeClass("animation-loading");
            $("#nama_pasien").focus();


            $(".ruangandokter_id").val(data.ruangan_id);
            $.fn.yiiGridView.update("pegawaiYangMengajukan-m-grid", {data: $("#dialogDokter :input").serialize()});

            $('#table-obatalkespasien tbody').html(data.rowObat);

            admisi = $('#pasienadmisi_id').val();

            console.log('pasienadmisinya ada nggak? ' + (admisi != ''));

            if(admisi !== '') {
                setTimeout(() => {
                $('.waktu-ri').removeClass('hide');
                $('.waktu-ranap').last().val($('#waktuTemp').val());
            }, 500);
            } else {
                setTimeout(() => {
                $('.waktu-ri').addClass('hide');
            }, 500);
            }
           
            jQuery('.exp_date').datepicker(
                jQuery.extend({showMonthAfterYear: false},
                    jQuery.datepicker.regional['id'], {
                        'dateFormat': 'dd/mm/yy', 
                        'timeText': 'Waktu', 
                        'hourText': 'Jam',
                        'minuteText': 'Menit', 
                        'secondText': 'Detik', 
                        'showSecond': true, 
                        'timeOnlyTitle': 'Pilih   Waktu', 
                        'timeFormat': 'hh:mm:ss', 
                        'changeYear': true, 
                        'changeMonth': true, 
                        'showAnim': 'fold'
                    }
                )
            );
        },
        error: function (jqXHR, textStatus, errorThrown) {
            myAlert("Data kunjungan tidak ditemukan !");
            console.log(errorThrown);
            setInfoPasienReset();
            $("#form-infopasien > div").removeClass("animation-loading");
            $("#instalasi_id").focus();
        }
    });
}
/**
 * reset form info pasien
 * @returns {undefined}
 */
function setInfoPasienReset(){
    $("#cari_pendaftaran_id").val("");
    $("#pendaftaran_id").val("");
    $("#pasien_id").val("");
    $("#pasienadmisi_id").val("");
    $("#jeniskasuspenyakit_id").val("");
    $("#carabayar_id").val("");
    $("#penjamin_id").val("");
    $("#penanggungjawab_id").val("");
    $("#kelaspelayanan_id").val("");
    $("#ruangan_id").val("");
    $("#no_pendaftaran").val("");
    $("#tgl_pendaftaran").val("");
    $("#ruangan_nama").val("");
    $("#nama_pegawai").val("");
    $("#jeniskasuspenyakit_nama").val("");
    $("#carabayar_nama").val("");
    $("#penjamin_nama").val("");
    $("#no_rekam_medik").val("");
    $("#namadepan").val("");
    $("#nama_pasien").val("");
    $("#nama_bin").val("");
    $("#tanggal_lahir").val("");
    $("#umur").val("");
    $("#jeniskelamin").val("");
    $("#nama_pj").val("");
    $("#pengantar").val("");
    $("#kelaspelayanan_nama").val("");
    $("#alamat_pasien").val("");
    $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
    $("#form-infopasien > legend > .judul").html('Data Pasien');
    $("#form-infopasien > legend > .tombol").attr('style','display:none;');
    $("#form-infopasien > .well").addClass("box").removeClass("well");
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
    myConfirm("Apakah anda akan membatalkan penjualan obat alkes ini?","Perhatian!",
    function(r){
        if(r){
           
            $(obj).parents('tr').detach();
            hitungTotal();
        }
    });
}
//TIDAK DIGUNAKAN ?
function hitungSubTotal(obj){
    unformatNumberSemua();
    harga = parseFloat($(obj).parents('tr').find('input[name$="[hargasatuan_oa]"]').val());
    qty = parseFloat($(obj).parents('tr').find('input[name$="[qty_oa]"]').val());
    diskon = parseFloat($(obj).parents('tr').find('input[name$="[discount]"]').val());

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
    obj_totalharganetto =  $('#<?php echo CHtml::activeId($modPenjualan,"totharganetto") ?>');
    obj_totalhargajual =  $('#<?php echo CHtml::activeId($modPenjualan,"totalhargajual") ?>');
    // var jasapelayanan_farmasi = parseFloat($('input[name*="[jasapelayanan_farmasi]"]').val());
    // if (isNaN(jasapelayanan_farmasi)) {
    //         jasapelayanan_farmasi = 0;
    //     }
    totalharganetto = 0;
    totalhargajual = 0;
    var totaldiskon = 0;
    var totalppn = 0;
    var total_adm = 0;
    var total_jasafarmasi = 0;
    var totalkeseluruhan = 0;
    var totalrke = 0;
    var cekrke = [];
    var row_racikan_1 = 0;

    $('#table-obatalkespasien > tbody > tr').each(function(){
        var ppnpersen = parseFloat($(this).find('input[name*="[ppnpersen]"]').val());
        var hargasatuan = parseFloat($(this).find('input[name*="[hargasatuan_oa]"]').val());
        var qty = parseFloat(unformatNumber($(this).find('input[name*="[qty_oa]"]').val()));
        var jasafarmasi = parseFloat(unformatNumber($(this).find('input[name*="[jasapelayanan_farmasi]"]').val()));
        var persenDiskon = parseFloat($(this).find('input[name*="[persen_discount]"]').val());
        var biayaadministrasi = parseFloat($(this).find('input[name*="[biayaadministrasi]"]').val());
        var totalembalase = parseFloat($(this).find('input[name*="[total_embalase]"]').val());
        var racikan_id = parseFloat($(this).find('input[name*="[racikan_id]"]').val());
        var admracikan = parseFloat($('#FAResepturT_admracikan').val());
        var administrasi = parseFloat($('#FAResepturT_administrasi').val());
        var rke = parseFloat($(this).find('input[name*="[rke]"]').val());

        if(racikan_id == 1 && !cekrke.includes(rke)){
            row_racikan_1 ++;
            cekrke.push(rke);

        }

        console.log('rke= '+row_racikan_1);
        console.log('rke= '+cekrke);
        console.log('administrasi= '+administrasi);
        console.log('racikan_id= '+racikan_id);

        if (isNaN(totalembalase)) {
            totalembalase = 0;
        }

        if (isNaN(persenDiskon)) {
            persenDiskon = 0;
        }

        if (isNaN(jasafarmasi)) {
            jasafarmasi = 0;
        }

        if(Math.ceil(persenDiskon) > 100){
          myAlert('Diskon (%) Lebih dari 100%');
          persenDiskon = 0;
          $(this).find('input[name*="[persen_discount]"]').val(0);
        }

        if (ppnpersen > 100){
          myAlert('PPN (%) tidak boleh melebihi 100%');
          $(this).find('input[name*="[ppnpersen]"]').val(0);
          return false;
        }
        var jmlqty = 0;
        if (racikan_id==1){
                jmlqty = (hargasatuan * qty);
                totalrke = admracikan * row_racikan_1;
            }

        if (racikan_id==2){
            jmlqty = (hargasatuan * qty) + administrasi;
            totalrke = totalrke
        }
        
        if (jmlqty > 0){
           jmlqty = parseFloat(jmlqty.toFixed(2));
       }

       var jml_totaladministrasi = (biayaadministrasi * qty);
        if (jml_totaladministrasi > 0){
            jml_totaladministrasi = parseFloat(jml_totaladministrasi.toFixed(2));
       }

       var jmldiskon = (((jmlqty + jml_totaladministrasi) * persenDiskon)/100);
       if (jmldiskon > 0){
          jmldiskon = parseFloat(jmldiskon.toFixed(2));
        }

        var jmlppn = ((((jmlqty + jml_totaladministrasi) - jmldiskon) * ppnpersen)/100);
        if (jmlppn > 0){
           jmlppn = parseFloat(jmlppn.toFixed(2));
       }

         var subtotal = ((jmlqty + jml_totaladministrasi) - jmldiskon) + jmlppn + totalembalase;
         if (subtotal > 0){
              subtotal = parseFloat(subtotal.toFixed(2));
         }

         $(this).find('input[name*="[jumlahppn]"]').val(jmlppn);
         $(this).find('input[name*="[hargajual_oa]"]').val(subtotal);
         $(this).find('input[name*="[discount]"]').val(jmldiskon);
         $(this).find('input[name*="[totalbiayaadministrasi]"]').val(jml_totaladministrasi);

       

        totalharganetto += parseFloat( $(this).find('input[name*="[harganetto_oa]"]').val() * $(this).find('input[name*="[qty_oa]"]').val() );
        // totalhargajual = totalhargajual + jasapelayanan_farmasi + subtotal;
        totalhargajual += subtotal;
        totaldiskon += jmldiskon;
        totalppn += jmlppn;
        total_adm += jml_totaladministrasi;
        total_jasafarmasi += jasafarmasi;

      
        totalkeseluruhan = (totalhargajual + total_jasafarmasi + totalrke);
        
    });

    obj_totalharganetto.val(totalharganetto);
    obj_totalhargajual.val(totalkeseluruhan);
    $('#KonfigfarmasiK_admracikan').val(totalrke);
    $('#totalkeseluruhanoa').val(totalkeseluruhan);
    $('#totaljual').val(totalhargajual);

    $('#<?php echo CHtml::activeId($modPenjualan, 'discount'); ?>').val(totaldiskon);
    $('#<?php echo CHtml::activeId($modPenjualan, "totalppn"); ?>').val(totalppn);
    $('#<?php echo CHtml::activeId($modPenjualan, "biayaadministrasi"); ?>').val(total_adm);
    $('#<?php echo CHtml::activeId($modPenjualan, "jasapelayanan_farmasi"); ?>').val(total_jasafarmasi);

    formatNumberSemua();
}

function hitungPersenDiskon() {
  unformatNumberSemua();

  $('#table-obatalkespasien > tbody > tr').each(function(){
      var hargasatuan = parseFloat($(this).find('input[name*="[hargasatuan_oa]"]').val());
      var qty = parseFloat($(this).find('input[name*="[qty_oa]"]').val());
      var jmldiscount = parseFloat($(this).find('input[name*="[discount]"]').val());
      var totalbiayaadministrasi = parseFloat($(this).find('input[name*="[totalbiayaadministrasi]"]').val());

      var jmlqty = (hargasatuan * qty);
      if (jmlqty > 0){
         jmlqty = parseFloat(jmlqty.toFixed(2));
     }

      var diskoPersen = 0;

      diskoPersen =((jmldiscount/(jmlqty + totalbiayaadministrasi))*100);
      if (diskoPersen > 0){
           diskoPersen = parseFloat(diskoPersen.toFixed(2));
       }

       if(Math.ceil(diskoPersen) > 100){
         myAlert('Keringanan (%) Lebih dari 100%');
         diskoPersen = 0;
       }

       $(this).find('input[name*="[persen_discount]"]').val(diskoPersen);
  });
  formatNumberSemua();
  hitungTotal();
}

/**
 * class integer2 di unformat
 * @returns {undefined}
 */
// function unformatNumberSemua(){
//     $(".integer2").each(function(){
//         $(this).val(parseInt(unformatNumber($(this).val())));
//     });
// }
/**
 * class integer2 di format kembali
 * @returns {undefined}
 */
// function formatNumberSemua(){
//     $(".integer2").each(function(){
//         $(this).val(formatInteger($(this).val()));
//     });
// }

/**
* untuk print penjualan dokter
 */
function print(caraPrint)
{
    var penjualanresep_id = '<?php echo isset($modPenjualan->penjualanresep_id) ? $modPenjualan->penjualanresep_id : null ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&penjualanresep_id='+penjualanresep_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
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
        var is_cukup = true;
        var is_nol = false;

        $("#table-obatalkespasien tbody tr").each(function() {
            $(this).removeClass("yellow");

            var qty = parseFloat(unformatNumber($(this).find(".qty_jual").val()));
            var stok = parseFloat(unformatNumber($(this).find(".qty_stok").val()));

            // console.log(qty, stok);
            /*
            if (qty == 0) {
                $(this).addClass("yellow");
                is_nol = true;
            }
        */

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
 * ubah takaran resep
 * @returns {undefined}
 */
function ubahTakaranResep(obj){
	var takaran = $(obj).val();
	var takarantext = $(obj).find("[value='"+takaran+"']").text();
	myConfirm('Proses perhitungan takaran resep hanya bisa dilakukan satu kali. Apakah anda ingin mengubah takaran semua obat menjadi '+takarantext+' dari resep?', 'Perhatian!', function(r){
		if(r){
			proporsiTakaranResep(takaran);
			$(obj).attr('readonly',true);
			$(obj).click(function(){
				$('#<?php echo CHtml::activeId($modPenjualan,"totalhargajual") ?>').focus();
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


function terapiobat_reset(){
	$("#form-nonracikan").addClass("animation-loading");
	var ruangantujuan_id = $('#ruanganapotek_id').val();
		$('#therapiobat_id').val('');
		$('#therapiobat_nama').val('');
		$('#FAObatAlkesM_therapiobat_id').val('');
		clearInputan();
		$('#ruanganapotek_id').val($('#<?php echo CHtml::activeId($modReseptur,"ruangan_id") ?>').val());
	setTimeout(function(){
		$("#form-nonracikan").removeClass("animation-loading");
	},500);
}

function clearInputan()
{
    $('#obatalkes_id').val('');
    $('#obatalkes_kode').val('');
    $('#ruanganapotek_id').val('');
    $('#namaObatNonRacik').val('');
	$('#therapiobat_id2').val('');
}

// function untuk men set dialog oa agar berelasi dengan therapiobatmap_m
function setOAJoinTerapi(){
	var therapiobat_id = $('#therapiobat_id').val();
	$("#namaObatNonRacik").addClass("animation-loading-1");
		$.fn.yiiGridView.update('obatAlkesDialog-m-grid', {
			data: {
				"FAObatAlkesM[therapiobat_id]":therapiobat_id,
			}
		});
	setTimeout(function(){
		$("#namaObatNonRacik").removeClass("animation-loading-1");
	},500);
}

$('#tombolDialogOa').click(function(){
	var therapiobat_id = $('#therapiobat_id').val();
	$.fn.yiiGridView.update('obatAlkesDialog-m-grid', {
		data: {
			"FAObatalkesM[therapiobat_id]":therapiobat_id,
		}
	});
});
function setThreapiobat_id(obatalkes_id){
	$.ajax({
		type:'POST',
		url:'<?php echo $this->createUrl('setTherapiobatid'); ?>',
		data: {obatalkes_id : obatalkes_id},//
		dataType: "json",
		success:function(data){
			if(data){
				$("#therapiobat_id2").val(data);
			}
		},
		error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	});
}

function formjenisresep(jenisresep){
	$(".formjenisresep").addClass("animation-loading");
	setTimeout(function(){
		if(jenisresep==1){
			$("#form-nonracikan").hide();
			$("#form-racikan").show();
		}else{
			$("#form-nonracikan").show();
			$("#form-racikan").hide();
		}

        $('#waktu').find('br').replaceWith("<span style='padding-left:20px;'>.</span>");
        $('#waktu_racikan').find('br').replaceWith("<span style='padding-left:20px;'>.</span>");

		$(".formjenisresep").removeClass("animation-loading");
	},500);
}

function hitungJumlahObat(){
	$("#qtyRacik").addClass("animation-loading-1");
	var jmlkemasanobat = parseFloat(unformatNumber($('#jmlKemasanObat').val()));
	var permintaan = parseFloat(unformatNumber($('#permintaan').val()));
	var kekuatanobat = parseFloat(unformatNumber($('#kekuatanObat').val()));
	setTimeout(function(){
		if((jmlkemasanobat != '')&&(permintaan != '')&&(kekuatanobat != '')){
                var jmlobat = permintaan*jmlkemasanobat/kekuatanobat;
                $("#tomboltambahracikan").attr("disabled",false);
        }else{
                var jmlobat = 0;
                // $("#tomboltambahracikan").attr("disabled",true);
        }
        $("#qtyRacik").val(formatFloat(jmlobat));
		$("#qtyRacik").removeClass("animation-loading-1");
	},500);
}

function setTombolRacikanBaru(){
	$("#formanak").addClass("animation-loading-1");
	setTimeout(function(){
		$("#tombolracikanbaru").attr('disabled',false);
		$("#racikanKe").attr('disabled',true);
		$("#signaracikan").attr('disabled',true);
		$("#etiketracikan").attr('disabled',true);
		$("#jmlKemasanObat").attr('disabled',true);
		$("#satuansediaan").attr('disabled',true);
		$("#permintaan").val('');
		$("#kekuatanObat").val('');
		hitungJumlahObat();
		$("#formanak").removeClass("animation-loading-1");
	},500);
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
        $("#signaracikan").val("");
        $("#dosisracik").val("");
        $("#etiketwakturacik").val("");
        $("#keteranganracik").val("");
		$("#jmlKemasanObat").val('');
		$("#permintaan").val('');
		$("#kekuatanObat").val('');
		hitungJumlahObat();
		setDropDownRke();
		$("#formanak").removeClass("animation-loading-1");
	},500);
}

function setDropDownRke(){
	var rmax = $("#table-obatalkespasien tbody tr:last-child td").find('input[name*="[rke]"]').val();
	$.ajax({
		type:'POST',
		url:'<?php echo $this->createUrl('SetDropdownRke'); ?>',
		data: {rmax : rmax++},//
		dataType: "json",
		success:function(data){
			$('#racikanKe').html(data);
		},
		error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	});
}

function hitungPecahanDosisRacikan() {
    var pembilang = $("#dosis_pembliang").val();
    var penyebut = $("#dosis_penyebut").val();
    var kekuatan = $("#kekuatanObat").val();
    var hasil = 0;

    if (penyebut == 0) {
        myAlert("Penyebut tidak boleh 0.");
        return false;
    }

    if (kekuatan.trim() == "") {
        myAlert("Kekuatan obat belum ada.");
        return false;
    }

    hasil = Math.round((pembilang / penyebut) * kekuatan * 100) / 100;

    $("#dosis_pembliang").val("");
    $("#dosis_penyebut").val("");

    $("#permintaan").val(formatFloat(hasil));
    $("#dialogPecahanDosis").dialog("close");
    hitungJumlahObat();
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
<?php if($this->id == "penjualanResepRS"){ ?>
function changeKronisObat(obj){
    if($(obj).prop('checked') == true){
        $('#form-nonracikan').find('#formulaobatkronis_id').attr('disabled',false);
    }else{
        $('#form-nonracikan').find('#formulaobatkronis_id').val('');
        $('#form-nonracikan').find('#formulaobatkronis_id').attr('disabled',true);
    }
}
<?php } ?>

function setFormulaobat(){
    var value =  $('#form-nonracikan').find('#qtyNonRacik').val();
    $("#qty").val(value);
    <?php if($this->id == "penjualanResepRS"){ ?>
        if($('#form-nonracikan').find('#formulaobatkronis_id').prop('disabled') == false){
            var nilai = '';
            $('#form-nonracikan').find('#formulaobatkronis_id').find('option').each(function(){
                var dataoption = $(this).data('jumlahobat');

                if(dataoption != undefined){
                    if(dataoption == value){
                        nilai = $(this).val();
                    }
                }
                
            });
            $('#form-nonracikan').find('#formulaobatkronis_id').val(nilai);
        }else{
            $('#form-nonracikan').find('#formulaobatkronis_id').val('');
        }
    <?php } ?>
}


function setSediaanRacikan(){
    var nominal = $('#form-racikan').find('#satuansediaan').val();
    var text = $('#form-racikan').find('#satuansediaan :selected').text();
    var jmlkemasan = $('#form-racikan').find('#jmlKemasanObat').val();

    if(nominal != ''){
        $('#form-racikan').find('#satuansediaan_text').val(text);
        $('#form-racikan').find('#tarifembalase').val(formatThousandDecimal(nominal * jmlkemasan));
    }
}

/**
 * function ini harus tetap berada di bawah
 * penambahan local storage untuk menampung nilai detiknya 
 * ketika dia refresh atau back menu lain detik akan terus berjalan
 * set null kembali setelah dia berhasil untuk di simpan
 */
var seconds = 0;
window.onbeforeunload= function(){
     localStorage.setItem("lastTime", seconds);
}
$(document).ready(function(){
    console.log('hdfhdfjdf');
    jQuery('.exp_date').datepicker(
        jQuery.extend({showMonthAfterYear: false},
            jQuery.datepicker.regional['id'], {
                'dateFormat': 'dd/mm/yy', 
                'timeText': 'Waktu', 
                'hourText': 'Jam',
                'minuteText': 'Menit', 
                'secondText': 'Detik', 
                'showSecond': true, 
                'timeOnlyTitle': 'Pilih   Waktu', 
                'timeFormat': 'hh:mm:ss', 
                'changeYear': true, 
                'changeMonth': true, 
                'showAnim': 'fold'
            }
        )
    );
    <?php if($this->id == "penjualanResepRS"){ ?>
    changeKronisObat($('#form-nonracikan').find('.is_kronis'));
    <?php } ?>

    renameInputRowObatAlkes($("#table-obatalkespasien"));
    hitungTotal();
    savedTime = localStorage.getItem("lastTime");
    if(savedTime && savedTime > 0){
        seconds = savedTime;
    }
    setInterval(function()
    {
        seconds++;
        if(seconds >= 999999) {
            seconds = 0;
        }
        $('#<?php echo CHtml::activeId($modPenjualan,"lamapelayanan") ?>').val(seconds);
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
        setNull();
    <?php } ?>

    // Notifikasi Pasien
    <?php
        if(isset($_GET['smspasien'])){
            if($_GET['smspasien']==0){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PASIEN', isinotifikasi:'Pasien <?php echo $modPenjualan->pasien->nama_pasien; ?> tidak memiliki nomor mobile'}; // 16
        insert_notifikasi(params);
    <?php
            }
        }
    ?>
	formjenisresep(0); // load awal form non racikan yang dimunculkan
});

//Penambahan untuk di set value nya menjadi 0 kembali
function setNull(){
    localStorage.setItem("lastTime", 0);
    seconds = 0;
}
// function cekInput(){
//     var kosong = 0;
//     if($('#pendaftaran_id').val()==''){
//         myAlert('Input data pasien terlebih dahulu');
//         kosong++;
//     }
//     if($('#<?php // echo CHtml::activeId($modPenjualan,"pegawai_id");?>').val()==''){
//         myAlert('Input data dokter reseptur terlebih dahulu');
//         kosong++;
//     }
//     if(kosong>0){
//         return false;
//     }else{
//         return true;
//     }
// }
function printTindakan(caraPrint) {
    var penjualanresep_id = '<?php echo isset($modPenjualan->penjualanresep_id) ? $modPenjualan->penjualanresep_id : null ?>';
    window.open('<?php echo $this->createUrl('/farmasiApotek/penjualanDariReseptur/PrintTindakan'); ?>&racikan=0&penjualanresep_id=' + penjualanresep_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
}
function printetiket(caraPrint) {
            var penjualanresep_id = '<?php echo isset($modPenjualan->penjualanresep_id) ? $modPenjualan->penjualanresep_id : null ?>';
            window.open('<?php echo $this->createUrl('printEtiket'); ?>&racikan=0&penjualanresep_id=' + penjualanresep_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
}
function printetiketRacikan(caraPrint) {
     var penjualanresep_id = '<?php echo isset($modPenjualan->penjualanresep_id) ? $modPenjualan->penjualanresep_id : null ?>';
     window.open('<?php echo $this->createUrl('printEtiket'); ?>&racikan=1&penjualanresep_id=' + penjualanresep_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
}
function printetiketRanap(caraPrint) {
    var penjualanresep_id = '<?php echo isset($_GET['penjualanresep_id']) ? $_GET['penjualanresep_id'] : null ?>';
    window.open('<?php echo $this->createUrl('/farmasiApotek/penjualanDariReseptur/printEtiketRanapNew'); ?>&penjualanresep_id=' + penjualanresep_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
}

function printNotaPenjualan(caraPrint) {
    var penjualanresep_id = '<?php echo isset($_GET['penjualanresep_id']) ? $_GET['penjualanresep_id'] : null ?>';
    window.open('<?php echo $this->createUrl('/farmasiApotek/penjualanDariReseptur/printNotaPenjualan'); ?>&penjualanresep_id=' + penjualanresep_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
}

function printTelaah(caraPrint) {
    var penjualanresep_id = '<?php echo isset($_GET['penjualanresep_id']) ? $_GET['penjualanresep_id'] : null ?>';
    window.open('<?php echo $this->createUrl('/farmasiApotek/penjualanResepRS/printTelaah'); ?>&penjualanresep_id=' + penjualanresep_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
}

$('.cb-waktu').change(function() {

    var tempWaktu = [];

    $(this).closest('td').find('.cb-waktu').each(function() {
        if($(this).is(':checked')) {
            tempWaktu.push($(this).val());
        }
    });

    $(this).closest('td').find('.wakturanap').val(tempWaktu.join(', '));
});


function waktu(obj) {

    console.log('ke fungsi waktu');
       var tempWaktu = [];

   $('#waktu').find('input').each(function() {
        if($(this).is(':checked')) {
            tempWaktu.push($(this).val());
        }
   });
   $('#tempWaktu').val(tempWaktu.join(', '));
   
}

function waktuRacikan(obj) {

console.log('ke fungsi waktu');
   var tempWaktu = [];

$('#waktu_racikan').find('input').each(function() {
    if($(this).is(':checked')) {
        tempWaktu.push($(this).val());
    }
});
$('#tempWaktuRacikan').val(tempWaktu.join(', '));

}
    
$(document).ready(function() {
    $('#waktu').find('br').replaceWith("<span style='padding-left:20px;'>.</span>");
});
</script>
