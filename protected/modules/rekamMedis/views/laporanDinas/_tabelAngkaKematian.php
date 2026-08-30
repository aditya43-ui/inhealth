<?php 

if (empty($is_print)) $is_print = false;
$prov = $model->search();

if ($is_print) {
	$prov->pagination = false;
?>
<style>
	
	.table {
		border-collapse: collapse;
	}
	.table td, .table th {
		border: 1px solid black;
	}
	
</style>
<?php
}

$row = $is_print ? '$row+1' : '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';


$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
	'id'=>'tableLaporan',
	'dataProvider'=>$prov,
	'template'=>$is_print?"{items}":"{summary}\n{items}\n{pager}",
	'enableSorting'=>!$is_print,
		'mergeHeaders'=>array(
			array(
				'name'=>'<p style="margin: 0; text-align: center;">Pasien Keluar<br>(Hidup + Mati)</p>',
				'start'=>3, 
				'end'=>5, 
			),
			array(
				'name'=>'<p style="margin: 0; text-align: center;">Pasien Keluar Mati</p>',
				'start'=>6, 
				'end'=>8, 
			),
			array(
				'name'=>'<p style="margin: 0; text-align: center;">Pasien Keluar Mati<br> &ge; 48 Jam</p>',
				'start'=>9, 
				'end'=>11, 
			),
			array(
				'name'=>'<p style="margin: 0; text-align: center;">GDR</p>',
				'start'=>12, 
				'end'=>14, 
			),
			array(
				'name'=>'<p style="margin: 0; text-align: center;">NDR</p>',
				'start'=>15, 
				'end'=>17, 
			),
		),
		'itemsCssClass'=>'table table-striped table-condensed',
		'columns'=>array(
			array(
					'header' => 'No.',
					'value' => $row,
			),
			array(
				'header'=>'Nama RS',
				'name'=>'namars',
			),
			array(
				'header'=>'Jumlah<br>Kamar',
				'type'=>'raw',
				'value'=>function($data) {
					$km = KamarruanganM::model()->findAll('kamarruangan_aktif = true');
					return count((array)$km);
				},
				'htmlOptions' => array('style'=>'text-align: right;'),
			),
			array(            
				'header' => 'L',     
				'name' => 'pasien_keluar_l',
				'htmlOptions' => array('class'=>'det_val', 'style'=>'text-align:right;'),
			),
			array(                
				'header' => 'P',
				'name' => 'pasien_keluar_p',
				'htmlOptions' => array('class'=>'det_val', 'style'=>'text-align:right;'),
			),
			array(                
				'header' => 'L + P',
				'value' => '$data->pasien_keluar_l + $data->pasien_keluar_p',
				'htmlOptions' => array('class'=>'det_val', 'style'=>'text-align:right;')
			),
			array(                 
				'header' => 'L',               
				'name' => 'pasien_meninggal_l',
				'htmlOptions' => array('class'=>'det_val', 'style'=>'text-align:right;')
			),
			array(                 
				'header' => 'P',               
				'name' => 'pasien_meninggal_p',
				'htmlOptions' => array('class'=>'det_val', 'style'=>'text-align:right;')
			),
			array(                
				'header' => 'L + P',
				'value' => '$data->pasien_meninggal_l + $data->pasien_meninggal_p',
				'htmlOptions' => array('class'=>'det_val', 'style'=>'text-align:right;')
			),
			array(                 
				'header' => 'L',               
				'name' => 'pasien_meninggal_24_l',
				'htmlOptions' => array('class'=>'det_val', 'style'=>'text-align:right;')
			),
			array(                 
				'header' => 'P',               
				'name' => 'pasien_meninggal_24_p',
				'htmlOptions' => array('class'=>'det_val', 'style'=>'text-align:right;')
			),
			array(                
				'header' => 'L + P',
				'value' => '$data->pasien_meninggal_24_l + $data->pasien_meninggal_24_p',
				'htmlOptions' => array('class'=>'det_val', 'style'=>'text-align:right;')
			),
			array(                 
				'header' => 'L', 
				'value' => function($data) use (&$gdr_l) {
					if ($data->pasien_keluar_l == 0)
						return $gdr_l = 0;

					$gdr_l = ($data->pasien_meninggal_l / $data->pasien_keluar_l) * 100;

					return number_format($gdr_l, 2, ",", "");
				},
				'htmlOptions' => array('class'=>'det_val', 'style'=>'text-align:right;')
			),
			array(                 
				'header' => 'P',               
				'value' => function($data) use (&$gdr_p) {

					if ($data->pasien_keluar_p == 0)
						return $gdr_p = "0,00";

					$gdr_p = ($data->pasien_meninggal_p / $data->pasien_keluar_p) * 100;

					return number_format($gdr_p, 2, ",", "");
				},
				'htmlOptions' => array('class'=>'det_val', 'style'=>'text-align:right;')
			),
			array(                
				'header' => 'L + P',
				'value' => function($data) {

					$tk = $data->pasien_keluar_l + $data->pasien_keluar_p;
					$tm = $data->pasien_meninggal_l + $data->pasien_meninggal_p;

					if ($tk == 0) return "0,00";
					return number_format(($tm/$tk) * 100, 2, ',', "");
					//return number_format(($gdr_l + $gdr_p) / 2, 2, ",", "");
				},
				'htmlOptions' => array('class'=>'det_val', 'style'=>'text-align:right;')
			),
			array(                 
				'header' => 'L',               
				'value' => function($data) use (&$gdr_l) {
					if ($data->pasien_keluar_l == 0)
						return number_format($gdr_l = 0, 2, ",", "");

					$gdr_l = ($data->pasien_meninggal_24_l / $data->pasien_keluar_l) * 100;

					return number_format($gdr_l, 2, ",", "");
				},
				'htmlOptions' => array('class'=>'det_val', 'style'=>'text-align:right;')
			),
			array(                 
				'header' => 'P',               
				'value' => function($data) use (&$gdr_p) {

					if ($data->pasien_keluar_p == 0)
						return number_format($gdr_p = 0, 2, ",", "");

					$gdr_p = ($data->pasien_meninggal_24_p / $data->pasien_keluar_p) * 100;

					return number_format($gdr_p, 2, ",", "");
				},
				'htmlOptions' => array('class'=>'det_val', 'style'=>'text-align:right;')
			),
			array(                
				'header' => 'L + P',
				'value' => function($data) {

					$tk = $data->pasien_keluar_l + $data->pasien_keluar_p;
					$tm = $data->pasien_meninggal_24_l + $data->pasien_meninggal_24_p;

					if ($tk == 0) return "0,00";
					return number_format(($tm/$tk) * 100, 2, ',', "");
					//return number_format(($gdr_l + $gdr_p) / 2, 2, ",", "");
				},
				'htmlOptions' => array('class'=>'det_val', 'style'=>'text-align:right;')
			),
		),
		'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>