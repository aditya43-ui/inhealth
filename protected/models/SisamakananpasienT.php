<?php

/**
 * This is the model class for table "sisamakananpasien_t".
 *
 * The followings are the available columns in table 'sisamakananpasien_t':
 * @property integer $sisamakananpasien_id
 * @property integer $pasienadmisi_id
 * @property integer $ruangan_id
 * @property integer $hariperawatke
 * @property integer $auditor_id
 * @property string $tgl_audit
 * @property string $jam_audit
 * @property integer $jenisdiet_id
 * @property integer $tipediet_id
 * @property integer $jml_jenismenu
 * @property integer $jml_4dan5
 * @property double $auditscore_persen
 * @property string $kesimpulan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PasienadmisiT $pasienadmisi
 * @property PegawaiM $auditor
 * @property JenisdietM $jenisdiet
 * @property TipeDietM $tipediet
 * @property SisamakananpasiendetT[] $sisamakananpasiendetTs
 */
class SisamakananpasienT extends CActiveRecord
{
    public $instalasi_id, $sisamakanan_image;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SisamakananpasienT the static model class
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
		return 'sisamakananpasien_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasienadmisi_id, ruangan_id, hariperawatke, auditor_id, tgl_audit, jam_audit, jml_jenismenu, jml_4dan5, auditscore_persen, kesimpulan, create_time, create_loginpemakai_id', 'required'),
			array('pasienadmisi_id, ruangan_id, hariperawatke, auditor_id, jenisdiet_id, tipediet_id, jml_jenismenu, jml_4dan5, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('auditscore_persen', 'numerical'),
			array('kesimpulan', 'length', 'max'=>100),
			array('update_time, sisamakanan_image', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('sisamakananpasien_id, pasienadmisi_id, ruangan_id, hariperawatke, auditor_id, tgl_audit, jam_audit, jenisdiet_id, tipediet_id, jml_jenismenu, jml_4dan5, auditscore_persen, kesimpulan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'auditor' => array(self::BELONGS_TO, 'PegawaiM', 'auditor_id'),
			'jenisdiet' => array(self::BELONGS_TO, 'JenisdietM', 'jenisdiet_id'),
			'tipediet' => array(self::BELONGS_TO, 'TipeDietM', 'tipediet_id'),
			'sisamakananpasiendetTs' => array(self::HAS_MANY, 'SisamakananpasiendetT', 'sisamakananpasien_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'sisamakananpasien_id' => 'Sisamakananpasien',
			'pasienadmisi_id' => 'Pasienadmisi',
			'ruangan_id' => 'Ruangan',
			'hariperawatke' => 'Hari Perawatan Ke-',
			'auditor_id' => 'Auditor',
			'tgl_audit' => 'Tanggal Audit',
			'jam_audit' => 'Jam Audit',
			'jenisdiet_id' => 'Jenis Diet',
			'tipediet_id' => 'Tipe Diet',
			'jml_jenismenu' => 'Jumlah Jenis Menu',
			'jml_4dan5' => 'Total 4 dan 5 (Sisa Makanan 25% dan 0%)',
			'auditscore_persen' => 'Audit Score',
			'sisamakanan_image' => 'Sisamakanan Image',
			'kesimpulan' => 'Kesimpulan',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
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

		$criteria->compare('sisamakananpasien_id',$this->sisamakananpasien_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('hariperawatke',$this->hariperawatke);
		$criteria->compare('auditor_id',$this->auditor_id);
		$criteria->compare('tgl_audit',$this->tgl_audit,true);
		$criteria->compare('jam_audit',$this->jam_audit,true);
		$criteria->compare('jenisdiet_id',$this->jenisdiet_id);
		$criteria->compare('tipediet_id',$this->tipediet_id);
		$criteria->compare('jml_jenismenu',$this->jml_jenismenu);
		$criteria->compare('jml_4dan5',$this->jml_4dan5);
		$criteria->compare('auditscore_persen',$this->auditscore_persen);
		$criteria->compare('kesimpulan',$this->kesimpulan,true);
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