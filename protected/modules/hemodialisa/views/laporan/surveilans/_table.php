<?php 
    $table = 'ext.groupgridview.GroupGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.groupgridview.GroupGridView';
    } else{
        $data = $model->searchTable();
         $template = "{summary}\n{items}\n{pager}";
    }
?>
<?php $format = new MyFormatter(); ?>

<?php $this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
        'template'=>$template,
        'enableSorting'=>$sort,
        'itemsCssClass'=>'table table-striped table-condensed',  
	 'extraRowColumns' => array('pasien_id'),
     'extraRowTotals' => function($data, $row, &$totals) {
          if(!isset($totals['count'])) $totals['count'] = 0;
          $totals['count']++;
          
          if(!isset($totals['ett'])) $totals['ett'] = 0;
          $totals['ett'] += $data['ett']; 
		  
		  if(!isset($totals['count'])) $totals['count'] = 0;
          $totals['count']++;
          
          if(!isset($totals['ivl'])) $totals['ivl'] = 0;
          $totals['ivl'] += $data['ivl']; 
		  
		  if(!isset($totals['count'])) $totals['count'] = 0;
          $totals['count']++;
          
          if(!isset($totals['cvl'])) $totals['cvl'] = 0;
          $totals['cvl'] += $data['cvl']; 
		  
		  if(!isset($totals['count'])) $totals['count'] = 0;
          $totals['count']++;
          
          if(!isset($totals['uc'])) $totals['uc'] = 0;
          $totals['uc'] += $data['uc']; 
		  
		   if(!isset($totals['count'])) $totals['count'] = 0;
          $totals['count']++;
          
          if(!isset($totals['vap'])) $totals['vap'] = 0;
          $totals['vap'] += $data['vap']; 
		  
		   if(!isset($totals['count'])) $totals['count'] = 0;
          $totals['count']++;
          
          if(!isset($totals['iad'])) $totals['iad'] = 0;
          $totals['iad'] += $data['iad']; 
		  
		   if(!isset($totals['count'])) $totals['count'] = 0;
          $totals['count']++;
          
          if(!isset($totals['pleb'])) $totals['pleb'] = 0;
          $totals['pleb'] += $data['pleb']; 
		  
		    if(!isset($totals['count'])) $totals['count'] = 0;
          $totals['count']++;
          
          if(!isset($totals['isk'])) $totals['isk'] = 0;
          $totals['isk'] += $data['isk'];
      },
  
    'extraRowExpression' => '"<strong>Total ETT : ".number_format($totals["ett"])."</strong> 
		   &nbsp;&nbsp;&nbsp; 
		   <strong>Total IVL :
             ".number_format($totals["ivl"])."</strong> 
			&nbsp;&nbsp;&nbsp;
            <strong>Total CVC :
             ".number_format($totals["cvl"])."</strong>
			&nbsp;&nbsp;&nbsp; 
            <strong>Total UC :
             ".number_format($totals["uc"])."</strong> 
			&nbsp;&nbsp;&nbsp; 
            <strong>Total VAP :
             ".number_format($totals["vap"])."</strong>
            &nbsp;&nbsp;&nbsp; 
            <strong>Total IAD :
             ".number_format($totals["iad"])."</strong> 
            &nbsp;&nbsp;&nbsp; 
            <strong>Total PLEB :
             ".number_format($totals["pleb"])."</strong> 
			&nbsp;&nbsp;&nbsp; 
            <strong>Total ISK :
             ".number_format($totals["isk"])."</strong>
            " 
             ',
    'extraRowPos'=>'below',
//	     'mergeHeaders'=>array(
//            array(
//                'name'=>'<center>Hari Pemasangan</center>',
//                'start'=>5, //indeks kolom 3
//                'end'=>8, //indeks kolom 4
//            ),
//            array(
//                'name'=>'<center>Infeksi</center>',
//                'start'=>9, //indeks kolom 3
//                'end'=>12, //indeks kolom 4
//            ), 
//             array(
//                'name'=>'<center>Hasil Kultur</center>',
//                'start'=>14, //indeks kolom 3
//                'end'=>17, //indeks kolom 4
//            ),
//        ),
	'columns'=>array( 
             array(
                'header' => 'No',
                'value' => '$row+1'
            ),  
            array(
                'header' => 'Nama Pasien',
                'value' => '$data->nama_pasien',
            ),
            array(
                'header' => 'TGL',
                'value' => 'MyFormatter::formatDateTimeForUser($data->surveilans_tgl)'
            ),  
            array(
                'header' => 'Ruangan',
                'value' => '$data->ruangan_nama'
            ), 
            array(
                'header' => 'Instalasi',
                'value' => '$data->instalasi_nama'
            ), 
            array(
                'header' => 'ETT', 
				'name'=>'ett',
                'value' => '($data->ett == true) ? 1 : 0'
            ),
            array(
                'header' => 'IVL',
                'value' => '($data->ivl == true) ? 1 : 0'
            ),
            array(
                'header' => 'CVC',
                'value' => '($data->cvl == true) ? 1 : 0'
            ),
            array(
                'header' => 'UC',
                'value' => '($data->uc == true) ? 1 : 0'
            ),  
           array(
                'header' => 'CDL',
                'value' => '($data->cdl == true) ? 1 : 0'
            ), 
           array(
                'header' => 'VAP',
                'value' => '($data->vap == true) ? 1 : 0'
            ),
            array(
                'header' => 'IAD',
                'value' => '($data->iad == true) ? 1 : 0'
            ),
            array(
                'header' => 'PLEB',
                'value' => '($data->pleb == true) ? 1 : 0'
            ),
            array(
                'header' => 'ISK',
                'value' => '($data->isk == true) ? 1 : 0'
            ), 
           array(
                'header' => 'DEKU',
                'value' => '($data->deku == "Ya") ? 1 : 0'
            ), 
            array(
                'header' => 'Sputum',
                'value' => '$data->sputum'
            ),
            array(
                'header' => 'Darah',
                'value' => '$data->darah'
            ), 
            array(
                'header' => 'Urine',
                'value' => '$data->urine'
            ), 
            array(
                'header' => 'Antibiotik',
                'value' => '$data->antibiotik'
            ),
            
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>