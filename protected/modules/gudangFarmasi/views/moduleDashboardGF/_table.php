<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-chart-pie"></i> 10 Daftar Mutasi Terakhir
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
                    'header' => 'Tgl. Mutasi',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tglmutasioa)',
                ),
                array(
                    'header' => 'No. Mutasi',
                    'type' => 'raw',
                    'value' => '$data->nomutasioa',
                ),
                array(
                    'header' => 'Instalasi Asal /Ruangan Asal',
                    'type' => 'raw',
                    'value' => '$data->instalasiasalmutasi_nama."/<br>".$data->ruanganasalmutasi_nama',
                ),
                array(
                    'header' => 'Instalasi Tujuan / Ruangan Tujuan',
                    'type' => 'raw',
                    'value' => '$data->instalasitujuanmutasi_nama."/<br>".$data->ruangantujuanmutasi_nama',
                ),
                array(
                    'header' => 'Total HPP Mutasi',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatNumberForUser($data->totalharganetto_mutasi)',
                ),
                array(
                    'header' => 'Total Harga Jual Mutasi',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatNumberForUser($data->totalharganetto_mutasi)',
                ),
                array(
                    'header' => 'Pegawai Mutasi',
                    'type' => 'raw',
                    'value' => '$data->PegawaiMutasi',
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