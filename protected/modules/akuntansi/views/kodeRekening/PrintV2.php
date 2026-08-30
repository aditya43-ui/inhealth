
<?php 

if (!empty($caraPrint) && $caraPrint != 'CSV') {

    if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');     
    }
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>5));      

}

$table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
	$itemCssClass='table table-bordered table-striped table-condensed';
    if (isset($caraPrint) && $caraPrint != 'CSV'){
		Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
		}
		if ($caraPrint=='PDF') {
            $table = 'ext.bootstrap.widgets.BootGridView';
        }
		$itemCssClass='table border';
    } else{
        $data = $model->search();
         $template = "{summary}\n{items}\n{pager}";
    }
  ?>  


<?php

$prov = $model->searchKodeRekening();
$prov->pagination = false;

            $this->widget($table,
                array(
                    'id'=>'AKRekeningakuntansi-v',
                    'dataProvider'=>$prov,
					'overflowx' => true,
                    'enablePagination'=>false,
                    'template'=>"{items}",
                    'itemsCssClass'=>'table table-bordered datatable',
                    'columns'=>array(
                        array(
                           'header'=>'Kode Akun',
                           'name'=>'kode',
                           'type'=>'raw',
                           'htmlOptions'=>array('style'=>'width:80px'),
                        ), 
                        array(
                           'header'=>'Nama Akun',
                           'name'=>'nama',
                           'type'=>'raw',
                           'value'=>function($data) use ($caraPrint) {
                                $nama = $data['nama'];
                                $pad = 0;
                                $res = "";
                                switch ($data['levelrek']) {
                                    case 1: 
                                        $res = "[1] - ".$data['nama'];
                                        break;
                                    case 2: 
                                        $res = ($caraPrint == "CSV" ? "" :"&emsp;")."[2] - ".$data['nama'];
                                        break;
                                    case 3: 
                                        $res = ($caraPrint == "CSV" ? "" :"&emsp;&emsp;")."[3] - ".$data['nama'];
                                        break;
                                    case 4: 
                                        $res = ($caraPrint == "CSV" ? "" :"&emsp;&emsp;&emsp;")."[4] - ".$data['nama'];
                                        break;
                                    case 5:
                                        $res = ($caraPrint == "CSV" ? "" :"&emsp;&emsp;&emsp;&emsp;")."[5] - ".$data['nama'];
                                        break;
                                    case 6:
                                        $res = ($caraPrint == "CSV" ? "" :"&emsp;&emsp;&emsp;&emsp;&emsp;")."[6] - ".$data['nama'];
                                        break;
                                    case 7:
                                        $res = ($caraPrint == "CSV" ? "" :"&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;")."[7] - ".$data['nama'];
                                        break;
                                    case 8:
                                        $res = ($caraPrint == "CSV" ? "" :"&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;")."[8] - ".$data['nama'];
                                        break;
                                    case 9:
                                        $res = ($caraPrint == "CSV" ? "" :"&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;")."[9] - ".$data['nama'];
                                        break;
                                    case 10:
                                        $res = ($caraPrint == "CSV" ? "" :"&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;")."[10] - ".$data['nama'];
                                        break;

                                }
                                return $res;
                           },//'isset($data->nmrekening5) ? CHtml::Link($data->nmrekening5, Yii::app()->controller->createUrl("KodeRekening/editRincianObyekRek",array("id"=>$data->rekening5_id)),array("style"=>"color:blue","target"=>"frameEditRincianObyekRek", "onclick"=>"$(\"#dialogEditRincianObyekRek\").dialog(\"open\");","rel"=>"tooltip", "title"=>"Klik untuk Edit<br>Rincian Obyek Rekening",)) : "-"',
                        ),
                        array(
                           'header'=>'Saldo Normal',
                           'name'=>'saldo_normal',
                           'type'=>'raw',
                           'value'=>'($data["saldo_normal"] == null ? "-" : ($data["saldo_normal"] == "D" ? "Debit" : "Kredit"))'
                        ),
                        array(
                               'header'=>'Tipe Rekening',
                               'name'=>'tiperekening_id',
                               'type'=>'raw',
                               'value'=>function($data) {
                                if (empty($data['tiperekening_id'])) {
                                    return "-";
                                }
                                
                                $rek = TiperekeningM::model()->findByPk($data['tiperekening_id']);
                                
                                if (empty($rek)) {
                                    return "-";
                                }
                                
                                return $rek->tiperekening;
                            }
                        ),
                        array(
                            'header' => 'Keterangan',
                           'name'=>'keterangan',
                           'type'=>'raw',
                            'value'=>'((empty($data["keterangan"]) || $data["keterangan"] == null) ? "-" : $data["keterangan"])',
                        ),
                    ),
                    //'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
                )
            );
                        
        ?>
<?php if (isset ($caraPrint) && $caraPrint != 'CSV' && $caraPrint!='PDF'){ ?>
<table>
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
</table>
<?php }?>