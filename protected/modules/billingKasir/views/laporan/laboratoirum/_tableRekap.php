<?php 
    $table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
    $sort = false;
    $dataProvider = $model->searchTableGroup();
    $template = "{summary}\n{items}\n{pager}";
?>
<?php
    $this->widget($table,
        array(
            'id'=>'tableRekap',
            'dataProvider'=>$dataProvider,
            'template'=>$template,
            'enableSorting'=>$sort,
            'itemsCssClass'=>'table table-responsive table-bordered table-striped table-condensed',
            'mergeColumns' => array('no_rekam_medik'),
            'columns'=>array(
                array(
                    'header'=>'No. Rekam Medik',
                    'name'=>'no_rekam_medik',
                    'type'=>'raw',
                    'value'=>'$data->no_rekam_medik',
                    'footerHtmlOptions' => array('colspan' => 5, 'style' => 'text-align: right; font-weight: bold;'),
                    'footer'=>'Total (Rp)',
                ),
                array(
                    'header'=>'Nama Pasien',
                    'type'=>'raw',
                    'value'=>'$data->nama_pasien',
                ),
                array(
                    'header'=>'No. Pendaftaran',
                    'type'=>'raw',
                    'value'=>'$data->no_pendaftaran',
                ),
                array(
                    'header'=>'Asal',
                    'type'=>'raw',
                    'value'=>'empty($data->rujukan_id) ? ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS())->nama_rumahsakit : "Rujukan"',
                ),
                array(
                    'header'=>'Initial P3',
                    'type'=>'raw',
                    'value'=>'$data->penjamin_nama',
                ),
                array(
                    'header'=>'Biaya Pasien',
                    'name'=>'tarif_tindakan',
                    'type'=>'raw',
                    'value'=>'number_format($data->tarif_tindakan,0,"",".")',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>number_format($model->getSumTarifTindakan(),0,",","."),
                ),
                array(
                    'header'=>'Tanggungan P3',
                    'name'=>'TotalSubsidi', 
                    'type'=>'raw',
                    'value'=>'number_format($data->TotalSubsidi,0,"",".")',
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>number_format($model->getSumTotalSubsidi(),0,",","."),
                ),
//                array(
//                    'header'=>'Iur Biaya',
//                    'type'=>'raw',
//                    'value'=>'number_format($data->iurbiaya_tindakan)',
//                    'htmlOptions'=>array('style'=>'text-align:right;'),
//                ),
             ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )
    );
    