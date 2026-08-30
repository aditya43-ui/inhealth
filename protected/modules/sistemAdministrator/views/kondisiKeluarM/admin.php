<?php
$this->breadcrumbs = array(
    'Kondisi Keluar Ms' => array('index'),
    'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('kondisi-keluar-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php if (!$this->isFrame) : ?>
    <legend class="rim2">Pengaturan Kondisi Keluar</legend>
<?php else : ?>
    <legend class='rim'>Pengaturan Kondisi Keluar</legend>
<?php endif; ?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="entypo-search"></i>')), '#', array('class' => 'search-button btn')); ?>
<div class="cari-lanjut search-form">
    <?php $this->renderPartial($this->path_view . '_search', array(
        'model' => $model,
    )); ?>
</div>
<!--search-form-->
<!--<legend class='rim'>Tabel Kondisi Keluar</legend>-->
<?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'kondisi-keluar-m-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'No.',
            'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:right;'),
        ),
        ////'kondisikeluar_id',
        array(
            'header' => 'ID',
            'name' => 'kondisikeluar_id',
            'value' => '$data->kondisikeluar_id',
            'filter' => false,
        ),

        'kondisikeluar_nama',
        'kondisikeluar_namalain',
        'carakeluar.carakeluar_nama',
        // 'kondisikeluar_aktif',
        array(
            'header' => 'Status',
            'value' => '($data->kondisikeluar_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
            'htmlOptions' => array('style' => 'text-align:center;'),
        ),
        array(
            'header' => Yii::t('zii', 'View'),
            'class' => 'bootstrap.widgets.BootButtonColumn',
            'template' => '{view}',
            'buttons' => array(
                'view' => array(),
            ),
            'htmlOptions' => array('style' => 'text-align: center; '),
        ),
        array(
            'header' => Yii::t('zii', 'Update'),
            'class' => 'bootstrap.widgets.BootButtonColumn',
            'template' => '{update}',
            'buttons' => array(
                'update' => array(),
            ),
            'htmlOptions' => array('style' => 'text-align: center; '),
        ),
        array(
            'header' => Yii::t('zii', 'Delete'),
            'class' => 'bootstrap.widgets.BootButtonColumn',
            'template' => '{remove}{add} {delete}',
            'buttons' => array(
                /*'remove' => array (
                                                'label'=>"<i class='icon-form-silang'></i>",
                                                'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
                                                'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/nonActive",array("id"=>"$data->kondisikeluar_id"))',
                                                'click'=>'function(){return confirm("'.Yii::t("mds","Do You want to remove this item temporary?").'");}',
                                                'visible'=>'$data->kondisikeluar_aktif',
                                        ),*/
                'remove' => array(
                    'label' => "<i class='icon-form-silang'></i>",
                    'options' => array('title' => Yii::t('mds', 'Remove Temporary')),
                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/nonActive",array("id"=>$data->kondisikeluar_id))',
                    'click' => 'function(){nonActive(this);return false;}',
                    'visible' => '(($data->kondisikeluar_aktif)? TRUE : FALSE)'
                ),
                'add' => array(
                    'label' => "<i class='icon-form-check'></i>",
                    'options' => array('title' => Yii::t('mds', 'Add Temporary')),
                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/active",array("id"=>$data->kondisikeluar_id))',
                    'click' => 'function(){active(this);return false;}',
                    'visible' => '(($data->kondisikeluar_aktif)? FALSE : TRUE)'
                ),
                'delete' => array(),
            ),
            'htmlOptions' => array('style' => 'text-align: center; '),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
)); ?>

<?php

echo CHtml::link(Yii::t('mds', '{icon} Tambah Kondisi Keluar', array('{icon}' => '<i class="icon-plus icon-white"></i>')), $this->createUrl($this->id . '/create', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
$content = $this->renderPartial($this->path_view . '/tips/master', array(), true);
$this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#kondisi-keluar-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>
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
                            $.fn.yiiGridView.update('kondisi-keluar-m-grid');
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

    function active(obj) {
        myConfirm("Anda yakin akan mengaktifkan data ini untuk sementara?", "Perhatian!",
            function(r) {
                if (r) {
                    $.ajax({
                        type: 'GET',
                        url: obj.href,
                        data: {}, //
                        dataType: "json",
                        success: function(data) {
                            $.fn.yiiGridView.update('kondisi-keluar-m-grid');
                            if (data.sukses > 0) {} else {
                                myAlert('Data gagal diaktifkan!');
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            myAlert('Data gagal diaktifkan!');
                            console.log(errorThrown);
                        }
                    });
                }
            }
        );
        return false;
    }
</script>