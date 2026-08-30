<?php
$this->breadcrumbs = array(
    'Informasi Waktu Tunggu',
);

Yii::app()->clientScript->registerScript('search', "
    $('#waktutunggu-info-search').submit(function(){
            $('#waktutunggu-info-grid').addClass('animation-loading');
            $.fn.yiiGridView.update('waktutunggu-info-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
?>
<div class="panel-body table-responsive">
    <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'waktutunggu-info-grid',
        'dataProvider' => $model->search(),
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-bordered table-striped table-condensed',
        'columns' => array(
            array(
                'header' => 'No.',
                'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
            ),
            array(
                'name' => 'noresep',
                'type' => 'raw',
                'value' => '$data->noresep',
            ),
            array(
                // 'header' => 'No. Rekam Medik',
                'name' => 'no_pendaftaran',
                'type' => 'raw',
                'value' => '$data->no_pendaftaran',
            ),
            array(
                'name' => 'no_rekam_medik',
                'type' => 'raw',
                'value' => '$data->no_rekam_medik',
            ),
            array(
                'name' => 'nama_pasien',
                'type' => 'raw',
                'value' => '$data->nama_pasien',

                // 'htmlOptions' => array('style' => 'text-align: center;'),
            ),
            array(
                'name' => 'wakturesep_masuk',
                'type' => 'raw',
                'value' => 'MyFormatter::formatDateTimeForUser($data->wakturesep_masuk)',
                // 'value' => 'Params::getWrStatusPeriksa($data->statusperiksa)',
            ),
            array(
                'name' => 'wakturesep_keluar',
                'type' => 'raw',
                'value' => 'MyFormatter::formatDateTimeForUser($data->wakturesep_keluar)',

            ),
            array(
                'name' => 'selisih_waktu',
                'type' => 'raw',
                'value' => '$data->selisih_waktu'
            ),
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    )); ?>
</div>