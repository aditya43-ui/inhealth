
<?php

    $jenisKontrol = $_GET['jnsKontrol'];

    if($jenisKontrol == 1){?>
        <?php $data = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT); ?>
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Arial">
        <?php $judulLaporan = 'SURAT PERINTAH RAWAT INAP'; ?>
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

        }

        td.header
        {
            padding-left:30px;
        }

        td
        {
            font-size: 9pt !important;
            vertical-align: top;
        }
        .entri{
            font-size: 10px;
        }
        .tgl{
            font-weight: 400;
        }
    </style>
<?php
    } else { ?>
    <?php $data = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT); ?>
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

        }

        td.header
        {
            padding-left:30px;
        }

        td
        {
            font-size: 9pt !important;
            vertical-align: top;
        }
        .entri{
            font-size: 10px;
        }
        .tgl{
            font-weight: 400;
        }
    </style>
    <?php //echo $this->renderPartial('pendaftaranPenjadwalan.views.pendaftaranRawatJalan._headerPrintStatus'); ?>
    <?php
    }

?>
    <div class="container">
    <table style='margin-left:auto; margin-right:auto;' border="0" width="100%">
            <thead>
            <th width = "25%"><img src="<?php echo Yii::app()->getBaseUrl('webroot') . '/images/logo_bpjs.png'; ?>" width="200px"></th>
            <th align='center' style="font-weight:bold; text-align: center;"><span style="font-size:17px;"><?php echo $judulLaporan; ?><br><?php echo $data->nama_rumahsakit; ?></span></th>        
            <th align='right' width="30%" style="font-weight:bold;"><span style="font-size:17px;"><?php echo "No. ". $_GET['noSuratKontrol']; ?></span></th>
        </thead>
        <tbody>
        <td colspan ="4">
            <br><br>
            <table border = "0" width=100%' style = "text-align:left;">
                <tr>
                    <td width="15%">Kepada Yth</td>
                    <td width="2%">:</td>
                    <td width="40%"><?php
                    $peg = PegawaiM::model()->findByAttributes(array('kodedokter_bpjs'=>$_GET['kodeDokter']));
                    $sept = SepT::model()->findByAttributes(array('nokartuasuransi'=>$_GET['noKartu']));
                    $spesialis = '';
                    if(!empty($peg->spesialissubspesialis_id)) {
                        $spesialis = SpesialissubspesialisM::model()->findByPk($peg->spesialissubspesialis_id)->spesialissubspesialis_nama;
                    }
                  
                    // echo $_GET['namaDokter']."<br/>Sp./Sub. ".$peg->spesialissubspesialis->spesialissubspesialis_nama; 
                    echo $_GET['namaDokter']."<br/>Sp./Sub. " . $spesialis; 
                    // echo $_GET['kodeDokter'];
                    // echo $peg->nama_pegawai;
                    // echo $peg->spesialissubspesialis_id;
                    // echo $peg->spesialissubspesialis->spesialissubspesialis_nama;
                    // echo $sept->nokartuasuransi;
                    ?></td>
                </tr>
                <tr>
                    <td colspan="3">Mohon Pemeriksaan dan Penanganan Lebih Lanjut </td>
                </tr>
                <tr>
                    <td width="15%">No. Kartu</td>
                    <td width="2%">:</td>
                    <td width="40%"><?php echo $_GET['noKartu'];  
                    
                    ?></td>
                </tr>
                <tr>
                    <td width="15%">Nama Peserta</td>
                    <td width="2%">:</td>
                    <td width="40%"><?php echo $_GET['nama']. "(". $_GET['kelamin'] . ")" ; ?></td>
                </tr>
                <tr>
                    <td width="15%">Tanggal Lahir</td>
                    <td width="2%">:</td>
                    <td width="40%"><?php echo $_GET['tglLahir']; ?></td>
                </tr>
                    <td width="15%">Diagnosa</td>
                    <td width="2%">:</td>
                    <td width="40%"><?php echo $_GET['diagnosa']; ?></td>
                </tr>
                <tr>
                    <td width="15%">Rencana Kontrol</td>
                    <td width="2%">:</td>
                    <td width="40%"><?php echo $_GET['tglRencanaKontrol']; ?></td>
                </tr>
            </table>
            </tbody>
        </table>

        <br>
        <br>
        <table style='margin-left:auto; margin-right:auto;' border="0" width="100%">
            <tr>
                <td>Demikian atas bantuannya, diucapkan banyak terima kasih.</td>
            </tr>
        </table>
        <br>
        <br>
        <table style='margin-left:auto; margin-right:auto;' border="0" width="100%">
            <tr>
                <th class="tgl" style="width:36%; text-align:center; padding-bottom: 50px;" colspan="2">
                <br><br><br><br><br><br><br>
                <?php $tgl = date('Y-m-d'); ?>
                <p class="entri">Tgl.Entri: <?php echo $_GET['tglTerbitKontrol']; ?> | Tgl. Cetak <?php echo $tgl; ?></p>
                </th>

                <th style="width:30%; text-align:center; padding-bottom: 50px;" colspan="2">
                </th>
                    
                <th style="width:34%; text-align:center; padding-bottom: 50px;" colspan="2">
                    <p>Mengetahui DPJP,</p>
                    <br><br><br><br><br><br>
                    ( <?php echo $_GET['namaDokter']; ?> )
                </th>

            </tr>
        </table>
    </div>


