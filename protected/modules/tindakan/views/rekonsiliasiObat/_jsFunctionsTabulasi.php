<?php
$gets = "";
if(isset($_GET)){
    foreach($_GET AS $name => $get){
      if(!is_array($get) && $name != "r") {
        if($name != 'pendaftaran_id'){
            $gets .= "&".$name."=".$get;
        }
      }
    }
}
?>
<?php $baseUrl = Yii::app()->createUrl("/");?>
<script type='text/javascript'>
function setTab(obj){
    $(obj).parents("ul").find("li").each(function(){
        $(this).removeClass("active");
//        $(this).attr("onclick","setTab(this);");
    });

    var pendaftaran_id = $('#<?php echo CHtml::activeId($modPendaftaran,'pendaftaran_id') ?>').val();

    if(pendaftaran_id != ''){
      $(obj).addClass("active");
      var tab = $(obj).attr("tab");
      var frameObj = document.getElementById("frame");

      var urlpendaftaran = '&pendaftaran_id='+pendaftaran_id;
      resetIframe(frameObj);
      $(frameObj).attr("src","<?php echo $baseUrl;?>?r="+tab+"<?php echo $gets;?>"+urlpendaftaran);
      $(frameObj).parent().addClass("animation-loading");
      $(frameObj).load(function(){
          $(frameObj).parent().removeClass("animation-loading");
          resizeIframe(frameObj);
      });
    }else{
      myAlert('Silakan isi Data Pasien !!')
    }
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

function getRiwayatData(pendaftaran_id){
  $.fn.yiiGridView.update('riwayatAlergiAdmisi-grid', {
    data: {
      "RekonobatadmisiT[pendaftaran_id]":pendaftaran_id
    }
  });

  $.fn.yiiGridView.update('riwayatAlergiObat-grid', {
    data: {
      "RekonobatalergiT[pendaftaran_id]":pendaftaran_id
    }
  });

  $.fn.yiiGridView.update('riwayatAlergiDischarge-grid', {
    data: {
      "RekonobatdischargeT[pendaftaran_id]":pendaftaran_id
    }
  });

  $.fn.yiiGridView.update('riwayatAlergiTransfer-grid', {
    data: {
      "RekonobattransferT[pendaftaran_id]":pendaftaran_id
    }
  });
}

</script>
