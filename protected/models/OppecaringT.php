<?php

/**
 * This is the model class for table "oppecaring_t".
 * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @package application.models
 * The followings are the available columns in table 'oppecaring_t':
 * @property integer $oppecaring_id
 * @property integer $indikatoroppekeperawatan_id
 * @property integer $pegawai_id
 * @property integer $ka_unitkerja_id
 * @property integer $unitkerja_id
 * @property string $bulan_caring
 * @property string $nama_perawat
 * @property string $nip_perawat
 * @property integer $perawat_unitkerja_id
 * @property string $tgl_kuisioner
 * @property double $nilai_pasien
 * @property double $nilai_keluarga
 * @property double $nilai_rata
 * @property integer $create_loginpemakai_id
 * @property string $create_time
 * @property integer $update_loginpemakai_id
 * @property string $update_time
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property IndikatoroppekeperawatanM $indikatoroppekeperawatan
 * @property PegawaiM $pegawai
 */
class OppecaringT extends CActiveRecord
{
        public $namaunitkerja, $return;
        public $capaian;
        public $jumlah;
        public $nama_indikator;
        public $standar_nilai;
        public $golongan_indikator;
        public $rekomendasi;        
        public $indikatoroppekeperawatan_nama;
        public $smf_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OppecaringT the static model class
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
		return 'oppecaring_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ka_unitkerja_id, unitkerja_id, bulan_caring, nama_perawat, nip_perawat, perawat_unitkerja_id, tgl_kuisioner, nilai_pasien, nilai_keluarga, nilai_rata, create_loginpemakai_id, create_time, create_ruangan', 'required'),
			array('indikatoroppekeperawatan_id, pegawai_id, ka_unitkerja_id, unitkerja_id, perawat_unitkerja_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('nilai_pasien, nilai_keluarga, nilai_rata', 'numerical'),
			array('nama_perawat, nip_perawat', 'length', 'max'=>255),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('oppecaring_id, indikatoroppekeperawatan_id, pegawai_id, ka_unitkerja_id, unitkerja_id, bulan_caring, nama_perawat, nip_perawat, perawat_unitkerja_id, tgl_kuisioner, nilai_pasien, nilai_keluarga, nilai_rata, create_loginpemakai_id, create_time, update_loginpemakai_id, update_time, create_ruangan', 'safe', 'on'=>'search'),
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
			'indikatoroppekeperawatan' => array(self::BELONGS_TO, 'IndikatoroppekeperawatanM', 'indikatoroppekeperawatan_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'unitkerja' => array(self::BELONGS_TO, 'UnitkerjaM', 'perawat_unitkerja_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'oppecaring_id' => 'Oppecaring',
			'indikatoroppekeperawatan_id' => 'Nama Indikator',
			'pegawai_id' => 'Nama Perawat',
			'ka_unitkerja_id' => 'Kepala Unit Kerja',
			'unitkerja_id' => 'Unit Kerja',
			'bulan_caring' => 'Bulan Caring',
			'nama_perawat' => 'Nama Perawat',
			'nip_perawat' => 'NIP Perawat',
			'perawat_unitkerja_id' => 'Unit Kerja',
			'tgl_kuisioner' => 'Tgl. Kuisioner',
			'nilai_pasien' => 'Nilai Pasien',
			'nilai_keluarga' => 'Nilai Keluarga',
			'nilai_rata' => 'Nilai Rata-rata',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'create_time' => 'Waktu Create',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'update_time' => 'Waktu Update',
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

		$criteria->compare('oppecaring_id',$this->oppecaring_id);
		$criteria->compare('indikatoroppekeperawatan_id',$this->indikatoroppekeperawatan_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('ka_unitkerja_id',$this->ka_unitkerja_id);
		$criteria->compare('unitkerja_id',$this->unitkerja_id);
//                if(!empty($this->bulan_caring)){
                    $criteria->addBetweenCondition('DATE(bulan_caring)', $this->bulan_pilih_awal, $this->bulan_pilih_akhir);
//                }
		$criteria->compare('nama_perawat',$this->nama_perawat,true);
		$criteria->compare('nip_perawat',$this->nip_perawat,true);
		$criteria->compare('perawat_unitkerja_id',$this->perawat_unitkerja_id);
		$criteria->compare('tgl_kuisioner',$this->tgl_kuisioner,true);
		$criteria->compare('nilai_pasien',$this->nilai_pasien);
		$criteria->compare('nilai_keluarga',$this->nilai_keluarga);
		$criteria->compare('nilai_rata',$this->nilai_rata);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}