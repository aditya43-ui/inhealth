<?php

/**
 * This is the model class for table "suratpersetujuanrdokter_t".
 *
 * The followings are the available columns in table 'suratpersetujuanrdokter_t':
 * @property integer $suratpersetujuanrdokter_id
 * @property string $tgl_persetujuan
 * @property integer $pendaftaran_id
 * @property string $pasien_nama
 * @property string $pasien_jeniskelamin
 * @property string $pasien_tanggal_lahir
 * @property string $pasien_no_rekam_medik
 * @property string $pasien_tglmasukrs
 * @property string $dokterpenanggungjawab
 * @property string $tandatangan_nama
 * @property string $tandatangan_telepon
 * @property string $tandatangan_hubungan
 * @property string $penanggung_jawab_biaya_nama
 * @property string $penanggung_jawab_biaya_telepon
 * @property string $privasi
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 */
class SuratpersetujuanrdokterT extends CActiveRecord
{
        public $penjamin_nama, $create_loginpemakai_nama;
        public $kamarruangan_nokamar, $umur;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'suratpersetujuanrdokter_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tgl_persetujuan', 'required'),
			array('pendaftaran_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id', 'numerical', 'integerOnly'=>true),
			array('pasien_nama, pasien_jeniskelamin, pasien_tanggal_lahir, pasien_no_rekam_medik, pasien_tglmasukrs, dokterpenanggungjawab, tandatangan_nama, tandatangan_telepon, tandatangan_hubungan, penanggung_jawab_biaya_nama, penanggung_jawab_biaya_telepon, privasi', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('suratpersetujuanrdokter_id, tgl_persetujuan, pendaftaran_id, pasien_nama, pasien_jeniskelamin, pasien_tanggal_lahir, pasien_no_rekam_medik, pasien_tglmasukrs, dokterpenanggungjawab, tandatangan_nama, tandatangan_telepon, tandatangan_hubungan, penanggung_jawab_biaya_nama, penanggung_jawab_biaya_telepon, privasi, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id', 'safe', 'on'=>'search'),
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
                    'createlogin' => [self::BELONGS_TO,'LoginpemakaiK','create_loginpemakai_id'],
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'suratpersetujuanrdokter_id' => 'Suratpersetujuanrdokter',
			'tgl_persetujuan' => 'Tgl Persetujuan',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_nama' => 'Pasien Nama',
			'pasien_jeniskelamin' => 'Pasien Jeniskelamin',
			'pasien_tanggal_lahir' => 'Pasien Tanggal Lahir',
			'pasien_no_rekam_medik' => 'Pasien No Rekam Medik',
			'pasien_tglmasukrs' => 'Pasien Tglmasukrs',
			'dokterpenanggungjawab' => 'Dokterpenanggungjawab',
			'tandatangan_nama' => 'Tandatangan Nama',
			'tandatangan_telepon' => 'Tandatangan Telepon',
			'tandatangan_hubungan' => 'Tandatangan Hubungan',
			'penanggung_jawab_biaya_nama' => 'Penanggung Jawab Biaya Nama',
			'penanggung_jawab_biaya_telepon' => 'Penanggung Jawab Biaya Telepon',
			'privasi' => 'Privasi',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
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

		$criteria->compare('suratpersetujuanrdokter_id',$this->suratpersetujuanrdokter_id);
		$criteria->compare('tgl_persetujuan',$this->tgl_persetujuan,true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_nama',$this->pasien_nama,true);
		$criteria->compare('pasien_jeniskelamin',$this->pasien_jeniskelamin,true);
		$criteria->compare('pasien_tanggal_lahir',$this->pasien_tanggal_lahir,true);
		$criteria->compare('pasien_no_rekam_medik',$this->pasien_no_rekam_medik,true);
		$criteria->compare('pasien_tglmasukrs',$this->pasien_tglmasukrs,true);
		$criteria->compare('dokterpenanggungjawab',$this->dokterpenanggungjawab,true);
		$criteria->compare('tandatangan_nama',$this->tandatangan_nama,true);
		$criteria->compare('tandatangan_telepon',$this->tandatangan_telepon,true);
		$criteria->compare('tandatangan_hubungan',$this->tandatangan_hubungan,true);
		$criteria->compare('penanggung_jawab_biaya_nama',$this->penanggung_jawab_biaya_nama,true);
		$criteria->compare('penanggung_jawab_biaya_telepon',$this->penanggung_jawab_biaya_telepon,true);
		$criteria->compare('privasi',$this->privasi,true);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('update_time',$this->update_time);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SuratpersetujuanrdokterT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public static function simpanData($model, $post){
            $format = new MyFormatter;
            $ok = true;
            $pesan = '';
            
            $model->attributes = $post;
            $model->tgl_persetujuan = !empty($model->tgl_persetujuan)?$format->formatDateTimeForDb($model->tgl_persetujuan):null;
            $model->pasien_tglmasukrs = !empty($model->pasien_tglmasukrs)?$format->formatDateTimeForDb($model->pasien_tglmasukrs):null;
            $model->pasien_tanggal_lahir = !empty($model->pasien_tanggal_lahir)?$format->formatDateTimeForDb($model->pasien_tanggal_lahir):null;
            
            if (empty($model->suratpersetujuanrdokter_id)){
                $model->create_time = strtotime(date('Y-m-d H:i:s'));
                $model->create_loginpemakai_id  = Yii::app()->user->getState('loginpemakai_id');
            }else{
                $model->update_time = strtotime(date('Y-m-d H:i:s'));
                $model->update_loginpemakai_id  = Yii::app()->user->getState('loginpemakai_id');
            }                        
            
            $ok &= $model->save();
            
            if (!$ok){
                $pesan .= 'Data surat persetujuan dokter gagal disimpan '.MyExceptionMessage::getErrorMessage($model);
            }
            
            return [
                'model'=>$model,
                'pesan'=>$pesan,
                'sukses'=>$ok
            ];     
        }
        
        public function loadInput(){
            $this->create_loginpemakai_nama = !empty($this->createlogin->pegawai)?$this->createlogin->pegawai->namaLengkap:'';
            $this->kamarruangan_nokamar = !empty($this->pendaftaran->pasienadmisi->kamarruangan)?$this->pendaftaran->pasienadmisi->kamarruangan->kamarruangan_nokamar:'-';
        }
}
