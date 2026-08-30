<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Implementasi Keperawatan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Saimplementasikeperawatan Ms' => array('index'),
            'Manage',
        );

        $arrMenu = array();
        (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Implementasi Keperawatan ', 'header' => true, 'itemOptions' => array('class' => 'heading-master'))) :  '';
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' RIImplementasikeperawatanM', 'icon'=>'list', 'url'=>array('index'))) ;
        // (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Implementasi Keperawatan', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

        $this->menu = $arrMenu;

        Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
$('#SAImplementasikeperawatanM_implementasikeperawatan_kode').focus();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('saimplementasikeperawatan-m-grid', {
data: $(this).serialize()
});
return false;
});
");

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut2 search-form" style="display:none; border: 1px solid">
            <?php $this->renderPartial($this->path_view . '_search', array(
                'model' => $model,
            )); ?>
        </div>

        <!--<h6>Tabel <b>Implementasi Keperawatan</b></h6>-->
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Implementasi Keperawatan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'saimplementasikeperawatan-m-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        ////'implementasikeperawatan_id',
                        array(
                            'header' => 'No.',
                            'value' => '($this->grid->dataProvider->pagination) ? 
($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
: ($row+1)',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'name' => 'diagnosakeperawatan_id',
                            'filter' => CHtml::dropDownList('SAImplementasikeperawatanM[diagnosakeperawatan_id]', $model->diagnosakeperawatan_id, CHtml::listData($model->DiagnosaKeperawatanItems, 'diagnosakeperawatan_id', 'diagnosakeperawatan_kode'), array('empty' => '-- Pilih --')),
                            'value' => '$data->diagnosakeperawatan->diagnosakeperawatan_kode." - ".$data->diagnosakeperawatan->diagnosa_keperawatan',
                        ),
                        array(
                            'name' => 'rencanakeperawatan_id',
                            'filter' =>  CHtml::dropDownList('SAImplementasikeperawatanM[rencanakeperawatan_id]', $model->rencanakeperawatan_id, CHtml::listData($model->RencanaKeperawatanItems, 'rencanakeperawatan_id', 'rencana_kode'), array('empty' => '-- Pilih --')),
                            'value' => '$data->rencanakeperawatan->rencana_kode." - ".$data->rencanakeperawatan->rencana_intervensi',
                        ),
                        'implementasikeperawatan_kode',
                        'implementasi_nama',

                        array(
                            'header' => 'Kolaborasi implementasi',
                            'class' => 'CCheckBoxColumn',
                            'selectableRows' => 0,
                            'id' => 'rows',
                            'checked' => '$data->iskolaborasiimplementasi',
                        ),
                        array(
                            'header' => 'Lihat',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{view}',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'buttons' => array(
                                'view' => array(
                                    'options' => array('rel' => 'tooltip', 'title' => 'Lihat Implementasi Keperawatan'),
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Ubah',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{update}',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'buttons' => array(
                                'update' => array(
                                    'visible' => 'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                    'options' => array('rel' => 'tooltip', 'title' => 'Ubah Implementasi Keperawatan'),
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Hapus',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->implementasikeperawatan_id)",array("id"=>"$data->implementasikeperawatan_id","rel"=>"tooltip","title"=>"Hapus Implementasi Keperawatan"))',
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

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Implementasi Keperawatan', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah implementasi keperawatan', 'class' => 'btn btn-danger',)
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
$("#saimplementasikeperawatan-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint){
window.open("${urlPrint}/"+$('#saimplementasikeperawatan-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
            ?>
        </div>
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
                            $.fn.yiiGridView.update('saimplementasikeperawatan-m-grid');
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
                            $.fn.yiiGridView.update('saimplementasikeperawatan-m-grid');
                        } else {
                            myAlert('Data gagal dihapus!')
                        }
                    }, "json");
            }
        });
    }

    $(document).ready(function() {
        $('input[name="RIImplementasikeperawatanM[implementasikeperawatan_kode]"]').focus();
    })
</script>