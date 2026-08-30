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
            foreach ($pengujianKompat as $det) {
        ?>
                <div class="col-sm-6">
                    <div class="control-group">
                        <label class="control-label">Waktu Pengujian</label>
                        <div class="controls">
                            <?php echo CHtml::textField('tube_waktu', $det['tglujikompatibilitas'], array('readonly' => true)); ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="control-group">
                        <label class="control-label">Nama Penguji</label>
                        <div class="controls">
                            <?php echo CHtml::textField('tube_penguji', $det['nama_penguji'], array('readonly' => true)); ?>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
                <table class="table table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>Nomor Kantong</th>
                            <th>Jenis Darah</th>
                            <!--th colspan="5" style="text-align: center;">Pemeriksaan Goldar Metode Slide Test</th>
                    <th colspan="6" style="text-align: center;">Hasil Uji Silang Serasi</th-->
                        </tr>
                        <!--tr>
                    <th></th>
                    <th></th>
                    <th colspan='4' style="text-align: center;">Sel Grouping</th>
                    <th colspan='3' style="text-align: center;" hidden>Serum Typing</th>
                    <th>Kesimpulan</th>
                    <th>Mayor</th>
                    <th>Minor</th>
                    <th>Auto Kontrol</th>
                    <th>DCT</th>
                    <th>Kesimpulan</th>
                    <th>Rilis</th>
                </tr>
                <tr>
                    <th></th>
                    <th></th>
                    <th>Anti A</th>
                    <th>Anti B</th>
                    <th>Anti AB</th>
                    <th>Anti D</th>
                    <th hidden>Test Cell A</th>
                    <th hidden>Test Cell B</th>
                    <th hidden>Test Cell O</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr-->
                    </thead>
                    <tbody>
                        <?php
                        foreach ($det['det'] as $item) {
                        ?>
                            <tr>
                                <td><?php echo $item['nomorbarcode']; ?></td>
                                <td><?php echo ($item['nama_jenis']); ?></td>
                                <?php /*
                    <td><?php echo $item['anti_a']; ?></td>
                    <td><?php echo $item['anti_b']; ?></td>
                    <td><?php echo $item['anti_ab']; ?></td>
                    <td><?php echo $item['anti_d']; ?></td>
                    <td hidden><?php echo $item['sel_a']; ?></td>
                    <td hidden><?php echo $item['sel_b']; ?></td>
                    <td hidden><?php echo $item['sel_o']; ?></td>
                    <td><?php echo $item['ket_hasiluji']; ?></td>
                    <td><?php echo $item['ujikomp_mayor']; ?></td>
                    <td><?php echo $item['ujikomp_minor']; ?></td>
                    <td><?php echo $item['ujikomp_autokontrol']; ?> </td>
                    <td><?php echo $item['ujikomp_dct']; ?> </td>
                    <td><?php echo $item['ujikomp_kesimpulan']; ?></td>
                    <td><?php echo $item['rilis']; ?></td>
                     * 
                     */ ?>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
        <?php }
        } ?>
    </div>
</div>