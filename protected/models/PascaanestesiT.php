<?php

/**
 * This is the model class for table "pascaanestesi_t".
 *
 * The followings are the available columns in table 'pascaanestesi_t':
 * @property integer $pascaanestesi_id
 * @property integer $pasienanastesi_id
 * @property integer $intraanestesi_id
 * @property integer $kamarruangan_id
 * @property integer $ruangan_id
 * @property string $nopascaanestesi
 * @property string $tglpascaanestesi
 * @property integer $instalasipasca_id
 * @property integer $ruanganpasca_id
 * @property integer $perawatruangan_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property string $komplikasi
 *
 * The followings are the available model relations:
 * @property KondisipasienanestesiT[] $kondisipasienanestesiTs
 * @property PasienanastesiT $pasienanastesi
 * @property IntraanestesiT $intraanestesi
 * @property KamarruanganM $kamarruangan
 * @property RuanganM $ruangan
 * @property InstalasiM $instalasipasca
 * @property RuanganM $ruanganpasca
 * @property PegawaiM $perawatruangan
 */
class PascaanestesiT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PascaanestesiT the static model class
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
		return 'pascaanestesi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasienanastesi_id, intraanestesi_id, nopascaanestesi, tglpascaanestesi, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pasienanastesi_id, intraanestesi_id, kamarruangan_id, ruangan_id, instalasipasca_id, ruanganpasca_id, perawatruangan_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('nopascaanestesi', 'length', 'max'=>20),
			array('update_time, komplikasi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pascaanestesi_id, pasienanastesi_id, intraanestesi_id, kamarruangan_id, ruangan_id, nopascaanestesi, tglpascaanestesi, instalasipasca_id, ruanganpasca_id, perawatruangan_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, komplikasi', 'safe', 'on'=>'search'),
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
			'kondisipasienanestesiTs' => array(self::HAS_MANY, 'KondisipasienanestesiT', 'pascaanestesi_id'),
			'pasienanastesi' => array(self::BELONGS_TO, 'PasienanastesiT', 'pasienanastesi_id'),
			'intraanestesi' => array(self::BELONGS_TO, 'IntraanestesiT', 'intraanestesi_id'),
			'kamarruangan' => array(self::BELONGS_TO, 'KamarruanganM', 'kamarruangan_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
			'instalasipasca' => array(self::BELONGS_TO, 'InstalasiM', 'instalasipasca_id'),
			'ruanganpasca' => array(self::BELONGS_TO, 'RuanganM', 'ruanganpasca_id'),
			'perawatruangan' => array(self::BELONGS_TO, 'PegawaiM', 'perawatruangan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pascaanestesi_id' => 'Pascaanestesi',
			'pasienanastesi_id' => 'Pasienanastesi',
			'intraanestesi_id' => 'Intraanestesi',
			'kamarruangan_id' => 'Kamarruangan',
			'ruangan_id' => 'Ruangan',
			'nopascaanestesi' => 'Nopascaanestesi',
			'tglpascaanestesi' => 'Tglpascaanestesi',
			'instalasipasca_id' => 'Instalasipasca',
			'ruanganpasca_id' => 'Ruanganpasca',
			'perawatruangan_id' => 'Perawatruangan',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'komplikasi' => 'Komplikasi',
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

		if(!empty($this->pascaanestesi_id)){
			$criteria->addCondition('pascaanestesi_id = '.$this->pascaanestesi_id);
		}
		if(!empty($this->pasienanastesi_id)){
			$criteria->addCondition('pasienanastesi_id = '.$this->pasienanastesi_id);
		}
		if(!empty($this->intraanestesi_id)){
			$criteria->addCondition('intraanestesi_id = '.$this->intraanestesi_id);
		}
		if(!empty($this->kamarruangan_id)){
			$criteria->addCondition('kamarruangan_id = '.$this->kamarruangan_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(nopascaanestesi)',strtolower($this->nopascaanestesi),true);
		$criteria->compare('LOWER(tglpascaanestesi)',strtolower($this->tglpascaanestesi),true);
		if(!empty($this->instalasipasca_id)){
			$criteria->addCondition('instalasipasca_id = '.$this->instalasipasca_id);
		}
		if(!empty($this->ruanganpasca_id)){
			$criteria->addCondition('ruanganpasca_id = '.$this->ruanganpasca_id);
		}
		if(!empty($this->perawatruangan_id)){
			$criteria->addCondition('perawatruangan_id = '.$this->perawatruangan_id);
		}
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