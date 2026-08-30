<?php

/**
 * This is the model class for table "daftartilikanestesipasien_t".
 *
 * The followings are the available columns in table 'daftartilikanestesipasien_t':
 * @property integer $daftartilikanestesipasien_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $rencanaoperasi_id
 * @property string $tanggal_pengkajian
 * @property string $isizinoperasi
 * @property string $issuplaisilinderoksigen
 * @property string $isekgterpasang
 * @property string $iskateterurine
 * @property string $isperhiasandilepas
 * @property string $isrambutditutup
 * @property string $isgigipalsu_dilepas
 * @property integer $kanulaiv_ukuran
 * @property string $kanulaiv_lokasi
 * @property integer $kanulaiv_pegawaipemasang
 * @property string $mesinanestesi_supplailistrik
 * @property string $mesinanestesi_breathyngsystem
 * @property string $mesinanestesi_co2absorbent
 * @property string $mesinanestesi_ventilator
 * @property string $mesinstatusakhir_vaporizeroff
 * @property string $mesinstatusakhir_aplvalveopen
 * @property string $mesinstatusakhir_bagmode
 * @property string $mesinstatusakhir_flowmeter
 * @property string $mesinstatusakhir_suctionunit
 * @property string $mesinstatusakhir_laringoskop
 * @property string $mesinstatusakhir_orophairway
 * @property string $mesinstatusakhir_ettlmaigel
 * @property string $mesinstatusakhir_plester
 * @property string $mesinstatusakhir_introducer
 * @property string $persiapanobat
 * @property string $cekmonitor
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PasienM $pasien
 * @property PendaftaranT $pendaftaran
 * @property PasienadmisiT $pasienadmisi
 * @property PasienmasukpenunjangT $pasienmasukpenunjang
 * @property RencanaoperasiT $rencanaoperasi
 * @property CairanpasienanestesiT[] $cairanpasienanestesiTs
 */
class DaftartilikanestesipasienT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DaftartilikanestesipasienT the static model class
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
		return 'daftartilikanestesipasien_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, pendaftaran_id, pasienmasukpenunjang_id, tanggal_pengkajian', 'required'),
			array('pasien_id, pendaftaran_id, pasienadmisi_id, pasienmasukpenunjang_id, rencanaoperasi_id, kanulaiv_ukuran, kanulaiv_pegawaipemasang, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('isizinoperasi, issuplaisilinderoksigen, isekgterpasang, iskateterurine, isperhiasandilepas, isrambutditutup, isgigipalsu_dilepas, mesinanestesi_supplailistrik, mesinanestesi_breathyngsystem, mesinanestesi_co2absorbent, mesinanestesi_ventilator, mesinstatusakhir_vaporizeroff, mesinstatusakhir_aplvalveopen, mesinstatusakhir_bagmode, mesinstatusakhir_flowmeter, mesinstatusakhir_suctionunit, mesinstatusakhir_laringoskop, mesinstatusakhir_orophairway, mesinstatusakhir_ettlmaigel, mesinstatusakhir_plester, mesinstatusakhir_introducer, persiapanobat, cekmonitor', 'length', 'max'=>20),
			array('kanulaiv_lokasi', 'length', 'max'=>50),
			array('create_time, update_time, rencanaoperasi_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('daftartilikanestesipasien_id, pasien_id, pendaftaran_id, pasienadmisi_id, pasienmasukpenunjang_id, rencanaoperasi_id, tanggal_pengkajian, isizinoperasi, issuplaisilinderoksigen, isekgterpasang, iskateterurine, isperhiasandilepas, isrambutditutup, isgigipalsu_dilepas, kanulaiv_ukuran, kanulaiv_lokasi, kanulaiv_pegawaipemasang, mesinanestesi_supplailistrik, mesinanestesi_breathyngsystem, mesinanestesi_co2absorbent, mesinanestesi_ventilator, mesinstatusakhir_vaporizeroff, mesinstatusakhir_aplvalveopen, mesinstatusakhir_bagmode, mesinstatusakhir_flowmeter, mesinstatusakhir_suctionunit, mesinstatusakhir_laringoskop, mesinstatusakhir_orophairway, mesinstatusakhir_ettlmaigel, mesinstatusakhir_plester, mesinstatusakhir_introducer, persiapanobat, cekmonitor, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'pasienmasukpenunjang' => array(self::BELONGS_TO, 'PasienmasukpenunjangT', 'pasienmasukpenunjang_id'),
			'rencanaoperasi' => array(self::BELONGS_TO, 'RencanaoperasiT', 'rencanaoperasi_id'),
			'cairanpasienanestesiTs' => array(self::HAS_MANY, 'CairanpasienanestesiT', 'daftartilikanestesipasien_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'daftartilikanestesipasien_id' => 'Daftartilikanestesipasien',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'rencanaoperasi_id' => 'Rencanaoperasi',
			'tanggal_pengkajian' => 'Tanggal Pengkajian',
			'isizinoperasi' => 'Izin Operasi',
			'issuplaisilinderoksigen' => 'Suplai Silinder Oksigen',
			'isekgterpasang' => 'Elektroda EKG Terpasang',
			'iskateterurine' => 'Kateter Urine',
			'isperhiasandilepas' => 'Perhiasan Dilepas',
			'isrambutditutup' => 'Rambut Ditutup',
			'isgigipalsu_dilepas' => 'Gigi Palsu Dilepas',
			'kanulaiv_ukuran' => 'Ukuran Kanula IV (G)',
			'kanulaiv_lokasi' => 'Lokasi Kanula IV',
			'kanulaiv_pegawaipemasang' => 'Dipasang Oleh',
			'mesinanestesi_supplailistrik' => 'Supplai Listrik',
			'mesinanestesi_breathyngsystem' => 'Breathing system',
			'mesinanestesi_co2absorbent' => 'CO2 Absorbent',
			'mesinanestesi_ventilator' => 'Ventilator',
			'mesinstatusakhir_vaporizeroff' => 'Vaporizer Off',
			'mesinstatusakhir_aplvalveopen' => 'Apl Valve Open',
			'mesinstatusakhir_bagmode' => 'Bag Mode',
			'mesinstatusakhir_flowmeter' => 'Flow Meter',
			'mesinstatusakhir_suctionunit' => 'Suction Unit',
			'mesinstatusakhir_laringoskop' => 'Laringoskop',
			'mesinstatusakhir_orophairway' => 'Oropharyngeal Airway',
			'mesinstatusakhir_ettlmaigel' => ' ETT/LMA/I-GEL',
			'mesinstatusakhir_plester' => 'Plester',
			'mesinstatusakhir_introducer' => 'Introducer',
			'persiapanobat' => 'Persiapan Obat-Obatan',
			'cekmonitor' => 'Cek Monitor',
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

		$criteria->compare('daftartilikanestesipasien_id',$this->daftartilikanestesipasien_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('rencanaoperasi_id',$this->rencanaoperasi_id);
		$criteria->compare('tanggal_pengkajian',$this->tanggal_pengkajian,true);
		$criteria->compare('isizinoperasi',$this->isizinoperasi,true);
		$criteria->compare('issuplaisilinderoksigen',$this->issuplaisilinderoksigen,true);
		$criteria->compare('isekgterpasang',$this->isekgterpasang,true);
		$criteria->compare('iskateterurine',$this->iskateterurine,true);
		$criteria->compare('isperhiasandilepas',$this->isperhiasandilepas,true);
		$criteria->compare('isrambutditutup',$this->isrambutditutup,true);
		$criteria->compare('isgigipalsu_dilepas',$this->isgigipalsu_dilepas,true);
		$criteria->compare('kanulaiv_ukuran',$this->kanulaiv_ukuran);
		$criteria->compare('kanulaiv_lokasi',$this->kanulaiv_lokasi,true);
		$criteria->compare('kanulaiv_pegawaipemasang',$this->kanulaiv_pegawaipemasang);
		$criteria->compare('mesinanestesi_supplailistrik',$this->mesinanestesi_supplailistrik,true);
		$criteria->compare('mesinanestesi_breathyngsystem',$this->mesinanestesi_breathyngsystem,true);
		$criteria->compare('mesinanestesi_co2absorbent',$this->mesinanestesi_co2absorbent,true);
		$criteria->compare('mesinanestesi_ventilator',$this->mesinanestesi_ventilator,true);
		$criteria->compare('mesinstatusakhir_vaporizeroff',$this->mesinstatusakhir_vaporizeroff,true);
		$criteria->compare('mesinstatusakhir_aplvalveopen',$this->mesinstatusakhir_aplvalveopen,true);
		$criteria->compare('mesinstatusakhir_bagmode',$this->mesinstatusakhir_bagmode,true);
		$criteria->compare('mesinstatusakhir_flowmeter',$this->mesinstatusakhir_flowmeter,true);
		$criteria->compare('mesinstatusakhir_suctionunit',$this->mesinstatusakhir_suctionunit,true);
		$criteria->compare('mesinstatusakhir_laringoskop',$this->mesinstatusakhir_laringoskop,true);
		$criteria->compare('mesinstatusakhir_orophairway',$this->mesinstatusakhir_orophairway,true);
		$criteria->compare('mesinstatusakhir_ettlmaigel',$this->mesinstatusakhir_ettlmaigel,true);
		$criteria->compare('mesinstatusakhir_plester',$this->mesinstatusakhir_plester,true);
		$criteria->compare('mesinstatusakhir_introducer',$this->mesinstatusakhir_introducer,true);
		$criteria->compare('persiapanobat',$this->persiapanobat,true);
		$criteria->compare('cekmonitor',$this->cekmonitor,true);
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