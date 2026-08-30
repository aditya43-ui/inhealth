<?php

$prov = $model->searchLaporan();

$prov->pagination = false;
$total = 0;

foreach ($prov->data as $item) {
    $total += $item->totalterima - $item->totalpotongan;
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'laporan-grid',
    'dataProvider' => $model->searchLaporan(),
    //	'filter'=>$model,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-condensed table-bordered',
    'columns' => array(
        array(
            'header' => 'No.',
            'type' => 'raw',
            'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
        ),
        array(
            'name' => 'tglpenggajian',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tglpenggajian)',
            'footer' => "Total Penerimaan Keseluruhan",
            'footerHtmlOptions' => array(
                'style' => 'text-align: right; font-weight: bold;',
                'colspan' => 19,
            ),
        ),
        array(
            'name' => 'pegawai.nomorindukpegawai',
            'footer' => false,
            'footerHtmlOptions' => array('hidden' => true),
        ),
        array(
            'header' => 'Unit Kerja',
            'type' => 'raw',
            'value' => function ($data) {
                return empty($data->pegawai->unitkerja) ? "-" : $data->pegawai->unitkerja->namaunitkerja;
            },
            'footer' => false,
            'footerHtmlOptions' => array('hidden' => true),
        ),
        array(
            'header' => 'Pendidikan',
            'type' => 'raw',
            'value' => function ($data) {
                return empty($data->pegawai->pendidikan) ? "-" : $data->pegawai->pendidikan->pendidikan_nama;
            },
            'footer' => false,
            'footerHtmlOptions' => array('hidden' => true),
        ),
        array(
            'header' => 'Jabatan',
            'type' => 'raw',
            'value' => function ($data) {
                return empty($data->pegawai->jabatan) ? "-" : $data->pegawai->jabatan->jabatan_nama;
            },
            'footer' => false,
            'footerHtmlOptions' => array('hidden' => true),
        ),
        array(
            'name' => 'pegawai.nama_pegawai',
            'footer' => false,
            'footerHtmlOptions' => array('hidden' => true),
        ),
        array(
            'header' => 'Tempat/ Tgl. Lahir',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->pegawai->tempatlahir_pegawai . '<br>' . MyFormatter::formatDateTimeForUser($data->pegawai->tgl_lahirpegawai);
            },
            'footer' => false,
            'footerHtmlOptions' => array('hidden' => true),
        ),
        array(
            'header' => 'No. Rekening',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->pegawai->no_rekening;
            },
            'footer' => false,
            'footerHtmlOptions' => array('hidden' => true),
        ),
        array(
            'header' => 'No. NPWP',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->pegawai->npwp;
            },
            'footer' => false,
            'footerHtmlOptions' => array('hidden' => true),
        ),
        array(
            'header' => 'Bank',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->pegawai->bank_no_rekening;
            },
            'footer' => false,
            'footerHtmlOptions' => array('hidden' => true),
        ),
        array(
            'header' => 'PTKP',
            'type' => 'raw',
            'value' => function ($data) {
                $peg = $data->pegawai;
                if (empty($peg->ptkp_id)) {
                    return "-";
                }
                $ptkp = PtkpM::model()->findByPk($peg->ptkp_id);

                if (empty($ptkp)) {
                    return "-";
                }

                return $ptkp->kodeptkp . "/" . $ptkp->jmltanggunan;
            },
            'footer' => false,
            'footerHtmlOptions' => array('hidden' => true),
        ),
        array(
            'header' => 'No. BPJS Kesehatan',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->pegawai->no_bpjs_kesehatan;
            },
            'footer' => false,
            'footerHtmlOptions' => array('hidden' => true),
        ),
        array(
            'header' => 'No. BPJS Ketenagakerjaan',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->pegawai->no_bpjs_ketenagakerjaan;
            },
            'footer' => false,
            'footerHtmlOptions' => array('hidden' => true),
        ),
        array(
            'header' => 'Tgl. Diterima',
            'type' => 'raw',
            'value' => function ($data) use (&$tgl_resign) {
                $resign = ResignT::model()->findByAttributes(array(
                    'pegawai_id' => $data->pegawai_id,
                ), array(
                    'order' => 'resign_id desc',
                ));

                $tgl_resign = "";
                $tgl_terima = empty($data->pegawai->tglditerima) ? "" : MyFormatter::formatDateTimeForUser($data->pegawai->tglditerima);
                if (!empty($resign)) {
                    $tgl_resign = MyFormatter::formatDateTimeForUser($resign->tglresign);
                    $tgl_terima = MyFormatter::formatDateTimeForUser($resign->tglditerima);
                }

                return $tgl_terima;
            }
        ),
        array(
            'header' => 'Tgl. Resign',
            'type' => 'raw',
            'value' => function ($data) use (&$tgl_resign) {
                return $tgl_resign;
            }
        ),
        array(
            'header' => 'Kehadiran',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->harihadir;
            },
            'footer' => false,
            'footerHtmlOptions' => array('hidden' => true),
        ),
        array(
            'header' => 'Status Pegawai',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->pegawai->kategoripegawai;
            },
            'footer' => false,
            'footerHtmlOptions' => array('hidden' => true),
        ),


        array(
            'header' => 'Total gaji',
            'type' => 'raw',
            'value' => 'number_format($data->totalterima,0,"",".")',
            'htmlOptions' => array(
                'style' => 'text-align: right;'
            ),
            'footer' => false,
            'footerHtmlOptions' => array('hidden' => true),
        ),
        array(
            'header' => 'Total Pajak',
            'type' => 'raw',
            'value' => 'number_format($data->totalpajak,0,"",".")',
            'htmlOptions' => array(
                'style' => 'text-align: right;'
            ),
            'footer' => false,
            'footerHtmlOptions' => array('hidden' => true),
        ),
        array(
            'header' => 'Potongan Lain-Lain',
            'type' => 'raw',
            'value' => 'number_format($data->potongan_lainlain,0,"",".")',
            'htmlOptions' => array(
                'style' => 'text-align: right;'
            ),
            'footer' => false,
            'footerHtmlOptions' => array('hidden' => true),
        ),
        array(
            'header' => 'Penambahan',
            'type' => 'raw',
            'value' => 'number_format($data->penambahan,0,"",".")',
            'htmlOptions' => array(
                'style' => 'text-align: right;'
            ),
            'footer' => false,
            'footerHtmlOptions' => array('hidden' => true),
        ),
        array(
            'header' => 'Pengurangan',
            'type' => 'raw',
            'value' => 'number_format($data->pengurangan,0,"",".")',
            'htmlOptions' => array(
                'style' => 'text-align: right;'
            ),
            'footer' => false,
            'footerHtmlOptions' => array('hidden' => true),
        ), /*
                    array(
                        'header'=>'Total Potongan',
                        'type'=>'raw',
                        'value'=>'number_format($data->totalpotongan,0,"",".")',
                        'htmlOptions'=>array(
                            'style'=>'text-align: right;'
                        ),
                        'footer'=>false,
                        'footerHtmlOptions'=>array('hidden'=>true),
                    ),
                     * 
                     */
        array(
            'header' => 'Total Penerimaan',
            'type' => 'raw',
            'value' => 'number_format(($data->totalterima - $data->totalpotongan),0,"",".")',
            'htmlOptions' => array(
                'style' => 'text-align: right;'
            ),
            'footer' => MyFormatter::formatNumberForPrint($total),
            'footerHtmlOptions' => array(
                'style' => 'text-align: right; font-weight: bold;'
            ),
        ),
        'keterangan',
        array(
            'header' => 'Rincian',
            'type' => 'raw',
            'value' => function ($data) {

                return CHtml::link("<i class=icon-form-detail></i>", Yii::app()->createUrl(Yii::app()->controller->module->id . '/penggajianpegT' . $this->init . '/Print', array("id" => $data->penggajianpeg_id, "pegawai_id" => $data->pegawai_id, 'jenis' => 'rincianlaporan')), array("target" => "frame_detail", "onclick" => "$('#detailSlipGaji').dialog('open');", "rel" => "tooltip", "rel" => "tooltip", "title" => "Detail Slip Gaji"));
            },
            'htmlOptions' => array('style' => 'text-align: center')
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>

<?php
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'detailSlipGaji',
        'options' => array(
            'title' => 'Detail Slip Gaji',
            'autoOpen' => false,
            'minWidth' => 500,
            'width' => 900,
            'modal' => true,
        ),
    )
);
?>
<iframe src="" height="500" width="100%" name="frame_detail"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>