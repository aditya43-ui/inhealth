<?php

/**
 * This is the model class for table "bakemajuanhasilpekerjaan_t".
 *
 * @author  Andyka Putra <andykaputra@.com>
 * @author  Yusuf Putra Anugrah <yusufputra@.com>
 * @author  Aida Rahmawati <aidarahmawati@.com>
 * @package application.models
 * @category model
 * 
 * The followings are the available columns in table 'bakemajuanhasilpekerjaan_t':
 * @property integer $bakemajuanhasilpekerjaan_id
 * @property integer $suratperjanjiankerja_id
 * @property string $bakemajuanhasilpekerjaan_nomor
 * @property string $bakemajuanhasilpekerjaan_tanggal
 * @property string $nomor_beritaacara
 * @property integer $pegpihakkesatu_id
 * @property string $pihakkesatu_jabatan
 * @property integer $supplier_id
 * @property double $jumlah_harga
 * @property double $jumlah_pajak
 * @property double $total_harga
 * @property integer $tahap_pekerjaan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property BakemajuanhasilpekerjaandetT[] $bakemajuanhasilpekerjaandetTs
 * @property SuratperjanjiankerjaT $suratperjanjiankerja
 * @property SupplierM $supplier
 * @property PegawaiM $pegpihakkesatu
 */
class BakemajuanhasilpekerjaanT extends CActiveRecord
{
        public $nomorsurat, $nomor, $termin_jumlah, $termin_terminke, $pegpihakkesatu_nama, $pegpihakkesatu_nip, $pegpihakkesatu_alamat, $supplier_nama, $direktur, $alamat_penyedia, $isi_surat; 
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BakemajuanhasilpekerjaanT the static model class
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
		return 'bakemajuanhasilpekerjaan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nomor_beritaacara,suratperjanjiankerja_id, bakemajuanhasilpekerjaan_nomor, bakemajuanhasilpekerjaan_tanggal, jumlah_harga, jumlah_pajak, total_harga, tahap_pekerjaan, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('suratperjanjiankerja_id, pegpihakkesatu_id, supplier_id, tahap_pekerjaan, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('jumlah_harga, jumlah_pajak, total_harga', 'numerical'),
			array('bakemajuanhasilpekerjaan_nomor, nomor_beritaacara', 'length', 'max'=>50),
			array('pihakkesatu_jabatan', 'length', 'max'=>100),
			array('isantidatir, nomor_urut, total_dibulatkan, total_pembayaran, pajak_persen, terminke, termin_persen, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('bakemajuanhasilpekerjaan_id, suratperjanjiankerja_id, bakemajuanhasilpekerjaan_nomor, bakemajuanhasilpekerjaan_tanggal, nomor_beritaacara, pegpihakkesatu_id, pihakkesatu_jabatan, supplier_id, jumlah_harga, jumlah_pajak, total_harga, tahap_pekerjaan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'bakemajuanhasilpekerjaandetTs' => array(self::HAS_MANY, 'BakemajuanhasilpekerjaandetT', 'bakemajuanhasilpekerjaan_id'),
			'suratperjanjiankerja' => array(self::BELONGS_TO, 'SuratperjanjiankerjaT', 'suratperjanjiankerja_id'),
			'supplier' => array(self::BELONGS_TO, 'SupplierM', 'supplier_id'),
			'pegpihakkesatu' => array(self::BELONGS_TO, 'PegawaiM', 'pegpihakkesatu_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'bakemajuanhasilpekerjaan_id' => 'Bakemajuanhasilpekerjaan',
			'suratperjanjiankerja_id' => 'Suratperjanjiankerja',
			'bakemajuanhasilpekerjaan_nomor' => 'Nomor Transaksi',
			'bakemajuanhasilpekerjaan_tanggal' => 'Tanggal Pembuatan BA',
			'nomor_beritaacara' => 'Nomor BA',
			'pegpihakkesatu_id' => 'Nama Pegawai',
			'pihakkesatu_jabatan' => 'Jabatan',
			'supplier_id' => 'Penyedia',
			'jumlah_harga' => 'Jumlah Harga',
			'jumlah_pajak' => 'Jumlah Pajak',
			'total_harga' => 'Total Harga',
			'tahap_pekerjaan' => 'Tahap Pekerjaan Ke',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'terminke' => 'Termin Ke',
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

		$criteria->compare('bakemajuanhasilpekerjaan_id',$this->bakemajuanhasilpekerjaan_id);
		$criteria->compare('suratperjanjiankerja_id',$this->suratperjanjiankerja_id);
		$criteria->compare('bakemajuanhasilpekerjaan_nomor',$this->bakemajuanhasilpekerjaan_nomor,true);
		$criteria->compare('bakemajuanhasilpekerjaan_tanggal',$this->bakemajuanhasilpekerjaan_tanggal,true);
		$criteria->compare('nomor_beritaacara',$this->nomor_beritaacara,true);
		$criteria->compare('pegpihakkesatu_id',$this->pegpihakkesatu_id);
		$criteria->compare('pihakkesatu_jabatan',$this->pihakkesatu_jabatan,true);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('jumlah_harga',$this->jumlah_harga);
		$criteria->compare('jumlah_pajak',$this->jumlah_pajak);
		$criteria->compare('total_harga',$this->total_harga);
		$criteria->compare('tahap_pekerjaan',$this->tahap_pekerjaan);
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