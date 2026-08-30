<?php 

$len = count((array)$mod);
if ($len < 20) $len = 20;

$denyut = array();
$tekanan = array();

$ketuban = array();
$penyusupan = array();

$oksitosin = array();
$tetes = array();

$protein = array();
$aseton = array();
$volume = array();

$pembukaan = array();
$penutupan = array();

$kontraksi = array();

$bcol = array(
	'<20' => '#eee',
	'20-40' => '#aaa',
	'>40' => 'black',
);
$col = array(
	'<20' => 'black',
	'20-40' => 'white',
	'>40' => 'white',
);

for($i = 0; $i < $len; $i++) {
	$denyut[$i] = array(
		'data'=>$i + 1, 'jumlah'=>null
	);
	$tekanan[$i] = array(
		'data'=>$i + 1, 'jumlah'=>null,
	);
	
	$kontraksi[$i] = array(
		'kontraksi'=>null, 'lama'=>null, 'lamac'=>null,
	);
	
	$ketuban[$i] = null;
	$penyusupan[$i] = null;
	
	$pembukaan[$i] = null;
	$penutupan[$i] = null;
	
	
	
	$oksitosin[$i] = null;
	$tetes[$i] = null;
	
	
	$protein[$i] = null;
	$aseton[$i] = null;
	$volume[$i] = null;
	
	
	if (!empty($mod[$i])) $denyut[$i]['jumlah'] = $mod[$i]->pto_djj_menit;
	if (!empty($mod[$i])) $tekanan[$i]['jumlah'] = $mod[$i]->pto_systolic;
	if (!empty($mod[$i])) $ketuban[$i] = substr($mod[$i]->pto_airketuban,0,1);
	if (!empty($mod[$i])) $penyusupan[$i] = $mod[$i]->pto_penyusupan;
	if (!empty($mod[$i])) $oksitosin[$i] = $mod[$i]->kontraksi_oksitosin_unit;
	if (!empty($mod[$i])) $tetes[$i] = $mod[$i]->kontraksi_tetes_menit;
	
	if (!empty($mod[$i])) $protein[$i] = $mod[$i]->urine_protein;
	if (!empty($mod[$i])) $aseton[$i] = $mod[$i]->urine_aseton;
	if (!empty($mod[$i])) $volume[$i] = $mod[$i]->urine_volumen;
	
	if (!empty($mod[$i])) $pembukaan[$i] = $mod[$i]->pto_pembukaan;
	if (!empty($mod[$i])) $penutupan[$i] = $mod[$i]->pto_penutupan;
	
	if (!empty($mod[$i])) {
		$kontraksi[$i]['kontraksi'] = $mod[$i]->kontraksi_jml;
		$kontraksi[$i]['lamac'] = $col[$mod[$i]->kontraksi_lama_detik];
		$kontraksi[$i]['lama'] = $bcol[$mod[$i]->kontraksi_lama_detik];
	}
	
	// else $denyut[$i]['jumlah'] = null;
}


$pdenyut = new CArrayDataProvider($denyut, array(
	'id'=>'data',
	'keyField'=>'data',
));

$ptekanan = new CArrayDataProvider($tekanan, array(
	'id'=>'dats',
	'keyField'=>'data',
));

$ld = LookupM::getItems('partografketuban');
foreach ($ld as $val => $item) {
	$ld[$val] = strtoupper(substr($item, 0, 1));
}

// var_dump($ketuban); die;


// var_dump($pdenyut); die;

?>

<style>
	.ptab th, .ptab td {
		border: 1px solid black;
	}
	
	.thead_col {
		width: 30px;
	}
</style>

<?php

echo $this->renderPartial($this->path_view_rj.'_periksaDataPasien._headerPrint'); 
?>

<h2 style="text-align: center;">Partograf</h2>

<table class="identitas" width="100%">
	<?php /*
    <tr>
        <td>Jenis Penjamin</td><td>:</td><td><?php echo $pendaftaran->carabayar->carabayar_nama; ?></td>
        <td nowrap>Kelas Pelayanan</td><td>:</td><td><?php echo !empty($pendaftaran->pasienadmisi_id)?$admisi->kelaspelayanan->kelaspelayanan_nama:$pendaftaran->kelaspelayanan->kelaspelayanan_nama; ?></td>
    </tr>
    <tr>
        <td>Penjamin</td><td>:</td><td><?php echo $pendaftaran->penjamin->penjamin_nama; ?></td>
    </tr>
    <tr>
        <td colspan="6" style="border-bottom: 1px solid black">&nbsp;</td>
    </tr>
	 * 
	 */ ?>
    <tr>
        <td nowrap>No. Rekam Medik</td><td>:</td><td width="100%"><?php echo $pasien->no_rekam_medik; ?></td>
        <td nowrap>Tgl. Pendaftaran</td><td>:</td><td nowrap><?php echo MyFormatter::formatDateTimeForUser($pendaftaran->tgl_pendaftaran); ?></td>
    </tr>
    <tr>
        <td>Nama Pasien</td><td>:</td><td nowrap><?php echo $pasien->namadepan.$pasien->nama_pasien; ?></td>
        <td nowrap>No. Pendaftaran</td><td>:</td><td nowrap><?php echo $pendaftaran->no_pendaftaran; ?></td>
    </tr>
    <tr>
        <td>Umur / Tgl. Lahir</td><td>:</td><td nowrap><?php echo $pendaftaran->umur." / ".MyFormatter::formatDateTimeForUser($pasien->tanggal_lahir); ?></td>
    </tr>
    <tr>
        <td>Alamat</td><td>:</td><td nowrap><?php echo $pasien->no_rekam_medik; ?></td>
        
        <?php if (!empty($pendaftaran->pasienadmisi_id)): ?> 
        <td nowrap>Kamar / No. Bed</td><td>:</td><td nowrap><?php echo empty($masukkamar->kamarruangan_id)?"-":($masukkamar->kamarruangan_nokamar." / ".$masukkamar->kamarruangan_nobed); ?></td>
        <?php endif; ?>
    </tr>
    <tr>
        <td>Dokter</td><td>:</td><td nowrap><?php echo $pendaftaran->pegawai->namaLengkap; ?></td>
        <?php if (!empty($pendaftaran->pasienadmisi_id)): ?> 
        <td>Dokter PJP</td><td>:</td><td nowrap><?php echo $admisi->pegawai->namaLengkap; ?></td>
        <?php endif; ?>
    </tr>
</table>
<br>

<!--Denyut Jantung-->
<h4>Denyut Jantung Janin / Menit</h4>
<?php 

$this->Widget('ext.jQPlot.jQPlotWidget', array(
	'dataProvider' => $pdenyut,
	'id'=>'tes',
	'type'=>'line',
	'options' => array(
		'width'=>300,
		'seriesDefaults'=>array(
				'renderer'=>'js:$.jqplot.LineRenderer',
				'dataLabels'=>'value',
				'barDirection'=>'vertical',
			/*
				'rendererOptions'=>array(
					'fillToZero'=>true,
					'barPadding'=>8,
					'barMargin'=>10,
					'barWidth'=>50,
					'barHeight'=>100,
					'padding'=>20,
					'sliceMargin'=>5,
					),
			 * 
			 */
				'pointLabels'=>array( 'show'=> true ),
				),
		'animate'=>false,
		
		'axes'=>array(
			'xaxis'=>array(
				//'renderer'=> 'js:$.jqplot.CategoryAxisRenderer',
				'width'=>10,
				'ticks'=>true,
				'min'=>1,
				'max'=>$len,
				'numberTicks'=>$len,
				'tickOptions'=>array(
					'mark'=>'inside',
					'showLabel'=>true,	
				),
			),
			'yaxis'=> array(
				'min'=>0,
				'max'=>200,
				'numberTicks'=>10,
				'labelRenderer'=>'js:$.jqplot.CanvasAxisLabelRenderer',
			)
		),
	),
	'htmlOptions'=>array(
		'style'=>'width:19cm;height:200px;'
	),
));

?>
<div class="clear"></div>

<h4>Air Ketuban / Penyusupan</h4>
<table width="100%" class="ptab">
	<thead>
		<tr>
			<th class="thead_left">Keterangan</td>
			<?php for ($i = 0; $i < $len; $i++): ?>
			<th class="thead_col"><?php echo $i + 1; ?></th>
			<?php endfor; ?>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>Air Ketuban</td>
			<?php for ($i = 0; $i < $len; $i++): ?>
			<td><?php echo $ketuban[$i]; ?></td>
			<?php endfor; ?>
		</tr>
		<tr>
			<td>Penyusupan</td>
			<?php for ($i = 0; $i < $len; $i++): ?>
			<td><?php echo $penyusupan[$i]; ?></td>
			<?php endfor; ?>
		</tr>
		<tr>
			<td>Pembukaan</td>
			<?php for ($i = 0; $i < $len; $i++): ?>
			<td><?php echo $pembukaan[$i]; ?></td>
			<?php endfor; ?>
		</tr>
		<tr> 
			<td>Penutupan</td>
			<?php for ($i = 0; $i < $len; $i++): ?>
			<td><?php echo $penutupan[$i]; ?></td>
			<?php endfor; ?>
		</tr>
	</tbody>
</table>
Keterangan : - 
<?php

foreach ($ld as $val => $item) {
	echo $item.": ".$val." - ";
}

?>
<br>
<br>

<h4>Kontraksi</h4>
<table width="100%" class="ptab">
	<thead>
		<tr>
			<th class="thead_left">Keterangan</td>
			<?php for ($i = 0; $i < $len; $i++): ?>
			<th class="thead_col"><?php echo $i + 1; ?></th>
			<?php endfor; ?>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>Kontraksi</td>
			<?php for ($i = 0; $i < $len; $i++): ?>
			<td style="
				background-color: <?php echo $kontraksi[$i]['lama']; ?>;
				color: <?php echo $kontraksi[$i]['lamac']; ?>;
			"><?php echo $kontraksi[$i]['kontraksi']; ?></td>
			<?php endfor; ?>
		</tr>
	</tbody>
</table>
Keterangan : 
<table class="ptab">
	<tr>
		<?php foreach ($bcol as $val=>$c): ?>
		<td style="
				background-color: <?php echo $c ?>;
				color: <?php echo $col[$val]; ?>;
				padding:2px;
			"><?php echo $val; ?></td>
		<?php endforeach; ?>
	</tr>
</table>

<br>
<br>

<h4>Oksitosin dan Tetes/Menit</h4>
<table width="100%" class="ptab">
	<thead>
		<tr>
			<th class="thead_left">Keterangan</td>
			<?php for ($i = 0; $i < $len; $i++): ?>
			<th class="thead_col"><?php echo $i + 1; ?></th>
			<?php endfor; ?>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>Oksitosin U/L</td>
			<?php for ($i = 0; $i < $len; $i++): ?>
			<td><?php echo $oksitosin[$i]; ?></td>
			<?php endfor; ?>
		</tr>
		<tr>
			<td>Tetes/menit</td>
			<?php for ($i = 0; $i < $len; $i++): ?>
			<td><?php echo $tetes[$i]; ?></td>
			<?php endfor; ?>
		</tr>
	</tbody>
</table>
<br>

<h4>Tekanan Darah</h4>
<?php 

$this->Widget('ext.jQPlot.jQPlotWidget', array(
	'dataProvider' => $ptekanan,
	'id'=>'tes2',
	'type'=>'line',
	'options' => array(
		'width'=>300,
		'seriesDefaults'=>array(
				'renderer'=>'js:$.jqplot.LineRenderer',
				'dataLabels'=>'value',
				'barDirection'=>'vertical',
			/*
				'rendererOptions'=>array(
					'fillToZero'=>true,
					'barPadding'=>8,
					'barMargin'=>10,
					'barWidth'=>50,
					'barHeight'=>100,
					'padding'=>20,
					'sliceMargin'=>5,
					),
			 * 
			 */
				'pointLabels'=>array( 'show'=> true ),
				),
		'animate'=>false,
		
		'axes'=>array(
			'xaxis'=>array(
				//'renderer'=> 'js:$.jqplot.CategoryAxisRenderer',
				'width'=>10,
				'ticks'=>true,
				'min'=>1,
				'max'=>$len,
				'numberTicks'=>$len,
				'tickOptions'=>array(
					'mark'=>'inside',
					'showLabel'=>true,	
				),
			),
			'yaxis'=> array(
				'min'=>0,
				'max'=>180,
				'numberTicks'=>10,
				'labelRenderer'=>'js:$.jqplot.CanvasAxisLabelRenderer',
			)
		),
	),
	'htmlOptions'=>array(
		'style'=>'width:19cm;height:200px;'
	),
));

?>

<h4>Urine</h4>
<table width="100%" class="ptab">
	<thead>
		<tr>
			<th class="thead_left">Keterangan</td>
			<?php for ($i = 0; $i < $len; $i++): ?>
			<th class="thead_col"><?php echo $i + 1; ?></th>
			<?php endfor; ?>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>Protein</td>
			<?php for ($i = 0; $i < $len; $i++): ?>
			<td><?php echo $protein[$i]; ?></td>
			<?php endfor; ?>
		</tr>
		<tr>
			<td>Aseton</td>
			<?php for ($i = 0; $i < $len; $i++): ?>
			<td><?php echo $aseton[$i]; ?></td>
			<?php endfor; ?>
		</tr>
		<tr>
			<td>Volume (cc)</td>
			<?php for ($i = 0; $i < $len; $i++): ?>
			<td><?php echo $volume[$i]; ?></td>
			<?php endfor; ?>
		</tr>
	</tbody>
</table>
<br>

<script>
$(document).ready(function() {
	$(".keys").parent().hide();
});
</script>


