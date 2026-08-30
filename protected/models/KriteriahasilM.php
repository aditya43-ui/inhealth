<?php

/**
 * This is the model class for table "kriteriahasil_m".
 *
 * The followings are the available columns in table 'kriteriahasil_m':
 * @property integer $kriteriahasil_id
 * @property integer $diagnosakep_id
 * @property string $kriteriahasil_nama
 * @property string $kriteriahasil_namalain
 * @property boolean $kriteriahasil_aktif
 */
class KriteriahasilM extends CActiveRecord
{
	public $diagnosakep_nama;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KriteriahasilM the static model class
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
		return 'kriteriahasil_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(//diagnosakep_id
			array('luarankeperawatan_id, kriteriahasil_nama', 'required'),
			array('diagnosakep_id', 'numerical', 'integerOnly'=>true),
			array('kriteriahasil_nama, kriteriahasil_namalain', 'length', 'max'=>200),
			array('kriteriahasil_aktif, diagnosakep_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kriteriahasil_id, diagnosakeperawatan_id, kriteriahasil_nama, kriteriahasil_namalain, kriteriahasil_aktif', 'safe', 'on'=>'search'),
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
                    'kriteriahasil'=>array(self::HAS_MANY, 'KriteriahasilM', 'kriteriahasil_id'),
                    'diagnosakeperawatan'=>array(self::BELONGS_TO, 'DiagnosakeperawatanM', 'diagnosakeperawatan_id'),
                    'luarankeperawatan'=>array(self::BELONGS_TO, 'LuarankeperawatanM', 'luarankeperawatan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kriteriahasil_id' => 'ID',
			'diagnosakeperawatan_id' => 'Diagnosa Keperawatan',
			'kriteriahasil_nama' => 'Kriteria Hasil',
			'kriteriahasil_namalain' => 'Nama Lain',
			'kriteriahasil_aktif' => 'Aktif',
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

		$criteria->compare('kriteriahasil_id',$this->kriteriahasil_id);
		$criteria->compare('diagnosakeperawatan_id',$this->diagnosakeperawatan_id);
		$criteria->compare('LOWER(kriteriahasil_nama)',strtolower($this->kriteriahasil_nama),true);
		$criteria->compare('LOWER(kriteriahasil_namalain)',strtolower($this->kriteriahasil_namalain),true);
		$criteria->compare('kriteriahasil_aktif',$this->kriteriahasil_aktif);
                $criteria->addCondition('kriteriahasil_aktif is true');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('kriteriahasil_id',$this->kriteriahasil_id);
		$criteria->compare('diagnosakeperawatan_id',$this->diagnosakeperawatan_id);
		$criteria->compare('LOWER(kriteriahasil_nama)',strtolower($this->kriteriahasil_nama),true);
		$criteria->compare('LOWER(kriteriahasil_namalain)',strtolower($this->kriteriahasil_namalain),true);
		$criteria->compare('kriteriahasil_aktif',$this->kriteriahasil_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}