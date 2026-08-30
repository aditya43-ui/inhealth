<?php

/**
 * This is the model class for table "inslogjualfarmasi_inv_v".
 *
 * The followings are the available columns in table 'inslogjualfarmasi_inv_v':
 * @property integer $pasien_id
 * @property string $normpx
 * @property string $namapx
 * @property string $tgllahir
 * @property double $umurpx
 * @property string $ketumur
 * @property string $alamatpx
 * @property string $nobilling
 * @property string $kodedepo
 * @property integer $kodedokter
 * @property string $idpetugas
 * @property string $tgljual
 * @property double $totjual
 * @property string $kode
 * @property string $nojual
 * @property string $nominta
 * @property string $inisialjual
 * @property integer $kodejamin
 * @property string $kodetl
 * @property string $nott
 * @property integer $aktif
 * @property integer $stcetak
 * @property integer $stjual
 * @property integer $penjualanresep_id
 */
class InslogjualfarmasiInvV extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'inslogjualfarmasi_inv_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, kodedokter, kodejamin, aktif, stcetak, stjual, penjualanresep_id', 'numerical', 'integerOnly'=>true),
			array('umurpx, totjual', 'numerical'),
			array('normpx', 'length', 'max'=>10),
			array('namapx', 'length', 'max'=>100),
			array('nobilling', 'length', 'max'=>20),
			array('kodedepo, idpetugas, kode, nojual, nominta, kodetl', 'length', 'max'=>255),
			array('tgllahir, ketumur, alamatpx, tgljual, inisialjual, nott', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pasien_id, normpx, namapx, tgllahir, umurpx, ketumur, alamatpx, nobilling, kodedepo, kodedokter, idpetugas, tgljual, totjual, kode, nojual, nominta, inisialjual, kodejamin, kodetl, nott, aktif, stcetak, stjual, penjualanresep_id', 'safe', 'on'=>'search'),
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
			'pasien_id' => 'Pasien',
			'normpx' => 'Normpx',
			'namapx' => 'Namapx',
			'tgllahir' => 'Tgllahir',
			'umurpx' => 'Umurpx',
			'ketumur' => 'Ketumur',
			'alamatpx' => 'Alamatpx',
			'nobilling' => 'Nobilling',
			'kodedepo' => 'Kodedepo',
			'kodedokter' => 'Kodedokter',
			'idpetugas' => 'Idpetugas',
			'tgljual' => 'Tgljual',
			'totjual' => 'Totjual',
			'kode' => 'Kode',
			'nojual' => 'Nojual',
			'nominta' => 'Nominta',
			'inisialjual' => 'Inisialjual',
			'kodejamin' => 'Kodejamin',
			'kodetl' => 'Kodetl',
			'nott' => 'Nott',
			'aktif' => 'Aktif',
			'stcetak' => 'Stcetak',
			'stjual' => 'Stjual',
			'penjualanresep_id' => 'Penjualanresep',
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

		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('normpx',$this->normpx,true);
		$criteria->compare('namapx',$this->namapx,true);
		$criteria->compare('tgllahir',$this->tgllahir,true);
		$criteria->compare('umurpx',$this->umurpx);
		$criteria->compare('ketumur',$this->ketumur,true);
		$criteria->compare('alamatpx',$this->alamatpx,true);
		$criteria->compare('nobilling',$this->nobilling,true);
		$criteria->compare('kodedepo',$this->kodedepo,true);
		$criteria->compare('kodedokter',$this->kodedokter);
		$criteria->compare('idpetugas',$this->idpetugas,true);
		$criteria->compare('tgljual',$this->tgljual,true);
		$criteria->compare('totjual',$this->totjual);
		$criteria->compare('kode',$this->kode,true);
		$criteria->compare('nojual',$this->nojual,true);
		$criteria->compare('nominta',$this->nominta,true);
		$criteria->compare('inisialjual',$this->inisialjual,true);
		$criteria->compare('kodejamin',$this->kodejamin);
		$criteria->compare('kodetl',$this->kodetl,true);
		$criteria->compare('nott',$this->nott,true);
		$criteria->compare('aktif',$this->aktif);
		$criteria->compare('stcetak',$this->stcetak);
		$criteria->compare('stjual',$this->stjual);
		$criteria->compare('penjualanresep_id',$this->penjualanresep_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return InslogjualfarmasiInvV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
