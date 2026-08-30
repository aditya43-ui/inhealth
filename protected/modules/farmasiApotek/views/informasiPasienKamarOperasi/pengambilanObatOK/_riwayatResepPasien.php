<?php

$modResepturOkDet = new ResepturokdetT;
$modResepturOkDet->unsetAttributes();

if(!empty($riwayatResep)) {
    $modResepturOkDet->resepturok_id = $modReseptur->resepturok_id;
} else {
    $modResepturOkDet->resepturok_id = 0;
}

if (isset($_GET['ResepturokdetT'])) {
    $modResepturOkDet->attributes = $_GET['ResepturokdetT'];
    $modResepturOkDet->obatalkes_nama = $_GET['ResepturokdetT']['obatalkes_nama'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'reseppasien-grid',
    'dataProvider' => $modResepturOkDet->searchReseptur(),
    'filter'=>$modResepturOkDet,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'Tanggal Resep',
            'type' => 'raw',
            'value' => '$data->reseptur->tglresep_ok',
        ),
        array(
            'header' => 'No. Resep',
            'type' => 'raw',
            'value' => '$data->reseptur->noresep_ok',
        ),
        array(
            'header' => 'Nama Pasien',
            'type' => 'raw',
            'value' => '$data->reseptur->pendaftaran->pasien->nama_pasien',
        ),
        array(
            'header' => 'Petugas Farmasi',
            'type' => 'raw',
            'value' => '$data->reseptur->petugasfarmasi->namaLengkap',
        ),
        array(
            'header' => 'Nama Obat',
            'filter' => Chtml::activeTextField($modResepturOkDet, 'obatalkes_nama', array('class' => '')),
            'type' => 'raw',
            'value' => '$data->obatalkes->obatalkes_nama',
        ),
        array(
            'header' => 'Paket Obat',
            'type' => 'raw',
            'value' => '"$data->paket_obat"',
        ),
        array(
            'header' => 'Jumlah',
            'type' => 'raw',
            'value' => '$data->jumlah',
            'htmlOptions' => array('style' => 'text-align:center;')
        ),
        array(
            'header' => 'Etiket',
            'type' => 'raw',
            'value' => function ($data) {
                echo CHtml::link('<i class="icon-form-print"></i>', '', [
                    'onclick' => "printEtiketOK('" . $data->resepturokdet_id . "')"
                ]); 
                
            },
            'htmlOptions' => array('style' => 'text-align: center; width:60px')
        ),

        array(
            'header' => 'Ubah',
            'type' => 'raw',
            'value' => function ($data) {
                $html = '';
                if($data->validasi) {
                    $html = CHtml::link('<i class="icon-form-ubah"></i>', 'javascript::', [
                        'onclick' => "window.parent.myAlert('Data Tidak Dapat Diubah Karena sudah di Validasi')"
                    ]);
                } else {
                    $html = CHtml::link('<i class="icon-form-ubah"></i>', $this->createUrl('ubah', ['resepturokdet_id' => $data->resepturokdet_id]), [
                        'target' => 'iframeUbah',
                        'onclick' => "$('#dialogUbah').dialog('open')"
                    ]);
                }
                echo $html;
            },
            'htmlOptions' => array('style' => 'text-align: center; width:60px')
        ),

        array(
            'header' => 'Hapus',
            'type' => 'raw',
            'value' => function ($data) {
                $html = "<center>" . CHtml::link("<i class='icon-trash'></i>",'javascript::', array('rel' => 'tooltip', 'title' => 'Klik untuk menghapus Reseptur', 'onclick' => 'hapusresep('.$data->resepturokdet_id.')' )) . "</center>";
                echo $html;
            },
            'htmlOptions' => array('style' => 'text-align: center; width:60px')
        ),

        array(
            'header' => 'Validasi ' . CHtml::link('<i class="fas fa-check-square" style="color:green"></i>','javascript::', array('rel' => 'tooltip', 'title' => 'Klik untuk validasi Semua Reseptur', 'onclick' => 'validasiAll('.$modReseptur->resepturok_id.', this)' )),
            'type' => 'raw',
            'value' => function ($data) {
                if($data->validasi) {
                    echo "<center>" . CHtml::link('<i class="fas fa-check-square" style="color:green"></i>','javascript::', array('rel' => 'tooltip', 'title' => 'Klik untuk validasi Reseptur', 'onclick' => 'validasiSingle('.$data->resepturokdet_id.', this)' )) . "</center>"; 
                    
                } else {
                    echo "<center>" . CHtml::link('<i class="fas fa-check-square" style="color:red"></i>','javascript::', array('rel' => 'tooltip', 'title' => 'Klik untuk validasi Reseptur', 'onclick' => 'validasiSingle('.$data->resepturokdet_id.', this)' )) . "</center>"; 
                }
            },
            'htmlOptions' => array('style' => 'text-align: center; width:60px')
        ),

        array(
            'header' => 'Keterangan',
            'type' => 'raw',
            'value' => function ($data) {
                echo $data->keterangan;
            },
            'htmlOptions' => array('style' => 'text-align: center; width:60px')
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));


?>