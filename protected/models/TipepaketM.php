<?php

/**
 * This is the model class for table "tipepaket_m".
 *
 * The followings are the available columns in table 'tipepaket_m':
 * @property integer $tipepaket_id
 * @property integer $kelaspelayanan_id
 * @property integer $penjamin_id
 * @property integer $carabayar_id
 * @property string $tipepaket_nama
 * @property string $tipepaket_singkatan
 * @property string $tipepaket_namalainnya
 * @property string $tglkesepakatantarif
 * @property string $nokesepakatantarif
 * @property double $tarifpaket
 * @property double $paketsubsidiasuransi
 * @property double $paketsubsidipemerintah
 * @property double $paketsubsidirs
 * @property double $paketiurbiaya
 * @property integer $nourut_tipepaket
 * @property string $keterangan_tipepaket
 * @property boolean $tipepaket_aktif
 */
class TipepaketM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TipepaketM the static model class
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
		return 'tipepaket_m';
	}
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kelaspelayanan_id, penjamin_id, carabayar_id, tipepaket_nama, tipepaket_singkatan, tarifpaket, paketsubsidiasuransi, paketsubsidipemerintah, paketsubsidirs, paketiurbiaya', 'required'),
			array('kelaspelayanan_id, penjamin_id, carabayar_id, nourut_tipepaket, jenistarif_id', 'numerical', 'integerOnly' => true),
			array('tarifpaket, paketsubsidiasuransi, paketsubsidipemerintah, paketsubsidirs, paketiurbiaya', 'numerical'),
			array('tipepaket_nama, tipepaket_namalainnya, nokesepakatantarif', 'length', 'max'=>50),
			array('tipepaket_singkatan', 'length', 'max'=>20),
			array('tglkesepakatantarif, keterangan_tipepaket, tipepaket_aktif, isnonpaket', 'safe'),
			array('is_paketmedis,is_rad,is_mikro,is_pk,is_pa,is_darah,jeniskomponendarah_id,', 'safe'),
                        //array('tarifpaket','cekTarif'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tipepaket_id, kelaspelayanan_id, penjamin_id, carabayar_id, tipepaket_nama, tipepaket_singkatan, tipepaket_namalainnya, tglkesepakatantarif, nokesepakatantarif, tarifpaket, paketsubsidiasuransi, paketsubsidipemerintah, paketsubsidirs, paketiurbiaya, nourut_tipepaket, keterangan_tipepaket, tipepaket_aktif, jenistarif_id, isnonpaket', 'safe', 'on'=>'search'),
		);
	}
	public function cekTarif($attribute, $params)
	{
		if (!$this->hasErrors()) {
			if ($this->tarifpaket < 1) {
				$this->addError('tarifpaket', $this->getAttributeLabel('tarifpaket') . ' harus lebih dari 0');
			}
			if ($this->tarifpaket != $this->paketsubsidiasuransi + $this->paketsubsidipemerintah + $this->paketsubsidirs + $this->paketiurbiaya) {
				$this->addError('paketsubsidiasuransi', 'Jumlah keseluruhan paket harus sama dengan ' . $this->getAttributeLabel('tarifpaket'));
				$this->addError('paketsubsidipemerintah', '');
				$this->addError('paketsubsidirs', '');
				$this->addError('paketiurbiaya', '');
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
			'carabayar' => array(self::BELONGS_TO, 'CarabayarM', 'carabayar_id'),
			'penjamin' => array(self::BELONGS_TO, 'PenjaminpasienM', 'penjamin_id'),
			'kelaspelayanan' => array(self::BELONGS_TO, 'KelaspelayananM', 'kelaspelayanan_id'),
			'jenistarif' => array(self::BELONGS_TO, 'JenistarifM', 'jenistarif_id'),
		);
	}
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tipepaket_id' => 'ID',
			'kelaspelayanan_id' => 'Kelas Pelayanan',
			'penjamin_id' => 'Penjamin',
			'carabayar_id' => 'Jenis Penjamin',
			'tipepaket_nama' => 'Nama',
			'tipepaket_singkatan' => 'Singkatan',
			'tipepaket_namalainnya' => 'Nama Lainnya',
			'tglkesepakatantarif' => 'Tanggal Kesepakatan Tarif',
			'nokesepakatantarif' => 'No. Kesepakatan Tarif',
			'tarifpaket' => 'Tarif Paket',
			'paketsubsidiasuransi' => 'Paket Tanggungan Asuransi',
			'paketsubsidipemerintah' => 'Paket Tanggungan Pemerintah',
			'paketsubsidirs' => 'Paket Tanggungan Rumah Sakit',
			'paketiurbiaya' => 'Paket Iur Biaya',
			'nourut_tipepaket' => 'No. Urut Tipe Paket',
			'keterangan_tipepaket' => 'Keterangan',
			'tipepaket_aktif' => 'Aktif',
			'is_paketmedis' => 'Paket Medis',
			'is_rad' => 'Radiologi',
			'is_mikro' => 'Mikrobiologi',
			'is_pk' => 'Potologi Klinik',
			'is_pa' => 'Patologi Anatomi',
			'is_darah' => 'Bank Darah',
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
		$criteria->with = array('carabayar');
		$criteria->compare('tipepaket_id', $this->tipepaket_id);
		$criteria->compare('kelaspelayanan_id', $this->kelaspelayanan_id);
		$criteria->compare('penjamin_id', $this->penjamin_id);
		$criteria->compare('carabayar_id', $this->carabayar_id);
		$criteria->compare('LOWER(tipepaket_nama)', strtolower($this->tipepaket_nama), true);
		$criteria->compare('LOWER(tipepaket_singkatan)', strtolower($this->tipepaket_singkatan), true);
		$criteria->compare('LOWER(tipepaket_namalainnya)', strtolower($this->tipepaket_namalainnya), true);
		$criteria->compare('LOWER(tglkesepakatantarif)', strtolower($this->tglkesepakatantarif), true);
		$criteria->compare('LOWER(nokesepakatantarif)', strtolower($this->nokesepakatantarif), true);
		$criteria->compare('tarifpaket', $this->tarifpaket);
		$criteria->compare('paketsubsidiasuransi', $this->paketsubsidiasuransi);
		$criteria->compare('paketsubsidipemerintah', $this->paketsubsidipemerintah);
		$criteria->compare('paketsubsidirs', $this->paketsubsidirs);
		$criteria->compare('paketiurbiaya', $this->paketiurbiaya);
		$criteria->compare('nourut_tipepaket', $this->nourut_tipepaket);
		$criteria->compare('LOWER(keterangan_tipepaket)', strtolower($this->keterangan_tipepaket), true);
		$criteria->compare('tipepaket_aktif', isset($this->tipepaket_aktif) ? $this->tipepaket_aktif : true);
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
	public function searchBD()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria = new CDbCriteria;
		$criteria->with = array('carabayar');
		$criteria->addInCondition('tipepaket_id', [316,321, 323, 324, 325, 326]);
		$criteria->compare('kelaspelayanan_id', $this->kelaspelayanan_id);
		$criteria->compare('penjamin_id', $this->penjamin_id);
		$criteria->compare('carabayar_id', $this->carabayar_id);
		$criteria->compare('LOWER(tipepaket_nama)', strtolower($this->tipepaket_nama), true);
		$criteria->compare('LOWER(tipepaket_singkatan)', strtolower($this->tipepaket_singkatan), true);
		$criteria->compare('LOWER(tipepaket_namalainnya)', strtolower($this->tipepaket_namalainnya), true);
		$criteria->compare('LOWER(tglkesepakatantarif)', strtolower($this->tglkesepakatantarif), true);
		$criteria->compare('LOWER(nokesepakatantarif)', strtolower($this->nokesepakatantarif), true);
		$criteria->compare('tarifpaket', $this->tarifpaket);
		$criteria->compare('paketsubsidiasuransi', $this->paketsubsidiasuransi);
		$criteria->compare('paketsubsidipemerintah', $this->paketsubsidipemerintah);
		$criteria->compare('paketsubsidirs', $this->paketsubsidirs);
		$criteria->compare('paketiurbiaya', $this->paketiurbiaya);
		$criteria->compare('nourut_tipepaket', $this->nourut_tipepaket);
		$criteria->compare('LOWER(keterangan_tipepaket)', strtolower($this->keterangan_tipepaket), true);
		$criteria->compare('tipepaket_aktif', isset($this->tipepaket_aktif) ? $this->tipepaket_aktif : true);
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria = new CDbCriteria;
		$criteria->compare('tipepaket_id', $this->tipepaket_id);
		$criteria->compare('kelaspelayanan_id', $this->kelaspelayanan_id);
		$criteria->compare('penjamin_id', $this->penjamin_id);
		$criteria->compare('carabayar_id', $this->carabayar_id);
		$criteria->compare('LOWER(tipepaket_nama)', strtolower($this->tipepaket_nama), true);
		$criteria->compare('LOWER(tipepaket_singkatan)', strtolower($this->tipepaket_singkatan), true);
		$criteria->compare('LOWER(tipepaket_namalainnya)', strtolower($this->tipepaket_namalainnya), true);
		$criteria->compare('LOWER(tglkesepakatantarif)', strtolower($this->tglkesepakatantarif), true);
		$criteria->compare('LOWER(nokesepakatantarif)', strtolower($this->nokesepakatantarif), true);
		$criteria->compare('tarifpaket', $this->tarifpaket);
		$criteria->compare('paketsubsidiasuransi', $this->paketsubsidiasuransi);
		$criteria->compare('paketsubsidipemerintah', $this->paketsubsidipemerintah);
		$criteria->compare('paketsubsidirs', $this->paketsubsidirs);
		$criteria->compare('paketiurbiaya', $this->paketiurbiaya);
		$criteria->compare('nourut_tipepaket', $this->nourut_tipepaket);
		$criteria->compare('LOWER(keterangan_tipepaket)', strtolower($this->keterangan_tipepaket), true);
		//$criteria->compare('tipepaket_aktif',$this->tipepaket_aktif);
		// Klo limit lebih kecil dari nol itu berarti ga ada limit 
		$criteria->limit = -1;
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => false,
		));
	}
	protected function beforeValidate()
	{
		// convert to storage format
		//$this->tglrevisimodul = date ('Y-m-d', strtotime($this->tglrevisimodul));
		$format = new MyFormatter();
		//$this->tglrevisimodul = $format->formatDateTimeForDb($this->tglrevisimodul);
		foreach ($this->metadata->tableSchema->columns as $columnName => $column) {
			if ($column->dbType == 'date') {
				$this->$columnName = $format->formatDateTimeForDb($this->$columnName);
			} else if ($column->dbType == 'timestamp without time zone') {
				$this->$columnName = $format->formatDateTimeForDb($this->$columnName);
			}
		}
		return parent::beforeValidate();
	}
	public function beforeSave()
	{
		if ($this->tglkesepakatantarif === null || trim($this->tglkesepakatantarif) == '') {
			$this->setAttribute('tglkesepakatantarif', null);
		}
		return parent::beforeSave();
	}
	protected function afterFind()
	{
		foreach ($this->metadata->tableSchema->columns as $columnName => $column) {
			if (!strlen($this->$columnName)) continue;
			if ($column->dbType == 'date') {
				$this->$columnName = Yii::app()->dateFormatter->formatDateTime(
					CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),
					'medium',
					null
				);
			} elseif ($column->dbType == 'timestamp without time zone') {
				$this->$columnName = Yii::app()->dateFormatter->formatDateTime(
					CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss')
				);
			}
		}
		return true;
	}
}
