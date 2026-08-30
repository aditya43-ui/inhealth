<?php

/**
 * This is the model class for table "realisasidiklat_t".
 *
 * The followings are the available columns in table 'realisasidiklat_t':
 * @property integer $realisasidiklat_id
 * @property integer $jenisdiklat_id
 * @property string $norealisasi
 * @property string $tglrealisasi
 * @property string $realisasi_tglawal
 * @property string $realisasi_tglakhir
 * @property string $tempat
 * @property string $alamat
 * @property integer $pemberitugas_id
 * @property integer $mengetahui_id
 * @property integer $menyetujui_id
 * @property string $tglmengetahui
 * @property string $tglmenyetujui
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property string $namapelatihan
 * @property string $keterangan_diklat
 * @property string $penyelenggara
 * @property string $pemateri
 * @property double $jumlah_peserta
 * @property string $jam_mulai
 * @property string $jam_akhir
 * @property double $total_jam
 * @property double $total_menit
 * @property integer $rencanadiklat_id
 *
 * The followings are the available model relations:
 * @property RencanadiklatT $rencanadiklat
 * @property RealisasibiayapelT[] $realisasibiayapelTs
 */
class RealisasidiklatT extends CActiveRecord
{
        public $jenisdiklat_nama;
        public $pegawaimengetahui_nama;
        public $pegawaimenyetujui_nama;
        public $pejabatyangmendiklat_nama;
        
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RealisasidiklatT the static model class
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
		return 'realisasidiklat_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenisdiklat_id, norealisasi, tglrealisasi, create_time, create_loginpemakai_id, create_ruangan, rencanadiklat_id', 'required'),
			array('jenisdiklat_id, pemberitugas_id, mengetahui_id, menyetujui_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, rencanadiklat_id', 'numerical', 'integerOnly'=>true),
			array('jumlah_peserta, total_jam, total_menit', 'numerical'),
			array('norealisasi', 'length', 'max'=>50),
			array('tempat, namapelatihan, penyelenggara, pemateri', 'length', 'max'=>100),
			array('keterangan_diklat', 'length', 'max'=>500),
			array('pejabatyangmendiklat, no_sk, tgl_ditetapkan, realisasi_tglawal, realisasi_tglakhir, alamat, tglmengetahui, tglmenyetujui, update_time, jam_mulai, jam_akhir, durasijam_awal, durasijam_akhir, dokumentasikegiatan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('realisasidiklat_id, jenisdiklat_id, norealisasi, tglrealisasi, realisasi_tglawal, realisasi_tglakhir, tempat, alamat, pemberitugas_id, mengetahui_id, menyetujui_id, tglmengetahui, tglmenyetujui, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, namapelatihan, keterangan_diklat, penyelenggara, pemateri, jumlah_peserta, jam_mulai, jam_akhir, total_jam, total_menit, rencanadiklat_id, durasijam_awal, durasijam_akhir, dokumentasikegiatan', 'safe', 'on'=>'search'),
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
			'rencanadiklat' => array(self::BELONGS_TO, 'RencanadiklatT', 'rencanadiklat_id'),
			'realisasibiayapelTs' => array(self::HAS_MANY, 'RealisasibiayapelT', 'realisasidiklat_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'realisasidiklat_id' => 'Realisasidiklat',
			'jenisdiklat_id' => 'Jenisdiklat',
			'norealisasi' => 'No Realisasi',
			'tglrealisasi' => 'Tgl. Realisasi',
			'realisasi_tglawal' => 'Realisasi Tglawal',
			'realisasi_tglakhir' => 'Realisasi Tglakhir',
			'tempat' => 'Tempat Pelatihan',
			'alamat' => 'Alamat Pelatihan',
			'pemberitugas_id' => 'Pemberitugas',
			'mengetahui_id' => 'Mengetahui',
			'menyetujui_id' => 'Menyetujui',
			'tglmengetahui' => 'Tglmengetahui',
			'tglmenyetujui' => 'Tglmenyetujui',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'namapelatihan' => 'Pelatihan',
			'keterangan_diklat' => 'Keterangan Realisasi',
			'penyelenggara' => 'Penyelenggara',
			'pemateri' => 'Pemateri',
			'jumlah_peserta' => 'Jumlah Peserta',
			'jam_mulai' => 'Jam Mulai',
			'jam_akhir' => 'Jam Akhir',
			'total_jam' => 'Total Jam',
			'total_menit' => 'Total Menit',
			'rencanadiklat_id' => 'Rencanadiklat',
                        'pejabatyangmendiklat' => 'Pejabat Diklat',
                        'tgl_ditetapkan' => 'Tanggal Ditetapkan',
                        'no_sk' => 'No SK',
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

		$criteria->compare('realisasidiklat_id',$this->realisasidiklat_id);
		$criteria->compare('jenisdiklat_id',$this->jenisdiklat_id);
		$criteria->compare('lower(norealisasi)',strtolower($this->norealisasi),true);
		$criteria->compare('tglrealisasi',$this->tglrealisasi,true);
		$criteria->compare('realisasi_tglawal',$this->realisasi_tglawal,true);
		$criteria->compare('realisasi_tglakhir',$this->realisasi_tglakhir,true);
		$criteria->compare('lower(tempat)', strtolower($this->tempat), true);
		$criteria->compare('lower(alamat)',strtolower($this->alamat),true);
		$criteria->compare('pemberitugas_id',$this->pemberitugas_id);
		$criteria->compare('mengetahui_id',$this->mengetahui_id);
		$criteria->compare('menyetujui_id',$this->menyetujui_id);
		$criteria->compare('tglmengetahui',$this->tglmengetahui,true);
		$criteria->compare('tglmenyetujui',$this->tglmenyetujui,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);
		$criteria->compare('lower(namapelatihan)',strtolower($this->namapelatihan),true);
		$criteria->compare('keterangan_diklat',$this->keterangan_diklat,true);
		$criteria->compare('penyelenggara',$this->penyelenggara,true);
		$criteria->compare('pemateri',$this->pemateri,true);
		$criteria->compare('jumlah_peserta',$this->jumlah_peserta);
		$criteria->compare('jam_mulai',$this->jam_mulai,true);
		$criteria->compare('jam_akhir',$this->jam_akhir,true);
		$criteria->compare('total_jam',$this->total_jam);
		$criteria->compare('total_menit',$this->total_menit);
		$criteria->compare('rencanadiklat_id',$this->rencanadiklat_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}