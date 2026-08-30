<?php
$this->breadcrumbs = array(
    'Informasi Pengiriman Dokumen Rekam Medis',
);
?>
<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('#rmpengirimanrm-t-search').submit(function(){
	$.fn.yiiGridView.update('informasipengiriman-t-grid', {
		data: $(this).serialize()
	});
	return false;
});
setInterval(   
    function(){
        $.fn.yiiGridView.update('informasipengiriman-t-grid', { 
        data: $(this).serialize()
        
    });
    return false;
    }, 
60000  
);
");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pengiriman Dokumen Rekam Medis</b>
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
                <?php $this->renderPartial($this->path_view . '_searchinformasi', array('model' => $model)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pengiriman Dokumen Rekam Medis</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'informasipengiriman-t-grid',
                    'dataProvider' => $model->searchInformasi(),
                    // 'filter'=>$model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered datatable',
                    //            'replaceUrl'=>true,
                    'columns' => array(
                        array(
                            'header' => 'Tanggal Pengiriman',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglpengirimanrm)',
                        ),
                        array(
                            'header' => 'No. Rekam Medik',
                            'value' => '$data->no_rekam_medik'
                        ),
                        array(
                            'header' => 'Nama Pasien',
                            'type' => 'raw',
                            'value' => '$data->namadepan.$data->nama_pasien',
                        ),
                        array(
                            'header' => 'Tanggal Lahir',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tanggal_lahir)',
                        ),
                        array(
                            'header' => 'Jenis Kelamin',
                            'value' => '$data->jeniskelamin',
                        ),
                        array(
                            'header' => 'Instalasi / Ruangan Asal',
                            'value' => function ($data) {
                                echo $data->instalasipengirim_nama . "/<br> " . $data->ruanganpengirim_nama;
                            },
                        ),
                        array(
                            'header' => 'Instalasi / Ruangan Tujuan',
                            'value' => function ($data) {
                                echo $data->instalasitujuan_nama . "/<br> " . $data->ruangantujuan_nama;
                            },
                        ),
                        array(
                            'header' => 'Petugas Pengirim',
                            'value' => function ($data) {
                                $pegawai = LoginpemakaiK::model()->findByPk($data->create_loginpemakai_id);
                                $nama = RKPegawaiM::model()->findByPk($pegawai->pegawai_id);
                                if (!empty($nama)) {
                                    return $nama->namaLengkap;
                                } else {
                                    return '-';
                                }
                            },
                        ),
                        array(
                            'header' => 'Kelengkapan Dokumen',
                            'type' => 'raw',
                            'value' => '($data->kelengkapandokumen==1)? Yii::t("mds","Lengkap") : Yii::t("mds","Belum")',
                        ),
                        array(
                            'header' => 'Status Dokumen',
                            'type' => 'raw',
                            'value' => '(!empty($data->kembalirm_id) ? "SUDAH DIKEMBALIKAN <br>".MyFormatter::formatDateTimeForUser($data->tglkembali) : $data->statusdokrm)',
                        ),
                        //                                array(
                        //                                    'name'=>'ruanganpengirim_id',
                        //                                    'filter'=>CHtml::listData($model->getRuanganItems(),'ruangan_id','ruangan_nama'),
                        //                                    'value'=>'$data->ruanganpengirim->ruangan_nama',
                        //                                ),
                        array(
                            'header' => 'Status Print',
                            'type' => 'raw',
                            'value' => '($data->printpengiriman==1)? Yii::t("mds","Sudah") : Yii::t("mds","Belum")',
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>