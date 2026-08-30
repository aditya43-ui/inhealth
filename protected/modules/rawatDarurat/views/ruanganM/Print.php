
<?php
$table = 'ext.bootstrap.widgets.BootGridView';
if($caraPrint=='EXCEL')
{
    $table = 'ext.bootstrap.widgets.BootExcelGridView';
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerLaporan',array('judulLaporan'=>$judulLaporan));      

$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
	'dataProvider'=>$model->searchPrint(),
                'itemsCssClass'=>'table table-striped table-bordered table-condensed',
//        'template'=>"{summary}\n{items}\n{pager}",
	'columns'=>array(
		////'ruangan_id',
//		array(
//                                        'header'=>'ID',
//                                        'value'=>'$data->ruangan_id',
//                                ),
            array(
                        'header'=>'Nama Ruangan',
                        'name'=>'ruangan_nama',
                        'value'=>'$data->ruangan->ruangan_nama',
              ),
		array(
                        'header'=>'Kategori Tindakan',
                        'name'=>'kategoritindakan_nama',
                        'value'=>'isset($data->daftartindakan->kategoritindakan->kategoritindakan_nama)?$data->daftartindakan->kategoritindakan->kategoritindakan_nama:" - "',
              ),
		array(
                        'header'=>'Kode Tindakan',
                        'name'=>'daftartindakan_kode',
                        'value'=>'isset($data->daftartindakan->daftartindakan_kode)?$data->daftartindakan->daftartindakan_kode:" - "',
              ),
		array(
                        'header'=>'Uraian Tindakan',
                        'name'=>'daftartindakan_nama',
                        'value'=>'isset($data->daftartindakan->daftartindakan_nama)?$data->daftartindakan->daftartindakan_nama:" - "',
              ),
              array(
                        'header'=>'Tarif',
                        'name'=>'harga_tariftindakan',
                        'value'=>'number_format(isset($data->daftartindakan->harga_tariftindakan)?$data->daftartindakan->harga_tariftindakan:0)',
                        'filter'=>true,
              ),
		//'instalasi.instalasi_nama',
//		'ruangan_namalainnya',
//		'ruangan_lokasi',
//                array(
//                     'header'=>'Kasus Penyakit',
//                     'type'=>'raw',
//                     'value'=>'$this->grid->getOwner()->renderPartial(\'_kasusPenyakit\',array(\'ruangan_id\'=>$data[ruangan_id]),true)',
//                 ),
//                array(
//                     'header'=>'Kelas Pelayanan',
//                     'type'=>'raw',
//                     'value'=>'$this->grid->getOwner()->renderPartial(\'_kelasPelayanan\',array(\'ruangan_id\'=>$data[ruangan_id]),true)',
//                 ), 
//                  array(
//                     'header'=>'Daftar Tindakan',
//                     'type'=>'raw',
//                     'value'=>'$this->grid->getOwner()->renderPartial(\'_daftarTindakan\',array(\'ruangan_id\'=>$data[ruangan_id]),true)',
//                 ),
//                array(
//                     'header'=>'Pegawai',
//                     'type'=>'raw',
//                     'value'=>'$this->grid->getOwner()->renderPartial(\'_ruanganPegawai\',array(\'ruangan_id\'=>$data[ruangan_id]),true)',
//                 ),  
//                 array
//                (
//                        'name'=>'ruangan_aktif',
//                        'type'=>'raw',
//                        'value'=>'($data->ruangan_aktif==1)? Yii::t("mds","Yes") : Yii::t("mds","No")',
//                ),
                
 
        ),
    )); 
?>