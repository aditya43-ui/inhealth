<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Keluhan Anamnesis</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Rmkeluhananamnesis Ms' => array('index'),
            'Manage',
        );

        $arrMenu = array();
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Keluhan Anamnesis ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' RKKeluhananamnesisM', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Keluhan Anamnesis', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

        $this->menu = $arrMenu;

        Yii::app()->clientScript->registerScript('search', "
                $('.search-button').click(function(){
                        $('.search-form').toggle();
                    $('#RKKeluhananamnesisM_keluhananamnesis_nama').focus();
                        return false;
                });
                $('.search-form form').submit(function(){
                        $.fn.yiiGridView.update('rmkeluhananamnesis-m-grid', {
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
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Keluhan Anamnesis</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'rmkeluhananamnesis-m-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        ////'keluhananamnesis_id',
                        array(
                            'header' => 'ID',
                            'value' => '$data->keluhananamnesis_id',
                            'filter' => false,
                        ),
                        'keluhananamnesis_nama',
                        array(
                            'header' => 'Lihat',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(
                                    'options' => array('rel' => 'tooltip', 'title' => 'Lihat keluhan anamnesis'),
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Ubah',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{update}',
                            'buttons' => array(
                                'update' => array(
                                    'visible' => 'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                    'options' => array('rel' => 'tooltip', 'title' => 'Ubah keluhan anamnesis'),
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Hapus',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{delete}',
                            'buttons' => array(
                                'remove' => array(
                                    'label' => "<i class='icon-form-silang'></i>",
                                    'options' => array('rel' => 'tooltip', 'title' => 'Menonaktifkan keluhan anamnesis'),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/removeTemporary",array("id"=>"$data->keluhananamnesis_id"))',
                                    //'visible'=>'($data->kabupaten_aktif && Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ? TRUE : FALSE',
                                    'click' => 'function(){return confirm("' . Yii::t("mds", "Do You want to remove this item temporary?") . '");}',
                                ),
                                'delete' => array(
                                    // 'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
                                    'options' => array('rel' => 'tooltip', 'title' => 'Hapus keluhan anamnesis'),
                                ),
                            )
                        ),
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
        </div>
        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Keluhan Anamnesis', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl('keluhananamnesisM/create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah keluhan anamnesis', 'class' => 'btn btn-danger',)
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial('../tips/master2', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>

        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');

        $js = <<< JSCRIPT
                function cekForm(obj){
                    $("#rmkeluhananamnesis-m-search :input[name='"+ obj.name +"']").val(obj.value);
                }
                function print(caraPrint){
                    window.open("${urlPrint}/"+$('#rmkeluhananamnesis-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
                }
JSCRIPT;
        Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
        ?>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("input[name='RKKeluhananamnesisM[keluhananamnesis_nama]']").focus();
    });
</script>