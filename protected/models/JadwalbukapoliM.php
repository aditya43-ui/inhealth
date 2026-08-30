<?php

/**
 * This is the model class for table "jadwalbukapoli_m".
 *
 * The followings are the available columns in table 'jadwalbukapoli_m':
 * @property integer $jadwalbukapoli_id
 * @property integer $ruangan_id
 * @property string $hari
 * @property string $jmabuka
 * @property string $jammulai
 * @property string $jamtutup
 * @property integer $maxantiranpoli
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class JadwalbukapoliM extends CActiveRecord
{
        public $ruangan_nama;
        public $loket_id, $modelantrian_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JadwalbukapoliM the static model class
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
		return 'jadwalbukapoli_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, hari, jmabuka, jammulai, jamtutup', 'required'),
			array('ruangan_id, maxantiranpoli', 'numerical', 'integerOnly'=>true),
			array('hari', 'length', 'max'=>20),
			array('jmabuka', 'length', 'max'=>50),
			array('update_time, jammulaipendaftaran, jamakhirpendaftaran, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
                        array('create_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date('Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
			array('jadwalbukapoli_id,ruangan_nama, ruangan_id, hari, jmabuka, jammulai, jamtutup, maxantiranpoli, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
                    'ruangan'=>array(self::BELONGS_TO, 'RuanganM','ruangan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'jadwalbukapoli_id' => 'ID',
			'ruangan_id' => 'Poliklinik',
			'hari' => 'Hari',
			'jmabuka' => 'Jam Buka',
			'jammulai' => 'Jam Mulai',
			'jamtutup' => 'Jam Tutup',
			'maxantiranpoli' => 'Max Antrian Poli',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria->compare('jadwalbukapoli_id',$this->jadwalbukapoli_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(hari)',strtolower($this->hari),true);
		$criteria->compare('LOWER(jmabuka)',strtolower($this->jmabuka),true);
		$criteria->compare('LOWER(jammulai)',strtolower($this->jammulai),true);
		$criteria->compare('LOWER(jamtutup)',strtolower($this->jamtutup),true);
		$criteria->compare('maxantiranpoli',$this->maxantiranpoli);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('jadwalbukapoli_id',$this->jadwalbukapoli_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(hari)',strtolower($this->hari),true);
		$criteria->compare('LOWER(jmabuka)',strtolower($this->jmabuka),true);
		$criteria->compare('LOWER(jammulai)',strtolower($this->jammulai),true);
		$criteria->compare('LOWER(jamtutup)',strtolower($this->jamtutup),true);
		$criteria->compare('maxantiranpoli',$this->maxantiranpoli);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function getRuanganItems()
        {
            return RuanganM::model()->findAll('ruangan_aktif=TRUE AND instalasi_id IN ('
                    . ' '.Params::getInstalasiJadwalPoli().''                    
                    . ')'
                    . ' ORDER BY ruangan_nama');
        }
}