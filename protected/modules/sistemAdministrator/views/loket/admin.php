<?php
$this->breadcrumbs = array(
    'Loket' => array('admin'),
    'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('saloket-m-grid', {
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
            <i class="fas fa-layer-group"></i> Pengaturan <b>Loket</b>
        </div>
    </div>
    <div class="panel-body">
        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form">
            <?php $this->renderPartial($this->path_view . '_search', array(
                'model' => $model,
            )); ?>
        </div>
        <!--search-form-->

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Loket</b>
                </div>
            </div>
            <div class="panel-body">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'saloket-m-grid',
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
                            'header' => 'No. Urut',
                            'name' => 'loket_nourut',
                            'type' => 'raw',
                        ),
                        // 'loket_nourut',
                        array(
                            'header' => 'Model Antrian',
                            'name' => 'modelantrian_id',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if (empty($data->modelantrian_id)) return "-";
                                $ma = ModelantrianM::model()->findByPk($data->modelantrian_id);

                                if (empty($ma)) return "-";
                                return $ma->modelantrian_nama;
                            },
                            'filter' => CHtml::activeDropDownList($model, 'modelantrian_id', CHtml::listData(ModelantrianM::model()->findAll('modelantrian_aktif = true order by modelantrian_nama'), 'modelantrian_id', 'modelantrian_nama'), array(
                                'empty' => '-- Pilih --'
                            )),
                        ),
                        'loket_nama',
                        'loket_namalain',
                        'loket_fungsi',
                        'loket_singkatan',
                        array(
                            'name' => 'bukaloketantrian',
                            'filter' => false,
                        ),
                        array(
                            'name' => 'estimasiantrian',
                            'filter' => false,
                        ),
                        array(
                            'header' => 'Status',
                            'value' => '($data->loket_aktif)?"Aktif":"Tidak Aktif"'
                        ),
                        /*
        'loket_formatnomor',
        'loket_maksantrian',
        'loket_aktif',
        'carabayar_id',
        'filesuara',
        'ispendaftaran',
        'iskasir',
        */

                        array(
                            'name' => 'ispendaftaran',
                            'header' => 'Pendaftaran',
                            'type' => 'raw',
                            'value' => '$data->ispendaftaran ? "<i class=\"glyphicon glyphicon-ok\"></i>" : "-"',
                            'htmlOptions' => array(
                                'style' => 'text-align: center;',
                            ),
                            'filter' => false,
                        ),
                        array(
                            'name' => 'ispendaftaran',
                            'header' => 'Kasir',
                            'type' => 'raw',
                            'value' => '$data->iskasir ? "<i class=\"glyphicon glyphicon-ok\"></i>" : "-"',
                            'htmlOptions' => array(
                                'style' => 'text-align: center;',
                            ),
                            'filter' => false,
                        ),
                        array(
                            'name' => 'is_penunjang',
                            'header' => 'Penunjang',
                            'type' => 'raw',
                            'value' => '$data->is_penunjang ? "<i class=\"glyphicon glyphicon-ok\"></i>" : "-"',
                            'htmlOptions' => array(
                                'style' => 'text-align: center;',
                            ),
                            'filter' => false,
                        ),
                        array(
                            'name' => 'is_farmasi',
                            'header' => 'Farmasi',
                            'type' => 'raw',
                            'value' => '$data->is_farmasi ? "<i class=\"glyphicon glyphicon-ok\"></i>" : "-"',
                            'htmlOptions' => array(
                                'style' => 'text-align: center;',
                            ),
                            'filter' => false,
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
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                            'template' => '{remove}{delete}',
                            'buttons' => array(
                                'remove' => array(
                                    'label' => "<i class='icon-form-silang'></i>",
                                    'options' => array('title' => Yii::t('mds', 'Remove Temporary')),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/nonActive",array("id"=>$data->loket_id))',
                                    'click' => 'function(){nonActive(this);return false;}',
                                    //'visible'=>'Yii::app()->controller->checkAccess(array("action"=>"nonActive"))',
                                    'visible' => '($data->loket_aktif)?true:false',
                                ),
                                'delete' => array(
                                    'visible' => 'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
                                ),
                            )
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Loket', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah loket', 'class' => 'btn btn-danger',)
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial($this->path_tips . 'master', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            $urlPrint = $this->createUrl('print');

            $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#saloket-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
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
                            $.fn.yiiGridView.update('saloket-m-grid');
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