<?php

/**
 * This is the model class for table "jeniswaktu_m".
 *
 * The followings are the available columns in table 'jeniswaktu_m':
 * @property integer $jeniswaktu_id
 * @property string $jeniswaktu_nama
 * @property string $jeniswaktu_namalain
 * @property string $jeniswaktu_jam
 * @property boolean $jeniswaktu_aktif
 */
class JeniswaktuM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JeniswaktuM the static model class
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
		return 'jeniswaktu_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jeniswaktu_nama, jeniswaktu_jam, urutan', 'required'),
			array('jeniswaktu_nama, jeniswaktu_namalain', 'length', 'max'=>50),
			array('jeniswaktu_jam', 'length', 'max'=>20),
			array('jeniswaktu_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jeniswaktu_id, jeniswaktu_nama, jeniswaktu_namalain, jeniswaktu_jam, jeniswaktu_aktif', 'safe', 'on'=>'search'),
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
			'jeniswaktu_id' => 'Jenis Waktu',
			'jeniswaktu_nama' => 'Jenis Waktu Nama',
			'jeniswaktu_namalain' => 'Jenis Waktu Nama Lain',
			'jeniswaktu_jam' => 'Jenis Waktu Jam',
			'jeniswaktu_aktif' => 'Aktif',
            'urutan' => 'Urutan',
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

		$criteria->compare('jeniswaktu_id',$this->jeniswaktu_id);
		$criteria->compare('LOWER(jeniswaktu_nama)',strtolower($this->jeniswaktu_nama),true);
		$criteria->compare('LOWER(jeniswaktu_namalain)',strtolower($this->jeniswaktu_namalain),true);
		$criteria->compare('LOWER(jeniswaktu_jam)',strtolower($this->jeniswaktu_jam),true);
		$criteria->compare('jeniswaktu_aktif',isset($this->jeniswaktu_aktif)?$this->jeniswaktu_aktif:true);
                //$criteria->addCondition('jeniswaktu_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('jeniswaktu_id',$this->jeniswaktu_id);
		$criteria->compare('LOWER(jeniswaktu_nama)',strtolower($this->jeniswaktu_nama),true);
		$criteria->compare('LOWER(jeniswaktu_namalain)',strtolower($this->jeniswaktu_namalain),true);
		$criteria->compare('LOWER(jeniswaktu_jam)',strtolower($this->jeniswaktu_jam),true);
		//$criteria->compare('jeniswaktu_aktif',$this->jeniswaktu_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public static function getJenisWaktu(){
            // return self::model()->findAll('jeniswaktu_aktif = true order by jeniswaktu_jam asc, jeniswaktu_nama asc');
			return self::model()->findAll('urutan in( 1, 3, 5) order by jeniswaktu_jam asc, jeniswaktu_nama asc');
        }
}