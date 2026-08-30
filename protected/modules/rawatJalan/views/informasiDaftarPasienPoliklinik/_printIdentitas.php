<style>
@media print {

    .container {
        font-family: arial;
        font-size: 7pt;
        font-weight: bold;
    }

    .header {
        text-align: center;
        margin-bottom: 10px;
    }

    .garis {
        width: 100%;
        border-top: 1px solid black;
    }

    .garis2 {
        width: 100%;
        margin-top: 1px;
        border-top: 2px solid black;
    }

    .content tr, .content td {
        width: 100%;
        font-family: arial;
        font-size: 7pt;
        font-weight: bold;
    }

    .footer {
        text-align: right;    
        font-size: 6.5pt;
        margin-bottom: 10px;

    }

    .content tr, .content td {

        vertical-align: top;
    }

}
</style>

<?php

$profil = ProfilrumahsakitM::model()->find();
$garisbatas = '---------------------------------------------------------------------------';

$untuk = ['Pasien', 'Arsip'];

?>

<?php foreach($untuk as $i => $u) :?>

<div class="container">
    <?= $garisbatas?>
    <div class="header">
        <?php echo $profil->nama_rumahsakit ?><br>
        <?php echo $profil->alamatlokasi_rumahsakit ?><br>
        <?php echo 'Telepon. ' . $profil->no_telp_profilrs ?><br>
    </div>
    <div class="body">
        Untuk <?= $u ?>
        <div class="garis"></div>
        <div class="garis2"></div>
        <table class="content">
            <tr>
                <td style="width: 43%;">No. Rekam Medis</td>
                <td style="width: 5%; text-align: center;"> : </td>
                <td style=""><?= $model->no_rekam_medik ?></td>
            </tr>
            <tr>
                <td style="width: 43%;">Nama Pasien</td>
                <td style="width: 5%; text-align: center;"> : </td>
                <td style=""><?= $model->nama_pasien ?></td>
            </tr>
            <tr>
                <td style="width: 43%;">Tgl. Lahir</td>
                <td style="width: 5%; text-align: center;"> : </td>
                <td style=""><?= date('d-m-Y', strtotime($model->tanggal_lahir)) ?></td>
            </tr>
            <tr>
                <td style="width: 43%;">Alamat Pasien</td>
                <td style="width: 5%; text-align: center;"> : </td>
                <td style=""><?= $model->alamat_pasien ?></td>
            </tr>
            <tr>
                <td style="width: 43%;">Tgl. Lahir</td>
                <td style="width: 5%; text-align: center;"> : </td>
                <td style=""><?= date('d-m-Y', strtotime($model->tanggal_lahir)) ?></td>
            </tr>
            <tr>
                <td style="width: 43%;">No. Telepon</td>
                <td style="width: 5%; text-align: center;"> : </td>
                <td style=""><?= $model->no_telepon_pasien ?></td>
            </tr>

        </table>
    </div>
    <div class="footer">
        Petugas:<br>
        Tanggal Cetak: <?= MyFormatter::formatDateTimeForUser(date('Y-m-d'));?>
    </div>
    <?= $garisbatas?>
</div>
<?php if($i < count($untuk) - 1) echo '<div style="margin-top: 30px;"></div>'?>
<?php endforeach;?>