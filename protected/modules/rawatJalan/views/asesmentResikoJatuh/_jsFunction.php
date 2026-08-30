<script>

function hitungSkor() {
    var skor_total = 0;
    $("#tab_skor tbody tr").each(function() {
        var skor = $(this).find(".list_skor :selected").data('value');
        
        if (skor == null) skor = 0;
        
        $(this).find(".txt_skor").val(skor);
        
        skor_total += skor;
    });
    
    $("#SkoringresikojatuhT_totalskor").val(skor_total);
    
    pilihPanelImplementasi();
}

function pilihPanelImplementasi() {
    var skor_total = $("#SkoringresikojatuhT_totalskor").val();
    
    // console.log(skor_total, !(skor_total >= 45), !(skor_total >= 25 && skor_total < 45));
    
    setHideShowPanel($("#panel_implementasi_tinggi"), (skor_total >= 45));
    setHideShowPanel($("#panel_implementasi_rendah"), (skor_total >= 25 && skor_total < 45));
}

function setHideShowPanel(obj, value) {
    // console.log(value);
    if (value == true) {
        $(obj).show().find(":input").prop("disabled", false);
    } else {
        $(obj).hide().find(":input").prop("disabled", true);
    }
}

function setPetugas(nama, id) {
    $("#pegawaiskoring_id").val(id);
    $("#pegawaiskoring_nama").val(nama);
    $("#pegawaiskoring_nama").change();
}
        
$(document).ready(function() {
    pilihPanelImplementasi();
    
    setValidasiCekDisabled($("#resikojatuh-form"), function() {                   
        return true;    
    });
});
</script>