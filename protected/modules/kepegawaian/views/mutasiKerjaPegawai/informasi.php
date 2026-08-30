<?php $linkHalaman = CustomFunction::getUrlByMenuID(1093); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Mutasi Pegawai',
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
            <i class="entypo-info-circled"></i> Informasi <b>Mutasi Pegawai</b>
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
                    <i class="entypo-credit-card"></i> Tabel <b>Mutasi Pegawai</b>
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
                            'name' => 'nosk',
                            'value' => '$data->nosk'
                        ),
                        array(
                            'header' => 'Jabatan Asal',
                            'name' => 'jabatan_nama',
                            'value' => '$data->jabatan_nama'
                        ),
                        array(
                            'header' => 'Unit Asal',
                            'name' => 'unitkerja',
                            'value' => '$data->unitkerja'
                        ),
                        array(
                            'header' => 'Jabatan Baru',
                            'name' => 'jabatan_baru',
                            'value' => '$data->jabatan_baru'
                        ),
                        array(
                            'header' => 'Unit Baru',
                            'name' => 'unitkerja_baru',
                            'value' => '$data->unitkerja_baru'
                        ),
                        array(
                            'header' => 'Lokasi Kerja',
                            'name' => 'lokasikerja_baru',
                            'value' => '$data->lokasikerja_baru'
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>
<!--/div-->

<?php
// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Mutasi Pegawai',
        'autoOpen' => false,
        'width' => 1000,
        'height' => 500,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="frmdetail" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details================================

?>