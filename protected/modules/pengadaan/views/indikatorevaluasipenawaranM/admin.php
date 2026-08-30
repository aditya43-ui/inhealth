<?php
$this->breadcrumbs = array(
    'Indikatorevaluasipenawaran Ms' => array('index'),
    'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('indikatorevaluasipenawaran-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="white-container">
    <div class="panel panel-success">
        <div class="panel panel-heading">
            <div class="panel-title"> Pengaturan <b> Indikator Evaluasi Penawaran </b> </div>
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
                    'id' => 'indikatorevaluasipenawaran-m-grid',
                    'dataProvider' => $model->search(),
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
                            'header' => 'Jenis Pengadaan',
                            'name' => 'jenispengadaan_id',
                            'value' => '$data->jenispengadaan->jenispengadaan_nama',
                        ),
                        'evaluasipenawaran_jenis',
                        'evaluasipenawaran_nama',
                        'urutan',
                        array(
                            'header'=>'<center>Aktif</center>',
                            'value'=>'($data->indikatorevaluasipenawaran_aktif == TRUE ) ? "Aktif" : "Tidak Aktif"',
                            'htmlOptions'=>array('style'=>'text-align:center;'),
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
                            'header' => Yii::t('zii', 'Delete'),
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{remove} {delete}',
                            'buttons' => array(
                                'remove' => array (
                                    'label'=>"<i class='glyphicon glyphicon-remove'></i>",
                                    'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
                                    'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/nonActive",array("id"=>$data->indikatorevaluasipenawaran_id))',
                                    'click'=>'function(){nonActive(this);return false;}',
                                    'visible' => '($data->indikatorevaluasipenawaran_aktif)?true:false'
                                ),
                                'delete'=> array(),
                            )
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>
    </div>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Tambah Indikator Evaluasi Penawaran', array('{icon}' => '<i class="icon-plus icon-white"></i>')), $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')) . "&nbsp&nbsp";
    echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="icon-book icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PDF\')')) . "&nbsp&nbsp";
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="icon-pdf icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')) . "&nbsp&nbsp";
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp&nbsp";
    $this->widget('UserTips', array('content' => ''));
    $urlPrint = $this->createUrl('print');

    $js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#indikatorevaluasipenawaran-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
    ?></div>
<script type="text/javascript">
    function nonActive(obj){
        myConfirm("Yakin akan menonaktifkan data ini untuk sementara?","Perhatian!",
            function(r){
                if(r){ 
                    $.ajax({
                            type:'GET',
                            url:obj.href,
                            data: {},//
                            dataType: "json",
                            success:function(data){
                                    $.fn.yiiGridView.update('indikatorevaluasipenawaran-m-grid');
                                    if(data.sukses > 0){
                                    }else{
                                            myAlert('Data gagal dinonaktifkan!');
                                    }
                            },
                            error: function (jqXHR, textStatus, errorThrown) { myAlert('Data gagal dinonaktifkan!'); console.log(errorThrown);}
                    });
                }
            }
        );
        return false;
    }
	
    function active(obj){
        myConfirm("Yakin akan mengaktifkan data ini untuk sementara?","Perhatian!",
            function(r){
                if(r){ 
                    $.ajax({
                        type:'GET',
                        url:obj.href,
                        data: {},//
                        dataType: "json",
                        success:function(data){
                                $.fn.yiiGridView.update('indikatorevaluasipenawaran-m-grid');
                                if(data.sukses > 0){
                                }else{
                                    myAlert('Data gagal diaktifkan!');
                                }
                        },
                        error: function (jqXHR, textStatus, errorThrown) { myAlert('Data gagal diaktifkan!'); console.log(errorThrown);}
                    });
                }
            }
        );
        return false;
    }
</script>