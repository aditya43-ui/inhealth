<?php     
    $table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
    $data = $model->searchSetoranKeBankBaru();
    $template = "{summary}\n{items}\n{pager}";
    $sort = true;
    if (isset($caraPrint)){
      $sort = false;
      $data = $model->searchPrintSetoranKeBankBaru(); 
      $rim = '';
      $template = "{items}";
      if ($caraPrint == "EXCEL"){
          $table = 'ext.bootstrap.widgets.BootExcelGridView';
	  }
    }
?>      
    <?php 
        $this->widget($table,array(
            'id'=>'laporansetorankebank-grid',
            'dataProvider'=>$data,
            'enableSorting'=>$sort,
            'template'=>$template,
            'itemsCssClass'=>'table table-bordered table-striped table-condensed',            
            'columns'=>array(
				array(
					'header' => 'No.',
					'value' => '($this->grid->dataProvider->pagination) ? 
						($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
						: ($row+1)'
				),
				array(
					'header' => 'Tanggal Setor',
					'type' => 'raw',
					'value' => 'MyFormatter::formatDateTimeForUser($data->tgldisetor)'
				),
				array(
					'header' => 'No. Bukti Setor',
					'type' => 'raw',
					'value'=>'$data->nostruksetor'
				),
				array(
					'header' => 'No. BKK',
					'type' => 'raw',
					'value'=>function($data){
						$bukti = TandabuktikeluarT::model()->findByAttributes(array('setorbank_id' => $data->setorbank_id));
						
						if (!empty($bukti)){
							return $bukti->nokaskeluar;
						}
					}
				),
				array(
					'header' => 'Shift',
					'type' => 'raw',
					'value' => function($data){
							$bukti = LaporansetorankebankV::model()->findAllByAttributes(array('nostruksetor' => $data->nostruksetor));
							
							echo "<ul>";
							foreach ($bukti as $shift){
								echo "<li>".$shift->shift_nama."</li>";
							}
							echo "</ul>";
					}
				),
				array(
					'header' => 'Petugas Kasir',
					'type' => 'raw',
					'value' => '$data->nama_pegawai',
					'footer' => '<b>Total</b>',
					'footerHtmlOptions'=>array('style' => 'text-align:right;', 'colspan'=>6)
				),
				array(
					'header' => 'Jumlah Setor',
					'type' => 'raw',
					'name'=>'jumlahsetoran',
					'value' => 'number_format($data->jumlahsetoran,0,"",".")',
					'htmlOptions' => array('style' => 'text-align: right;'),
					'footer' => 'sum(jumlahsetoran)',
					'footerHtmlOptions'=>array('style' => 'text-align:right;')
				),
			),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); 
        ?>   