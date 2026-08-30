<?php

/**
 * This is the model class for table "jadwalmakan_m".
 *
 * The followings are the available columns in table 'jadwalmakan_m':
 * @property integer $jadwalmakan_id
 * @property integer $jeniswaktu_id
 * @property integer $jenisdiet_id
 * @property integer $tipediet_id
 * @property integer $menudiet_id
 */
class JadwalMakanM extends CActiveRecord
{
        public $jeniswaktu_nama;
        public $jenisdiet_nama;
        public $tipediet_nama;
        public $menudiet_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JadwalMakanM the static model class
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
		return 'jadwalmakan_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jeniswaktu_id, jenisdiet_id, tipediet_id, menudiet_id', 'required'),
			array('jeniswaktu_id, jenisdiet_id, tipediet_id, menudiet_id', 'numerical', 'integerOnly'=>true),
                        array('menudiet_nama, jeniswaktu_nama, jenisdiet_nama, tipediet_nama','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('menudiet_nama, jadwalmakan_id, jeniswaktu_id, jenisdiet_id, tipediet_id, menudiet_id', 'safe', 'on'=>'search'),
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
                                    'jeniswaktu' => array(self::BELONGS_TO,'JenisWaktuM','jeniswaktu_id'),
                                    'tipediet' => array(self::BELONGS_TO,'TipeDietM','tipediet_id'),
                                    'jenisdiet' => array(self::BELONGS_TO,'JenisdietM','jenisdiet_id'),
                                    'menudiet' => array(self::BELONGS_TO,'MenuDietM', 'menudiet_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'jadwalmakan_id' => 'ID',
			'jeniswaktu_id' => 'Jenis Waktu',
			'jenisdiet_id' => 'Jenis Diet',
			'tipediet_id' => 'Tipe Diet',
			'menudiet_id' => 'Menu Diet',
                    
                                                'jenisdiet_nama'=>'Jenis diet',
                                                'tipediet_nama'=>'Tipe diet',
                                                'menudiet_nama'=>'Menu diet',
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

		$criteria->compare('jadwalmakan_id',$this->jadwalmakan_id);
		$criteria->compare('jeniswaktu_id',$this->jeniswaktu_id);
		$criteria->compare('jenisdiet_id',$this->jenisdiet_id);
		$criteria->compare('tipediet_id',$this->tipediet_id);
		$criteria->compare('menudiet_id',$this->menudiet_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('jadwalmakan_id',$this->jadwalmakan_id);
		$criteria->compare('jeniswaktu_id',$this->jeniswaktu_id);
		$criteria->compare('jenisdiet_id',$this->jenisdiet_id);
		$criteria->compare('tipediet_id',$this->tipediet_id);
		$criteria->compare('menudiet_id',$this->menudiet_id);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function getJenisWaktuItems()
        {
            return JenisWaktuM::model()->findAll('jeniswaktu_aktif=TRUE ORDER BY jeniswaktu_nama');
        }
        
        public function getJenisdietItems()
        {
            return JenisdietM::model()->findAll('jenisdiet_aktif=TRUE ORDER BY jenisdiet_nama');
        }
        
        public function getTipeDietItems()
        {
            return TipeDietM::model()->findAll('tipediet_aktif=TRUE ORDER BY tipediet_nama');
        }
        
        public function getMenuDietItems()
        {
            return MenuDietM::model()->findAll(array('order'=>'menudiet_nama'));
        }
}