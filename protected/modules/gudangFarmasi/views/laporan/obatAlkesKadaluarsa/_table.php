<?php
/**
 * menampilkan daftar data
 * 
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            .com
 * 
 */
    $itemCssClass='table table-bordered table-striped table-condensed';
    $table = 'ext.bootstrap.widgets.BootGroupGridView';
    $sort = true;
    $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
        $row = '$row+1';
        $data = $model->searchObatAlkesKadaluarsaPrint();
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
                }

                .table tbody tr:hover td, .table tbody tr:hover th {
                    background-color: none;
                }
            </style>";
        $itemCssClass='table border';        
    } else{
        $data = $model->searchObatAlkesKadaluarsa();
         $template = "{summary}\n{items}\n{pager}";       
    }
?>
<?php $this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
        'template'=>$template,
        'enableSorting'=>$sort,
        'itemsCssClass'=>$itemCssClass,
        'mergeColumns'=>array('instalasi_nama','ruangan_nama'),
        'extraRowColumns'=> array('instalasi_nama','ruangan_nama'),
	'columns'=>array(
                array(
                    'header'=>'No.',
                    'value' => '$row+1',
                    'headerHtmlOptions'=>array('style'=>'text-align: left;vertical-align:middle;'),
                ),
                array(
                    'header' => 'Instalasi <br> / Ruangan',
                    'type' => 'raw',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => '$data->instalasi_nama." <br> / ".$data->ruangan_nama',
                ),               
                array(
                    'header' => 'Kode Obat',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => '$data->obatalkes_kode'
                ),
                array(
                    'header' => 'Nama Obat',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => '$data->obatalkes_nama'
                ),
                array(
                    'header' => 'Jumlah',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => function($data) use (&$stok) {
                                //$stok = StokobatalkesT::model()->findAllByAttributes(array(
                                  //  'obatalkes_id'=>$data->obatalkes_id,
                                    //'ruangan_id'=>Yii::app()->user->getState('ruangan_id'),
                                //));
                                $criteria = new CDbCriteria();
                                $criteria->addCondition('obatalkes_id ='.$data->obatalkes_id);
                                $criteria->addCondition("tglkadaluarsa = '".MyFormatter::formatDateTimeForDb($data->tglkadaluarsa)."' ");                                
                                $criteria->addCondition("ruangan_id = ".$data->ruangan_id);                                
                                $stok = StokobatalkesT::model()->findAll($criteria);
                                $total = 0;
                                foreach ($stok as $item) {
                                    $total += $item->qtystok_in - $item->qtystok_out;
                                }
                                $satuan = ($data->satuankecil_nama==null)?$data->satuankecil->satuankecil_nama:$data->satuankecil_nama;
                                return $total." ".$satuan;
                                
                            },
                    'htmlOptions' => array('style'=>'text-align:right;')
                ),
                array(
                    'header' => 'Harga Satuan',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => (Params::cekHiddenHargaGudangFarmasi()==true)?'number_format($data->harganetto,0,"",".")':'"Hidden"',
                    'htmlOptions' => array('style'=>(Params::cekHiddenHargaGudangFarmasi()==true)?'text-align:right;':'text-align:center;')
                ),                
               array(
                    'header' => 'Jumlah Harga',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => function ($data)  use (&$stok){
                            $total = 0;
                            foreach ($stok as $item) {
                                $total += $item->qtystok_in - $item->qtystok_out;
                            }
                            $satuan = ($data->satuankecil_nama==null)?$data->satuankecil->satuankecil_nama:$data->satuankecil_nama;
                            return number_format((abs($total) * $data->harganetto),0,"",".");
                    },
                    'htmlOptions' => array('style'=>'text-align:right;')
                ),                
                array(
                    'header' => 'Tanggal Kedaluwarsa',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tglkadaluarsa)',                    
                ),
                array(
                    'header' => 'Status',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => '($data->tglkadaluarsa <= date("Y-m-d H:i:s"))?"Sudah Kedaluwarsa":"Belum Kedaluwarsa"'
                ),
                
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>

<?php 
    // ===========================Dialog Details=========================================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id'=>'dialogFormulir',
            // additional javascript options for the dialog plugin
            'options'=>array(
            'title'=>'Details Formulir Opname',
            'autoOpen'=>false,
            'minWidth'=>900,
            'minHeight'=>100,
            'resizable'=>false,
             ),
        ));
    ?>
    <iframe src="" name="formulir" width="100%" height="500">
    </iframe>
    <?php    
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    //===============================Akhir Dialog Details================================
    ?>