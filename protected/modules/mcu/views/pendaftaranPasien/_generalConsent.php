<?php
// Dialog cetak label gelang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogGeneralConsent',
    'options' => array(
        'title' => 'General Consent',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'resizable' => true,        
    ),
));
?>
<iframe id="frameGeneralConsent" name='frameGeneralConsent' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>

<script>
    var url = '<?php echo $this->createUrl('/pendaftaranPenjadwalan/suratPersetujuanUmum/create'); ?>';
    function setDialogGeneralConsent(id) {
        var url_lengkap = url + "&pendaftaran_id=" + id;
        
        $("#dialogGeneralConsent").dialog("open");
        $("#frameGeneralConsent").prop("src", url_lengkap);
    }
    
</script>
