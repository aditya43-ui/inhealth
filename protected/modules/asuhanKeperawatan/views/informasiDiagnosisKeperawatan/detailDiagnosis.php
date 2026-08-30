<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Detail <b>Diagnosa Keperawatan</b>
        </div>
    </div>
    <div class="panel-body">
        <style>
            .tandagejala label {
                display: flex;
            }

            .intervensi label {
                display: flex;
            }

            .form-horizontal .control-label {
                width: 155px;
            }

            .table thead tr th {
                vertical-align: middle;
            }

            .panel-default>.panel-heading {
                background-color: #e1e1e1;
            }

            .panel-group.joined>.panel>.panel-heading h5 a::before {
                content: '\f103';
                position: relative;
                font: normal normal normal 14px/1 FontAwesome;
                display: inline-block;
                float: right;
            }
        </style>
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pembayaran-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'focus' => '#ASPendaftaranT_no_pendaftaran',
            'htmlOptions' => array(
                'onKeyPress' => 'return disableKeyPress(event)',
                'onsubmit' => 'return requiredCheck(this);'
            ),
        ));
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Pengkajian</b>
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('detail/_dataPengkajian', array('modPengkajian' => $modPengkajian, 'form' => $form)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-user"></i> Identitas Pasien
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('detail/_ringkasDataPasien', array('model' => $model, 'modPasien' => $modPasien)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Penegakan Diagnosa Keperawatan</b>
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('detail/_dataDiagnosis', array('model' => $model, 'form' => $form)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    Identifikasi Diagnosa Keperawatan
                </div>
            </div>
            <div class="panel-body">
                <div class="row-fluid block-tabel overflow-x">
                    <?php
                    $diagnosisdet = ASDiagnosisaskepdetT::model()->findAllBySql(
                        'SELECT diagnosisaskepdet_t.diagnosisaskepdet_id, diagnosisaskepdet_t.iskolaborasi, diagnosakep.diagnosakep_nama, diagnosisaskepdet_t.hasildiagnosa_id
                                FROM diagnosisaskepdet_t
                                JOIN diagnosakep_m AS diagnosakep ON diagnosakep.diagnosakep_id = diagnosisaskepdet_t.hasildiagnosa_id
                                WHERE diagnosisaskepdet_t.diagnosisaskep_id=' . $model->diagnosisaskep_id
                    );
                    ?>
                    <table id="table-diagnosis" class="table table-striped table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th style="text-align: center">Diagnosis</th>
                                <th style="text-align: center">Penyebab</th>
                                <th style="text-align: center">Kondisi Klinis Terkait</th>
                                <th style="text-align: center">Tanda dan Gejala / Faktor Risiko</th>
                                <th style="text-align: center">Kolaborasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (count($diagnosisdet)) {
                                $nomor = 1;
                                foreach ($diagnosisdet as $i => $modDetail) {
                            ?>
                                    <tr>
                                        <td>
                                            <?php
                                            echo $modDetail->diagnosakep_nama;
                                            if ($nomor % 2 == 0) {
                                                $warna = '#fff';
                                            } else {
                                                $warna = '#f8f8f8';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $diagnosakep = !empty($modDetail->hasildiagnosa_id) ? $modDetail->hasildiagnosa_id : null;
                                            if (!empty($diagnosakep)) {
                                                $diagnosa = ASDiagnosakepM::model()->findByPk($diagnosakep);
                                                echo "<div class='diagdetail'>";
                                                $bk_head = BataskarakteristikM::model()->findAllByAttributes(array('diagnosakep_id' => $diagnosakep));
                                                if (count($bk_head)) {
                                                    foreach ($bk_head as $i => $bk) {
                                                        echo "<ul class='spasi1'>";
                                                        echo '<li >' . $bk->bataskarakteristik_nama . '</li>';
                                                        echo "<ul class='spasi1'>";
                                                        $bk_tail = BataskarakteristikdetM::model()->findAllByAttributes(array('bataskarakteristikdet_aktif' => true, 'bataskarakteristik_id' => $bk->bataskarakteristik_id));
                                                        if (count($bk_tail)) {
                                                            foreach ($bk_tail as $i => $bkd) {
                                                                echo '<li >' . $bkd->bataskarakteristikdet_indikator . '</li>';
                                                            }
                                                        } else {
                                                            echo '<li> Data tidak ditemukan. </li>';
                                                        }
                                                        echo "</ul>";
                                                        echo "</ul>";
                                                    }
                                                } else {
                                                    echo "<ul class='spasi1'>";
                                                    echo '<li> Data tidak ditemukan. </li>';
                                                    echo "</ul>";
                                                }
                                            } else {
                                                echo "<ul class='spasi1'>";
                                                echo '<li> Data tidak ditemukan. </li>';
                                                echo "</ul>";
                                            }
                                            echo '</div>';
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $diagnosakep = !empty($modDetail->hasildiagnosa_id) ? $modDetail->hasildiagnosa_id : null;
                                            if (!empty($diagnosakep)) {
                                                $diagnosa = ASDiagnosakepM::model()->findByPk($diagnosakep);
                                                echo "<div class='diagdetail'>";
                                                $bk_head = FaktorhubM::model()->findAllByAttributes(array('diagnosakep_id' => $diagnosakep));
                                                if (count($bk_head)) {
                                                    foreach ($bk_head as $i => $bk) {
                                                        echo "<ul class='spasi1'>";
                                                        echo '<li >' . $bk->faktorhub_nama . '</li>';
                                                        echo "<ul class='spasi1'>";
                                                        $bk_tail = FaktorhubdetM::model()->findAllByAttributes(array('faktorhubdet_aktif' => true, 'faktorhub_id' => $bk->faktorhub_id));
                                                        if (count($bk_tail)) {
                                                            foreach ($bk_tail as $i => $bkd) {
                                                                echo '<li >' . $bkd->faktorhubdet_indikator . '</li>';
                                                            }
                                                        } else {
                                                            echo '<li> Data tidak ditemukan. </li>';
                                                        }
                                                        echo "</ul>";
                                                        echo "</ul>";
                                                    }
                                                } else {
                                                    echo "<ul class='spasi1'>";
                                                    echo '<li> Data tidak ditemukan. </li>';
                                                    echo "</ul>";
                                                }
                                            } else {
                                                echo "<ul class='spasi1'>";
                                                echo '<li> Data tidak ditemukan. </li>';
                                                echo "</ul>";
                                            }
                                            echo '</div>';
                                            ?>
                                        </td>
                                        <td>
                                            <table class="noborder">
                                                <?php
                                                $cekPilih = PilihdiagnosisaskepT::model()->findAllByAttributes(array('diagnosisaskepdet_id' => $modDetail->diagnosisaskepdet_id));
                                                $tandagejala_id = array();
                                                foreach ($cekPilih as $value) {
                                                    if (!empty($value->tandagejala_id)) {
                                                        $tandagejala_id[] = $value->tandagejala_id;
                                                    }
                                                }

                                                if (!empty($tandagejala_id)) {
                                                    $criteria = new CDbCriteria;
                                                    $criteria->select = 'tandagejala.tandagejala_id, t.tandagejala_daftar_nama, det.kelompoktandagejaladaftar_id, jenistandagejala.jenistandagejala_nama, jenistandagejala.subjenistandagejala_nama';
                                                    $criteria->join = 'JOIN kelompoktandagejaladaftar_m det ON det.tandagejala_daftar_id = t.tandagejala_daftar_id '
                                                        . 'JOIN jenistandagejala_m jenistandagejala ON jenistandagejala.jenistandagejala_id = det.jenistandagejala_id '
                                                        . 'JOIN tandagejala_m tandagejala ON tandagejala.kelompoktandagejaladaftar_id = det.kelompoktandagejaladaftar_id';
                                                    if (is_array($tandagejala_id)) {
                                                        $criteria->addInCondition("tandagejala.tandagejala_id", $tandagejala_id);
                                                    } else {
                                                        $criteria->addCondition("tandagejala.tandagejala_id = " . $tandagejala_id);
                                                    }
                                                    $criteria->addCondition('t.tandagejala_daftar_aktif is true');
                                                    $criteria->order = 't.tandagejala_daftar_nama';

                                                    $modTandaGejala = ASTandagejalaDaftarM::model()->findAll($criteria);

                                                    $kanUtam = array();

                                                    foreach ($modTandaGejala as $d) {
                                                        $kanUtam[$d->tandagejala_id]['tandagejala_id'] = $d->tandagejala_id;
                                                        $kanUtam[$d->tandagejala_id]['jenistandagejala_nama'] = $d->jenistandagejala_nama;
                                                        $kanUtam[$d->tandagejala_id]['subjenistandagejala_nama'] = $d->subjenistandagejala_nama;
                                                        $kanUtam[$d->tandagejala_id]['tandagejala_daftar_nama'] = $d->tandagejala_daftar_nama;
                                                    }

                                                    $no = 0;
                                                    echo '<tr> 
                                                                <td colspan="2"><b>Diagnosa Keperawatan Aktual</b><br></td>
                                                            </tr>
                                                            <tr> 
                                                                <td colspan="2"><b>Tanda dan Gejala Mayor</b></td>
                                                            </tr>
                                                            <tr> 
                                                                <td colspan="2"><b>Objektif</b></td>
                                                            </tr> ';
                                                    $no1 = 0;
                                                    $tandagejala1 = array();
                                                    foreach ($kanUtam as $det) {
                                                        $modDet = new ASPilihdiagnosisaskepT();
                                                        $modDet->tandagejala_id = !empty($det['tandagejala_id']) ? $det['tandagejala_id'] : null;
                                                        if (!empty($modDet->tandagejala_id)) {
                                                            if ($det['jenistandagejala_nama'] == 'Mayor') {
                                                                if ($det['subjenistandagejala_nama'] == 'Objektif') {
                                                                    $tandagejala1[] = $det['tandagejala_id'];
                                                                    echo $this->renderPartial($this->path_view . 'detail/_detailTandagejala', array('no' => $no + 1, 'modTandaGejala' => $det, 'modDetail' => $modDet, 'warna' => $warna), true);
                                                                    $no1++;
                                                                }
                                                            }
                                                            $no++;
                                                        }
                                                    }
                                                    if ($no1 == 0) {
                                                        echo '<tr><td colspan="2">- &nbsp;(Tidak Tersedia)</td></tr>';
                                                    }
                                                    echo '<tr> 
                                                                <td colspan="2"><br><b>Subjektif</b></td>
                                                            </tr>';
                                                    $no2 = 0;
                                                    $tandagejala2 = array();
                                                    foreach ($kanUtam as $det) {
                                                        $modDet = new ASPilihdiagnosisaskepT();
                                                        $modDet->tandagejala_id = !empty($det['tandagejala_id']) ? $det['tandagejala_id'] : null;
                                                        if (!empty($modDet->tandagejala_id)) {
                                                            if ($det['jenistandagejala_nama'] == 'Mayor') {
                                                                if ($det['subjenistandagejala_nama'] == 'Subjektif') {
                                                                    $tandagejala2[] = $det['tandagejala_id'];
                                                                    echo $this->renderPartial($this->path_view . 'detail/_detailTandagejala', array('no' => $no + 1, 'modTandaGejala' => $det, 'modDetail' => $modDet, 'warna' => $warna), true);
                                                                    $no2++;
                                                                }
                                                            }
                                                            $no++;
                                                        }
                                                    }
                                                    if ($no2 == 0) {
                                                        echo '<tr><td colspan="2">- &nbsp;(Tidak Tersedia)</td></tr>';
                                                    }
                                                    echo '<tr> 
                                                                <td colspan="2"><br><b>Tanda dan Gejala Minor</b></td>
                                                            </tr>
                                                            <tr> 
                                                                <td colspan="2"><b>Objektif</b></td>
                                                            </tr> ';
                                                    $no3 = 0;
                                                    $tandagejala3 = array();
                                                    foreach ($kanUtam as $det) {
                                                        $modDet = new ASPilihdiagnosisaskepT();
                                                        $modDet->tandagejala_id = !empty($det['tandagejala_id']) ? $det['tandagejala_id'] : null;
                                                        if (!empty($modDet->tandagejala_id)) {
                                                            if ($det['jenistandagejala_nama'] == 'Minor') {
                                                                if ($det['subjenistandagejala_nama'] == 'Objektif') {
                                                                    $tandagejala3[] = $det['tandagejala_id'];
                                                                    echo $this->renderPartial($this->path_view . 'detail/_detailTandagejala', array('no' => $no + 1, 'modTandaGejala' => $det, 'modDetail' => $modDet, 'warna' => $warna), true);
                                                                    $no3++;
                                                                }
                                                            }
                                                            $no++;
                                                        }
                                                    }
                                                    if ($no3 == 0) {
                                                        echo '<tr><td colspan="2">- &nbsp;(Tidak Tersedia)</td></tr>';
                                                    }
                                                    echo '<tr> 
                                                                <td colspan="2"><br><b>Subjektif</b></td>
                                                            </tr>';
                                                    $no4 = 0;
                                                    $tandagejala4 = array();
                                                    foreach ($kanUtam as $det) {
                                                        $modDet = new ASPilihdiagnosisaskepT();
                                                        $modDet->tandagejala_id = !empty($det['tandagejala_id']) ? $det['tandagejala_id'] : null;
                                                        if (!empty($modDet->tandagejala_id)) {
                                                            if ($det['jenistandagejala_nama'] == 'Minor') {
                                                                if ($det['subjenistandagejala_nama'] == 'Subjektif') {
                                                                    $tandagejala4[] = $det['tandagejala_id'];
                                                                    echo $this->renderPartial($this->path_view . 'detail/_detailTandagejala', array('no' => $no + 1, 'modTandaGejala' => $det, 'modDetail' => $modDet, 'warna' => $warna), true);
                                                                    $no4++;
                                                                }
                                                            }
                                                            $no++;
                                                        }
                                                    }
                                                    if ($no4 == 0) {
                                                        echo '<tr><td colspan="2">- &nbsp;(Tidak Tersedia)</td></tr>';
                                                    }
                                                }
                                                ?>

                                                <?php
                                                $faktorrisiko_id = array();
                                                foreach ($cekPilih as $value) {
                                                    if (!empty($value->faktorrisiko_id)) {
                                                        $faktorrisiko_id[] = $value->faktorrisiko_id;
                                                    }
                                                }

                                                if (!empty($faktorrisiko_id)) {
                                                    $criteria = new CDbCriteria;
                                                    $criteria->select = 'jenisfaktorrisiko.jenisfaktorrisiko_nama, det.faktorrisiko_daftar_id, t.faktorrisiko_daftar_nama, det.kelompokfaktorrisikodaftar_id, det.jenisfaktorrisiko_id, row_number() OVER (PARTITION BY jenisfaktorrisiko.jenisfaktorrisiko_urutan ORDER BY jenisfaktorrisiko.jenisfaktorrisiko_urutan) AS no';
                                                    $criteria->join = 'JOIN kelompokfaktorrisikodaftar_m det ON det.faktorrisiko_daftar_id = t.faktorrisiko_daftar_id '
                                                        . 'JOIN jenisfaktorrisiko_m jenisfaktorrisiko ON jenisfaktorrisiko.jenisfaktorrisiko_id = det.jenisfaktorrisiko_id '
                                                        . 'JOIN faktorrisiko_m faktorrisiko ON faktorrisiko.kelompokfaktorrisikodaftar_id = det.kelompokfaktorrisikodaftar_id';
                                                    $criteria->addCondition('t.faktorrisiko_daftar_aktif is true');
                                                    $criteria->order = 'jenisfaktorrisiko.jenisfaktorrisiko_urutan';
                                                    if (is_array($faktorrisiko_id)) {
                                                        $criteria->addInCondition("faktorrisiko.faktorrisiko_id", $faktorrisiko_id);
                                                    } else {
                                                        $criteria->addCondition("faktorrisiko.faktorrisiko_id = " . $faktorrisiko_id);
                                                    }
                                                    $modFaktorRisiko = ASFaktorrisikoDaftarM::model()->findAll($criteria);


                                                    $jenisResiko = JenisfaktorrisikoM::model()->findAllByAttributes(array('jenisfaktorrisiko_aktif' => true), array('order' => 'jenisfaktorrisiko_urutan ASC'));

                                                    $kanUtam = array();

                                                    foreach ($modFaktorRisiko as $d) {
                                                        $kanUtam[$d->kelompokfaktorrisikodaftar_id]['kelompokfaktorrisikodaftar_id'] = $d->kelompokfaktorrisikodaftar_id;
                                                        $kanUtam[$d->kelompokfaktorrisikodaftar_id]['faktorrisiko_daftar_nama'] = $d->faktorrisiko_daftar_nama;
                                                        $kanUtam[$d->kelompokfaktorrisikodaftar_id]['jenisfaktorrisiko_nama'] = $d->jenisfaktorrisiko_nama;
                                                        $kanUtam[$d->kelompokfaktorrisikodaftar_id]['jenisfaktorrisiko_id'] = $d->jenisfaktorrisiko_id;
                                                        $kanUtam[$d->kelompokfaktorrisikodaftar_id]['no'] = $d->no;
                                                    }

                                                    $no = 0;
                                                    echo '<tr> 
                                                            <td colspan="2"><b>Diagnosa Keperawatan Risiko</b><br></td>
                                                          </tr>';

                                                    foreach ($kanUtam as $det) {
                                                        foreach ($jenisResiko as $key => $value) {
                                                            if (!empty($det['jenisfaktorrisiko_id'])) {
                                                                if ($value->jenisfaktorrisiko_id == $det['jenisfaktorrisiko_id']) {
                                                                    $no = !empty($det['no']) ? $det['no'] : 0;
                                                                    if ($det['no'] == 1) {
                                                                        echo '<tr> 
                                                                                <td colspan="2"><b>' . $det['jenisfaktorrisiko_nama'] . '</b></td>
                                                                              </tr>';
                                                                    }
                                                                    $modDetail = new ASPilihdiagnosisaskepT();
                                                                    $modDetail->kelompokfaktorrisikodaftar_id = $det['kelompokfaktorrisikodaftar_id'];
                                                                    $kelompokfaktorrisikodaftar[] = $det['kelompokfaktorrisikodaftar_id'];
                                                                    echo $this->renderPartial($this->path_view . 'detail/_detailFaktorRisiko', array('no' => $no + 1, 'modFaktorRisiko' => $det, 'modDetail' => $modDetail, 'warna' => $warna), true);

                                                                    $no++;
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                                ?>
                                            </table>
                                        </td>
                                        <td>
                                            <?php
                                            echo ($modDetail->iskolaborasi == 1) ? "Ya" : "Tidak";
                                            $nomor++;
                                            ?>
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo "<tr>";
                                echo "<td colspan=6>Data tidak ditemukan.</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>

<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printDetail');
$url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);

$js = <<< JSCRIPT

function print(caraPrint)
{
    window.open("${urlPrint}/&diagnosisaskep_id="+$model->diagnosisaskep_id+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>
<?php
$this->renderPartial($this->path_view . 'detail/_jsFunctions', array(
    'model' => $model,
    'modDetail' => $modDetail,
    'modPasien' => $modPasien,
    'modPengkajian' => $modPengkajian,
    'form' => $form
));
?>