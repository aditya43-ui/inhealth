<?php

/**
 * @author Aida Rahmawati <aidarahmawati@.com>
 */
?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b> Riwayat Pemeriksaan Radiologi </b>
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
                foreach ($modRiwayatRad as $rad) {

                ?>
                    <tr>
                        <td> <?php echo $no++; ?></td>
                        <td> <?php echo $rad->pemeriksaanrad->pemeriksaanrad_nama ?></td>
                        <td>
                            <?php
                            $pasienmasukpenunjang_id = $rad['pasienmasukpenunjang_id'];
                            $modDetailPemeriksaan = PasienmasukpenunjangT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
                            foreach ($modDetailPemeriksaan as $key => $penunjang) {
                                echo $penunjang->ruangan->ruangan_nama;
                            }
                            ?>
                        </td>
                        <?php if ($rad->statusperiksahasil == "BELUM") { ?>
                            <td style="text-align: center"> <button class="btn btn-default btn-status nohover" type="button"> <b> BELUM DIPERIKSA</b> </button> </td>
                        <?php } else if ($rad->statusperiksahasil == "SUDAH") { ?>
                            <td style="text-align: center"> <button class="btn btn-info btn-status nohover" type="button"> <b> SUDAH DIPERIKSA</b> </button> </td>
                        <?php } else { ?>
                            <td style="text-align: center"> <button class="btn btn-gold btn-status nohover" type="button"> <b> SEDANG DIPERIKSA</b> </button> </td>
                        <?php } ?>
                        <?php if ($rad->statusperiksahasil == "SUDAH") { ?>
                            <td>
                                <?php
                                echo CHtml::link("<i class='icon-list-alt'></i> ",  Yii::app()->controller->createUrl(
                                    "pemeriksaanPasienMC/detailHasilRad",
                                    array("id" => $rad->pendaftaran_id)
                                ), array("id" => "$modKunjungan->no_pendaftaran", "target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail Radiologi", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat Radiologi"));

                                ?>
                            </td>
                        <?php } else { ?>
                            <td> <?php echo " " ?></td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>