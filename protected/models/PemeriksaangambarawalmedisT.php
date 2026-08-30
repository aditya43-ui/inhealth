<?php

/**
 * This is the model class for table "pemeriksaangambarawalmedis_t".
 * @author     Yusuf Putra Anugrah <yusufputra@.com>
 * @package application.models
 * The followings are the available columns in table 'pemeriksaangambarawalmedis_t':
 * @property integer $pemeriksaangambarawalmedis_id
 * @property integer $gambartubuh_id
 * @property integer $asesmen_awal_medis_id
 * @property integer $bagiantubuh_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property string $tglpemeriksaan
 * @property double $kordinat_tubuh_x
 * @property double $kordinat_tubuh_y
 * @property string $keterangan_periksa_gbr
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property BagiantubuhM $bagiantubuh
 */
class PemeriksaangambarawalmedisT extends CActiveRecord
{
    public $namabagtubuh;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemeriksaangambarawalmedisT the static model class
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
		return 'pemeriksaangambarawalmedis_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('gambartubuh_id, asesmen_awal_medis_id, bagiantubuh_id, pendaftaran_id, pasien_id, tglpemeriksaan, kordinat_tubuh_x, kordinat_tubuh_y, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('gambartubuh_id, asesmen_awal_medis_id, bagiantubuh_id, pendaftaran_id, pasien_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('kordinat_tubuh_x, kordinat_tubuh_y', 'numerical'),
			array('keterangan_periksa_gbr, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pemeriksaangambarawalmedis_id, gambartubuh_id, asesmen_awal_medis_id, bagiantubuh_id, pendaftaran_id, pasien_id, tglpemeriksaan, kordinat_tubuh_x, kordinat_tubuh_y, keterangan_periksa_gbr, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'bagiantubuh' => array(self::BELONGS_TO, 'BagiantubuhM', 'bagiantubuh_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pemeriksaangambarawalmedis_id' => 'Pemeriksaangambarawalmedis',
			'gambartubuh_id' => 'Gambartubuh',
			'asesmen_awal_medis_id' => 'Asesmen Awal Medis',
			'bagiantubuh_id' => 'Bagiantubuh',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'tglpemeriksaan' => 'Tglpemeriksaan',
			'kordinat_tubuh_x' => 'Kordinat Tubuh X',
			'kordinat_tubuh_y' => 'Kordinat Tubuh Y',
			'keterangan_periksa_gbr' => 'Keterangan Periksa Gbr',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
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

		if(!empty($this->pemeriksaangambarawalmedis_id)){
			$criteria->addCondition('pemeriksaangambarawalmedis_id = '.$this->pemeriksaangambarawalmedis_id);
		}
		if(!empty($this->gambartubuh_id)){
			$criteria->addCondition('gambartubuh_id = '.$this->gambartubuh_id);
		}
		if(!empty($this->asesmen_awal_medis_id)){
			$criteria->addCondition('asesmen_awal_medis_id = '.$this->asesmen_awal_medis_id);
		}
		if(!empty($this->bagiantubuh_id)){
			$criteria->addCondition('bagiantubuh_id = '.$this->bagiantubuh_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		$criteria->compare('LOWER(tglpemeriksaan)',strtolower($this->tglpemeriksaan),true);
		$criteria->compare('kordinat_tubuh_x',$this->kordinat_tubuh_x);
		$criteria->compare('kordinat_tubuh_y',$this->kordinat_tubuh_y);
		$criteria->compare('LOWER(keterangan_periksa_gbr)',strtolower($this->keterangan_periksa_gbr),true);
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