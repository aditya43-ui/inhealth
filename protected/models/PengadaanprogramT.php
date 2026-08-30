<?php

/**
 * This is the model class for table "pengadaanprogram_t".
 *
 * The followings are the available columns in table 'pengadaanprogram_t':
 * @property integer $pengadaanprogram_id
 * @property integer $persiapanpengadaan_id
 * @property integer $rencanaumumpengadaan_id
 * @property integer $programkerja_id
 * @property integer $subprogramkerja_id
 * @property integer $kegiatanprogram_id
 * @property integer $subkegiatanprogram_id
 * @property integer $suratperjanjiankerja_id
 *
 * The followings are the available model relations:
 * @property SuratperjanjiankerjaT $suratperjanjiankerja
 * @property PersiapanpengadaanT $persiapanpengadaan
 * @property RencanaumumpengadaanT $rencanaumumpengadaan
 */
class PengadaanprogramT extends CActiveRecord
{
        public $subkegiatanprogram_nama;
        public $kegiatanprogram_nama;
        public $programkerja_nama;        
        public $subprogramkerja_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengadaanprogramT the static model class
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
		return 'pengadaanprogram_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('persiapanpengadaan_id, rencanaumumpengadaan_id, programkerja_id, subprogramkerja_id, kegiatanprogram_id, subkegiatanprogram_id, suratperjanjiankerja_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pengadaanprogram_id, persiapanpengadaan_id, rencanaumumpengadaan_id, programkerja_id, subprogramkerja_id, kegiatanprogram_id, subkegiatanprogram_id, suratperjanjiankerja_id', 'safe', 'on'=>'search'),
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
                    'suratperjanjiankerja' => array(self::BELONGS_TO, 'SuratperjanjiankerjaT', 'suratperjanjiankerja_id'),
                    'persiapanpengadaan' => array(self::BELONGS_TO, 'PersiapanpengadaanT', 'persiapanpengadaan_id'),
                    'rencanaumumpengadaan' => array(self::BELONGS_TO, 'RencanaumumpengadaanT', 'rencanaumumpengadaan_id'),
                    'programkerja' => array(self::BELONGS_TO, 'ProgramkerjaM', 'programkerja_id'),
                    'subprogramkerja' => array(self::BELONGS_TO, 'SubprogramkerjaM', 'subprogramkerja_id'),
                    'kegiatanprogram' => array(self::BELONGS_TO, 'KegiatanprogramM', 'kegiatanprogram_id'),
                    'subkegiatanprogram' => array(self::BELONGS_TO, 'SubkegiatanprogramM', 'subkegiatanprogram_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pengadaanprogram_id' => 'Pengadaanprogram',
			'persiapanpengadaan_id' => 'Persiapanpengadaan',
			'rencanaumumpengadaan_id' => 'Rencanaumumpengadaan',
			'programkerja_id' => 'Programkerja',
			'subprogramkerja_id' => 'Subprogramkerja',
			'kegiatanprogram_id' => 'Kegiatanprogram',
			'subkegiatanprogram_id' => 'Subkegiatanprogram',
			'suratperjanjiankerja_id' => 'Suratperjanjiankerja',
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

		$criteria->compare('pengadaanprogram_id',$this->pengadaanprogram_id);
		$criteria->compare('persiapanpengadaan_id',$this->persiapanpengadaan_id);
		$criteria->compare('rencanaumumpengadaan_id',$this->rencanaumumpengadaan_id);
		$criteria->compare('programkerja_id',$this->programkerja_id);
		$criteria->compare('subprogramkerja_id',$this->subprogramkerja_id);
		$criteria->compare('kegiatanprogram_id',$this->kegiatanprogram_id);
		$criteria->compare('subkegiatanprogram_id',$this->subkegiatanprogram_id);
		$criteria->compare('suratperjanjiankerja_id',$this->suratperjanjiankerja_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}