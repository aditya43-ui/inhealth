<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Jadwal Makanan</b>
        </div>
    </div>
    <div class="panel-body">
        <!--<div class="white-container">
            <legend class="rim2">Pengaturan <b>Jaswal Makan</b></legend>-->
        <?php //$this->renderPartial('_tabMenu',array()); 
        ?>
        <!--<div class="biru">
            <div class="white">-->
        <?php
        $this->breadcrumbs = array(
            'Gzjadwalmakan Ms' => array('index'),
            'Manage',
        );
        $arrMenu = array();
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jadwal Makan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Jadwal Makan', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE))?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Jadwal Makan', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

        $this->menu = $arrMenu;

        Yii::app()->clientScript->registerScript('search', "
            $('.search-button').click(function(){
                    $('.search-form').toggle();
                    return false;
            });
            $('.search-form form').submit(function(){
                    $.fn.yiiGridView.update('jadwal-makan-m-grid', {
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
        <!--search-form-->

        <!--<h6>Tabel <b>Jadwal Makan</b></h6>-->
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Jadwal Makanan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'jadwal-makan-m-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'itemsCssClass' => 'table table-condensed table-striped',
                    'template' => "{summary}\n{items}{pager}",
                    'columns' => array(
                        array(
                            'name' => 'jenisdiet_id',
                            'filter' => CHtml::dropDownList('JadwalMakanM[jenisdiet_id]', $model->jenisdiet_id, CHtml::listData($model->getJenisdietItems(), 'jenisdiet_id', 'jenisdiet_nama'), array('empty' => '-- Pilih --')),
                            'value' => '$data->jenisdiet->jenisdiet_nama',
                        ),
                        array(
                            'name' => 'tipediet_id',
                            'filter' => CHtml::dropDownList('JadwalMakanM[tipediet_id]', $model->tipediet_id, CHtml::listData($model->getTipeDietItems(), 'tipediet_id', 'tipediet_nama'), array('empty' => '-- Pilih --')),
                            'value' => '$data->tipediet->tipediet_nama',
                        ),
                        array(
                            'name' => 'jeniswaktu_id',
                            'filter' => CHtml::dropDownList('JadwalMakanM[jeniswaktu_id]', $model->jeniswaktu_id, CHtml::listData($model->getJenisWaktuItems(), 'jeniswaktu_id', 'jeniswaktu_nama'), array('empty' => '-- Pilih --')),
                            'value' => '$data->jeniswaktu->jeniswaktu_nama',
                        ),
                        array(
                            'name' => 'menudiet_id',
                            'filter' => CHtml::dropDownList('JadwalMakanM[menudiet_id]', $model->menudiet_id, CHtml::listData($model->getMenuDietItems(), 'menudiet_id', 'menudiet_nama'), array('empty' => '-- Pilih --')),
                            'value' => '$data->menudiet->menudiet_nama',
                        ),
                        array(
                            'header' => Yii::t('mds', 'View'),
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'class' => 'ext.bootstrap.widgets.BootButtonColumn',
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(
                                    'options' => array('rel' => 'tooltip', 'title' => 'Lihat jadwal makan'),
                                ),
                            ),
                        ),
                        array(
                            'header' => Yii::t('mds', 'Update'),
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'class' => 'ext.bootstrap.widgets.BootButtonColumn',
                            'template' => '{update}',
                            'buttons' => array(
                                'update' => array(
                                    'options' => array('rel' => 'tooltip', 'title' => 'Ubah jadwal makan'),
                                ),
                            )
                        ),
                        array(
                            'header' => 'Hapus',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'class' => 'ext.bootstrap.widgets.BootButtonColumn',
                            'template' => '{delete}',
                            'buttons' => array(
                                'delete' => array(
                                    'options' => array('rel' => 'tooltip', 'title' => 'Hapus jadwal makan'),
                                ),
                            )
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
                Yii::t('mds', '{icon} Tambah Jadwal Makan', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl('jadwalMakanM/create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah jadwal makan', 'class' => 'btn btn-danger',)
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
    $("#gzjadwalmakanan-m-search :input[name='"+ obj.name +"']").val(obj.value);
}     
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#gzjadwalmakanan-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
        </div>
    </div>
</div>