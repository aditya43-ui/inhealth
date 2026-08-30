<?php $linkHalaman = CustomFunction::getUrlByMenuID(3269); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Pegawai Resign',
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
            <i class="entypo-info-circled"></i> Informasi <b>Pegawai Resign</b>
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
                    <i class="entypo-credit-card"></i> Tabel <b>Pegawai Resign</b>
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
                            'header' => 'NIP',
                            'name' => 'nip',
                            'value' => '$data->pegawaiRl->nomorindukpegawai',
                        ),
                        array(
                            'header' => 'Nama Pegawai',
                            'name' => 'nama_pegawai',
                            'value' => '$data->Pegawai($data->pegawai_id)',
                        ),
                        array(
                            'header' => 'Jabatan',
                            'name' => 'jabatan_id',
                            'value' => '$data->jenisJabatan($data->jabatan_id)',
                        ),
                        array(
                            'header' => 'Unit Kerja',
                            'name' => 'untikerja_id',
                            'value' => '$data->jenisUnit($data->untikerja_id)',
                        ),
                        array(
                            'header' => 'No. Surat Resign',
                            'name' => 'noresign',
                            'value' => '$data->noresign'
                        ),
                        array(
                            'header' => 'Tgl. Diterima',
                            'name' => 'tglditerima',
                            'value' => '$data->tglditerima'
                        ),
                        array(
                            'header' => 'Tgl. Resign',
                            'name' => 'tglresign',
                            'value' => '$data->tglresign'
                        ),
                        array(
                            'header' => 'Alasan Resign',
                            'name' => 'alasanresign',
                            'value' => '$data->alasanresign'
                        ),
                        array(
                            'header' => 'Lampiran Surat Resign',
                            'type' => 'raw',
                            //                                                  'value' => '$data->lampiran_surat',
                            'value' => function ($data) {
                                //                                                        return CHtml::link($data->lampiran_surat, Params::urlPegawaiFileDirectory().$data->lampiran_surat, array('rel'=>'tooltip','title'=>'Klik untuk melihat file lampiran', 'data-html'=>true,"id"=>"$data->lampiran_surat"));
                                if (file_exists(Params::pathPegawaiFileDirectory() . $data->lampiran_surat)) {
                                    return CHtml::link($data->lampiran_surat, Params::urlPegawaiFileDirectory() . $data->lampiran_surat, array('target' => '_blank', 'rel' => 'tooltip', 'title' => 'Klik untuk melihat file lampiran', 'data-html' => true, "id" => "$data->lampiran_surat"));
                                } else {
                                    return CHtml::link($data->lampiran_surat, 'javascript:void(0);', array("onclick" => "myAlert('File " . $data->lampiran_surat . " tidak ditemukan di folder server!'); return false;", 'rel' => 'tooltip', 'title' => 'Klik untuk melihat file lampiran', 'data-html' => true, "id" => "$data->lampiran_surat"));
                                }
                            }
                        ),
                        array(
                            'header' => 'Batal',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $namaPegawai = (!empty($data->pegawai_id) ? $data->pegawaiRl->namaLengkap : "");
                                return CHtml::link('<i class="icon-form-silang"></i>', "javascript:batalResignPegawai($data->resign_id,'$namaPegawai')", array("id" => "$data->resign_id", "rel" => "tooltip", "title" => "Klik untuk membatalkan resign pegawai", "data-placement" => "left"));
                                //                                            return CHtml::link('<i class="icon-form-silang"></i>', "javascript:;",array("id"=>$data->penggajianpeg_id,"rel"=>"tooltip","title"=>"Klik untuk membatalkan pengajuan gaji", 'data-placement'=>'left', 'onclick'=>'myAlert("Apakah Anda Akan Membatalkan Pengajuan Gaji'.$data->nopenggajian.' ","Perhatian")'));
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>
<script>
    function batalResignPegawai(resign_id, nama_pegawai) {
        myConfirm('Apakah Anda yakin pegawai "' + nama_pegawai.trim() + '" batal resign?', "Perhatian!", function(r) {
            if (r) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/' . 'BatalResignPegawai'); ?>',
                    data: {
                        resign_id: resign_id
                    }, //
                    dataType: "json",
                    success: function(data) {
                        if (data.status == true) {
                            myAlert(data.pesan);
                            $.fn.yiiGridView.update('pegmutasi-r-grid', {
                                data: $(this).serialize()
                            });
                        } else {
                            myAlert(data.pesan);
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