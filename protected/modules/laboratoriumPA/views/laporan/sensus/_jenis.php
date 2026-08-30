<?php $modPemeriksaan = LaporansensusradiologiV::model()->findAll('pendaftaran_id = '.$id); ?>
<ul>
<?php foreach ($modPemeriksaan as $row){
    echo '<li>'.$row->pemeriksaanrad_jenis.'</li>';
}?>
</ul>
