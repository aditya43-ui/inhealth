<?php 
$table = 'ext.bootstrap.widgets.BootGridView';
$data = $model->searchTable();
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
  $data = $model->searchPrint();  
  $template = "{items}";
  if ($caraPrint == "EXCEL")
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
}
?>

<?php $this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
	'template'=>$template,
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
            array(
                'header' => 'No',
                'value' => '$row+1'
            ), 
		   array(
			   'header' => 'Nama Pasien',
			   'value'=>'$data->nama_pasien',	   
		   ), 
		   array(
			   'header' => 'Ruangan',
			   'value'=>'$data->ruangan_nama',	   
		   ), 
		   array(
			   'header' => 'Time Dialisis',
			   'value'=>'$data->lamahd_jam',	   
		   ), 
		   array(
			   'header' => 'Dializer',
			   'value'=>'$data->dialiserke',	   
		   ), 
		   array(
			   'header'=>'QB',
			   'value'=>'$data->kec_darah_qb',
		  ),  
		 array(
			   'header'=>'Heparin Continue',
			   'value'=>'$data->heparin_continyu',
		  ),  
		 array(
			   'header'=>'Heparin Intermiten',
			   'value'=>'$data->heparin_intermiten',
		  ),
		 array(
			   'header'=>'Heparin Dosis Awal',
			   'value'=>'$data->heparin_dosisawal',
		  ),   
		  array(
			   'header'=>'Heparin LMWH',
			   'value'=>'isset($data->heparin_lmwh) ? $data->heparin_lmwh : " " '
		  ),
		array(
		       'header'=>'Akses',
			   'value'=>'$data->aksesvaskular_nama',
		), 
		array(
		       'header'=>'Penyulit',
			   'value'=>'$data->penyulit_teknis',
		), 
		array(
		       'header'=>'Preparat besi',
			   'value'=>'$data->injeksi_preb_besi'
		), 
		array(
		      'header'=>'Transfusi',
			  'value'=>'$data->jenistransfusi_nama',
		), 
		array(
		      'header'=>'ultrafiltrasi Mode',
			  'value'=>'$data->ultrafiltrasi_mode',
		),
		array(
		      'header'=>'Natrium Mode',
			  'value'=>'$data->natrium_mode',
		),
		array(
		      'header'=>'Bicarbonat Mode',
			  'value'=>'$data->bicarbonat_mode',
		),
		array(
		      'header'=>'Iso Uf Ml',
			  'value'=>'$data->iso_uf_ml',
		),
		array(
		      'header'=>'Lama Uso Uf',
			  'value'=>'$data->lama_uso_uf',
		), 
		array(
			  'header'=>'Tanpa Heparin/Jumlah',
		      'value'=>'$data->tanpaheparin_nama."-".$data->tanpaheparin_jml'	
		), 
		array(
			'header'=>'Obat Hemapo',
			'value'=>'$data->obat_hemapo',
		), 
		array(
			'header'=>'Obat Recormon',
			'value'=>'$data->obat_recormon',
		), 
		array(
			'header'=>'Obat Eprex',
			'value'=>'$data->obat_eprex',
		), 
		array(
			'header'=>'Obat Epotrex',
			'value'=>'$data->obat_epotrex',
		), 
		array(
			'header'=>'Obat Epodion',
			'value'=>'$data->obat_epodion',
		),  
        array(
			'header'=>'Obat Renogen',
			'value'=>'$data->obat_renogen',
		),
		array(
		    'header'=>'Jumlah Labu', 
			'value'=>'isset($data->jmllabudarah) ? $data->jmllabudarah : " - " '
		), 
		array(
		    'header'=>'Prep Besi',
			'value'=>'isset($data->injeksi_preb_besi) ? $data->injeksi_preb_besi : "- " '
		),  
		array(
		    'header'=>'Asam Amino',
			'value'=>'isset($data->injeksi_asamamir) ? $data->injeksi_asamamir : "- " '
		),  
		array(
		    'header'=>'Aliran Darah QD',
			'value'=>'isset($data->kec_dialisat_qd) ? $data->kec_dialisat_qd : "- "'
		), 
		array(
		    'header'=>'UF GOAL',
			'value'=>'isset($data->uf_goal) ? $data->uf_goal : "- "'		
		),
		array(
		   'header'=>'Peresapan HD',
		   'value'=>'$data->getJenishd($data->jenishd_id)'
		), 
		array(
			'header'=>'Jenis Dialisat',
			'value'=>'$data->getJenisDialisat($data->jenisdialisat_id)',
		), 
		array(
		    'header'=>'Heparin Dosis Sirkulasi',
			'value'=>'$data->heparin_dosissirkulasi',
		),
			
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>