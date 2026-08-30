<?php 
$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
$data = $model->searchRiwayatPasien();
$template = "{summary}\n{items}\n{pager}";
$sort = false;
if (isset($caraPrint)){
    $sort = false;
  $data = $model->searchRiwayatPasienPrint();  
  $template = "{items}";
  if ($caraPrint == "EXCEL") {
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
  }
}
?>
<?php 
$this->widget($table,array(
    'id'=>'laporan-grid',
    'dataProvider'=>$data,
    'enableSorting'=>$sort,
    'template'=>$template,
        'itemsCssClass'=>'table table-bordered table-striped table-condensed',
//                'mergeColumns'=>array('noresep','tglresep','totalhargajual','jumalhresep'),
	'columns'=>array(
                    array(
                        'header'=>'No.',
                        'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
                    ),
                    array(
                        'header'=>'Tanggal Resep',
                        'name'=>'tglresep',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tglresep)',
                        'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                        'footerHtmlOptions'=>array('colspan'=>6,'style'=>'text-align:center;font-weight:bold;'),
                        'footer'=>'<b>Total</b>',
                    ),
                    array(
                        'header'=>'No. Resep',
                        'name'=>'noresep',
                        'value'=>'$data->noresep',
                    ),      
                    array(
                        'header'=>'Nama Pasien',
                        'name'=>'noresep',
                        'value'=>'$data->nama_pasien',
                    ),     
                    array(
                        'header'=>'Dokter Resep',
                        'name'=>'pegawai_id',
                        'value'=>function($data){
                            
                            if ($data->jenispenjualan == Params::JENISPENJUALAN_RESEP || $data->jenispenjualan == Params::JENISPENJUALAN_DOKTER){
                                $peg = PegawaiM::model()->findByPk($data->pegawai_id);
                                
                                if (!empty($peg)){
                                    return $peg->namaLengkap;
                                }else{
                                    return '-';
                                }
                            }else{
                                return '-';
                            }
                        }
                    ),   
                    array(
                        'header'=>'Jenis Obat',
                        'name'=>'jenisobatalkes_nama',
                        'value'=>'$data->jenisobatalkes_nama',
                    ),    
                    array(
                        'header'=>'Nama Obat',
                        'name'=>'obatalkes_nama',
                        'value'=>'$data->obatalkes_nama',
                    ),    
                    array(
                        'header'=>'Qty',
                        'name'=>'qty_oa',
                        'value'=>'number_format($data->qty_oa)',
                        'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                        'footer'=>'sum(qty_oa)'
                    ),
                    array(
                        'header'=>'Signa',
                        'name'=>'signa_oa',
                        'value'=>'$data->signa_oa',
                    ),
                    array(
                        'header'=>'Etiket',
                        'name'=>'etiket',
                        'value'=>'$data->etiket',
                    ),                    
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 
?>