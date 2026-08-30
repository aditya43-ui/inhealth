<?php 
    $table = 'ext.bootstrap.widgets.BootGroupGridViewEx';
    $sort = true;
    $itemCssClass='table table-striped table-condensed';
    if (isset($caraPrint)){
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
        $table = 'ext.bootstrap.widgets.BootGroupGridViewEx';}
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
        $data = $model->searchTable();
         $template = "{summary}\n{items}\n{pager}";
    }
?>
<?php $format = new MyFormatter(); 

$totals = array();
$data2 = $model->searchPrint();

foreach ($data2->data as $item) {
    if(!isset($totals['count'])) $totals['count'] = 0;
    $totals['count']++;

    if(!isset($totals['ett'])) $totals['ett'] = 0;
    $totals['ett'] += $item['ett']; 

    if(!isset($totals['count'])) $totals['count'] = 0;
    $totals['count']++;

    if(!isset($totals['ivl'])) $totals['ivl'] = 0;
    $totals['ivl'] += $item['ivl']; 

    if(!isset($totals['count'])) $totals['count'] = 0;
    $totals['count']++;

    if(!isset($totals['cvl'])) $totals['cvl'] = 0;
    $totals['cvl'] += $item['cvl']; 

    if(!isset($totals['count'])) $totals['count'] = 0;
    $totals['count']++;

    if(!isset($totals['uc'])) $totals['uc'] = 0;
    $totals['uc'] += $item['uc']; 

     if(!isset($totals['count'])) $totals['count'] = 0;
    $totals['count']++;

    if(!isset($totals['vap'])) $totals['vap'] = 0;
    $totals['vap'] += $item['vap']; 

     if(!isset($totals['count'])) $totals['count'] = 0;
    $totals['count']++;

    if(!isset($totals['iad'])) $totals['iad'] = 0;
    $totals['iad'] += $item['iad']; 

     if(!isset($totals['count'])) $totals['count'] = 0;
    $totals['count']++;

    if(!isset($totals['pleb'])) $totals['pleb'] = 0;
    $totals['pleb'] += $item['pleb']; 

    if(!isset($totals['count'])) $totals['count'] = 0;
    $totals['count']++;

    if(!isset($totals['isk'])) $totals['isk'] = 0;
    $totals['isk'] += $item['isk'];
}

$this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
    'template'=>$template,
    'enableSorting'=>$sort,
    'itemsCssClass'=>$itemCssClass,  
	'extraRowColumns' => array('pasien_id'),
    'extraRowPos'=>'below',
    'extraRowTotals' => function($data, $row, &$totals) {
    if(!isset($totals['ett'])) $totals['ett'] = 0;
    $totals['ett'] += (($data->ett == true) ? $data->getSelisihSurveilansPasang($data->pelepasan_tgl,$data->surveilans_tgl) : 0);
    if(!isset($totals['cvp'])) $totals['cvp'] = 0;
    $totals['cvp'] += (($data->cvp == true) ? $data->getSelisihSurveilansPasang($data->pelepasan_tgl,$data->surveilans_tgl) : 0);
    if(!isset($totals['cvc'])) $totals['cvc'] = 0;
    $totals['cvc'] += (($data->cvc == true) ? $data->getSelisihSurveilansPasang($data->pelepasan_tgl,$data->surveilans_tgl) : 0);
    if(!isset($totals['uc'])) $totals['uc'] = 0;
    $totals['uc'] += (($data->uc == true) ? $data->getSelisihSurveilansPasang($data->pelepasan_tgl,$data->surveilans_tgl) : 0);
    if(!isset($totals['cdl'])) $totals['cdl'] = 0;
    $totals['cdl'] += (($data->cdl == true) ? $data->getSelisihSurveilansPasang($data->pelepasan_tgl,$data->surveilans_tgl) : 0);
		  
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
  
    'extraRowExpression' => '"<b>Total ETT : ".number_format($totals["ett"])."</b> 
		   &nbsp;&nbsp;&nbsp; 
		   <b>Total CPV :
             ".number_format($totals["cvp"])."</b> 
			&nbsp;&nbsp;&nbsp;
            <b>Total CVC :
             ".number_format($totals["cvc"])."</b>
			&nbsp;&nbsp;&nbsp; 
            <b>Total UC :
             ".number_format($totals["uc"])."</b> 
			&nbsp;&nbsp;&nbsp; 
            <b>Total VAP :
             ".number_format($totals["vap"])."</b>
            &nbsp;&nbsp;&nbsp; 
            <b>Total IAD :
             ".number_format($totals["iad"])."</b> 
            &nbsp;&nbsp;&nbsp; 
            <b>Total PLEB :
             ".number_format($totals["pleb"])."</b> 
			&nbsp;&nbsp;&nbsp; 
            <b>Total ISK :
             ".number_format($totals["isk"])."</b>
            " 
             ',
//	     'mergeHeaders'=>array(
//            array(
//                'name'=>'<p style="margin: 0; text-align: center;">Hari Pemasangan</p>',
//                'start'=>5, //indeks kolom 3
//                'end'=>8, //indeks kolom 4
//            ),
//            array(
//                'name'=>'<p style="margin: 0; text-align: center;">Infeksi</p>',
//                'start'=>9, //indeks kolom 3
//                'end'=>12, //indeks kolom 4
//            ), 
//             array(
//                'name'=>'<p style="margin: 0; text-align: center;">Hasil Kultur</p>',
//                'start'=>14, //indeks kolom 3
//                'end'=>17, //indeks kolom 4
//            ),
//        ),
	'columns'=>array( 
             array(
                'header' => 'No.',
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
                'value' => '($data->ett == true) ? $data->getSelisihSurveilansPasang($data->pelepasan_tgl,$data->surveilans_tgl) : 0'
            ),
            array(
                'header' => 'PVC',
                'value' => '($data->cvp == true) ? $data->getSelisihSurveilansPasang($data->pelepasan_tgl,$data->surveilans_tgl) : 0'
            ),
            array(
                'header' => 'CVC',
                'value' => '($data->cvc == true) ? $data->getSelisihSurveilansPasang($data->pelepasan_tgl,$data->surveilans_tgl) : 0'
            ),
            array(
                'header' => 'UC',
                'value' => '($data->uc == true) ? $data->getSelisihSurveilansPasang($data->pelepasan_tgl,$data->surveilans_tgl) : 0'
            ),  
           array(
                'header' => 'CDL',
                'value' => '($data->cdl == true) ? $data->getSelisihSurveilansPasang($data->pelepasan_tgl,$data->surveilans_tgl) : 0'
            ), 
            array(
                'header' => 'OP',
                'value' => '($data->surgery == true) ? 1 : 0'
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
                'header' => 'IDO',
                'value' => '($data->ido == true) ? 1 : 0'
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