<?php
// Dialog cetak label gelang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogGeneralConsentKeuangan',
    'options' => array(
        'title' => 'General Consent Keuangan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 550,
        'resizable' => true,        
    ),
));
?>
<iframe id="frameGeneralConsentKeuangan" name='frameGeneralConsentKeuangan' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>

<script>
    var url = '<?php echo $this->createUrl('/pendaftaranPenjadwalan/suratPersetujuanUmum/indexKeuangan'); ?>';
    function setDialogGeneralConsentKeuangan(id) {
        var url_lengkap = url + "&pendaftaran_id=" + id;
        
        $("#dialogGeneralConsentKeuangan").dialog("open");
        $("#frameGeneralConsentKeuangan").prop("src", url_lengkap);
    }
    
</script>
