<?php
$this->breadcrumbs = array(
    'Jurnal Rekening Jenis Barang' => array('admin'),
    'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('jenisbarangrek-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Jurnal Rekening Jenis Barang</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form">
            <?php $this->renderPartial('_search', array('model' => $model,)); ?>
        </div>
        <!--search-form-->

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Jurnal Rekening Jenis Barang</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'jenisbarangrek-m-grid',
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
                        //'jenisbarangrek_id',
                        array(
                            'name' => 'jenisbarang_id',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $jenis = JenisbarangM::model()->findByPk($data->jenisbarang_id);
                                if (empty($jenis)) return "-";
                                return $jenis->jenisbarang_nama;
                            },
                            'filter' => CHtml::activeDropDownList($model, 'jenisbarang_id', CHtml::listData(
                                JenisbarangM::model()->findAll('jenisbarang_aktif = true order by jenisbarang_nama'),
                                'jenisbarang_id',
                                'jenisbarang_nama'
                            ), array('empty' => '-- Pilih --')),
                        ),
                        array(
                            'header' => 'Rekening 5',
                            'name' => 'rekening5_id',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $rek = Rekening5M::model()->findByPk($data->rekening5_id);
                                if (empty($rek)) {
                                    return "-";
                                }
                                return $rek->kdrekening5 . " - " . $rek->nmrekening5;
                            },
                            'filter' => false,
                        ),
                        array(
                            'header' => 'Saldo Normal',
                            'name' => 'debitkredit',
                            'filter' => CHtml::activeDropDownList($model, 'debitkredit', ['D' => 'Debit', 'K' => 'Kredit'], array(
                                'empty' => '-- Pilih --',
                            )),
                        ),
                        array(
                            'header' => 'Penerimaan Faktur',
                            'type' => "raw",
                            'value' => '$data->ispenerimaan ? "<i class=\"entypo-check\"></i>" : ""',
                            'filter' => CHtml::activeDropDownList($model, 'ispenerimaan', [1 => 'Ya', 2 => 'Tidak'], array(
                                'empty' => '-- Pilih --',
                            )),
                            'htmlOptions' => array(
                                'style' => 'text-align: center;',
                            ),
                        ),
                        array(
                            'header' => 'Retur Penerimaan Faktur',
                            'type' => "raw",
                            'value' => '$data->isreturpenerimaan ? "<i class=\"entypo-check\"></i>" : ""',
                            'filter' => CHtml::activeDropDownList($model, 'isreturpenerimaan', [1 => 'Ya', 2 => 'Tidak'], array(
                                'empty' => '-- Pilih --',
                            )),
                            'htmlOptions' => array(
                                'style' => 'text-align: center;',
                            ),
                        ),
                        array(
                            'header' => 'Inventarisasi Stok Awal',
                            'type' => "raw",
                            'value' => '$data->isstokopname ? "<i class=\"entypo-check\"></i>" : ""',
                            'filter' => CHtml::activeDropDownList($model, 'isstokopname', [1 => 'Ya', 2 => 'Tidak'], array(
                                'empty' => '-- Pilih --',
                            )),
                            'htmlOptions' => array(
                                'style' => 'text-align: center;',
                            ),

                        ),
                        array(
                            'header' => 'Inventarisasi Penyesuaian Berkurang',
                            'type' => "raw",
                            'value' => '$data->isstokopnameberkurang ? "<i class=\"entypo-check\"></i>" : ""',
                            'filter' => CHtml::activeDropDownList($model, 'isstokopnameberkurang', [1 => 'Ya', 2 => 'Tidak'], array(
                                'empty' => '-- Pilih --',
                            )),
                            'htmlOptions' => array(
                                'style' => 'text-align: center;',
                            ),
                        ),
                        array(
                            'header' => 'Inventarisasi Penyesuaian Bertambah',
                            'type' => "raw",
                            'value' => '$data->isstokopnamebertambah ? "<i class=\"entypo-check\"></i>" : ""',
                            'filter' => CHtml::activeDropDownList($model, 'isstokopnamebertambah', [1 => 'Ya', 2 => 'Tidak'], array(
                                'empty' => '-- Pilih --',
                            )),
                            'htmlOptions' => array(
                                'style' => 'text-align: center;',
                            ),
                        ),
                        array(
                            'name' => 'ismutasi',
                            'type' => "raw",
                            'value' => '$data->ismutasi ? "<i class=\"entypo-check\"></i>" : ""',
                            'filter' => CHtml::activeDropDownList($model, 'ismutasi', [1 => 'Ya', 2 => 'Tidak'], array(
                                'empty' => '-- Pilih --',
                            )),
                            'htmlOptions' => array(
                                'style' => 'text-align: center;',
                            ),
                        ),
                        array(
                            'name' => 'ispemakaian',
                            'type' => "raw",
                            'value' => '$data->ispemakaian ? "<i class=\"entypo-check\"></i>" : ""',
                            'filter' => CHtml::activeDropDownList($model, 'ispemakaian', [1 => 'Ya', 2 => 'Tidak'], array(
                                'empty' => '-- Pilih --',
                            )),
                            'htmlOptions' => array(
                                'style' => 'text-align: center;',
                            ),

                        ),

                        array(
                            'header' => 'Ubah',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{update}',
                        ),
                        array(
                            'header' => 'Hapus',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                            'template' => '{remove} {delete}',
                            'buttons' => array(
                                'remove' => array(
                                    'label' => "<i class='icon-form-silang'></i>",
                                    'options' => array('title' => Yii::t('mds', 'Remove Temporary')),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/nonActive",array("id"=>$data->jenisbarangrek_id))',
                                    'click' => 'function(){nonActive(this);return false;}',
                                ),
                            )
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){
                        jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                        $("table").find("input,select").each(function(){
                            cekForm(this);
                        })
                    }',
                )); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Jurnal Rekening Jenis Barang', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah jurnal rekening jenis barang', 'class' => 'btn btn-danger',)
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $this->widget('UserTips', array('content' => ''));
            // $urlPrint= $this->createUrl('print');
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
            $url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);

            $js = <<< JSCRIPT
function cekForm(obj)
{
    $("#jenisbarangrek-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#jenisbarangrek-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
        </div>
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
                            $.fn.yiiGridView.update('jenisbarangrek-m-grid');
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