<?php

/**
 * This is the model class for table "informasiusulanpenghapusanaset_v".
 *
 * The followings are the available columns in table 'informasiusulanpenghapusanaset_v':
 * @property integer $usulanpenghapusanaset_id
 * @property string $usulanpenghapusanaset_nomor
 * @property string $usulanpenghapusanaset_tanggal
 * @property integer $pegpengusul_id
 * @property integer $lokasi_id
 * @property string $lokasi_aset
 * @property integer $pegverifikasi_id
 * @property string $tanggal_verifikasi
 * @property integer $lokasisementara_id
 * @property string $lokasi_sementara
 * @property integer $pengeluaranaset_id
 * @property string $verifikasi
 * @property string $penghapusanaset
 */
class InformasiusulanpenghapusanasetV extends CActiveRecord
{
        public $pegpengusul_nama;
        public $ada_pj_aset;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasiusulanpenghapusanasetV the static model class
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
		return 'informasiusulanpenghapusanaset_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('usulanpenghapusanaset_id, pegpengusul_id, lokasi_id, pegverifikasi_id, lokasisementara_id, pengeluaranaset_id', 'numerical', 'integerOnly'=>true),
			array('usulanpenghapusanaset_nomor', 'length', 'max'=>20),
			array('lokasi_aset, lokasi_sementara', 'length', 'max'=>100),
			array('usulanpenghapusanaset_tanggal, tanggal_verifikasi, verifikasi, penghapusanaset', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('usulanpenghapusanaset_id, usulanpenghapusanaset_nomor, usulanpenghapusanaset_tanggal, pegpengusul_id, lokasi_id, lokasi_aset, pegverifikasi_id, tanggal_verifikasi, lokasisementara_id, lokasi_sementara, pengeluaranaset_id, verifikasi, penghapusanaset', 'safe', 'on'=>'search'),
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
                    'usulanpenghapusanaset_id' => 'Usulanpenghapusanaset',
                    'usulanpenghapusanaset_nomor' => 'Nomor Usulan',
                    'usulanpenghapusanaset_tanggal' => 'Usulanpenghapusanaset Tanggal',
                    'pegpengusul_id' => 'Pegpengusul',
                    'lokasi_id' => 'Lokasi',
                    'lokasi_aset' => 'Lokasi Aset',
                    'pegverifikasi_id' => 'Pegverifikasi',
                    'tanggal_verifikasi' => 'Tanggal Verifikasi',
                    'lokasisementara_id' => 'Lokasisementara',
                    'lokasi_sementara' => 'Lokasi Sementara',
                    'pengeluaranaset_id' => 'Pengeluaranaset',
                    'verifikasi' => 'Verifikasi',
                    'penghapusanaset' => 'Penghapusanaset',
                    'pegpengusul_nama' => 'Pegawai Mengusulkan'
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

		$criteria->compare('usulanpenghapusanaset_id',$this->usulanpenghapusanaset_id);
		$criteria->compare('usulanpenghapusanaset_nomor',$this->usulanpenghapusanaset_nomor,true);
		$criteria->compare('usulanpenghapusanaset_tanggal',$this->usulanpenghapusanaset_tanggal,true);
		$criteria->compare('pegpengusul_id',$this->pegpengusul_id);
		$criteria->compare('lokasi_id',$this->lokasi_id);
		$criteria->compare('lokasi_aset',$this->lokasi_aset,true);
		$criteria->compare('pegverifikasi_id',$this->pegverifikasi_id);
		$criteria->compare('tanggal_verifikasi',$this->tanggal_verifikasi,true);
		$criteria->compare('lokasisementara_id',$this->lokasisementara_id);
		$criteria->compare('lokasi_sementara',$this->lokasi_sementara,true);
		$criteria->compare('pengeluaranaset_id',$this->pengeluaranaset_id);
		$criteria->compare('verifikasi',$this->verifikasi,true);
		$criteria->compare('penghapusanaset',$this->penghapusanaset,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}