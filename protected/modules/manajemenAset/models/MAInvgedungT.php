
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class MAInvgedungT extends InvgedungT
{
    public $barang_nama;
    public $kode_wilayah,$status_tanah,$kondisifisikbangunan,$kontruksi_bangunan,$luas,$kd_tanah;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KabupatenM the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'invgedung_id' => 'Inv. Gedung ID',
			'pemilikbarang_id' => 'Pemilik Aset',
			'barang_id' => 'Aset',
			'lokasi_id' => 'Lokasi',
			'asalaset_id' => 'Asal Aset',
			'invgedung_kode' => 'Kode Aset Gedung',
			'invgedung_noregister' => 'Kode Lokasi',
			'invgedung_namabrg' => 'Nama Gedung',
			'invgedung_kontruksi' => 'Kontruksi Gedung',
			'invgedung_luaslantai' => 'Luas Lantai',
			'invgedung_alamat' => 'Alamat Gedung',
			'invgedung_tgldokumen' => 'Tanggal Dokumen Gedung',
			'invgedung_tglguna' => 'Tanggal Guna Gedung',
			'invgedung_nodokumen' => 'No. Dokumen Gedung',
			'invgedung_harga' => 'Harga Gedung',
			'invgedung_akumsusut' => 'Akumulasi Susut Gedung',
			'invgedung_ket' => 'Keterangan Gedung',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'umurekonomis' => 'Umur Ekonomis',
			'tglpenghapusan' => 'Tanggal Penghapusan',
			'tipepenghapusan' => 'Tipe Penghapusan',
                        'kd_tanah'=> 'Kode Tanah'
		);
	}
}
?>
