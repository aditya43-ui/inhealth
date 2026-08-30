<?php

/**
 * This is the model class for table "dosisradiasidet_t".
 *
 * The followings are the available columns in table 'dosisradiasidet_t':
 * @property integer $dosisradiasidet_id
 * @property integer $dosisradiasi_id
 * @property integer $pemeriksaanrad_id
 * @property integer $pemeriksaanalatrad_id
 * @property double $dosis_kv
 * @property double $dosis_mas
 * @property double $dosis_sigmaimage
 * @property double $dosis_ma
 * @property double $dosis_s
 * @property double $dosis_fpdcm
 * @property double $dosis_anoda
 * @property double $dosis_thikness
 * @property double $dosis_compressionforce
 * @property double $dosisradiasi_ctdivol
 * @property double $dosisradiasi_dlp
 * @property double $dosisradiasi_dap
 * @property double $dosisradiasi_sigmadap
 * @property double $dosisradiasi_inak
 * @property double $dosisradiasi_esak
 * @property double $dosisradiasi_sigmaesak
 * @property double $dosisradiasi_mgd
 * @property double $dosisradiasi_sigmamgd
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 *
 * The followings are the available model relations:
 * @property DosisradiasiT $dosisradiasi
 * @property PemeriksaanradM $pemeriksaanrad
 */
class DosisradiasidetT extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dosisradiasidet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dosisradiasi_id, pemeriksaanrad_id, pemeriksaanalatrad_id, create_time, create_loginpemakai_id, update_loginpemakai_id', 'required'),
			array('dosisradiasi_id, pemeriksaanrad_id, pemeriksaanalatrad_id', 'numerical', 'integerOnly'=>true),
			array('dosis_kv, dosis_mas, dosis_sigmaimage, dosis_ma, dosis_s, dosis_fpdcm, dosis_anoda, dosis_thikness, dosis_compressionforce, dosisradiasi_ctdivol, dosisradiasi_dlp, dosisradiasi_dap, dosisradiasi_sigmadap, dosisradiasi_inak, dosisradiasi_esak, dosisradiasi_sigmaesak, dosisradiasi_mgd, dosisradiasi_sigmamgd', 'numerical'),
			array('create_loginpemakai_id, update_loginpemakai_id', 'length', 'max'=>100),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('dosisradiasidet_id, dosisradiasi_id, pemeriksaanrad_id, pemeriksaanalatrad_id, dosis_kv, dosis_mas, dosis_sigmaimage, dosis_ma, dosis_s, dosis_fpdcm, dosis_anoda, dosis_thikness, dosis_compressionforce, dosisradiasi_ctdivol, dosisradiasi_dlp, dosisradiasi_dap, dosisradiasi_sigmadap, dosisradiasi_inak, dosisradiasi_esak, dosisradiasi_sigmaesak, dosisradiasi_mgd, dosisradiasi_sigmamgd, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id', 'safe', 'on'=>'search'),
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
			'dosisradiasi' => array(self::BELONGS_TO, 'DosisradiasiT', 'dosisradiasi_id'),
			'pemeriksaanrad' => array(self::BELONGS_TO, 'PemeriksaanradM', 'pemeriksaanrad_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'dosisradiasidet_id' => 'Dosisradiasidet',
			'dosisradiasi_id' => 'Dosisradiasi',
			'pemeriksaanrad_id' => 'Pemeriksaanrad',
			'pemeriksaanalatrad_id' => 'Pemeriksaanalatrad',
			'dosis_kv' => 'kV',
			'dosis_mas' => 'mAs',
			'dosis_sigmaimage' => '&Sigma; Image',
			'dosis_ma' => 'mA',
			'dosis_s' => 's',
			'dosis_fpdcm' => 'FPD (cm)',
			'dosis_anoda' => 'Anoda/Filter',
			'dosis_thikness' => 'Thikness',
			'dosis_compressionforce' => 'Compression Force (N)',
			'dosisradiasi_ctdivol' => 'CTDivol (mGy)',
			'dosisradiasi_dlp' => 'DLP (mGy.cm)',
			'dosisradiasi_dap' => 'DAP (mGy.cm<sup>2</sup>)',
			'dosisradiasi_sigmadap' => '&Sigma; DAP (mGy.cm<sup>2</sup>)',
			'dosisradiasi_inak' => 'INAK (mGy)',
			'dosisradiasi_esak' => 'ESAK (&micro;Gy)',
			'dosisradiasi_sigmaesak' => '&Sigma; ESAK (&micro;Gy)',
			'dosisradiasi_mgd' => 'MGD (mGy)',
			'dosisradiasi_sigmamgd' => '&Sigma; MGD (mGy)',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
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

		$criteria->compare('dosisradiasidet_id',$this->dosisradiasidet_id);
		$criteria->compare('dosisradiasi_id',$this->dosisradiasi_id);
		$criteria->compare('pemeriksaanrad_id',$this->pemeriksaanrad_id);
		$criteria->compare('pemeriksaanalatrad_id',$this->pemeriksaanalatrad_id);
		$criteria->compare('dosis_kv',$this->dosis_kv);
		$criteria->compare('dosis_mas',$this->dosis_mas);
		$criteria->compare('dosis_sigmaimage',$this->dosis_sigmaimage);
		$criteria->compare('dosis_ma',$this->dosis_ma);
		$criteria->compare('dosis_s',$this->dosis_s);
		$criteria->compare('dosis_fpdcm',$this->dosis_fpdcm);
		$criteria->compare('dosis_anoda',$this->dosis_anoda);
		$criteria->compare('dosis_thikness',$this->dosis_thikness);
		$criteria->compare('dosis_compressionforce',$this->dosis_compressionforce);
		$criteria->compare('dosisradiasi_ctdivol',$this->dosisradiasi_ctdivol);
		$criteria->compare('dosisradiasi_dlp',$this->dosisradiasi_dlp);
		$criteria->compare('dosisradiasi_dap',$this->dosisradiasi_dap);
		$criteria->compare('dosisradiasi_sigmadap',$this->dosisradiasi_sigmadap);
		$criteria->compare('dosisradiasi_inak',$this->dosisradiasi_inak);
		$criteria->compare('dosisradiasi_esak',$this->dosisradiasi_esak);
		$criteria->compare('dosisradiasi_sigmaesak',$this->dosisradiasi_sigmaesak);
		$criteria->compare('dosisradiasi_mgd',$this->dosisradiasi_mgd);
		$criteria->compare('dosisradiasi_sigmamgd',$this->dosisradiasi_sigmamgd);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DosisradiasidetT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
