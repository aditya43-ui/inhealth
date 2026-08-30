<?php

/**
 * This is the model class for table "persiapanpengadaandet_t".
 *
 * The followings are the available columns in table 'persiapanpengadaandet_t':
 * @property integer $persiapanpengadaandet_id
 * @property integer $persiapanpengadaan_id
 * @property string $persiapanpengadaandet_nama
 * @property string $persiapanpengadaandet_satuan
 * @property string $persiapanpengadaandet_volume
 * @property double $harga_estimasi
 * @property double $jumlah_pajak
 * @property double $harga_pasar
 * @property double $jumlah_harga
 *
 * The followings are the available model relations:
 * @property PersiapanpengadaanT $persiapanpengadaan
 * 
 * @package      application.models 
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link      <http://piindonesia.co.id>
 * @link      <http://172.9.1.15/simpp/docs/>
 * 
 */
class PersiapanpengadaandetT extends CActiveRecord
{
        public $obatalkes_id, $sebelum_pajak, $jumlah_awal, $volume_awal, $sisa_pagu;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PersiapanpengadaandetT the static model class
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
		return 'persiapanpengadaandet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('persiapanpengadaan_id', 'required'),
			array('persiapanpengadaan_id', 'numerical', 'integerOnly'=>true),
			array('harga_estimasi, jumlah_pajak, harga_pasar, jumlah_harga', 'numerical'),
			array('persiapanpengadaandet_satuan', 'length', 'max'=>100),
			array('persiapanpengadaandet_nama, obatalkes_id, dokumenpelaksanaananggarandet_id, jenis_barang, barang_id, pajak_persen, persiapanpengadaandet_volume', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('persiapanpengadaandet_id, persiapanpengadaan_id, persiapanpengadaandet_nama, persiapanpengadaandet_satuan, persiapanpengadaandet_volume, harga_estimasi, jumlah_pajak, harga_pasar, jumlah_harga', 'safe', 'on'=>'search'),
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
			'persiapanpengadaan' => array(self::BELONGS_TO, 'PersiapanpengadaanT', 'persiapanpengadaan_id'),
                        'dokumenpelaksanaananggarandet' => array(self::BELONGS_TO, 'DokumenpelaksanaananggarandetT', 'dokumenpelaksanaananggarandet_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'persiapanpengadaandet_id' => 'Persiapanpengadaandet',
			'persiapanpengadaan_id' => 'Persiapanpengadaan',
			'persiapanpengadaandet_nama' => 'Persiapanpengadaandet Nama',
			'persiapanpengadaandet_satuan' => 'Persiapanpengadaandet Satuan',
			'persiapanpengadaandet_volume' => 'Persiapanpengadaandet Volume',
			'harga_estimasi' => 'Harga Estimasi',
			'jumlah_pajak' => 'Jumlah Pajak',
			'harga_pasar' => 'Harga Pasar',
			'jumlah_harga' => 'Jumlah Harga',
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

		$criteria->compare('persiapanpengadaandet_id',$this->persiapanpengadaandet_id);
		$criteria->compare('persiapanpengadaan_id',$this->persiapanpengadaan_id);
		$criteria->compare('persiapanpengadaandet_nama',$this->persiapanpengadaandet_nama,true);
		$criteria->compare('persiapanpengadaandet_satuan',$this->persiapanpengadaandet_satuan,true);
		$criteria->compare('persiapanpengadaandet_volume',$this->persiapanpengadaandet_volume,true);
		$criteria->compare('harga_estimasi',$this->harga_estimasi);
		$criteria->compare('jumlah_pajak',$this->jumlah_pajak);
		$criteria->compare('harga_pasar',$this->harga_pasar);
		$criteria->compare('jumlah_harga',$this->jumlah_harga);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}