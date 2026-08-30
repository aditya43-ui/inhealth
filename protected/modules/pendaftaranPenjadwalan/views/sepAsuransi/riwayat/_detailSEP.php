<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title pull-left">
            <strong><?php echo $data['noSep']; ?></strong>
        </div>
        <div class="panel-title pull-right">
            <?php echo $data['jnsPelayanan'] == 2 ? "Rawat Jalan" : "Rawat Inap"; ?>
        </div>
    </div>
    <div class="panel-body">
        <table width="100%" class="tab_sep_detail">
            <tbody>
                <tr>
                    <td width="200">Spesialis/Sub Spesialis</td>
                    <td width="10">:</td>
                    <td><?php 
                    echo $data['poli']; 
                    if ($detail['poliEksekutif'] != 0) {
                        echo " (Eksekutif)";
                    }
                    ?></td>
                </tr>
                <tr>
                    <td>DPJP yang Melayani</td>
                    <td>:</td>
                    <td><?php echo $detail['dpjp']['nmDPJP'] ?? "-"; ?></td>
                </tr>
                <tr hidden>
                    <td>Asal Rujukan</td>
                    <td>:</td>
                    <td></td>
                </tr>
                <tr hidden>
                    <td>PPK Asal Rujukan</td>
                    <td>:</td>
                    <td></td>
                </tr>
                <tr hidden>
                    <td>Tgl. Rujukan</td>
                    <td>:</td>
                    <td></td>
                </tr>
                <tr>
                    <td>No. Rujukan</td>
                    <td>:</td>
                    <td><?php echo $detail['noRujukan'] ?? "-"; ?></td>
                </tr>
                <tr>
                    <td>Tgl. SEP</td>
                    <td>:</td>
                    <td><?php echo empty($detail['tglSep']) ? "-" : MyFormatter::formatDateTimeForUser($detail['tglSep']); ?></td>
                </tr>
                <tr>
                    <td>No. RM</td>
                    <td>:</td>
                    <td><?php echo $detail['peserta']['noMr'] ?? "-"; ?></td>
                </tr>
                <tr>
                    <td>Diagnosa</td>
                    <td>:</td>
                    <td><?php echo $data['diagnosa'] ?? "-"; ?></td>
                </tr>
                <tr hidden>
                    <td>No. Telepon</td>
                    <td>:</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Catatan</td>
                    <td>:</td>
                    <td><?php echo $detail['catatan'] ?? "-"; ?></td>
                </tr>
                <tr>
                    <td>Status Kecelakaan</td>
                    <td>:</td>
                    <td><?php echo $detail['nmstatusKecelakaan'] ?? "-"; ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<br/>