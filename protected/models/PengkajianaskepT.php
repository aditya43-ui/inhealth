<?php

/**
 * This is the model class for table "pengkajianaskep_t".
 *
 * The followings are the available columns in table 'pengkajianaskep_t':
 * @property integer $pengkajianaskep_id
 * @property integer $pegawai_id
 * @property integer $pendaftaran_id
 * @property integer $ruangan_id
 * @property integer $anamesa_id
 * @property integer $pemeriksaanfisik_id
 * @property string $no_pengkajian
 * @property string $pengkajianaskep_tgl
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $verifikasiaskep_id
 * @property boolean $iskeperawatan
 *
 * The followings are the available model relations:
 * @property RencanaaskepT[] $rencanaaskepTs
 * @property DatapenunjangT[] $datapenunjangTs
 * @property AnamnesaT $anamesa
 * @property PegawaiM $pegawai
 * @property PemeriksaanfisikT $pemeriksaanfisik
 * @property PendaftaranT $pendaftaran
 * @property RuanganM $ruangan
 */
class PengkajianaskepT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengkajianaskepT the static model class
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
		return 'pengkajianaskep_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, pendaftaran_id, ruangan_id, anamesa_id, pemeriksaanfisik_id, no_pengkajian, pengkajianaskep_tgl, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pegawai_id, pendaftaran_id, ruangan_id, anamesa_id, pemeriksaanfisik_id, verifikasiaskep_id', 'numerical', 'integerOnly'=>true),
			array('no_pengkajian', 'length', 'max'=>20),
			array('update_time, update_loginpemakai_id, iskeperawatan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pengkajianaskep_id, pegawai_id, pendaftaran_id, ruangan_id, anamesa_id, pemeriksaanfisik_id, no_pengkajian, pengkajianaskep_tgl, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, verifikasiaskep_id, iskeperawatan', 'safe', 'on'=>'search'),
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
			'rencanaaskepTs' => array(self::HAS_MANY, 'RencanaaskepT', 'pengkajianaskep_id'),
			'datapenunjangTs' => array(self::HAS_MANY, 'DatapenunjangT', 'pengkajianaskep_id'),
			'anamesa' => array(self::BELONGS_TO, 'AnamnesaT', 'anamesa_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'pemeriksaanfisik' => array(self::BELONGS_TO, 'PemeriksaanfisikT', 'pemeriksaanfisik_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pengkajianaskep_id' => 'Pengkajianaskep',
			'pegawai_id' => 'Pegawai',
			'pendaftaran_id' => 'Pendaftaran',
			'ruangan_id' => 'Ruangan',
			'anamesa_id' => 'Anamesa',
			'pemeriksaanfisik_id' => 'Pemeriksaanfisik',
			'no_pengkajian' => 'No Pengkajian',
			'pengkajianaskep_tgl' => 'Pengkajianaskep Tgl',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'verifikasiaskep_id' => 'Verifikasiaskep',
			'iskeperawatan' => 'Iskeperawatan',
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

		$criteria->compare('pengkajianaskep_id',$this->pengkajianaskep_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('anamesa_id',$this->anamesa_id);
		$criteria->compare('pemeriksaanfisik_id',$this->pemeriksaanfisik_id);
		$criteria->compare('no_pengkajian',$this->no_pengkajian,true);
		$criteria->compare('pengkajianaskep_tgl',$this->pengkajianaskep_tgl,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('verifikasiaskep_id',$this->verifikasiaskep_id);
		$criteria->compare('iskeperawatan',$this->iskeperawatan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}