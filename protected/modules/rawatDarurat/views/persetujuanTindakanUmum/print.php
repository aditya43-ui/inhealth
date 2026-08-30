<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">        
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>
<style>
    
    .tab_header {
        width: 100%;
    }
    
    .tab_header td {
        border: 1px solid black;
        line-height: 32px;
        padding-left: 5px;
        vertical-align: top;
    }
    
    .tab_header .head_cell {
        font-weight: bold;
    }
    
    .pilihan_ijin, .pilihan_privasi {
        font-weight: bold;
        cursor: pointer;
    }
    
    .tab_informasi {
        width: 100%;
    }
    
    .tab_informasi th, .tab_informasi td {
        border: 1px solid black;
        padding: 2px;
    }
    
    .tab_informasi th {
        text-align: center;
    }
    
</style>

<?php 


$modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
$modAnamnesa = AnamnesaT::model()->findByAttributes(array(
    'pendaftaran_id'=>$modPendaftaran->pendaftaran_id,
), array(
    'order'=>'anamesa_id desc',
));

if (empty($modAnamnesa)) {
    $modAnamnesa = new AnamnesaT;
}

$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); 
$konfig = KonfigsystemK::model()->find();


$jenis = $model->jenissurat == Params::SURAT_PERSETUJUAN_PERSETUJUAN ? "Persetujuan" : "Penolakan";
$judul = $model->jenissurat == Params::SURAT_PERSETUJUAN_PERSETUJUAN ? "INFORMED CONSENT" : "INFORMED REFUSAL";

?>
<h3 style="text-align: center;"><?php echo $judul; ?></h3>
<h4 style="text-align: center;">SURAT <?php echo strtoupper($jenis); ?></h4>

    <table class="tab_header">
        <tr>
            <td rowspan="2" colspan="2" width="50%" align="center"><img src="<?php echo Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit ?> " style="height: 60px;"/></td>
            <td width="20%" class="head_cell">No. RM</td>
            <td><?php echo $modPasien->no_rekam_medik." / ".substr($modPasien->jeniskelamin, 0, 1); ?></td>
        </tr>
        <tr>
            <td class="head_cell">Nama</td>
            <td><?php echo $modPasien->namadepan.$modPasien->nama_pasien; ?></td>
        </tr>
        <tr>
            <td width="20%" class="head_cell">Riwayat Alergi</td>
            <td><?php echo $modAnamnesa->riwayatalergiobat; ?></td>
            <td class="head_cell">Tgl. Lahir</td>
            <td><?php echo MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir); ?></td>
        </tr>
        <tr>
            <td class="head_cell">Riwayat Penyakit Terdahulu</td>
            <td><?php echo $modAnamnesa->riwayatpenyakitterdahulu; ?></td>
            <td class="head_cell">Alamat</td>
            <td><?php echo $modPasien->alamat_pasien; ?></td>
        </tr>
    </table>

<table class="tab_informasi">
    <thead>
        <tr>
            <th>JENIS INFORMASI</th>
            <th>ISI INFORMASI</th>
            <th>PARAF / TANDA</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        foreach ($inform->informasi_tindakan_medis as $jenis => $item): ?>
        <tr>
            <td><?php echo $jenis; ?></td>
            <td><?php echo $item['text']; ?></td>
            <td style="text-align: center;">
                <?php echo '<span class="fa fa'.($item['ceklis'] == 1 ? '-check' : '').'-square-o"></span>'?>
            </td>
        </tr>
        <?php
        endforeach;
        ?>
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">
                Dengan ini menyatakan bahwa saya sebagai Dokter telah menjelaskan semua hal tersebut diatas
                secara benar dan jelas serta memberikan kesempatan untuk bertanya dan atau berdiskusi.
            </td>
            <td style="text-align: center;">
                <br/>
                <br/>
                <?php echo $inform->nama_menyetujui1; ?>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                Dengan ini menyatakan bahwa saya telah menerima semua informasi dari Dokter sebagaimana diatas
                kemudian saya beri tanda (V) atau paraf dan telah memahami semua penjelasan Dokter.
            </td>
            <td style="text-align: center;">
                <br/>
                <br/>
                <?php echo $inform->nama_menyetujui2; ?>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                Dengan ini saya memahami manfaat dari Tindakan Medis sebagaimana yang telah dijelaskan kepada
                saya, termasuk Resiko dan Komplikasi yang mungkin timbul.
            </td>
            <td style="text-align: center;">
                <br/>
                <br/>
                <?php echo $inform->nama_menyetujui3; ?>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                Dengan ini saya memahami bahwa Dokter melakukan suatu upaya maksimal maka keberhasilan Tindakan
                Medis bukanlah keniscayaan melainkan sangat tergantung pada izin Allah SWT
            </td>
            <td style="text-align: center;">
                <br/>
                <br/>
                <?php echo $inform->nama_menyetujui4; ?>
            </td>
        </tr>
    </tbody>
</table>
<div style="text-align: center; padding: 20px">
    Dengan ini saya menjatakan <b>
        <?php echo $model->jenissurat == Params::SURAT_PERSETUJUAN_PERSETUJUAN ? "SETUJU" : "TIDAK SETUJU"; ?>
    </b> dengan Tindakan Medis yang dilaksanakan tersebut.
</div>
<table>
    
</table>
<table class="tab_informasi">
    <tr>
        <td width="33%" align="center">
            Dokter/Operator
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            (
            <?php 
            $peg = PasienmasukpenunjangT::model()->findByPk($model->dokter_id);
            echo $peg->pegawai->namaLengkap;
            
            ?>
            )
        </td>
        <td align="center">
            Yang Membuat Pernyataan
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <?php echo "(".$model->nama_yangmenyetujui.")"; ?>
        </td>
        <td width="33%" align="center">
            Perawat/Bidan
            <br/>Pemberi Penjelasan
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <?php 
            echo "(";
            if (!$model->isNewRecord && !empty($model->pegawaisaksi1_id)) {
                $peg = PegawaiM::model()->findByPk($model->pegawaisaksi1_id);
                echo $peg->nama_pegawai;
            }
            echo ")";
            
            ?>
            
            
        </td>
    </tr>
</table>