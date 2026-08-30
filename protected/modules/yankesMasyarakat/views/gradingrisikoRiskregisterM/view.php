<?php
/**
* digunakan untuk Master grading risiko
* @author Elham Budianto <elhambudianto@.com>
**/
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Lihat <strong>Grading Risiko</strong></div>
            </div>
            <div class="panel-body">
                <?php
                $this->breadcrumbs = array(
                    'subtingkat insiden' => array('index'),
                    $model->gradingrisiko_riskregister_id,
                );
                $arrMenu = array();
                $this->menu = $arrMenu;
                $this->widget('bootstrap.widgets.BootAlert');
                
                $peluang = PeluangM::model()->findByPk($model->peluang_id);
                if(!empty($peluang)){
                    $peluang_descriptor = $peluang->peluang_descriptor;
                }else{
                    $peluang_descriptor = '-';
                }
                
                $konsekuensi = KonsekuensiM::model()->findByPk($model->konsekuensi_id);
                if(!empty($konsekuensi)){
                    $konsekuensi_namabobot = $konsekuensi->konsekuensi_namabobot;
                }else{
                    $konsekuensi_namabobot = '-';
                }
                
                $detectability = DetectabilityM::model()->findByPk($model->detectability_id);
                if(!empty($detectability)){
                    $detectability_deskripsi = $detectability->detectability_deskripsi;
                }else{
                    $detectability_deskripsi = '-';
                }
                
                $tingkatrisiko = TingkatrisikoRiskregisterM::model()->findByPk($model->tingkatrisiko_riskregister_id);
                if(!empty($tingkatrisiko)){
                    $tingkatrisiko_nama = $tingkatrisiko->tingkatrisiko_nama;
                    $tingkatrisiko_warna = $tingkatrisiko->tingkatrisiko_warna;
                }else{
                    $tingkatrisiko_nama = '-';
                    $tingkatrisiko_warna = '-';
                }
                ?>
                <?php
                $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        array(
                            'label' => 'ID',
                            'value' => $model->gradingrisiko_riskregister_id,
                        ),
                        array(
                            'label' => 'Peluang',
                            'value' => $peluang_descriptor,
                        ),
                        array(
                            'label' => 'Konsekuensi',
                            'value' => $konsekuensi_namabobot,
                        ),
                        array(
                            'label' => 'Detectability',
                            'value' => $detectability_deskripsi,
                        ),
                        array(
                            'label' => 'Tingkat Risiko',
                            'value' => $tingkatrisiko_nama,
                        ),
                        array(
                            'label' => 'Warna Risiko',
                            'value' => $tingkatrisiko_warna,
                        ),
                        array(
                            'label' => 'Status',
                            'type' => 'raw',
                            'value' => ($model->gradingrisiko_aktif == 1 ) ? "Aktif" : "Tidak Aktif",
                        ),
                    ),
                ));
                ?>
                <?php
                echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Grading Risiko', array('{icon}' => '<i class="entypo-folder"></i>')), $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')) . "&nbsp";
                $this->widget('UserTips', array('type' => 'view'));
                ?>
            </div>
        </div>
    </div>
</div>
