<?php

/**
 * This is the model class for table "realisasilemburdet_t".
 *
 * The followings are the available columns in table 'realisasilemburdet_t':
 * @property integer $realisasilemburdet_id
 * @property integer $realisasilembur_id
 * @property integer $pegawai_id
 * @property string $nourut
 * @property string $alasanlembur
 * @property string $tglmulai
 * @property string $tglselesai
 * @property integer $total_jam
 * @property double $nilai_lembur
 * @property double $total_nilai_lembur
 *
 * The followings are the available model relations:
 * @property PegawaiM $pegawai
 * @property RealisasilemburT $realisasilembur
 */
class RealisasilemburdetT extends CActiveRecord
{
    public $jamMulai, $jamSelesai;
    public $nomorindukpegawai;
    public $upah_lembur_jam1;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RealisasilemburdetT the static model class
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
		return 'realisasilemburdet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglmulai, total_jam', 'required'),
			array('realisasilembur_id, pegawai_id, total_jam', 'numerical', 'integerOnly'=>true),
			array('nilai_lembur, total_nilai_lembur, upahsejamlembur', 'numerical'),
			array('nourut', 'length', 'max'=>3),
			array('alasanlembur', 'length', 'max'=>500),
			array('tglselesai, upahsejamlembur', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('realisasilemburdet_id, realisasilembur_id, pegawai_id, nourut, alasanlembur, tglmulai, tglselesai, total_jam, nilai_lembur, total_nilai_lembur, upahsejamlembur', 'safe', 'on'=>'search'),
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
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'realisasilembur' => array(self::BELONGS_TO, 'RealisasilemburT', 'realisasilembur_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'realisasilemburdet_id' => 'Realisasilemburdet',
			'realisasilembur_id' => 'Realisasilembur',
			'pegawai_id' => 'Pegawai',
			'nourut' => 'Nourut',
			'alasanlembur' => 'Alasanlembur',
			'tglmulai' => 'Tglmulai',
			'tglselesai' => 'Tglselesai',
			'total_jam' => 'Total Jam',
			'nilai_lembur' => 'Nilai Lembur',
			'total_nilai_lembur' => 'Total Nilai Lembur',
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

		$criteria->compare('realisasilemburdet_id',$this->realisasilemburdet_id);
		$criteria->compare('realisasilembur_id',$this->realisasilembur_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('nourut',$this->nourut,true);
		$criteria->compare('alasanlembur',$this->alasanlembur,true);
		$criteria->compare('tglmulai',$this->tglmulai,true);
		$criteria->compare('tglselesai',$this->tglselesai,true);
		$criteria->compare('total_jam',$this->total_jam);
		$criteria->compare('nilai_lembur',$this->nilai_lembur);
		$criteria->compare('total_nilai_lembur',$this->total_nilai_lembur);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}