<?php

/**
 * This is the model class for table "pembayaranangsuran_t".
 *
 * The followings are the available columns in table 'pembayaranangsuran_t':
 * @property integer $pembayaranangsuran_id
 * @property integer $jmlangsuran_id
 * @property integer $buktikasmasukkop_id
 * @property integer $pengajuanpembayaran_id
 * @property integer $potongansumber_id
 * @property string $tglpembayaranangsuran
 * @property integer $byrangsuranke
 * @property double $jmlbayar_pembangsuran
 * @property double $jmlpokok_byrangsuran
 * @property double $jmljasa_byrangsuran
 * @property double $jmldenda_byrangsuran
 * @property double $jmlsisa_pembangsuran
 * @property integer $lamahari_sdhjthtempo
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property BuktikasmasukkopT $buktikasmasukkop
 * @property JmlangsuranT $jmlangsuran
 * @property PengajuanpembayaranT $pengajuanpembayaran
 * @property PermohonanpenangguhanT[] $permohonanpenangguhanTs
 */
class PembayaranangsuranT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PembayaranangsuranT the static model class
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
		return 'pembayaranangsuran_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jmlangsuran_id, buktikasmasukkop_id, tglpembayaranangsuran, byrangsuranke, lamahari_sdhjthtempo, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('jmlangsuran_id, buktikasmasukkop_id, pengajuanpembayaran_id, potongansumber_id, byrangsuranke, lamahari_sdhjthtempo, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('jmlbayar_pembangsuran, jmlpokok_byrangsuran, jmljasa_byrangsuran, jmldenda_byrangsuran, jmlsisa_pembangsuran', 'numerical'),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pembayaranangsuran_id, jmlangsuran_id, buktikasmasukkop_id, pengajuanpembayaran_id, potongansumber_id, tglpembayaranangsuran, byrangsuranke, jmlbayar_pembangsuran, jmlpokok_byrangsuran, jmljasa_byrangsuran, jmldenda_byrangsuran, jmlsisa_pembangsuran, lamahari_sdhjthtempo, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'buktikasmasukkop' => array(self::BELONGS_TO, 'BuktikasmasukkopT', 'buktikasmasukkop_id'),
			'jmlangsuran' => array(self::BELONGS_TO, 'JmlangsuranT', 'jmlangsuran_id'),
			'pengajuanpembayaran' => array(self::BELONGS_TO, 'PengajuanpembayaranT', 'pengajuanpembayaran_id'),
			'permohonanpenangguhanTs' => array(self::HAS_MANY, 'PermohonanpenangguhanT', 'pembayaranangsuran_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pembayaranangsuran_id' => 'Pembayaranangsuran',
			'jmlangsuran_id' => 'Jmlangsuran',
			'buktikasmasukkop_id' => 'Buktikasmasukkop',
			'pengajuanpembayaran_id' => 'Pengajuanpembayaran',
			'potongansumber_id' => 'Potongansumber',
			'tglpembayaranangsuran' => 'Tglpembayaranangsuran',
			'byrangsuranke' => 'Byrangsuranke',
			'jmlbayar_pembangsuran' => 'Jmlbayar Pembangsuran',
			'jmlpokok_byrangsuran' => 'Jmlpokok Byrangsuran',
			'jmljasa_byrangsuran' => 'Jmljasa Byrangsuran',
			'jmldenda_byrangsuran' => 'Jmldenda Byrangsuran',
			'jmlsisa_pembangsuran' => 'Jmlsisa Pembangsuran',
			'lamahari_sdhjthtempo' => 'Lamahari Sdhjthtempo',
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

		$criteria->compare('pembayaranangsuran_id',$this->pembayaranangsuran_id);
		$criteria->compare('jmlangsuran_id',$this->jmlangsuran_id);
		$criteria->compare('buktikasmasukkop_id',$this->buktikasmasukkop_id);
		$criteria->compare('pengajuanpembayaran_id',$this->pengajuanpembayaran_id);
		$criteria->compare('potongansumber_id',$this->potongansumber_id);
		$criteria->compare('tglpembayaranangsuran',$this->tglpembayaranangsuran,true);
		$criteria->compare('byrangsuranke',$this->byrangsuranke);
		$criteria->compare('jmlbayar_pembangsuran',$this->jmlbayar_pembangsuran);
		$criteria->compare('jmlpokok_byrangsuran',$this->jmlpokok_byrangsuran);
		$criteria->compare('jmljasa_byrangsuran',$this->jmljasa_byrangsuran);
		$criteria->compare('jmldenda_byrangsuran',$this->jmldenda_byrangsuran);
		$criteria->compare('jmlsisa_pembangsuran',$this->jmlsisa_pembangsuran);
		$criteria->compare('lamahari_sdhjthtempo',$this->lamahari_sdhjthtempo);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}