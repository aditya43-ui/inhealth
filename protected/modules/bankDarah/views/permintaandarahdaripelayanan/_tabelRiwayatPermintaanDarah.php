<?php

$modul_login = Yii::app()->user->getState('modul_id');
$modul_hide = Params::MODUL_ID_HIDE;

$hide_edit = in_array($modul_login, $modul_hide) ? "hidden" : "";
$visible = isset($_GET['lihat']) ? false : true;
$column =  array(
    array(
        'header' => 'No',
        'value' => '$row+1',
    ),
    array(
        'header' => 'Tanggal kirim permintaan darah',
        'name' => 'tgl_kirimpasien',
        'value' => function($data) {
            return MyFormatter::formatDateTimeForUser($data->tgl_kirimpasien);
        },
    ),
    array(
        'header' => 'No formulir permintaan',
        'name' => 'no_permintaandarah',
        'value' => function($data) {
           echo $data->no_permintaan ?? '';
        },
    ),
    array(
        'header' => 'Jenis darah yang diperlukan',
        'value' => function($data) {
            if(count($data->banyakpermintaanpenunjang) > 0) {
                foreach ($data->banyakpermintaanpenunjang as $i => $data) {
                    echo $i+1 . '. '; 
                    echo $data->jeniskomponendarah->jeniskomponenedarah_nama ?? '';
                    echo '<br>';
                }
            }
        },
    ),
   
);

if(!$hide_edit && $visible) {
    array_push($column,
    array(
        'header' => 'Ubah',
        'name' => 'no_permintaandarah',
        'type' => 'raw',
        'htmlOptions' => array('style' => 'text-align:center;  width:80px;'),
        'value' => function($data) {
            return CHtml::Link("<span style='font-size:17px'><i class='glyphicon glyphicon-pencil'></i></span>", Yii::app()->controller->createUrl("index", array("pasienkirimkeunitlain_id" => $data->pasienkirimkeunitlain_id, "pendaftaran_id" => $data->pendaftaran_id, "update" => 'update')), array("class" => "",
                        "rel" => "tooltip",
                        "title" => "Klik untuk Ubah",
            ));
        },
    )
);
}

if($visible) {
    array_push($column, 
    array(
        'header' => 'Hapus',
        'name' => 'no_permintaandarah',
        'type' => 'raw',
        'value' => function ($data) {
            if ($data->pasienkirimkeunitlain_id) {
                $tanggal_dibuat = new DateTime($data->create_time);
                $tanggal_sekarang = new DateTime(date('Y-m-d H:i:s'));
                $d = $tanggal_sekarang->diff($tanggal_dibuat)->d;
    
                // echo strval($tanggal_sekarang);
                // echo strval($tanggal_dibuat);
    
                $onclick = 'javascript:window.parent.myAlert("Tidak bisa dihapus karena hak akses tidak sesuai")';
    
                $bisa_hapus = CustomFunction::hakAksesHapus(Yii::app()->user->getState('loginpemakai_id'), $data->create_ruangan, $data->create_loginpemakai_id);
    
                if($bisa_hapus) {
                    $onclick = "javascript:deleteRecord($data->pasienkirimkeunitlain_id)";
                }
    
                if ($d < 1) {
                    return CHtml::link("<span style='font-size:17px'><i class='glyphicon glyphicon-trash'></i></span>", $onclick, array("id" => $data->pasienkirimkeunitlain_id, "rel" => "tooltip", "title" => "Hapus Kalibrasi"));
                } else {
                    return '<span style="font-size:17px"><i class="glyphicon glyphicon-trash"></i></span>';
                }
            }
        },
        'htmlOptions' => array('style' => 'text-align: center; width:80px;'),
    )
    );
}

?>


<?php
$this->widget('ext.bootstrap.widgets.MergeHeaderGroupGridView', array(
    'id' => 'asesmen-awal-keperawatan-grid',
    'dataProvider' => $modRiwayatPermintaanDarah->search(),
    'template' => "{items}",
    'itemsCssClass' => 'table table-striped table-condensed table-bordered',
    'columns' => $column,
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
        var url = '<?php echo $url . "/DeleteriwayatPermintaan"; ?>';
        window.parent.myConfirm('Yakin Akan Menghapus Data ini ?', 'Perhatian!', function (r) {
            if (r) {
                $.post(url, {id: id},
                        function (data) {
                            if (data.sukses == 1) {
                                toastr.success('Data berhasil dihapus', 'Perhatian!');
                                $.fn.yiiGridView.update('asesmen-awal-keperawatan-grid');
                                $.fn.yiiGridView.update('grid-statusterima');
                            } else {
                                window.parent.myAlert(data.pesan);
                            }
                        }, "json");
            }
        });
    }
</script>