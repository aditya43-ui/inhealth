<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-chart-pie"></i> 10 Faktur Jatuh Tempo
        </div>
        <div class="panel-options">
            <a data-rel="collapse" href="#">
                <i class="entypo-down-open"></i>
            </a>
            <a data-rel="reload" href="#">
                <i class="entypo-arrows-ccw"></i>
            </a>
        </div>
    </div>
    <div class="panel-body with-table table-responsive">
        <?php

        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'table-grid',
            'dataProvider' => $dataTable->searchDashboard(),
            'template' => "{pager}\n{items}",
            'itemsCssClass' => 'table table-striped table-bordered table-condensed table-responsive',
            'columns' => array(
                array(
                    'header' => 'Tgl. Faktur',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tglfaktur)',
                ),
                array(
                    'header' => 'Tgl. Jatuh Tempo',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tgljatuhtempo)',
                ),
                array(
                    'header' => 'No. Faktur',
                    'type' => 'raw',
                    'value' => '$data->nofaktur',
                ),
                array(
                    'header' => 'Nama Supplier',
                    'type' => 'raw',
                    'value' => '$data->supplier->supplier_nama',
                ),
            ),
        ));
        ?>
    </div>
</div>

<script type="text/javascript">
    function refreshTable() {
        $.fn.yiiGridView.update('table-grid');
    }
</script>