<?php
// Dialog cetak label gelang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogTataTertibPengunjung',
    'options' => array(
        'title' => '<span style="width: 100%"> <span style="float: left !important; width:80% !important;">Tata Terbit Pengunjung/ Pendamping Pasien Rawat Inap</span><span style="float: right !important;" class="normDokumen"></span> </span>',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1200,
        'height' => 600,
        'resizable' => true,
    ),
));
?>
<iframe id="frameTataTertibPengunjung" name='frameTataTertibPengunjung' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>

<script>
    function setDialogTataTertibPengunjung(id) {
        var url = '<?php echo $this->createUrl('/pendaftaranPenjadwalan/TataTerbitPengunjung/index'); ?>';
        var url_lengkap = url + "&pendaftaran_id=" + id+"&urlId=<?php echo $this->id; ?>";
        $('.normDokumen').html('<?php
          $modMasterTataTertib = TatatertibpengunjungM::model()->find();
         echo (isset($modMasterTataTertib)?$modMasterTataTertib->tatatertibpengunjung_no_rm :"") ?>');
        $("#dialogTataTertibPengunjung").dialog("open");
        $("#frameTataTertibPengunjung").prop("src", url_lengkap);
    }

</script>
