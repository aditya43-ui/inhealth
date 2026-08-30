<?php

/**
 * This is the model class for table "layanansurvei_m".
 *
 * The followings are the available columns in table 'layanansurvei_m':
 * @property integer $layanansurvei_id
 * @property integer $instalasi_id
 * @property integer $ruangan_id
 * @property string $layanansurvei_nama
 * @property string $layanansurvei_ask
 * @property string $layanansurvei_desc
 * @property boolean $layanansurvei_aktif
 */
class LayanansurveiM extends CActiveRecord
{

	public $instalasi_nama, $layanansurvei;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LayanansurveiM the static model class
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
		return 'layanansurvei_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('instalasi_id, ruangan_id, layanansurvei_id, layanansurvei_nama, layanansurvei_ask, layanansurvei_desc', 'required', 'message' => '{attribute} Harus Diisi'),
			array('instalasi_id, ruangan_id', 'numerical', 'integerOnly'=>true),
			array('layanansurvei_nama, layanansurvei_ask', 'length', 'max'=>200),
			array('layanansurvei_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.

			array('instalasi_nama,layanansurvei_id, instalasi_id, ruangan_id, layanansurvei_nama, layanansurvei_ask, layanansurvei_desc, layanansurvei_aktif', 'safe', 'on'=>'search'),

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

			'instalasirl' => array(self::BELONGS_TO, 'InstalasiM', 'instalasi_id'),
			'ruanganrl' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(

			'layanansurvei_id' => 'ID',
			'instalasi_id' => 'Instalasi',
			'ruangan_id' => 'Ruangan',
			'layanansurvei_nama' => 'Nama Layanan',
			'layanansurvei_ask' => 'Ask Layanan',
			'layanansurvei_desc' => 'Deskripsi Layanan',
			'layanansurvei_aktif' => 'Aktif',
			'layanansurvei' => 'Pengaduan Laboratorium'
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


		if(!empty($this->layanansurvei_id)){
			$criteria->addCondition('layanansurvei_id = '.$this->layanansurvei_id);
		}
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
                $criteria->compare('instalasi_id',$this->instalasi_id);
                $criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(layanansurvei_nama)',strtolower($this->layanansurvei_nama),true);
		$criteria->compare('LOWER(layanansurvei_ask)',strtolower($this->layanansurvei_ask),true);
		$criteria->compare('LOWER(layanansurvei_desc)',strtolower($this->layanansurvei_desc),true);
		$criteria->compare('layanansurvei_aktif',$this->layanansurvei_aktif);
//		$criteria->compare('layanansurvei_aktif',isset($this->layanansurvei_aktif)?$this->layanansurvei_aktif:true);

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
		
		public function getLayananItems($instalasi_nama=null){
			if (!empty($instalasi_nama)){
//				return PendidikankualifikasiM::model()->findAllByAttributes (array('pendkualifikasi_aktif'=>TRUE, 'pendidikan_id'=>$pendidikan_id),array('order'=>'pendkualifikasi_nama asc'));
				$criteria=new CDbCriteria;
				$criteria->select = 't.layanansurvei_nama, t.layanansurvei_id';
				$criteria->join = ''
						. ' JOIN instalasi_m i  ON i.instalasi_id = t.instalasi_id';
				$criteria->addCondition("i.instalasi_nama = '".$instalasi_nama."'  ");
				$criteria->addCondition('t.layanansurvei_aktif = TRUE');
				
				return LayanansurveiM::model()->findAll($criteria);
			} 
			else{
				return array();
			}
		}
                public function getInstalasiItems($instalasi_nama=null){
			if (!empty($instalasi_nama)){
//				return PendidikankualifikasiM::model()->findAllByAttributes (array('pendkualifikasi_aktif'=>TRUE, 'pendidikan_id'=>$pendidikan_id),array('order'=>'pendkualifikasi_nama asc'));
				$criteria=new CDbCriteria;
				$criteria->select = 'i.instalasi_id,i.instalasi_nama';
				$criteria->join = ''
						. ' JOIN instalasi_m i  ON i.instalasi_id = t.instalasi_id';
				$criteria->addCondition("t.layanansurvei_nama = '".$instalasi_nama."'  ");
				$criteria->addCondition('t.layanansurvei_aktif = TRUE');
				
                               
				return LayanansurveiM::model()->findAll($criteria);
			} 
			else{
				return array();
			}
		}

}