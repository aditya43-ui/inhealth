<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Bahan Menu Diet</b>
        </div>
    </div>
    <div class="panel-body">
        <?php //echo $this->renderPartial('_tabMenu',array()); 
        ?>
        <!--<div class="biru">
            <div class="white">-->
        <?php
        $this->breadcrumbs = array(
            'Gzbahanmenudiet Ms' => array('index'),
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
                $('#menudiet').focus();
                    return false;
            });
            $('.search-form form').submit(function(){
                    $.fn.yiiGridView.update('bahan-menu-diet-m-grid', {
                            data: $(this).serialize()
                    });
                    return false;
            });
            ");

        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form">
            <?php
            $this->renderPartial('_search', array(
                'model' => $model,
            ));
            ?>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Bahan Menu Diet</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'bahan-menu-diet-m-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'itemsCssClass' => 'table table-condensed table-striped table-bordered',
                    'template' => "{summary}{items}\n{pager}",
                    'columns' => array(
                        array(
                            'header' => 'ID',
                            'value' => '$data->bahanmenudiet_id',
                        ),
                        array(
                            'header' => 'Nama Menu Diet',
                            'name' => 'menudiet_id',
                            'type' => 'raw',
                            'filter' => CHtml::dropDownList('BahanMenuDietM[menudiet_id]', $model->menudiet_id, Chtml::listData($model->getMenuDietItems(), 'menudiet_id', 'menudiet_nama'), array('empty' => '-- Pilih --')),
                            'value' => 'empty($data->menudiet->menudiet_nama)?"-":$data->menudiet->menudiet_nama',
                        ),
                        array(
                            'header' => 'Nama Bahan Makanan',
                            'name' => 'bahanmakanan_id',
                            'filter' => CHtml::dropDownList('BahanMenuDietM[bahanmakanan_id]', $model->bahanmakanan_id, CHtml::listData($model->getBahanMakananItems(), 'bahanmakanan_id', 'namabahanmakanan'), array('empty' => '-- Pilih --')),
                            'value' => '$data->bahanmakanan->namabahanmakanan',
                        ),
                        'jmlbahan',
                        array(
                            'header' => 'Lihat',
                            'class' => 'ext.bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(
                                    'options' => array('rel' => 'tooltip', 'title' => 'Lihat bahan menu diet'),
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Ubah',
                            'class' => 'ext.bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{update}',
                            'buttons' => array(
                                'update' => array(
                                    'options' => array('rel' => 'tooltip', 'title' => 'Ubah bahan menu diet'),
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Hapus',
                            'class' => 'ext.bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{delete}',
                            'buttons' => array(
                                'delete' => array(
                                    'options' => array('rel' => 'tooltip', 'title' => 'Hapus bahan menu diet'),
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
                ));
                ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Bahan Menu Diet', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl('bahanMenuDietM/create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah bahan menu diet', 'class' => 'btn btn-danger',)
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial('../tips/master2', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');

            $js = <<< JSCRIPT
        
         function cekForm(obj)
{
    $("#gzbahanmenudiet-m-search :input[name='"+ obj.name +"']").val(obj.value);
}     
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#gzbahanmenudiet-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>

            <script>
                $(document).ready(function() {
                    $("input[name='BahanMenuDietM[jmlbahan]']").focus();
                });
            </script>
        </div>
    </div>
</div>