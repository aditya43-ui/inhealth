<?php
$this->breadcrumbs = array(
    'Petunjuktransaksi Ms' => array('index'),
    'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('petunjuktransaksi-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="white-container">
    <div class="panel panel-gradient">
        <div class="panel panel-heading">
            <div class="panel-title"> Pengaturan <b> Petunjuk Penggunaan  </b> </div>
        </div>
        <div class="panel-body">

            <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

            <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-search"></i>')), '#', array('class' => 'search-button btn')); ?>
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
                    'id' => 'petunjuktransaksi-m-grid',
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
                        array(
                            'header' => 'Tipe',
                            'filter' => CHtml::activeDropDownList($model,'petunjuktransaksi_type', CHtml::listData(YKMPetunjuktransaksiM::getAllPetunjuk(), 'petunjuktransaksi_type', 'petunjuktransaksi_type'), array('class'=>'span3','empty'=>'-- Pilih --')),
                            'value' => '$data->petunjuktransaksi_type',
                        ),
                        'petunjuktransaksi_nama',
                        'petunjuktransaksi_deskripsi',
                        array(
                            'header' => 'Gambar',
                            'htmlOptions' => array('style' => 'text-align:center; width: 20%'),
                            'value' => function($data) {
                                $img = "";
                                if (empty($data->petunjuktransaksi_image)) {
                                    $img = "";
                                } else {
                                    if (file_exists(Params::pathPetunjukTransaksiDirectory() . $data->petunjuktransaksi_image)) {
                                        $img = Params::urlPetunjukTransaksiDirectory() . $data->petunjuktransaksi_image;
                                    } else {
                                        $img = Params::urlPetunjukTransaksiDirectory() . "no_photo.jpeg";
                                    }
                                }
                                echo '<img src="' . $img . '" height="200" width="200">';
                                echo CHtml::link("$data->petunjuktransaksi_image", $this->createUrl('Unduh', array('id' => $data->petunjuktransaksi_id)), array('title' => 'Unduh Petunjuk Transaksi', 'rel' => 'tooltip', 'style' => 'color:blue;'));

                            }
                        ),
                        array(
                            'header' => 'Urutan',
                            'htmlOptions' => array('style' => 'text-align:center; width: 5%'),
                            'value' => '$data->petunjuktransaksi_urutan',
                        ),
                        array(
                            'header' => 'Aktif',
                            'value'=>'($data->petunjuktransaksi_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
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
                            'htmlOptions' => array('style' => 'text-align:center; width: 8%'),
                            'header' => 'Hapus',
                            'value' => function($data) {
                                if ($data->petunjuktransaksi_aktif == true) {
                                    echo CHtml::link("<i class='glyphicon glyphicon-remove' style='font-size: 14px; margin-right: 20px;'></i> ", "javascript:removeTemporary($data->petunjuktransaksi_id)", array("id" => "$data->petunjuktransaksi_id", "rel" => "tooltip", "title" => "Menonaktifkan Petunjuk Penggunaan")) . ' ' . CHtml::link("<i class='glyphicon glyphicon-trash' style='font-size: 14px'></i> ", "javascript:deleteRecord($data->petunjuktransaksi_id)", array("id" => "$data->petunjuktransaksi_id", "title" => "Hapus Petunjuk Penggunaan"));
                                } else {
                                    echo CHtml::link("<i class='glyphicon glyphicon-check' style='font-size: 14px; margin-right: 20px;'></i> ", "javascript:aktifkan($data->petunjuktransaksi_id)", array("id" => "$data->petunjuktransaksi_id", "title" => "Mengaktifkan Petunjuk Penggunaan")) . ' ' . CHtml::link("<i class='glyphicon glyphicon-trash' style='font-size: 14px'></i> ", "javascript:deleteRecord($data->petunjuktransaksi_id)", array("id" => "$data->petunjuktransaksi_id", "title" => "Hapus Petunjuk Penggunaan"));
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
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Tambah Petunjuk Penggunaan', array('{icon}' => '<i class="icon-plus icon-white"></i>')), $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')) . "&nbsp&nbsp";
    echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="icon-book icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PDF\')')) . "&nbsp&nbsp";
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="icon-pdf icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')) . "&nbsp&nbsp";
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp&nbsp";
    $content = $this->renderPartial('pengadaan.views.tips/master', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
$url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);


    $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#petunjuktransaksi-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
    ?></div><script type="text/javascript">
    function removeTemporary(id) {
        var url = '<?php echo $url . "/removeTemporary"; ?>';
        myConfirm('Yakin akan menonaktifkan data ini?', 'Perhatian!', function (r) {
            if (r) {
                $.post(url, {id: id},
                        function (data) {
                            if (data.status == 'proses_form') {
                                $.fn.yiiGridView.update('petunjuktransaksi-m-grid');
                            } else {
                                toastr.error('Data Gagal di Nonaktifkan')
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
                                $.fn.yiiGridView.update('petunjuktransaksi-m-grid');
                            } else {
                                toastr.error('Data Gagal di Aktifkan')
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
                        if (data.sukses != 1) {
                            toastr.error(data.msg);
                            return false;
                        }
                        $.fn.yiiGridView.update('petunjuktransaksi-m-grid');
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }
        });
    }
</script>