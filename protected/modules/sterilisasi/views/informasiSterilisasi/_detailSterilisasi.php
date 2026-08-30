<?php echo $this->renderPartial('application.views.headerReport.headerDefaultNew',array()); ?>
<fieldset>
    <table width="74%" style="margin: 0;" cellpadding="0" cellspacing="0">
        <tr>
            <td>No. Sterilisasi</td>
            <td>:</td>
            <td><?php echo isset($model->sterilisasi_no) ? $model->sterilisasi_no : ""; ?></td>
        </tr>
        <tr>
            <td>Tanggal Sterilisasi</td>
            <td>:</td>
            <td><?php echo isset($model->sterilisasi_tgl) ? MyFormatter::formatDateTimeForUser($model->sterilisasi_tgl) : ""; ?></td>
        </tr>
        <tr>
            <td>Pegawai Sterilisasi</td>
            <td>:</td>
            <td><?php echo (isset($model->pegsterilisasi->NamaLengkap) ? $model->pegsterilisasi->NamaLengkap : ""); ?></td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td><?php echo isset($model->sterilisasi_ket) ? $model->sterilisasi_ket : ""; ?></td>
        </tr>
    </table><br>
    <table class="items table table-striped table-bordered table-condensed" id="table-detailpemesanan">
        <thead>
            <tr>
                <th>No.</th>
                <th>No. Penerimaan Sterilisasi</th>
                <th>Ruangan Asal</th>
                <th>Jenis Sterilisasi</th>
                <th>Alat Sterilisasi</th>
                <th>Nama Peralatan</th>
                <th>Jumlah</th>
                <th>Kemasan Yang Digunakan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(count((array)$modDetail) > 0){
                foreach($modDetail AS $i=>$detail){ 
                    $modPeralatanSterilisasi = PeralatansterilisasiM::model()->findByPk($detail->peralatansterilisasi_id);
                    ?>
            <tr>
                <td><?php echo $i+1; ?></td>
                <td><?php echo (!empty($detail->penerimaansterilisasi_id) ? $detail->penerimaansterilisasi->penerimaansterilisasi_no : ""); ?></td>
                <td><?php echo (!empty($detail->sterilisasi->create_ruangan) ? $detail->sterilisasi->ruangan->ruangan_nama : ""); ?></td>
                <td><?php echo (!empty($detail->jenissterilisasi_id) ? $detail->jenissterilisasi->jenissterilisasi_nama : ""); ?></td>
                <td><?php 
                $barang = BarangM::model()->findByPk($detail->barang_id);
                if (!empty($barang)) {
                    echo $barang->barang_nama;
                } else {
                    echo "-";
                }
                ?></td>
                <td><?php echo (!empty($detail->peralatansterilisasi_id) ? $modPeralatanSterilisasi->peralatansterilisasi_nama : ""); ?></td>
                <td><?php echo (!empty($detail->sterilisasidetail_jml) ? $detail->sterilisasidetail_jml : ""); ?></td>
                <td><?php echo (!empty($detail->kemasanygdigunakan) ? $detail->kemasanygdigunakan : ""); ?></td>
            </tr>
            <?php    }
            }
            ?>
        </tbody>
    </table>
</fieldset>