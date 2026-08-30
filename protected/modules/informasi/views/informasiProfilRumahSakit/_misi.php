<div class="judul"><h2>MISI RUMAH SAKIT</h2></div>
<div class="isi">
	<ol>
	<?php 
	if(count((array)$modMisiRS) > 0){
		foreach ($modMisiRS as $i => $val) {
			echo '<li>'.$val->misi.'</li>';
		}
	}
	?>
	</ol>
</div>