<div style="overflow: auto">
    <?php 
    $this->widget('ext.bootstrap.widgets.BootGridView', array(
	'id'=>'riwayatobservasidewasa-grid',
	'dataProvider'=>$model->searchRiwayatDewasa($model->pendaftaran_id, $model->pasienadmisi_id),
                'template'=>"{summary}\n{items}\n{pager}",
                'replaceUrl'=>true,
                'itemsCssClass'=>'table table-bordered table-striped table-condensed',
	'columns'=>array(
                    array(
                       'name'=>'Tanggal',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_observasi)',
                    ),
                    array(
                       'name'=>'Jam',
                        'type'=>'raw',
                        'value'=>'$data->jam_observasi',
                    ),
                    array(
                        'header'=>'Tekanan Darah <br /> (mmHg)',
                        'type'=>'raw',
                        'value'=>'$data->td_sistolic ."/".$data->td_diastolic'
                    ),
                    array(
                        'header'=>'Nadi <br /> (x/menit)',
                        'type'=>'raw',
                        'value'=>'$data->detaknadi'
                    ),
                    array(
                        'header'=>'Suhu <br /> (&#176 C)',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatNumberForPrint($data->suhutubuh,2)'
                    ),
                    array(
                        'header'=>'Pernapasan <br />(x /menit)',
                        'type'=>'raw',
                        'value'=>'$data->pernapasan'
                    ),
                    array(
                        'header'=>'Saturasi Oksigen <br />(Sp02)',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatNumberForPrint($data->spo2_nilai,2)'
                    ),
                    array(
                        'header'=>'Jenis Cairan',
                        'type'=>'raw',
                        'value'=>'(!empty($data->cairan_jenis)?$data->cairan_jenis:"-")'
                    ),
                    array(
                        'header'=>'Jumlah Tetesan',
                        'type'=>'raw',
                        'value'=>'(!empty($data->jml_tetesan)?$data->jml_tetesan:"-")'
                    ),
                    array(
                        'header'=>'Kolf',
                        'type'=>'raw',
                        'value'=>'(!empty($data->kolf)?$data->kolf:"-")'
                    ),
                    array(
                        'header'=>'Jumlah Urine',
                        'type'=>'raw',
                        'value'=>'(!empty($data->jml_urine)?$data->jml_urine:"-")'
                    ),
                    array(
                        'header'=>'Bunyi Jantung Anak (BJA)',
                        'type'=>'raw',
                        'value'=>'(!empty($data->bunyijantung_anak)?$data->bunyijantung_anak:"-")'
                    ),
                    array(
                        'header'=>'Catatan',
                        'type'=>'raw',
                        'value'=>'(!empty($data->catatan)?$data->catatan:"-")'
                    ),
                    array(
                        'header'=>'Nama Petugas',
                        'type'=>'raw',
                        'value'=>'(isset($data->petugas)?$data->petugas->namaLengkap:"-")'
                    ),
                array(
                    'header'=>'Ubah',
                    'type'=>'raw',
                    'value'=>function($data) {
                        return CHtml::link('<i class="entypo-pencil"></i>', Yii::app()->controller->createUrl('index', array(
                            'pendaftaran_id'=>$data->pendaftaran_id,
                            'pasienadmisi_id'=>$data->pasienadmisi_id,
                            'observasipasienri_id'=>$data->observasipasienri_id,
                        )));
                    },
                    'htmlOptions'=>array(
                        'style'=>'text-align: center;',
                    )
                ),
                array(
                    'header'=>'Hapus',
                    'type'=>'raw',
                    'value'=>function($data) {
                        return CHtml::link('<i class="icon-trash"></i>', '#', array(
                            'onclick'=>'hapusRiwayat('.$data->pendaftaran_id.',"'.$data->pasienadmisi_id.'",'.$data->observasipasienri_id.'); return false'
                        ));
                    },
                    'htmlOptions'=>array(
                        'style'=>'text-align: center;',
                    )
                ),
            ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
?>
   
</div>
    