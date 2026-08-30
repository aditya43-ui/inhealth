
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class MAInvasetlainT extends InvasetlainT
{
    public $barang_nama;
	public $kode_wilayah;
    public $tahun_cetak,$pembelian;
    public $lokasi_nama;
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
			'invasetlain_id' => 'ID',
			'asalaset_id' => 'Asal Aset',
			'barang_id' => 'Aset',
			'lokasi_id' => 'Lokasi',
			'pemilikbarang_id' => 'Pemilik Aset',
			'invasetlain_kode' => 'Kode',
			'invasetlain_noregister' => ' No. Register',
			'invasetlain_namabrg' => 'Nama Aset',
			'invasetlain_judulbuku' => 'Judul Buku',
			'invasetlain_spesifikasibuku' => 'Spesifikasi Buku',
			'invasetlain_asalkesenian' => 'Asal Kesenian',
			'invasetlain_jumlah' => 'Jumlah',
			'invasetlain_thncetak' => 'Tahun Cetak',
			'invasetlain_harga' => 'Harga',
			'invasetlain_tglguna' => 'Tanggal Penggunaan',
			'invasetlain_akumsusut' => 'Akumulasi Penyusutan',
			'invasetlain_ket' => 'Keterangan',
			'invasetlain_penciptakesenian' => 'Pencipta Kesenian',
			'invasetlain_bahankesenian' => 'Bahan Kesenian',
			'invasetlain_jenishewan_tum' => 'Jenis Hewan',
			'invasetlain_ukuranhewan_tum' => 'Ukuran Hewan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'tglpenghapusan' => 'Tanggal Penghapusan',
			'tipepenghapusan' => 'Tipe Penghapusan',
		);
	}
			
}
?>
