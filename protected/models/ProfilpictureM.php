<?php

/**
 * This is the model class for table "profilpicture_m".
 *
 * The followings are the available columns in table 'profilpicture_m':
 * @property integer $profilpicture_id
 * @property integer $profilrs_id
 * @property string $profilpicture_tgl
 * @property string $profilpicture_nama
 * @property string $profilpicture_desc
 * @property boolean $display_antrian
 * @property string $profilpicture_path
 */
class ProfilpictureM extends CActiveRecord
{
        public $temp_gambar;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProfilpictureM the static model class
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
		return 'profilpicture_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('profilrs_id, profilpicture_tgl, profilpicture_path', 'required'),
			array('profilrs_id', 'numerical', 'integerOnly'=>true),
			array('profilpicture_nama', 'length', 'max'=>100),
			array('profilpicture_desc, display_antrian', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('profilpicture_id, profilrs_id, profilpicture_tgl, profilpicture_nama, profilpicture_desc, display_antrian, profilpicture_path', 'safe', 'on'=>'search'),
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
			'profilpicture_id' => 'Profil Picture',
			'profilrs_id' => 'Profil RS',
			'profilpicture_tgl' => 'Profil Picture Tgl',
			'profilpicture_nama' => 'Profil Picture Nama',
			'profilpicture_desc' => 'Profil Picture Description',
			'display_antrian' => 'Display Antrian',
			'profilpicture_path' => 'Profil Picture Path',
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

		$criteria->compare('profilpicture_id',$this->profilpicture_id);
		$criteria->compare('profilrs_id',$this->profilrs_id);
		$criteria->compare('LOWER(profilpicture_tgl)',strtolower($this->profilpicture_tgl),true);
		$criteria->compare('LOWER(profilpicture_nama)',strtolower($this->profilpicture_nama),true);
		$criteria->compare('LOWER(profilpicture_desc)',strtolower($this->profilpicture_desc),true);
		$criteria->compare('display_antrian',$this->display_antrian);
		$criteria->compare('LOWER(profilpicture_path)',strtolower($this->profilpicture_path),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getPicture()
    {
//            return DiagnosaM::model()->findAll('diagnosa_aktif=TRUE ORDER BY diagnosa_nama');
        return Yii::app()->db->createCommand('SELECT * FROM profilpicture_m where display_antrian=TRUE ORDER BY profilpicture_tgl, profilpicture_id DESC LIMIT 10')->queryAll();
    }
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('profilpicture_id',$this->profilpicture_id);
		$criteria->compare('profilrs_id',$this->profilrs_id);
		$criteria->compare('LOWER(profilpicture_tgl)',strtolower($this->profilpicture_tgl),true);
		$criteria->compare('LOWER(profilpicture_nama)',strtolower($this->profilpicture_nama),true);
		$criteria->compare('LOWER(profilpicture_desc)',strtolower($this->profilpicture_desc),true);
		$criteria->compare('display_antrian',$this->display_antrian);
		$criteria->compare('LOWER(profilpicture_path)',strtolower($this->profilpicture_path),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}