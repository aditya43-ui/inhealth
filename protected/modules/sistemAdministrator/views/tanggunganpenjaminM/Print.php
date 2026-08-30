
<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      

  $table = 'ext.bootstrap.widgets.BootGroupGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchTable();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchTable();
         $template = "{summary}\n{items}\n{pager}";
    }
    
?>
<?php 
$this->widget($table,array(
    'id'=>'satanggunganpenjamin-m-grid',
    'dataProvider'=>$data,
    'enableSorting'=>$sort,
    'mergeColumns' => array('carabayar_id', 'kelaspelayanan_id'),
//    'filter'=>$model,
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'name'=>'carabayar_id',
            'filter'=>CHtml::listData(CarabayarM::model()->findAllByAttributes(array('carabayar_aktif'=>true)), 'carabayar_id', 'carabayar_nama'),
            'value'=>'$data->carabayar->carabayar_nama',
        ),
        array(
            'name'=>'kelaspelayanan_id',
            'filter'=>CHtml::listData(KelaspelayananM::model()->findAllByAttributes(array('kelaspelayanan_aktif'=>true)), 'kelaspelayanan_id', 'kelaspelayanan_nama'),
            'value'=>'$data->kelaspelayanan->kelaspelayanan_nama',
        ),
        array(
            'name'=>'penjamin_id',
            'filter'=>CHtml::listData(PenjaminpasienM::model()->findAllByAttributes(array('penjamin_aktif'=>true)), 'penjamin_id', 'penjamin_nama'),
            'value'=>'$data->penjamin->penjamin_nama',
        ),
    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
?> 