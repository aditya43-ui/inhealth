<?php // $this->renderPartial('_tabMenu',array()); 
?>
<?php
$this->breadcrumbs = array(
    'Sarencana Keperawatan Ms' => array('index'),
    'Manage',
);

$arrMenu = array();
(Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Rencana Keperawatan  ', 'header' => true, 'itemOptions' => array('class' => 'heading-master'))) :  '';
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' RJRencanakeperawatanM', 'icon'=>'list', 'url'=>array('index'))) ;
(Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Create') . ' Rencana Keperawatan ', 'icon' => 'file', 'url' => array('create'))) :  '';

//$this->menu=$arrMenu;

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('sarencana-keperawatan-m-grid', {
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
<div class='block-tabel'>
    <!--<h6>Tabel <b>Rencana Keperawatan</b></h6>-->
    <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'sarencana-keperawatan-m-grid',
        'dataProvider' => $model->searchData(),
        'filter' => $model,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            ////'rencanakeperawatan_id',
            array(
                'name' => 'rencanakeperawatan_id',
                'value' => '$data->rencanakeperawatan_id',
                'filter' => false,
            ),
            array(
                'name' => 'diagnosakeperawatan_id',
                'filter' =>  CHtml::listData($model->DiagnosaKeperawatanItems, 'diagnosakeperawatan_id', 'diagnosakeperawatan_kode'),
                'value' => '$data->diagnosakeperawatan->diagnosakeperawatan_kode',
            ),
            'rencana_kode',
            'rencana_intervensi',
            'rencana_rasionalisasi',

            array(
                'header' => 'Kolaborasi Intervensi',
                'class' => 'CCheckBoxColumn',
                'selectableRows' => 0,
                'id' => 'rows',
                'checked' => '$data->iskolaborasiintervensi',
            ),
            array(
                'header' => 'Lihat',
                'class' => 'bootstrap.widgets.BootButtonColumn',
                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                'template' => '{view}',
                'buttons' => array(
                    'view' => array(
                        'options' => array('rel' => 'tooltip', 'title' => 'Lihat Rencana Keperawatan'),
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
                        'options' => array('rel' => 'tooltip', 'title' => 'Ubah Rencana Keperawatan'),
                    ),
                ),
            ),
            array(
                'header' => 'Hapus',
                'type' => 'raw',
                'value' => '($data->iskolaborasiintervensi)? CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->rencanakeperawatan_id)",array("id"=>"$data->rencanakeperawatan_id","rel"=>"tooltip","title"=>"Menonaktifkan Rencana Keperawatan"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->rencanakeperawatan_id)",array("id"=>"$data->rencanakeperawatan_id","rel"=>"tooltip","title"=>"Hapus Rencana Keperawatan")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->rencanakeperawatan_id)",array("id"=>"$data->rencanakeperawatan_id","rel"=>"tooltip","title"=>"Hapus Rencana Keperawatan"));',
                'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
            ),
            //		array(
            //                        'header'=>Yii::t('zii','Delete'),
            //			'class'=>'bootstrap.widgets.BootButtonColumn',
            //                        'template'=>'{remove} {delete}',
            //                        'buttons'=>array(
            //                                        'remove' => array (
            //                                                'label'=>"<i class='icon-form-silang'></i>",
            //                                                'options'=>array('rel' => 'tooltip' , 'title'=> 'Menonaktifkan Rencana Keperawatan' ),
            //                                                'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>"$data->rencanakeperawatan_id"))',
            //                                                //'visible'=>'($data->kabupaten_aktif && Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ? TRUE : FALSE',
            //                                                'click'=>'function(){return confirm("'.Yii::t("mds","Do You want to remove this item temporary?").'");}',
            //                                        ),
            //                                        'delete'=> array(
            //                                                'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
            //                                                'options'=>array('rel' => 'tooltip' , 'title'=> 'Hapus Rencana Keperawatan' ),
            //                                        ),
            //                        )
            //		),
        ),
        'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
            $("table").find("input[type=text]").each(function(){
                cekForm(this);
            })
        }',
    )); ?>
</div>
<?php
echo CHtml::link(Yii::t('mds', '{icon} Tambah Rencana Keperawatan', array('{icon}' => '<i class="icon-plus icon-white"></i>')), $this->createUrl('rencanaKeperawatanM/create', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
$content = $this->renderPartial('../tips/master', array(), true);
$this->widget('UserTips', array('type' => 'admin', 'content' => $content));
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
$url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);
$js = <<< JSCRIPT
        function cekForm(obj)
{
    $("#sarencana-keperawatan-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#sarencana-keperawatan-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>
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
                            $.fn.yiiGridView.update('sarencana-keperawatan-m-grid');
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
                            $.fn.yiiGridView.update('sarencana-keperawatan-m-grid');
                        } else {
                            myAlert('Data gagal dihapus karena data digunakan oleh Master Rencana Keperawatan atau Master Implementasi Keperawatan.');
                        }
                    }, "json");
            }
        });
    }

    $(document).ready(function() {
        $('input[name="RJRencanakeperawatanM[rencana_kode]"]').focus();
    });
</script>
<br><br><br><br><br><br>