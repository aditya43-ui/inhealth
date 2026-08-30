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
    $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
    $sort = true;
    $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
        $row = '$row+1';
        $data = $model->searchLaporanFormulirPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
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
        $rincian = array(
            'header' => '',
            'value' => '""',
            'visible' => false
        );
    } else{
        $data = $model->searchLaporanFormulir();
         $template = "{summary}\n{items}\n{pager}";
        $rincian = array(
                    'header' => 'Rincian',
                    'type' => 'raw',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value'=>'CHtml::Link("<i class=\"icon-form-formulir\"></i>","'.$this->createUrl("formulirStockOpnameObatAlkes/Print").'&formuliropname_id=$data->formuliropname_id&frame=true",
                        array("class"=>"", 
                              "target"=>"formulir",
                              "onclick"=>"$(\"#dialogFormulir\").dialog(\"open\");",
                              "rel"=>"tooltip",
                              "title"=>"Klik untuk melihat details formulir",
                        ))',
                );
    }
?>
<?php $this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
        'template'=>$template,
        'enableSorting'=>$sort,
        'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
                array(
                    'header'=>'No.',
                    'value' => '$row+1',
                    'headerHtmlOptions'=>array('style'=>'text-align: left;vertical-align:middle;'),
                ),
                array(
                    'header' => 'Tanggal Formulir',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tglformulir)',
                ),
                array(
                    'header' => 'No. Formulir',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => '$data->noformulir'
                ),
                array(
                    'header' => 'Status Stok Opname',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => '(!empty($data->stokopname_id)?"Sudah Stok Opname":"Belum Stok Opname")'
                ),
                array(
                    'header' => 'Tanggal Stok Opname',
                    'headerHtmlOptions'=>array('style'=>'text-align: center;vertical-align:middle;'),
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tglstokopname)'
                ),
                $rincian
                
                
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