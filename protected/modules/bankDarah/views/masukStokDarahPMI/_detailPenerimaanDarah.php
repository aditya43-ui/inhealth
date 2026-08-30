<?php
$display = "block";
if (isset($_GET['sukses'])) {
    $display = "none";
}
?>
<div class="panel panel-success" style="display: <?= $display ?>">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Penerimaan Darah <?= $modelPenerimaan->no_penerimaan ?></b> yang Sudah Masuk Stok
        </div>
    </div>
    <div class="panel-body table-responsive">
        <table class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th>No.</th>
                    <th style="text-align: center">No. Kantong Darah</th>
                    <th style="text-align: center">Jenis Komponen Darah</th>
                    <th style="text-align: center">Gol. Darah</th>
                    <th style="text-align: center">Rhesus</th>
                    <th style="text-align: center">Jenis Kantong Darah</th>
                    <th style="text-align: center">Tgl. Aftap</th>
                    <th style="text-align: center">Tgl. Kedaluwarsa</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (count((array)$modelDetail)) {
                    $k = 0;
                    foreach ($modelDetail as $key => $value) {

                        $jeniskomponenedarah_nama = "";
                        if (!empty($value->jeniskomponendarah_id)) {
                            $mod = JeniskomponendarahM::model()->findByPk($value->jeniskomponendarah_id);
                            $jeniskomponenedarah_nama = $mod->jeniskomponenedarah_nama;
                        }

                        $criteria = new CDbCriteria;
                        $criteria->addCondition('penerimaandarahpmidet_id = ' . $value->penerimaandarahpmidet_id);
                        $criteria->addCondition('kantongdarah_id IN (SELECT kantongdarah_id FROM stokkantongdarah_t)');
                        $modKantongDarah = KantongdarahT::model()->findAll($criteria);
                        if (count((array)$modKantongDarah)) {
                            foreach ($modKantongDarah as $key => $Kantong) {
                                if (isset($_GET['sukses'])) {
                                    $modKantong->pilih = 1;
                                }
                                echo '
                                        <tr>
                                            <td>' . ($k + 1) . '</td>
                                            <td style="text-align: center">' . $Kantong->no_kantongdarah . '</td>
                                            <td style="text-align: center">' . $jeniskomponenedarah_nama . '</td>
                                            <td style="text-align: center">' . $value->golongandarah . '</td>
                                            <td style="text-align: center">' . $value->rhesus . '</td>
                                            <td style="text-align: center">' . $Kantong->jeniskantongdarah->nama_jenis . '</td>
                                            <td style="text-align: center">' . MyFormatter::formatDateTimeForUser($Kantong->tgl_aftap) . '</td>
                                            <td style="text-align: center">' . MyFormatter::formatDateTimeForUser($Kantong->tgl_kadaluarsa) . '</td>
                                        </tr>
                                    ';
                                $k++;
                            }
                        }
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Penerimaan Darah dari PMI</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <table class="table table-bordered table-condensed" id="detail">
            <thead>
                <tr>
                    <th>No.</th>
                    <th style="text-align: center">No. Kantong Darah</th>
                    <th style="text-align: center">Jenis Komponen Darah</th>
                    <th style="text-align: center">Gol. Darah</th>
                    <th style="text-align: center">Rhesus</th>
                    <th style="text-align: center">Jenis Kantong Darah</th>
                    <th style="text-align: center">Tgl. Aftap</th>
                    <th style="text-align: center">Tgl. Kedaluwarsa</th>
                    <th style="text-align: center">Pilih <?= CHtml::checkBox('check_all', '0', array('onclick' => 'cekSemua(this);', 'rel' => 'tooltip', 'title' => 'Pilih/batal semua')) ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (count((array)$modelDetail)) {
                    $k = 0;
                    foreach ($modelDetail as $key => $value) {

                        $jeniskomponenedarah_nama = "";
                        if (!empty($value->jeniskomponendarah_id)) {
                            $mod = JeniskomponendarahM::model()->findByPk($value->jeniskomponendarah_id);
                            $jeniskomponenedarah_nama = $mod->jeniskomponenedarah_nama;
                        }

                        $criteria = new CDbCriteria;
                        $criteria->addCondition('penerimaandarahpmidet_id = ' . $value->penerimaandarahpmidet_id);
                        if (isset($_GET['sukses'])) {
                            $criteria->addCondition('kantongdarah_id IN (SELECT kantongdarah_id FROM stokkantongdarah_t)');
                        } else {
                            $criteria->addCondition('kantongdarah_id NOT IN (SELECT kantongdarah_id FROM stokkantongdarah_t)');
                        }
                        $modKantongDarah = KantongdarahT::model()->findAll($criteria);
                        if (count((array)$modKantongDarah)) {
                            foreach ($modKantongDarah as $key => $Kantong) {
                                if (isset($_GET['sukses'])) {
                                    $modKantong->pilih = 1;
                                }
                                echo '
                                        <tr>
                                            <td>' . ($k + 1) . '</td>
                                            <td style="text-align: center">' . $Kantong->no_kantongdarah . '</td>
                                            <td style="text-align: center">' . $jeniskomponenedarah_nama . '</td>
                                            <td style="text-align: center">' . $value->golongandarah . '</td>
                                            <td style="text-align: center">' . $value->rhesus . '</td>
                                            <td style="text-align: center">' . $Kantong->jeniskantongdarah->nama_jenis . '</td>
                                            <td style="text-align: center">' . MyFormatter::formatDateTimeForUser($Kantong->tgl_aftap) . '</td>
                                            <td style="text-align: center">' . MyFormatter::formatDateTimeForUser($Kantong->tgl_kadaluarsa) . '</td>
                                            <td style="text-align: center">' .
                                    CHtml::activeHiddenField($modKantong, '[' . $k . ']kantongdarah_id', array('readonly' => true, 'value' => $Kantong->kantongdarah_id)) .
                                    CHtml::activeHiddenField($modKantong, '[' . $k . ']penerimaandarahpmidet_id', array('readonly' => true, 'value' => $Kantong->penerimaandarahpmidet_id)) .
                                    CHtml::activeCheckBox($modKantong, '[' . $k . ']pilih', array('class' => 'check'))
                                    . '</td>
                                        </tr>
                                    ';
                                $k++;
                            }
                        }
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>