<div class='white-container'>
    <legend class='rim2'>Pengaturan <b>Pelayanan Rekening</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Jenis Penjamin Alkes Ms'=>array('index'),
            'Manage',
    );

    $arrMenu = array();
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Pelayanan Rekening ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Pelayanan Rekening ', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

    $this->menu=$arrMenu;

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
        $('#PelayananrekM_ruanganNama').focus();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('pelayananrek-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
if(!empty($_GET['sukses'])){
	echo Yii::app()->user->setFlash('success',"Data berhasil disimpan!");
}
    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
    <div class="cari-lanjut search-form">
        <?php $this->renderPartial('_search',array(
            'model'=>$model,
        )); ?>
    </div><!--search-form-->
    <div class='block-tabel'>
        <!--<h6>Tabel <b>Pelayanan Rekening</b></h6>-->
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'pelayananrek-m-grid',
            'dataProvider'=>$model->searchPelayanan(),
            'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    array(
                        'header' => 'No.',
                        'value'=>'$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1',  
                    ),                
                    array(
                        'header'=>'Jenis Pelayanan',
                        'name'=>'jnspelayanan',
						'filter'=>CHtml::listData(LookupM::model()->findAllByAttributes(array('lookup_type'=>'jenispelayanan')), 'lookup_value', 'lookup_name'),
                        'value'=>'!empty($data->jnspelayanan)?$data->JenisPelayanan:" - "',  
                    ),
                    array(
                        'header'=>'Ruangan',
                        'name'=>'ruanganNama',
                        'value'=>'!empty($data->ruangan_id)?$data->ruangan->ruangan_nama:" - "',  
                    ),
                    array(
                        'header'=>'Nama Pelayanan',
                        'name'=>'daftartindakan_nama',
                        'value'=>'$data->daftartindakan->daftartindakan_nama',  
                    ),
                    array(
                        'header'=>'Rekening Debit',
                        'type'=>'raw',
                        'name'=>'rekDebit',
                        'value'=>'$this->grid->owner->renderPartial("_rekPelayananD",array("saldonormal"=>"D","ruangan_id"=>$data->ruangan_id,"daftartindakan_id"=>$data->daftartindakan_id),true)',
                    ),   
                     array(
                        'header'=>'Rekening Kredit',
                        'type'=>'raw',
                        'name'=>'rekKredit',
                        'value'=>'$this->grid->owner->renderPartial("_rekPelayananK",array("saldonormal"=>"K","ruangan_id"=>$data->ruangan_id,"daftartindakan_id"=>$data->daftartindakan_id),true)',
                    ), 

                           array(
                        'header'=>Yii::t('zii','View'),
                        'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{view}',
                        'buttons'=>array(
                                'view' => array (
                                        'label'=>"<i class='icon-view'></i>",
                                        'options'=>array('title'=>Yii::t('mds','View')),
                                        'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/view",array("id"=>"$data->daftartindakan_id", "ruangan_id"=>"$data->ruangan_id"))',

                                ),
                        ),
                    ),

                            array(
                        'header'=>Yii::t('zii','Delete'),
                        'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{delete}',
                        'buttons'=>array(                                        
                                 'delete' => array (
                                    'label'=>"<i class='icon-delete'></i>",
                                    'options'=>array('title'=>Yii::t('mds','Delete')),
                                    'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/delete",array("id"=>"$data->daftartindakan_id", "ruangan_id"=>"$data->ruangan_id"))',               
                                ),
                        )
                    ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <?php 
    echo CHtml::link(Yii::t('mds', '{icon} Tambah Pelayanan Rekening', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),
        array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 

    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),
        array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 

    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),
            array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
    ?>
    <?php
    $content = $this->renderPartial('../tips/master2',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
        
        
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#pelayananrek-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);    
    ?>
</div>
<?php 
// Dialog buat lihat penjualan resep =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogUbahRekeningDebitKredit',
    'options'=>array(
        'title'=>'Ubah Data Rekening',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>800,
        'minHeight'=>400,
        'resizable'=>false,
        'close'=>'js:function(){$.fn.yiiGridView.update(\'pelayananrek-m-grid\',{})}'
    ),
));
?>
<iframe src="" name="iframeEditRekeningDebitKredit" width="100%" height="300"></iframe>
<?php $this->endWidget(); ?>