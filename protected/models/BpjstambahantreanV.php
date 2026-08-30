<?php

/**
 * This is the model class for table "v_bpjstambahantrean".
 *
 * The followings are the available columns in table 'v_bpjstambahantrean':
 * @property string $kodebooking
 * @property string $jenispasien
 * @property string $nomorkartu
 * @property string $nik
 * @property string $nohp
 * @property string $kodepoli
 * @property string $namapoli
 * @property integer $pasienbaru
 * @property string $norm
 * @property string $tanggalperiksa
 * @property string $kodedokter
 * @property string $namadokter
 * @property string $jampraktek
 * @property integer $jeniskunjungan
 * @property string $nomorreferensi
 * @property string $nomorantrean
 * @property string $angkaantrean
 * @property integer $kuotajkn
 * @property integer $kuotanonjkn
 */
class BpjstambahantreanV extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'v_bpjstambahantrean';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasienbaru, jeniskunjungan, kuotajkn, kuotanonjkn', 'numerical', 'integerOnly'=>true),
			array('kodebooking, nohp', 'length', 'max'=>20),
			array('nomorkartu, namapoli, kodedokter, namadokter, jampraktek, nomorreferensi', 'length', 'max'=>50),
			array('nik', 'length', 'max'=>30),
			array('kodepoli, norm', 'length', 'max'=>10),
			array('nomorantrean, angkaantrean', 'length', 'max'=>6),
			array('jenispasien, tanggalperiksa', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('kodebooking, jenispasien, nomorkartu, nik, nohp, kodepoli, namapoli, pasienbaru, norm, tanggalperiksa, kodedokter, namadokter, jampraktek, jeniskunjungan, nomorreferensi, nomorantrean, angkaantrean, kuotajkn, kuotanonjkn', 'safe', 'on'=>'search'),
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
			'kodebooking' => 'Kodebooking',
			'jenispasien' => 'Jenispasien',
			'nomorkartu' => 'Nomorkartu',
			'nik' => 'Nik',
			'nohp' => 'Nohp',
			'kodepoli' => 'Kodepoli',
			'namapoli' => 'Namapoli',
			'pasienbaru' => 'Pasienbaru',
			'norm' => 'Norm',
			'tanggalperiksa' => 'Tanggalperiksa',
			'kodedokter' => 'Kodedokter',
			'namadokter' => 'Namadokter',
			'jampraktek' => 'Jampraktek',
			'jeniskunjungan' => 'Jeniskunjungan',
			'nomorreferensi' => 'Nomorreferensi',
			'nomorantrean' => 'Nomorantrean',
			'angkaantrean' => 'Angkaantrean',
			'kuotajkn' => 'Kuotajkn',
			'kuotanonjkn' => 'Kuotanonjkn',
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

		$criteria->compare('kodebooking',$this->kodebooking,true);
		$criteria->compare('jenispasien',$this->jenispasien,true);
		$criteria->compare('nomorkartu',$this->nomorkartu,true);
		$criteria->compare('nik',$this->nik,true);
		$criteria->compare('nohp',$this->nohp,true);
		$criteria->compare('kodepoli',$this->kodepoli,true);
		$criteria->compare('namapoli',$this->namapoli,true);
		$criteria->compare('pasienbaru',$this->pasienbaru);
		$criteria->compare('norm',$this->norm,true);
		$criteria->compare('tanggalperiksa',$this->tanggalperiksa,true);
		$criteria->compare('kodedokter',$this->kodedokter,true);
		$criteria->compare('namadokter',$this->namadokter,true);
		$criteria->compare('jampraktek',$this->jampraktek,true);
		$criteria->compare('jeniskunjungan',$this->jeniskunjungan);
		$criteria->compare('nomorreferensi',$this->nomorreferensi,true);
		$criteria->compare('nomorantrean',$this->nomorantrean,true);
		$criteria->compare('angkaantrean',$this->angkaantrean,true);
		$criteria->compare('kuotajkn',$this->kuotajkn);
		$criteria->compare('kuotanonjkn',$this->kuotanonjkn);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BpjstambahantreanV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
