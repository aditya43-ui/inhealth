
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
	'columns'=>array(
		////'ruangan_id',
		array(
                        'header'=>'ID',
                        'value'=>'$data->ruangan_id',
                ),
		'instalasi.instalasi_nama',
		'ruangan_nama',
		'ruangan_namalainnya',
		'ruangan_lokasi',
                array(
                     'header'=>'Kasus Penyakit',
                     'type'=>'raw',
                     'value'=>'$this->grid->getOwner()->renderPartial(\'_kasusPenyakit\',array(\'ruangan_id\'=>$data->ruangan_id),true)',
                 ),
                array(
                     'header'=>'Kelas Pelayanan',
                     'type'=>'raw',
                     'value'=>'$this->grid->getOwner()->renderPartial(\'_kelasPelayanan\',array(\'ruangan_id\'=>$data->ruangan_id),true)',
                 ), 
                  array(
                     'header'=>'Daftar Tindakan',
                     'type'=>'raw',
                     'value'=>'$this->grid->getOwner()->renderPartial(\'_daftarTindakan\',array(\'ruangan_id\'=>$data->ruangan_id),true)',
                 ),
                array(
                     'header'=>'Pegawai',
                     'type'=>'raw',
                     'value'=>'$this->grid->getOwner()->renderPartial(\'_ruanganPegawai\',array(\'ruangan_id\'=>$data->ruangan_id),true)',
                 ),  
                 array
                (
                        'name'=>'ruangan_aktif',
                        'type'=>'raw',
                        'value'=>'($data->ruangan_aktif==1)? Yii::t("mds","Yes") : Yii::t("mds","No")',
                ),
                
 
        ),
    )); 
?>