<?php

/**
 * This is the model class for table "kegiatanoperasi_m".
 *
 * The followings are the available columns in table 'kegiatanoperasi_m':
 * @property integer $kegiatanoperasi_id
 * @property string $kegiatanoperasi_kode
 * @property string $kegiatanoperasi_nama
 * @property string $kegiatanoperasi_namalainnya
 * @property boolean $kegiatanoperasi_aktif
 */
class KegiatanOperasiM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KegiatanOperasiM the static model class
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
		return 'kegiatanoperasi_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kegiatanoperasi_kode, kegiatanoperasi_nama', 'required'),
			array('kegiatanoperasi_kode', 'length', 'max'=>20),
			array('kegiatanoperasi_nama, kegiatanoperasi_namalainnya', 'length', 'max'=>100),
			array('kegiatanoperasi_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kegiatanoperasi_id, kegiatanoperasi_kode, kegiatanoperasi_nama, kegiatanoperasi_namalainnya, kegiatanoperasi_aktif', 'safe', 'on'=>'search'),
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
			'kegiatanoperasi_id' => 'ID',
			'kegiatanoperasi_kode' => 'Kode',
			'kegiatanoperasi_nama' => 'Nama Kegiatan',
			'kegiatanoperasi_namalainnya' => 'Nama Lainnya',
			'kegiatanoperasi_aktif' => 'Aktif',
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

		$criteria->compare('kegiatanoperasi_id',$this->kegiatanoperasi_id);
		$criteria->compare('LOWER(kegiatanoperasi_kode)',strtolower($this->kegiatanoperasi_kode),true);
		$criteria->compare('LOWER(kegiatanoperasi_nama)',strtolower($this->kegiatanoperasi_nama),true);
		$criteria->compare('LOWER(kegiatanoperasi_namalainnya)',strtolower($this->kegiatanoperasi_namalainnya),true);
		$criteria->compare('kegiatanoperasi_aktif',isset($this->kegiatanoperasi_aktif)?$this->kegiatanoperasi_aktif:true);
                //$criteria->addCondition('kegiatanoperasi_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('kegiatanoperasi_id',$this->kegiatanoperasi_id);
		$criteria->compare('LOWER(kegiatanoperasi_kode)',strtolower($this->kegiatanoperasi_kode),true);
		$criteria->compare('LOWER(kegiatanoperasi_nama)',strtolower($this->kegiatanoperasi_nama),true);
		$criteria->compare('LOWER(kegiatanoperasi_namalainnya)',strtolower($this->kegiatanoperasi_namalainnya),true);
//		$criteria->compare('kegiatanoperasi_aktif',$this->kegiatanoperasi_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function beforeSave() {
            $this->kegiatanoperasi_nama = ucwords(strtolower($this->kegiatanoperasi_nama));
            $this->kegiatanoperasi_namalainnya = strtoupper($this->kegiatanoperasi_namalainnya);
            return parent::beforeSave();
         }
}