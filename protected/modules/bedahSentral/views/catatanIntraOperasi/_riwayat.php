<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Riwayat Observasi Intra Operasi</div>
    </div>
    <div class="panel-body">
        <?php

        $mod = new BedahanastesilokalIntraopT;
        $mod->unsetAttributes();
        $mod->pasienmasukpenunjang_id = $model->pasienmasukpenunjang_id;

        $prov = $mod->search();
        $prov->criteria->order = 'pemeriksaanke asc';

        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'durante-v-grid',
            'dataProvider' => $prov,
            'template' => "{items}\n{pager}",
            'itemsCssClass' => 'table table-striped table-condensed',
            'columns' => array(
                array(
                    'name'=>'pemeriksaanke',
                    'htmlOptions'=>array(
                        'style'=>'width: 50px;'
                    )
                ),
                'observasi_jam',
                array(
                    'header'=>'Ubah',
                    'type'=>'raw',
                    'value'=>function($data) {
                        return CHtml::link('<i class="entypo-pencil"></i>', Yii::app()->controller->createUrl('create', array(
                            'pasienmasukpenunjang_id'=>$data->pasienmasukpenunjang_id,
                            'id'=>$data->bedahanastesilokal_intraop_id
                        )), array(
                            'rel'=>'tooltip',
                            'title'=>'Ubah Catatan',
                        ));
                    },
                    'htmlOptions'=>array(
                        'style'=>'width: 50px; text-align: center;'
                    )
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));



        ?>
        
    </div>
</div>

