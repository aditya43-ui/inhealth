<?php 
/**
 * css untuk membuat text head berada d tengah
 */
echo CHtml::css('.table thead tr th{
    vertical-align:middle;
}'); ?>
<?php 
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$data = $model->searchTable();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)){
    $row = '$row+1';
    $sort = false;
  $data = $model->searchPrint();  
  $template = "{items}";
  if ($caraPrint == "EXCEL") {
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
  }
}
?>
<?php $this->widget($table,array(
    'id'=>'tableLaporan',
    'dataProvider'=>$data,
    'enableSorting'=>$sort,
    'template'=>$template,
        'mergeHeaders'=>array(
            array(
                'name'=>'<p style="margin: 0; text-align: center;">Subsidi</p>',
                'start'=>8, //indeks kolom 3
                'end'=>11, //indeks kolom 4
            ),
        ),
        'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
            array(
                    'header' => 'No.',
                    'value' => $row,
            ),
            array(
                'header'=>'Tanggal Penjualan <br> Tanggal Resep',
//                'name'=>'Tanggal Penjualan<br>Tanggal Resep',
                'type'=>'raw',
                'value'=>'date("d/m/Y H:i:s",strtotime($data->tglpenjualan)).\'<br>\'.date("d/m/Y H:i:s",strtotime($data->tglresep))',
            ),
            array(
                'header'=>'Jenis Penjualan <br> No. Resep',
//                'name'=>'Jenis Penjualan<br>No. Resep',
                'type'=>'raw',
                'value'=>'$data->jenispenjualan.\'<br>\'.$data->noresep',
            ),
            array(
                'header'=>'No. Rekam Medik <br> No. Pendaftaran',
//                'name'=>'No. Rekam Medik<br>No. Pendaftaran',
                'type'=>'raw',
                'value'=>'$data->no_rekam_medik.\'<br>\'.$data->no_pendaftaran',
            ),
            array(
                'header'=>'Nama Pasien <br> Alias',
//                'name'=>'Nama Pasien<br>Nama Bin',
                'type'=>'raw',
                'value'=>'$data->nama_pasien.\'<br>\'.$data->nama_bin',
            ),
            array(
                'header'=>'Jenis Kelamin <br> Umur',
//                'name'=>'Jenis Kelamin<br>Umur',
                'type'=>'raw',
                'value'=>'$data->jeniskelamin.\'<br>\'.$data->umur',
            ),
            array(
                'header'=>'Total Harga Jual',
//                'name'=>'Total Harga Jual',
                'type'=>'raw',
                'value'=>'MyFormatter::formatUang($data->totalhargajual)',
                'htmlOptions'=>array('style'=>'text-align:right;'),
            ),
            array(
                'header'=>'Total Tarif Service',
//                'name'=>'Total Tarif Service<br>Biaya Administrasi',
                'type'=>'raw',
                'value'=>'MyFormatter::formatUang($data->totaltarifservice)',
                'htmlOptions'=>array('style'=>'text-align:right;'),
            ),
             array(
                'header'=>'Biaya Administrasi',
//                'name'=>'Total Tarif Service<br>Biaya Administrasi',
                'type'=>'raw',
                'value'=>'MyFormatter::formatUang($data->biayaadministrasi)',
                'htmlOptions'=>array('style'=>'text-align:right;'),
            ),
            array(
                'header'=>'Asuransi',
//                'name'=>'Asuransi',
                'type'=>'raw',
                'value'=>'MyFormatter::formatUang($data->subsidiasuransi)',
                'htmlOptions'=>array('style'=>'text-align:right;'),
            ),
            array(
                'header'=>'Pemerintah',
//                'name'=>'Pemerintah',
                'type'=>'raw',
                'value'=>'MyFormatter::formatUang($data->subsidipemerintah)',
                'htmlOptions'=>array('style'=>'text-align:right;'),
            ),
            array(
                'header'=>'Rumah Sakit',
//                'name'=>'Rumah Sakit',
                'type'=>'raw',
                'value'=>'MyFormatter::formatUang($data->subsidirs)',
                'htmlOptions'=>array('style'=>'text-align:right;'),
            ),
            array(
                'header'=>'Iur Biaya',
//                'name'=>'Iur Biaya',
                'type'=>'raw',
                'value'=>'MyFormatter::formatUang($data->iurbiaya)',
                'htmlOptions'=>array('style'=>'text-align:right;'),
            ),
            array(
                'header'=>'Jenis Penjamin <br> Penjamin',
//                'name'=>'Jenis Penjamin<br>Penjamin',
                'type'=>'raw',
                'value'=>'$data->carabayar_nama.\'<br>\'.$data->penjamin_nama',
            ),
            array(
                'header'=>'Instalasi Asal <br> Ruangan Asal',
//                'name'=>'Instalasi Asal<br>Ruangan Asal',
                'type'=>'raw',
                'value'=>'$data->instalasiasal_nama.\'<br>\'.$data->ruanganasal_nama',
            ),
            array(
                'header'=>'Status Bayar',
                'type'=>'raw',
                'value'=>'(empty($data->oasudahbayar_id)) ? "Belum" : "Sudah"',
            ),
           // 'tglpenjualan',
           // 'jenispenjualan',
           // 'tglresep',
           // 'noresep',
           // 'pasien_id',
           // 'no_rekam_medik',
            /*
            'namadepan',
            'nama_pasien',
            'nama_bin',
            'jeniskelamin',
            'tempat_lahir',
            'tanggal_lahir',
            'alamat_pasien',
            'rt',
            'rw',
            ////'pendaftaran_id',
            array(
                        'name'=>'pendaftaran_id',
                        'value'=>'$data->pendaftaran_id',
                        'filter'=>false,
                ),
            'no_pendaftaran',
            'tgl_pendaftaran',
            'umur',
            'carabayar_id',
            'carabayar_nama',
            'penjamin_id',
            'penjamin_nama',
            'pasienadmisi_id',
            'reseptur_id',
            'ruangan_id',
            'pegawai_id',
            'gelardepan',
            'nama_pegawai',
            'nomorindukpegawai',
            'totharganetto',
            'totalhargajual',
            
            'biayakonseling',
            'pembulatanharga',
            'jasadokterresep',
            'instalasiasal_nama',
            'ruanganasal_nama',
            'discount',
            '',
            'subsidipemerintah',
            'subsidirs',
            'iurbiaya',
            'lamapelayanan',
            'create_time',
            'update_time',
            'create_loginpemakai_id',
            'update_loginpemakai_id',
            'create_ruangan',
            'penjualanresep_id',
            'obatalkes_id',
            'obatalkes_kode',
            'obatalkes_nama',
            'obatalkes_golongan',
            'obatalkes_kategori',
            'obatalkes_kadarobat',
            'satuankecil_id',
            'satuankecil_nama',
            'jenisobatalkes_id',
            'jenisobatalkes_nama',
            'sumberdana_id',
            'sumberdana_nama',
            'qty_oa',
            'hargasatuan_oa',
            'hargajual_oa',
            'oasudahbayar_id',
            'racikan_id',
            'r',
            'rke',
             * */
    //            'alamat_pasien',   
	),
)); ?>