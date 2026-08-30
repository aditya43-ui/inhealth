<?php

/**
 * This is the model class for table "intraanestesi_t".
 *
 * The followings are the available columns in table 'intraanestesi_t':
 * @property integer $intraanestesi_id
 * @property integer $pasienanastesi_id
 * @property integer $praanestesi_id
 * @property integer $ruangan_id
 * @property integer $kamarruangan_id
 * @property string $nointraanestesi
 * @property string $tglintraanestesi
 * @property integer $dokter_id
 * @property integer $perawat1_id
 * @property integer $perawat2_id
 * @property string $tekniksedasi
 * @property string $tglpuasa
 * @property boolean $isdarurat
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property TindakananestesiT[] $tindakananestesiTs
 * @property KondisipasienanestesiT[] $kondisipasienanestesiTs
 * @property ObatalkesanestesiT[] $obatalkesanestesiTs
 * @property PasienanastesiT $pasienanastesi
 * @property PraanestesiT $praanestesi
 * @property RuanganM $ruangan
 * @property KamarruanganM $kamarruangan
 * @property PegawaiM $dokter
 * @property PegawaiM $perawat1
 * @property PegawaiM $perawat2
 * @property PascaanestesiT[] $pascaanestesiTs
 */
class IntraanestesiT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return IntraanestesiT the static model class
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
		return 'intraanestesi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasienanastesi_id, ruangan_id, nointraanestesi, tglintraanestesi, dokter_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pasienanastesi_id, praanestesi_id, ruangan_id, kamarruangan_id, dokter_id, perawat1_id, perawat2_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('nointraanestesi, tekniksedasi', 'length', 'max'=>20),
			array('tglpuasa, isdarurat, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('intraanestesi_id, pasienanastesi_id, praanestesi_id, ruangan_id, kamarruangan_id, nointraanestesi, tglintraanestesi, dokter_id, perawat1_id, perawat2_id, tekniksedasi, tglpuasa, isdarurat, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'tindakananestesiTs' => array(self::HAS_MANY, 'TindakananestesiT', 'intraanestesi_id'),
			'kondisipasienanestesiTs' => array(self::HAS_MANY, 'KondisipasienanestesiT', 'intraanestesi_id'),
			'obatalkesanestesiTs' => array(self::HAS_MANY, 'ObatalkesanestesiT', 'intraanestesi_id'),
			'pasienanastesi' => array(self::BELONGS_TO, 'PasienanastesiT', 'pasienanastesi_id'),
			'praanestesi' => array(self::BELONGS_TO, 'PraanestesiT', 'praanestesi_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
			'kamarruangan' => array(self::BELONGS_TO, 'KamarruanganM', 'kamarruangan_id'),
			'dokter' => array(self::BELONGS_TO, 'PegawaiM', 'dokter_id'),
			'perawat1' => array(self::BELONGS_TO, 'PegawaiM', 'perawat1_id'),
			'perawat2' => array(self::BELONGS_TO, 'PegawaiM', 'perawat2_id'),
			'pascaanestesiTs' => array(self::HAS_MANY, 'PascaanestesiT', 'intraanestesi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'intraanestesi_id' => 'Intra Anestesia',
			'pasienanastesi_id' => 'Pasien Anestesia',
			'praanestesi_id' => 'Pra Anestesia',
			'ruangan_id' => 'Ruangan',
			'kamarruangan_id' => 'Kamar Ruangan',
			'nointraanestesi' => 'No. Intra Anestesia',
			'tglintraanestesi' => 'Tgl. Intra Anestesia',
			'dokter_id' => 'Dokter Anestesia',
			'perawat1_id' => 'Perawat Anestesia 1',
			'perawat2_id' => 'Perawat Anestesia 2',
			'tekniksedasi' => 'Teknik Sedasi',
			'tglpuasa' => 'Tanggal',
			'isdarurat' => 'Darurat',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update LOgin Pemakai',
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

		if(!empty($this->intraanestesi_id)){
			$criteria->addCondition('intraanestesi_id = '.$this->intraanestesi_id);
		}
		if(!empty($this->pasienanastesi_id)){
			$criteria->addCondition('pasienanastesi_id = '.$this->pasienanastesi_id);
		}
		if(!empty($this->praanestesi_id)){
			$criteria->addCondition('praanestesi_id = '.$this->praanestesi_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->kamarruangan_id)){
			$criteria->addCondition('kamarruangan_id = '.$this->kamarruangan_id);
		}
		$criteria->compare('LOWER(nointraanestesi)',strtolower($this->nointraanestesi),true);
		$criteria->compare('LOWER(tglintraanestesi)',strtolower($this->tglintraanestesi),true);
		if(!empty($this->dokter_id)){
			$criteria->addCondition('dokter_id = '.$this->dokter_id);
		}
		if(!empty($this->perawat1_id)){
			$criteria->addCondition('perawat1_id = '.$this->perawat1_id);
		}
		if(!empty($this->perawat2_id)){
			$criteria->addCondition('perawat2_id = '.$this->perawat2_id);
		}
		$criteria->compare('LOWER(tekniksedasi)',strtolower($this->tekniksedasi),true);
		$criteria->compare('LOWER(tglpuasa)',strtolower($this->tglpuasa),true);
		$criteria->compare('isdarurat',$this->isdarurat);
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