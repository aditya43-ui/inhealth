<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Tabel Riwayat Pembukaan Serviks & Turunnya Kepala</div>
    </div>
    <div class="panel-body">
        <?php
        
        $model = new MonitoringjalanlahirT;
        $model->unsetAttributes();
        $model->partografpasien_id = $partograf->partografpasien_id;
        
        $col = array(
            'pemeriksaanke',
            array(
                'name'=>'tgl_pemeriksaan',
                'type'=>'raw',
                'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pemeriksaan)',
            ),
            'jam_pemeriksaan',
            array(
                'name'=>'petugaspemeriksa_id',
                'type'=>'raw',
                'value'=>function($data) {
                    return empty($data->petugaspemeriksa) ? "-" : $data->petugaspemeriksa->namaLengkap;
                }
            ),
            array(
                'name'=>'pembukaanserviks',
                'htmlOptions'=>array(
                    'style'=>'text-align: center',
                ),
            ),
            array(
                'name'=>'turunnyakepalajanin',
                'htmlOptions'=>array(
                    'style'=>'text-align: center',
                ),
            ),
        );
            
        if (empty($is_detail) || $is_detail != 1) {
            array_push($col, array(
                'header'=>'Ubah',
                'type'=>'raw',
                'value'=>function($data) use ($partograf) {
                    return CHtml::link('<i class="glyphicon glyphicon-pencil"></i>', Yii::app()->controller->createUrl('index', array('pendaftaran_id'=>$partograf->pendaftaran_id, 'serviks_id'=>$data->monitoringjalanlahir_id)));
                },
                'htmlOptions'=>array(
                    'style'=>'text-align: center; width: 80px;',
                ),
            ),
            array (
                'header'=>'Hapus',
                'type'=>'raw',
                'value'=>function($data) {
                    return CHtml::link('<i class="glyphicon glyphicon-remove"></i>', '#', array(
                        'onclick'=>'hapusServiks('.$data->monitoringjalanlahir_id.'); return false;',
                    ));
                },
                'htmlOptions'=>array(
                    'style'=>'text-align: center; width: 80px;',
                ),
            ));
        }
        
        
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'jalan-lahir-grid',
            'dataProvider' => $model->searchRiwayat(),
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-bordered table-striped table-condensed',
            'columns' => $col,
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
        
        ?>
    </div>
</div>