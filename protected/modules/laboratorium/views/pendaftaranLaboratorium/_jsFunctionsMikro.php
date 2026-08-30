<script>
function printRincianPenunjangBelumBayar() {
    // var instalasi_id = $("#instalasi_id").val();
    var pendaftaran_id = "<?= isset($_GET['id']) ? $_GET['id'] : 0 ?>";
    //if(instalasi_id && pendaftaran_id){
    window.open("<?php echo $this->createUrl('PrintRincianBelumBayar') ?>&pendaftaran_id=" + pendaftaran_id, "",
        'location=_new, width=1024px');
    //}else{
    //    myAlert("Silakan cari data kunjungan terlabih dahulu!");
    //}
}


function setInputan(inp, obj, pendaftaran_id) {

    var jml = $("#tabelBahan tbody").find('tr').length;
    var jns = $('#jenispermintaan').val();
    var jns_low = jns;

    if (jns == 'non') { 
        jns == 'non program';
    }

    if (jml > 0) {
        myAlert("Simpan Order permintaan " + jns.toUpperCase() + " terlebih dahulu");

        $('.jenispermintaan').prop("checked", false);
        $('.jenispermintaan[value="' + jns_low + '"]').prop("checked", true);

    } else {

        if (inp === 'non') {
            $('.panel-non').find('input, select, textarea').removeAttr('disabled');
            $('.panel-tbc').find('input, select, textarea').attr('disabled', true);
            $('.panel-hiv').find('input, select, textarea').attr('disabled', true);
            $('.panel-non').removeClass('hide');
            $('.panel-tbc').addClass('hide');
            $('.panel-hiv').addClass('hide');
        } else if (inp === 'tbc') {
            $('.panel-tbc').find('input, select, textarea').removeAttr('disabled');
            $('.panel-non').find('input, select, textarea').attr('disabled', true);
            $('.panel-hiv').find('input, select, textarea').attr('disabled', true);
            $('.panel-tbc').removeClass('hide');
            $('.panel-non').addClass('hide');
            $('.panel-hiv').addClass('hide');
        } else if (inp === 'hiv') {
            $('.panel-hiv').find('input, select, textarea').removeAttr('disabled');
            $('.panel-non').find('input, select, textarea').attr('disabled', true);
            $('.panel-tbc').find('input, select, textarea').attr('disabled', true);
            $('.panel-hiv').removeClass('hide');
            $('.panel-non').addClass('hide');
            $('.panel-tbc').addClass('hide');
        }

        $('#RJPasienKirimKeUnitLainT_samplelab_id').closest('.multiselect-native-select').find(
            'input[type="radio"][value=""]').click();
        $('#jenispermintaan').val(inp);
        $('#loadSpesimen').removeClass('hide');

        setBahan(obj, pendaftaran_id);

    }
}

    $('.jenispermintaan').click(function() {
        $('.jenispermintaan').prop('checked', false);
        $(this).prop('checked', true);
    });


    function setBahan(obj, pendaftaran_id){
        var periksabahan_nama = $("#periksabahan").val();
        var subjenis_pemeriksaanlab_id = $(".form_subjenis_pemeriksaanlab_id").val();
        var samplelab = $('.samplelab').val();
        var jenispermintaan = $('#jenispermintaan').val();
        var count = 0;

        console.log("jenisnya: " + jenispermintaan);


        $("#loadSpesimen").addClass("animation-loading");

        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('/rawatJalan/mikrobiologiKlinik/loadBahanSpesimen'); ?>',
            data: {
                periksabahan: periksabahan_nama,
                subjenis_pemeriksaanlab_id: subjenis_pemeriksaanlab_id,
                samplelab: samplelab,
                jenispermintaan: jenispermintaan,
                pendaftaran_id: pendaftaran_id
            },
            dataType: "json",
            success:function(data){
                if (data.sukses == 1){
                    $("#loadSpesimen").html(data.html);
                }else{
                    myAlert(data.pesan);
                }
                $("#loadSpesimen").removeClass("animation-loading");
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        }); 
    }

    function inputBahanJenis(obj) {

if($(obj).is(':checked')) {

    $(obj).closest('.boxtindakan').find('.cekPemeriksaan:not(:checked)').trigger('click');
    // $(obj).prop('checked', 'checked');
    console.log('jenis tercek');
} else {
    // $(obj).prop('checked', false);
    console.log('jenis nggak tercek');

    myConfirm("Apakah anda akan membatalkan pemeriksaan ini?","Perhatian!",function(r) {
            if(r){

                $(obj).closest('.boxtindakan').find('.cekPemeriksaan:checked').each(function () {

                    var samplelab_id = $(this).closest('.base_input_ceklis').find('.samplelab_id').val();
                    var pemeriksaanlab_id = $(this).val();

                    console.log('sample: ' +  $(obj).closest('.base_input_ceklis'));
                    console.log('pemeriksaan: ' + pemeriksaanlab_id);

                    batalBahan(pemeriksaanlab_id, samplelab_id);

                    $(this).prop('checked', false);
                });

                toastr.success("Pemeriksaan berhasil dibatalkan", "Perhatian!");
            }
        });
}


}

function inputBahan(obj, pemeriksaanlab_id, samplelab_id, is_dialog = null) {

var sampleid = $('#LBPasienKirimKeUnitLainT_samplelab_id').val();
var jenispermintaan = $('#jenispermintaan').val();

console.log('sample iki jenenge ' + sampleid);
console.log('jenis iki jenenge ' + jenispermintaan);

console.log('ini dari jenis ---');
console.log('hello');
var catatan = $('.catatan').val();

if(sampleid == '' && jenispermintaan == 'non') {
    myAlert('Silahkan pilih sample lab terlebih dahulu');
    $(obj).prop('checked', false);
} else {
    if($(obj).is(':checked') || is_dialog == "ya") {
    var sample_id = obj.value;
    var lokasi = lokasi;
    var kode_unik = $(obj).parents(".base_input_ceklis").find(".periksa_kode_unik").val();
    var caraambilsampel_id = $("#LBPasienKirimKeUnitLainT_caraambilsampel_id").val();
    var jenispermintaan = $('#jenispermintaan').val();

    var kelaspelayanan_id = null;

    console.log('pemeriksaan_idne: ' + pemeriksaanlab_id);
    console.log('samplelab_idne: ' + samplelab_id);

    if(jenispermintaan == 'tbc') {
        samplelab_id = $('#sample_tbc').val();
    }

    if(jenispermintaan == 'hiv') {
        samplelab_id = $('#LBPermintaanPenunjangT_samplelab_id_hiv').val();
    }

    jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('/pendaftaranPenjadwalan/PendaftaranLaboratoriumMikrobiologiPP/loadTabelSpesimenMikro')?>',
            'data':{
                sample_id:sample_id, lokasi:lokasi, catatan:catatan, kode_unik:kode_unik,
                samplelab_id:samplelab_id, caraambilsampel_id:caraambilsampel_id, pemeriksaanlab_id:pemeriksaanlab_id, kelaspelayanan_id:kelaspelayanan_id
            },
            'type':'post',
            'dataType':'json',
            'success':function(data) {
                    // $('.samplelab').val(data.samplelab_id);
                    // $('.caraambilsample').val(data.caraambilsampel_id);
                    
                    var rowCount = document.getElementsByClassName("jumlahspesimen");
                    var count = rowCount.length;
                    var cito = $('#LBPasienKirimKeUnitLainT_is_cito').val();

                    console.log(count);
                    if (count == 0) {
                        if(jenispermintaan == 'non') {
                            jenispermintaan = 'non program';
                        }

                        jenispermintaan = jenispermintaan.toUpperCase();
                        jenispermintaan_prev = $('.jenispermintaan_row').last().val();


                        if(jenispermintaan == jenispermintaan_prev || typeof jenispermintaan_prev == "undefined") {
                            $('#tabelBahan > tbody').append(data.form);
                            $("#tabelBahan > tbody > tr:last .integer").maskMoney({"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0});
                            $('.integer').each(function(){this.value = formatNumber(this.value)});
                            
                            if(cito == 1) {
                                $('.cek-cito').last().prop("checked", "checked");
                            }

                            console.log('jenis permintaan: ' + jenispermintaan);

                            renameInputRow();


                            $('.cek-cito').last().change();
                            setTimeout(() => {
                                console.log('timeout jenis permintaan');
                                $('.jenispermintaan_row').last().val(jenispermintaan);
                            }, 500);
                        } else {
                            myAlert("Simpan Order permintaan " + jenispermintaan_prev +  " terlebih dahulu");
                            $(obj).closest('.accordion-inner').find('.ceklis-jenis').prop("checked", false);
                        }


                    } else {
                        toastr.error("Tidak bisa memilih lebih dari satu spesimen", "Perhatian!");
                        batalBahan(obj.value);
                        $(obj).attr('checked', false);
                    }
            } ,
            'cache':false});
        } else {

            setTimeout(() => {

                myConfirm("Apakah anda akan membatalkan pemeriksaan ini?","Perhatian!",function(r) {
                if(r){
                    batalBahan(pemeriksaanlab_id, samplelab_id);
                    toastr.success("Pemeriksaan berhasil dibatalkan", "Perhatian!");
                }else{
                    $(obj).attr('checked', 'checked');
                }
            });

            }, 1000);

        }
    }


}

function renameInputRow() {

    console.log('rename input iki');
    $('.tr-pemeriksaan').each(function(idx) {

        $(this).find('td').find('input, select, textarea').each(function() {
            
            var nama = $(this).attr('name');

            console.log("name" + nama);
            var nama_old = nama.replace("]", "");

            var nama_old_arr = nama_old.split("[");

            console.log("name arr: " + nama_old_arr);

            nama_old_arr[nama_old_arr.length - 1] = nama_old_arr[nama_old_arr.length - 1].replace("]", "");

            $(this).attr('name', nama_old_arr[0] + "[" + idx + "][" + nama_old_arr[nama_old_arr.length - 1] + "]");
            $(this).attr('id', nama_old_arr[0] + "_" + idx + "_" + nama_old_arr[nama_old_arr.length - 1]);

            console.log("nama ini adalah: " + $(this).attr('name'));
            console.log("id ini adalah: " + $(this).attr('id'));
        });

    });

    setTimeout(() => {
            // console.log('nomor: ' + no);
            $('.no-urut').each(function (idx) {
            $(this).val(parseInt(idx) + 1);
        });
    }, 2000);
}

function batalBahan(pemeriksaanlab_id, samplelab_id) {
    console.log('samplenya id: ' + samplelab_id);
	$('#tabelBahan #pemeriksaanSpesimen_'+pemeriksaanlab_id+'_'+samplelab_id).detach();
    $('.samplelab').val();
    $('.caraambilsample').val();
}


setTimeout(function(){
  $("#<?php echo CHtml::activeId($modKirimUnitLain, 'catatandokterpengirim') ?>").blur();
},500);


</script>