<?php

/** 
 * This is the model class for table "kelurahan_m".
 *
 * The followings are the available columns in table 'kelurahan_m':
 * @property integer $kelurahan_id
 * @property integer $kecamatan_id
 * @property string $kelurahan_nama
 * @property string $kelurahan_namalainnya
 * @property string $kode_pos
 * @property boolean $kelurahan_aktif
 */
class KelurahanM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KelurahanM the static model class
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
		return 'kelurahan_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kecamatan_id, kelurahan_nama', 'required'),
			array('kecamatan_id', 'numerical', 'integerOnly'=>true),
			array('kelurahan_nama, kelurahan_namalainnya', 'length', 'max'=>50),
			array('kode_pos', 'length', 'max'=>15),
                        array('longitude, latitude','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kelurahan_id, kecamatan_id, kelurahan_nama, kelurahan_namalainnya, kode_pos, kelurahan_aktif', 'safe', 'on'=>'search'),
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
                                    'kecamatan' => array(self::BELONGS_TO, 'KecamatanM', 'kecamatan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kelurahan_id' => 'ID',
			'kecamatan_id' => 'Kecamatan',
			'kelurahan_nama' => 'Nama Kelurahan',
			'kelurahan_namalainnya' => 'Nama Lain',
			'kode_pos' => 'Kode Pos',
			'kelurahan_aktif' => 'Aktif',
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

		$criteria->compare('kelurahan_id',$this->kelurahan_id);
		$criteria->compare('kecamatan_id',$this->kecamatan_id);
		$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		$criteria->compare('LOWER(kelurahan_namalainnya)',strtolower($this->kelurahan_namalainnya),true);
		$criteria->compare('LOWER(kode_pos)',strtolower($this->kode_pos),true);
        $criteria->compare('kelurahan_aktif',isset($this->kelurahan_aktif)?$this->kelurahan_aktif:true);
                $criteria->addCondition('kelurahan_aktif is true');
                $criteria->order = 'kelurahan_id';
                $criteria->with=array('kecamatan');
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
                public function searchPrint()
                {
                        // Warning: Please modify the following code to remove attributes that
                        // should not be searched.

                        $criteria=new CDbCriteria;
                        $criteria->compare('kelurahan_id',$this->kelurahan_id);
                        $criteria->compare('kecamatan_id',$this->kecamatan_id);
                        $criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
                        $criteria->compare('LOWER(kelurahan_namalainnya)',strtolower($this->kelurahan_namalainnya),true);
                        $criteria->compare('LOWER(kode_pos)',strtolower($this->kode_pos),true);
                        $criteria->order = 'kelurahan_id';
                        $criteria->with=array('kecamatan');
//                        $criteria->compare('kelurahan_aktif',$this->kelurahan_aktif);
                        // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                        $criteria->limit=-1; 

                        return new CActiveDataProvider($this, array(
                                'criteria'=>$criteria,
                                 'pagination'=>false,
                        ));
                }
                
               public function beforeSave() 
               {
                    return parent::beforeSave();
                    $this->kelurahan_nama = ucwords(strtolower($this->kelurahan_nama));
                    $this->kelurahan_namalainnya = strtoupper($this->kelurahan_namalainnya);
                    
                }
                
                public function getPropinsiItems()
                {
                    return PropinsiM::model()->findAll('propinsi_aktif = TRUE ORDER BY propinsi_nama');
                }

                /**
                 * Mengambil daftar semua kabupaten
                 * @return CActiveDataProvider 
                 */
                public function getKabupatenItems()
                {
                    return KabupatenM::model()->findAll('kabupaten_aktif = TRUE ORDER BY kabupaten_nama');
                }
                
                /**
                 * Mengambil daftar semua kecamatan
                 * @return CActiveDataProvider 
                 */
                public function getKecamatanItems()
                {
                    return KecamatanM::model()->findAll('kecamatan_aktif = TRUE ORDER BY kecamatan_nama');
                }
                
                /**
                 * Mengambil daftar semua kelurahan yg sudah diorder dan berdasarkan kelurahan_aktif = TRUE
                 * @return CActiveDataProvider 
                 */
                public function getKelurahanItems()
                {
                    return $this->findAll('kelurahan_aktif = TRUE ORDER BY kelurahan_nama');
                }
                
                
                /**
                 * Mengambil  kabupaten_id berdasarkan kecamatan
                 * @return CActiveDataProvider 
                 */
                public function getKabupatenItemsKec($kecId)
                {
                   $kabupaten = KecamatanM::model()->findByPk($kecId);
                   return $kabupaten->kabupaten_id ;
                   
                }
                
                /**
                 *
                 * @param type $kecId
                 * @return result 
                 */
                public function getPropinsiItemsKec($kecId)
                {
                   $sql = "SELECT 
                                  propinsi_m.propinsi_id 
                                FROM 
                                  public.kecamatan_m, 
                                  public.kabupaten_m, 
                                  public.propinsi_m
                                WHERE 
                                  kecamatan_m.kabupaten_id = kabupaten_m.kabupaten_id AND
                                  kabupaten_m.propinsi_id = propinsi_m.propinsi_id AND kecamatan_m.kecamatan_id = $kecId;
                                ";
                   return $runSql  = Yii::app()->db->createCommand($sql)->queryScalar();
                }
                
                /**
                 * Mengambil daftar semua kecamatan berdasarkan kabupaten_id
                 * @param type $kabId integer kabupaten_id
                 * @return CActiveDataProvider 
                 */

                public function getKelurahanItemsKec($kecId)
                {
                    return $this->findAllByAttributes(array('kecamatan_id'=>$kecId,'kelurahan_aktif' => TRUE),array('order'=>'kelurahan_nama'));
                }
                
}
