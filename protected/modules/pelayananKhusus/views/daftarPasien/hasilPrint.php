<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>
<?php  $data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());?>

<?php  echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan)); 
?>

<br>
<table border="0" width="80%" align="center">
<tr>
    <td width="50%" style="vertical-align:top;">
    <table border="0" align="center" style="vertical-align:top;">
        <tr>
            <td width="15%">No. Pendaftaran</td><td width="1%">:</td><td width="33%"><?php echo $masukpenunjang->no_pendaftaran; ?></td>
        </tr>
        <tr>
            <td>Tanggal Pendaftaran</td><td>:</td><td><?php echo substr($masukpenunjang->tgl_pendaftaran,0,-9); ?></td>
        </tr>
        <tr>
            <td>Ruangan</td><td>:</td><td><?php echo $masukpenunjang->ruangan_nama; ?></td>
        </tr>
        <tr>
            <td>No. Hasil Pemeriksaan</td><td>:</td><td><?php echo $masukpenunjang->no_masukpenunjang; ?></td>
        </tr>
        <tr>
            <td>Tanggal Pemeriksaan</td><td>:</td><td><?php echo substr($masukpenunjang->tglmasukpenunjang,0,-9); ?></td>
        </tr>
    </table>
    </td>
    <td width="50%">
        <table border="0" align="center">
        <tr>
            <td width="12%">No. DMK</td><td width="1%">:</td><td width="36%"><?php echo $masukpenunjang->no_rekam_medik; ?></td>
        </tr>
        <tr>
            <td>Nama Pasien</td><td>:</td><td><?php echo $masukpenunjang->nama_pasien; ?></td>
        </tr>
        <tr>
            <td>Tanggal Lahir</td><td>:</td><td><?php echo $masukpenunjang->tanggal_lahir; ?></td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td><td>:</td><td><?php echo $masukpenunjang->jeniskelamin; ?></td>
        </tr>
        <tr>
            <td>Alamat</td><td>:</td><td><?php echo $masukpenunjang->alamat_pasien; ?></td>
        </tr>
        <tr>
            <td>Jenis Penjamin</td><td>:</td><td><?php echo $masukpenunjang->carabayar_nama; ?> / <?php echo $masukpenunjang->penjamin_nama; ?></td>
        </tr>
    </table>
    </td>
</tr>
<tr><td>
<br>

</td></tr>
</table>
        <!-- <?php 
        //if(count($detailHasil) > 0){              
            //foreach($detailHasil as $i=>$hasil){     
        ?> 
<div style="border: 1px solid #a1a1a1; width:80%; margin:auto;  page-break-after: auto;">
    <?php //echo ($i+1); ?> &nbsp; <?php //echo $hasil->tindakanrm->tindakanrm_nama;?><br>
    Hasil Pemeriksaan :<?php //echo $hasil->hasilpemeriksaanrm; ?><br>
    Keterangan : <?php //echo $hasil->keteranganhasilrm; ?><br>
    Evaluasi : <?php //echo $hasil->evaluasi; ?><br>
    Peralatan yang diperlukan : <?php //echo $hasil->peralatandigunakan; ?>
</div>
	<?php //}} ?> -->

    <table class='table table-striped table-bordered table-condensed'>
    <thead>
        <tr>
            <th>
                No.
            </th>
            <th>
                Nama Pemeriksaan
            </th>
            <th>
                Hasil Pemeriksaan
            </th>
            <th>
                Keterangan
            </th>
            <th>
                Evaluasi
            </th>
            <th>
                Peralatan yang digunakan
            </th>
        </tr>
    </thead>
    <tbody>
            <tr>
                <?php 
                if(count($detailHasil) > 0){              
                    foreach($detailHasil as $i=>$hasil){     
                ?> 
                    <tr>
                        <td width="3%" style="vertical-align:top;">&nbsp;<?php echo ($i+1); ?>. </td>
                        <td><?php echo $hasil->tindakanrm->tindakanrm_nama;?></td>
                        <td><center><?php echo $hasil->hasilpemeriksaanrm; ?></center></td>
                        <td><center><?php echo $hasil->keteranganhasilrm; ?></center></td>
                        <td><center><?php echo $hasil->evaluasi; ?></center></td>
                        <td><?php
                                   $lookupperalatan = LookupM::model()->findAll("lookup_type = 'peralatanfisioterapi'");

                                   if(count($lookupperalatan) >0 ){
                                     $htmlPeralatan = "";

                                     foreach($lookupperalatan as $i => $look_risiko){
                                       $isPeralatan = false;
                                       

                                       if(!empty($hasil->peralatandigunakan)){
                                         $oriKualitasNyeri = json_decode($hasil->peralatandigunakan);

                                         if(isset($oriKualitasNyeri) && count($oriKualitasNyeri) > 0){
                                           foreach ($oriKualitasNyeri as $propKualitas) {
                                             if($propKualitas == $look_risiko->lookup_value){
                                               $isPeralatan = true;
                                             }
                                           }
                                         }
                                       }

                                        if ($isPeralatan == true){
                                            if($i > 0){
                                                $htmlPeralatan .= "<br/>";
                                            }
                                        }

                                       if($look_risiko->lookup_value == 'Lainnya'){
                                            if ($isPeralatan == true){
                                               $htmlPeralatan .= "<span class='".(($isPeralatan==true)?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$look_risiko->lookup_name;
                                            }
                                         
                                       }else{
                                            if ($isPeralatan == true){
                                                $htmlPeralatan .= "<span class='".(($isPeralatan==true)?'fa fa-check-square-o':'fa fa-square-o')."'></span> ".$look_risiko->lookup_name;
                                            }
                                       }
                                     }
                                     echo $htmlPeralatan;
                                   }
                               ?>
                        </td>
                    </tr>
                <?php }} ?>
            </tr>
    </tbody>
</table>
    
	<table border="0" width="30%" align="right">
		<tr>
			<td align="center">
				<?php if (empty($masukpenunjang->nama_dokterasal)){
					echo "<br><i><b>*Belum ada dokter pemeriksa</b></i><br>";
				}else { ?>
				<?php echo "Bandung, ".MyFormatter::formatDateTimeId(date('Y-m-d')); ?><br>
				Dokter Pemeriksa <br><br><br><br><br><br>
				<?php echo $masukpenunjang->gelardokterasal;?>.&nbsp;<?php echo $masukpenunjang->nama_dokterasal;?>
				<?php 
				echo "<br>";
				} ?>
			</td>
			<td>&nbsp;</td>
		</tr>
	</table>
    
