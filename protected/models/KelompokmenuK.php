<?php

/**
 * This is the model class for table "kelompokmenu_k".
 *
 * The followings are the available columns in table 'kelompokmenu_k':
 * @property integer $kelmenu_id
 * @property string $kelmenu_nama
 * @property string $kelmenu_namalainnya
 * @property string $kelmenu_key
 * @property string $kelmenu_url
 * @property integer $kelmenu_urutan
 * @property boolean $kelmenu_aktif
 */
class KelompokmenuK extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KelompokmenuK the static model class
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
		return 'kelompokmenu_k';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kelmenu_nama', 'required'),
			array('kelmenu_urutan', 'numerical', 'integerOnly'=>true),
			array('kelmenu_nama, kelmenu_namalainnya, kelmenu_key', 'length', 'max'=>100),
			array('kelmenu_url,kelmenu_icon', 'length', 'max'=>50),
			array('kelmenu_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kelmenu_id, kelmenu_nama, kelmenu_namalainnya, kelmenu_key, kelmenu_url, kelmenu_urutan, kelmenu_icon, kelmenu_aktif', 'safe', 'on'=>'search'),
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
			'kelmenu_id' => 'ID',
			'kelmenu_nama' => 'Kelompok Menu',
			'kelmenu_namalainnya' => 'Nama Lain',
			'kelmenu_key' => 'Key',
			'kelmenu_url' => 'URL',
			'kelmenu_urutan' => 'Urutan',
			'kelmenu_aktif' => 'Aktif',
			'kelmenu_icon' => 'Icon',
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

		$criteria->compare('kelmenu_id',$this->kelmenu_id);
		if($this->kelmenu_icon == 1){
			$criteria->addCondition("(kelmenu_icon = '') IS NOT FALSE"
		);
		}
		$criteria->compare('LOWER(kelmenu_nama)',strtolower($this->kelmenu_nama),true);
		$criteria->compare('LOWER(kelmenu_namalainnya)',strtolower($this->kelmenu_namalainnya),true);
		$criteria->compare('LOWER(kelmenu_key)',strtolower($this->kelmenu_key),true);
		$criteria->compare('LOWER(kelmenu_url)',strtolower($this->kelmenu_url),true);
        // $criteria->compare('LOWER(kelmenu_icon)',strtolower($this->kelmenu_icon),true);
		$criteria->compare('kelmenu_urutan',$this->kelmenu_urutan);
		$criteria->compare('kelmenu_aktif',isset($this->kelmenu_aktif)?$this->kelmenu_aktif:true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('kelmenu_id',$this->kelmenu_id);
		$criteria->compare('LOWER(kelmenu_nama)',strtolower($this->kelmenu_nama),true);
		$criteria->compare('LOWER(kelmenu_namalainnya)',strtolower($this->kelmenu_namalainnya),true);
		$criteria->compare('LOWER(kelmenu_key)',strtolower($this->kelmenu_key),true);
		$criteria->compare('LOWER(kelmenu_url)',strtolower($this->kelmenu_url),true);
		$criteria->compare('LOWER(kelmenu_icon)',strtolower($this->kelmenu_icon),true);
		$criteria->compare('kelmenu_urutan',$this->kelmenu_urutan);
//		$criteria->compare('kelmenu_aktif',$this->kelmenu_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                         'pagination'=>false,
                ));
        }
        
        public function beforeSave() {
            $this->kelmenu_nama = ucwords(strtolower($this->kelmenu_nama));
            $this->kelmenu_namalainnya = strtoupper($this->kelmenu_namalainnya);
            return parent::beforeSave();
        }
        
        public function findAllAktif($compare=array())
        {
            $criteria = new CDbCriteria;
            $criteria->compare('kelmenu_aktif',true);
            $criteria->order = 'kelmenu_urutan';
            if(!empty($compare)){
                foreach($compare as $column=>$value)
                $criteria->compare($column,$value);
            }
            return self::model()->findAll($criteria);
        }
}