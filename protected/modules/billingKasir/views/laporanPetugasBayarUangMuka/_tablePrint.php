<?php

$caraPrint = $caraPrint ?? null;

$col = array(
    array(
        'header' => 'Tgl. Pembayaran Uang Muka Pasien/<br/>No. Pembayaran<br>',
        'type' => 'raw',
        'value' => 'MyFormatter::formatDateTimeForUser($data->tgluangmuka) . " <br> " . $data->nouangmuka ',
    ),
    array(
        'header' => 'No. Pendaftaran<br>',
        'type' => 'raw',
        'value' => '$data->no_pendaftaran ',
    ),
    array(
        'header' => 'Instalasi / Ruangan',
        'type' => 'raw',
        'value' => 'isset($data->instalasi_nama)?$data->ruangan_nama. " / ".$data->ruangan_nama:" - "',
    ),
    array(
        'header' => 'Jenis Penjamin/<br/>Penjamin',
        'type' => 'raw',
        'value' => '$data->carabayar_nama."/<br/>".$data->penjamin_nama',
    ),
    array(
        'header' => 'No. Rekam Medik',
        'type' => 'raw',
        'value' => '$data->no_rekam_medik',
    ),
    array(
        'name' => 'nama_pasien',
        'type' => 'raw',
        'value' => '$data->nama_pasien',
    ),
    array(
        'header' => 'Total Uang Muka',
        'type' => 'raw',
        'value' => function($data) {
            $str = "Rp. ".MyFormatter::formatNumberForPrint($data->jumlahuangmuka,2);
            if ($data->carabayar_id == Params::CARABAYAR_ID_MEMBAYAR) {
                if ($data->jumlahuangmuka >= 2000000) {
                    $str .= '<span class="sorot_merah">&nbsp;</span>';
                } else {
                    $str .= '<span class="sorot_kuning">&nbsp;</span>';
                }
            }
            return $str;
        }, //'"Rp. ".MyFormatter::formatNumberForPrint($data->jumlahuangmuka,2)',
        'htmlOptions' => array('style' => 'text-align: left; width:80px'),
        'htmlOptions' => array(
            'style' => 'text-align: right',
        ),
    ),
   
);

$prov = $model->searchInformasi();
$table = 'ext.bootstrap.widgets.BootGridView';

if ($caraPrint == "EXCEL"){
    $table = 'ext.bootstrap.widgets.BootExcelGridView';
}
 if ($caraPrint=='PDF') {
    $table = 'ext.bootstrap.widgets.BootGridViewPDF';
}

if (empty($caraPrint)) {
    $sort = true;
    $template = "{summary}\n{items}\n{pager}";
    array_push($col, 
    array(
        'header' => 'Status Periksa',
        'type' => 'raw',
        'value' => function ($data) {
            $p = PendaftaranT::model()->findByPk($data->pendaftaran_id);
            return CHtml::htmlButton($p->statusperiksa, array(
                'class' => 'btn ' . Params::statusPeriksaCol()[$p->statusperiksa],
                'style' => 'min-width: 200px;'
            ));
        },
    ),
    array(
        'header' => 'Rincian',
        'type' => 'raw',
        'value' => function ($data) {
            return CHtml::link('<i class="icon-form-detail"></i>', $this->createUrl('detailUangMuka', array('id' => $data->bayaruangmuka_id)), array(
                'target' => 'iframeDetail',
                'onclick' => '$("#dialogDetail").dialog("open");',
                'data-toggle' => 'tooltip',
                'title' => 'Klik untuk melihat Rincian Pembayaran Uang Muka',
            ));
        },
    ),
    array(
        'header' => 'Petugas Kasir',
        'type' => 'raw',
        'value' => function ($data) use (&$bayar) {
            $bayar = BayaruangmukaT::model()->findByPk($data->bayaruangmuka_id);
            $login = LoginpemakaiK::model()->findByPk($bayar->create_loginpemakai_id);
            if (empty($login->pegawai_id)) return "-";
            $peg = PegawaiM::model()->findByPk($login->pegawai_id);
            return $peg->namaLengkap;
        },
    )
    );
    $itemCssClass='table table-bordered table-condensed';
} else {
    $template = "{items}";
    $prov->pagination = false;
    $sort = false;
    $itemCssClass='table border';
}


$this->widget($table, array(
    'id' => 'pencarianpasien-grid',
    'dataProvider' => $prov,
    'template' => $template,
    'enableSorting'=>$sort,
    'itemsCssClass'=>$itemCssClass,
    'columns' => $col,
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"}); sorotTabel();}',
));
?>