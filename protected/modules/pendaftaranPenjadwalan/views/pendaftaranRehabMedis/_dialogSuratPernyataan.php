<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPernyataanPersetujuan',
    'options' => array(
        'title' => 'Buat Pernyataan Persetujuan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'resizable' => true,        
    ),
));
?>

<iframe id="framePernyataanPersetujuan" name='framePernyataanPersetujuan' style="width: 100%; height: 98%;"></iframe>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    var urlSuratPeryataan = '<?php echo $this->createUrl('/pendaftaranPenjadwalan/suratPernyataanPersetujuan/index'); ?>';
    
    function setSuratPeryataan(id) {
        var url_lengkap = urlSuratPeryataan + "&pendaftaran_id=" + id;
        
        $("#dialogPernyataanPersetujuan").dialog("open");
        $("#framePernyataanPersetujuan").prop("src", url_lengkap);
    }
</script>