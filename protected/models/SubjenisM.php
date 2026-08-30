<?php

/**
 * This is the model class for table "subjenis_m".
 *
 * The followings are the available columns in table 'subjenis_m':
 * @property integer $subjenis_id
 * @property integer $jenisobatalkes_id
 * @property string $subjenis_kode
 * @property string $subjenis_nama
 * @property string $subjenis_namalainnya
 * @property boolean $subjenis_farmasi
 * @property boolean $subjenis_aktif
 */
class SubjenisM extends CActiveRecord
{
        public $jenisobatalkes_nama;
        public $default;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SubjenisM the static model class
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
		return 'subjenis_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenisobatalkes_id, subjenis_kode, subjenis_nama', 'required'),
			array('jenisobatalkes_id', 'numerical', 'integerOnly'=>true),
			array('subjenis_kode', 'length', 'max'=>10),
			array('subjenis_nama, subjenis_namalainnya', 'length', 'max'=>100),
			array('subjenis_farmasi, subjenis_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('subjenis_id, jenisobatalkes_id, subjenis_kode, subjenis_nama, subjenis_namalainnya, subjenis_farmasi, subjenis_aktif', 'safe', 'on'=>'search'),
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
                     'jenisobatalkes'=>array(self::BELONGS_TO, 'JenisobatalkesM','jenisobatalkes_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'subjenis_id' => 'ID',
			'jenisobatalkes_id' => 'Kategori Barang',
			'subjenis_kode' => 'Sub Kategori Kode',
			'subjenis_nama' => 'Sub Kategori Nama',
			'subjenis_namalainnya' => 'Nama Lainnya',
			'subjenis_farmasi' => 'Sub Kategori Farmasi',
			'subjenis_aktif' => 'Sub Kategori Aktif',
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
                $criteria->select = [
                    "t.*",
                    "joa.jenisobatalkes_nama"
                ];
                $criteria->join = " LEFT JOIN jenisobatalkes_m joa ON joa.jenisobatalkes_id = t.jenisobatalkes_id ";
		$criteria->compare('t.subjenis_id',$this->subjenis_id);
		$criteria->compare('t.jenisobatalkes_id',$this->jenisobatalkes_id);
		$criteria->compare('LOWER(t.subjenis_kode)',strtolower($this->subjenis_kode),true);
                $criteria->compare('LOWER(t.jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
		$criteria->compare('LOWER(t.subjenis_nama)',strtolower($this->subjenis_nama),true);
		$criteria->compare('LOWER(t.subjenis_namalainnya)',strtolower($this->subjenis_namalainnya),true);
		$criteria->compare('t.subjenis_farmasi',$this->subjenis_farmasi);
		$criteria->compare('t.subjenis_aktif',$this->subjenis_aktif);
                $criteria->addCondition('t.subjenis_aktif is true');
                
                if (!empty($this->default)){
                    $criteria->addCondition(" subjenis_id  IS NULL ");
                }

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('subjenis_id',$this->subjenis_id);
		$criteria->compare('jenisobatalkes_id',$this->jenisobatalkes_id);
		$criteria->compare('LOWER(subjenis_kode)',strtolower($this->subjenis_kode),true);
		$criteria->compare('LOWER(subjenis_nama)',strtolower($this->subjenis_nama),true);
		$criteria->compare('LOWER(subjenis_namalainnya)',strtolower($this->subjenis_namalainnya),true);
//		$criteria->compare('subjenis_farmasi',$this->subjenis_farmasi);
		$criteria->compare('subjenis_aktif',$this->subjenis_aktif);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}