<?php
$this->breadcrumbs = array(
    'PTKP' => array('admin'),
);

$arrMenu = array();
//    (Yii::app()->user->checkAccess('Admin')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' PTKP ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
// (Yii::app()->user->checkAccess('Create')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' PTKP ', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

$this->menu = $arrMenu;

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('ptkp-m-grid', {
data: $(this).serialize()
});
return false;
});
");
// $this->renderPartial($this->path_view_tab. '_tabMenu',array());
$this->widget('bootstrap.widgets.BootAlert');
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <?php if ($this->hasTab) : ?>
            <div class="panel-title">
                <i class="fas fa-layer-group"></i> Pengaturan <b>PTKP</b>
            </div>
        <?php else : ?>
            <div class="panel-title">
                <i class="fas fa-layer-group"></i> Pengaturan <b>PTKP</b>
            </div>
        <?php endif; ?>
    </div>
    <div class="panel-body">
        <!--<div class="biru">
<div class="white">-->
        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-white icon-accordion"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form">
            <?php $this->renderPartial($this->path_view . '_search', array(
                'model' => $model,
            )); ?>
        </div>
        <!--<div class="block-tabel">
<h6>Tabel <b>PTKP</b></h6>-->
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>PTKP</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'ptkp-m-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        array(
                            'name' => 'ptkp_id',
                            'value' => '$data->ptkp_id',
                            'filter' => false,
                        ),
                        //'tglberlaku',
                        array(
                            'header' => 'Tanggal Berlaku',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglberlaku)',
                            'filter' => $this->widget(
                                'MyDateTimePicker',
                                array(
                                    'model' => $model,
                                    'attribute' => 'tglberlaku',
                                    'mode' => 'date',
                                    'htmlOptions' => array(
                                        'id' => 'datepicker_for_due_date',
                                        'size' => '20',
                                        'style' => 'width:80%'
                                    ),
                                    'options' => array(  // (#3)                    
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    ),
                                ),
                                true
                            ),
                        ),
                        array(
                            'header' => 'Status Perkawinan',
                            'name' => 'statusperkawinan',
                            'value' => '$data->statusperkawinan',
                            'filter' => Chtml::activeDropDownList($model, 'statusperkawinan', LookupM::getItems('statusperkawinan'), array('empty' => '-- Pilih --'))
                        ),
                        array(
                            'header' => 'Jumlah Tanggungan',
                            'name' => 'jmltanggunan',
                            'value' => '$data->jmltanggunan',
                            'filter' => Chtml::activeTextField($model, 'jmltanggunan', array('class' => 'numbers-only', 'style' => 'text-align:right;')),
                            'htmlOptions' => array('size' => '5', 'style' => 'text-align:right;')
                        ),
                        // 'wajibpajak_thn',
                        array(
                            'header' => 'Nilai Wajib Pajak Tahun (Rp)',
                            'name' => 'wajibpajak_thn',
                            'value' => 'number_format($data->wajibpajak_thn,0,"",".")',
                            'filter' => Chtml::activeTextField($model, 'wajibpajak_thn', array('class' => 'numbers-only', 'style' => 'text-align:right;')),
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Nilai Wajib Pajak Bulan (Rp)',
                            'name' => 'wajibpajak_bln',
                            'filter' => Chtml::activeTextField($model, 'wajibpajak_bln', array('class' => 'numbers-only', 'style' => 'text-align:right;')),
                            'value' => 'number_format($data->wajibpajak_bln,0,"",".")',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        'kodeptkp',
                        array(
                            'header' => 'Status',
                            'value' => '($data->berlaku)?"Aktif":"Tidak Aktif"',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                            'filter' => false,
                        ),
                        // array(
                        //     'header'=>'Aktif',
                        //     'class'=>'CCheckBoxColumn',
                        //     'id'=>'rows',
                        //     'selectableRows'=>0,
                        //     'checked'=>'$data->berlaku',
                        // ),
                        array(
                            'header' => 'Lihat',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{view}',
                        ),
                        array(
                            'header' => 'Ubah',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{update}',
                            'buttons' => array(
                                'update' => array(
                                    'visible' => 'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                ),
                            ),
                        ),
                        /*    array(
'header'=>Yii::t('zii','Delete'),
'class'=>'bootstrap.widgets.BootButtonColumn',
'template'=>'{delete}',
'buttons'=>array(
'delete'=> array(
'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
),
)
),   */
                        array(
                            'header' => 'Hapus',
                            'type' => 'raw',
                            'value' => '($data->berlaku)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->ptkp_id)",array("id"=>"$data->ptkp_id","rel"=>"tooltip","title"=>"Menonaktifkan"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->ptkp_id)",array("id"=>"$data->ptkp_id","rel"=>"tooltip","title"=>"Hapus")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->ptkp_id)",array("id"=>"$data->ptkp_id","rel"=>"tooltip","title"=>"Hapus"));',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){
jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
$("table").find("input[type=text]").each(function(){
cekForm(this);
});
$("table").find("select").each(function(){
cekForm(this);
});
$(".numbers-only").keyup(function() {
setNumbersOnly(this);
});
reinstallDatePicker();
}',
                )); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah PTKP', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl(Yii::app()->controller->id . '/create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah PTKP', 'class' => 'btn btn-danger',)
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial('sistemAdministrator.views/tips/master', array(), true);
            $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
            $url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);

            $js = <<< JSCRIPT
function cekForm(obj){
$("#ptkp-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint){
window.open("${urlPrint}/"+$('#ptkp-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {        
$('#datepicker_for_due_date').datepicker(jQuery.extend({showMonthAfterYear:false},jQuery.datepicker.regional['id'],{'dateFormat':'" . Params::DATE_FORMAT . "','changeMonth':true, 'changeYear':true,'maxDate':'d'}));
}
");
            ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    function removeTemporary(id) {
        var url = '<?php echo $url . "/removeTemporary"; ?>';
        myConfirm("Anda yakin akan menonaktifkan data ini untuk sementara?", 'Perhatian!', function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.status == 'proses_form') {
                            $.fn.yiiGridView.update('ptkp-m-grid');
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
        myConfirm("Yakin Akan Menghapus Data ini?", 'Perhatian!', function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.status == 'proses_form') {
                            $.fn.yiiGridView.update('ptkp-m-grid');
                        } else {
                            myAlert('Data gagal dihapus karena data digunakan di tabel lain.');
                        }
                    }, "json");
            }
        });
    }

    $(document).ready(function() {
        $("input[name='KPPtkpM[tglberlaku]']").focus();
    })
</script>