<fieldset>
    <table width="74%" style="margin: 0;" cellpadding="0" cellspacing="0">
        <tr>
            <td>No. Pengajuan</td>
            <td>:</td>
            <td><?php echo isset($model->pengajuansterlilisasi_no) ? $model->pengajuansterlilisasi_no : ""; ?></td>
        </tr>
        <tr>
            <td>Tanggal Pengajuan</td>
            <td>:</td>
            <td><?php echo isset($model->pengajuansterlilisasi_tgl) ? MyFormatter::formatDateTimeForUser($model->pengajuansterlilisasi_tgl) : ""; ?></td>
        </tr>
        <tr>
            <td>Pegawai Pengajuan</td>
            <td>:</td>
            <td><?php echo (isset($model->pegawaiMengajukan->NamaLengkap) ? $model->pegawaiMengajukan->NamaLengkap : ""); ?></td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td><?php echo isset($model->pengajuansterlilisasi_ket) ? $model->pengajuansterlilisasi_ket : ""; ?></td>
        </tr>
    </table><br>
    <table class="items table table-striped table-bordered table-condensed" id="table-detailpemesanan">
        <thead>
            <tr>
                <th>No.</th>
                <th>Ruangan Asal</th>
                <th>Nama Peralatan</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(count((array)$modDetail) > 0){
                foreach($modDetail AS $i=>$detail){ ?>
            <tr>
                <td><?php echo $i+1; ?></td>
                <td><?php echo (!empty($detail->pengajuan->ruangan_id) ? $detail->pengajuan->ruangan->ruangan_nama : ""); ?></td>
                <td><?php echo (!empty($detail->barang_id) ? $detail->barang->barang_nama : ""); ?></td>
                <td><?php echo (!empty($detail->pengajuansterlilisasidet_jml) ? $detail->pengajuansterlilisasidet_jml : ""); ?></td>
                <td><?php echo (!empty($detail->pengajuansterlilisasidet_ket) ? $detail->pengajuansterlilisasidet_ket : ""); ?></td>
            </tr>
            <?php    }
            }
            ?>
        </tbody>
    </table>
</fieldset>