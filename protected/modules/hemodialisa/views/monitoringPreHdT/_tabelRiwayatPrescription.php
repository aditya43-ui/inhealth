
<?php
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'prescription-grid',
    'dataProvider' => $modPrescription->searchRiwayat(),
    'template' => "{items}",
    'itemsCssClass' => 'table table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'No',
            'value' => '$row+1',
        ),
        array(
            'header' => 'Tgl Prescription',
            'value' => function($data) {
                return MyFormatter::formatDateTimeForUser($data->waktu_prescription);
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
            'header' => 'Prescription Dokter',
            'value' => function($data) {
                if ($data->prescription_dokter_akut == true) {
                    echo "Akut";
                } elseif ($data->prescription_dokter_kronis == true) {
                    echo "Kronis";
                } elseif ($data->prescription_dokter_pirrt == true) {
                    echo "PIRRT";
                } else {
                    echo "";
                }
            },
        ),
        array(
            'header' => 'Lihat',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => function($data) {
                return CHtml::Link("<span style='font-size:17px;'><i class='glyphicon glyphicon-eye-open'></i></span>", Yii::app()->controller->createUrl("/hemodialisa/prescriptionTHD/index", array("pendaftaran_id" => $data->pendaftaran_id, "prescription_id" => $data->prescription_hd_id, "mode" => 'view', "frame" => 'frame')), array("class" => "",
                            "target" => "frameDetail",
                            "onclick" => "$('#dialogDetail').dialog('open');",
                            "rel" => "tooltip",
                            'data-placement' => 'left',
                            "title" => "Klik untuk melihat detail",
                ));
            },
        ),
    ),
));
// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetail',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail Rincian Prescription Dokter',
        'autoOpen' => false,
        'minWidth' => 1000,
        'minHeight' => 100,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="frameDetail" width="100%" height="500" style="border: none;">
</iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
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
                                $.fn.yiiGridView.update('prescription-grid');
                            } else {
                                myAlert('Data Gagal di Hapus')
                            }
                        }, "json");
            }
        });
    }
</script>