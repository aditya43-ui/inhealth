<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <?php $jenis = ($jenissurat == Params::SURAT_PERSETUJUAN_PERSETUJUAN) ? 'Persetujuan' : 'Penolakan'?>
            Riwayat Surat <?php echo $jenis ?>
        </div>
    </div>
    <div class="panel-body">
        <?php 
        
        
        
        $model = new PersetujuananestesiT();
        $model->jenissurat = $jenissurat;
        $model->pendaftaran_id = $pendaftaran_id;
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
         
        $prov = $model->search();
        $prov->pagination->pageSize = 5;
        $prov->sort->defaultOrder = 'create_time desc';
        
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id'=>'daftarPasien-grid',
            'dataProvider'=>$prov,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-bordered table-striped table-condensed',
            'columns'=>array(
                array(
                    'header'=>'Tgl. '.$jenis,
                    'name'=>'create_time',
                    'value'=>'MyFormatter::formatDateTimeForUser($data->create_time);'
                ),
                /*
                array(
                    'header'=>'No. '.$jenis,
                    'name'=>'tglpersetujuan',
                    'value'=>'MyFormatter::formatDateTimeForUser($data->tglpersetujuan);'
                ),
                 * 
                 */
                array(
                    'header'=> 'Jenis',
                    'name'=> 'jenis',
                    'value'=> function($data){
                        $informasi = PemberianinformasiT::model()->findByAttributes(array('persetujuananestesi_id'=>$data->persetujuananestesi_id));
                        echo $informasi->jenisanestesi;
                    },
                    'htmlOptions'=>array(
                        'style'=>'width: 200px;',
                    )
                ),
                array(
                    'header'=>'Print</br/>Informasi',
                    'type'=>'raw',
                    'value'=>function($data) use ($pendaftaran_id) {
                        return CHtml::link('<i class="icon-form-print"></i>', '#', array(
                            'onclick'=>"printInformasiRiwayat(".$data->persetujuananestesi_id.", 'PRINT'); return false;",
                        ));
                    },
                    'htmlOptions'=>array(
                        'style'=>'text-align: center; width: 100px;',
                    )
                ),
                array(
                    'header'=>'Print</br/>Surat Keterangan',
                    'type'=>'raw',
                    'value'=>function($data) use ($pendaftaran_id) {
                        return CHtml::link('<i class="icon-form-print"></i>', '#', array(
                            'onclick'=>"printRiwayat(".$data->persetujuananestesi_id.", 'PRINT'); return false;",
                        ));
                    },
                    'htmlOptions'=>array(
                        'style'=>'text-align: center; width: 100px;',
                    )
                ),
             ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        ));
        ?>
    </div>
</div>