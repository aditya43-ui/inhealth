<?php

/**
 * This is the model class for table "suratakadijarah_t".
 *
 * The followings are the available columns in table 'suratakadijarah_t':
 * @property integer $suratakadijarah_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $penanggungjawab_id
 * @property string $nama_pj
 * @property string $umur_pj
 * @property string $jeniskelamin_pj
 * @property string $pekerjaan_pj
 * @property string $alamat_pj
 * @property string $no_telponpj
 * @property string $jenisidentitas_pj
 * @property string $no_identitas
 * @property string $hubungankeluarga
 * @property string $nama_pasien
 * @property string $umur_pasien
 * @property string $jeniskelamin
 * @property string $alamat_pasien
 * @property string $jenisidentitas
 * @property string $no_identitas_pasien
 * @property string $tgl_masuk
 * @property string $diagnosa_nama
 * @property string $no_rekam_medik
 * @property integer $rencana_uangmuka
 * @property integer $tambah_uangmuka
 * @property string $tgl_tambahuangmuka
 * @property integer $ruang_id
 * @property integer $dokter_dpjp1
 * @property string $tgl_persetujuan
 */
class SuratakadijarahT extends CActiveRecord
{
        public $carabayar_nama;
        public $pihakpertama, $pihakkedua;
        public $noteleponpasien, $kelaspelayanan_nama, $ruangan_nama, $doktermerawat;
        public $tgladmisi, $kamarruangan_nama;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'suratakadijarah_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, pendaftaran_id, penanggungjawab_id, rencana_uangmuka, tambah_uangmuka, ruang_id, dokter_dpjp1', 'numerical', 'integerOnly'=>true),
			array('nama_pj, nama_pasien, diagnosa_nama', 'length', 'max'=>100),
			array('umur_pj, umur_pasien, no_identitas_pasien', 'length', 'max'=>30),
			array('jeniskelamin_pj, jenisidentitas_pj, jeniskelamin, jenisidentitas', 'length', 'max'=>20),
			array('pekerjaan_pj, no_identitas', 'length', 'max'=>50),
			array('no_telponpj', 'length', 'max'=>15),
			array('hubungankeluarga', 'length', 'max'=>51),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('namapegawai_id, alamat_pj, alamat_pasien, tgl_masuk, tgl_tambahuangmuka, tgl_persetujuan, catatanpenting', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('suratakadijarah_id, pasien_id, pendaftaran_id, penanggungjawab_id, nama_pj, umur_pj, jeniskelamin_pj, pekerjaan_pj, alamat_pj, no_telponpj, jenisidentitas_pj, no_identitas, hubungankeluarga, nama_pasien, umur_pasien, jeniskelamin, alamat_pasien, jenisidentitas, no_identitas_pasien, tgl_masuk, diagnosa_nama, no_rekam_medik, rencana_uangmuka, tambah_uangmuka, tgl_tambahuangmuka, ruang_id, dokter_dpjp1, tgl_persetujuan, catatanpenting', 'safe', 'on'=>'search'),
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
                    'pendaftaran' => [self::BELONGS_TO,'PendaftaranT','pendaftaran_id'],
                    'ruangan' => [self::BELONGS_TO,'RuanganM','ruang_id'],
                    'dokterdpjp1' => [self::BELONGS_TO,'PegawaiM','dokter_dpjp1'],
                    'pegawai' => [self::BELONGS_TO,'PegawaiM','namapegawai_id'],
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'suratakadijarah_id' => 'Suratakadijarah',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'penanggungjawab_id' => 'Penanggungjawab',
			'nama_pj' => 'Nama Pj',
			'umur_pj' => 'Umur Pj',
			'jeniskelamin_pj' => 'Jeniskelamin Pj',
			'pekerjaan_pj' => 'Pekerjaan Pj',
			'alamat_pj' => 'Alamat Pj',
			'no_telponpj' => 'No Telponpj',
			'jenisidentitas_pj' => 'Jenisidentitas Pj',
			'no_identitas' => 'No Identitas',
			'hubungankeluarga' => 'Hubungankeluarga',
			'nama_pasien' => 'Nama Pasien',
			'umur_pasien' => 'Umur Pasien',
			'jeniskelamin' => 'Jeniskelamin',
			'alamat_pasien' => 'Alamat Pasien',
			'jenisidentitas' => 'Jenisidentitas',
			'no_identitas_pasien' => 'No Identitas Pasien',
			'tgl_masuk' => 'Tgl Masuk',
			'diagnosa_nama' => 'Diagnosa Nama',
			'no_rekam_medik' => 'No Rekam Medik',
			'rencana_uangmuka' => 'Rencana Uangmuka',
			'tambah_uangmuka' => 'Tambah Uangmuka',
			'tgl_tambahuangmuka' => 'Tgl Tambahuangmuka',
			'ruang_id' => 'Ruang',
			'dokter_dpjp1' => 'Dokter Dpjp1',
			'tgl_persetujuan' => 'Tgl Persetujuan',
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

		$criteria->compare('suratakadijarah_id',$this->suratakadijarah_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('penanggungjawab_id',$this->penanggungjawab_id);
		$criteria->compare('nama_pj',$this->nama_pj,true);
		$criteria->compare('umur_pj',$this->umur_pj,true);
		$criteria->compare('jeniskelamin_pj',$this->jeniskelamin_pj,true);
		$criteria->compare('pekerjaan_pj',$this->pekerjaan_pj,true);
		$criteria->compare('alamat_pj',$this->alamat_pj,true);
		$criteria->compare('no_telponpj',$this->no_telponpj,true);
		$criteria->compare('jenisidentitas_pj',$this->jenisidentitas_pj,true);
		$criteria->compare('no_identitas',$this->no_identitas,true);
		$criteria->compare('hubungankeluarga',$this->hubungankeluarga,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('umur_pasien',$this->umur_pasien,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('alamat_pasien',$this->alamat_pasien,true);
		$criteria->compare('jenisidentitas',$this->jenisidentitas,true);
		$criteria->compare('no_identitas_pasien',$this->no_identitas_pasien,true);
		$criteria->compare('tgl_masuk',$this->tgl_masuk,true);
		$criteria->compare('diagnosa_nama',$this->diagnosa_nama,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('rencana_uangmuka',$this->rencana_uangmuka);
		$criteria->compare('tambah_uangmuka',$this->tambah_uangmuka);
		$criteria->compare('tgl_tambahuangmuka',$this->tgl_tambahuangmuka,true);
		$criteria->compare('ruang_id',$this->ruang_id);
		$criteria->compare('dokter_dpjp1',$this->dokter_dpjp1);
		$criteria->compare('tgl_persetujuan',$this->tgl_persetujuan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SuratakadijarahT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public static function simpanData($model, $post){
            
            $pesan = '';
            $ok = true;
            
            $model->attributes = $post;
            $model->tgl_tambahuangmuka = !empty($model->tgl_tambahuangmuka)?MyFormatter::formatDateTimeForDb($model->tgl_tambahuangmuka):null;
            $model->tgl_masuk = !empty($model->tgl_masuk)?MyFormatter::formatDateTimeForDb($model->tgl_masuk):null;
            $model->tgl_persetujuan = !empty($model->tgl_persetujuan)?MyFormatter::formatDateTimeForDb($model->tgl_persetujuan):null;            
            
            $ok &= $model->save();
            
            if (!$ok){
                $pesan .= 'Data surat akad ijarah gagal disimpan '.MyExceptionMessage::getErrorMessage($model);
            }
            
            
            return [
                'model'=>$model,
                'pesan'=>$pesan,
                'sukses'=>$ok
            ];                        
        }
        
        public function loadInput(){            
            $admisi = PasienadmisiT::model()->findByPk($this->pendaftaran->pasienadmisi_id);
            
            $this->kelaspelayanan_nama = $admisi->kelaspelayanan->kelaspelayanan_nama;
            $this->ruangan_nama = $admisi->ruangan->ruangan_nama;
            $this->kamarruangan_nama = !empty($admisi->kamarruangan)?$admisi->kamarruangan->kamarruangan_nokamar:'-';
            $this->doktermerawat = $this->dokterdpjp1->namaLengkap;
            $this->carabayar_nama = $admisi->carabayar->carabayar_nama;
            
            $peg = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
            $this->pihakpertama = (!empty($this->pegawa->namaLengkap))?$this->pegawa->namaLengkap:$peg->namaLengkap;
            $this->pihakkedua = $this->nama_pj;
        }
}
