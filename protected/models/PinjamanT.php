<?php

/**
 * This is the model class for table "pinjaman_t".
 *
 * The followings are the available columns in table 'pinjaman_t':
 * @property integer $pinjaman_id
 * @property integer $permohonanpinjaman_id
 * @property integer $keanggotaan_id
 * @property string $jenispinjaman
 * @property string $tglpinjaman
 * @property string $no_pinjaman
 * @property double $jml_pinjaman
 * @property integer $jangka_waktu_bln
 * @property double $persen_jasa_pinjaman
 * @property string $jatuh_tempo
 * @property string $cara_bayar
 * @property string $untuk_keperluan
 * @property integer $jml_kali_angsur
 * @property double $biaya_materai
 * @property double $biaya_administrasi
 * @property string $tgldiperiksa
 * @property integer $pegawaipemeriksa_id
 * @property integer $pegawaimenyetujui_id
 * @property string $tgldisetujui
 * @property string $jaminan_berupa
 * @property boolean $statuspinjaman
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property JmlangsuranT[] $jmlangsuranTs
 * @property PermohonanpenangguhanT[] $permohonanpenangguhanTs
 * @property KeanggotaanT $keanggotaan
 * @property PermohonanpinjamanT $permohonanpinjaman
 * @property PotonganasuransiT[] $potonganasuransiTs
 */
class PinjamanT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PinjamanT the static model class
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
		return 'pinjaman_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('permohonanpinjaman_id, keanggotaan_id, jenispinjaman, tglpinjaman, no_pinjaman, jml_pinjaman, jangka_waktu_bln, jatuh_tempo, jml_kali_angsur, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('permohonanpinjaman_id, keanggotaan_id, jangka_waktu_bln, jml_kali_angsur, pegawaipemeriksa_id, pegawaimenyetujui_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('jml_pinjaman, persen_jasa_pinjaman, biaya_materai, biaya_administrasi', 'numerical'),
			array('jenispinjaman, no_pinjaman', 'length', 'max'=>50),
			array('cara_bayar, jaminan_berupa', 'length', 'max'=>100),
			array('untuk_keperluan, tgldiperiksa, tgldisetujui, statuspinjaman, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pinjaman_id, permohonanpinjaman_id, keanggotaan_id, jenispinjaman, tglpinjaman, no_pinjaman, jml_pinjaman, jangka_waktu_bln, persen_jasa_pinjaman, jatuh_tempo, cara_bayar, untuk_keperluan, jml_kali_angsur, biaya_materai, biaya_administrasi, tgldiperiksa, pegawaipemeriksa_id, pegawaimenyetujui_id, tgldisetujui, jaminan_berupa, statuspinjaman, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'jmlangsuranTs' => array(self::HAS_MANY, 'JmlangsuranT', 'pinjaman_id'),
			'permohonanpenangguhanTs' => array(self::HAS_MANY, 'PermohonanpenangguhanT', 'pinjaman_id'),
			'keanggotaan' => array(self::BELONGS_TO, 'KeanggotaanT', 'keanggotaan_id'),
			'permohonanpinjaman' => array(self::BELONGS_TO, 'PermohonanpinjamanT', 'permohonanpinjaman_id'),
			'potonganasuransiTs' => array(self::HAS_MANY, 'PotonganasuransiT', 'pinjaman_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pinjaman_id' => 'Pinjaman',
			'permohonanpinjaman_id' => 'Permohonanpinjaman',
			'keanggotaan_id' => 'Keanggotaan',
			'jenispinjaman' => 'Jenispinjaman',
			'tglpinjaman' => 'Tglpinjaman',
			'no_pinjaman' => 'No Pinjaman',
			'jml_pinjaman' => 'Jml Pinjaman',
			'jangka_waktu_bln' => 'Jangka Waktu Bln',
			'persen_jasa_pinjaman' => 'Persen Jasa Pinjaman',
			'jatuh_tempo' => 'Jatuh Tempo',
			'cara_bayar' => 'Jenis Penjamin',
			'untuk_keperluan' => 'Untuk Keperluan',
			'jml_kali_angsur' => 'Jml Kali Angsur',
			'biaya_materai' => 'Biaya Materai',
			'biaya_administrasi' => 'Biaya Administrasi',
			'tgldiperiksa' => 'Tgldiperiksa',
			'pegawaipemeriksa_id' => 'Pegawaipemeriksa',
			'pegawaimenyetujui_id' => 'Pegawaimenyetujui',
			'tgldisetujui' => 'Tgldisetujui',
			'jaminan_berupa' => 'Jaminan Berupa',
			'statuspinjaman' => 'Statuspinjaman',
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

		$criteria->compare('pinjaman_id',$this->pinjaman_id);
		$criteria->compare('permohonanpinjaman_id',$this->permohonanpinjaman_id);
		$criteria->compare('keanggotaan_id',$this->keanggotaan_id);
		$criteria->compare('jenispinjaman',$this->jenispinjaman,true);
		$criteria->compare('tglpinjaman',$this->tglpinjaman,true);
		$criteria->compare('no_pinjaman',$this->no_pinjaman,true);
		$criteria->compare('jml_pinjaman',$this->jml_pinjaman);
		$criteria->compare('jangka_waktu_bln',$this->jangka_waktu_bln);
		$criteria->compare('persen_jasa_pinjaman',$this->persen_jasa_pinjaman);
		$criteria->compare('jatuh_tempo',$this->jatuh_tempo,true);
		$criteria->compare('cara_bayar',$this->cara_bayar,true);
		$criteria->compare('untuk_keperluan',$this->untuk_keperluan,true);
		$criteria->compare('jml_kali_angsur',$this->jml_kali_angsur);
		$criteria->compare('biaya_materai',$this->biaya_materai);
		$criteria->compare('biaya_administrasi',$this->biaya_administrasi);
		$criteria->compare('tgldiperiksa',$this->tgldiperiksa,true);
		$criteria->compare('pegawaipemeriksa_id',$this->pegawaipemeriksa_id);
		$criteria->compare('pegawaimenyetujui_id',$this->pegawaimenyetujui_id);
		$criteria->compare('tgldisetujui',$this->tgldisetujui,true);
		$criteria->compare('jaminan_berupa',$this->jaminan_berupa,true);
		$criteria->compare('statuspinjaman',$this->statuspinjaman);
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