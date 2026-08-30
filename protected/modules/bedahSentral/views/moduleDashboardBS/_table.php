<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-users"></i> Update 10 Pasien Melakukan Operasi
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
            'dataProvider' => $dataTable->searchTabel(),
            'template' => "{pager}\n{items}",
            'itemsCssClass' => 'table table-striped table-bordered table-condensed table-responsive',
            'columns' => array(
                array(
                    'header' => 'Tanggal Operasi',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->selesaioperasi)',
                ),
                array(
                    'header' => 'Pasien',
                    'type' => 'raw',
                    'value' => '$data->pasien->nama_pasien',
                ),
                array(
                    'header' => 'Jenis Operasi',
                    'type' => 'raw',
                    'value' => '!empty($data->operasi) ? $data->operasi->operasi_nama : ""',
                ),
                array(
                    'header' => 'Dokter',
                    'type' => 'raw',
                    'value' => '$data->dokter1->nama_pegawai',
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