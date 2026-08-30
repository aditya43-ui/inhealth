<?php

/**
 * This is the model class for table "pbf_m".
 *
 * The followings are the available columns in table 'pbf_m':
 * @property integer $pbf_id
 * @property string $pbf_kode
 * @property string $pbf_nama
 * @property string $pbf_singkatan
 * @property string $pbf_alamat
 * @property string $pbf_propinsi
 * @property string $pbf_kabupaten
 * @property boolean $pbf_aktif
 */
class PbfM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PbfM the static model class
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
		return 'pbf_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pbf_kode, pbf_nama', 'required'),
			array('pbf_kode, pbf_singkatan', 'length', 'max'=>20),
			array('pbf_nama', 'length', 'max'=>100),
			array('pbf_propinsi, pbf_kabupaten', 'length', 'max'=>50),
			array('pbf_alamat, pbf_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pbf_id, pbf_kode, pbf_nama, pbf_singkatan, pbf_alamat, pbf_propinsi, pbf_kabupaten, pbf_aktif', 'safe', 'on'=>'search'),
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
			'pbf_id' => 'ID',
			'pbf_kode' => 'Kode',
			'pbf_nama' => 'Nama',
			'pbf_singkatan' => 'Singkatan',
			'pbf_alamat' => 'Alamat',
			'pbf_propinsi' => 'Provinsi',
			'pbf_kabupaten' => 'Kabupaten',
			'pbf_aktif' => 'Aktif',
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

		$criteria->compare('pbf_id',$this->pbf_id);
		$criteria->compare('LOWER(pbf_kode)',strtolower($this->pbf_kode),true);
		$criteria->compare('LOWER(pbf_nama)',strtolower($this->pbf_nama),true);
		$criteria->compare('LOWER(pbf_singkatan)',strtolower($this->pbf_singkatan),true);
		$criteria->compare('LOWER(pbf_alamat)',strtolower($this->pbf_alamat),true);
		$criteria->compare('LOWER(pbf_propinsi)',strtolower($this->pbf_propinsi),true);
		$criteria->compare('LOWER(pbf_kabupaten)',strtolower($this->pbf_kabupaten),true);
		$criteria->compare('pbf_aktif',isset($this->pbf_aktif)?$this->pbf_aktif:true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pbf_id',$this->pbf_id);
		$criteria->compare('LOWER(pbf_kode)',strtolower($this->pbf_kode),true);
		$criteria->compare('LOWER(pbf_nama)',strtolower($this->pbf_nama),true);
		$criteria->compare('LOWER(pbf_singkatan)',strtolower($this->pbf_singkatan),true);
		$criteria->compare('LOWER(pbf_alamat)',strtolower($this->pbf_alamat),true);
		$criteria->compare('LOWER(pbf_propinsi)',strtolower($this->pbf_propinsi),true);
		$criteria->compare('LOWER(pbf_kabupaten)',strtolower($this->pbf_kabupaten),true);
//		$criteria->compare('pbf_aktif',$this->pbf_aktif);
                $criteria->order='pbf_nama asc';
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
         public function beforeSave() {
            $this->pbf_singkatan = strtoupper($this->pbf_singkatan);
            $this->pbf_nama = ucwords(strtolower($this->pbf_nama));
            return parent::beforeSave();
        }
        
        public function getPropinsiItems()
        {
            return PropinsiM::model()->findAll('propinsi_aktif=TRUE ORDER BY propinsi_nama');
        }
        
        public function getkabupatenItems()
        {
            return KabupatenM::model()->findAll('kabupaten_aktif=TRUE ORDER BY kabupaten_nama');
        }
        
       
}