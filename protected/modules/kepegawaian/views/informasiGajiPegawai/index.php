<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.mtz.monthpicker.js'); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Penggajian</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Informasi' => array('index'),
            'Penggajian Pegawai',
        );
        ?>
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'carigaji-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        ));
        Yii::app()->clientScript->registerScript('cariPasien', "
    $('#carigaji-form').submit(function(){
            $.fn.yiiGridView.update('kppenggajianpeg-t-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Pegawai</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-4">
                        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                            'data' => $modelpegawai,
                            'attributes' => array(
                                array(
                                    'label' => 'NIP',
                                    'type' => 'raw',
                                    'value' => $modelpegawai->nomorindukpegawai,
                                ),
                                array(
                                    'label' => 'Pegawai',
                                    'type' => 'raw',
                                    'value' => $modelpegawai->nama_pegawai,
                                ),
                                array(
                                    'label' => 'Tempat Lahir',
                                    'type' => 'raw',
                                    'value' => $modelpegawai->tempatlahir_pegawai,
                                ),
                                array(
                                    'label' => 'Tanggal Lahir',
                                    'type' => 'raw',
                                    'value' => $modelpegawai->tgl_lahirpegawai,
                                ),
                                array(
                                    'label' => 'Jenis Kelamin',
                                    'type' => 'raw',
                                    'value' => $modelpegawai->jeniskelamin,
                                ),
                                array(
                                    'label' => 'Jabatan',
                                    'type' => 'raw',
                                    'value' => (isset($modelpegawai->jabatan->jabatan_nama) ? $modelpegawai->jabatan->jabatan_nama : "-"),
                                ),
                                array(
                                    'label' => 'NPWP',
                                    'type' => 'raw',
                                    'value' => (isset($modelpegawai->npwp) ? $modelpegawai->npwp : "-"),
                                ),
                            ),
                        )); ?>
                    </div>
                    <div class="col-sm-4">
                        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                            'data' => $modelpegawai,
                            'attributes' => array(
                                array(
                                    'label' => 'No. Rekening',
                                    'type' => 'raw',
                                    'value' => (isset($modelpegawai->no_rekening) ? $modelpegawai->no_rekening : "-"),
                                ),
                                array(
                                    'label' => 'Bank',
                                    'type' => 'raw',
                                    'value' => (isset($modelpegawai->banknorekening) ? $modelpegawai->banknorekening : "-"),
                                ),
                                array(
                                    'label' => 'No. Telepon',
                                    'type' => 'raw',
                                    'value' => (isset($modelpegawai->notelp_pegawai) ? $modelpegawai->notelp_pegawai : "-"),
                                ),
                                array(
                                    'label' => 'No. Handphone',
                                    'type' => 'raw',
                                    'value' => (isset($modelpegawai->nomobile_pegawai) ? $modelpegawai->nomobile_pegawai : "-"),
                                ),
                                array(
                                    'label' => 'Agama',
                                    'type' => 'raw',
                                    'value' => $modelpegawai->agama,
                                ),
                                array(
                                    'label' => 'Alamat',
                                    'type' => 'raw',
                                    'value' => (!empty($modelpegawai->alamat_pegawai) ? $modelpegawai->alamat_pegawai : "-"),
                                ),
                            ),
                        )); ?>
                    </div>
                    <div class="col-sm-4 text-center">
                        <?php echo !empty($modelpegawai->photopegawai) ? CHtml::image(Params::urlPegawaiTumbsDirectory() . 'kecil_' . $modelpegawai->photopegawai, 'Foto pasien', array('id' => 'photo_pasien', 'width' => 180)) : CHtml::image(Params::urlPegawaiDirectory() . 'no_photo.jpeg', 'Photo Pegawai', array('id' => 'photo_pasien', 'width' => 180)); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_search', array('form' => $form, 'format' => $format, 'model' => $model)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Informasi Penggajian</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'kppenggajianpeg-t-grid',
                    'dataProvider' => $model->searchRiwayatGaji($pegawai),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-condensed table-bordered',
                    'columns' => array(
                        array(
                            'header' => 'Tanggal Penggajian',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglpenggajian)',
                        ),
                        array(
                            'header' => 'No. Penggajian',
                            'value' => '$data->nopenggajian',
                        ),
                        array(
                            'header' => 'Keterangan',
                            'value' => '(($data->keterangan) ? $data->keterangan : "-")',
                        ),
                        array(
                            'header' => 'Mengetahui',
                            'value' => '(($data->mengetahui) ? $data->mengetahui : "-")',
                        ),
                        array(
                            'header' => 'Rincian',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return CHtml::link("<i class='icon-form-detail'></i>", Yii::app()->createUrl('/' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/detailGaji&pegawai_id=' . $data->pegawai_id . '&nopenggajian=' . $data->nopenggajian), array("rel" => "tooltip", "title" => "Klik untuk Detail Penggajian", "target" => "iframe", "onclick" => "$('#dialogDetailsPenggajian').dialog('open');",));
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width:60px'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
        <?php
        // ===========================Dialog Details Penggajian=========================================
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id' => 'dialogDetailsPenggajian',
            // additional javascript options for the dialog plugin
            'options' => array(
                'title' => 'Detail Penggajian Pegawi',
                'autoOpen' => false,
                'width' => 800,
                'height' => 500,
                'resizable' => true,
                'scroll' => false
            ),
        ));
        ?>
        <iframe src="" name="iframe" width="100%" height="100%">
        </iframe>
        <?php
        $this->endWidget('zii.widgets.jui.CJuiDialog');
        //===============================Akhir Dialog Details Penggajian================================
        ?>
        <?php $this->endWidget(); ?>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#PenggajianpegT_tgl_awal').monthpicker({
            pattern: 'mmmm yyyy'
        });
    });
</script>