<?php 
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$data = $model->searchTable();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
$itemCssClass='table table-striped table-bordered table-condensed';
if (isset($caraPrint)){
    $sort = false;
  $data = $model->searchPrint();  
  $template = "{items}";
  if ($caraPrint == "EXCEL"){
  $table = 'ext.bootstrap.widgets.BootExcelGridView';
  
  }
  
  echo CHtml::css('.control-label{
        float:left; 
        text-align: right; 
        width:50%;
        color:black;
        padding-right:10px;
        font-size:8pt;
    }
    body{
        font-size:8pt;
    }
    td .uang{
        text-align:right;
    }
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
    
    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: none;
    }
');  
  if ($caraPrint != 'PDF'){
  $itemCssClass='table border';
  
  }
}
?>
<?php $this->widget($table,array(
    'id'=>'tableLaporan',
    'dataProvider'=>$data,
    'enableSorting'=>$sort,
    'template'=>$template,
        'itemsCssClass'=>$itemCssClass,
    'mergeHeaders'=>array(
            array(
                'name'=>'<p style="margin: 0; text-align: center;">Penerimaan</p>',
                'start'=>5, //indeks kolom 3
                'end'=>7, //indeks kolom 4
            ),
            array(
                'name'=>'<p style="margin: 0; text-align: center;">Piutang</p>',
                'start'=>8, //indeks kolom 3
                'end'=>10, //indeks kolom 4
            ),
        ),
	'columns'=>array(
            array(
                    'header' => 'No.',
                    'value' => '$row+1',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
            ),  
            array(
                'header'=>'Tanggal Pelayanan',
                'type'=>'raw',
                'value'=>'MyFormatter::formatDateTimeForUser(date("d/m/Y", strtotime($data->tglpembayaran)))',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
            ),
            array(
                'header'=>'No. RM',
                'type'=>'raw',
                'value'=>'$data->no_rekam_medik',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
            ),
            array(
                'header'=>'Nama Pasien',
                'type'=>'raw',
                'value'=>'$data->nama_pasien',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
            ),
            array(
                'header'=>'Total Tagihan',
                'type'=>'raw',
                'value'=>'number_format($data->totalbiayapelayanan,0,"",".")',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
            ),
            array(
                'header'=>'<p style="margin: 0; text-align: center;">Bayar Tunai</p>',
                'type'=>'raw',
                'value'=>'$this->grid->owner->renderPartial("billingKasir.views.laporan/rekapPendapatan/_totalKas",array("pendaftaran_id"=>$data->pendaftaran_id,"tglpembayaran"=>$data->tglpembayaran),true)',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
            ),
            array(
                'header'=>'<p style="margin: 0; text-align: center;">Bank</p>',
                'type'=>'raw',
                'value'=>'$this->grid->owner->renderPartial("billingKasir.views.laporan/rekapPendapatan/_totalBank",array("pendaftaran_id"=>$data->pendaftaran_id,"tglpembayaran"=>$data->tglpembayaran),true)',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
               
            ),
            array(
                'header'=>'<p style="margin: 0; text-align: center;">Giro</p>',
                'type'=>'raw',
                'value'=>'$this->grid->owner->renderPartial("billingKasir.views.laporan/rekapPendapatan/_totalGiro",array("pendaftaran_id"=>$data->pendaftaran_id,"tglpembayaran"=>$data->tglpembayaran),true)',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
            ),
            array(
                'header'=>'<p style="margin: 0; text-align: center;">Piutang P3</p>',
                'type'=>'raw',
                'value'=>'$this->grid->owner->renderPartial("billingKasir.views.laporan/rekapPendapatan/_totalP3",array("pendaftaran_id"=>$data->pendaftaran_id,"tglpembayaran"=>$data->tglpembayaran),true)',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
            ),
            array(
                'header'=>'<p style="margin: 0; text-align: center;">Piutang Pasien</p>',
                'type'=>'raw',
                'value'=>'$this->grid->owner->renderPartial("billingKasir.views.laporan/rekapPendapatan/_totalPiutang",array("pendaftaran_id"=>$data->pendaftaran_id,"tglpembayaran"=>$data->tglpembayaran),true)',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
            ),
            array(
                'header'=>'<p style="margin: 0; text-align: center;">Jumlah</p>',
                'type'=>'raw',
                'value'=>'$this->grid->owner->renderPartial("billingKasir.views.laporan/rekapPendapatan/_totalJumlah",array("pendaftaran_id"=>$data->pendaftaran_id,"tglpembayaran"=>$data->tglpembayaran),true)',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
            ),
            array(
                'header'=>'<p style="margin: 0; text-align: center;">User <br> Name</p>',
                'type'=>'raw',
                'value'=>'($data->nama_pemakai != null) ? "$data->nama_pemakai":"-"',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:center;'),
            ),
            array(
                'header'=>'<p style="margin: 0; text-align: center;">Nama <br> Perusahaan <br> P3 </p>',
                'type'=>'raw',
                'value'=>'($data->penjamin_nama == "Umum" ) ? "-":"$data->penjamin_nama" ',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:center;'),
            ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>