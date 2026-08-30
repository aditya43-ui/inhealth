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

            //array('text'=>'FASILITAS PELAYANAN KESEHATAN','colspan'=>16,'options'=>array())			
        ),
        array(
            array('text' => 'NO', 'colspan' => 1, 'options' => array('rowspan' => '2')),
            array('text' => 'RUMAH SAKIT', 'colspan' => 1, 'options' => array('rowspan' => '2')),
            //0-65 Bln
            array('text' => '0 - 5 bln', 'colspan' => 2, 'options' => array()),

            //>= 6 - 1 Th
            array('text' => '&ge; 6 bln - 1 th', 'colspan' => 2, 'options' => array()),

            //1 - 4 th
            array('text' => '1 - 4 th', 'colspan' => 2, 'options' => array()),

            //5 - 9 th
            array('text' => '5 - 9 th', 'colspan' => 2, 'options' => array()),

            //10 - 14 th
            array('text' => '10 - 14 th', 'colspan' => 2, 'options' => array()),

            //15 - 19 th
            array('text' => '15 - 19 th', 'colspan' => 2, 'options' => array()),

            //>=20 th
            array('text' => '&ge; 20 th', 'colspan' => 2, 'options' => array()),

            //jumlah
            array('text' => 'Subtotal', 'colspan' => 2, 'options' => array()),

        ),
        array(
            //0-6 bln
            array('text' => 'L', 'colspan' => 1, 'options' => array()),
            array('text' => 'P', 'colspan' => 1, 'options' => array()),
            //>= 6 bln- 1 th
            array('text' => 'L', 'colspan' => 1, 'options' => array()),
            array('text' => 'P', 'colspan' => 1, 'options' => array()),

            //1-4th
            array('text' => 'L', 'colspan' => 1, 'options' => array()),
            array('text' => 'P', 'colspan' => 1, 'options' => array()),
            //5-9th
            array('text' => 'L', 'colspan' => 1, 'options' => array()),
            array('text' => 'P', 'colspan' => 1, 'options' => array()),

            //10-14th
            array('text' => 'L', 'colspan' => 1, 'options' => array()),
            array('text' => 'P', 'colspan' => 1, 'options' => array()),
            //15-19th
            array('text' => 'L', 'colspan' => 1, 'options' => array()),
            array('text' => 'P', 'colspan' => 1, 'options' => array()),

            //> 20th
            array('text' => 'L', 'colspan' => 1, 'options' => array()),
            array('text' => 'P', 'colspan' => 1, 'options' => array()),

            //Jumlah
            array('text' => 'L', 'colspan' => 1, 'options' => array()),
            array('text' => 'P', 'colspan' => 1, 'options' => array()),
        )
    ),
    'columns' => array(
        array(
            'header' => 'No.',
            'value' => $row,
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;text-align:center;'),
            'htmlOptions' => array('style' => 'text-align:center;')
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
            'headerHtmlOptions' => array('style' => 'vertical-align:middle;text-align:center;'),
            'htmlOptions' => array('style' => 'text-align: center;'),
            'footer' => '<b>Total</b>',
            'footerHtmlOptions' => array('style' => 'text-align:right;', 'colspan' => 2),
        ),

        //0-5 bln
        array(
            'name' => 'diare_0_5_bln_lk',
            'value' => 'number_format($data->diare_0_5_bln_lk,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'footer' => 'sum(diare_0_5_bln_lk)',
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
        ),
        array(
            'name' => 'diare_0_5_bln_pr',
            'value' => 'number_format($data->diare_0_5_bln_pr,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'footer' => 'sum(diare_0_5_bln_pr)',
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
        ),

        // 6 bln - 1 th
        array(
            'name' => 'diare_6_12_bln_lk',
            'value' => 'number_format($data->diare_6_12_bln_lk,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'footer' => 'sum(diare_6_12_bln_lk)',
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
        ),
        array(
            'name' => 'diare_6_12_bln_pr',
            'value' => 'number_format($data->diare_6_12_bln_pr,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'footer' => 'sum(diare_6_12_bln_pr)',
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
        ),

        //2 - 4 th  diare_2_4_th_pr
        array(
            'name' => 'diare_2_4_th_lk',
            'value' => 'number_format($data->diare_2_4_th_lk,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'footer' => 'sum(diare_2_4_th_lk)',
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
        ),
        array(
            'name' => 'diare_2_4_th_pr',
            'value' => 'number_format($data->diare_2_4_th_pr,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'footer' => 'sum(diare_2_4_th_pr)',
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
        ),


        //5-9th
        array(
            'name' => 'diare_5_9_th_lk',
            'value' => 'number_format($data->diare_5_9_th_lk,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'footer' => 'sum(diare_5_9_th_lk)',
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
        ),
        array(
            'name' => 'diare_5_9_th_pr',
            'value' => 'number_format($data->diare_5_9_th_pr,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'footer' => 'sum(diare_5_9_th_pr)',
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
        ),

        //10 - 14th
        array(
            'name' => 'diare_10_14_th_lk',
            'value' => 'number_format($data->diare_10_14_th_lk,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'footer' => 'sum(diare_10_14_th_lk)',
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
        ),
        array(
            'name' => 'diare_10_14_th_pr',
            'value' => 'number_format($data->diare_10_14_th_pr,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'footer' => 'sum(diare_10_14_th_pr)',
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
        ),

        //15-19th
        array(
            'name' => 'diare_15_19_th_lk',
            'value' => 'number_format($data->diare_15_19_th_lk,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'footer' => 'sum(diare_15_19_th_lk)',
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
        ),
        array(
            'name' => 'diare_15_19_th_pr',
            'value' => 'number_format($data->diare_15_19_th_pr,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'footer' => 'sum(diare_15_19_th_pr)',
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
        ),


        //>= 20th
        array(
            'name' => 'diare_20_th_lk',
            'value' => 'number_format($data->diare_20_th_lk,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'footer' => 'sum(diare_20_th_lk)',
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
        ),
        array(
            'name' => 'diare_20_th_pr',
            'value' => 'number_format($data->diare_20_th_pr,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'footer' => 'sum(diare_20_th_pr)',
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
        ),

        //total 
        array(
            'name' => 'diare_tot_lk',
            'value' => 'number_format($data->diare_tot_lk,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'footer' => 'sum(diare_tot_lk)',
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
        ),
        array(
            'name' => 'diare_tot_pr',
            'value' => 'number_format($data->diare_tot_pr,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'footer' => 'sum(diare_tot_pr)',
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