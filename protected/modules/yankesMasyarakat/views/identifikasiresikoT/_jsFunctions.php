<script type="text/javascript">
    
function pilihPeluang(obj) {
    var peluang = $(obj).val();
    $.post('<?php echo $this->createUrl('getBobotPeluang'); ?>', { 
        id:peluang},
    function(data){
        $('#YKMIdentifikasiresikoT_peluang_skor').val(data.return);
        hitungRPN();
    }, "json");
}

function pilihKonsekuensi(obj) {
    var peluang = $(obj).val();
    $.post('<?php echo $this->createUrl('getBobotKonsekuensi'); ?>', { 
        id:peluang},
    function(data){
        $('#YKMIdentifikasiresikoT_konsekuensi_skor').val(data.return);
        hitungRPN();
    }, "json");
}

function pilihDetectability(obj) {
    var peluang = $(obj).val();
    $.post('<?php echo $this->createUrl('getBobotDetectability'); ?>', { 
        id:peluang},
    function(data){
        $('#YKMIdentifikasiresikoT_detectability_skor').val(data.return);
        hitungRPN();
    }, "json");
}


function hitungRPN(){
    var konsekuensi_id = $("#YKMIdentifikasiresikoT_konsekuensi_id").val();
    var peluang_id = $("#YKMIdentifikasiresikoT_peluang_id").val();
    var detectability_id = $("#YKMIdentifikasiresikoT_detectability_id").val();
    var nilai_konsekuensi = $("#YKMIdentifikasiresikoT_konsekuensi_skor").val();
    var nilai_peluang = $("#YKMIdentifikasiresikoT_peluang_skor").val();
    var nilai_detectability = $("#YKMIdentifikasiresikoT_detectability_skor").val();
    
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
     console.log(konsekuensi_id);
    $("#YKMIdentifikasiresikoT_rpn_score").val(total);
}

function loadTingkatRisiko(){
    var konsekuensi_id = $("#YKMIdentifikasiresikoT_konsekuensi_id").val();
    var peluang_id = $("#YKMIdentifikasiresikoT_peluang_id").val();
    var detect_id = $("#YKMIdentifikasiresikoT_detectability_id").val();
        
    $.post('<?php echo $this->createUrl('getTingkatRisiko'); ?>', { 
        konsekuensi_id:konsekuensi_id,
        peluang_id:peluang_id,
        detect_id:detect_id
    },        
    function(data){
        $('#YKMIdentifikasiresikoT_skor_cl').val(data.skor_cl);
        $('#YKMIdentifikasiresikoT_konsekuensi_skor').val(data.konsekuensi_skor);
        $('#YKMIdentifikasiresikoT_peluang_skor').val(data.peluang_skor);
        $('#YKMIdentifikasiresikoT_detectability_skor').val(data.detectability_skor);       
        
        $('#YKMIdentifikasiresikoT_tingkatrisiko_id').val(data.tingkatrisiko_id);            
        $('#YKMIdentifikasiresikoT_tingkatrisiko_nama').val(data.tingkatrisiko_nama);
        
        $("#YKMIdentifikasiresikoT_rpn_score").val(data.rpn_score);
//        $("#YKMIdentifikasiresikoT_target_rpn").val(data.target_rpn);
    }, "json");    
}
function getsubtipe(obj){
    var tiperesiko_id = $("#YKMIdentifikasiresikoT_tiperesiko_id").val();
    if(tiperesiko_id != ""){
        $.post('<?php echo $this->createUrl('getSubTipeRisiko'); ?>', { 
            tiperesiko_id:tiperesiko_id},
        function(data){
            $('#YKMIdentifikasiresikoT_subtiperesiko_id').val(data.subtiperesiko_id);
        }, "json");
    }else{
        $('#YKMIdentifikasiresikoT_subtiperesiko_id').val("");
    }
}

$(document).ready(function(){
    hitungRPN();
    refreshDialog(); 
});
</script>