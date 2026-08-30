<?php

$caraPrint = isset($caraPrint) ? $caraPrint : null;

$table = 'ext.bootstrap.widgets.BootGridView';
$sort = true;
$visible = true;
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
$filter = $model;
if (isset($caraPrint)) {
    $row = '$row+1';
    $visible = false;
    $data = $model->searchInformasi('ada');

    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL") {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
    $filter = null;
} else {
    $data = $model->searchInformasi();
    $template = "{summary}\n{items}\n{pager}";
}

$this->widget($table, array(
    'id' => 'informasi-peralatan-opname-grid',
    'enableSorting' => $sort,
    'dataProvider' => $data,
    'template' => $template,
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'No',
            'value' => $row,
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:right;'),
        ),
        [
            'header' => 'Periode Opname',
            'type' => 'raw',
            'value' => function($data) {
                return $data->periodeasetopname_nama;
            }
        ],
        [
            'header' => 'Tanggal Opname',
            'name' => 'asetopname_tanggal',
            'value' => 'MyFormatter::formatDateTimeForUser($data->asetopname_tanggal,"long")'
        ],
        [
            'header' => 'Nomor Aset',
            'name' => 'invperalatan_kode'
        ],
        [
            'header' => 'Nama Aset',
            'name' => 'invperalatan_namabrg'
        ],
        [
            'header' => 'Ruangan Aset',
            'name' => 'ruangan_nama'
        ],
        [
            'header' => 'Lokasi Aset',
            'name' => 'lokasiaset_namalokasi'
        ],
        [
            'header' => 'Kondisi Aset',
            'name' => 'invperalatan_keadaan'
        ],
        [
            'header' => 'PIC Opname',
            'name' => 'nama_pegawai'
        ],
        [
            'header' => 'Verifikasi',
            'type' => 'raw',
            'name' => 'tanggal_verifikasi',
            'value' => function($data) {
                $pj_aset = PenanggungjawabasetM::model()->find(" pegawai_id = " . Yii::app()->user->getState('pegawai_id') . " ");
                $modAset = MAAsetopnameT::model()->findByPk($data->asetopname_id);
                
                if (empty($modAset->tanggal_verifikasi)) {
                    if (!empty($pj_aset)) {
                        return CHtml::link("<i class='entypo entypo-check'></i>", 'javascript:;', [
                                    'onclick' => 'toastr.warning("Hanya Pengurus Barang yang dapat melakukan verifikasi","Perhatian!")',
                                    'rel' => 'tooltip',
                                    'title' => 'Verifikasi Data',
                                    'class' => 'btn btn-success'
                        ]);
                    } else {
                        return CHtml::link("<i class='entypo entypo-check'></i>", $this->createUrl('verifikasi', ['asetopname_id' => $data->asetopname_id]), [
                                    'target' => 'frameAset',
                                    'onclick' => '$("#dialogVerifikasi").dialog("open");',
                                    'rel' => 'tooltip',
                                    'title' => 'Verifikasi Data',
                                    'class' => 'btn btn-success']);
                    }
                } else {
                    return 'Terverifikasi';
                }
            }
        ]
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});            
    }',
));
?>
