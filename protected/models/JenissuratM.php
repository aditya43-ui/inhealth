<?php

/**
 * This is the model class for table "jenissurat_m".
 *
 * The followings are the available columns in table 'jenissurat_m':
 * @property integer $jenissurat_id
 * @property string $jenissurat_nama
 * @property string $jenissurat_namalain
 * @property boolean $jenissurat_aktif
 */
class JenissuratM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JenisSuratM the static model class
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
		return 'jenissurat_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenissurat_nama', 'required'),
			array('jenissurat_nama, jenissurat_namalain', 'length', 'max'=>200),
			array('jenissurat_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jenissurat_id, jenissurat_nama, jenissurat_namalain, jenissurat_aktif', 'safe', 'on'=>'search'),
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
			'jenissurat_id' => 'ID',
			'jenissurat_nama' => 'Nama Jenis Surat',
			'jenissurat_namalain' => 'Nama Lain',
			'jenissurat_aktif' => 'Aktif',
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

		$criteria->compare('jenissurat_id',$this->jenissurat_id);
		$criteria->compare('LOWER(jenissurat_nama)',strtolower($this->jenissurat_nama),true);
		$criteria->compare('LOWER(jenissurat_namalain)',strtolower($this->jenissurat_namalain),true);
		$criteria->compare('jenissurat_aktif',isset($this->jenissurat_aktif)?$this->jenissurat_aktif:true);
                //$criteria->addCondition('jenissurat_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('jenissurat_id',$this->jenissurat_id);
		$criteria->compare('LOWER(jenissurat_nama)',strtolower($this->jenissurat_nama),true);
		$criteria->compare('LOWER(jenissurat_namalain)',strtolower($this->jenissurat_namalain),true);
		//$criteria->compare('jenissurat_aktif',$this->jenissurat_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}