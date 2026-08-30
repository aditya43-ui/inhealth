<!--<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
        <i class="entypo-credit-card"></i> Riwayat Surat Persetujuan/Penolakan Tindakan Anestesi
        </div>
    </div>
    <div class="panel-body">-->
<?php
$model = new PersetujuananestesiT();
$model->pendaftaran_id = $pendaftaran_id;

$prov = $model->search();
$prov->pagination->pageSize = 5;
$prov->sort->defaultOrder = 'create_time desc';

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'daftarPasien-grid',
    'dataProvider' => $prov,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'Tgl. Surat',
            'name' => 'create_time',
            'value' => 'MyFormatter::formatDateTimeForUser($data->create_time);'
        ),
        array(
            'header' => 'Jenis Surat',
            'name' => 'jenissurat',
            'value' => '$data->jenissurat'
        ),
        array(
            'header' => 'Detail',
            'type' => 'raw',
            'value' => function ($data) use ($pendaftaran_id) {
                return CHtml::link('<i class="icon-form-detail"></i>', $this->createUrl('detailTindakanAnestesi', array(
                    'id' => $pendaftaran_id,
                    'persetujuananestesi_id' => $data->persetujuananestesi_id,
                    'noframe' => 0,
                )));
            },
            'htmlOptions' => array(
                'style' => 'text-align: center;',
            )
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>
<!--</div>
</div>-->