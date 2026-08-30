<legend class="rim">Pengaturan <?php echo $this->nama; ?></legend>
<?php
$this->breadcrumbs = array(
    'Lookup Ms' => array('index'),
    'Manage',
);

$this->menu = array(
    //       array('label'=>Yii::t('mds','Manage').' Kategori Obat ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
    //	array('label'=>Yii::t('mds','List').' Lookup', 'icon'=>'list', 'url'=>array('index')),
    //	array('label'=>Yii::t('mds','Create').' Kategori Obat', 'icon'=>'file', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('#form_kategoriObt_search').submit(function(){
	$.fn.yiiGridView.update('lookup-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
<div class="cari-lanjut search-form">
    <?php $this->renderPartial($this->path_view . '_search', array(
        'model' => $model,
    )); ?>
</div>
<!--search-form-->
<?php //echo CHtml::dropDownList('agama', '', LookupM::getItems('agama')); 
?>
<?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'lookup-m-grid',
    'dataProvider' => $model->searchStrict(),
    'filter' => $model,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        ////'lookup_id',
        //array(
        //        'header'=>'ID',
        //        'value'=>'$data->lookup_id',
        //),
        //'lookup_type',
        //               'lookup_type',		
        array(
            'header' => 'Nama',
            'name' => 'lookup_name',
            'value' => '$data->lookup_name',
            'filter' => Chtml::activeTextField($model, 'lookup_name', array('class' => 'custom-only'))
        ),
        array(
            'header' => 'Value',
            'name' => 'lookup_value',
            'value' => '$data->lookup_value',
            'filter' => Chtml::activeTextField($model, 'lookup_value', array('class' => 'custom-only'))
        ),
        array(
            'header' => 'Kode',
            'name' => 'lookup_kode',
            'value' => '$data->lookup_kode',
            'filter' => Chtml::activeTextField($model, 'lookup_kode', array('class' => 'custom-only'))
        ),
        array(
            'header' => 'Urutan',
            'name' => 'lookup_urutan',
            'value' => '$data->lookup_urutan',
            'filter' => Chtml::activeTextField($model, 'lookup_urutan', array('class' => 'numbers-only')),
            'htmlOptions' => array('style' => 'text-align:right;')
        ),
        //'lookup_aktif',
        array(
            'header' => 'Status',
            'value' => '($data->lookup_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
            'htmlOptions' => array('style' => 'text-align:center;'),
        ),
        //                array(
        //                        'header'=>'Aktif',
        //                        'class'=>'CCheckBoxColumn',     
        //                        'selectableRows'=>0,
        //                        'id'=>'rows',
        //                        'checked'=>'$data->lookup_aktif',
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
            'buttons' => array(
                'remove' => array(
                    'label' => "<i class='icon-form-silang'></i>",
                    'options' => array('title' => Yii::t('mds', 'Remove Temporary')),
                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/removeTemporary",array("id"=>"$data->lookup_id"))',
                    'visible' => '($data->lookup_aktif==TRUE)?TRUE:FALSE',
                    'click' => 'function(){ removeTemporary(this); return false;}',
                ),
                'delete' => array(
                    'visible' => 'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
                ),
            )
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
            $("table").find("input[type=text]").each(function(){
                cekForm(this);
            });
            $(".custom-only").keyup(function() {
                setCustomOnly(this);
            });
            $(".numbers-only").keyup(function() {
                setNumbersOnly(this);
            });
        }',
)); ?>

<?php
echo CHtml::link(Yii::t('mds', '{icon} Tambah ' . $this->nama, array('{icon}' => '<i class="icon-plus icon-white"></i>')), $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));

$tips = array(
    '0' => 'lihat',
    '1' => 'ubah',
    '2' => 'nonaktif',
    '3' => 'hapus',
    '4' => 'pencarianlanjut',
    '5' => 'cari',
    '6' => 'ulang2',
    '7' => 'masterPRINT',
    '8' => 'masterEXCEL',
    '9' => 'masterPDF',
);
$content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
$this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');

$js = <<< JSCRIPT
function cekForm(obj)
{
    $("#form_kategoriObt_search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#form_kategoriObt_search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
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
                            $.fn.yiiGridView.update('lookup-m-grid');
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