<?php

/**
 * This is the model class for table "periksahd_t".
 *
 * The followings are the available columns in table 'periksahd_t':
 * @property integer $periksahd_id
 * @property integer $pasien_id
 * @property integer $aksesvaskular_id
 * @property integer $pegawai_id
 * @property integer $ruangan_id
 * @property integer $jenishd_id
 * @property integer $jenisdialisat_id
 * @property integer $pendaftaran_id
 * @property integer $jenistransfusi_id
 * @property string $periksahd_tgl
 * @property integer $dialiserke
 * @property string $suhudialisis_c
 * @property string $periksahd_penyulit
 * @property string $lamahd_jam
 * @property string $uf_goal
 * @property string $kec_darah_qb
 * @property string $kec_dialisat_qd
 * @property string $heparin_dosisawal
 * @property string $heparin_continyu
 * @property string $heparin_intermiten
 * @property string $tanpaheparin_nama
 * @property string $tanpaheparin_jml
 * @property string $heparin_lmwh
 * @property integer $jmllabudarah
 * @property string $bb_pra_hd_kg
 * @property string $bb_post_hd_kg
 * @property string $bb_kering_kg
 * @property boolean $is_ultrafiltrasi
 * @property string $ultrafiltrasi_mode
 * @property boolean $is_natrium
 * @property string $natrium_mode
 * @property boolean $is_bicarbonat
 * @property string $bicarbonat_mode
 * @property string $pre_dialisis_bun
 * @property string $post_dialisis_bun
 * @property string $adekuasi_urr
 * @property string $adekuasi_kt_v
 * @property string $obat_hemapo
 * @property string $obat_hemapo_stn
 * @property string $obat_recormon
 * @property string $obat_recormon_stn
 * @property string $obat_eprex
 * @property string $obat_eprex_stn
 * @property string $obat_epotrex
 * @property string $obat_epotrex_stn
 * @property string $obat_epodion
 * @property string $obat_epodion_stn
 * @property string $injeksi_preb_besi
 * @property string $injeksi_preb_besi_stn
 * @property string $injeksi_asamamir
 * @property string $injeksi_asamamir_stn
 * @property string $ph_create_time
 * @property string $ph_udpate_time
 * @property integer $ph_create_loginid
 * @property integer $ph_update_loginid
 * @property integer $ph_create_ruanganid
 * @property string $ph_create_iphost
 */
class PeriksahdT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PeriksahdT the static model class
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
		return 'periksahd_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, aksesvaskular_id, pegawai_id, ruangan_id, jenishd_id, jenisdialisat_id, pendaftaran_id, periksahd_tgl, dialiserke', 'required'),
			array('pasien_id, aksesvaskular_id, pegawai_id, ruangan_id, jenishd_id, jenisdialisat_id, pendaftaran_id, jenistransfusi_id, dialiserke, jmllabudarah, ph_create_loginid, ph_update_loginid, ph_create_ruanganid', 'numerical', 'integerOnly'=>true),
			array('tanpaheparin_nama, ph_create_iphost', 'length', 'max'=>50),
			array('ultrafiltrasi_mode, natrium_mode, bicarbonat_mode', 'length', 'max'=>100),
			array('obat_hemapo_stn, obat_recormon_stn, obat_eprex_stn, obat_epotrex_stn, obat_epodion_stn, injeksi_preb_besi_stn, injeksi_asamamir_stn', 'length', 'max'=>20),
			array('suhudialisis_c, periksahd_penyulit, lamahd_jam, uf_goal, kec_darah_qb, kec_dialisat_qd, heparin_dosisawal, heparin_continyu, heparin_intermiten, tanpaheparin_jml, heparin_lmwh, bb_pra_hd_kg, bb_post_hd_kg, bb_kering_kg, is_ultrafiltrasi, is_natrium, is_bicarbonat, pre_dialisis_bun, post_dialisis_bun, adekuasi_urr, adekuasi_kt_v, obat_hemapo, obat_recormon, obat_eprex, obat_epotrex, obat_epodion, injeksi_preb_besi, injeksi_asamamir, ph_create_time, ph_udpate_time, tglpenggunaanawal, heparin_dosissirkulasi, iso_uf_ml, lama_uso_uf, penyulit_teknis, resephd_id, jenisdialiser, tensi_pre_hd, tensi_post_hd, nadi_pre_hd, nadi_post_hd, suhu_pre_hd, suhu_post_hd, respirasi_pre_hd, respirasi_post_hd, hd_ke, res_use, jam_md, qb_md, ap_md, vp_md, tmp_md, ufg_md, ufv_md, ufr_md, qd_md, tensi_md', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('periksahd_id, pasien_id, aksesvaskular_id, pegawai_id, ruangan_id, jenishd_id, jenisdialisat_id, pendaftaran_id, jenistransfusi_id, periksahd_tgl, dialiserke, suhudialisis_c, periksahd_penyulit, lamahd_jam, uf_goal, kec_darah_qb, kec_dialisat_qd, heparin_dosisawal, heparin_continyu, heparin_intermiten, tanpaheparin_nama, tanpaheparin_jml, heparin_lmwh, jmllabudarah, bb_pra_hd_kg, bb_post_hd_kg, bb_kering_kg, is_ultrafiltrasi, ultrafiltrasi_mode, is_natrium, natrium_mode, is_bicarbonat, bicarbonat_mode, pre_dialisis_bun, post_dialisis_bun, adekuasi_urr, adekuasi_kt_v, obat_hemapo, obat_hemapo_stn, obat_recormon, obat_recormon_stn, obat_eprex, obat_eprex_stn, obat_epotrex, obat_epotrex_stn, obat_epodion, obat_epodion_stn, injeksi_preb_besi, injeksi_preb_besi_stn, injeksi_asamamir, injeksi_asamamir_stn, ph_create_time, ph_udpate_time, ph_create_loginid, ph_update_loginid, ph_create_ruanganid, ph_create_iphost, tglpenggunaanawal, heparin_dosissirkulasi, , iso_uf_ml, lama_uso_uf, penyulit_teknis, resephd_id, jenisdialiser, tensi_pre_hd, tensi_post_hd, nadi_pre_hd, nadi_post_hd, suhu_pre_hd, suhu_post_hd, respirasi_pre_hd, respirasi_post_hd, hd_ke, res_use, jam_md, qb_md, ap_md, vp_md, tmp_md, ufg_md, ufv_md, ufr_md, qd_md, tensi_md', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
//		JenisdialisatM::
		return array(
			'jenisdialisatrl'=>array(self::BELONGS_TO,'JenisdialisatM','jenisdialisat_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'periksahd_id' => 'Periksahd',
			'pasien_id' => 'Pasien',
			'aksesvaskular_id' => 'Aksesvaskular',
			'pegawai_id' => 'Pegawai',
			'ruangan_id' => 'Ruangan',
			'jenishd_id' => 'Jenishd',
			'jenisdialisat_id' => 'Jenisdialisat',
			'pendaftaran_id' => 'Pendaftaran',
			'jenistransfusi_id' => 'Jenistransfusi',
			'periksahd_tgl' => 'Periksahd Tgl',
			'dialiserke' => 'Dialiserke',
			'suhudialisis_c' => 'Suhudialisis C',
			'periksahd_penyulit' => 'Periksahd Penyulit',
			'lamahd_jam' => 'Lamahd Jam',
			'uf_goal' => 'Uf Goal',
			'kec_darah_qb' => 'Kec Darah Qb',
			'kec_dialisat_qd' => 'Kec Dialisat Qd',
			'heparin_dosisawal' => 'Heparin Dosisawal',
			'heparin_continyu' => 'Heparin Continyu',
			'heparin_intermiten' => 'Heparin Intermiten',
			'tanpaheparin_nama' => 'Tanpaheparin Nama',
			'tanpaheparin_jml' => 'Tanpaheparin Jml',
			'heparin_lmwh' => 'Heparin Lmwh',
			'jmllabudarah' => 'Jmllabudarah',
			'bb_pra_hd_kg' => 'Bb Pra Hd Kg',
			'bb_post_hd_kg' => 'Bb Post Hd Kg',
			'bb_kering_kg' => 'Bb Kering Kg',
			'is_ultrafiltrasi' => 'Is Ultrafiltrasi',
			'ultrafiltrasi_mode' => 'Ultrafiltrasi Mode',
			'is_natrium' => 'Is Natrium',
			'natrium_mode' => 'Natrium Mode',
			'is_bicarbonat' => 'Is Bicarbonat',
			'bicarbonat_mode' => 'Bicarbonat Mode',
			'pre_dialisis_bun' => 'Pre Dialisis Bun',
			'post_dialisis_bun' => 'Post Dialisis Bun',
			'adekuasi_urr' => 'Adekuasi Urr',
			'adekuasi_kt_v' => 'Adekuasi Kt V',
			'obat_hemapo' => 'Obat Hemapo',
			'obat_hemapo_stn' => 'Obat Hemapo Stn',
			'obat_recormon' => 'Obat Recormon',
			'obat_recormon_stn' => 'Obat Recormon Stn',
			'obat_eprex' => 'Obat Eprex',
			'obat_eprex_stn' => 'Obat Eprex Stn',
			'obat_epotrex' => 'Obat Epotrex',
			'obat_epotrex_stn' => 'Obat Epotrex Stn',
			'obat_epodion' => 'Obat Epodion',
			'obat_epodion_stn' => 'Obat Epodion Stn',
			'injeksi_preb_besi' => 'Injeksi Preb Besi',
			'injeksi_preb_besi_stn' => 'Injeksi Preb Besi Stn',
			'injeksi_asamamir' => 'Injeksi Asamamir',
			'injeksi_asamamir_stn' => 'Injeksi Asamamir Stn',
			'ph_create_time' => 'Ph Create Time',
			'ph_udpate_time' => 'Ph Udpate Time',
			'ph_create_loginid' => 'Ph Create Loginid',
			'ph_update_loginid' => 'Ph Update Loginid',
			'ph_create_ruanganid' => 'Ph Create Ruanganid',
			'ph_create_iphost' => 'Ph Create Iphost',
			'tglpenggunaanawal'=>'Tanggal Penggunaan Awal',
			'heparin_dosissirkulasi'=>'Dosis Sirkulasi',
			'iso_uf_ml'=>'Iso UF',
			'lama_uso_uf'=>'Lama Iso',
			'penyulit_teknis'=>'Penyulit Teknis',
			'resephd_id'=>'Resep HD',
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

		$criteria->compare('periksahd_id',$this->periksahd_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('aksesvaskular_id',$this->aksesvaskular_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('jenishd_id',$this->jenishd_id);
		$criteria->compare('jenisdialisat_id',$this->jenisdialisat_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('jenistransfusi_id',$this->jenistransfusi_id);
		$criteria->compare('periksahd_tgl',$this->periksahd_tgl,true);
		$criteria->compare('dialiserke',$this->dialiserke);
		$criteria->compare('suhudialisis_c',$this->suhudialisis_c,true);
		$criteria->compare('periksahd_penyulit',$this->periksahd_penyulit,true);
		$criteria->compare('lamahd_jam',$this->lamahd_jam,true);
		$criteria->compare('uf_goal',$this->uf_goal,true);
		$criteria->compare('kec_darah_qb',$this->kec_darah_qb,true);
		$criteria->compare('kec_dialisat_qd',$this->kec_dialisat_qd,true);
		$criteria->compare('heparin_dosisawal',$this->heparin_dosisawal,true);
		$criteria->compare('heparin_continyu',$this->heparin_continyu,true);
		$criteria->compare('heparin_intermiten',$this->heparin_intermiten,true);
		$criteria->compare('tanpaheparin_nama',$this->tanpaheparin_nama,true);
		$criteria->compare('tanpaheparin_jml',$this->tanpaheparin_jml,true);
		$criteria->compare('heparin_lmwh',$this->heparin_lmwh,true);
		$criteria->compare('jmllabudarah',$this->jmllabudarah);
		$criteria->compare('bb_pra_hd_kg',$this->bb_pra_hd_kg,true);
		$criteria->compare('bb_post_hd_kg',$this->bb_post_hd_kg,true);
		$criteria->compare('bb_kering_kg',$this->bb_kering_kg,true);
		$criteria->compare('is_ultrafiltrasi',$this->is_ultrafiltrasi);
		$criteria->compare('ultrafiltrasi_mode',$this->ultrafiltrasi_mode,true);
		$criteria->compare('is_natrium',$this->is_natrium);
		$criteria->compare('natrium_mode',$this->natrium_mode,true);
		$criteria->compare('is_bicarbonat',$this->is_bicarbonat);
		$criteria->compare('bicarbonat_mode',$this->bicarbonat_mode,true);
		$criteria->compare('pre_dialisis_bun',$this->pre_dialisis_bun,true);
		$criteria->compare('post_dialisis_bun',$this->post_dialisis_bun,true);
		$criteria->compare('adekuasi_urr',$this->adekuasi_urr,true);
		$criteria->compare('adekuasi_kt_v',$this->adekuasi_kt_v,true);
		$criteria->compare('obat_hemapo',$this->obat_hemapo,true);
		$criteria->compare('obat_hemapo_stn',$this->obat_hemapo_stn,true);
		$criteria->compare('obat_recormon',$this->obat_recormon,true);
		$criteria->compare('obat_recormon_stn',$this->obat_recormon_stn,true);
		$criteria->compare('obat_eprex',$this->obat_eprex,true);
		$criteria->compare('obat_eprex_stn',$this->obat_eprex_stn,true);
		$criteria->compare('obat_epotrex',$this->obat_epotrex,true);
		$criteria->compare('obat_epotrex_stn',$this->obat_epotrex_stn,true);
		$criteria->compare('obat_epodion',$this->obat_epodion,true);
		$criteria->compare('obat_epodion_stn',$this->obat_epodion_stn,true);
		$criteria->compare('injeksi_preb_besi',$this->injeksi_preb_besi,true);
		$criteria->compare('injeksi_preb_besi_stn',$this->injeksi_preb_besi_stn,true);
		$criteria->compare('injeksi_asamamir',$this->injeksi_asamamir,true);
		$criteria->compare('injeksi_asamamir_stn',$this->injeksi_asamamir_stn,true);
		$criteria->compare('ph_create_time',$this->ph_create_time,true);
		$criteria->compare('ph_udpate_time',$this->ph_udpate_time,true);
		$criteria->compare('ph_create_loginid',$this->ph_create_loginid);
		$criteria->compare('ph_update_loginid',$this->ph_update_loginid);
		$criteria->compare('ph_create_ruanganid',$this->ph_create_ruanganid);
		$criteria->compare('ph_create_iphost',$this->ph_create_iphost,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	} 
    

     public static function getItemsHeparin_Continyu()
	{
            $data = array();
            $criteria = new CDbCriteria(); 
            $criteria->select= "heparin_continyu";
            $criteria->order = "heparin_continyu"; 
            $criteria->group ="heparin_continyu";
            $models=self::model()->findAll($criteria);
            if(count((array)$models) > 0){
                foreach($models as $model) 
                    if($model->heparin_continyu != 0) {
                    $data[$model->heparin_continyu]= $model->heparin_continyu; 
                    }
            }else{
                $data[""] = null;
            }
            
            return $data;
	} 
    
    public static function getItemsPrep_besi() 
    {      
            $data = array();
            $criteria = new CDbCriteria(); 
            $criteria->select= "injeksi_preb_besi";
            $criteria->order = "injeksi_preb_besi"; 
            $criteria->group ="injeksi_preb_besi";
            $models=self::model()->findAll($criteria);
            if(count((array)$models) > 0){
                foreach($models as $model) 
                    if($model->injeksi_preb_besi != 0){
                    $data[$model->injeksi_preb_besi]= $model->injeksi_preb_besi; 
                    }
            }else{
                $data[""] = null;
            }
            
            return $data;
    } 
    
    public static function getItemsUltrafiltrasi_Mode() 
    {
            $data = array();
            $criteria = new CDbCriteria();
            $criteria->select="ultrafiltrasi_mode"; 
            $criteria->order ="ultrafiltrasi_mode";
            $criteria->group ="ultrafiltrasi_mode"; 
            $models=self::model()->findAll($criteria);
            if(count((array)$models) > 0) {
                foreach($models as $model)  
                    if($model->ultrafiltrasi_mode != null) {
                    $data[$model->ultrafiltrasi_mode] = $model->ultrafiltrasi_mode; 
                    }
            }else{
                $data[""] = null;
            } 
            return $data;
    } 
    
    public static function getItemsNatrium_mode()
    {
        $data = array();
        $criteria = new CDbCriteria();
        $criteria->select="natrium_mode";
        $criteria->order="natrium_mode";
        $criteria->group="natrium_mode"; 
        $models=self::model()->findAll($criteria); 
        if(count((array)$models) > 0) {
            foreach($models as $model) 
                if($model->natrium_mode != null) {
                $data[$model->natrium_mode] = $model->natrium_mode; 
                }
        }else{
            $data[""] = null;
        }
        return $data;        
        
    }
    
    public static function getJenisDialisat()
	{
		$data = array();
		$criteria = new CDbCriteria();
		$criteria->addCondition("jenisdialisat_aktif IS TRUE");
		$models = JenisdialisatM::model()->findAll($criteria);
		if(count((array)$models) > 0){
			foreach($models as $model)
				$data[$model->jenisdialisat_id] = strtoupper($model->jenisdialisat_nama).'&nbsp; &nbsp;';
		}else{
			$data[""] = null;
		}

		return $data;
	}
}