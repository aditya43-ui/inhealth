<?php

/**
 * This is the model class for table "verifikasitagihantindakan_r".
 *
 * The followings are the available columns in table 'verifikasitagihantindakan_r':
 * @property integer $verifikasitagihantindakan_id
 * @property integer $verifikasitagihan_id
 * @property integer $tindakanpelayanan_id
 * @property integer $daftartindakan_id
 * @property integer $carabayar_id
 * @property integer $penjamin_id
 * @property double $qty_tindakan_sebelum
 * @property double $qty_tindakan_sesudah
 * @property double $tarif_satuan_sebelum
 * @property double $tarif_satuan_sesudah
 * @property double $tarif_tindakan_sebelum
 * @property double $tarif_tindakan_sesudah
 * @property double $discount_tindakan_sebelum
 * @property double $discount_tindakan_sesudah
 * @property double $subsidiasuransi_tindakan_sebelum
 * @property double $subsidiasuransi_tindakan_sesudah
 * @property double $subsidipemerintah_tindakan_sebelum
 * @property double $subsidipemerintah_tindakan_sesudah
 * @property double $subsisidirumahsakit_tindakan_sebelum
 * @property double $subsisidirumahsakit_tindakan_sesudah
 *
 * The followings are the available model relations:
 * @property VerifikasitagihanT $verifikasitagihan
 * @property DaftartindakanM $daftartindakan
 * @property CarabayarM $carabayar
 * @property PenjaminpasienM $penjamin
 * @property VerifikasitagihankomponenR[] $verifikasitagihankomponenRs
 */
class VerifikasitagihantindakanR extends CActiveRecord
{
	public $komponen;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VerifikasitagihantindakanR the static model class
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
		return 'verifikasitagihantindakan_r';
	}
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('verifikasitagihan_id, tindakanpelayanan_id, daftartindakan_id, carabayar_id, penjamin_id', 'required'),
			array('verifikasitagihan_id, tindakanpelayanan_id, daftartindakan_id, carabayar_id, penjamin_id', 'numerical', 'integerOnly' => true),
			array('qty_tindakan_sebelum, qty_tindakan_sesudah, tarif_satuan_sebelum, tarif_satuan_sesudah, tarif_tindakan_sebelum, tarif_tindakan_sesudah, discount_tindakan_sebelum, discount_tindakan_sesudah, subsidiasuransi_tindakan_sebelum, subsidiasuransi_tindakan_sesudah, subsidipemerintah_tindakan_sebelum, subsidipemerintah_tindakan_sesudah, subsisidirumahsakit_tindakan_sebelum, subsisidirumahsakit_tindakan_sesudah', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('verifikasitagihantindakan_id, verifikasitagihan_id, tindakanpelayanan_id, daftartindakan_id, carabayar_id, penjamin_id, qty_tindakan_sebelum, qty_tindakan_sesudah, tarif_satuan_sebelum, tarif_satuan_sesudah, tarif_tindakan_sebelum, tarif_tindakan_sesudah, discount_tindakan_sebelum, discount_tindakan_sesudah, subsidiasuransi_tindakan_sebelum, subsidiasuransi_tindakan_sesudah, subsidipemerintah_tindakan_sebelum, subsidipemerintah_tindakan_sesudah, subsisidirumahsakit_tindakan_sebelum, subsisidirumahsakit_tindakan_sesudah', 'safe', 'on' => 'search'),
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
			'verifikasitagihan' => array(self::BELONGS_TO, 'VerifikasitagihanT', 'verifikasitagihan_id'),
			'daftartindakan' => array(self::BELONGS_TO, 'DaftartindakanM', 'daftartindakan_id'),
			'carabayar' => array(self::BELONGS_TO, 'CarabayarM', 'carabayar_id'),
			'penjamin' => array(self::BELONGS_TO, 'PenjaminpasienM', 'penjamin_id'),
			'verifikasitagihankomponenRs' => array(self::HAS_MANY, 'VerifikasitagihankomponenR', 'verifikasitagihantindakan_id'),
		);
	}
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'verifikasitagihantindakan_id' => 'Verifikasitagihantindakan',
			'verifikasitagihan_id' => 'Verifikasitagihan',
			'tindakanpelayanan_id' => 'Tindakanpelayanan',
			'daftartindakan_id' => 'Daftartindakan',
			'carabayar_id' => 'Jenis Penjamin',
			'penjamin_id' => 'Penjamin',
			'qty_tindakan_sebelum' => 'Qty Tindakan Sebelum',
			'qty_tindakan_sesudah' => 'Qty Tindakan Sesudah',
			'tarif_satuan_sebelum' => 'Tarif Satuan Sebelum',
			'tarif_satuan_sesudah' => 'Tarif Satuan Sesudah',
			'tarif_tindakan_sebelum' => 'Nominal Tarif Sebelum',
			'tarif_tindakan_sesudah' => 'Nominal Tarif Sesudah',
			'discount_tindakan_sebelum' => 'Keringanan Tindakan Sebelum',
			'discount_tindakan_sesudah' => 'Keringanan Tindakan Sesudah',
			'subsidiasuransi_tindakan_sebelum' => 'Tanggungan Asuransi Tindakan Sebelum',
			'subsidiasuransi_tindakan_sesudah' => 'Tanggungan Asuransi Tindakan Sesudah',
			'subsidipemerintah_tindakan_sebelum' => 'Tanggungan Pemerintah Tindakan Sebelum',
			'subsidipemerintah_tindakan_sesudah' => 'Tanggungan Pemerintah Tindakan Sesudah',
			'subsisidirumahsakit_tindakan_sebelum' => 'Tanggungan Rumah Sakit Tindakan Sebelum',
			'subsisidirumahsakit_tindakan_sesudah' => 'Tanggungan Rumah Sakit Tindakan Sesudah',
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
		$criteria->compare('verifikasitagihantindakan_id', $this->verifikasitagihantindakan_id);
		$criteria->compare('verifikasitagihan_id', $this->verifikasitagihan_id);
		$criteria->compare('tindakanpelayanan_id', $this->tindakanpelayanan_id);
		$criteria->compare('daftartindakan_id', $this->daftartindakan_id);
		$criteria->compare('carabayar_id', $this->carabayar_id);
		$criteria->compare('penjamin_id', $this->penjamin_id);
		$criteria->compare('qty_tindakan_sebelum', $this->qty_tindakan_sebelum);
		$criteria->compare('qty_tindakan_sesudah', $this->qty_tindakan_sesudah);
		$criteria->compare('tarif_satuan_sebelum', $this->tarif_satuan_sebelum);
		$criteria->compare('tarif_satuan_sesudah', $this->tarif_satuan_sesudah);
		$criteria->compare('tarif_tindakan_sebelum', $this->tarif_tindakan_sebelum);
		$criteria->compare('tarif_tindakan_sesudah', $this->tarif_tindakan_sesudah);
		$criteria->compare('discount_tindakan_sebelum', $this->discount_tindakan_sebelum);
		$criteria->compare('discount_tindakan_sesudah', $this->discount_tindakan_sesudah);
		$criteria->compare('subsidiasuransi_tindakan_sebelum', $this->subsidiasuransi_tindakan_sebelum);
		$criteria->compare('subsidiasuransi_tindakan_sesudah', $this->subsidiasuransi_tindakan_sesudah);
		$criteria->compare('subsidipemerintah_tindakan_sebelum', $this->subsidipemerintah_tindakan_sebelum);
		$criteria->compare('subsidipemerintah_tindakan_sesudah', $this->subsidipemerintah_tindakan_sesudah);
		$criteria->compare('subsisidirumahsakit_tindakan_sebelum', $this->subsisidirumahsakit_tindakan_sebelum);
		$criteria->compare('subsisidirumahsakit_tindakan_sesudah', $this->subsisidirumahsakit_tindakan_sesudah);
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
	public function loadKomponen()
	{
		$this->komponen = VerifikasitagihankomponenR::model()->findAllByAttributes(array(
			'verifikasitagihantindakan_id' => $this->verifikasitagihantindakan_id,
		));
	}
}
