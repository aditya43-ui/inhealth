<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Abnormal Absen</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Informasi Abnormal Absen',
        );
        Yii::app()->clientScript->registerScript('search', "
                            $('#abnormalabsen-info-search').submit(function(){
                                    $.fn.yiiGridView.update('abnormalabsen-info-grid', {
                                            data: $(this).serialize()
                                    });
                                    return false;
                            });
                            ");
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_search', array('model' => $model)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Abnormal Absen</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp', array(
                    'id' => 'abnormalabsen-info-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'type' => 'raw',
                            'value' => '$row+1',
                        ),
                        array(
                            'header' => 'Tanggal Pengajuan',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglpengajuan)',
                        ),
                        array(
                            'header' => 'No Register',
                            'type' => 'raw',
                            'value' => '$data->nomorindukpegawai',
                        ),
                        array(
                            'header' => 'Nama Karyawan',
                            'type' => 'raw',
                            'value' => '$data->pegawai->namaLengkap',
                        ),
                        array(
                            'header' => 'Unit Kerja',
                            'type' => 'raw',
                            'value' => '(!empty($data->pegawai->unitkerja)? $data->pegawai->unitkerja->namaunitkerja:"")',
                        ),
                        array(
                            'header' => 'Tanggal Presensi',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglabnormalabsen)',
                        ),
                        array(
                            'header' => 'Jam Masuk',
                            'type' => 'raw',
                            'value' => '$data->jammasuk',
                        ),
                        array(
                            'header' => 'Jam Keluar',
                            'type' => 'raw',
                            'value' => '$data->jamkeluar',
                        ),
                        array(
                            'header' => 'Alasan',
                            'type' => 'raw',
                            'value' => '$data->alasan',
                        ),
                        array(
                            'header' => 'Keterangan',
                            'type' => 'raw',
                            'value' => '$data->keterangan',
                        ),
                        array(
                            'header' => 'Mengetahui',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $dataDialog = 'myAlert("Hanya ' . (!empty($data->pegawaimengetahui) ? $data->pegawaimengetahui->namaLengkap : "-") . ' yang bisa mengakses");';
                                if ($data->pegawaimengetahui_id == Yii::app()->user->getState('pegawai_id')) {
                                    $dataDialog = "$('#dialogMengetahui').dialog('open');";
                                }
                                $html = (!empty($data->pegawaimengetahui) ? $data->pegawaimengetahui->namaLengkap : "-") . (isset($data->tglmengetahui) ? "<br>" . MyFormatter::formatDateTimeForUser($data->tglmengetahui) : (!isset($data->pegawaimengetahui_id) ? "" : " " . CHtml::link("<icon class='icon-form-check'></icon> ", Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/approve', array("abnormalabsen_id" => $data->abnormalabsen_id, 'type' => 'mengetahui', "frame" => true)), array("target" => "frameMengetahui", "rel" => "tooltip", "title" => "Klik untuk Approve Mengetahui", "onclick" => $dataDialog))));
                                return $html;
                            }
                        ),
                        array(
                            'header' => 'Menyetujui',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $dataDialog = 'myAlert("Hanya ' . (!empty($data->pegawaimenyetujui) ? $data->pegawaimenyetujui->namaLengkap : "-") . ' yang bisa mengakses");';
                                if ($data->pegawaimenyetujui_id == Yii::app()->user->getState('pegawai_id')) {
                                    $dataDialog = "$('#dialogMenyetujui').dialog('open');";
                                }
                                $html = (!empty($data->pegawaimenyetujui) ? $data->pegawaimenyetujui->namaLengkap : "-") . (isset($data->tglmenyetujui) ? "<br>" . MyFormatter::formatDateTimeForUser($data->tglmenyetujui) : (!isset($data->pegawaimenyetujui_id) ? "" : ((empty($data->tglmengetahui)) ? "" : " " . CHtml::link("<icon class='icon-form-check'></icon> ", Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/approve', array("abnormalabsen_id" => $data->abnormalabsen_id, 'type' => 'menyetujui', "frame" => true)), array("target" => "frameMenyetujui", "rel" => "tooltip", "title" => "Klik Untuk Approve Menyetujui", "onclick" => $dataDialog)))));
                                return $html;
                            }
                        ),
                        array(
                            'header' => 'Status',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $html = CHtml::link('Menunggu Persetujuan', 'javascript:;', array('class' => 'btn btn-blue nohover'));;
                                if (!empty($data->statuspersetujuan)) {
                                    if ($data->statuspersetujuan == Params::STATUS_ABNORMALABSEN_DISETUJUI) {
                                        $html = CHtml::link('Disetujui', 'javascript:;', array('class' => 'btn btn-success nohover'));
                                    } else if ($data->statuspersetujuan == Params::STATUS_ABNORMALABSEN_DITOLAK) {
                                        $html = CHtml::link('Ditolak', 'javascript:;', array('class' => 'btn btn-danger nohover'));
                                    }
                                }
                                return $html;
                            },
                            'htmlOptions' => array('style' => 'text-align: center;'),
                        ),
                        array(
                            'header' => 'Presensi',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return ((empty($data->statuspersetujuan) || (!empty($data->statuspersetujuan) && $data->statuspersetujuan != Params::STATUS_ABNORMALABSEN_DISETUJUI)) ? CHtml::Link("<i class='icon-form-ubah'></i>", 'javascript:void(0)', array('disabled' => true, 'style' => 'opacity: 0.3', "class" => "", "rel" => "tooltip", "title" => "Tombol akan aktif jika status sudah disetujui")) : CHtml::link("<i class='icon-form-ubah'></i>", Yii::app()->createUrl('/kepegawaian/PresensiT/Create', array("abnormalabsen_id" => $data->abnormalabsen_id)), array("rel" => "tooltip", "title" => "Klik untuk mentransaksikan presensi", "data-placement" => "left")));
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogMengetahui',
    'options' => array(
        'title' => 'Approvement Pegawai Mengetahui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'resizable' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('abnormalabsen-info-grid', {
                            data: $(this).serialize()
                    }); }",
    ),
));
?>
<iframe name='frameMengetahui' width="100%" height="600"></iframe>
<?php $this->endWidget(); ?>
<!-- Dialog untuk menyetujui -->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogMenyetujui',
    'options' => array(
        'title' => 'Approvement Pegawai Menyetujui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'resizable' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('abnormalabsen-info-grid', {
                            data: $(this).serialize()
                    }); }",
    ),
));
?>
<iframe name='frameMenyetujui' width="100%" height="600"></iframe>
<?php $this->endWidget(); ?>