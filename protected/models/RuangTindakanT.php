<?php

/**
 * This is the model class for table "ruangtindakan_t".
 *
 * The followings are the available columns in table 'ruangtindakan_t':
 * @property integer $ruangtindakan_id
 * @property integer $ruangan_id
 * @property integer $daftartindakan_id
 * @property integer $pegawai_id
 * @property integer $tindakanpelayanan_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property integer $pasien_id
 * @property string $tglordertindakan
 * @property string $asalpoliklinikorder_id
 * @property string $statusperiksa
 * @property string $catatan_dokter_ordertindakan
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property string $no_antrianordertindakan
 * @property string $tglberlakuordertindakan_sd
 * @property integer $shift_id
 * @property integer $jenisdialisat_id
 * @property string $penarikan_cairan
 * @property double $lama_hd
 * @property integer $jenistransfusi_id
 * @property integer $aksesvaskular_id
 * @property string $tgljawabordertindakan
 * @property string $jawaban_tindakan
 * @property string $saran_tindakan
 * @property integer $pegawaiordertindakan_id
 * @property integer $kelaspelayanan_id
 * @property integer $jeniskasuspenyakit_id
 * @property integer $kamarruangan_id
 * @property boolean $is_verifikasi_hd
 * @property integer $sep_id
 * @property string $subjektif_jawaban
 * @property string $objektif_jawaban
 * @property string $assesment_jawaban
 * @property string $planning_jawaban
 * @property string $subjective
 * @property string $objective
 * @property string $assessment
 * @property string $planning
 */
class RuangTindakanT extends CActiveRecord
{
	public $diagnosa_id, $diagnosa_nama, $nama_pegawai;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ruangtindakan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, pendaftaran_id, pasien_id, tglordertindakan, asalpoliklinikorder_id, create_time, create_loginpemakai_id', 'required'),
			array('ruangan_id, daftartindakan_id, pegawai_id, tindakanpelayanan_id, pendaftaran_id, pasienadmisi_id, pasien_id, shift_id, jenisdialisat_id, jenistransfusi_id, aksesvaskular_id, pegawaiordertindakan_id, kelaspelayanan_id, jeniskasuspenyakit_id, kamarruangan_id, sep_id', 'numerical', 'integerOnly'=>true),
			array('lama_hd', 'numerical'),
			array('statusperiksa', 'length', 'max'=>50),
			array('no_antrianordertindakan', 'length', 'max'=>6),
			array('catatan_dokter_ordertindakan,instalasi_id, update_time, update_loginpemakai_id, create_ruangan, tglberlakuordertindakan_sd, penarikan_cairan, tgljawabordertindakan, jawaban_tindakan, saran_tindakan, is_verifikasi_hd, subjektif_jawaban, objektif_jawaban, assesment_jawaban, planning_jawaban, subjective, objective, assessment, planning', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ruangtindakan_id,instalasi_id, ruangan_id, daftartindakan_id, pegawai_id, tindakanpelayanan_id, pendaftaran_id, pasienadmisi_id, pasien_id, tglordertindakan, asalpoliklinikorder_id, statusperiksa, catatan_dokter_ordertindakan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, no_antrianordertindakan, tglberlakuordertindakan_sd, shift_id, jenisdialisat_id, penarikan_cairan, lama_hd, jenistransfusi_id, aksesvaskular_id, tgljawabordertindakan, jawaban_tindakan, saran_tindakan, pegawaiordertindakan_id, kelaspelayanan_id, jeniskasuspenyakit_id, kamarruangan_id, is_verifikasi_hd, sep_id, subjektif_jawaban, objektif_jawaban, assesment_jawaban, planning_jawaban, subjective, objective, assessment, planning', 'safe', 'on'=>'search'),
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
			'pendaftaran'=>array(self::BELONGS_TO,'PendaftaranT','pendaftaran_id'),
			'ruangasal'=>array(self::BELONGS_TO,'RuanganM','asalpoliklinikorder_id'),
			'ruangtujuan'=>array(self::BELONGS_TO,'RuanganM','ruangan_id'),
			'jenisdialisat'=>array(self::BELONGS_TO,'JenisdialisatM','jenisdialisat_id'),
			'aksesvaskular'=>array(self::BELONGS_TO,'AksesvaskularM','aksesvaskular_id'),
			'jenistransfusi'=>array(self::BELONGS_TO,'JenistransfusiM','jenistransfusi_id'),
			'pegawai'=>array(self::BELONGS_TO,'PegawaiM','pegawai_id'),                    
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ruangtindakan_id' => 'Ruangtindakan',
			'ruangan_id' => 'Ruangan',
			'instalasi_id' => 'Instalasi',
			'daftartindakan_id' => 'Daftartindakan',
			'pegawai_id' => 'Dokter',
			'tindakanpelayanan_id' => 'Tindakanpelayanan',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pasien_id' => 'Pasien',
			'tglordertindakan' => 'Tgl Order Tindakan',
			'asalpoliklinikorder_id' => 'Asal Poliklinik Order',
			'statusperiksa' => 'Statusperiksa',
			'catatan_dokter_ordertindakan' => 'Catatan Dokter Order Tindakan',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'no_antrianordertindakan' => 'No Antrianordertindakan',
			'tglberlakuordertindakan_sd' => 'Tglberlakuordertindakan Sd',
			'shift_id' => 'Shift',
			'jenisdialisat_id' => 'Jenisdialisat',
			'penarikan_cairan' => 'Penarikan Cairan',
			'lama_hd' => 'Lama Hd',
			'jenistransfusi_id' => 'Jenistransfusi',
			'aksesvaskular_id' => 'Aksesvaskular',
			'tgljawabordertindakan' => 'Tgljawabordertindakan',
			'jawaban_tindakan' => 'Jawaban Tindakan',
			'saran_tindakan' => 'Saran Tindakan',
			'pegawaiordertindakan_id' => 'Pegawaiordertindakan',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'jeniskasuspenyakit_id' => 'Jeniskasuspenyakit',
			'kamarruangan_id' => 'Kamarruangan',
			'is_verifikasi_hd' => 'Is Verifikasi Hd',
			'sep_id' => 'Sep',
			'subjektif_jawaban' => 'Subjektif Jawaban',
			'objektif_jawaban' => 'Objektif Jawaban',
			'assesment_jawaban' => 'Assesment Jawaban',
			'planning_jawaban' => 'Planning Jawaban',
			'subjective' => 'Subjective',
			'objective' => 'Objective',
			'assessment' => 'Assessment',
			'planning' => 'Planning',
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

		$criteria->compare('ruangtindakan_id',$this->ruangtindakan_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('tindakanpelayanan_id',$this->tindakanpelayanan_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('tglordertindakan',$this->tglordertindakan,true);
		$criteria->compare('asalpoliklinikorder_id',$this->asalpoliklinikorder_id,true);
		$criteria->compare('statusperiksa',$this->statusperiksa,true);
		$criteria->compare('catatan_dokter_ordertindakan',$this->catatan_dokter_ordertindakan,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('no_antrianordertindakan',$this->no_antrianordertindakan,true);
		$criteria->compare('tglberlakuordertindakan_sd',$this->tglberlakuordertindakan_sd,true);
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('jenisdialisat_id',$this->jenisdialisat_id);
		$criteria->compare('penarikan_cairan',$this->penarikan_cairan,true);
		$criteria->compare('lama_hd',$this->lama_hd);
		$criteria->compare('jenistransfusi_id',$this->jenistransfusi_id);
		$criteria->compare('aksesvaskular_id',$this->aksesvaskular_id);
		$criteria->compare('tgljawabordertindakan',$this->tgljawabordertindakan,true);
		$criteria->compare('jawaban_tindakan',$this->jawaban_tindakan,true);
		$criteria->compare('saran_tindakan',$this->saran_tindakan,true);
		$criteria->compare('pegawaiordertindakan_id',$this->pegawaiordertindakan_id);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('kamarruangan_id',$this->kamarruangan_id);
		$criteria->compare('is_verifikasi_hd',$this->is_verifikasi_hd);
		$criteria->compare('sep_id',$this->sep_id);
		$criteria->compare('subjektif_jawaban',$this->subjektif_jawaban,true);
		$criteria->compare('objektif_jawaban',$this->objektif_jawaban,true);
		$criteria->compare('assesment_jawaban',$this->assesment_jawaban,true);
		$criteria->compare('planning_jawaban',$this->planning_jawaban,true);
		$criteria->compare('subjective',$this->subjective,true);
		$criteria->compare('objective',$this->objective,true);
		$criteria->compare('assessment',$this->assessment,true);
		$criteria->compare('planning',$this->planning,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RuangTindakanT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
