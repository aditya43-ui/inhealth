<style>
    .fa-disabled {
  opacity: 0.6;
  cursor: not-allowed;
    }
</style>

<?php

$modRiwayat = new AsesmenpraanestesiT;
$modRiwayat->pasien_id = $model->pendaftaran->pasien_id;

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'riwayat-grid',
    'dataProvider' => $modRiwayat->searchRiwayat(),
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'columns' => array(                     
        array(
            'name' => 'no_pendaftaran',            
            'value' => '$data->pendaftaran->no_pendaftaran'
        ),
        array(
            'name' => 'tgl_pendaftaran',            
            'value' => 'MyFormatter::formatDateTimeForUser($data->pendaftaran->tgl_pendaftaran)'
        ), 
        array(
            'name' => 'tgl_asesmenpraanestesi',
            'value' => '!empty($data->tgl_asesmenprabedah)?MyFormatter::formatDateTimeForUser($data->tgl_asesmenprabedah):""'
        ), 
        array(
            'header' => 'Dokter Bedah',
            'name' => 'dokterbedah_nama',
            'value' => '!empty($data->dokterbedah) ? $data->dokterbedah->namaLengkap : ""'
        ), 
        array(
            'header' => 'Ruangan',
            'name' => 'create_ruangan',
            'value' => '$data->ruangbuat->ruangan_nama'
        ), 
        array(
            'header' => 'Detail',
            'headerHtmlOptions' => array('style' => 'width:5%;'),
            'type' => 'raw',
            'value' => function($data) {                
                return CHtml::link('<i class="icon-form-lihat"></i>', $this->createUrl('detail', array(
                    'pendaftaran_id' => $data->pendaftaran_id,
                    'id' => $data->asesmenpraanestesi_id,
                )));                
            },
            'htmlOptions' => array('style' => 'text-align: center;'),
        ),
        array(
            'header' => 'Edit',
            'headerHtmlOptions' => array('style' => 'width:5%;'),
            'type' => 'raw',
            'value' => function($data) {
                if ($data->create_ruangan == Yii::app()->user->getState('ruangan_id')) {
                    return CHtml::link('<i class="icon-form-ubah"></i>', $this->createUrl('ubah', array(
                        'id' => $data->asesmenpraanestesi_id,
                    )));
                }  else {
                    return '<i class="icon-form-ubah fa-disabled"></i>';
                }
            },
            'htmlOptions' => array('style' => 'text-align: center; width:40px'),
        ),
        array(
            'header' => 'Salin',
            'headerHtmlOptions' => array('style' => 'width:5%;'),
            'type' => 'raw',
            'value' => function($data) {
                if ($data->create_ruangan == Yii::app()->user->getState('ruangan_id')) {
                    return CHtml::link('<i class="icon-form-copy"></i>', $this->createUrl('salin', array(
                        'id' => $data->asesmenpraanestesi_id,
                        'aksi' => 'view',
                    )));
                }  else {
                    return '<i class="icon-form-copy fa-disabled"></i>';
                }
            },
            'htmlOptions' => array('style' => 'text-align: center; width:40px'),
        ),
        array(
            'header' => 'Hapus',
            'headerHtmlOptions' => array('style' => 'width:5%;'),
            'type' => 'raw',
            'value' => function($data) {
                if ($data->create_ruangan == Yii::app()->user->getState('ruangan_id')) {
                    return CHtml::link('<i class="icon-form-sampah" style="font-size:14pt"></i>', 'javascript:;', array(
                                'onclick' => 'hapus(' . $data->asesmenpraanestesi_id . '); return false'
                    ));
                }   else {
                    return '<i class="icon-form-sampah fa-disabled"></i>';
                }
            },
            'htmlOptions' => array('style' => 'text-align: center; width:40px'),
        ),
        array(
            'header' => 'Cetak',
            'headerHtmlOptions' => array('style' => 'width:5%;'),
            'type' => 'raw',
            'value' => function($data) {
                return CHtml::link('<span class="entypo-print" style="font-size:14pt"></span>', 'javascript:;', array(
                            'onclick' => 'cetak(' . $data->asesmenpraanestesi_id . '); return false'
                ));
            },
            'htmlOptions' => array('style' => 'text-align: center; width:40px'),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
