
<?php
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));

$table = 'ext.bootstrap.widgets.BootGridView';
$itemCssClass='table table-striped table-condensed';
    $sort = true;
    if (isset($caraPrint)){
		$rows = '$row+1';
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
		$rows = '$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1';
        $data = $model->searchPrint();
		// $template = "{summary}\n{items}\n{pager}";
    }
  ?>

<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'carabayarrek-m-grid',
    'dataProvider'=>$data,
    'template'=>$template,
    'itemsCssClass'=>$itemCssClass,
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
		array(
                            'header' => 'No.',
                            'value'=>'$row+1',
                        ),
                        array(
                            'header'=>'Rekening',
                            'type'=>'raw',
                            // 'name'=>'rekening5_id',
                            //'filter'=>CHtml::listData(CarabayarM::model()->findAll(),'carabayar_id','carabayar_nama'),
                            'value'=>'(isset($data->rekening5)? $data->rekening5->nmrekening5: "")',
                        ),
                        array(
                            'header'=>'Saldo Normal',
                            'type'=>'raw',
                            // 'name'=>'debitkredit',
                            //'filter'=>CHtml::listData(CarabayarM::model()->findAll(),'carabayar_id','carabayar_nama'),
                            'value'=>'$data->debitkredit',
                        ),
                        array(
                            'header'=>'Jenis Obat Alkes',
                            'type'=>'raw',
                            // 'name'=>'jenisobatalkes_id',
                            //'filter'=>CHtml::listData(CarabayarM::model()->findAll(),'carabayar_id','carabayar_nama'),
                            'value'=>'(isset($data->jenisobatalkes)? $data->jenisobatalkes->jenisobatalkes_nama: "")',
                        ),
                        array(
                            'header'=>'Ruangan',
                            'type'=>'raw',
                            // 'name'=>'ruangan_id',
                            //'filter'=>CHtml::listData(CarabayarM::model()->findAll(),'carabayar_id','carabayar_nama'),
                            'value'=>function($data){
                                $ruanganNama = RuanganM::model()->findByPk($data->ruangan_id);
                                return (isset($ruanganNama)?$ruanganNama->ruangan_nama : "");
                            },
                        ),
                        array(
                            'header'=>'Jenis Transaksi',
                            'type'=>'raw',
                            'value'=>function($data){
															if($data->ispenerimaanoa == TRUE){
																	return 'Penerimaan Faktur';
															}else if($data->isreturpembelian == TRUE){
                                    return 'Retur Penerimaan Faktur';
                              }else if($data->ispenjualanresep == TRUE){
                                    return 'Penjualan Resep';
                              }else if($data->isreturoa == TRUE){
                                    return 'Retur Penjualan Resep';
                              }else if($data->isstokberkurangoa == TRUE){
                                    return 'Pengurangan Stok Ruangan';
                              }else if($data->isstokopnameoaberkurang == TRUE){
                                    return 'Stok Opname Penyesuaian Berkurang';
                              }else if($data->isstokopnameoabertambah == TRUE){
                                    return 'Stok Opname Penyesuaian Bertambah';
                              }else if($data->ismutasioa == TRUE){
																	return 'Mutasi Ruangan';
															}else if($data->ispemakaianruangan == TRUE){
																	return 'Pemakaian Ruangan';
															}else if($data->ispemusnahan == TRUE){
																	return 'Pemusnahan';
															}else if($data->isbahanproduksi == TRUE){
																	return 'Bahan Produksi';
															}else if($data->ishasilproduksi == TRUE){
																	return 'Hasil Produksi';
															}else{
                                  return '-';
                              }
                            },
                        ),

    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>
