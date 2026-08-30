<?php 
$arr =  array(
    array(
        'header' => 'No.',
        'value' => '$row+1',
    ),
    array(
        'header' => 'Tgl. Pemeriksaan',
        'value' => function ($data) {
            return MyFormatter::formatDateTimeForUser($data->tglpemeriksaannyeri);
        },
    ),
    array(
        'header' => 'Score',
        'value' => function ($data) {
            return   $data->score_skalanyeri;
        },
    ),
    array(
        'header' => 'Keterangan',
        'value' => function ($data) {
            return   $data->keteranganskala_nyeri;
        },
    ),

    array(
        'header' => 'Rincian',
        'type' => 'raw',
        'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        'value' => function ($data) {
            return CHtml::Link(
                "<span style='font-size:17px'><i class='icon-form-lihat'></i></span>",
                Yii::app()->controller->createUrl("lihatDetail", array("asesmentnyeri_id" => $data->asesmentnyeri_id, "detail" => 'detail')),
                array(
                    "class" => "",
                    "target" => "frameDetail",
                    "onclick" => "$('#dialogDetail').dialog('open');",
                    "rel" => "tooltip",
                    "title" => "Klik untuk melihat detail",
                )
            );
        },
    ),
    

    array(
        'header' => 'Hapus',
        'type' => 'raw',
        'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        'value' => function($data, $row) {
            $onclick = 'window.parent.myAlert("Tidak bisa dihapus karena hak akses tidak sesuai")';
            
            $bisa_hapus = CustomFunction::hakAksesHapus(Yii::app()->user->getState('loginpemakai_id'), $data->create_ruangan_id, $data->create_loginpemakai_id);


            if($data->asesmentnyeri_id){
                if($bisa_hapus) {
                    $onclick = "javascript:deleteRecord($data->asesmentnyeri_id)";
                }
                if($row > 0) {
                    $onclick = 'javascript:window.parent.myAlert("Data tidak dapat dihapus karena sudah valid")';
                }
                echo CHtml::link("<i class='icon-form-sampah'></i> ", $onclick,array("id"=>"$data->asesmentnyeri_id","rel"=>"tooltip","title"=>"Hapus Kalibrasi"));
            } else {
                if($bisa_hapus) {
                    $onclick = "javascript:deleteRecord($data->invkalibrasi_id)";
                }
                if($row > 0) {
                    $onclick = 'javascript:window.parent.myAlert("Data tidak dapat dihapus karena sudah valid")';
                }
                echo CHtml::link("<i class='glyphicon glyphicon-trash'></i> ", $onclick,array("id"=>"$data->invkalibrasi_id","rel"=>"tooltip","title"=>"Hapus Asesmen Nyeri"));
            }
           
        },
    ),


);

$modul_login = Yii::app()->user->getState('modul_id');
$modul_hide = Params::MODUL_ID_HIDE;

$hide_edit = !in_array($modul_login, $modul_hide) ? true : false;

if($hide_edit) {
    array_push($arr, array(
        'header' => 'Ubah',
        'type' => 'raw',
        'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        'value' => function ($data) {
            return CHtml::Link(
                "<span style='font-size:17px'><i class='icon-form-ubah'></i></span>",
                Yii::app()->controller->createUrl("index", array("asesmentnyeri_id" => $data->asesmentnyeri_id, "pendaftaran_id" => $data->pendaftaran_id, "update" => 'update')),
                array(
                    "class" => "",
    
                    "rel" => "tooltip",
                    "title" => "Klik untuk Ubah",
                )
            );
        },
    ),);
}

?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Aspek Yang Dinilai</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'penilaianiki-indikator-m-grid',
            'dataProvider' => $model->searchRiwayat(),
            'template' => "{items}",
            'itemsCssClass' => 'table table-striped table-condensed',
            'columns' => $arr,
        )); ?>
    </div>
</div>
<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
$url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);

?>

<script>
    function deleteRecord(id) {
        var id = id;

        console.log(id);
        var url = '<?php echo $url . "/deleteriwayat"; ?>';
        window.parent.myConfirm('Yakin Akan Menghapus Data ini?', 'Perhatian!', function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.status == 'sukses') {
                            $.fn.yiiGridView.update('data-m-grid');
                        } else {
                            window.parent.myAlert('Data gagal dihapus!')
                        }
                    }, "json");
            }
        });
    }
</script>
<script>
    function deleteRecord(id) {
        var id = id;

        console.log(id);
        var url = '<?php echo $url . "/deleteriwayat"; ?>';
        window.parent.myConfirm('Yakin Akan Menghapus Data ini?', 'Perhatian!', function(r) {
            if (r) {
                $.post(url, {
                        id: id
                    },
                    function(data) {
                        if (data.status == 'sukses') {
                            $.fn.yiiGridView.update('penilaianiki-indikator-m-grid');
                        } else {
                            window.parent.myAlert('Data gagal dihapus!')
                        }
                    }, "json");
            }
        });
    }
</script>