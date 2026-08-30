<?php

$model->pasien_id = $modPasien->pasien_id;
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'riwayataskep-grid',
    'dataProvider' => $model->searchRiwayat(),
    'template' => "{summary}\n{items}\n{pager}",
    'replaceUrl' => true,
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'No',
            'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
        ),
        array(
            'name' => 'Tanggal',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_evaluasi)',
        ),
        array(
            'name' => 'Ruangan',
            'type' => 'raw',
            'value' => '$data->ruangan->ruangan_nama',
        ),
        array(
            'name' => 'Kelas',
            'type' => 'raw',
            'value' => '$data->kelaspelayanan->kelaspelayanan_nama',
        ),
        array(
            'name' => 'Diagnosa',
            'type' => 'raw',
            'value' => '(isset($data->diagnosa)?$data->diagnosa->diagnosa_nama:"-")',
        ),
        array(
            'name' => 'Manager Pelayanan Pasien',
            'type' => 'raw',
            'value' => '$data->petugaspengisi->namaLengkap',
        ),
        array(
            'header' => 'Lihat',
            'type' =>'raw',
            'value' => function($data) use ($typeinstalasi) {
                return CHtml::link('<i class="glyphicon glyphicon-eye-open"><i>', $this->createUrl('view', array(
                    'pendaftaran_id'=>0,
                    'pasien_id'=>$data->pasien_id,
                    'evaluasi_id'=>$data->evaluasiawal_id,
                    'typeinstalasi'=>$typeinstalasi,
                )));
            },
            'htmlOptions' => array(
                'style' => 'text-align: center;'
            ),
        ),
        array(
            'header' => 'Edit',
            'type' => 'raw',
            'value' => function($data) use ($typeinstalasi) {
                return CHtml::link('<i class="icon-pencil"></i>', '#', array(
                        'onclick' => "parent.editEvaluasi(" . $data->pasien_id . ", '" . $typeinstalasi . "', " . $data->evaluasiawal_id . "); return false;"
                ));
            },
            'htmlOptions' => array(
                'style' => 'text-align: center;'
            ),
        ),
        array(
            'header' => 'Hapus',
            'type' => 'raw',
            'value' => function($data) {
                return CHtml::link('<i class="icon-trash"></i>', '#', array(
                        'onclick' => "hapusEvaluasi(" . $data->evaluasiawal_id . "); return false;"
                ));
            },
            'htmlOptions' => array(
                'style' => 'text-align: center;'
            ),
        ),
        array(
            'header' => 'Cetak',
            'type' => 'raw',
            'value' => function($data) {
                return CHtml::link('<i class="entypo-print" style="font-size: 14pt"></i>', 'javascript:void(0)', array(
                        'onclick' => 'printRiwayat(' . $data->evaluasiawal_id . ',"PRINT"); return false'
                ));
            },
            'htmlOptions' => array(
                'style' => 'text-align: center;',
            )
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>
<script type="text/javascript">
    function printRiwayat(evaluasi_id, caraPrint)
    {
        window.open('<?php echo $this->createUrl('printRiwayat'); ?>&evaluasi_id=' + evaluasi_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=793,height=1122,scrollbars=yes');
    }
    
    function hapusEvaluasi(evaluasi_id) {
        myConfirm("Anda yaking untuk menghapus data skrining pasien ini ?", "Peringatan", function(r) {
            if (r) {
                $.post("<?php echo $this->createUrl('delete'); ?>", {
                    id: evaluasi_id,
                }, function(data) {
                    if (data.ok == 1) {
                        myAlert(data.msg);
                        $.fn.yiiGridView.update('riwayataskep-grid');
                    } else {
                        myAlert(data.msg);
                    }
                }, 'json');
            }
        });
    }
</script>
