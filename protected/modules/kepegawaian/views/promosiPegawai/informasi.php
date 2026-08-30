<?php

/**
 *       - digunakan sebagai view utama untuk menampilkan data pada tabel pegpromosi
 *       @author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 *       @website	<piindonesia.co.id>
 */
?>
<?php $linkHalaman = CustomFunction::getUrlByMenuID(1158); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Promosi Pegawai',
);
$arrMenu = array();
(Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'List') . ' Data Pelamar ', 'header' => true, 'itemOptions' => array('class' => 'heading-master'))) :  '';
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' PelamarT', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' PelamarT', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
$this->menu = $arrMenu;
Yii::app()->clientScript->registerScript('search', "
    //$('.search-button').click(function(){
    //	$('.search-form').toggle();
    //	return false;
    //});
    $('#pegmutasi-r-search').submit(function(){
            $.fn.yiiGridView.update('pegmutasi-r-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
$this->widget('bootstrap.widgets.BootAlert'); ?>
<?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="entypo-search"></i>')),'#',array('class'=>'search-button btn')); 
?>
<!--<div class="cari-lanjut search-form">-->
<!--</div> search-form-->
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Promosi Pegawai</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_search', array('model' => $model,)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Promosi Pegawai</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'pegmutasi-r-grid',
                    'dataProvider' => $model->searchInformasi(),
                    //	'filter'=>$model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        ////'pelamar_id',
                        array(
                            'header' => 'No.',
                            'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
                            'htmlOptions' => array('style' => 'text-align:center;width:30px;'),
                            'type' => 'raw',
                        ),
                        array(
                            'header' => 'Nama Pegawai',
                            'name' => 'nama_pegawai',
                            'value' => '$data->pegawai->namaLengkap'
                        ),
                        array(
                            'header' => 'No. SK',
                            'name' => 'prom_nosk',
                            'value' => '$data->prom_nosk'
                        ),
                        array(
                            'header' => 'Jabatan Asal',
                            'name' => 'prom_jabatan_lama',
                            'value' => '$data->prom_jabatan_lama'
                        ),
                        array(
                            'header' => 'Unit Asal',
                            'name' => 'prom_unitkerja',
                            'value' => '$data->prom_unitkerja'
                        ),
                        array(
                            'header' => 'Jabatan Baru',
                            'name' => 'prom_jabatan_baru',
                            'value' => '$data->prom_jabatan_baru'
                        ),
                        array(
                            'header' => 'Unit Baru',
                            'name' => 'prom_unitkerja_baru',
                            'value' => '$data->prom_unitkerja_baru'
                        ),
                        array(
                            'header' => 'Lokasi Kerja',
                            'name' => 'prom_lokasikerja_baru',
                            'value' => '$data->prom_lokasikerja_baru'
                        ),
                        array(
                            'header' => 'Status',
                            'type' => 'raw',
                            'name' => 'pegpromosi_id',
                            'value' => function ($data) {
                                if (empty($data->prom_status)) {
                                    return CHtml::link(" Approved <i class='fas fa-check'></i>", "javascript:;", array('onclick' => "getApproved('" . $data->prom_pimpinan_nama . "'," . $data->pegpromosi_id . ",'dialog');jQuery('#dialogChangeSt').dialog('open');", 'class' => 'btn btn-info btn-icon'));
                                } else {
                                    return CHtml::link($data->prom_status, "javascript:;", array('class' => Params::getColorStPromosi($data->prom_status)));
                                }
                            }
                        ),
                        array(
                            'header' => 'Detail',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return CHtml::link("<i class='" . MyIcon::getIcons('lihat2') . "'>", Yii::app()->controller->createUrl('/' . Yii::app()->controller->module->id . "/" . Yii::app()->controller->id . "/detail", array("id" => $data->pegpromosi_id)), array('rel' => 'tooltip', 'title' => 'Klik ikon ini, jika Anda ingin menampilkan <b>detail data promosi pegawai ini</b>', 'data-html' => true, "id" => "$data->pegpromosi_id", "target" => "frameDetail", "onclick" => "window.parent.$('#dialogDetail').dialog('open');"));
                            },
                            'htmlOptions' => array('style' => 'text-align:center;')
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>
<!--/div-->
<?php echo $this->renderPartial('js/_jsFunctionsInfo', array(), true); ?>
<?php echo $this->renderPartial('dialog/_dialogChangeSt', array(), true); ?>
<?php echo $this->renderPartial('dialog/_dialogDetail', array(), true); ?>