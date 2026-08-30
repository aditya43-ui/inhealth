<?php
$this->breadcrumbs = array(
    'Diagnosakep Ms' => array('index'),
    'Manage',
);

$arrMenu = array();
(Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Signa Obat ', 'header' => true, 'itemOptions' => array('class' => 'heading-master'))) : '';
//array_push($arrMenu,array('label'=>Yii::t('mds','List').' FALookupM', 'icon'=>'list', 'url'=>array('index'))) ;
(Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Create') . ' Signa Obat', 'icon' => 'file', 'url' => array('create'))) : '';

//$this->menu=$arrMenu;

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
    $('#" . CHtml::activeId($model, 'diagnosakep_kode') . "').focus();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('diagnosakep-m-gird', {
		data: $(this).serialize()
	});
	return false;
});
");

$this->widget('bootstrap.widgets.BootAlert');
?>

<div class="panel panel-gradient">
    <div class="panel panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Diagnosa Keperawatan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>

        <div class="cari-lanjut search-form">
            <?php
            $this->renderPartial($this->path_view . '_search', array(
                'model' => $model,
            ));
            ?>
        </div>
        <!--search-form-->

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Diagnosa Keperawatan</b>
                </div>
            </div>
            <div class="panel-body">
                <!--<h6>Tabel <b>Signa Obat</b></h6>-->
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'diagnosakep-m-gird',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '($this->grid->dataProvider->pagination) ? 
                        ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                        : ($row+1)',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Kode Diagnosa',
                            'name' => 'diagnosakep_kode',
                            'value' => '$data->diagnosakep_kode',
                        ),
                        array(
                            'header' => 'Diagnosa Keperawatan',
                            'name' => 'diagnosakep_nama',
                            'value' => '$data->diagnosakep_nama',
                        ),
                        array(
                            'header' => 'Deskripsi',
                            'name' => 'diagnosakep_deskripsi',
                            'value' => '$data->diagnosakep_deskripsi',
                        ),
                        array(
                            'header' => 'Aktif',
                            'value' => '($data->diagnosakep_aktif == true ? \'Aktif\': \'Tidak Aktif\')',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                            'filter' => CHtml::dropDownList(
                                'aktif',
                                $model->aktif,
                                array(
                                    '1' => 'Aktif',
                                    '0' => 'Tidak Aktif',
                                ),
                                array('empty' => '-- Pilih --')
                            )
                        ),
                        array(
                            'header' => 'Lihat',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(
                                    'options' => array('rel' => 'tooltip', 'title' => 'Lihat Diagnosa Keperawatan'),
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Ubah',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{update}',
                            'buttons' => array(
                                'update' => array(
                                    'visible' => 'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                    'options' => array('rel' => 'tooltip', 'title' => 'Ubah Diagnosa Keperawatan'),
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Hapus',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                            'value' => function ($data) {
                                if ($data->diagnosakep_aktif == true) {
                                    echo CHtml::link("<i class='icon-form-silang'></i> ", "javascript:removeTemporary($data->diagnosakep_id)", array("id" => "$data->diagnosakep_id", "rel" => "tooltip", "title" => "Menonaktifkan Diagnosa Keperawatan")) . ' ' . CHtml::link("<i style='font-size: 14px;' class='icon-form-sampah'></i>", "javascript:deleteRecord($data->diagnosakep_id)", array("id" => "$data->diagnosakep_id", "title" => "Hapus Diagnosa Keperawatan"));
                                } else {
                                    echo CHtml::link("<i class='glyphicon glyphicon-ok'></i> ", "javascript:aktifkan($data->diagnosakep_id)", array("id" => "$data->diagnosakep_id", "title" => "Mengaktifkan Diagnosa Keperawatan")) . ' ' . CHtml::link("<i style='font-size: 14px;' class='icon-form-sampah'></i>", "javascript:deleteRecord($data->diagnosakep_id)", array("id" => "$data->diagnosakep_id", "title" => "Hapus Diagnosa Keperawatan"));
                                }
                            },
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
            $("table").find("input[type=text]").each(function(){
                cekForm(this);
            })
        }',
                ));
                ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Diagnosa Keperawatan', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah Diagnosa Keperawatan', 'class' => 'btn btn-danger')
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));

            $tips = array(
                '0' => 'lihat',
                '1' => 'ubah',
                '2' => 'nonaktif',
                '3' => 'hapus',
                '7' => 'pencarianlanjut',
                '8' => 'cari',
                '4' => 'masterPDF',
                '5' => 'masterEXCEL',
                '6' => 'masterPRINT',
            );
            $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
            $this->widget('UserTips', array('content' => $content));

            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
            $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);

            $js = <<< JSCRIPT
         function cekForm(obj)
{
    $("#diagnosakep-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#diagnosakep-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
        </div>
    </div>
</div>

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
                            $.fn.yiiGridView.update('diagnosakep-m-gird');
                            window.parent.toastr.success('Data berhasil diaktifkan', 'Perhatian!');
                        } else {
                            window.parent.toastr.error('Data gagal dinonaktifkan!');
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
                            $.fn.yiiGridView.update('diagnosakep-m-gird');
                            window.parent.toastr.success('Data berhasil diaktifkan', 'Perhatian!');
                        } else {
                            window.parent.toastr.error('Data Gagal di Aktifkan');
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
                            window.parent.toastr.error(data.pesan, 'Perhatian!');
                            return false;
                        } else {
                            window.parent.toastr.success(data.pesan, 'Perhatian!');
                            $.fn.yiiGridView.update('diagnosakep-m-gird');
                        }
                    }, "json");
            }
        });
    }

    $(document).ready(function() {
        $("input[name='SADiagnosakepM[diagnosakep_kode]']").focus();
    });
</script>