<?php

/**
 * This is the model class for table "pengkajianresikojatuh_t".
 *
 * The followings are the available columns in table 'pengkajianresikojatuh_t':
 * @property integer $pengkajianresikojatuh_id
 * @property integer $pendaftaran_id
 * @property string $skalajatuh_jenis
 * @property string $tanggal_pengkajian
 * @property string $jam_pengkajian
 * @property integer $pegawaipengkaji_id
 * @property integer $ruangan_id
 * @property string $waktupengkajian_resikojatuh
 * @property integer $totalskor
 * @property string $keteranganskor_resikojatuh
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai
 * @property string $update_loginpemakai
 * @property integer $create_petugaspengisi_id
 * @property integer $create_ruangan_id
 *
 * The followings are the available model relations:
 * @property PendaftaranT $pendaftaran
 * @property HasilpengkajianresikojatuhT[] $hasilpengkajianresikojatuhTs
 */
class PengkajianresikojatuhT extends CActiveRecord
{
	public $tgl_awal_kaji, $tgl_akhir_kaji, $tgl_awal_daftar, $tgl_akhir_daftar, $is_ceklis, $instalasi_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengkajianresikojatuhT the static model class
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
		return 'pengkajianresikojatuh_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, skalajatuh_jenis, create_loginpemakai, update_loginpemakai', 'required'),
			array('pendaftaran_id, pegawaipengkaji_id, ruangan_id, totalskor, create_petugaspengisi_id, create_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('skalajatuh_jenis, waktupengkajian_resikojatuh, keteranganskor_resikojatuh', 'length', 'max'=>50),
			array('create_loginpemakai, update_loginpemakai', 'length', 'max'=>100),
			array('tanggal_pengkajian, jam_pengkajian, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pengkajianresikojatuh_id, pendaftaran_id, skalajatuh_jenis, tanggal_pengkajian, jam_pengkajian, pegawaipengkaji_id, ruangan_id, waktupengkajian_resikojatuh, totalskor, keteranganskor_resikojatuh, create_time, update_time, create_loginpemakai, update_loginpemakai, create_petugaspengisi_id, create_ruangan_id', 'safe', 'on'=>'search'),
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
			'hasilpengkajianresikojatuhTs' => array(self::HAS_MANY, 'HasilpengkajianresikojatuhT', 'pengkajianresikojatuh_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
			'petugas' => array(self::BELONGS_TO, 'PegawaiM', 'pegawaipengkaji_id'),
			'intervensi' => array(self::BELONGS_TO, 'IntervensicegahjatuhpasienT', 'pengkajianresikojatuh_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pengkajianresikojatuh_id' => 'Pengkajianresikojatuh',
			'pendaftaran_id' => 'Pendaftaran',
			'skalajatuh_jenis' => 'Skalajatuh Jenis',
			'tanggal_pengkajian' => 'Tanggal Pengkajian',
			'jam_pengkajian' => 'Jam Pengkajian',
			'pegawaipengkaji_id' => 'Pegawaipengkaji',
			'ruangan_id' => 'Ruangan',
			'waktupengkajian_resikojatuh' => 'Waktupengkajian Resikojatuh',
			'totalskor' => 'Totalskor',
			'keteranganskor_resikojatuh' => 'Keteranganskor Resikojatuh',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai' => 'Create Loginpemakai',
			'update_loginpemakai' => 'Update Loginpemakai',
			'create_petugaspengisi_id' => 'Create Petugaspengisi',
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

		$criteria->compare('pengkajianresikojatuh_id',$this->pengkajianresikojatuh_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('skalajatuh_jenis',$this->skalajatuh_jenis,true);
		$criteria->compare('tanggal_pengkajian',$this->tanggal_pengkajian,true);
		$criteria->compare('jam_pengkajian',$this->jam_pengkajian,true);
		$criteria->compare('pegawaipengkaji_id',$this->pegawaipengkaji_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('waktupengkajian_resikojatuh',$this->waktupengkajian_resikojatuh,true);
		$criteria->compare('totalskor',$this->totalskor);
		$criteria->compare('keteranganskor_resikojatuh',$this->keteranganskor_resikojatuh,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai,true);
		$criteria->compare('update_loginpemakai',$this->update_loginpemakai,true);
		$criteria->compare('create_petugaspengisi_id',$this->create_petugaspengisi_id);
		$criteria->compare('create_ruangan_id',$this->create_ruangan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchRiwayat()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->join = "join pendaftaran_t p on p.pendaftaran_id = t.pendaftaran_id "
            . "join ruangan_m r on r.ruangan_id = t.ruangan_id";

		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('t.pendaftaran_id ='.$this->pendaftaran_id);
		}

		if (!empty($this->tgl_awal_kaji) && !empty($this->tgl_akhir_kaji)) {
            $criteria->addBetweenCondition('tanggal_pengkajian::date', $this->tgl_awal_kaji, $this->tgl_akhir_kaji);
        }
        if ($this->is_ceklis == 1 && !empty($this->tgl_awal_daftar) && !empty($this->tgl_akhir_daftar)) {
            $criteria->addBetweenCondition('p.tgl_pendaftaran::date', $this->tgl_awal_daftar, $this->tgl_akhir_daftar);
        }


		$criteria->addCondition("skalajatuh_jenis = 'anak_humptydumpty'");

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getInstalasiRuangan(){
		$ruangan = RuanganM::model()->findByPK($this->ruangan_id);
		$instalasi = InstalasiM::model()->findByPK($ruangan->instalasi_id);
		return $instalasi->instalasi_nama." / ".$ruangan->ruangan_nama;
	}

	public function searchRiwayatPengkajian()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with = array('pendaftaran','ruangan');
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('t.pendaftaran_id ='.$this->pendaftaran_id);
		}

		if (!empty($this->tgl_awal_kaji) && !empty($this->tgl_akhir_kaji)) {
            $criteria->addBetweenCondition('t.tanggal_pengkajian::date', MyFormatter::formatDateTimeForDb($this->tgl_awal_kaji), MyFormatter::formatDateTimeForDb($this->tgl_akhir_kaji));
        }
        if ($this->is_ceklis == 1 && !empty($this->tgl_awal_daftar) && !empty($this->tgl_akhir_daftar)) {
            $criteria->addBetweenCondition('pendaftaran.tgl_pendaftaran::date', MyFormatter::formatDateTimeForDb($this->tgl_awal_daftar), MyFormatter::formatDateTimeForDb($this->tgl_akhir_daftar));
        }
		$criteria->compare('lower(t.skalajatuh_jenis)',strtolower($this->skalajatuh_jenis),false);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}