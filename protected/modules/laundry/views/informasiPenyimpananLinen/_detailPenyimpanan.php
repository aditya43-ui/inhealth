<fieldset>
    <table width="74%" style="margin: 0;" cellpadding="0" cellspacing="0">
        <tr>
            <td>No. Penyimpanan</td>
            <td>:</td>
            <td><?php echo isset($model->nopenyimpananlinen) ? $model->nopenyimpananlinen : ""; ?></td>
        </tr>
        <tr>
            <td>Tanggal Penyimpanan</td>
            <td>:</td>
            <td><?php echo isset($model->tglpenyimpananlinen) ? MyFormatter::formatDateTimeForUser($model->tglpenyimpananlinen) : ""; ?></td>
        </tr>
        <tr>
            <td>Pegawai Mengetahui</td>
            <td>:</td>
            <td><?php echo (isset($model->pegmengetahui->NamaLengkap) ? $model->pegmengetahui->NamaLengkap : ""); ?></td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td><?php echo isset($model->keterangan_penyimpanan) ? $model->keterangan_penyimpanan : ""; ?></td>
        </tr>
    </table><br>
    <table class="items table table-striped table-bordered table-condensed" id="table-detailpemesanan">
        <thead>
            <tr>
                <th>No.</th>
                <th>Lokasi Penyimpanan</th>
                <th>Sub Rak</th>
                <th>No. Pencucian</th>
                <th>Kode Linen</th>
                <th>Nama Linen</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(count((array)$modDetail) > 0){
                foreach($modDetail AS $i=>$detail){ ?>
            <tr>
                <td><?php echo $i+1; ?></td>
                <td><?php echo (!empty($detail->lokasipenyimpanan_id) ? $detail->lokasipenyimpanan->lokasipenyimpanan_nama : ""); ?></td>
                <td><?php echo (!empty($detail->rakpenyimpanan_id) ? $detail->rakpenyimpanan->rakpenyimpanan_id : ""); ?></td>
                <td><?php echo (!empty($detail->pencucianlinen_id) ? $detail->pencucianlinen->nopencucianlinen : ""); ?></td>
                <td><?php echo (!empty($detail->linen_id) ? $detail->linen->kodelinen : ""); ?></td>
                <td><?php echo (!empty($detail->linen_id) ? $detail->linen->namalinen : ""); ?></td>
                <td><?php echo $detail->keterangan_penyimpaanlinen; ?></td>
            </tr>
            <?php    }
            }
            ?>
        </tbody>
    </table>
</fieldset>