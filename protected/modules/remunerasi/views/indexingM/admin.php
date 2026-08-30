<legend class="rim">Pengaturan Indexing</legend>
<!--<div class="white-container">
    <legend class="rim2">Pengaturan <b>Kelompok Remunerasi</b></legend>-->
<?php
$this->breadcrumbs = array(
    'Saindexing Ms' => array('index'),
    'Manage',
);

$arrMenu = array();
(Yii::app()->user->checkAccess('Admin')) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Indexing ', 'header' => true, 'itemOptions' => array('class' => 'heading-master'))) :  '';
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Indexing', 'icon'=>'list', 'url'=>array('index'))) ;
(Yii::app()->user->checkAccess('Create')) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Create') . ' Indexing', 'icon' => 'file', 'url' => array('create'))) :  '';

$this->menu = $arrMenu;

Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('indexing-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
?>
<?php
$this->widget('bootstrap.widgets.BootAlert');
// $this->renderPartial('_tabMenu',array());
?>
<!--<div class="biru">
        <div class="white">-->
<?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
<div class="cari-lanjut search-form">
    <?php $this->renderPartial('_search', array(
        'model' => $model,
    )); ?>
</div>
<!--search-form-->
<!--<div class='block-tabel'>-->
<?php


$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'indexing-m-grid',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'table table-striped table-condensed',
    'filter' => $model,
    'columns' => array(
        array(
            'header' => 'ID',
            'value' => '$data->indexing_id'
        ),
        array(
            'header' => 'Kelompok Remunerasi',
            'name' => 'kelrem_id',
            'value' => '$data->kelrem->kelrem_nama',
            'filter' => CHtml::dropDownList('IndexingM[kelrem_id]', $model->kelrem_id, CHtml::listData(KelremM::model()->findAll("kelrem_aktif = TRUE ORDER BY kelrem_nama ASC"), 'kelrem_id', 'kelrem_nama'), array('empty' => '-- Pilih --')),
        ),
        //'kelrem.kelrem_nama',
        'indexing_nama',
        'indexing_singk',
        array(
            'name' => 'indexing_nilai',
            'htmlOptions' => array(
                'style' => 'text-align: right;',
            ),
            'value' => 'MyFormatter::formatNumberForPrint($data->indexing_nilai, 2)',
            'filter' => false,
        ),
        array(
            'name' => 'indexing_offset',
            'htmlOptions' => array(
                'style' => 'text-align: right;',
            ),
            'filter' => false,
        ),
        array(
            'name' => 'indexing_step',
            'htmlOptions' => array(
                'style' => 'text-align: right;',
            ),
            'filter' => false,
        ),
        //'indexing_urutan',
        /*
                            'indexing_aktif',
                            */
        array(
            'header' => 'Status',
            'value' => '($data->indexing_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
            'htmlOptions' => array('style' => 'text-align:center;'),
        ),
        //                array(
        //                        'header'=>'Aktif',
        //                        'class'=>'CCheckBoxColumn',     
        //                        'selectableRows'=>0,
        //                        'id'=>'rows',
        //                        'checked'=>'$data->indexing_aktif',
        //                ),
        array(
            'header' => Yii::t('zii', 'View'),
            'class' => 'bootstrap.widgets.BootButtonColumn',
            'template' => '{view}',
        ),
        array(
            'header' => Yii::t('zii', 'Update'),
            'class' => 'bootstrap.widgets.BootButtonColumn',
            'template' => '{update}',
        ),
        array(
            'header' => Yii::t('zii', 'Delete'),
            'class' => 'bootstrap.widgets.BootButtonColumn',
            'template' => '{remove} {delete}',
            'deleteConfirmation' => 'Apakah Anda yakin ingin mengubah data ini?',
            'buttons' => array(
                'remove' => array(
                    'label' => "<i class='icon-form-silang'></i>",
                    'options' => array('title' => Yii::t('mds', 'Remove Temporary')),
                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/removeTemporary",array("id"=>"$data->indexing_id"))',
                    'visible' => '($data->indexing_aktif)?TRUE:FALSE',
                    'click' => 'function(){ removeTemporary(this); return false;}',
                ),
                'delete' => array(
                    //  'visible'=>'Yii::app()->user->checkAccess("Delete")',
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
<!--</div>-->
<?php
echo CHtml::link(Yii::t('mds', '{icon} Tambah Indexing', array('{icon}' => '<i class="icon-plus icon-white"></i>')), $this->createUrl(Yii::app()->controller->id . '/create', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
$content = $this->renderPartial('../tips/master', array(), true);
$this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
?>
<!--</div>
    </div>
</div>-->
<?php
$js = <<< JSCRIPT
         function cekForm(obj)
{
    $("#saindexing-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#saindexing-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>
<script type="text/javascript">
    function removeTemporary(obj) {
        var url = $(obj).attr('href');
        myConfirm("Apakah Anda yakin ingin menonaktifkan data ini untuk sementara?", "Perhatian!", function(r) {
            if (r) {
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: {},
                    dataType: "json",
                    success: function(data) {
                        if (data.status == 'proses_form') {
                            $.fn.yiiGridView.update('indexing-m-grid');
                        } else {
                            myAlert('Data gagal dinonaktifkan!.')
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }
        });
    }
</script>