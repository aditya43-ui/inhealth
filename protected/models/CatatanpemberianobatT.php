<?php

/**
 * This is the model class for table "catatanpemberianobat_t".
 *
 * The followings are the available columns in table 'catatanpemberianobat_t':
 * @property integer $catatanpemberianobat_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property integer $pasien_id
 * @property integer $obatalkes_id
 * @property boolean $isalergiobat
 * @property string $riwayatalergiobat
 * @property string $dosisobat
 * @property string $aturanpakaiobat
 * @property string $jadwalpemberianobat
 * @property string $jenisinfus
 * @property string $catatanpemberian
 * @property string $keteragan
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai
 * @property integer $create_ruangan
 * @property string $update_loginpemakai
 */
class CatatanpemberianobatT extends CActiveRecord
{
        public $obatalkes_nama, $petugaspengisi_nama, $jenisresep, $jnstransaksi;
        public $resepturdetail_id;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CatatanpemberianobatT the static model class
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
		return 'catatanpemberianobat_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, pasien_id, obatalkes_id, create_time, create_loginpemakai', 'required'),
			array('pendaftaran_id, pasienadmisi_id, pasien_id, obatalkes_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('dosisobat, aturanpakaiobat, catatanpemberian, create_loginpemakai, update_loginpemakai', 'length', 'max'=>100),
			array('jadwalpemberianobat', 'length', 'max'=>10),
			array('jenisinfus', 'length', 'max'=>30),
			array('resepturdetail_id, penerimaan_status, riwayatalergiobat, keteragan, update_time, cairanmasuk', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('catatanpemberianobat_id, pendaftaran_id, pasienadmisi_id, pasien_id, obatalkes_id, isalergiobat, riwayatalergiobat, dosisobat, aturanpakaiobat, jadwalpemberianobat, jenisinfus, catatanpemberian, keteragan, create_time, update_time, create_loginpemakai, create_ruangan, update_loginpemakai, carapemberian, pegawai_id, jeniscairanmasuk, cairanmasuk', 'safe', 'on'=>'search'),
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
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
			'petugaspengisi' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'obatalkes' => array(self::BELONGS_TO, 'ObatalkesM', 'obatalkes_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'catatanpemberianobat_id' => 'Catatanpemberianobat',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pasien_id' => 'Pasien',
			'obatalkes_id' => 'Nama Obat',
			'isalergiobat' => 'Alergi Obat',
			'riwayatalergiobat' => 'Riwayatalergiobat',
			'dosisobat' => 'Dosis',
			'aturanpakaiobat' => 'Aturan Pakai',
			'jadwalpemberianobat' => 'Jadwal Pemberian Obat',
			'jenisinfus' => 'Jenis Obat',
			'catatanpemberian' => 'Catatanpemberian',
			'carapemberian' => 'Cara Pemberian',
			'keteragan' => 'Keteragan atau Reaksi Obat',
			'pegawai_id' => 'Petugas Pengisi',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai' => 'Create Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'update_loginpemakai' => 'Update Loginpemakai',
			'cairanmasuk' => 'Cairan Masuk',
			'jeniscairanmasuk' => 'Jenis Cairan Masuk',
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

		$criteria->compare('catatanpemberianobat_id',$this->catatanpemberianobat_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('isalergiobat',$this->isalergiobat);
		$criteria->compare('riwayatalergiobat',$this->riwayatalergiobat,true);
		$criteria->compare('dosisobat',$this->dosisobat,true);
		$criteria->compare('aturanpakaiobat',$this->aturanpakaiobat,true);
		$criteria->compare('jadwalpemberianobat',$this->jadwalpemberianobat,true);
		$criteria->compare('jenisinfus',$this->jenisinfus,true);
		$criteria->compare('catatanpemberian',$this->catatanpemberian,true);
		$criteria->compare('keteragan',$this->keteragan,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai,true);
		$criteria->compare('create_ruangan',$this->create_ruangan);
		$criteria->compare('update_loginpemakai',$this->update_loginpemakai,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
