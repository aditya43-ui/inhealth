<div class="panel_main">
    <div class="panel_judul">
        XI. ASPEK MEDIS
    </div>
    <div class="panel_body">
        <table class="tab_info">
            <tbody>
                <tr>
                    <td>Diagnosa Medik</td>
                    <td>:</td>
                    <td><?php echo empty($model->diagnosamedik) ? null : $model->diagnosamedik; ?></td>
                </tr>
                <tr>
                    <td>Terapi Medik</td>
                    <td>:</td>
                    <td><?php echo empty($model->terapimedik) ? null : $model->terapimedik; ?></td>
                </tr>
                <tr>
                    <td>Riwayat penggunaan Obat</td>
                    <td>:</td>
                    <td><?php echo empty($model->riwayat_penggunaanobat) ? null : $model->riwayat_penggunaanobat; ?></td>
                </tr>
                <tr>
                    <td>Hasil Pemeriksaan Laboratorium</td>
                    <td>:</td>
                    <td><?php echo empty($model->hasilperiksa_lab) ? null : $model->hasilperiksa_lab; ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="panel_main">
    <div class="panel_judul">
        XI. DIAGNOSA KEPERAWATAN
    </div>
    <div class="panel_body">
        <?php echo empty($model->diagnosakeperawatan) ? null : $model->diagnosakeperawatan; ?>
    </div>
</div>
<br/>
<br/>
<table width="100%">
    <tr>
        <td></td>
        <td width="200" style="text-align: center;">
            <?php echo Yii::app()->user->getState('kabupaten_nama').", ".MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s')); ?>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <?php echo empty($model->perawatpengkaji) ? "-" : $model->perawatpengkaji->namaLengkap; ?>
        </td>
    </tr>
</table>