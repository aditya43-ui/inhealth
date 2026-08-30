<?php
$default = 100; 
$vars = $_GET;
unset($vars['r']);
$gets = '&'.http_build_query($vars);
$persiapan = $model->persiapanpengadaan_id;

$konfig = KonfigsystemK::model()->find();

?>

<?php $baseUrl = Yii::app()->createUrl("/");?>
<script>
    var set_tabulasi = () => {
        let simplikasi = '<?= ($konfig->is_simplifikasipengadaan)?'ya':'tidak' ?>';
        let ba = '<?= ($konfig->is_banegosiasiaktif)?'ya':'tidak' ?>';
        if (simplikasi == 'ya'){
            $("#buka-penawaran").addClass('hide').removeAttr('style');
            $("#eval-penawaran").addClass('hide').removeAttr('style');
            $("#ba-langsung").addClass('hide').removeAttr('style');
            $("#penetapan").addClass('hide').removeAttr('style');
            $("#pengumuman").addClass('hide').removeAttr('style');
            $("#nota-dinas").addClass('hide').removeAttr('style');
            $("#sskk").addClass('hide').removeAttr('style');
            $("#mulai-kerja").addClass('hide').removeAttr('style');
            $("#penyedia").addClass('hide').removeAttr('style');
        }
        
        if (ba == 'tidak'){
            $("#ba-nego").addClass('hide').removeAttr('style');
        }
    }
    
        function setTab(obj) {
            var id = $("#InformasipersiapanpengadaanV_persiapanpengadaan_id").val();
            if (id != '') {
                    $(obj).parents("ul").find("li").each(function () {
                        $(this).removeClass("active");
                        $(this).attr("onclick", "setTab(this);");
                    });
                    $(obj).addClass("active");
                    $(obj).removeAttr("onclick", "setTab(this);");
                    var tab = $(obj).attr("tab");
                    var frameObj = document.getElementById("frame");
                    resetIframe(frameObj);
                    $(frameObj).attr("src", "<?php echo $baseUrl; ?>?r=" + tab + "&id=" + id);
                    $(frameObj).parent().addClass("animation-loading");
                    $(frameObj).load(function () {
                    $(frameObj).parent().removeClass("animation-loading");
                    resizeIframe(frameObj);
                    });
            } else {
                    myAlert("Silahkan pilih data Persiapan Pengadaan");
            }
            return false;
	}
    function setTabReset() {
        $(".nav-tabs > .active").attr("onclick", "setTab(this);");
        $(".nav-tabs > .active").removeClass("active");
        
        $("#frame").attr("src", "");
    }


    function resetIframe(obj) {
        obj.style.height = 128 + 'px';
    }
    function resizeIframe(obj) {
        obj.style.height = (obj.contentWindow.document.body.scrollHeight) + 'px';
    }
    
    function setPersiapan(data){
        $("#InformasipersiapanpengadaanV_persiapanpengadaan_id").val(data.persiapanpengadaan_id);
        $("#InformasipersiapanpengadaanV_persiapanpengadaan_nomor").val(data.persiapanpengadaan_nomor);
        $("#InformasipersiapanpengadaanV_programkerja_nama").val(data.programkerja_nama);
        $("#InformasipersiapanpengadaanV_kegiatanprogram_nama").val(data.subprogramkerja_nama);
        $("#InformasipersiapanpengadaanV_subkegiatanprogram_nama").val(data.subkegiatanprogram_nama);
        $("#InformasipersiapanpengadaanV_nama_pekerjaan").val(data.nama_pekerjaan);
        $("#InformasipersiapanpengadaanV_total_hargaseluruhnya").val(data.total_hargaseluruhnya);
        $("#InformasipersiapanpengadaanV_tahunanggaran").val(data.tahunanggaran);
        $("#InformasipersiapanpengadaanV_persiapanpengadaan_tanggal").val(data.persiapanpengadaan_tanggal);
        $("#InformasipersiapanpengadaanV_daftarsumberdana").val(data.daftarsumberdana);
        $("#InformasipersiapanpengadaanV_daftarjenispengadaan").val(data.daftarjenispengadaan);
        $("#dialogPersiapan").dialog("close");
        setTabReset();
    }
    
    set_tabulasi();
</script>