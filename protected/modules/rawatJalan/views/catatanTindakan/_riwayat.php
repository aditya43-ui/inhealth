<?php



$prov = $modRiwayat->search();
$prov->criteria->order = 'pendaftaran_id desc, catatantindakan_id desc';

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'riwayat-catatan-tindakan-dokter-grid',
    'dataProvider' => $prov,
    'template'=>"{summary}\n{items}\n{pager}", 
    'itemsCssClass' => 'table table-bordered table-condensed',
    'htmlOptions' => array(
        'style' => 'width: 100%;',
    ),
    'columns' => [
        [
            'header' => 'No',
            'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
        ],
        [
            'name' => 'tgl_catatantindakan',
            'type' => 'raw',
            'value' => function($data) {
                return MyFormatter::formatDateTimeForUser($data->tgl_catatantindakan);
            }
        ],
        [
            'name' => 'pegawai_id',
            'type' => 'raw',
            'value' => function($data) {
                $peg = PegawaiM::model()->findByPk($data->pegawai_id);
                return $peg->namaLengkap ?? "-";
            }
        ],
        [
            'header' => 'Detail',
            'type' => 'raw',
            'value' => function($data) {
                return CHtml::link('<i class="icon-form-mata"></i>', Yii::app()->controller->createUrl('detail', [
                    'id'=>$data->catatantindakan_id
                ]), [
                    'target'=>'frameDetailCatatan',
                    'onclick'=>"$('#dialogDetailCatatan').dialog('open');"
                ]);
            }
        ]
    ]
));