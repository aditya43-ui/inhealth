<?php

/**
 * This is the model class for table "cetakclosingkasir_v".
 *
 * The followings are the available columns in table 'cetakclosingkasir_v':
 * @property string $jenis_rekap
 * @property integer $closingkasir_id
 * @property string $nopembayaran
 * @property integer $tandabuktibayar_id
 * @property string $no_pendaftaran
 * @property string $nama_pasien
 * @property string $instalasi_nama
 * @property string $ruangan_nama
 * @property string $penjamin_nama
 * @property string $tglbuktibayar
 * @property string $jnspembayar_nama
 * @property string $namabankpembayaran
 * @property string $nokartu
 * @property double $nilai
 */
class CetakclosingkasirV extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cetakclosingkasir_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('closingkasir_id, tandabuktibayar_id', 'numerical', 'integerOnly'=>true),
			array('nilai', 'numerical'),
			array('no_pendaftaran', 'length', 'max'=>20),
			array('nama_pasien, instalasi_nama, ruangan_nama', 'length', 'max'=>50),
			array('penjamin_nama', 'length', 'max'=>100),
			array('jenis_rekap, nopembayaran, tglbuktibayar, jnspembayar_nama, namabankpembayaran, nokartu', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('jenis_rekap, closingkasir_id, nopembayaran, tandabuktibayar_id, no_pendaftaran, nama_pasien, instalasi_nama, ruangan_nama, penjamin_nama, tglbuktibayar, jnspembayar_nama, namabankpembayaran, nokartu, nilai', 'safe', 'on'=>'search'),
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
			'jenis_rekap' => 'Jenis Rekap',
			'closingkasir_id' => 'Closingkasir',
			'nopembayaran' => 'Nopembayaran',
			'tandabuktibayar_id' => 'Tandabuktibayar',
			'no_pendaftaran' => 'No Pendaftaran',
			'nama_pasien' => 'Nama Pasien',
			'instalasi_nama' => 'Instalasi Nama',
			'ruangan_nama' => 'Ruangan Nama',
			'penjamin_nama' => 'Penjamin Nama',
			'tglbuktibayar' => 'Tglbuktibayar',
			'jnspembayar_nama' => 'Jnspembayar Nama',
			'namabankpembayaran' => 'Namabankpembayaran',
			'nokartu' => 'Nokartu',
			'nilai' => 'Nilai',
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

		$criteria->compare('jenis_rekap',$this->jenis_rekap,true);
		$criteria->compare('closingkasir_id',$this->closingkasir_id);
		$criteria->compare('nopembayaran',$this->nopembayaran,true);
		$criteria->compare('tandabuktibayar_id',$this->tandabuktibayar_id);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('penjamin_nama',$this->penjamin_nama,true);
		$criteria->compare('tglbuktibayar',$this->tglbuktibayar,true);
		$criteria->compare('jnspembayar_nama',$this->jnspembayar_nama,true);
		$criteria->compare('namabankpembayaran',$this->namabankpembayaran,true);
		$criteria->compare('nokartu',$this->nokartu,true);
		$criteria->compare('nilai',$this->nilai);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CetakclosingkasirV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
