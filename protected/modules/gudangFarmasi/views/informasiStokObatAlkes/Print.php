<?php

if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
}
?>
<?php
if ($caraPrint != 'GRAFIK' && $caraPrint != 'PDF'){
    
    
?>

 <table style="width: 100%; border: none;">
    <thead>
        <tr>
             <td>
                <div class="header"><?php
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNewest', array());
                    ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
                        <br>
			<div class="judulcontent"> <?php echo $judulLaporan   ?> </div>
                        <br>
                <?php  
$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
$sort = true;
if (isset($caraPrint)) {
    $row = '$row+1';
    $data = $model->searchDataObatInformasiPrint();
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL") {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else if ($caraPrint == "PDF") {
        $table = 'ext.bootstrap.widgets.BootGridViewPDF';
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
    
} else {
    $data = $model->searchDataObatInformasiPrint();
    $template = "{items}";
}

$this->widget($table, array(
    'id' => 'informasistokbarang-grid',
    'dataProvider' => $data,
    //	'filter'=>$model,
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'mergeHeaders'=>array(
                                    array(
                                        'name'=>'<p style="margin: 0; text-align: center;">Kondisi Obat Alkes</p>',
                                        'start'=>7, 
                                        'end'=>8, 
                                    ),
                                ),
                                'columns'=>array( 
                                    array(
                                        'header' => 'Instalasi',
                                        'type'=>'raw',
                                        'value' => '$data->instalasi_nama'
                                    ),
                                     array(
                                        'header' => 'Ruangan',
                                        'type'=>'raw',
                                        'value' => '$data->ruangan_nama'
                                    ),
                                     array(
                                        'header' => 'Jenis Obat Alkes',
                                        'type'=>'raw',
                                        'value' => '$data->jenisobatalkes_nama'
                                    ),
                                     array(
                                        'header' => 'Kode Obat Alkes',
                                        'type'=>'raw',
                                        'value' => '$data->obatalkes_kode'
                                    ),
                                     array(
                                        'header' => 'Nama Obat Alkes',
                                        'type'=>'raw',
                                        'value' => '$data->obatalkes_nama'
                                    ),
                                    array(
                                        'header' => 'Stok Minimal',
                                        'type'=>'raw',
//                                        'value' => '$data->minimalstok'
                                         'value'=>function($data) {   
                                            $modKonfigF = KonfigfarmasiK::model()->find();
                                            
                                            $minimalstok = 0;
                                            if($modKonfigF->isstokminimalfarmasi){
                                                $minimalstok = $data->minimalstok;
                                            }else{
                                                $modStokMinimal = StokminimalT::model()->findByAttributes(array('ruangan_id'=>$data->ruangan_id,'obatalkes_id'=>$data->obatalkes_id));
                                                if(isset($modStokMinimal)){
                                                    $minimalstok = $modStokMinimal->jmlminimalstok;
                                                }
                                            }
                                            
                                            return MyFormatter::formatNumberForPrint($minimalstok,2);
                                         }
                                    ),
                                     array(
                                        'header' => 'Tanggal Kedaluwarsa',
                                        'type'=>'raw',
                                        'value' => 'MyFormatter::formatDateTimeForUser($data->tglkadaluarsa)'
                                    ),
                                     array(
                                        'header' => 'Baik',
                                        'type'=>'raw',
                                        'value' => 'MyFormatter::formatNumberForPrint($data->qtystokoa_baik,2) ." ".$data->satuankecil_nama'
                                    ),
                                     array(
                                        'header' => 'Rusak',
                                        'type'=>'raw',
                                        'value' => 'MyFormatter::formatNumberForPrint($data->qtystokoa_rusak,2) ." ".$data->satuankecil_nama'
                                    ),
                                     array(
                                        'header' => 'Jumlah Obat Alkes',
                                        'type'=>'raw',
                                        'value' => 'MyFormatter::formatNumberForPrint($data->qtystokoa,2) ." ".$data->satuankecil_nama'
                                    ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
)); ?>
		</div>		
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>
                <div class="footer-space">&nbsp;</div>
            </td>
        </tr>
    </tfoot>
</table>
<div class="">
</div>
<div class="footer">
    <table>
        <tr>
            <td>Dicetak Pada : <?php echo date('d-M-Y H:i:s'); ?></td>
        </tr>
        <tr>
            <td>Oleh : <?php 
                $logPg = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id')); 
                $pegLog = (isset($logPg)?$logPg->namaLengkap:"");
            echo $pegLog; ?></td>
        </tr>
    </table>
    <br>
    <?php   if (isset($caraPrint) && $caraPrint!="PDF"){  ?>
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
    <?php  }  ?>
</div>   

<?php
}
if ($caraPrint == 'PDF'){
?>
<div class="header">
<?php echo $this->renderPartial('application.views.headerReport.headerDefaultNewest'); ?>
</div>
<div class="content">
     <br>
    <div class="judulcontent"> <?php echo $judulLaporan   ?> </div>
     <br>
<?php 
$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
$sort = true;
//$row = '$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1';
if (isset($caraPrint)) {
    $row = '$row+1';
    $data = $model->searchDataObatInformasiPrint();
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL") {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else if ($caraPrint == "PDF") {
        $table = 'ext.bootstrap.widgets.BootGridViewPDF';
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
} else {
    $data = $model->searchDataObatInformasiPrint();
    $template = "{items}";
}

$this->widget($table, array(
    'id' => 'informasistokbarang-grid',
    'dataProvider' => $data,
    'itemsCssClass' => 'table border',
    'mergeHeaders' => array(
        array(
                        'name'=>'<p style="margin: 0; text-align: center;">Kondisi Barang</p>',
                        'start'=>8, 
                        'end'=>10, 
                    ),
    ),
    'template' => $template,
    'itemsCssClass' => 'table table-bordered table-striped datatable',
    'mergeHeaders'=>array(
                                    array(
                                        'name'=>'<p style="margin: 0; text-align: center;">Kondisi Obat Alkes</p>',
                                        'start'=>7, 
                                        'end'=>8, 
                                    ),
                                ),
                                'columns'=>array( 
                                    array(
                                        'header' => 'Instalasi',
                                        'type'=>'raw',
                                        'value' => '$data->instalasi_nama'
                                    ),
                                     array(
                                        'header' => 'Ruangan',
                                        'type'=>'raw',
                                        'value' => '$data->ruangan_nama'
                                    ),
                                     array(
                                        'header' => 'Jenis Obat Alkes',
                                        'type'=>'raw',
                                        'value' => '$data->jenisobatalkes_nama'
                                    ),
                                     array(
                                        'header' => 'Kode Obat Alkes',
                                        'type'=>'raw',
                                        'value' => '$data->obatalkes_kode'
                                    ),
                                     array(
                                        'header' => 'Nama Obat Alkes',
                                        'type'=>'raw',
                                        'value' => '$data->obatalkes_nama'
                                    ),
                                     array(
                                        'header' => 'Stok Minimal',
                                        'type'=>'raw',
//                                        'value' => '$data->minimalstok'
                                         'value'=>function($data) {   
                                            $modKonfigF = KonfigfarmasiK::model()->find();
                                            
                                            $minimalstok = 0;
                                            if($modKonfigF->isstokminimalfarmasi){
                                                $minimalstok = $data->minimalstok;
                                            }else{
                                                $modStokMinimal = StokminimalT::model()->findByAttributes(array('ruangan_id'=>$data->ruangan_id,'obatalkes_id'=>$data->obatalkes_id));
                                                if(isset($modStokMinimal)){
                                                    $minimalstok = $modStokMinimal->jmlminimalstok;
                                                }
                                            }
                                            
                                            return $minimalstok;
                                         }
                                    ),
                                     array(
                                        'header' => 'Tanggal Kedaluwarsa',
                                        'type'=>'raw',
                                        'value' => 'MyFormatter::formatDateTimeForUser($data->tglkadaluarsa)'
                                    ),
                                     array(
                                        'header' => 'Baik',
                                        'type'=>'raw',
                                        'value' => '$data->qtystokoa_baik ." ".$data->satuankecil_nama'
                                    ),
                                     array(
                                        'header' => 'Rusak',
                                        'type'=>'raw',
                                        'value' => '$data->qtystokoa_rusak ." ".$data->satuankecil_nama'
                                    ),
                                     array(
                                        'header' => 'Jumlah Obat Alkes',
                                        'type'=>'raw',
                                        'value' => '$data->qtystokoa ." ".$data->satuankecil_nama'
                                    ),
                                ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
)); ?>
</div>
<div class="">
</div>
<div class="footer">
    <table>
        <tr>
            <td>Dicetak Pada : <?php echo date('d-M-Y H:i:s'); ?></td>
        </tr>
        <tr>
            <td>Oleh : <?php 
                $logPg = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id')); 
                $pegLog = (isset($logPg)?$logPg->namaLengkap:"");
            echo $pegLog; ?></td>
        </tr>
    </table>
</div> 
<?php
}

 ?>