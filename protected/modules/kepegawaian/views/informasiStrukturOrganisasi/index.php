<!--div class="white-container"-->
<?php
$this->breadcrumbs = array(
    'Informasi Struktur Organisasi',
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
            <i class="entypo-info-circled"></i> Informasi <b>Struktur Organisasi</b>
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
                    <i class="entypo-credit-card"></i> Tabel <b>Struktur Organisasi</b>
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
                            'header' => 'No. SK',
                            'name' => 'organigram_kode',
                            'value' => '$data->organigram_kode'
                        ),
                        array(
                            'header' => 'Bertanggung Jawab Kepada',
                            'name' => 'organigramasal_id',
                            'value' => '!empty($data->organigramasal->pegawai->namaLengkap)?$data->organigramasal->pegawai->namaLengkap:"-"',
                        ),
                        array(
                            'header' => 'Unit Kerja Organigram',
                            'name' => 'organigram_unitkerja',
                            'value' => '$data->organigram_unitkerja',
                        ),
                        array(
                            'header' => 'Formasi',
                            'name' => 'organigram_formasi',
                            'value' => '$data->organigram_formasi'
                        ),
                        array(
                            'header' => 'NIP',
                            'name' => 'nomorindukpegawai',
                            'value' => '$data->pegawai->nomorindukpegawai'
                        ),
                        array(
                            'header' => 'Nama Pegawai',
                            'name' => 'nama_pegawai',
                            'value' => '$data->pegawai->namaLengkap'
                        ),
                        array(
                            'header' => 'Jabatan',
                            'name' => 'jabatan_id',
                            'value' => '$data->pegawai->jabatan->jabatan_nama'
                        ),
                        array(
                            'header' => 'Pelaksana Kerja',
                            'name' => 'organigram_pelaksanakerja',
                            'value' => '$data->organigram_pelaksanakerja'
                        ),
                        array(
                            'header' => 'Periode',
                            'name' => 'organigram_periode',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->organigram_periode)'
                        ),
                        array(
                            'header' => 'Sampai Dengan',
                            'name' => 'organigram_sampaidengan',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->organigram_sampaidengan)'
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>

<!--/div-->