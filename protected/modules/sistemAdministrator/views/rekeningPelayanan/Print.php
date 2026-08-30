
<?php
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
	$rows = '$row+1';
    $template = "{items}";
}else{
	$rows = '$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1';
}

if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');
    $table = 'ext.bootstrap.widgets.BootExcelGridView';
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>''));

$this->widget($table,array(
	'id'=>'jenispenerimaan-m-grid',
	'enableSorting'=>false,
	'dataProvider'=>$model->searchPrint(),
	'template'=>$template,
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		array(
			'header' => 'No.',
			'value'=>$rows,
		),
		array(
                            'header' => 'Ruangan',
                            'type'=>'raw',
                            'value' => '(!empty($data->ruangan_nama)?$data->ruangan_nama:" - ")',
                        ),
                        array(
                            'header' => 'Uraian Tindakan',
                            'type'=>'raw',
                            'value' => '(!empty($data->daftartindakan_nama)?$data->daftartindakan_nama:" - ")',
                        ),
                        array(
                            'header' => 'Komponen Tarif',
                            'type'=>'raw',
                            'value' => '(!empty($data->komponentarif_nama)? $data->komponentarif_nama : " - ")',
                        ),
                        array(
                            'header' => 'Kode Akun',
                            'type'=>'raw',
                            'value' => '(!empty($data->kdrekening5)?$data->kdrekening5:" - ")',
                        ),
                        array(
                            'header' => 'Nama Akun',
                            'type'=>'raw',
                            'value' => '(!empty($data->nmrekening5)?$data->nmrekening5:" - ")',
                        ),
                        array(
                                'header' => 'Saldo Normal',
                                'type' => 'raw',
                                'value' => function($data) {
                                        return $data->saldonormal == 'D' ? 'Debit' : 'Kredit';
                                },
                        ),
                        array(
                                'header'=>'Pelayanan',
                                'type'=>'raw',
                                'value'=>function($data) {
                                        return $data->ispelayanan?'<i class="icon-form-check"></i>':'-';
                                },
                                'htmlOptions'=>array(
                                        'style'=>'text-align: center'
                                )
                        ),
//                        array(
//                                'header'=>'Pembayaran',
//                                'type'=>'raw',
//                                'value'=>function($data) {
//                                        return $data->ispembayaran?'<i class="icon-form-check"></i>':'-';
//                                },
//                                'htmlOptions'=>array(
//                                        'style'=>'text-align: center'
//                                )
//                        ),
                        // array(
                        //         'header'=>'Retur',
                        //         'type'=>'raw',
                        //         'value'=>function($data) {
                        //                 return $data->isretur?'<i class="icon-form-check"></i>':'-';
                        //         },
                        //         'htmlOptions'=>array(
                        //                 'style'=>'text-align: center'
                        //         )
                        // ),
//                        array(
//                                'header'=>'Hutang',
//                                'type'=>'raw',
//                                'value'=>function($data) {
//                                        return $data->ishutang?'<i class="icon-form-check"></i>':"-";
//                                },
//                                'htmlOptions'=>array(
//                                        'style'=>'text-align: center'
//                                )
//                        ),
                        array(
                                'header'=>'Mapping tindakan Ruangan',
                                'type'=>'raw',
                                'value'=>function($data) {
                                        return (!empty($data->ruangan) ? '<i class="icon-form-check"></i>':"-");
                                },
                                'htmlOptions'=>array(
                                        'style'=>'text-align: center'
                                )
                        ),
                        array(
                                'header'=>'Mappingan Rekening Pelayanan',
                                'type'=>'raw',
                                'value'=>function($data) {
                                    return (!empty($data->pelayananrek_id) ? '<i class="icon-form-check"></i>':"-");
                                },
                                'htmlOptions'=>array(
                                        'style'=>'text-align: center'
                                )
                        ),
        ),
    ));
?>

<?php
    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK' || $caraPrint == 'EXCEL' ){?>
        <div id="footer" style = "width:100%;">
             <div style = "display:inline-block;float:left;text-align:left;">
                 <i><b>
                    Created At :
                    <?php
                        echo MyFormatter::formatDateTimeId(date('Y-m-d H:i:s'));
                    ?>
                </b></i>
             </div>
             <div style = "text-align:right;float:right;">
                 <i><b>
                    Created By :
                    <?php
                        echo $this->pageTitle=Yii::app()->user->nama_pemakai;
                    ?>
                </b></i>
             </div>
         </div>
<?php }?>
