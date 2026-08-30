<?php $linkHalaman = CustomFunction::getUrlByMenuID(3189); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Edukasi',
);
Yii::app()->clientScript->registerScript('search', "
        $('#evaluasi-m-search').submit(function(){
            $.fn.yiiGridView.update('evaluasi-m-grid', {
                data: $(this).serialize()
            });
            return false;
        });
    ");
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash("success", "Data berhasil disimpan!");
    $this->widget('bootstrap.widgets.BootAlert');
} ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Edukasi</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
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
                    <i class="entypo-credit-card"></i> Tabel <b>Edukasi</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div style="float:right;margin-bottom:10px">
                </div>
                <?php
                $this->widget('ext.bootstrap.widgets.MergeHeaderGroupGridView', array(
                    'id' => 'evaluasi-m-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'mergeHeaders' => array(
                        array(
                            'name' => 'Edukator',
                            'start' => '7',
                            'end' => '9',
                        ),
                        array(
                            'name' => 'Peserta',
                            'start' => '10',
                            'end' => '13',
                        ),
                        array(
                            'name' => 'Aksi',
                            'start' => '16',
                            'end' => '17',
                        ),
                    ),
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '($this->grid->dataProvider->pagination) ? 
                                                    ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                                    : ($row+1)',
                            'type' => 'raw',
                        ),
                        array(
                            'header' => 'Tanggal Edukasi',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if (!empty($data)) {
                                    return MyFormatter::formatDateTimeforUser($data->tgledukasi);
                                } else {
                                    return '-';
                                }
                            },
                            'htmlOptions' => array(
                                'style' => 'text-align: center;',
                            ),
                        ),
                        array(
                            'header' => 'Instalasi/Ruangan',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if (!empty($data)) {
                                    $ruangan = "-";
                                    $instalasi = "-";
                                    if (!empty($data->ruangan_id)) {
                                        $ruangan = RuanganM::model()->findByPk($data->ruangan_id)->ruangan_nama;
                                    }
                                    if (!empty($data->instalasi_id)) {
                                        $instalasi = InstalasiM::model()->findByPk($data->instalasi_id)->instalasi_nama;
                                    }
                                    return $instalasi . "/" . $ruangan;
                                } else {
                                    return '-';
                                }
                            },
                            'htmlOptions' => array(
                                'style' => 'text-align: center;',
                            ),
                        ),
                        array(
                            'header' => 'Topik Edukasi',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if (!empty($data->topikedukasi)) {
                                    return $data->topikedukasi;
                                } else {
                                    return '-';
                                }
                            },
                            'htmlOptions' => array(
                                'style' => 'text-align: center;',
                            ),
                        ),
                        array(
                            'header' => 'Judul Edukasi',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if (!empty($data->juduledukasi)) {
                                    return $data->juduledukasi;
                                } else {
                                    return '-';
                                }
                            },
                            'htmlOptions' => array(
                                'style' => 'text-align: center;',
                            ),
                        ),
                        array(
                            'header' => 'Bentuk Edukasi',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if (!empty($data->edukasipkrs_id)) {
                                    $criteria = new CDbCriteria;
                                    $criteria->select = " case WHEN  bentukedukasi_individu is true  THEN 'Individu'
                                                                WHEN  bentukedukasi_kelompokkecil is true  THEN 'Kelompok Kecil(2-10 Orang)'
                                                                WHEN  bentukedukasi_kelompoksedang is true  THEN 'Kelompok Sedang(11-20 Orang)'
                                                                WHEN  bentukedukasi_kelompokbesar is true  THEN 'Kelompok Besar(>20 Orang)' END as data";
                                    $criteria->addCondition('edukasipkrs_id=' . $data->edukasipkrs_id);
                                    $model = EdukasipkrsT::model()->findAll($criteria);
                                    foreach ($model as $row) {
                                        return $row->data;
                                    }
                                } else {
                                    return '-';
                                }
                            },
                            'htmlOptions' => array(
                                'style' => 'text-align: center;',
                            ),
                        ),
                        array(
                            'header' => 'Metode Edukasi',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if (!empty($data->edukasipkrs_id)) {
                                    $criteria = new CDbCriteria;
                                    $criteria->select = " case WHEN  metode_ceramah is true  THEN 'Ceramah'
                                                                WHEN  metode_demontrsasi is true  THEN 'Demonstrasi'
                                                                WHEN  metode_diskusi is true  THEN 'Diskusi Kelompok'
                                                                WHEN  metode_wawancara is true  THEN 'Tatap Muka' END as data";
                                    $criteria->addCondition('edukasipkrs_id=' . $data->edukasipkrs_id);
                                    $model = EdukasipkrsT::model()->findAll($criteria);
                                    foreach ($model as $row) {
                                        return $row->data;
                                    }
                                } else {
                                    return '-';
                                }
                            },
                            'htmlOptions' => array(
                                'style' => 'text-align: center;',
                            ),
                        ),
                        array(
                            'header' => 'Dokter',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if (!empty($data)) {
                                    return $data->dokterpenyuluh;
                                } else {
                                    return '-';
                                }
                            },
                            'htmlOptions' => array(
                                'style' => 'text-align: center;',
                            ),
                        ),
                        array(
                            'header' => 'Perawat',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if (!empty($data)) {
                                    return $data->paramedispenyuluh;
                                } else {
                                    return '-';
                                }
                            },
                            'htmlOptions' => array(
                                'style' => 'text-align: center;',
                            ),
                        ),
                        array(
                            'header' => 'Lainnya',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if (!empty($data)) {
                                    return $data->penyuluhlainnya;
                                } else {
                                    return '-';
                                }
                            },
                            'htmlOptions' => array(
                                'style' => 'text-align: center;',
                            ),
                        ),
                        array(
                            'header' => 'Pasien',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if (!empty($data)) {
                                    return $data->jml_pasien;
                                } else {
                                    return '-';
                                }
                            },
                            'htmlOptions' => array(
                                'style' => 'text-align: center;',
                            ),
                        ),
                        array(
                            'header' => 'Keluarga Pasien',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if (!empty($data)) {
                                    return $data->jml_keluargapasien;
                                } else {
                                    return '-';
                                }
                            },
                            'htmlOptions' => array(
                                'style' => 'text-align: center;',
                            ),
                        ),
                        array(
                            'header' => 'Laki-Laki',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if (!empty($data)) {
                                    return $data->jml_lakilaki;
                                } else {
                                    return '-';
                                }
                            },
                            'htmlOptions' => array(
                                'style' => 'text-align: center;',
                            ),
                        ),
                        array(
                            'header' => 'Perempuan',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if (!empty($data)) {
                                    return $data->jml_perempuan;
                                } else {
                                    return '-';
                                }
                            },
                            'htmlOptions' => array(
                                'style' => 'text-align: center;',
                            ),
                        ),
                        array(
                            'header' => 'File Berkas',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if (!empty($data)) {
                                    return CHtml::link("<i class='fa fa-cloud-download'></i>", $this->createUrl('Unduh', array('id' => $data->edukasipkrs_id)), array('title' => 'Unduh Dokumen', 'rel' => 'tooltip'));
                                } else {
                                    return '-';
                                }
                            },
                            'htmlOptions' => array(
                                'style' => 'text-align: center;font-size:20px;',
                                'class' => 'hover',
                            ),
                        ),
                        array(
                            'header' => 'Detail',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return CHtml::link("<i class='entypo-doc-text'></i>", Yii::app()->createUrl('informasi/InformasiEdukasi/detail&id=' . $data->edukasipkrs_id), array(
                                    "rel" => "tooltip",
                                    //'onclick'=>'Menyetujui('.$data->ppdslisensi_id.');',
                                    "target" => "iframeDetail",
                                    "onclick" => "$('#dialogDetail').dialog('open');",
                                    "title" => "Klik untuk Melihat Detail Edukasi"
                                ));
                            },
                            'htmlOptions' => array(
                                'style' => 'text-align: center;font-size:20px;',
                                'class' => 'hover',
                            ),
                        ),
                        array(
                            'header' => 'Ubah',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return CHtml::link("<i class='entypo-pencil'></i>", Yii::app()->createUrl('informasi/TransaksiEdukasipkrs/index&edukasipkrs_id=' . $data->edukasipkrs_id), array(
                                    "rel" => "tooltip",
                                    //'onclick'=>'Menyetujui('.$data->ppdslisensi_id.');',
                                    "title" => "Klik untuk Mengedit Edukasi"
                                ));
                            },
                            'htmlOptions' => array(
                                'style' => 'text-align: center;font-size:20px;',
                                'class' => 'hover',
                            ),
                        ),
                        array(
                            'header' => 'Hapus',
                            'type' => 'raw',
                            'value' => '($data->edukasipkrs_id)?CHtml::link("<i class=\'glyphicon glyphicon-trash\'></i> ", "javascript:deleteRecord($data->edukasipkrs_id)",array("id"=>"$data->edukasipkrs_id","rel"=>"tooltip","title"=>"Hapus")):CHtml::link("<i class=\'glyphicon glyphicon-trash\'></i> ", "javascript:deleteRecord($data->edukasipkrs_id)",array("id"=>"$data->edukasipkrs_id","rel"=>"tooltip","title"=>"Hapus"));',
                            'htmlOptions' => array('style' => 'text-align: center;font-size:20px;'),
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
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);
$urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
$urlDelete = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/delete');
?>
<?php
// ===========================Dialog Details Evaluasi=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetail',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail Edukasi',
        'autoOpen' => false,
        'zIndex' => 1002,
        'width' => 500,
        'height' => 460,
        'resizable' => true,
        'scroll' => false,
    ),
));
?>
<iframe src="" name="iframeDetail" style="width:100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Evaluasi================================
?>
<?php
// ===========================Dialog Review=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogReview',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Review Evaluasi',
        'autoOpen' => false,
        'width' => 1500,
        'height' => 500,
        'resizable' => true,
        'scroll' => false,
    ),
));
?>
<iframe src="" name="iframeReview" style="width:100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Review================================
?>
<script>
    function deleteRecord(id) {
        var id = id;
        console.log(id);
        var url = '<?php echo $urlDelete; ?>';
        myConfirm('Yakin Akan Menghapus Data ini?', 'Perhatian!', function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.status == 'sukses') {
                            $.fn.yiiGridView.update('evaluasi-m-grid');
                        } else {
                            myAlert('Data gagal dihapus!')
                        }
                    }, "json");
            }
        });
    }
</script>