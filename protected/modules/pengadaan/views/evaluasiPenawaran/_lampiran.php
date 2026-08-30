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
                <?php $cekpersiapan = PersiapanpengadaanT::model()->findByPk($_GET['id']);?>
                <?php if (!empty($cekpersiapan)) : ?>
                    <?php $cekjenis = PengadaanjenisT::model()->findByAttributes(array('rencanaumumpengadaan_id' => $cekpersiapan->rencanaumumpengadaan_id)) ?>
                    <?php $modIndikator = IndikatorevaluasipenawaranM::model()->findAllByAttributes(array('evaluasipenawaran_jenis' => $value->lookup_name, 'jenispengadaan_id' => $cekjenis->jenispengadaan_id)); ?>
                    <?php $abjad = 0; ?>    
                    <?php
                    if ($value->lookup_value == 'Evaluasi Administrasi') {
                        $lookup_value = 'evaluasi_administrasi';
                    } else if ($value->lookup_value == 'Evaluasi Teknis') {
                        $lookup_value = 'evaluasi_teknis';
                    } else if ($value->lookup_value == 'Evaluasi Harga') {
                        $lookup_value = 'evaluasi_harga';
                    } else if ($value->lookup_value == 'Evaluasi Kualifikasi') {
                        $lookup_value = 'evaluasi_kualifikasi';
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
                            <?= CHtml::textField('EvaluasipenawaranT[' . $lookup_value . ']', 'Tidak Memenuhi Syarat', array('readonly' => true, 'style' => 'width:160px')) ?> 
                            <table width="100%" class="panel<?php echo $lookup_value ?>">
                                <?php
                                if (!empty($modIndikator)) {
                                    foreach ($modIndikator as $val) {
                                        echo '<tr> <td style="text-align: center"> ';
                                        echo CHtml::checkBox('EvaluasipenawarandetT[' . $val->indikatorevaluasipenawaran_id . '][ismemenuhi]', false, array('onclick' => "setValidasi(this,'" . $lookup_value . "')", 'class' => 'cekLengkap ' . $lookup_value));
                                        echo CHtml::hiddenField('EvaluasipenawarandetT[' . $val->indikatorevaluasipenawaran_id . '][evaluasipenawarandet_jenis]', $value->lookup_value, array('readonly' => true, 'style' => 'width:160px'));
                                        echo CHtml::hiddenField('EvaluasipenawarandetT[' . $val->indikatorevaluasipenawaran_id . '][evaluasipenawaran_nama]', $val->evaluasipenawaran_nama, array('readonly' => true, 'style' => 'width:160px'));
                                        echo CHtml::hiddenField('EvaluasipenawarandetT[' . $val->indikatorevaluasipenawaran_id . '][indikatorevaluasipenawaran_id]', $val->indikatorevaluasipenawaran_id, array('readonly' => true, 'style' => 'width:160px'));
                                        echo ' </td> </tr>';
                                    }
                                }
                                ?>
                            </table>
                        </td>
                    </tr>
                    <?php $no++; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>