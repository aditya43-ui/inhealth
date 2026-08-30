<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Dokumentasi Manajer Pelayanan Pasien
        </div>
    </div>
    <div class="panel-body">

	<?php
	$this->breadcrumbs=array(
		'Daftar Pasien'=>Yii::app()->request->urlReferrer,
		'Dokumentasi Manajer Pelayanan Pasien',
	);
	?>

	<?php
	$this->renderPartial($this->path_view.'_dataPasien',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien, 'diagnosa_nama'=>$diagnosa_nama));
	?>
  <div class="panel panel-success">
      <div class="panel-heading">
          <div class="panel-title">
              Riwayat
          </div>
      </div>
      <div class="panel-body">
        <?php echo $this->renderPartial($this->path_view.'_riwayatTable',array('modPendaftaran'=>$modPendaftaran)); ?>
      </div>
</div>
  <?php $this->renderPartial($this->path_view.'_tabMenu',array()); ?>
  <div>
  <iframe id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll; overflow-x: scroll;" ></iframe>
  </div>

    </div>
</div>
<?php $this->renderPartial($this->path_view.'_jsFunctions',array("modPasien"=>$modPasien, 'modPendaftaran'=>$modPendaftaran)); ?>

<script>
    
    function editSkrining(pendaftaran_id, typeinstalasi, skrining_id) {
        $(".tabber li").attr("class", "");
        $("#tabber_skrining").attr("class", "active");
        $("#dialogDetailSkrining").dialog("close");
        
        var frameObj = document.getElementById("frame");
        resetIframe(frameObj);
        $(frameObj).attr("src","<?php echo $this->createUrl('/rekamMedis/skrinningT/index'); ?>&pendaftaran_id=" + pendaftaran_id + "&typeinstalasi=" + typeinstalasi + "&id=" + skrining_id);
        $(frameObj).parent().addClass("animation-loading");
        $(frameObj).load(function(){
            $(frameObj).parent().removeClass("animation-loading");
            resizeIframe(frameObj);
        });
    }
    
    function editEvaluasi(pasien_id, typeinstalasi, evaluasiawal_id) {
        $(".tabber li").attr("class", "");
        $("#tabber_evaluasi").attr("class", "active");
        $("#dialogDetailEvaluasiAwal").dialog("close");
        
        var frameObj = document.getElementById("frame");
        resetIframe(frameObj);
        $(frameObj).attr("src","<?php echo $this->createUrl('/rekamMedis/evaluasiAwal/index'); ?>&pasien_id=" + pasien_id + "&typeinstalasi=" + typeinstalasi + "&evaluasi_id=" + evaluasiawal_id);
        $(frameObj).parent().addClass("animation-loading");
        $(frameObj).load(function(){
            $(frameObj).parent().removeClass("animation-loading");
            resizeIframe(frameObj);
        });
    }
    
    function editImplementasi(pasien_id, typeinstalasi, catatanimplementasi_id) {
        $(".tabber li").attr("class", "");
        $("#tabber_implementasi").attr("class", "active");
        $("#dialogDetailCatatan").dialog("close");
        
        var frameObj = document.getElementById("frame");
        resetIframe(frameObj);
        $(frameObj).attr("src","<?php echo $this->createUrl('/rekamMedis/catatanImplementasi/index'); ?>&pasien_id=" + pasien_id + "&typeinstalasi=" + typeinstalasi + "&catatanimplementasi_id=" + catatanimplementasi_id);
        $(frameObj).parent().addClass("animation-loading");
        $(frameObj).load(function(){
            $(frameObj).parent().removeClass("animation-loading");
            resizeIframe(frameObj);
        });
    }
    
</script>
