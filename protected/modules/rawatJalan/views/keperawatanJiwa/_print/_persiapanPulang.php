<?php

$bantuan_item = array(
    'Bantuan Minimal'=>'Bantuan Minimal',
    'Bantuan Total'=>'Bantuan Total'
);

$yatidak_item = array(
    1 => 'Ya',
    0 => 'Tidak',
);

?>

<table class='form_predispo'>
    <tr>
        <td width='10'>1.</td>
        <td width='200'>Makan</td>
        <td>
            <?php echo $model->kebutuhanpulang_makan; ?>
        </td>
    </tr>
    <tr>
        <td>2</td>
        <td>BAB/BAK</td>
        <td>
            <?php echo $model->kebutuhanpulang_bab; ?>
        </td>
    </tr>
    <tr>
        <td></td>
        <td>Jelaskan</td>
        <td>
            <?php echo $model->kebutuhanpulang_penjelasan_makanbab; ?>
        </td>
    </tr>
    <tr>
        <td></td>
        <td><b>Masalah Keperawatan</b></td>
        <td>
            <?php echo $model->kebutuhanpulang_masalahkeperawatan_makanbab; ?>
        </td>
    </tr>
    <tr>
        <td>3</td>
        <td>Mandi</td>
        <td>
            <?php echo $model->kebutuhanpulang_mandi; ?>
        </td>
    </tr>
    <tr>
        <td>4</td>
        <td>Berpakaian/berhias</td>
        <td>
            <?php echo $model->kebutuhanpulang_berpakaian; ?>
        </td>
    </tr>
    <tr>
        <td>5</td>
        <td>Istirahat</td>
        <td>
            <?php 
            
            $istirahat = $model->kebutuhanpulang_istirahat;
            echo "Tidur Siang : ";
            if (isset($istirahat['siang_lama']) && isset($istirahat['siang_lama']['nilai'])) {
                echo "Ya";
                if (isset($istirahat['siang_lama']['awal']) && isset($istirahat['siang_lama']['akhir'])) {
                    echo ", Lama : ".$istirahat['siang_lama']['awal']." s/d ".$istirahat['siang_lama']['akhir'];
                }
            } else {
                echo "Tidak";
            }
            echo "<br>";
            echo "Tidur Malam : ";
            if (isset($istirahat['malam_lama']) && isset($istirahat['malam_lama']['nilai'])) {
                // echo "Ya";
                if (isset($istirahat['malam_lama']['awal']) && isset($istirahat['malam_lama']['akhir'])) {
                    echo ", Lama : ".$istirahat['malam_lama']['awal']." s/d ".$istirahat['malam_lama']['akhir'];
                }
            } else {
               echo "Tidak";
            }
            echo "<br>";
            ?>
            Kegiatan sebelum/sesudah tidur : <?php echo (isset($model->kebutuhanpulang_istirahat['kegiatan']['nilai']) && $model->kebutuhanpulang_istirahat['kegiatan']['nilai']) ? "Ya" : "Tidak"; ?>
            
        </td>
    </tr>
    <tr>
        <td>6.</td>
        <td>Penggunaan Obat</td>
        <td>
            <?php echo $model->kebutuhanpulang_penggunaanobat; ?>
        </td>
    </tr>

    <tr>
        <td>7</td>
        <td>Pemeliharaan Kesehatan</td>
        <td>
        </td>
    </tr>
    <tr>
        <td></td>
        <td>Perawatan Lanjutan</td>
        <td>
            <?php echo $model->kebutuhanpulang_pemeliharaankesehatan_lanjutan ? "Ya" : "Tidak"; ?>
        </td>
    </tr>
    <tr>
        <td></td>
        <td>Perawatan Pendukung</td>
        <td>
            <?php echo $model->kebutuhanpulang_pemeliharaankesehatan_pendukung ? "Ya" : "Tidak"; ?>
        </td>
    </tr>
    <tr>
        <td>8</td>
        <td>Kegiatan di dalam rumah</td>
        <td>
        </td>
    </tr>
    <tr>
        <td></td>
        <td>Memperisapkan Makanan</td>
        <td>
            <?php echo $model->kebutuhanpulang_kegiatanrumah_makanan ? "Ya" : "Tidak"; ?>
        </td>
    </tr>
    <tr>
        <td></td>
        <td>Menjaga kerapihan rumah</td>
        <td>
            <?php echo $model->kebutuhanpulang_kegiatanrumah_kerapihan ? "Ya" : "Tidak"; ?>
        </td>
    </tr>
    <tr>
        <td></td>
        <td>Mencuci Pakaian</td>
        <td>
            <?php echo $model->kebutuhanpulang_kegiatanrumah_mencuci ? "Ya" : "Tidak"; ?>
        </td>
    </tr>
    <tr>
        <td></td>
        <td>Pengaturan Keuangan</td>
        <td>
            <?php echo $model->kebutuhanpulang_kegiatanrumah_keuangan ? "Ya" : "Tidak"; ?>
        </td>
    </tr>
    <tr>
        <td>9</td>
        <td>Kegiatan di luar rumah</td>
        <td>
        </td>
    </tr>
    <tr>
        <td></td>
        <td>Belanja</td>
        <td>
            <?php echo $model->kebutuhanpulang_kegiatanluarrumah_belanja ? "Ya" : "Tidak"; ?>
        </td>
    </tr>
    <tr>
        <td></td>
        <td>Transportasi</td>
        <td>
            <?php echo $model->kebutuhanpulang_kegiatanluarrumah_transportasi ? "Ya" : "Tidak"; ?>
        </td>
    </tr>
    <tr>
        <td></td>
        <td>Lain-lain</td>
        <td>
            <?php echo $model->kebutuhanpulang_kegiatanluarrumah_lain2 ? "Ya" : "Tidak"; ?>
        </td>
    </tr>
    <tr>
        <td></td>
        <td>Jelaskan</td>
        <td>
            <?php echo $model->kebutuhanpulang_penjelasan; ?>
        </td>
    </tr>
    <tr>
        <td></td>
        <td><b>Masalah Keperawatan</b></td>
        <td>
            <?php echo $model->kebutuhanpulang_masalahkeperawatan; ?>
        </td>
    </tr>

</table>