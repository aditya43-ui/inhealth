<?php
/**
* @category	Icon
* @fungsi	digunakan untuk menyederhanakan icon, jika dipakai pada beberapa menu (supaya tidak harus diganti per menu)
* @author	Muhammad Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 * 
 */
Class MyIcon
{
    public static function getIcons($icon)
    {
        $data =  array(
			'cetak'					=> 'entypo-print',
			'excel'					=> 'fas fa-file-excel',
			'pdf'					=> 'fas fa-file-pdf',
			'file'					=> 'fas fa-file',
			'grafik'				=> 'entypo-chart-area',
			'ulang'					=> 'entypo-arrows-ccw',
			'cari'					=> 'entypo-search',            
			'ubah2'					=> 'entypo-pencil',
			'tambah'				=> 'icon-plus icon-white',
			'tambah-circled'        => 'entypo-plus-circled',
			'tambah-baris'          => 'icon-plus icon-white',
			'hapus-baris'           => 'entypo-minus',
			'simpan'				=> 'entypo-check',
			'lihat'					=> 'glyphicon glyphicon-eye-open',
			'lihat2'				=> 'icon-form-detail',
			'ubah'					=> 'glyphicon glyphicon-pencil',
			'hapus'					=> 'icon-form-sampah',
			'batal'					=> 'icon-form-silang',
			'pengaturan'            => 'entypo-folder',
			'list'                  => 'glyphicon glyphicon-list',
            'list2'                 => 'glyphicon glyphicon-list-alt',
			'info'                  => 'glyphicon glyphicon-info-sign',
			'info2'                 => 'entypo-info',
			'info3'                 => 'entypo-info-circled',
			'approve'               => 'entypo-check',
			'signin'				=> 'glyphicon glyphicon-log-in',
			'signout'				=> 'glyphicon glyphicon-log-out',
			'timeout'				=> 'glyphicon glyphicon-off',
            'gambar'                => 'glyphicon glyphicon-picture',
            'periksa'               => 'icon-form-periksa',
            'alergi'                => 'icon-form-riwayatperiksa',
            'tindakan'              => 'icon-medical-listcentang',
            'tindaklanjut'          =>'icon-form-ri',
            'konfujidarah'          =>'entypo-water',
        );
		
		return $data[$icon];
    }
        
}
?>