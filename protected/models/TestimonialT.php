<?php

/**
 * This is the model class for table "testimonial_t".
 *
 * The followings are the available columns in table 'testimonial_t':
 * @property integer $testimonial_id
 * @property integer $pasien_id
 * @property string $tgl_testimoni
 * @property string $deskripsitestimoni
 * @property string $email
 * @property string $no_mobile
 * @property string $jeniskelamin
 * @property boolean $mediapengaduan
 * @property string $tglverifikasi
 * @property string $namaverifikator
 * @property boolean $is_publish
 */
class TestimonialT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TestimonialT the static model class
	 */
	public $tgl_awal,$tgl_akhir;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'testimonial_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id', 'numerical', 'integerOnly'=>true),
			array('email, namaverifikator', 'length', 'max'=>100),
			array('no_mobile, jeniskelamin', 'length', 'max'=>15),
			array('tgl_testimoni, deskripsitestimoni, mediapengaduan, tglverifikasi, is_publish', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('testimonial_id, pasien_id, tgl_testimoni, deskripsitestimoni, email, no_mobile, jeniskelamin, mediapengaduan, tglverifikasi, namaverifikator, is_publish', 'safe', 'on'=>'search'),
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
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'testimonial_id' => 'Testimonial',
			'pasien_id' => 'Pasien',
			'tgl_testimoni' => 'Tgl Testimoni',
			'deskripsitestimoni' => 'Deskripsi Testimoni',
			'email' => 'Email',
			'no_mobile' => 'No Mobile',
			'jeniskelamin' => 'Jenis kelamin',
			'mediapengaduan' => 'Media Pengaduan',
			'tglverifikasi' => 'Tgl verifikasi',
			'namaverifikator' => 'Nama verifikator',
			'is_publish' => 'Is Publish',
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

		// $criteria->addBetweenCondition('tgl_testimoni', $this->tgl_awal, $this->tgl_akhir);
		$criteria->addBetweenCondition('tgl_testimoni',$this->tgl_awal,$this->tgl_akhir,true);
		$criteria->compare('testimonial_id',$this->testimonial_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('tgl_testimoni',$this->tgl_testimoni,true);
		$criteria->compare('deskripsitestimoni',$this->deskripsitestimoni,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('no_mobile',$this->no_mobile,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('mediapengaduan',$this->mediapengaduan);
		$criteria->compare('tglverifikasi',$this->tglverifikasi,true);
		$criteria->compare('namaverifikator',$this->namaverifikator,true);
		$criteria->compare('is_publish',$this->is_publish);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}