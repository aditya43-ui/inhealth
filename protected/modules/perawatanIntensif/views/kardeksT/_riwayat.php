<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Riwayat Observasi Pasien</div>
    </div>
    <div class="panel-body">
        <?php 
        
        $mod = new KardeksT;
        $mod->unsetAttributes();
        $mod->pendaftaran_id = $model->pendaftaran_id;
        
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
                'id'=>'daftarPasien-grid',
                'dataProvider'=>$mod->searchRiwayat(),
                'replaceUrl'=>true,
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass'=>'table table-striped table-condensed table-bordered',
                'columns'=>array(
                    array(
                        'header' => 'Pemeriksaan Ke',
                        'value' => '$data->pemeriksaan_ke',
                        'htmlOptions'=>array(
                            
                        ),
                    ),
                    array(
                        'name'=>'tgl_pemeriksaan',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pemeriksaan)',
                    ),
                    array(
                        'header'=>'Edit',
                        'type'=>'raw',
                        'value'=>function($data) {
                            return CHtml::link('<i class="entypo-pencil"></i>', $this->createUrl('update', array(
                                'pendaftaran_id'=>$data->pendaftaran_id,
                                'kardeks_id'=>$data->kardeks_id,
                            )), array(
                                'rel'=>'tooltip',
                                'title'=>'Klik untuk ubah data Observasi Pasien'
                            ));
                        },
                        'htmlOptions'=>array(
                            'style'=>'text-align: center;',
                        ),
                    ),
                    array(
                        'header'=>'Hapus',
                        'type'=>'raw',
                        'value'=>function($data) {
                            return CHtml::link('<i class="entypo-trash"></i>', '', array(
                                'rel'=>'tooltip',
                                'title'=>'Klik untuk ubah data Observasi Pasien',
                                'onclick' => 'hapusRiwayat(' . $data->kardeks_id . ',' . $data->pendaftaran_id. ')'
                            ));
                        },
                        'htmlOptions'=>array(
                            'style'=>'text-align: center;',
                        ),
                    ),
                ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
            ));
        
        ?>
    </div>
</div>