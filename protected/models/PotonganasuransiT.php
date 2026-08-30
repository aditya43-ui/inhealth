<?php

/**
 * This is the model class for table "potonganasuransi_t".
 *
 * The followings are the available columns in table 'potonganasuransi_t':
 * @property integer $potonganasuransi_id
 * @property integer $pinjaman_id
 * @property integer $buktikaskeluarkop_id
 * @property string $tglpotonganasuransi
 * @property double $jml_pinjaman_asuransi
 * @property integer $umuranggota_thn
 * @property integer $lamaasuransi_thn
 * @property double $premi_asuransi_persen
 * @property double $jml_biayaasuransi
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property BuktikaskeluarkopT $buktikaskeluarkop
 * @property PinjamanT $pinjaman
 */
class PotonganasuransiT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PotonganasuransiT the static model class
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
		return 'potonganasuransi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pinjaman_id, tglpotonganasuransi, jml_pinjaman_asuransi, umuranggota_thn, lamaasuransi_thn, premi_asuransi_persen, jml_biayaasuransi, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pinjaman_id, buktikaskeluarkop_id, umuranggota_thn, lamaasuransi_thn, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('jml_pinjaman_asuransi, premi_asuransi_persen, jml_biayaasuransi', 'numerical'),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('potonganasuransi_id, pinjaman_id, buktikaskeluarkop_id, tglpotonganasuransi, jml_pinjaman_asuransi, umuranggota_thn, lamaasuransi_thn, premi_asuransi_persen, jml_biayaasuransi, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'buktikaskeluarkop' => array(self::BELONGS_TO, 'BuktikaskeluarkopT', 'buktikaskeluarkop_id'),
			'pinjaman' => array(self::BELONGS_TO, 'PinjamanT', 'pinjaman_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'potonganasuransi_id' => 'Potonganasuransi',
			'pinjaman_id' => 'Pinjaman',
			'buktikaskeluarkop_id' => 'Bukti Kas Keluar Kop',
			'tglpotonganasuransi' => 'Tglpotonganasuransi',
			'jml_pinjaman_asuransi' => 'Jml Pinjaman Asuransi',
			'umuranggota_thn' => 'Umuranggota Thn',
			'lamaasuransi_thn' => 'Lamaasuransi Thn',
			'premi_asuransi_persen' => 'Premi Asuransi Persen',
			'jml_biayaasuransi' => 'Jml Biayaasuransi',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
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

		$criteria->compare('potonganasuransi_id',$this->potonganasuransi_id);
		$criteria->compare('pinjaman_id',$this->pinjaman_id);
		$criteria->compare('buktikaskeluarkop_id',$this->buktikaskeluarkop_id);
		$criteria->compare('tglpotonganasuransi',$this->tglpotonganasuransi,true);
		$criteria->compare('jml_pinjaman_asuransi',$this->jml_pinjaman_asuransi);
		$criteria->compare('umuranggota_thn',$this->umuranggota_thn);
		$criteria->compare('lamaasuransi_thn',$this->lamaasuransi_thn);
		$criteria->compare('premi_asuransi_persen',$this->premi_asuransi_persen);
		$criteria->compare('jml_biayaasuransi',$this->jml_biayaasuransi);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}