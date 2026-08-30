
<?php $baseUrl = Yii::app()->createUrl("/");?>
<script type='text/javascript'>
function setTab(obj){
    $(obj).parents("ul").find("li").each(function(){
        $(this).removeClass("active");
        $(this).attr("onclick","setTab(this);");
    });

    if(!requiredCheck($("#kunjungan-form"))){
            myAlert('Inputan bertanda <font style = "color:red;">*</font> harap di isi !!');
            return false;
        }

    $(obj).addClass("active");
    $(obj).removeAttr("onclick","setTab(this);");
    var pendaftaran_id = $('#pendaftaran_id').val();
    var tab = $(obj).attr("tab");
    var frameObj = document.getElementById("frame");
    resetIframe(frameObj);
    $(frameObj).attr("src","<?php echo $baseUrl;?>?r="+tab+"&pendaftaran_id="+pendaftaran_id+"");
    $(frameObj).parent().addClass("animation-loading");
    $(frameObj).load(function(){
        $(frameObj).parent().removeClass("animation-loading");
        resizeIframe(frameObj);
    });
    return false;
}

function resetIframe(obj) {
    obj.style.height = 128 + 'px';
}

function resizeIframe(obj) {            
    obj.style.height = (obj.contentWindow.document.body.scrollHeight) + 'px';
}

function resizeIframeJs(obj) {  
    var h1 = obj.height();
    var h2 = 100;
    var h3 = h2+h1;
    
    obj.attr("style",'height:'+h3+'px');
}

function showTabulasi(obj) {
     setTab(obj);
}


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
                $("#pendaftaran_id").val(data.pendaftaran_id);
                $("#pasien_id").val(data.pasien_id);
                $("#jeniskasuspenyakit_id").val(data.jeniskasuspenyakit_id);
                $("#carabayar_id").val(data.carabayar_id);
                $("#penjamin_id").val(data.penjamin_id);
                $("#penanggungjawab_id").val(data.penanggungjawab_id);
                $("#instalasi_id").val(data.instalasi_id);
                $("#ruangan_id").val(data.ruangan_id);
                $("#kelaspelayanan_id").val(data.kelaspelayanan_id);
                $("#no_pendaftaran").val(data.no_pendaftaran);
                $("#penanggungJawab").val(data.penanggungJawab);
                $("#tgl_pendaftaran").val(data.tgl_pendaftaran);
                $("#instalasi_nama").val(data.instalasi_nama);
                $("#ruangan_nama").val(data.ruangan_nama);
                $("#jeniskasuspenyakit_nama").val(data.jeniskasuspenyakit_nama);
                $("#carabayar_nama").val(data.carabayar_nama);
                $("#penjamin_nama").val(data.penjamin_nama);
                $("#no_rekam_medik").val(data.no_rekam_medik);
                $("#namadepan").val(data.namadepan);
                $("#nama_pasien").val(data.nama_pasien);
                $("#nama_bin").val(data.nama_bin);
                $("#tanggal_lahir").val(data.tanggal_lahir);
                $("#umur").val(data.umur);
                $("#jeniskelamin").val(data.jeniskelamin);
                $("#nama_pj").val(data.nama_pj);
                $("#pengantar").val(data.pengantar);
                $("#kelaspelayanan_nama").val(data.kelaspelayanan_nama);
                $("#alamat_pasien").val(data.alamat_pasien);
                $("#PelayanankerohanianT_agama").val('hai');
                if(data.photopasien === null || data.photopasien === ""){ //set photo
                    $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
                }else{
                    $('#photo-preview').attr('src','<?php echo Params::urlPasienTumbsDirectory()."kecil_"?>'+data.photopasien);
                }
                

                $("#form-datakunjungan > legend > .judul").html('Data Kunjungan '+data.no_pendaftaran);
                $("#form-datakunjungan > legend > .tombol").attr('style','display:true;');
                $("#form-datakunjungan > .box").addClass("well").removeClass("box");
                setTab($("#menuBoot").find("#default-tab"));
            }
            $("#form-datakunjungan > div").removeClass("animation-loading");
            $("#no_pendaftaran").focus();
        },
        error: function (jqXHR, textStatus, errorThrown) { 
            myAlert("Data kunjungan tidak ditemukan !"); 
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
        
    $('#riwayat-obatalkespasien-t table > tbody').html("");
    $('#table-obatalkespasien > tbody').html(""); 
}
</script>
