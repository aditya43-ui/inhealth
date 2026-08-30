<?php

$caraPrint = isset($caraPrint) ? $caraPrint : null;
$lihatKasir = (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_KASIR ) ? true : false;
$lihatUnit = (Yii::app()->user->getState('ruangan_id') !== Params::RUANGAN_ID_KASIR ) ? true : false;

$table = 'ext.bootstrap.widgets.BootGridView';
$sort = true;
$visible = true;
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
$filter = $model;
if (isset($caraPrint)) {
    $row = '$row+1';
    $visible = false;
    $data = $model->searchInformasi('ada');

    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL") {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
    $filter = null;
} else {
    $data = $model->searchInformasi();
    $template = "{summary}\n{items}\n{pager}";
}?>
<style>
    table tr th {
        text-align: center!important;
    }
</style>
<?php 
$this->widget($table, array(
    'id' => 'informasi-pengajuankasbon-grid',
    'enableSorting' => $sort,
    'dataProvider' => $data,
    'template' => $template,
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'No',
            'value' => $row,
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:right;'),
        ),

        [
            'header' => 'Tgl. Pengajuan / <br> No. Pengajuan',
            'type' => 'raw', 
            'value' => function($data){
                return MyFormatter::formatDateTimeForUser($data->tgl_pengajuan) . "<br>". $data->no_pengajuan;
            }
        ],
        [
            'header' => 'Nominal',
            'value' => function ($data) {
                return MyFormatter::formatUang($data->nominal_kasbon); 
            } 
        ], 
        [
            'header' => 'Keperluan',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->keperluan; 
            } 
        ], 
        [
            'header' => 'Pegawai Mengajukan',
            'htmlOptions' => array('style' => 'text-align: center;'),
            'value' => function ($data) {
                return $data->pegawaimengajukan->namaLengkap; 
            } 
        ], 
        [
            'header' => 'Pegawai Mengetahui',
            'htmlOptions' => array('style' => 'text-align: center;'),
            'type' => 'raw',
            'value' => function ($data) {
                $btn = "";
                $alert = "Approval hanya bisa dilakukan oleh ".$data->pegawaimengetahui->namaLengkap;

                if ($data->status_persetujuan == Params::STATUS_PENGAJUAN_KASBON_PENGAJUAN && empty($data->tgl_pegawai_mengetahui)) {
                    if (Yii::app()->user->getState('pegawai_id') == $data->pegawai_mengetahui_id) {
                        $btn .= CHtml::link("<icon class='icon-form-check'></icon>",'javascript:;',array('rel'=>'tooltip','title'=>'Verifikasi Pegawai Mengetahui','onclick'=>'verifikasi('.$data->pengajuankasbon_id.', "tgl_pegawai_mengetahui")'));
                    } else {
                        $btn .= CHtml::link("<icon class='icon-form-check'></icon>",'javascript:;',array('rel'=>'tooltip','title'=>'Verifikasi Pegawai Mengetahui','onclick'=>'myAlert("'.$alert.'")'));

                    }
                } else if (!empty($data->tgl_pegawai_mengetahui)) {
                    $btn .= "<br>";
                    $btn .= date("d M Y", strtotime($data->tgl_pegawai_mengetahui));
                }

                return $data->pegawaimengetahui->namaLengkap . $btn ; 
            } 
        ], 
        [
            'header' => 'Pegawai Menyetujui 1',
            'htmlOptions' => array('style' => 'text-align: center;'),
            'type' => 'raw',
            'value' => function ($data) {
                $btn = "";
                $alert = "Approval hanya bisa dilakukan oleh ".$data->pegawaimenyetujui1->namaLengkap;

                if ($data->status_persetujuan == Params::STATUS_PENGAJUAN_KASBON_PERSETUJUAN && 
                    !empty($data->tgl_pegawai_mengetahui) && empty($data->tgl_pegawai_menyetuji1)) {
                    if (Yii::app()->user->getState('pegawai_id') == $data->pegawai_menyetujui1_id) {
                        $btn .= CHtml::link("<icon class='icon-form-check'></icon>",'javascript:;',array('rel'=>'tooltip','title'=>'Verifikasi Pegawai Menyetujui 1','onclick'=>'verifikasi('.$data->pengajuankasbon_id.', "tgl_pegawai_menyetuji1")'));
                    } else {
                        $btn .= CHtml::link("<icon class='icon-form-check'></icon>",'javascript:;',array('rel'=>'tooltip','title'=>'Verifikasi Pegawai Menyetujui 1','onclick'=>'myAlert("'.$alert.'")'));

                    }
                } else if (!empty($data->tgl_pegawai_menyetuji1)) {
                    $btn .= "<br>";
                    $btn .= date("d M Y", strtotime($data->tgl_pegawai_menyetuji1));
                } 
                
                return $data->pegawaimenyetujui1->namaLengkap; 
            } 
        ], 
        [
            'header' => 'Pegawai Menyetujui 2',
            'htmlOptions' => array('style' => 'text-align: center;'),
            'type' => 'raw',
            'value' => function ($data) {
                $btn = "";
                $alert = "Approval hanya bisa dilakukan oleh ".$data->pegawaimenyetujui2->namaLengkap;

                if ($data->status_persetujuan == Params::STATUS_PENGAJUAN_KASBON_PERSETUJUAN && !empty($data->tgl_pegawai_menyetuji1) && empty($data->tgl_pegawai_menyetujui2)) {
                    if (Yii::app()->user->getState('pegawai_id') == $data->pegawai_menyetujui2_id) {
                        $btn .= CHtml::link("<icon class='icon-form-check'></icon>",'javascript:;',array('rel'=>'tooltip','title'=>'Verifikasi Pegawai Menyetujui 2','onclick'=>'verifikasi('.$data->pengajuankasbon_id.', "tgl_pegawai_menyetujui2")'));
                    } else {
                        $btn .= CHtml::link("<icon class='icon-form-check'></icon>",'javascript:;',array('rel'=>'tooltip','title'=>'Verifikasi Pegawai Menyetujui 2','onclick'=>'myAlert("'.$alert.'")'));

                    }
                } else if (!empty($data->tgl_pegawai_menyetujui2)) {
                    $btn .= "<br>";
                    $btn .= date("d M Y", strtotime($data->tgl_pegawai_menyetujui2));
                } 

                return $data->pegawaimenyetujui2->namaLengkap; 
            } 
        ], 
        [
            'header' => 'Status Pengajuan',
            'htmlOptions' => array('style' => 'text-align: center;'),
            'type' => 'raw',
            'value' => function ($data) {
                return Params::getStatusKasbon($data->status_persetujuan); 
            } 
        ], 
        [
            'header' => 'Ubah Pengajuan',
            'htmlOptions' => array('style' => 'text-align: center;'),
            'value' => function ($data) {
                $disable = true;
                if ($data['status_persetujuan'] == Params::STATUS_PENGAJUAN_KASBON_PENGAJUAN) {
                    $disable = false;   
                }
                echo CHtml::link("<span class='fa fa-pencil'></span>", 
                        $this->createUrl('index', ['id' => $data['pengajuankasbon_id']]), [
                        'disabled' => $disable, 'class' => 'btn btn-info', 'rel' => 'tooltip', 'title' => 'Mengubah Data']);
            } 
        ], 
        [
            'header' => 'Pengeluaran Kas',
            'htmlOptions' => array('style' => 'text-align: center;'),
            // 'visible' => $lihatKasir, 
            'value' => function ($data) {
                $disable = true;
                if ($data['status_persetujuan'] == Params::STATUS_PENGAJUAN_KASBON_DISETUJUI 
                    && Yii::app()->user->getState('pegawai_id') == $data->pegawai_mengajukan_id
                ) {
                    $disable = false;   
                }
                // $modDetail = LpjT::model()->findAllByAttributes(['pengajuankasbon_id' => $data->pengajuankasbon_id]);

                if (!empty($data->pengeluaranumum_id)) {
                    echo CHtml::link("<span class='fa fa-print'></span>", $this->createUrl('printPengeluaran', ['id' => $data['pengajuankasbon_id']]), ['class' => 'btn btn-blue', 'rel' => 'tooltip', 'title' => 'Mencetak Pengeluaran Kas']);
                } else {
                    echo CHtml::link("Pengeluaran Kas", 
                            $this->createUrl('pengeluaranKas', ['id' => $data['pengajuankasbon_id']]), [
                            'disabled' => $disable, 'class' => 'btn btn-info', 'rel' => 'tooltip', 'title' => 'Pengeluaran Kas']);
                }
            } 
        ], 
        [
            'header' => 'LPJ',
            'htmlOptions' => array('style' => 'text-align: center;'),
            // 'visible' => $lihatKasir, 
            'value' => function ($data) {
                $disable = true;
                if ($data['status_persetujuan'] == Params::STATUS_PENGAJUAN_KASBON_DISETUJUI 
                    && !empty($data->pengeluaranumum_id)
                    && Yii::app()->user->getState('pegawai_id') == $data->pegawai_mengajukan_id
                ) {
                    $disable = false;   
                }
                $modDetail = LpjT::model()->findAllByAttributes(['pengajuankasbon_id' => $data->pengajuankasbon_id]);

                if (!empty($data->penerimaanumum_id)) {
                    echo CHtml::link("<span class='fa fa-print'></span>", $this->createUrl('printPenerimaan', ['id' => $data['pengajuankasbon_id']]), ['class' => 'btn btn-blue', 'rel' => 'tooltip', 'title' => 'Mencetak LPJ']);
                } else {
                    echo CHtml::link("Buat LPJ", 
                            $this->createUrl('realisasi', ['id' => $data['pengajuankasbon_id']]), [
                            'disabled' => $disable, 'class' => 'btn btn-info', 'rel' => 'tooltip', 'title' => 'Menambahkan LPJ']);
                }
            } 
        ], 
        [
            'header' => 'Cetak',
            'visible' => $lihatKasir, 
            'htmlOptions' => array('style' => 'text-align: center;'),
            'value' => function ($data) {
                echo CHtml::link("<span class='fa fa-print'></span>", $this->createUrl('print', ['id' => $data['pengajuankasbon_id']]), ['class' => 'btn btn-success', 'target' => '_blank', 'rel' => 'tooltip', 'title' => 'Mencetak Data']);
            },
        ], 
        [
            'header' => 'Batal',
            'visible' => $lihatUnit, 
            'htmlOptions' => array('style' => 'text-align: center;'),
            'type' => 'raw',
            'value' => function ($data){                               
                
                $btn = 'btn btn-sm btn-primary disabled';
                $dis  = true;
                if ($data->status_persetujuan == Params::STATUS_PENGAJUAN_KASBON_PENGAJUAN){
                    if (in_array(Yii::app()->user->getState('pegawai_id'), array($data->pegawai_menyetujui1_id, $data->pegawai_mengajukan_id)) && empty($data->tgl_pegawai_menyetuji1)) {
                        $btn = 'btn btn-sm btn-danger';
                        $dis = false;
                    }
                }
                
                return CHtml::link("<span style='font-size:15px;' class='fa fa-times'></span>",'javascript:;',array('disabled'=>$dis,'class'=>$btn,'rel'=>'tooltip','title'=>'Membatalkan Pengajuan Kasbon','onclick'=>'batal('.$data->pengajuankasbon_id.')'));
            },
            'visible' => $visible,
            'htmlOptions' => ['style'=>'text-align:center']
        ],
        [
            'header' => 'Status Validasi',
            'htmlOptions' => array('style' => 'text-align: center;'),
            'type' => 'raw',
            'visible' => $lihatKasir,
            'value' => function ($data) {
                $alert = "Approval hanya bisa dilakukan jika sudah mengisi data LPJ";

                $modDetail = LpjT::model()->findAllByAttributes(['pengajuankasbon_id' => $data->pengajuankasbon_id]);
                $btn = CHtml::link($data->status_validasi,'javascript:;',array('class' => "btn btn-danger", 'rel'=>'tooltip','title'=>'Verifikasi Status Validasi','onclick'=>'myAlert("'.$alert.'")'));

                if (!empty($modDetail)) {
                    if ($data->status_validasi == Params::STATUS_VALIDASI_KASBON_BELUM_DIVERIFIKASI) {
                        $btn = CHtml::link($data->status_validasi,'javascript:;',array('rel'=>'tooltip', 'class' => "btn btn-danger",'title'=>'Verifikasi Pegawai Kasir','onclick'=>'verifikasiKasir('.$data->pengajuankasbon_id.')'));
                    } else {
                        $btn = CHtml::link($data->status_validasi,'javascript:;',array('class' => 'btn btn-success','rel'=>'tooltip'));
                    }
                }

                return $btn; 
            } 
        ], 
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});            
    }',
));
?>

<?php 
    $urlHapus = $this->createUrl('batalKasbon');
    $urlVerifikasi = $this->createUrl('verifikasi');
    $urlVerifikasiKasir = $this->createUrl('verifikasiKasir');
?>

<script>
     const batal = (id) => {
        myConfirm("Apakah Anda yakin ingin membatalkan data ini?","Perhatian!", function(r){
            if (r){
                $.ajax({
                    type: 'POST',
                    url:'<?php echo $urlHapus ?>',
                    data: {id:id},
                    dataType: "json",
                    success: function (data) {                                    
                        if (data.sukses == 1){
                            toastr.success("Data berhasil dihapus","Perhatian!");
                            refInfo();
                        }else{
                            toastr.error("Data gagal dihapus","Perhatian!");
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {                                    
                    }
                });
            }
        }); 
    }

    const verifikasi = (id, jenis) => {
        myConfirm("Apakah Anda yakin ingin memverifikasi data ini?","Perhatian!", function(r){
            if (r){
                $.ajax({
                    type: 'POST',
                    url:'<?php echo $urlVerifikasi ?>',
                    data: {id:id, jenis:jenis},
                    dataType: "json",
                    success: function (data) {                                    
                        if (data.sukses == 1){
                            toastr.success("Data berhasil diverifikasi","Perhatian!");
                            refInfo();
                        }else{
                            toastr.error("Data gagal diverifikasi","Perhatian!");
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {                                    
                    }
                });
            }
        }); 
    }

    const verifikasiKasir = (id) => {
        myConfirm("Apakah Anda yakin ingin memverifikasi data ini?","Perhatian!", function(r){
            if (r){
                $.ajax({
                    type: 'POST',
                    url:'<?php echo $urlVerifikasiKasir ?>',
                    data: {id:id},
                    dataType: "json",
                    success: function (data) {                                    
                        if (data.sukses == 1){
                            toastr.success("Data berhasil diverifikasi","Perhatian!");
                            refInfo();
                        }else{
                            toastr.error("Data gagal diverifikasi","Perhatian!");
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {                                    
                    }
                });
            }
        }); 
    }

    const refInfo = () => {
        $.fn.yiiGridView.update('informasi-pengajuankasbon-grid', {
            data: $("#informasi-pengajuankasbon-r-search").serialize()
        });
    }
</script>