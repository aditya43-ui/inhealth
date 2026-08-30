
<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerLaporan',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      

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
				array(
									'header' => 'No.',
									'value' => '$row+1'
								),
								'grouplayanan_kode',            
								'grouplayanan_nama',
								'grouplayanan_definisi',
								array(
									'header' => 'Pengelompokkan',
									'value' => function($data){
										if ($data->is_oa){
											return 'Jenis Obat Alkes';
										}else{
											return 'Tindakan';
										}
									},
								//	'filter' => CHtml::activeDropDownList($model, 'is_oa', array(
						//'is_oa'=>'Jenis Obat dan Alkes',
						//'is_tindakan'=>'Tindakan'),array('empty' => '-- Pilih --'))
								),
						/*		array(
									'header'=>'Status',
									'value'=>'($data->grouplayanan_aktif == true ) ? "Aktif" : "Tidak Aktif"',									
								),			*/
        ),
    )); 
?>