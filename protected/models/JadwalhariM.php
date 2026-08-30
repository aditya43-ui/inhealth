<?php

/**
 * This is the model class for table "jadwalhari_m".
 *
 * The followings are the available columns in table 'jadwalhari_m':
 * @property integer $jadwalhari_id
 * @property string $jadwalhari_nama
 * @property boolean $jadwalhari_hari_senin
 * @property boolean $jadwalhari_hari_selasa
 * @property boolean $jadwalhari_hari_rabu
 * @property boolean $jadwalhari_hari_kamis
 * @property boolean $jadwalhari_hari_jumat
 * @property boolean $jadwalhari_hari_sabtu
 * @property boolean $jadwalhari_hari_minggu
 * @property boolean $jadwalhari_aktif
 */
class JadwalhariM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JadwalhariM the static model class
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
		return 'jadwalhari_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jadwalhari_nama', 'required'),
			array('jadwalhari_nama', 'length', 'max'=>100),
			array('jadwalhari_hari_senin, jadwalhari_hari_selasa, jadwalhari_hari_rabu, jadwalhari_hari_kamis, jadwalhari_hari_jumat, jadwalhari_hari_sabtu, jadwalhari_hari_minggu, jadwalhari_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jadwalhari_id, jadwalhari_nama, jadwalhari_hari_senin, jadwalhari_hari_selasa, jadwalhari_hari_rabu, jadwalhari_hari_kamis, jadwalhari_hari_jumat, jadwalhari_hari_sabtu, jadwalhari_hari_minggu, jadwalhari_aktif', 'safe', 'on'=>'search'),
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
			'jadwalhari_id' => 'ID',
			'jadwalhari_nama' => 'Nama Jadwal Hari',
			'jadwalhari_hari_senin' => 'Senin',
			'jadwalhari_hari_selasa' => 'Selasa',
			'jadwalhari_hari_rabu' => 'Rabu',
			'jadwalhari_hari_kamis' => 'Kamis',
			'jadwalhari_hari_jumat' => 'Jumat',
			'jadwalhari_hari_sabtu' => 'Sabtu',
			'jadwalhari_hari_minggu' => 'Minggu',
			'jadwalhari_aktif' => 'Aktif',
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

		if(!empty($this->jadwalhari_id)){
			$criteria->addCondition('jadwalhari_id = '.$this->jadwalhari_id);
		}
		$criteria->compare('LOWER(jadwalhari_nama)',strtolower($this->jadwalhari_nama),true);
//		$criteria->compare('jadwalhari_hari_senin',$this->jadwalhari_hari_senin);
//		$criteria->compare('jadwalhari_hari_selasa',$this->jadwalhari_hari_selasa);
//		$criteria->compare('jadwalhari_hari_rabu',$this->jadwalhari_hari_rabu);
//		$criteria->compare('jadwalhari_hari_kamis',$this->jadwalhari_hari_kamis);
//		$criteria->compare('jadwalhari_hari_jumat',$this->jadwalhari_hari_jumat);
//		$criteria->compare('jadwalhari_hari_sabtu',$this->jadwalhari_hari_sabtu);
//		$criteria->compare('jadwalhari_hari_minggu',$this->jadwalhari_hari_minggu);
//		$criteria->compare('jadwalhari_aktif',$this->jadwalhari_aktif);
//		$criteria->compare('jadwalhari_aktif',isset($this->jadwalhari_aktif)?$this->jadwalhari_aktif:true);

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