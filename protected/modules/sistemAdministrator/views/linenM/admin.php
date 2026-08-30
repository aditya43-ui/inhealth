<?php
$this->breadcrumbs = array(
    'Pengaturan Linen',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('salinen-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Linen</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn'));
        ?>
        <div class="cari-lanjut search-form">
            <?php $this->renderPartial($this->path_view . '_search', array('model' => $model,)); ?>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Linen</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'salinen-m-grid',
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
                        array(
                            'header' => 'Ruangan',
                            'type' => 'raw',
                            'name' => 'ruangan_id',
                            'value' => '(!empty($data->ruangan)? $data->ruangan->ruangan_nama :"")',
                            'filter' =>  CHtml::activeDropDownList(
                                $model,
                                'ruangan_id',
                                CHtml::listData(RuanganM::model()->findAllByAttributes(array(
                                    'ruangan_aktif' => true,
                                ), array(
                                    'order' => 'ruangan_nama',
                                )), 'ruangan_id', 'ruangan_nama'),
                                array('empty' => '-- Pilih --')
                            ),
                        ),
                        array(
                            'header' => 'Rak Penyimpanan',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $rak = RakpenyimpananM::model()->findByPk($data->rakpenyimpanan_id);
                                return empty($rak) ? "-" : $rak->rakpenyimpanan_nama;
                            },
                            'filter' =>  CHtml::activeDropDownList(
                                $model,
                                'rakpenyimpanan_id',
                                CHtml::listData(RakpenyimpananM::model()->findAllByAttributes(array(
                                    'rakpenyimpanan_aktif' => true,
                                ), array(
                                    'order' => 'rakpenyimpanan_nama',
                                )), 'rakpenyimpanan_id', 'rakpenyimpanan_nama'),
                                array('empty' => '-- Pilih --')
                            ),
                        ),
                        array(
                            'header' => 'Jenis',
                            'name' => 'jenislinen_id',
                            'type' => 'raw',
                            'value' => 'empty($data->jenis) ? "" : $data->jenis->jenislinen_nama',
                            'filter' =>  CHtml::activeDropDownList(
                                $model,
                                'jenislinen_id',
                                CHtml::listData(JenislinenM::model()->findAll(array(
                                    'order' => 'jenislinen_nama',
                                )), 'jenislinen_id', 'jenislinen_nama'),
                                array('empty' => '-- Pilih --')
                            ),
                        ),
                        array(
                            'header' => 'Bahan',
                            'type' => 'raw',
                            'name' => 'bahanlinen_id',
                            'value' => 'empty($data->bahan) ? "" : $data->bahan->bahanlinen_nama',
                            'filter' =>  CHtml::activeDropDownList(
                                $model,
                                'bahanlinen_id',
                                CHtml::listData(BahanlinenM::model()->findAllByAttributes(array(
                                    'bahanlinen_aktif' => true,
                                ), array(
                                    'order' => 'bahanlinen_nama',
                                )), 'bahanlinen_id', 'bahanlinen_nama'),
                                array('empty' => '-- Pilih --')
                            ),
                        ),
                        array(
                            'header' => 'Nama Linen',
                            'type' => 'raw',
                            'name' => 'barang_nama',
                            'value' => 'isset($data->barang->barang_nama)?$data->barang->barang_nama:"-"'
                        ),
                        array(
                            'header' => 'Status',
                            'value' => '($data->linen_aktif)?"Aktif":"Tidak Aktif"',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),

                        /*
		'kodelinen',
		'tglregisterlinen',
		'noregisterlinen',
		'namalinen',
		'namalainnya',
		'merklinen',
		'beratlinen',
		'warna',
		'tahunbeli',
		'gambarlinen',
		'jmlcucilinen',
		'create_time',
		'update_time',
		'create_loginpemakai_id',
		'update_loginpemakai_id',
		'create_ruangan',
		'linen_aktif',
		*/
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
                                    //		'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Hapus',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                            'template' => '{remove} {delete}',
                            'buttons' => array(
                                'remove' => array(
                                    'label' => "<i class='" . MyIcon::getIcons('batal') . "'></i>",
                                    'options' => array('title' => Yii::t('mds', 'Remove Temporary')),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/nonActive",array("id"=>$data->linen_id))',
                                    'click' => 'function(){nonActive(this);return false;}',
                                    'visible' => '($data->linen_aktif)?TRUE:FALSE',
                                ),
                                'delete' => array(
                                    //	'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
                                ),
                            )
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){
                jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                $("table").find("input[type=text]").each(function(){
                    cekForm(this);
                })
                 $("table").find("select").each(function(){
                    cekForm(this);
                })
            }',
                )); ?>
            </div>
        </div>
        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Linen', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah linen', 'class' => 'btn btn-danger')
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial($this->path_tips . 'master', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>

        <?php
        $urlPrint = $this->createUrl('print');

        $js = <<< JSCRIPT
function cekForm(obj)
{
    $("#salinen-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#salinen-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
        Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
        ?>
    </div>
</div>
<script type="text/javascript">
    function nonActive(obj) {
        myConfirm("Anda yakin akan menonaktifkan data ini untuk sementara?", "Perhatian!",
            function(r) {
                if (r) {
                    $.ajax({
                        type: 'GET',
                        url: obj.href,
                        data: {}, //
                        dataType: "json",
                        success: function(data) {
                            $.fn.yiiGridView.update('salinen-m-grid');
                            if (data.sukses > 0) {} else {
                                myAlert('Data gagal dinonaktifkan!');
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            myAlert('Data gagal dinonaktifkan!');
                            console.log(errorThrown);
                        }
                    });
                }
            }
        );
        return false;
    }
</script>