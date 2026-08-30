<?php

/**
 * This is the model class for table "periksakomponendarah_t".
 *
 * The followings are the available columns in table 'periksakomponendarah_t':
 * @property string $periksakomponendarah_id
 * @property integer $terimakantongdet_id
 * @property string $tglperiksakompdarah
 * @property integer $petugasperiksakomp_id
 * @property integer $shift_id
 * @property integer $asalruangan_id
 * @property string $komponen_wb
 * @property string $komponen_prc
 * @property string $komponen_tc
 * @property string $komponen_ffp
 * @property string $periksakomp_ket
 * @property string $create_time
 * @property string $updat_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property TerimakantongdetT $terimakantongdet
 */
class PeriksakomponendarahT extends CActiveRecord
{
    public $no_barcode,$jeniskantongdarah,$tanggal_penerimaan_kantong,$golongan_darah,$rhesus,$ruangan_asal;
    public $petugasperiksakomp_nama, $terimakantongdarah_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PeriksakomponendarahT the static model class
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
		return 'periksakomponendarah_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('terimakantongdet_id, volume, tglperiksakompdarah, petugasperiksakomp_id, shift_id, asalruangan_id, komponen_wb, komponen_prc, komponen_tc, komponen_ffp, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('terimakantongdet_id, petugasperiksakomp_id, shift_id, asalruangan_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('komponen_wb, komponen_prc, komponen_tc, komponen_ffp', 'length', 'max'=>50),
			array('komponen_cry, periksakomp_ket, updat_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('periksakomponendarah_id, terimakantongdet_id, tglperiksakompdarah, petugasperiksakomp_id, shift_id, asalruangan_id, komponen_wb, komponen_prc, komponen_tc, komponen_ffp, periksakomp_ket, create_time, updat_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'terimakantongdet' => array(self::BELONGS_TO, 'TerimakantongdetT', 'terimakantongdet_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'petugasperiksakomp_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'periksakomponendarah_id' => 'Periksakomponendarah',
			'terimakantongdet_id' => 'Terimakantongdet',
			'tglperiksakompdarah' => 'Tglperiksakompdarah',
			'petugasperiksakomp_id' => 'Petugasperiksakomp',
			'shift_id' => 'Shift',
			'asalruangan_id' => 'Asalruangan',
			'komponen_wb' => 'Komponen Wb',
			'komponen_prc' => 'Komponen Prc',
			'komponen_tc' => 'Komponen Tc',
			'komponen_ffp' => 'Komponen Ffp',
			'periksakomp_ket' => 'Periksakomp Ket',
			'volume' => 'Volume',
			'create_time' => 'Waktu Create',
			'updat_time' => 'Updat Time',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria->compare('periksakomponendarah_id',$this->periksakomponendarah_id,true);
		$criteria->compare('terimakantongdet_id',$this->terimakantongdet_id);
		$criteria->compare('tglperiksakompdarah',$this->tglperiksakompdarah,true);
		$criteria->compare('petugasperiksakomp_id',$this->petugasperiksakomp_id);
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('asalruangan_id',$this->asalruangan_id);
		$criteria->compare('komponen_wb',$this->komponen_wb,true);
		$criteria->compare('komponen_prc',$this->komponen_prc,true);
		$criteria->compare('komponen_tc',$this->komponen_tc,true);
		$criteria->compare('komponen_ffp',$this->komponen_ffp,true);
		$criteria->compare('periksakomp_ket',$this->periksakomp_ket,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('updat_time',$this->updat_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}