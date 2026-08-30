<b>PENAFISAN / SKRINING GIZI</b>
<p>
	<?php echo "BB: " . (isset($modPeriksaFisik->beratbadan_kg) ? $modPeriksaFisik->beratbadan_kg : "-") . " Kg ".
	" TB: " . (isset($modPeriksaFisik->tinggibadan_cm) ? $modPeriksaFisik->tinggibadan_cm : "-") . " cm";
	?>
</p>
<ol>
	<li>
		Apakah Pasien mengalami penurunan BB yang tidak dinginkan dalam 3 bulan terakhir?
		<br>
		<?php echo ($modAnamnesa->penurunanbb_3bln == 1) ? "Ya" : "Tidak";?>
	</li>
	<li>
		Apakah asupan berkurang karena tidak nafsu makan?
		<br>
		<?php echo ($modAnamnesa->asupanberkurang == 1) ? "Ya" : "Tidak";?>
	</li>
</ol>
<br>
<p>STATUS FUNGSIONAL</p>
<p>
	Aktifitas dan Mobilisasi : ( Lampirkan Formulir Pengkajian Fungsional Barthel IndeX)
</p>
<p>
	<?php 
	if(isset($modAnamnesa->aktifitas_mobilisasi)){
		if($modAnamnesa->aktifitas_mobilisasi == 'Mandiri'){
			echo "Mandiri";
		}
		if($modAnamnesa->aktifitas_mobilisasi == 'Perlu Bantuan'){
			echo "Perlu Bantuan, sebutkan ". (isset($modAnamnesa->sebutkan_bantuan) ? $modAnamnesa->sebutkan_bantuan : "-");
		}
		if($modAnamnesa->aktifitas_mobilisasi == 'Ketergantungan Total'){
			echo "Ketergantungan Total";
		}
	}
	?>
</p>
<p>RESIKO CEDERA / JATUH</p>
<p>
<?php 
	if($modAnamnesa->resikocedera == 1){
		echo 'Ya Bila ya, isi formulir pemantauan pencegahan jatuh sesuai usia';
	}else{
		echo 'Tidak';
	}
?>
</p>
<p>Gelang resiko jatuh terpasang di lengan pasien : <?php echo ($modAnamnesa->isgelangresiko == 1) ? "Ya": "Tidak"; ?></p>
<p>Tanda segitiga warna kuning terpasang di tempat tidur / blankar / kursi roda : <?php echo ($modAnamnesa->tandasegitigaterpasang == 1) ? "Ya": "Tidak"; ?></p>
<br>
<b>PENAFISAN / SKRINNING NYERI</b>
<p><?php echo (isset($modAnamnesa->skriningnyeri) ? $modAnamnesa->skriningnyeri : "-");?></p>
<p>Skala Nyeri: <?php echo (isset($modAnamnesa->skalanyeri) ? $modAnamnesa->skalanyeri : "-");?></p>
<p>Karakteristik: <?php echo (isset($modAnamnesa->karakteristiknyeri) ? $modAnamnesa->karakteristiknyeri : "-");?></p>
<p>Lokasi: <?php echo (isset($modAnamnesa->lokasinyeri) ? $modAnamnesa->lokasinyeri : "-");?></p>
<p>Nyeri Terasa: <?php echo (isset($modAnamnesa->nyeriterasa) ? $modAnamnesa->nyeriterasa : "-");?></p>
<p>Nyeri Hilang, bila: </p>
<p><?php echo (isset($modAnamnesa->nyerihilangbila) ? $modAnamnesa->nyerihilangbila : "-");?></p>