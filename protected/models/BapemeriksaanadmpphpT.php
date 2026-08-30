<?php

/**
 * This is the model class for table "bapemeriksaanadmpphp_t".
 *
 * @author  Andyka Putra <andykaputra@.com>
 * @author  Yusuf Putra Anugrah <yusufputra@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'bapemeriksaanadmpphp_t':
 * @property integer $bapemeriksaanadmpphp_id
 * @property integer $suratperjanjiankerja_id
 * @property string $bapemeriksaanadmpphp_nomor
 * @property string $bapemeriksaanadmpphp_tanggal
 * @property string $nomor_beritaacara
 * @property integer $pegttdkontrak_id
 * @property string $nomor_sk
 * @property string $tanggal_sk
 * @property string $pemeriksaan_hasil
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PegawaiM $pegttdkontrak
 * @property DokumenpemeriksaanadministratifT[] $dokumenpemeriksaanadministratifTs
 */
class BapemeriksaanadmpphpT extends CActiveRecord
{
    public $pegttdkontrak_nama, $isi_surat, $total_termin, $termin_ke;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BapemeriksaanadmpphpT the static model class
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
		return 'bapemeriksaanadmpphp_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nomor_beritaacara,suratperjanjiankerja_id, bapemeriksaanadmpphp_nomor, bapemeriksaanadmpphp_tanggal, pegttdkontrak_id, create_time, create_loginpemakai_id, create_ruangan, tanggal_sk, nomor_sk', 'required'),
			array('suratperjanjiankerja_id, pegttdkontrak_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('bapemeriksaanadmpphp_nomor, nomor_beritaacara', 'length', 'max'=>50),
			array('nomor_sk, pemeriksaan_hasil', 'length', 'max'=>100),
			array('tanggal_sk, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('bapemeriksaanadmpphp_id, suratperjanjiankerja_id, bapemeriksaanadmpphp_nomor, bapemeriksaanadmpphp_tanggal, nomor_beritaacara, pegttdkontrak_id, nomor_sk, tanggal_sk, pemeriksaan_hasil, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pegttdkontrak' => array(self::BELONGS_TO, 'PegawaiM', 'pegttdkontrak_id'),
			'dokumenpemeriksaanadministratifTs' => array(self::HAS_MANY, 'DokumenpemeriksaanadministratifT', 'bapemeriksaanadmpphp_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'bapemeriksaanadmpphp_id' => 'Bapemeriksaanadmpphp',
			'suratperjanjiankerja_id' => 'Suratperjanjiankerja',
			'bapemeriksaanadmpphp_nomor' => 'Nomor Transaksi',
			'bapemeriksaanadmpphp_tanggal' => 'Tanggal Pembuatan BA',
			'nomor_beritaacara' => 'Nomor BA',
			'pegttdkontrak_id' => 'Penandatangan Kontrak',
			'nomor_sk' => 'Nomor SK',
			'tanggal_sk' => 'Tanggal SK',
			'pemeriksaan_hasil' => 'Pemeriksaan Hasil',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
                        'terminke'=>'Termin ke'
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

		$criteria->compare('bapemeriksaanadmpphp_id',$this->bapemeriksaanadmpphp_id);
		$criteria->compare('suratperjanjiankerja_id',$this->suratperjanjiankerja_id);
		$criteria->compare('bapemeriksaanadmpphp_nomor',$this->bapemeriksaanadmpphp_nomor,true);
		$criteria->compare('bapemeriksaanadmpphp_tanggal',$this->bapemeriksaanadmpphp_tanggal,true);
		$criteria->compare('nomor_beritaacara',$this->nomor_beritaacara,true);
		$criteria->compare('pegttdkontrak_id',$this->pegttdkontrak_id);
		$criteria->compare('nomor_sk',$this->nomor_sk,true);
		$criteria->compare('tanggal_sk',$this->tanggal_sk,true);
		$criteria->compare('pemeriksaan_hasil',$this->pemeriksaan_hasil,true);
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