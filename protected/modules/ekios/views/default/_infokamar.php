<style type="text/css">
	.idhome{
		cursor: pointer;
	}
</style>

<div class="block-kioskmodule" id="infokamar" name="infokamar">
	<legend class="rim idhome" onclick="home_kk()" data-toggle="tooltip" title="Klik Disini untuk kembali ke tampilan awal">KETERSEDIAAN KAMAR</legend><hr>
	<div id="daftarruangan" name="daftarruangan" class="contentKamar" style="max-height:400px;overflow-y: scroll;">
	<?php 
		$ruang = RuanganM::model()->findAll('instalasi_id = '.Params::INSTALASI_ID_RI);
		foreach ($ruang as $data => $nilai) {
			if(empty($nilai->ruangan_image) || $nilai->ruangan_image==''){
				$gambar = "images/noimage.jpg";
			}else{
				$gambar = "images/icon_menu/".$nilai->ruangan_image;
			}
	?>
			
	<?php 
		} 

		echo "&nbsp;&nbsp;<label>Pilih Ruangan</label>&nbsp;&nbsp;";
		echo CHtml::dropDownList('ruangan', '', CHtml::listData(RuanganM::model()->findAll('instalasi_id = '.Params::INSTALASI_ID_RI), 'ruangan_id', 'ruangan_nama'), array('empty'=>'-- Pilih --', 'onchange'=>'getListRuangan();')); 
	?>
	</div>
	<style>
    .contentKamar, .bed{
        -moz-box-shadow: 0px 5px 10px rgba(0,0,0,.6);
        -webkit-box-shadow: 0px 5px 10px rgba(0,0,0,.6);
        -o-box-shadow: 0px 5px 10px rgba(0,0,0,.6);
        -moz-border-radius:3px;
        -webkit-border-radius:3px;
        -o-border-radius:3px;
    }
    .contentKamar{
        border:1px solid black;
        margin:10px;
		height: 398px;
    }
    .bed{
        display:inline-block;
        width:13%;
        border-color:#ccc;
        margin:10px;
    }
    .popover-inner{
        width:100%;
    }
    .image_ruangan{
        height:100px;
        width:100px;
    }
	.pintu{
		background-image:url(images/pintu.png);
		width:16px;
		height:75px;
		margin-top:80px;
		float:right;
		margin-right:-2px;
	}
</style>

	<div class="isi">
		<?php echo $row; ?>
	</div>
</div>	
<?php 
	$url = Yii::app()->createUrl($this->route);
	Yii::app()->clientScript->registerScript('list', '
	    function getListRuangan($ruangan){
	    	$("#daftarruangan").hide();	    	
	        ruangan = $ruangan;
	        $.post("'.$url.'", {ajax:true,ruangan:ruangan},function(data){
	            $(".isi").html(data);
				$(".isi").show();
	            jQuery(\'a[rel="popover"]\').popover();
	            jQuery(\'.poping\').popover({placement:"bottom"});
	        },"json");
	    }
	',  CClientScript::POS_HEAD); 
?>
<?php Yii::app()->clientScript->registerScript('readyFunction','
    jQuery(\'.poping\').popover({placement:"bottom"});	    
	',  CClientScript::POS_READY); 
?>
<script type="text/javascript">
    function home_kk(){
    	$("#daftarruangan").show();
    	$(".isi").hide();
    }

</script>