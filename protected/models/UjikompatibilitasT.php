<?php

/**
 * This is the model class for table "ujikompatibilitas_t".
 * @author Rusdiyanto <rusdiyanto@.com>
 * @package application.modules.bankDarah
 * @subpackage models
 * The followings are the available columns in table 'ujikompatibilitas_t':
 * @property integer $ujikompatibilitas_id
 * @property string $tglujikompabilitas
 * @property integer $peg_pemeriksa_id
 * @property integer $ruang_periksa
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $ujidarahpasien_id
 * @property integer $stokkantongdarah_id
 * @property string $nomorbarcode
 * @property integer $pengujiandarah_id
 * @property string $ujikomp_mayor
 * @property string $ujikomp_minor
 * @property string $ujikomp_autokontrol
 * @property string $ujikomp_dct
 * @property string $ujikomp_kesimpulan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class UjikompatibilitasT extends CActiveRecord
{
    public $singkatan_komp;
    public $nama_penguji;
    public $nama_jenis;
    public $peg_referal_id;
    public $peg_pelabelan;
    public $tgl_referal;
    public $tglpelabelan;
    public $tglpenyiapandarah;
    public $peg_penerimapermintaan_id;
    public $anti_a, $anti_b, $anti_ab, $anti_d, $sel_a, $sel_b, $sel_o, $ket_hasiluji;    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UjikompatibilitasT the static model class
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
		return 'ujikompatibilitas_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglujikompabilitas, peg_pemeriksa_id, ruang_periksa, pasien_id, pendaftaran_id, ujidarahpasien_id, stokkantongdarah_id, nomorbarcode, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('peg_pemeriksa_id, ruang_periksa, pasien_id, pendaftaran_id, ujidarahpasien_id, stokkantongdarah_id, pengujiandarah_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('nomorbarcode', 'length', 'max'=>100),
			array('ujikomp_mayor1, ujikomp_minor1, ujikomp_autokontrol, ujikomp_dct', 'length', 'max'=>50),
			array('ujikomp_kesimpulan', 'length', 'max'=>255),
			array('ujikompatibilitas_ke, update_time,permintaandarahdet_id, pengujiandarah_id, ujikomp_mayor, ujikomp_minor, ujikomp_autokontrol', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ujikompatibilitas_id, tglujikompabilitas, peg_pemeriksa_id, ruang_periksa, pasien_id, pendaftaran_id, ujidarahpasien_id, stokkantongdarah_id, nomorbarcode, pengujiandarah_id, ujikomp_mayor, ujikomp_minor, ujikomp_autokontrol, ujikomp_dct, ujikomp_kesimpulan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'stokkantong' => array(self::BELONGS_TO,'StokkantongdarahT','stokkantongdarah_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ujikompatibilitas_id' => 'Ujikompatibilitas',
			'tglujikompabilitas' => 'Tglujikompabilitas',
			'peg_pemeriksa_id' => 'Peg Pemeriksa',
			'ruang_periksa' => 'Ruang Periksa',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'ujidarahpasien_id' => 'Ujidarahpasien',
			'stokkantongdarah_id' => 'Stokkantongdarah',
			'nomorbarcode' => 'Nomorbarcode',
			'pengujiandarah_id' => 'Pengujiandarah',
			'ujikomp_mayor' => 'Ujikomp Mayor',
			'ujikomp_minor' => 'Ujikomp Minor',
			'ujikomp_autokontrol' => 'Ujikomp Autokontrol',
			'ujikomp_dct' => 'Ujikomp Dct',
			'ujikomp_kesimpulan' => 'Ujikomp Kesimpulan',
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

		if(!empty($this->ujikompatibilitas_id)){
			$criteria->addCondition('ujikompatibilitas_id = '.$this->ujikompatibilitas_id);
		}
		$criteria->compare('LOWER(tglujikompabilitas)',strtolower($this->tglujikompabilitas),true);
		if(!empty($this->peg_pemeriksa_id)){
			$criteria->addCondition('peg_pemeriksa_id = '.$this->peg_pemeriksa_id);
		}
		if(!empty($this->ruang_periksa)){
			$criteria->addCondition('ruang_periksa = '.$this->ruang_periksa);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->ujidarahpasien_id)){
			$criteria->addCondition('ujidarahpasien_id = '.$this->ujidarahpasien_id);
		}
		if(!empty($this->stokkantongdarah_id)){
			$criteria->addCondition('stokkantongdarah_id = '.$this->stokkantongdarah_id);
		}
		$criteria->compare('LOWER(nomorbarcode)',strtolower($this->nomorbarcode),true);
		if(!empty($this->pengujiandarah_id)){
			$criteria->addCondition('pengujiandarah_id = '.$this->pengujiandarah_id);
		}
		$criteria->compare('LOWER(ujikomp_mayor)',strtolower($this->ujikomp_mayor),true);
		$criteria->compare('LOWER(ujikomp_minor)',strtolower($this->ujikomp_minor),true);
		$criteria->compare('LOWER(ujikomp_autokontrol)',strtolower($this->ujikomp_autokontrol),true);
		$criteria->compare('LOWER(ujikomp_dct)',strtolower($this->ujikomp_dct),true);
		$criteria->compare('LOWER(ujikomp_kesimpulan)',strtolower($this->ujikomp_kesimpulan),true);
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

        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
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