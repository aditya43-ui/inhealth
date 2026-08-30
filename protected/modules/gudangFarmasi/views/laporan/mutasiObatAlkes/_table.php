<?php 
/**
 * menampilkan daftar data
 * 
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            .com
 * 
 */
    $itemsCssClass ='table table-bordered table-striped table-condensed';
    $table = 'ext.bootstrap.widgets.BootGroupGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchLaporanPrint();
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
        
     
        $itemsCssClass='table border';
    } else{
        $data = $model->searchLaporan();
         $template = "{summary}\n{items}\n{pager}";
    }
    
    $this->widget($table,array( 
    'id'=>'laporan-grid',
    'dataProvider'=>$data, 
    'template'=>$template, 
    'itemsCssClass'=>$itemsCssClass,
    'mergeColumns'=>array('ruangantujuan_nama','nomutasioa'),
    'extraRowColumns'=> array('ruangantujuan_nama'),
    'columns'=>array( 
        ////'mutasioaruangan_id',
//        array(
//            'name'=>'no',
//            'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
//            'header'=>'No.',
//            'filter'=>false,
//        ),
        //'pesanobatalkes.nopemesanan',
        array(
            'header'=>'<p style="margin: 0; text-align: center;">Ruangan Tujuan</p>',
            'name'=>'ruangantujuan_nama',
            'type'=>'raw',
            'htmlOptions'=>array('style'=>'text-align:left;'),
            'value'=>'$data->ruangantujuan_nama',
        ),
       
         array(
            'header'=>'<p style="margin: 0; text-align: center;">No. Mutasi</p>',
         
            'type'=>'raw',
            'value'=>'$data->nomutasioa',
        ),
        array(
            'header'=>'<p style="margin: 0; text-align: center;">Tanggal Mutasi</p>',
           
            'type'=>'raw',
            'value'=>'date("d/m/Y H:i:s", strtotime($data->tglmutasioa))',
        ),
        array(
            'header'=>'<p style="margin: 0; text-align: center;">Obat Alkes</p>',
            'name'=>'obatalkes',
            'type'=>'raw',
            'value'=>'$data->obatalkes_nama',
        ),
        array(
            'header'=>'HPP/ Satuan (Rp)',
            'type'=>'raw',
            'value'=>(Params::cekHiddenHargaGudangFarmasi()==true)?'number_format($data->harganettosatuan,0,",",".")':'"Hidden"',
        ),
        array(
            'header'=>'Harga Jual/ Satuan (Rp)',
            'type'=>'raw',
            'value'=>(Params::cekHiddenHargaGudangFarmasi()==true)?'number_format($data->hargajualsatuan,0,",",".")':'"Hidden"',
        ),
        array(
            'header'=>'Jumlah',
            'type'=>'raw',
            'value'=>'$data->jummutasi',
        ),
        array(
            'header'=>'Total (Rp)',
            'type'=>'raw',
            'value'=>'number_format($data->totalharga,0,",",".")',
        ),
//        array(
//            'header'=>'Total HPP (Rp)',
//            'type'=>'raw',
//            'value'=>'number_format($data->totalharganettomutasi)',
//        ),
//         array(
//          'header'=>'Total Harga Jual (Rp)',
//          'type'=>'raw',
//          'value'=>'number_format($data->totalhargajual)', 
//        ),
//        'totalhargajual',
        //'nomutasioa',
        /*
        'ruangantujuan_id',
        'keteranganmutasi',
        'totalharganettomutasi',
        'totalhargajual',
        'create_time',
        'update_time',
        'create_loginpemakai_id',
        'update_loginpemakai_id',
        'create_ruangan',
        */
        array(
            'header' => 'Status Terima',
            'type' => 'raw',
            'value'=>'(empty($data->terimamutasi_id))? "Belum Diterima" : "Telah Diterima"',
        ),
    ), 
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}', 
));
