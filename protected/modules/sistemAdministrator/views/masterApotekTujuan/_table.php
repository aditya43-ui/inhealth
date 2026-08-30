<?php 

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'ruanganapotek-grid',
    'dataProvider' => $model->searchRuanganInstalasiFarmasi(),
    'filter' => $model,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        [
            'header' => 'Apotek Tujuan',
            'type' => 'raw',
            'value' => function ($data) {
                
                echo $data->ruangan_nama;
                
            }
        ],
        [
            'header' => 'Ruang Pelayanan',
            'type' => 'raw',
            'value' => function($data) {
                echo '<div class="col-sm-2">';
                    echo CHtml::link(
                        Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-plus"></i>')),
                        $this->createUrl('create', [
                            'ruanganapotektujuan_id' => $data->ruangan_id
                        ]),
                        array(
                            'title' => 'Tambah',
                            'class' => 'btn btn-danger',
                            'target' => 'iframeRuanganPelayanan',
                            'onclick' => '$("#dialogRuangPelayanan").dialog("open")'
                        )
                    );
                echo '</div>';
                echo '<div class="col-sm-10">';
                $modRuangan = RuanganapotektujuanK::model()->findAllByAttributes(['ruanganapotektujuan_id' => $data->ruangan_id]);

                echo '<ul sty>';
                if(!empty($modRuangan)) {
                    foreach ($modRuangan as $i => $val) {
                    
                        $ruangan = RuanganM::model()->findByAttributes(['ruangan_id' => $val->ruanganpelayanan_id]);
                        if(!empty($ruangan)) {
                            echo '<li>' . $ruangan->ruangan_nama . '</li>';
                        }
                    }
                }
                echo '</ul>';
                echo '</div>';

            }
        ]
    ),
    'afterAjaxUpdate' => 'function(id, data){
        jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
       
    }',
));