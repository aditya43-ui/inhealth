<?php

/**
 * This is the model class for table "pengambilansimpanan_t".
 *
 * The followings are the available columns in table 'pengambilansimpanan_t':
 * @property integer $pengambilansimpanan_id
 * @property integer $keanggotaan_id
 * @property integer $buktikaskeluarkop_id
 * @property string $tglpengambilan
 * @property string $nopengambilan
 * @property double $jml_pokok_pengambilan
 * @property double $jml_jasa_pengambilan
 * @property double $jml_pengambilan
 * @property double $biaya_materai_peng
 * @property double $biaya_administrasi_peng
 * @property string $keterangan_pengambilan
 * @property integer $lamasimpanan_bln
 * @property integer $ambil_diperiksaoleh_id
 * @property string $ambil_diperiksa_tgl
 * @property integer $ambil_disetujuioleh_id
 * @property string $ambil_disetujui_tgl
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property BuktikaskeluarkopT $buktikaskeluarkop
 * @property KeanggotaanT $keanggotaan
 * @property SimpananT[] $simpananTs
 */
class PengambilansimpananT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengambilansimpananT the static model class
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
		return 'pengambilansimpanan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('keanggotaan_id, tglpengambilan, nopengambilan, jml_pokok_pengambilan, jml_jasa_pengambilan, jml_pengambilan, biaya_materai_peng, biaya_administrasi_peng, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('keanggotaan_id, buktikaskeluarkop_id, lamasimpanan_bln, ambil_diperiksaoleh_id, ambil_disetujuioleh_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('jml_pokok_pengambilan, jml_jasa_pengambilan, jml_pengambilan, biaya_materai_peng, biaya_administrasi_peng', 'numerical'),
			array('nopengambilan', 'length', 'max'=>50),
			array('keterangan_pengambilan, ambil_diperiksa_tgl, ambil_disetujui_tgl, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pengambilansimpanan_id, keanggotaan_id, buktikaskeluarkop_id, tglpengambilan, nopengambilan, jml_pokok_pengambilan, jml_jasa_pengambilan, jml_pengambilan, biaya_materai_peng, biaya_administrasi_peng, keterangan_pengambilan, lamasimpanan_bln, ambil_diperiksaoleh_id, ambil_diperiksa_tgl, ambil_disetujuioleh_id, ambil_disetujui_tgl, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'buktikaskeluarkop' => array(self::BELONGS_TO, 'BuktikaskeluarkopT', 'buktikaskeluarkop_id'),
			'keanggotaan' => array(self::BELONGS_TO, 'KeanggotaanT', 'keanggotaan_id'),
			'simpananTs' => array(self::HAS_MANY, 'SimpananT', 'pengambilansimpanan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pengambilansimpanan_id' => 'Pengambilansimpanan',
			'keanggotaan_id' => 'Keanggotaan',
			'buktikaskeluarkop_id' => 'Bukti Kas Keluar Kop',
			'tglpengambilan' => 'Tanggal Pengambilan',
			'nopengambilan' => 'No Pengambilan',
			'jml_pokok_pengambilan' => 'Pokok Pengambilan',
			'jml_jasa_pengambilan' => 'Jasa Pengambilan',
			'jml_pengambilan' => 'Jml Pengambilan',
			'biaya_materai_peng' => 'Biaya Materai Peng',
			'biaya_administrasi_peng' => 'Biaya Administrasi Peng',
			'keterangan_pengambilan' => 'Keterangan Pengambilan',
			'lamasimpanan_bln' => 'Lama Simpanan Bln',
			'ambil_diperiksaoleh_id' => 'Ambil Diperiksaoleh',
			'ambil_diperiksa_tgl' => 'Ambil Diperiksa Tgl',
			'ambil_disetujuioleh_id' => 'Ambil Disetujuioleh',
			'ambil_disetujui_tgl' => 'Ambil Disetujui Tgl',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
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

		$criteria->compare('pengambilansimpanan_id',$this->pengambilansimpanan_id);
		$criteria->compare('keanggotaan_id',$this->keanggotaan_id);
		$criteria->compare('buktikaskeluarkop_id',$this->buktikaskeluarkop_id);
		$criteria->compare('tglpengambilan',$this->tglpengambilan,true);
		$criteria->compare('nopengambilan',$this->nopengambilan,true);
		$criteria->compare('jml_pokok_pengambilan',$this->jml_pokok_pengambilan);
		$criteria->compare('jml_jasa_pengambilan',$this->jml_jasa_pengambilan);
		$criteria->compare('jml_pengambilan',$this->jml_pengambilan);
		$criteria->compare('biaya_materai_peng',$this->biaya_materai_peng);
		$criteria->compare('biaya_administrasi_peng',$this->biaya_administrasi_peng);
		$criteria->compare('keterangan_pengambilan',$this->keterangan_pengambilan,true);
		$criteria->compare('lamasimpanan_bln',$this->lamasimpanan_bln);
		$criteria->compare('ambil_diperiksaoleh_id',$this->ambil_diperiksaoleh_id);
		$criteria->compare('ambil_diperiksa_tgl',$this->ambil_diperiksa_tgl,true);
		$criteria->compare('ambil_disetujuioleh_id',$this->ambil_disetujuioleh_id);
		$criteria->compare('ambil_disetujui_tgl',$this->ambil_disetujui_tgl,true);
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