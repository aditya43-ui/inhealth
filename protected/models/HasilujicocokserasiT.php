<?php

/**
 * This is the model class for table "hasilujicocokserasi_t".
 *
 * The followings are the available columns in table 'hasilujicocokserasi_t':
 * @property integer $hasilujicocokserasi_id
 * @property integer $labregno_lis
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $ruanganasal_id
 * @property string $jeniskantongdarah_singkatan
 * @property integer $ruangan_id
 * @property string $tgl_hasilujigoldar
 * @property integer $pegawai_id
 * @property integer $peg_pemeriksa1_id
 * @property integer $peg_pemeriksa2_id
 * @property string $dinas
 * @property string $jumlah_permintaan
 * @property string $jumlah_dilayani
 * @property boolean $selgrouping_antia
 * @property boolean $selgrouping_antib
 * @property boolean $serumgrouping_a
 * @property boolean $serumgrouping_b
 * @property boolean $serumgrouping_o
 * @property boolean $autocontrol
 * @property boolean $rhesusfaktor_d
 * @property boolean $rhesusfaktor_albumin
 * @property string $jam_pemeriksaangoldar
 * @property boolean $bacahasil
 * @property boolean $mayor1_serum
 * @property boolean $mayor1_sel
 * @property boolean $mayor2_serum
 * @property boolean $mayor2_sel
 * @property boolean $mayor3_serum
 * @property boolean $mayor3_sel
 * @property boolean $mayor4_serum
 * @property boolean $mayor4_sel
 * @property boolean $minor1_plasma
 * @property boolean $minor1_sel
 * @property boolean $minor2_plasma
 * @property boolean $minor2_sel
 * @property boolean $minor3_plasma
 * @property boolean $minor3_sel
 * @property boolean $minor4_plasma
 * @property boolean $minor4_sel
 * @property boolean $ac_serum
 * @property boolean $ac_sel
 * @property boolean $pool1_plasma
 * @property boolean $pool1_sel
 * @property boolean $pool2_plasma
 * @property boolean $pool2_sel
 * @property string $jam_pemeriksaancocokserasi
 * @property integer $create_loginpemakai_id
 * @property integer $create_ruangan
 * @property string $create_time
 */
class HasilujicocokserasiT extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'hasilujicocokserasi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, pendaftaran_id, jeniskantongdarah_singkatan', 'required'),
			array('hasilujicocokserasi_id, labregno_lis, pasien_id, pendaftaran_id, ruanganasal_id, ruangan_id, pegawai_id, peg_pemeriksa1_id, peg_pemeriksa2_id, create_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('jeniskantongdarah_singkatan, dinas, jumlah_permintaan, jumlah_dilayani', 'length', 'max'=>255),
			array('hasilujicocokserasi_id, tgl_hasilujigoldar, selgrouping_antia, selgrouping_antib, serumgrouping_a, serumgrouping_b, serumgrouping_o, autocontrol, rhesusfaktor_d, rhesusfaktor_albumin, jam_pemeriksaangoldar, bacahasil, mayor1_serum, mayor1_sel, mayor2_serum, mayor2_sel, mayor3_serum, mayor3_sel, mayor4_serum, mayor4_sel, minor1_plasma, minor1_sel, minor2_plasma, minor2_sel, minor3_plasma, minor3_sel, minor4_plasma, minor4_sel, ac_serum, ac_sel, pool1_plasma, pool1_sel, pool2_plasma, pool2_sel, jam_pemeriksaancocokserasi, create_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('hasilujicocokserasi_id, labregno_lis, pasien_id, pendaftaran_id, ruanganasal_id, jeniskantongdarah_singkatan, ruangan_id, tgl_hasilujigoldar, pegawai_id, peg_pemeriksa1_id, peg_pemeriksa2_id, dinas, jumlah_permintaan, jumlah_dilayani, selgrouping_antia, selgrouping_antib, serumgrouping_a, serumgrouping_b, serumgrouping_o, autocontrol, rhesusfaktor_d, rhesusfaktor_albumin, jam_pemeriksaangoldar, bacahasil, mayor1_serum, mayor1_sel, mayor2_serum, mayor2_sel, mayor3_serum, mayor3_sel, mayor4_serum, mayor4_sel, minor1_plasma, minor1_sel, minor2_plasma, minor2_sel, minor3_plasma, minor3_sel, minor4_plasma, minor4_sel, ac_serum, ac_sel, pool1_plasma, pool1_sel, pool2_plasma, pool2_sel, jam_pemeriksaancocokserasi, create_loginpemakai_id, create_ruangan, create_time', 'safe', 'on'=>'search'),
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
			'hasilujicocokserasi_id' => 'Hasilujicocokserasi',
			'labregno_lis' => 'Labregno Lis',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'ruanganasal_id' => 'Ruanganasal',
			'jeniskantongdarah_singkatan' => 'Jeniskantongdarah Singkatan',
			'ruangan_id' => 'Ruangan',
			'tgl_hasilujigoldar' => 'Tgl Hasilujigoldar',
			'pegawai_id' => 'Pegawai',
			'peg_pemeriksa1_id' => 'Peg Pemeriksa1',
			'peg_pemeriksa2_id' => 'Peg Pemeriksa2',
			'dinas' => 'Dinas',
			'jumlah_permintaan' => 'Jumlah Permintaan',
			'jumlah_dilayani' => 'Jumlah Dilayani',
			'selgrouping_antia' => 'Selgrouping Antia',
			'selgrouping_antib' => 'Selgrouping Antib',
			'serumgrouping_a' => 'Serumgrouping A',
			'serumgrouping_b' => 'Serumgrouping B',
			'serumgrouping_o' => 'Serumgrouping O',
			'autocontrol' => 'Autocontrol',
			'rhesusfaktor_d' => 'Rhesusfaktor D',
			'rhesusfaktor_albumin' => 'Rhesusfaktor Albumin',
			'jam_pemeriksaangoldar' => 'Jam Pemeriksaangoldar',
			'bacahasil' => 'Bacahasil',
			'mayor1_serum' => 'Mayor1 Serum',
			'mayor1_sel' => 'Mayor1 Sel',
			'mayor2_serum' => 'Mayor2 Serum',
			'mayor2_sel' => 'Mayor2 Sel',
			'mayor3_serum' => 'Mayor3 Serum',
			'mayor3_sel' => 'Mayor3 Sel',
			'mayor4_serum' => 'Mayor4 Serum',
			'mayor4_sel' => 'Mayor4 Sel',
			'minor1_plasma' => 'Minor1 Plasma',
			'minor1_sel' => 'Minor1 Sel',
			'minor2_plasma' => 'Minor2 Plasma',
			'minor2_sel' => 'Minor2 Sel',
			'minor3_plasma' => 'Minor3 Plasma',
			'minor3_sel' => 'Minor3 Sel',
			'minor4_plasma' => 'Minor4 Plasma',
			'minor4_sel' => 'Minor4 Sel',
			'ac_serum' => 'Ac Serum',
			'ac_sel' => 'Ac Sel',
			'pool1_plasma' => 'Pool1 Plasma',
			'pool1_sel' => 'Pool1 Sel',
			'pool2_plasma' => 'Pool2 Plasma',
			'pool2_sel' => 'Pool2 Sel',
			'jam_pemeriksaancocokserasi' => 'Jam Pemeriksaancocokserasi',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'create_time' => 'Create Time',
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

		$criteria->compare('hasilujicocokserasi_id',$this->hasilujicocokserasi_id);
		$criteria->compare('labregno_lis',$this->labregno_lis);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('ruanganasal_id',$this->ruanganasal_id);
		$criteria->compare('jeniskantongdarah_singkatan',$this->jeniskantongdarah_singkatan,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('tgl_hasilujigoldar',$this->tgl_hasilujigoldar,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('peg_pemeriksa1_id',$this->peg_pemeriksa1_id);
		$criteria->compare('peg_pemeriksa2_id',$this->peg_pemeriksa2_id);
		$criteria->compare('dinas',$this->dinas,true);
		$criteria->compare('jumlah_permintaan',$this->jumlah_permintaan,true);
		$criteria->compare('jumlah_dilayani',$this->jumlah_dilayani,true);
		$criteria->compare('selgrouping_antia',$this->selgrouping_antia);
		$criteria->compare('selgrouping_antib',$this->selgrouping_antib);
		$criteria->compare('serumgrouping_a',$this->serumgrouping_a);
		$criteria->compare('serumgrouping_b',$this->serumgrouping_b);
		$criteria->compare('serumgrouping_o',$this->serumgrouping_o);
		$criteria->compare('autocontrol',$this->autocontrol);
		$criteria->compare('rhesusfaktor_d',$this->rhesusfaktor_d);
		$criteria->compare('rhesusfaktor_albumin',$this->rhesusfaktor_albumin);
		$criteria->compare('jam_pemeriksaangoldar',$this->jam_pemeriksaangoldar,true);
		$criteria->compare('bacahasil',$this->bacahasil);
		$criteria->compare('mayor1_serum',$this->mayor1_serum);
		$criteria->compare('mayor1_sel',$this->mayor1_sel);
		$criteria->compare('mayor2_serum',$this->mayor2_serum);
		$criteria->compare('mayor2_sel',$this->mayor2_sel);
		$criteria->compare('mayor3_serum',$this->mayor3_serum);
		$criteria->compare('mayor3_sel',$this->mayor3_sel);
		$criteria->compare('mayor4_serum',$this->mayor4_serum);
		$criteria->compare('mayor4_sel',$this->mayor4_sel);
		$criteria->compare('minor1_plasma',$this->minor1_plasma);
		$criteria->compare('minor1_sel',$this->minor1_sel);
		$criteria->compare('minor2_plasma',$this->minor2_plasma);
		$criteria->compare('minor2_sel',$this->minor2_sel);
		$criteria->compare('minor3_plasma',$this->minor3_plasma);
		$criteria->compare('minor3_sel',$this->minor3_sel);
		$criteria->compare('minor4_plasma',$this->minor4_plasma);
		$criteria->compare('minor4_sel',$this->minor4_sel);
		$criteria->compare('ac_serum',$this->ac_serum);
		$criteria->compare('ac_sel',$this->ac_sel);
		$criteria->compare('pool1_plasma',$this->pool1_plasma);
		$criteria->compare('pool1_sel',$this->pool1_sel);
		$criteria->compare('pool2_plasma',$this->pool2_plasma);
		$criteria->compare('pool2_sel',$this->pool2_sel);
		$criteria->compare('jam_pemeriksaancocokserasi',$this->jam_pemeriksaancocokserasi,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);
		$criteria->compare('create_time',$this->create_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return HasilujicocokserasiT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
