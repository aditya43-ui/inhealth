<?php

/**
 * This is the model class for table "realisasikenpangkat_r".
 *
 * The followings are the available columns in table 'realisasikenpangkat_r':
 * @property integer $realisasikenpangkat_id
 * @property integer $kenaikanpangkat_id
 * @property string $realisasikenpangkat_tglsk
 * @property string $realisasikenpangkat_nosk
 * @property integer $realisasikenpangkat_masakerjath
 * @property integer $realisasiken_masakerjabln
 * @property double $realisasiken_gajipokok
 * @property string $realisasiken_pejabatygberwenang
 */
class RealisasikenpangkatR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RealisasikenpangkatR the static model class
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
		return 'realisasikenpangkat_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('realisasikenpangkat_tglsk, realisasikenpangkat_nosk, realisasikenpangkat_masakerjath, realisasiken_masakerjabln, realisasiken_gajipokok, realisasiken_pejabatygberwenang', 'required'),
			array('kenaikanpangkat_id, realisasikenpangkat_masakerjath, realisasiken_masakerjabln', 'numerical', 'integerOnly'=>true),
			array('realisasiken_gajipokok', 'numerical'),
			array('realisasikenpangkat_nosk, realisasiken_pejabatygberwenang', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('realisasikenpangkat_id, kenaikanpangkat_id, realisasikenpangkat_tglsk, realisasikenpangkat_nosk, realisasikenpangkat_masakerjath, realisasiken_masakerjabln, realisasiken_gajipokok, realisasiken_pejabatygberwenang', 'safe', 'on'=>'search'),
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
			'realisasikenpangkat_id' => 'Realisasikenpangkat',
			'kenaikanpangkat_id' => 'ID',
			'realisasikenpangkat_tglsk' => 'Tanggal SK',
			'realisasikenpangkat_nosk' => 'Nomer SK',
			'realisasikenpangkat_masakerjath' => 'Tahun',
			'realisasiken_masakerjabln' => 'Bulan',
			'realisasiken_gajipokok' => 'Gaji Pokok',
			'realisasiken_pejabatygberwenang' => 'Mengetahui',
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

		$criteria->compare('realisasikenpangkat_id',$this->realisasikenpangkat_id);
		$criteria->compare('kenaikanpangkat_id',$this->kenaikanpangkat_id);
		$criteria->compare('LOWER(realisasikenpangkat_tglsk)',strtolower($this->realisasikenpangkat_tglsk),true);
		$criteria->compare('LOWER(realisasikenpangkat_nosk)',strtolower($this->realisasikenpangkat_nosk),true);
		$criteria->compare('realisasikenpangkat_masakerjath',$this->realisasikenpangkat_masakerjath);
		$criteria->compare('realisasiken_masakerjabln',$this->realisasiken_masakerjabln);
		$criteria->compare('realisasiken_gajipokok',$this->realisasiken_gajipokok);
		$criteria->compare('LOWER(realisasiken_pejabatygberwenang)',strtolower($this->realisasiken_pejabatygberwenang),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('realisasikenpangkat_id',$this->realisasikenpangkat_id);
		$criteria->compare('kenaikanpangkat_id',$this->kenaikanpangkat_id);
		$criteria->compare('LOWER(realisasikenpangkat_tglsk)',strtolower($this->realisasikenpangkat_tglsk),true);
		$criteria->compare('LOWER(realisasikenpangkat_nosk)',strtolower($this->realisasikenpangkat_nosk),true);
		$criteria->compare('realisasikenpangkat_masakerjath',$this->realisasikenpangkat_masakerjath);
		$criteria->compare('realisasiken_masakerjabln',$this->realisasiken_masakerjabln);
		$criteria->compare('realisasiken_gajipokok',$this->realisasiken_gajipokok);
		$criteria->compare('LOWER(realisasiken_pejabatygberwenang)',strtolower($this->realisasiken_pejabatygberwenang),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}