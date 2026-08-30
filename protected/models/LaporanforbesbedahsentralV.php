<?php

/**
 * This is the model class for table "laporanforbesbedahsentral_v".
 *
 * The followings are the available columns in table 'laporanforbesbedahsentral_v':
 * @property integer $rencanaoperasi_id
 * @property string $tglrencanaoperasi
 * @property string $norencanaoperasi
 * @property integer $kamarruangan_id
 * @property string $kamarruangan_nokamar
 * @property string $jam_mulai
 * @property string $jam_selesai
 * @property integer $pasien_id
 * @property string $nama_pasien
 * @property string $jeniskelamin
 * @property double $umur
 * @property string $no_rekam_medik
 * @property integer $ruanganasal_id
 * @property string $ruanganasal_nama
 * @property integer $diagnosa_id
 * @property string $diagnosa_nama
 * @property integer $operasi_id
 * @property string $operasi_nama
 * @property integer $jeniskasuspenyakit_id
 * @property string $jeniskasuspenyakit_nama
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property integer $dpjp_id
 * @property string $dpjp_nama
 * @property string $residen
 * @property string $jenisanestesi
 * @property string $lama_op
 * @property string $keterangan_rencana
 */
class LaporanforbesbedahsentralV extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'laporanforbesbedahsentral_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rencanaoperasi_id, kamarruangan_id, pasien_id, ruanganasal_id, diagnosa_id, operasi_id, jeniskasuspenyakit_id, kelaspelayanan_id, dpjp_id', 'numerical', 'integerOnly'=>true),
			array('umur', 'numerical'),
			array('norencanaoperasi, kelaspelayanan_nama, dpjp_nama', 'length', 'max'=>50),
			array('kamarruangan_nokamar, nama_pasien, ruanganasal_nama, jeniskasuspenyakit_nama', 'length', 'max'=>100),
			array('jeniskelamin', 'length', 'max'=>20),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('diagnosa_nama, operasi_nama, jenisanestesi', 'length', 'max'=>200),
			array('tglrencanaoperasi, jam_mulai, jam_selesai, residen, lama_op, keterangan_rencana', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('rencanaoperasi_id, tglrencanaoperasi, norencanaoperasi, kamarruangan_id, kamarruangan_nokamar, jam_mulai, jam_selesai, pasien_id, nama_pasien, jeniskelamin, umur, no_rekam_medik, ruanganasal_id, ruanganasal_nama, diagnosa_id, diagnosa_nama, operasi_id, operasi_nama, jeniskasuspenyakit_id, jeniskasuspenyakit_nama, kelaspelayanan_id, kelaspelayanan_nama, dpjp_id, dpjp_nama, residen, jenisanestesi, lama_op, keterangan_rencana', 'safe', 'on'=>'search'),
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
			'rencanaoperasi_id' => 'Rencanaoperasi',
			'tglrencanaoperasi' => 'Tglrencanaoperasi',
			'norencanaoperasi' => 'Norencanaoperasi',
			'kamarruangan_id' => 'Kamarruangan',
			'kamarruangan_nokamar' => 'Kamarruangan Nokamar',
			'jam_mulai' => 'Jam Mulai',
			'jam_selesai' => 'Jam Selesai',
			'pasien_id' => 'Pasien',
			'nama_pasien' => 'Nama Pasien',
			'jeniskelamin' => 'Jeniskelamin',
			'umur' => 'Umur',
			'no_rekam_medik' => 'No Rekam Medik',
			'ruanganasal_id' => 'Ruanganasal',
			'ruanganasal_nama' => 'Ruanganasal Nama',
			'diagnosa_id' => 'Diagnosa',
			'diagnosa_nama' => 'Diagnosa Nama',
			'operasi_id' => 'Operasi',
			'operasi_nama' => 'Operasi Nama',
			'jeniskasuspenyakit_id' => 'Jeniskasuspenyakit',
			'jeniskasuspenyakit_nama' => 'Jeniskasuspenyakit Nama',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'kelaspelayanan_nama' => 'Kelaspelayanan Nama',
			'dpjp_id' => 'Dpjp',
			'dpjp_nama' => 'Dpjp Nama',
			'residen' => 'Residen',
			'jenisanestesi' => 'Jenisanestesi',
			'lama_op' => 'Lama Op',
			'keterangan_rencana' => 'Keterangan Rencana',
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

		$criteria->compare('rencanaoperasi_id',$this->rencanaoperasi_id);
		$criteria->compare('tglrencanaoperasi',$this->tglrencanaoperasi,true);
		$criteria->compare('norencanaoperasi',$this->norencanaoperasi,true);
		$criteria->compare('kamarruangan_id',$this->kamarruangan_id);
		$criteria->compare('kamarruangan_nokamar',$this->kamarruangan_nokamar,true);
		$criteria->compare('jam_mulai',$this->jam_mulai,true);
		$criteria->compare('jam_selesai',$this->jam_selesai,true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('umur',$this->umur);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('ruanganasal_id',$this->ruanganasal_id);
		$criteria->compare('ruanganasal_nama',$this->ruanganasal_nama,true);
		$criteria->compare('diagnosa_id',$this->diagnosa_id);
		$criteria->compare('diagnosa_nama',$this->diagnosa_nama,true);
		$criteria->compare('operasi_id',$this->operasi_id);
		$criteria->compare('operasi_nama',$this->operasi_nama,true);
		$criteria->compare('jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('jeniskasuspenyakit_nama',$this->jeniskasuspenyakit_nama,true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('kelaspelayanan_nama',$this->kelaspelayanan_nama,true);
		$criteria->compare('dpjp_id',$this->dpjp_id);
		$criteria->compare('dpjp_nama',$this->dpjp_nama,true);
		$criteria->compare('residen',$this->residen,true);
		$criteria->compare('jenisanestesi',$this->jenisanestesi,true);
		$criteria->compare('lama_op',$this->lama_op,true);
		$criteria->compare('keterangan_rencana',$this->keterangan_rencana,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchLaporan()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('rencanaoperasi_id',$this->rencanaoperasi_id);
		$criteria->compare('norencanaoperasi',$this->norencanaoperasi,true);
		$criteria->compare('kamarruangan_id',$this->kamarruangan_id);
		$criteria->compare('LOWER(kamarruangan_nobed)', strtolower($this->kamarruangan_nobed),true);

		if(!empty($this->jam_mulai)) {
			$criteria->addCondition("jam_mulai = '$this->jam_mulai'");
		}

		if(!empty($this->tglrencanaoperasi)) {
			$criteria->addCondition("DATE(tglrencanaoperasi) = '" . MyFormatter::formatDateTimeForDb($this->tglrencanaoperasi) . "'");
		}

		$criteria->compare('jam_selesai',$this->jam_selesai,true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('umur',$this->umur);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('ruanganasal_id',$this->ruanganasal_id);
		$criteria->compare('LOWER(ruanganasal_nama)', strtolower($this->ruanganasal_nama),true);
		$criteria->compare('diagnosa_id',$this->diagnosa_id);
		$criteria->compare('LOWER(diagnosa_nama)',strtolower($this->diagnosa_nama),true);
		$criteria->compare('operasi_id',$this->operasi_id);
		$criteria->compare('LOWER(operasi_nama)', strtolower($this->operasi_nama),true);
		$criteria->compare('jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)', strtolower($this->jeniskasuspenyakit_nama),true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('kelaspelayanan_nama',$this->kelaspelayanan_nama,true);
		$criteria->compare('dpjp_id',$this->dpjp_id);
		$criteria->compare('dpjp_nama',$this->dpjp_nama,true);
		$criteria->compare('residen',$this->residen,true);
		$criteria->compare('jenisanestesi',$this->jenisanestesi,true);
		$criteria->compare('lama_op',$this->lama_op,true);
		$criteria->compare('keterangan_rencana',$this->keterangan_rencana,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchLaporanCrit()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('rencanaoperasi_id',$this->rencanaoperasi_id);
		$criteria->compare('norencanaoperasi',$this->norencanaoperasi,true);
		$criteria->compare('kamarruangan_id',$this->kamarruangan_id);
		$criteria->compare('LOWER(kamarruangan_nokamar)', strtolower($this->kamarruangan_nokamar),true);

		if(!empty($this->jam_mulai)) {
			$criteria->addCondition("jam_mulai = '$this->jam_mulai'");
		}

		if(!empty($this->tglrencanaoperasi)) {
			$criteria->addCondition("DATE(tglrencanaoperasi) = '" . MyFormatter::formatDateTimeForDb($this->tglrencanaoperasi) . "'");
		}

		$criteria->compare('jam_selesai',$this->jam_selesai,true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('umur',$this->umur);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('ruanganasal_id',$this->ruanganasal_id);
		$criteria->compare('LOWER(ruanganasal_nama)', strtolower($this->ruanganasal_nama),true);
		$criteria->compare('diagnosa_id',$this->diagnosa_id);
		$criteria->compare('LOWER(diagnosa_nama)',strtolower($this->diagnosa_nama),true);
		$criteria->compare('operasi_id',$this->operasi_id);
		$criteria->compare('LOWER(operasi_nama)', strtolower($this->operasi_nama),true);
		$criteria->compare('jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)', strtolower($this->jeniskasuspenyakit_nama),true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('kelaspelayanan_nama',$this->kelaspelayanan_nama,true);
		$criteria->compare('dpjp_id',$this->dpjp_id);
		$criteria->compare('dpjp_nama',$this->dpjp_nama,true);
		$criteria->compare('residen',$this->residen,true);
		$criteria->compare('jenisanestesi',$this->jenisanestesi,true);
		$criteria->compare('lama_op',$this->lama_op,true);
		$criteria->compare('keterangan_rencana',$this->keterangan_rencana,true);

		return $criteria;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LaporanforbesbedahsentralV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
