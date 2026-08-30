<?php $linkHalaman = CustomFunction::getUrlByMenuID(1625); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Realisasi Pelatihan',
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
            <i class="entypo-info-circled"></i> Informasi <b>Realisasi Pelatihan</b>
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
                <?php $this->renderPartial('_searchRealisasi', array('model' => $model,)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Realisasi Pelatihan</b>
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
                        array(
                            'name' => 'tglrealisasi',
                            'value' => 'date("d M Y", strtotime($data->tglrealisasi));',
                        ),
                        array(
                            'name' => 'norealisasi',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return CHtml::link('<u>' . $data->norealisasi . '</u>', Yii::app()->controller->createUrl('detailRealisasi', array('id' => $data->realisasidiklat_id)), array(
                                    'target' => 'frameRencanaDetail',
                                    'onclick' => '$("#dialogRencanaDetail").dialog("open");',
                                    'data-toggle' => 'tooltip',
                                    'title' => 'Klik untuk menampilkan Detail Rencana Pelatihan',
                                ));
                            }
                        ),
                        array(
                            'header' => 'Jenis Diklat',
                            'type' => 'raw',
                            'name' => 'jenisdiklat_id',
                            'value' => function ($data) {
                                if (empty($data->jenisdiklat_id)) return "-";
                                $modJenis = JenisdiklatM::model()->findByPk($data->jenisdiklat_id);
                                return $modJenis->jenisdiklat_nama;
                            },
                        ),
                        array(
                            'header' => 'Nama Pelatihan',
                            'name' => 'namapelatihan',
                        ),
                        array(
                            'header' => 'Pemateri/<br>Penyelenggara',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if ($data->jenisdiklat_id == Params::JENIS_DIKLAT_EKSTERNAL)
                                    return $data->penyelenggara;
                                return $data->pemateri;
                            }
                        ),
                        array(
                            'header' => 'Periode Pelatihan',
                            'name' => 'realisasi_tglawal',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return date('d M Y', strtotime($data->realisasi_tglawal)) . '<br>' .
                                    date('d M Y', strtotime($data->realisasi_tglakhir));
                            }
                        ),
                        array(
                            'header' => 'Waktu',
                            'name' => 'jam_mulai',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return $data->jam_mulai . ' - ' . $data->jam_akhir;
                            }
                        ),
                        array(
                            'header' => 'Tempat/Alamat',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return $data->tempat . '/<br>' .
                                    $data->alamat;
                            }
                        ),
                        array(
                            'header' => 'Pemberi Tugas',
                            'name' => 'pemberitugas_id',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if (empty($data->pemberitugas_id)) return "-";
                                $p = PegawaiM::model()->findByPk($data->pemberitugas_id);
                                return !empty($p->pegawai_id) ? $p->namaLengkap : null;
                            }
                        ),
                        'keterangan_diklat',
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>
<!--/div-->
<?php echo $this->renderPartial('_dialogDetail', array(), true); ?>