<style>

    .btn-grey {
        background-color: grey;
        color: white;
        font-weight: bold;
    }

    .btn-blue {
        background-color: blue;
        color: white;
        font-weight: bold;
    }


    .btn-green {
        background-color: green;
        color: white;
        font-weight: bold;
    }


    .btn-orange {
        background-color: orange;
        color: white;
        font-weight: bold;
    }

    .btn-red {
        background-color: red;
        color: white;
        font-weight: bold;
    }

    .btn-blue-rev {
        background-color: white;
        border-color: blue;
        color: blue;
        font-weight: bold;
    }

    .btn-group .btn-blue-rev:hover {
        background-color: blue;
        border-color: white;
        color: white;
        font-weight: bold;
    }

</style>

<?php 

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pasienpenunjangrujukan-m-grid',
    'dataProvider' => $model->searchHasil(),
    'replaceUrl' => true,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'replaceUrl' => true,
    'columns' => array(

        array(
            'header' => 'No.',
            'value' => '($this->grid->dataProvider->pagination) ? 
                            ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                            : ($row+1)',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:left;'),
        ),

        [
            'header' => 'Tanggal Pemeriksaan',
            'name' => 'tgl_pemeriksaan',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pemeriksaan)'
        ],	
        [
            'header' => 'No. Lab',
            'name' => 'no_lab',
        ],	
        array(
            'header' => 'Nama Pasien',
            'name' => 'nama_pasien',
            'value' => '$data->nama_pasien',
        ),
        array(
            'header' => 'No. Rekam Medik',
            'name' => 'no_rekam_medik',
        ),
        array(
            'header' => 'DPJP',
            'name' => 'nama_dpjp',
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jenis Spesimen',
            'name' => 'samplelab_nama',
            'value' => '$data->samplelab_nama',
        ),
        array(
            'header' => 'Jenis Pemeriksaan',
            'name' => 'tindakanpelayanan_id',
            'value' => '$data->daftartindakan_nama',
        ),
        array(
            'header' => 'Pemeriksaan',
            'value' => function($data) {
                if($data->pemeriksaan == 'Kultur') {
                    echo CHtml::link('Kultur', 'javascript:void(0)', array('class' => 'btn btn-grey'));
                } else if($data->pemeriksaan == 'Pewarnaan Langsung') {
                    echo CHtml::link('Pewarnaan Langsung', 'javascript:void(0)', array('class' => 'btn btn-blue'));
                } else if($data->pemeriksaan == 'CCI') {
                    echo CHtml::link('CCI', 'javascript:void(0)', array('class' => 'btn btn-green'));
                } else if($data->pemeriksaan == 'PCR Covid') {
                    echo CHtml::link('PCR Covid', 'javascript:void(0)', array('class' => 'btn btn-orange'));
                } else if($data->pemeriksaan == 'Viral Load') {
                    echo CHtml::link('Viral Load', 'javascript:void(0)', array('class' => 'btn btn-red'));
                } else if($data->pemeriksaan == 'TBC') {
                    echo CHtml::link('TBC', 'javascript:void(0)', array('class' => 'btn btn-blue-rev'));
                }
            },
        ),
        array(
            'header' => 'Cara Bayar',
            'name' => 'tindakanpelayanan_id',
            'value' => '$data->carabayar_nama',
        ),
        array(
            'header' => 'Status Kirim Hasil',
            'name' => 'is_kirimhasil',
            'value' => '$data->is_kirimhasil ? "Sudah Kirim" : "Belum Kirim"',
        ),
        array(
            'header' => 'Hasil Expertise',
            'type' => 'raw',
            'value' => function ($data) {

                $id = null;
                if($data->pemeriksaan == 'Kultur') {
                    $id = $data->pemeriksaankultur_id;
                } else if($data->pemeriksaan == 'Pemeriksaan Kultur') {
                    $id = $data->pemeriksaanpewarnaan_id;
                } else if($data->pemeriksaan == 'CCI') {
                    $id = $data->pemeriksaancci_id;
                } else if($data->pemeriksaan == 'PCR Covid') {
                    $id = $data->pemeriksaanpcr_id;
                } else if($data->pemeriksaan == 'Viral Load') {
                    $id = $data->pemeriksaanviralload_id;
                } else if($data->pemeriksaan == 'TBC') {
                    $id = $data->pemeriksaantbc_id;
                }


                return CHtml::link(
                    "<icon class='icon-form-detail'></icon>", Yii::app()->controller->createUrl("hasilPemeriksaan/hasilExpertise", array("kelompokpemeriksaanmikro_id" => $data->kelompokpemeriksaanmikro_id, "id" => $id, "pasienmasukpenunjang_id" => $data->pasienmasukpenunjang_id, "pemeriksaan"=>$data->pemeriksaan)), array("rel" => "tooltip",
                    "title" => "Klik untuk mengisi hasil analis" 
                    )
                );

            }
        ),
        array(
            'header' => 'Lihat Hasil',
            'value' => function ($data) {
                if($data->is_pemeriksaankultur) {
                   echo CHtml::link('<i class="icon-form-print"></i>', '#', array('onclick'=>'printKultur(' . $data->pemeriksaankultur_id . ');return false;'));
                } else if($data->is_pemeriksaanpewarnaan) {
                    echo CHtml::link('<i class="icon-form-print"></i>', '#', array('onclick'=>'printPewarnaan(' . $data->pemeriksaanpewarnaan_id . ');return false;'));
                } else if($data->is_pemeriksaancci) {
                    echo CHtml::link('<i class="icon-form-print"></i>', '#', array('onclick'=>'printCci(' . $data->pemeriksaancci_id . ');return false;'));
                } else if($data->is_pemeriksaanpcr) {
                    echo CHtml::link('<i class="icon-form-print"></i>', '#', array('onclick'=>'printPcr(' . $data->pemeriksaanpcr_id . ');return false;'));
                } else if($data->is_pemeriksaanviralload) {
                } else if($data->is_pemeriksaantbc) {
                }
            }
        ),




       
                
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

?>

<script>
function printCci(pemeriksaancci_id) {
    window.open(
        '<?php echo $this->createUrl('/mikrobiologiKlinik/daftarPasien/printCci'); ?>' + '&pemeriksaancci_id=' + pemeriksaancci_id,
        'printwin', 'left=100,top=100,width=720,height=960');
}

function printKultur(pemeriksaankultur_id) {
     window.open(
         '<?php echo $this->createUrl('/mikrobiologiKlinik/daftarPasien/printKultur', array()); ?>&pemeriksaankultur_id='+pemeriksaankultur_id,
         'printwin', 'left=100,top=100,width=1280,height=720');
 }

function printPewarnaan(pemeriksaanpewarnaan_id) {
    window.open(
        '<?php echo $this->createUrl('/mikrobiologiKlinik/daftarPasien/printPewarnaan', array()); ?>&pemeriksaanpewarnaan_id='+pemeriksaanpewarnaan_id,
        'printwin', 'left=100,top=100,width=1280,height=720');
}

function printPCR(pemeriksaanpcr_id) {
    window.open(
        '<?php echo $this->createUrl('mikrobiologiKlinik/daftarPasien/printPcr', array()); ?>&pemeriksaanpcr_id='+pemeriksaanpcr_id,
        'printwin', 'left=100,top=100,width=640,height=480');
}

</script>