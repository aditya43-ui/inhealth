<style>
.td-black {
    border: 1px solid black;
}

.tbl-collapse {
    border-collapse: collapse;
}
</style>
<div style="margin: 30px;">
    <?php
echo $this->renderPartial($this->path_view . '_headerPrint',array('judulLaporan'=>$judulLaporan, 'daftar' => $pendaftaran, 'colspan'=>''));  
?>
    <table>
        <tbody>
            <tr>
                <td style="width: 20%;"></td>
                <td style="width: 50%; text-align: center;">
                    <h3><?php echo 'LEMBAR CATATAN HASIL'; ?></h3>
                    <h4><?php echo 'ELEKTROKARDIOGRAM'; ?></h4>
                </td>
                <td>
                <td style="border: 1px solid black; margin-right: 0px; width: 30%;" class="d-flex justify-content-end">
                    <table class="tab_header" style="width: 100%;">
                        <tr>
                            <td width="100">No. RM</td>
                            <td width="10">:</td>
                            <td><?php echo $pendaftaran->pasien->no_rekam_medik; ?></td>
                        </tr>
                        <tr>
                            <td>Nama Pasien</td>
                            <td>:</td>
                            <td><?php echo $pendaftaran->pasien->nama_pasien; ?></td>
                        </tr>
                        <tr>
                            <td>Tanggal Lahir</td>
                            <td>:</td>
                            <td><?php echo MyFormatter::formatDateTimeForUser($pendaftaran->pasien->tanggal_lahir); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Jenis Kelamin</td>
                            <td>:</td>
                            <td><?php echo $pendaftaran->pasien->jeniskelamin; ?></td>
                        </tr>
                    </table>

                </td>
                </td>
            </tr>
        </tbody>
    </table>
    <br />
    <br />
    <table style="width: 100%; border: 1px solid black;" class="tbl-collapse">
        <tbody>
            <tr>
                <td colspan="2">
                    <table style="width: 100%;">
                        <tr>
                            <td colspan="9">Frekwensi&emsp;<?php echo $model->frekuensijantung?></td>
                        </tr>
                        <tr>
                            <td style="width: 20%;">Atrium</td>
                            <td style="width: 3%;">:</td>
                            <td style="width: 10%;"><?php echo $model->atrium?></td>
                            <td style="width: 20%;">P-R interval</td>
                            <td style="width: 3%;"></td>
                            <td style="width: 10%;"><?php echo $model->pr_interval?></td>
                            <td style="width: 20%;">Sek sumbu listrik QRS</td>
                            <td style="width: 3%;"></td>
                            <td style="width: 10%;"><?php echo $model->seksumbulistrik_qrs?></td>
                        </tr>
                        <tr>
                            <td style="width: 20%;">Ventrikel</td>
                            <td style="width: 3%;">:</td>
                            <td style="width: 10%;"><?php echo $model->ventrikel?></td>
                            <td style="width: 20%;">QRS interval</td>
                            <td style="width: 3%;">:</td>
                            <td style="width: 10%;"><?php echo $model->qrs_interval?></td>
                            <td style="width: 20%;">Sek bidang frontal</td>
                            <td style="width: 3%;">:</td>
                            <td style="width: 10%;"><?php echo $model->sekbidangfrontal?></td>
                        </tr>
                        <tr>
                            <td colspan="9">&emsp;</td>
                        </tr>
                        <tr>
                            <td colspan="9">IRAMA&emsp;<?php echo $model->iramajantung?></td>
                        </tr>
                        <tr>
                            <td style="width: 33%;" colspan="3">Devisa dari normal</td>
                            <td style="width: 33%;" colspan="3"></td>
                            <td style="width: 33%;" colspan="3">Interpretasi</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="width: 100%;">
        <tr style=" height: 300px;">
            <td style=" border: 1px solid black; border-top: 0px solid transparent;">&nbsp;</td>
            <td style=" border: 1px solid black; border-top: 0px solid transparent;">&nbsp;</td>
        <tr>
        <tr style=" height: 300px;">
            <td style=" border: 1px solid black; border-top: 0px solid transparent;" colspan="2">&nbsp;</td>
        <tr>
        <tr style=" height: 300px;">
            <td style=" border: 1px solid black; border-top: 0px solid transparent;" colspan="2">&nbsp;</td>
        <tr>
    </table>
</div>