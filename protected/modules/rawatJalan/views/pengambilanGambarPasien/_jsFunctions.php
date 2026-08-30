<?php
$gets = "";

if(isset($_GET)){    
    foreach($_GET AS $name => $get){
        if($name == "r")
            $gets .= "&".$name."=".$get;
    } 
}
?>
<?php $baseUrl = Yii::app()->createUrl("/");
// var_dump($baseUrl); die;
?>
<script type="text/javascript">
/**
 * set form kunjungan
 * @param {type} pendaftaran_id
 * @returns {undefined}
 */
function setKunjungan(pendaftaran_id){
    $("#form-datakunjungan > div").addClass("animation-loading");
    window.location.href = "<?php echo $this->createUrl("index"); ?>&pendaftaran_id="+pendaftaran_id;
    setJudulPhoto();
}

function setJudulPhoto(){
    var nama_pasien = $("#nama_pasien").val();
    var no_pendaftaran = $("#no_pendaftaran").val();
    var judulphotopemeriksaan = $("#judulphotopemeriksaan").val();
    if(judulphotopemeriksaan == ''){
       judulphotopemeriksaan = nama_pasien +'-' + no_pendaftaran;
    }
    $("#judulphoto").val(judulphotopemeriksaan);
}
/**
 * untuk mereset form kunjungan
 * @returns {undefined} */
function setKunjunganReset(){
    $("#form-datakunjungan input,textarea").each(function(){
        $(this).val("");
    });
    $("#ruangan_id").val(<?php echo $modKunjungan->ruangan_id; ?>);
    $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
    $("#form-datakunjungan > legend > .judul").html('Data Kunjungan');
    $("#form-datakunjungan > legend > .tombol").attr('style','display:none;');
    $("#form-datakunjungan > .well").addClass("box").removeClass("well");
        
}

function updatePhoto(obj){
    var pendaftaran_id = '<?php echo isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : null; ?>';
    var photopemeriksaan_id = $(obj).parents('.caption').find('#photopemeriksaan_id').val();
    var judulphoto = $('#judulphoto').val();
    var keteranganphoto = $(obj).parents('.caption').find('#photo_description').val();
    
    if(photopemeriksaan_id != '')
    {
        $(obj).parent('div').addClass("animation-loading");
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('updatePhoto'); ?>',
            data: {pendaftaran_id:pendaftaran_id,photopemeriksaan_id:photopemeriksaan_id,judulphoto:judulphoto,keteranganphoto:keteranganphoto},
            dataType: "json",
            success:function(data){
                $(obj).parent('div').removeClass("animation-loading");
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);$("#form-datakunjungan > div").removeClass("animation-loading");}
        });
    }else{
        myAlert("Silakan pilih data pasein terlebih dahulu!");
    }
}

function setEdit(obj){
    $(obj).parents('.photo').find('#photo_description').removeAttr('readonly');
    $(obj).parents('.photo').find('#photo_description').focus();
}

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
    console.log("<?php echo $baseUrl;?>?r="+tab);
    $(frameObj).attr("src","<?php echo $baseUrl;?>?r="+tab);
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

function refreshGallery(){
    document.getElementById('frame').contentWindow.location.reload(true);
    location.reload;
}

function updateGallery(obj,photopemeriksaan_id){
    var photopemeriksaan_id = photopemeriksaan_id;
    var status = true;   
    if(photopemeriksaan_id != '')
    {
        $(obj).parent().parent().addClass("animation-loading");
        window.parent.$('.sorter').addClass("animation-loading");
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('updateGalleryView'); ?>',
            data: {id:photopemeriksaan_id,status:status},
            dataType: "json",
            success:function(data){
                if(data.pesan == 'OK'){                    
                    window.parent.location.reload();  
                    window.parent.$('.sorter').removeClass("animation-loading");
                    location.reload();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);$("#form-datakunjungan > div").removeClass("animation-loading");}
        });
    }else{
        myAlert("Silakan pilih data pasein terlebih dahulu!");
    }
}

/**
 * function ini harus tetap berada di bawah
 */
$(document).ready(function() {
var pendaftaran_id = $('#pendaftaran_id').val();
if(pendaftaran_id != ''){
    setJudulPhoto();
}
/*
*   show - images
*/
$("a#show7").fancybox({
        'titlePosition'	: 'inside',
        'width'         : '25%',
        'height'        : '25%',
        'autoScale'     : false,
        'transitionIn'  : 'elastic',
        'transitionOut' : 'none',
});

$("a[rel=example_group]").fancybox({
        'transitionIn'		: 'none',
        'transitionOut'		: 'none',
        'titlePosition' 	: 'over',
        'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
                return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
        }
});
});
</script>