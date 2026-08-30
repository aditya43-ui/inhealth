<?php
    $controller = Yii::app()->controller->id; 
    $module = Yii::app()->controller->module->id;
?>
<script>


function setDokterReseptur(nama, id) {
    $("#<?php echo CHtml::activeId($modReseptur, 'pegawai_nama') ?>").val(nama);
    $("#pegawai_reseptur").val(id);
    $("#iter").change().blur();
    $("#dialogDokterDPJP").dialog("close");
}    

function beforeSubmit() {

        
    return true;
}

function loadScanFile() {
    var no_pendaftaran = $("#InfokunjunganriV_no_pendaftaran").val();
    var no_rm = $("#InfokunjunganriV_no_rekam_medik").val();
    
    $.post('<?php echo $this->createUrl('loadFileScan'); ?>', {
        no_pendaftaran: no_pendaftaran,
        no_rm: no_rm,
    }, function(data) {
        $(".panel-gambar .panel-body").html(data.html);
        $("#iter").change().blur();
    }, 'json');
}

function launchScanner() {
    var no_pendaftaran = $("#InfokunjunganriV_no_pendaftaran").val();
    var no_rm = $("#InfokunjunganriV_no_rekam_medik").val();
    
    if (no_pendaftaran.trim() == "" || no_rm.trim() == "") {
        myAlert("Pasien harus diinput");
        return false;
    }

    location.href='Scanner: ' + no_rm + "_" + no_pendaftaran;
}

function setScanFormat(data) {
    $("#txt_format_scanner").val(data.no_rekam_medik + "_"  + data.no_pendaftaran);
    loadScanFile();
}

function copyFormat() {
    if (no_pendaftaran.trim() == "" || no_rm.trim() == "") {
        myAlert("Pasien harus diinput");
        return false;
    }
    
    $("#txt_format_scanner").get(0).select();
    document.execCommand("copy");
}

$(document).ready(function() {
    
    

    setValidasiCekDisabled($("#pelayananpasien-form"), function() {
            if ($(".ceklis_scan").length == 0){
                return false;
            }

            return true;
     });
});

</script>

