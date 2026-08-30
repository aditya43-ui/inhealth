<?php
$this->breadcrumbs = array(
    'Luarankeperawatan Ms' => array('index'),
    'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('luarankeperawatan-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Pengaturan <b>Luaran Keperawatan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        if (!empty($_GET['sukses'])) {
            $this->widget('bootstrap.widgets.BootAlert');
            Yii::app()->user->setFlash('success', '<b>Berhasil!</b> Data berhasil disimpan.');
        }
        echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn'));
        ?>

        <div class="cari-lanjut search-form">
            <?php
            $this->renderPartial($this->path_view . '_search', array(
                'model' => $model,
            ));
            ?>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Luaran Keperawatan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'luarankeperawatan-m-grid',
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
                        'luarankeperawatan_kode',
                        'luarankeperawatan_nama',
                        'luarankeperawatan_deskripsi',
                        array(
                            'header' => 'Status',
                            'value' => '($data->luarankeperawatan_aktif == true ? \'Aktif\': \'Tidak Aktif\')',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                            'filter' => CHtml::activeDropDownList($model, 'luarankeperawatan_aktif', array('1' => 'Aktif', '0' => 'Tidak Aktif',), array())
                        ),
                        array(
                            'header' => 'Lihat',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(),
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
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Hapus',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if ($data->luarankeperawatan_aktif == TRUE) {
                                    return CHtml::link("<i class='glyphicon glyphicon-remove'></i> ", "javascript:nonActive(" . $data->luarankeperawatan_id . " )", array("id" => $data->luarankeperawatan_id, "rel" => "tooltip", "title" => "Menonaktifkan")) . '&nbsp;' .
                                        CHtml::link("<i class='glyphicon glyphicon-trash'></i> ", "javascript:deleteRecord($data->luarankeperawatan_id)", array("id" => "$data->luarankeperawatan_id", "rel" => "tooltip", "title" => "Hapus Bahan Makanan"));
                                } else {
                                    return CHtml::link("<i class='glyphicon glyphicon-ok'></i> ", "javascript:active(" . $data->luarankeperawatan_id . " )", array("id" => $data->luarankeperawatan_id, "rel" => "tooltip", "title" => "Mengaktifkan")) . '&nbsp;' .
                                        CHtml::link("<i class='glyphicon glyphicon-trash'></i> ", "javascript:deleteRecord($data->luarankeperawatan_id)", array("id" => "$data->luarankeperawatan_id", "rel" => "tooltip", "title" => "Hapus Bahan Makanan"));
                                }
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){
                            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                            $("table").find("input[type=text]").each(function(){
                                cekForm(this);
                            });
                             $("table").find("select").each(function(){
                                cekForm(this);
                            });
                            $(".kode-alatmedis").keyup(function() {
                                setKodeAlatMedis(this);
                            });
                            $(".hurufs-only").keyup(function() {
                                setHurufsOnly(this);
                            });
                        }',
                ));
                ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Luaran Keperawatan', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah Luaran Keperawatan', 'class' => 'btn btn-danger')
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial('sistemAdministrator.views.tips.master', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);
            $urlPrint = $this->createUrl('print');

            $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#luarankeperawatan-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    function cekForm(obj) {
        $("#luarankeperawatan-m-search :input[name='" + obj.name + "']").val(obj.value);
    }

    function nonActive(id) {
        var url = '<?php echo $url . "/nonActive"; ?>';
        myConfirm("Anda yakin akan menonaktifkan data ini untuk sementara?", "Perhatian!", function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.sukses > 0) {
                            $.fn.yiiGridView.update('luarankeperawatan-m-grid');
                        } else {
                            myAlert('Data gagal dinonaktifkan!')
                        }
                    }, "json");
            }
        });
    }

    function active(id) {
        var url = '<?php echo $url . "/active"; ?>';
        myConfirm("Anda yakin akan mengaktifkan data ini untuk sementara?", "Perhatian!", function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.sukses > 0) {
                            $.fn.yiiGridView.update('luarankeperawatan-m-grid');
                        } else {
                            myAlert('Data gagal dinonaktifkan!')
                        }
                    }, "json");
            }
        });
    }

    function deleteRecord(id) {
        var id = id;
        var url = '<?php echo $url . "/delete"; ?>';
        myConfirm('Apakah Anda yakin ingin menghapus data ini?', 'Perhatian!',
            function(r) {
                if (r) {
                    $.post(url, {
                            id: id
                        },
                        function(data) {
                            $.fn.yiiGridView.update('luarankeperawatan-m-grid');
                            if (data.sukses > 0) {} else {
                                myAlert("Data tidak bisa dihapus karena sudah berelasi dengan data master yang lain.");
                            }
                        }, "json");
                }
            });
    }
</script>