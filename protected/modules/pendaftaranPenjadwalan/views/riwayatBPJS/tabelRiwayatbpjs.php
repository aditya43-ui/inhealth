<div>
    <?php
    $table = 'ext.bootstrap.widgets.BootGridView';
    if (isset($caraPrint)) {
        $data = $model->searchLog();
        $template = '{items}';
        if ($caraPrint == 'EXCEL') {
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
        }
    } else {
        $data = $model->searchLog();
        $template = "{summary}{items}{pager}";
    }
    ?>
    <?php
    $this->widget($table, array(
        'id' => 'informasibpjslog-v',
        'dataProvider' => $data,
        'template' => $template,
        'itemsCssClass' => 'table table-bordered datatable',
        'columns' => array(
            array(
                'header' => 'Tanggal Log',
                'value' => function ($data) {
                    echo MyFormatter::formatDateTimeForUser($data->tgl_log);
                },
            ),
            array(
                'header' => 'No. Pendaftaran',
                'value' => function ($data) {
                    echo $data->no_pendaftaran;
                }
            ),
            array(
                'header' => 'Tanggal Pendaftaran',
                'value' => function ($data) {
                    echo MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran);
                }
            ),
            array(
                'header' => 'Username Log',
                'value' => function ($data) {
                    echo $data->nama_pemakai;
                }
            ),
            array(
                'header' => 'Nama Pegawai Log',
                'value' => function ($data) {
                    echo $data->nama_pegawai;
                }
            ),
            array(
                'header' => 'API',
                'value' => function ($data) {
                    echo $data->api;
                }
            ),
            array(
                'header' => 'Request',
                'value' => function ($data) {
                    echo $data->json_request_respose;
                }
            ),
            array(
                'header' => 'Response Code',
                'value' => function ($data) {
                    echo $data->code;
                }
            ),
            array(
                'header' => 'Response Message',
                'value' => function ($data) {
                    echo $data->pesan;
                }
            ),
            array(
                'header' => 'Ip Address  Log',
                'value' => function ($data) {
                    echo $data->ip_address;
                }
            ),
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    )); ?>
</div>