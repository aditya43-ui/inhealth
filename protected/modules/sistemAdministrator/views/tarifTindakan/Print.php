<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
// echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      
if ($caraPrint=='EXCEL') {
    echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel',array('judulLaporan'=>$judulLaporan, 'colspan'=>7));      
} else {
    echo $this->renderPartial('application.views.headerReport.headerDefaultNew',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      
}

echo 'Perda Tarif : '.PerdatarifM::model()->findByAttributes(array('perdatarif_id'=>Params::DEFAULT_PERDA_TARIF))->perdanama_sk.'';
ini_set('memory_limit','-1');
  $table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchPrint();
         $template = "{summary}\n{items}\n{pager}";
    }
    
$this->widget($table,array(
	'id'=>'satarif-tindakan-m-grid',
        'enableSorting'=>$sort,
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                 array(
                    'header'=>'No',
                    'value'=>'$row+1',
                ),
                 array(
                        'name'=>'jenistarif_id',
//                        'filter'=>  CHtml::listData(SATarifTindakanM ::model()->getJenisTarifItems(), 'jenistarif_id', 'jenistarif_nama'),
//                         'value'=>array($this,'gridJenisTarif'),
                         'value'=>'$data->jenistarif_nama',
                ),
                 array(
                        'name'=>'kelaspelayanan_id',
//                        'filter'=>  CHtml::listData(SATarifTindakanM ::model()->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama'),
//                         'value'=>array($this,'gridKelasPelayanan'),
                         'value'=>'$data->kelaspelayanan_nama',
                ),
                array(
                        'name'=>'kategoritindakan_id',
//                        'filter'=>  CHtml::listData(SATarifTindakanM ::model()->KategoriTindakanItems, 'kategoritindakan_id', 'kategoritindakan_nama'),
//                        'value'=>array($this,'gridKategoriTindakan'),
                        'value'=>'$data->kategoritindakan_nama',
                ),
                array(
                        'name'=>'daftartindakan_id',
//                        'filter'=>  CHtml::listData(SATarifTindakanM ::model()->DaftarTindakanItems, 'daftartindakan_id', 'daftartindakan_nama'),
//                         'value'=>array($this,'gridDaftarTindakan'),
                         'value'=>'$data->daftartindakan_nama',
                ),
                array(
                        'name'=>'komponentarif_id',
//                        'filter'=>  CHtml::listData(SATarifTindakanM ::model()->KomponenTarifItems, 'komponentarif_id', 'komponentarif_nama'),
//                        'value'=>'$data->komponentarif_nama',
//                        'value'=>array($this,'gridKomponenTarif'),
                        'value'=>'$data->komponentarif_nama',
                ),
                array(
                    'header'=>'Nominal Tarif',
                    'name'=>'harga_tariftindakan',
                    'type'=>'raw',
					'htmlOptions' => array('style' => 'text-align:right;'),
                    'value'=>'"Rp".number_format($data->harga_tariftindakan,0,"",".")',
                ),
				array(
						'header' => 'Penjamin',
						'value' => '$data->penjamin_nama'
					),
//		'harga_tariftindakan',
		/*
		'persendiskon_tind',
		'hargadiskon_tind',
		'persencyto_tind',
		*/
               
	),
    )); 
?>