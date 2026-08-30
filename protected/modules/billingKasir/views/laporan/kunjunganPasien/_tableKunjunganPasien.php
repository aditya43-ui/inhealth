<?php 
    $table = 'ext.bootstrap.widgets.BootGroupGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchTable();
         $template = "{summary}\n{items}\n{pager}";
    }
?>
<?php
    $this->widget($table,
        array(
            'id'=>'tableLaporan',
            'dataProvider'=>$data,
            'template'=>$template,
            'enableSorting'=>$sort,
            'itemsCssClass'=>'table table-striped table-condensed',
            'mergeColumns' => array('instalasi_nama', 'ruangan_nama'),
            'columns'=>array(
                'instalasi_nama',
                'ruangan_nama',
                'no_rekam_medik',
                array(
                    'header' => 'Nama Pasien',
                    'value' => '$data->namadepan." ".$data->nama_pasien',
                ),                
                'alamat_pasien',
                'jeniskelamin',
                'umur',
                'jeniskasuspenyakit_nama',
                'kelaspelayanan_nama',
                array(
                  'name'=>'tgl_pendaftaran',
                  'type'=>'raw',
                  'value'=>'MyFormatter::formatDateTimeForUser(date("d/m/Y H:i:s",strtotime($data->tgl_pendaftaran)))',
                ),
                array(
                  'header'=>'Nama Dokter',
                  'type'=>'raw',
                  'value'=>'$data->getNamaDokter()',
                ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
?> 
