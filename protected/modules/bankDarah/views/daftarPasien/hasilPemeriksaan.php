<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pppendaftaran-mp-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => false,
    'type' => 'horizontal',
    'focus' => '#isPasienLama',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
));
//
?>
<?php $this->widget('bootstrap.widgets.BootAlert');
$this->renderPartial('/_ringkasDataPasien', array('modPasienMasukPenunjang' => $modPasienMasukPenunjang));
?>

<?php
if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_LAB_KLINIK) {
?>
    <?php
    $i = 0;
    foreach ($modDetailHasilPemeriksaanLab as $dataDetailpemeriksaaanLab) :
        $jenis = $dataDetailpemeriksaaanLab->pemeriksaanlab->jenispemeriksaan->jenispemeriksaanlab_nama;
        $kelDetail = $dataDetailpemeriksaaanLab->pemeriksaandetail->nilairujukan->kelompokdet;
        $periksa[$jenis][$kelDetail][$i]['id_pemeriksaan'] = $dataDetailpemeriksaaanLab->pemeriksaanlab->pemeriksaanlab_id;
        $periksa[$jenis][$kelDetail][$i]['detailhasilpemeriksaanlab_id'] = $dataDetailpemeriksaaanLab['detailhasilpemeriksaanlab_id'];
        $periksa[$jenis][$kelDetail][$i]['hasilpemeriksaan'] = $dataDetailpemeriksaaanLab['hasilpemeriksaan'];
        $periksa[$jenis][$kelDetail][$i]['nilairujukan'] = $dataDetailpemeriksaaanLab->pemeriksaandetail->nilairujukan->nilairujukan_nama;
        $periksa[$jenis][$kelDetail][$i]['id_nilairujukan'] = $dataDetailpemeriksaaanLab->pemeriksaandetail->nilairujukan->nilairujukan_id;
        $periksa[$jenis][$kelDetail][$i]['hasilpemeriksaan_satuan'] = $dataDetailpemeriksaaanLab->pemeriksaandetail->nilairujukan->nilairujukan_satuan;
        $periksa[$jenis][$kelDetail][$i]['hasilpemeriksaan_metode'] = $dataDetailpemeriksaaanLab->pemeriksaandetail->nilairujukan->nilairujukan_metode;
        $periksa[$jenis][$kelDetail][$i]['nilairujukan_keterangan'] = $dataDetailpemeriksaaanLab->pemeriksaandetail->nilairujukan->nilairujukan_keterangan;
        $periksa[$jenis][$kelDetail][$i]['namapemeriksaandet'] = $dataDetailpemeriksaaanLab->pemeriksaandetail->nilairujukan->namapemeriksaandet;
        $i++;
    endforeach;
    ?>

    <?php
    foreach ($periksa as $jenis => $kelompok) {
        echo '<table class="table table-bordered table-condensed">
        <thead>  
        <tr>
            <th class="span2"><h4>' . strtoupper($jenis) . '</h4></th>
            <th>Detail Pemeriksaan</th>
            <th width="300px">Hasil Pemeriksaan</th>
            <th width="100px">Nilai Rujukan</th>
            <th width="50px">Satuan</th>
            <th width="50px">Metode</th>
            <th width="50px">Keterangan</th>
        </tr>
        </thead> 
        <tbody>';
        foreach ($kelompok as $kelDetail => $details) {
            $colspan = (count((array)$details) > 1) ? (count((array)$details) + 1) : 0;
            if ($colspan > 0) {
                if ($jenis == 'MIKROBIOLOGI') {
                    echo '<tr><td rowspan="' . $colspan . '"><i>' . $kelDetail . '</i></td></tr>';
                    foreach ($details as $j => $detail) {
                        echo '<tr>';
                        echo '<td>' . $detail['namapemeriksaandet'] . CHtml::hiddenField('BDDetailHasilPemeriksaanLabT[detailhasilpemeriksaanlab_id][]', $detail['detailhasilpemeriksaanlab_id'], array('class' => 'span1', 'readonly' => true)) . '</td>';
                        //                        echo '<td>'.CHtml::textArea('BDDetailHasilPemeriksaanLabT[hasilpemeriksaan][]',$detail['hasilpemeriksaan'], array('class'=>'span4 hasilPem','readonly'=>false)).'</td>';
                        echo '<td>';
                        $this->widget(
                            'ext.redactorjs.Redactor',
                            array(
                                'model' => 'BDDetailHasilPemeriksaanLabT',
                                'name' => 'BDDetailHasilPemeriksaanLabT[hasilpemeriksaan][]',
                                'id' => 'LKDetailHasilPemeriksaanLabT_hasilpemeriksaan_' . $detail['id_nilairujukan'],
                                'value' => $detail['hasilpemeriksaan'],
                                'toolbar' => 'mini',
                                'debugMode' => true,
                                'height' => '100px',
                                'htmlOptions' => array('autofocus' => true)
                            )
                        );
                        echo '<td>' . CHtml::textField('BDDetailHasilPemeriksaanLabT[nilairujukan][]', $detail['nilairujukan'], array('class' => 'span2', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td>';
                        echo '<td>' . CHtml::textField('BDDetailHasilPemeriksaanLabT[hasilpemeriksaan_satuan][]', $detail['hasilpemeriksaan_satuan'], array('class' => 'inputFormTabel lebar3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td>';
                        echo '<td>' . CHtml::textField('BDDetailHasilPemeriksaanLabT[hasilpemeriksaan_metode][]', $detail['hasilpemeriksaan_metode'], array('class' => 'inputFormTabel lebar3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td>';
                        echo '<td>' . CHtml::textField('BDNilaiRujukanM[nilairujukan_keterangan][]', $detail['nilairujukan_keterangan'], array('class' => 'inputFormTabel lebar3', 'readonly' => false, 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td>';
                        echo '</tr>';
                    }
                } else {
                    if ($jenis == 'HEMATOLOGI') {
                        if ($kelDetail == "Morfologi") {
                            echo '<tr><td rowspan="' . $colspan . '"><i>' . $kelDetail . '</i></td></tr>';
                            foreach ($details as $j => $detail) {
                                echo '<tr>';
                                echo '<td>' . $detail['namapemeriksaandet'] . CHtml::hiddenField('BDDetailHasilPemeriksaanLabT[detailhasilpemeriksaanlab_id][]', $detail['detailhasilpemeriksaanlab_id'], array('class' => 'span1', 'readonly' => true)) . '</td>';
                                //                                echo '<td>'.CHtml::textArea('BDDetailHasilPemeriksaanLabT[hasilpemeriksaan][]',$detail['hasilpemeriksaan'], array('class'=>'span4 hasilPem','readonly'=>false)).'</td>';
                                echo '<td>';
                                $this->widget(
                                    'ext.redactorjs.Redactor',
                                    array(
                                        'model' => 'BDDetailHasilPemeriksaanLabT',
                                        'name' => 'BDDetailHasilPemeriksaanLabT[hasilpemeriksaan][]',
                                        'id' => 'LKDetailHasilPemeriksaanLabT_hasilpemeriksaan_' . $detail['id_nilairujukan'],
                                        'value' => $detail['hasilpemeriksaan'],
                                        'toolbar' => 'mini',
                                        'debugMode' => true,
                                        'height' => '100px'
                                    )
                                );
                                echo '</td>';
                                echo '<td>' . CHtml::textField('BDDetailHasilPemeriksaanLabT[nilairujukan][]', $detail['nilairujukan'], array('class' => 'span2', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td>';
                                echo '<td>' . CHtml::textField('BDDetailHasilPemeriksaanLabT[hasilpemeriksaan_satuan][]', $detail['hasilpemeriksaan_satuan'], array('class' => 'inputFormTabel lebar3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td>';
                                echo '<td>' . CHtml::textField('BDDetailHasilPemeriksaanLabT[hasilpemeriksaan_metode][]', $detail['hasilpemeriksaan_metode'], array('class' => 'inputFormTabel lebar3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td>';
                                echo '<td>' . CHtml::textField('BDNilaiRujukanM[nilairujukan_keterangan][]', $detail['nilairujukan_keterangan'], array('class' => 'inputFormTabel lebar3', 'readonly' => false, 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td>';
                                echo '</tr>';
                            }
                        } else {
                            echo '<tr><td rowspan="' . $colspan . '"><i>' . $kelDetail . '</i></td></tr>';
                            foreach ($details as $j => $detail) {
                                echo '<tr>';
                                echo '<td>' . $detail['namapemeriksaandet'] . CHtml::hiddenField('BDDetailHasilPemeriksaanLabT[detailhasilpemeriksaanlab_id][]', $detail['detailhasilpemeriksaanlab_id'], array('class' => 'span1', 'readonly' => true)) . '</td>';
                                echo '<td>' . CHtml::textField('BDDetailHasilPemeriksaanLabT[hasilpemeriksaan][]', $detail['hasilpemeriksaan'], array('autofocus' => true, 'class' => 'span4 hasilPem', 'readonly' => false, 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td>';
                                echo '<td>' . CHtml::textField('BDDetailHasilPemeriksaanLabT[nilairujukan][]', $detail['nilairujukan'], array('class' => 'span2', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td>';
                                echo '<td>' . CHtml::textField('BDDetailHasilPemeriksaanLabT[hasilpemeriksaan_satuan][]', $detail['hasilpemeriksaan_satuan'], array('class' => 'inputFormTabel lebar3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td>';
                                echo '<td>' . CHtml::textField('BDDetailHasilPemeriksaanLabT[hasilpemeriksaan_metode][]', $detail['hasilpemeriksaan_metode'], array('class' => 'inputFormTabel lebar3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td>';
                                echo '<td>' . CHtml::textField('BDNilaiRujukanM[nilairujukan_keterangan][]', $detail['nilairujukan_keterangan'], array('class' => 'inputFormTabel lebar3', 'readonly' => false, 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td>';
                                echo '</tr>';
                            }
                        }
                    } else {
                        echo '<tr><td rowspan="' . $colspan . '"><i>' . $kelDetail . '</i></td></tr>';
                        foreach ($details as $j => $detail) {
                            echo '<tr>';
                            echo '<td>' . $detail['namapemeriksaandet'] . CHtml::hiddenField('BDDetailHasilPemeriksaanLabT[detailhasilpemeriksaanlab_id][]', $detail['detailhasilpemeriksaanlab_id'], array('class' => 'span1', 'readonly' => true)) . '</td>';
                            if (
                                $jenis == 'KARBOHIDRAT' &&
                                (
                                    ($detail['id_pemeriksaan'] != '341' || trim($detail['namapemeriksaandet']) != 'Fruktosamin') ||
                                    ($detail['id_pemeriksaan'] != '342' || trim($detail['namapemeriksaandet']) != 'HBA1C'))
                            ) {
                                echo '<td>' . CHtml::textField('BDDetailHasilPemeriksaanLabT[hasilpemeriksaan][]', (strlen(trim($detail['hasilpemeriksaan']) == 0) ? 'DARAH = , URINE RED = ' : $detail['hasilpemeriksaan']), array('autofocus' => true, 'class' => 'span4', 'readonly' => false, 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td>';
                            } else {
                                echo '<td>' . CHtml::textField('BDDetailHasilPemeriksaanLabT[hasilpemeriksaan][]', $detail['hasilpemeriksaan'], array('autofocus' => true, 'class' => 'span4 hasilPem', 'readonly' => false, 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td>';
                            }

                            echo '<td>' . CHtml::textField('BDDetailHasilPemeriksaanLabT[nilairujukan][]', $detail['nilairujukan'], array('class' => 'span2', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td>';
                            echo '<td>' . CHtml::textField('BDDetailHasilPemeriksaanLabT[hasilpemeriksaan_satuan][]', $detail['hasilpemeriksaan_satuan'], array('class' => 'inputFormTabel lebar3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td>';
                            echo '<td>' . CHtml::textField('BDDetailHasilPemeriksaanLabT[hasilpemeriksaan_metode][]', $detail['hasilpemeriksaan_metode'], array('class' => 'inputFormTabel lebar3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td>';
                            echo '<td>' . CHtml::textField('BDNilaiRujukanM[nilairujukan_keterangan][]', $detail['nilairujukan_keterangan'], array('class' => 'inputFormTabel lebar3', 'readonly' => false, 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td>';
                            echo '</tr>';
                        }
                    }
                }
            } else {
                echo '<tr><td><i>' . $kelDetail . '</i></td>';
                foreach ($details as $j => $detail) {
                    echo '<td>' . $detail['namapemeriksaandet'] . CHtml::hiddenField('BDDetailHasilPemeriksaanLabT[detailhasilpemeriksaanlab_id][]', $detail['detailhasilpemeriksaanlab_id'], array('class' => 'span1', 'readonly' => true)) . '</td>';

                    if ($detail['namapemeriksaandet'] == 'Bilirubin Total') {
                        echo '<td>' . CHtml::textField('BDDetailHasilPemeriksaanLabT[hasilpemeriksaan][]', $detail['hasilpemeriksaan'], array('autofocus' => true, 'class' => 'span4 bilTot', 'readonly' => false, 'onchange' => 'hitungBilInd()', 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td>';
                    } else if ($detail['namapemeriksaandet'] == 'Bilirubin Direct') {
                        echo '<td>' . CHtml::textField('BDDetailHasilPemeriksaanLabT[hasilpemeriksaan][]', $detail['hasilpemeriksaan'], array('autofocus' => true, 'class' => 'span4 bilDir', 'readonly' => false, 'onchange' => 'hitungBilInd()', 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td>';
                    } elseif ($detail['namapemeriksaandet'] == 'Bilirubin Indirect') {
                        echo '<td>' . CHtml::textField('BDDetailHasilPemeriksaanLabT[hasilpemeriksaan][]', $detail['hasilpemeriksaan'], array('autofocus' => true, 'class' => 'span4 bilInd', 'readonly' => false, 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td>';
                    } else if ($detail['namapemeriksaandet'] == 'Protein Total') {
                        echo '<td>' . CHtml::textField('BDDetailHasilPemeriksaanLabT[hasilpemeriksaan][]', $detail['hasilpemeriksaan'], array('autofocus' => true, 'class' => 'span4 protTot', 'readonly' => false, 'onchange' => 'hitungGlob()', 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td>';
                    } else if ($detail['namapemeriksaandet'] == 'Albumin') {
                        echo '<td>' . CHtml::textField('BDDetailHasilPemeriksaanLabT[hasilpemeriksaan][]', $detail['hasilpemeriksaan'], array('autofocus' => true, 'class' => 'span4 albumin', 'readonly' => false, 'onchange' => 'hitungGlob()', 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td>';
                    } elseif ($detail['namapemeriksaandet'] == 'Globulin') {
                        echo '<td>' . CHtml::textField('BDDetailHasilPemeriksaanLabT[hasilpemeriksaan][]', $detail['hasilpemeriksaan'], array('autofocus' => true, 'class' => 'span4 glob', 'readonly' => false, 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td>';
                    } elseif ($detail['namapemeriksaandet'] == 'Cholesterol Total') {
                        echo '<td>' . CHtml::textField('BDDetailHasilPemeriksaanLabT[hasilpemeriksaan][]', $detail['hasilpemeriksaan'], array('autofocus' => true, 'class' => 'span4 cholTot', 'readonly' => false, 'onchange' => 'hitungLdl()', 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td>';
                    } else if ($detail['namapemeriksaandet'] == 'HDL-Cholesterol') {
                        echo '<td>' . CHtml::textField('BDDetailHasilPemeriksaanLabT[hasilpemeriksaan][]', $detail['hasilpemeriksaan'], array('autofocus' => true, 'class' => 'span4 hdl', 'readonly' => false, 'onchange' => 'hitungLdl()', 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td>';
                    } else if ($detail['namapemeriksaandet'] == 'Triglyseride') {
                        echo '<td>' . CHtml::textField('BDDetailHasilPemeriksaanLabT[hasilpemeriksaan][]', $detail['hasilpemeriksaan'], array('autofocus' => true, 'class' => 'span4 trigl', 'readonly' => false, 'onchange' => 'hitungLdl()', 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td>';
                    } elseif ($detail['namapemeriksaandet'] == 'LDL-Cholesterol') {
                        echo '<td>' . CHtml::textField('BDDetailHasilPemeriksaanLabT[hasilpemeriksaan][]', $detail['hasilpemeriksaan'], array('autofocus' => true, 'class' => 'span4 ldl', 'readonly' => false, 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td>';
                    } else {
                        if (
                            $jenis == 'KARBOHIDRAT' &&
                            (
                                ($detail['id_pemeriksaan'] != '341' || trim($detail['namapemeriksaandet']) != 'Fruktosamin') &&
                                ($detail['id_pemeriksaan'] != '342' || trim($detail['namapemeriksaandet']) != 'HBA1C'))
                        ) {
                            echo '<td>' . CHtml::textField('BDDetailHasilPemeriksaanLabT[hasilpemeriksaan][]', (strlen(trim($detail['hasilpemeriksaan']) == 0) ? 'DARAH = , URINE RED = ' : $detail['hasilpemeriksaan']), array('autofocus' => true, 'class' => 'span4', 'readonly' => false, 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td>';
                        } else {
                            echo '<td>' . CHtml::textField('BDDetailHasilPemeriksaanLabT[hasilpemeriksaan][]', $detail['hasilpemeriksaan'], array('autofocus' => true, 'class' => 'span4 hasilPem', 'readonly' => false, 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td>';
                        }
                    }

                    echo '<td>' . CHtml::textField('BDDetailHasilPemeriksaanLabT[nilairujukan][]', $detail['nilairujukan'], array('class' => 'span2', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td>';
                    echo '<td>' . CHtml::textField('BDDetailHasilPemeriksaanLabT[hasilpemeriksaan_satuan][]', $detail['hasilpemeriksaan_satuan'], array('class' => 'inputFormTabel lebar3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td>';
                    echo '<td>' . CHtml::textField('BDDetailHasilPemeriksaanLabT[hasilpemeriksaan_metode][]', $detail['hasilpemeriksaan_metode'], array('class' => 'inputFormTabel lebar3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td>';
                    echo '<td>' . CHtml::textField('BDNilaiRujukanM[nilairujukan_keterangan][]', $detail['nilairujukan_keterangan'], array('class' => 'inputFormTabel lebar3', 'readonly' => false, 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td>';
                }
                echo '</tr>';
            }
        }
        echo '</tbody></table>';
    }
    ?>
<?php } else { ?>
    <table width="50%" id="tblFormHasilPemeriksaanRad" class="table table-bordered table-condensed">
        <thead>
            <tr>
                <th>Jenis/Detail Pemeriksaan</th>
                <th>Makroskopis</th>
                <th>Mikroskopis</th>
                <th>Saran</th>
                <th>Catatan</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <?php foreach ($modHasilPemeriksaanPA as $i => $hasil) : ?>
            <tr>
                <td>
                    <?php echo BDPemeriksaanlabM::model()->findByPK($hasil->pemeriksaanlab_id)->pemeriksaanlab_nama; ?> : <br>
                    <b>
                        <?php $idJenisPemeriksaan = BDPemeriksaanlabM::model()->findByPK($hasil->pemeriksaanlab_id)->jenispemeriksaanlab_id;
                        echo BDJenisPemeriksaanLabM::model()->findByPk($idJenisPemeriksaan)->jenispemeriksaanlab_nama; ?></b> <br>
                    <?php echo CHtml::activeHiddenField($hasil, "[$i]hasilpemeriksaanpa_id", array('readonly' => true)); ?>
                    <?php echo '<b>No. Sediaan : ' . $hasil->nosediaanpa . '</b><br>' . $hasil->tglperiksapa; ?>
                </td>
                <td>
                    <?php $this->widget('ext.redactorjs.Redactor', array('model' => $hasil, 'attribute' => '[' . $i . ']makroskopis', 'name' => 'LKHasilPemeriksaanPAT_' . $i . '_makroskopis', 'toolbar' => 'mini', 'height' => '200px')) ?>
                </td>
                <td>
                    <?php $this->widget('ext.redactorjs.Redactor', array('model' => $hasil, 'attribute' => '[' . $i . ']mikroskopis', 'name' => 'LKHasilPemeriksaanPAT_' . $i . '_mikroskopis', 'toolbar' => 'mini', 'height' => '200px')) ?>
                </td>
                <td>
                    <?php $this->widget('ext.redactorjs.Redactor', array('model' => $hasil, 'attribute' => '[' . $i . ']saranpa', 'name' => 'LKHasilPemeriksaanPAT_' . $i . '_saranpa', 'toolbar' => 'mini', 'height' => '200px')) ?>
                <td>
                    <?php $this->widget('ext.redactorjs.Redactor', array('model' => $hasil, 'attribute' => '[' . $i . ']catatanpa', 'name' => 'LKHasilPemeriksaanPAT_' . $i . '_catatanpa', 'toolbar' => 'mini', 'height' => '200px')) ?>
                <td><?php echo CHtml::button('Referensi', array('onclick' => 'return false;', 'class' => 'btn btn-info', 'disabled' => false)); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php } ?>

<table>
    <tr>
        <?php if (isset($modRujukanT->rujukandari_id)) { ?>
            <td>
                <div class="control-group">
                    <?php echo CHtml::label('Dokter Perujuk', 'Dokter Perujuk', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        //                           echo CHtml::dropDownList('BDPasienKirimKeUnitLainT[pegawai_id]',$modPasienKirimKeUnitLain->pegawai_id,CHtml::listData(DokterV::model()->findAll(),'pegawai_id','nama_pegawai'),array('empty'=>'-- Pilih --','style'=>'width:160px;', 'readonly'=>false));
                        echo CHtml::activeHiddenField($modRujukanT, 'asalrujukan_id', array('class' => 'span1'));
                        echo CHtml::activeHiddenField($modRujukanT, 'rujukandari_id', array('class' => 'span1'));
                        //                           echo CHtml::dropDownList('BDRujukanT[rujukandari_id]',$modPasienMasukPenunjang->rujukandari_id,CHtml::listData(RujukandariM::model()->findAllByAttributes(array('asalrujukan_id'=>$modPasienMasukPenunjang->asalrujukan_id)),'rujukandari_id','namaperujuk'),array('empty'=>'-- Pilih --','class'=>'span3'));
                        echo $form->dropDownList($modRujukanT, 'rujukandari_id', CHtml::listData(RujukandariM::model()->findAll(), 'rujukandari_id', 'namaperujuk'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onchange' => 'konfirmUbahDokterPerujuk(this);'));
                        //                           echo CHtml::textField('BDRujukanT[rujukandari_id]',$modPasienMasukPenunjang->namaperujuk,array('empty'=>'-- Pilih --','class'=>'span3', 'readonly'=>true));

                        ?>
                    </div>
                </div>
            </td>
        <?php } ?>
        <td>
            <div class="control-group">
                <?php echo CHtml::label('Dokter Pemeriksa', 'Dokter Pemeriksa', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    echo CHtml::activeHiddenField($modPasienMasukPenunjang, 'pegawai_id', array('class' => 'span1'));
                    echo CHtml::dropDownList('BDPasienmasukpenunjangT[pegawai_id]', $modPasienMasukPenunjang->pegawai_id, CHtml::listData(DokterV::model()->findAllByAttributes(array('ruangan_id' =>  Yii::app()->user->getState('ruangan_id'))), 'pegawai_id', 'NamaLengkap'), array('empty' => '-- Pilih --', 'class' => 'span3', 'readonly' => false, 'onchange' => 'konfirmUbahDokterPemeriksa(this);'));
                    //                           echo $form->dropDownList($modPasienMasukPenunjang,'pegawai_id',CHtml::listData(DokterV::model()->findAllByAttributes(array('ruangan_id'=>  Yii::app()->user->getState('ruangan_id'))),'pegawai_id','NamaLengkap'),array('empty'=>'-- Pilih --','class'=>'span3', 'readonly'=>false));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::hiddenField('BDHasilPemeriksaanLabT[hasilpemeriksaanlab_id]', $modHasilpemeriksaanLab->hasilpemeriksaanlab_id, array('class' => 'span1', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                <?php echo CHtml::label('Tgl. Pengambilan Hasil', 'Tanggal Pengambilan Hasil', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'name' => 'BDHasilPemeriksaanLabT[tglpengambilanhasil]',
                        'mode' => 'datetime',
                        'value' => $modHasilpemeriksaanLab->tglpengambilanhasil,
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                            'yearRange' => "-60:+0",

                        ),
                        'htmlOptions' => array(
                            'readonly' => true, 'class' => 'dtPicker3',
                            'onkeypress' => "return $(this).focusNextInputField(event)",

                        ),
                    )); ?>
                </div>
            </div>
        </td>
        <td>
            <div class="control-group">
                <?php echo CHtml::label('Catatan Bank Darah', 'Catatan Bank Darah', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo CHtml::textArea('BDHasilPemeriksaanLabT[catatanlabklinik]', $modHasilpemeriksaanLab->catatanlabklinik, array()); ?>
                </div>
            </div>
        </td>
    </tr>
</table>

<div class='form-actions'>
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array(
            'class' => 'btn btn-danger', 'type' => 'submit',
            'onKeypress' => 'return formSubmit(this,event)',
            'id' => 'btn_simpan',
        )
    ); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl('index', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger')); ?>
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')),
        array('class' => 'btn btn-info', 'onclick' => "printPemeriksaan(" . $modHasilpemeriksaanLab->pendaftaran_id . ",
                    " . $modHasilpemeriksaanLab->pasienmasukpenunjang_id . "," . $modHasilpemeriksaanLab->pasien_id . ");return false")
    ); ?>
</div>
<?php $this->endWidget(); ?>

<?php
$urlPrintPemeriksaan = Yii::app()->createUrl('bankDarah/daftarPasien/details/', array());
$jscript = <<< JS
function printPemeriksaan(pendaftaran_id,pasienmasukpenunjang_id,pasien_id)
{
            window.open('${urlPrintPemeriksaan}&pendaftaran_id='+pendaftaran_id+'&pasienmasukpenunjang_id='+pasienmasukpenunjang_id+'&pasien_id='+pasien_id,'printwin','left=100,top=100,width=800,height=590, scrollbars=1');
}

JS;
Yii::app()->clientScript->registerScript('jsPendaftaran', $jscript, CClientScript::POS_BEGIN);
?>
<script>
    function konfirmUbahDokterPerujuk(obj) {
        var sblm = $('#LKRujukanT_rujukandari_id').val();
        myConfirm('Apakah Anda yakin akan merubah Dokter Perujuk?', 'Perhatian!', function(r) {
            if (!r) {
                obj.value = sblm;
            };
        });
    }

    function konfirmUbahDokterPemeriksa(obj) {
        var sblm = $('#LKPasienMasukPenunjangV_pegawai_id').val();
        myConfirm('Apakah Anda yakin akan merubah Dokter Pemeriksa?', 'Perhatian!', function(r) {
            if (!r) {
                obj.value = sblm;
            };
        });
    }

    function hitungBilInd() {
        var total = 0;
        var bilTotal = 0;
        var bilDirect = 0;
        if ($('.bilTot').val() != '') bilTotal = $('.bilTot').val();
        if ($('.bilDir').val() != '') bilDirect = $('.bilDir').val();

        total = parseFloat(bilTotal) - parseFloat(bilDirect);
        $('.bilInd').val(Math.round(total));
    }

    function hitungGlob() {
        var total = 0;
        var proteinTotal = 0;
        var albumin = 0;

        if ($('.protTot').val() != '') proteinTotal = $('.protTot').val();
        if ($('.albumin').val() != '') albumin = $('.albumin').val();

        total = parseFloat(proteinTotal) - parseFloat(albumin);
        $('.glob').val(total);
    }

    function hitungLdl() {
        var total = 0;
        var cholesterolTotal = 0;
        var hdl = 0;
        var triglyseride = 0;

        if ($('.cholTot').val() != '') cholesterolTotal = $('.cholTot').val();
        if ($('.hdl').val() != '') hdl = $('.hdl').val();
        if ($('.trigl').val() != '') triglyseride = $('.trigl').val();

        total = parseFloat(cholesterolTotal) - (parseFloat(triglyseride) / 5) - parseFloat(hdl);
        $('.ldl').val(total);
    }
</script>