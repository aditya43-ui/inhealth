<style>
    .nama_kolom {
        text-align:right;
        vertical-align:top;
    }
    tr, td {
        font-size : 13px;
        font-color : black !important;
    }
</style>

<div class="row">
    <div class="col-sm-6">
        <table width="100%">
            <tr>
                <td width="45%" class="nama_kolom">Tgl Pendaftaran / No. Pendaftaran</td>
                <td width="5%" align="center" style="vertical-align:top">:</td>
                <td width="50%"><?php echo MyFormatter::formatdatetimeId($modPendaftaran->tgl_pendaftaran)." / ".$modPendaftaran->no_pendaftaran;?></td>
            </tr>
            <tr>
                <td class="nama_kolom">No Rekam Medik</td>
                <td align="center">:</td>
                <td><?php echo $modPasien->no_rekam_medik;?></td>
            </tr>
            <tr>
                <td class="nama_kolom">Petugas Pemeriksa</td>
                <td align="center">:</td>
                <td><?php echo $model->petugas->NamaLengkap;?></td>
            </tr>
            <tr>
                <td class="nama_kolom">Tanggal Awal Pelayanan</td>
                <td align="center">:</td>
                <td><?php echo date('d M Y',strtotime($model->tglawal_pelayanan));?></td>
            </tr>
            <tr>
                <td class="nama_kolom">Jam Awal Pelayanan</td>
                <td align="center">:</td>
                <td><?php echo $model->jamawal_pelayanan;?></td>
            </tr>
            <tr>
                <td class="nama_kolom">Ketuban Pecah Sejak Jam</td>
                <td align="center">:</td>
                <td><?php echo MyFormatter::formatdatetimeId($model->ketubahpecahsejak_jam);?></td>
            </tr>
        </table>
    </div>
    <div class="col-sm-6">
        <table width="100%">
            <tr>
                <td width="45%" class="nama_kolom">Mules Sejak Jam</td>
                <td width="5%" align="center">:</td>
                <td width="50%"><?php echo MyFormatter::formatdatetimeId($model->mulessejak_jam);?></td>
            </tr>
            <tr>
                <td class="nama_kolom">Gravida (G)</td>
                <td align="center">:</td>
                <td><?php echo $model->gravida;?></td>
            </tr>
            <tr>
                <td class="nama_kolom">Para (P)</td>
                <td align="center">:</td>
                <td><?php echo $model->para;?></td>
            </tr>
            <tr>
                <td class="nama_kolom">Abortus (A)</td>
                <td align="center">:</td>
                <td><?php echo $model->abortus;?></td>
            </tr>
            <tr>
                <td class="nama_kolom">Anak Hidup (H)</td>
                <td align="center">:</td>
                <td><?php echo $model->jml_anakhidup;?></td>
            </tr>
        </table>
    
    </div>
</div>