<?php 

    $itemCssClass='table table-bordered table-striped table-condensed';
    $table = 'ext.bootstrap.widgets.MergeHeaderGroupGridView';
    $sort = true;
    $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
		Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
         $row = '$row+1';
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
        }
        
        if ($caraPrint=='PDF') {
            $table = 'ext.bootstrap.widgets.BootGridViewPDFNonRp';
        }
        
       
        $itemCssClass='table border';
        
    } else{
        $data = $model->searchTable();
         $template = "{items}";
    }
?>

<?php  $this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
	'template'=>$template,
	'enableSorting'=>$sort,
	'itemsCssClass'=>$itemCssClass,
	'mergeHeaders'=>array(
		array(
			'name'=>'<p style="margin: 0; text-align: center;">NO</p>',
			'start'=>0, //indeks kolom 3
			'end'=>0, //indeks kolom 4
		),
		array(
			'name'=>'<p style="margin: 0; text-align: center;">NAMA RUMAH SAKIT</p>',
			'start'=>1, //indeks kolom 3
			'end'=>1, //indeks kolom 4
		),
		array(
			'name'=>'<p style="margin: 0; text-align: center;">JUMLAH TEMPAT TIDUR</p>',
			'start'=>2, //indeks kolom 3
			'end'=>2, //indeks kolom 4
		),
		array(
			'name'=>'<p style="margin: 0; text-align: center;">PASIEN KELUAR (HIDUP + MATI)</p>',
			'start'=>3, //indeks kolom 3
			'end'=>3, //indeks kolom 4
		),
		array(
			'name'=>'<p style="margin: 0; text-align: center;">JUMLAH HARI PERAWATAN</p>',
			'start'=>4, //indeks kolom 3
			'end'=>4, //indeks kolom 4
		),
		array(
			'name'=>'<p style="margin: 0; text-align: center;">JUMLAH LAMA DIRAWAT</p>',
			'start'=>5, //indeks kolom 3
			'end'=>5, //indeks kolom 4
		),
		array(
			'name'=>'<p style="margin: 0; text-align: center;">BOR (%)</p>',
			'start'=>6, //indeks kolom 3
			'end'=>6, //indeks kolom 4
		),
		array(
			'name'=>'<p style="margin: 0; text-align: center;">BTO (KALI)</p>',
			'start'=>7, //indeks kolom 3
			'end'=>7, //indeks kolom 4
		),
		array(
			'name'=>'<p style="margin: 0; text-align: center;">TOI (HARI)</p>',
			'start'=>8, //indeks kolom 3
			'end'=>8, //indeks kolom 4
		),
		array(
			'name'=>'<p style="margin: 0; text-align: center;">ALOS (HARI)</p>',
			'start'=>9, //indeks kolom 3
			'end'=>9, //indeks kolom 4
		),
	),
	'columns'=>array(
            array(
				'header'=>'1',
				'value' => $row,
				'htmlOptions' => array('style' => 'text-align:center;')
            ),      
			array(
				'header' => '2',
				'value' => function($data){
					return $data->namars;
				},				
				'htmlOptions' => array('style' => 'text-align:left;'),
				'footer' => '<b>Total</b>',
				'footerHtmlOptions' => array('style' => 'text-align:right;', 'colspan' => 2),
			),
			array(
				'header' => '3',				
				'value' => function ($data){
					return $data->jumlah_kamar;
				},
				'htmlOptions' => array('style' => 'text-align: right;'),
				'footerHtmlOptions' => array('style' => 'text-align:right;'),
				'footer' => 'sum(jumlah_kamar)',
				'name' => 'jumlah_kamar'
			),
			array(
				'header' => '4',
				//'value' => '$data->rj_p',
				'value' => function ($data){
					return $data->pasien_keluar;
				},
				'htmlOptions' => array('style' => 'text-align: right;'),
				'footerHtmlOptions' => array('style' => 'text-align:right;'),
				'footer' => 'sum(pasien_keluar)',
				'name' => 'pasien_keluar'
			),
			array(
				'header' => '5',
				//'value' => '$data->tot_rj',
				'value' => function ($data){
					return $data->hariperawatan;
				},
				'htmlOptions' => array('style' => 'text-align: right;'),
				'footerHtmlOptions' => array('style' => 'text-align:right;'),
				'footer' => 'sum(hariperawatan)',
				'name' => 'hariperawatan'
			),
			array(
				'header' => '6',
				//'value' => '$data->ri_l',
				'value' => function ($data){
					return $data->lamadirawat;
				},
				'htmlOptions' => array('style' => 'text-align: right;'),
				'footerHtmlOptions' => array('style' => 'text-align:right;'),
				'footer' => 'sum(lamadirawat)',
				'name' => 'lamadirawat'
			),
			array(
				'header' => '7',
				//'value' => '$data->ri_p',
				'value' => function ($data){
					if ($data->jumlah_kamar != 0){
						$bor = ($data->hariperawatan / ($data->jumlah_kamar*365)) * 100;
					}else{
						$bor = 0;
					}
								
					return number_format($bor,2,",","");

				},
				'htmlOptions' => array('style' => 'text-align:left;'),
				'footerHtmlOptions' => array('style' => 'text-align:left;'),
				'footer' => $model->getFooter('bor'),
			//	'name' => 'ri_p'
			),
			array(
				'header' => '8',
				//'value' => '$data->tot_ri',
				'value' => function ($data){
					if ($data->jumlah_kamar != 0){
						$bto = $data->pasien_keluar / $data->jumlah_kamar;
					}else{
						$bto = 0;
					}
					
					return number_format($bto,2,",","");
				},
				'htmlOptions' => array('style' => 'text-align: right;'),
				'footerHtmlOptions' => array('style' => 'text-align:right;'),
				'footer' => $model->getFooter('bto'),
			////	'name' => 'tot_ri'
			),
			array(
				'header' => '9',
				//'value' => '$data->jiwa_l',
				'value' => function ($data){				
					if ($data->pasien_keluar != 0){
						$toi = ((($data->jumlah_kamar*365) - $data->hariperawatan)/$data->pasien_keluar);
					}else{
						$toi = 0;
					}
					
					return number_format($toi,2,",","");
				},
				//'value' => '"0"',
				'htmlOptions' => array('style' => 'text-align: right;'),
				'footerHtmlOptions' => array('style' => 'text-align:right;'),
				'footer' => $model->getFooter('toi'),
				//'footer' => 'sum(jiwa_l)',
				//'name' => 'jiwa_l'
			),
			array(
				'header' => '10',
				//'value' => '$data->jiwa_p',
				'value' => function ($data){				
					if ($data->pasien_keluar != 0){
						$alos = ($data->hariperawatan/$data->pasien_keluar);
					}else{
						$alos = 0;
					}
					
					return number_format($alos,2,",","");
				},
				//'value' => '"0"',
				'htmlOptions' => array('style' => 'text-align: right;'),
				'footerHtmlOptions' => array('style' => 'text-align:right;'),
				'footer' => $model->getFooter('alos'),
			//	'footer' => 'sum(jiwa_p)',
			//	'name' => 'jiwa_p'
			),			
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
?>

<?php /*
<table class="<?php echo $itemCssClass ?>">
	<tr>
		<th style="vertical-align: middle;text-align: center;" rowspan="3">NO</th>
		<th style="vertical-align: middle;text-align: center;" rowspan="3">SARANA PELAYANAN KESEHATAN</th>
		<th style="vertical-align: middle;text-align: center;" colspan="6">JUMLAH KUNJUNGAN</th>
		<th style="vertical-align: middle;text-align: center;" colspan="3"></th>
	</tr>
	<tr>
		<th style="vertical-align: middle;text-align: center;" colspan="3">RAWAT JALAN</th>
		<th style="vertical-align: middle;text-align: center;" colspan="3">RAWAT INAP</th>
		<th style="vertical-align: middle;text-align: center;" colspan="3">JUMLAH</th>
	</tr>
	<tr>
		<th style="vertical-align: middle;text-align: center;">L</th>
		<th style="vertical-align: middle;text-align: center;">P</th>
		<th style="vertical-align: middle;text-align: center;">L+P</th>
		<th style="vertical-align: middle;text-align: center;">L</th>
		<th style="vertical-align: middle;text-align: center;">P</th>
		<th style="vertical-align: middle;text-align: center;">L+P</th>
		<th style="vertical-align: middle;text-align: center;">L</th>
		<th style="vertical-align: middle;text-align: center;">P</th>
		<th style="vertical-align: middle;text-align: center;">L+P</th>
	</tr>
	<tr>
		<th style="vertical-align: middle;text-align: center;"><i>1</i></th>
		<th style="vertical-align: middle;text-align: center;"><i>2</i></th>
		<th style="vertical-align: middle;text-align: center;"><i>3</i></th>
		<th style="vertical-align: middle;text-align: center;"><i>4</i></th>
		<th style="vertical-align: middle;text-align: center;"><i>5</i></th>
		<th style="vertical-align: middle;text-align: center;"><i>6</i></th>
		<th style="vertical-align: middle;text-align: center;"><i>7</i></th>
		<th style="vertical-align: middle;text-align: center;"><i>8</i></th>
		<th style="vertical-align: middle;text-align: center;"><i>9</i></th>
		<th style="vertical-align: middle;text-align: center;"><i>10</i></th>
		<th style="vertical-align: middle;text-align: center;"><i>11</i></th>
	</tr>
	<tbody id="getdatakunjungan">
	
		<?php 
			if (!empty($kunjungan)){
				$no = 1;
				foreach ($kunjungan as $det){
		?>
				<tr>
					<td><?php echo $no; ?></td>
				</tr>
		<?php
				}
			}
		?>
	</tbody>
</table>
 * 
 */ ?>