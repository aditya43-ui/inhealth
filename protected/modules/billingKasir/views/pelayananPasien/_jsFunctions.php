<script type="text/javascript">
/**
 * set form kunjungan
 * @param {type} pasien_id
 * @returns {undefined}
 */
function setKunjungan(pendaftaran_id, no_pendaftaran, no_rekam_medik, pasienadmisi_id ){
    $("#form-datakunjungan > div").addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetDataKunjungan'); ?>',
        data: {pendaftaran_id:pendaftaran_id, no_pendaftaran:no_pendaftaran, no_rekam_medik:no_rekam_medik, pasienadmisi_id:pasienadmisi_id},
        dataType: "json",
        success:function(data){
            $("#cari_pendaftaran_id").val(data.pendaftaran_id);
            $("#instalasi_id").val(data.instalasi_id);
            $("#pendaftaran_id").val(data.pendaftaran_id);
            $("#pasien_id").val(data.pasien_id);
            $("#pasienadmisi_id").val(data.pasienadmisi_id);
            $("#jeniskasuspenyakit_id").val(data.jeniskasuspenyakit_id);
            $("#carabayar_id").val(data.carabayar_id);
            $("#penjamin_id").val(data.penjamin_id);
            $("#penanggungjawab_id").val(data.penanggungjawab_id);
            $("#kelaspelayanan_id").val(data.kelaspelayanan_id);
            if(data.ruangan_id)
                $("#ruangan_id").val(data.ruangan_id);
            else
                $("#ruangan_id").val(data.ruanganakhir_id);
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
            if(data.photopasien === null || data.photopasien === ""){ //set photo
                $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
            }else{
                $('#photo-preview').attr('src','<?php echo Params::urlPasienTumbsDirectory()."kecil_"?>'+data.photopasien);
            }
            
            if (data.dokterpenerima != '' || data.dpjp1 != '' || data.dpjp2 != '' || data.dpjp3 != '') {
                if (data.dokterpenerima != '') $("#dokterpenerima").val(data.dokterpenerima);
                if (data.dpjp1 != '') $("#dpjp1").val(data.dpjp1);
                if (data.dpjp2 != '') $("#dpjp2").val(data.dpjp2);
                if (data.dpjp3 != '') $("#dpjp3").val(data.dpjp3);
                $(".dpjp").show();
            } else {
                $(".dpjp").val("").hide();
            }

            if (data.kelastanggungan_id != '') {
                $(".kelastanggungan").show();
                $("#kelastanggungan_nama").val(data.kelastanggungan_nama);
                $(".info_kelastanggungan_id").data('weight', data.kelaspelayanan_nilai);
            } else {
                $(".kelastanggungan").hide();
                $(".info_kelastanggungan_id").data('weight', 0);
            }
            
            
//          RND-3402 >>  setRiwayatPasien();
            setTab($(".default-tab"));
            
            $("#form-datakunjungan > legend > .judul").html('Data Kunjungan '+data.no_pendaftaran);
            $("#form-datakunjungan > legend > .tombol").attr('style','display:true;');
            $("#form-datakunjungan > .box").addClass("well").removeClass("box");
            
            $("#form-datakunjungan > div").removeClass("animation-loading");
            $("#nama_pasien").focus();
        },
        error: function (jqXHR, textStatus, errorThrown) { 
            myAlert("Data kunjungan tidak ditemukan!"); 
            console.log(errorThrown);
            setKunjunganReset();
            $("#form-datakunjungan > div").removeClass("animation-loading");
            $("#cari_pendaftaran_id").focus();
        }
    });

}
/**
 * untuk mereset form kunjungan
 * @returns {undefined} */
function setKunjunganReset(){
    $("#cari_pendaftaran_id").val("");
    // $("#instalasi_id").val("");
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
    $("#kelastanggungan_nama").val("");
    $("#alamat_pasien").val("");
    $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
    $("#form-datakunjungan > legend > .judul").html('Data Kunjungan');
    $("#form-datakunjungan > legend > .tombol").attr('style','display:none;');
    $("#form-datakunjungan > .well").addClass("box").removeClass("well");
    
    $(".dpjp").hide().find("input").val("");
    
//  RND-3402 >>  setRiwayatPasien();
    setTabReset();
}

/**
 * refresh dialog kunjungan
 * @returns {undefined}
 */
function refreshDialogKunjungan(){
    var instalasi_id = $("#instalasi_id").val();
    var instalasi_nama = $("#instalasi_id option:selected").text();
    $.fn.yiiGridView.update('datakunjungan-grid', {
        data: {
            "BKInformasikasirrawatjalanV[instalasi_id]":instalasi_id,
            "BKInformasikasirrawatjalanV[instalasi_nama]":instalasi_nama,
        }
    });
}

function resetPencarianRuangan() {
    $("#dialog_pasien_ruangan_id").val("");
    // console.log("Cari : ", $("#dialog_pasien_ruangan_id").val());
}

<?php $baseUrl = Yii::app()->createUrl("/");?>
<?php $riwayatPasien = Yii::app()->createUrl('/rawatJalan/daftarPasien/getRiwayatPasien'); ?>
function setTab(obj){
    var pendaftaran_id = $("#pendaftaran_id").val();
    if(pendaftaran_id !== ""){
        $(obj).parents("ul").find("li").each(function(){
            $(this).removeClass("active");
            $(this).attr("onclick","setTab(this);");
        });
        $(obj).addClass("active");
        $(obj).removeAttr("onclick","setTab(this);");
        var tab = $(obj).attr("tab");
        var frameObj = document.getElementById("frame");
        resetIframe(frameObj);
        $(frameObj).attr("src","<?php echo $baseUrl;?>?r="+tab+"&pendaftaran_id="+pendaftaran_id);
        $(frameObj).parent().addClass("animation-loading");
        $(frameObj).load(function(){
            $(frameObj).parent().removeClass("animation-loading");
            resizeIframe(frameObj);
        });
    }else{
        myAlert("Silakan pilih data kunjungan!");
    }
    return false;
}
/**
 * reset tab 
 **/
function setTabReset(){
    $(".nav-tabs > .active").removeClass("active");
    $("#frame").attr("src","");
}

/**
 * menampilkan riwayat pasien 
 **/
//  === RND-3402
//function setRiwayatPasien(){
//    var pasien_id = $("#pasien_id").val();
//    var frameObj = document.getElementById("frame-riwayatpasien");
//    $(frameObj).parent().addClass("animation-loading");
//    if(pasien_id !== ""){
//        $(frameObj).attr("src","<?php echo $riwayatPasien;?>&id="+pasien_id);
//    }else{
//        $(frameObj).attr("src","");
//    }
//    $(frameObj).load(function(){
//        resizeIframe(frameObj);
//        $(frameObj).parent().removeClass("animation-loading");
//        $("#divRiwayatPasien").slideToggle(500);
//    });
//    return false;
//}
function resetIframe(obj) {
    obj.style.height = 128 + 'px';
}
function resizeIframe(obj) {
    obj.style.height = (obj.contentWindow.document.body.scrollHeight+25) + 'px';
}
$("#cekRiwayatPasien").change(function(){
    $('#divRiwayatPasien').slideToggle(500);
});
/**
* redirect ke pembayaran tagihan pasien
*/ 
function pembayaranTagihanPasien(){
    var pendaftaran_id = $("#pendaftaran_id").val();
    var pasienadmisi_id = $("#pasienadmisi_id").val();
    var instalasi_id = $("#instalasi_id").val();
    if(pendaftaran_id !== ""){
        window.open("<?php echo $this->createUrl('pembayaranTagihanPasien/index') ?>&instalasi_id="+instalasi_id+"&pendaftaran_id="+pendaftaran_id+"&pasienadmisi_id="+pasienadmisi_id, "_self");
    }else{
        myAlert("Silakan pilih data kunjungan!");
    }
}

/**
 * javascript yang di running setelah halaman ready / load sempurna
 * posisi script ini harus tetap dibawah
 */
$( document ).ready(function(){
//  RND-3402  setRiwayatPasien();
    <?php if(!empty($modKunjungan->pendaftaran_id)){ ?>
            setTab($(".default-tab"));
            $(".add-on").attr("style","display:none");
    <?php } ?>
});
</script>