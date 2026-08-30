
<?php
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'monitoring-post-hd-grid',
    'dataProvider' => $modMonitoringPostHd->searchRiwayat(),
    'template' => "{items}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'No',
            'value' => '$row+1',
        ),
        array(
            'header' => 'Tgl Pendaftaran / No. Pendaftaran',
            'value' => function($data) {
                return MyFormatter::formatDateTimeForUser($data->pendaftaran->tgl_pendaftaran) . ' / ' . $data->pendaftaran->no_pendaftaran;
            },
        ),
        array(
            'header' => 'Tgl dan Jam',
            'value' => function($data) {
                return MyFormatter::formatDateTimeForUser($data->waktu);
            },
        ),
        array(
            'header' => 'Perawat 1',
            'value' => function($data) {
                if (!empty($data->perawat1_id)) {
                    return !empty($data->perawat1->namaLengkap) ? $data->perawat1->namaLengkap : '';
                }
            },
        ),
        array(
            'header' => 'Perawat 2',
            'value' => function($data) {
                if (!empty($data->perawat2_id2)) {
                    return !empty($data->perawat2Id2->namaLengkap) ? $data->perawat2Id2->namaLengkap : '';
                }
            },
        ),
        array(
            'header' => 'DPJP',
            'value' => function($data) {
                if (!empty($data->dpjp_id)) {
                    return !empty($data->dpjp->namaLengkap) ? $data->dpjp->namaLengkap : '';
                }
            },
        ),
        array(
            'header' => 'Lihat',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => function($data) {
                return CHtml::Link("<span style='font-size:17px'><i class='glyphicon glyphicon-pencil'></i></span>", 'javascript:void(0)', array(
                            "data-placement" => "left",
                            "rel" => "tooltip",
                            "title" => "Klik untuk lihat data",
                            "onclick" => "myAlert('Coming Soon')"
                ));
            },
        ),
        array(
            'header' => 'Ubah',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => function($data) {
                return CHtml::Link("<span style='font-size:17px'><i class='glyphicon glyphicon-pencil'></i></span>", 'javascript:void(0)', array(
                            "data-placement" => "left",
                            "rel" => "tooltip",
                            "title" => "Klik untuk mengubah data",
                            "onclick" => "myAlert('Coming Soon')"
                ));
            },
        ),
        array(
            'header' => 'Hapus',
            'type' => 'raw',
            'value' => function ($data) {
                return CHtml::Link("<span style='font-size:17px'><i class='glyphicon glyphicon-trash'></i></span>", 'javascript:void(0)', array(
                            "data-placement" => "left",
                            "rel" => "tooltip",
                            "title" => "Klik untuk menghapus data",
                            "onclick" => "myAlert('Coming Soon')"
                ));
            },
            'htmlOptions' => array('style' => 'text-align: center; width:80px'),
        ),
        array(
            'header' => 'Cetak',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => function($data) {
                return CHtml::Link("<span style='font-size:17px'><i class='fa fa-print'></i></span>", 'javascript:void(0)', array(
                            "data-placement" => "left",
                            "rel" => "tooltip",
                            "title" => "Klik untuk mencetak data",
                            "onclick" => "myAlert('Coming Soon')"
                ));
            },
        ),
        array(
            'header' => 'Salin',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => function($data) {
                return CHtml::Link("<span style='font-size:17px'><i class='fa fa-clipboard'></i></span>", 'javascript:void(0)', array(
                            "data-placement" => "left",
                            "rel" => "tooltip",
                            "title" => "Klik untuk menyalin data",
                            "onclick" => "myAlert('Coming Soon')"
                ));
            },
        ),
    ),
));
?>
<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
$url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);
?>

<script>
    function deleteRecord(id) {
        var id = id;

        console.log(id);
        var url = '<?php echo $url . "/deleteriwayat"; ?>';
        window.parent.myConfirm('Yakin Akan Menghapus Data ini ?', 'Perhatian!', function (r) {
            if (r) {
                $.post(url, {id: id},
                        function (data) {
                            if (data.status == 'sukses') {
                                $.fn.yiiGridView.update('monitoring-post-hd-grid');
                            } else {
                                myAlert('Data Gagal di Hapus')
                            }
                        }, "json");
            }
        });
    }
</script>