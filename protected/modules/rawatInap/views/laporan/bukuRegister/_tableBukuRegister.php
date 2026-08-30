<?php 
    $table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
    $itemCssClass="table table-bordered table-striped table-condensed";
    if (isset($caraPrint)){
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
        $table = 'ext.bootstrap.widgets.BootExcelGridView';}
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
        $data = $model->searchTable();
         $template = "{summary}\n{items}\n{pager}";
    }
?>

<?php $this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
        'template'=>$template,
        'enableSorting'=>$sort,
        'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
//            'instalasi_nama',
            'no_rekam_medik',
            array(
                'header'=>'Nama Pasien',
                'value'=>'$data->namadepan.$data->nama_pasien',
            ),
            'umur',
            'jeniskelamin',
            'no_pendaftaran',
            'nama_perujuk',
            'alamat_pasien',
            'kabupaten_nama',
            'propinsi_nama',
            'kelaspelayanan_nama',
            'nomasukkamar',
            'kunjungan',
            array(
               'header'=>'Jenis Penjamin <br>Penjamin',
               'type'=>'raw',
               'value'=>'$data->carabayar_nama."/<br>".$data->penjamin_nama',
               'htmlOptions'=>array('style'=>'text-align: center')
            ),
            array(
                'name'=>'Diagnosa Pasien',
                'type'=>'raw',
                'value'=> function($data){
                    $modMorbiditas = PasienmorbiditasT::model()->findByAttributes(array(
                        'pendaftaran_id' => $data->pendaftaran_id,
                        //'kelaspelayanan_id'=>$row->kelaspelayanan_id
                    ));
                    return !empty($modMorbiditas->diagnosa_id) ? $modMorbiditas->diagnosa->diagnosa_nama : " ";
                }
                // 'value'=>'!empty($data->diagnosa_id) ? $data->diagnosa_nama : ""',
            ),     
            // 'penjamin_nama',
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>