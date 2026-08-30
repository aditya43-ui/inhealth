<style>
    body {
        color: black;
    }
    .border th,
    .border td {
        border: 1px solid #000;
        padding: 2px;
    }

    .table thead:first-child {
        border-top: 1px solid #000;
    }

    thead th {
        background: none;
        color: #333;
    }

    .table tbody tr td,
    .table tbody tr th {
        background-color: none;
    }

    .table {
        box-shadow: none;
    }

    .judulcontent {
        text-align: center;
        color: black !important;
        font-weight: bold;
        font-size: 12pt;
    }
</style>
<?php
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
?>
<table style="width: 100%; border: none;">
    <thead>
        <tr>
            <td>
                <div class="header">
                <?php
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                ?></div>
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
                    <div class="judulcontent">
                        RIWAYAT WAKTU TUNGGU LAYANAN
                    </div>
                    <table class='table' style="border: 0;">
                        <tr>
                            <td width="180px"> Tgl. Pendaftaran </td>
                            <td>
                                : <?php echo MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran); ?>
                            </td>
                        </tr>
                        
                        <tr>
                            <td> No. Pendaftaran </td>
                            <td>
                                : <?php echo CHtml::encode($modPendaftaran->no_pendaftaran); ?>
                            </td>
                        </tr>
                        <tr>
                            <td> No. Rekam Medik </td>
                            <td>
                                : <?php echo CHtml::encode($modPasien->no_rekam_medik); ?>
                            </td>
                        </tr>
                        <tr>
                            <td> Nama Pasien </td>
                            <td>
                                : <?php echo $modPasien->namadepan.' '.$modPasien->nama_pasien; ?>
                            </td>
                        </tr>
                        <tr>
                            <td> Ruangan </td>
                            <td>
                                : <?php echo $modPendaftaran->ruangan->ruangan_nama; ?>
                            </td>
                        </tr>
                        <tr>
                            <td> Kode Booking </td>
                            <td>
                                : <?php echo $kodebooking; ?>
                            </td>
                        </tr>
                    </table>

                    <p style="text-align: center;">RINCIAN STATUS KIRIM<center>
                        <p style="margin: 0; text-align: center;">
                            <div style="border: 1px solid black; width: 80%;"></div>
                        </p>
                        </center>
                    </p>
                    <br>
                    <table width="85%" style='margin-left:auto; margin-right:auto;' class="border">
                        <thead class="border">
                            <th>No.</th>
                            <th>Tanggal Waktu Tunggu</th>
                            <th>Task</th>
                            <th>Status Kirim</th>    
                            <th>Response BPJS</th>
                            <th>Tanggal Kirim</th>
                        </thead>
                        <?php
                        if(!empty($waktu_riwayat)){
                            foreach ($waktu_riwayat as $i => $modRw) {
                        ?>
                            <tr class="border">
                                <td><?php echo ($i + 1) . "."; ?></td>
                                <td><?php echo MyFormatter::formatDateTimeForUser($modRw['tanggal']); ?></td>
                                <td><?php echo $modRw['task_id'].' - '.$modRw['task']; ?></td>
                                <td style="text-align: center"><?php echo $modRw['terkirim']; ?></td>
                                <td><?php echo $modRw['response_list']; ?></td>
                                <td><?php echo (!empty($modRw['tgl_kirim'])? MyFormatter::formatDateTimeForUser($modRw['tgl_kirim']) : ""); ?></td>
                            </tr>
                        <?php }
                        } ?>
                    </table>
                </div>
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>
                <div class="footer-space">&nbsp;</div>
            </td>
        </tr>
    </tfoot>
</table>
