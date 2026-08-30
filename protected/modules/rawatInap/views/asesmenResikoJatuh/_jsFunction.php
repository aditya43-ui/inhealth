<?php
/**
 * view ini digunakan untuk menyimpan fungsi - fungsi javascript
 * 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0 
 * @link    <http://piindonesia.co.id>
 */
?>

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

function hitungSkorAnak() {
    var skor_total = 0;
    $("#tab_skor_anak tbody tr").each(function() {
        var skor = $(this).find(".list_skor :selected").data('value');
        
        if (skor == null) skor = 0;
        
        $(this).find(".txt_skor").val(skor);
        
        skor_total += skor;
    });
    
    $("#SkoringresikojatuhT_totalskor").val(skor_total);
    
    pilihPanelImplementasiAnak();
}

function pilihPanelImplementasi() {
    var skor_total = $("#SkoringresikojatuhT_totalskor").val();
    
    // console.log(skor_total, !(skor_total >= 45), !(skor_total >= 25 && skor_total < 45));
    
    setHideShowPanel($("#panel_implementasi_tinggi"), (skor_total > 50));
    setHideShowPanel($("#panel_implementasi_rendah"), (skor_total >= 25 && skor_total <= 50));
}
function pilihPanelImplementasiAnak() {
    var skor_total = $("#SkoringresikojatuhT_totalskor").val();
    
    // console.log(skor_total, !(skor_total >= 45), !(skor_total >= 25 && skor_total < 45));
    
    setHideShowPanel($("#panel_implementasi_tinggi"), (skor_total > 11));
    setHideShowPanel($("#panel_implementasi_rendah"), (skor_total >= 7 && skor_total <= 11));
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


function inputAllDisabled(obj){
    $(obj).find('input,select,textarea').each(function(){
        $(this).attr('disabled',true);
    });
}

function inputAllEnabled(obj){
    $(obj).find('input,select,textarea').each(function(){
        $(this).attr('disabled',false);
    });
}

function choiseResikoJatuh(obj){
    if($(obj).val() == 1 && $(obj).prop('checked')==true){
        inputAllEnabled($('#panelresikojatuh_anak').find('.panel-body'));
        $('#panelresikojatuh_anak').find('#resikojatuhanak').show();

        inputAllDisabled($('#panelresikojatuh_dewasa').find('.panel-body'));
        $('#panelresikojatuh_dewasa').find('#resikojatuhdewasa').hide();
    } else if($(obj).val() == 2 && $(obj).prop('checked')==true){
        inputAllEnabled($('#panelresikojatuh_dewasa').find('.panel-body'));
        $('#panelresikojatuh_dewasa').find('#resikojatuhdewasa').show();

        inputAllDisabled($('#panelresikojatuh_anak').find('.panel-body'));
        $('#panelresikojatuh_anak').find('#resikojatuhanak').hide();
    }else{
        inputAllDisabled($('#panelresikojatuh_anak').find('.panel-body'));
        $('#panelresikojatuh_anak').find('#resikojatuhanak').hide();

        inputAllDisabled($('#panelresikojatuh_dewasa').find('.panel-body'));
        $('#panelresikojatuh_dewasa').find('#resikojatuhdewasa').hide();
    }
}

function resikojatuhanak_usia(obj){
    $('#<?php echo CHtml::activeId($model,'anak_usia_skor') ?>').val($(obj).val());
    $('#<?php echo CHtml::activeId($model,'anak_usia_keterangan') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh();
}

function resikojatuhanak_jeniskelamin(obj){
    $('#<?php echo CHtml::activeId($model,'anak_jeniskelamin_skor') ?>').val($(obj).val());
    $('#<?php echo CHtml::activeId($model,'anak_jeniskelamin_keterangan') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh();
}

function resikojatuhanak_diagnosa(obj){
    $('#<?php echo CHtml::activeId($model,'anak_diagnosis_skor') ?>').val($(obj).val());
    $('#<?php echo CHtml::activeId($model,'anak_diagnosis_keterangan') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh();
}

function resikojatuhanak_gangguan(obj){
    $('#<?php echo CHtml::activeId($model,'anak_gangguankognitif_skor') ?>').val($(obj).val());
    $('#<?php echo CHtml::activeId($model,'anak_gangguankognitif_keterangan') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh();
}


function resikojatuhanak_faktor(obj){
    $('#<?php echo CHtml::activeId($model,'anak_faktorlingkungan_skor') ?>').val($(obj).val());
    $('#<?php echo CHtml::activeId($model,'anak_faktorlingkungan_keterangan') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh();
}


function resikojatuhanak_respon(obj){
    $('#<?php echo CHtml::activeId($model,'anak_pembedahan_skor') ?>').val($(obj).val());
    $('#<?php echo CHtml::activeId($model,'anak_pembedahan_keterangan') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh();
}

function resikojatuhanak_bedah(obj){
    $('#<?php echo CHtml::activeId($model,'anak_medikamentosa_skor') ?>').val($(obj).val());
    $('#<?php echo CHtml::activeId($model,'anak_medikamentosa_keterangan') ?>').val(obj.options[obj.selectedIndex].text);
    skorresikojatuh();
}

function skorresikojatuh(){
    var totalSkorAnak = 0;

    $('#tblResikojatuhAnak').find('.resikojatuhanak_skor').each(function(){
        var skor = $(this).val();

        if(skor == ''){
            skor = 0;
        }
        totalSkorAnak += parseInt(skor);
    });
    var ketResikoAnak = "";
    if (totalSkorAnak >= 0  && totalSkorAnak <=6)  {
       ketResikoAnak = "Risiko Rendah";
    }
    else if(totalSkorAnak >= 7  && totalSkorAnak <=11) {
       ketResikoAnak = "Risiko Sedang";
    }
    else if(totalSkorAnak >= 12) {
        ketResikoAnak = "Risiko Tinggi";
    }

    $('#<?php echo CHtml::activeId($model,'totalskor_anak') ?>').val(totalSkorAnak);
    $('#<?php echo CHtml::activeId($model,'totalskor_keterangan_anak') ?>').val(ketResikoAnak);
}
    
function print() {
    window.open('<?php echo $this->createUrl('print', array('id' => $modPendaftaran->pendaftaran_id)); ?>', 'printwin', 'left=100,top=100,width=640,height=480');
}

$(document).ready(function() {
    <?php if (in_array(trim(strtolower($modPasien->namadepan)), array("an.", "by."))): ?>
    pilihPanelImplementasiAnak();
    <?php else: ?>
    pilihPanelImplementasi();
    <?php endif; ?>
    setValidasiCekDisabled($("#resikojatuh-form"), function() {                   
        return true;    
    });
    $(".pilih_resikoJatuh").each(function(){
         choiseResikoJatuh($(this));
     });
});
</script>