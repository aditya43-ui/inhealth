<?php $linkHalaman = CustomFunction::getUrlByMenuID(3572); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Diagnosis Keperawatan</b> <?= isset($_GET['status']) ? CHtml::link("<b>Lanjut ke Rencana Keperawatan</b>", $this->createUrl('rencanaKeperawatan/index', ['diagnosisaskep_id' => $model->diagnosisaskep_id]), ['class' => 'btn btn-info', 'style' => 'color:#fff;']) : ''; ?>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Transaksi Diagnosis Keperawatan',
        );
        ?>
        <style>
            .panel-body style+.form-horizontal {
                margin-top: 0 !important;
            }

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
                <?php $this->renderPartial('_dataPengkajian', array('modPengkajian' => $modPengkajian, 'form' => $form)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-user"></i> Identitas Pasien
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_ringkasDataPasien', array('model' => $model, 'modPasien' => $modPasien)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Penegakan Diagnosa Keperawatan</b>
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_dataDiagnosis', array('model' => $model, 'form' => $form)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Identifikasi Diagnosa Keperawatan
                </div>
            </div>
            <div class="panel-body table-responsive">
                <table id="table-diagnosis" class="table table-striped table-bordered table-condensed">
                    <thead>
                        <th style="text-align: center">Tanda dan Gejala / Faktor Risiko</th>
                        <th style="text-align: center">Diagnosa Keperawatan<span class='required'>*</span></th>
                        <th style="text-align: center" width="5%">Aksi</th>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($_GET['status'])) {
                            $diagnosisdet = ASDiagnosisaskepdetT::model()->findAllBySql(
                                'SELECT diagnosisaskepdet_t.diagnosisaskepdet_id, diagnosisaskepdet_t.iskolaborasi, diagnosakep.diagnosakep_nama, diagnosisaskepdet_t.hasildiagnosa_id
                                        FROM diagnosisaskepdet_t
                                        JOIN diagnosakep_m AS diagnosakep ON diagnosakep.diagnosakep_id = diagnosisaskepdet_t.hasildiagnosa_id
                                        WHERE diagnosisaskepdet_t.diagnosisaskep_id=' . $model->diagnosisaskep_id
                            );
                            if (count($diagnosisdet)) {
                                $nomor = 1;
                                foreach ($diagnosisdet as $i => $modDetailnya) {
                        ?>
                                    <tr>
                                        <td>
                                            <table style="width:100%">
                                                <?php
                                                if ($nomor % 2 == 0) {
                                                    $warna = '#fff';
                                                } else {
                                                    $warna = '#f8f8f8';
                                                }
                                                $cekPilih = PilihdiagnosisaskepT::model()->findAllByAttributes(array('diagnosisaskepdet_id' => $modDetailnya->diagnosisaskepdet_id));
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
                                                                    <td colspan="2" style="background-color:' . $warna . '; border: 1px solid ' . $warna . ' !important;"><b>Diagnosa Keperawatan Aktual</b><br></td>
                                                                </tr>
                                                                <tr> 
                                                                    <td colspan="2" style="background-color:' . $warna . '; border: 1px solid ' . $warna . ' !important;"><b>Tanda dan Gejala Mayor</b></td>
                                                                </tr>
                                                                <tr> 
                                                                    <td colspan="2" style="background-color:' . $warna . '; border: 1px solid ' . $warna . ' !important;"><b>Objektif</b></td>
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
                                                                    echo $this->renderPartial($this->path_view . '_detailTandagejala_1', array('no' => $no + 1, 'modTandaGejala' => $det, 'modDetail' => $modDet, 'warna' => $warna), true);
                                                                    $no1++;
                                                                }
                                                            }
                                                            $no++;
                                                        }
                                                    }
                                                    if ($no1 == 0) {
                                                        echo '<tr><td colspan="2" style="background-color:' . $warna . '; border: 1px solid ' . $warna . ' !important;">- &nbsp;(Tidak Tersedia)</td></tr>';
                                                    }
                                                    echo '<tr> 
                                                                    <td colspan="2" style="background-color:' . $warna . '; border: 1px solid ' . $warna . ' !important;"><br><b>Subjektif</b></td>
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
                                                                    echo $this->renderPartial($this->path_view . '_detailTandagejala_1', array('no' => $no + 1, 'modTandaGejala' => $det, 'modDetail' => $modDet, 'warna' => $warna), true);
                                                                    $no2++;
                                                                }
                                                            }
                                                            $no++;
                                                        }
                                                    }
                                                    if ($no2 == 0) {
                                                        echo '<tr><td colspan="2" style="background-color:' . $warna . '; border: 1px solid ' . $warna . ' !important;">- &nbsp;(Tidak Tersedia)</td></tr>';
                                                    }
                                                    echo '<tr> 
                                                                    <td colspan="2" style="background-color:' . $warna . '; border: 1px solid ' . $warna . ' !important;"><br><b>Tanda dan Gejala Minor</b></td>
                                                                </tr>
                                                                <tr> 
                                                                    <td colspan="2" style="background-color:' . $warna . '; border: 1px solid ' . $warna . ' !important;"><b>Objektif</b></td>
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
                                                                    echo $this->renderPartial($this->path_view . '_detailTandagejala_1', array('no' => $no + 1, 'modTandaGejala' => $det, 'modDetail' => $modDet, 'warna' => $warna), true);
                                                                    $no3++;
                                                                }
                                                            }
                                                            $no++;
                                                        }
                                                    }
                                                    if ($no3 == 0) {
                                                        echo '<tr><td colspan="2" style="background-color:' . $warna . '; border: 1px solid ' . $warna . ' !important;">- &nbsp;(Tidak Tersedia)</td></tr>';
                                                    }
                                                    echo '<tr> 
                                                                    <td colspan="2" style="background-color:' . $warna . '; border: 1px solid ' . $warna . ' !important;"><br><b>Subjektif</b></td>
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
                                                                    echo $this->renderPartial($this->path_view . '_detailTandagejala_1', array('no' => $no + 1, 'modTandaGejala' => $det, 'modDetail' => $modDet, 'warna' => $warna), true);
                                                                    $no4++;
                                                                }
                                                            }
                                                            $no++;
                                                        }
                                                    }
                                                    if ($no4 == 0) {
                                                        echo '<tr><td colspan="2" style="background-color:' . $warna . '; border: 1px solid ' . $warna . ' !important;">- &nbsp;(Tidak Tersedia)</td></tr>';
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
                                                    $criteria->select = 'jenisfaktorrisiko.jenisfaktorrisiko_nama, det.faktorrisiko_daftar_id, t.faktorrisiko_daftar_nama, det.kelompokfaktorrisikodaftar_id, det.jenisfaktorrisiko_id';
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
                                                    }
                                                    $no = 0;
                                                    foreach ($kanUtam as $det) {
                                                        echo ' <tr> 
                                                                        <td colspan="2" style="background-color:' . $warna . '; border: 1px solid ' . $warna . ' !important;"><b>Diagnosa Keperawatan Risiko</b><br></td>
                                                                    </tr>
                                                                    <tr> 
                                                                        <td colspan="2" style="background-color:' . $warna . '; border: 1px solid ' . $warna . ' !important;"><b>' . $det['jenisfaktorrisiko_nama'] . '</b></td>
                                                                    </tr>';
                                                        foreach ($jenisResiko as $value) {
                                                            if (!empty($det['jenisfaktorrisiko_id'])) {
                                                                if ($value->jenisfaktorrisiko_id == $det['jenisfaktorrisiko_id']) {
                                                                    $modDetail = new ASPilihdiagnosisaskepT();
                                                                    $modDetail->kelompokfaktorrisikodaftar_id = $det['kelompokfaktorrisikodaftar_id'];
                                                                    $kelompokfaktorrisikodaftar[] = $det['kelompokfaktorrisikodaftar_id'];
                                                                    echo $this->renderPartial($this->path_view . '_detailFaktorRisiko_1', array('no' => $no + 1, 'modFaktorRisiko' => $det, 'modDetail' => $modDetail, 'warna' => $warna), true);
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
                                            echo $modDetailnya->diagnosakep_nama;
                                            ?>
                                        </td>
                                    </tr>
                        <?php
                                    $nomor++;
                                }
                            } else {
                                echo "<tr>";
                                echo "<td colspan=6>Data tidak ditemukan.</td>";
                                echo "</tr>";
                            }
                        } else {
                            $trDiagnosis = $this->renderPartial($this->path_view . '_rowDiagnosisDetail', array('modDetail' => $modDetail, 'modPilih' => $modPilih), true);
                            echo $trDiagnosis;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="form-actions">
            <?php
            if ($modPengkajian->isNewRecord) {
                // echo CHtml::htmlButton(
                //     Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                //     array('class' => (isset($_GET['sukses'])) ? 'btn btn-danger' : 'btn btn-danger submit', 'title' => 'Simpan', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => (isset($_GET['sukses'])) ? true : false)
                // );
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);')
                );
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')),
                    array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'return false', 'disabled' => true)
                );
            } else {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array(
                        'title' => 'Simpan',
                        'class' => 'btn btn-danger',
                        'type' => 'submit',
                        'onKeypress' => 'return formSubmit(this,event)',
                        'disabled' => true
                    )
                );
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            }
            echo CHtml::link(
                Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
                array('class' => 'btn btn-default', 'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . '') . '";}); return false;')
            );
            ?>
            <?php
            $tips = array(
                '0' => 'simpan',
                '1' => 'ulang',
                '2' => 'print',
            );
            $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint = Yii::app()->createAbsoluteUrl($module . '/InformasiDiagnosisKeperawatan/Detail');
$url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/&diagnosisaskep_id=$model->diagnosisaskep_id&caraPrint="+caraPrint,"",'location=_new, width=900px, scrollbars=yes');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>
<?php
$this->renderPartial('_jsFunctions', array(
    'model' => $model,
    'modDetail' => $modDetail,
    'modPasien' => $modPasien,
    'modPengkajian' => $modPengkajian,
    'form' => $form
));
?>
<?php $this->renderPartial('_dialog', array()); ?>