<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-users"></i> 10 Pasien Konsultasi Gizi Terakhir
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
                    'header' => 'Tgl. Masuk Penunjang',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tglmasukpenunjang)',
                ),
                array(
                    'header' => 'No. Masuk Penunjang',
                    'type' => 'raw',
                    'value' => '$data->no_masukpenunjang',
                ),
                array(
                    'header' => 'No. Rekam Medik',
                    'type' => 'raw',
                    'value' => '$data->no_rekam_medik',
                ),
                array(
                    'header' => 'No. Pendaftaran',
                    'type' => 'raw',
                    'value' => '$data->no_pendaftaran',
                ),
                array(
                    'header' => 'Nama Pasien',
                    'type' => 'raw',
                    'value' => '$data->namadepan." ".$data->nama_pasien',
                ),
                array(
                    'header' => 'Umur',
                    'type' => 'raw',
                    'value' => '$data->umur',
                ),
                array(
                    'header' => 'Jenis Kelamin',
                    'type' => 'raw',
                    'value' => '$data->jeniskelamin',
                ),
                array(
                    'header' => 'Ruangan Asal',
                    'type' => 'raw',
                    'value' => '$data->ruanganasal_nama',
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