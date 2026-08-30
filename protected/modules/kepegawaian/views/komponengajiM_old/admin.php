<div class="white-container">
    <legend class="rim2">Pengaturan <b>Komponen Gaji</b></legend>
    <?php
    $this->breadcrumbs = array(
        'Komponengaji Ms' => array('index'),
        'Manage',
    );

    $arrMenu = array();
    //                (Yii::app()->user->checkAccess('Admin')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Komponen Gaji  ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Gelar Belakang', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess('Create')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Komponen Gaji ', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

    $this->menu = $arrMenu;

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
        $('#KomponengajiM_nourutgaji').focus();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('komponengaji-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    $this->renderPartial('_tabMenu', array());
    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="biru">
        <div class="white">
            <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-white icon-accordion"></i>')), '#', array('class' => 'search-button btn')); ?>
            <div class="cari-lanjut search-form">
                <?php $this->renderPartial('_search', array(
                    'model' => $model,
                )); ?>
            </div>
            <!--search-form-->

            <!--<h6>Tabel <b>Komponen Gaji</b></h6>-->
            <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                'id' => 'komponengaji-m-grid',
                'dataProvider' => $model->search(),
                'filter' => $model,
                'template' => "{summary}\n{items}\n{pager}",
                'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                'columns' => array(
                    ////'komponengaji_id',
                    array(
                        'name' => 'komponengaji_id',
                        'value' => '$data->komponengaji_id',
                        'filter' => false,
                    ),
                    'nourutgaji',
                    'komponengaji_kode',
                    'komponengaji_nama',
                    'komponengaji_singkt',
                    array(
                        'header' => 'Potongan',
                        'value' => '(($data->ispotongan==1)? "Ya" : "Tidak")',
                    ),
                    array(
                        'header' => 'Status',
                        'value' => '($data->komponengaji_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                        'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                    ),
                    // array(
                    //     'header'=>'Aktif',
                    //     'class'=>'CCheckBoxColumn',
                    //     'id'=>'rows',
                    //     'selectableRows'=>0,
                    //     'checked'=>'$data->komponengaji_aktif',
                    // ),
                    /*
                            'komponengaji_aktif',
                            */
                    array(
                        'header' => 'Lihat',
                        'class' => 'bootstrap.widgets.BootButtonColumn',
                        'template' => '{view}',
                    ),
                    array(
                        'header' => 'Ubah',
                        'class' => 'bootstrap.widgets.BootButtonColumn',
                        'template' => '{update}',
                        'buttons' => array(
                            'update' => array(
                                'visible' => 'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                            ),
                        ),
                    ),
                    array(
                        'header' => 'Hapus',
                        'type' => 'raw',
                        'value' => '($data->komponengaji_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->komponengaji_id)",array("id"=>"$data->komponengaji_id","rel"=>"tooltip","title"=>"Menonaktifkan"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->komponengaji_id)",array("id"=>"$data->komponengaji_id","rel"=>"tooltip","title"=>"Hapus")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->komponengaji_id)",array("id"=>"$data->komponengaji_id","rel"=>"tooltip","title"=>"Hapus"));',
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
            <!--</div>-->
        </div>
    </div>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Tambah Komponen Gaji', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
        $this->createUrl(Yii::app()->controller->id . '/create', array('modul_id' => Yii::app()->session['modul_id'])),
        array('title' => 'Tambah komponen gaji', 'class' => 'btn btn-danger',)
    );
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
    echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
    $content = $this->renderPartial('../tips/master', array(), true);
    $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
    $url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);

    $js = <<< JSCRIPT
         function cekForm(obj)
{
    $("#komponengaji-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#komponengaji-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
    ?>
</div>
<script type="text/javascript">
    function removeTemporary(id) {
        var url = '<?php echo $url . "/removeTemporary"; ?>';

        myConfirm('Yakin akan menonaktifkan data ini untuk sementara?', 'Perhatian!',
            function(r) {
                if (r) {
                    $.post(url, {
                            id: id
                        },
                        function(data) {
                            if (data.status == 'proses_form') {
                                $.fn.yiiGridView.update('komponengaji-m-grid');
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
        myConfirm('Yakin Akan Menghapus Data ini?', 'Perhatian!',
            function(r) {
                if (r) {
                    $.post(url, {
                            id: id
                        },
                        function(data) {
                            if (data.status == 'proses_form') {
                                $.fn.yiiGridView.update('komponengaji-m-grid');
                            } else {
                                myAlert('Data gagal dihapus!')
                            }
                        }, "json");
                }
            });
    }
</script>