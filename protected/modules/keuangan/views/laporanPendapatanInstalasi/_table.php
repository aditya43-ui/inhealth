<?php 
$table = 'ext.bootstrap.widgets.MergeHeaderGroupGridView';
$data = $model->searchTableInstalasi();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
if (isset($caraPrint)){
  $sort = false;
  $data = $model->searchTableInstalasiPrint();  
  $template = "{items}";
  if ($caraPrint == "EXCEL"){
    $table = 'ext.bootstrap.widgets.BootExcelGridView';
  
  }
  
}

$totalTagihan = 0;
$bayarTunai = 0;
$p3 = 0;
$piutangPasien = 0;
$totalJumlah = 0;

foreach($data->data as $item){
	$tanda = TandabuktibayarT::model()->findByPk($item->tandabuktibayar_id);
	
	if (!empty($tanda)){
		$totalTagihan += $item->totalbiayapelayanan + $tanda->biayaadministrasi + $tanda->biayamaterai - $item->totaldiscount;
	}else{
		$totalTagihan += $item->totalbiayapelayanan - $item->totaldiscount;
	}
        
    $bayarTunai += $this->renderPartial('_totalKas', array('pendaftaran_id'=>$item->pendaftaran_id, 'tglpembayaran'=>$item->tglpembayaran, 'footer'=>'footer'), true);
    
    $p3 += $this->renderPartial("_totalP3",array("pendaftaran_id"=>$item->pendaftaran_id ,"tglpembayaran"=>$item->tglpembayaran, 'footer'=>'footer'),true);
    
    $piutangPasien += $this->renderPartial("_totalPiutang",array("pendaftaran_id"=>$item->pendaftaran_id ,"tglpembayaran"=>$item->tglpembayaran, 'footer'=>'footer'),true);
    
    $totalJumlah += $this->renderPartial("_totalJumlah",array("pendaftaran_id"=>$item->pendaftaran_id ,"tglpembayaran"=>$item->tglpembayaran, 'footer'=>'footer'),true);	
}
?>
<?php $this->widget($table,array(
    'id'=>'tableLaporan',
    'dataProvider'=>$model->searchTableInstalasi(),
    'enableSorting'=>$sort,
    'template'=>$template,
        'itemsCssClass'=>'table table-bordered datatable',
    'mergeHeaders'=>array(
            array(
                'name'=>'<p style="margin: 0; text-align: center;">Penerimaan</p>',
                'start'=>7, //indeks kolom 3
                'end'=>8, //indeks kolom 4
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
                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
            ),  
            array(
                'header'=>'Tgl. Pembayaran/<br>No Pembayaran',
                'type'=>'raw',
                'value'=>'MyFormatter::formatDateTimeForUser(date("d/m/Y", strtotime($data->tglpembayaran)))." ".$data->nopembayaran',
                'headerHtmlOptions'=>array('style'=>'vertical-align:top;text-align:left;'),
            ),
            array(
                'header'=>'No. Rekam Medik',
                'type'=>'raw',
                'value'=>'$data->no_rekam_medik',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
            ),
            array(
                'header'=>'Nama Pasien',
                'type'=>'raw',
                'value'=>'$data->nama_pasien',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'footer'=>'<b>TOTAL</b>',                
                'footerHtmlOptions'=>array('colspan'=>6, 'style'=>'text-align:right;'),
            ),
			array(
				'header' => 'Jenis Penjamin/<br> Penjamin',
				'type' => 'raw',
				'value' => '$data->carabayar_nama."/<br> ".$data->penjamin_nama'
			),
			array(
				'header' => 'Instalasi',
				'type' => 'raw',
				'value'=>function($data){
                    $ins = RuanganM::model()->find("ruangan_id = '".$data->ruanganpelakhir_id."' ");
                    echo $ins->instalasi->instalasi_nama;
                },
			),
             array(
				'header'=>'<p style="margin: 0; text-align: center;">Total Tagihan</p>',
				'type'=>'raw',
				'name'=>'totaltagihanseluruh',
				'value'=>function($data) {
					return MyFormatter::formatNumberForPrint($data->totaltagihanseluruh);
					//$tanda = TandabuktibayarT::model()->findByPk($data->tandabuktibayar_id);
					//var_dump(count((array)$tanda));
					if (!empty($tanda)>0){
					//	return MyFormatter::formatNumberForPrint($data->totalbiayapelayanan+$tanda->biayaadministrasi + $tanda->biayamaterai - $data->totaldiscount);
					}else{
					//	return MyFormatter::formatNumberForPrint($data->totalbiayapelayanan);
					}
				},
				'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
				'htmlOptions'=>array('style'=>'vertical-align:middle;text-align:right;'),
				'footer'=>'sum(totaltagihanseluruh)',
				'footerHtmlOptions'=>array('style'=>'text-align: right; font-weight: bold;'),
			),
            array(
                'header'=>'<p style="margin: 0; text-align: center;">Bayar Tunai</p>',
                'type'=>'raw',
				'name'=>'totaliurbiaya',
                //'value'=>'$this->grid->owner->renderPartial("_totalKas",array("pendaftaran_id"=>$data->pendaftaran_id,"tglpembayaran"=>$data->tglpembayaran),true)',
				'value'=>'MyFormatter::formatNumberForPrint($data->totaliurbiaya)',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
               // 'footer'=> number_format($bayarTunai,0,"","."),      
				'footer'=>'sum(totaliurbiaya)',
                'footerHtmlOptions'=>array('style'=>'text-align:right; font-weight: bold;'),
            ),
            array(
                'header'=>'<p style="margin: 0; text-align: center;">Bank</p>',
                'type'=>'raw',
                'value'=>'$this->grid->owner->renderPartial("_totalBank",array("pendaftaran_id"=>$data->pendaftaran_id,"tglpembayaran"=>$data->tglpembayaran),true)',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>'0',      
                'footerHtmlOptions'=>array('style'=>'text-align:right; font-weight: bold;'),
            ),
         /*   array(
                'header'=>'<p style="margin: 0; text-align: center;">Giro</p>',
                'type'=>'raw',
                'value'=>'$this->grid->owner->renderPartial("_totalGiro",array("pendaftaran_id"=>$data->pendaftaran_id,"tglpembayaran"=>$data->tglpembayaran),true)',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>'0',      
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
            ),*/
            array(
                'header'=>'<p style="margin: 0; text-align: center;">Penjamin</p>',
                'type'=>'raw',
				'name'=>'totalpenjamin',
               // 'value'=>'$this->grid->owner->renderPartial("_totalP3",array("pendaftaran_id"=>$data->pendaftaran_id,"tglpembayaran"=>$data->tglpembayaran),true)',
				'value'=>'MyFormatter::formatNumberForPrint($data->totalpenjamin)',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                //'footer' => number_format($p3,0,"","."),    
				'footer'=>'sum(totalpenjamin)',
                'footerHtmlOptions'=>array('style'=>'text-align:right; font-weight: bold;'),
            ),
            array(
                'header'=>'<p style="margin: 0; text-align: center;">Pasien</p>',
                'type'=>'raw',
                'value'=>'$this->grid->owner->renderPartial("_totalPiutang",array("pendaftaran_id"=>$data->pendaftaran_id,"tglpembayaran"=>$data->tglpembayaran),true)',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=> number_format($piutangPasien,0,"","."),    //$piutangPasien      
                'footerHtmlOptions'=>array('style'=>'text-align:right; font-weight: bold;'),
            ),
            /*array(
                'header'=>'<p style="margin: 0; text-align: center;">Jumlah</p>',
                'type'=>'raw',
                'value'=>'$this->grid->owner->renderPartial("_totalJumlah",array("pendaftaran_id"=>$data->pendaftaran_id,"tglpembayaran"=>$data->tglpembayaran),true)',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>  number_format($totalJumlah,0,"","."),         
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
            ),*/
            /*array(
                'header'=>'<p style="margin: 0; text-align: center;">User <br> Name</p>',
                'type'=>'raw',
                'value'=>'($data->nama_pemakai != null) ? "$data->nama_pemakai":"-"',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:center;'),
            ),*/
            /*array(
                'header'=>'<p style="margin: 0; text-align: center;"> Instalasi <br> / Ruangan   </p>',
                'type'=>'raw',
                'value'=>function($data){
                    $ins = RuanganM::model()->find("ruangan_id = '".$data->ruanganpelakhir_id."' ");
                    echo $ins->instalasi->instalasi_nama.' <br> / '.$data->ruanganakhir_nama;
                },
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                'htmlOptions'=>array('style'=>'text-align:center;'),
                'footer' => ' '
            ),*/
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>
