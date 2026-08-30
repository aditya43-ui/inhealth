<?php

/**
 * This is the model class for table "riwayatpersalinan_r".
 *
 * The followings are the available columns in table 'riwayatpersalinan_r':
 * @property integer $riwayatpersalinan_id
 * @property integer $pendaftaran_id
 * @property integer $anamesa_id
 * @property integer $riwayat_urutan
 * @property string $tglpartus
 * @property string $tempatpartus
 * @property integer $umurhamil_bln
 * @property string $jenispersalinan
 * @property string $penolongpersalinan
 * @property string $penyulit
 * @property string $bbanak_gram
 * @property string $pbanak_cm
 * @property string $pemberianasi
 * @property string $keadaananakskrg
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class RiwayatpersalinanR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RiwayatpersalinanR the static model class
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
		return 'riwayatpersalinan_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, anamesa_id, riwayat_urutan, tglpartus, tempatpartus, umurhamil_bln, bbanak_gram, pbanak_cm, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pendaftaran_id, anamesa_id, riwayat_urutan, umurhamil_bln, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('tempatpartus, pemberianasi', 'length', 'max'=>100),
			array('jenispersalinan', 'length', 'max'=>50),
			array('penolongpersalinan', 'length', 'max'=>150),
			array('penyulit, keadaananakskrg', 'length', 'max'=>200),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('riwayatpersalinan_id, pendaftaran_id, anamesa_id, riwayat_urutan, tglpartus, tempatpartus, umurhamil_bln, jenispersalinan, penolongpersalinan, penyulit, bbanak_gram, pbanak_cm, pemberianasi, keadaananakskrg, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'riwayatpersalinan_id' => 'Riwayatpersalinan',
			'pendaftaran_id' => 'Pendaftaran',
			'anamesa_id' => 'Anamesa',
			'riwayat_urutan' => 'Riwayat Urutan',
			'tglpartus' => 'Tglpartus',
			'tempatpartus' => 'Tempatpartus',
			'umurhamil_bln' => 'Umurhamil Bln',
			'jenispersalinan' => 'Jenispersalinan',
			'penolongpersalinan' => 'Penolongpersalinan',
			'penyulit' => 'Penyulit',
			'bbanak_gram' => 'Bbanak Gram',
			'pbanak_cm' => 'Pbanak Cm',
			'pemberianasi' => 'Pemberianasi',
			'keadaananakskrg' => 'Keadaananakskrg',
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

		$criteria->compare('riwayatpersalinan_id',$this->riwayatpersalinan_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('anamesa_id',$this->anamesa_id);
		$criteria->compare('riwayat_urutan',$this->riwayat_urutan);
		$criteria->compare('tglpartus',$this->tglpartus,true);
		$criteria->compare('tempatpartus',$this->tempatpartus,true);
		$criteria->compare('umurhamil_bln',$this->umurhamil_bln);
		$criteria->compare('jenispersalinan',$this->jenispersalinan,true);
		$criteria->compare('penolongpersalinan',$this->penolongpersalinan,true);
		$criteria->compare('penyulit',$this->penyulit,true);
		$criteria->compare('bbanak_gram',$this->bbanak_gram,true);
		$criteria->compare('pbanak_cm',$this->pbanak_cm,true);
		$criteria->compare('pemberianasi',$this->pemberianasi,true);
		$criteria->compare('keadaananakskrg',$this->keadaananakskrg,true);
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