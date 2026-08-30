<?php

/**
 * This is the model class for table "baserahterima_t".
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author  Yusuf Putra Anugrah <yusufputra@.com>
 * @package application.models
 * @category model
 * 
 * The followings are the available columns in table 'baserahterima_t':
 * @property integer $baserahterima_id
 * @property integer $suratperjanjiankerja_id
 * @property string $baserahterima_nomor
 * @property string $baserahterima_tanggal
 * @property string $nomor_beritaacara
 * @property integer $pegpihakkesatu_id
 * @property string $jabatan_pihakkesatu
 * @property integer $supplier_id
 * @property double $jumlah_harga
 * @property double $jumlah_pajak
 * @property double $total_harga
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property SupplierM $supplier
 * @property SuratperjanjiankerjaT $suratperjanjiankerja
 */
class BaserahterimaT extends CActiveRecord
{
        public $pegpihakkesatu_alamat, $pegpihakkesatu_nip, $pegpihakkesatu_nama,
               $direktur, $alamat_penyedia, $supplier_nama, $dasar, $nomor, $nomorsurat, 
               $termin_terminke, $termin_terminjumlah, $termin_termintotal;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaserahterimaT the static model class
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
		return 'baserahterima_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nomor_beritaacara,suratperjanjiankerja_id, baserahterima_nomor, baserahterima_tanggal, jumlah_harga, jumlah_pajak, total_harga, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('suratperjanjiankerja_id, pegpihakkesatu_id, supplier_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('jumlah_harga, jumlah_pajak, total_harga', 'numerical'),
			array('baserahterima_nomor, nomor_beritaacara', 'length', 'max'=>50),
			array('jabatan_pihakkesatu', 'length', 'max'=>100),
			array('nomor_urut, isantidatir, terminke, termin_persen, total_dibulatkan, total_pembayaran, pajak_persen, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('baserahterima_id, suratperjanjiankerja_id, baserahterima_nomor, baserahterima_tanggal, nomor_beritaacara, pegpihakkesatu_id, jabatan_pihakkesatu, supplier_id, jumlah_harga, jumlah_pajak, total_harga, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegpihakkesatu_id'),
			'supplier' => array(self::BELONGS_TO, 'SupplierM', 'supplier_id'),
			'suratperjanjiankerja' => array(self::BELONGS_TO, 'SuratperjanjiankerjaT', 'suratperjanjiankerja_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'baserahterima_id' => 'Baserahterima',
			'suratperjanjiankerja_id' => 'Suratperjanjiankerja',
			'baserahterima_nomor' => 'Baserahterima Nomor',
			'baserahterima_tanggal' => 'Baserahterima Tanggal',
			'nomor_beritaacara' => 'Nomor Beritaacara',
			'pegpihakkesatu_id' => 'Pegpihakkesatu',
			'jabatan_pihakkesatu' => 'Jabatan Pihakkesatu',
			'supplier_id' => 'Supplier',
			'jumlah_harga' => 'Jumlah Harga',
			'jumlah_pajak' => 'Jumlah Pajak',
			'total_harga' => 'Total Harga',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
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

		$criteria->compare('baserahterima_id',$this->baserahterima_id);
		$criteria->compare('suratperjanjiankerja_id',$this->suratperjanjiankerja_id);
		$criteria->compare('baserahterima_nomor',$this->baserahterima_nomor,true);
		$criteria->compare('baserahterima_tanggal',$this->baserahterima_tanggal,true);
		$criteria->compare('nomor_beritaacara',$this->nomor_beritaacara,true);
		$criteria->compare('pegpihakkesatu_id',$this->pegpihakkesatu_id);
		$criteria->compare('jabatan_pihakkesatu',$this->jabatan_pihakkesatu,true);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('jumlah_harga',$this->jumlah_harga);
		$criteria->compare('jumlah_pajak',$this->jumlah_pajak);
		$criteria->compare('total_harga',$this->total_harga);
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