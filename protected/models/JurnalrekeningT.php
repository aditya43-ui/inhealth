<?php

/**
 * This is the model class for table "jurnalrekening_t".
 *
 * The followings are the available columns in table 'jurnalrekening_t':
 * @property integer $jurnalrekening_id
 * @property integer $jenisjurnal_id
 * @property integer $rekperiod_id
 * @property string $tglbuktijurnal
 * @property string $nobuktijurnal
 * @property string $kodejurnal
 * @property string $noreferensi
 * @property string $tglreferensi
 * @property integer $nobku
 * @property string $urianjurnal
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class JurnalrekeningT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JurnalrekeningT the static model class
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
		return 'jurnalrekening_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('urianjurnal, jenisjurnal_id, rekperiod_id, tglbuktijurnal, nobuktijurnal, kodejurnal, noreferensi, tglreferensi, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('jenisjurnal_id, rekperiod_id, nobku, ruangan_id, bukubesar_id ,tindakanpelayanan_id ,obatalkespasien_id ,penyusutanaset_id ,tandabuktibayar_id ,unitkerja_id ,fakturpembelian_id ,tandabuktikeluar_id ,bayarkesupplier_id ,bayaruangmuka_id ,penggajianpeg_id ,terimabahanmakan_id ,setoranbdhara_id ,rinciansetoranbdhara_id ,stokopname_id ,invbarang_id,terimamutasi_id,returpembelian_id,batalbayarsupplier_id,returpenerimaanumum_id,batalkeluarumum_id,pembayarklaim_id,closingkasir_id,pembayaranjasa_id,terimapersediaan_id,pembatalanuangmuka_id,returresep_id,returbayarpelayanan_id,pemakaianbhnmkn_id,pemakaianbarang_id,mutasibrg_id, mutasioaruangan_id, pemakaianobat_id, jurnalbalik_id, returpenerimaan_id, returpenbahanmakan_id, uangmukabeli_id, pembpiutangbankdetail_id, stokopnamedet_id, stokopnamegizidet_id', 'numerical', 'integerOnly'=>true),
			array('nobuktijurnal', 'length', 'max'=>50),
			array('kodejurnal', 'length', 'max'=>20),
			array('update_time, update_loginpemakai_id, noreferensi, ruangan_id, bukubesar_id ,tindakanpelayanan_id ,obatalkespasien_id ,penyusutanaset_id ,tandabuktibayar_id ,unitkerja_id ,fakturpembelian_id ,tandabuktikeluar_id ,bayarkesupplier_id ,bayaruangmuka_id ,penggajianpeg_id ,terimabahanmakan_id ,setoranbdhara_id ,rinciansetoranbdhara_id ,stokopname_id ,invbarang_id,terimamutasi_id,returpembelian_id,batalbayarsupplier_id,returpenerimaanumum_id,batalkeluarumum_id,pembayarklaim_id,closingkasir_id,pembayaranjasa_id,terimapersediaan_id,pembatalanuangmuka_id,returresep_id,returbayarpelayanan_id,pemakaianbhnmkn_id,pemakaianbarang_id,mutasibrg_id, mutasioaruangan_id, pemakaianobat_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jurnalrekening_id, jenisjurnal_id, rekperiod_id, tglbuktijurnal, nobuktijurnal, kodejurnal, noreferensi, tglreferensi, nobku, urianjurnal, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, ruangan_id, bukubesar_id ,tindakanpelayanan_id ,obatalkespasien_id ,penyusutanaset_id ,tandabuktibayar_id ,unitkerja_id ,fakturpembelian_id ,tandabuktikeluar_id ,bayarkesupplier_id ,bayaruangmuka_id ,penggajianpeg_id ,terimabahanmakan_id ,setoranbdhara_id ,rinciansetoranbdhara_id ,stokopname_id ,invbarang_id,terimamutasi_id,returpembelian_id,batalbayarsupplier_id,returpenerimaanumum_id,batalkeluarumum_id,pembayarklaim_id,closingkasir_id,pembayaranjasa_id,terimapersediaan_id,pembatalanuangmuka_id,returresep_id,returbayarpelayanan_id,pemakaianbhnmkn_id,pemakaianbarang_id,mutasibrg_id, mutasioaruangan_id, pemakaianobat_id, jurnalbalik_id, returpenerimaan_id, returpenbahanmakan_id, uangmukabeli_id, pembpiutangbankdetail_id, stokopnamedet_id, stokopnamegizidet_id', 'safe', 'on'=>'search'),
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
                    'jenisJurnal'=>array(self::BELONGS_TO,'JenisjurnalM','jenisjurnal_id'),
                    'rekPeriode'=>array(self::BELONGS_TO,'RekperiodM','rekperiod_id'),
                    'jurnalDetail'=>array(self::HAS_MANY,'JurnaldetailT','jurnalrekening_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'jurnalrekening_id' => 'Jurnal Rekening ID',
			'jenisjurnal_id' => 'Jenis Jurnal',
			'rekperiod_id' => 'Rek Period',
			'tglbuktijurnal' => 'Tanggal Bukti Jurnal',
			'nobuktijurnal' => 'No. Bukti Jurnal',
			'kodejurnal' => 'Kode Jurnal',
			'noreferensi' => 'No. Referensi',
			'tglreferensi' => 'Tanggal Referensi',
			'nobku' => 'No. BKU',
			'urianjurnal' => 'Uraian Jurnal',
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

		$criteria->compare('jurnalrekening_id',$this->jurnalrekening_id);
		$criteria->compare('jenisjurnal_id',$this->jenisjurnal_id);
		$criteria->compare('rekperiod_id',$this->rekperiod_id);
		$criteria->compare('LOWER(tglbuktijurnal)',strtolower($this->tglbuktijurnal),true);
		$criteria->compare('LOWER(nobuktijurnal)',strtolower($this->nobuktijurnal),true);
		$criteria->compare('LOWER(kodejurnal)',strtolower($this->kodejurnal),true);
		$criteria->compare('LOWER(noreferensi)',strtolower($this->noreferensi),true);
		$criteria->compare('LOWER(tglreferensi)',strtolower($this->tglreferensi),true);
		$criteria->compare('nobku',$this->nobku);
		$criteria->compare('LOWER(urianjurnal)',strtolower($this->urianjurnal),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('jurnalrekening_id',$this->jurnalrekening_id);
		$criteria->compare('jenisjurnal_id',$this->jenisjurnal_id);
		$criteria->compare('rekperiod_id',$this->rekperiod_id);
		$criteria->compare('LOWER(tglbuktijurnal)',strtolower($this->tglbuktijurnal),true);
		$criteria->compare('LOWER(nobuktijurnal)',strtolower($this->nobuktijurnal),true);
		$criteria->compare('LOWER(kodejurnal)',strtolower($this->kodejurnal),true);
		$criteria->compare('LOWER(noreferensi)',strtolower($this->noreferensi),true);
		$criteria->compare('LOWER(tglreferensi)',strtolower($this->tglreferensi),true);
		$criteria->compare('nobku',$this->nobku);
		$criteria->compare('LOWER(urianjurnal)',strtolower($this->urianjurnal),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit
                $criteria->limit=-1;

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }

        public function getCurrentPeriod() {
            $cr = new CDbCriteria;
            $cr->addCondition("'".$this->tglbuktijurnal."'::date between perideawal::date and sampaidgn::date");
            $cr->addCondition('isclosing = false');

            $mod = RekperiodM::model()->find($cr);

            if (empty($mod)) return null;
            return $mod->rekperiod_id;
        }
}
