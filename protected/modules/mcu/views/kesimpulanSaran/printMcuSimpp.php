<?php
/**
* 
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @author      Deni Hamdani <denihamdani@piindonesia.co.id>
* 
*/
?>
<?php
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
?>

<?php echo $this->renderPartial('application.views.headerReport.headerPrint'); ?>
<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<style>
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
    td, th{
        font-size: 8pt !important;
        height: 24px;
        padding-left:10px;
    }
    body{
        width: 21.7cm;
    }
    .content td{
        height: 28px;
        vertical-align: top;
    }
</style>


<div style="text-align: center;"><b>HASIL PEMERIKSAAN KESEHATAN<br>LAPORAN CHECKUP</b></div>
<br>
<table width="100%" class="content" style="border: none;">
    <tr>
        <td>Nomor</td>
        <td><?php echo $ModKesimpulanMCU->no_sarandankesimpulan; ?></td>
        <td>Tanggal</td>
        <td><?php echo MyFormatter::formatDateTimeForUser($ModKesimpulanMCU->tgl_kesimpulanmcu); ?></td>
    </tr>
    <tr>
        <td>Keperluan</td>
        <td><?php echo $ModKesimpulanMCU->keperluan; ?></td>
        <td>Koordinator Checkup</td>
        <td><?php 
        if (!empty($ModKesimpulanMCU->kordinator_id)) {
            $peg = PegawaiM::model()->findByPk($ModKesimpulanMCU->kordinator_id);
            echo empty($peg) ? "-" : $peg->nama_pegawai;
        } else {
            echo "-";
        } 
        ?></td>
    </tr>
    <tr>
        <td colspan="4" align="center">PEMERIKSAAN FISIK</td>
    </tr>
    <tr>
        <td>Tinggi Badan</td>
        <td><?php echo empty($ModKesimpulanMCU->periksaumum_tinggibadan) ? "-" : ($ModKesimpulanMCU->periksaumum_tinggibadan." cm"); ?></td>
        <td>Berat Badan</td>
        <td><?php echo empty($ModKesimpulanMCU->periksaumum_beratbadan) ? "-" : ($ModKesimpulanMCU->periksaumum_beratbadan." Kg"); ?></td>
    </tr>
    <tr>
        <td>Tekanan Darah</td>
        <td><?php 
        if (!empty($ModKesimpulanMCU->periksaumum_sistolic) && !empty($ModKesimpulanMCU->periksaumum_diastolic)) {
            echo $ModKesimpulanMCU->periksaumum_sistolic."/".$ModKesimpulanMCU->periksaumum_diastolic;
        } else {
            echo "-";
        }
        
        ?></td>
        <td>Nadi</td>
        <td><?php echo empty($ModKesimpulanMCU->periksaumum_nadi) ? "-" : $ModKesimpulanMCU->periksaumum_nadi; ?></td>
    </tr>
    <tr>
        <td>Mata</td>
        <td><?php echo $ModKesimpulanMCU->mata; ?></td>
        <td>BMI</td>
        <td><?php echo empty($ModKesimpulanMCU->periksaumum_nilaibmi) ? "-" : ($ModKesimpulanMCU->periksaumum_nilaibmi." - ".$ModKesimpulanMCU->periksaumum_bmikategori); ?></td>
    </tr>
    <tr>
        <td colspan="4" align="center">LABORATORIUM</td>
    </tr>
    <tr>
        <td>Hasil Laboratorium</td>
        <td colspan="3"><?php echo $ModKesimpulanMCU->pemeriksaan_laboratorium; ?></td>
    </tr>
    <tr>
        <td colspan="4" align="center">RADIOLOGI</td>
    </tr>
    <tr>
        <td>Hasil Radiologi</td>
        <td colspan="3"><?php echo $ModKesimpulanMCU->pemeriksaan_radiologi; ?></td>
    </tr>
    <tr>
        <td colspan="4" align="center">PEMERIKSAAN LAIN-LAIN</td>
    </tr>
    <tr>
        <td>Kesimpulan</td>
        <td colspan="3"><?php echo empty($ModKesimpulanMCU->kesimpulanperorangan) ? "-" : $ModKesimpulanMCU->kesimpulanperorangan; ?></td>
    </tr>
    <tr>
        <td>Saran</td>
        <td colspan="3"><?php echo empty($ModKesimpulanMCU->saranperorangan) ? "-" : $ModKesimpulanMCU->saranperorangan; ?></td>
    </tr>
    <tr>
        <td>Catatan</td>
        <td colspan="3"><?php echo empty($ModKesimpulanMCU->keterangan_kesimpulanmcu) ? "-" : $ModKesimpulanMCU->keterangan_kesimpulanmcu; ?></td>
    </tr>
</table>

<?php /*
<table class="border noborder">
    <tr>
        <td style="text-align:center;"><h4><u>HASIL PEMERIKSAAN KESEHATAN</u></h4></td>
    </tr>
</table>

<table class="border noborder">
    <tr>
        <td width="25%"></td>
        <td width="15%">NOMOR</td>
        <td>: <?php echo $ModKesimpulanMCU->no_sarandankesimpulan ?></td>
        <td></td>        
    </tr>
    <tr>
        <td></td>
        <td>Nama</td>
        <td>: <?php echo $modPasien->nama_pasien; ?></td>
        <td></td>        
    </tr>
    <tr>
        <td></td>
        <td>Umur</td>
        <td>: <?php echo CustomFunction::getUmur($modPasien->tanggal_lahir); ?></td>
        <td></td>        
    </tr>
    <tr>
        <td></td>
        <td>Alamat</td>
        <td>: <?php echo $modPasien->alamat_pasien; ?></td>
        <td></td>        
    </tr>
    <tr>
        <td></td>
        <td>Jenis Kelamin</td>
        <td>: <?php echo $modPasien->jeniskelamin; ?></td>
        <td></td>        
    </tr>
    <tr>
        <td></td>
        <td>Keperluan</td>
        <td>: <?php echo $ModKesimpulanMCU->keperluan; ?></td>
        <td></td>        
    </tr>
</table>

<?php
$tinggi_badan ='';
$tekanandarah ='';
$beratbadan_kg ='';
$mata_kelainan='';
$mata_persepsiwarna='';
$mata_visus_od='';
$mata_visus_os='';
$nilai_bmi='';
$nadi='';

if(!empty($modPemeriksaanFisik)) {
    $tinggi_badan = $modPemeriksaanFisik->tinggibadan;
    $tekanandarah = $modPemeriksaanFisik->tekanandarah_sistolok.'/'.$modPemeriksaanFisik->tekanandarah_diastolik;
    $beratbadan_kg = $modPemeriksaanFisik->beratbadan;
    $mata_kelainan = '';
    $mata_persepsiwarna = '';
    $mata_visus_od = '';
    $mata_visus_os = '';
    $nadi = $modPemeriksaanFisik->nadi;
    $nilai_bmi = (isset($modPemeriksaanFisik->nilai_bmi) && ($modPemeriksaanFisik->bodymassindex_nama)) ? $modPemeriksaanFisik->nilai_bmi.'/'.$modPemeriksaanFisik->bodymassindex_nama : " ";
}   
?>

<table class="border noborder">
    <tr>
        <td>PEMERIKSAAN FISIK :</td>
    </tr>
</table>
<table class="table border">
    <tr>
        <td>
            <table class="table noborder paddingtext2">
                <tr>
                    <td>Tinggi Badan</td>
                    <td width="1%">:</td>
                    <td> <?php echo $ModKesimpulanMCU->periksaumum_tinggibadan; ?> Cm</td>
                    <td></td>
                    <td>Berat Badan</td>
                    <td width="1%">:</td>
                    <td> <?php echo $ModKesimpulanMCU->periksaumum_beratbadan; ?> Kg</td>
                </tr>
                <tr>
                    <td>Tekanan Darah</td>
                    <td width="1%">:</td>
                    <td> <?php echo $ModKesimpulanMCU->periksaumum_sistolic.'/'.$ModKesimpulanMCU->periksaumum_diastolic; ?> mm/Hg</td>
                    <td></td>
                    <td>Nadi</td>
                    <td width="1%">:</td>
                    <td> <?php echo $ModKesimpulanMCU->periksaumum_nadi; ?> x/menit</td>
                </tr>
                <tr>
                    <td>Mata</td>
                    <td width="1%">:</td>
                    <td> <?php echo $ModKesimpulanMCU->mata; ?></td>
                    <td></td>
                    <td>BMI</td>
                    <td width="1%">:</td>
                    <td> <?php echo $ModKesimpulanMCU->periksaumum_bmikategori; ?> </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<?php if (!empty($ModKesimpulanMCU->pemeriksaan_laboratorium)){ ?>
<table class="border noborder">
    <tr>
        <td>LABORATORIUM</td>
    </tr>
</table>
<table class="table border">
    <tr>
        <td>                            
             <?php
             
            if (empty($ModKesimpulanMCU->pemeriksaan_laboratorium)){
                foreach ($data as $dt1) {
                    ?>
                    <table class="table noborder paddingtext2">			
                        <tr>
                            <td width="15%" style="padding-top:10px;"><?php echo $dt1['jenispemeriksaanlab_nama']; ?></td>
                            <td style="padding-top:10px;" width="1%">:</td>
                            <td style="vertical-align:top;">
                            <table class="table noborder paddingtext2">			                            
                                <?php
                                foreach ($dt1['pemeriksaanlab'] as $dt2) {

                                    $a = 1;
                                    $i = 1;
                                    $b = 1;
                                    foreach ($dt2['kelompokdet'] as $dt3) {
                                        if (count((array)$dt3['nilairujukan']) > 1) {
                                            ?>
                                            <tr>

                                                <td style="border-bottom:white 1px solid !important;">
                                                    <?php
                                                    if ($i == 1) {
                                                        echo $dt2['pemeriksaanlab_nama'];
                                                    }
                                                    ?>
                                                </td>													
                                                <td colspan="3"> :
                            <?php echo $dt3['kelompokdet'] . ' :'; ?>
                                                </td>							
                                            </tr>
                            <?php
                        }
                        $j = 1;
                        foreach ($dt3['nilairujukan'] as $dt4) {
                            if (count((array)$dt2['kelompokdet']) == $b) {
                                if (count((array)$dt3['nilairujukan']) > 1) {
                                    if (count((array)$dt3['nilairujukan']) == $j) {
                                        $border = 'border-bottom:1px solid #000 !important;';
                                    } else {
                                        $border = 'border-bottom:1px solid #fff !important;';
                                    }
                                } else {
                                    $border = 'border-bottom:1px solid #000 !important;';
                                }
                            } else {
                                $border = 'border-bottom:1px solid #fff !important;';
                            }
                            $border = '';
                            ?>
                                            <tr>

                                                <td style="<?php echo $border; ?>" width="15%">
                                                    <?php
                                                    if ($i == 1) {

                                                        echo $dt2['pemeriksaanlab_nama'];
                                                    } else {

                                                    }
                            ?>
                                                </td>					
                                                <td width="1%">
                                                    <?php
                                                        if ($i == 1) {
                                                            echo ':';
                                                        } else {

                                                        }
                                                    ?>
                                                </td>
                                                <td width="20%">								
                                                    <?php
                                                    if (count((array)$dt3['nilairujukan']) > 1) {
                                                        echo '<ul><li>' . $dt4['namapemeriksaandet'] . '</li><ul>';
                                                    } else {
                                                        echo '# '.$dt4['namapemeriksaandet'];
                                                    }
                                                    ?>
                                                </td>
                                                <td width="1%">:</td>                                            
                                                <td>
                                                    <?php echo $dt4['nilairujukan']; ?>
                                                </td>
                                            </tr>

                            <?php
                            $i++;
                            $j++;
                        }

                        $b++;
                    }
                }
            
            ?>
                        </table>	
                </td>
                    </tr>
                </table>
                    <?php
                }
            }else{                
                echo $ModKesimpulanMCU->pemeriksaan_laboratorium;
           
            }
                ?>     
        </td>
    </tr>
</table>

<?php } ?>

<?php if (!empty($ModKesimpulanMCU->pemeriksaan_radiologi)){ ?>
<table class="border noborder">
    <tr>
        <td>Radiologi</td>
    </tr>
</table>
<table class="table border">
    <tr>
        <td>
            <table class="table noborder paddingtext2">
                <?php 
                    if (empty($ModKesimpulanMCU->pemeriksaan_radiologi)){
                        if(!empty($modHasilPemeriksaanRad)){
                            foreach ($modHasilPemeriksaanRad as $rad){
                ?>
                                <tr>
                                    <td width="30%"><?php echo $rad->pemeriksaanrad->pemeriksaanrad_nama; ?></td>
                                    <td width="1%">:</td>
                                    <td><?php echo $rad->hasilexpertise; ?></td>
                                </tr>
                <?php
                            }
                        }
                    }else{
                        echo $ModKesimpulanMCU->pemeriksaan_radiologi;
                    }
                ?>
            </table>
        </td>
    </tr>
</table>
<?php } ?>

<table class="table noborder">
    <tr>
        <td width="12%"><b>Kesimpulan</b></td>
        <td width="1%">:</td>
        <td><?php echo $ModKesimpulanMCU->kesimpulanperorangan; ?></td>
    </tr>
</table>

<table class="table noborder">
    <tr>
        <td width="12%"><b>Catatan</b></td>
        <td width="1%">:</td>
        <td><?php echo $ModKesimpulanMCU->keterangan_kesimpulanmcu; ?></td>
    </tr>
</table>

<?php /*
<table style="width: 100%; border: none;">
        <tr>
                <td width="60%"></td>
                <td width="30%" style="text-align: center;">
                        <?php 
                        echo $modProfilRs->kabupaten->kabupaten_nama. ", ".(!empty($ModKesimpulanMCU->tgl_kesimpulanmcu)?MyFormatter::formatDateTimeId($ModKesimpulanMCU->tgl_kesimpulanmcu):''); ?><br>
                        Koordinator Check-Up,
                        <br><br><br><br><br>
                        <b><?php echo !empty($ModKesimpulanMCU->kordinator_id)?$ModKesimpulanMCU->kordinator->namaLengkap:''; ?></b>                        
                        <hr style="background: #333;height:1px;padding: 0;margin: 0;">                        
                        <b><?php echo !empty($ModKesimpulanMCU->kordinator_id)?'NIP : '.$ModKesimpulanMCU->kordinator->nomorindukpegawai:''; ?></b>
                </td>
                <td width="10%"></td>
        </tr>
</table>
 * 
 */ ?>