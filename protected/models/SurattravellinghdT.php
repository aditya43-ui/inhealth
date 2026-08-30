<?php

/**
 * This is the model class for table "surattravellinghd_t".
 *
 * The followings are the available columns in table 'surattravellinghd_t':
 * @property integer $travellinghd_id
 * @property string $no_pendaftaran
 * @property string $no_rekam_medik
 * @property string $nama_pasien
 * @property string $umur_pasien
 * @property boolean $jk_pr
 * @property boolean $jk_lk
 * @property string $alamat_pasien
 * @property string $diagnosa_nama
 * @property string $hd_pertama
 * @property string $hd_terakhir
 * @property string $dialiser
 * @property boolean $bicarbonate
 * @property boolean $asetat
 * @property boolean $minggu_1x
 * @property boolean $minggu_2x
 * @property boolean $minggu_3x
 * @property boolean $menit_300ml
 * @property boolean $menit_400ml
 * @property boolean $menit_500ml
 * @property boolean $kecepatanmenit_150ml
 * @property boolean $kecepatanmenit_249ml
 * @property boolean $kecepatanmenit_250ml
 * @property boolean $tigajam
 * @property boolean $empatjam
 * @property boolean $limajam
 * @property boolean $femoral
 * @property boolean $av_fistula
 * @property boolean $catlumen_lugular
 * @property boolean $catlumen_subclavia
 * @property boolean $catlumen_femoral
 * @property integer $heparinisasi
 * @property integer $dosis
 * @property boolean $unit_perjam
 * @property boolean $tanpa_heparin
 * @property boolean $lmwh
 * @property integer $tensi_sistolik
 * @property integer $tensi_diastolik
 * @property string $hasil_lab
 * @property integer $bb_kering
 * @property integer $kenaikan_bb
 * @property string $masalah_seringterjadi
 * @property string $obat
 * @property string $tanggal
 * @property integer $dpjp_id
 * @property integer $perawat1_id
 * @property integer $perawat2_id
 *
 * The followings are the available model relations:
 * @property PegawaiM $dpjp
 * @property PegawaiM $perawat1
 * @property PegawaiM $perawat2
 */
class SurattravellinghdT extends CActiveRecord
{
        public $perawat1_nama, $perawat2_nama;
        public $dpjp_nama;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'surattravellinghd_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('heparinisasi, dosis, tensi_sistolik, tensi_diastolik, bb_kering, kenaikan_bb, dpjp_id, perawat1_id, perawat2_id', 'numerical', 'integerOnly'=>true),
			array('no_pendaftaran', 'length', 'max'=>20),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('nama_pasien', 'length', 'max'=>50),
			array('umur_pasien', 'length', 'max'=>30),
			array('diagnosa_nama', 'length', 'max'=>100),
			array('jk_pr, jk_lk, alamat_pasien, hd_pertama, hd_terakhir, dialiser, bicarbonate, asetat, minggu_1x, minggu_2x, minggu_3x, menit_300ml, menit_400ml, menit_500ml, kecepatanmenit_150ml, kecepatanmenit_249ml, kecepatanmenit_250ml, tigajam, empatjam, limajam, femoral, av_fistula, catlumen_lugular, catlumen_subclavia, catlumen_femoral, unit_perjam, tanpa_heparin, lmwh, hasil_lab, masalah_seringterjadi, obat, tanggal', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('travellinghd_id, no_pendaftaran, no_rekam_medik, nama_pasien, umur_pasien, jk_pr, jk_lk, alamat_pasien, diagnosa_nama, hd_pertama, hd_terakhir, dialiser, bicarbonate, asetat, minggu_1x, minggu_2x, minggu_3x, menit_300ml, menit_400ml, menit_500ml, kecepatanmenit_150ml, kecepatanmenit_249ml, kecepatanmenit_250ml, tigajam, empatjam, limajam, femoral, av_fistula, catlumen_lugular, catlumen_subclavia, catlumen_femoral, heparinisasi, dosis, unit_perjam, tanpa_heparin, lmwh, tensi_sistolik, tensi_diastolik, hasil_lab, bb_kering, kenaikan_bb, masalah_seringterjadi, obat, tanggal, dpjp_id, perawat1_id, perawat2_id', 'safe', 'on'=>'search'),
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
			'dpjp' => array(self::BELONGS_TO, 'PegawaiM', 'dpjp_id'),
			'perawat1' => array(self::BELONGS_TO, 'PegawaiM', 'perawat1_id'),
			'perawat2' => array(self::BELONGS_TO, 'PegawaiM', 'perawat2_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'travellinghd_id' => 'Travellinghd',
			'no_pendaftaran' => 'No Pendaftaran',
			'no_rekam_medik' => 'No Rekam Medik',
			'nama_pasien' => 'Nama Pasien',
			'umur_pasien' => 'Umur Pasien',
			'jk_pr' => 'Jk Pr',
			'jk_lk' => 'Jk Lk',
			'alamat_pasien' => 'Alamat Pasien',
			'diagnosa_nama' => 'Diagnosa Nama',
			'hd_pertama' => 'Hd Pertama',
			'hd_terakhir' => 'Hd Terakhir',
			'dialiser' => 'Dialiser',
			'bicarbonate' => 'Bicarbonate',
			'asetat' => 'Asetat',
			'minggu_1x' => 'Minggu 1x',
			'minggu_2x' => 'Minggu 2x',
			'minggu_3x' => 'Minggu 3x',
			'menit_300ml' => 'Menit 300ml',
			'menit_400ml' => 'Menit 400ml',
			'menit_500ml' => 'Menit 500ml',
			'kecepatanmenit_150ml' => 'Kecepatanmenit 150ml',
			'kecepatanmenit_249ml' => 'Kecepatanmenit 249ml',
			'kecepatanmenit_250ml' => 'Kecepatanmenit 250ml',
			'tigajam' => 'Tigajam',
			'empatjam' => 'Empatjam',
			'limajam' => 'Limajam',
			'femoral' => 'Femoral',
			'av_fistula' => 'Av Fistula',
			'catlumen_lugular' => 'Catlumen Lugular',
			'catlumen_subclavia' => 'Catlumen Subclavia',
			'catlumen_femoral' => 'Catlumen Femoral',
			'heparinisasi' => 'Heparinisasi',
			'dosis' => 'Dosis',
			'unit_perjam' => 'Unit Perjam',
			'tanpa_heparin' => 'Tanpa Heparin',
			'lmwh' => 'Lmwh',
			'tensi_sistolik' => 'Tensi Sistolik',
			'tensi_diastolik' => 'Tensi Diastolik',
			'hasil_lab' => 'Hasil Lab',
			'bb_kering' => 'Bb Kering',
			'kenaikan_bb' => 'Kenaikan Bb',
			'masalah_seringterjadi' => 'Masalah Seringterjadi',
			'obat' => 'Obat',
			'tanggal' => 'Tanggal',
			'dpjp_id' => 'Dpjp',
			'perawat1_id' => 'Perawat1',
			'perawat2_id' => 'Perawat2',
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

		$criteria->compare('travellinghd_id',$this->travellinghd_id);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('umur_pasien',$this->umur_pasien,true);
		$criteria->compare('jk_pr',$this->jk_pr);
		$criteria->compare('jk_lk',$this->jk_lk);
		$criteria->compare('alamat_pasien',$this->alamat_pasien,true);
		$criteria->compare('diagnosa_nama',$this->diagnosa_nama,true);
		$criteria->compare('hd_pertama',$this->hd_pertama,true);
		$criteria->compare('hd_terakhir',$this->hd_terakhir,true);
		$criteria->compare('dialiser',$this->dialiser,true);
		$criteria->compare('bicarbonate',$this->bicarbonate);
		$criteria->compare('asetat',$this->asetat);
		$criteria->compare('minggu_1x',$this->minggu_1x);
		$criteria->compare('minggu_2x',$this->minggu_2x);
		$criteria->compare('minggu_3x',$this->minggu_3x);
		$criteria->compare('menit_300ml',$this->menit_300ml);
		$criteria->compare('menit_400ml',$this->menit_400ml);
		$criteria->compare('menit_500ml',$this->menit_500ml);
		$criteria->compare('kecepatanmenit_150ml',$this->kecepatanmenit_150ml);
		$criteria->compare('kecepatanmenit_249ml',$this->kecepatanmenit_249ml);
		$criteria->compare('kecepatanmenit_250ml',$this->kecepatanmenit_250ml);
		$criteria->compare('tigajam',$this->tigajam);
		$criteria->compare('empatjam',$this->empatjam);
		$criteria->compare('limajam',$this->limajam);
		$criteria->compare('femoral',$this->femoral);
		$criteria->compare('av_fistula',$this->av_fistula);
		$criteria->compare('catlumen_lugular',$this->catlumen_lugular);
		$criteria->compare('catlumen_subclavia',$this->catlumen_subclavia);
		$criteria->compare('catlumen_femoral',$this->catlumen_femoral);
		$criteria->compare('heparinisasi',$this->heparinisasi);
		$criteria->compare('dosis',$this->dosis);
		$criteria->compare('unit_perjam',$this->unit_perjam);
		$criteria->compare('tanpa_heparin',$this->tanpa_heparin);
		$criteria->compare('lmwh',$this->lmwh);
		$criteria->compare('tensi_sistolik',$this->tensi_sistolik);
		$criteria->compare('tensi_diastolik',$this->tensi_diastolik);
		$criteria->compare('hasil_lab',$this->hasil_lab,true);
		$criteria->compare('bb_kering',$this->bb_kering);
		$criteria->compare('kenaikan_bb',$this->kenaikan_bb);
		$criteria->compare('masalah_seringterjadi',$this->masalah_seringterjadi,true);
		$criteria->compare('obat',$this->obat,true);
		$criteria->compare('tanggal',$this->tanggal,true);
		$criteria->compare('dpjp_id',$this->dpjp_id);
		$criteria->compare('perawat1_id',$this->perawat1_id);
		$criteria->compare('perawat2_id',$this->perawat2_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SurattravellinghdT the static model class
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
            $model->hd_pertama = !empty($model->hd_pertama)?$format->formatDateTimeForDb($model->hd_pertama):null;
            $model->hd_terakhir = !empty($model->hd_terakhir)?$format->formatDateTimeForDb($model->hd_terakhir):null;
            $model->tanggal = !empty($model->tanggal)?$format->formatDateTimeForDb($model->tanggal):null;
            
            $ok &= $model->save();
            
            if (!$ok){
                $pesan .= 'surat traveling <br/>'.MyExceptionMessage::getErrorMessage($model);
            }
            
            return [
                'sukses' => $ok,
                'pesan' => $pesan,
                'model' => $model
            ];
        }
        
        public function loadInput(){
            $this->dpjp_nama = !empty($this->dpjp)?$this->dpjp->namaLengkap:null;
            $this->perawat1_nama = !empty($this->perawat1)?$this->perawat1->namaLengkap:null;
            $this->perawat2_nama = !empty($this->perawat2)?$this->perawat2->namaLengkap:null;
        }
}
    
