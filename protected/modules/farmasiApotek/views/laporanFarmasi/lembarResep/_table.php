<?php 
/**
 * css untuk membuat text head berada d tengah
 */
echo CHtml::css('.table thead tr th{
    vertical-align:middle;
}'); ?>
<?php 
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$itemCssClass='table table-striped table-bordered table-condensed';
$data = $model->searchTable();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
if (isset($caraPrint)){
    $sort = false;
  $data = $model->searchPrint();
echo "
        <style>
            .border th, .border td{
                border:1px solid #000;
            }
            .table thead:first-child{
                border-top:1px solid #000;        
            }

            thead th{
                background:none;
                color:#333;
            }

            .border {
                box-shadow:none;
                border-spacing: 0;
                padding: 0;
            }

            .table tbody tr:hover td, .table tbody tr:hover th {
                background-color: none;
            }
        </style>";
    $itemCssClass='table border';  
  $template = "{items}";
  if ($caraPrint == "EXCEL")
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
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
                'end'=>10, //indeks kolom 4
            ),
        ),
        'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
            array(
                    'header' => 'No.',
                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
            ),
            'instalasiasal_nama',
            'ruanganasal_nama',
            'pegawai.nama_pegawai',
            array(
                'name'=>'Jenis Penjamin<br>Penjamin',
                'type'=>'raw',
                'value'=>'$data->carabayar->carabayar_nama.\'<br>\'.$data->penjamin->penjamin_nama',
                'footer'=>'Jumlah',
                'footerHtmlOptions'=>array('style'=>'text-align:right;', 'colspan'=>5),
            ),
            array(
                'header'=>'Jumlah Lembar Resep',
                'name'=>'noresep',
                'value'=>'$data->noresep',
                'footer'=>'sum(noresep)',
            ),
            array(
                'header'=>'Jumlah R/',
                'name'=>'rke',
                'value'=>'$data->rke',
                'footer'=>'sum(rke)',
            ),
//                    'penjualanresep_id',
//        'tglresep',
       
//        'totharganetto',
//        'totalhargajual',
//        'totaltarifservice',
                   
        /*
        'biayaadministrasi',
        'biayakonseling',
        '',
        

        
        'ruangan_id',
        'penjamin_id',
        'carabayar_id',
        'pendaftaran_id',*/
//            array(
//                'name'=>'Tanggal Penjualan<br>Tanggal Resep',
//                'type'=>'raw',
//                'value'=>'$data->tglpenjualan.\'<br>\'.$data->tglresep',
//            ),
//            array(
//                'name'=>'Jenis Penjualan<br>No. Resep',
//                'type'=>'raw',
//                'value'=>'$data->jenispenjualan.\'<br>\'.$data->noresep',
//            ),
//            array(
//                'name'=>'No. Rekam Medik<br>No. Pendaftaran',
//                'type'=>'raw',
//                'value'=>'$data->no_rekam_medik.\'<br>\'.$data->no_pendaftaran',
//            ),
//            array(
//                'name'=>'Nama Pasien<br>Nama Bin',
//                'type'=>'raw',
//                'value'=>'$data->nama_pasien.\'<br>\'.$data->nama_bin',
//            ),
//            array(
//                'name'=>'Jenis Kelamin<br>Umur',
//                'type'=>'raw',
//                'value'=>'$data->jeniskelamin.\'<br>\'.$data->umur',
//            ),
//            array(
//                'name'=>'Total Harga Jual',
//                'type'=>'raw',
//                'value'=>'CustomFunction::formatnumber($data->totalhargajual)',
//                'htmlOptions'=>array('style'=>'text-align:right;'),
//            ),
//            array(
//                'name'=>'Total Tarif Service<br>Biaya Administrasi',
//                'type'=>'raw',
//                'value'=>'CustomFunction::formatnumber($data->totaltarifservice).\'<br>\'.CustomFunction::formatnumber($data->biayaadministrasi)',
//                'htmlOptions'=>array('style'=>'text-align:right;'),
//            ),
//            array(
//                'name'=>'Asuransi',
//                'type'=>'raw',
//                'value'=>'CustomFunction::formatnumber($data->subsidiasuransi)',
//                'htmlOptions'=>array('style'=>'text-align:right;'),
//            ),
//            array(
//                'name'=>'Pemerintah',
//                'type'=>'raw',
//                'value'=>'CustomFunction::formatnumber($data->subsidipemerintah)',
//                'htmlOptions'=>array('style'=>'text-align:right;'),
//            ),
//            array(
//                'name'=>'Rumah Sakit',
//                'type'=>'raw',
//                'value'=>'CustomFunction::formatnumber($data->subsidirs)',
//                'htmlOptions'=>array('style'=>'text-align:right;'),
//            ),
//            array(
//                'name'=>'Iur Biaya',
//                'type'=>'raw',
//                'value'=>'CustomFunction::formatnumber($data->iurbiaya)',
//                'htmlOptions'=>array('style'=>'text-align:right;'),
//            ),
//            array(
//                'name'=>'Jenis Penjamin<br>Penjamin',
//                'type'=>'raw',
//                'value'=>'$data->carabayar_nama.\'<br>\'.$data->penjamin_nama',
//            ),
//            array(
//                'name'=>'Instalasi Asal<br>Ruangan Asal',
//                'type'=>'raw',
//                'value'=>'$data->instalasiasal_nama.\'<br>\'.$data->ruanganasal_nama',
//            ),
//            'tglpenjualan',
//            'jenispenjualan',
//            'tglresep',
//            'noresep',
//            'pasien_id',
//            'no_rekam_medik',
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
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>