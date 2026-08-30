
<script type="text/javascript">
    $('#tab1-klinik').fadeIn(100);
    $('#tab1-anatomi').hide();
    
    function tab1(obj){
	var lab = obj.id;
	if(lab=='klinik'){
		$('#klinik').attr('class', 'active');
		$('#anatomi').removeAttr('class');
		$('#tab1-anatomi').fadeOut(100);
		$('#tab1-klinik').fadeIn(100);
	}else{
		$('#klinik').removeAttr('class');
		$('#anatomi').attr('class', 'active');
		$('#tab1-klinik').fadeOut(100);
		$('#tab1-anatomi').fadeIn(100);
	}
    }

    function cekAntibiotik(){        
        var inf = $("#RJPasienKirimKeUnitLainT_antibiotikygdiberi_tidakada");
        if (inf.is(":checked")) {
             $("#RJPasienKirimKeUnitLainT_antibiotikygdiberi").val('Tidak ada');
             $("#RJPasienKirimKeUnitLainT_antibiotik_hari").removeClass('required');
             $("#RJPasienKirimKeUnitLainT_antibiotikygdiberi, #RJPasienKirimKeUnitLainT_antibiotik_hari").parents(".control-group").find('.control-label').find('span.required').remove();
        } else {
             $("#RJPasienKirimKeUnitLainT_antibiotikygdiberi").val('');
             $("#RJPasienKirimKeUnitLainT_antibiotikygdiberi").addClass('required');
             $("#RJPasienKirimKeUnitLainT_antibiotik_hari").addClass('required');
             $("#RJPasienKirimKeUnitLainT_antibiotikygdiberi, #RJPasienKirimKeUnitLainT_antibiotik_hari").parents(".control-group").find('.control-label').append('<span class="required">*</span>');

        }
    }

    /**
     * 
     * @param {type} obj
     * @param {type} ruangan_id = klinik / anatomi
     * @returns {undefined}
     */

    function inputperiksanew() {
        var sample_id = 'empty';
        var samplelab_id = $('.samplelab').val();
        var caraambilsample_id = $('.caraambilsample').val();
        var catatan = $('.catatan').val()

        console.log(samplelab_id, caraambilsample_id, catatan);
        $('.cekList:checked').each(function(data, obj) {
            // console.log(obj);
            sample_id = obj.value;
            // ruangan_id = obj.value;
        });


        console.log(sample_id);

        if(sample_id != 'empty') {
            
            jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('rawatJalan/mikrobiologiKlinik/loadTabelSpesimen')?>',
                     'data':{sample_id:sample_id, samplelab_id:samplelab_id, caraambilsample_id:caraambilsample_id, catatan:catatan},
                     'type':'post',
                     'dataType':'json',
                     'success':function(data) {
                            // $('.samplelab').val(data.samplelab_id);
                            // $('.caraambilsample').val(data.caraambilsampel_id);
                            
                            var rowCount = document.getElementsByClassName("jumlahspesimen");
                            var count = rowCount.length;
                            console.log(count);
                            if (count == 0) {
                                $('#tabelBahan > tbody').append(data.form);
                                $("#tabelBahan > tbody > tr:last .integer").maskMoney({"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0});
                                $('.integer').each(function(){this.value = formatNumber(this.value)});
                            } else {
                                toastr.error("Tidak bisa memilih lebih dari satu spesimen", "Perhatian!");
                                // batalBahan(obj.value);
                                $('.cekList').removeAttr('checked');
                            }
                     } ,
                     'cache':false});
        } else {
            myAlert('Pilih Pemeriksaan terlebih Dahulu');
        }

    }

    function inputperiksa(obj, ruangan_id)
    {

        if($(obj).is(':checked')) {
            var pemeriksaanlab_id = obj.value;
            var kelaspelayanan_id = $('#<?php echo CHtml::activeId($modKirimKeUnitLain, 'kelaspelayanan_id') ?>').val();
            var pendaftaran_id = '<?php echo $modPendaftaran->pendaftaran_id; ?>';
            jQuery.ajax({'url':'<?php echo $this->createUrl(Yii::app()->controller->id . '/loadFormPemeriksaanLab') ?>',
                     'data':{pemeriksaanlab_id:pemeriksaanlab_id, kelaspelayanan_id:kelaspelayanan_id,pendaftaran_id:pendaftaran_id,ruangan_id:ruangan_id},
                     'type':'post',
                     'dataType':'json',
                     'success':function(data) {
                             if($.trim(data.form)=='')
                             {
                                $(obj).removeAttr('checked');
                                myAlert ('Pemeriksaan belum memilik tarif silahkan hubungi SIMRS untuk memeriksa tarif pemeriksaan tersebut');
                               // checkIni(obj);
                             } 
                             $('#tblFormPemeriksaanLab #trPeriksaLabKosong').detach();
                             $('#tblFormPemeriksaanLab > tbody').append(data.form);
                             $("#tblFormPemeriksaanLab > tbody > tr:last .integer").maskMoney({"defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0,"symbol":null});
                             $('.integer').each(function(){this.value = formatNumber(this.value)});
                             hitungTotal();

                                                            if(obj.value == '352')
                                                            {
                                                                            batalPeriksa('563');
                                                                            $('#formPeriksaLab').find('input[value="563"]').attr('checked', 'checked');
                                                                            $('#formPeriksaLab').find('input[value="563"]').attr('disabled', 'true');

                                                                            batalPeriksa('564');
                                                                            $('#formPeriksaLab').find('input[value="564"]').attr('checked', 'checked');
                                                                            $('#formPeriksaLab').find('input[value="564"]').attr('disabled', 'true');

                                                                            hitungTotal();

                                                            }
                                     } ,
                                     'cache':false});
            } else {

                    batalPeriksa(obj.value);
                    hitungTotal();
            }


    }
    
    function batalPeriksa(pemeriksaanlab_id) {
        $('#tblFormPemeriksaanLab #periksalab_'+pemeriksaanlab_id).detach();
    }

    function batalKirim(pasienkirimkeunitlain_id,pendaftaran_id) {
	myConfirm("Apakah anda akan membatalkan kirim pasien ke Laboratorium?","Perhatian!",function(r) {
		if(r){
			$.post('<?php echo $this->createUrl('ajaxBatalKirim') ?>', {pasienkirimkeunitlain_id: pasienkirimkeunitlain_id, pendaftaran_id:pendaftaran_id}, function(data){
				$('#tblListPemeriksaanLab').html(data.result);
				myAlert(data.pesan);
			}, 'json');
		}
	});
    }

    function hitungTotal(){
            var total = 0;
            $('.tarif_satuan').each(
                    function(){
                            qty = $(this).parents('tr').find('.gty').val();
                            total_harga = unformatNumber(this.value) * qty; 
                            total += total_harga;
                    }
            );

            $('#periksaTotal').val(formatNumber(total));  

            $("#<?php echo CHtml::activeId($modKirimKeUnitLain, 'catatandokterpengirim') ?>").blur();
    }

    function cekInput(){

        if (requiredCheck($("#rjpasien-laboratorium-t-form"))){                
            var deposit = $('#deposit').val();
            var periksaTotal = unformatNumber($('#periksaTotal').val());
            var tr = $("#tabelBahan > tbody > tr").length;

            if (tr > 0){            
                    $('#rjpasien-laboratorium-t-form').submit();

            }else{
                alert("Tindakan Laboratorium belum dipilih");
                return false;
            }        
        }

       return false;
    }

    function cariTarifLab(obj){    
        var pendaftaran_id = <?php echo $modPendaftaran->pendaftaran_id; ?>; 
        var penjamin_id = <?php echo $modPendaftaran->penjamin_id; ?>;
        var kelaspelayanan_id = <?php echo $modPendaftaran->kelaspelayanan_id; ?>;
        var jenistarif_id = <?php echo $modJenisTarif->jenistarif_id; ?>;
        var ruangan_id = $(".form_ruangan_id").val();
        var subjenis_pemeriksaanlab_id = $(".form_subjenis_pemeriksaanlab_id").val();
        var pemeriksaanlab_nama = $("#periksalab").val();
        var count = 0;


        $("#generate-pemeriksaanlab").addClass("animation-loading");

        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('loadTarifLab'); ?>',
            data: {
                pendaftaran_id:pendaftaran_id, 
                penjamin_id:penjamin_id,
                kelaspelayanan_id:kelaspelayanan_id,
                jenistarif_id:jenistarif_id,
                ruangan_id:ruangan_id,
                periksalab: pemeriksaanlab_nama,
                subjenis_pemeriksaanlab_id: subjenis_pemeriksaanlab_id
            },
            dataType: "json",
            success:function(data){
                if (data.sukses == 1){
                    $("#formPeriksaLab").html(data.html);

                    $("#tblFormPemeriksaanLab > tbody > tr ").each(function(){                    
                        if ($(this).find('.idruangan').val() != ruangan_id){
                            count++;
                        }

                        if (count < 1){
                            $("#generate-pemeriksaanlab").find('input[id$="pemeriksaanlabid"][value="'+$(this).find('.idpemeriksaanlab').val()+'"]').prop("checked", true);
                        }
                    });

                    if(count > 0 ){
                        $("#tblFormPemeriksaanLab > tbody ").html('');
                    }
                }else{
                    myAlert(data.pesan);
                }

                $("#generate-pemeriksaanlab").removeClass("animation-loading");
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }

    function setPpds(ppds_id){
        var id = ppds_id;
        $.ajax({
            type:'POST',
            data: {id : id},
            url:'<?php echo $this->createUrl('generatePpds'); ?>',
            dataType: "json",
            success:function(data) {
                if (data.ok != 1) {
                    toastr.warning(data.msg);
                    $("#nim").val("");
                    $("#nama_prodi").val("");
                    $("#no_hp").val("");
                    return false;
                }
            setVal(data.data);
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }

    function setVal(data){
         $("#nim").val(data.ppds_nim);
         $("#nama_prodi").val(data.programstudi_nama);
         $("#no_hp").val(data.nomor_hp);
    }

    function setBahan(obj){
        var periksabahan_nama = $("#periksabahan").val();
        var subjenis_pemeriksaanlab_id = $(".form_subjenis_pemeriksaanlab_id").val();
        var count = 0;

        $("#loadSpesimen").addClass("animation-loading");

        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('loadBahanSpesimen'); ?>',
            data: {
                periksabahan: periksabahan_nama,
                subjenis_pemeriksaanlab_id: subjenis_pemeriksaanlab_id
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

    function inputBahan(obj, lokasi) {
        console.log('hello');
        var catatan = $('.catatan').val();
        if($(obj).is(':checked')) {
            var sample_id = obj.value;
            var lokasi = lokasi;
            var kode_unik = $(obj).parents(".base_input_ceklis").find(".periksa_kode_unik").val();
            var samplelab_id = $("#RJPasienKirimKeUnitLainT_samplelab_id").val();
            var caraambilsampel_id = $("#RJPasienKirimKeUnitLainT_caraambilsampel_id").val();

            jQuery.ajax({'url':'<?php echo Yii::app()->createUrl('rawatJalan/mikrobiologiKlinik/loadTabelSpesimen')?>',
                    'data':{
                        sample_id:sample_id, lokasi:lokasi, catatan:catatan, kode_unik:kode_unik,
                        samplelab_id:samplelab_id, caraambilsampel_id:caraambilsampel_id 
                    },
                    'type':'post',
                    'dataType':'json',
                    'success':function(data) {
                            // $('.samplelab').val(data.samplelab_id);
                            // $('.caraambilsample').val(data.caraambilsampel_id);
                            
                            var rowCount = document.getElementsByClassName("jumlahspesimen");
                            var count = rowCount.length;
                            console.log(count);
                            if (count == 0) {
                                $('#tabelBahan > tbody').append(data.form);
                                $("#tabelBahan > tbody > tr:last .integer").maskMoney({"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0});
                                $('.integer').each(function(){this.value = formatNumber(this.value)});
                            } else {
                                toastr.error("Tidak bisa memilih lebih dari satu spesimen", "Perhatian!");
                                batalBahan(obj.value);
                                $(obj).attr('checked', false);
                            }
                    } ,
                    'cache':false});
            } else {
                myConfirm("Apakah anda akan membatalkan pemeriksaan ini?","Perhatian!",function(r) {
                    if(r){
                        batalBahan(obj.value);
                        toastr.success("Pemeriksaan berhasil dibatalkan", "Perhatian!");
                    }else{
                        $(obj).attr('checked', 'checked');
                    }
                });
            }

          setTimeout(function(){
            $("#<?php echo CHtml::activeId($modKirimKeUnitLain, 'catatandokterpengirim') ?>").blur();
          },500);
    }
    function batalBahan(samplelab_id) {
	$('#tabelBahan #pemeriksaanSpesimen_'+samplelab_id).detach();
    $('.samplelab').val();
    $('.caraambilsample').val();
    }

$(document).ready(function(){
        cekAntibiotik();
	// Notifikasi Pasien
	<?php 
            if(isset($_GET['smspasien'])){
                if($_GET['smspasien']==0){
	?>
		var params = [];
		params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PASIEN', isinotifikasi:'Pasien <?php echo $modPasien->nama_pasien; ?> tidak memiliki nomor mobile'}; // 16 
		insert_notifikasi(params);
	<?php
                }
            }
	?>

	<?php 
		if(isset($modKirimKeUnitLain->pasienkirimkeunitlain_id)){
	?>
		var params = [];
		params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_LAB ?>, judulnotifikasi:'Pasien Rujukan', isinotifikasi:'<?php echo $modPasien->nama_pasien ?> dengan <?php echo $modPasien->no_rekam_medik ?> telah dirujuk pada <?php echo $modKirimKeUnitLain->tgl_kirimpasien ?> dari <?php echo $modKirimKeUnitLain->ruangan->ruangan_nama ?>'}; // 16 
		insert_notifikasi(params);
	<?php
		}
	?>

        setValidasiCekDisabled($("#rjpasien-laboratorium-t-form"), function() {
                if ($("#tblFormPemeriksaanLab > tbody > tr").length == 0){
                    return false;
                }
                
                return true;
         });

    setBahan($("#KirimspesimenlabT_samplelab_id"));
});
</script>
	
