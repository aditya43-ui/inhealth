<?php

/**
 * This is the model class for table "statusimunisasi_m".
 *
 * The followings are the available columns in table 'statusimunisasi_m':
 * @property integer $statusimunisasi_id
 * @property string $statusimunisasi_kode
 * @property string $statusimunisasi_nama
 * @property string $statusimunisasi_namalain
 * @property boolean $statusimunisasi_aktif
 */
class StatusimunisasiM extends CActiveRecord
{
        public $kodeNama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StatusimunisasiM the static model class
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
		return 'statusimunisasi_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('statusimunisasi_kode, statusimunisasi_nama', 'required'),
			array('statusimunisasi_kode', 'length', 'max'=>2),
			array('statusimunisasi_nama, statusimunisasi_namalain', 'length', 'max'=>100),
			array('statusimunisasi_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('statusimunisasi_id, statusimunisasi_kode, statusimunisasi_nama, statusimunisasi_namalain, statusimunisasi_aktif', 'safe', 'on'=>'search'),
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
			'statusimunisasi_id' => 'Statusimunisasi',
			'statusimunisasi_kode' => 'Statusimunisasi Kode',
			'statusimunisasi_nama' => 'Statusimunisasi Nama',
			'statusimunisasi_namalain' => 'Statusimunisasi Namalain',
			'statusimunisasi_aktif' => 'Statusimunisasi Aktif',
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

		$criteria->compare('statusimunisasi_id',$this->statusimunisasi_id);
		$criteria->compare('LOWER(statusimunisasi_kode)',strtolower($this->statusimunisasi_kode),true);
		$criteria->compare('LOWER(statusimunisasi_nama)',strtolower($this->statusimunisasi_nama),true);
		$criteria->compare('LOWER(statusimunisasi_namalain)',strtolower($this->statusimunisasi_namalain),true);
		$criteria->compare('statusimunisasi_aktif',$this->statusimunisasi_aktif);
                $criteria->addCondition('statusimunisasi_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('statusimunisasi_id',$this->statusimunisasi_id);
		$criteria->compare('LOWER(statusimunisasi_kode)',strtolower($this->statusimunisasi_kode),true);
		$criteria->compare('LOWER(statusimunisasi_nama)',strtolower($this->statusimunisasi_nama),true);
		$criteria->compare('LOWER(statusimunisasi_namalain)',strtolower($this->statusimunisasi_namalain),true);
		$criteria->compare('statusimunisasi_aktif',$this->statusimunisasi_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        protected function afterFind()
          {
            $this->kodeNama = $this->statusimunisasi_kode . '-' . $this->statusimunisasi_nama;
            parent::afterFind();    
          }
        
         public function getkodeNama() {                         
            return $this->statusimunisasi_kode.PHP_EOL.'<br/>'.$this->statusimunisasi_nama;
        }
}