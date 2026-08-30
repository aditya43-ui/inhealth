<?php

/**
 * This is the model class for table "pengkajiannyeri_t".
 *
 * The followings are the available columns in table 'pengkajiannyeri_t':
 * @property integer $pengkajiannyeri_id
 * @property integer $pendaftaran_id
 * @property integer $ruangan_id
 * @property string $waktupengkajian
 * @property integer $petugaspengkaji_id
 * @property string $sistemskoring
 * @property integer $skalanyeri
 * @property string $keterangan_skalanyeri
 * @property string $tipenyeri
 * @property string $deskripsinyeri_lokasinyeri
 * @property string $deskripsinyeri_onset
 * @property string $deskripsinyeri_onsetsatuan
 * @property string $deskripsinyeri_pencetus
 * @property string $deskripsinyeri_kualitasnyeri
 * @property string $deskripsinyeri_kualitasnyerilainnya
 * @property string $deskripsinyeri_menjalar
 * @property string $deskripsinyeri_lokasipenjalaran
 * @property string $deskripsinyeri_tingkatan
 * @property string $deskripsinyeri_frekuensinyeri
 * @property string $deskripsinyeri_frekuensinyerilainnya
 * @property string $tatalaksananyeri
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan_id
 *
 * The followings are the available model relations:
 * @property PendaftaranT $pendaftaran
 */
class PengkajiannyeriT extends CActiveRecord
{
    public $pasien_id;
    public $instalasi_id;
    
    public $tgl_awal_kaji, $tgl_akhir_kaji;
    public $is_ceklis = 0;
    public $tgl_awal_daftar, $tgl_akhir_daftar;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengkajiannyeriT the static model class
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
		return 'pengkajiannyeri_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, waktupengkajian, petugaspengkaji_id, sistemskoring, skalanyeri, keterangan_skalanyeri, create_time, create_loginpemakai_id', 'required'),
			array('pendaftaran_id, ruangan_id, petugaspengkaji_id, skalanyeri, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('sistemskoring, tipenyeri, deskripsinyeri_onset, deskripsinyeri_onsetsatuan', 'length', 'max'=>50),
			array('keterangan_skalanyeri', 'length', 'max'=>100),
			array('deskripsinyeri_lokasinyeri, deskripsinyeri_pencetus, deskripsinyeri_lokasipenjalaran', 'length', 'max'=>255),
			array('deskripsinyeri_menjalar, deskripsinyeri_tingkatan', 'length', 'max'=>20),
			array('instalasi_id, is_ceklis, deskripsinyeri_kualitasnyeri, deskripsinyeri_kualitasnyerilainnya, deskripsinyeri_frekuensinyeri, deskripsinyeri_frekuensinyerilainnya, tatalaksananyeri, update_time, isverifikasipetugas, verifikasipetugas_tanggal, verifikasipetugas_catatan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('instalasi_id, pengkajiannyeri_id, pendaftaran_id, ruangan_id, waktupengkajian, petugaspengkaji_id, sistemskoring, skalanyeri, keterangan_skalanyeri, tipenyeri, deskripsinyeri_lokasinyeri, deskripsinyeri_onset, deskripsinyeri_onsetsatuan, deskripsinyeri_pencetus, deskripsinyeri_kualitasnyeri, deskripsinyeri_kualitasnyerilainnya, deskripsinyeri_menjalar, deskripsinyeri_lokasipenjalaran, deskripsinyeri_tingkatan, deskripsinyeri_frekuensinyeri, deskripsinyeri_frekuensinyerilainnya, tatalaksananyeri, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id, isverifikasipetugas, verifikasipetugas_tanggal, verifikasipetugas_catatan', 'safe', 'on'=>'search'),
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
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
            'petugaspengkaji' => array(self::BELONGS_TO, 'PegawaiM', 'petugaspengkaji_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pengkajiannyeri_id' => 'Pengkajiannyeri',
			'pendaftaran_id' => 'Pendaftaran',
			'ruangan_id' => 'Ruangan',
			'waktupengkajian' => 'Waktu Pengkajian',
			'petugaspengkaji_id' => 'Petugas Pengkaji',
			'sistemskoring' => 'Sistem Skoring',
			'skalanyeri' => 'Skala Nyeri',
			'keterangan_skalanyeri' => 'Keterangan Skala Nyeri',
			'tipenyeri' => 'Tipe Nyeri',
			'deskripsinyeri_lokasinyeri' => 'Lokasi',
			'deskripsinyeri_onset' => 'Onset',
			'deskripsinyeri_onsetsatuan' => 'Deskripsinyeri Onsetsatuan',
			'deskripsinyeri_pencetus' => 'Pencetus',
			'deskripsinyeri_kualitasnyeri' => 'Kualitas',
			'deskripsinyeri_kualitasnyerilainnya' => 'Deskripsinyeri Kualitasnyerilainnya',
			'deskripsinyeri_menjalar' => 'Menjalar',
			'deskripsinyeri_lokasipenjalaran' => 'Lokasi Penjalaran',
			'deskripsinyeri_tingkatan' => 'Tingkatan',
			'deskripsinyeri_frekuensinyeri' => 'Waktu',
			'deskripsinyeri_frekuensinyerilainnya' => 'Deskripsinyeri Frekuensinyerilainnya',
			'tatalaksananyeri' => 'Tatalaksananyeri',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan_id' => 'Create Ruangan',
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

        $criteria->join = "join pendaftaran_t p on p.pendaftaran_id = t.pendaftaran_id "
            . "join ruangan_m r on r.ruangan_id = t.ruangan_id";
        
        if (!empty($this->tgl_awal_kaji) && !empty($this->tgl_akhir_kaji)) {
            $criteria->addBetweenCondition('t.waktupengkajian::date', $this->tgl_awal_kaji, $this->tgl_akhir_kaji);
        }
        if ($this->is_ceklis == 1 && !empty($this->tgl_awal_daftar) && !empty($this->tgl_akhir_daftar)) {
            $criteria->addBetweenCondition('p.tgl_pendaftaran::date', $this->tgl_awal_daftar, $this->tgl_akhir_daftar);
        }
        
		$criteria->compare('t.pengkajiannyeri_id',$this->pengkajiannyeri_id);
		$criteria->compare('t.pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('t.ruangan_id',$this->ruangan_id);
		$criteria->compare('r.instalasi_id',$this->instalasi_id);
		$criteria->compare('p.pasien_id',$this->pasien_id);
		$criteria->compare('t.waktupengkajian',$this->waktupengkajian,true);
		$criteria->compare('t.petugaspengkaji_id',$this->petugaspengkaji_id);
		$criteria->compare('t.sistemskoring',$this->sistemskoring,true);
		$criteria->compare('t.skalanyeri',$this->skalanyeri);
		$criteria->compare('t.keterangan_skalanyeri',$this->keterangan_skalanyeri,true);
		$criteria->compare('t.tipenyeri',$this->tipenyeri,true);
		$criteria->compare('t.deskripsinyeri_lokasinyeri',$this->deskripsinyeri_lokasinyeri,true);
		$criteria->compare('t.deskripsinyeri_onset',$this->deskripsinyeri_onset,true);
		$criteria->compare('t.deskripsinyeri_onsetsatuan',$this->deskripsinyeri_onsetsatuan,true);
		$criteria->compare('t.deskripsinyeri_pencetus',$this->deskripsinyeri_pencetus,true);
		$criteria->compare('t.deskripsinyeri_kualitasnyeri',$this->deskripsinyeri_kualitasnyeri,true);
		$criteria->compare('t.deskripsinyeri_kualitasnyerilainnya',$this->deskripsinyeri_kualitasnyerilainnya,true);
		$criteria->compare('t.deskripsinyeri_menjalar',$this->deskripsinyeri_menjalar,true);
		$criteria->compare('t.deskripsinyeri_lokasipenjalaran',$this->deskripsinyeri_lokasipenjalaran,true);
		$criteria->compare('t.deskripsinyeri_tingkatan',$this->deskripsinyeri_tingkatan,true);
		$criteria->compare('t.deskripsinyeri_frekuensinyeri',$this->deskripsinyeri_frekuensinyeri,true);
		$criteria->compare('t.deskripsinyeri_frekuensinyerilainnya',$this->deskripsinyeri_frekuensinyerilainnya,true);
		$criteria->compare('t.tatalaksananyeri',$this->tatalaksananyeri,true);
		$criteria->compare('t.create_time',$this->create_time,true);
		$criteria->compare('t.update_time',$this->update_time,true);
		$criteria->compare('t.create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('t.update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('t.create_ruangan_id',$this->create_ruangan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function searchPrint() {
        $prov = $this->search();
        $prov->pagination = false;
        
        return $prov;
    }
}