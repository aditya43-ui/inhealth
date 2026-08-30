<?php
$this->breadcrumbs = array(
    'Informasi Komposisi Bahan Makanan',
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Komposisi Bahan Makanan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        //            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        //            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        Yii::app()->clientScript->registerScript('search', "
            $('#search').submit(function(){
                    $.fn.yiiGridView.update('infokomposisibahanmakanan-grid', {
                            data: $(this).serialize()
                    });
                    return false;
            });
            ");
        ?>
        <?php $this->renderPartial('search', array('modKomposisiBahanMakanan' => $modKomposisiBahanMakanan)); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Komposisi Bahan Makanan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
                    'id' => 'infokomposisibahanmakanan-grid',
                    'dataProvider' => $modKomposisiBahanMakanan->searchInformasi(),
                    'enableSorting' => true,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-condensed',
                    'mergeHeaders' => array(
                        array(
                            'name' => '<p style="margin: 0; text-align: center;">Komposisi Makanan</p>',
                            'start' => 2, //indeks kolom 3
                            'end' => 12, //indeks kolom 4
                        ),
                    ),
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
                            'htmlOptions' => array('style' => 'text-align:center'),
                            'headerHtmlOptions' => array(
                                'style' => 'text-align:center',
                            ),
                        ),
                        array(
                            'header' => 'Bahan Makanan',
                            'type' => 'raw',
                            'value' => '$data->namabahanmakanan',
                            'headerHtmlOptions' => array(
                                'style' => 'text-align:center',
                            ),
                        ),
                        array(
                            'header' => 'Kalori <br> (Kal)',
                            'type' => 'raw',
                            'value' => '$data->kalori',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                            'headerHtmlOptions' => array(
                                'style' => 'text-align:center',
                            ),
                        ),
                        array(
                            'header' => 'Protein <br> (g)',
                            'type' => 'raw',
                            'value' => '$data->protein',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                            'headerHtmlOptions' => array(
                                'style' => 'text-align:center',
                            ),
                        ),
                        array(
                            'header' => 'Lemak <br> (g)',
                            'type' => 'raw',
                            'value' => '$data->lemak',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                            'headerHtmlOptions' => array(
                                'style' => 'text-align:center',
                            ),
                        ),
                        array(
                            'header' => 'Hidrat <br> Arang <br> (g)',
                            'type' => 'raw',
                            'value' => '$data->hidrat_arang',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                            'headerHtmlOptions' => array(
                                'style' => 'text-align:center',
                            ),
                        ),
                        array(
                            'header' => 'Ca <br> (mg)',
                            'type' => 'raw',
                            'value' => '$data->calsium',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                            'headerHtmlOptions' => array(
                                'style' => 'text-align:center',
                            ),
                        ),
                        array(
                            'header' => 'P <br> (mg)',
                            'type' => 'raw',
                            'value' => '$data->fosfor',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                            'headerHtmlOptions' => array(
                                'style' => 'text-align:center',
                            ),
                        ),
                        array(
                            'header' => 'Fe <br> (mg)',
                            'type' => 'raw',
                            'value' => '$data->fe',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                            'headerHtmlOptions' => array(
                                'style' => 'text-align:center',
                            ),
                        ),
                        array(
                            'header' => 'Vit. <br> A <br> (IU)',
                            'type' => 'raw',
                            'value' => '$data->vit_a',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                            'headerHtmlOptions' => array(
                                'style' => 'text-align:center',
                            ),
                        ),
                        array(
                            'header' => 'Vit. <br> B1 <br> (mg)',
                            'type' => 'raw',
                            'value' => '$data->vit_b1',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                            'headerHtmlOptions' => array(
                                'style' => 'text-align:center',
                            ),
                        ),
                        array(
                            'header' => 'Vit. <br> C <br> (mg)',
                            'type' => 'raw',
                            'value' => '$data->vit_c',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                            'headerHtmlOptions' => array(
                                'style' => 'text-align:center',
                            ),
                        ),
                        array(
                            'header' => 'Air <br> (g)',
                            'type' => 'raw',
                            'value' => '$data->air',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                            'headerHtmlOptions' => array(
                                'style' => 'text-align:center',
                            ),
                        ),
                        array(
                            'header' => 'Bagian yang <br> dapat dimakan <br> (%)',
                            'type' => 'raw',
                            'value' => '$data->bkaroten',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                            'headerHtmlOptions' => array(
                                'style' => 'text-align:center',
                            ),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>
    </div>
</div>