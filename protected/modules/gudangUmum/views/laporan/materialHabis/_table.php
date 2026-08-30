<?php 
    $itemCssClass='table table-bordered table-striped table-condensed';
    $table = 'ext.bootstrap.widgets.BootGroupGridView';
    $sort = true;
    $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
        $row = '$row+1';
        $data = $model->searchMaterialHabisPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
        }
        
         if ($caraPrint=='PDF') {
            $table = 'ext.bootstrap.widgets.BootGroupGridViewPDF';
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
        $data = $model->searchMaterialHabisTable();
         $template = "{summary}\n{items}\n{pager}";
    }
?>
<?php $this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
        'template'=>$template,
        'enableSorting'=>$sort,
        'itemsCssClass'=>$itemCssClass,
        'mergeColumns'=>array('ruangan_nama'),
        'extraRowColumns'=> array('ruangan_nama'),
	'columns'=>array(                
                array(
                    'header' => 'No.',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => $row,
                ),
                array(
                    'header' => 'Kode',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => '$data->barang_kode',
                ),
                array(
                    'header' => 'Nama',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => '$data->barang_nama',
                ),
                array(
                    'header' => 'Merk',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => '$data->barang_merk',
                ),
                array(
                    'header' => 'No. Seri',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => '$data->barang_noseri',
                ),
                array(
                    'header' => 'Tahun Beli',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => '$data->barang_thnbeli',
                ),
                array(
                    'header' => 'Harga (Rp)',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => 'number_format($data->barang_harga,0,"",".")',
                    'htmlOptions' => array('style'=>'text-align:right;')
                ),
                array(
                    'header' => 'Jumlah Barang',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => 'number_format($data->inventarisasi_stok,0,"",".")',
                    'htmlOptions' => array('style'=>'text-align:right; width:50px',)
                ),
                array(
                    'header' => 'Jumlah Barang yang Dipakai',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'type' => 'raw',
                    'value' => function($data) {
                        $cr = new CDbCriteria();
                        $cr->join = 'join pemakaianbarang_t a on a.pemakaianbarang_id = t.pemakaianbarang_id';
                        $cr->compare('t.barang_id', $data->barang_id);
                        $cr->compare('a.ruangan_id', $data->ruangan_id);
                        $pemakaian = PemakaianbrgdetailT::model()->findAll($cr);
                        $total = 0;
                        foreach ($pemakaian as $item) {
                            $total += $item->jmlpakai;
                        }
                        return $total;
                    },
                    'htmlOptions' => array('style'=>'text-align:right; width:50px',)
                ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>