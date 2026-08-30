<style>

    .judul_form {
        font-size: 20pt;
        text-align: center;
        margin-bottom: 50px;
    }

    .form_utama {
        text-align: center;
    }

    .form_utama .form_main {
        display: inline-block;
    }
</style>

<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<div class="judul_form">DAFTAR SURAT ELIGIBILITAS PASIEN BPJS</div>

<div class="form_panel form_utama">
    <div class="form_main">

        SEP Berhasil dibuat. SEP akan di-print otomatis.<br/>
        Jika terjadi kendala dalam proses print, tekan tombol <strong>Cetak SEP</strong> sekali lagi<br/>
        atau hubungi pihak <strong>Administrator Rumah Sakit</strong>
        <br/><br/>

        <div class="form-action">
            <?php echo CHtml::htmlButton('<i class="icon-print icon-white"></i> Cetak SEP', array(
                "onclick"=>"printSep();",
                "class"=>"btn btn-success",
            )); ?>
            <?php echo CHtml::htmlButton("Kembali", array(
                "onclick"=>"kembali();",
                "class"=>"btn btn-danger",
            )); ?>
        </div>
    </div>
</div>

<iframe id="framePrint" hidden>
</iframe>

<script>

    function printSep() {
        $("#framePrint").prop("src", null);
        $("#framePrint").prop("src", "<?php echo $this->createUrl('printSep', array('sep_id'=>$modSep->sep_id)); ?>");
    }

    function kembali() {
        window.location.replace("<?php echo $this->createUrl('index'); ?>");
    }

    $(document).ready(function() {
        printSep();
    });



</script>