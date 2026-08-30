<?php
$daftar = PendaftaranT::model()->findAllByAttributes(array('pasien_id'=>$modPasien->pasien_id));
$count = count((array)$daftar) * 90;
$default = 100+ $count; 

$gets = "";
if(isset($_GET)){
    foreach($_GET AS $name => $get){
        if($name != "r")
            $gets .= "&".$name."=".$get;
    }
}
?>
<?php $baseUrl = Yii::app()->createUrl("/");?>
<?php $riwayatPasien = Yii::app()->createUrl('rawatJalan/daftarPasien/getRiwayatPasien&id='.$modPasien->pasien_id); ?>
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

function callDialog(obj){
    $('#dialogAsesmen').dialog('open');
    $('#judul ').html($(obj).attr('ases-judul'));				
    
    $('#frameAsesmen').attr('src', $(obj).attr('ases-src'));				
}

function callIPOC(obj){
   $('#dialogAsesmenRevisiRencana').dialog('open');
   $('#judul-tambah').html($(obj).attr('ases-judul'));
   $('#frameTambah').attr('src', $(obj).attr('ases-url'));	
}

function refreshIframe(){
    document.getElementById('frameAsesmen').contentDocument.location.reload(true);				
}

$("#cekRiwayatPasien").change(function(){
    $('#divRiwayatPasien').slideToggle(500);
});
</script>
<?php
Yii::app()->clientScript->registerScript('onLoadJs','
    setRiwayatPasien();
', CClientScript::POS_READY);
?>
