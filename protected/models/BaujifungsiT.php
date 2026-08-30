<?php

/**
 * This is the model class for table "baujifungsi_t".
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author  Yusuf Putra Anugrah <yusufputra@.com>
 * @package application.models
 * @category model
 * The followings are the available columns in table 'baujifungsi_t':
 * @property integer $baujifungsi_id
 * @property integer $suratperjanjiankerja_id
 * @property string $baujifungsi_nomor
 * @property string $baujifungsi_tanggal
 * @property string $nomor_beritaacara
 * @property integer $pegawai_id
 * @property string $pegawai_jabatan
 * @property string $pegawai_unitkerja
 * @property string $hasil_uji
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property BaujifungsidetT[] $baujifungsidetTs
 * @property PegawaiM $pegawai
 * @property SuratperjanjiankerjaT $suratperjanjiankerja
 */
class BaujifungsiT extends CActiveRecord
{
        public $pegawai_nama, $nomorindukpegawai, $pegawai_ketua, $dasar;
        public $jumlah_termin, $temp_file;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaujifungsiT the static model class
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
		return 'baujifungsi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nomor_beritaacara,suratperjanjiankerja_id, baujifungsi_nomor, baujifungsi_tanggal, pegawai_jabatan, pegawai_unitkerja, hasil_uji, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('suratperjanjiankerja_id, pegawai_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('baujifungsi_nomor, nomor_beritaacara, hasil_uji', 'length', 'max'=>50),
			array('pegawai_jabatan', 'length', 'max'=>100),
			array('pegawai_unitkerja', 'length', 'max'=>300),
			array('dokumen_pendukung, update_time, terminke, termin_persen', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('baujifungsi_id, suratperjanjiankerja_id, baujifungsi_nomor, baujifungsi_tanggal, nomor_beritaacara, pegawai_id, pegawai_jabatan, pegawai_unitkerja, hasil_uji, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'baujifungsidetTs' => array(self::HAS_MANY, 'BaujifungsidetT', 'baujifungsi_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'suratperjanjiankerja' => array(self::BELONGS_TO, 'SuratperjanjiankerjaT', 'suratperjanjiankerja_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'baujifungsi_id' => 'Baujifungsi',
			'suratperjanjiankerja_id' => 'Suratperjanjiankerja',
			'baujifungsi_nomor' => 'Nomor Transaksi',
			'baujifungsi_tanggal' => 'Tanggal Pembuatan BA',
			'nomor_beritaacara' => 'Nomor BA',
			'pegawai_id' => 'Pegawai',
			'pegawai_jabatan' => 'Pegawai Jabatan',
			'pegawai_unitkerja' => 'Pegawai Unitkerja',
			'hasil_uji' => 'Hasil Uji',
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

		$criteria->compare('baujifungsi_id',$this->baujifungsi_id);
		$criteria->compare('suratperjanjiankerja_id',$this->suratperjanjiankerja_id);
		$criteria->compare('baujifungsi_nomor',$this->baujifungsi_nomor,true);
		$criteria->compare('baujifungsi_tanggal',$this->baujifungsi_tanggal,true);
		$criteria->compare('nomor_beritaacara',$this->nomor_beritaacara,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('pegawai_jabatan',$this->pegawai_jabatan,true);
		$criteria->compare('pegawai_unitkerja',$this->pegawai_unitkerja,true);
		$criteria->compare('hasil_uji',$this->hasil_uji,true);
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