<div>
    <?php
    $this->widget(
        'ext.bootstrap.widgets.BootGridView',
        array(
            'id' => 'AK-grid-rincian-jurnal',
            'dataProvider' => $model->searchByFilter(),
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
            'columns' => array(
                array(
                    'header' => 'No.',
                    'type' => 'raw',
                    'value' => '$row+1',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                'uraiantransaksi',
                array(
                    'header' => 'Debit',
                    'type' => 'raw',
                    'value' => '$data->getRekDebit()',
                ),
                array(
                    'header' => 'Kredit',
                    'type' => 'raw',
                    'value' => '$data->getRekKredit()',
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        )
    );
    ?>
</div>