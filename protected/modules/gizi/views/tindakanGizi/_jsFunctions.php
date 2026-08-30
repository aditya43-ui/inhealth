<?php
$gets = '';
if (empty($default)) {
    $default = 200;
}
?>
<?php $baseUrl = Yii::app()->createUrl("/");?>
<?php $riwayatPasien = Yii::app()->createUrl('rawatJalan/daftarPasien/getRiwayatPasien&id='.$modPasien->pasien_id); ?>
<?php $riwayatPasienIbu = Yii::app()->createUrl('rawatJalan/daftarPasien/getRiwayatPasien&id='.$modPasien->pasien_ibu_id); ?>
<script type='text/javascript'>
function setTab(obj){
    $(obj).parents("ul").find("li").each(function(){
        $(this).removeClass("active");
        $(this).attr("onclick","setTab(this);");
    });
    $(obj).addClass("active");
    // $(obj).removeAttr("onclick","setTab(this);");
    var tab = $(obj).attr("tab");
    var frameObj = document.getElementById("frame");
    resetIframe(frameObj);
    $(frameObj).attr("src","<?php echo $baseUrl;?>?r="+tab+"<?php echo $gets;?>");
    $(frameObj).parent().addClass("animation-loading");
    $(frameObj).load(function(){
        $(frameObj).parent().removeClass("animation-loading");
        resizeIframe(frameObj);
    });
    return false;
}
function setRiwayatPasien(){
    //var frameObj = document.getElementById("riwayatPasien");
    //$(frameObj).attr("src","<?php echo $riwayatPasien;?>");
    //$(frameObj).parent().addClass("animation-loading");
    //$(frameObj).load(function(){
      //  resizeIframe(frameObj);
        //$(frameObj).parent().removeClass("animation-loading");
        //$("#divRiwayatPasien").slideToggle(500);
    //});
     var frameObj = document.getElementById("riwayatPasien");
    var jsframe = $("#riwayatPasien");
    
    
    
    jsframe.attr("src","<?php echo $riwayatPasien;?>");
    jsframe.parent().addClass("animation-loading");    
    jsframe.on('load', function() {         
        resizeIframeJs(jsframe);
        jsframe.parent().removeClass("animation-loading");            
    }); 
    return false;
}

function setRiwayatPasienIbu(){
    //var frameObj = document.getElementById("riwayatPasien");
    //$(frameObj).attr("src","<?php echo $riwayatPasienIbu;?>");
    //$(frameObj).parent().addClass("animation-loading");
    //$(frameObj).load(function(){
      //  resizeIframe(frameObj);
        //$(frameObj).parent().removeClass("animation-loading");
        //$("#divRiwayatPasien").slideToggle(500);
    //});
     var frameObj = document.getElementById("riwayatPasienIbu");
    var jsframe = $("#riwayatPasienIbu");
    
    
    
    jsframe.attr("src","<?php echo $riwayatPasienIbu;?>");
    jsframe.parent().addClass("animation-loading");    
    jsframe.on('load', function() {         
        resizeIframeJs(jsframe);
        jsframe.parent().removeClass("animation-loading");            
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
    
    obj.attr("style",'height:<?php echo $default; ?>px');
}

$("#cekRiwayatPasien").change(function(){
    $('#divRiwayatPasien').slideToggle(500);
});
</script>
<?php
Yii::app()->clientScript->registerScript('onLoadJs','
    setRiwayatPasien();
    setRiwayatPasienIbu();
', CClientScript::POS_READY);
?>
