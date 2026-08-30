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
            'value' => '$data->tindakanterapi_rehab ?? ""'
        ),
        array(
            'header' => 'Petugas Pengisi',
            'type' => 'raw',
            'value' => '$data->pegawai->namaLengkap ?? ""'
        ),
        array(
            'header' => 'Tanggal Pemeriksaan',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tglpemeriksaanrm)'
        ),
        array(
            'header' => 'Hasil Pemeriksaan',
            'type' => 'raw',
            'value' => '$data->hasilpemeriksaanrm'
        ),
        array(
            'header' => 'Kesimpulan',
            'type' => 'raw',
            'value' => '$data->keteranganhasilrm'
        ),
        array(
            'header' => 'Lihat File',
            'type' => 'raw',
            'value' => function ($data) {
                if(!empty($data->dokfilerm_filepath)) {
                    $file = Yii::app()->request->baseUrl . '/data/images/hasilPemeriksaanTindakan/'. $data->dokfilerm_filepath;
                    return CHtml::link('Lihat File', 'javascript:lihatFile("' . $file. '")', ['class' => 'btn btn-danger']);
                } else {
                    echo 'Tidak ada file diupload';
                }
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
                    'hasilpemeriksaanrm_id'=>$data->hasilpemeriksaanrm_id,
                    'update' => 1
                )));
            }
        ),
        array(
            'header' => 'Hapus',
            'type' => 'raw',
            'value' => function ($data) {
                return CHtml::link('<i class="icon-form-sampah" style="font-size:14pt"></i>', 'javascript:deleteRecord('. $data->hasilpemeriksaanrm_id .')');
            }
        ),
        
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
)); 

?>

<script>
    function deleteRecord(hasilpemeriksaanrm_id) {
        myConfirm('Yakin ingin menghapus data?', 'Perhatian!', function(r) {
            if(r) {
                $.post('<?= $this->createUrl('deleteRecord') ?>', {
                    hasilpemeriksaanrm_id:hasilpemeriksaanrm_id
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