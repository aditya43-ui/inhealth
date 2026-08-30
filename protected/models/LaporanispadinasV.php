<?php

/**
 * This is the model class for table "laporanispadinas_v".
 *
 * The followings are the available columns in table 'laporanispadinas_v':
 * @property double $tahun
 * @property double $bulan
 * @property integer $instalasi_id
 * @property integer $ruangan_id
 * @property integer $pendaftaran_id
 * @property string $umur
 * @property string $jeniskelamin
 * @property boolean $is_mneumonia
 * @property boolean $ismeninggal
 */
class LaporanispadinasV extends CActiveRecord
{
	public $tahun;
	public $bulan;
	
	public $pneumonia_1_4_lk;
	public $pneumonia_1_4_pr;
	public $pneumonia_0_lk;
	public $pneumonia_0_pr;
	public $pneumonia_5_sub;
	
	public $notpneumonia_1_4_lk;
	public $notpneumonia_1_4_pr;
	public $notpneumonia_0_lk;
	public $notpneumonia_0_pr;
	public $notpneumonia_5_sub;
	
	public $matipneumonia_1_4_lk;
	public $matipneumonia_1_4_pr;
	public $matipneumonia_0_lk;
	public $matipneumonia_0_pr;
	public $matipneumonia_5_sub;
	
	public $pneumonia_5_lk;
	public $pneumonia_5_pr;
	public $notpneumonia_5_lk;
	public $notpneumonia_5_pr;
	public $subpneumonia_5;	
	
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanispadinasV the static model class
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
		return 'laporanispadinas_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('instalasi_id, ruangan_id, pendaftaran_id', 'numerical', 'integerOnly'=>true),
			array('tahun, bulan', 'numerical'),
			array('umur', 'length', 'max'=>30),
			array('jeniskelamin', 'length', 'max'=>20),
			array('is_mneumonia, ismeninggal', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tahun, bulan, instalasi_id, ruangan_id, pendaftaran_id, umur, jeniskelamin, is_mneumonia, ismeninggal', 'safe', 'on'=>'search'),
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
			'tahun' => 'Tahun',
			'bulan' => 'Bulan',
			'instalasi_id' => 'Instalasi',
			'ruangan_id' => 'Ruangan',
			'pendaftaran_id' => 'Pendaftaran',
			'umur' => 'Umur',
			'jeniskelamin' => 'Jenis Kelamin',
			'is_mneumonia' => 'Is Mneumonia',
			'ismeninggal' => 'Ismeninggal',
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

		$criteria->compare('tahun',$this->tahun);
		$criteria->compare('bulan',$this->bulan);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('umur',$this->umur,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('is_mneumonia',$this->is_mneumonia);
		$criteria->compare('ismeninggal',$this->ismeninggal);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}