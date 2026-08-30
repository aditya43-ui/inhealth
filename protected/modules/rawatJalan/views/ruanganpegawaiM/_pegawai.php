<ul>
<?php
	$modRuanganpegawai = RuanganpegawaiM::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id));
	foreach ($modRuanganpegawai as $row){
		echo '<li>'.$row->pegawai->gelardepan.' '.$row->pegawai->namalengkap.'</li>';
	}
?>
</ul>