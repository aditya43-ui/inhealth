<?php

/**
 * - digunakan sebagai informasi work order
 * @author : Elham Budianto
 * @email : elhambudianto1@gmail.com
 * @wiki : ..
 **/
?>
<?php
Yii::app()->clientScript->registerScript('search', "
    $('#workorder-r-search').submit(function(){
        $.fn.yiiGridView.update('workorder-r-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Work Order</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_search', array('model' => $model,)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Work Order</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'workorder-r-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'replaceUrl' => true,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '($this->grid->dataProvider->pagination) ? 
                                                    ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                                    : ($row+1)',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align:left;'),
                        ),
                        array(
                            'header' => 'Nomor Work Order',
                            'value' => function ($data) {
                                $workorder = WorkorderT::model()->findByPk($data->workorder_id);
                                echo $workorder->workorder_no;
                            },
                        ),
                        array(
                            'header' => 'Unit Kerja',
                            'value' => function ($data) {
                                if ($data->ruangan_id != NULL) {
                                    $ruangan = RuanganM::model()->findByPk($data->ruangan_id);
                                    $unitkerjaruangan = UnitkerjaruanganM::model()->findByAttributes(array('ruangan_id' => $data->ruangan_id));
                                    if (!empty($unitkerjaruangan)) {
                                        $unitkerja = UnitkerjaM::model()->findByPk($unitkerjaruangan->unitkerja_id);
                                        echo $unitkerja->namaunitkerja . ' - ' . $ruangan->ruangan_nama;
                                    } else {
                                        echo '-';
                                    }
                                } else {
                                    echo '-';
                                }
                            },
                        ),
                        array(
                            'header' => 'Lokasi',
                            'value' => function ($data) {
                                if ($data->ruangan_nama !== NULL) {
                                    echo 'Ruang ' . $data->ruangan_nama;
                                } else {
                                    echo '-';
                                }
                            },
                        ),
                        array(
                            'header' => 'Jenis Peralatan',
                            'value' => function ($data) {
                                if ($data->invperalatan_namabrg !== NULL) {
                                    echo $data->invperalatan_namabrg;
                                } else {
                                    echo '-';
                                }
                            },
                        ),
                        array(
                            'header' => 'No. Aset',
                            'value' => function ($data) {
                                if ($data->invperalatan_kode !== NULL) {
                                    echo $data->invperalatan_kode;
                                } else {
                                    echo '-';
                                }
                            },
                        ),
                        array(
                            'header' => 'Tanggal Pemeliharaan',
                            'value' => function ($data) {
                                $tglpemeliharaan = WorkorderT::model()->findByPk($data->workorder_id);
                                echo MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($tglpemeliharaan->tglpemeliharaan)));
                            },
                        ),
                        array(
                            'header' => 'Penanggung Jawab',
                            'value' => function ($data) {
                                $pj_id = WorkorderT::model()->findByPk($data->workorder_id);
                                $pj = PegawaiM::model()->findByPk($pj_id->pj_pemeliharaan_id);
                                echo $pj->namaLengkap;
                            },
                        ),
                        array(
                            'header' => 'Teknisi',
                            'value' => function ($data) {
                                if ($data->jenisteknisi == 'EKSTERNAL') {
                                    echo $data->namateknisi;
                                } else {
                                    $work = WorkorderT::model()->findByPk($data->workorder_id);
                                    $pegawai = PegawaiM::model()->findByPk($work->teknisiint_id);
                                    if (!empty($pegawai)) {
                                        echo $pegawai->namaLengkap;
                                    } else {
                                        echo '-';
                                    }
                                }
                            },
                        ),
                        array(
                            'header' => 'Keterangan',
                            'value' => function ($data) {
                                $keterangan = WorkorderT::model()->findByPk($data->workorder_id);
                                echo $keterangan->ket_pemeliharaan;
                            },
                        ),
                        array(
                            'header' => 'Status',
                            'value' => function ($data) {
                                $status = WorkorderT::model()->findByPk($data->workorder_id);
                                if ($status->status_pemeliharaan == 'BELUM') {
                                    echo CHtml::htmlButton("OPEN", array(
                                        'class' => 'btn btn-primary',
                                        'onclick' => 'statusOpen(' . $data->workorder_id . ');',
                                        'data-toggle' => 'tooltip',
                                        'title' => 'Klik untuk Menjadikan In Progress',
                                        //'style'=>'width: 100px;'
                                    ));
                                } else if ($status->status_pemeliharaan == 'SEDANG') {
                                    echo CHtml::link("IN PROGRESS", Yii::app()->createUrl('manajemenAset/InformasiWorkOrder/isiPemeliharaan&id=' . $data->workorder_id), array("rel" => "tooltip", "title" => "Klik untuk mengubah menjadi finish", "target" => "iframe2", "onclick" => "$('#dialogPemeliharaan').dialog('open');", 'class' => 'btn btn-info'));
                                } else {
                                    echo CHtml::htmlButton("FINISH", array(
                                        'class' => 'btn btn-default',
                                        'data-toggle' => 'tooltip',
                                        'title' => 'Status sudah selesai',
                                        //'style'=>'width: 100px;'
                                    ));
                                }
                            },
                        ),
                        array(
                            'header' => 'Detil',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return CHtml::link("<span style='font-size:15px'><i class='entypo-doc-text'></i></span>", Yii::app()->createUrl('manajemenAset/InformasiWorkOrder/detail&id=' . $data->workorder_id), array("rel" => "tooltip", "title" => "Klik untuk Melihat Detail Work Order", "target" => "iframe1", "onclick" => "$('#dialogDetail').dialog('open');"));
                            },
                            'htmlOptions' => array(
                                'style' => 'text-align: center',
                            ),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<?php
echo $this->renderPartial('_dialog',['model'=>$model],true);

// ===========================Dialog Details Work Order=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetail',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail Work Order',
        'autoOpen' => false,
        'width' => 1000,
        'height' => 600,
        'resizable' => true,
        'scroll' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('workorder-r-grid', {
            data: $('#workorder-r-search').serialize()
    }); }",
    ),
));
?>
<iframe src="" name="iframe1" style="width:100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Work Order================================
?>
<?php
// ===========================Dialog Isi Pemeliharaan=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPemeliharaan',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Pemeliharaan Aset',
        'autoOpen' => false,
        'width' => 500,
        'height' => 500,
        'resizable' => true,
        'scroll' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('workorder-r-grid', {
            data: $('#workorder-r-search').serialize()
    }); }",
    ),
));
?>
<iframe src="" name="iframe2" style="width:100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog isi Pemeliharaan================================
?>
<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);
?>
<script>
    function statusOpen(id) {
        var id = id;
        var url = '<?php echo $url . "/ubahStatusInProgress"; ?>';
        myConfirm('Anda yakin untuk mengubah status menjadi In Progress?', 'Perhatian!', function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.status == 'proses_form') {
                            $.fn.yiiGridView.update('workorder-r-grid');
                        } else {
                            myAlert('Data Gagal di Ubah');
                        }
                    }, "json");
            }
        });
    }
</script>
