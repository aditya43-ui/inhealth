<?php

/**
 * This is the model class for table "prosestransferpasien_t".
 *
 * The followings are the available columns in table 'prosestransferpasien_t':
 * @property integer $prosestransferpasien_id
 * @property integer $formtransferpasien_id
 * @property string $derajatpasien
 * @property string $catatanpendampingtransfer
 * @property string $sebelumtransfer_tanggal
 * @property string $sebelumtransfer_keadaanumum
 * @property string $sebelumtransfer_kesadaran
 * @property integer $sebelumtransfer_td_systolic
 * @property integer $sebelumtransfer_td_diastolic
 * @property double $sebelumtransfer_suhutubuh
 * @property integer $sebelumtransfer_nadi
 * @property string $sebelumtransfer_skorews
 * @property string $sebelumtransfer_klasifikasi_skorews
 * @property integer $sebelumtransfer_pegawaiygmenyerahkan
 * @property string $sebelumtransfer_catatanpenting
 * @property string $setelahtransfer_tanggal
 * @property string $setelahtransfer_waktutiba
 * @property string $setelahtransfer_keadaanumum
 * @property string $setelahtransfer_kesadaran
 * @property integer $setelahtransfer_td_systolic
 * @property integer $setelahtransfer_td_diastolic
 * @property double $setelahtransfer_suhutubuh
 * @property integer $setelahtransfer_nadi
 * @property string $setelahtransfer_skorews
 * @property string $setelahtransfer_klasifikasi_skorews
 * @property integer $setelahtransfer_pegawaiygmenerima
 * @property integer $setelahtransfer_catatanpenting
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai
 * @property string $update_loginpemakai
 * @property integer $create_petugaspengisi_id
 * @property integer $create_ruangan_id
 *
 * The followings are the available model relations:
 * @property FormtransferpasienT $formtransferpasien
 * @property PegawaipendampingtransferpasienT[] $pegawaipendampingtransferpasienTs
 */
class ProsestransferpasienT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProsestransferpasienT the static model class
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
		return 'prosestransferpasien_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('formtransferpasien_id, create_loginpemakai', 'required'),
			array('formtransferpasien_id, sebelumtransfer_td_systolic, sebelumtransfer_td_diastolic, sebelumtransfer_nadi, sebelumtransfer_pegawaiygmenyerahkan, setelahtransfer_td_systolic, setelahtransfer_td_diastolic, setelahtransfer_nadi, setelahtransfer_pegawaiygmenerima, create_petugaspengisi_id, create_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('sebelumtransfer_suhutubuh, setelahtransfer_suhutubuh', 'numerical'),
			array('derajatpasien, sebelumtransfer_skorews, setelahtransfer_skorews', 'length', 'max'=>50),
			array('sebelumtransfer_keadaanumum, setelahtransfer_keadaanumum', 'length', 'max'=>300),
			array('sebelumtransfer_kesadaran, setelahtransfer_kesadaran', 'length', 'max'=>20),
			array('sebelumtransfer_klasifikasi_skorews, setelahtransfer_klasifikasi_skorews, create_loginpemakai, update_loginpemakai', 'length', 'max'=>100),
			array('catatanpendampingtransfer, sebelumtransfer_tanggal, sebelumtransfer_catatanpenting, setelahtransfer_tanggal, setelahtransfer_waktutiba, create_time, update_time, setelahtransfer_catatanpenting', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('prosestransferpasien_id, formtransferpasien_id, derajatpasien, catatanpendampingtransfer, sebelumtransfer_tanggal, sebelumtransfer_keadaanumum, sebelumtransfer_kesadaran, sebelumtransfer_td_systolic, sebelumtransfer_td_diastolic, sebelumtransfer_suhutubuh, sebelumtransfer_nadi, sebelumtransfer_skorews, sebelumtransfer_klasifikasi_skorews, sebelumtransfer_pegawaiygmenyerahkan, sebelumtransfer_catatanpenting, setelahtransfer_tanggal, setelahtransfer_waktutiba, setelahtransfer_keadaanumum, setelahtransfer_kesadaran, setelahtransfer_td_systolic, setelahtransfer_td_diastolic, setelahtransfer_suhutubuh, setelahtransfer_nadi, setelahtransfer_skorews, setelahtransfer_klasifikasi_skorews, setelahtransfer_pegawaiygmenerima, setelahtransfer_catatanpenting, create_time, update_time, create_loginpemakai, update_loginpemakai, create_petugaspengisi_id, create_ruangan_id', 'safe', 'on'=>'search'),
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
			'formtransferpasien' => array(self::BELONGS_TO, 'FormtransferpasienT', 'formtransferpasien_id'),
			'pegawaipendampingtransferpasienTs' => array(self::HAS_MANY, 'PegawaipendampingtransferpasienT', 'prosestransferpasien_id'),
                    'sebelumtransferpegawaiygmenyerahkan' => array(self::BELONGS_TO, 'PegawaiM', 'sebelumtransfer_pegawaiygmenyerahkan'),
                    'setelahtransferpegawaiygmenerima' => array(self::BELONGS_TO, 'PegawaiM', 'setelahtransfer_pegawaiygmenerima'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'prosestransferpasien_id' => 'Prosestransferpasien',
			'formtransferpasien_id' => 'Formtransferpasien',
			'derajatpasien' => 'Derajat Pasien',
			'catatanpendampingtransfer' => 'Catatan',
			'sebelumtransfer_tanggal' => 'Tanggal &  Jam',
			'sebelumtransfer_keadaanumum' => 'Keadaan Umum',
			'sebelumtransfer_kesadaran' => 'Kesadaran',
			'sebelumtransfer_td_systolic' => 'Sebelumtransfer Td Systolic',
			'sebelumtransfer_td_diastolic' => 'Sebelumtransfer Td Diastolic',
			'sebelumtransfer_suhutubuh' => 'Sebelumtransfer Suhutubuh',
			'sebelumtransfer_nadi' => 'Sebelumtransfer Nadi',
			'sebelumtransfer_skorews' => 'Sebelumtransfer Skorews',
			'sebelumtransfer_klasifikasi_skorews' => 'Sebelumtransfer Klasifikasi Skorews',
			'sebelumtransfer_pegawaiygmenyerahkan' => 'Sebelumtransfer Pegawaiygmenyerahkan',
			'sebelumtransfer_catatanpenting' => 'Sebelumtransfer Catatanpenting',
			'setelahtransfer_tanggal' => 'Tanggal & Jam',
			'setelahtransfer_waktutiba' => 'Waktu Tiba',
			'setelahtransfer_keadaanumum' => 'Keadaan Umum',
			'setelahtransfer_kesadaran' => 'Kesadaran',
			'setelahtransfer_td_systolic' => 'Setelahtransfer Td Systolic',
			'setelahtransfer_td_diastolic' => 'Setelahtransfer Td Diastolic',
			'setelahtransfer_suhutubuh' => 'Setelahtransfer Suhutubuh',
			'setelahtransfer_nadi' => 'Setelahtransfer Nadi',
			'setelahtransfer_skorews' => 'Setelahtransfer Skorews',
			'setelahtransfer_klasifikasi_skorews' => 'Setelahtransfer Klasifikasi Skorews',
			'setelahtransfer_pegawaiygmenerima' => 'Setelahtransfer Pegawaiygmenerima',
			'setelahtransfer_catatanpenting' => 'Setelahtransfer Catatanpenting',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai' => 'Create Loginpemakai',
			'update_loginpemakai' => 'Update Loginpemakai',
			'create_petugaspengisi_id' => 'Create Petugaspengisi',
			'create_ruangan_id' => 'Create Ruangan',
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

		$criteria->compare('prosestransferpasien_id',$this->prosestransferpasien_id);
		$criteria->compare('formtransferpasien_id',$this->formtransferpasien_id);
		$criteria->compare('derajatpasien',$this->derajatpasien,true);
		$criteria->compare('catatanpendampingtransfer',$this->catatanpendampingtransfer,true);
		$criteria->compare('sebelumtransfer_tanggal',$this->sebelumtransfer_tanggal,true);
		$criteria->compare('sebelumtransfer_keadaanumum',$this->sebelumtransfer_keadaanumum,true);
		$criteria->compare('sebelumtransfer_kesadaran',$this->sebelumtransfer_kesadaran,true);
		$criteria->compare('sebelumtransfer_td_systolic',$this->sebelumtransfer_td_systolic);
		$criteria->compare('sebelumtransfer_td_diastolic',$this->sebelumtransfer_td_diastolic);
		$criteria->compare('sebelumtransfer_suhutubuh',$this->sebelumtransfer_suhutubuh);
		$criteria->compare('sebelumtransfer_nadi',$this->sebelumtransfer_nadi);
		$criteria->compare('sebelumtransfer_skorews',$this->sebelumtransfer_skorews,true);
		$criteria->compare('sebelumtransfer_klasifikasi_skorews',$this->sebelumtransfer_klasifikasi_skorews,true);
		$criteria->compare('sebelumtransfer_pegawaiygmenyerahkan',$this->sebelumtransfer_pegawaiygmenyerahkan);
		$criteria->compare('sebelumtransfer_catatanpenting',$this->sebelumtransfer_catatanpenting,true);
		$criteria->compare('setelahtransfer_tanggal',$this->setelahtransfer_tanggal,true);
		$criteria->compare('setelahtransfer_waktutiba',$this->setelahtransfer_waktutiba,true);
		$criteria->compare('setelahtransfer_keadaanumum',$this->setelahtransfer_keadaanumum,true);
		$criteria->compare('setelahtransfer_kesadaran',$this->setelahtransfer_kesadaran,true);
		$criteria->compare('setelahtransfer_td_systolic',$this->setelahtransfer_td_systolic);
		$criteria->compare('setelahtransfer_td_diastolic',$this->setelahtransfer_td_diastolic);
		$criteria->compare('setelahtransfer_suhutubuh',$this->setelahtransfer_suhutubuh);
		$criteria->compare('setelahtransfer_nadi',$this->setelahtransfer_nadi);
		$criteria->compare('setelahtransfer_skorews',$this->setelahtransfer_skorews,true);
		$criteria->compare('setelahtransfer_klasifikasi_skorews',$this->setelahtransfer_klasifikasi_skorews,true);
		$criteria->compare('setelahtransfer_pegawaiygmenerima',$this->setelahtransfer_pegawaiygmenerima);
		$criteria->compare('setelahtransfer_catatanpenting',$this->setelahtransfer_catatanpenting);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai,true);
		$criteria->compare('update_loginpemakai',$this->update_loginpemakai,true);
		$criteria->compare('create_petugaspengisi_id',$this->create_petugaspengisi_id);
		$criteria->compare('create_ruangan_id',$this->create_ruangan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}