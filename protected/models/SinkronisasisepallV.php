<?php

/**
 * This is the model class for table "sinkronisasisepall_v".
 *
 * The followings are the available columns in table 'sinkronisasisepall_v':
 * @property integer $pendaftaran_id
 * @property string $tgl_pendaftaran
 * @property string $no_pendaftaran
 * @property string $no_rekam_medik
 * @property string $nama_pasien
 * @property string $jnspelayanan
 * @property string $nokartuasuransi
 * @property integer $sep_id
 */
class SinkronisasisepallV extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sinkronisasisepall_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, sep_id', 'numerical', 'integerOnly'=>true),
			array('no_pendaftaran', 'length', 'max'=>20),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('nama_pasien, nokartuasuransi', 'length', 'max'=>50),
			array('tgl_pendaftaran, jnspelayanan', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pendaftaran_id, tgl_pendaftaran, no_pendaftaran, no_rekam_medik, nama_pasien, jnspelayanan, nokartuasuransi, sep_id', 'safe', 'on'=>'search'),
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
			'pendaftaran_id' => 'Pendaftaran',
			'tgl_pendaftaran' => 'Tgl Pendaftaran',
			'no_pendaftaran' => 'No Pendaftaran',
			'no_rekam_medik' => 'No Rekam Medik',
			'nama_pasien' => 'Nama Pasien',
			'jnspelayanan' => 'Jnspelayanan',
			'nokartuasuransi' => 'Nokartuasuransi',
			'sep_id' => 'Sep',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('jnspelayanan',$this->jnspelayanan,true);
		$criteria->compare('nokartuasuransi',$this->nokartuasuransi,true);
		$criteria->compare('sep_id',$this->sep_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SinkronisasisepallV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
