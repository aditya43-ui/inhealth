<?php
class PPAntrianT extends AntrianT
{
    public $namaLoket,$tgl_awal,$tgl_akhir,$tgl_pendaftaran,$no_pendaftaran,$waktupanggilpasien,$tgl_panggilan,$waktumulaiperiksa
    ,$tglpasienpulang,$noantrian_loket,$statusdaftar,$prefix_pendaftaran;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AntrianT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
	 * @return array validation rules for model attributes.
         * melepas elemen required
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, carabayar_id, pendaftaran_id, profilrs_id, loket_id', 'numerical', 'integerOnly'=>true),
			array('noantrian', 'length', 'max'=>6),
			array('statuspasien, carabayar_loket', 'length', 'max'=>50),
			array('panggil_flaq', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('antrian_id, ruangan_id, carabayar_id, pendaftaran_id, profilrs_id, tglantrian, noantrian, statuspasien, carabayar_loket, panggil_flaq, loket_id', 'safe', 'on'=>'search'),
		);
	}
        
        public function criteriaSearch(){
            $criteria = new CDbCriteria();
            $criteria->compare('DATE(tglantrian)', date("Y-m-d"));
            return $criteria;
        }
        /**
         * menentukan antrian berikutnya
         * @return null
         */

         public function searchAntrian()
         {
             // @todo Please modify the following code to remove attributes that should not be searched.
     
             $criteria=new CDbCriteria;
             $criteria->join ='JOIN pendaftaran_t p on p.pendaftaran_id = t.pendaftaran_id '
                             .'JOIN pasien_m pa on pa.pasien_id = p.pasien_id '
                             .'JOIN pasienpulang_t pas on pas.pendaftaran_id = p.pendaftaran_id '
                             .'JOIN ruangan_m r on r.ruangan_id = p.pendaftaran_id ';
     
             $criteria->select = 'p.*, pa.*, pas.*';
     
             //$criteria->compare('t.formlab_id',$this->formlab_id);
             //$criteria->compare('p.pemeriksaanlab_id',$this->pemeriksaanlab_id);
             $criteria->compare('p.pendaftaran_id',$this->pendaftaran_id);
             $criteria->compare('LOWER(p.tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
             $criteria->compare('LOWER(p.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
             $criteria->compare('LOWER(p.waktupanggilpasien)',strtolower($this->waktupanggilpasien),true);
             $criteria->compare('LOWER(pa.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
             $criteria->compare('LOWER(t.noantrian)',strtolower($this->noantrian),true);
             $criteria->compare('LOWER(t.tgl_panggilan)',strtolower($this->tgl_panggilan),true);
             $criteria->compare('LOWER(t.waktumulaiperiksa)',strtolower($this->waktumulaiperiksa),true);
             $criteria->compare('LOWER(pa.nama_pasien)',strtolower($this->nama_pasien),true);
             $criteria->compare('LOWER(pas.tglpasienpulang)',strtolower($this->tglpasienpulang),true);
             $criteria->compare('LOWER(r.ruangan_nama)',strtolower($this->ruangan_nama),true);
            
             return new CActiveDataProvider($this, array(
                 'criteria'=>$criteria,
             ));
         }


        public function getAntrianBerikut()
        {
            $criteria = $this->criteriaSearch();
            if (!empty($this->antrian_id)){
                $criteria->addCondition("antrian_id > ".$this->antrian_id);
            }else{
                $criteria->addCondition("antrian_id IS NULL");
            }
            $criteria->addCondition("jenis_kunjungan!='". "Fast Track'");
            $criteria->addCondition("pendaftaran_id IS NULL");
            $criteria->addCondition("panggil_flaq = false");
			if(!empty($this->modelantrian_id)){$criteria->addCondition("modelantrian_id = ".$this->modelantrian_id); }
            $criteria->order = "modelantrian_id ASC, antrian_id::integer ASC";
            $criteria->limit = 1;
            
            $record=self::model()->find($criteria);
            
            if($record!==null)
                return $record;
            return null;
        }

        public function getAntrianBerikutFast()
        {
            $criteria = $this->criteriaSearch();
            if (!empty($this->antrian_id)){
                $criteria->addCondition("antrian_id > ".$this->antrian_id);
            }else{
                $criteria->addCondition("antrian_id IS NULL");
            }
            $criteria->addCondition("jenis_kunjungan='". "Fast Track'");
            $criteria->addCondition("pendaftaran_id IS NULL");
            $criteria->addCondition("panggil_flaq = false");
			if(!empty($this->modelantrian_id)){$criteria->addCondition("modelantrian_id = ".$this->modelantrian_id); }
            $criteria->order = "modelantrian_id ASC, antrian_id::integer ASC";
            $criteria->limit = 1;
            
            $record=self::model()->find($criteria);
            
            if($record!==null)
                return $record;
            return null;
        }

        public function getAntrianTerkecil()
        {
            $criteria = $this->criteriaSearch();
            $criteria->addCondition("pendaftaran_id IS NULL");
            $criteria->addCondition("panggil_flaq = false");
			if(!empty($this->modelantrian_id)){$criteria->addCondition("modelantrian_id = ".$this->modelantrian_id); }
            $criteria->order = "modelantrian_id ASC, antrian_id::integer ASC";
            $criteria->limit = 1;
            
            $record=self::model()->find($criteria);
            
            if($record!==null)
                return $record;
            return null;
        }
        /**
         * menentukan antrian sebelumnya
         * @return null
         */
        public function getAntrianSebelum()
        {
            $criteria = $this->criteriaSearch();
            if (!empty($this->antrian_id)){
                $criteria->addCondition("antrian_id < ".$this->antrian_id);
            }else{
                $criteria->addCondition("antrian_id IS NULL");
            }
            $criteria->addCondition("jenis_kunjungan='". "Fast Track'");
            $criteria->addCondition("pendaftaran_id IS NULL");
            if (!empty($this->modelantrian_id)){
                $criteria->addCondition("modelantrian_id = ".$this->modelantrian_id);
            }else{
                $criteria->addCondition("antrian_id IS NULL");
            }
            $criteria->order = "modelantrian_id DESC, antrian_id::integer DESC";
            $criteria->limit = 1;
            
            $record=self::model()->find($criteria);

            if($record === null) {
                $criteria = $this->criteriaSearch();
                if (!empty($this->antrian_id)){
                    $criteria->addCondition("antrian_id < ".$this->antrian_id);
                }else{
                    $criteria->addCondition("antrian_id IS NULL");
                }
                $criteria->addCondition("pendaftaran_id IS NULL");
                if (!empty($this->modelantrian_id)){
                    $criteria->addCondition("modelantrian_id = ".$this->modelantrian_id);
                }else{
                    $criteria->addCondition("antrian_id IS NULL");
                }
                $criteria->order = "modelantrian_id DESC, antrian_id::integer DESC";
                $criteria->limit = 1;
                
                $record=self::model()->find($criteria);

                if($record===null) {
                    $criteria = $this->criteriaSearch();
                    $criteria->addCondition("pendaftaran_id IS NULL");
                    $criteria->addCondition("jenis_kunjungan!='". "Fast Track'");
                    if(!empty($this->modelantrian_id)){$criteria->addCondition("modelantrian_id = ".$this->modelantrian_id); }
                    $criteria->order = "modelantrian_id DESC, antrian_id::integer DESC";
                    $criteria->limit = 1;
                    
                    $record=self::model()->find($criteria);
                }
            }

            if($record!==null)
                return $record;
            return null;
        }
        
        /**
         * menampilkan loket antrian (loket_m)
         */
        public function getLokets($loket_id = null, $israwatinap = false){
            $data = array();
            $criteria = new CDbCriteria();
            if (!empty($loket_id)){
                $criteria->addCondition("loket_id = ".$loket_id);
            }
            $criteria->addCondition("ispendaftaran = TRUE");
            
           // if ($israwatinap) $criteria->addCondition("israwatinap = true");
           // else $criteria->addCondition("israwatinap = false");
            
            $criteria->addCondition("loket_aktif = TRUE");
            $criteria->order = "loket_nourut ASC";
            $modLokets = LoketM::model()->findAll($criteria);
            if(count((array)$modLokets) > 0){
                return $modLokets;
            }else{
                return array();
            }
        }
        
        /**
         * menampilkan lokasi_karcisantrian_m
         */
        public function getLokasiKarcisAntrian(){
            $data = array();
            $criteria = new CDbCriteria();
            $criteria->addCondition("lokasi_karcisantrian_aktif = TRUE");
            
            $criteria->order = "lokasi_karcisantrian_nama ASC";
            $modLokets = LokasiKarcisantrianM::model()->findAll($criteria);
            if(count((array)$modLokets) > 0){
                return $modLokets;
            }else{
                return array();
            }
        }
        
        public function getNamaLoketAntrian($id_nama_loket = null) {
            if(!empty($id_nama_loket)){
                $listLoket = LoketM::model()->findAllByAttributes(array('modelantrian_id'=>$id_nama_loket, 'ispendaftaran'=>TRUE, 'loket_aktif'=>TRUE), array('order'=>'loket_nama ASC'));
            }
            else{
                $listLoket = array();
            }
            return $listLoket;
        }
		
		public function getModelAntriansPendaftaran($modelantrian_id = null){
            $data = array();
            $criteria = new CDbCriteria();
            if (!empty($modelantrian_id)){
                $criteria->addCondition("modelantrian_id = ".$modelantrian_id);
            }
            $criteria->addCondition("modelantrian_aktif = TRUE");
            $criteria->order = "modelantrian_nama ASC";
            $modLoketsAlpha = ModelantrianM::model()->findAll($criteria);
            $modLokets = array();
            
            foreach ($modLoketsAlpha as $item) {
                $det = LoketM::model()->findByAttributes(array(
                    'modelantrian_id'=>$item->modelantrian_id,
                    'ispendaftaran'=>true,
                ));
                if (!empty($det)) {
                    $modLokets[] = $item;
                }
            }
            
            if(count((array)$modLokets) > 0){
                return $modLokets;
            }else{
                return array();
            }
        }


        public function getModelAntriansPendaftaranByCode($modelantrian_code = null){
            $data = array();
            $criteria = new CDbCriteria();
            if (!empty($modelantrian_code)){
                $criteria->compare("modelantrian_kode", $modelantrian_code);
            }
            $criteria->addCondition("modelantrian_aktif = TRUE");
            $criteria->order = "modelantrian_nama ASC";
            $modLoketsAlpha = ModelantrianM::model()->findAll($criteria);
            $modLokets = array();
            
            foreach ($modLoketsAlpha as $item) {
                $det = LoketM::model()->findByAttributes(array(
                    'modelantrian_id'=>$item->modelantrian_id,
                    'ispendaftaran'=>true,
                ));
                if (!empty($det)) {
                    $modLokets[] = $item;
                }
            }
            
            if(count((array)$modLokets) > 0){
                return $modLokets;
            }else{
                return array();
            }
        }

        public function getModelAntriansPendaftaranByCodes($modelantrian_codes = null){
            $data = array();
            $criteria = new CDbCriteria();
            if (!empty($modelantrian_codes)){
                // $criteria->compare("modelantrian_kode", );
                $criteria->addInCondition("modelantrian_kode", $modelantrian_codes);

            }
            $criteria->addCondition("modelantrian_aktif = TRUE");
            $criteria->order = "modelantrian_nama ASC";
            $modLoketsAlpha = ModelantrianM::model()->findAll($criteria);
            $modLokets = array();
            
            foreach ($modLoketsAlpha as $item) {
                $det = LoketM::model()->findByAttributes(array(
                    'modelantrian_id'=>$item->modelantrian_id,
                    'ispendaftaran'=>true,
                ));
                if (!empty($det)) {
                    $modLokets[] = $item;
                }
            }
            
            if(count((array)$modLokets) > 0){
                return $modLokets;
            }else{
                return array();
            }
        }

}