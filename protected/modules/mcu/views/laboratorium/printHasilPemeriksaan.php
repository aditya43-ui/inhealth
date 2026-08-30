<?php
/**
 * khusus format print tarakan
 */
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerDefaultNew',array('judulLaporan'=>$judulLaporan, 'colspan'=>7)); 
$no_urut = 1;
$class='';
if(isset($_GET['frame']) ){
    $class="table table-bordered";
}
//kelompokkan hasil pemeriksaan berdasarkan kelompokdet
$hasils = array();
$kelompok = 0;
$ii = 0;
if(count((array)$modDetailHasilPemeriksaans) > 0){
    foreach($modDetailHasilPemeriksaans AS $rec => $modDetail){
        if($rec == 0){
        }else{
            if($modDetailHasilPemeriksaans[$rec-1]->pemeriksaandetail->nilairujukan->kelompokdet == $modDetailHasilPemeriksaans[$rec]->pemeriksaandetail->nilairujukan->kelompokdet){
            }else{ //jika beda kelompok
                $kelompok ++;
                $ii = 0;
            }
        }
        $attributes = $modDetail->attributeNames();
        foreach($attributes AS $attribute){
            $hasils[$kelompok][$ii]["$attribute"] = $modDetail->$attribute;
        }
        $hasils[$kelompok][$ii]['kelompokdet'] = $modDetail->pemeriksaandetail->nilairujukan->kelompokdet;
        $hasils[$kelompok][$ii]['namapemeriksaandet'] = $modDetail->pemeriksaandetail->nilairujukan->namapemeriksaandet;
        $hasils[$kelompok][$ii]["nilairujukan"] = htmlentities($modDetail->nilairujukan, ENT_QUOTES | ENT_IGNORE, "UTF-8");
        $ii ++;
    }
}
//echo "<pre>";
//print_r($hasils);
//exit;
?>

<table style="width: 100%; border: none;">
    <tr>
        <td><?php echo $modKunjungan->getAttributeLabel('no_pendaftaran') ?></td><td>: <?php echo $modKunjungan->no_pendaftaran ?></td>
        <td><?php echo $modKunjungan->getAttributeLabel('no_rekam_medik') ?></td><td>: <?php echo $modKunjungan->no_rekam_medik ?></td>
    </tr>
    <tr>
        <td><?php echo $modKunjungan->getAttributeLabel('tgl_pendaftaran') ?></td><td>: <?php echo $modKunjungan->tgl_pendaftaran ?></td>
        <td><?php echo $modKunjungan->getAttributeLabel('nama_pasien') ?></td><td>: <?php echo $modKunjungan->namadepan." ".$modKunjungan->nama_pasien ?></td>
    </tr>
    <tr>
        <td><?php echo $modKunjungan->getAttributeLabel('no_masukpenunjang') ?></td><td>: <?php echo $modKunjungan->no_masukpenunjang ?></td>
        <td><?php echo $modKunjungan->getAttributeLabel('tanggal_lahir') ?></td><td>: <?php echo $modKunjungan->tanggal_lahir ?></td>
    </tr>
    <tr>
        <td><?php echo $modKunjungan->getAttributeLabel('tglmasukpenunjang') ?></td><td>: <?php echo $modKunjungan->tglmasukpenunjang ?></td>
        <td><?php echo $modKunjungan->getAttributeLabel('jeniskelamin') ?></td><td>: <?php echo $modKunjungan->jeniskelamin ?></td>
    </tr>
    <tr>
        <td><?php echo $modKunjungan->getAttributeLabel('ruangan_nama') ?></td><td>: <?php echo $modKunjungan->ruangan_nama ?></td>
        <td><?php echo $modKunjungan->getAttributeLabel('alamat_pasien') ?></td><td>: <?php echo $modKunjungan->alamat_pasien ?></td>
    </tr>
    <tr>
        <td><?php echo $modHasilPemeriksaan->getAttributeLabel('nohasilperiksalab') ?></td><td>: <?php echo $modHasilPemeriksaan->nohasilperiksalab; ?></td>
    </tr>
    <tr>
        <td><?php echo $modHasilPemeriksaan->getAttributeLabel('tglhasilpemeriksaanlab') ?></td><td>: <?php echo $format->formatDateTimeForUser($modHasilPemeriksaan->tglhasilpemeriksaanlab); ?></td>
    </tr>
</table>
<table width="100%" border="1" class='<?php echo $class; ?>'>
    <thead>
        <th>NO.</th>
        <th colspan="2" width="30%">NAMA PEMERIKSAAN</th>
        <th>HASIL PEMERIKSAAN</th>
        <th>NILAI RUJUKAN</th>
        <th>SATUAN</th>
        <th>METODE</th>
    </thead>
    <tbody>
        <?php
        if(count((array)$hasils) > 0){
            foreach($hasils AS $i => $kelompok){
                foreach($kelompok AS $ii => $nilai){
                    
                    echo "<tr>";
                    echo "<td>".($ii+1)."</td>";
                    if($ii == 0){
                        if($nilai['namapemeriksaandet'] == $nilai['kelompokdet']){
                            echo "<td colspan=2>".$nilai['namapemeriksaandet']."</td>";
                        }else{
                            echo "<td valign='top' rowspan='".(count((array)$kelompok))."'>".$nilai['kelompokdet']."</td>";
                            echo "<td>".$nilai['namapemeriksaandet']."</td>";
                        }
                    }else{
                        echo "<td>".$nilai['namapemeriksaandet']."</td>";
                    }
                    echo "<td>".$nilai['hasilpemeriksaan']."</td>";
                    echo "<td>".$nilai['nilairujukan']."</td>";
                    echo "<td>".$nilai['hasilpemeriksaan_satuan']."</td>";
                    echo "<td>".$nilai['hasilpemeriksaan_metode']."</td>";
                    echo "</tr>";
                }
            }
        }
        ?>
    </tbody>
</table>
<table style="width: 100%; border: none;">
    <tr>
        <td><br>
            <span style='font-size:9pt'><?php echo $modHasilPemeriksaan->getAttributeLabel('catatanlabklinik') ?> :<br>
            <div style='border:1px solid #cccccc; border-radius:2px;padding:10px; width: 98%;float:left;border-color: black;'>                
            <?php echo $modHasilPemeriksaan->catatanlabklinik; ?>
            </div>
            </div>
        </td>
    </tr>
    <tr>
        <td><br>
            <span style='font-size:9pt'><?php echo $modHasilPemeriksaan->getAttributeLabel('kesimpulan') ?> :<br>
            <div style='border:1px solid #cccccc; border-radius:2px;padding:10px; width: 98%;float:left;border-color: black;'>                
            <?php echo $modHasilPemeriksaan->kesimpulan; ?>
            </div>
            </div><br>
        </td>
    </tr>
</table>

<?php
if(isset($_GET['frame']) && $_GET['frame'] == 1){    
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'printHasil();'));     
}else{
?> 
    <table style="width: 100%; border: none;">
    <tr>
        <td></td>
        <td></td>
        <td><?php echo Yii::app()->user->getState('kabupaten_nama') ?>, <?php echo date('d/m/Y') ?></td>
    </tr>
    <tr>
        <td width="100px">&nbsp;</td>
        <td>Analis Laboratorium,</td>
        <td>Dokter Penanggung Jawab,</td>
    </tr>
    <tr height="200px;">
        <td></td>
        <td style="text-decoration: underline;"><?php echo Yii::app()->user->getState("nama_pegawai"); ?></td>
        <td style="text-decoration: underline;"><?php echo $modKunjungan->gelardepan." ".$modKunjungan->nama_pegawai." ".$modKunjungan->gelarbelakang_nama; ?></td>
    </tr>
    
</table>
<?php } ?>
</div>
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
