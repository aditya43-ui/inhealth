<?php

/**
 * This is the model class for table "pengambilanobat_triage_t".
 *
 * The followings are the available columns in table 'pengambilanobat_triage_t':
 * @property integer $pengambilanobat_triage_id
 * @property integer $notriage_pasien_id
 * @property string $noresep_triage
 * @property integer $petugasfarmasi_id
 * @property integer $petugasigd_id
 * @property integer $obatalkes_id
 * @property integer $jumlah
 * @property boolean $validasi
 * @property string $keterangan
 * @property integer $pendaftaran_id
 * @property string $create_time
 * @property string $update_time
 */
class PengambilanobatTriageT extends CActiveRecord
{
	public $no_triage, $harga_satuanpakai, $biayaadministrasi, $hargasatuan_oa, $total_embalase, $totalbiayaadministrasi;
	public $create_time, $petugasfarmasi_nama, $petugasigd_nama, $tgl_resep, $obatalkes_nama, $nobed_triage, $nama_pasien;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pengambilanobat_triage_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('notriage_pasien_id, noresep_triage, petugasfarmasi_id, create_time', 'required'),
			array('pengambilanobat_triage_id, notriage_pasien_id, petugasfarmasi_id, petugasigd_id, obatalkes_id, pendaftaran_id', 'numerical', 'integerOnly'=>true),
			array('noresep_triage', 'length', 'max'=>50),
			array('validasi, update_time, petugas_pengambil_obat, jumlah', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pengambilanobat_triage_id, notriage_pasien_id, noresep_triage, petugasfarmasi_id, petugasigd_id, obatalkes_id, jumlah, validasi, keterangan, pendaftaran_id, create_time, update_time', 'safe', 'on'=>'search'),
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
			'obatalkes' => array(self::BELONGS_TO, 'ObatalkesM', 'obatalkes_id'),
			'petugasfarmasi' => array(self::BELONGS_TO, 'PegawaiM', 'petugasfarmasi_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'notriage' => array(self::BELONGS_TO, 'NotriagePasienT', 'notriage_pasien_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pengambilanobat_triage_id' => 'Pengambilanobat Triage',
			'notriage_pasien_id' => 'Notriage Pasien',
			'noresep_triage' => 'Noresep Triage',
			'petugasfarmasi_id' => 'Petugas Farmasi',
			'petugasigd_id' => 'Petugas Pengambil Obat',
			'obatalkes_id' => 'Obatalkes',
			'jumlah' => 'Jumlah',
			'validasi' => 'Validasi',
			'keterangan' => 'Keterangan',
			'pendaftaran_id' => 'Pendaftaran',
			'create_time' => 'Waktu Buat',
			'update_time' => 'Update Time',
			'petugas_pengambil_obat' => 'Petugas Pengambil Obat'
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

		$criteria->compare('pengambilanobat_triage_id',$this->pengambilanobat_triage_id);
		$criteria->compare('notriage_pasien_id',$this->notriage_pasien_id);
		$criteria->compare('noresep_triage',$this->noresep_triage,true);
		$criteria->compare('petugasfarmasi_id',$this->petugasfarmasi_id);
		$criteria->compare('petugasigd_id',$this->petugasigd_id);
		$criteria->compare('obatalkes_id',$this->obatalkes_id);
		$criteria->compare('jumlah',$this->jumlah);
		$criteria->compare('validasi',$this->validasi);
		$criteria->compare('keterangan',$this->keterangan,true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PengambilanobatTriageT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

