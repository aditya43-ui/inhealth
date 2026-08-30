<?php
/**
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @digunakan untuk layout cetak label penyiapan darah. 
 * @keterangan label dicetak sesuai dengan jumlah permintaan darah 
 */
?>
<style type="text/css">
    .labelDarah {
        width: 7cm;
        height: 5cm;
        color: black;
        font-size: 8pt;
        border: solid, 1px, black;
        border-radius: 3px; 
        margin-bottom: 1mm;
        line-height: 110%;
        margin-top: 1mm;
        display: block
    }
    .cetak {
        width: 7cm;
        height: 5cm;
        color: black;
        font-size: 8pt;
        border: solid, 1px, black;
        border-radius: 3px; 
        margin-right: 2mm;
        position: static;
    }
    @page {
        font-size: 8pt;
        size: A5;
        margin: 0;
    }
    @media print {
        html, body {
            margin: 1mm;
            line-height: 110%;
            font-size: 8pt;
            width: 7cm;
            height: 5cm;
        }

    }
</style>
<?php
$pengujianTube = UjidarahpasienT::model()->findByAttributes(array(
    'permintaandarah_id' => $_GET['id'],
    //'metodedarah_id' => Params::METODE_DARAH_ID_TUBE_TEST
        ), array(
    'order' => 'ujidarahpasien_id desc'
        ));

if (!empty($pengujianTube)) {    
    $cri = new CDbCriteria();
    $cri->join = " JOIN penyiapandarah_t siap ON siap.ujikompatibilitas_id = t.ujikompatibilitas_id ";
    $cri->addCondition(" siap.penyiapandarah_ke = '".$penyiapandarah_ke."' AND siap.permintaandarah_id = '".$permintaan->permintaandarah_id."' ");
    $pengujianKompat = UjikompatibilitasT::model()->findAll($cri);  
    
    foreach ($pengujianKompat as $value) {
        $kantong = KantongdarahT::model()->findByAttributes(array('no_kantongdarah' => $value->nomorbarcode));
        $ruangan_id = $pendaftaran->ruangan_id;
        $analis = $value->peg_pemeriksa_id;
        if (!empty($pendaftaran->pasienadmisi_id)) {
            $admisi = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);
            $ruangan_id = $admisi->ruangan_id;
        }
        $ruangan = RuanganM::model()->findByPk($ruangan_id);
        $pegawai = PegawaiM::model()->findByPk($analis);
        $ujidarah = UjidarahpasienT::model()->findByAttributes(array('ujidarahpasien_id' => $value->ujidarahpasien_id));
        $goldarah = explode(' ', $ujidarah->kesimpulan_uji);
        ?>
        <div class="labelDarah" style="border: 1px solid black">
            <table width="100%" class="kop">
                <tr>
                    <td align="center"> 
                        <img src="<?php echo Params::pathImageErrorAdmin() . 'Jawa_Timur.png' ?> " style="text-align: center; max-width: 30px; width:30px;" class='image_report'/>
                    </td>
                    <td style=" font-size: 8pt; text-align: center; font-weight: bold"> INSTALASI TRANSFUSI DARAH <br>  <?php echo strtoupper(Yii::app()->user->getState('nama_rumahsakit')); ?></td> 
                    <td align="center">
                        <img src="<?php echo Params::urlProfilRSPDFPath() . '7552278rs_soetomo.png' ?> " style="text-align: center; max-width: 30px; width:30px;" class='image_report'/>
                    </td>
                </tr>
            </table>
            <table style="width: 100%; border: none;">
                <tr >
                    <td width="30%" style="font-size: 8pt;"> No. Formulir </td>
                    <td width="1%" style="font-size: 8pt;"> : </td>
                    <td width="69%" colspan="4" style="font-size: 8pt;"> <?php echo $permintaan->no_permintaandarah ?> </td>
                </tr>
                <tr>
                    <td width="30%" style="font-size: 8pt;"> Nomor Kantong </td>
                    <td width="1%" style="font-size: 8pt;"> : </td>
                    <td width="69%" colspan="4" style="font-size: 8pt;"> <?php echo $value->nomorbarcode ?></td>
                </tr>   
                <tr>
                    <td width="30%" style="font-size: 8pt;"> Nama Pasien </td>
                    <td width="1%" style="font-size: 8pt;"> : </td>
                    <td width="69%" colspan="4" style="font-size: 8pt;"> <?php echo $pasien->nama_pasien; ?>  </td>
                </tr>
                <tr>
                    <td width="30%" style="font-size: 8pt;"> Nomor RM </td>
                    <td width="1%" style="font-size: 8pt;"> : </td>
                    <td width="15%" style="font-size: 8pt;">  <?php echo $pasien->no_rekam_medik ?> </td>
                    <td width="20%" style="font-size: 8pt;"> Jns. Kelamin </td>
                    <td width="1%" style="font-size: 8pt;"> : </td>
                    <?php if ($pasien->jeniskelamin == "PEREMPUAN") { ?>
                        <td width="5%" style="font-size: 8pt;"> <?php echo "P" ?> </td>
                    <?php } else { ?>
                        <td width="5%" style="font-size: 8pt;"> <?php echo "L" ?> </td>
                    <?php } ?>
                </tr>
                <tr>
                    <td width="30%" style="font-size: 8pt;"> Tgl. Lahir </td>
                    <td width="1%" style="font-size: 8pt;"> : </td>
                    <td width="69%" colspan="4" style="font-size: 8pt;"> <?php echo MyFormatter::formatDateTimeForUser($pasien->tanggal_lahir) ?> </td>
                </tr>
                <tr>
                    <td width="30%" style="font-size: 8pt;"> Ruangan </td>
                    <td width="1%" style="font-size: 8pt;"> : </td>
                    <td width="69%" colspan="4" style="font-size: 8pt;"> <?php echo $ruangan->ruangan_nama ?> </td>
                </tr>
                <tr>
                    <td width="30%" style="font-size: 8pt;"> Gol Darah / Rhesus </td>
                    <td width="1%" style="font-size: 8pt;"> : </td>
                    <td width="69%" colspan="4" style="font-size: 8pt;"> <?php echo $goldarah[0]." / ".$goldarah[1];?> </td>
                </tr>
                <tr>
                    <td width="30%" style="font-size: 8pt;"> Jenis Darah </td>
                    <td width="1%" style="font-size: 8pt;"> : </td>
                    <td width="69%" colspan="4" style="font-size: 8pt;"> <?php echo $kantong->komponendarah->singkatan_komp; ?> </td>
                </tr>
                <tr>
                    <td width="30%" style="font-size: 8pt;"> Crossmatch </td>
                    <td width="1%" style="font-size: 8pt;"> : </td>
                    <td width="69%" colspan="4" style="font-size: 8pt;"> Compatible </td>
                </tr>
                <tr>
                    <td width="30%" style="font-size: 8pt;"> Analis </td>
                    <td width="1%" style="font-size: 8pt;"> : </td>
                    <td width="30%" colspan="4" style="font-size: 8pt;"> <?php echo $pegawai->namaLengkap ?> </td>
                </tr>
            </table>
            <table class="cetak">
                <tr>
                    <td style="font-size: 7pt; float: right; margin-right: 3px"> Tgl. Cetak : <?php echo date("d/m/Y H:i") ?>  </td>
                </tr>
            </table>
        </div>
    <?php
    }
}
?>

