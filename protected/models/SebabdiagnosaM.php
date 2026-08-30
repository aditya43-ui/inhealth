<?php

/**
 * This is the model class for table "sebabdiagnosa_m".
 *
 * The followings are the available columns in table 'sebabdiagnosa_m':
 * @property integer $sebabdiagnosa_id
 * @property integer $jenissebab_id
 * @property string $sebabdiagnosa_nama
 * @property string $sebabdiagnosa_namalainnya
 * @property boolean $sebabdiagnosa_aktif
 */
class SebabdiagnosaM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SebabdiagnosaM the static model class
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
		return 'sebabdiagnosa_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenissebab_id, sebabdiagnosa_nama', 'required'),
			array('jenissebab_id', 'numerical', 'integerOnly'=>true),
			array('sebabdiagnosa_nama, sebabdiagnosa_namalainnya', 'length', 'max'=>100),
			array('sebabdiagnosa_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('sebabdiagnosa_id, jenissebab_id, sebabdiagnosa_nama, sebabdiagnosa_namalainnya, sebabdiagnosa_aktif', 'safe', 'on'=>'search'),
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
                                    'jenissebab'=>array(self::BELONGS_TO,'JenissebabM','jenissebab_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'sebabdiagnosa_id' => 'ID',
			'jenissebab_id' => 'Jenis Sebab',
			'sebabdiagnosa_nama' => 'Nama Sebab Diagnosa',
			'sebabdiagnosa_namalainnya' => 'Nama Lainnya',
			'sebabdiagnosa_aktif' => 'Aktif',
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

		$criteria->compare('sebabdiagnosa_id',$this->sebabdiagnosa_id);
		$criteria->compare('jenissebab_id',$this->jenissebab_id);
		$criteria->compare('LOWER(sebabdiagnosa_nama)',strtolower($this->sebabdiagnosa_nama),true);
		$criteria->compare('LOWER(sebabdiagnosa_namalainnya)',strtolower($this->sebabdiagnosa_namalainnya),true);
		$criteria->compare('sebabdiagnosa_aktif',isset($this->sebabdiagnosa_aktif)?$this->sebabdiagnosa_aktif:true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('sebabdiagnosa_id',$this->sebabdiagnosa_id);
		$criteria->compare('jenissebab_id',$this->jenissebab_id);
		$criteria->compare('LOWER(sebabdiagnosa_nama)',strtolower($this->sebabdiagnosa_nama),true);
		$criteria->compare('LOWER(sebabdiagnosa_namalainnya)',strtolower($this->sebabdiagnosa_namalainnya),true);
		$criteria->compare('sebabdiagnosa_aktif',$this->sebabdiagnosa_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }

        public function getJenisSebabItems()
        {
            return JenissebabM::model()->findAll('jenissebab_aktif=true ORDER BY jenissebab_nama');
        }
}