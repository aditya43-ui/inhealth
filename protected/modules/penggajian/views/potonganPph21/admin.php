<?php
$this->breadcrumbs = array(
    'Gjpotonganpph21 Ms' => array('index'),
    'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('gjpotonganpph21-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="white-container">
    <legend class="rim2">Pengaturan <b>Potongan PPh 21</b></legend>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="entypo-search"></i>')), '#', array('class' => 'search-button btn')); ?>
    <div class="cari-lanjut search-form">
        <?php $this->renderPartial('_search', array(
            'model' => $model,
        )); ?>
    </div>
    <!--search-form-->
    <div class="block-tabel">
        <h6 class="rim2">Tabel Potongan PPh 21</h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'gjpotonganpph21-m-grid',
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
                //			'potonganpph21_id',
                'penghasilandari',
                'sampaidgn_thn',
                'persentarifpenghsl',
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
                    'header' => Yii::t('zii', 'Delete'),
                    'class' => 'bootstrap.widgets.BootButtonColumn',
                    'template' => '{delete}',
                    'buttons' => array(
                        //					'remove' => array (
                        //							'label'=>"<i class='icon-form-silang'></i>",
                        //							'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
                        //							'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/nonActive",array("id"=>$data->potonganpph21_id))',
                        //							'click'=>'function(){nonActive(this);return false;}',
                        //							'visible'=>'Yii::app()->controller->checkAccess(array("action"=>"nonActive"))',
                        //					),
                        'delete' => array(
                            'visible' => 'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
                        ),
                    )
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        )); ?>
    </div>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Tambah Potongan PPh 21', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
        $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])),
        array('title' => 'Tambah Potongan PPh 21', 'class' => 'btn btn-danger',)
    );
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
    echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
    $this->widget('UserTips', array('content' => ''));
    $urlPrint = $this->createUrl('print');
    $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#gjpotonganpph21-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
    ?>
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
                            $.fn.yiiGridView.update('gjpotonganpph21-m-grid');
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