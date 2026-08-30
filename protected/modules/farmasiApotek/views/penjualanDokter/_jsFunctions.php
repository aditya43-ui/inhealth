<script type="text/javascript">
/**
 * set form info pasien
 * @returns {undefined}
 */
function setInfoPegawai(pegawai_id,nama_pegawai){
    $("#form-info > div").addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetDataInfoPegawai'); ?>',
        data: {pegawai_id:pegawai_id,nama_pegawai:nama_pegawai},
        dataType: "json",
        success:function(data){
            $("#cari_pegawai_id").val(data.pegawai_id);
            $("#FAPenjualanResepT_pasienpegawai_id").val(data.pegawai_id);
            $("#pasien_id").val(data.pasien_id);
            $("#FAPegawaiV_nomorindukpegawai").val(data.nomorindukpegawai);
            $("#nama_pegawai").val(data.nama_pegawai);
            $("#alamat_pegawai").val(data.alamat_pegawai);
            $("#jeniskelamin").val(data.jeniskelamin);
            if(data.photopegawai != ""){
                var url = "<?php echo Params::urlPegawaiTumbsDirectory() . 'kecil_'; ?>" + data.photopegawai;
                $("#photo-preview").attr('src', url);
            } else {
                var url = "<?php echo Params::urlPegawaiDirectory() . 'no_photo.jpeg'; ?>";
                $("#photo-preview").attr('src',url);
            }
            $("#form-info > legend > .judul").html('Data Pegawai '+data.nama_pegawai_lengkap);
            $("#form-info > legend > .tombol").attr('style','display:true;');
            $("#form-info > .box").addClass("well").removeClass("box");

            $("#form-info > div").removeClass("animation-loading");
            $("#nama_pegawai").focus();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            myAlert("Data pegawai tidak ditemukan !");
            console.log(errorThrown);
            setInfoPegawaiReset();
            $("#form-info > div").removeClass("animation-loading");
        }
    });
}
/**
 * reset form info pasien
 * @returns {undefined}
 */
function setInfoPegawaiReset(){
    $("#cari_pegawai_id").val("");
    $("#FAPenjualanResepT_pasienpegawai_id").val("");
    $("#pasien_id").val("");
    $("#FAPegawaiV_nomorindukpegawai").val("");
    $("#jeniskelamin").val("");
    $("#nama_pegawai").val("");
    $("#alamat_pegawai").val("");
    $('#photo-preview').attr('src','<?php echo Params::urlPegawaiDirectory()."no_photo.jpeg"?>');
    $("#form-info > legend > .judul").html('Data Pegawai');
    $("#form-info > legend > .tombol").attr('style','display:none;');
    $("#form-info > .well").addClass("box").removeClass("well");
}

/**
 * set form info pasien
 * @returns {undefined}
 */
function setInfoDokter(pegawai_id, nama_pegawai){
    $("#form-info > div").addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetDataInfoDokter'); ?>',
        data: {pegawai_id:pegawai_id, nama_pegawai:nama_pegawai},
        dataType: "json",
        success:function(data){
            $("#cari_pegawai_id").val(data.pegawai_id);
            $("#pegawai_id").val(data.pegawai_id);
            $("#<?php echo CHtml::activeId($modPenjualan,"pasienpegawai_id"); ?>").val(data.pegawai_id);
            $("#pasien_id").val(data.pasien_id);
            $("#FADokterV_nomorindukpegawai").val(data.nomorindukpegawai);
            $("#nama_pegawai").val(data.nama_pegawai);
            $("#alamat_pegawai").val(data.alamat_pegawai);
            $("#jeniskelamin").val(data.jeniskelamin);
            if(data.photopegawai != ""){
                var url = "<?php echo Params::urlPegawaiTumbsDirectory() . 'kecil_'; ?>" + data.photopegawai;
                $("#photo-preview").attr('src', url);
            } else {
                var url = "<?php echo Params::urlPegawaiDirectory() . 'no_photo.jpeg'; ?>";
                $("#photo-preview").attr('src',url);
            }

            $("#form-info > legend > .judul").html('Data Dokter '+data.nama_pegawai_lengkap + " ");
            $("#form-info > legend > .tombol").attr('style','display:true;');
            $("#form-info > .box").addClass("well").removeClass("box");

            $("#form-info > div").removeClass("animation-loading");
            $("#nama_pegawai").focus();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            myAlert("Data dokter tidak ditemukan !");
            console.log(errorThrown);
            setInfoDokterReset();
            $("#form-info > div").removeClass("animation-loading");
        }
    });
}
/**
 * reset form info pasien
 * @returns {undefined}
 */
function setInfoDokterReset(){
    $("#cari_pegawai_id").val("");
    $("#pegawai_id").val("");
    $("#<?php echo CHtml::activeId($modPenjualan,"pasienpegawai_id"); ?>").val("");
    $("#pasien_id").val("");
    $("#FADokterV_nomorindukpegawai").val("");
    $("#jeniskelamin").val("");
    $("#nama_pegawai").val("");
    $("#alamat_pegawai").val("");
    $('#photo-preview').attr('src','<?php echo Params::urlPegawaiDirectory()."no_photo.jpeg"?>');
    $("#form-info > legend > .judul").html('Data Dokter');
    $("#form-info > legend > .tombol").attr('style','display:none;');
    $("#form-info > .well").addClass("box").removeClass("well");
}

/**
* untuk print penjualan pegawai
 */
function print(caraPrint)
{
    var penjualanresep_id = '<?php echo isset($modPenjualan->penjualanresep_id) ? $modPenjualan->penjualanresep_id : null ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&penjualanresep_id='+penjualanresep_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

function cekObat(){
    if(requiredCheck($("form"))){


        var is_cukup = true;

        $("#table-obatalkespasien tbody tr").each(function() {

            $(this).removeClass("yellow");

            var qty = parseFloat(unformatNumber($(this).find(".qty_jual").val()));
            var stok = parseFloat(unformatNumber($(this).find(".qty_stok").val()));

            // console.log(qty, stok);

            if (qty > stok) {
                $(this).addClass("yellow");
                is_cukup = false;
            }

        });

        if (!is_cukup) {
            myAlert("Stok tidak mencukupi.");
            return false;
        }

        var jmlObat = $('#table-obatalkespasien tbody tr').length;
        var pasien_id = $('#pasien_id').val();
        if(pasien_id == ''){
                myAlert('Isikan data Pegawai terlebih dahulu.');
                return false;
        }
        if(jmlObat <= 0){
                myAlert('Isikan obat alkes rencana kebutuhan terlebih dahulu.');
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
 * refresh dialog kunjungan
 * @returns {undefined}
 */
function refreshDialogInfoPegawai(){
    $.fn.yiiGridView.update('datakunjungankaryawan-grid', {
        data: {
        }
    });
}

/**
 * refresh dialog kunjungan
 * @returns {undefined}
 */
function refreshDialogInfoDokter(){
    $.fn.yiiGridView.update('datakunjungandokter-grid', {
        data: {
        }
    });
}

function jenisPenjualan(){
	var jenispenjualan = $('#FAPenjualanResepT_jenispenjualan').val();
	if (jenispenjualan == "PENJUALAN DOKTER"){
		$('#dokter').show();
		$('#pegawai').hide();
		resetDropdown();
	}else{
		$('#pegawai').show();
		$('#dokter').hide();
		resetDropdown();
	}
}
function resetDropdown(){
	 $("#pasien_id").val("");
	 $("#FAPenjualanResepT_pasienpegawai_id").val("");
	 $("#FADokterV_nomorindukpegawai").val("");
	 $("#FAPegawaiV_nomorindukpegawai").val("");
	 $("#nama_pegawai").val("");
	 $("#jeniskelamin").val("");
}
/**
 * function ini harus tetap berada di bawah
 */
$(document).ready(function(){
    var penjualanresep_id = '<?php echo isset($modPenjualan->penjualanresep_id) ? $modPenjualan->penjualanresep_id : null; ?>';
    var sukses = '<?php echo isset($_GET['sukses']) ? $_GET['sukses'] : null; ?>';
    if(penjualanresep_id != "" && sukses > 0){
        $("#table-obatalkespasien :input").removeAttr("readonly",true);
        $("#table-obatalkespasien .add-on").remove();
        $("#table-obatalkespasien .icon-remove").remove();

        $("#penjualanresep-form :input").attr("readonly",true);
        $("#penjualanresep-form .dtPicker3").attr("readonly",true);
        $("#penjualanresep-form .add-on").remove();

        $("input, select, textarea").attr("disabled",true);
    }

    // Notifikasi Dokter
    <?php
        if(isset($_GET['smspegawai'])){
            if($_GET['smspegawai']==0){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS KARYAWAN', isinotifikasi:'Sdr/i. <?php echo $modPenjualan->pasienpegawai->nama_pegawai; ?> tidak memiliki nomor mobile'}; // 16
        insert_notifikasi(params);
    <?php
            }
        }
    ?>
});
</script>
