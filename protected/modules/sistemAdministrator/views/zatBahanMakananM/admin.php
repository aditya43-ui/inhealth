<div class="white-container">
    <legend class="rim2">Pengaturan Zat <b>Bahan Makanan</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sazatbahanmakanan Ms'=>array('index'),
            'Manage',
    );
    $arrMenu = array();
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Zat Makanan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Zat Makanan', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE))?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Zat Makanan', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

    $this->menu=$arrMenu;

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('sazatbahanmakanan-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
    <div class="cari-lanjut search-form">
        <?php $this->renderPartial('_search',array(
                'model'=>$model,
        )); ?>
    </div><!--search-form-->
    <div class="block-tabel">
        <h6>Tabel Zat <b>Bahan Makanan</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id'=>'zat-bahan-makanan-m-grid',
            'dataProvider'=>$model->search(),
            'filter'=>$model,
                    'itemsCssClass'=>'table table-bordered table-striped table-condensed',
                    'template'=>"{summary}{pager}\n{items}",
            'columns'=>array(
                    array(
                                        'header'=>'ID',
                                        'value'=>'$data->zatbahanmakan_id',
                                    ),
                    array(
                                        'name'=>'zatgizi_id',
                                        'filter'=> CHtml::listData($model->getZatgiziItems(), 'zatgizi_id','zatgizi_nama'),
                                        'value'=>'$data->zatgizi->zatgizi_nama',
                                    ),
                                    array(
                                        'name'=>'bahanmakanan_id',
                                        'filter'=>CHtml::listData($model->getBahanMakananItems(), 'bahanmakanan_id', 'namabahanmakanan'),
                                        'value'=>'$data->bahanmakanan->namabahanmakanan',
                                    ),
                    'kandunganbahan',
                                    array(
                                        'header'=>Yii::t('mds','View'),
                                        'class'=>'bootstrap.widgets.BootButtonColumn',
                                        'template'=>'{view}',
                                    ),
                                    array(
                                        'header'=>Yii::t('mds','Update'),
                                        'class'=>'bootstrap.widgets.BootButtonColumn',
                                        'template'=>'{update}',
                                    ),
                                    array(
                                        'header'=>'Hapus',
                                        'class'=>'bootstrap.widgets.BootButtonColumn',
                                        'template'=>'{delete}',
                                    ),
            ),
          'afterAjaxUpdate'=>'function(id, data){
                jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
                $("table").find("input[type=text]").each(function(){
                    cekForm(this);
                })
                 $("table").find("select").each(function(){
                    cekForm(this);
                })
            }',
        )); ?>
    </div>
    <?php 
    echo CHtml::link(Yii::t('mds', '{icon} Tambah Zat Makan', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
    $content = $this->renderPartial('../tips/master',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');

$js = <<< JSCRIPT
         function cekForm(obj)
{
    $("#sajenis-carabayar-m-search  :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#sajenis-carabayar-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
    ?>
</div>