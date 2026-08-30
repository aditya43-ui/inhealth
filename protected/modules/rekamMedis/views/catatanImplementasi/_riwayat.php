<?php

if (empty($typeinstalasi)) {
    $typeinstalasi = 'RJ';
}

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
                return CHtml::link('<i class="glyphicon glyphicon-eye-open"><i>', $this->createUrl('printRiwayat', array(
                    'catatanimplementasi_id'=>$data->catatanimplementasi_id,
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
                        'onclick' => "parent.editImplementasi(" . $data->pasien_id . ", '" . $typeinstalasi . "', " . $data->catatanimplementasi_id . "); return false;"
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
                        'onclick' => "hapusImplementasi(" . $data->catatanimplementasi_id . "); return false;"
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
                        'onclick' => 'printRiwayat(' . $data->catatanimplementasi_id . ',"PRINT"); return false'
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
    function printRiwayat(catatanimplementasi_id, caraPrint)
    {
        window.open('<?php echo $this->createUrl('printRiwayat'); ?>&catatanimplementasi_id=' + catatanimplementasi_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=793,height=1122,scrollbars=yes');
    }
    
    function hapusImplementasi(catatanimplementasi_id) {
        myConfirm("Anda yaking untuk menghapus data implementasi pasien ini ?", "Peringatan", function(r) {
            if (r) {
                $.post("<?php echo $this->createUrl('delete'); ?>", {
                    id: catatanimplementasi_id,
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
