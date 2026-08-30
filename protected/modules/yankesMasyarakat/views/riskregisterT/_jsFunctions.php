<script type="text/javascript">
    
function pilihPeluang(obj) {
    var peluang = $(obj).val();
    $.post('<?php echo $this->createUrl('getBobotPeluang'); ?>', { 
        id:peluang},
    function(data){
        $('#RiskregisterM_peluang_skor').val(data.return);
        hitungRPN();
    }, "json");
}

function pilihKonsekuensi(obj) {
    var peluang = $(obj).val();
    $.post('<?php echo $this->createUrl('getBobotKonsekuensi'); ?>', { 
        id:peluang},
    function(data){
        $('#RiskregisterM_konsekuensi_skor').val(data.return);
        hitungRPN();
    }, "json");
}

function pilihDetectability(obj) {
    var peluang = $(obj).val();
    $.post('<?php echo $this->createUrl('getBobotDetectability'); ?>', { 
        id:peluang},
    function(data){
        $('#RiskregisterM_detectability_skor').val(data.return);
        hitungRPN();
    }, "json");
}

function pilihPeluangSisa(obj) {
    var peluang = $(obj).val();
    $.post('<?php echo $this->createUrl('getBobotPeluang'); ?>', { 
        id:peluang},
    function(data){
        $('#RiskregisterM_peluang_skor_rpnsisa').val(data.return);
        hitungRPNSisa();
    }, "json");
}

function pilihKonsekuensiSisa(obj) {
    var peluang = $(obj).val();
    $.post('<?php echo $this->createUrl('getBobotKonsekuensi'); ?>', { 
        id:peluang},
    function(data){
        $('#RiskregisterM_konsekuensi_skor_rpnsisa').val(data.return);
        hitungRPNSisa();
    }, "json");
}

function pilihDetectabilitySisa(obj) {
    var peluang = $(obj).val();
    $.post('<?php echo $this->createUrl('getBobotDetectability'); ?>', { 
        id:peluang},
    function(data){
        $('#RiskregisterM_detectability_skor_rpnsisa').val(data.return);
        hitungRPNSisa();
    }, "json");
}
    
function hitungRPNSisa(){
    var konsekuensi_id = $("#RiskregisterM_konsekuensi_rpnsisa_id").val();
    var peluang_id = $("#RiskregisterM_peluang_rpnsisa_id").val();
    var detectability_id = $("#RiskregisterM_detectability_rpnsisa_id").val();
    var nilai_konsekuensi = $("#RiskregisterM_konsekuensi_skor_rpnsisa").val();
    var nilai_peluang = $("#RiskregisterM_peluang_skor_rpnsisa").val();
    var nilai_detectability = $("#RiskregisterM_detectability_skor_rpnsisa").val();
    if(nilai_konsekuensi==0){
        nilai_konsekuensi=1;
    }
    if(nilai_peluang==0){
        nilai_peluang=1;
    }
    if(nilai_detectability==0){
        nilai_detectability=1;
    }
    var total = parseInt(nilai_konsekuensi) * parseInt(nilai_peluang) * parseInt(nilai_detectability);
    if(konsekuensi_id == "" && peluang_id == "" && detectability_id == ""){
        total = 0;
    }
    $("#RiskregisterM_riskregister_rpnsisa").val(total);
}

function hitungRPN(){
    var konsekuensi_id = $("#RiskregisterM_konsekuensi_id").val();
    var peluang_id = $("#RiskregisterM_peluang_id").val();
    var detectability_id = $("#RiskregisterM_detectability_id").val();
    var nilai_konsekuensi = $("#RiskregisterM_konsekuensi_skor").val();
    var nilai_peluang = $("#RiskregisterM_peluang_skor").val();
    var nilai_detectability = $("#RiskregisterM_detectability_skor").val();
    if(nilai_konsekuensi==0){
        nilai_konsekuensi=1;
    }
    if(nilai_peluang==0){
        nilai_peluang=1;
    }
    if(nilai_detectability==0){
        nilai_detectability=1;
    }
        
    var total = parseInt(nilai_konsekuensi) * parseInt(nilai_peluang) * parseInt(nilai_detectability);
    if(konsekuensi_id == "" && peluang_id == "" && detectability_id == ""){
        total = 0;
    }
    $("#RiskregisterM_riskregister_rpn").val(total);
}

function loadTingkatRisiko(){
    var konsekuensi_id = $("#RiskregisterM_konsekuensi_id").val();
    var peluang_id = $("#RiskregisterM_peluang_id").val();
    
    if(konsekuensi_id != "" && peluang_id != ""){
        $.post('<?php echo $this->createUrl('getTingkatRisiko'); ?>', { 
            konsekuensi_id:konsekuensi_id,peluang_id:peluang_id},
        function(data){
            $('#RiskregisterM_tingkatrisiko_nama').val(data.return);
        }, "json");
    }else{
        $('#RiskregisterM_tingkatrisiko_nama').val("");
    }
}

$(document).ready(function(){
    hitungRPN();
    hitungRPNSisa();
});
</script>