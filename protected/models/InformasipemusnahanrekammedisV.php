<?php

/**
 * This is the model class for table "informasipemusnahanrekammedis_v".
 * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @package application.models
 * @category model
 * The followings are the available columns in table 'informasipemusnahanrekammedis_v':
 * @property integer $pemusnahanrekammedis_id
 * @property string $nopemusnahanrekammedis
 * @property string $tglpemusnahanrekammedis
 * @property integer $pegawai_id
 * @property string $nama_pegawai
 * @property integer $penanggungjawab_id
 * @property string $penanggungjawab_nama
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $nama_pasien
 * @property string $tanggal_lahir
 * @property string $jeniskelamin
 * @property string $alamat_pasien
 * @property string $tglkunjunganterakhir
 * @property string $masafungsirm
 */
class InformasipemusnahanrekammedisV extends CActiveRecord
{
        public $tgl_awal,$tgl_akhir,$no_rekam_medis,$tgl_lahir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasipemusnahanrekammedisV the static model class
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
		return 'informasipemusnahanrekammedis_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pemusnahanrekammedis_id, pegawai_id, penanggungjawab_id, pasien_id', 'numerical', 'integerOnly'=>true),
			array('nopemusnahanrekammedis, jeniskelamin, masafungsirm', 'length', 'max'=>20),
			array('nama_pegawai, penanggungjawab_nama, nama_pasien', 'length', 'max'=>50),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('tglpemusnahanrekammedis, tanggal_lahir, alamat_pasien, tglkunjunganterakhir', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pemusnahanrekammedis_id, nopemusnahanrekammedis, tglpemusnahanrekammedis, pegawai_id, nama_pegawai, penanggungjawab_id, penanggungjawab_nama, pasien_id, no_rekam_medik, nama_pasien, tanggal_lahir, jeniskelamin, alamat_pasien, tglkunjunganterakhir, masafungsirm', 'safe', 'on'=>'search'),
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
			'pemusnahanrekammedis_id' => 'Pemusnahanrekammedis',
			'nopemusnahanrekammedis' => 'Nopemusnahanrekammedis',
			'tglpemusnahanrekammedis' => 'Tglpemusnahanrekammedis',
			'pegawai_id' => 'Pegawai',
			'nama_pegawai' => 'Nama Pegawai',
			'penanggungjawab_id' => 'Penanggungjawab',
			'penanggungjawab_nama' => 'Penanggungjawab Nama',
			'pasien_id' => 'Pasien',
			'no_rekam_medik' => 'No. Rekam Medik',
			'nama_pasien' => 'Nama Pasien',
			'tanggal_lahir' => 'Tanggal Lahir',
			'jeniskelamin' => 'Jenis Kelamin',
			'alamat_pasien' => 'Alamat Pasien',
			'tglkunjunganterakhir' => 'Tglkunjunganterakhir',
			'masafungsirm' => 'Masafungsirm',
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

		$criteria->compare('pemusnahanrekammedis_id',$this->pemusnahanrekammedis_id);
		$criteria->compare('LOWER(nopemusnahanrekammedis)',strtolower($this->nopemusnahanrekammedis),true);
		$criteria->compare('tglpemusnahanrekammedis',$this->tglpemusnahanrekammedis,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('penanggungjawab_id',$this->penanggungjawab_id);
		$criteria->compare('penanggungjawab_nama',$this->penanggungjawab_nama,true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('tanggal_lahir',$this->tanggal_lahir,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('alamat_pasien',$this->alamat_pasien,true);
		$criteria->compare('tglkunjunganterakhir',$this->tglkunjunganterakhir,true);
		$criteria->compare('masafungsirm',$this->masafungsirm,true);
                $criteria->addBetweenCondition('date(tglpemusnahanrekammedis)', $this->tgl_awal, $this->tgl_akhir);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}