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
            'value' => 'MyFormatter::formatDateTimeForUser($data->create_time)',
        ),
        array(
            'name' => 'Petugas Pengisi',
            'type' => 'raw',
            'value' => 'empty($data->petugaspengisi) ? "-" : $data->petugaspengisi->namaLengkap',
        ),
        array(
            'name' => 'Total Skor',
            'type' => 'raw',
            'value' => '$data->jumlahskor',
        ),
        array(
            'header' => 'Lihat',
            'type' =>'raw',
            'value' => function($data) use (&$typeinstalasi) {
                $daftar = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                $typeinstalasi = "RJ";
                if (empty($daftar->pasienadmisi_id)) {
                    if ($daftar->instalasi_id == Params::INSTALASI_ID_RJ) {
                        $typeinstalasi = "RJ";
                    }
                    if ($daftar->instalasi_id == Params::INSTALASI_ID_RD) {
                        $typeinstalasi = "RD";
                    }
                } else {
                    $typeinstalasi = "RI";
                }
                
                return CHtml::link('<i class="glyphicon glyphicon-eye-open"><i>', $this->createUrl('view', array(
                    'pendaftaran_id'=>$data->pendaftaran_id,
                    'skriningpasien_id'=>$data->skriningpasien_id,
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
            'value' => function($data) use (&$typeinstalasi) {
                return CHtml::link('<i class="icon-pencil"></i>', '#', array(
                        'onclick' => "parent.editSkrining(" . $data->pendaftaran_id . ", '" . $typeinstalasi . "', " . $data->skriningpasien_id . "); return false;"
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
                        'onclick' => "hapusSkrining(" . $data->skriningpasien_id . "); return false;"
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
                        'onclick' => 'printRiwayat(' . $data->skriningpasien_id . ',"PRINT"); return false'
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
    function printRiwayat(skrinning_id, caraPrint)
    {
        window.open('<?php echo $this->createUrl('printRiwayat'); ?>&skriningpasien_id=' + skrinning_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=793,height=1122,scrollbars=yes');
    }
    
    function hapusSkrining(skrinning_id) {
        myConfirm("Anda yaking untuk menghapus data skrining pasien ini ?", "Peringatan", function(r) {
            if (r) {
                $.post("<?php echo $this->createUrl('delete'); ?>", {
                    id: skrinning_id,
                }, function(data) {
                    if (data.ok == 1) {
                        myAlert(data.msg);
                        $.fn.yiiGridView.update('riwayataskep-grid');
                    } else {
                        myAlert(data.msg);
                    }
                }, 'json')
            };
        });
    }
</script>
