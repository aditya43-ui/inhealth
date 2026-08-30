<?php

/**
 * This is the model class for table "asesmentriagewpss_t".
 *
 * The followings are the available columns in table 'asesmentriagewpss_t':
 * @property integer $asesmentriagewpss_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $notriage_pasien_id
 * @property integer $prioritastriage_id
 * @property string $waktudatang
 * @property string $waktuperiksa
 * @property integer $petugastriage_id
 * @property string $caramasuk
 * @property string $transportasi
 * @property string $dikirimoleh
 * @property string $jeniskasus
 * @property string $appereance
 * @property string $workofbreathing
 * @property string $crculation
 * @property integer $totalskor
 * @property string $warnatriage
 * @property string $ruang
 * @property string $keputusan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property NotriagePasienT $notriagePasien
 * @property PasienM $pasien
 * @property PendaftaranT $pendaftaran
 * @property PegawaiM $petugastriage
 * @property PrioritastriageM $prioritastriage
 * @property AsesmentriagewpssdetT[] $asesmentriagewpssdetTs
 */
class AsesmentriagewpssT extends CActiveRecord
{
        public $petugastriage_nama;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'asesmentriagewpss_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('no_triage, notriage_pasien_id, keputusan, waktudatang, waktuperiksa, petugastriage_id, caramasuk, jeniskasus, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pasien_id, pendaftaran_id, notriage_pasien_id, prioritastriage_id, petugastriage_id, totalskor, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('caramasuk, transportasi, dikirimoleh, jeniskasus, ruang', 'length', 'max'=>100),
			array('warnatriage', 'length', 'max'=>50),
			array('waktudatang, waktuperiksa, appereance, workofbreathing, crculation, keputusan, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('asesmentriagewpss_id, pasien_id, pendaftaran_id, notriage_pasien_id, prioritastriage_id, waktudatang, waktuperiksa, petugastriage_id, caramasuk, transportasi, dikirimoleh, jeniskasus, appereance, workofbreathing, crculation, totalskor, warnatriage, ruang, keputusan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'notriagePasien' => array(self::BELONGS_TO, 'NotriagePasienT', 'notriage_pasien_id'),
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'petugastriage' => array(self::BELONGS_TO, 'PegawaiM', 'petugastriage_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'create_ruangan'),
			'loginpemakai'=> array(self::BELONGS_TO, 'LoginpemakaiK', 'create_ruangan'),
			'prioritastriage' => array(self::BELONGS_TO, 'PrioritastriageM', 'prioritastriage_id'),
			'asesmentriagewpssdetTs' => array(self::HAS_MANY, 'AsesmentriagewpssdetT', 'asesmentriagewpss_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'asesmentriagewpss_id' => 'Asesmentriagewpss',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'notriage_pasien_id' => 'No Triage',
			'prioritastriage_id' => 'Prioritas Triage',
			'waktudatang' => 'Waktu Datang',
			'waktuperiksa' => 'Waktu Periksa',
			'petugastriage_id' => 'Petugas Triage',
			'caramasuk' => 'Cara Masuk',
			'transportasi' => 'Transportasi',
			'dikirimoleh' => 'Dikirim Oleh',
			'jeniskasus' => 'Jenis Trauma',
			'appereance' => 'Appearance',
			'workofbreathing' => 'Work of Breathing',
			'crculation' => 'Circulation',
			'totalskor' => 'Total Skor',
			'warnatriage' => 'Warna Triage',
			'ruang' => 'Ruang',
			'keputusan' => 'Keputusan',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		// var_dump($this->attributes); die;

		$criteria->compare('asesmentriagewpss_id',$this->asesmentriagewpss_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		if(!empty($this->pendaftaran_id)) {
			$criteria->addCondition("pendaftaran_id= '" . $this->pendaftaran_id . "'");
		}
		if(!empty($this->notriage_pasien_id)) {
			$criteria->addCondition("notriage_pasien_id= '" . $this->notriage_pasien_id . "'");
		}
		$criteria->compare('prioritastriage_id',$this->prioritastriage_id);
		$criteria->compare('waktudatang',$this->waktudatang,true);
		$criteria->compare('waktuperiksa',$this->waktuperiksa,true);
		$criteria->compare('petugastriage_id',$this->petugastriage_id);
		$criteria->compare('caramasuk',$this->caramasuk,true);
		$criteria->compare('transportasi',$this->transportasi,true);
		$criteria->compare('dikirimoleh',$this->dikirimoleh,true);
		$criteria->compare('jeniskasus',$this->jeniskasus,true);
		$criteria->compare('appereance',$this->appereance,true);
		$criteria->compare('workofbreathing',$this->workofbreathing,true);
		$criteria->compare('crculation',$this->crculation,true);
		$criteria->compare('totalskor',$this->totalskor);
		$criteria->compare('warnatriage',$this->warnatriage,true);
		$criteria->compare('ruang',$this->ruang,true);
		$criteria->compare('keputusan',$this->keputusan,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		$criteria->order = 'asesmentriagewpss_id DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchTriage()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		// var_dump($this->attributes); die;

		$criteria->join = 'left join notriage_pasien_t n on n.notriage_pasien_id = t.notriage_pasien_id';
		$criteria->compare('t.asesmentriagewpss_id',$this->asesmentriagewpss_id);
		$criteria->compare('t.pasien_id',$this->pasien_id);
		if(!empty($this->pendaftaran_id)) {
			$criteria->addCondition("n.pendaftaran_id= '" . $this->pendaftaran_id . "'");
		}
		if(!empty($this->notriage_pasien_id)) {
			$criteria->addCondition("t.notriage_pasien_id= '" . $this->notriage_pasien_id . "'");
		}
		$criteria->compare('t.prioritastriage_id',$this->prioritastriage_id);
		$criteria->compare('t.waktudatang',$this->waktudatang,true);
		$criteria->compare('t.waktuperiksa',$this->waktuperiksa,true);
		$criteria->compare('t.petugastriage_id',$this->petugastriage_id);
		$criteria->compare('t.caramasuk',$this->caramasuk,true);
		$criteria->compare('t.transportasi',$this->transportasi,true);
		$criteria->compare('t.dikirimoleh',$this->dikirimoleh,true);
		$criteria->compare('t.jeniskasus',$this->jeniskasus,true);
		$criteria->compare('t.appereance',$this->appereance,true);
		$criteria->compare('t.workofbreathing',$this->workofbreathing,true);
		$criteria->compare('t.crculation',$this->crculation,true);
		$criteria->compare('t.totalskor',$this->totalskor);
		$criteria->compare('t.warnatriage',$this->warnatriage,true);
		$criteria->compare('t.ruang',$this->ruang,true);
		$criteria->compare('t.keputusan',$this->keputusan,true);
		$criteria->compare('t.create_time',$this->create_time,true);
		$criteria->compare('t.update_time',$this->update_time,true);
		$criteria->compare('t.create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('t.update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('t.create_ruangan',$this->create_ruangan);

		$criteria->order = 'asesmentriagewpss_id DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AsesmentriagewpssT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
