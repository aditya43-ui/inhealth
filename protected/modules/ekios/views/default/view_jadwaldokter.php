<style type="text/css">
    .table th, .table td{padding:8px;line-height:35px;text-align:left;vertical-align:top;border-top:1px solid #ddd;font-size: 12px; font-family: monospace;}
</style>

<?php
$this->breadcrumbs=array(
    'View Asuransi'=>array('index'),
    $model->jadwaldokter_tgl,
);

$arrMenu = array();
    array_push($arrMenu,array('label'=>Yii::t('mds','View').' Jadwal Dokter ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php
	// var_dump($model[0]->ruangan->ruangan_nama);
	// exit;
	$jumlah = count($model);
	$tanggal = $model[0]->jadwaldokter_tgl;
?>

<table class="table table-hover table-hover table-bordered" >
    <caption><h4>Jadwal Dokter Tanggal <?php echo $tanggal ?></h4></caption>
    <thead>
	    <tr>
	    	<th>Nama Dokter</th>
		    <th>Ruangan</th>
		    <th>Instalasi</th>
		    <th>Jam Praktek</th>
		    </tr>
    </thead>
    <tbody>
    <?php
    	for($i=0;$i<=$jumlah;$i++){
    ?>	
	    <tr>
		    <td><?php echo $model[$i]->pegawai->nama_pegawai ?></td>
		    <td><?php echo $model[$i]->ruangan->ruangan_nama ?></td>
		    <td><?php echo $model[$i]->instalasi->instalasi_nama ?></td>
		    <td><?php echo $model[$i]->jadwaldokter_buka ?></td>
	    </tr>
	<?php } ?>    
    </tbody>
</table>