<?php

/**
 * This is the model class for table "intrahemodialisa_t".
 *
 * The followings are the available columns in table 'intrahemodialisa_t':
 * @property integer $intrahemodialisa_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property integer $jenishd_id
 * @property integer $jenisdialisat_id
 * @property double $suhudialisat
 * @property integer $aksesvaskular_id
 * @property string $tglpenggunaanawal
 * @property string $tglpenggunaandialiser
 * @property integer $penggunaanke
 * @property integer $perawat_id
 * @property string $jenisdialeser
 * @property integer $hd_ke
 * @property string $res_use
 * @property string $teknik_hd
 * @property string $kec_darah_qb
 * @property double $kec_dialisat_qd
 * @property string $lamahd_jam
 * @property double $uf_goal
 * @property boolean $is_ultrafiltrasi
 * @property string $ultrafiltrasi_mode
 * @property boolean $is_iso_uf
 * @property string $iso_uf_ml
 * @property boolean $islama_isouf
 * @property string $lama_isouf
 * @property boolean $is_natrium
 * @property string $natrium_mode
 * @property boolean $is_bicarbonat
 * @property string $bicarbonat_mode
 * @property boolean $heparin_isdosis_sirkulasi
 * @property string $heparin_dosis_sirkulasi
 * @property boolean $heparin_isdosis_awal
 * @property string $heparin_dosis_awal
 * @property boolean $heparin_iskontinyu
 * @property string $heparin_kontinyuket
 * @property boolean $heparin_isintermiten
 * @property string $heparin_intermitenket
 * @property boolean $heparin_islmwh
 * @property string $heparin_lmwh
 * @property boolean $heparin_istanpaheparin
 * @property string $heparin_tanpaheparinalasan
 * @property string $heparin_tanpaheparinjml
 * @property double $heparin_bbkering
 * @property string $hemapo_nilai
 * @property string $hemapo_satuan
 * @property string $recormon_nilai
 * @property string $recormon_satuan
 * @property string $eprex_nilai
 * @property string $exprex_satuan
 * @property string $epotrex_nilai
 * @property string $epotrex_satuan
 * @property string $epodion_nilai
 * @property string $epodion_satuan
 * @property string $renogen_nilai
 * @property string $renogen_satuan
 * @property string $prepbesi_nilai
 * @property string $prepbesi_satuan
 * @property string $asamamino_nilai
 * @property string $asamamino_satuan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan_id
 *
 * The followings are the available model relations:
 * @property PasienM $pasien
 * @property PendaftaranT $pendaftaran
 * @property PasienadmisiT $pasienadmisi
 */
class IntrahemodialisaT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return IntrahemodialisaT the static model class
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
		return 'intrahemodialisa_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, pendaftaran_id, jenishd_id, suhudialisat, tglpenggunaanawal, tglpenggunaandialiser, penggunaanke, perawat_id', 'required'),
			array('pasien_id, pendaftaran_id, pasienadmisi_id, jenishd_id, jenisdialisat_id, aksesvaskular_id, penggunaanke, perawat_id, hd_ke, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('jenisdialisat_id, suhudialisat, kec_dialisat_qd, uf_goal, heparin_bbkering', 'numerical'),
			array('jenisdialeser, res_use, teknik_hd, kec_darah_qb, lamahd_jam, heparin_tanpaheparinjml, hemapo_nilai, recormon_nilai, eprex_nilai, epotrex_nilai, epodion_nilai, renogen_nilai, prepbesi_nilai, asamamino_nilai', 'length', 'max'=>50),
			array('ultrafiltrasi_mode, iso_uf_ml, natrium_mode, bicarbonat_mode, heparin_dosis_sirkulasi, heparin_dosis_awal, heparin_kontinyuket, heparin_intermitenket, heparin_lmwh, heparin_tanpaheparinalasan', 'length', 'max'=>100),
			array('hemapo_satuan, recormon_satuan, exprex_satuan, epotrex_satuan, epodion_satuan, renogen_satuan, prepbesi_satuan, asamamino_satuan', 'length', 'max'=>20),
			array('is_ultrafiltrasi, is_iso_uf, islama_isouf, lama_isouf, is_natrium, is_bicarbonat, heparin_isdosis_sirkulasi, heparin_isdosis_awal, heparin_iskontinyu, heparin_isintermiten, heparin_islmwh, heparin_istanpaheparin, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('intrahemodialisa_id, pasien_id, pendaftaran_id, pasienadmisi_id, jenishd_id, jenisdialisat_id, suhudialisat, aksesvaskular_id, tglpenggunaanawal, tglpenggunaandialiser, penggunaanke, perawat_id, jenisdialeser, hd_ke, res_use, teknik_hd, kec_darah_qb, kec_dialisat_qd, lamahd_jam, uf_goal, is_ultrafiltrasi, ultrafiltrasi_mode, is_iso_uf, iso_uf_ml, islama_isouf, lama_isouf, is_natrium, natrium_mode, is_bicarbonat, bicarbonat_mode, heparin_isdosis_sirkulasi, heparin_dosis_sirkulasi, heparin_isdosis_awal, heparin_dosis_awal, heparin_iskontinyu, heparin_kontinyuket, heparin_isintermiten, heparin_intermitenket, heparin_islmwh, heparin_lmwh, heparin_istanpaheparin, heparin_tanpaheparinalasan, heparin_tanpaheparinjml, heparin_bbkering, hemapo_nilai, hemapo_satuan, recormon_nilai, recormon_satuan, eprex_nilai, exprex_satuan, epotrex_nilai, epotrex_satuan, epodion_nilai, epodion_satuan, renogen_nilai, renogen_satuan, prepbesi_nilai, prepbesi_satuan, asamamino_nilai, asamamino_satuan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id', 'safe', 'on'=>'search'),
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
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
                        'perawat' => array(self::BELONGS_TO, 'PegawaiM', 'perawat_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'intrahemodialisa_id' => 'Intrahemodialisa',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'jenishd_id' => 'Peresean HD',
			'jenisdialisat_id' => 'Jenis Dialisat',
			'suhudialisat' => 'Suhu Dialisat',
			'aksesvaskular_id' => 'Aksesvaskular',
			'tglpenggunaanawal' => 'Tanggal Penggunaan Awal',
			'tglpenggunaandialiser' => 'Tanggal Penggunaan Dialiser',
			'penggunaanke' => 'Penggunaan Ke-',
			'perawat_id' => 'Perawat',
			'jenisdialeser' => 'Jenis Dialeser',
			'hd_ke' => 'HD Ke',
			'res_use' => 'Res-Use',
			'teknik_hd' => 'Teknik Hd',
			'kec_darah_qb' => 'Aliran Darah (QB)',
			'kec_dialisat_qd' => 'Aliran Dialisat (QD)',
			'lamahd_jam' => 'Lama Pemakaian',
			'uf_goal' => 'UF Goal',
			'is_ultrafiltrasi' => 'Ultrafiltrasi',
			'ultrafiltrasi_mode' => 'Ultrafiltrasi Mode',
			'is_iso_uf' => 'ISO UF',
			'iso_uf_ml' => 'Iso Uf Ml',
			'islama_isouf' => 'Lama Iso',
			'lama_isouf' => 'Lama Isouf',
			'is_natrium' => 'Natrium',
			'natrium_mode' => 'Natrium Mode',
			'is_bicarbonat' => 'Bicarbonat',
			'bicarbonat_mode' => 'Bicarbonat Mode',
			'heparin_isdosis_sirkulasi' => 'Dosis Sirkulasi',
			'heparin_dosis_sirkulasi' => 'Heparin Dosis Sirkulasi',
			'heparin_isdosis_awal' => 'Dosis Awal',
			'heparin_dosis_awal' => 'Heparin Dosis Awal',
			'heparin_iskontinyu' => 'Kontinyu',
			'heparin_kontinyuket' => 'Heparin Kontinyuket',
			'heparin_isintermiten' => 'Intermiten',
			'heparin_intermitenket' => 'Heparin Intermitenket',
			'heparin_islmwh' => 'LMWH',
			'heparin_lmwh' => 'Heparin Lmwh',
			'heparin_istanpaheparin' => 'Tanpa Heparin',
			'heparin_tanpaheparinalasan' => 'Heparin Tanpaheparinalasan',
			'heparin_tanpaheparinjml' => 'Heparin Tanpaheparinjml',
			'heparin_bbkering' => 'BB Kering',
			'hemapo_nilai' => 'Hemapo',
			'hemapo_satuan' => 'Hemapo Satuan',
			'recormon_nilai' => 'Recormon',
			'recormon_satuan' => 'Recormon Satuan',
			'eprex_nilai' => 'Eprex',
			'exprex_satuan' => 'Exprex Satuan',
			'epotrex_nilai' => 'Epotrex',
			'epotrex_satuan' => 'Epotrex Satuan',
			'epodion_nilai' => 'Epodion',
			'epodion_satuan' => 'Epodion Satuan',
			'renogen_nilai' => 'Renogen',
			'renogen_satuan' => 'Renogen Satuan',
			'prepbesi_nilai' => 'Prep Besi',
			'prepbesi_satuan' => 'Prepbesi Satuan',
			'asamamino_nilai' => 'Asam Amino',
			'asamamino_satuan' => 'Asamamino Satuan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan_id' => 'Create Ruangan',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->intrahemodialisa_id)){
			$criteria->addCondition('intrahemodialisa_id = '.$this->intrahemodialisa_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition('pasienadmisi_id = '.$this->pasienadmisi_id);
		}
		if(!empty($this->jenishd_id)){
			$criteria->addCondition('jenishd_id = '.$this->jenishd_id);
		}
		if(!empty($this->jenisdialisat_id)){
			$criteria->addCondition('jenisdialisat_id = '.$this->jenisdialisat_id);
		}
		$criteria->compare('suhudialisat',$this->suhudialisat);
		if(!empty($this->aksesvaskular_id)){
			$criteria->addCondition('aksesvaskular_id = '.$this->aksesvaskular_id);
		}
		$criteria->compare('LOWER(tglpenggunaanawal)',strtolower($this->tglpenggunaanawal),true);
		$criteria->compare('LOWER(tglpenggunaandialiser)',strtolower($this->tglpenggunaandialiser),true);
		if(!empty($this->penggunaanke)){
			$criteria->addCondition('penggunaanke = '.$this->penggunaanke);
		}
		if(!empty($this->perawat_id)){
			$criteria->addCondition('perawat_id = '.$this->perawat_id);
		}
		$criteria->compare('LOWER(jenisdialeser)',strtolower($this->jenisdialeser),true);
		if(!empty($this->hd_ke)){
			$criteria->addCondition('hd_ke = '.$this->hd_ke);
		}
		$criteria->compare('LOWER(res_use)',strtolower($this->res_use),true);
		$criteria->compare('LOWER(teknik_hd)',strtolower($this->teknik_hd),true);
		$criteria->compare('LOWER(kec_darah_qb)',strtolower($this->kec_darah_qb),true);
		$criteria->compare('kec_dialisat_qd',$this->kec_dialisat_qd);
		$criteria->compare('LOWER(lamahd_jam)',strtolower($this->lamahd_jam),true);
		$criteria->compare('uf_goal',$this->uf_goal);
		$criteria->compare('is_ultrafiltrasi',$this->is_ultrafiltrasi);
		$criteria->compare('LOWER(ultrafiltrasi_mode)',strtolower($this->ultrafiltrasi_mode),true);
		$criteria->compare('is_iso_uf',$this->is_iso_uf);
		$criteria->compare('LOWER(iso_uf_ml)',strtolower($this->iso_uf_ml),true);
		$criteria->compare('islama_isouf',$this->islama_isouf);
		$criteria->compare('LOWER(lama_isouf)',strtolower($this->lama_isouf),true);
		$criteria->compare('is_natrium',$this->is_natrium);
		$criteria->compare('LOWER(natrium_mode)',strtolower($this->natrium_mode),true);
		$criteria->compare('is_bicarbonat',$this->is_bicarbonat);
		$criteria->compare('LOWER(bicarbonat_mode)',strtolower($this->bicarbonat_mode),true);
		$criteria->compare('heparin_isdosis_sirkulasi',$this->heparin_isdosis_sirkulasi);
		$criteria->compare('LOWER(heparin_dosis_sirkulasi)',strtolower($this->heparin_dosis_sirkulasi),true);
		$criteria->compare('heparin_isdosis_awal',$this->heparin_isdosis_awal);
		$criteria->compare('LOWER(heparin_dosis_awal)',strtolower($this->heparin_dosis_awal),true);
		$criteria->compare('heparin_iskontinyu',$this->heparin_iskontinyu);
		$criteria->compare('LOWER(heparin_kontinyuket)',strtolower($this->heparin_kontinyuket),true);
		$criteria->compare('heparin_isintermiten',$this->heparin_isintermiten);
		$criteria->compare('LOWER(heparin_intermitenket)',strtolower($this->heparin_intermitenket),true);
		$criteria->compare('heparin_islmwh',$this->heparin_islmwh);
		$criteria->compare('LOWER(heparin_lmwh)',strtolower($this->heparin_lmwh),true);
		$criteria->compare('heparin_istanpaheparin',$this->heparin_istanpaheparin);
		$criteria->compare('LOWER(heparin_tanpaheparinalasan)',strtolower($this->heparin_tanpaheparinalasan),true);
		$criteria->compare('LOWER(heparin_tanpaheparinjml)',strtolower($this->heparin_tanpaheparinjml),true);
		$criteria->compare('heparin_bbkering',$this->heparin_bbkering);
		$criteria->compare('LOWER(hemapo_nilai)',strtolower($this->hemapo_nilai),true);
		$criteria->compare('LOWER(hemapo_satuan)',strtolower($this->hemapo_satuan),true);
		$criteria->compare('LOWER(recormon_nilai)',strtolower($this->recormon_nilai),true);
		$criteria->compare('LOWER(recormon_satuan)',strtolower($this->recormon_satuan),true);
		$criteria->compare('LOWER(eprex_nilai)',strtolower($this->eprex_nilai),true);
		$criteria->compare('LOWER(exprex_satuan)',strtolower($this->exprex_satuan),true);
		$criteria->compare('LOWER(epotrex_nilai)',strtolower($this->epotrex_nilai),true);
		$criteria->compare('LOWER(epotrex_satuan)',strtolower($this->epotrex_satuan),true);
		$criteria->compare('LOWER(epodion_nilai)',strtolower($this->epodion_nilai),true);
		$criteria->compare('LOWER(epodion_satuan)',strtolower($this->epodion_satuan),true);
		$criteria->compare('LOWER(renogen_nilai)',strtolower($this->renogen_nilai),true);
		$criteria->compare('LOWER(renogen_satuan)',strtolower($this->renogen_satuan),true);
		$criteria->compare('LOWER(prepbesi_nilai)',strtolower($this->prepbesi_nilai),true);
		$criteria->compare('LOWER(prepbesi_satuan)',strtolower($this->prepbesi_satuan),true);
		$criteria->compare('LOWER(asamamino_nilai)',strtolower($this->asamamino_nilai),true);
		$criteria->compare('LOWER(asamamino_satuan)',strtolower($this->asamamino_satuan),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan_id)){
			$criteria->addCondition('create_ruangan_id = '.$this->create_ruangan_id);
		}

		return $criteria;
	}
        
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function search()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }


        public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
}