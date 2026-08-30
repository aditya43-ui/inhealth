<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-chart-pie"></i> Dokumen Rekam Medis Hari Ini
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
                    'header' => 'Tanggal Rekam Medis',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tglrekammedis)',
                ),
                array(
                    'header' => 'Lokasi Rak',
                    'type' => 'raw',
                    'value' => 'isset($data->lokasirak->lokasirak_nama) ? $data->lokasirak->lokasirak_nama : ""',
                ),
                array(
                    'header' => 'Sub Rak',
                    'type' => 'raw',
                    'value' => 'isset($data->subrak->subrak_nama) ? $data->subrak->subrak_nama : ""',
                ),
                array(
                    'header' => 'Warna Dokumen',
                    'type' => 'raw',
                    'value' => 'isset($data->warnadok->warnadokrm_namawarna) ? $data->warnadok->warnadokrm_namawarna : ""',
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