<?php
$this->breadcrumbs = array(
    'Biaya Lembur',
);

$this->menu = array(
    array('label' => 'List BiayalemburM', 'url' => array('index')),
    array('label' => 'Create BiayalemburM', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('biayalembur-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Master <b>Biaya Lembur</b>
        </div>
    </div>
    <div class="panel-body">
        <?php /* echo CHtml::link('Pencarian Lanjut','#',array('class'=>'search-button btn')); ?>
        <div class="cari-lanjut search-form">
        <?php $this->renderPartial('_search',array(
            'model'=>$model,
        )); ?>
        </div>
         * 
         */ ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Biaya Lembur</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'biayalembur-m-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped datatable',
                    'columns' => array(
                        // 'biayalembur_id',
                        array(
                            'name' => 'biayalembur_nama',
                            'header' => 'Nama',
                        ),
                        array(
                            'header' => 'Biaya Normal per Jam (Rp)',
                            'name' => 'biayalembur_nilai',
                            'filter' => false,
                            'value' => 'MyFormatter::formatNumberForPrint($data->biayalembur_nilai)',
                            'htmlOptions' => array(
                                'style' => 'text-align: right;'
                            ),
                        ),
                        array(
                            'header' => 'Biaya Libur per Jam (Rp)',
                            'name' => 'biayalembur_nilailibur',
                            'filter' => false,
                            'value' => 'MyFormatter::formatNumberForPrint($data->biayalembur_nilailibur)',
                            'htmlOptions' => array(
                                'style' => 'text-align: right;'
                            ),
                        ),
                        array(
                            'name' => 'biayalembur_aktif',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return $data->biayalembur_aktif ? 'Aktif' : 'Tidak Aktif';
                            },
                            'filter' => CHtml::activeDropDownList($model, 'biayalembur_aktif', array(
                                '0' => 'Ya',
                                '1' => 'Tidak',
                            ), array('empty' => '-- Pilih --')),
                        ),
                        //'create_time',
                        //'update_time',
                        /*
                        'create_loginpemakai_id',
                        'update_loginpemakai_id',
                        'create_ruangan',
                        */
                        array(
                            'header' => 'Lihat',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{view}',
                        ),
                        array(
                            'header' => 'Ubah',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{update}',
                        ),
                        array(
                            'header' => 'Hapus',
                            'type' => 'raw',
                            'value' => '($data->biayalembur_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->biayalembur_id)",array("id"=>"$data->biayalembur_id","rel"=>"tooltip","title"=>"Menonaktifkan"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->biayalembur_id)",array("id"=>"$data->biayalembur_id","rel"=>"tooltip","title"=>"Hapus")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->biayalembur_id)",array("id"=>"$data->biayalembur_id","rel"=>"tooltip","title"=>"Hapus"));',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),
                    ),
                )); ?>

            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Biaya Lembur', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah biaya lembur', 'class' => 'btn btn-danger',)
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial('../tips/master', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
            $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);

            $js = <<< JSCRIPT
         function cekForm(obj)
{
    $("#sainstalasi-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(obj)
{
    window.open("${urlPrint}/"+$('#sainstalasi-m-search').serialize()+"&caraPrint="+obj,"",'location=_new, width=900px');
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
        </div>
    </div>
</div>