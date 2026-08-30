<?php

/**
 * This is the model class for table "laporanpasiendbd_v".
 *
 * The followings are the available columns in table 'laporanpasiendbd_v':
 * @property integer $pasienmorbiditas_id
 * @property integer $pendaftaran_id
 * @property string $tgl_pendaftaran
 * @property string $no_pendaftaran
 * @property string $no_rekam_medik
 * @property integer $pasien_id
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $alamat_pasien
 * @property string $umur
 * @property string $diagnosa_nama
 * @property string $diagnosa_kode
 * @property integer $pasienmasukpenunjang_id
 * @property integer $pasienkirimkeunitlain_id
 * @property integer $jeniskasuspenyakit_id
 * @property integer $pasienadmisi_id
 * @property string $no_masukpenunjang
 * @property double $tahun
 * @property double $bulan
 * @property string $tglmasukpenunjang
 * @property string $total_trombosit
 * @property string $total_hematokrit
 */
class LaporanpasiendbdV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanpasiendbdV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'laporanpasiendbd_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasienmorbiditas_id, pendaftaran_id, pasien_id, pasienmasukpenunjang_id, pasienkirimkeunitlain_id, jeniskasuspenyakit_id, pasienadmisi_id', 'numerical', 'integerOnly'=>true),
			array('tahun, bulan', 'numerical'),
			array('no_pendaftaran, namadepan, no_masukpenunjang', 'length', 'max'=>20),
			array('no_rekam_medik, diagnosa_kode', 'length', 'max'=>10),
			array('nama_pasien', 'length', 'max'=>50),
			array('umur', 'length', 'max'=>30),
			array('diagnosa_nama', 'length', 'max'=>200),
			array('tgl_pendaftaran, alamat_pasien, tglmasukpenunjang, total_trombosit, total_hematokrit', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasienmorbiditas_id, pendaftaran_id, tgl_pendaftaran, no_pendaftaran, no_rekam_medik, pasien_id, namadepan, nama_pasien, alamat_pasien, umur, diagnosa_nama, diagnosa_kode, pasienmasukpenunjang_id, pasienkirimkeunitlain_id, jeniskasuspenyakit_id, pasienadmisi_id, no_masukpenunjang, tahun, bulan, tglmasukpenunjang, total_trombosit, total_hematokrit', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pasienmorbiditas_id' => 'Pasienmorbiditas',
			'pendaftaran_id' => 'Pendaftaran',
			'tgl_pendaftaran' => 'Tgl. Masuk',
			'no_pendaftaran' => 'No. Pendaftaran',
			'no_rekam_medik' => 'No. Rekam Medik',
			'pasien_id' => 'Pasien',
			'namadepan' => 'Namadepan',
			'nama_pasien' => 'Nama Pasien',
			'alamat_pasien' => 'Alamat Pasien',
			'umur' => 'Umur',
			'diagnosa_nama' => 'Diagnosa Nama',
			'diagnosa_kode' => 'Diagnosa Kode',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'pasienkirimkeunitlain_id' => 'Pasienkirimkeunitlain',
			'jeniskasuspenyakit_id' => 'Jeniskasuspenyakit',
			'pasienadmisi_id' => 'Pasienadmisi',
			'no_masukpenunjang' => 'No Masukpenunjang',
			'tahun' => 'Tahun',
			'bulan' => 'Bulan',
			'tglmasukpenunjang' => 'Tgl. Pemeriksaan',
			'total_trombosit' => 'Trombosit',
			'total_hematokrit' => 'Hematokrit',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('pasienmorbiditas_id',$this->pasienmorbiditas_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('namadepan',$this->namadepan,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('alamat_pasien',$this->alamat_pasien,true);
		$criteria->compare('umur',$this->umur,true);
		$criteria->compare('diagnosa_nama',$this->diagnosa_nama,true);
		$criteria->compare('diagnosa_kode',$this->diagnosa_kode,true);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('pasienkirimkeunitlain_id',$this->pasienkirimkeunitlain_id);
		$criteria->compare('jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('no_masukpenunjang',$this->no_masukpenunjang,true);
		$criteria->compare('tahun',$this->tahun);
		$criteria->compare('bulan',$this->bulan);
		$criteria->compare('tglmasukpenunjang',$this->tglmasukpenunjang,true);
		$criteria->compare('total_trombosit',$this->total_trombosit,true);
		$criteria->compare('total_hematokrit',$this->total_hematokrit,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('pasienmorbiditas_id',$this->pasienmorbiditas_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('namadepan',$this->namadepan,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('alamat_pasien',$this->alamat_pasien,true);
		$criteria->compare('umur',$this->umur,true);
		$criteria->compare('diagnosa_nama',$this->diagnosa_nama,true);
		$criteria->compare('diagnosa_kode',$this->diagnosa_kode,true);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('pasienkirimkeunitlain_id',$this->pasienkirimkeunitlain_id);
		$criteria->compare('jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('no_masukpenunjang',$this->no_masukpenunjang,true);
		$criteria->compare('tahun',$this->tahun);
		$criteria->compare('bulan',$this->bulan);
		$criteria->compare('tglmasukpenunjang',$this->tglmasukpenunjang,true);
		$criteria->compare('total_trombosit',$this->total_trombosit,true);
		$criteria->compare('total_hematokrit',$this->total_hematokrit,true);
		$criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false
		));
	}
	
	/**
	 * - digunakan untuk mengenerate data di tabel  target bep
	 * @return \CActiveDataProvider
	 */
	public function searchTable(){
		$criteria = $this->searchCriteria();		
		//$criteria->group = " pendaftaran_id, instalasi_id, jeniskelamin";
		$criteria->order = " tglmasukpenunjang ASC ";
		 return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}

	/**
	 * - digunakan untuk mengenerate data di tabel  target bep  pada prinout
	 * @return \CActiveDataProvider
	 */
	public function searchTablePrint(){
		$criteria = $this->searchCriteria();
	
		//$criteria->group = " pendaftaran_id";
		$criteria->order = " tglmasukpenunjang ASC ";
		$criteria->limit = -1;

		 return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination' => false
		));
	}

	/**
	 * - digunakan untuk mengenerate data target bep dalam bentuk grafik
	 * @return \CActiveDataProvider
	 */
	public function searchGrafik(){
		
        $profil = ProfilrumahsakitM::model()->find();
		
		$criteria = $this->searchCriteria();
		$criteria->select = " count(alatmedis_id) as pendaftaran_id, '".$profil->nama_rumahsakit."' as data ";
		$criteria->group = " data ";
		$criteria->order = " jumlah DESC ";
		

		 return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,                    
		));
	}

	/**
	 * - digunakan untuk memfilter datanya berdasarkan pencarian yang ada
	 * @return \CActiveDataProvider
	 */
	public function searchCriteria(){
		$criteria = new CDbCriteria();
		$criteria->addBetweenCondition('DATE(tglmasukpenunjang)', date('Y-m-01', strtotime($this->tahun.'-'.$this->bulan.'-01')), date('Y-m-t', strtotime($this->tahun.'-'.$this->bulan.'-01')));
		//$criteria->compare('LOWER(alatmedis_nama)', strtolower($this->nama_pasien),true);
		

		return $criteria;
	}
}