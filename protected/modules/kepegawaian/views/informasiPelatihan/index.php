<?php $linkHalaman = CustomFunction::getUrlByMenuID(1620); ?>
<?php
$this->breadcrumbs = array(
    'InformasiRencana Pelatihan'
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
            <i class="entypo-info-circled"></i> Informasi <b>Rencana Pelatihan</b>
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
                    <i class="entypo-credit-card"></i> Tabel <b>Pelatihan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'pegmutasi-r-grid',
                    'dataProvider' => $model->searchRencanaDiklat(),
                    //	'filter'=>$model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        array(
                            'name' => 'tglrencanadiklat',
                            'value' => 'date("d M Y", strtotime($data->tglrencanadiklat));',
                        ),
                        array(
                            'name' => 'norencanadiklat',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return CHtml::link('<u>' . $data->norencanadiklat . '</u>', Yii::app()->controller->createUrl('detail', array('id' => $data->rencanadiklat_id)), array(
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
                            'header' => 'Nama Rencana',
                            'name' => 'namadiklat',
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
                            'name' => 'rencanadiklat_periode',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return date('d M Y', strtotime($data->rencanadiklat_periode)) . '<br>' .
                                    date('d M Y', strtotime($data->rencanadiklat_sampaidgn));
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
                                return $data->tempat_diklat . '/<br>' .
                                    $data->alamat_diklat;
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
                        array(
                            'header' => 'Status',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $col = array(
                                    Params::STATUS_RENCANA_DIKLAT_RENCANA => array(
                                        'class' => 'btn btn-info',
                                        'onclick' => 'batalRencana(' . $data->rencanadiklat_id . ');',
                                    ),
                                    Params::STATUS_RENCANA_DIKLAT_REALISASI => array(
                                        'class' => 'btn btn-primary',
                                        'onclick' => 'return false',
                                    ),
                                    Params::STATUS_RENCANA_DIKLAT_BATAL => array(
                                        'class' => 'btn btn-default',
                                        'onclick' => 'return false',
                                    )
                                );
                                return CHtml::htmlButton($data->status_rencana, array(
                                    'class' => $col[$data->status_rencana]['class'],
                                    'onclick' => $col[$data->status_rencana]['onclick'],
                                    'style' => 'width: 100px;'
                                ));
                            }
                        ),
                        array(
                            'header' => 'Update',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if ($data->status_rencana == Params::STATUS_RENCANA_DIKLAT_BATAL) return 'SUDAH<br>DIBATALKAN';
                                if ($data->status_rencana == Params::STATUS_RENCANA_DIKLAT_REALISASI) return 'SUDAH<br>DIREALISASIKAN';
                                return CHtml::link('<i class="entypo-pencil"></i>', Yii::app()->controller->createUrl('rencanaPelatihanT/update', array('id' => $data->rencanadiklat_id)), array(
                                    'data-toggle' => 'tooltip',
                                    'title' => 'Ubah Rencana Pelatihan',
                                ));
                            },
                            'htmlOptions' => array(
                                'style' => 'text-align: center;',
                            ),
                        ),
                        array(
                            'header' => 'Realisasi',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if ($data->status_rencana == Params::STATUS_RENCANA_DIKLAT_BATAL) return 'SUDAH<br>DIBATALKAN';
                                if ($data->status_rencana == Params::STATUS_RENCANA_DIKLAT_REALISASI) return 'SUDAH<br>DIREALISASIKAN';
                                return CHtml::link('<i class="entypo-login"></i>', Yii::app()->controller->createUrl('realisasiPelatihanT/index', array('id' => $data->rencanadiklat_id)), array(
                                    'data-toggle' => 'tooltip',
                                    'title' => 'Realisasi Rencana Pelatihan',
                                ));
                            },
                            'htmlOptions' => array(
                                'style' => 'text-align: center;',
                            ),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>
<?php $url_nota = $this->createUrl('printNota'); ?>
<?php echo $this->renderPartial('_dialogDetail', array(), true); ?>
<script>
    function batalRencana(id) {
        myConfirm('Anda yakin untuk membatalkan rencana ini?', 'Perhatian!', function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('batalRencana'); ?>', {
                    id: id
                }, function(data) {
                    if (data.ok) {
                        toastr.success(data.msg);
                        myAlert(data.msg);
                        $.fn.yiiGridView.update('pegmutasi-r-grid');
                    } else {
                        toastr.error(data.msg);
                    }
                }, 'json');
            }
        });
    }
</script>