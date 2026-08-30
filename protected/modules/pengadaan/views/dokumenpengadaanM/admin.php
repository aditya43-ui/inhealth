<?php
$this->breadcrumbs = array(
    'Dokumenpengadaan Ms' => array('index'),
    'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('dokumenpengadaan-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<!--<div class="white-container">-->
<div class="panel panel-gradient">
    <div class="panel panel-heading">
        <div class="panel-title"> Pengaturan <b>Dokumen Pengadaan </b> </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form" style="display:none">
            <?php
            $this->renderPartial('_search', array(
                'model' => $model,
            ));
            ?>
        </div> 
        <hr>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Tabel <b>Dokumen Pengadaan </b></div>
            </div>
            <div class="panel-body">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'dokumenpengadaan-m-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '($this->grid->dataProvider->pagination) ? 
						($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
						: ($row+1)',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align:right;'),
                        ),
                        'dokumenpengadaan_jenistransaksi',
                        array(
                            'header' => 'Jenis Pengadaan',
                            'value' => '!empty($data->jenispengadaan_id) ? $data->jenispengadaan->jenispengadaan_nama : " - "',
                        ),
                        array(
                            'header' => 'Metode Pengadaan',
                            'value' => function($data){
                                $modMetode = MetodepengadaanM::model()->findByAttributes(array('metodepengadaan_id' => $data->metodepengadaan_id));
                                if (!empty($modMetode->metodepengadaan_id)) {
                                    echo $modMetode->metodepengadaan_nama; 
                                } else {
                                    echo "-";
                                }
                            }
                        ),
                        'dokumenpengadaan_nama',
                        'dokumenpengadaan_namalain',
                        'dokumenpengadaan_deskripsi',
                        array(
                            'header' => '<center>Wajib</center>',
                            'value' => '($data->dokumenpengadaan_wajib == 1 ) ? "Wajib" : "Tidak Wajib"',
                            'htmlOptions' => array('style' => 'text-align:center;'),
                        ),
                        array(
                            'header' => 'Format',
                            'value' => function($data) {
                                $pdf = " ";
                                $img = " ";
                                $zip = " ";
                                $rar = " ";
                                $excel = " ";
                                $word = " ";
                                if ($data->file_zip == true) {
                                    $zip = "ZIP,";
                                }
                                if ($data->file_image == true) {
                                    $img = "Gambar,";
                                }
                                if ($data->file_pdf == true) {
                                    $pdf = "PDF,";
                                }

                                if ($data->file_excel == true) {
                                    $excel = "Excel,";
                                }
                                if ($data->file_word == true) {
                                    $word = "Word,";
                                }

                                if ($data->file_rar == true) {
                                    $rar = "RAR";
                                }

                                return $zip . " " . $img . " " . $pdf . " " . $excel . " " . $word . " " . $rar;
                            }
                        ),
                        array(
                            'header' => '<center>Aktif</center>',
                            'value' => '($data->dokumenpengadaan_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                            'htmlOptions' => array('style' => 'text-align:center;'),
                        ),
                        array(
                            'header' => Yii::t('zii', 'View'),
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(),
                            ),
                        ),
                        array(
                            'header' => 'Ubah',
                            'value' => function($data) {

                                if ($data->dokumenpengadaan_aktif == true) {
                                    echo CHtml::link("<i class='entypo entypo-pencil'> </i>", Yii::app()->createUrl('/pengadaan/dokumenpengadaanM/update&id=' . $data->dokumenpengadaan_id . '&update=1'), array("title" => "Klik untuk Mengubah Dokumen Pengadaan"));
                                    echo CHtml::link("<i class='glyphicon glyphicon-remove'></i> ", "javascript:removeTemporary($data->dokumenpengadaan_id)", array("id" => "$data->dokumenpengadaan_id", "rel" => "tooltip", "title" => "Menonaktifkan Dokumen Pengadaan")) . ' ' . CHtml::link("<i class='glyphicon glyphicon-trash'></i> ", "javascript:deleteRecord($data->dokumenpengadaan_id)", array("id" => "$data->dokumenpengadaan_id", "title" => "Hapus Dokumen Pengadaan"));
                                } else {
                                    echo CHtml::link("<i class='entypo entypo-pencil'> </i>", Yii::app()->createUrl('/pengadaan/dokumenpengadaanM/update&id=' . $data->dokumenpengadaan_id . '&update=1'), array("title" => "Klik untuk Mengubah Dokumen Pengadaan"));
                                    echo CHtml::link("<i class='glyphicon glyphicon-check'></i> ", "javascript:aktifkan($data->dokumenpengadaan_id)", array("id" => "$data->dokumenpengadaan_id", "title" => "Mengaktifkan Pengadaan")) . ' ' . CHtml::link("<i class='glyphicon glyphicon-trash'></i> ", "javascript:deleteRecord($data->dokumenpengadaan_id)", array("id" => "$data->dokumenpengadaan_id", "title" => "Hapus Dokumen Pengadaan"));
                                }
                            },
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
echo CHtml::link(Yii::t('mds', '{icon} Tambah Dokumen Pengadaan', array('{icon}' => '<i class="icon-plus icon-white"></i>')), $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger')) . "&nbsp&nbsp";
echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="icon-book icon-white"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')')) . "&nbsp&nbsp";
echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="icon-pdf icon-white"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')) . "&nbsp&nbsp";
echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp&nbsp";
$content = $this->renderPartial('pengadaan.views.tips/master', array(), true);
$this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
$url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#dokumenpengadaan-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>
<!--</div>-->
<script type="text/javascript">
    function removeTemporary(id) {
        var url = '<?php echo $url . "/removeTemporary"; ?>';
        myConfirm('Yakin akan menonaktifkan data ini untuk sementara?', 'Perhatian!', function (r) {
            if (r) {
                $.post(url, {id: id},
                        function (data) {
                            if (data.status == 'proses_form') {
                                $.fn.yiiGridView.update('dokumenpengadaan-m-grid');
                            } else {
                                myAlert('Data Gagal di Nonaktifkan')
                            }
                        }, "json");
            }
        });
    }

    function aktifkan(id) {
        var url = '<?php echo $url . "/aktifkan"; ?>';
        myConfirm('Yakin akan menonaktifkan data ini untuk sementara?', 'Perhatian!', function (r) {
            if (r) {
                $.post(url, {id: id},
                        function (data) {
                            if (data.status == 'proses_form') {
                                $.fn.yiiGridView.update('dokumenpengadaan-m-grid');
                            } else {
                                myAlert('Data Gagal di Aktifkan')
                            }
                        }, "json");
            }
        });
    }

    function deleteRecord(id) {
        var id = id;
        var url = '<?php echo $url . "/deleteRow"; ?>';
        myConfirm('Yakin Akan Menghapus Data ini ?', 'Perhatian!', function (r) {
            if (r) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('deleteRow'); ?>',
                    data: {id: id},
                    dataType: "json",
                    success: function (data) {
                        if (data.ok != 1) {
                            myAlert(data.msg);
                            return false;
                        }
                        $.fn.yiiGridView.update('dokumenpengadaan-m-grid');
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }
        });
    }
</script>