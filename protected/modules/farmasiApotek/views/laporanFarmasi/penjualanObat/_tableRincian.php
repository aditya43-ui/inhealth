
<?php 
/**
 * css untuk membuat text head berada d tengah
 */
echo CHtml::css('.table thead tr th{
    vertical-align:middle;
}'); ?>
<?php
    $table = 'ext.bootstrap.widgets.BootExtendGroupGridView';
    if ($caraPrint=='EXCEL') {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
?>
<?php $this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$model->searchPrint(),
        'template'=>"\n{items}",
        'mergeHeaders'=>array(
            array(
                'name'=>'<p style="margin: 0; text-align: center;">Subsidi</p>',
                'start'=>8, //indeks kolom 3
                'end'=>10, //indeks kolom 4
            ),
        ),
        'classExtending'=>array(
            'widget'=>'ext.bootstrap.widgets.HeaderGroupGridView',
            'htmlOptions'=>array('style'=>'background-color:#cccccc;'),
            'dataProvider'=>$model->searchData(),
            'uniqueKey'=>'noresep',
            'columns'=>array(
                            'r',
                            'rke',
                            'jenisobatalkes_nama',
                            array(
                                'header'=>'Kategori<br>Golongan',
                                'type'=>'raw',
                                'value'=>'$data->obatalkes_golongan.\'<br>\'.$data->obatalkes_kategori',
                                'footer'=>'Jumlah',
                                'footerHtmlOptions'=>array('colspan'=>6, 'style'=>'text-align:right;'),
                                ),
                            'obatalkes_kode',
                            'obatalkes_nama',
                            array(
                                'name'=>'qty_oa',
                                'type'=>'raw',
                                'value'=>'CustomFunction::formatnumber($data->qty_oa)',
                                'footer'=>'sum(qty_oa)',
                                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                                'htmlOptions'=>array('style'=>'text-align:right;'),
                            ),
                            array(
                                'name'=>'hargasatuan_oa',
                                'type'=>'raw',
                                'value'=>'CustomFunction::formatnumber($data->hargasatuan_oa)',
                                'footer'=>'sum(hargasatuan_oa)',
                                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                                'htmlOptions'=>array('style'=>'text-align:right;'),
                            ),
                            array(
                                'name'=>'subTotal',
                                'type'=>'raw',
                                'value'=>'CustomFunction::formatnumber($data->subTotal)',
                                'footer'=>'sum(subTotal)',
                                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                                'htmlOptions'=>array('style'=>'text-align:right;'),
                                ),
                array(
                    'header'=>'Status Bayar',
                    'type'=>'raw',
                    'value'=>'empty($data->oasudahbayar_id) ? "Belum Bayar" : "Sudah Bayar"',
                    'footer'=>' ',
                ),
                        ),
        ),
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
            array(
                    'header' => 'No.',
                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
            ),
            array(
                'name'=>'Tanggal Penjualan<br>Tanggal Resep',
                'type'=>'raw',
                'value'=>'$data->tglpenjualan.\'<br>\'.$data->tglresep',
            ),
            array(
                'name'=>'Jenis Penjualan<br>No. Resep',
                'type'=>'raw',
                'value'=>'$data->jenispenjualan.\'<br>\'.$data->noresep',
            ),
            array(
                'name'=>'No. Rekam Medik<br>No. Pendaftaran',
                'type'=>'raw',
                'value'=>'$data->no_rekam_medik.\'<br>\'.$data->no_pendaftaran',
            ),
            array(
                'name'=>'Nama Pasien<br>Alias',
                'type'=>'raw',
                'value'=>'$data->nama_pasien.\'<br>\'.$data->nama_bin',
            ),
            array(
                'name'=>'Jenis Kelamin<br>Umur',
                'type'=>'raw',
                'value'=>'$data->jeniskelamin.\'<br>\'.$data->umur',
            ),
            array(
                'name'=>'Total Harga Jual',
                'type'=>'raw',
                'value'=>'CustomFunction::formatnumber($data->totalhargajual)',
                'htmlOptions'=>array('style'=>'text-align:right;'),
            ),
            array(
                'name'=>'Total Tarif Service<br>Biaya Administrasi',
                'type'=>'raw',
                'value'=>'CustomFunction::formatnumber($data->totaltarifservice).\'<br>\'.CustomFunction::formatnumber($data->biayaadministrasi)',
                'htmlOptions'=>array('style'=>'text-align:right;'),
            ),
            array(
                'name'=>'Asuransi',
                'type'=>'raw',
                'value'=>'CustomFunction::formatnumber($data->subsidiasuransi)',
                'htmlOptions'=>array('style'=>'text-align:right;'),
            ),
            array(
                'name'=>'Pemerintah',
                'type'=>'raw',
                'value'=>'CustomFunction::formatnumber($data->subsidipemerintah)',
                'htmlOptions'=>array('style'=>'text-align:right;'),
            ),
            array(
                'name'=>'Rumah Sakit',
                'type'=>'raw',
                'value'=>'CustomFunction::formatnumber($data->subsidirs)',
                'htmlOptions'=>array('style'=>'text-align:right;'),
            ),
            array(
                'name'=>'Iur Biaya',
                'type'=>'raw',
                'value'=>'CustomFunction::formatnumber($data->iurbiaya)',
                'htmlOptions'=>array('style'=>'text-align:right;'),
            ),
            array(
                'name'=>'Jenis Penjamin<br>Penjamin',
                'type'=>'raw',
                'value'=>'$data->carabayar_nama.\'<br>\'.$data->penjamin_nama',
            ),
            array(
                'name'=>'Instalasi Asal<br>Ruangan Asal',
                'type'=>'raw',
                'value'=>'$data->instalasiasal_nama.\'<br>\'.$data->ruanganasal_nama',
            ),
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