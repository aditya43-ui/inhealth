<fieldset>
    <table width="74%" style="margin: 0;" cellpadding="0" cellspacing="0">
        <tr>
            <td>No. Penyimpanan</td>
            <td>:</td>
            <td><?php echo $model->penyimpanansteril_no; ?></td>
        </tr>
        <tr>
            <td>Tanggal Penyimpanan</td>
            <td>:</td>
            <td><?php echo isset($model->penyimpanansteril_tgl) ? MyFormatter::formatDateTimeForUser($model->penyimpanansteril_tgl) : ""; ?></td>
        </tr>
        <tr>
            <td>Pegawai Penyimpanan</td>
            <td>:</td>
            <td><?php echo (isset($model->pegpenyimpanan->NamaLengkap) ? $model->pegpenyimpanan->NamaLengkap : ""); ?></td>
        </tr>
        <tr>
            <td>Pegawai Mengetahui</td>
            <td>:</td>
            <td><?php echo (isset($model->pegmengetahui->NamaLengkap) ? $model->pegmengetahui->NamaLengkap : ""); ?></td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td><?php echo $model->penyimpanansteril_ket; ?></td>
        </tr>
    </table><br>
    <table class="items table table-striped table-bordered table-condensed" id="table-detailpemesanan">
        <thead>
            <tr>
				<th>No.</th>
				<th>Lokasi Penyimpanan</th>
				<th>Sub Rak</th>
				<th>No. Sterilisasi</th>
				<th>Instalasi</th>
				<th>Ruangan</th>
				<th>Nama Peralatan dan Linen</th>
			</tr>
        </thead>
        <tbody>
            <?php
            if(count((array)$modDetail) > 0){
                foreach($modDetail AS $i=>$detail){ ?>
            <tr>
                <td><?php echo $i+1; ?></td>
                <td><?php echo (!empty($detail->lokasipenyimpanan->lokasipenyimpanan_id) ? $detail->lokasipenyimpanan->lokasipenyimpanan_nama : ""); ?></td>
                <td><?php echo (!empty($detail->rakpenyimpanan->rakpenyimpanan_id) ? $detail->rakpenyimpanan->rakpenyimpanan_nama : ""); ?></td>
                <td><?php echo (!empty($detail->sterilisasi_id) ? $detail->sterilisasi->sterilisasi_no : ""); ?></td>
                <td><?php echo (!empty($detail->sterilisasi->ruangan->instalasi_id) ? $detail->sterilisasi->ruangan->instalasi->instalasi_nama : ""); ?></td>
                <td><?php echo (!empty($detail->sterilisasi->ruangan->ruangan_id) ? $detail->sterilisasi->ruangan->ruangan_nama : ""); ?></td>
                <td><?php echo (!empty($detail->peralatansterilisasi_id) ? $detail->peralatansterilisasi->peralatansterilisasi_nama : 0); ?></td>                
            </tr>
            <?php    }
            }
            ?>
        </tbody>
    </table>	
</fieldset>