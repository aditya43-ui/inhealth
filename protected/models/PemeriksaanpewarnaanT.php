<?php

/**
 * This is the model class for table "pemeriksaanpewarnaan_t".
 *
 * The followings are the available columns in table 'pemeriksaanpewarnaan_t':
 * @property integer $pemeriksaanpewarnaan_id
 * @property integer $pegawai_id
 * @property integer $dpjp_id
 * @property integer $perawat_id
 * @property string $tgl_pemeriksaan
 * @property integer $daftartindakan_id
 * @property integer $tindakanpelayanan_id
 * @property integer $pasien_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $pasienadmisi_id
 * @property integer $pendaftaran_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property string $daftartindakan_nama
 * @property string $no_lab
 * @property string $sel_epitel_pewarnaan
 * @property string $sel_radang_pewarnaan
 * @property string $mikroorganisme
 * @property string $ziehlnielsen_pewarnaan
 * @property string $koh_pewarnaan
 * @property string $niesser_pewarnaan
 * @property string $negatif_pewarnaan
 * @property string $spora_pewarnaan
 * @property string $giemsa_pewarnaan
 * @property string $mikroorganisme_ket
 * @property string $saran_pewarnaan
 * @property string $pewarnaan_lain
 */
class PemeriksaanpewarnaanT extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */

	public $jenis_pemeriksaan;
	
	public function tableName()
	{
		return 'pemeriksaanpewarnaan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, pasienmasukpenunjang_id, pendaftaran_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pemeriksaanpewarnaan_id, pegawai_id, dpjp_id, perawat_id, daftartindakan_id, tindakanpelayanan_id, pasien_id, pasienmasukpenunjang_id, pasienadmisi_id, pendaftaran_id', 'numerical', 'integerOnly'=>true),
			array('no_lab', 'length', 'max'=>30),
			array('sel_epitel_pewarnaan, sel_radang_pewarnaan, ziehlnielsen_pewarnaan, koh_pewarnaan, niesser_pewarnaan, negatif_pewarnaan, spora_pewarnaan, giemsa_pewarnaan', 'length', 'max'=>255),
			array('mikroorganisme', 'length', 'max'=>100),
			array('tgl_pemeriksaan, update_time, update_loginpemakai_id, daftartindakan_nama, mikroorganisme_ket, saran_pewarnaan, pewarnaan_lain', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pemeriksaanpewarnaan_id, pegawai_id, dpjp_id, perawat_id, tgl_pemeriksaan, daftartindakan_id, tindakanpelayanan_id, pasien_id, pasienmasukpenunjang_id, pasienadmisi_id, pendaftaran_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, daftartindakan_nama, no_lab, sel_epitel_pewarnaan, sel_radang_pewarnaan, mikroorganisme, ziehlnielsen_pewarnaan, koh_pewarnaan, niesser_pewarnaan, negatif_pewarnaan, spora_pewarnaan, giemsa_pewarnaan, mikroorganisme_ket, saran_pewarnaan, pewarnaan_lain', 'safe', 'on'=>'search'),
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
			'tindakanpelayanan'=>array(self::BELONGS_TO, 'TindakanpelayananT','tindakanpelayanan_id'),
			'daftartindakan'=>array(self::BELONGS_TO, 'DaftartindakanM','daftartindakan_id'),
			'pegawai'=>array(self::BELONGS_TO, 'PegawaiM','pegawai_id'),
			'perawat'=>array(self::BELONGS_TO, 'PegawaiM','perawat_id'),
			'dpjp'=>array(self::BELONGS_TO, 'PegawaiM','dpjp_id'),
			'pasienmasukpenunjang'=>array(self::BELONGS_TO, 'PasienmasukpenunjangT','pasienmasukpenunjang_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pemeriksaanpewarnaan_id' => 'Pemeriksaanpewarnaan',
			'pegawai_id' => 'Pegawai',
			'dpjp_id' => 'Dpjp',
			'perawat_id' => 'Perawat',
			'tgl_pemeriksaan' => 'Tgl Pemeriksaan',
			'daftartindakan_id' => 'Daftartindakan',
			'tindakanpelayanan_id' => 'Tindakanpelayanan',
			'pasien_id' => 'Pasien',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pendaftaran_id' => 'Pendaftaran',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'daftartindakan_nama' => 'Daftartindakan Nama',
			'no_lab' => 'No Lab',
			'sel_epitel_pewarnaan' => 'Sel Epitel Pewarnaan',
			'sel_radang_pewarnaan' => 'Sel Radang Pewarnaan',
			'mikroorganisme' => 'Mikroorganisme',
			'ziehlnielsen_pewarnaan' => 'Ziehlnielsen Pewarnaan',
			'koh_pewarnaan' => 'Koh Pewarnaan',
			'niesser_pewarnaan' => 'Niesser Pewarnaan',
			'negatif_pewarnaan' => 'Negatif Pewarnaan',
			'spora_pewarnaan' => 'Spora Pewarnaan',
			'giemsa_pewarnaan' => 'Giemsa Pewarnaan',
			'mikroorganisme_ket' => 'Mikroorganisme Ket',
			'saran_pewarnaan' => 'Saran Pewarnaan',
			'pewarnaan_lain' => 'Pewarnaan Lain',
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

		$criteria->compare('pemeriksaanpewarnaan_id',$this->pemeriksaanpewarnaan_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('dpjp_id',$this->dpjp_id);
		$criteria->compare('perawat_id',$this->perawat_id);
		$criteria->compare('tgl_pemeriksaan',$this->tgl_pemeriksaan,true);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('tindakanpelayanan_id',$this->tindakanpelayanan_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('daftartindakan_nama',$this->daftartindakan_nama,true);
		$criteria->compare('no_lab',$this->no_lab,true);
		$criteria->compare('sel_epitel_pewarnaan',$this->sel_epitel_pewarnaan,true);
		$criteria->compare('sel_radang_pewarnaan',$this->sel_radang_pewarnaan,true);
		$criteria->compare('mikroorganisme',$this->mikroorganisme,true);
		$criteria->compare('ziehlnielsen_pewarnaan',$this->ziehlnielsen_pewarnaan,true);
		$criteria->compare('koh_pewarnaan',$this->koh_pewarnaan,true);
		$criteria->compare('niesser_pewarnaan',$this->niesser_pewarnaan,true);
		$criteria->compare('negatif_pewarnaan',$this->negatif_pewarnaan,true);
		$criteria->compare('spora_pewarnaan',$this->spora_pewarnaan,true);
		$criteria->compare('giemsa_pewarnaan',$this->giemsa_pewarnaan,true);
		$criteria->compare('mikroorganisme_ket',$this->mikroorganisme_ket,true);
		$criteria->compare('saran_pewarnaan',$this->saran_pewarnaan,true);
		$criteria->compare('pewarnaan_lain',$this->pewarnaan_lain,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PemeriksaanpewarnaanT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
