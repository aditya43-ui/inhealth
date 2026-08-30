
<div class="panel panel-primary panel-success">
    <div class="panel-heading">
        <div class="panel-title">											
            Riwayat Status Pemeliharaan																
        </div>
    </div>
    <div class="panel-body">
        <?php

        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'corectivemaintenance-r-grid',
            'dataProvider' => $modR->search(),
            'replaceUrl' => true,
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-bordered table-striped table-condensed',
            'columns' => array(
                array(
                    'header' => 'No.',
                    'value' => '($this->grid->dataProvider->pagination) ? 
                                                            ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                                            : ($row+1)',
                    'type' => 'raw',
                    'htmlOptions' => array('style' => 'text-align:left;'),
                ),
                array(
                    'header' => 'Tanggal',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tanggal)'
                ),
                array(
                    'header' => 'Pegawai',
                    'value' => '$data->nama_lengkap'
                ),
                array(
                    'header' => 'Status',
                    'type' => 'raw',
                    'value' => '$data->status'
                ),                
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
        ?>
    </div>
</div>