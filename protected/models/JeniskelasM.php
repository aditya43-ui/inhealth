<?php

/**
 * This is the model class for table "jeniskelas_m".
 *
 * The followings are the available columns in table 'jeniskelas_m':
 * @property integer $jeniskelas_id
 * @property string $jeniskelas_nama
 * @property string $jeniskelas_namalainnya
 * @property boolean $jeniskelas_aktif
 *
 * The followings are the available model relations:
 * @property KelaspelayananM[] $kelaspelayananMs
 */
class JeniskelasM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JeniskelasM the static model class
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
		return 'jeniskelas_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jeniskelas_nama', 'required'),
			array('jeniskelas_nama, jeniskelas_namalainnya', 'length', 'max'=>25),
			array('jeniskelas_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jeniskelas_id, jeniskelas_nama, jeniskelas_namalainnya, jeniskelas_aktif', 'safe', 'on'=>'search'),
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
			'kelaspelayananMs' => array(self::HAS_MANY, 'KelaspelayananM', 'jeniskelas_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'jeniskelas_id' => 'ID',
			'jeniskelas_nama' => 'Jenis Kelas',
			'jeniskelas_namalainnya' => 'Nama Lain',
			'jeniskelas_aktif' => 'Aktif',
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

		$criteria->compare('jeniskelas_id',$this->jeniskelas_id);
		$criteria->compare('LOWER(jeniskelas_nama)',strtolower($this->jeniskelas_nama),true);
		$criteria->compare('LOWER(jeniskelas_namalainnya)',strtolower($this->jeniskelas_namalainnya),true);
		$criteria->compare('jeniskelas_aktif',isset($this->jeniskelas_aktif)?$this->jeniskelas_aktif:true);
//                $criteria->addCondition('jeniskelas_aktif is true');
                $criteria->order='jeniskelas_nama';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchPrint()
         {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;

            $criteria->compare('jeniskelas_id',$this->jeniskelas_id);
            $criteria->compare('LOWER(jeniskelas_nama)',strtolower($this->jeniskelas_nama),true);
            $criteria->compare('LOWER(jeniskelas_namalainnya)',strtolower($this->jeniskelas_namalainnya),true);
//            $criteria->compare('jeniskelas_aktif',$this->jeniskelas_aktif);
            $criteria->order='jeniskelas_nama';
            $criteria->limit=-1; //Klo limit lebih kecil dari nol itu berarti ga ada limit http://www.yiiframework.com/doc/api/1.1/CDbCriteria#limit-detail

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
         }
        
        public function beforeSave() {
            $this->jeniskelas_nama = ucwords(strtolower($this->jeniskelas_nama));
            $this->jeniskelas_namalainnya = strtoupper($this->jeniskelas_namalainnya);
            return parent::beforeSave();
        }
}