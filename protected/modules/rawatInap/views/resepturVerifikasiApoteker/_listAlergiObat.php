<?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'daftarriwayat-v-grid',
    'dataProvider' => $modAnamnesa->searchAlergi(),
    'template' => "{summary}\n{items}\n{pager}",
    "replaceUrl" => true,
    'itemsCssClass' => 'table table-striped table-condensed',
    'columns' => [
        [
            'header' => 'No',
            'value' => '$row+1',
        ],  [
            'header' => 'Tanggal Anamnesis',
            'value' => function ($data) {
                return MyFormatter::formatDateTimeForUser($data->tglanamnesis);
            }
        ],
        [
            'header' => 'Riwayat Alergi Obat',
            'value' => function ($data) {
                return $data->riwayatalergiobat;
            }
        ],
        [
            'header' => 'Nama Dokter',
            'value' => function ($data) {
                $pegawai = PegawaiM::model()->findByPk($data->pegawai_id);

                return $pegawai->namaLengkap;
            }
        ],
    ],
    'afterAjaxUpdate' => 'function(id, data){
        jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
)); ?>

