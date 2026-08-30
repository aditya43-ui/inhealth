<?php

/**
 * This is the model class for table "paketpelayanan_m".
 *
 * The followings are the available columns in table 'paketpelayanan_m':
 * @property integer $paketpelayanan_id
 * @property integer $daftartindakan_id
 * @property integer $tipepaket_id
 * @property integer $ruangan_id
 */
class PaketpelayananM extends CActiveRecord
{
	public $ruanganNama;
	public $daftartindakanNama;
	public $tipepaketNama;
	public $carabayar_nama;
	public $penjamin_nama;
	public $jenistarif_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PaketpelayananM the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'paketpelayanan_m';
	}
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('daftartindakan_id, tipepaket_id', 'required'),
			array('daftartindakan_id, tipepaket_id, ruangan_id, carabayar_id, penjamin_id, jenistarif_id', 'numerical', 'integerOnly' => true),
			array('tarifpaketpel, subsidiasuransi, subsidirumahsakit, subsidipemerintah, iurbiaya', 'numerical'),
			array('iurbiaya', 'safe'),
			array('tarifpaketpel', 'cekTarif'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ruanganNama, daftartindakanNama, tipepaketNama, paketpelayanan_id, daftartindakan_id, tipepaket_id, ruangan_id, namatindakan, carabayar_id, penjamin_id, jenistarif_id', 'safe', 'on' => 'search'),
		);
	}
	public function cekTarif($object, $attribute)
	{
		if (!$this->hasErrors()) {
			$result = $this->subsidiasuransi + $this->subsidirumahsakit + $this->subsidipemerintah + $this->iurbiaya;
			if ($this->tarifpaketpel != $result) {
				$this->addError('subsidiasuransi', 'Total subsidi Harus sama dengan Tarif Paket Pelayanan');
				$this->addError('subsidirumahsakit', '');
				$this->addError('subsidipemerintah', '');
				$this->addError('iurbiaya', '');
			}
		}
	}
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'daftartindakan' => array(self::BELONGS_TO, 'DaftartindakanM', 'daftartindakan_id'),
			'tipepaket' => array(self::BELONGS_TO, 'TipepaketM', 'tipepaket_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
		);
	}
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'paketpelayanan_id' => 'ID',
			'daftartindakan_id' => 'Daftar Tindakan',
			'tipepaket_id' => 'Tipe Paket',
			'ruangan_id' => 'Ruangan',
			'namatindakan' => 'Uraian Tindakan',
			//                        'tarifpaketpel'=>'Tarif Paket Pelayanan',
			'subsidiasuransi' => 'Tanggungan Asuransi',
			'subsidirumahsakit' => 'Tanggungan Rumah Sakit',
			'subsidipemerintah' => 'Tanggungan Pemerintah',
			'iurbiaya' => 'Iuran Biaya',
			'tarifpaketpel' => 'Tarif Paket',
			'tipepaketNama' => 'Tipe Paket',
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
		$criteria = new CDbCriteria;
		$criteria->compare('paketpelayanan_id', $this->paketpelayanan_id);
		$criteria->compare('daftartindakan_id', $this->daftartindakan_id);
		$criteria->compare('tipepaket_id', $this->tipepaket_id);
		$criteria->compare('ruangan_id', $this->ruangan_id);
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria = new CDbCriteria;
		$criteria->compare('paketpelayanan_id', $this->paketpelayanan_id);
		$criteria->compare('daftartindakan_id', $this->daftartindakan_id);
		$criteria->compare('tipepaket_id', $this->tipepaket_id);
		$criteria->compare('ruangan_id', $this->ruangan_id);
		// Klo limit lebih kecil dari nol itu berarti ga ada limit 
		$criteria->limit = -1;
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => false,
		));
	}
}
