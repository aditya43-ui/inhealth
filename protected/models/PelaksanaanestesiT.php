<?php

/**
 * This is the model class for table "pelaksanaanestesi_t".
 *
 * The followings are the available columns in table 'pelaksanaanestesi_t':
 * @property integer $pelaksanaanestesi_id
 * @property integer $evaluasianestesi_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property string $kruanestesi
 * @property integer $pegawai_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property integer $batalpelaksanaananestesi_id
 * @author Rusdiyanto <rusdiyanto@.com>
 * @package application.models
 * @subpackage models
 */
class PelaksanaanestesiT extends CActiveRecord
{
    public $status;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PelaksanaanestesiT the static model class
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
		return 'pelaksanaanestesi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                    array('evaluasianestesi_id, pasien_id, kruanestesi, create_time, create_loginpemakai_id', 'required'),
                    array('evaluasianestesi_id, pasien_id, pendaftaran_id, pegawai_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, batalpelaksanaananestesi_id', 'numerical', 'integerOnly'=>true),
                    array('kruanestesi', 'length', 'max'=>200),
                    array('update_time', 'safe'),
                    // The following rule is used by search().
                    // Please remove those attributes that should not be searched.
                    array('pelaksanaanestesi_id, evaluasianestesi_id, pasien_id, pendaftaran_id, kruanestesi, pegawai_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, batalpelaksanaananestesi_id', 'safe', 'on'=>'search'),
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
                    'evaluasianestesi' => array(self::BELONGS_TO, 'EvaluasianestesiT', 'evaluasianestesi_id'),
                );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
                    'pelaksanaanestesi_id' => 'Pelaksanaanestesi',
                    'evaluasianestesi_id' => 'Evaluasianestesi',
                    'pasien_id' => 'Pasien',
                    'pendaftaran_id' => 'Pendaftaran',
                    'kruanestesi' => 'Kruanestesi',
                    'pegawai_id' => 'Pegawai',
                    'create_time' => 'Create Time',
                    'update_time' => 'Update Time',
                    'create_loginpemakai_id' => 'Create Loginpemakai',
                    'update_loginpemakai_id' => 'Update Loginpemakai',
                    'create_ruangan' => 'Create Ruangan',
                    'batalpelaksanaananestesi_id' => 'Batalpelaksanaananestesi',
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

		if(!empty($this->pelaksanaanestesi_id)){
			$criteria->addCondition('pelaksanaanestesi_id = '.$this->pelaksanaanestesi_id);
		}
		if(!empty($this->evaluasianestesi_id)){
			$criteria->addCondition('evaluasianestesi_id = '.$this->evaluasianestesi_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		$criteria->compare('LOWER(kruanestesi)',strtolower($this->kruanestesi),true);
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
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
		if(!empty($this->batalpelaksanaananestesi_id)){
			$criteria->addCondition('batalpelaksanaananestesi_id = '.$this->batalpelaksanaananestesi_id);
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