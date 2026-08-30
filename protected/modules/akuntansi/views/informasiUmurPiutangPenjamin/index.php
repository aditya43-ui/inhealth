<?php
$this->breadcrumbs = array(
    'Informasi Umur Piutang Penjamin',
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Umur Piutang Penjamin</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        Yii::app()->clientScript->registerScript('search', "
            $('#informasiumurpiutangpenjamin-search').submit(function(){
                    $('#informasiumurpiutangpenjamin-grid').addClass('animation-loading');
                    $.fn.yiiGridView.update('informasiumurpiutangpenjamin-grid', {
                                    data: $(this).serialize()
                    });
                    return false;
            });
            ");
        $format = new MyFormatter();
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js');
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_search', array(
                    'model' => $model
                )); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Umur Piutang Penjamin</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'informasiumurpiutangpenjamin-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                            'type' => 'raw',
                            'value' => '$row+1'
                        ),
                        array(
                            'header' => 'Tanggal Pengajuan Klaim',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglpengajuanklaimanklaim)'
                        ),
                        array(
                            'header' => 'No. Pengajuan Klaim',
                            'type' => 'raw',
                            'value' => '$data->nopengajuanklaimanklaim'
                        ),
                        //                                    array(
                        //                                        'header' => 'Nama Pasien',
                        //                                        'type' => 'raw',
                        //                                        'value' => '$data->namadepan." ".$data->nama_pasien'
                        //                                    ),
                        array(
                            'header' => 'Penjamin',
                            'type' => 'raw',
                            'value' => '$data->penjamin_nama'
                        ),
                        array(
                            'header' => 'Total Piutang (Rp)',
                            'type' => 'raw',
                            'value' => 'number_format($data->totalpiutang,0,"",".")',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Sisa Piutang (Rp)',
                            'type' => 'raw',
                            'value' => 'number_format(($data->totalpiutang- $data->totalbayar),0,"",".")',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Umur Piutang',
                            'type' => 'raw',
                            'value' => 'number_format($data->lama_piutang,0,"","."). " Hari"',
                        ),
                        array(
                            'header' => '0-30 Hari (Rp)',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if (($data->lama_piutang >= 0) && ($data->lama_piutang <= 30)) {
                                    return number_format(($data->totalpiutang - $data->totalbayar), 0, "", ".");
                                } else {
                                    return '-';
                                }
                            },
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => '31-60 Hari (Rp)',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if (($data->lama_piutang >= 31) && ($data->lama_piutang <= 60)) {
                                    return number_format(($data->totalpiutang - $data->totalbayar), 0, "", ".");
                                } else {
                                    return '-';
                                }
                            },
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => '61-90 Hari (Rp)',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if (($data->lama_piutang >= 61) && ($data->lama_piutang <= 90)) {
                                    return number_format(($data->totalpiutang - $data->totalbayar), 0, "", ".");
                                } else {
                                    return '-';
                                }
                            },
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => '> 90 Hari (Rp)',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if (($data->lama_piutang > 90)) {
                                    return number_format(($data->totalpiutang - $data->totalbayar), 0, "", ".");
                                } else {
                                    return '-';
                                }
                            },
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>