<ul>
	<?php
	$modKasuspenyakitruangan = KasuspenyakitruanganM::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id));
	foreach ($modKasuspenyakitruangan as $row){
		echo '<li>'.$row->jeniskasuspenyakit->jeniskasuspenyakit_nama.'</li>';
	}
	?>
</ul>