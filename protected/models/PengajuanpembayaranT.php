<?php

/**
 * This is the model class for table "pengajuanpembayaran_t".
 *
 * The followings are the available columns in table 'pengajuanpembayaran_t':
 * @property integer $pengajuanpembayaran_id
 * @property string $tglpengajuanpemb
 * @property string $nopengajuan
 * @property integer $potongansumber_id
 * @property integer $keanggotaan_id
 * @property integer $jmlangsuran_id
 * @property string $tglpembjthtempo
 * @property string $sampaidgntgljthtempo
 * @property double $jmlpotongan_sumber
 * @property string $tgldibuat_pengpemb
 * @property integer $dibuatoleh_id_pengpemb
 * @property string $tgldiperiksa_pengpemb
 * @property integer $diperiksaoleh_id_pengpemb
 * @property string $tgldisetujui_pengpemb
 * @property integer $disetujuioleh_id_pengpemb
 * @property double $simpananwajib
 * @property double $simpanansukarela
 * @property double $jmlpokok_pengangs
 * @property double $jmljasaangs_pengangs
 * @property double $jmldendaangs_pengangs
 * @property double $jmlpengajuan_pengangsuran
 * @property double $jmlsisapeng_pengangs
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PembayaranangsuranT[] $pembayaranangsuranTs
 * @property JmlangsuranT $jmlangsuran
 * @property KeanggotaanT $keanggotaan
 * @property PermohonanpenangguhanT[] $permohonanpenangguhanTs
 */
class PengajuanpembayaranT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengajuanpembayaranT the static model class
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
		return 'pengajuanpembayaran_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglpengajuanpemb, nopengajuan, potongansumber_id, keanggotaan_id, jmlangsuran_id, tglpembjthtempo, sampaidgntgljthtempo, tgldibuat_pengpemb, dibuatoleh_id_pengpemb, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('potongansumber_id, keanggotaan_id, jmlangsuran_id, dibuatoleh_id_pengpemb, diperiksaoleh_id_pengpemb, disetujuioleh_id_pengpemb, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('jmlpotongan_sumber, simpananwajib, simpanansukarela, jmlpokok_pengangs, jmljasaangs_pengangs, jmldendaangs_pengangs, jmlpengajuan_pengangsuran, jmlsisapeng_pengangs', 'numerical'),
			array('nopengajuan', 'length', 'max'=>50),
			array('tgldiperiksa_pengpemb, tgldisetujui_pengpemb, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pengajuanpembayaran_id, tglpengajuanpemb, nopengajuan, potongansumber_id, keanggotaan_id, jmlangsuran_id, tglpembjthtempo, sampaidgntgljthtempo, jmlpotongan_sumber, tgldibuat_pengpemb, dibuatoleh_id_pengpemb, tgldiperiksa_pengpemb, diperiksaoleh_id_pengpemb, tgldisetujui_pengpemb, disetujuioleh_id_pengpemb, simpananwajib, simpanansukarela, jmlpokok_pengangs, jmljasaangs_pengangs, jmldendaangs_pengangs, jmlpengajuan_pengangsuran, jmlsisapeng_pengangs, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pembayaranangsuranTs' => array(self::HAS_MANY, 'PembayaranangsuranT', 'pengajuanpembayaran_id'),
			'jmlangsuran' => array(self::BELONGS_TO, 'JmlangsuranT', 'jmlangsuran_id'),
			'keanggotaan' => array(self::BELONGS_TO, 'KeanggotaanT', 'keanggotaan_id'),
			'permohonanpenangguhanTs' => array(self::HAS_MANY, 'PermohonanpenangguhanT', 'pengajuanpembayaran_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pengajuanpembayaran_id' => 'Pengajuanpembayaran',
			'tglpengajuanpemb' => 'Tglpengajuanpemb',
			'nopengajuan' => 'Nopengajuan',
			'potongansumber_id' => 'Potongansumber',
			'keanggotaan_id' => 'Keanggotaan',
			'jmlangsuran_id' => 'Jmlangsuran',
			'tglpembjthtempo' => 'Tglpembjthtempo',
			'sampaidgntgljthtempo' => 'Sampaidgntgljthtempo',
			'jmlpotongan_sumber' => 'Jmlpotongan Sumber',
			'tgldibuat_pengpemb' => 'Tgldibuat Pengpemb',
			'dibuatoleh_id_pengpemb' => 'Dibuatoleh Id Pengpemb',
			'tgldiperiksa_pengpemb' => 'Tgldiperiksa Pengpemb',
			'diperiksaoleh_id_pengpemb' => 'Diperiksaoleh Id Pengpemb',
			'tgldisetujui_pengpemb' => 'Tgldisetujui Pengpemb',
			'disetujuioleh_id_pengpemb' => 'Disetujuioleh Id Pengpemb',
			'simpananwajib' => 'Simpananwajib',
			'simpanansukarela' => 'Simpanansukarela',
			'jmlpokok_pengangs' => 'Jmlpokok Pengangs',
			'jmljasaangs_pengangs' => 'Jmljasaangs Pengangs',
			'jmldendaangs_pengangs' => 'Jmldendaangs Pengangs',
			'jmlpengajuan_pengangsuran' => 'Jmlpengajuan Pengangsuran',
			'jmlsisapeng_pengangs' => 'Jmlsisapeng Pengangs',
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

		$criteria->compare('pengajuanpembayaran_id',$this->pengajuanpembayaran_id);
		$criteria->compare('tglpengajuanpemb',$this->tglpengajuanpemb,true);
		$criteria->compare('nopengajuan',$this->nopengajuan,true);
		$criteria->compare('potongansumber_id',$this->potongansumber_id);
		$criteria->compare('keanggotaan_id',$this->keanggotaan_id);
		$criteria->compare('jmlangsuran_id',$this->jmlangsuran_id);
		$criteria->compare('tglpembjthtempo',$this->tglpembjthtempo,true);
		$criteria->compare('sampaidgntgljthtempo',$this->sampaidgntgljthtempo,true);
		$criteria->compare('jmlpotongan_sumber',$this->jmlpotongan_sumber);
		$criteria->compare('tgldibuat_pengpemb',$this->tgldibuat_pengpemb,true);
		$criteria->compare('dibuatoleh_id_pengpemb',$this->dibuatoleh_id_pengpemb);
		$criteria->compare('tgldiperiksa_pengpemb',$this->tgldiperiksa_pengpemb,true);
		$criteria->compare('diperiksaoleh_id_pengpemb',$this->diperiksaoleh_id_pengpemb);
		$criteria->compare('tgldisetujui_pengpemb',$this->tgldisetujui_pengpemb,true);
		$criteria->compare('disetujuioleh_id_pengpemb',$this->disetujuioleh_id_pengpemb);
		$criteria->compare('simpananwajib',$this->simpananwajib);
		$criteria->compare('simpanansukarela',$this->simpanansukarela);
		$criteria->compare('jmlpokok_pengangs',$this->jmlpokok_pengangs);
		$criteria->compare('jmljasaangs_pengangs',$this->jmljasaangs_pengangs);
		$criteria->compare('jmldendaangs_pengangs',$this->jmldendaangs_pengangs);
		$criteria->compare('jmlpengajuan_pengangsuran',$this->jmlpengajuan_pengangsuran);
		$criteria->compare('jmlsisapeng_pengangs',$this->jmlsisapeng_pengangs);
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