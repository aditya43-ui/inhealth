
<?php $tindakan = ROLaporanrekaptransaksi::model()->findAll("pendaftaran_id = '".$id."' AND ruangan_id = '".$ruangan_id."' "); ?>
<ul>
<?php foreach ($tindakan as $row){
    echo '<li>'.$row->daftartindakan_nama.'</li>';
}?>
</ul>
