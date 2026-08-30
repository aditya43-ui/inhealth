<?php
//========= Dialog buat cari data pendaftaran / kunjungan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPasien',
    'options' => array(
        'title' => 'Pencarian Data Kunjungan Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 980,
        'height' => 400,
        'resizable' => false,
    ),
));

$this->renderPartial($this->pathView.'grid/_daftar_pasien_rjrdri',[]);

$this->endWidget();

//========= Dialog buat cari data riwayat SEP =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRiwayatSep',
    'options' => array(
        'title' => 'Pencarian Riwayat SEP Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 980,
        'height' => 400,
        'resizable' => false,
    ),
));

$this->renderPartial($this->pathView.'grid/_formRiwayatSep',[]);

$this->endWidget();



// Dialog untuk rencana kontrol =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRencanaKontrol',
    'options' => array(
        'title' => 'Rencana Kontrol',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 900,
        'height' => 480,
        'resizable' => true,        
    ),
));
?>
<iframe id="iframeRencanaKontrol" src="" name="iframeRencanaKontrol" width="100%" height="520"></iframe>

<?php
$this->endWidget();
?>
<script>
    $(document).ready(function() {
        setPickerRangeTanggal();        
    });

    function setPickerRangeTanggal() {
    $('input[name="InfokunjunganrdV[tgl_pencarian]"]').daterangepicker({
        "maxDate": "<?php echo date('m/d/Y') ?>",
        "format": "MM/DD/YYYY",
        "applyClass": "btn-primary btn_pendaftaran_apply",
        "showDropdowns": true,
    });
    
    $(".btn_pendaftaran_apply").on("click", function() {
        setTimeout(function() {
            $.fn.yiiGridView.update("datakunjungan-grid", {data: $("#datakunjungan-grid :input").serialize()});
        }, 100);
    });
}
</script>