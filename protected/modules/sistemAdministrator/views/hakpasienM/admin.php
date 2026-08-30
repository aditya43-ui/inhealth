<?php
$this->breadcrumbs = array(
    'Hak dan Kewajiban Pasien' => array('admin'),
    'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('sahakkewajiban-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Pengaturan <b>Hak dan Kewajiban Pasien</b>
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
        <?php
        $listKel = LookupM::getItems('kelompokhakpasien');

        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'sahakkewajiban-m-grid',
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
                    'name' => 'kelompok',
                    'value' => function ($data) use ($listKel) {
                        return empty($listKel[$data->kelompok]) ? "-" : $listKel[$data->kelompok];
                    },
                    'filter' => CHtml::activeDropDownList($model, 'kelompok', LookupM::getItems('kelompokhakpasien'), array(
                        'empty' => '-- Pilih --'
                    )),
                ),
                'hakpasien_nama',
                'hakpasien_urutan',
                array(
                    'header' => 'Status',
                    'type' => 'raw',
                    'name' => 'hakpasien_aktif',
                    'filter' => false,
                    'value' => '$data->hakpasien_aktif ? "Aktif" : "Tidak Aktif"',
                    'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                ),
                /*
            'create_loginpemakai_id',
            'update_loginpemakai_id',
            'create_ruangan',
            */
                array(
                    'header' => Yii::t('zii', 'View'),
                    'class' => 'bootstrap.widgets.BootButtonColumn',
                    'template' => '{view}',
                    'buttons' => array(
                        'view' => array(),
                    ),
                    'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                ),
                array(
                    'header' => Yii::t('zii', 'Update'),
                    'class' => 'bootstrap.widgets.BootButtonColumn',
                    'template' => '{update}',
                    'buttons' => array(
                        'update' => array(
                            //'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                        ),
                    ),
                    'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                ),
                array(
                    'header' => Yii::t('zii', 'Delete'),
                    'class' => 'bootstrap.widgets.BootButtonColumn',
                    'template' => '{remove} {delete}',
                    'buttons' => array(
                        'remove' => array(
                            'label' => "<i class='icon-form-silang'></i>",
                            'options' => array('title' => Yii::t('mds', 'Remove Temporary')),
                            'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/nonActive",array("id"=>$data->hakpasien_id))',
                            'click' => 'function(){nonActive(this);return false;}',
                            //'visible'=>'Yii::app()->controller->checkAccess(array("action"=>"nonActive"))',
                        ),
                        'delete' => array(
                            //'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
                        ),
                    ),
                    'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        )); ?>


        <?php
        echo CHtml::link(
            Yii::t('mds', '{icon} Tambah Hak dan Kewajiban Pasien', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
            $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])),
            array('placeholder' => 'Tambah Hak dan Kewajiban Pasien', 'class' => 'btn btn-danger')
        );
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
        echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
      $this->widget('UserTips', array('content' => ''));
      $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
      $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
      $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');

        $js = <<< JSCRIPT
        function cekForm(obj){
            $("#sahakkewajiban-m-search :input[name='"+ obj.name +"']").val(obj.value);
            }
            function print(caraPrint){
            window.open("${urlPrint}/"+$('#sahakkewajiban-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
            }
JSCRIPT;
        Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
        ?>
    </div>
</div>
<script type="text/javascript">
    function nonActive(obj) {
        myConfirm("Yakin akan menonaktifkan data ini untuk sementara?", "Perhatian!",
            function(r) {
                if (r) {
                    $.ajax({
                        type: 'GET',
                        url: obj.href,
                        data: {}, //
                        dataType: "json",
                        success: function(data) {
                            $.fn.yiiGridView.update('hakpasien-m-grid');
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