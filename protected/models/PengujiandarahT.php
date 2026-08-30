<?php

/**
 * This is the model class for table "pengujiandarah_t".
 *
 * The followings are the available columns in table 'pengujiandarah_t':
 * @property integer $pengujiandarah_id
 * @property integer $terimakantongdet_id
 * @property string $tglpengujian
 * @property integer $petugaspengujian_id
 * @property integer $shift_id
 * @property integer $asalruangan_id
 * @property string $anti_a
 * @property string $anti_b
 * @property string $anti_d
 * @property string $anti_ab
 * @property string $sel_a
 * @property string $sel_b
 * @property string $sel_o
 * @property string $gol_darah
 * @property string $rhesus
 * @property string $hasil_uji
 * @property string $ket_hasiluji
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class PengujiandarahT extends CActiveRecord
{

        public $petugaspengujian_nama,$tgl_awal,$tgl_akhir,$tanggal,$no_kantong_darah,$goldar_awal,$rhesus_awal,$goldar_akhir,$rhesus_akhir,$keterangan;
        public $berubahdata;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengujiandarahT the static model class
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
		return 'pengujiandarah_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglpengujian, petugaspengujian_id, shift_id, asalruangan_id,  hasil_uji, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('terimakantongdet_id, petugaspengujian_id, shift_id, asalruangan_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('anti_a, anti_b, anti_d, anti_ab, sel_a, sel_b, sel_o, hasil_uji', 'length', 'max'=>50),
			array('gol_darah', 'length', 'max'=>2),
			array('rhesus', 'length', 'max'=>20),
			array('ket_hasiluji', 'length', 'max'=>255),
			array('gol_darah_awal, rhesus_awal, nomorbarcode_sample, pengujian_ke, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pengujiandarah_id, terimakantongdet_id, tglpengujian, petugaspengujian_id, shift_id, asalruangan_id, anti_a, anti_b, anti_d, anti_ab, sel_a, sel_b, sel_o, gol_darah, rhesus, hasil_uji, ket_hasiluji, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
                    'petugaspengujian' => array(self::BELONGS_TO,'PegawaiM','petugaspengujian_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pengujiandarah_id' => 'Pengujiandarah',
			'terimakantongdet_id' => 'Terimakantongdet',
			'tglpengujian' => 'Tglpengujian',
			'petugaspengujian_id' => 'Petugaspengujian',
			'shift_id' => 'Shift',
                        'instalasi_id' => 'Instalasi',
			'asalruangan_id' => 'Asal Ruangan',
			'anti_a' => 'Anti A',
			'anti_b' => 'Anti B',
			'anti_d' => 'Anti D',
			'anti_ab' => 'Anti Ab',
			'sel_a' => 'Sel A',
			'sel_b' => 'Sel B',
			'sel_o' => 'Sel O',
			'gol_darah' => 'Gol Darah',
			'rhesus' => 'Rhesus',
			'hasil_uji' => 'Hasil Uji',
			'ket_hasiluji' => 'Ket Hasiluji',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
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

		$criteria->compare('pengujiandarah_id',$this->pengujiandarah_id);
		$criteria->compare('terimakantongdet_id',$this->terimakantongdet_id);
		$criteria->compare('tglpengujian',$this->tglpengujian,true);
		$criteria->compare('petugaspengujian_id',$this->petugaspengujian_id);
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('asalruangan_id',$this->asalruangan_id);
		$criteria->compare('anti_a',$this->anti_a,true);
		$criteria->compare('anti_b',$this->anti_b,true);
		$criteria->compare('anti_d',$this->anti_d,true);
		$criteria->compare('anti_ab',$this->anti_ab,true);
		$criteria->compare('sel_a',$this->sel_a,true);
		$criteria->compare('sel_b',$this->sel_b,true);
		$criteria->compare('sel_o',$this->sel_o,true);
		$criteria->compare('gol_darah',$this->gol_darah,true);
		$criteria->compare('rhesus',$this->rhesus,true);
		$criteria->compare('hasil_uji',$this->hasil_uji,true);
		$criteria->compare('ket_hasiluji',$this->ket_hasiluji,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
         public function getInstalasiItems()
        {
            return InstalasiM::model()->findAll("instalasi_aktif=true");
        }
}