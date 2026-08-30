<?php
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$action = $this->getAction()->getId();
$currentUrl = Yii::app()->createUrl($module . '/' . $controller . '/' . $action);
?>

<?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'gumutasibrg-t-grid',
    'dataProvider' => $model->searchInformasi(),
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-striped datatable',
    'columns' => array(
        array(
            'name' => 'nomutasibrg',
            'type' => 'raw',
            'value' => function ($data) {
                return CHtml::link(
                    '<u>' . $data->nomutasibrg . '</u>',
                    Yii::app()->controller->createUrl("detailMutasiBarang", array("id" => $data->mutasibrg_id)),
                    array(
                        "id" => "$data->mutasibrg_id",
                        "target" => "frameDetail",
                        "rel" => "tooltip",
                        "title" => "Klik untuk Detail Mutasi Barang",
                        "onclick" => 'window.parent.$("#dialogDetail").dialog("open");'
                    )
                );
            }
        ),
        array(
            'name' => 'tglmutasibrg',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tglmutasibrg)',
        ),
        array(
            'header' => 'Pengirim',
            'type' => 'raw',
            'value' => '(isset($data->pegawaipengirim)?$data->pegawaipengirim->nama_pegawai:"")',
        ),
        array(
            'header' => 'Menyetujui',
            'type' => 'raw',
            'value' => '(isset($data->pegawaimenyetujui)?$data->pegawaimenyetujui->nama_pegawai:"")',
        ),
        array(
            'header' => 'Mengetahui',
            'type' => 'raw',
            'value' => '(isset($data->pegawaimengetahui)?$data->pegawaimengetahui->nama_pegawai:"")',
        ),
        array(
            'name' => 'totalhargamutasi',
            'value' => 'MyFormatter::formatNumberForPrint($data->totalhargamutasi)',
            'htmlOptions' => array(
                'style' => 'text-align: right;',
            ),
        ),
        array(
            'header' => 'Ruangan Pengirim',
            'type' => 'raw',
            'value' => function ($data) {
                if (empty($data->create_ruangan)) return "-";
                $ruangan = RuanganM::model()->findByPk($data->create_ruangan);

                return $ruangan->ruangan_nama;
            }
        ),
        array(
            'header' => 'Ruangan Tujuan',
            'type' => 'raw',
            'value' => function ($data) {
                if (empty($data->ruangantujuan_id)) return "-";
                $ruangan = RuanganM::model()->findByPk($data->ruangantujuan_id);

                return $ruangan->ruangan_nama;
            }
        ),
        'keterangan_mutasi',
        array(
            'name' => 'No. Pemesanan',
            'type' => 'raw',
            'value' => function ($data) {
                if (empty($data->pesanbarang_id)) return "-";
                $pesan = PesanbarangT::model()->findByPk($data->pesanbarang_id);

                return CHtml::link('<u>' . $pesan->nopemesanan . '</u>', Yii::app()->controller->createUrl('detailPesanBarang', array('id' => $pesan->pesanbarang_id)), array(
                    "target" => "frameDetailPesan",
                    "rel" => "tooltip",
                    "title" => "Klik untuk Detail Pemesanan Barang",
                    "onclick" => 'window.parent.$("#dialogDetailPesan").dialog("open");'
                ));
            }
        ),
        // 'pesanbarang.nopemesanan',
        array(
            'header' => 'Batal Mutasi',
            'type' => 'raw',
            'value' => function ($data) {

                if ($data->create_ruangan == Yii::app()->user->getState('ruangan_id'))
                    return ($data->testingData == false) ? CHtml::link('<span style="font-size:17px;"><i class="' . MyIcon::getIcons('batal') . '"></i></span>',  Yii::app()->controller->createUrl("batalMutasiBarang", array("id" => $data->mutasibrg_id)), array(
                        "id" => "$data->mutasibrg_id",
                        "target" => "frameDetail",
                        "rel" => "tooltip",
                        "data-placement" => 'left',
                        "title" => "Klik untuk Pembatalan Mutasi Barang",
                        "onclick" => 'window.parent.$("#dialogDetail").dialog("open")'
                    )) : "Telah Dibatalkan";

                return ($data->testingData == false) ? "-" : "Telah dibatalkan";
            },
            'htmlOptions' => array(
                'style' => 'text-align: center;'
            ),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
)); ?>