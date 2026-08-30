<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="panel-title">5 User Terakhir Login</div>
        <div class="panel-options">
            <a data-rel="collapse" href="#">
                <i class="entypo-down-open"></i>
            </a>
            <a data-rel="reload" href="#">
                <i class="entypo-arrows-ccw"></i>
            </a>
        </div>
    </div>
    <div class="panel-body with-table">
        <?php

        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'table-grid',
            'dataProvider' => $dataTable->searchDashboard(),
            'template' => "{pager}\n{items}",
            'itemsCssClass' => 'table table-striped table-bordered table-condensed table-responsive',
            'columns' => array(
                array(
                    'header' => 'Tgl. Terakhir Login',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->lastlogin)',
                ),
                array(
                    'header' => 'Nama Pemakai',
                    'type' => 'raw',
                    'value' => '$data->nama_pemakai',
                ),
                array(
                    'header' => 'Nama Pegawai',
                    'type' => 'raw',
                    'value' => ' (isset($data->pegawai_id)?$data->pegawai->NamaLengkap: "-")',
                ),
                array(
                    'header' => 'Nama Pasien',
                    'type' => 'raw',
                    'value' => '(isset($data->pasien_id)?$data->pasien->nama_pasien:"-")',
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