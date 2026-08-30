<?php

/**
 * This is the model class for table "laporanrealisasidiklatinternal_v".
 *
 * The followings are the available columns in table 'laporanrealisasidiklatinternal_v':
 * @property integer $realisasidiklat_id
 * @property string $norealisasi
 * @property string $tglrealisasi
 * @property string $namapelatihan
 * @property string $realisasi_tglawal
 * @property string $realisasi_tglakhir
 * @property string $jam_mulai
 * @property string $jam_akhir
 * @property string $tempat
 * @property string $alamat
 * @property double $total_jam
 * @property double $total_menit
 * @property string $keterangan_diklat
 * @property double $internal_biayapemateri
 * @property double $internal_biayakonsumsi
 * @property double $internal_biayaalatperaga
 * @property double $internal_biayalainlain
 * @property double $total_biaya
 */
class LaporanrealisasidiklatinternalV extends CActiveRecord
{
	public $tgl_awal;
	public $tgl_akhir;
	public $bln_awal;
	public $bln_akhir;
	public $thn_awal;
	public $thn_akhir;
	public $jns_periode;
	public $data;
	public $tick;
	public $jumlah;
	public $pemateri;
	public $jenisdiklat_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanrealisasidiklatinternalV the static model class
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
		return 'laporanrealisasidiklatinternal_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('realisasidiklat_id', 'numerical', 'integerOnly'=>true),
			array('total_jam, total_menit, internal_biayapemateri, internal_biayakonsumsi, internal_biayaalatperaga, internal_biayalainlain, total_biaya', 'numerical'),
			array('norealisasi', 'length', 'max'=>50),
			array('namapelatihan, tempat', 'length', 'max'=>100),
			array('keterangan_diklat', 'length', 'max'=>500),
			array('tglrealisasi, realisasi_tglawal, realisasi_tglakhir, jam_mulai, jam_akhir, alamat', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('realisasidiklat_id, norealisasi, tglrealisasi, namapelatihan, realisasi_tglawal, realisasi_tglakhir, jam_mulai, jam_akhir, tempat, alamat, total_jam, total_menit, keterangan_diklat, internal_biayapemateri, internal_biayakonsumsi, internal_biayaalatperaga, internal_biayalainlain, total_biaya', 'safe', 'on'=>'search'),
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
			'realisasidiklat_id' => 'Realisasidiklat',
			'norealisasi' => 'Norealisasi',
			'tglrealisasi' => 'Tglrealisasi',
			'namapelatihan' => 'Namapelatihan',
			'realisasi_tglawal' => 'Realisasi Tglawal',
			'realisasi_tglakhir' => 'Realisasi Tglakhir',
			'jam_mulai' => 'Jam Mulai',
			'jam_akhir' => 'Jam Akhir',
			'tempat' => 'Tempat',
			'alamat' => 'Alamat',
			'total_jam' => 'Total Jam',
			'total_menit' => 'Total Menit',
			'keterangan_diklat' => 'Keterangan Diklat',
			'internal_biayapemateri' => 'Internal Biayapemateri',
			'internal_biayakonsumsi' => 'Internal Biayakonsumsi',
			'internal_biayaalatperaga' => 'Internal Biayaalatperaga',
			'internal_biayalainlain' => 'Internal Biayalainlain',
			'total_biaya' => 'Total Biaya',
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

		$criteria->compare('realisasidiklat_id',$this->realisasidiklat_id);
		$criteria->compare('norealisasi',$this->norealisasi,true);
		$criteria->compare('tglrealisasi',$this->tglrealisasi,true);
		$criteria->compare('namapelatihan',$this->namapelatihan,true);
		$criteria->compare('realisasi_tglawal',$this->realisasi_tglawal,true);
		$criteria->compare('realisasi_tglakhir',$this->realisasi_tglakhir,true);
		$criteria->compare('jam_mulai',$this->jam_mulai,true);
		$criteria->compare('jam_akhir',$this->jam_akhir,true);
		$criteria->compare('tempat',$this->tempat,true);
		$criteria->compare('alamat',$this->alamat,true);
		$criteria->compare('total_jam',$this->total_jam);
		$criteria->compare('total_menit',$this->total_menit);
		$criteria->compare('keterangan_diklat',$this->keterangan_diklat,true);
		$criteria->compare('internal_biayapemateri',$this->internal_biayapemateri);
		$criteria->compare('internal_biayakonsumsi',$this->internal_biayakonsumsi);
		$criteria->compare('internal_biayaalatperaga',$this->internal_biayaalatperaga);
		$criteria->compare('internal_biayalainlain',$this->internal_biayalainlain);
		$criteria->compare('total_biaya',$this->total_biaya);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
		
}