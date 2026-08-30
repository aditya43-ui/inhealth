<?php

/**
 * This is the model class for table "informasirujukankeluarbpjs_v".
 *
 * The followings are the available columns in table 'informasirujukankeluarbpjs_v':
 * @property string $nosep
 * @property integer $pasiendirujukkeluar_id
 * @property string $tgldirujuk
 * @property string $nosuratrujukan
 * @property string $no_pendaftaran
 * @property string $no_rekam_medik
 * @property string $nama_pasien
 * @property string $dirujukke
 * @property string $dirujukkebagian
 * @property string $diagnosasementara_ruj
 * @property string $catatandokterperujuk
 * @property string $dokterpemeriksa
 * @property boolean $isdikembalikan
 * @property string $jenispelayanan_bpjs
 * @property string $tiperujukan_bpjs
 * @property string $userinput_bpjs
 */
class InformasirujukankeluarbpjsV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasirujukankeluarbpjsV the static model class
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
		return 'informasirujukankeluarbpjs_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasiendirujukkeluar_id', 'numerical', 'integerOnly'=>true),
			array('nosep, dirujukke', 'length', 'max'=>100),
			array('nosuratrujukan, nama_pasien', 'length', 'max'=>50),
			array('no_pendaftaran, jenispelayanan_bpjs, tiperujukan_bpjs, userinput_bpjs', 'length', 'max'=>20),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('dirujukkebagian', 'length', 'max'=>30),
			array('tgldirujuk, diagnosasementara_ruj, catatandokterperujuk, dokterpemeriksa, isdikembalikan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('nosep, pasiendirujukkeluar_id, tgldirujuk, nosuratrujukan, no_pendaftaran, no_rekam_medik, nama_pasien, dirujukke, dirujukkebagian, diagnosasementara_ruj, catatandokterperujuk, dokterpemeriksa, isdikembalikan, jenispelayanan_bpjs, tiperujukan_bpjs, userinput_bpjs', 'safe', 'on'=>'search'),
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
			'nosep' => 'Nosep',
			'pasiendirujukkeluar_id' => 'Pasiendirujukkeluar',
			'tgldirujuk' => 'Tgldirujuk',
			'nosuratrujukan' => 'Nosuratrujukan',
			'no_pendaftaran' => 'No Pendaftaran',
			'no_rekam_medik' => 'No Rekam Medik',
			'nama_pasien' => 'Nama Pasien',
			'dirujukke' => 'Dirujukke',
			'dirujukkebagian' => 'Dirujukkebagian',
			'diagnosasementara_ruj' => 'Diagnosasementara Ruj',
			'catatandokterperujuk' => 'Catatandokterperujuk',
			'dokterpemeriksa' => 'Dokterpemeriksa',
			'isdikembalikan' => 'Isdikembalikan',
			'jenispelayanan_bpjs' => 'Jenispelayanan Bpjs',
			'tiperujukan_bpjs' => 'Tiperujukan Bpjs',
			'userinput_bpjs' => 'Userinput Bpjs',
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

		$criteria->compare('nosep',$this->nosep,true);
		$criteria->compare('pasiendirujukkeluar_id',$this->pasiendirujukkeluar_id);
		$criteria->compare('tgldirujuk',$this->tgldirujuk,true);
		$criteria->compare('nosuratrujukan',$this->nosuratrujukan,true);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('dirujukke',$this->dirujukke,true);
		$criteria->compare('dirujukkebagian',$this->dirujukkebagian,true);
		$criteria->compare('diagnosasementara_ruj',$this->diagnosasementara_ruj,true);
		$criteria->compare('catatandokterperujuk',$this->catatandokterperujuk,true);
		$criteria->compare('dokterpemeriksa',$this->dokterpemeriksa,true);
		$criteria->compare('isdikembalikan',$this->isdikembalikan);
		$criteria->compare('jenispelayanan_bpjs',$this->jenispelayanan_bpjs,true);
		$criteria->compare('tiperujukan_bpjs',$this->tiperujukan_bpjs,true);
		$criteria->compare('userinput_bpjs',$this->userinput_bpjs,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}