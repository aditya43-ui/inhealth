<?php
echo CHtml::css('.control-label{
        float:left; 
        text-align: right; 
        width:1%;
        color:black;
        padding-right:10px;
        font-size:8pt;
    }
    body{
        font-size:8pt;
    }
    td .uang{
        text-align:right;
    }
    .border{
        border:1px solid;
    }
');
?>  
<?php
$format = new MyFormatter;
if (!isset($_GET['frame'])){
    echo $this->renderPartial($this->path_view.'_headerPrint'); 
}
?>
<table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center" valign="middle" colspan="3">
			<b><u><?php echo $judul_print ?></u></b>
		</td>
	</tr>
</table><br>
<table width="100%" style="margin:30px;" cellpadding="0" cellspacing="0">
	<tr>
		<td width="20%">Tanggal Pemeriksaan </td>
		<td>:</td>
		<td><?php echo MyFormatter::formatDateTimeId($modHearingTest->tglhearingtest); ?></td>

		<td width="20%"></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td width="20%">Nama</td>
		<td>:</td>
		<td><?php echo $modPasien->namadepan; ?> <?php echo $modPasien->nama_pasien; ?></td>

		<td width="20%"></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td width="20%">Tempat & Tanggal Lahir</td>
		<td>:</td>
		<td><?php echo $modPasien->tempat_lahir; ?>, <?php echo MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir); ?></td>

		<td width="20%"></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td width="20%">No. Pekerja & Jenis Kelamin</td>
		<td>:</td>
		<td><?php echo $modPasien->jeniskelamin; ?></td>

		<td width="20%"></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td width="20%">Department/Seksi</td>
		<td>:</td>
		<td></td>

		<td width="20%"></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td width="20%">Lokasi Kerja Sekarang</td>
		<td>:</td>
		<td></td>

		<td width="20%">Tingkat Kebisingan</td>
		<td>:</td>
		<td width="20%">Zona</td>
	</tr>
	<tr>
		<td width="20%">Jabatan Sekarang</td>
		<td>:</td>
		<td></td>

		<td width="20%"></td>
		<td></td>
		<td></td>
	</tr>
</table>
    
<ol style="list-style-type: upper-roman;">
	<li><b>RIWAYAT PEKERJAAN</b>
		<table class="table-condensed" width="100%">
			<tr>            
				<td width="100%">
					<table width="100%" id="form-riwayatpekerjaan-mcu" border="1">
						<thead>
							<tr>
								<th style='text-align:center;'>NAMA PERUSAHAAN</th>
								<th style='text-align:center;'>LAMA BEKERJA <br>(T.M.T)</th>
								<th style='text-align:center;'>JENIS PEKERJAAN</th>
								<th style='text-align:center;'>TERPAPAR / KONTAK DGN BISING</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<?php echo $modHearingTest->nmperusahaan_rwt; ?>
								</td>
								<td>
									<?php echo $modHearingTest->lamabekerja; ?> <?php echo $modHearingTest->satuan_lamakrj; ?>
								</td>
								<td>
									<?php echo $modHearingTest->jnspekerjaan_rwt; ?>
								</td>
								<td>
									<?php echo $modHearingTest->kontakdgnbising; ?>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</table>
		<table style="width: 100%; border: none;">
			<tr width="50%">            
				<td>Hobby Menembak/Musik</td>
				<td>:</td>
				<td><?php 
				if($modHearingTest->hobtembak_musik == 'Ya'){
					echo "<b>".$modHearingTest->hobtembak_musik."</b> / Tidak";
				}else{
					echo "Ya / <b>".$modHearingTest->hobtembak_musik."</b>";
				} ?></td>
			</tr>
			<tr width="50%">            
				<td>Alat proteksi telinga yang pernah dikenakan</td>
				<td>:</td>
				<td><?php // echo $modHearingTest->altproteksi_telinga; 
					foreach(LookupM::getItems('alatproteksitelinga') as $i=>$datas){
						if($modHearingTest->altproteksi_telinga == $datas){
							echo "<b>".$datas."</b>";
						}else{
							echo $datas;
						}
						echo " / ";
					}
				?></td>
			</tr>
			<tr width="50%">            
				<td>Keterangan lainnya di lingkungan kerja</td>
				<td>:</td>
				<td><?php echo $modHearingTest->ket_kerja_lingkungan; ?></td>
			</tr>
			<tr width="50%">            
				<td>Paparan bahan kimia di lingkungan kerja</td>
				<td>:</td>
				<td><?php
				if($modHearingTest->bahankimia_lk == 'Ya'){
					echo "<b>".$modHearingTest->bahankimia_lk."</b> / Tidak";
				}else{
					echo "Ya / <b>".$modHearingTest->bahankimia_lk."</b>";
				} ?></td>
			</tr>
			<tr width="50%">            
				<td>Kelainan Pendengaran di kalangan keluarga</td>
				<td>:</td>
				<td><?php
				if($modHearingTest->kelainanpend_kal_kel == 'Ya'){
					echo "<b>".$modHearingTest->kelainanpend_kal_kel."</b> / Tidak";
				}else{
					echo "Ya / <b>".$modHearingTest->kelainanpend_kal_kel."</b>";
				} ?></td>
			</tr>
		</table><br>
	</li>
	<li><b>KELUHAN-KELUHAN LAINNYA</b>
		<table style="width: 100%; border: none;">
			<tr width="50%">            
				<td>Apakah ada gangguan Pembicaraan antara perorangan</td>
				<td>:</td>
				<td><?php 
				if($modHearingTest->gangguan_antarperorangan == 'Baik'){
					echo "<b>".$modHearingTest->gangguan_antarperorangan."</b> / Susah";
				}else{
					echo "Baik / <b>".$modHearingTest->gangguan_antarperorangan."</b>";
				} ?></td>
			</tr>
			<tr width="50%">            
				<td>Apakah ada gangguan Pendengaran di lingkungan yang gaduh/berisik</td>
				<td>:</td>
				<td><?php 
				if($modHearingTest->gangguan_lingkgaduh == 'Baik'){
					echo "<b>".$modHearingTest->gangguan_lingkgaduh."</b> / Susah";
				}else{
					echo "Baik / <b>".$modHearingTest->gangguan_lingkgaduh."</b>";
				} ?></td>
			</tr>
			<tr width="50%">            
				<td>Apakah telinganya sering mendenging</td>
				<td>:</td>
				<td><?php 
				if($modHearingTest->telinga_mendenging == 'Ya'){
					echo "<b>".$modHearingTest->telinga_mendenging."</b> / Tidak";
				}else{
					echo "Ya / <b>".$modHearingTest->telinga_mendenging."</b>";
				}
				?></td>
			</tr>
			<tr width="50%">            
				<td>
					<table width="100%" style="margin-top:20px;margin-left: 70px;">
						<tr>
							<td></td>
							<td></td>
							<td width="40%" align="center" align="top">
								<div>Petugas Pemeriksa,</div>
								<div style="margin-top:60px;">(_________________)</div>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table><br>
	</li>
	<li><b>PEMERIKSAAN TELINGA (diisi oleh Dokter/Paramedis RS)</b>
		<table style="width: 100%; border: none;">
			<tr width="50%">            
				<td>Telinga Kanan</td>
				<td>:</td>
				<td>
					<ul>
						<li>Membran Tympani : <?php 
							if($modHearingTest->tkn_membrantympani == 'Utuh'){
								echo "<b>".$modHearingTest->tkn_membrantympani."</b> / Robek";
							}else{
								echo "Utuh / <b>".$modHearingTest->tkn_membrantympani."</b>";
							}
						?></li>
						<li>Infeksi Lubang Telinga : <?php 
							if($modHearingTest->tkn_influbtelinga == 'Ya'){
								echo "<b>".$modHearingTest->tkn_influbtelinga."</b> / Tidak";
							}else{
								echo "Ya / <b>".$modHearingTest->tkn_influbtelinga."</b>";
							}
						?></li>
						<li>Serumen : <?php 
							if($modHearingTest->tkn_serumen == 'Ada'){
								echo "<b>".$modHearingTest->tkn_serumen."</b> / Tidak";
							}else{
								echo "Ada / <b>".$modHearingTest->tkn_serumen."</b>";
							}
						?></li>
					</ul>
				</td>
			</tr>
			<tr width="50%">            
				<td>Telinga Kiri</td>
				<td>:</td>
				<td>
					<ul>
						<li>Membran Tympani : <?php 
							if($modHearingTest->tkr_membrantympani == 'Utuh'){
								echo "<b>".$modHearingTest->tkr_membrantympani."</b> / Robek";
							}else{
								echo "Utuh / <b>".$modHearingTest->tkr_membrantympani."</b>";
							}
						?></li>
						<li>Infeksi Lubang Telinga : <?php 
							if($modHearingTest->tkr_influbtelinga == 'Ya'){
								echo "<b>".$modHearingTest->tkr_influbtelinga."</b> / Tidak";
							}else{
								echo "Ya / <b>".$modHearingTest->tkr_influbtelinga."</b>";
							}
						?></li>
						<li>Serumen : <?php 
							if($modHearingTest->tkr_serumen == 'Ada'){
								echo "<b>".$modHearingTest->tkr_serumen."</b> / Tidak";
							}else{
								echo "Ada / <b>".$modHearingTest->tkr_serumen."</b>";
							}
						?></li>
					</ul>
				</td>
			</tr>
		</table><br>
	</li>
	<li><b>KESIMPULAN HASIL AUDIOGRAM (diisi oleh Dokter RS </b>
		<div class="row">
			1. Penurunan kemampuan pendenganran untuk komunikasi akibat terpapar kebisingan Derajat :
			<?php // echo $modHearingTest->penuruankempendengaran; 
				foreach(LookupM::getItems('penurunanpendengaran') as $i=>$data){
					if($modHearingTest->penuruankempendengaran == $data){
						echo "<b>".$data."</b>";
					}else{
						echo $data;
					}
					echo " / ";
				}
			?><br>
			2. Penurunan kemampuan pendenganran pada frekuensi :<br>			
			<table class="table-condensed" width="50%">				
				<tr>    
					<td width="10%">
						Telinga Kanan
					</td>
					<td width="40%">
						<table width="50%" id="form-pemeriksaan-telingakanan-mcu" border="1">
							<thead>
								<tr>
									<th style='text-align:center;'>Freq</th>
									<th style='text-align:center;'>500</th>
									<th style='text-align:center;'>1k</th>
									<th style='text-align:center;'>2k</th>
									<th style='text-align:center;'>3k</th>
									<th style='text-align:center;'>4k</th>
									<th style='text-align:center;'>6k</th>
									<th style='text-align:center;'>8k</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Db</td>
									<td><?php echo $modHearingTest->tkn_500; ?></td>
									<td><?php echo $modHearingTest->tkn_1k; ?></td>
									<td><?php echo $modHearingTest->tkn_2k; ?></td>
									<td><?php echo $modHearingTest->tkn_3k; ?></td>
									<td><?php echo $modHearingTest->tkn_4k; ?></td>
									<td><?php echo $modHearingTest->tkn_6k; ?></td>
									<td><?php echo $modHearingTest->tkn_8k; ?></td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<tr>    
					<td width="10%">
						Telinga Kiri
					</td>
					<td width="40%">
						<table width="50%" id="form-pemeriksaan-telingakiri-mcu" border="1">
							<thead>
								<tr>
									<th style='text-align:center;'>Freq</th>
									<th style='text-align:center;'>500</th>
									<th style='text-align:center;'>1k</th>
									<th style='text-align:center;'>2k</th>
									<th style='text-align:center;'>3k</th>
									<th style='text-align:center;'>4k</th>
									<th style='text-align:center;'>6k</th>
									<th style='text-align:center;'>8k</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Db</td>
									<td><?php echo $modHearingTest->tkr_500; ?></td>
									<td><?php echo $modHearingTest->tkr_1k; ?></td>
									<td><?php echo $modHearingTest->tkr_2k; ?></td>
									<td><?php echo $modHearingTest->tkr_3k; ?></td>
									<td><?php echo $modHearingTest->tkr_4k; ?></td>
									<td><?php echo $modHearingTest->tkr_6k; ?></td>
									<td><?php echo $modHearingTest->tkr_8k; ?></td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</table>
			3. Penurunan kemampuan pendengaran akibat : Pertambahan usia / Presbyacusis
			<?php echo isset($modHearingTest->penurunan_presbyacusis) ? "<u>".$modHearingTest->penurunan_presbyacusis."</u>" : "_____________________"; ?><br>
			4. Penurunan kemampuan pendengaran akibat : Penyakit infeksi dan lainnya
			<?php echo isset($modHearingTest->penurunan_infdanlain) ? "<u>".$modHearingTest->penurunan_infdanlain."</u>" : "_________________________"; ?><br><br>
			<div class="col-sm-6">
				Catatan Pemeriksa : <?php echo $modHearingTest->catatan_hearingtest; ?> <br>
				Keterangan Pemeriksa : <?php echo $modHearingTest->keterangan_hearingtest; ?>	
			</div>
		</div>
	</li>
</ol>
<br>
	
<?php
if (isset($_GET['frame'])){
    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')"));
    echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')")); 
?>
    <script type='text/javascript'>
    /**
     * print
     */    
    function print(caraPrint){
        var hearingtest_id = '<?php echo isset($modHearingTest->hearingtest_id) ? $modHearingTest->hearingtest_id : null ?>';
		var pendaftaran_id = '<?php echo isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : null; ?>';
		window.open('<?php echo $this->createUrl('print'); ?>&hearingtest_id='+hearingtest_id+'&pendaftaran_id='+pendaftaran_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
    }
    </script>
<?php
}else{ ?>
    <table width="100%" style="margin-top:20px;">
    <tr>
        <td></td>
        <td></td>
        <td width="30%" align="center" align="top">
            <div><?php echo Yii::app()->user->getState("kabupaten_nama").", ".MyFormatter::formatDateTimeId(date('Y-m-d')); ?></div>
            <div>Dokter Pemeriksa,</div>
            <div style="margin-top:60px;">(<?php echo $modHearingTest->namapemeriksa_hearingtest; ?>)</div>
        </td>
    </tr>
    
    </table>
<?php } ?>
<?php 
$profil = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
        $alamat=!empty($profil->alamatlokasi_rumahsakit)?$profil->alamatlokasi_rumahsakit:"";
	$motto=!empty($profil->motto)?$profil->motto:"";
        $telp=!empty($profil->no_telp_profilrs)?$profil->no_telp_profilrs:"";
        $email=!empty($profil->email)?$profil->email:"";
        $website=!empty($profil->website)?$profil->website:"";
        $layoutkiri=$alamat."<br>"."Telp:".$telp." Email:".$email." Website:".$website;
?>
<table width="100%" class="footer">
    <tr><td width="70%" style="text-align:left" align="left" class="alamatfooter"><?php echo  $layoutkiri ?></td><td class="mottofooter" style="text-align:right"  width="30%" align="right"><?php echo $motto ?></td></tr>
        
</table>