<div class="white-container">
    <legend class="rim2">Pengaturan <b>Jadwal Makan</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sajadwalmakan Ms'=>array('index'),
            'Manage',
    );
    $arrMenu = array();
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jadwal Makan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Jadwal Makan', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE))?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Jadwal Makan', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

    $this->menu=$arrMenu;

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('jadwalmakan-m-grid', {
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
        <h6>Tabel <b>Jadwal Makan</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id'=>'jadwalmakan-m-grid',
            'dataProvider'=>$model->search(),
            'filter'=>$model,
                    'itemsCssClass'=>'table table-bordered table-striped table-condensed',
                    'template'=>"{summary}{pager}\n{items}",
            'columns'=>array(
                    array(
                                        'name'=>'jenisdiet_id',
                                        'filter'=>CHtml::listData($model->getJenisdietItems(), 'jenisdiet_id','jenisdiet_nama'),
                                        'value'=>'$data->jenisdiet->jenisdiet_nama',
                                    ),
                                    array(
                                        'name'=>'tipediet_id',
                                        'filter'=>CHtml::listData($model->getTipeDietItems(), 'tipediet_id','tipediet_nama'),
                                        'value'=>'$data->tipediet->tipediet_nama',
                                    ),
                    array(
                                        'name'=>'jeniswaktu_id',
                                        'filter'=>CHtml::listData($model->getJenisWaktuItems(), 'jeniswaktu_id','jeniswaktu_nama'),
                                        'value'=>'$data->jeniswaktu->jeniswaktu_nama',
                                    ),
                    array(
                                        'name'=>'menudiet_id',
                                        'filter'=>CHtml::listData($model->getMenuDietItems(),'menudiet_id','menudiet_nama'),
                                        'value'=>'$data->menudiet->menudiet_nama',
                                    ),
                                    array(
                                        'header'=>Yii::t('mds','View'),
                                        'class'=>'ext.bootstrap.widgets.BootButtonColumn',
                                        'template'=>'{view}',
                                    ),
                                    array(
                                        'header'=>Yii::t('mds','Update'),
                                        'class'=>'ext.bootstrap.widgets.BootButtonColumn',
                                        'template'=>'{update}',
                                    ),
                                    array(
                                        'header'=>'Hapus',
                                        'class'=>'ext.bootstrap.widgets.BootButtonColumn',
                                        'template'=>'{delete}',
                                    )
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
    echo CHtml::link(Yii::t('mds', '{icon} Tambah Jadwal Makan', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
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
    $("#sajadwalmakanan-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#sajadwalmakanan-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
    ?>
</div>