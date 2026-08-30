<script type="text/javascript">
<?php
    $random=date('YmdHis').rand(0000000000000000, 9999999999999999);
    echo $random;
?>

/**
 * ambil gambar pada webcam
 * @returns {Boolean}
 */
function ambilGambar(){
    webcam.freeze();
    $("#btn_ambil_gambar").attr("disabled",true);
    $("#btn_simpan_gambar").removeAttr("disabled");
}
/**
 * menyimpan / meng-upload gambar
 * @returns {undefined}
 */
function simpanGambar() {
    $("#btn_simpan_gambar").attr("disabled",true);
    document.getElementById('upload_results').innerHTML = '<h3>Proses Penyimpanan...</h3>';
//    webcam.snap(); << sering bugs hasil photo blank putih
    webcam.upload();
}
/**
 * mengulang pengambilan gambar
 * @returns {undefined}
 */
function ulangGambar(){
    $("#btn_ambil_gambar").removeAttr("disabled");
    $("#btn_simpan_gambar").attr("disabled",true);
    webcam.reset();
}

/**
 * keterangan setelah berhasil ambil gambar webcam
 * @returns {Boolean}
 */
function suksesUpload(msg) {
    if (msg == 'OK'){
            $('#photo-preview').attr('src','<?php echo Params::urlPegawaiDirectory()."no_photo.jpeg"?>');
            setTimeout(function(){
                document.getElementById('upload_results').innerHTML = '';
                $("#<?php echo CHtml::activeId($modPegawai,'photopegawai') ?>").val("<?php echo $random ?>.jpg")
                $('#photo-preview').attr('src','<?php echo Params::urlPegawaiTumbsDirectory()."kecil_".$random;?>.jpg');
                simpanFotoDb();
                $('#dialog-addphoto').dialog('close');
            },3000);
            
    }else{
        myAlert("PHP Error: " + msg);
    }
}
function simpanFotoDb(){
    var pegawaiId = <?php echo $modPegawai->pegawai_id ?>;
    var photoPegawai = $("#<?php echo CHtml::activeId($modPegawai,'photopegawai') ?>").val();
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SimpanFoto'); ?>',
        data: {pegawaiId:pegawaiId,photoPegawai:photoPegawai},
        dataType: "json",
        success:function(data){
            myAlert(data.pesan);
            return true;
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

function refresh(pilihan){
    switch(pilihan) {
        case 'todolist':
            $.fn.yiiListView.update("listTodolist");
        break;
        case 'pengumuman':
            $.fn.yiiListView.update("list-pengumuman");
        break;
        // default:
        //     default code block
    }
}

function resizeIframe(obj){
    obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
}

function resetIframe(obj) {
    obj.style.height = 128 + 'px';
}

<?php $urlKalender = Yii::app()->createUrl("pendaftaranPenjadwalan/ModuleDashboard/SetKalender"); ?>

function setKalender(){
    var obj_kalender = document.getElementById("ifkalender");
    resetIframe(obj_kalender);
    $(obj_kalender).attr('src', '<?php echo $urlKalender ?>');
    $(obj_kalender).parent().addClass("animation-loading");
    $(obj_kalender).load(function(){
        $(obj_kalender).parent().removeClass("animation-loading");
        resizeIframe(obj_kalender);
    });
    return false;
}

<?php $urlStatistik = Yii::app()->createUrl("pendaftaranPenjadwalan/ModuleDashboard/SetStatistik"); ?>

function setStatistik(){
    var obj_kalender = document.getElementById("ifstatistik");
    resetIframe(obj_kalender);
    $(obj_kalender).attr('src', '<?php echo $urlStatistik ?>');
    $(obj_kalender).parent().addClass("animation-loading");
    $(obj_kalender).load(function(){
        $(obj_kalender).parent().removeClass("animation-loading");
        resizeIframe(obj_kalender);
    });
    return false;
}

$( document ).ready(function(){
    /**
    * set webcam
    * @returns {Boolean}
    */
    
    setStatistik();
    setKalender();

    function setWebcam(){
        webcam.set_api_url( 'index.php?r=photoWebCam/jpegcam.saveJpg&random=<?php echo $random;?>&pathTumbs=<?php echo Params::pathPegawaiTumbsDirectory();?>&path=<?php echo Params::pathPegawaiDirectory(); ?>' );
        webcam.set_quality( 90 );
        webcam.set_shutter_sound( false );
        webcam.set_stealth( 1 );
        webcam.set_swf_url('<?php echo Yii::app()->baseUrl.'/js/jpegcam/assets/'; ?>webcam.swf');
        $('#cam-preview').append(webcam.get_html(303, 320));
        webcam.set_hook( 'onComplete', 'suksesUpload' );
    }
    setWebcam();
});

// function setKalender(){

//     $("#content-kalender > .accordion-inner").addClass('animation-loading');
//     $.ajax({
//         type:'POST',
//         url:'<?php echo $this->createUrl('SetKalender'); ?>',
//         data: {},
//         dataType: "json",
//         success:function(data){
//             $("#content-kalender > .accordion-inner").html(data.konten_kalender);
//             $("#content-kalender > .accordion-inner").removeClass('animation-loading');
//             return true;
//         },
//         error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
//     });
//     }  

</script>