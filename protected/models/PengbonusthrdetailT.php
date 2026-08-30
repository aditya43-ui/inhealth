<?php

/**
 * This is the model class for table "pengbonusthrdetail_t".
 *
 * The followings are the available columns in table 'pengbonusthrdetail_t':
 * @property integer $pengbonusthrdetail_id
 * @property integer $pengbonusthr_id
 * @property integer $pegawai_id
 * @property string $statuspegawai
 * @property string $tglditerima
 * @property string $jenisgaji
 * @property double $gajipokok
 * @property double $tunjangantetap
 * @property double $totalthr
 * @property double $totalpajak
 * @property double $nilaibonus
 * @property string $keteranganbonus
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 *
 * The followings are the available model relations:
 * @property PengbonusthrT $pengbonusthr
 * @property PegawaiM $pegawai
 * @property KomponengajiM $komponengaji
 */
class PengbonusthrdetailT extends CActiveRecord
{
    public $nama_pegawai, $periodebonusthr;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengbonusthrdetailT the static model class
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
		return 'pengbonusthrdetail_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pengbonusthr_id, pegawai_id, statuspegawai, tglditerima, jenisgaji, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pengbonusthr_id, pegawai_id, jurnalrekening_id', 'numerical', 'integerOnly'=>true),
			array('gajipokok, tunjangantetap, totalthr, totalpajak, nilaibonus, pajakbonus, tunjangan_pph_21_thr, tunjangan_pph_21_bonus, thp_thr', 'numerical'),
			array('statuspegawai', 'length', 'max'=>50),
			array('jenisgaji', 'length', 'max'=>20),
			array('keteranganbonus, update_time, update_loginpemakai_id, isimport, thp_bonus', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pengbonusthrdetail_id, pengbonusthr_id, pegawai_id, statuspegawai, tglditerima, jenisgaji, gajipokok, tunjangantetap, totalthr, totalpajak, nilaibonus, keteranganbonus, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, pajakbonus, isimport, tunjangan_pph_21_thr, tunjangan_pph_21_bonus, thp_thr, jurnalrekening_id', 'safe', 'on'=>'search'),
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
			'pengbonusthr' => array(self::BELONGS_TO, 'PengbonusthrT', 'pengbonusthr_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pengbonusthrdetail_id' => 'Pengbonusthrdetail',
			'pengbonusthr_id' => 'Pengbonusthr',
			'pegawai_id' => 'Pegawai',
			'statuspegawai' => 'Statuspegawai',
			'tglditerima' => 'Tglditerima',
			'jenisgaji' => 'Jenis Gaji',
			'gajipokok' => 'Gajipokok',
			'tunjangantetap' => 'Tunjangantetap',
			'totalthr' => 'Totalthr',
			'totalpajak' => 'Totalpajak',
			'nilaibonus' => 'Nilaibonus',
			'keteranganbonus' => 'Keteranganbonus',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
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

		$criteria->compare('pengbonusthrdetail_id',$this->pengbonusthrdetail_id);
		$criteria->compare('pengbonusthr_id',$this->pengbonusthr_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('statuspegawai',$this->statuspegawai,true);
		$criteria->compare('tglditerima',$this->tglditerima,true);
		$criteria->compare('jenisgaji',$this->jenisgaji,true);
		$criteria->compare('gajipokok',$this->gajipokok);
		$criteria->compare('tunjangantetap',$this->tunjangantetap);
		$criteria->compare('totalthr',$this->totalthr);
		$criteria->compare('totalpajak',$this->totalpajak);
		$criteria->compare('nilaibonus',$this->nilaibonus);
		$criteria->compare('keteranganbonus',$this->keteranganbonus,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
