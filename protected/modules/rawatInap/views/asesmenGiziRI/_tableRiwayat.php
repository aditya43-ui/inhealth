<?php 

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'riwayat_pengkajian',
    'dataProvider' => $modRiwayat->search(),
    'template' => "{items}",
    'itemsCssClass' => 'table table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'No.',
            'value' => '$row+1',
        ),
        array(
            'header' => 'Tgl. Asuhan Gizi',
            'value' => function ($data) {
                return MyFormatter::formatDateTimeForUser($data->tgl_konsultasi);
            },
        ),
        [
            'header' => 'Ahli Gizi',
            'value' => '$data->ahligizi->namaLengkap'
        ],
        array(
            'header' => 'Detail',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
            'value' => function ($data) {
                return CHtml::link('<i class="icon-form-detail"></i>', $this->createUrl('detail', array(
                    'asesmengizi_id'=>$data->asesmengizi_id,
                )), array('rel'=>'tooltip', 'title'=>'Detail Asesmen Gizi', 'target' => 'iframeDetail', 'onclick' => "$('#dialogDetail').dialog('open')"));
            },
        ),
        


    ),
));
?>