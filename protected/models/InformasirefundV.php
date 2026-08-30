<?php

/**
 * This is the model class for table "informasirefund_v".
 *
 * The followings are the available columns in table 'informasirefund_v':
 * @property integer $pembebasantarif_id
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $jenisidentitas
 * @property string $no_identitas_pasien
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $jeniskelamin
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $alamat_pasien
 * @property integer $kelurahan_id
 * @property string $kelurahan_nama
 * @property integer $kecamatan_id
 * @property string $kecamatan_nama
 * @property integer $kabupaten_id
 * @property string $kabupaten_nama
 * @property integer $propinsi_id
 * @property string $propinsi_nama
 * @property string $statusperkawinan
 * @property string $agama
 * @property string $no_telepon_pasien
 * @property string $no_mobile_pasien
 * @property string $warga_negara
 * @property string $alamatemail
 * @property string $nama_ibu
 * @property string $nama_ayah
 * @property string $tglpembebasan
 * @property double $jmlpembebasan
 * @property integer $returbayarpelayanan_id
 * @property string $tglreturpelayanan
 * @property string $noreturbayar
 * @property double $totaloaretur
 * @property integer $tandabuktibayar_id
 * @property string $tglbuktibayar
 * @property string $nobuktibayar
 * @property integer $tandabuktikeluar_id
 * @property string $tglkaskeluar
 * @property string $nokaskeluar
 */
class InformasirefundV extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'informasirefund_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pembebasantarif_id, pasien_id, kelurahan_id, kecamatan_id, kabupaten_id, propinsi_id, returbayarpelayanan_id, tandabuktibayar_id, tandabuktikeluar_id', 'numerical', 'integerOnly'=>true),
			array('jmlpembebasan, totaloaretur', 'numerical'),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('jenisidentitas, namadepan, jeniskelamin, statusperkawinan, agama, no_mobile_pasien', 'length', 'max'=>20),
			array('no_identitas_pasien', 'length', 'max'=>30),
			array('nama_pasien, kelurahan_nama, kecamatan_nama, kabupaten_nama, propinsi_nama, nama_ibu, nama_ayah, noreturbayar, nobuktibayar, nokaskeluar', 'length', 'max'=>50),
			array('tempat_lahir, warga_negara', 'length', 'max'=>25),
			array('no_telepon_pasien', 'length', 'max'=>15),
			array('alamatemail', 'length', 'max'=>100),
			array('tanggal_lahir, alamat_pasien, tglpembebasan, tglreturpelayanan, tglbuktibayar, tglkaskeluar', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pembebasantarif_id, pasien_id, no_rekam_medik, jenisidentitas, no_identitas_pasien, namadepan, nama_pasien, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, kelurahan_id, kelurahan_nama, kecamatan_id, kecamatan_nama, kabupaten_id, kabupaten_nama, propinsi_id, propinsi_nama, statusperkawinan, agama, no_telepon_pasien, no_mobile_pasien, warga_negara, alamatemail, nama_ibu, nama_ayah, tglpembebasan, jmlpembebasan, returbayarpelayanan_id, tglreturpelayanan, noreturbayar, totaloaretur, tandabuktibayar_id, tglbuktibayar, nobuktibayar, tandabuktikeluar_id, tglkaskeluar, nokaskeluar', 'safe', 'on'=>'search'),
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
			'pembebasantarif_id' => 'Pembebasantarif',
			'pasien_id' => 'Pasien',
			'no_rekam_medik' => 'No Rekam Medik',
			'jenisidentitas' => 'Jenisidentitas',
			'no_identitas_pasien' => 'No Identitas Pasien',
			'namadepan' => 'Namadepan',
			'nama_pasien' => 'Nama Pasien',
			'jeniskelamin' => 'Jeniskelamin',
			'tempat_lahir' => 'Tempat Lahir',
			'tanggal_lahir' => 'Tanggal Lahir',
			'alamat_pasien' => 'Alamat Pasien',
			'kelurahan_id' => 'Kelurahan',
			'kelurahan_nama' => 'Kelurahan Nama',
			'kecamatan_id' => 'Kecamatan',
			'kecamatan_nama' => 'Kecamatan Nama',
			'kabupaten_id' => 'Kabupaten',
			'kabupaten_nama' => 'Kabupaten Nama',
			'propinsi_id' => 'Propinsi',
			'propinsi_nama' => 'Propinsi Nama',
			'statusperkawinan' => 'Statusperkawinan',
			'agama' => 'Agama',
			'no_telepon_pasien' => 'No Telepon Pasien',
			'no_mobile_pasien' => 'No Mobile Pasien',
			'warga_negara' => 'Warga Negara',
			'alamatemail' => 'Alamatemail',
			'nama_ibu' => 'Nama Ibu',
			'nama_ayah' => 'Nama Ayah',
			'tglpembebasan' => 'Tglpembebasan',
			'jmlpembebasan' => 'Jmlpembebasan',
			'returbayarpelayanan_id' => 'Returbayarpelayanan',
			'tglreturpelayanan' => 'Tglreturpelayanan',
			'noreturbayar' => 'Noreturbayar',
			'totaloaretur' => 'Totaloaretur',
			'tandabuktibayar_id' => 'Tandabuktibayar',
			'tglbuktibayar' => 'Tglbuktibayar',
			'nobuktibayar' => 'Nobuktibayar',
			'tandabuktikeluar_id' => 'Tandabuktikeluar',
			'tglkaskeluar' => 'Tglkaskeluar',
			'nokaskeluar' => 'Nokaskeluar',
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

		$criteria->compare('pembebasantarif_id',$this->pembebasantarif_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('jenisidentitas',$this->jenisidentitas,true);
		$criteria->compare('no_identitas_pasien',$this->no_identitas_pasien,true);
		$criteria->compare('namadepan',$this->namadepan,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('tempat_lahir',$this->tempat_lahir,true);
		$criteria->compare('tanggal_lahir',$this->tanggal_lahir,true);
		$criteria->compare('alamat_pasien',$this->alamat_pasien,true);
		$criteria->compare('kelurahan_id',$this->kelurahan_id);
		$criteria->compare('kelurahan_nama',$this->kelurahan_nama,true);
		$criteria->compare('kecamatan_id',$this->kecamatan_id);
		$criteria->compare('kecamatan_nama',$this->kecamatan_nama,true);
		$criteria->compare('kabupaten_id',$this->kabupaten_id);
		$criteria->compare('kabupaten_nama',$this->kabupaten_nama,true);
		$criteria->compare('propinsi_id',$this->propinsi_id);
		$criteria->compare('propinsi_nama',$this->propinsi_nama,true);
		$criteria->compare('statusperkawinan',$this->statusperkawinan,true);
		$criteria->compare('agama',$this->agama,true);
		$criteria->compare('no_telepon_pasien',$this->no_telepon_pasien,true);
		$criteria->compare('no_mobile_pasien',$this->no_mobile_pasien,true);
		$criteria->compare('warga_negara',$this->warga_negara,true);
		$criteria->compare('alamatemail',$this->alamatemail,true);
		$criteria->compare('nama_ibu',$this->nama_ibu,true);
		$criteria->compare('nama_ayah',$this->nama_ayah,true);
		$criteria->compare('tglpembebasan',$this->tglpembebasan,true);
		$criteria->compare('jmlpembebasan',$this->jmlpembebasan);
		$criteria->compare('returbayarpelayanan_id',$this->returbayarpelayanan_id);
		$criteria->compare('tglreturpelayanan',$this->tglreturpelayanan,true);
		$criteria->compare('noreturbayar',$this->noreturbayar,true);
		$criteria->compare('totaloaretur',$this->totaloaretur);
		$criteria->compare('tandabuktibayar_id',$this->tandabuktibayar_id);
		$criteria->compare('tglbuktibayar',$this->tglbuktibayar,true);
		$criteria->compare('nobuktibayar',$this->nobuktibayar,true);
		$criteria->compare('tandabuktikeluar_id',$this->tandabuktikeluar_id);
		$criteria->compare('tglkaskeluar',$this->tglkaskeluar,true);
		$criteria->compare('nokaskeluar',$this->nokaskeluar,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return InformasirefundV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
