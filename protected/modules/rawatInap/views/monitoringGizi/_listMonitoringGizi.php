
        <?php 
        
        
        
        $model = new MonitoringgiziranapT();
        $model->unsetAttributes();
        $model->asesmengizi_id = $model->asesmengizi_id;
         
        $prov = $model->search();
        $prov->pagination->pageSize = 5;
        $prov->sort->defaultOrder = 'create_time desc';
        
        
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id'=>'daftar-asesmen-grid',
            'dataProvider'=>$prov,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-bordered table-striped table-condensed',
            'columns'=>array(
                array(
                    'header'=>'Tgl. Monitoring',
                    'name'=>'tglmonitoringgizi',
                    'value'=>'MyFormatter::formatDateTimeForUser($data->tglmonitoringgizi);'
                ),
                array(
                    'header'=>'Terapi Gizi/Diet',
                    'type'=>'raw',
                    'value'=>'$data->dietintake',
                ),
                array(
                    'header'=>'Asupan/Intake Makanan',
                    'type'=>'raw',
                    'value'=>'$data->rencanapenatalaksanaan_diet',
                ),
                array(
                    'header'=>'Antropometri (Status Gizi)',
                    'type'=>'raw',
                    'value'=>'$data->antropometri',
                ),
                array(
                    'name'=>'laboratorium',
                    'type'=>'raw',
                    'value'=>'$data->laboratorium',
                ),
                array(
                    'name'=>'fisik_klinis',
                    'type'=>'raw',
                    'value'=>'$data->fisik_klinis',
                ),
                array(
                    'name'=>'lainlain',
                    'type'=>'raw',
                    'value'=>'$data->lainlain',
                ),
                array(
                    'name'=>'ahligiziranap_id',
                    'type'=>'raw',
                    'value'=>function($data) {
                        return empty($data->ahligizi) ? "-" : $data->ahligizi->namaLengkap;
                    }
                ),
                array(
                    'header'=>'Batal',
                    'type'=>'raw',
                    'value'=>function($data) {
                        return CHtml::link('<i class="icon-form-silang"></i>', '#', array('rel'=>'tooltip', 'title'=>'Batal Asesmen Gizi', 'onclick'=>'hapusAsesmen('.$data->monitoringgiziranap_id.');'));
                    },
                    'htmlOptions'=>array(
                        'style'=>'text-align: center;',
                    )
                )
             ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        ));
        ?>

<script>
    function hapusAsesmen(id) {
        myConfirm("Anda yakin untuk menghapus monitoring ini?", "Peringatan", function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('hapus'); ?>', {id: id}, function(data) {
                    $.fn.yiiGridView.update('daftar-asesmen-grid');
                    myAlert("Data monitoring berhasil dihapus");
                });
            }
        });
    }
</script>