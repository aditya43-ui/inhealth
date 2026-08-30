<?php

/**
 * This is the model class for table "pendidikan_m".
 *
 * The followings are the available columns in table 'pendidikan_m':
 * @property integer $pendidikan_id
 * @property string $pendidikan_nama
 * @property string $pendidikan_namalainnya
 * @property boolean $pendidikan_aktif
 */
class PendidikanM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PendidikanM the static model class
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
		return 'pendidikan_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendidikan_nama, pendidikan_urutan', 'required'),
			array('pendidikan_nama, pendidikan_namalainnya', 'length', 'max'=>50),
			array('pendidikan_aktif', 'safe'),
                        //ditabahin sama jw dikarenakan adanya penambahan field baru 
                        array('indexing_id, pendidikan_urutan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pendidikan_id, indexing_id, pendidikan_urutan, pendidikan_nama, pendidikan_namalainnya, pendidikan_aktif', 'safe', 'on'=>'search'),
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
			'pendidikan_id' => 'ID',
			'pendidikan_nama' => 'Pendidikan',
			'pendidikan_namalainnya' => 'Nama Lainnya',
			'pendidikan_aktif' => 'Aktif',
                    
                        //ditabahin sama jw dikarenakan adanya penambahan field baru
                        'indexing_id' => 'indexing_id',
                        'pendidikan_urutan' => 'Urutan Pendidikan',
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

		$criteria->compare('pendidikan_id',$this->pendidikan_id);
		$criteria->compare('LOWER(pendidikan_nama)',strtolower($this->pendidikan_nama),true);		
		$criteria->compare('LOWER(pendidikan_namalainnya)',strtolower($this->pendidikan_namalainnya),true);
                $criteria->compare('pendidikan_urutan',$this->pendidikan_urutan);
		$criteria->compare('pendidikan_aktif',isset($this->pendidikan_aktif)?$this->pendidikan_aktif:true);
              //  $criteria->addCondition('pendidikan_aktif is true');                

		return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,                    
		));
	}
        
        public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('pendidikan_id',$this->pendidikan_id);
		$criteria->compare('LOWER(pendidikan_nama)',strtolower($this->pendidikan_nama),true);
		$criteria->compare('LOWER(pendidikan_namalainnya)',strtolower($this->pendidikan_namalainnya),true);
                $criteria->compare('pendidikan_urutan',$this->pendidikan_urutan);
//		$criteria->compare('pendidikan_aktif',$this->pendidikan_aktif);
                $criteria->order='pendidikan_id';
                $criteria->limit=-1;        

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	}
        
        public function beforeSave() {
            $this->pendidikan_nama = ucwords(strtolower($this->pendidikan_nama));
            $this->pendidikan_namalainnya = strtoupper($this->pendidikan_namalainnya);
            return parent::beforeSave();
        }
}