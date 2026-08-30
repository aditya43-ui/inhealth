<?php

$itemCssClass = 'table table-bordered table-striped table-condensed';
$table = 'ext.bootstrap.widgets.MergeHeaderGroupGridView';
$sort = true;
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)) {
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
    $row = '$row+1';
    $data = $model->searchPrint();
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL") {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }

    if ($caraPrint == 'PDF') {
        $table = 'ext.bootstrap.widgets.BootGridViewPDFNonRp';
    }


    $itemCssClass = 'table border';
} else {
    $data = $model->searchTable();
    $template = "{items}";
}
?>

<?php $this->widget($table, array(
    'id' => 'tableLaporan',
    'dataProvider' => $data,
    'template' => $template,
    'enableSorting' => $sort,
    'itemsCssClass' => $itemCssClass,
    'mergeHeaders' => array(
        array(
            'name' => '<p style="margin: 0; text-align: center;">Kunjungan RJ</p>',
            'start' => 2, //indeks kolom 3
            'end' => 4, //indeks kolom 4
        ),
        array(
            'name' => '<p style="margin: 0; text-align: center;">Kunjungan RI</p>',
            'start' => 5, //indeks kolom 3
            'end' => 7, //indeks kolom 4
        ),
        array(
            'name' => '<p style="margin: 0; text-align: center;">Kunjungan Gangguan Jiwa</p>',
            'start' => 8, //indeks kolom 3
            'end' => 10, //indeks kolom 4
        ),
    ),
    'columns' => array(
        array(
            'header' => 'No.',
            'value' => $row,
            'htmlOptions' => array('style' => 'text-align:center;')
        ),
        array(
            'header' => 'Sarana Pelayanan Kesehatan',
            'value' => function ($data) {
                $pr = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());

                if (!empty($pr)) {
                    return $pr->nama_rumahsakit;
                } else {
                    return '-';
                }
            },
            'htmlOptions' => array('style' => 'text-align: center;'),
            'footer' => '<b>Total</b>',
            'footerHtmlOptions' => array('style' => 'text-align:right;', 'colspan' => 2),
        ),
        array(
            'header' => 'L',
            //'value' => '$data->rj_l',
            'value' => function ($data) {
                if (empty($data->rj_l)) {
                    return 0;
                } else {
                    return $data->rj_l;
                }
            },
            'htmlOptions' => array('style' => 'text-align: center;'),
            'footerHtmlOptions' => array('style' => 'text-align:center;'),
            'footer' => 'sum(rj_l)',
            'name' => 'rj_l'
        ),
        array(
            'header' => 'P',
            //'value' => '$data->rj_p',
            'value' => function ($data) {
                if (empty($data->rj_p)) {
                    return 0;
                } else {
                    return $data->rj_p;
                }
            },
            'htmlOptions' => array('style' => 'text-align: center;'),
            'footerHtmlOptions' => array('style' => 'text-align:center;'),
            'footer' => 'sum(rj_p)',
            'name' => 'rj_p'
        ),
        array(
            'header' => 'L+P',
            //'value' => '$data->tot_rj',
            'value' => function ($data) {
                if (empty($data->tot_rj)) {
                    return 0;
                } else {
                    return $data->tot_rj;
                }
            },
            'htmlOptions' => array('style' => 'text-align: center;'),
            'footerHtmlOptions' => array('style' => 'text-align:center;'),
            'footer' => 'sum(tot_rj)',
            'name' => 'tot_rj'
        ),
        array(
            'header' => 'L',
            //'value' => '$data->ri_l',
            'value' => function ($data) {
                if (empty($data->ri_l)) {
                    return 0;
                } else {
                    return $data->ri_l;
                }
            },
            'htmlOptions' => array('style' => 'text-align: center;'),
            'footerHtmlOptions' => array('style' => 'text-align:center;'),
            'footer' => 'sum(ri_l)',
            'name' => 'ri_l'
        ),
        array(
            'header' => 'P',
            //'value' => '$data->ri_p',
            'value' => function ($data) {
                if (empty($data->ri_p)) {
                    return 0;
                } else {
                    return $data->ri_p;
                }
            },
            'htmlOptions' => array('style' => 'text-align: center;'),
            'footerHtmlOptions' => array('style' => 'text-align:center;'),
            'footer' => 'sum(ri_p)',
            'name' => 'ri_p'
        ),
        array(
            'header' => 'L+P',
            //'value' => '$data->tot_ri',
            'value' => function ($data) {
                if (empty($data->tot_ri)) {
                    return 0;
                } else {
                    return $data->tot_ri;
                }
            },
            'htmlOptions' => array('style' => 'text-align: center;'),
            'footerHtmlOptions' => array('style' => 'text-align:center;'),
            'footer' => 'sum(tot_ri)',
            'name' => 'tot_ri'
        ),
        array(
            'header' => 'L',
            //'value' => '$data->jiwa_l',
            'value' => function ($data) {
                if (empty($data->jiwa_l)) {
                    return 0;
                } else {
                    return $data->jiwa_l;
                }
            },
            //'value' => '"0"',
            'htmlOptions' => array('style' => 'text-align: center;'),
            'footerHtmlOptions' => array('style' => 'text-align:center;'),
            'footer' => 'sum(jiwa_l)',
            'name' => 'jiwa_l'
        ),
        array(
            'header' => 'P',
            //'value' => '$data->jiwa_p',
            'value' => function ($data) {
                if (empty($data->jiwa_p)) {
                    return 0;
                } else {
                    return $data->jiwa_p;
                }
            },
            //'value' => '"0"',
            'htmlOptions' => array('style' => 'text-align: center;'),
            'footerHtmlOptions' => array('style' => 'text-align:center;'),
            'footer' => 'sum(jiwa_p)',
            'name' => 'jiwa_p'
        ),
        array(
            'header' => 'L+P',
            'value' => function ($data) {
                if (empty($data->tot_jiwa)) {
                    return 0;
                } else {
                    return $data->tot_jiwa;
                }
            },
            //'value' => '"0"',
            'htmlOptions' => array('style' => 'text-align: center;'),
            'footerHtmlOptions' => array('style' => 'text-align:center;'),
            'footer' => 'sum(tot_jiwa)',
            'name' => 'tot_jiwa'
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
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