<?php

/**
 * This is the model class for table "detailoperasi_m".
 *
 * The followings are the available columns in table 'detailoperasi_m':
 * @property integer $detailoperasi_id
 * @property integer $operasi_id
 * @property string $detailoperasi_nama
 * @property string $detailoperasi_namalainnya
 * @property boolean $detailoperasi_aktif
 */
class DetailOperasiM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DetailOperasiM the static model class
	 */
        public $operasi_nama;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'detailoperasi_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('operasi_id, detailoperasi_nama', 'required'),
			array('operasi_id', 'numerical', 'integerOnly'=>true),
			array('detailoperasi_nama, detailoperasi_namalainnya', 'length', 'max'=>100),
			array('detailoperasi_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('detailoperasi_id, operasi_id, operasi_nama, detailoperasi_nama, detailoperasi_namalainnya, detailoperasi_aktif', 'safe', 'on'=>'search'),
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
                    'operasi'=>array(self::BELONGS_TO,'OperasiM','operasi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'detailoperasi_id' => 'ID',
			'operasi_id' => 'Operasi',
			'detailoperasi_nama' => 'Nama Detail',
			'detailoperasi_namalainnya' => 'Nama Lainnya',
			'detailoperasi_aktif' => 'Aktif',
                        'operasi_nama'=>'Nama Operasi',
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

                $criteria->with=array('operasi');
		$criteria->compare('t.detailoperasi_id',$this->detailoperasi_id);
		$criteria->compare('t.operasi_id',$this->operasi_id);
		$criteria->compare('LOWER(t.detailoperasi_nama)',strtolower($this->detailoperasi_nama),true);
		$criteria->compare('LOWER(t.detailoperasi_namalainnya)',strtolower($this->detailoperasi_namalainnya),true);
		$criteria->compare('LOWER(operasi.operasi_nama)',strtolower($this->operasi_nama),true);
		$criteria->compare('t.detailoperasi_aktif',isset($this->detailoperasi_aktif)?$this->detailoperasi_aktif:true);
                //$criteria->addCondition('detailoperasi_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort' => array(
                            'attributes' => array(
                                'operasi_nama' => array(
                                    'asc' => 'operasi.operasi_nama ASC',
                                    'desc' => 'operasi.operasi_nama DESC',
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
		$criteria->compare('detailoperasi_id',$this->detailoperasi_id);
		$criteria->compare('operasi_id',$this->operasi_id);
		$criteria->compare('LOWER(detailoperasi_nama)',strtolower($this->detailoperasi_nama),true);
		$criteria->compare('LOWER(detailoperasi_namalainnya)',strtolower($this->detailoperasi_namalainnya),true);
//		$criteria->compare('detailoperasi_aktif',$this->detailoperasi_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function beforeSave() {
            $this->detailoperasi_nama = ucwords(strtolower($this->detailoperasi_nama));
            $this->detailoperasi_namalainnya = strtoupper($this->detailoperasi_namalainnya);
            return parent::beforeSave();
        }
}