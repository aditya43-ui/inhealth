<?php 

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'hasilpemeriksaan-t-grid',
    'dataProvider' => $modRiwayat->searchRiwayat(),
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'dropdownItemKelipatan' => 5,
    'columns' => array(
        array(
            'header' => 'Tindakan',
            'type' => 'raw',
            'value' => '$data->ruangan->ruangan_nama ?? ""'
        ),
        array(
            'header' => 'Petugas Pengisi',
            'type' => 'raw',
            'value' => '$data->pegawai->namaLengkap'
        ),
        array(
            'header' => 'Tanggal Pemeriksaan',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tglpemeriksaantindakan)'
        ),
        array(
            'header' => 'Hasil Pemeriksaan',
            'type' => 'raw',
            'value' => '$data->hasilpemeriksaantindakan'
        ),
        array(
            'header' => 'Kesimpulan',
            'type' => 'raw',
            'value' => '$data->kesimpulantindakan'
        ),
        array(
            'header' => 'Lihat File',
            'type' => 'raw',
            'value' => function ($data) {
                $file = Yii::app()->request->baseUrl . '/data/images/hasilPemeriksaanTindakan/'. $data->dokfiletindakan_filepath;
                return CHtml::link('Lihat File', 'javascript:lihatFile("' . $file. '")', ['class' => 'btn btn-danger']);
            }
        ),
        array(
            'header' => 'Ubah',
            'type' => 'raw',
            'value' => function ($data) {
                return CHtml::link('<i class="icon-form-ubah" style="font-size:14pt"></i>', Yii::app()->controller->createUrl('hasilPemeriksaan', array(
                    'pendaftaran_id'=>$data->pendaftaran_id,
                    'pasien_id'=>$data->pasien_id,
                    'pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id,
                    'hasilpemeriksaantindakan_id'=>$data->hasilpemeriksaantindakan_id
                )));
            }
        ),
        array(
            'header' => 'Hapus',
            'type' => 'raw',
            'value' => function ($data) {
                return CHtml::link('<i class="icon-form-sampah" style="font-size:14pt"></i>', 'javascript:deleteRecord('. $data->hasilpemeriksaantindakan_id .')');
            }
        ),
        
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
)); 

?>

<script>
    function deleteRecord(hasilpemeriksaantindakan_id) {
        myConfirm('Yakin ingin menghapus data?', 'Perhatian!', function(r) {
            if(r) {
                $.post('<?= $this->createUrl('deleteRecord') ?>', {
                    hasilpemeriksaantindakan_id:hasilpemeriksaantindakan_id
                }, function(data){
                    if(data.sukses == 1) {
                        myAlert('Data berhasil dihapus');
                    } else {
                        myAlert('Data gagal dihapus');
                    }
                    $.fn.yiiGridView.update('hasilpemeriksaan-t-grid');
                }, 'json');
            }
        });
    }

    function lihatFile(filePath) {
        $('#iframeLihatFile').attr("src", filePath);
        $('#lihatFile').dialog('open');
    }
</script>