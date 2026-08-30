<?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'penjualanresepriwayat-v-grid',
    'dataProvider' => $modRiwayatPenjualanResep->searchRiwayatPenjualan(),
    'template' => "{summary}\n{items}\n{pager}",
    "replaceUrl" => true,
    'itemsCssClass' => 'table table-striped table-condensed',
    'columns' => [
        [
            'header' => 'No',
            'value' => '$row+1',
        ],
        [
            'header' => 'Tanggal Resep',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tglresep)'
        ],
        [
            'header' => 'No. Resep',
            'value' => '$data->noresep'
        ],
        [
            'header' => 'No. Triage',
            'value' => function($data) {
                $modPengambilan = PengambilanobatTriageT::model()->findByAttributes(['pendaftaran_id' => $data->pendaftaran_id]);
                echo $modPengambilan->notriage->no_triage_pasien ?? '';
            }
        ],
        [
            'header' => 'Jenis Penjamin/ <br> Penjamin/ <br> No. SEP/ <br> No. Kartu',
            'value' => function($data) {
                $str = $data->pendaftaran->carabayar->carabayar_nama ?? '';
                $str .= "<br/>" . $data->pendaftaran->penjamin->penjamin_nama ?? '';
                $str .= "<br>";
                $str .= $data->pendaftaran->sepTs->nosep ?? '';
                $str .= "<br>";
                $str .= $data->pendaftaran->sepTs->nokartuasuransi ?? '';
                echo $str;
            }
        ],
        [
            'header' => 'Pegawai Input',
            'value' => function($data) {
               echo $data->loginpemakai->pegawai->namaLengkap ?? '';
            }
        ],
        [
            'header' => 'Lihat Detail',
            'type' => 'raw',
            'value' => function($data){
                return "<center>" . CHtml::link('<i class="icon-form-lihat" style="color:green;"></i>', $this->createUrl('detailPenjualan', ['penjualanresep_id' => $data->penjualanresep_id]), array('rel' => 'tooltip', 'title' => 'Klik untuk Lihat Detail', 'target' => 'iframeDetail', 'onclick' => "$('#dialogDetailPenjualan').dialog('open')")) . "</center>"; 
            }
        ]
        
    ],
    'afterAjaxUpdate' => 'function(id, data){
        jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    )); 
?>
