<?php

/**
 * @author Aida Rahmawati <aidarahmawati@.com>
 */
?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b> Riwayat Treadmill </b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <table class="table table-striped table-condensed">
            <thead>
                <tr>
                    <th> No. </th>
                    <th> Nama Pemeriksaan</th>
                    <th> Ruangan Pemeriksaan</th>
                    <th> Status Pemeriksaan</th>
                    <th> Hasil </th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($modRiwayatTM as $tm) {
                    $treadmill_id = $tm['treadmill_id'];
                    $modDetailTreadmill = TreadmilldetailT::model()->findAllByAttributes(array('treadmill_id' => $treadmill_id));
                    foreach ($modDetailTreadmill as $key => $detail) {
                ?>
                        <td> <?php echo $no++ ?> </td>
                        <td> Treadmill </td>
                        <td>
                            <?php
                            $ruangan_id = $tm['ruangan_id'];
                            $ruangan = RuanganM::model()->findAllByAttributes(array('ruangan_id' => $ruangan_id));
                            foreach ($ruangan as $key => $ruang) {
                                echo $ruang->ruangan_nama;
                            }
                            ?>
                        </td>
                        <?php if ($modKunjungan->statusperiksa == Params::STATUSPERIKSA_RUJUKAN) { ?>
                            <td style="text-align: center"> <button class="btn btn-default btn-status nohover" type="button"> <b> RUJUKAN</b> </button> </td>
                        <?php } else if ($modKunjungan->statusperiksa == Params::STATUSPERIKSA_SUDAH_DIPERIKSA) { ?>
                            <td style="text-align: center"> <button class="btn btn-info btn-status nohover" type="button"> <b> SUDAH DIPERIKSA</b> </button> </td>
                        <?php } else if ($modKunjungan->statusperiksa == Params::STATUSPERIKSA_SEDANG_PERIKSA) { ?>
                            <td style="text-align: center"> <button class="btn btn-gold btn-status nohover" type="button"> <b> SEDANG DIPERIKSA</b> </button> </td>
                        <?php } else if ($modKunjungan->statusperiksa == Params::STATUSPERIKSA_ANTRIAN) { ?>
                            <td style="text-align: center"> <button class="btn btn-purple btn-status nohover" type="button"> <b> ANTRIAN</b> </button> </td>
                        <?php } else if ($modKunjungan->statusperiksa == Params::STATUSPERIKSA_BATAL_PERIKSA) { ?>
                            <td style="text-align: center"> <button class="btn btn-purple btn-status nohover" type="button"> <b> BATAL PERIKSA </b> </button> </td>
                        <?php } else if ($modKunjungan->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) { ?>
                            <td style="text-align: center"> <button class="btn btn-primary btn-status nohover" type="button"> <b> SUDAH PULANG </b> </button> </td>
                        <?php } else if ($modKunjungan->statusperiksa == Params::STATUSPERIKSA_NUNGGU_DAFTAR_SO) { ?>
                            <td style="text-align: center"> <button class="btn btn-orange btn-status nohover" type="button"> <b> MENUNGGU ADMISI PASIEN </b> </button> </td>
                        <?php } else { ?>
                            <td style="text-align: center"> <button class="btn btn-purple btn-status nohover" type="button"> <b> SEDANG DIRAWAT INAP </b> </button> </td>
                        <?php } ?>
                        <td>
                            <?php
                            echo CHtml::link("<i class='icon-list-alt'></i> ",  Yii::app()->controller->createUrl(
                                "pemeriksaanPasienMC/detailTreadmill",
                                array("id" => $modKunjungan->pendaftaran_id)
                            ), array("id" => "$modKunjungan->no_pendaftaran", "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Treadmill", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Treadmill"));

                            ?>
                        </td>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>