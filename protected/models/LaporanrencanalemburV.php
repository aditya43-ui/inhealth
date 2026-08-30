<?php

/**
 * This is the model class for table "laporanrencanalembur_v".
 *
 * The followings are the available columns in table 'laporanrencanalembur_v':
 * @property integer $rencanalembur_id
 * @property string $tglrencana
 * @property string $norencana
 * @property string $create_ruangan
 * @property string $create_ruangan_nama
 * @property string $nama_pegawai
 * @property integer $rencanalemburdet_id
 * @property string $nourut
 * @property string $alasanlembur
 * @property string $tglmulai
 * @property string $tglselesai
 * @property integer $pemberitugas_id
 * @property string $gelardepan_pegawaitugas
 * @property string $nama_pegawaitugas
 * @property string $gelarbelakang_pegawaitugas
 * @property integer $mengetahui_id
 * @property string $gelardepan_mengetahui
 * @property string $nama_mengetahui
 * @property string $gelarbelakang_mengetahui
 * @property integer $menyetujui_id
 * @property string $gelardepan_menyetujui
 * @property string $nama_menyetujui
 * @property string $gelarbelakang_menyetujui
 */
class LaporanrencanalemburV extends CActiveRecord
{
	public $tgl_awal;
	public $tgl_akhir;
	public $thn_awal;
	public $thn_akhir;
	public $bln_awal;
	public $bln_akhir;
	public $jns_periode;
	public $jumlah;
	public $data;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanrencanalemburV the static model class
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
		return 'laporanrencanalembur_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rencanalembur_id, rencanalemburdet_id, pemberitugas_id, mengetahui_id, menyetujui_id', 'numerical', 'integerOnly'=>true),
			array('norencana', 'length', 'max'=>20),
			array('create_ruangan_nama, nama_pegawai, nama_pegawaitugas, nama_mengetahui, nama_menyetujui', 'length', 'max'=>50),
			array('nourut', 'length', 'max'=>3),
			array('alasanlembur', 'length', 'max'=>500),
			array('gelardepan_pegawaitugas, gelardepan_mengetahui, gelardepan_menyetujui', 'length', 'max'=>10),
			array('gelarbelakang_pegawaitugas, gelarbelakang_mengetahui, gelarbelakang_menyetujui', 'length', 'max'=>15),
			array('tglrencana, create_ruangan, tglmulai, tglselesai', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rencanalembur_id, tglrencana, norencana, create_ruangan, create_ruangan_nama, nama_pegawai, rencanalemburdet_id, nourut, alasanlembur, tglmulai, tglselesai, pemberitugas_id, gelardepan_pegawaitugas, nama_pegawaitugas, gelarbelakang_pegawaitugas, mengetahui_id, gelardepan_mengetahui, nama_mengetahui, gelarbelakang_mengetahui, menyetujui_id, gelardepan_menyetujui, nama_menyetujui, gelarbelakang_menyetujui', 'safe', 'on'=>'search'),
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
			'rencanalembur_id' => 'Rencanalembur',
			'tglrencana' => 'Tglrencana',
			'norencana' => 'Norencana',
			'create_ruangan' => 'Create Ruangan',
			'create_ruangan_nama' => 'Create Ruangan Nama',
			'nama_pegawai' => 'Nama Pegawai',
			'rencanalemburdet_id' => 'Rencanalemburdet',
			'nourut' => 'Nourut',
			'alasanlembur' => 'Alasanlembur',
			'tglmulai' => 'Tglmulai',
			'tglselesai' => 'Tglselesai',
			'pemberitugas_id' => 'Pemberitugas',
			'gelardepan_pegawaitugas' => 'Gelardepan Pegawaitugas',
			'nama_pegawaitugas' => 'Nama Pegawaitugas',
			'gelarbelakang_pegawaitugas' => 'Gelarbelakang Pegawaitugas',
			'mengetahui_id' => 'Mengetahui',
			'gelardepan_mengetahui' => 'Gelardepan Mengetahui',
			'nama_mengetahui' => 'Nama Mengetahui',
			'gelarbelakang_mengetahui' => 'Gelarbelakang Mengetahui',
			'menyetujui_id' => 'Menyetujui',
			'gelardepan_menyetujui' => 'Gelardepan Menyetujui',
			'nama_menyetujui' => 'Nama Menyetujui',
			'gelarbelakang_menyetujui' => 'Gelarbelakang Menyetujui',
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

		$criteria->compare('rencanalembur_id',$this->rencanalembur_id);
		$criteria->compare('tglrencana',$this->tglrencana,true);
		$criteria->compare('norencana',$this->norencana,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('create_ruangan_nama',$this->create_ruangan_nama,true);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('rencanalemburdet_id',$this->rencanalemburdet_id);
		$criteria->compare('nourut',$this->nourut,true);
		$criteria->compare('alasanlembur',$this->alasanlembur,true);
		$criteria->compare('tglmulai',$this->tglmulai,true);
		$criteria->compare('tglselesai',$this->tglselesai,true);
		$criteria->compare('pemberitugas_id',$this->pemberitugas_id);
		$criteria->compare('gelardepan_pegawaitugas',$this->gelardepan_pegawaitugas,true);
		$criteria->compare('nama_pegawaitugas',$this->nama_pegawaitugas,true);
		$criteria->compare('gelarbelakang_pegawaitugas',$this->gelarbelakang_pegawaitugas,true);
		$criteria->compare('mengetahui_id',$this->mengetahui_id);
		$criteria->compare('gelardepan_mengetahui',$this->gelardepan_mengetahui,true);
		$criteria->compare('nama_mengetahui',$this->nama_mengetahui,true);
		$criteria->compare('gelarbelakang_mengetahui',$this->gelarbelakang_mengetahui,true);
		$criteria->compare('menyetujui_id',$this->menyetujui_id);
		$criteria->compare('gelardepan_menyetujui',$this->gelardepan_menyetujui,true);
		$criteria->compare('nama_menyetujui',$this->nama_menyetujui,true);
		$criteria->compare('gelarbelakang_menyetujui',$this->gelarbelakang_menyetujui,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getNamaLengkapPemberi(){
		return $this->gelardepan_pegawaitugas.' '.$this->nama_pegawaitugas.' '.$this->gelarbelakang_pegawaitugas;
	}
}