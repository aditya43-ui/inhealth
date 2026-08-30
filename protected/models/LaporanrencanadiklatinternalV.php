<?php

/**
 * This is the model class for table "laporanrencanadiklatinternal_v".
 *
 * The followings are the available columns in table 'laporanrencanadiklatinternal_v':
 * @property integer $rencanadiklat_id
 * @property string $norencanadiklat
 * @property string $tglrencanadiklat
 * @property string $namadiklat
 * @property string $rencanadiklat_periode
 * @property string $rencanadiklat_sampaidgn
 * @property string $jam_mulai
 * @property string $jam_akhir
 * @property string $tempat_diklat
 * @property string $alamat_diklat
 * @property double $total_jam
 * @property double $total_menit
 * @property string $keterangan_diklat
 * @property string $status_rencana
 * @property double $internal_biayapemateri
 * @property double $internal_biayakonsumsi
 * @property double $internal_biayaalatperaga
 * @property double $internal_biayalainlain
 * @property double $total_biaya
 */
class LaporanrencanadiklatinternalV extends CActiveRecord
{
	public $jenisdiklat_id;
	public $tgl_awal;
	public $tgl_akhir;
	public $jns_periode;
	public $bln_awal;
	public $bln_akhir;
	public $thn_awal;
	public $thn_akhir;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanrencanadiklatinternalV the static model class
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
		return 'laporanrencanadiklatinternal_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rencanadiklat_id', 'numerical', 'integerOnly'=>true),
			array('total_jam, total_menit, internal_biayapemateri, internal_biayakonsumsi, internal_biayaalatperaga, internal_biayalainlain, total_biaya', 'numerical'),
			array('norencanadiklat', 'length', 'max'=>50),
			array('namadiklat, tempat_diklat, status_rencana', 'length', 'max'=>100),
			array('alamat_diklat, keterangan_diklat', 'length', 'max'=>500),
			array('tglrencanadiklat, rencanadiklat_periode, rencanadiklat_sampaidgn, jam_mulai, jam_akhir', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rencanadiklat_id, norencanadiklat, tglrencanadiklat, namadiklat, rencanadiklat_periode, rencanadiklat_sampaidgn, jam_mulai, jam_akhir, tempat_diklat, alamat_diklat, total_jam, total_menit, keterangan_diklat, status_rencana, internal_biayapemateri, internal_biayakonsumsi, internal_biayaalatperaga, internal_biayalainlain, total_biaya', 'safe', 'on'=>'search'),
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
			'rencanadiklat_id' => 'Rencanadiklat',
			'norencanadiklat' => 'Norencanadiklat',
			'tglrencanadiklat' => 'Tglrencanadiklat',
			'namadiklat' => 'Namadiklat',
			'rencanadiklat_periode' => 'Rencanadiklat Periode',
			'rencanadiklat_sampaidgn' => 'Rencanadiklat Sampaidgn',
			'jam_mulai' => 'Jam Mulai',
			'jam_akhir' => 'Jam Akhir',
			'tempat_diklat' => 'Tempat Diklat',
			'alamat_diklat' => 'Alamat Diklat',
			'total_jam' => 'Total Jam',
			'total_menit' => 'Total Menit',
			'keterangan_diklat' => 'Keterangan Diklat',
			'status_rencana' => 'Status Rencana',
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

		$criteria->compare('rencanadiklat_id',$this->rencanadiklat_id);
		$criteria->compare('norencanadiklat',$this->norencanadiklat,true);
		$criteria->compare('tglrencanadiklat',$this->tglrencanadiklat,true);
		$criteria->compare('namadiklat',$this->namadiklat,true);
		$criteria->compare('rencanadiklat_periode',$this->rencanadiklat_periode,true);
		$criteria->compare('rencanadiklat_sampaidgn',$this->rencanadiklat_sampaidgn,true);
		$criteria->compare('jam_mulai',$this->jam_mulai,true);
		$criteria->compare('jam_akhir',$this->jam_akhir,true);
		$criteria->compare('tempat_diklat',$this->tempat_diklat,true);
		$criteria->compare('alamat_diklat',$this->alamat_diklat,true);
		$criteria->compare('total_jam',$this->total_jam);
		$criteria->compare('total_menit',$this->total_menit);
		$criteria->compare('keterangan_diklat',$this->keterangan_diklat,true);
		$criteria->compare('status_rencana',$this->status_rencana,true);
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