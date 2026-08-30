<div class="white-container">
    <legend class="rim2">Pengaturan <b>Bahan Menu Diet</b></legend>
    <?php
    $this->breadcrumbs = array(
        'Sabahanmenudiet Ms' => array('index'),
        'Manage',
    );
    $arrMenu = array();
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Bahan Menu Diet ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Bahan Menu Diet', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE))?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Bahan Menu Diet', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

    $this->menu = $arrMenu;

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            $('#BahanMenuDietM_menudiet_id').focus();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('bahan-menu-diet-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
    <div class="cari-lanjut search-form">
        <?php $this->renderPartial('_search', array(
            'model' => $model,
        )); ?>
    </div>
    <!--search-form-->
    <div class="block-tabel">
        <h6>Tabel <b>Bahan Menu Diet</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'bahan-menu-diet-m-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'itemsCssClass' => 'table table-bordered table-condensed table-striped',
            'template' => "{summary}{pager}\n{items}",
            'columns' => array(
                array(
                    'header' => 'ID',
                    'value' => '$data->bahanmenudiet_id',
                ),
                array(
                    'name' => 'menudiet_nama',
                    'filter' => Chtml::listData($model->getMenuDietItems(), 'menudiet_id', 'menudiet_nama'),
                    'value' => '$data->menudiet->menudiet_nama',
                ),
                array(
                    'header' => 'Nama Bahan makanan',
                    'filter' => CHtml::listData($model->getBahanMakananItems(), 'bahanmakanan_id', 'namabahanmakanan'),
                    'value' => '$data->bahanmakanan->namabahanmakanan',
                ),
                'jmlbahan',
                array(
                    'header' => Yii::t('zii', 'View'),
                    'class' => 'ext.bootstrap.widgets.BootButtonColumn',
                    'template' => '{view}',
                    'buttons' => array(
                        'view' => array(
                            'options' => array('rel' => 'tooltip', 'title' => 'Lihat Bahan Menu Diet'),
                        ),
                    ),
                ),
                array(
                    'header' => Yii::t('zii', 'Update'),
                    'class' => 'ext.bootstrap.widgets.BootButtonColumn',
                    'template' => '{update}',
                    'buttons' => array(
                        'update' => array(
                            'options' => array('rel' => 'tooltip', 'title' => 'Ubah Bahan Menu Diet'),
                        ),
                    ),
                ),
                array(
                    'header' => 'Hapus',
                    'class' => 'ext.bootstrap.widgets.BootButtonColumn',
                    'template' => '{delete}',
                    'buttons' => array(
                        'delete' => array(
                            'options' => array('rel' => 'tooltip', 'title' => 'Hapus Bahan Menu Diet'),
                        ),
                    ),
                )
            ),
            'afterAjaxUpdate' => 'function(id, data){
                jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
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
    echo CHtml::link(Yii::t('mds', '{icon} Tambah Bahan Menu Diet', array('{icon}' => '<i class="icon-plus icon-white"></i>')), $this->createUrl('/sistemAdministrator/BahanMenuDietM/create', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
    echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
    $content = $this->renderPartial('../tips/master', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');

    $js = <<< JSCRIPT
         function cekForm(obj)
{
    $("#bahanmenudiet-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#bahanmenudiet-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
    ?>
</div>