<?php

/**
 * This is the model class for table "ujidarahpasien_t".
 *
 * The followings are the available columns in table 'ujidarahpasien_t':
 * @property integer $ujidarahpasien_id
 * @property string $tglujidarahpasien
 * @property integer $peg_pemeriksa_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $ruanguji_id
 * @property integer $permintaandarah_id
 * @property integer $metodedarah_id
 * @property string $anti_a
 * @property string $anti_b
 * @property string $anti_ab
 * @property string $anti_d
 * @property string $sel_a
 * @property string $sel_b
 * @property string $sel_o
 * @property string $kesimpulan_uji
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PermintaandarahT $permintaandarah
 */
class UjidarahpasienT extends CActiveRecord
{
        public $peg_pemeriksa_nama;
        public $tglujidarahpasien_temp;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UjidarahpasienT the static model class
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
		return 'ujidarahpasien_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglujidarahpasien, peg_pemeriksa_id, pasien_id, pendaftaran_id, ruanguji_id, permintaandarah_id, metodedarah_id, anti_a, anti_b, anti_d, kesimpulan_uji, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('peg_pemeriksa_id, pasien_id, pendaftaran_id, ruanguji_id, permintaandarah_id, metodedarah_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('anti_a, anti_b, anti_ab, anti_d, sel_a, sel_b, sel_o', 'length', 'max'=>50),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ujidarahpasien_id, tglujidarahpasien, peg_pemeriksa_id, pasien_id, pendaftaran_id, ruanguji_id, permintaandarah_id, metodedarah_id, anti_a, anti_b, anti_ab, anti_d, sel_a, sel_b, sel_o, kesimpulan_uji, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'permintaandarah' => array(self::BELONGS_TO, 'PermintaandarahT', 'permintaandarah_id'),
                        'pegpemeriksa' => array(self::BELONGS_TO, 'PegawaiM', 'peg_pemeriksa_id'),
                        'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ujidarahpasien_id' => 'Ujidarahpasien',
			'tglujidarahpasien' => 'Tglujidarahpasien',
			'peg_pemeriksa_id' => 'Peg Pemeriksa',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'ruanguji_id' => 'Ruanguji',
			'permintaandarah_id' => 'Permintaandarah',
			'metodedarah_id' => 'Metodedarah',
			'anti_a' => 'Anti A',
			'anti_b' => 'Anti B',
			'anti_ab' => 'Anti AB',
			'anti_d' => 'Anti D',
			'sel_a' => 'Sel A',
			'sel_b' => 'Sel B',
			'sel_o' => 'Sel O',
			'kesimpulan_uji' => 'Kesimpulan Uji',
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

		$criteria->compare('ujidarahpasien_id',$this->ujidarahpasien_id);
		$criteria->compare('tglujidarahpasien',$this->tglujidarahpasien,true);
		$criteria->compare('peg_pemeriksa_id',$this->peg_pemeriksa_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('ruanguji_id',$this->ruanguji_id);
		$criteria->compare('permintaandarah_id',$this->permintaandarah_id);
		$criteria->compare('metodedarah_id',$this->metodedarah_id);
		$criteria->compare('anti_a',$this->anti_a,true);
		$criteria->compare('anti_b',$this->anti_b,true);
		$criteria->compare('anti_ab',$this->anti_ab,true);
		$criteria->compare('anti_d',$this->anti_d,true);
		$criteria->compare('sel_a',$this->sel_a,true);
		$criteria->compare('sel_b',$this->sel_b,true);
		$criteria->compare('sel_o',$this->sel_o,true);
		$criteria->compare('kesimpulan_uji',$this->kesimpulan_uji,true);
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