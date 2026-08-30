<?php

/**
 * This is the model class for table "verifikasiberkasmcu_t".
 *
 * The followings are the available columns in table 'verifikasiberkasmcu_t':
 * @property integer $verifikasiberkasmcu_id
 * @property integer $ruangan_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property string $noverifkasiberkasmcu
 * @property string $tglverifikasiberkasmcu
 * @property string $nosurat_rs
 * @property string $tglsurat_rs
 * @property string $statusverifikasiberkas
 * @property string $tglberkasmcumasuk
 * @property string $tglberkasdikembalikan
 * @property string $namarumahsakit
 * @property integer $petugasverifikasi_id
 * @property string $tgljatuhtempo
 * @property double $totaltagihanmcu
 * @property string $berkas_1
 * @property string $berkas_2
 * @property string $berkas_3
 * @property string $berkas_4
 * @property string $berkas_5
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class VerifikasiberkasmcuT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VerifikasiberkasmcuT the static model class
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
		return 'verifikasiberkasmcu_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, pasien_id, pendaftaran_id, noverifkasiberkasmcu, tglverifikasiberkasmcu, nosurat_rs, tglsurat_rs, tglberkasmcumasuk, totaltagihanmcu, create_loginpemakai_id, create_ruangan', 'required'),
			array('ruangan_id, pasien_id, pendaftaran_id, petugasverifikasi_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('totaltagihanmcu', 'numerical'),
			array('noverifkasiberkasmcu', 'length', 'max'=>20),
			array('nosurat_rs, namarumahsakit', 'length', 'max'=>50),
			array('statusverifikasiberkas', 'length', 'max'=>30),
			array('berkas_1, berkas_2, berkas_3, berkas_4, berkas_5', 'length', 'max'=>200),
			array('tglberkasdikembalikan, tgljatuhtempo, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('verifikasiberkasmcu_id, ruangan_id, pasien_id, pendaftaran_id, noverifkasiberkasmcu, tglverifikasiberkasmcu, nosurat_rs, tglsurat_rs, statusverifikasiberkas, tglberkasmcumasuk, tglberkasdikembalikan, namarumahsakit, petugasverifikasi_id, tgljatuhtempo, totaltagihanmcu, berkas_1, berkas_2, berkas_3, berkas_4, berkas_5, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'verifikasiberkasmcu_id' => 'ID Verifikasi Berkas MCU',
			'ruangan_id' => 'Ruangan',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'noverifkasiberkasmcu' => 'No. Verifikasi Berkas',
			'tglverifikasiberkasmcu' => 'Tanggal Verifikasi Berkas',
			'nosurat_rs' => 'No. Surat RS',
			'tglsurat_rs' => 'Tanggal Surat RS',
			'statusverifikasiberkas' => 'Status Berkas',
			'tglberkasmcumasuk' => 'Tanggal Berkas Masuk',
			'tglberkasdikembalikan' => 'Tanggal Berkas Dikembalikan',
			'namarumahsakit' => 'Nama Rumah Sakit',
			'petugasverifikasi_id' => 'Petugas Verifikasi',
			'tgljatuhtempo' => 'Tanggal Jatuh Tempo',
			'totaltagihanmcu' => 'Total Tagihan MCU',
			'berkas_1' => 'Berkas 1',
			'berkas_2' => 'Berkas 2',
			'berkas_3' => 'Berkas 3',
			'berkas_4' => 'Berkas 4',
			'berkas_5' => 'Berkas 5',
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

		if(!empty($this->verifikasiberkasmcu_id)){
			$criteria->addCondition('verifikasiberkasmcu_id = '.$this->verifikasiberkasmcu_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		$criteria->compare('LOWER(noverifkasiberkasmcu)',strtolower($this->noverifkasiberkasmcu),true);
		$criteria->compare('LOWER(tglverifikasiberkasmcu)',strtolower($this->tglverifikasiberkasmcu),true);
		$criteria->compare('LOWER(nosurat_rs)',strtolower($this->nosurat_rs),true);
		$criteria->compare('LOWER(tglsurat_rs)',strtolower($this->tglsurat_rs),true);
		$criteria->compare('LOWER(statusverifikasiberkas)',strtolower($this->statusverifikasiberkas),true);
		$criteria->compare('LOWER(tglberkasmcumasuk)',strtolower($this->tglberkasmcumasuk),true);
		$criteria->compare('LOWER(tglberkasdikembalikan)',strtolower($this->tglberkasdikembalikan),true);
		$criteria->compare('LOWER(namarumahsakit)',strtolower($this->namarumahsakit),true);
		if(!empty($this->petugasverifikasi_id)){
			$criteria->addCondition('petugasverifikasi_id = '.$this->petugasverifikasi_id);
		}
		$criteria->compare('LOWER(tgljatuhtempo)',strtolower($this->tgljatuhtempo),true);
		$criteria->compare('totaltagihanmcu',$this->totaltagihanmcu);
		$criteria->compare('LOWER(berkas_1)',strtolower($this->berkas_1),true);
		$criteria->compare('LOWER(berkas_2)',strtolower($this->berkas_2),true);
		$criteria->compare('LOWER(berkas_3)',strtolower($this->berkas_3),true);
		$criteria->compare('LOWER(berkas_4)',strtolower($this->berkas_4),true);
		$criteria->compare('LOWER(berkas_5)',strtolower($this->berkas_5),true);
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