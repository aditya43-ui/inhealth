<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Pengujian Kompatibilitas
        </div>
    </div>
    <div class="panel-body">
        <?php

        $peg = "";

        $waktu_uji = "";

        if (!empty($pengujianKompat)) {
            foreach ($pengujianKompat as $item) :
        ?>
                <div class="col-sm-6">
                    <div class="control-group">
                        <label class="control-label">Waktu Pengujian</label>
                        <div class="controls">
                            <?php echo CHtml::textField('tube_waktu', $item['tglujikompatibilitas'], array('readonly' => true)); ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="control-group">
                        <label class="control-label">Nama Penguji</label>
                        <div class="controls">
                            <?php echo CHtml::textField('tube_penguji', $item['nama_penguji'], array('readonly' => true)); ?>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
                <table class="table table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th rowspan="2">Nomor Kantong</th>
                            <th rowspan="2">Jenis Darah</th>
                            <th colspan="5" hidden>Hasil Uji Silang Selesai</th>
                        </tr>
                        <!--tr>
                    <th>Major</th>
                    <th>Minor</th>
                    <th>Auto Control</th>
                    <th>DCT</th>
                    <th>Kesimpulan</th>
                </tr-->
                    </thead>
                    <tbody>
                        <?php

                        foreach ($item['det'] as $d) {
                        ?>
                            <tr>
                                <td><?php echo $d['nomorbarcode']; ?></td>
                                <td><?php echo $d['nama_jenis']; ?></td>
                                <?php /*
                        <td><?php echo $d['ujikomp_mayor']; ?></td>
                        <td><?php echo $d['ujikomp_minor']; ?></td>
                        <td><?php echo $d['ujikomp_autokontrol']; ?></td>
                        <td><?php echo $d['ujikomp_dct']; ?></td>
                        <td><?php echo $d['ujikomp_kesimpulan']; ?></td>
                         * 
                         */ ?>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
        <?php endforeach;
        } ?>
    </div>
</div>