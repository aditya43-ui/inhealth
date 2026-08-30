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
    'multipleHeader' => array(
        array(
            array('text' => 'No', 'colspan' => 1, 'options' => array('rowspan' => '3')),
            array('text' => 'Rumah Sakit', 'colspan' => 1, 'options' => array('rowspan' => '3')),
            array('text' => 'Pneumonia', 'colspan' => 5, 'options' => array()),
            array('text' => 'Batuk Bukan Pneumonia', 'colspan' => 5, 'options' => array()),
            array('text' => 'Jumlah Kematian Balita karena Pneumonia', 'colspan' => 5, 'options' => array()),
            array('text' => 'ISPA &ge; 5th', 'colspan' => 5, 'options' => array())
        ),
        array(
            //pneumonia
            array('text' => '< 1 th', 'colspan' => 2, 'options' => array()),
            array('text' => '1 < 5 th', 'colspan' => 2, 'options' => array()),
            array('text' => 'Subtotal', 'colspan' => 1, 'options' => array('rowspan' => 2)),

            //bukan batuk pneumonia
            array('text' => '< 1 th', 'colspan' => 2, 'options' => array()),
            array('text' => '1 < 5 th', 'colspan' => 2, 'options' => array()),
            array('text' => 'Subtotal', 'colspan' => 1, 'options' => array('rowspan' => 2)),

            //jumlah kematian balita karena pneumonia
            array('text' => '< 1 th', 'colspan' => 2, 'options' => array()),
            array('text' => '1 < 5 th', 'colspan' => 2, 'options' => array()),
            array('text' => 'Subtotal', 'colspan' => 1, 'options' => array('rowspan' => 2)),

            //ISPAn lebih dari samadengan 5th
            array('text' => 'Bukan Pneumonia', 'colspan' => 2, 'options' => array()),
            array('text' => 'Pneumonia', 'colspan' => 2, 'options' => array()),
            array('text' => 'Subtotal', 'colspan' => 1, 'options' => array('rowspan' => 2)),
        ),
        array(
            //pnemumonia < 1 th
            array('text' => 'L', 'colspan' => 1, 'options' => array()),
            array('text' => 'P', 'colspan' => 1, 'options' => array()),
            //pnemumonia 1 < 5 th
            array('text' => 'L', 'colspan' => 1, 'options' => array()),
            array('text' => 'P', 'colspan' => 1, 'options' => array()),

            //bukan batuk pneumonia < 1 th
            array('text' => 'L', 'colspan' => 1, 'options' => array()),
            array('text' => 'P', 'colspan' => 1, 'options' => array()),
            //bukan batuk pnemumonia 1 < 5 th
            array('text' => 'L', 'colspan' => 1, 'options' => array()),
            array('text' => 'P', 'colspan' => 1, 'options' => array()),

            //jumlah kematian balita karena pneumonia <1 th
            array('text' => 'L', 'colspan' => 1, 'options' => array()),
            array('text' => 'P', 'colspan' => 1, 'options' => array()),
            //jumlah kematian balita karena pneumonia 1 < 5 th
            array('text' => 'L', 'colspan' => 1, 'options' => array()),
            array('text' => 'P', 'colspan' => 1, 'options' => array()),

            //ISPA >= 5 th bukan pneumonia
            array('text' => 'L', 'colspan' => 1, 'options' => array()),
            array('text' => 'P', 'colspan' => 1, 'options' => array()),

            //ISPA >= 5 th pneumonia
            array('text' => 'L', 'colspan' => 1, 'options' => array()),
            array('text' => 'P', 'colspan' => 1, 'options' => array()),
        )
    ),
    'columns' => array(
        array(
            'header' => 'No.',
            'value' => $row,
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Rumah Sakit',
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

        //pneumonia  < 1 th
        array(
            'name' => 'pneumonia_0_lk',
            'value' => 'number_format($data->pneumonia_0_lk,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'footer' => 'sum(pneumonia_0_lk)',
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
        ),
        array(
            'name' => 'pneumonia_0_pr',
            'value' => 'number_format($data->pneumonia_0_pr,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'footer' => 'sum(pneumonia_0_pr)',
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
        ),

        //pneumonia 1 < 5 th	
        array(
            'name' => 'pneumonia_1_4_lk',
            'value' => 'number_format($data->pneumonia_1_4_lk,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'footer' => 'sum(pneumonia_1_4_lk)',
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
        ),
        array(
            'name' => 'pneumonia_1_4_pr',
            'value' => 'number_format($data->pneumonia_1_4_pr,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'footer' => 'sum(pneumonia_1_4_pr)',
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
        ),

        //total pneumonia
        array(
            'name' => 'pneumonia_5_sub',
            'value' => 'number_format($data->pneumonia_5_sub,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'footer' => 'sum(pneumonia_5_sub)',
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
        ),


        //bukan batuk pneumonia  < 1 th
        array(
            'name' => 'notpneumonia_0_lk',
            'value' => 'number_format($data->notpneumonia_0_lk,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'footer' => 'sum(notpneumonia_0_lk)',
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
        ),
        array(
            'name' => 'notpneumonia_0_pr',
            'value' => 'number_format($data->notpneumonia_0_pr,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'footer' => 'sum(notpneumonia_0_pr)',
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
        ),

        //bukan batuk pneumonia 1 < 5 th	
        array(
            'name' => 'notpneumonia_1_4_lk',
            'value' => 'number_format($data->notpneumonia_1_4_lk,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'footer' => 'sum(notpneumonia_1_4_lk)',
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
        ),
        array(
            'name' => 'notpneumonia_1_4_pr',
            'value' => 'number_format($data->notpneumonia_1_4_pr,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'footer' => 'sum(notpneumonia_1_4_pr)',
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
        ),

        //total bukan batuk pneumonia
        array(
            'name' => 'notpneumonia_5_sub',
            'value' => 'number_format($data->notpneumonia_5_sub,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'footer' => 'sum(notpneumonia_5_sub)',
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
        ),


        //jumlah kematian balita karena pneumonia  < 1 th
        array(
            'name' => 'matipneumonia_0_lk',
            'value' => 'number_format($data->matipneumonia_0_lk,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'footer' => 'sum(matipneumonia_0_lk)',
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
        ),
        array(
            'name' => 'matipneumonia_0_pr',
            'value' => 'number_format($data->matipneumonia_0_pr,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'footer' => 'sum(matipneumonia_0_pr)',
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
        ),

        //jumlah kematian balita karena pneumonia   1 < 5 th	
        array(
            'name' => 'matipneumonia_1_4_lk',
            'value' => 'number_format($data->matipneumonia_1_4_lk,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'footer' => 'sum(matipneumonia_1_4_lk)',
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
        ),
        array(
            'name' => 'matipneumonia_1_4_pr',
            'value' => 'number_format($data->matipneumonia_1_4_pr,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'footer' => 'sum(matipneumonia_1_4_pr)',
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
        ),

        //total jumlah kematian balita karena pneumonia
        array(
            'name' => 'matipneumonia_5_sub',
            'value' => 'number_format($data->matipneumonia_5_sub,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'footer' => 'sum(matipneumonia_5_sub)',
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
        ),

        //ISPA >= 5 th bukan pneumonia
        array(
            'name' => 'pneumonia_5_lk',
            'value' => 'number_format($data->pneumonia_5_lk,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'footer' => 'sum(pneumonia_5_lk)',
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
        ),
        array(
            'name' => 'pneumonia_5_pr',
            'value' => 'number_format($data->pneumonia_5_pr,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'footer' => 'sum(pneumonia_5_pr)',
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
        ),

        //jumlah kematian balita karena pneumonia   1 < 5 th	
        array(
            'name' => 'notpneumonia_5_lk',
            'value' => 'number_format($data->notpneumonia_5_lk,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'footer' => 'sum(notpneumonia_5_lk)',
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
        ),
        array(
            'name' => 'notpneumonia_5_pr',
            'value' => 'number_format($data->notpneumonia_5_pr,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'footer' => 'sum(notpneumonia_5_pr)',
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
        ),

        //total bukan batuk pneumonia
        array(
            'name' => 'subpneumonia_5',
            'value' => 'number_format($data->subpneumonia_5,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'footer' => 'sum(subpneumonia_5)',
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
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