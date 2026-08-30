
<?php
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'monitoring-pre-hd-grid',
    'dataProvider' => $model->searchRiwayat($model->pasien_id),
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
                if (!empty($data->perawat2_id)) {
                    return !empty($data->perawat2->namaLengkap) ? $data->perawat2->namaLengkap : '';
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
                return CHtml::Link("<span style='font-size:17px'><i class='glyphicon glyphicon-eye-open'></i></span>", Yii::app()->controller->createUrl("index", array("id" => $data->monitoring_pre_hd_id, "pendaftaran_id" => $data->pendaftaran_id, "detail" => 'detail')), array("class" => "",
                            "rel" => "tooltip",
                            "title" => "Klik untuk Ubah",
                ));
            },
        ),
        array(
            'header' => 'Ubah',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => function($data) {
                return CHtml::Link("<span style='font-size:17px'><i class='glyphicon glyphicon-pencil'></i></span>", Yii::app()->controller->createUrl("index", array("id" => $data->monitoring_pre_hd_id, "pendaftaran_id" => $data->pendaftaran_id, "update" => 'update')), array("class" => "",
                            "rel" => "tooltip",
                            "title" => "Klik untuk Ubah",
                ));
            },
        ),
        array(
            'header' => 'Hapus',
            'type' => 'raw',
            'value' => function ($data) {
                return CHtml::link("<span style='font-size:17px'><i class='glyphicon glyphicon-trash'></i></span>", "javascript:deleteRecordPre($data->monitoring_pre_hd_id)", array("id" => $data->monitoring_pre_hd_id, "rel" => "tooltip", "title" => "Hapus Data"));
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
                            "onclick" => "print('".$data->monitoring_pre_hd_id."')"
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
                            "onclick" => "salinRiwayat(" . $data->monitoring_pre_hd_id . "); return false; "
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
    function deleteRecordPre(id) {
        var id = id;

        console.log(id);
        var url = '<?php echo $url . "/deleteriwayat"; ?>';
        window.parent.myConfirm('Apakah Anda Yakin Menghapus Data ini ?', 'Perhatian!', function (r) {
            if (r) {
                $.post(url, {id: id},
                        function (data) {
                            $.fn.yiiGridView.update('monitoring-pre-hd-grid');
                        }, "json");
            }
        });
    }
    
    function print(id){
        window.open('<?php echo $this->createUrl('print'); ?>&id='+id,'printwin','left=100,top=100,width=640,height=640');
    }
</script>