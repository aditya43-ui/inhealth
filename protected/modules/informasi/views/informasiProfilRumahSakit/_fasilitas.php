<div class="judul"><h2>FASILITAS KESEHATAN RUMAH SAKIT</h2></div>
<div class="isi">
	<ol>
	<?php 
		foreach ($modInstalasi as $i => $val) {
			echo '<li>'.$val->instalasi_nama.'</li>';
		}
	?>
	</ol>
</div>