<?php
$itemCssClass='table table-striped table-bordered table-condensed';
//    $table = 'ext.bootstrap.widgets.MergeHeaderGroupGridView';
    $sort = true;
if (isset($caraPrint)){
    $data = $model->searchPrintLaporan();
    $template = "{items}";
    $sort = false;
    
    if ($caraPrint == "EXCEL"){
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
    
    if ($caraPrint == "PDF"){
        $itemCssClass='table border';
    }
    
    echo "
        <style>
            .border th, .border td{
                border:1px solid #000;
            }
            .table thead:first-child{
                border-top:1px solid #000;        
            }

            thead th{
                background:none;
                color:#333;
            }

            .border {
                box-shadow:none;
                border-spacing: 0;
                padding: 0;
            }

            .table tbody tr:hover td, .table tbody tr:hover th {
                background-color: none;
            }
        </style>";
    $itemCssClass='table border';
} else{
    $data = $model->searchTableLaporan();
    $template = "{summary}\n{items}\n{pager}";
}
?>

<?php
                        $this->widget('ext.bootstrap.widgets.BootGridView', array(
                            'id' => 'laporanpemakaiandarah-v-grid',
                            'dataProvider' => $data,
                             'enableSorting'=>$sort,
                            'replaceUrl'=>true,
                            'template' => "{summary}\n{items}\n{pager}",
                            'itemsCssClass' => $itemCssClass,
                            'columns' => array(
                                array(
                                    'header'=>'No.',
                                    'value' => '($this->grid->dataProvider->pagination) ? 
                                                    ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                                    : ($row+1)',
                                    'type'=>'raw',
                                    'htmlOptions'=>array('style'=>'text-align:left;'),
                                ),
                                array(
                                    'header'=>'Tanggal Pendaftaran',
                                    'type'=>'raw',
                                    'value'=> 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)'
                                ),
                                array(
                                    'header'=>'No. Pendaftaran',
                                    'type'=>'raw',
                                    'value'=> '$data->no_pendaftaran'
                                ),
                                array(
                                    'header'=>'Tanggal Permintaan',
                                    'type'=>'raw',
                                    'value'=> 'MyFormatter::formatDateTimeForUser($data->tglpermintaan)'
                                ),
                                array(
                                    'header'=>'No Permintaan',
                                    'type'=>'raw',
                                    'value'=> '$data->no_permintaandarah'
                                ),
                                array(
                                    'header'=>'Ruangan Asal',
                                    'type'=>'raw',
                                    'value'=> '$data->ruangan_nama'
                                ),
                                array(
                                    'header'=>'DPJP',
                                    'type'=>'raw',
                                    'value'=> '$data->nama_pegawai'
                                ),
                                array(
                                    'header'=>'No. Rekam Medik',
                                    'type'=>'raw',
                                    'value'=> '$data->no_rekam_medik'
                                ),
                                array(
                                    'header'=>'Nama Pasien',
                                    'type'=>'raw',
                                    'value'=> '$data->nama_pasien'
                                ),
                                array(
                                    'header'=>'Jenis Kelamin',
                                    'type'=>'raw',
                                    'value'=> '$data->jeniskelamin'
                                ),
                                array(
                                    'header'=>'Alamat',
                                    'type'=>'raw',
                                    'value'=> '$data->alamat_pasien'
                                ),
                                array(
                                    'header'=>'Umur',
                                    'type'=>'raw',
                                    'value'=> '$data->umur'
                                ),
                                array(
                                    'header'=>'Gol. Darah / Rhesus',
                                    'type'=>'raw',
                                    'value'=> '$data->kesimpulan_uji'
                                ),
                                array(
                                    'header'=>'Komponen Darah',
                                    'type'=>'raw',
                                    'value'=> '$data->singkatan_komp'
                                ),
                                array(
                                    'header'=>'Golongan Darah',
                                    'type'=>'raw',
                                    'value'=> '$data->golongan_darah'
                                ),
                                array(
                                    'header'=>'Stok Permintaan',
                                    'type'=>'raw',
                                    'value'=> '$data->jml_kantong'
                                ),
                                array(
                                    'header'=>'Stok Penyerahan',
                                    'type'=>'raw',
                                    'value'=> '$data->jml_penyerahan'
                                )
                            ),
                            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                        ));
                        ?>   