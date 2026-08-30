<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan Mutasi Pegawai
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'mutasi-r-grid',
            'dataProvider' => $model->getData(),
            'filter' => $model,
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
            'columns' => array(
                [
                    'header' => 'NIP',
                    'value' => '$data->pegawai->nomorindukpegawai'
                ],
                array(
                    'header' => 'Nama Pegawai',
                    'value' => '$data->pegawai->nama_pegawai'
                ),
                [
                    'header' => 'Tanggal Mutasi',
                    'value' => '$data->tglsk'
                ],
                [
                    "header" => 'Asal Unit Kerja',
                    'value' => '$data->unitkerja',
                ],
                [
                    "header" => 'Tujuan Mutasi Unit Kerja',
                    'value' => '$data->unitkerja_baru',
                ]
            ),
        ));
        ?>
    </div>
</div>