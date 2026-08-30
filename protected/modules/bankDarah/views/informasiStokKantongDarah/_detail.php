<?php

/**
 ** - digunakan untuk menampilkan detail stok kantong darah
 **  @author Aida Rahmawati <aidarahmawati@.com>
 **  @author Elham Budianto <elhambudianto@.com>
 **/
?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Detail <?php echo $judul; ?></b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <table style="width: 100%; border: none;">
            <tr>
                <td width="20%">
                    <h5> Komponen Darah </h5>
                </td>
                <td width="25%">
                    <h5> <input readonly="readonly" class="span3" type="text" maxlength="50" value="<?php echo $singkatan_komp ?>"></h5>
                </td>
                <td width="10%"></td>
                <td width="20%">
                    <h5> Golongan Darah </h5>
                </td>
                <td width="25%">
                    <h5> <input readonly="readonly" class="span3" type="text" maxlength="50" value="<?php echo $gol_darah ?>"></h5>
                </td>
            </tr>
        </table>

        <table class="table table-striped">
            <tr>
                <th> No. </th>
                <th> Nomor Kantong Darah </th>
                <th> Rhesus </th>
                <th> Jenis Kantong </th>
            </tr>
            <?php
            $i = 1;
            foreach ($model as $mod) { ?>
                <tr>
                    <td> <?php echo $i++; ?> </td>
                    <td> <?php echo $mod->nomorbarcode ?></td>
                    <td> <?php echo $mod->rhesus ?></td>
                    <td> <?php
                            if (!empty($mod->jeniskantongdarah_id)) {
                                $jenis = JeniskantongdarahM::model()->findByPk($mod->jeniskantongdarah_id);
                                echo $jenis->nama_jenis;
                            } else {
                                echo '-';
                            }
                            ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>