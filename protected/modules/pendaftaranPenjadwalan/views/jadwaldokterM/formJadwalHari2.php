<table class="table table-bordered table-condensed">

    <thead>
        <tr>
            <th>Minggu</th>
            <th>Senin</th>
            <th>Selasa</th>
            <th>Rabu</th>
            <th>Kamis</th>
            <th>Jumat</th>
            <th>Sabtu</th>
        </tr>
    </thead>

    <?php
    $cnt = 0;

    foreach ($hari_list as $baris => $mingguan): ?>
    <tr>
        <?php foreach ($mingguan as $idx => $item):
            ?>
        <td class="col_tanggal" width="200">
            <?php if (isset($gen[$idx]) && !empty($item)):

                ?>
                <?php echo CHtml::hiddenField("detail[".$cnt."][jadwaldokter_id]", $item['id']); ?>
                <?php echo CHtml::hiddenField("detail[".$cnt."][pegawai_id]", $pegawai_id); ?>
                <?php echo CHtml::hiddenField("detail[".$cnt."][instalasi_id]", $instalasi_id); ?>
                <?php echo CHtml::hiddenField("detail[".$cnt."][ruangan_id]", $ruangan_id); ?>
                <?php echo CHtml::hiddenField("detail[".$cnt."][jadwaldokter_tgl]", $item['tanggal']); ?>
                <?php echo CHtml::hiddenField("detail[".$cnt."][hari]", $idx); ?>
                <?php echo CHtml::checkBox("detail[".$cnt."][ceklis]", true, array(
                    'onclick'=>'cekJadwalAktif($(this));',
                    'class'=>'col_ceklis',
                )); ?>
                <?php echo MyFormatter::formatDateTimeForUser($item['tanggal']); ?><br/>
                <br/>
                <div class="col_content">
                    <div class="input-append required">
                        <input style="float:left" type="text" name="detail[<?php echo $cnt ?>][jadwaldokter_mulai]" class="span2 timePickerTest jadwaldokter_mulai" value="<?php echo $gen[$idx]['jadwaldokter_mulai']; ?>" onchange="hitungJumlahPasienDariEstimasi();"><span class="add-on" style="margin-top:0px !important; height: 31px !important;"><i class="icon-time"></i></span>
                    </div> s/d
                    <div class="input-append required">
                        <input style="float:left" type="text" name="detail[<?php echo $cnt ?>][jadwaldokter_tutup]" class="span2 timePickerTest jadwaldokter_tutup" value="<?php echo $gen[$idx]['jadwaldokter_tutup']; ?>" onchange="hitungJumlahPasienDariEstimasi();"><span class="add-on" style="margin-top:0px !important; height: 31px !important;"><i class="icon-time"></i></span>
                    </div>
                    <hr/>
                    <div style="width: 200px;">
                        <label style="display: inline-block; width: 140px;">Estimasi Pelayanan (menit)</label>
                        <?php echo CHtml::textField("detail[".$cnt."][estimasipelayanan]", $gen[$idx]['estimasipelayanan'], array('class'=>'span1 numbersOnly maximumantrian', 'style'=>'text-align: right;','onblur'=>'hitungJumlahPasienDariEstimasi();')); ?>
                    </div>
                    <div style="width: 200px;">
                        <label style="display: inline-block; width: 140px;">Kuota Pendaftaran Umum</label>
                        <?php echo CHtml::textField("detail[".$cnt."][maximumantrian]", $gen[$idx]['maximumantrian'], array('class'=>'span1 numbersOnly maximumantrian', 'style'=>'text-align: right;')); ?>
                    </div>
                        <div>
                            <label style="display: inline-block; width: 140px;">Kuota Pendaftaran BPJS</label>
                            <?php echo CHtml::textField("detail[".$cnt."][maximumbpjsantrian]",$gen[$idx]['maximumbpjsantrian'], array('class'=>'span1 numbersOnly maximumbpjsantrian', 'style'=>'text-align: right;')); ?>
                        </div>
                    <div>
                        <label style="display: inline-block; width: 140px;">Kuota Pembuatan Janji</label>
                        <?php echo CHtml::textField("detail[".$cnt."][maksbuatjanji]", $gen[$idx]['maksbuatjanji'], array('class'=>'span1 numbersOnly maksbuatjanji', 'style'=>'text-align: right;')); ?>
                    </div>


                </div>

                <hr/>
            <?php
                $cnt++;
            else:
                echo MyFormatter::formatDateTimeForUser(isset($item['tanggal']) ? $item['tanggal'] : date('Y-m-d'));
            endif; ?>
        </td>
        <?php endforeach; ?>
    </tr>
    <?php endforeach; ?>

</table>
