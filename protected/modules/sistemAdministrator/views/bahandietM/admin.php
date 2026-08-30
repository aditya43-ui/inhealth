<div class="white-container">
    <legend class="rim2">Pengaturan <b>Bahan Diet</b></legend>
    <?php
    $this->breadcrumbs = array(
        'Sabahandiet Ms' => array('index'),
        'Manage',
    );
    $arrMenu = array();
    //                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Bahan Diet ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Bahan Diet', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE))?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Bahan Diet', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

    $this->menu = $arrMenu;

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            $('#BahandietM_bahandiet_nama').focus();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('bahan-diet-m-grid', {
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
    </div><!--search-form-->
    <div class="block-tabel">
        <h6>Tabel <b>Bahan Diet</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'bahan-diet-m-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'itemsCssClass' => 'table table-bordered table-condensed table-striped',
            'template' => "{summary}{pager}\n{items}",
            'columns' => array(
                array(
                    'header' => 'ID',
                    'value' => '$data->bahandiet_id',
                ),
                array(
                    'name' => 'bahandiet_nama',
                    'value' => '$data->bahandiet_nama',
                    'filter' => CHtml::activeTextField($model, 'bahandiet_nama')
                ),
                'bahandiet_namalain',
                array(
                    'header' => 'Status',
                    'value' => '($data->bahandiet_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                    'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                ),
                //		array(
                //                    'header'=>'Aktif',
                //                    'class'=>'CCheckBoxColumn',
                //                    'checked'=>'$data->bahandiet_aktif',
                //                ),
                array(
                    'header' => 'Lihat',
                    'class' => 'ext.bootstrap.widgets.BootButtonColumn',
                    'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                    'template' => '{view}',
                    'buttons' => array(
                        'view' => array(
                            'options' => array('rel' => 'tooltip', 'title' => 'Lihat Bahan Diet'),
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
                            'options' => array('rel' => 'tooltip', 'title' => 'Ubah Bahan Diet'),
                        ),
                    ),
                ),
                //                                array(
                //                                    'header'=>'Hapus',
                //                                    'class'=>'ext.bootstrap.widgets.BootButtonColumn',
                //                                    'template'=>'{delete}',
                //                                ),
                array(
                    'header' => 'Hapus',
                    'type' => 'raw',
                    'value' => '($data->bahandiet_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->bahandiet_id)",array("id"=>"$data->bahandiet_id","rel"=>"tooltip","title"=>"Menonaktifkan Bahan Diet"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->bahandiet_id)",array("id"=>"$data->bahandiet_id","rel"=>"tooltip","title"=>"Hapus Bahan Diet")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->bahandiet_id)",array("id"=>"$data->bahandiet_id","rel"=>"tooltip","title"=>"Hapus Bahan Diet"));',
                    'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
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
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Tambah Bahan Diet', array('{icon}' => '<i class="icon-plus icon-white"></i>')), $this->createUrl('/sistemAdministrator/BahandietM/create', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
    echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
    $content = $this->renderPartial('../tips/master', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
    $url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);

    $js = <<< JSCRIPT
         function cekForm(obj)
{
    $("#sabahandiet-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#sabahandiet-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
    ?>
</div>
<script type="text/javascript">
    function removeTemporary(id) {
        var url = '<?php echo $url . "/removeTemporary"; ?>';
        myConfirm("Anda yakin akan menonaktifkan data ini untuk sementara?", "Perhatian!", function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.status == 'proses_form') {
                            $.fn.yiiGridView.update('bahan-diet-m-grid');
                        } else {
                            myAlert('Data gagal dinonaktifkan!')
                        }
                    }, "json");
            }
        });
    }

    function deleteRecord(id) {
        var id = id;
        var url = '<?php echo $url . "/delete"; ?>';
        myConfirm("Yakin Akan Menghapus Data ini?", "Perhatian!", function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.status == 'proses_form') {
                            $.fn.yiiGridView.update('bahan-diet-m-grid');
                        } else {
                            myAlert('Data gagal dihapus!')
                        }
                    }, "json");
            }
        });
    }
    $('.filters #BahandietM_bahandiet_nama').focus();
</script>