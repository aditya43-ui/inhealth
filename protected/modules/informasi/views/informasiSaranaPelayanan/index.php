<style type="text/css">
.white-container{ padding: 0 10px 0 0; border:none;}
.row{margin: 0;}
.iconrs img { margin: 15px 0;}
.kiri{border: 1px solid #006600;min-height: 350px; width: 250px;}

.menuFasilitas{
	font-weight: bold;
	padding: 15px 5px 5px 5px;
	color: #1b61a6;
}

.kiri ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    width: 245px;
    background-color: #f1f1f1;
}

.kiri li a {
    display: block;
    color: #000;
    padding: 8px 16px;
    text-decoration: none;
	cursor: pointer;
}

.kiri li.active a {
	color: #fff;
}

.kiri li a:hover {
    background-color: #555;
    color: white;
}
.active{
		background-color: #555;
	}
	.konten{
		padding: 10px 10px;
	}
	.judul{
		text-align: center;
		background-color: #00802b;
		padding: 5px;
		color: #FFF;
		border-radius:5px;
		box-shadow: 0 6px 5px rgba(0, 0, 0, 0.25);
	}
	.judul h2{
		color: #FFF;
		text-shadow: -1px 0 #000, 0 1px #000, 1px 0 #000, 0 -1px #000;
		font-size: 16pt;
		font-weight: bold;
	}
	.isi{
		background: rgba(0, 153, 0, 0.1);
		padding: 25px 20px;
	}
	.arrowPlush{
		margin: 15px 5px 0 0;
	}
	.lfloat{ float: left;}
	.rfloat{ float: right;}
	.fclear{ clear: both; float: none;}
	.pasilitasPenunjangShow, .paketPelayananShow{ display: none;}
	.pasilitasUtama, .pasilitasPenunjang, .paketPelayanan{ cursor: pointer;}
</style>
<div class="white-container">
    <div class="row">
		<div class="span3">
			<div class="iconrs">
			<img src="<?php echo Params::urlProfilRSDirectory().$model->logo_rumahsakit ?>" width="150">
			</div>
			<div class="kiri testclick">
				
<div class="pasilitasUtama">		
	<div class="menuFasilitas lfloat">  &#9745; <?php echo $fasilitas_utama_title->nama_static_page; ?></div>
	<i class="rfloat arrowPlush icon-minus-sign"></i>
	<div class="fclear"></div>
</div>
<!--<i class="icon-minus-sign"></i>-->
<ul class="pasilitasUtamaShow">
	<?php 
	foreach ($fasilitas_utama as $i => $fasilitasUtama){
		if($fasilitasUtama->static_page_id == 65){
			echo '<li class="foricon active"><a onclick="getInfoFasilitas(\''.$fasilitasUtama->static_page_id.'\');">'.$fasilitasUtama->nama_static_page.'</a></li>';
		}
		else{
			echo '<li class="foricon"><a onclick="getInfoFasilitas(\''.$fasilitasUtama->static_page_id.'\');">'.$fasilitasUtama->nama_static_page.'</a></li>';
		}
	}
	?>
</ul>

<div class="pasilitasPenunjang">
	<div class="menuFasilitas lfloat">  &#9745; <?php echo $fasilitas_penunjang_title->nama_static_page; ?></div>
	<i class="rfloat arrowPlush icon-plus-sign"></i>
	<div class="fclear"></div>
</div>
<ul class="pasilitasPenunjangShow">
	<?php 
	foreach ($fasilitas_penunjang as $i => $fasilitasPenunjang){
		echo '<li class="foricon"><a onclick="getInfoFasilitas(\''.$fasilitasPenunjang->static_page_id.'\');">'.$fasilitasPenunjang->nama_static_page.'</a></li>';
	}
	?>
</ul>

<div class="paketPelayanan">
	<div class="menuFasilitas lfloat">  &#9745; Paket Pelayanan</div>
	<i class="rfloat arrowPlush icon-plus-sign"></i>
	<div class="fclear"></div>
</div>
<ul class="paketPelayananShow">
	<?php 
	foreach($modProduk as $i => $Produk) {
		echo '<li class="foricon"><a onclick="getInfoProduk(\''.$Produk->produk_id.'\');">'.$Produk->nama_produk.'</a></li>';
	}
	?>
</ul>

			</div>
		</div>
		<div class="span9">
			<div class="konten contentData">
				
				
				<div class="judul"><h2> FASILITAS <?php echo strtoupper($modFasilitas->nama_static_page); ?></h2></div>
				<div class="isi">
					<?php 
						echo $modFasilitas->nama_lainnya_static_page; 
						echo $modFasilitas->deskripsi_static_page; 
					?>
				</div>

			</div>
		</div>
	</div>
</div>

<script>
$(".foricon").click(function() {
    $(".active").removeClass("active");
    $(this).addClass("active");
});	
$(".pasilitasUtama").click(function(){
    $(".pasilitasUtamaShow").slideToggle();
});
$(".pasilitasPenunjang").click(function(){
    $(".pasilitasPenunjangShow").slideToggle();
});
$(".paketPelayanan").click(function(){
    $(".paketPelayananShow").slideToggle();
});

function getInfoFasilitas(listData)
{
    $(".contentData").addClass("animation-loading");
	$.post('<?php echo $this->createUrl('ajaxInfoFasilitas') ?>', {listData:listData}, function(data){
         $(".konten").html(data.isidata);
		 $(".contentData").removeClass("animation-loading");
    },'json');
}

function getInfoProduk(listData)
{
    $(".contentData").addClass("animation-loading");
	$.post('<?php echo $this->createUrl('ajaxInfoProduk') ?>', {listData:listData}, function(data){
         $(".konten").html(data.isidata);
		 $(".contentData").removeClass("animation-loading");
    },'json');
}
</script>
