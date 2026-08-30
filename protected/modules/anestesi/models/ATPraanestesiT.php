<?php

/**
 * This is the model class for table "praanestesi_t".
 *
 * The followings are the available columns in table 'praanestesi_t':
 * @property integer $praanestesi_id
 * @property integer $pasienanastesi_id
 * @property integer $ruangan_id
 * @property integer $kamarruangan_id
 * @property integer $anamesa_id
 * @property integer $pemeriksaanfisik_id
 * @property integer $hasilpemeriksaanlab_id
 * @property string $nopraanestesi
 * @property string $tglpraanestesi
 * @property integer $dokter_id
 * @property integer $perawat1_id
 * @property integer $perawat2_id
 * @property string $tglpuasa
 * @property string $tekniksedasi
 * @property string $ketpraanestesi
 * @property integer $instalasipasca_id
 * @property integer $ruanganpasca_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property TindakananestesiT[] $tindakananestesiTs
 * @property ObatalkesanestesiT[] $obatalkesanestesiTs
 * @property PasienanastesiT $pasienanastesi
 * @property RuanganM $ruangan
 * @property KamarruanganM $kamarruangan
 * @property AnamnesaT $anamesa
 * @property PemeriksaanfisikT $pemeriksaanfisik
 * @property HasilpemeriksaanlabT $hasilpemeriksaanlab
 * @property PegawaiM $dokter
 * @property PegawaiM $perawat1
 * @property PegawaiM $perawat2
 * @property InstalasiM $instalasipasca
 * @property RuanganM $ruanganpasca
 * @property IntraanestesiT[] $intraanestesiTs
 */
class ATPraanestesiT extends PraanestesiT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PraanestesiT the static model class
	 */
	public $no_rekam_medik,$nama_pasien,$jeniskelamin,$umur;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'praanestesi_id' => 'Pra Anestesi',
			'pasienanastesi_id' => 'Pasien Anestesi',
			'ruangan_id' => 'Ruangan',
			'kamarruangan_id' => 'Kamar Ruangan',
			'anamesa_id' => 'Anamesa',
			'pemeriksaanfisik_id' => 'Pemeriksaan Fisik',
			'hasilpemeriksaanlab_id' => 'Hasil Pemeriksaan Lab',
			'nopraanestesi' => 'No. Pra Anestesi',
			'tglpraanestesi' => 'Tanggal Pra Anestesi',
			'dokter_id' => 'Dokter Anestesi',
			'perawat1_id' => 'Perawat Anestesi 1',
			'perawat2_id' => 'Perawat Anestesi 2',
			'tglpuasa' => 'Tanggal Puasa',
			'tekniksedasi' => 'Teknik Sedasi',
			'ketpraanestesi' => 'Keterangan Rencana',
			'instalasipasca_id' => 'Instalasi Pasca',
			'ruanganpasca_id' => 'Ruangan Pasca',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'monitoring' => 'Monitoring',
		);
	}
	
	public function getDokterItems()
	{
	    $criteria = new CDbCriteria;
	    $criteria->join = 'LEFT JOIN pegawai_m ON pegawai_m.pegawai_id = t.pegawai_id LEFT JOIN kelompokpegawai_m ON kelompokpegawai_m.kelompokpegawai_id = pegawai_m.kelompokpegawai_id';
	    $ruangan_id = Yii::app()->user->getState('ruangan_id');
	    $criteria->addCondition('t.ruangan_id='.$ruangan_id);
	    $dokter = Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK;
	    $criteria->addCondition('kelompokpegawai_m.kelompokpegawai_id='.$dokter);
	    
	    return RuanganpegawaiM::model()->findAll($criteria);
	}
	
	public function getParamedisItems()
	{
	    $criteria = new CDbCriteria;
	    $criteria->join = 'LEFT JOIN pegawai_m ON pegawai_m.pegawai_id = t.pegawai_id LEFT JOIN kelompokpegawai_m ON kelompokpegawai_m.kelompokpegawai_id = pegawai_m.kelompokpegawai_id';
	    $ruangan_id = Yii::app()->user->getState('ruangan_id');
	    $criteria->addCondition('t.ruangan_id='.$ruangan_id);
	    $paramedis = Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN;
	    $criteria->addCondition('kelompokpegawai_m.kelompokpegawai_id='.$paramedis);
	    
	    return RuanganpegawaiM::model()->findAll($criteria);
	}
	public function getTypeAnestesiItems()
	{
	    $criteria = new CDbCriteria;
	    $criteria->addCondition('typeanastesi_aktif is TRUE');
		
	    return TypeanastesiM::model()->findAll($criteria);
	}
	public function getInstalasiItems()
	{
	    $criteria = new CDbCriteria;
	    $criteria->addCondition('instalasi_aktif is TRUE');
		
	    return InstalasiM::model()->findAll($criteria);
	}
	
	public function getRuanganItems()
	{
	    $criteria = new CDbCriteria;
	    $criteria->addCondition('ruangan_aktif is TRUE');
		
	    return RuanganM::model()->findAll($criteria);
	}
	public function getRuanganInstalasiItems($instalasi_id = null)
	{
	    if(!empty($instalasi_id)){
			$criteria = new CDbCriteria;
			$criteria->addCondition('instalasi_id ='.$instalasi_id);
			$criteria->addCondition('ruangan_aktif is TRUE');

			return RuanganM::model()->findAll($criteria);
		}else{
			return array();
		}
	}
	public function getKamarruanganItems()
	{
	    $criteria = new CDbCriteria;
	    $criteria->addCondition('kamarruangan_aktif is TRUE');
		
	    return KamarruanganM::model()->findAll($criteria);
	}
	
	/**
	* kriteria pencarian untuk dashboard
	* @return \CActiveDataProvider
	*/
	public function searchDashboard()
	{
	   // Warning: Please modify the following code to remove attributes that
	   // should not be searched.

	   $criteria=new CDbCriteria;
	   $criteria->select = 't.nopraanestesi, t.tglpraanestesi, pasien_m.no_rekam_medik, pasien_m.nama_pasien, pasien_m.jeniskelamin, pendaftaran_t.umur';
	   $criteria->join = 'JOIN pasienanastesi_t ON t.pasienanastesi_id=pasienanastesi_t.pasienanastesi_id';
	   $criteria->join .= ' JOIN pendaftaran_t ON pasienanastesi_t.pendaftaran_id=pendaftaran_t.pendaftaran_id';
	   $criteria->join .= ' JOIN pasien_m ON pendaftaran_t.pasien_id=pasien_m.pasien_id';
	   $criteria->group = 't.nopraanestesi, t.tglpraanestesi, pasien_m.no_rekam_medik, pasien_m.nama_pasien, pasien_m.jeniskelamin, pendaftaran_t.umur';
	   $criteria->order = 'tglpraanestesi DESC';
	   $criteria->limit = 10;
	   return new CActiveDataProvider($this, array(
		   'criteria'=>$criteria,
		   'pagination'=>false
	   ));
	}
}