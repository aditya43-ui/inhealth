<?php

/**
 * This is the model class for table "tindakanrm_m".
 *
 * The followings are the available columns in table 'tindakanrm_m':
 * @property integer $tindakanrm_id
 * @property integer $jenistindakanrm_id
 * @property integer $daftartindakan_id
 * @property string $tindakanrm_nama
 * @property string $tindakanrm_namalainnya
 * @property boolean $tindakanrm_aktif
 */
class TindakanrmM extends CActiveRecord
{

	public $daftartindakan_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TindakanrmM the static model class
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
		return 'tindakanrm_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenistindakanrm_id, daftartindakan_id, tindakanrm_nama', 'required'),
			array('jenistindakanrm_id, daftartindakan_id', 'numerical', 'integerOnly'=>true),
			array('tindakanrm_nama, tindakanrm_namalainnya', 'length', 'max'=>100),
			array('tindakanrm_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tindakanrm_id, jenistindakanrm_id, daftartindakan_id, daftartindakan_nama, tindakanrm_nama, tindakanrm_namalainnya, tindakanrm_aktif', 'safe', 'on'=>'search'),
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

                    'daftartindakan'=>array(self::BELONGS_TO,'DaftartindakanM','daftartindakan_id'),
                    'jenistindakanrm'=>array(self::BELONGS_TO, 'JenistindakanrmM','jenistindakanrm_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tindakanrm_id' => 'ID',
			'jenistindakanrm_id' => 'Jenis Tindakan',
			'daftartindakan_id' => 'Daftar Tindakan',
			'tindakanrm_nama' => 'Uraian Tindakan',
			'tindakanrm_namalainnya' => 'Nama Lain Tindakan',
			'tindakanrm_aktif' => 'Aktif',
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

		$criteria->compare('tindakanrm_id',$this->tindakanrm_id);
		$criteria->compare('jenistindakanrm_id',$this->jenistindakanrm_id);
		$criteria->compare('t.daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('LOWER(daftartindakan.daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
		$criteria->compare('LOWER(tindakanrm_nama)',strtolower($this->tindakanrm_nama),true);
		$criteria->compare('LOWER(tindakanrm_namalainnya)',strtolower($this->tindakanrm_namalainnya),true);
		$criteria->compare('tindakanrm_aktif',isset($this->tindakanrm_aktif)?$this->tindakanrm_aktif:true);
			$criteria->with=array('daftartindakan');
                //$criteria->addCondition('tindakanrm_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort'=>array(
                            'attributes'=>array(
                                'daftartindakan_nama'=>array(
                                    'asc'=>'daftartindakan.daftartindakan_nama',
                                    'desc'=>'daftartindakan.daftartindakan_nama DESC',
                                ),
                                '*',
                            ),
		)));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('tindakanrm_id',$this->tindakanrm_id);
		$criteria->compare('jenistindakanrm_id',$this->jenistindakanrm_id);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('LOWER(tindakanrm_nama)',strtolower($this->tindakanrm_nama),true);
		$criteria->compare('LOWER(tindakanrm_namalainnya)',strtolower($this->tindakanrm_namalainnya),true);
		$criteria->compare('tindakanrm_aktif',$this->tindakanrm_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}