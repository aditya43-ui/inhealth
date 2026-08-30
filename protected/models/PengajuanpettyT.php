<?php

/**
 * This is the model class for table "pengajuanpetty_t".
 *
 * The followings are the available columns in table 'pengajuanpetty_t':
 * @property integer $pengajuanpetty_id
 * @property string $pengajuanpetty_tgl
 * @property string $pengajuanpetty_no
 * @property integer $ruangan_id
 * @property integer $pegawai_id
 * @property double $pengajuanpetty_total
 * @property string $pengajuanpetty_untuk
 * @property string $pengajuanpetty_status
 * @property integer $diketahuiatasan_id
 * @property string $diketahuiatasan_tgl
 * @property integer $diketahuikeuangan_id
 * @property string $diketahuikeuangan_tgl
 * @property integer $accdirektur_id
 * @property string $accdirektur_tgl
 * @property integer $tandabuktikeluar_id
 * @property integer $profilrs_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PengajuanpettydetT[] $pengajuanpettydetTs
 */
class PengajuanpettyT extends CActiveRecord
{
	public $diketahuiatasan_nama;
	public $diketahuikeuangan_nama;
	public $accdirektur_nama;
	public $kabidyanmed_nama, $disetujuioleh_nama;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengajuanpettyT the static model class
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
		return 'pengajuanpetty_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pengajuanpetty_tgl, pengajuanpetty_no, ruangan_id, pegawai_id, profilrs_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('ruangan_id, pegawai_id, diketahuiatasan_id, diketahuikeuangan_id, accdirektur_id, tandabuktikeluar_id, profilrs_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('pengajuanpetty_total', 'numerical'),
			array('pengajuanpetty_no', 'length', 'max'=>50),
			array('pengajuanpetty_untuk', 'length', 'max'=>250),
			array('pengajuanpetty_status', 'length', 'max'=>25),
			array('unitkerja_id, diketahuiatasan_tgl, diketahuikeuangan_tgl, accdirektur_tgl, update_time', 'safe'),
			array('pengajuanpetty_kategori, kabidyanmed_id, kabidyanmed_tgl, disetujuioleh_id, disetujuioleh_tgl','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pengajuanpetty_id, pengajuanpetty_tgl, pengajuanpetty_no, ruangan_id, pegawai_id, pengajuanpetty_total, pengajuanpetty_untuk, pengajuanpetty_status, diketahuiatasan_id, diketahuiatasan_tgl, diketahuikeuangan_id, diketahuikeuangan_tgl, accdirektur_id, accdirektur_tgl, tandabuktikeluar_id, profilrs_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, disetujuioleh_id, disetujuioleh_tgl', 'safe', 'on'=>'search'),
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
			'pengajuanpettydetTs' => array(self::HAS_MANY, 'PengajuanpettydetT', 'pengajuanpetty_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'atasan' => array(self::BELONGS_TO, 'PegawaiM', 'diketahuiatasan_id'),
			'keuangan' => array(self::BELONGS_TO, 'PegawaiM', 'diketahuikeuangan_id'),
			'direktur' => array(self::BELONGS_TO, 'PegawaiM', 'accdirektur_id'),
			'kabidyanmed' => array(self::BELONGS_TO, 'PegawaiM', 'kabidyanmed_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
			'unitkerja' => array(self::BELONGS_TO, 'UnitkerjaM', 'unitkerja_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pengajuanpetty_id' => 'ID',
			'pengajuanpetty_tgl' => 'Tgl. Pengajuan',
			'pengajuanpetty_no' => 'No. Pengajuan',
			'ruangan_id' => 'Ruangan',
			'pegawai_id' => 'Pegawai',
			'pengajuanpetty_total' => 'Total',
			'pengajuanpetty_untuk' => 'Alasan Pengajuan',
			'pengajuanpetty_status' => 'Status',
			'diketahuiatasan_id' => 'Atasan',
			'diketahuiatasan_tgl' => 'Tanggal Diketahui Atasan',
			'diketahuikeuangan_id' => 'Keuangan',
			'diketahuikeuangan_tgl' => 'Tanggal Diketahui Keuangan',
			'accdirektur_id' => 'Direktur',
			'accdirektur_tgl' => 'Tanggal Acc Direktur',
			'tandabuktikeluar_id' => 'Tanda Bukti Keluar',
			'profilrs_id' => 'ID',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'pengajuanpetty_kategori' => 'Kategori',
			'kabidyanmed_id' => 'Kabid Yanmed',
			'kabidyanmed_tgl' => 'Tanggal Diketahui Kabid Yanmed'
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
		$criteria->compare('pengajuanpetty_tgl',$this->pengajuanpetty_tgl,true);
		$criteria->compare('pengajuanpetty_no',$this->pengajuanpetty_no,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('pengajuanpetty_total',$this->pengajuanpetty_total);
		$criteria->compare('pengajuanpetty_untuk',$this->pengajuanpetty_untuk,true);
		$criteria->compare('pengajuanpetty_status',$this->pengajuanpetty_status,true);
		$criteria->compare('diketahuiatasan_id',$this->diketahuiatasan_id);
		$criteria->compare('diketahuiatasan_tgl',$this->diketahuiatasan_tgl,true);
		$criteria->compare('diketahuikeuangan_id',$this->diketahuikeuangan_id);
		$criteria->compare('diketahuikeuangan_tgl',$this->diketahuikeuangan_tgl,true);
		$criteria->compare('accdirektur_id',$this->accdirektur_id);
		$criteria->compare('accdirektur_tgl',$this->accdirektur_tgl,true);
		$criteria->compare('tandabuktikeluar_id',$this->tandabuktikeluar_id);
		$criteria->compare('profilrs_id',$this->profilrs_id);
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