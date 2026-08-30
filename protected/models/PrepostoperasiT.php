<?php

/**
 * This is the model class for table "prepostoperasi_t".
 *
 * The followings are the available columns in table 'prepostoperasi_t':
 * @property integer $prepostoperasi_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property string $tanggal_penginputan
 * @property integer $petugas_pengisi
 * @property integer $ruanganasal_id
 * @property integer $instalasitujuan_id
 * @property integer $ruangantujuan_id
 * @property boolean $isterima
 * @property string $jenischecklist
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai
 * @property integer $update_loginpemakai
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PendaftaranT $pendaftaran
 * @property PasienadmisiT $pasienadmisi
 * @property PegawaiM $petugasPengisi
 * @property PrepostoperasidetailT[] $prepostoperasidetailTs
 */
class PrepostoperasiT extends CActiveRecord
{
	public $petugas_pengisi_nama, $diagnosa, $ruanganasal_nama, $instalasitujuan_nama, $ruangantujuan_nama, $diagnosa_utama, $diagnosa_tambahan;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PrepostoperasiT the static model class
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
		return 'prepostoperasi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, tanggal_penginputan, ruanganasal_id, instalasitujuan_id, ruangantujuan_id, isterima, create_time, create_loginpemakai, create_ruangan', 'required'),
			array('pendaftaran_id, pasienadmisi_id, petugas_pengisi, ruanganasal_id, instalasitujuan_id, ruangantujuan_id, create_loginpemakai, update_loginpemakai, create_ruangan, petugaspengisi_ruangantujuan', 'numerical', 'integerOnly'=>true),
			array('jenischecklist', 'length', 'max'=>50),
			array('update_time, tglpengisian_ruangantujuan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('prepostoperasi_id, pendaftaran_id, pasienadmisi_id, tanggal_penginputan, petugas_pengisi, ruanganasal_id, instalasitujuan_id, ruangantujuan_id, isterima, jenischecklist, create_time, update_time, create_loginpemakai, update_loginpemakai, create_ruangan, tglpengisian_ruangantujuan, petugaspengisi_ruangantujuan', 'safe', 'on'=>'search'),
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
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'petugasPengisi' => array(self::BELONGS_TO, 'PegawaiM', 'petugas_pengisi'),
			'ruanganasal' => array(self::BELONGS_TO, 'RuanganM', 'ruanganasal_id'),
			'instalasitujuan' => array(self::BELONGS_TO, 'InstalasiM', 'instalasitujuan_id'),
			'ruangantujuan' => array(self::BELONGS_TO, 'RuanganM', 'ruangantujuan_id'),
			'prepostoperasidetailTs' => array(self::HAS_MANY, 'PrepostoperasidetailT', 'prepostoperasi_id'),
			'ruanganasal' => array(self::BELONGS_TO, 'RuanganM', 'ruanganasal_id'),
			'instalasitujuan' => array(self::BELONGS_TO, 'InstalasiM', 'instalasitujuan_id'),
			'ruangantujuan' => array(self::BELONGS_TO, 'RuanganM', 'ruangantujuan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'prepostoperasi_id' => 'Prepostoperasi',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'tanggal_penginputan' => 'Tanggal',
			'petugas_pengisi' => 'Petugas Pengisi',
			'ruanganasal_id' => 'Ruangan Asal',
			'instalasitujuan_id' => 'Instalasi Tujuan',
			'ruangantujuan_id' => 'Ruangan Tujuan',
			'isterima' => 'Isterima',
			'jenischecklist' => 'Jenischecklist',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai' => 'Create Loginpemakai',
			'update_loginpemakai' => 'Update Loginpemakai',
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

		$criteria->compare('prepostoperasi_id',$this->prepostoperasi_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('tanggal_penginputan',$this->tanggal_penginputan,true);
		$criteria->compare('petugas_pengisi',$this->petugas_pengisi);
		$criteria->compare('ruanganasal_id',$this->ruanganasal_id);
		$criteria->compare('instalasitujuan_id',$this->instalasitujuan_id);
		$criteria->compare('ruangantujuan_id',$this->ruangantujuan_id);
		$criteria->compare('isterima',$this->isterima);
		$criteria->compare('jenischecklist',$this->jenischecklist,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai);
		$criteria->compare('update_loginpemakai',$this->update_loginpemakai);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
