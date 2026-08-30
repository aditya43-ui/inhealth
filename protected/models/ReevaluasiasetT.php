<?php

/**
 * This is the model class for table "reevaluasiaset_t".
 *
 * The followings are the available columns in table 'reevaluasiaset_t':
 * @property integer $reevaluasiaset_id
 * @property string $reevaluasiaset_tgl
 * @property string $reevaluasiaset_no
 * @property double $reevaluasiaset_totalselisih
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property integer $pegawaimengetahui_id
 * @property integer $pegawaimenyetujui_id
 *
 * The followings are the available model relations:
 * @property ReevaluasiasetdetailT[] $reevaluasiasetdetailTs
 * @property LoginpemakaiK $createLoginpemakai
 * @property LoginpemakaiK $updateLoginpemakai
 * @property RuanganM $createRuangan
 * @property PegawaiM $pegawaimengetahui
 */
class ReevaluasiasetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ReevaluasiasetT the static model class
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
		return 'reevaluasiaset_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('reevaluasiaset_tgl, reevaluasiaset_no, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('create_loginpemakai_id, update_loginpemakai_id, create_ruangan, pegawaimengetahui_id, pegawaimenyetujui_id', 'numerical', 'integerOnly'=>true),
			array('reevaluasiaset_totalselisih', 'numerical'),
			array('reevaluasiaset_no', 'length', 'max'=>25),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('reevaluasiaset_id, reevaluasiaset_tgl, reevaluasiaset_no, reevaluasiaset_totalselisih, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, pegawaimengetahui_id, pegawaimenyetujui_id', 'safe', 'on'=>'search'),
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
			'reevaluasiasetdetailTs' => array(self::HAS_MANY, 'ReevaluasiasetdetailT', 'reevaluasiaset_id'),
			'createLoginpemakai' => array(self::BELONGS_TO, 'LoginpemakaiK', 'create_loginpemakai_id'),
			'updateLoginpemakai' => array(self::BELONGS_TO, 'LoginpemakaiK', 'update_loginpemakai_id'),
			'createRuangan' => array(self::BELONGS_TO, 'RuanganM', 'create_ruangan'),
			'pegawaimengetahui' => array(self::BELONGS_TO, 'PegawaiM', 'pegawaimengetahui_id'),
                        'pegawaimenyetujui' => array(self::BELONGS_TO, 'PegawaiM', 'pegawaimenyetujui_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'reevaluasiaset_id' => 'Reevaluasiaset',
			'reevaluasiaset_tgl' => 'Tgl. Re-evaluasi Aset',
			'reevaluasiaset_no' => 'No. Re-evaluasi Aset',
			'reevaluasiaset_totalselisih' => 'Reevaluasiaset Totalselisih',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'pegawaimengetahui_id' => 'Pegawaimengetahui',
			'pegawaimenyetujui_id' => 'Pegawaimenyetujui',
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

		if(!empty($this->reevaluasiaset_id)){
			$criteria->addCondition('reevaluasiaset_id = '.$this->reevaluasiaset_id);
		}
		$criteria->compare('LOWER(reevaluasiaset_tgl)',strtolower($this->reevaluasiaset_tgl),true);
		$criteria->compare('LOWER(reevaluasiaset_no)',strtolower($this->reevaluasiaset_no),true);
		$criteria->compare('reevaluasiaset_totalselisih',$this->reevaluasiaset_totalselisih);
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
		if(!empty($this->pegawaimengetahui_id)){
			$criteria->addCondition('pegawaimengetahui_id = '.$this->pegawaimengetahui_id);
		}
		if(!empty($this->pegawaimenyetujui_id)){
			$criteria->addCondition('pegawaimenyetujui_id = '.$this->pegawaimenyetujui_id);
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