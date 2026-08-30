<?php $linkHalaman = CustomFunction::getUrlByMenuID(594); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Retur Penerimaan Barang</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        Yii::app()->clientScript->registerScript('search', "
            $('.search-button').click(function(){
                $('.search-form').toggle();
                return false;
            });
            $('.search-form form').submit(function(){
                $.fn.yiiGridView.update('gupemakaianbarang-t-grid', {
                    data: $(this).serialize()
                });
                return false;
            });
            ");
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <div class="search-form">
                    <?php $this->renderPartial($this->path_view . '_search', array(
                        'model' => $model,
                    )); ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Retur Penerimaan Barang</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'gupemakaianbarang-t-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'template' => "{pager}{summary}\n{items}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'replaceUrl' => true,
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
                        ),
                        array(
                            'header' => 'Tgl. Retur/<br>No. Retur',
                            'type' => 'raw',
                            //  	'value'=>'MyFormatter::formatDateTimeForUser($data->tglreturterima)',
                            'value' => function ($data) {
                                return CHtml::link('<u>' . MyFormatter::formatDateTimeForUser($data->tglreturterima) . '/<br>' . $data->noreturterima . '</u>',  Yii::app()->controller->createUrl("detailInformasi", array("id" => $data->returpenerimaan_id)), array("target" => "frameDetail", "rel" => "tooltip", "title" => "Klik untuk Detail Retur Barang", "onclick" => "window.parent.$('#dialogDetail').dialog('open')"));
                            }
                        ),
                        array(
                            'header' => 'Tgl. Penerimaan/<br>No Penerimaan',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return CHtml::link('<u>' . MyFormatter::formatDateTimeForUser($data->tglterima) . '/<br>' . $data->nopenerimaan . '</u>',  Yii::app()->controller->createUrl("/gudangUmum/TerimapersediaanT/detailTerimaPersediaan", array("id" => $data->terimapersediaan_id, "frame" => 1)), array("target" => "frameDetailTerima", "rel" => "tooltip", "title" => "Klik untuk Detail Penerimaan Barang", "onclick" => "window.parent.$('#dialogDetailTerima').dialog('open')"));
                            }
                        ),
                        array(
                            'header' => 'Alasan Retur',
                            'value' => '$data->alasanreturterima'
                        ),
                        array(
                            'header' => 'Operator',
                            'value' => function ($data) {
                                return $data->pegretur_gelardepan . ' ' . $data->pegretur_nama . ' ' . $data->pegretur_gelarbelakang;
                            }
                        ),
                        array(
                            'header' => 'Mengetahui',
                            'value' => function ($data) {
                                $peg = PegawaiM::model()->findByPk($data->pegreturmengetahui_id);
                                if (!empty($peg)) {
                                    return $peg->namaLengkap;
                                }
                            }
                        ),
                        array(
                            'header' => 'Supplier',
                            'value' => '$data->supplier_nama'
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
        <?php
        //========= Dialog untuk Melihat detail Pemakaian Barang =========================
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
            'id' => 'dialogDetail',
            'options' => array(
                'title' => 'Detail Retur Penerimaan Barang',
                'autoOpen' => false,
                'modal' => true,
                'width' => 750,
                'height' => 500,
                'resizable' => false,
            ),
        ));
        echo '<iframe src="" name="frameDetail" style="width: 100%; height: 98%;"></iframe>';
        $this->endWidget();
        ?>
        <?php
        //========= Dialog untuk Melihat detail Pemakaian Barang =========================
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
            'id' => 'dialogDetailTerima',
            'options' => array(
                'title' => 'Detail Penerimaan Barang',
                'autoOpen' => false,
                'modal' => true,
                'width' => 750,
                'height' => 500,
                'resizable' => false,
            ),
        ));
        echo '<iframe src="" name="frameDetailTerima" style="width: 100%; height: 98%;"></iframe>';
        $this->endWidget();
        ?>
    </div>
</div>