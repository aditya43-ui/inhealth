<?php 
if(isset($_POST["EXCEL"]))
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'."Surat Keterangan".'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
} 
$data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$format = new MyFormatter();
$judul_print = "SURAT RENCANA KONTROL";
if (!empty($modPendaftaran)) {
    $asuransi = AsuransipasienM::model()->findByPk($modPendaftaran->asuransipasien_id);
}

if (empty($asuransi)) {
    $asuransi = new AsuransipasienM;
}


$bpjs = new BpjsVklaim();
$res = CJSON::decode($bpjs->search_no_surat_kontrol($model->nomorsurat_bpjs));

if (empty($modPasien)) {
    $modPasien = new PasienM;
}

if (empty($modDiagnosa)) {
    if (!empty($res['response']['sep']['diagnosa'])) {
        $model->diagnosa_kontrol = $res['response']['sep']['diagnosa'];
    }
} else {
    $model->diagnosa_kontrol = $modDiagnosa->diagnosa_kode." - ".$modDiagnosa->diagnosa_nama;
}

if (!empty($model->nosep)) {
    $res_sep = CJSON::decode($bpjs->search_sep($model->nosep));
    if (!empty($res_sep['response'])) {
        $modPasien->nama_pasien = $res_sep['response']['peserta']['nama'];
        $modPasien->tanggal_lahir = $res_sep['response']['peserta']['tglLahir'];
        $asuransi->nokartuasuransi = $res_sep['response']['peserta']['noKartu'];

        if (empty($model->diagnosa_kontrol)) {
            $res_rujukan = CJSON::decode($bpjs->search_rujukan_no_rujukan($res_sep['response']['noRujukan']));
            if (empty($res_rujukan['response'])) {
                $res_rujukan = CJSON::decode($bpjs->search_rujukan_no_rujukan_rs($res_sep['response']['noRujukan']));
            }
            if (!empty($res_rujukan['response'])) {
                $model->diagnosa_kontrol .= $res_rujukan['response']['rujukan']['diagnosa']['kode']." - ";
                $model->diagnosa_kontrol .= $res_rujukan['response']['rujukan']['diagnosa']['nama'];
                // var_dump($res_rujukan); die;
            }
        }
        //var_dump($res_sep['response'], $modPasien->attributes); die;
    }
}

?>

<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Arial">

<style>     
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
    td{
        font-size: 11pt !important;
    }
    body{
        width: 21.7cm;     
        font-family: "Arial" !important;     
    }

    td.header
    {
        padding-left:30px;
    }

    td
    {
        font-size: 12pt !important;
        vertical-align: top;
    }

    .qr_data img {
        max-width: none;
        width: 100px;
        padding-left: 10px;
    }
</style>
<table width="100%" border = "0" style = "text-align:left; color: black;">
    <thead>
    <th width = "25%"><img src="<?php echo Yii::app()->getBaseUrl('webroot') . '/images/logo_bpjs.png'; ?>" width="200px"></th>
    <th style="font-weight:bold; text-align: left;"><span style="font-size:17px;"><?php echo $judul_print; ?><br><?php echo $data->nama_rumahsakit; //." (".Yii::app()->user->getState('ppkpelayanan').")"; ?></span></th>        
    <th align='right' width="27%" style="font-weight:bold;"><span style="font-size:17px;"><?php echo "No. ".$model->nomorsurat_bpjs; ?></span></th-->        
   <!--<th  style = "padding: 0;"><!--<img src="<?php //echo Params::urlProfilRSDirectory().$data->logo_rumahsakit   ?>" width="120px"></th>-->
</thead>
</table>
<table border = "0"  style = "text-align:left; color:black" width="100%">
    <tr>
        <td width="150">Kepada Yth.</td>
        <td width="10">:</td>
        <td><?php 
            
            if (!empty($modPendaftaran->doktertujuankontrol_id)) {
                $peg = PegawaiM::model()->findByPk($modPendaftaran->doktertujuankontrol_id);
                if (empty($peg)) {
                    echo "-";
                } else {
                    echo $peg->namaLengkap;
                    $sub = SpesialissubspesialisM::model()->findByPk($peg->spesialissubspesialis_id);

                    if (!empty($sub)) {
                        echo "<br/>";
                        echo "Sp./Sub. ".$sub->spesialissubspesialis_nama;
                    }
                }
            } else if (!empty($model->doktertujuankontrol_id)) {
                $peg = PegawaiM::model()->findByPk($model->doktertujuankontrol_id);
                if (empty($peg)) {
                    echo "-";
                } else {
                    echo $peg->namaLengkap;
                    $sub = SpesialissubspesialisM::model()->findByPk($peg->spesialissubspesialis_id);

                    if (!empty($sub)) {
                        echo "<br/>";
                        echo "Sp./Sub. ".$sub->spesialissubspesialis_nama;
                    }
                }
            } else {
                echo "-";
            }
            
        ?></td>
    </tr>
    <tr>
        <td colspan="3"><br/>Mohon Pemeriksaan dan Penanganan Lebih Lanjut : </td>
    </tr>
    <tr>
        <td width="150">No. Kartu</td>
        <td width="10">:</td>
        <td><?php echo empty($asuransi->nokartuasuransi) ? "-" : $asuransi->nokartuasuransi; ?></td>
    </tr>
    <tr>
        <td width="150">Nama Peserta</td>
        <td width="10">:</td>
        <td><?php echo $modPasien->namadepan.' '.$modPasien->nama_pasien ?></td>
    </tr>
    <tr>
        <td width="150">Tgl. Lahir</td>
        <td width="10">:</td>
        <td><?php echo MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir) ?></td>
    </tr>
    <tr>
        <td width="150">Diagnosa</td>
        <td width="10">:</td>
        <td><?php echo $model->diagnosa_kontrol; ?></td>
    </tr>
    <tr>
        <td width="150">Rencana Kontrol</td>
        <td width="10">:</td>
        <td><?php echo !empty($modPendaftaran->tglrenkontrol) ? MyFormatter::formatDateTimeForUser($modPendaftaran->tglrenkontrol) : (!empty($model->tglkontrol) ? MyFormatter::formatDateTimeForUser($model->tglkontrol) : "-") ?></td>
    </tr>
    <tr>
        <td colspan="3"><br/>Demikian atas bantuannya, diucapkan banyak terima kasih.</td>
    </tr>
    

    
</table>
<table border = "0"  style = "text-align:left; color:black" width="100%">
    <tr>
        <td style="font-size: 8pt !important; vertical-align: bottom">Tgl Entri: <?php echo date('d/m/Y', strtotime($model->create_time)); ?> / Tgl Cetak: <?php echo date('d/m/Y H:i:s'); ?></td>
        <td width="300" style="text-align: center;">
            Mengetahui DPJP,
            <br/><br/><br/><br/><br/>
            <?php echo empty($peg) ? "-" : $peg->namaLengkap; ?>
        </td>
    </tr>
</table>