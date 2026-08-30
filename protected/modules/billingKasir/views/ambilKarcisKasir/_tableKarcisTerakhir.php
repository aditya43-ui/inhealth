<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Tabel Karcis Terakhir
        </div>
    </div>
    <div class="panel-body">
        <?php
        $modKarcisTerakhir = new BKAntrianT('search');
        $modKarcisTerakhir->unsetAttributes();
        if (isset($_GET['BKAntrianT'])) {
            $modKarcisTerakhir->attributes = $_GET['BKAntrianT'];
        }
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'anantrian-t-grid',
            'dataProvider' => $modKarcisTerakhir->searchKarcisTerakhir(),
            'filter' => $modKarcisTerakhir,
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
            'columns' => array(
                array(
                    'header' => 'No.',
                    'value' => '(($this->grid->dataProvider->pagination) ? '
                        . '($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)'
                        . ' : $row+1)',
                    'type' => 'raw',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                array(
                    'name' => 'tglantrian',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tglantrian)',
                    'filter' => false,
                ),
                array(
                    'name' => 'ruangan_id',
                    'type' => 'raw',
                    'value' => '$data->ruangan->ruangan_nama." (".$data->ruangan->ruangan_singkatan.")"',
                    'filter' => $modKarcisTerakhir->getListRuangans(),
                ),
                'noantrian',
                array(
                    'name' => 'panggil_flaq',
                    'filter' => array(1 => 'Sudah', 0 => 'Belum'),
                    'type' => 'raw',
                    'value' => '($data->panggil_flaq) ? "Sudah" : "Belum"',
                ),

                array(
                    'header' => 'Print Karcis',
                    'filter' => false,
                    'type' => 'raw',
                    'value' => 'CHtml::Link("<i class=\"entypo-print\"></i>","javascript:void(0);",
                            array(
                                  "onclick"=>"printKarcisKasir($data->antrian_id,\"PRINT\")",
                                  "rel"=>"tooltip",
                                  "title"=>"Klik untuk Membatalkan Pembayaran",
                            ))',
                    'htmlOptions' => array(
                        'style' => 'text-align: center;'
                    )
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        )); ?>
    </div>
</div>