
<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      

$table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchPrint();
         $template = "{summary}\n{items}\n{pager}";
    }
    
$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
        'enableSorting'=>$sort,
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'komponenjasa_id',
		array(
                        'header' => 'ID',
                        //'name'=>'komponenjasa_id',
                        'value'=>'$data->komponenjasa_id',
                        'filter'=>false,
                ),
                array(
                    'header' => 'Komponen Tarif',
                    'name' => 'komponentarif_id',
                    'value' => 'isset($data->komponentarif_id)?$data->komponentarif->komponentarif_nama:""',
                   // 'filter' => CHtml::activeDropDownList($model,'komponentarif_id',CHtml::listData($model->getKomponentarifItems(),'komponentarif_id','komponentarif_nama'),array('empty'=>'-- Pilih --'))
                ),
                array(
                    'header' => 'Jenis Tarif',
                    'name' => 'jenistarif_id',
                    'value' => 'isset($data->jenistarif_id)?$data->jenistarif->jenistarif_nama:""',
                   // 'filter' => CHtml::activeDropDownList($model,'jenistarif_id', CHtml::listData($model->getJenistarifItems(), 'jenistarif_id', 'jenistarif_nama'),array('empty'=>'-- Pilih --'))
                ),
                 array(
                    'header' => 'Komponen Tarif',
                    'name' => 'carabayar_id',
                    'value' => 'isset($data->carabayar_id)?$data->carabayar->carabayar_nama:""',
                   // 'filter' => CHtml::activeDropDownList($model,'carabayar_id',CHtml::listData($model->getCarabayarItems(),'carabayar_id','carabayar_nama'),array('empty'=>'-- Pilih --'))
                ),
		array(
                    'header' => 'Komponen Tarif',
                    'name' => 'kelompoktindakan_id',
                    'value' => 'isset($data->kelompoktindakan_id)?$data->kelompoktindakan->kelompoktindakan_nama:""',
                   // 'filter' => CHtml::activeDropDownList($model,'kelompoktindakan_id',CHtml::listData($model->getKelompoktindakanItems(),'kelompoktindakan_id','kelompoktindakan_nama'),array('empty'=>'-- Pilih --'))
                ),
                array(
                    'header' => 'Komponen Tarif',
                    'name' => 'ruangan_id',
                    'value' => 'isset($data->ruangan_id)?$data->ruangan->ruangan_nama:""',
                   // 'filter' => CHtml::activeDropDownList($model,'ruangan_id',CHtml::listData($model->getRuanganItems(),'ruangan_id','ruangan_nama'),array('empty'=>'-- Pilih --'))
                ),						
		'komponenjasa_kode',
		'komponenjasa_nama',
		'komponenjasa_singkatan',
		'besaranjasa',
		'potongan',
		'jasadireksi',
		'kuebesar',
		'jasadokter',
		'jasaparamedis',
		'jasaunit',
		'jasabalanceins',
		'jasaemergency',
		'biayaumum',
 
        ),
    )); 
?>