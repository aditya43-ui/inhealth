<script type="text/javascript">
/**
* untuk print penjualan dokter
 */
function print(caraPrint)
{
    var penjualanresep_id = '<?php echo isset($modPenjualan->penjualanresep_id) ? $modPenjualan->penjualanresep_id : null ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&penjualanresep_id='+penjualanresep_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

function cekObat(){
    if(requiredCheck($("form"))){
        var jmlObat = $('#table-obatalkespasien tbody tr').length;
        
        if(jmlObat <= 0){
                myAlert('Silakan isikan obat alkes terlebih dahulu!');
            return false;
        }else{
            $('#penjualanbebas-form').submit();
        }
        
        $(".animation-loading").removeClass("animation-loading");
        $("form").find('.float').each(function(){
            $(this).val(formatFloat($(this).val()));
        });
        $("form").find('.integer2').each(function(){
            $(this).val(formatInteger($(this).val()));
        });
    }
    return false;
    
}

/**
 * refresh dialog kunjungan
 * @returns {undefined}
 */
function refreshDialogInfoDokter(){
    $.fn.yiiGridView.update('datakunjungan-grid', {
        data: {
        }
    });
}

/**
 * untuk set value jenis kelamin
 * @returns {undefined}
 */
function setJenisKelaminPasien(jeniskelamin)
{
    $('input[name="FAPasienM[jeniskelamin]"]').each(function(){
            if(this.value == jeniskelamin)
                $(this).attr('checked',true);
        }
    );
}

/** control accordion data pasien */
$('#form-pasien > div > .accordion-heading').click(function(){
    var is_pasien = $("#<?php echo CHtml::activeId($modPenjualan, "is_pasien"); ?>");
    if(is_pasien.val() > 0){ //hide
        is_pasien.val(0);
    }else{//show
        is_pasien.val(1);
        $("input, select, textarea").attr("disabled",false);
    }
});

/**
 * set nilai tanggal_lahir dari umur 
 * @param {type} obj
 * @returns {undefined} */
function setTglLahir(obj)
{
    var str = obj.value;
    obj.value = str.replace(/_/gi, "0");
    $.ajax({
       type:'POST',
       url:'<?php echo $this->createUrl('SetTanggalLahir'); ?>',
       data: {umur : obj.value},
       dataType: "json",
       success:function(data){
           $("#<?php echo CHtml::activeId($modPasien,"tanggal_lahir");?>").val(data.tanggal_lahir);
       },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}
/**
 * set nilai umur dari tanggal_lahir 
 * @param {type} tanggal_lahir
 * @returns {undefined} */
function setUmur(tanggal_lahir)
{
    $.ajax({
       type:'POST',
       url:'<?php echo $this->createUrl('SetUmur'); ?>',
       data: {tanggal_lahir : tanggal_lahir},//
       dataType: "json",
       success:function(data){
           $("#umur").val(data.umur);
       },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

/**
 * set form info pasien
 * @returns {undefined}
 */
function setInfoPasien(no_rekam_medik, pasien_id){
    $("#form-infopasien > div").addClass("animation-loading");
    var instalasi_id = $("#instalasi_id").val();
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetDataInfoPasien'); ?>',
        data: {no_rekam_medik:no_rekam_medik, pasien_id:pasien_id},
        dataType: "json",
        success:function(data){
            $("#<?php echo CHtml::activeId($modPasien,'pasien_id'); ?>").val(data.pasien_id);
            $("#<?php echo CHtml::activeId($modPasien,'jenisidentitas'); ?>").val(data.jenisidentitas);
            $("#<?php echo CHtml::activeId($modPasien,'no_identitas_pasien'); ?>").val(data.no_identitas_pasien);
            $("#<?php echo CHtml::activeId($modPasien,'namadepan'); ?>").val(data.nama_depan);
            $("#<?php echo CHtml::activeId($modPasien,'nama_pasien'); ?>").val(data.nama_pasien);
            $("#<?php echo CHtml::activeId($modPasien,'nama_bin'); ?>").val(data.nama_bin);
            $("#<?php echo CHtml::activeId($modPasien,'tempat_lahir'); ?>").val(data.tempat_lahir);
            $("#<?php echo CHtml::activeId($modPasien,'tanggal_lahir'); ?>").val(data.tanggal_lahir);
            $("#<?php echo CHtml::activeId($modPasien,'kelompokumur_id'); ?>").val(data.kelompokumur_id);
            $("#<?php echo CHtml::activeId($modPasien,'jeniskelamin'); ?>").val(data.jeniskelamin);
            $("#<?php echo CHtml::activeId($modPasien,'alamat_pasien'); ?>").val(data.alamat_pasien);
           
            $("#form-infopasien .tombol").attr('style','display:true;');
            
            $("#form-infopasien div").removeClass("animation-loading");
            setUmur(data.tanggal_lahir);
        },
        error: function (jqXHR, textStatus, errorThrown) { 
            myAlert("Data kunjungan tidak ditemukan!"); 
            console.log(errorThrown);
            setInfoPasienReset();
            $("#form-infopasien > div").removeClass("animation-loading");
            $("#instalasi_id").focus();
        }
    });
}
/*
 * reset form info pasien
 * @returns {undefined}
 */
function setInfoPasienReset(){
    $("#<?php echo CHtml::activeId($modPasien,'pasien_id'); ?>").val("");
    $("#<?php echo CHtml::activeId($modPasien,'jenisidentitas'); ?>").val("");
    $("#<?php echo CHtml::activeId($modPasien,'no_identitas_pasien'); ?>").val("");
    $("#<?php echo CHtml::activeId($modPasien,'namadepan'); ?>").val("");
    $("#<?php echo CHtml::activeId($modPasien,'nama_pasien'); ?>").val("");
    $("#<?php echo CHtml::activeId($modPasien,'nama_bin'); ?>").val("");
    $("#<?php echo CHtml::activeId($modPasien,'tempat_lahir'); ?>").val("");
    $("#<?php echo CHtml::activeId($modPasien,'tanggal_lahir'); ?>").val("");
    $("#<?php echo CHtml::activeId($modPasien,'kelompokumur_id'); ?>").val("");
    $("#<?php echo CHtml::activeId($modPasien,'jeniskelamin'); ?>").val("");
    $("#<?php echo CHtml::activeId($modPasien,'alamat_pasien'); ?>").val("");
    $("#noPasienApotek").val("");
    $("#umur").val("");
    
    $("#form-infopasien .tombol").attr('style','display:none;');
}
/**
 * refresh dialog kunjungan
 * @returns {undefined}
 */
/**
 * function ini harus tetap berada di bawah
 */
$(document).ready(function(){
    
    var penjualanresep_id = '<?php echo isset($modPenjualan->penjualanresep_id) ? $modPenjualan->penjualanresep_id : null; ?>';
    if(penjualanresep_id != ""){
        $("#table-obatalkespasien :input").attr("readonly",true);
        $("#table-obatalkespasien .add-on").remove();
        $("#table-obatalkespasien .icon-remove").remove();
        
        $("#penjualanbebas-form :input").attr("readonly",true);
        $("#penjualanbebas-form .dtPicker3").attr("readonly",true);
        $("#penjualanbebas-form .add-on").remove();
        
        $("input, select, textarea").attr("disabled",true);        
    }
});
</script>