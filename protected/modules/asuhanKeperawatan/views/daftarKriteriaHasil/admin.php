<?php
$this->breadcrumbs = array(
    'Jenisintervensi Ms' => array('index'),
    'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('jenisintervensi-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="panel panel-success">
    <div class="panel panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b> Daftar Hasil Kriteria </b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form">
            <?php
            $this->renderPartial('_search', array(
                'model' => $model,
            ));
            ?>
        </div>
        <!--search-form-->

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Daftar Hasil Kriteria</b>
                </div>
            </div>
            <div class="panel-body">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'jenisintervensi-m-grid',
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
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        'kriteriahasil_daftar_nama',
                        'kriteriahasil_daftar_namalain',
                        array(
                            'header' => 'Aktif',
                            'value' => function ($data) {
                                echo ($data->kriteriahasil_daftar_aktif == 1) ? 'Aktif' : 'Tidak Aktif';
                            }
                        ),
                        array(
                            'header' => 'Lihat',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(),
                            ),
                        ),
                        array(
                            'header' => 'Ubah',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{update}',
                            'buttons' => array(
                                'update' => array(
                                    'visible' => 'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Hapus',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'value' => function ($data) {
                                if ($data->kriteriahasil_daftar_aktif == true) {
                                    echo CHtml::link("<i class='icon-form-silang'></i> ", "javascript:removeTemporary($data->kriteriahasil_daftar_id)", array("id" => "$data->kriteriahasil_daftar_id", "rel" => "tooltip", "title" => "Menonaktifkan Daftar Hasil Kriteria")) . ' ' . CHtml::link("<i style='font-size: 14px;' class='icon-form-sampah'></i>", "javascript:deleteRecord($data->kriteriahasil_daftar_id)", array("id" => "$data->kriteriahasil_daftar_id", "title" => "Hapus Daftar Hasil Kriteria"));
                                } else {
                                    echo CHtml::link("<i class='glyphicon glyphicon-check'></i> ", "javascript:aktifkan($data->kriteriahasil_daftar_id)", array("id" => "$data->kriteriahasil_daftar_id", "title" => "Mengaktifkan Daftar Hasil Kriteria")) . ' ' . CHtml::link("<i style='font-size: 14px;' class='icon-form-sampah'></i>", "javascript:deleteRecord($data->kriteriahasil_daftar_id)", array("id" => "$data->kriteriahasil_daftar_id", "title" => "Hapus Daftar Hasil Kriteria"));
                                }
                            },
                        ),

                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Daftar Hasil Kriteria', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah Daftar Hasil Kriteria', 'class' => 'btn btn-danger')
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial('sistemAdministrator.views/tips/master', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
            $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);

            $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#jenisintervensi-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
        </div>
    </div>
</div>

<!--</div>-->
<script type="text/javascript">
    function removeTemporary(id) {
        var url = '<?php echo $url . "/removeTemporary"; ?>';
        myConfirm('Yakin akan menonaktifkan data ini untuk sementara?', 'Perhatian!', function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.status == 'proses_form') {
                            $.fn.yiiGridView.update('jenisintervensi-m-grid');
                        } else {
                            myAlert('Data gagal dinonaktifkan!')
                        }
                    }, "json");
            }
        });
    }

    function aktifkan(id) {
        var url = '<?php echo $url . "/aktifkan"; ?>';
        myConfirm('Yakin akan menonaktifkan data ini untuk sementara?', 'Perhatian!', function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.status == 'proses_form') {
                            $.fn.yiiGridView.update('jenisintervensi-m-grid');
                        } else {
                            myAlert('Data Gagal di Aktifkan')
                        }
                    }, "json");
            }
        });
    }

    function deleteRecord(id) {
        var id = id;
        var url = '<?php echo $url . "/delete"; ?>';
        myConfirm('Yakin Akan Menghapus Data ini?', 'Perhatian!', function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.sukses == 0) {
                            toastr.error(data.pesan, 'Perhatian!');
                            return false;
                        } else {
                            toastr.success(data.pesan, 'Perhatian!');
                            $.fn.yiiGridView.update('jenisintervensi-m-grid');
                        }
                    }, "json");
            }
        });
    }
</script>