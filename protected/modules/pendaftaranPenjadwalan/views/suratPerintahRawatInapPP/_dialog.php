<?php
//========= Dialog buat cari data pendaftaran / kunjungan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPasien',
    'options' => array(
        'title' => 'Pencarian Data Kunjungan Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 980,
        'height' => 480,
        'resizable' => false,
    ),
));

$this->renderPartial('grid/_daftar_pasien_rdri',[]);

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