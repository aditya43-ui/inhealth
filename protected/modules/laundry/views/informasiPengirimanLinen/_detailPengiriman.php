
    <table width="100%" style="margin:5px;" cellpadding="0" cellspacing="0">
        <tr>
            <td>No. Pengiriman</td>
            <td>:</td>
            <td><?php echo isset($model->nopengirimanlinen) ? $model->nopengirimanlinen : ""; ?></td>
        </tr>
        <tr>
            <td>Tanggal Pengiriman</td>
            <td>:</td>
            <td><?php echo isset($model->tglpengirimanlinen) ? MyFormatter::formatDateTimeForUser($model->tglpengirimanlinen) : ""; ?></td>
        </tr>
        <tr>
            <td>Pegawai Pengirim</td>
            <td>:</td>
            <td><?php echo (isset($model->pegpengirim->NamaLengkap) ? $model->pegpengirim->NamaLengkap : ""); ?></td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td><?php echo isset($model->keterangan_perawatan) ? $model->keterangan_perawatan : ""; ?></td>
        </tr>
    </table><br>
    <table width="100%"  class="items table table-striped table-bordered table-condensed" id="table-detailpemesanan">
        <thead>
            <tr>
                <th>No.</th>
                <th>Ruangan Asal</th>
                <th>No. Penerimaan</th>
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
                <td><?php echo (!empty($detail->ruangan_id) ? $detail->ruangan->ruangan_nama : ""); ?></td>
                <td><?php echo (!empty($detail->pengirimanlinen_id) ? $detail->pengirimanlinen->nopengirimanlinen : ""); ?></td>
                <td><?php echo (!empty($detail->linen_id) ? $detail->linen->kodelinen : ""); ?></td>
                <td><?php echo (!empty($detail->linen_id) ? $detail->linen->namalinen : ""); ?></td>
                <td><?php echo $detail->keterangan_linen; ?></td>
            </tr>
            <?php    }
            }
            ?>
        </tbody>
    </table>
