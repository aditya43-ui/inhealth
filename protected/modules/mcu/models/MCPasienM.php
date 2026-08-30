<?php
/**
 * model ini digunakan untuk meload data ke tabel pasien_m, dan hanya dapat digunakan pada modul medical checkup saja
 * 
 * @package application.modules.mcu
 * @subpackage models
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
class MCPasienM extends PasienM
{
	public $no_pendaftaran;
	public $tgl_pendaftaran;
	public $tgl_admisi;
	public $tgl_rm_awal;
	public $tgl_rm_akhir;
	public $jeniskasuspenyakit_nama;
	public $ceklis;
	public $umur,$thn,$bln,$hr; //untuk pendaftaran.umur
	public $isPasienLama = false;
	public $propinsiNama, $kabupatenNama, $kecamatanNama, $kelurahanNama;
	public $cari_kelurahan_nama, $cari_kecamatan_nama; //filter pencarian
        public $nomorindukpegawai,$nama_pegawai,$pegawai_aktif;
	public $is_update;
	public $no_asuransi_pasien;
        public $gelardepan;
        public $gelarbelakang;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasienM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
     
	/**
	 * untuk menampilkan data pada grid dialog pasien
	 * @return \CActiveDataProvider
	 */
	public function searchDialog()
	{
		$criteria = new CDbCriteria();
		$criteria->join = " LEFT JOIN kecamatan_m ON t.kecamatan_id = kecamatan_m.kecamatan_id
								LEFT JOIN kelurahan_m ON t.kelurahan_id = kelurahan_m.kelurahan_id ";
		$criteria->compare('LOWER(kecamatan_m.kecamatan_nama)',  strtolower($this->cari_kecamatan_nama), true);
		$criteria->compare('LOWER(kelurahan_m.kelurahan_nama)',  strtolower($this->cari_kelurahan_nama), true);
		$criteria->compare('LOWER(pegawai_m.nomorindukpegawai)',  strtolower($this->nomorindukpegawai), true);
		$criteria->compare('LOWER(t.jeniskelamin)',strtolower($this->jeniskelamin), true);
		$criteria->compare('LOWER(t.no_rekam_medik)',  strtolower($this->no_rekam_medik), true);
		$criteria->compare('LOWER(t.nama_pasien)',  strtolower($this->nama_pasien), true);
		$criteria->compare('LOWER(t.nama_bin)',  strtolower($this->nama_bin), true);
		$criteria->compare('LOWER(t.alamat_pasien)',  strtolower($this->alamat_pasien), true);
		$criteria->compare('t.rt',  $this->rt);
		$criteria->compare('t.rw',  $this->rw);
		$criteria->compare('LOWER(kelurahan_m.kelurahan_nama)',  strtolower($this->cari_kelurahan_nama), true);
		$criteria->compare('LOWER(kecamatan_m.kecamatan_nama)',  strtolower($this->cari_kecamatan_nama), true);
		$criteria->compare('LOWER(t.statusrekammedis)',  strtolower($this->statusrekammedis), true);
		$criteria->compare('LOWER(t.norm_lama)',  strtolower($this->norm_lama), true);
		if(!empty($this->tanggal_lahir)){
			$criteria->compare('DATE(t.tanggal_lahir)',$this->tanggal_lahir);
		}
		if($this->ispasienluar){
			$criteria->addCondition('ispasienluar = TRUE');
		}else{
			$criteria->addCondition('ispasienluar = FALSE');
		}
		$criteria->limit=5;
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false,
		));
	}
	
	/**
	 * Mengambil daftar semua propinsi
	 * @return CActiveDataProvider 
	 */
	public function getPropinsiItems()
	{
		return PropinsiM::model()->findAllByAttributes(array('propinsi_aktif'=>true),array('order'=>'propinsi_nama'));
	}
	/**
	 * Mengambil daftar semua kabupaten berdasarkan propinsi
	 * @return CActiveDataProvider 
	 */
	public function getKabupatenItems($propinsi_id=null)
	{
		$criteria = new CDbCriteria();
		if(!empty($propinsi_id)){
			$criteria->addCondition("propinsi_id = ".$propinsi_id); 			
                }else{
                    $criteria->addCondition("kabupaten_id is null "); 			
                }
		$criteria->compare('kabupaten_aktif', true);
		$criteria->order='kabupaten_nama';
		$models = KabupatenM::model()->findAll($criteria);
		return $models;
	}
	/**
	 * Mengambil daftar semua kecamatan berdasarkan kabupaten
	 * @return CActiveDataProvider 
	 */
	public function getKecamatanItems($kabupaten_id=null)
	{
		$criteria = new CDbCriteria();
		if(!empty($kabupaten_id)){
			$criteria->addCondition("kabupaten_id = ".$kabupaten_id); 			
		}else{
                    $criteria->addCondition("kecamatan_id is null "); 			
                }
		$criteria->compare('kecamatan_aktif', true);
		$criteria->order='kecamatan_nama';
		$models = KecamatanM::model()->findAll($criteria);
		return $models;
	}
	/**
	 * Mengambil daftar semua kelurahan berdasarkan kecamatan
	 * @return CActiveDataProvider 
	 */
	public function getKelurahanItems($kecamatan_id=null)
	{
		$criteria = new CDbCriteria();
		if(!empty($kecamatan_id)){
			$criteria->addCondition("kecamatan_id = ".$kecamatan_id); 			
                }else{
                    $criteria->addCondition("kelurahan_id is null "); 			
                }
		$criteria->compare('kelurahan_aktif', true);
		$criteria->order='kelurahan_nama';
		$models = KelurahanM::model()->findAll($criteria);
		return $models;
	}
	/**
	 * Mengambil daftar semua pendidikan
	 * @return CActiveDataProvider 
	 */
	public function getPendidikanItems()
	{
		return PendidikanM::model()->findAllByAttributes(array('pendidikan_aktif'=>true),array('order'=>'pendidikan_nama'));
	}
	/**
	 * Mengambil daftar semua pekerjaan
	 * @return CActiveDataProvider 
	 */
	public function getPekerjaanItems()
	{
		return PekerjaanM::model()->findAllByAttributes(array('pekerjaan_aktif'=>true),array('order'=>'pekerjaan_nama'));
	}
	/**
	 * Mengambil daftar semua propinsi
	 * @return CActiveDataProvider 
	 */
	public function getSukuItems()
	{
		return SukuM::model()->findAllByAttributes(array('suku_aktif'=>true),array('order'=>'suku_nama'));
	}
	/**
	 * function untuk dialog NIP
	 */
	public function searchDialogPegawai()
	{
		$criteria=new CDbCriteria;
		$criteria->join = " LEFT JOIN kecamatan_m ON t.kecamatan_id = kecamatan_m.kecamatan_id
							JOIN pegawai_m ON t.pegawai_id = pegawai_m.pegawai_id
							LEFT JOIN kelurahan_m ON t.kelurahan_id = kelurahan_m.kelurahan_id ";
		$criteria->compare('LOWER(kecamatan_m.kecamatan_nama)',  strtolower($this->cari_kecamatan_nama), true);
		$criteria->compare('LOWER(kelurahan_m.kelurahan_nama)',  strtolower($this->cari_kelurahan_nama), true);
		$criteria->compare('LOWER(pegawai_m.nomorindukpegawai)',  strtolower($this->nomorindukpegawai), true);
		$criteria->compare('LOWER(t.jeniskelamin)',strtolower($this->jeniskelamin), true);
		$criteria->compare('LOWER(t.no_rekam_medik)',  strtolower($this->no_rekam_medik), true);
		$criteria->compare('LOWER(t.nama_pasien)',  strtolower($this->nama_pasien), true);
		$criteria->compare('LOWER(t.nama_bin)',  strtolower($this->nama_bin), true);
		$criteria->compare('LOWER(t.alamat_pasien)',  strtolower($this->alamat_pasien), true);
		$criteria->compare('t.rt',  $this->rt);
		$criteria->compare('t.rw',  $this->rw);
		$criteria->compare('LOWER(kelurahan_m.kelurahan_nama)',  strtolower($this->cari_kelurahan_nama), true);
		$criteria->compare('LOWER(kecamatan_m.kecamatan_nama)',  strtolower($this->cari_kecamatan_nama), true);
		$criteria->compare('LOWER(t.statusrekammedis)',  strtolower($this->statusrekammedis), true);
		$criteria->compare('LOWER(t.norm_lama)',  strtolower($this->norm_lama), true);
		if(!empty($this->tanggal_lahir)){
			$criteria->compare('DATE(t.tanggal_lahir)',$this->tanggal_lahir);
		}
		if($this->ispasienluar){
			$criteria->addCondition('ispasienluar = TRUE');
		}else{
			$criteria->addCondition('ispasienluar = FALSE');
		}
		$criteria->limit=5;
		
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false,
		));
	}
}
