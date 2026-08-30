<?php

/**
 * This is the model class for table "laporanindikatordokter_v".
 *
 * The followings are the available columns in table 'laporanindikatordokter_v':
 * @property integer $ubahdokter_id
 * @property integer $pendaftaran_id
 * @property string $tgl_pendaftaran
 * @property string $no_pendaftaran
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property integer $pegawai_id
 * @property string $nobadge
 * @property string $jenisidentitas
 * @property string $no_identitas_pasien
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $jeniskelamin
 * @property string $tempat_lahir
 * @property string $alamat_pasien
 * @property integer $dokterlama_id
 * @property string $dokterlama_nobadge
 * @property string $dokterlama_jenisidentitas
 * @property string $dokterlama_noidentitas
 * @property string $dokterlama_gelardepan
 * @property string $dokterlama_nama
 * @property string $dokterlama_gelarbelakang
 * @property integer $dokterbaru_id
 * @property string $dokterbaru_nobadge
 * @property string $dokterbaru_jenisidentitas
 * @property string $dokterbaru_noidentitas
 * @property string $dokterbaru_gelardepan
 * @property string $dokterbaru_nama
 * @property string $dokterbaru_gelarbelakang
 * @property string $tglubahdokter
 * @property string $alasanperubahandokter
 * @property string $keterangan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class LaporanindikatordokterV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanindikatordokterV the static model class
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
		return 'laporanindikatordokter_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ubahdokter_id, pendaftaran_id, pasien_id, pegawai_id, dokterlama_id, dokterbaru_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('no_pendaftaran, jenisidentitas, namadepan, jeniskelamin, dokterlama_jenisidentitas, dokterbaru_jenisidentitas', 'length', 'max'=>20),
			array('no_rekam_medik, dokterlama_gelardepan, dokterbaru_gelardepan', 'length', 'max'=>10),
			array('nobadge, no_identitas_pasien, dokterlama_nobadge, dokterbaru_nobadge', 'length', 'max'=>30),
			array('nama_pasien, dokterlama_nama, dokterbaru_nama', 'length', 'max'=>50),
			array('tempat_lahir', 'length', 'max'=>25),
			array('dokterlama_noidentitas, dokterbaru_noidentitas', 'length', 'max'=>100),
			array('dokterlama_gelarbelakang, dokterbaru_gelarbelakang', 'length', 'max'=>15),
			array('alasanperubahandokter', 'length', 'max'=>200),
			array('tgl_pendaftaran, alamat_pasien, tglubahdokter, keterangan, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ubahdokter_id, pendaftaran_id, tgl_pendaftaran, no_pendaftaran, pasien_id, no_rekam_medik, pegawai_id, nobadge, jenisidentitas, no_identitas_pasien, namadepan, nama_pasien, jeniskelamin, tempat_lahir, alamat_pasien, dokterlama_id, dokterlama_nobadge, dokterlama_jenisidentitas, dokterlama_noidentitas, dokterlama_gelardepan, dokterlama_nama, dokterlama_gelarbelakang, dokterbaru_id, dokterbaru_nobadge, dokterbaru_jenisidentitas, dokterbaru_noidentitas, dokterbaru_gelardepan, dokterbaru_nama, dokterbaru_gelarbelakang, tglubahdokter, alasanperubahandokter, keterangan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'ubahdokter_id' => 'Ubahdokter',
			'pendaftaran_id' => 'Pendaftaran',
			'tgl_pendaftaran' => 'Tgl. Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'pasien_id' => 'Pasien',
			'no_rekam_medik' => 'No. Rekam Medik',
			'pegawai_id' => 'Pegawai',
			'nobadge' => 'Nobadge',
			'jenisidentitas' => 'Jenisidentitas',
			'no_identitas_pasien' => 'No Identitas Pasien',
			'namadepan' => 'Namadepan',
			'nama_pasien' => 'Nama Pasien',
			'jeniskelamin' => 'Jenis Kelamin',
			'tempat_lahir' => 'Tempat Lahir',
			'alamat_pasien' => 'Alamat Pasien',
			'dokterlama_id' => 'Dokterlama',
			'dokterlama_nobadge' => 'Dokterlama Nobadge',
			'dokterlama_jenisidentitas' => 'Dokterlama Jenisidentitas',
			'dokterlama_noidentitas' => 'Dokterlama Noidentitas',
			'dokterlama_gelardepan' => 'Dokterlama Gelardepan',
			'dokterlama_nama' => 'Dokterlama Nama',
			'dokterlama_gelarbelakang' => 'Dokterlama Gelarbelakang',
			'dokterbaru_id' => 'Dokterbaru',
			'dokterbaru_nobadge' => 'Dokterbaru Nobadge',
			'dokterbaru_jenisidentitas' => 'Dokterbaru Jenisidentitas',
			'dokterbaru_noidentitas' => 'Dokterbaru Noidentitas',
			'dokterbaru_gelardepan' => 'Dokterbaru Gelardepan',
			'dokterbaru_nama' => 'Dokterbaru Nama',
			'dokterbaru_gelarbelakang' => 'Dokterbaru Gelarbelakang',
			'tglubahdokter' => 'Tglubahdokter',
			'alasanperubahandokter' => 'Alasanperubahandokter',
			'keterangan' => 'Keterangan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->ubahdokter_id)){
			$criteria->addCondition('ubahdokter_id = '.$this->ubahdokter_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		$criteria->compare('LOWER(nobadge)',strtolower($this->nobadge),true);
		$criteria->compare('LOWER(jenisidentitas)',strtolower($this->jenisidentitas),true);
		$criteria->compare('LOWER(no_identitas_pasien)',strtolower($this->no_identitas_pasien),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		if(!empty($this->dokterlama_id)){
			$criteria->addCondition('dokterlama_id = '.$this->dokterlama_id);
		}
		$criteria->compare('LOWER(dokterlama_nobadge)',strtolower($this->dokterlama_nobadge),true);
		$criteria->compare('LOWER(dokterlama_jenisidentitas)',strtolower($this->dokterlama_jenisidentitas),true);
		$criteria->compare('LOWER(dokterlama_noidentitas)',strtolower($this->dokterlama_noidentitas),true);
		$criteria->compare('LOWER(dokterlama_gelardepan)',strtolower($this->dokterlama_gelardepan),true);
		$criteria->compare('LOWER(dokterlama_nama)',strtolower($this->dokterlama_nama),true);
		$criteria->compare('LOWER(dokterlama_gelarbelakang)',strtolower($this->dokterlama_gelarbelakang),true);
		if(!empty($this->dokterbaru_id)){
			$criteria->addCondition('dokterbaru_id = '.$this->dokterbaru_id);
		}
		$criteria->compare('LOWER(dokterbaru_nobadge)',strtolower($this->dokterbaru_nobadge),true);
		$criteria->compare('LOWER(dokterbaru_jenisidentitas)',strtolower($this->dokterbaru_jenisidentitas),true);
		$criteria->compare('LOWER(dokterbaru_noidentitas)',strtolower($this->dokterbaru_noidentitas),true);
		$criteria->compare('LOWER(dokterbaru_gelardepan)',strtolower($this->dokterbaru_gelardepan),true);
		$criteria->compare('LOWER(dokterbaru_nama)',strtolower($this->dokterbaru_nama),true);
		$criteria->compare('LOWER(dokterbaru_gelarbelakang)',strtolower($this->dokterbaru_gelarbelakang),true);
		$criteria->compare('LOWER(tglubahdokter)',strtolower($this->tglubahdokter),true);
		$criteria->compare('LOWER(alasanperubahandokter)',strtolower($this->alasanperubahandokter),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
		}

		return $criteria;
	}
        
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function search()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }


        public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
}