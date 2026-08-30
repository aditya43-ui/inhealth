<style>
    .barcode-label {
        margin-top: -20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }

    td,
    th {
        font-size: 6pt !important;
        /*        font-weight: bold;*/
    }

    body {
        width: 61mm;
    }

    .content {
        -webkit-transform: rotate(-90deg);
        -moz-transform: rotate(-90deg);
        -o-transform: rotate(-90deg);
        -ms-transform: rotate(0deg);
        transform: rotate(0deg);
        color: #000000;
        height: 60mm;
        width: 70mm;
        margin: 6px 0px 30px 5px;
        position: relative;
    }

    @media print {
        .barcode-label {
            margin-top: -20px;
            z-index: 1;
            text-align: center;
            letter-spacing: 10px;
        }

        td,
        th {
            font-size: 6pt !important;
        }

        body {
            width: 61mm;
        }

        .content {
            -webkit-transform: rotate(-90deg);
            -moz-transform: rotate(-90deg);
            -o-transform: rotate(-90deg);
            -ms-transform: rotate(0deg);
            transform: rotate(0deg);
            color: #000000;
            height: 6cm;
            width: 7cm;
            margin: 0px 0px 30px 5px;
            position: relative;
            margin-top: 1%;
        }
    }

    @page {
        margin-top: 1%;
    }

    .tab_etiket {
        border-collapse: collapse;
        margin-right: 5px;
    }

    .tab_etiket td {
        font-size: 6pt;
        font-family: Arial, Helvetica, sans-serif;
        /* vertical-align: top; */
        padding-left: 2px;
        padding-right: 1px;
        padding-top: 0px;
    }

    #logo {
        width: 30px;
        height: 30px;
    }

    .text tr td {
        font-size: 7pt;
        /* font-family: Arial, Helvetica, sans-serif;
        /* vertical-align: top; */
        /* padding-left: 2px;
        padding-right: 1px;
        padding-top: 0px; */
    }
</style>
<?php
// echo '<pre>';var_dump($modPenjualanDetail);die;
 $dokter = PegawaiM::model()->findByPk($modPenjualan->pegawai_id);
 $modPenjualanDetailRes = [];
 foreach($modPenjualanDetail as $modObat) {
     if (empty($modPenjualanDetailRes[$modObat->rke])) {
          $modPenjualanDetailRes[$modObat->rke] = $modObat ?? "";
     }
 }
//  echo '<pre>';var_dump($modPenjualanDetailRes);die;
 foreach ($modPenjualanDetailRes as $i=>$modObat){

$penggunaan = str_replace("<br>", " - ", $modObat->ket_penggunaan);
// var_dump($penggunaan);die;
$jumlah = $modObat->qty_oa;

if (!empty($modReseptur)) {

    $detail = ResepturdetailT::model()->findByAttributes(array(
        'obatalkes_id'=>$modObat->obatalkes_id,
        'reseptur_id'=>$modReseptur->reseptur_id,
    ));

    if(empty($detail)){
        $detail = new ResepturdetailT();
    }

    if (!empty($detail)) {
        $jumlah = $detail->qty_reseptur;
    }

} else{
    $detail = ResepturdetailT::model()->findByAttributes(array(
        'obatalkes_id'=>$modObat->obatalkes_id,
    ));

    if(empty($detail)){
        $detail = new ResepturdetailT();
    }

    if (!empty($detail)) {
        $jumlah = $detail->qty_reseptur;
    } 
}

$format = new MyFormatter;
?>

<?php
$data = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$konfig = KonfigsystemK::model()->find();

$path = Params::pathProfilRSDirectory().$data->logo_rumahsakit;
// $path2 = Params::pathProfilRSDirectory().$data->logo_rumahsakit_2;

$res = "";
$ext = "png";

if (file_exists($path)) {
    $content = file_get_contents($path);
    $ext_data = pathinfo($path);
    
    if (!empty($ext_data) && is_array($ext_data) && !empty($ext_data)) {
        $ext = $ext_data['extension'];
    }
    
    $res = "data:image/".$ext.";base64,". base64_encode($content);
}

// $res2 = "";
// $ext = "png";

// if (file_exists($path2)) {
//     $content = file_get_contents($path2);
//     $ext_data = pathinfo($path2);
    
//     if (!empty($ext_data) && is_array($ext_data) && !empty($ext_data)) {
//         $ext = $ext_data['extension'];
//     }
    
//     $res2 = "data:image/".$ext.";base64,". base64_encode($content);
// }

// $modCatatanPemberianObat1 = CatatanpemberianobatT::model()->findByAttributes(array('pendaftaran_id'=>$modPenjualan->pendaftaran_id,'pasien_id'=>$modPenjualan->pasien_id),array('order'=>'pendaftaran_id asc'));
?>

<div class="header">
    <?php //echo $this->renderPartial('application.views.headerReport.headerDefaultNewEtiket'); ?>
    <table width='100%' style="padding-top: 0px">
        <tr>
            <td width='20%' ALIGN="CENTER" VALIGN="MIDDLE">
                <div class="logo">
                    <img src="<?php echo $res; ?>" style="width:10%;" class="logoRS">
                </div>
            </td>
            <td width='80%' align="left" style="text-align:center; font-size:5pt;">
                <div class="namaRS" align="center">
                    <div>INSTALASI FARMASI <?php echo $data->nama_rumahsakit; ?></div>
                    <div><?php echo $data->alamatlokasi_rumahsakit; ?></div>
                    <?php $nama = PegawaiM::model()->findAll('pegawai_id = 427'); //14?>
                    <div>Apoteker : apt.Zulia Khozanah A M.Farm</div>
                </div>
            </td>
        </tr>
    </table>
</div>
<!-- <hr style="color:#000;"> -->
<div class="content">
    <!-- <table width='100%'>
		<tr>
			<td style='line-height:0.10'>
			<span>----------------------------------------------------------------------</span> </td>
		</tr>
	</table> -->
    <table width="100%" class="tab_etiket">
        <?php if (in_array($modPenjualan->jenispenjualan, array(Params::JENISPENJUALAN_KARYAWAN, Params::JENISPENJUALAN_DOKTER))): ?>
        <tr>
            <td width="45">NIK</td>
            <td width="5">:</td>
            <td><?php

        // $nip = "-";
        $nama_pegawai = "-";

        if (!empty($modPenjualan->pasienpegawai_id)) {
            $peg = PegawaiM::model()->findByPk($modPenjualan->pasienpegawai_id);
            if (!empty($peg)) {
                // $nip = $peg->nomorindukpegawai;
                $nama_pegawai = $peg->namaLengkap;
            }
        }
        // echo $nip;
        echo $modPenjualan->pasien->no_identitas_pasien;

        ?>
            </td>
            <td width="45">Tgl.Pelayanan<b></b></td>
            <td>:</td>
            <td><?php
        $pelayanan = date('Y-m-d', strtotime(MyFormatter::formatDateTimeForDb($modObat->tglpelayanan)));

        echo MyFormatter::formatDateTimeForUser($pelayanan);  ?></td>
        </tr>
        <tr>
            <td>Pegawai</td>
            <td width="5">:</td>
            <td><?php echo $nama_pegawai;  ?></td>
            <!-- <td rowspan="4">Kelas Terapi</td>
        <td rowspan="4">:</td>
        <td rowspan="4"><?php
        //$therapi = TherapiobatM::model()->findByPk($modObat->therapiobat_id);
        //if (!empty($therapi)) {
        //    echo $therapi->therapiobat_nama;
        //} else {
        //    echo "-";
        //}

        ?></td> -->
        </tr>
        <tr>
            <td width="35">Tgl Lahir</td>
            <td>:</td>
            <td><?php
        $pelayanan = date('Y-m-d', strtotime(MyFormatter::formatDateTimeForDb($modObat->penjualanresep->pasien->tanggal_lahir)));

        echo MyFormatter::formatDateTimeForUser($pelayanan);  ?></td>
        </tr>
        <!-- <tr>
        <td>Dokter Resep</td>
        <td>:</td>
        <td><?php //echo empty($dokter) ? "-" : $dokter->namaLengkap; ?></td>
    </tr> -->
        <?php else: ?>

        <!-- MULAI PERUBAHAN -->
        <tr style="font-size:5pt">
            <td width="35">NO. RM</td>
            <td width="5">:</td>
            <td><?php echo $modObat->penjualanresep->pasien->no_rekam_medik;  ?></td>;
            <td width="45">Tgl. Resep</td>
            <td>:</td>
            <td width="50"><?php $jam = $modPenjualan->tglresep;
                            $tgl = explode(" ", $jam);
        echo MyFormatter::formatDateTimeForUser($tgl[0]);?></td>
        </tr>
        <tr>
            <td width="45">Tgl Lahir</td>
            <td>:</td>
            <td><?php
        $pelayanan = date('Y-m-d', strtotime(MyFormatter::formatDateTimeForDb($modObat->penjualanresep->pasien->tanggal_lahir)));

        echo MyFormatter::formatDateTimeForUser($pelayanan);  ?></td>
            <td width="25">Umur</td>
            <td>:</td>
            <td><?php echo $modPenjualan->pendaftaran->umur ?></td>
        </tr>
        <tr>
            <td width="45">NIK</td>
            <td>:</td>
            <td><?php echo $modPenjualan->pasien->no_identitas_pasien;?>
        </tr>

        <?php endif; ?>
        <!--
	 <tr>
             <td><?php // echo $modObat->penjualanresep->pasien->nama_pasien.' - '.$modObat->penjualanresep->pasien->no_rekam_medik;  ?></td>
	 </tr>-->
    </table>
    <?php if($modObat->racikan_id == Params::RACIKAN_ID_RACIKAN){?>
        <table class="text" width="100%" style="text-align:left; margin-top: 0px; ">
            <tr>
                <td><b><?php echo $modObat->penjualanresep->pasien->nama_pasien;  ?>
                        <?php if($modObat->penjualanresep->pasien->jeniskelamin == "Laki-Laki"){
                echo "(L)";
            } else{
                echo "(P)";
            }?><b></td>;
            </tr>
            <tr>
            <tr>
                <td><b>R/<?php echo $modObat->rke." - (".$modObat->qty_oa.")";  ?><b></td>
                <td width="50"><b> Qty: <?= $modObat->qty_oa?><b></td>
            </tr>
            <tr>
                <td><b><?php //echo $modObat->signa_oa;echo $modObat->signa_oa;  ?>(<?php echo !empty($modObat->etiket) ? $modObat->etiket : "-" ;//echo $penggunaan;  ?>)<b>
                </td>

                <td width="50"><b> <?php echo empty($mod->jadwal) ? "-" : $mod->jadwal;?><b></td>

            </tr>
            <tr>
                <td><b><?= isset($modObat->keterangan) ? $modObat->keterangan : "-"?><b></td>
            </tr>
        </table>
    <?php }else{?>
        <table class="text" width="100%" style="text-align:left; margin-top: 0px; ">
            <tr>
                <td><b><?php echo $modObat->penjualanresep->pasien->nama_pasien;  ?>
                        <?php if($modObat->penjualanresep->pasien->jeniskelamin == "Laki-Laki"){
                echo "(L)";
            } else{
                echo "(P)";
            }?><b></td>;
            </tr>
            <tr>
                <td><b><?php echo $modObat->obatalkes->obatalkes_nama;?><b></td>
                <td width="50"><b> Qty: <?= $modObat->qty_oa?><b></td>
            </tr>
            <!-- <tr>
                <td><b><?php //echo $modObat->ket_penggunaan?><b></td>
            </tr> -->
            <tr>
                <td><b><?php //echo $modObat->signa_oa;echo $modObat->signa_oa;  ?>(<?php echo !empty($modObat->etiket) ? $modObat->etiket : "-" ;//echo $penggunaan;  ?>)<b>
                </td>

                <td width="50"><b> <?php echo empty($mod->jadwal) ? "-" : $mod->jadwal;?><b></td>

            </tr>
            <!-- <tr>
                <td><b><?php //echo empty($modCatatanPemberianObat->jadwalpemberianobat) ? "-" : $modCatatanPemberianObat->jadwalpemberianobat; ?></b>
                </td>
            </tr> -->
            <tr>
                <td><b><?= isset($modObat->keterangan) ? $modObat->keterangan : "-"?><b></td>
            </tr>
            <!-- <td rowspan="7" width="20%" height="50" style="vertical-align: middle; text-align: center;">
                <?php 
                    //$this->widget('application.extensions.qrcode.QRCodeGenerator',array(
                    //                  'data' =>$modPenjualan->pasien->no_rekam_medik,
                    //                  'subfolderVar' => false,
                    //                  'displayImage'=>true, // default to true, if set to false display a URL path
                    //                  'errorCorrectionLevel'=>'M', // available parameter is L,M,Q,H
                    //                  'matrixPointSize'=>1.8, // 1 to 10 only
                    //              )); 
                    ?>
            </td> -->
            <!-- <tr>
                    <td><?php //echo $penggunaan;  ?></td>
            </tr> -->
                <!-- <tr>
                <td align="center"> <?php echo (!empty($modObat->etiket) ? $modObat->etiket :""); ?> </td>
            </tr> -->
                <!-- <tr>
                <td align="center" style="font-family: Helvetica Neue;"><i>Semoga Lekas Sembuh</i></td>
            </tr> -->

        </table>
    <?php }?>
    <table>

    </table>

</div>
<?php }?>