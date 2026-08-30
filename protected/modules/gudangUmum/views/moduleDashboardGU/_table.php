<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-chart-pie"></i> Transaksi <b>Pembelian Barang terakhir</b>
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
            'dataProvider' => $dataTable->search10Terakhir(),
            'template' => "{pager}\n{items}",
            'itemsCssClass' => 'table table-striped table-bordered table-condensed table-responsive',
            'columns' => array(
                'nopembelian',
                array(
                    'name' => 'tglpembelian',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tgldikirim)',
                ),
                'belibrgdetail.barang.barang_nama',
                array(
                    'header' => 'Sumber Dan',
                    'type' => 'raw',
                    'value' => '$data->sumberdana->sumberdana_nama',
                ),
                'supplier.supplier_nama'

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