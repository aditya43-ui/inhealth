<?php
$this->breadcrumbs = array(
    'Metodepengadaan Ms' => array('index'),
    'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('metodepengadaan-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="white-container">
    <div class="panel panel-gradient">
        <div class="panel panel-heading">
            <div class="panel-title"> Pengaturan <b> Metode Pengadaan</b> </div>
        </div>
        <div class="panel-body">
            <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

            <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="entypo-search "></i>')), '#', array('class' => 'search-button btn')); ?>
            <div class="cari-lanjut search-form" style="display:none">
                <?php
                $this->renderPartial('_search', array(
                    'model' => $model,
                ));
                ?>
            </div><!-- search-form -->
            <div class="block-tabel">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'metodepengadaan-m-grid',
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
                        'metodepengadaan_nama',
                        'metodepengadaan_namalain',
                        'metodepengadaan_ket',
                        'metodepengadaan_urutan',
                        array(
                            'header' => 'Status',
                            'type' => 'raw',
                            'value' => '($data->metodepengadaan_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
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
                            'header' => Yii::t('zii', 'Update'),
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
                            'type' => 'raw',
                            'value' => function($data) {
                                if ($data->metodepengadaan_aktif == true) {
                                    return CHtml::link("<i class='icon-form-silang'></i> ", "javascript:removeTemporary($data->metodepengadaan_id)", array("id" => "$data->metodepengadaan_id", "rel" => "tooltip", "title" => "Menonaktifkan Metode Pengadaan")) . ' ' . CHtml::link("<i class='icon-form-sampah'></i> ", "javascript:deleteRecord($data->metodepengadaan_id)", array("id" => "$data->metodepengadaan_id", "rel" => "tooltip", "title" => "Hapus Metode Pengadaan"));
                                } else {
                                    return CHtml::link("<i class='icon-form-check'></i> ", "javascript:aktifkan($data->metodepengadaan_id)", array("id" => "$data->metodepengadaan_id", "rel" => "tooltip", "title" => "Mengaktifkan Metode Pengadaan")) . ' ' . CHtml::link("<i class='icon-form-sampah'></i> ", "javascript:deleteRecord($data->metodepengadaan_id)", array("id" => "$data->metodepengadaan_id", "rel" => "tooltip", "title" => "Hapus Metode Pengadaan"));
                                }
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width:80px'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>
    </div>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Tambah Metode Pengadaan', array('{icon}' => '<i class="icon-plus icon-white"></i>')), $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger')) . "&nbsp&nbsp";
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
    window.open("${urlPrint}/"+$('#metodepengadaan-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
    ?></div>
<script type="text/javascript">
    function removeTemporary(id) {
        var url = '<?php echo $url . "/removeTemporary"; ?>';
        myConfirm('Yakin akan menonaktifkan data ini untuk sementara?', 'Perhatian!', function (r) {
            if (r) {
                $.post(url, {id: id},
                        function (data) {
                            if (data.status == 'proses_form') {
                                $.fn.yiiGridView.update('metodepengadaan-m-grid');
                            } else {
                                myAlert('Data Gagal di Nonaktifkan')
                            }
                        }, "json");
            }
        });
    }
    function aktifkan(id) {
        var url = '<?php echo $url . "/aktifkan"; ?>';
        myConfirm('Yakin akan mengaktifkan data ini?', 'Perhatian!', function (r) {
            if (r) {
                $.post(url, {id: id},
                        function (data) {
                            if (data.status == 'proses_form') {
                                $.fn.yiiGridView.update('metodepengadaan-m-grid');
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
        myConfirm('Yakin Akan Menghapus Data ini ?', 'Perhatian!', function (r) {
            if (r) {
                $.post(url, {id: id},
                        function (data) {
                            if (data.status == 'proses_form') {
                                $.fn.yiiGridView.update('metodepengadaan-m-grid');
                            } else {
                                myAlert('Data gagal di hapus karena digunakan di transaksi lain')
                            }
                        }, "json");
            }
        });
    }
</script>