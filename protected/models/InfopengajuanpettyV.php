<?php

/**
 * This is the model class for table "infopengajuanpetty_v".
 *
 * The followings are the available columns in table 'infopengajuanpetty_v':
 * @property integer $pengajuanpetty_id
 * @property string $pengajuanpetty_no
 * @property string $pengajuanpetty_tgl
 * @property string $pengajuanpetty_untuk
 * @property string $pengajuanpetty_status
 * @property double $pengajuanpetty_total
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $pembuat_id
 * @property string $pembuat_gelardepan
 * @property string $pembuat_nama
 * @property string $pembuat_jabatan
 * @property string $pembuat_gelarbelakang
 * @property string $diketahuiatasan_tgl
 * @property integer $atasan_id
 * @property string $atasan_gelardepan
 * @property string $atasan_nama
 * @property string $atasan_jabatan
 * @property string $atasan_gelarbelakang
 * @property string $diketahuikeuangan_tgl
 * @property integer $keuangan_id
 * @property string $keuangan_gelardepan
 * @property string $keuangan_nama
 * @property string $keuangan_jabatan
 * @property string $keuangan_gelarbelakang
 * @property string $accdirektur_tgl
 * @property integer $direktur_id
 * @property string $direktur_gelardepan
 * @property string $direktur_nama
 * @property string $direktur_jabatan
 * @property string $direktur_gelarbelakang
 * @property integer $tandabuktikeluar_id
 * @property string $tglkaskeluar
 * @property string $nokaskeluar
 * @property string $carabayarkeluar
 * @property string $namapenerima
 */
class InfopengajuanpettyV extends CActiveRecord
{
	public $tgl_awal;
	public $tgl_akhir;
	public $unitkerja_id;
	public $jns_periode;
	public $bln_awal;
	public $bln_akhir;
	public $thn_awal;
	public $thn_akhir;
	public $data;
	public $jumlah, $jenispengeluaran_id;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfopengajuanpettyV the static model class
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
		return 'infopengajuanpetty_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pengajuanpetty_id, ruangan_id, pembuat_id, atasan_id, keuangan_id, direktur_id, tandabuktikeluar_id', 'numerical', 'integerOnly'=>true),
			array('pengajuanpetty_total', 'numerical'),
			array('pengajuanpetty_no, ruangan_nama, pembuat_nama, atasan_nama, keuangan_nama, direktur_nama, nokaskeluar, carabayarkeluar', 'length', 'max'=>50),
			array('pengajuanpetty_untuk', 'length', 'max'=>250),
			array('pengajuanpetty_status', 'length', 'max'=>25),
			array('pembuat_gelardepan, atasan_gelardepan, keuangan_gelardepan, direktur_gelardepan', 'length', 'max'=>10),
			array('pembuat_jabatan, atasan_jabatan, keuangan_jabatan, direktur_jabatan, namapenerima', 'length', 'max'=>100),
			array('pembuat_gelarbelakang, atasan_gelarbelakang, keuangan_gelarbelakang, direktur_gelarbelakang', 'length', 'max'=>15),
			array('pengajuanpetty_tgl, diketahuiatasan_tgl, diketahuikeuangan_tgl, accdirektur_tgl, tglkaskeluar', 'safe'),
			array('pengajuanpetty_kategori, kabidyanmed_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pengajuanpetty_id, pengajuanpetty_no, pengajuanpetty_tgl, pengajuanpetty_untuk, pengajuanpetty_status, pengajuanpetty_total, ruangan_id, ruangan_nama, pembuat_id, pembuat_gelardepan, pembuat_nama, pembuat_jabatan, pembuat_gelarbelakang, diketahuiatasan_tgl, atasan_id, atasan_gelardepan, atasan_nama, atasan_jabatan, atasan_gelarbelakang, diketahuikeuangan_tgl, keuangan_id, keuangan_gelardepan, keuangan_nama, keuangan_jabatan, keuangan_gelarbelakang, accdirektur_tgl, direktur_id, direktur_gelardepan, direktur_nama, direktur_jabatan, direktur_gelarbelakang, tandabuktikeluar_id, tglkaskeluar, nokaskeluar, carabayarkeluar, namapenerima', 'safe', 'on'=>'search'),
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
			'pengajuanpetty_id' => 'Pengajuanpetty',
			'pengajuanpetty_no' => 'No. Pengajuan',
			'pengajuanpetty_tgl' => 'Tanggal Pengajuan',
			'pengajuanpetty_untuk' => 'Untuk',
			'pengajuanpetty_status' => 'Status',
			'pengajuanpetty_total' => 'Total',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan',
			'pembuat_id' => 'Pembuat',
			'pembuat_gelardepan' => 'Pembuat Gelardepan',
			'pembuat_nama' => 'Yang Mengajukan',
			'pembuat_jabatan' => 'Pembuat Jabatan',
			'pembuat_gelarbelakang' => 'Pembuat Gelarbelakang',
			'diketahuiatasan_tgl' => 'Diketahuiatasan Tgl',
			'atasan_id' => 'Atasan',
			'atasan_gelardepan' => 'Atasan Gelardepan',
			'atasan_nama' => 'Kabid Admin & Umum',
			'atasan_jabatan' => 'Atasan Jabatan',
			'atasan_gelarbelakang' => 'Atasan Gelarbelakang',
			'diketahuikeuangan_tgl' => 'Diketahuikeuangan Tgl',
			'keuangan_id' => 'Keuangan',
			'keuangan_gelardepan' => 'Keuangan Gelardepan',
			'keuangan_nama' => 'Pemegang Kas',
			'keuangan_jabatan' => 'Keuangan Jabatan',
			'keuangan_gelarbelakang' => 'Keuangan Gelarbelakang',
			'accdirektur_tgl' => 'Accdirektur Tgl',
			'direktur_id' => 'Direktur',
			'direktur_gelardepan' => 'Direktur Gelardepan',
			'direktur_nama' => 'Direktur',
			'direktur_jabatan' => 'Direktur Jabatan',
			'direktur_gelarbelakang' => 'Direktur Gelarbelakang',
			'kabidyanmed_id' => 'Kabid Yanmed',
			'kabidyanmed_gelardepan' => 'Kabid Yanmed Gelardepan',
			'kabidyanmed_nama' => 'Kabid Yanmed',
			'kabidyanmed_jabatan' => 'Kabid Yanmed Jabatan',
			'kabidyanmed_gelarbelakang' => 'Kabid Yanmed Gelarbelakang',
			'tandabuktikeluar_id' => 'Tanda Bukti Keluar',
			'tglkaskeluar' => 'Tgl. Kas Keluar',
			'nokaskeluar' => 'No. Kas Keluar',
			'carabayarkeluar' => 'Cara Bayar Keluar',
			'namapenerima' => 'Nama Penerima',
			'pengajuanpetty_kategori' => 'Kategori'
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

		$criteria->compare('pengajuanpetty_id',$this->pengajuanpetty_id);
		$criteria->compare('pengajuanpetty_no',$this->pengajuanpetty_no,true);
		$criteria->compare('pengajuanpetty_tgl',$this->pengajuanpetty_tgl,true);
		$criteria->compare('pengajuanpetty_untuk',$this->pengajuanpetty_untuk,true);
		$criteria->compare('pengajuanpetty_status',$this->pengajuanpetty_status,true);
		$criteria->compare('pengajuanpetty_total',$this->pengajuanpetty_total);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('pembuat_id',$this->pembuat_id);
		$criteria->compare('pembuat_gelardepan',$this->pembuat_gelardepan,true);
		$criteria->compare('pembuat_nama',$this->pembuat_nama,true);
		$criteria->compare('pembuat_jabatan',$this->pembuat_jabatan,true);
		$criteria->compare('pembuat_gelarbelakang',$this->pembuat_gelarbelakang,true);
		$criteria->compare('diketahuiatasan_tgl',$this->diketahuiatasan_tgl,true);
		$criteria->compare('atasan_id',$this->atasan_id);
		$criteria->compare('atasan_gelardepan',$this->atasan_gelardepan,true);
		$criteria->compare('atasan_nama',$this->atasan_nama,true);
		$criteria->compare('atasan_jabatan',$this->atasan_jabatan,true);
		$criteria->compare('atasan_gelarbelakang',$this->atasan_gelarbelakang,true);
		$criteria->compare('diketahuikeuangan_tgl',$this->diketahuikeuangan_tgl,true);
		$criteria->compare('keuangan_id',$this->keuangan_id);
		$criteria->compare('keuangan_gelardepan',$this->keuangan_gelardepan,true);
		$criteria->compare('keuangan_nama',$this->keuangan_nama,true);
		$criteria->compare('keuangan_jabatan',$this->keuangan_jabatan,true);
		$criteria->compare('keuangan_gelarbelakang',$this->keuangan_gelarbelakang,true);
		$criteria->compare('accdirektur_tgl',$this->accdirektur_tgl,true);
		$criteria->compare('direktur_id',$this->direktur_id);
		$criteria->compare('direktur_gelardepan',$this->direktur_gelardepan,true);
		$criteria->compare('direktur_nama',$this->direktur_nama,true);
		$criteria->compare('direktur_jabatan',$this->direktur_jabatan,true);
		$criteria->compare('direktur_gelarbelakang',$this->direktur_gelarbelakang,true);
		$criteria->compare('tandabuktikeluar_id',$this->tandabuktikeluar_id);
		$criteria->compare('tglkaskeluar',$this->tglkaskeluar,true);
		$criteria->compare('nokaskeluar',$this->nokaskeluar,true);
		$criteria->compare('carabayarkeluar',$this->carabayarkeluar,true);
		$criteria->compare('namapenerima',$this->namapenerima,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getNamaLengkapMengajukan(){
		return $this->pembuat_gelardepan.' '.$this->pembuat_nama.' '.$this->pembuat_gelarbelakang;
	}
	
	public function getNamaLengkapAtasan(){
		return $this->atasan_gelardepan.' '.$this->atasan_nama.' '.$this->atasan_gelarbelakang;
	}
	
	public function getNamaLengkapKeuangan(){
		return $this->keuangan_gelardepan.' '.$this->keuangan_nama.' '.$this->keuangan_gelarbelakang;
	}
	
	public function getNamaLengkapDirektur(){
		return $this->direktur_gelardepan.' '.$this->direktur_nama.' '.$this->direktur_gelarbelakang;
	}
	
	public function getNamaLengkapKabidYanmed(){
		return $this->kabidyanmed_gelardepan.' '.$this->kabidyanmed_nama.' '.$this->kabidyanmed_gelarbelakang;
	}
}