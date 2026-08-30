<?php

/**
 * This is the model class for table "jenistarif_m".
 *
 * The followings are the available columns in table 'jenistarif_m':
 * @property integer $jenistarif_id
 * @property string $jenistarif_nama
 * @property string $jenistarif_namalainnya
 * @property boolean $jenistarif_aktif
 */
class JenistarifM extends CActiveRecord
{
	public $penjamin_nama;
	public $penjamin_id;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JenistarifM the static model class
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
		return 'jenistarif_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenistarif_nama', 'required'),
			array('jenistarif_nama, jenistarif_namalainnya', 'length', 'max'=>25),
			array('jenistarif_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jenistarif_id, jenistarif_nama, jenistarif_namalainnya, jenistarif_aktif', 'safe', 'on'=>'search'),
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
			'jenistarif_id' => 'ID',
			'jenistarif_nama' => 'Jenis Tarif',
			'jenistarif_namalainnya' => 'Nama Lain',
			'jenistarif_aktif' => 'Aktif',
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

		$criteria->compare('jenistarif_id',$this->jenistarif_id);
		$criteria->compare('LOWER(jenistarif_nama)',strtolower($this->jenistarif_nama),true);
		$criteria->compare('LOWER(jenistarif_namalainnya)',strtolower($this->jenistarif_namalainnya),true);
		$criteria->compare('jenistarif_aktif',isset($this->jenistarif_aktif)?$this->jenistarif_aktif:true);
//                $criteria->addCondition('jenistarif_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('jenistarif_id',$this->jenistarif_id);
		$criteria->compare('LOWER(jenistarif_nama)',strtolower($this->jenistarif_nama),true);
		$criteria->compare('LOWER(jenistarif_namalainnya)',strtolower($this->jenistarif_namalainnya),true);
//		$criteria->compare('jenistarif_aktif',$this->jenistarif_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                         'pagination'=>false,
                ));
        }
        
        public function beforeSave() {
            $this->jenistarif_nama = ucwords(strtolower($this->jenistarif_nama));
            $this->jenistarif_namalainnya = strtoupper($this->jenistarif_namalainnya);
            return parent::beforeSave();
        }
}