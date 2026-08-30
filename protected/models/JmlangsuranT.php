<?php

/**
 * This is the model class for table "jmlangsuran_t".
 *
 * The followings are the available columns in table 'jmlangsuran_t':
 * @property integer $jmlangsuran_id
 * @property integer $keanggotaan_id
 * @property integer $pinjaman_id
 * @property integer $buktikaskeluarkop_id
 * @property integer $angsuran_ke
 * @property string $tglangsuran
 * @property string $tgljatuhtempoangs
 * @property double $jmlpokok_angsuran
 * @property double $jmljasa_angsuran
 * @property double $jmldenda_angsuran
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property boolean $status_bayar
 * @property boolean $status_pengajuan
 * @property integer $permintaanberhenti_id
 *
 * The followings are the available model relations:
 * @property BuktikaskeluarkopT $buktikaskeluarkop
 * @property KeanggotaanT $keanggotaan
 * @property PermintaanberhentiT $permintaanberhenti
 * @property PinjamanT $pinjaman
 * @property PembayaranangsuranT[] $pembayaranangsuranTs
 * @property PengajuanpembayaranT[] $pengajuanpembayaranTs
 * @property PermohonanpenangguhanT[] $permohonanpenangguhanTs
 */
class JmlangsuranT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JmlangsuranT the static model class
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
		return 'jmlangsuran_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('keanggotaan_id, pinjaman_id, angsuran_ke, tglangsuran, tgljatuhtempoangs, jmlpokok_angsuran, create_time, create_loginpemakai_id', 'required'),
			array('keanggotaan_id, pinjaman_id, buktikaskeluarkop_id, angsuran_ke, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, permintaanberhenti_id', 'numerical', 'integerOnly'=>true),
			array('jmlpokok_angsuran, jmljasa_angsuran, jmldenda_angsuran', 'numerical'),
			array('update_time, status_bayar, status_pengajuan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jmlangsuran_id, keanggotaan_id, pinjaman_id, buktikaskeluarkop_id, angsuran_ke, tglangsuran, tgljatuhtempoangs, jmlpokok_angsuran, jmljasa_angsuran, jmldenda_angsuran, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, status_bayar, status_pengajuan, permintaanberhenti_id', 'safe', 'on'=>'search'),
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
			'buktikaskeluarkop' => array(self::BELONGS_TO, 'BuktikaskeluarkopT', 'buktikaskeluarkop_id'),
			'keanggotaan' => array(self::BELONGS_TO, 'KeanggotaanT', 'keanggotaan_id'),
			'permintaanberhenti' => array(self::BELONGS_TO, 'PermintaanberhentiT', 'permintaanberhenti_id'),
			'pinjaman' => array(self::BELONGS_TO, 'PinjamanT', 'pinjaman_id'),
			'pembayaranangsuranTs' => array(self::HAS_MANY, 'PembayaranangsuranT', 'jmlangsuran_id'),
			'pengajuanpembayaranTs' => array(self::HAS_MANY, 'PengajuanpembayaranT', 'jmlangsuran_id'),
			'permohonanpenangguhanTs' => array(self::HAS_MANY, 'PermohonanpenangguhanT', 'jmlangsuran_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'jmlangsuran_id' => 'Jmlangsuran',
			'keanggotaan_id' => 'Keanggotaan',
			'pinjaman_id' => 'Pinjaman',
			'buktikaskeluarkop_id' => 'Bukti Kas Keluar Kop',
			'angsuran_ke' => 'Angsuran Ke',
			'tglangsuran' => 'Tglangsuran',
			'tgljatuhtempoangs' => 'Tgljatuhtempoangs',
			'jmlpokok_angsuran' => 'Jmlpokok Angsuran',
			'jmljasa_angsuran' => 'Jmljasa Angsuran',
			'jmldenda_angsuran' => 'Jmldenda Angsuran',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'status_bayar' => 'Status Bayar',
			'status_pengajuan' => 'Status Pengajuan',
			'permintaanberhenti_id' => 'Permintaanberhenti',
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

		$criteria->compare('jmlangsuran_id',$this->jmlangsuran_id);
		$criteria->compare('keanggotaan_id',$this->keanggotaan_id);
		$criteria->compare('pinjaman_id',$this->pinjaman_id);
		$criteria->compare('buktikaskeluarkop_id',$this->buktikaskeluarkop_id);
		$criteria->compare('angsuran_ke',$this->angsuran_ke);
		$criteria->compare('tglangsuran',$this->tglangsuran,true);
		$criteria->compare('tgljatuhtempoangs',$this->tgljatuhtempoangs,true);
		$criteria->compare('jmlpokok_angsuran',$this->jmlpokok_angsuran);
		$criteria->compare('jmljasa_angsuran',$this->jmljasa_angsuran);
		$criteria->compare('jmldenda_angsuran',$this->jmldenda_angsuran);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);
		$criteria->compare('status_bayar',$this->status_bayar);
		$criteria->compare('status_pengajuan',$this->status_pengajuan);
		$criteria->compare('permintaanberhenti_id',$this->permintaanberhenti_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}