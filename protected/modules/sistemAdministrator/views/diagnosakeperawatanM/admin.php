<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Diagnosa Keperawatan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Sadiagnosakeperawatan Ms' => array('index'),
            'Manage',
        );

        $arrMenu = array();
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Diagnosa Keperawatan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' RIDiagnosakeperawatanM', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Diagnosa Keperawatan', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

        $this->menu = $arrMenu;

        Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
$('#SADiagnosakeperawatanM_diagnosakeperawatan_kode').focus();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('sadiagnosakeperawatan-m-grid', {
data: $(this).serialize()
});
return false;
});
");
        $path_view = $this->path_view;
        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form">
            <?php $this->renderPartial($this->path_view . '_search', array(
                'model' => $model,
            )); ?>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Diagnosa Keperawatan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'sadiagnosakeperawatan-m-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        ////'diagnosakeperawatan_id',
                        array(
                            'header' => 'No.',
                            'value' => '($this->grid->dataProvider->pagination) ? 
($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
: ($row+1)',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Diagnosa',
                            'name' => 'diagnosa_nama',
                            'value' => '$data->diagnosa->diagnosa_nama',
                            'filter' =>  CHtml::activeTextField($model, 'diagnosa_nama'),
                        ),
                        'diagnosakeperawatan_kode',
                        'diagnosa_medis',
                        'diagnosa_keperawatan',
                        'diagnosa_tujuan',
                        //'kriteriahasil_id',
                        /*
'diagnosa_keperawatan_aktif',
*/

                        array(
                            'header' => 'Kriteria Hasil',
                            'type' => 'raw',
                            'value' => function ($data) use ($path_view) {
                                Yii::app()->controller->renderPartial($path_view . "_KriteriaHasil", array("diagnosakeperawatan_id" => $data->diagnosakeperawatan_id), true);
                            }

                        ),
                        array(
                            'header' => 'Status',
                            'value' => '($data->diagnosa_keperawatan_aktif)?"Aktif":"Tidak Aktif"',
                        ),
                        array(
                            'header' => 'Lihat',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(
                                    'options' => array('rel' => 'tooltip', 'title' => 'Lihat Diagnosa Keperawatan'),
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Ubah',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{update}',
                            'buttons' => array(
                                'update' => array(
                                    'visible' => 'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                    'options' => array('rel' => 'tooltip', 'title' => 'Ubah Diagnosa Keperawatan'),
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Hapus',
                            'type' => 'raw',
                            'value' => '($data->diagnosa_keperawatan_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->diagnosakeperawatan_id)",array("id"=>"$data->diagnosakeperawatan_id","rel"=>"tooltip","title"=>"Menonaktifkan Diagnosa Keperawatan"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->diagnosakeperawatan_id)",array("id"=>"$data->diagnosakeperawatan_id","rel"=>"tooltip","title"=>"Hapus Diagnosa Keperawatan")):CHtml::link("<i class=\'icon-form-check\'></i> ","javascript:addTemporary($data->diagnosakeperawatan_id, 1)",array("id"=>"$data->diagnosakeperawatan_id","rel"=>"tooltip","title"=>"Mengaktifkan Diagnosa Keperawatan"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->diagnosakeperawatan_id)",array("id"=>"$data->diagnosakeperawatan_id","rel"=>"tooltip","title"=>"Hapus Diagnosa Keperawatan"));',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){
jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
$("table").find("input[type=text]").each(function(){
cekForm(this);
})
}',
                )); ?>
            </div>
        </div>

        <?php
        echo CHtml::link(
            Yii::t('mds', '{icon} Tambah Diagnosa Keperawatan', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
            $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])),
            array('title' => 'Tambah Diagnosa Keperawatan', 'class' => 'btn btn-danger',)
        );
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
        echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
        $content = $this->renderPartial($this->path_views . '/tips/master', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
        $url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);

        $js = <<< JSCRIPT
function cekForm(obj){
$("#sadiagnosakeperawatan-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint){
window.open("${urlPrint}/"+$('#sadiagnosakeperawatan-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
        Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
        ?>
    </div>
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
                            $.fn.yiiGridView.update('sadiagnosakeperawatan-m-grid');
                        } else {
                            myAlert('Data gagal dinonaktifkan!')
                        }
                    }, "json");
            }
        });
    }

    function addTemporary(id, add) {
        var url = '<?php echo $url . "/removeTemporary"; ?>';
        myConfirm("Anda yakin akan mengaktifkan data ini untuk sementara?", "Perhatian!", function(r) {
            if (r) {
                $.post(url, {
                        id: id,
                        add: add
                    },
                    function(data) {
                        if (data.status == 'proses_form') {
                            $.fn.yiiGridView.update('sadiagnosakeperawatan-m-grid');
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
                            $.fn.yiiGridView.update('sadiagnosakeperawatan-m-grid');
                        } else {
                            myAlert('Data gagal dihapus karena data digunakan oleh Master Rencana Keperawatan atau Master Implementasi Keperawatan.');
                        }
                    }, "json");
            }
        });
    }
    $('.filters #SADiagnosakeperawatanM_diagnosa_nama').focus();
</script>