<?php
                            // var_dump(); die;
                        ?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-list-alt"></i> Tabel Riwayat <b>Pengecekan Kelengkapan Data Pasien Pulang</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12">
                <table class="items table table-striped table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th style="width: 10%;">No. </th>
                            <th>Tanggal & Jam Pengecekan</th>
                            <th>No. Pendaftaran</th>
                            <th>Nama Petugas</th>
                            <th>Cetak</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php if(empty($modRiwayat)):?>
                        <tr>
                            <td colspan="5">Data Tidak Ditemukan</td>
                        </tr>
                        <?php else:?>
                        <?php foreach($modRiwayat as $i => $r):?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= MyFormatter::formatDateTimeForUser($r->create_time) ?></td>
                            <td><?= $r->pendaftaran->no_pendaftaran ?></td>
                            <td>
                                <?php 
                                    if($r->loginpemakai->pegawai) {
                                        echo $r->loginpemakai->pegawai->namaLengkap;
                                    } else {
                                        echo '-';
                                    }
                                ?>
                            </td>
                            <td style="text-align: center; width: 60px;">
                                <?php
                                        echo CHtml::link('<i class="icon-form-print"></i>', 'javascript:void(0)', array(
                                            'onclick' => "printChecklist(" . $r->pendaftaran_id . ", " . $r->kelengkapandokumen_id . ", 'PRINT'); return false;", 'rel' => 'tooltip', 'title' => 'Klik untuk Mencetak Pasien Keluar ICU',
                                        ));
                                    ?>
                            </td>
                        </tr>
                        <?php endforeach;?>
                        <?php endif;?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>