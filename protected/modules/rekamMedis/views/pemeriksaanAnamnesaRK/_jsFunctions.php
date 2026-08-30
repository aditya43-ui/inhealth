<?php
$gets = "";
//if(isset($_GET)){
  //  foreach($_GET AS $name => $get){
  //      if($name != "r")
   //         $gets .= "&".$name."=".$get;
   // }
//}
?>
<?php $baseUrl = Yii::app()->createUrl("/");?>
<?php //$riwayatPasien = Yii::app()->createUrl('rawatJalan/daftarPasien/getRiwayatPasien&id='.$modPasien->pasien_id); ?>
<script type='text/javascript'>
function setTab(obj){   
    
    $(obj).parents("ul").find("li").each(function(){
        $(this).removeClass("active");
        $(this).attr("onclick","setTab(this);");
    });
    $(obj).addClass("active");
    $(obj).removeAttr("onclick","setTab(this);");
    var tab = $(obj).attr("tab");
    var frameObj = document.getElementById("frame");
    resetIframe(frameObj);
    if (document.getElementById("RKPendaftaranT_pendaftaran_id").value == ''){
        $(frameObj).attr("src","");
    }else{        
        $(frameObj).attr("src","<?php echo $baseUrl;?>?r="+tab+"&pendaftaran_id="+document.getElementById("RKPendaftaranT_pendaftaran_id").value);
    }
    $(frameObj).parent().addClass("animation-loading");
    $(frameObj).load(function(){
        $(frameObj).parent().removeClass("animation-loading");
        resizeIframe(frameObj);
    });
    return false;
}
/*function setRiwayatPasien(){
    var frameObj = document.getElementById("riwayatPasien");
    $(frameObj).attr("src","<?php //echo $riwayatPasien;?>");
    $(frameObj).parent().addClass("animation-loading");
    $(frameObj).load(function(){
        resizeIframe(frameObj);
        $(frameObj).parent().removeClass("animation-loading");
        $("#divRiwayatPasien").slideToggle(500);
    });
    return false;
}*/
function resetIframe(obj) {
    obj.style.height = 128 + 'px';
}
function resizeIframe(obj) {
    obj.style.height = (obj.contentWindow.document.body.scrollHeight) + 'px';
}
$("#cekRiwayatPasien").change(function(){
    $('#divRiwayatPasien').slideToggle(500);
});

function setKunjungan(pendaftaran_id){
    $("#form-datakunjungan > div").addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetDataKunjungan'); ?>',
        data: {pendaftaran_id:pendaftaran_id},
        dataType: "json",
        success:function(data){
            if(data.pesan != ""){
                myAlert(data.pesan);
                setKunjunganReset();
            }else{
                $("#RKPendaftaranT_tgl_pendaftaran").val(data.tgl_pendaftaran);
                $("#RKPendaftaranT_pendaftaran_id").val(data.pendaftaran_id);
                $("#RKPendaftaranT_no_pendaftaran").val(data.no_pendaftaran);
                $("#no_pendaftaran").val(data.no_pendaftaran);
                $("#no_rekam_medik").val(data.no_rekam_medik);
                $("#nama_pasien").val(data.nama_pasien);
                $("#RKPendaftaranT_umur").val(data.umur);
                $("#RKPasienM_no_rekam_medik").val(data.no_rekam_medik);
                $("#RKPasienM_nama_pasien").val(data.nama_pasien);
                $("#RKPasienM_jeniskelamin").val(data.jeniskelamin);
                $("#RKPendaftaranT_jeniskasuspenyakit_nama").val(data.jeniskasuspenyakit_nama);
                $("#RKPendaftaranT_namaLengkap").val(data.namaLengkap);
                $("#RKPendaftaranT_carabayar_nama").val(data.carabayar_nama);
                $("#RKPendaftaranT_penjamin_nama").val(data.penjamin_nama);
                $("").addClass("active")
        
                if(data.photopasien === null || data.photopasien === ""){ //set photo
                    $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
                }else{
                    $('#photo-preview').attr('src','<?php echo Params::urlPasienTumbsDirectory()."kecil_"?>'+data.photopasien);
                }                                

                $("#form-datakunjungan > legend > .judul").html('Data Kunjungan '+data.no_pendaftaran);
                $("#form-datakunjungan > legend > .tombol").attr('style','display:true;');
                $("#form-datakunjungan > .box").addClass("well").removeClass("box");
                                
                setTab($("#anamnesaTab"));
            }
            $("#form-datakunjungan > div").removeClass("animation-loading");
           
        },
        error: function (jqXHR, textStatus, errorThrown) { 
            myAlert("Data kunjungan tidak ditemukan!"); 
            console.log(errorThrown);
            setKunjunganReset();
            $("#form-datakunjungan > div").removeClass("animation-loading");
            $("#no_pendaftaran").focus();
        }
    });

}

function setKunjunganReset(){
    $("#form-datakunjungan input,textarea").each(function(){
        $(this).val("");
    });    
    $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
    $("#form-datakunjungan > legend > .judul").html('Data Kunjungan');
    $("#form-datakunjungan > legend > .tombol").attr('style','display:none;');
    $("#form-datakunjungan > .well").addClass("box").removeClass("well"); 
    
    //$("#anamnesaTab").removeClass('active');
    
    var frameObj = document.getElementById("frame");
    $("#frame").attr('src','');
    resetIframe(frameObj);
}

</script>
<?php
//Yii::app()->clientScript->registerScript('onLoadJs','
  //  setRiwayatPasien();
//', CClientScript::POS_READY);
?>
