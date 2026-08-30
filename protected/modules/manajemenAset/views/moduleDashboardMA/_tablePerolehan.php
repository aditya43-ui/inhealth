<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="panel-title">10 Peralatan dengan nilai perolehan terbesar</div>
        <div class="panel-options">
            <a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
            <a data-rel="reload" href="#" onclick="refreshTable2();"><i class="entypo-arrows-ccw"></i></a>
        </div>
    </div>
    <div class="panel-body with-table">
        <?php
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'table2-grid',
            'dataProvider' => $dataTable2->searchPeralatanNilaiPerolehan(),
            'template' => "{pager}\n{items}",
            'itemsCssClass' => 'table table-striped table-bordered table-condensed table-responsive',
            'columns' => array(
                array(
                    'header' => 'Jenis',
                    'type' => 'raw',
                    'value' => '$data->barang_nama',
                ),                
                array(
                    'header' => 'Kode Aset',
                    'type' => 'raw',
                    'value' => '$data->invperalatan_kode',
                ),  
                array(
                    'header' => 'Nilai Perolehan',
                    'type' => 'raw',
                    'htmlOptions' => [
                        'style' => 'text-align:right;'
                    ],
                    'value' => 'MyFormatter::formatNumberForPrint((float)$data->invperalatan_harga,2)',
                ),  
            ),
        ));
        ?>

    </div>
</div>

<script type="text/javascript">
    function refreshTable2() {
        $.fn.yiiGridView.update('table2-grid');
    }
</script>