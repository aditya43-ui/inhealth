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
<?php $riwayatPasienIbu = Yii::app()->createUrl('rawatJalan/daftarPasien/getRiwayatPasien&id='.$modPasien->pasien_ibu_id); ?>
<script type='text/javascript'>

    const approveFrame = (obj, frameObj) => {
        $(obj).parents("ul").find("li").each(function() {
            $(this).removeClass("active");
            $(this).attr("onclick", "setTab(this);");
        });
        $(obj).addClass("active");
        $(obj).removeAttr("onclick", "setTab(this);");
        var tab = $(obj).attr("tab");

        resetIframe(frameObj);                
        if(tab == 'smart'){
            cekRM();
            $(frameObj).removeAttr("src","<?php echo $baseUrl;?>?r="+tab+"<?php echo $gets;?>");
            $(frameObj).parent().removeClass("animation-loading");
        }else{
            $(frameObj).attr("src","<?php echo $baseUrl;?>?r="+tab+"<?php echo $gets;?>");
            $(frameObj).parent().addClass("animation-loading");
        }
        $(frameObj).load(function() {
            $(frameObj).parent().removeClass("animation-loading");
            resizeIframe(frameObj);
        });
    }
    
    const cekSimpanTabulasi = (frameObj, tabObj, dari = 'tab') => {
        const form = $("#frame").contents().find('form.form-iframe');
        const active = $("#tab-periksa").find("li.active").length;

        let status = true;

        if (active == 0) {
            status = true;
        } else {
            const changed = form.attr("changed");
            if (changed == 'true') {
                myConfirm("Data belum disimpan. Apakah Anda ingin pindah tabulasi?", "Perhatian!", function(r) {
                    if (r) {
                        status = true;
                        approveFrame(tabObj, frameObj);
                    } else {
                        status = false;
                    }
                });
                return false;
            } else {
                status = true;
            }
        }
        return status;
    }

    function setTab(obj) {
        
        var frameObj = document.getElementById("frame");
        if (!cekSimpanTabulasi(frameObj, obj)){
            return false;
        }else{        
            approveFrame(obj, frameObj);
            return false;
        }
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
    obj.style.width = 100 + '%';
}
function resizeIframe(obj) {
    obj.style.height = (obj.contentWindow.document.body.scrollHeight) + 'px';
    obj.style.width = 100 + '%';
}

function resizeIframeJs(obj) {  
    var h1 = obj.height();
    var h2 = 100;
    var h3 = h2+h1;
    
    obj.attr("style",'height:<?php echo $default; ?>px; width: 100%');
}

$("#cekRiwayatPasien").change(function(){
    $('#divRiwayatPasien').slideToggle(500);
});

function cekRM(){
    const id = $(".idrm").val();
    // alert('no rm', console.log(id)); 
    window.open(`http://192.168.0.23/smartplus/history/pasien/`+ id , 'location=_new, width=900px');
}
</script>
<?php
Yii::app()->clientScript->registerScript('onLoadJs','
    setRiwayatPasien();
    setRiwayatPasienIbu();
', CClientScript::POS_READY);
?>
