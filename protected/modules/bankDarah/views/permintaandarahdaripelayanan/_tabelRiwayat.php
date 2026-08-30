
<?php
$this->widget('ext.bootstrap.widgets.MergeHeaderGroupGridView', array(
    'id' => 'asesmen-awal-keperawatan-grid',
    'dataProvider' => $model->searchRiwayat(),
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-condensed table-bordered',
    'mergeColumns' => array('tglpermintaan', 'no_permintaandarah', 'permintaandarah_id'),
    'columns' => array(
        array(
            'header' => 'No',
            'value' => '$row+1',
        ),
        array(
            'header' => 'Tanggal kirisssm permintaan darah',
            'name' => 'tglpermintaan',
            'value' => function($data) {
                return MyFormatter::formatDateTimeForUser($data->tglpermintaan);
            },
        ),
        array(
            'header' => 'No formulir permintaan',
            'name' => 'no_permintaandarah',
            'value' => function($data) {
                return $data->no_permintaandarah;
            },
        ),
        array(
            'header' => 'Jenis darah yang diperlukan',
            'value' => function($data) {
                return $data->singkatan_komp;
            },
        ),
        array(
            'header' => 'Jumlah',
            'value' => function($data) {
                return $data->jml;
            },
        ),
        array(
            'header' => 'Dokter Perujuk',
            'name' => 'no_permintaandarah',
            'value' => function($data) {
                $cekPegawai = PegawaiM::model()->findByPk($data->dpjp_id);
                return !empty($cekPegawai) ? $cekPegawai->namaLengkap : '';
            },
        ),
        array(
            'header' => 'Ubah',
            'name' => 'no_permintaandarah',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => function($data) {
                return CHtml::Link("<span style='font-size:17px'><i class='glyphicon glyphicon-pencil'></i></span>", Yii::app()->controller->createUrl("index", array("permintaandarah_id" => $data->permintaandarah_id, "pendaftaran_id" => $data->pendaftaran_id, "update" => 'update')), array("class" => "",
                            "rel" => "tooltip",
                            "title" => "Klik untuk Ubah",
                ));
            },
        ),
        array(
            'header' => 'Detail',
            'name' => 'no_permintaandarah',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => function($data) {
                return CHtml::Link("<span style='font-size:17px'><i class='glyphicon glyphicon-eye-open'></i></span>", Yii::app()->controller->createUrl("index", array("permintaandarah_id" => $data->permintaandarah_id, "pendaftaran_id" => $data->pendaftaran_id, "detail" => 'detail')), array("class" => "",
                            "rel" => "tooltip",
                            "title" => "Klik untuk Ubah",
                ));
            },
        ),
        array(
            'header' => 'Hapus',
            'name' => 'no_permintaandarah',
            'type' => 'raw',
            'value' => function ($data) {
                if ($data->permintaandarah_id) {
                    $tanggal_dibuat = new DateTime($data->create_time);
                    $tanggal_sekarang = new DateTime(date('Y-m-d H:i:s'));
                    $d = $tanggal_sekarang->diff($tanggal_dibuat)->d;

                    if ($d < 1) {
                        return CHtml::link("<span style='font-size:17px'><i class='glyphicon glyphicon-trash'></i></span>", "javascript:deleteRecord($data->permintaandarah_id)", array("id" => $data->permintaandarah_id, "rel" => "tooltip", "title" => "Hapus Kalibrasi"));
                    } else {
                        return '<span style="font-size:17px"><i class="glyphicon glyphicon-trash"></i></span>';
                    }
                }
            },
            'htmlOptions' => array('style' => 'text-align: center; width:80px'),
        ),
        array(
            'header' => 'Cetak',
            'name' => 'no_permintaandarah',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => function($data) {
                return CHtml::link("<span style='font-size:17px'><i class='fa fa-print'></i></span>", 'javascript:void(0);', array('onclick' => "printRiwayat('PDF'," . $data->permintaandarah_id . ")", 'disabled' => false));
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
        myConfirm('Yakin Akan Menghapus Data ini ?', 'Perhatian!', function (r) {
            if (r) {
                $.post(url, {id: id},
                        function (data) {
                            if (data.status == 'sukses') {
                                $.fn.yiiGridView.update('asesmen-awal-keperawatan-grid');
                            } else {
                                myAlert('Data Gagal di Hapus')
                            }
                        }, "json");
            }
        });
    }
</script>