<?php

/**
 * digunakan untuk membuat detail jadwal monev
 * RSST-2632
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 * 
 */
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pengirimanrm-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
));
$this->widget('bootstrap.widgets.BootAlert');
?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Detail <b>Edukasi</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label("Tgl. Edukasi", '', array('class' => 'control-label')); ?>

                    <div class="controls">
                        <div class="control-label" style="text-align:left">
                            <?php echo MyFormatter::formatDateTimeForUser($data->tgledukasi) ?>
                        </div>
                    </div>


                </div>

                <div class="control-group">
                    <?php echo CHtml::label("Instalasi", '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <div class="control-label" style="text-align:left">
                            <?php
                            if (!empty($data->instalasi_id)) {
                                echo $instalasi = InstalasiM::model()->findByPk($data->instalasi_id)->instalasi_nama;
                            } else {
                                echo "-";
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Ruangan", '', array('class' => 'control-label')); ?>

                    <div class="controls">
                        <div class="control-label" style="text-align:left">

                            <?php
                            if (!empty($data->ruangan_id)) {
                                echo $ruangan = RuanganM::model()->findByPk($data->ruangan_id)->ruangan_nama;
                            } else {
                                echo "-";
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Topik Edukasi", '', array('class' => 'control-label')); ?>

                    <div class="controls">
                        <div class="control-label" style="text-align:left">

                            <?php
                            if (!empty($data->topikedukasi)) {
                                echo $data->topikedukasi;
                            } else {
                                echo '-';
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <?php echo CHtml::label("Judul Edukasi", '', array('class' => 'control-label')); ?>

                    <div class="controls">
                        <div class="control-label" style="text-align:left">

                            <?php
                            if (!empty($data->juduledukasi)) {
                                echo $data->juduledukasi;
                            } else {
                                echo '-';
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Bentuk Edukasi", '', array('class' => 'control-label')); ?>

                    <div class="controls">
                        <div class="control-label" style="text-align:left">

                            <?php
                            if (!empty($data->edukasipkrs_id)) {
                                $criteria = new CDbCriteria;
                                $criteria->select = " case WHEN  bentukedukasi_individu is true  THEN 'Individu'
                                                                WHEN  bentukedukasi_kelompokkecil is true  THEN 'Kelompok Kecil(2-10 Orang)'
                                                                WHEN  bentukedukasi_kelompoksedang is true  THEN 'Kelompok Sedang(11-20 Orang)'
                                                                WHEN  bentukedukasi_kelompokbesar is true  THEN 'Kelompok Besar(>20 Orang)' END as data";
                                $criteria->addCondition('edukasipkrs_id=' . $data->edukasipkrs_id);
                                $model = EdukasipkrsT::model()->findAll($criteria);
                                foreach ($model as $row) {
                                    echo $row->data . "</br>";
                                }
                            } else {
                                echo '-';
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Metode Edukasi", '', array('class' => 'control-label')); ?>

                    <div class="controls">
                        <div class="control-label" style="text-align:left">

                            <?php
                            if (!empty($data->edukasipkrs_id)) {
                                $criteria = new CDbCriteria;
                                $criteria->select = " case WHEN  metode_ceramah is true  THEN 'Ceramah'
                                                                WHEN  metode_demontrsasi is true  THEN 'Demonstrasi'
                                                                WHEN  metode_diskusi is true  THEN 'Diskusi Kelompok'
                                                                WHEN  metode_wawancara is true  THEN 'Tatap Muka' END as data";
                                $criteria->addCondition('edukasipkrs_id=' . $data->edukasipkrs_id);
                                $model = EdukasipkrsT::model()->findAll($criteria);
                                foreach ($model as $row) {
                                    echo $row->data . "</br>";
                                }
                            } else {
                                echo '-';
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Alat/VA", '', array('class' => 'control-label')); ?>

                    <div class="controls">
                        <div class="control-label" style="text-align:left">

                            <?php
                            if (!empty($data->edukasipkrs_id)) {
                                $criteria = new CDbCriteria;
                                $criteria->select = " case WHEN  sarana_leaflet is true  THEN 'Leaflet'
                                                                WHEN  sarana_poster is true  THEN 'Poster'
                                                                WHEN  sarana_microphone is true  THEN 'Microphone'
                                                                WHEN  sarana_lcd  is true  THEN 'LCD'
                                                                WHEN  sarana_lainnya  is true  THEN saraba_lainntaket
                                                                WHEN  sarana_ohp is true  THEN 'OHP' END as data";
                                $criteria->addCondition('edukasipkrs_id=' . $data->edukasipkrs_id);
                                $model = EdukasipkrsT::model()->findAll($criteria);
                                foreach ($model as $row) {
                                    echo $row->data . "</br>";
                                }
                            } else {
                                echo '-';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title">
                                Edukator
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="col-sm-6">
                                <div class="control-group">
                                    <?php echo CHtml::label("Dokter", '', array('class' => 'control-label')); ?>

                                    <div class="controls">
                                        <div class="control-label" style="text-align:left">

                                            <?php
                                            if (!empty($data)) {
                                                echo $data->dokterpenyuluh . " Orang";
                                            } else {
                                                echo '-';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label("Perawat", '', array('class' => 'control-label')); ?>

                                    <div class="controls">
                                        <div class="control-label" style="text-align:left">

                                            <?php
                                            if (!empty($data)) {
                                                echo $data->paramedispenyuluh . " Orang";
                                            } else {
                                                echo '-';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label("Lainnya", '', array('class' => 'control-label')); ?>

                                    <div class="controls">
                                        <div class="control-label" style="text-align:left">

                                            <?php
                                            if (!empty($data)) {
                                                echo $data->penyuluhlainnya . " Orang";
                                            } else {
                                                echo '-';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <i class="entypo-user"></i> Peserta
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="col-sm-6">
                                <div class="control-group">
                                    <?php echo CHtml::label("Pasien", '', array('class' => 'control-label')); ?>

                                    <div class="controls">
                                        <div class="control-label" style="text-align:left">

                                            <?php
                                            if (!empty($data)) {
                                                echo $data->jml_pasien . " Orang";
                                            } else {
                                                echo '-';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label("Keluarga Pasien", '', array('class' => 'control-label')); ?>

                                    <div class="controls">
                                        <div class="control-label" style="text-align:left">

                                            <?php
                                            if (!empty($data)) {
                                                echo $data->jml_keluargapasien . " Orang";
                                            } else {
                                                echo '-';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label("Laki-Laki", '', array('class' => 'control-label')); ?>

                                    <div class="controls">
                                        <div class="control-label" style="text-align:left">

                                            <?php
                                            if (!empty($data)) {
                                                echo $data->jml_lakilaki . " Orang";
                                            } else {
                                                echo '-';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label("Perempuan", '', array('class' => 'control-label')); ?>

                                    <div class="controls">
                                        <div class="control-label" style="text-align:left">

                                            <?php
                                            if (!empty($data)) {
                                                echo $data->jml_perempuan . " Orang";
                                            } else {
                                                echo '-';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label("File Edukasi", '', array('class' => 'control-label')); ?>

                                    <div class="controls">
                                        <div class="control-label" style="text-align:left">

                                            <?php
                                            if (!empty($data)) {
                                                echo $data->file_lampiran;
                                            } else {
                                                echo '-';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label("Pertanyaan", '', array('class' => 'control-label')); ?>

                                    <div class="controls">
                                        <div class="control-label" style="text-align:left">

                                            <?php
                                            if (!empty($data)) {
                                                echo $data->pertanyaan;
                                            } else {
                                                echo '-';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>