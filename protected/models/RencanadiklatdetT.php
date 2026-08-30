<?php

/**
 * This is the model class for table "rencanadiklatdet_t".
 *
 * The followings are the available columns in table 'rencanadiklatdet_t':
 * @property integer $rencanadiklatdet_id
 * @property integer $pegawai_id
 * @property integer $jabatan_id
 * @property integer $rencanadiklat_id
 * @property string $luar_peserta
 * @property string $luar_asalinstalasi
 * @property double $biaya_pelatihan
 * @property double $biaya_transportasi
 * @property double $biaya_penginapan
 * @property double $biaya_perjalanandinas
 * @property double $total
 * @property double $biaya_lainlain
 * @property string $keterangan_lainlain
 *
 * The followings are the available model relations:
 * @property RencanadiklatT $rencanadiklat
 */
class RencanadiklatdetT extends CActiveRecord
{
        public $nomorindukpegawai;
        public $pegawai_nama;
        public $jabatan_nama;
                
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RencanadiklatdetT the static model class
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
		return 'rencanadiklatdet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rencanadiklat_id', 'required'),
			array('pegawai_id, jabatan_id, rencanadiklat_id', 'numerical', 'integerOnly'=>true),
			array('biaya_pelatihan, biaya_transportasi, biaya_penginapan, biaya_perjalanandinas, total, biaya_lainlain', 'numerical'),
			array('luar_peserta, luar_asalinstalasi', 'length', 'max'=>100),
			array('keterangan_lainlain', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rencanadiklatdet_id, pegawai_id, jabatan_id, rencanadiklat_id, luar_peserta, luar_asalinstalasi, biaya_pelatihan, biaya_transportasi, biaya_penginapan, biaya_perjalanandinas, total, biaya_lainlain, keterangan_lainlain', 'safe', 'on'=>'search'),
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
			'rencanadiklat' => array(self::BELONGS_TO, 'RencanadiklatT', 'rencanadiklat_id'),
                        'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
                        'jabatan' => array(self::BELONGS_TO, 'JabatanM', 'jabatan_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'rencanadiklatdet_id' => 'Rencanadiklatdet',
			'pegawai_id' => 'Pegawai',
			'jabatan_id' => 'Jabatan',
			'rencanadiklat_id' => 'Rencanadiklat',
			'luar_peserta' => 'Luar Peserta',
			'luar_asalinstalasi' => 'Luar Asalinstalasi',
			'biaya_pelatihan' => 'Biaya Pelatihan',
			'biaya_transportasi' => 'Biaya Transportasi',
			'biaya_penginapan' => 'Biaya Penginapan',
			'biaya_perjalanandinas' => 'Biaya Perjalanandinas',
			'total' => 'Total',
			'biaya_lainlain' => 'Biaya Lainlain',
			'keterangan_lainlain' => 'Keterangan Lainlain',
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

		$criteria->compare('rencanadiklatdet_id',$this->rencanadiklatdet_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('jabatan_id',$this->jabatan_id);
		$criteria->compare('rencanadiklat_id',$this->rencanadiklat_id);
		$criteria->compare('luar_peserta',$this->luar_peserta,true);
		$criteria->compare('luar_asalinstalasi',$this->luar_asalinstalasi,true);
		$criteria->compare('biaya_pelatihan',$this->biaya_pelatihan);
		$criteria->compare('biaya_transportasi',$this->biaya_transportasi);
		$criteria->compare('biaya_penginapan',$this->biaya_penginapan);
		$criteria->compare('biaya_perjalanandinas',$this->biaya_perjalanandinas);
		$criteria->compare('total',$this->total);
		$criteria->compare('biaya_lainlain',$this->biaya_lainlain);
		$criteria->compare('keterangan_lainlain',$this->keterangan_lainlain,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}