<?php
$this->widget('bootstrap.widgets.BootMenu', array(
    'type' => 'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked' => false, // whether this is a stacked menur
    'items' => array(
        array('label' => 'Pegawai Diklat', 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTabPekerjaan(this);', 'tab' => $this->createUrl('RiwayatDiklat/Index'))),
        array('label' => 'Jabatan Pegawai', 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTabPekerjaan(this);', 'tab' => $this->createUrl('RiwayatJabatan/Index'))),
        array('label' => 'Mutasi Pegawai', 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTabPekerjaan(this);', 'tab' => $this->createUrl('RiwayatMutasi/Index'))),
        array('label' => 'Cuti Pegawai', 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTabPekerjaan(this);', 'tab' => $this->createUrl('RiwayatCuti/Index'))),
        array('label' => 'Izin Tugas Belajar', 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTabPekerjaan(this);', 'tab' => $this->createUrl('RiwayatIzinTugasBelajar/Index'))),
        array('label' => 'Hukuman Disiplin', 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTabPekerjaan(this);', 'tab' => $this->createUrl('RiwayatHukumanDisiplin/Index'))),
        array('label' => 'Prestasi Kerja', 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTabPekerjaan(this);', 'tab' => $this->createUrl('RiwayatPrestasiKerja/Index'))),
        array('label' => 'Perjalanan Dinas', 'url' => 'javascript:void(0);', 'itemOptions' => array('id' => 'tab-default', 'onclick' => 'setTabPekerjaan(this);', 'tab' => $this->createUrl('RiwayatPerjalananDinas/Index'))),
    ),
));
?>
<div>
    <iframe class="biru" id="framePekerjaan" src="" frameborder="0" style="overflow-y:scroll" width="100%" height="100%" onresize="javascript:resizeIframe(this);" onload="javascript:resizeIframe(this);"></iframe>
</div>
<script type="text/javascript">
    function setTabPekerjaan(obj) {
        var pegawai_id = <?php echo $pegawai; ?>;
        if (pegawai_id !== "") {
            $(obj).parents("ul").find("li").each(function() {
                $(this).removeClass("active");
                $(this).attr("onclick", "setTabPekerjaan(this);");
            });
            $(obj).addClass("active");
            $(obj).removeAttr("onclick", "setTabPekerjaan(this);");
            var tab = $(obj).attr("tab");
            var frameObj = document.getElementById("framePekerjaan");
            resetIframe(frameObj);
            $(frameObj).attr("src", tab + "&pegawai_id=" + pegawai_id);
            $(frameObj).parent().addClass("animation-loading");
            $(frameObj).load(function() {
                $(frameObj).parent().removeClass("animation-loading");
                resizeIframe(frameObj);
            });
        } else {
            myAlert("Silakan pilih data pegawai!");
        }
        return false;

    }

    function resetIframe(obj) {
        obj.style.height = 150 + 'px';
    }

    function resizeIframe(obj) {
        obj.style.height = (obj.contentWindow.document.body.scrollHeight) + 'px';
        //    obj.style.height = 400 + 'px';
    }
</script>