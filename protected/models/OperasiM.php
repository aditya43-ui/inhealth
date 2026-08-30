<?php

/**
 * This is the model class for table "operasi_m".
 *
 * The followings are the available columns in table 'operasi_m':
 * @property integer $operasi_id
 * @property integer $daftartindakan_id
 * @property integer $kegiatanoperasi_id
 * @property string $operasi_kode
 * @property string $operasi_nama
 * @property string $operasi_namalainnya
 * @property boolean $operasi_aktif
 */
class OperasiM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OperasiM the static model class
	 */
         public $daftartindakan_nama;
    
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'operasi_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kegiatanoperasi_id, operasi_kode, operasi_nama', 'required'),
			array('daftartindakan_id, kegiatanoperasi_id', 'numerical', 'integerOnly'=>true),
			array('operasi_kode', 'length', 'max'=>20),
			array('operasi_nama, operasi_namalainnya', 'length', 'max'=>100),
			array('operasi_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('daftartindakan_nama, operasi_id, daftartindakan_id, kegiatanoperasi_id, operasi_kode, operasi_nama, operasi_namalainnya, operasi_aktif', 'safe', 'on'=>'search'),
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
                    'daftartindakan'=>array(self::BELONGS_TO,'DaftartindakanM','daftartindakan_id'),
                    'kegiatanoperasi'=>array(self::BELONGS_TO,'KegiatanOperasiM','kegiatanoperasi_id'),
		);	
                
        }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'operasi_id' => 'Operasi',
			'daftartindakan_id' => 'Daftar Tindakan',
			'kegiatanoperasi_id' => 'Kegiatan Operasi',
			'operasi_kode' => 'Operasi Kode',
			'operasi_nama' => 'Operasi Nama',
			'operasi_namalainnya' => 'Nama Lain Operasi',
			'operasi_aktif' => 'Operasi Aktif',
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
                $criteria->with = array('daftartindakan');
		$criteria->compare('t.operasi_id',$this->operasi_id);
		$criteria->compare('t.daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('t.kegiatanoperasi_id',$this->kegiatanoperasi_id);
		$criteria->compare('LOWER(t.operasi_kode)',strtolower($this->operasi_kode),true);
		$criteria->compare('LOWER(t.operasi_nama)',strtolower($this->operasi_nama),true);
		$criteria->compare('LOWER(t.operasi_namalainnya)',strtolower($this->operasi_namalainnya),true);
                $criteria->compare('LOWER(daftartindakan.daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
		$criteria->compare('t.operasi_aktif',isset($this->operasi_aktif)?$this->operasi_aktif:true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort' => array(
                            'attributes' => array(
                                'daftartindakan_nama' => array(
                                    'asc' => 'daftartindakan.daftartindakan_nama ASC',
                                    'desc' => 'daftartindakan.daftartindakan_nama DESC',
                                ),
                                '*',
                            )
                        )
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('operasi_id',$this->operasi_id);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
//		$criteria->compare('kegiatanoperasi_id',$this->kegiatanoperasi_id);
		$criteria->compare('LOWER(operasi_kode)',strtolower($this->operasi_kode),true);
		$criteria->compare('LOWER(operasi_nama)',strtolower($this->operasi_nama),true);
		$criteria->compare('LOWER(operasi_namalainnya)',strtolower($this->operasi_namalainnya),true);
//		$criteria->compare('operasi_aktif',$this->operasi_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
         public function beforeSave() {
            $this->operasi_nama = ucwords(strtolower($this->operasi_nama));
            $this->operasi_namalainnya = strtoupper($this->operasi_namalainnya);
            return parent::beforeSave();
         }
         
         public function getAllItems()
        {
            return $this->model()->findAll('operasi_aktif = true order by operasi_nama');
        }
}