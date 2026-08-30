<?php

/**
 * This is the model class for table "radorderlist_v".
 *
 * The followings are the available columns in table 'radorderlist_v':
 * @property string $nama
 * @property string $noregister
 * @property string $jk
 * @property string $tgllahir
 * @property string $telpon
 * @property string $alamat
 * @property string $kota
 * @property double $beratbadan
 * @property string $asalpasien
 * @property string $namarspengirim
 * @property string $dokterpengirim
 * @property string $asuransi
 * @property string $urgensi
 * @property string $requestid
 * @property string $diagnosis
 * @property integer $orderlabsimrs_id
 * @property boolean $is_kirim
 */
class RadorderlistV extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'radorderlist_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('orderlabsimrs_id', 'numerical', 'integerOnly'=>true),
			array('beratbadan', 'numerical'),
			array('nama, kota, dokterpengirim, asuransi', 'length', 'max'=>50),
			array('noregister', 'length', 'max'=>10),
			array('telpon', 'length', 'max'=>15),
			array('asalpasien', 'length', 'max'=>100),
			array('diagnosis', 'length', 'max'=>200),
			array('jk, tgllahir, alamat, namarspengirim, urgensi, requestid, is_kirim', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('nama, noregister, jk, tgllahir, telpon, alamat, kota, beratbadan, asalpasien, namarspengirim, dokterpengirim, asuransi, urgensi, requestid, diagnosis, orderlabsimrs_id, is_kirim', 'safe', 'on'=>'search'),
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
			'nama' => 'Nama',
			'noregister' => 'Noregister',
			'jk' => 'Jk',
			'tgllahir' => 'Tgllahir',
			'telpon' => 'Telpon',
			'alamat' => 'Alamat',
			'kota' => 'Kota',
			'beratbadan' => 'Beratbadan',
			'asalpasien' => 'Asalpasien',
			'namarspengirim' => 'Namarspengirim',
			'dokterpengirim' => 'Dokterpengirim',
			'asuransi' => 'Asuransi',
			'urgensi' => 'Urgensi',
			'requestid' => 'Requestid',
			'diagnosis' => 'Diagnosis',
			'orderlabsimrs_id' => 'Orderlabsimrs',
			'is_kirim' => 'Is Kirim',
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

		$criteria->compare('nama',$this->nama,true);
		$criteria->compare('noregister',$this->noregister,true);
		$criteria->compare('jk',$this->jk,true);
		$criteria->compare('tgllahir',$this->tgllahir,true);
		$criteria->compare('telpon',$this->telpon,true);
		$criteria->compare('alamat',$this->alamat,true);
		$criteria->compare('kota',$this->kota,true);
		$criteria->compare('beratbadan',$this->beratbadan);
		$criteria->compare('asalpasien',$this->asalpasien,true);
		$criteria->compare('namarspengirim',$this->namarspengirim,true);
		$criteria->compare('dokterpengirim',$this->dokterpengirim,true);
		$criteria->compare('asuransi',$this->asuransi,true);
		$criteria->compare('urgensi',$this->urgensi,true);
		$criteria->compare('requestid',$this->requestid,true);
		$criteria->compare('diagnosis',$this->diagnosis,true);
		$criteria->compare('orderlabsimrs_id',$this->orderlabsimrs_id);
		$criteria->compare('is_kirim',$this->is_kirim);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RadorderlistV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
