<?php

/**
 * This is the model class for table "feedback_t".
 *
 * The followings are the available columns in table 'feedback_t':
 * @property integer $feedback_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property string $tgl_pembuatan
 * @property string $sarandankritik
 * @property string $create_time
 * @property string $update_time
 */
class FeedbackT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FeedbackT the static model class
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
		return 'feedback_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email,nama_pasien,tgl_rekam_medik,no_mobile, tgl_pembuatan, create_time', 'required'),
			array('pendaftaran_id, pasien_id,no_mobile', 'numerical', 'integerOnly'=>true),
			array('tidakrekomendasi_deskripsi,rekomendasi_status,jeniskelamin,sarandankritik, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tidakrekomendasi_deskripsi,rekomendasi_status,feedback_id, pendaftaran_id, pasien_id, tgl_pembuatan, sarandankritik, create_time, update_time', 'safe', 'on'=>'search'),
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
			'feedback_id' => 'Feedback',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'tgl_pembuatan' => 'Tgl Pembuatan',
			'email' => 'Email',
			'nama_pasien' => 'Nama Pasien',
			'tgl_rekam_medik' => 'Tanggal Rekam Medik',
			'no_mobile' => 'No Telp',
			'no_rekam_medik' => 'No Rekam Medik',
			'jenikelamin' => 'Jenis Kelamin',
			'sarandankritik' => 'Saran dan Kritik Anda lainnya / Other suggestions and critics',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
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

		$criteria->compare('feedback_id',$this->feedback_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('tgl_pembuatan',$this->tgl_pembuatan,true);
		$criteria->compare('sarandankritik',$this->sarandankritik,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}