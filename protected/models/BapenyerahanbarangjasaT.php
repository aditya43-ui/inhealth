<?php

/**
 * This is the model class for table "bapenyerahanbarangjasa_t".
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author  Yusuf Putra Anugrah <yusufputra@.com>
 * @package application.models
 * @category model
 * The followings are the available columns in table 'bapenyerahanbarangjasa_t':
 * @property integer $bapenyerahanbarangjasa_id
 * @property integer $suratperjanjiankerja_id
 * @property string $bapenyerahanbarangjasa_nomor
 * @property string $bapenyerahanbarangjasa_tanggal
 * @property string $nomor_beritaacara
 * @property integer $pegpihakkesatu_id
 * @property string $jabatan_pihakkesatu
 * @property integer $pegpihakkedua_id
 * @property string $jabatan_pihakkedua
 * @property string $pernyataan
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
 * @property PegawaiM $pegpihakkedua
 * @property PegawaiM $pegpihakkesatu
 * @property SuratperjanjiankerjaT $suratperjanjiankerja
 */
class BapenyerahanbarangjasaT extends CActiveRecord
{
        public $pegpihakkesatu_nip, $pegpihakkesatu_alamat, $pegpihakkesatu_nama,
               $pegpihakkedua_nip, $pegpihakkedua_alamat, $pegpihakkedua_nama, $dasar,
               $total_termin, $termin_ke, $nomor_urut, $nomor;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BapenyerahanbarangjasaT the static model class
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
		return 'bapenyerahanbarangjasa_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nomor_beritaacara,suratperjanjiankerja_id, bapenyerahanbarangjasa_nomor, bapenyerahanbarangjasa_tanggal, jumlah_harga, jumlah_pajak, total_harga, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('suratperjanjiankerja_id, pegpihakkesatu_id, pegpihakkedua_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('jumlah_harga, jumlah_pajak, total_harga', 'numerical'),
			array('bapenyerahanbarangjasa_nomor, nomor_beritaacara', 'length', 'max'=>50),
			array('jabatan_pihakkesatu, jabatan_pihakkedua', 'length', 'max'=>100),
			array('bapenyerahanbarangjasa_t, pernyataan, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('bapenyerahanbarangjasa_id, suratperjanjiankerja_id, bapenyerahanbarangjasa_nomor, bapenyerahanbarangjasa_tanggal, nomor_beritaacara, pegpihakkesatu_id, jabatan_pihakkesatu, pegpihakkedua_id, jabatan_pihakkedua, pernyataan, jumlah_harga, jumlah_pajak, total_harga, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pegpihakkedua' => array(self::BELONGS_TO, 'PegawaiM', 'pegpihakkedua_id'),
			'pegpihakkesatu' => array(self::BELONGS_TO, 'PegawaiM', 'pegpihakkesatu_id'),
			'suratperjanjiankerja' => array(self::BELONGS_TO, 'SuratperjanjiankerjaT', 'suratperjanjiankerja_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'bapenyerahanbarangjasa_id' => 'Bapenyerahanbarangjasa',
			'suratperjanjiankerja_id' => 'Suratperjanjiankerja',
			'bapenyerahanbarangjasa_nomor' => 'Nomor Transaksi',
			'bapenyerahanbarangjasa_tanggal' => 'Bapenyerahanbarangjasa Tanggal',
			'nomor_beritaacara' => 'Nomor Berita Acara',
			'pegpihakkesatu_id' => 'Pegpihakkesatu',
			'jabatan_pihakkesatu' => 'Jabatan Pihakkesatu',
			'pegpihakkedua_id' => 'Pegpihakkedua',
			'jabatan_pihakkedua' => 'Jabatan Pihakkedua',
			'pernyataan' => 'Pernyataan',
			'jumlah_harga' => 'Jumlah Harga',
			'jumlah_pajak' => 'Jumlah Pajak',
			'total_harga' => 'Total Harga',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
                        'terminke'=>'Termin Ke'
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

		$criteria->compare('bapenyerahanbarangjasa_id',$this->bapenyerahanbarangjasa_id);
		$criteria->compare('suratperjanjiankerja_id',$this->suratperjanjiankerja_id);
		$criteria->compare('bapenyerahanbarangjasa_nomor',$this->bapenyerahanbarangjasa_nomor,true);
		$criteria->compare('bapenyerahanbarangjasa_tanggal',$this->bapenyerahanbarangjasa_tanggal,true);
		$criteria->compare('nomor_beritaacara',$this->nomor_beritaacara,true);
		$criteria->compare('pegpihakkesatu_id',$this->pegpihakkesatu_id);
		$criteria->compare('jabatan_pihakkesatu',$this->jabatan_pihakkesatu,true);
		$criteria->compare('pegpihakkedua_id',$this->pegpihakkedua_id);
		$criteria->compare('jabatan_pihakkedua',$this->jabatan_pihakkedua,true);
		$criteria->compare('pernyataan',$this->pernyataan,true);
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