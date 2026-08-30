<div class="span12">
    <table class="table table-bordered table-condensed" id="tabel_kuesioner">
        <thead>
            <tr>
                <th style="text-align:center;">No</th>
                <th>Jenis Evaluasi</th>
                <th style="text-align:center;">Kelengkapan</th>
            </tr>
        </thead>
        <tbody>
            <?php $modPertanyaan = LookupM::model()->findAll("lookup_type = 'jenisevaluasipenawaran' ORDER BY lookup_urutan ASC"); ?>
            <?php $no = 1; ?>                   
            <?php foreach ($modPertanyaan as $value) : ?>
                <?php $modIndikator = EvaluasipenawarandetT::model()->findAllByAttributes(array('evaluasipenawaran_id'=>$model->evaluasipenawaran_id,'evaluasipenawarandet_jenis' => $value->lookup_name)); ?>
                <?php $abjad = 0; ?>    
                <?php
                if ($value->lookup_value == 'Evaluasi Administrasi') {
                    $lookup_value = 'evaluasi_administrasi';
                    $memenuhi = !empty($model->evaluasi_administrasi) ? 'Memenuhi Syarat' : 'Tidak Memenuhi Syarat';
                } else if ($value->lookup_value == 'Evaluasi Teknis') {
                    $lookup_value = 'evaluasi_teknis';
                    $memenuhi = !empty($model->evaluasi_teknis) ? 'Memenuhi Syarat' : 'Tidak Memenuhi Syarat';
                } else if ($value->lookup_value == 'Evaluasi Harga') {
                    $lookup_value = 'evaluasi_harga';
                    $memenuhi = !empty($model->evaluasi_harga) ? 'Memenuhi Syarat' : 'Tidak Memenuhi Syarat';
                } else if ($value->lookup_value == 'Evaluasi Kualifikasi') {
                    $lookup_value = 'evaluasi_kualifikasi';
                    $memenuhi = !empty($model->evaluasi_kualifikasi) ? 'Memenuhi Syarat' : 'Tidak Memenuhi Syarat';
                }
                ?>     
                <tr>
                    <td style="text-align:center;width: 5%">
                        <label>
                            <b><?= $no ?></b>
                        </label>
                        <table width="100%">
                            <?php
                            if (!empty($modIndikator)) {
                                foreach ($modIndikator as $val) {
                                    echo '<tr> <td style="text-align: center"><label>' . CustomFunction::NumtoAlphabet($abjad) . '. </label></td> </tr>';
                                    $abjad++;
                                }
                            }
                            ?>
                        </table>                        
                    </td>
                    <td>
                        <label>
                            <b><?= $value->lookup_name; ?></b>
                        </label>
                        <table >
                            <?php
                            if (!empty($modIndikator)) {
                                foreach ($modIndikator as $val) {
                                    echo '<tr> <td><label>' . $val->evaluasipenawaran_nama . '</label></td> </tr>';
                                }
                            }
                            ?>
                        </table>
                    </td>
                    <td style="text-align:center; width: 15%">
                        <?= CHtml::textField('EvaluasipenawaranT[' . $lookup_value . ']', $memenuhi, array('readonly' => true, 'style' => 'width:160px')) ?> 
                        <table width="100%" class="panel<?php echo $lookup_value ?>">
                            <?php
                            if (!empty($modIndikator)) {
                                foreach ($modIndikator as $val) {
                                    echo '<tr> <td style="text-align: center"> ';
                                    echo CHtml::checkBox('EvaluasipenawarandetT[' . $val->indikatorevaluasipenawaran_id . '][ismemenuhi]', !empty($val->ismemenuhi) ? $val->ismemenuhi : 0, array('onclick' => "setValidasi(this,'" . $lookup_value . "')", 'class' => 'cekLengkap '.$lookup_value)); 
                                    echo CHtml::hiddenField('EvaluasipenawarandetT[' . $val->indikatorevaluasipenawaran_id . '][evaluasipenawarandet_jenis]', $value->lookup_value, array('readonly' => true, 'style' => 'width:160px'));
                                    echo CHtml::hiddenField('EvaluasipenawarandetT[' . $val->indikatorevaluasipenawaran_id . '][evaluasipenawaran_nama]', $val->evaluasipenawaran_nama, array('readonly' => true, 'style' => 'width:160px'));
                                    echo CHtml::hiddenField('EvaluasipenawarandetT[' . $val->indikatorevaluasipenawaran_id . '][indikatorevaluasipenawaran_id]', $val->indikatorevaluasipenawaran_id, array('readonly' => true, 'style' => 'width:160px'));
                                    echo CHtml::hiddenField('EvaluasipenawarandetT[' . $val->indikatorevaluasipenawaran_id . '][evaluasipenawarandet_id]', $val->evaluasipenawarandet_id, array('readonly' => true, 'style' => 'width:160px'));
                                    echo ' </td> </tr>';
                                }
                            }
                            ?>
                        </table>
                    </td>
                </tr>
                <?php $no++; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>