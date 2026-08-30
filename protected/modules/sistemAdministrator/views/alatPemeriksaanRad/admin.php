<?php
$this->breadcrumbs = array(
    'Sapemeriksaanalatrad Ms' => array('index'),
    'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('sapemeriksaanmapalatrad-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
$this->widget('bootstrap.widgets.BootAlert');
?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Alat Pemeriksaan Radiologi
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
                    <i class="entypo-credit-card"></i> Tabel <b>Alat Pemeriksaan Radiologi</b>
                </div>
            </div>
            <div class="panel-body">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'sapemeriksaanmapalatrad-m-grid',
                    'dataProvider' => $model->searchTabel(),
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
                        //		array(
                        //			'header'=>'ID',
                        //			'name'=>'pemeriksaanalatrad_id',
                        //                        'value'=>function($data){
                        //                                if(!empty($data->pemeriksaanalatrad->pemeriksaanalatrad_id)){
                        //                                   return $data->pemeriksaanalatrad->pemeriksaanalatrad_id;
                        //                                }
                        //                        },
                        //			'filter'=>false,
                        //			),
                        array(
                            'header' => 'Alat Pemeriksaan Rad.',
                            'name' => 'pemeriksaanalatrad_nama',
                            'value' => function ($data) {
                                if (!empty($data->pemeriksaanalatrad->pemeriksaanalatrad_nama)) {
                                    return $data->pemeriksaanalatrad->pemeriksaanalatrad_nama;
                                }
                            },
                            'filter' => CHtml::activeTextField($model, 'pemeriksaanalatrad_nama'),
                        ),
                        array(
                            'header' => 'Nama Pemeriksaan Detail',
                            'name' => 'pemeriksaanrad_nama',
                            'value' => function ($data) {
                                if (!empty($data->pemeriksaanrad->pemeriksaanrad_nama)) {
                                    return $data->pemeriksaanrad->pemeriksaanrad_nama;
                                }
                            },
                            'filter' => CHtml::activeTextField($model, 'pemeriksaanrad_nama'),
                        ),
                        array(
                            'header' => 'Daftar Tindakan',
                            'name' => 'daftartindakan_nama',
                            'value' => function ($data) {
                                if (!empty($data->pemeriksaanrad->daftartindakan->daftartindakan_nama)) {
                                    return $data->pemeriksaanrad->daftartindakan->daftartindakan_nama;
                                }
                            },
                            'filter' => false,
                        ),
                        array(
                            'header' => 'Jenis Pemeriksaan',
                            'name' => 'jenispemeriksaanrad_nama',
                            'value' => function ($data) {
                                if (!empty($data->pemeriksaanrad->jenispemeriksaanrad->jenispemeriksaanrad_nama)) {
                                    return $data->pemeriksaanrad->jenispemeriksaanrad->jenispemeriksaanrad_nama;
                                }
                            },
                            'filter' => false,
                        ),

                        /*
		'pemeriksaanalatrad_aktif',
		*/
                        /**array(
				'header'=>Yii::t('zii','View'),
				'class'=>'bootstrap.widgets.BootButtonColumn',
				'template'=>'{view}',
				'buttons'=>array(
					'view' => array(),
				 ),
			),
			array(
				'header'=>Yii::t('zii','Update'),
				'class'=>'bootstrap.widgets.BootButtonColumn',
				'template'=>'{update}',
				'buttons'=>array(
					'update' => array(
							'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
					),
				 ),
			),
                         * 
                         */
                        array(
                            'header' => 'Hapus',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{delete}',
                            'buttons' => array(
                                /*'remove' => array (
							'label'=>"<i class='icon-form-silang'></i>",
							'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
							'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/nonActive",array("id"=>$data->pemeriksaanalatrad_id))',
							'click'=>'function(){nonActive(this);return false;}',
							'visible'=>'Yii::app()->controller->checkAccess(array("action"=>"nonActive"))',
					),
					 * 
					 */
                                'delete' => array(
                                    'visible' => 'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
                                ),
                            )
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){
                jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                $("table").find("input[type=text]").each(function(){
                    cekForm(this);
                })            
             }',
                )); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Pemeriksaan', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah pemeriksaan', 'class' => 'btn btn-danger',)
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));

            $tips = array(
                '0' => 'pencarianlanjut',
                '1' => 'cari2',
                '2' => 'print',
            );
            $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));

            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
            $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);
            //$urlPrint= $this->createUrl('print');

            $js = <<< JSCRIPT
function cekForm(obj)
{
    $("#sapemeriksaanmapalatrad-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#sapemeriksaanmapalatrad-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
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
                            $.fn.yiiGridView.update('sapemeriksaanalatrad-m-grid');
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