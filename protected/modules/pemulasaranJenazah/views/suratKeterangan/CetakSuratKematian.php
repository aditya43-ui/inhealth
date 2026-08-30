<table style="width:100%;">
    <tr>
        <td>
            <?php echo $this->renderPartial('application.views.headerReport.headerDefaultSurat'); ?>
        </td>
    </tr>
    <tr>
        <td>
            <p style="margin: 0; text-align: center;">
                <h3><?php echo strtoupper($model->judulsurat); ?></h3>
                No.: <?php echo $model->nomorsurat; ?>
            </p><br><br>
        </td>
    </tr>
    <tr>
        <td>
            Yang bertanda tangan di bawah ini, Pejabat <?php echo Yii::app()->user->getState('nama_rumahsakit'); ?>, dengan ini menerangkan bahwa:<br><br>
        </td>
    </tr>
    <tr>
        <td>
            <table>
                <tr>
                    <td width="150px;">Nama Pasien</td><td width="2px;">:</td><td><?php echo $modPasien->nama_pasien; ?></td>
                </tr>
                <tr>
                    <td>Jenis Kelamin</td><td>:</td><td><?php echo $modPasien->jeniskelamin; ?></td>
                </tr>
                <tr>
                    <td>Tempat, Tanggal Lahir</td><td>:</td><td><?php echo $modPasien->tempat_lahir.', '.$modPasien->tanggal_lahir; ?></td>
                </tr>
                <tr>
                    <td>Pekerjaan</td><td>:</td><td><?php echo (isset($modPasien->pekerjaan->pekerjaan_nama) ? $modPasien->pekerjaan->pekerjaan_nama : ""); ?></td>
                </tr>
                <tr>
                    <td>Agama</td><td>:</td><td><?php echo $modPasien->agama; ?></td>
                </tr>
                <tr>
                    <td>Alamat</td><td>:</td><td><?php echo $modPasien->alamat_pasien; ?></td>
                </tr>
                <tr>
                    <td>Kelurahan</td><td>:</td><td><?php echo (isset($modPasien->kelurahan->kelurahan_nama) ? $modPasien->kelurahan->kelurahan_nama:"") ; ?></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <p style="margin: 0; text-align: center;">
                <h3><u>TELAH MENINGGAL DUNIA</u></h3>
            </p><br><br>
        </td>
    </tr>
    <tr>
        <td>
            Demikian Surat Keterangan Kematian ini dibuat dengan sesungguhnya untuk dipergunakan sebagaimana mestinya.<br><br>
        </td>
    </tr>
    <tr>
        <td>
            mengetahui: <br>
            Pejabat Rumah Sakit <br><br><br><br>
            <u><?php echo $model->mengetahui_surat; ?></u>
        </td>
    </tr>
</table>

