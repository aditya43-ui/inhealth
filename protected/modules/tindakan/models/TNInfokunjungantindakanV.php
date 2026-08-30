<?php 

class TNInfokunjungantindakanV extends InfokunjungantindakanV {
    public $tgl_awal;
    public $tgl_akhir;
    public $jns_periode;
    public $bln_awal;
    public $bln_akhir;
    public $thn_awal;
    public $thn_akhir;
    public $data;
    public $jumlah;
    public $tick;
    public $statuspetiksa;
    public $tgl_pendaftaran;
    public $prefix_pendaftaran;
	public $tgl_awall,$tgl_akhirl;
    public $jenis_kunjungan;
	public $ceklis = false;

     /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PasienM the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchDaftarPasien() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        
        $criteria = new CDbCriteria;
        
        if(!empty($this->no_rekam_medik) || !empty($this->nama_pasien) || !empty($this->no_identitas_pasien) ){
            $criteria->compare('LOWER(t.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
            $criteria->compare('LOWER(t.nama_pasien)', strtolower($this->nama_pasien), true);
            $criteria->compare('LOWER(t.no_identitas_pasien)', strtolower($this->no_identitas_pasien), true);
        }else{
            $criteria->addBetweenCondition('DATE(t.tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
        }
        $criteria->compare('LOWER(t.no_pendaftaran)', strtolower($this->prefix_pendaftaran.$this->no_pendaftaran), true);
        $criteria->compare('LOWER(t.statusperiksa)', strtolower($this->statusperiksa), true);
        // $criteria->compare('LOWER(t.nama_pegawai)', strtolower($this->nama_pegawai), true);
        $criteria->compare('t.carabayar_id', $this->carabayar_id);
        $criteria->compare('t.penjamin_id', $this->penjamin_id);
		if($this->ceklis)
		{
			$criteria->addBetweenCondition('DATE(tanggal_lahir)', $this->tgl_awall, $this->tgl_akhirl);
		}

        // var_dump(Yii::app()->user->id);die;
        $criteria->addCondition('t.ruangan_id = '.$this->ruangan_id);
        if(Yii::app()->user->id != Params::LOGINPEMAKAI_ID_ADMIN) {
            $criteria->compare('t.pegawai_id', $this->pegawai_id);
        }
        // $criteria->join = 'JOIN pasienmasukpenunjang_t pv on t.pendaftaran_id = pv.pendaftaran_id';
        // $criteria->addCondition('pasienmasukpenunjang_id is null');
        $criteria->order = 't.jenis_kunjungan';
        //$criteria->condition = 'pasienpulang.pendaftaran_id = t.pendaftaran_id';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort'=>array(
                'defaultOrder'=>'t.no_urutantri asc',
            ),
            'pagination' => [
                'pageSize' => 50
            ]
        ));
    }

    public function getStatus($status,$id){
        
        if($status == "ANTRIAN"){
            $status = '<button id="green" class="btn btn-black nohover" name="yt1">'.$status.'</button>';
        }else if($status == "SEDANG PERIKSA"){
            $status = '<button id="red" class="btn btn-gold nohover" name="yt1" onclick="setStatus(this,\''.$status.'\','.$id.')">'.$status.'</button>';
        }else if($status == "SUDAH PULANG"){
            $status = '<button id="blue" class="btn btn-green nohover" name="yt1" onclick="setStatus(this,\''.$status.'\','.$id.')">'.$status.'</button>';
        }else if($status == "SUDAH DI PERIKSA"){
            $status = '<button id="orange" class="btn btn-blue nohover"  name="yt1" onclick="setStatus(this,\''.$status.'\','.$id.')">'.$status.'</button>';
        }else if($status == "SEDANG DIRAWAT INAP"){
            $status = '<button id="orange" class="btn btn-purple nohover"  name="yt1">'.$status.'</button>';
        }else if($status == "MENUNGGU ADMISI PASIEN"){
            $status = '<button id="orange" class="btn btn-orange nohover"  name="yt1">'.$status.'</button>';
        }
        else{
            $status = '<button id="orange" class="btn btn-blue nohover"  name="yt1">'.$status.'</button>';
        }
        return $status;
    }

    public function getAsalPoli()
    {
        $modelA = KonsulpoliT::model()->findByAttributes(array('pendaftaran_id' => $this->pendaftaran_id)); //, 'ruangan_id' => Yii::app()->user->getState('ruangan_id')
        if (!empty($modelA)) {
            $modelB = RuanganM::model()->findByAttributes(array('ruangan_id' => $modelA->asalpoliklinikkonsul_id));
            // return '<br/>Pasien konsul dari ' .$modelA->konsulpoli_id;
            if (Yii::app()->user->getState('ruangan_id') != $modelA->asalpoliklinikkonsul_id) {
                return '<br/><button class="btn nohover" name="yt1" style="color:#424242; background-color:#F0E68C">Pasien konsul dari ' . $modelB->ruangan_nama;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }


public function getRuanganItems($instalasi_id=null)
	{
		if($instalasi_id==null){
			return RuanganM::model()->findAllByAttributes(array(),array('order'=>'ruangan_nama' and 'ruangan_aktif true'));
		}else{
			return RuanganM::model()->findAllByAttributes(array('instalasi_id'=>$instalasi_id),array('order'=>'ruangan_nama' and 'ruangan_aktif true'));   
		}
	}
	

	
    public function getCaraBayarItems()
    {
        return CarabayarM::model()->findAll('carabayar_aktif=TRUE ORDER BY carabayar_nama ASC') ;
    }
    
    public function getTindakLanjut($status,$id,$nopen,$alih){
            if($status == "ANTRIAN" || $status == "BATAL PERIKSA" || $status == "DIBATALKAN"){
                $status = '<center><a id='.$id.' href="#" onclick="cekStatus(\''.$status.'\')" rel="tooltip" 
                                data-original-title="Klik untuk Proses Tindak Lanjut Pasien"><i class="icon-user"></i></a></center>';
            }else if($status == "SEDANG PERIKSA" || $status == "SUDAH PULANG"){
                 $status = "<center><a id=".$id." href=\"javascript:tindaklanjutrawatjalan('$id')\" rel=\"tooltip\" 
                                data-original-title=\"Klik untuk Proses Tindak Lanjut Pasien\"><i class=\"icon-user\"></i></a></center>";
            }else if(!empty($pasienpulang) || ($status==Params::STATUSPERIKSA_BATAL_PERIKSA) || $alih = true){
                $status = "<center>Pasien di Rawat Inap
                                <a id=".$id." href=\"javascript:cekHakAkses('$id')\" rel=\"tooltip\" 
                                    data-original-title=\"Klik untuk Batal Rawat Inap\"><i class=\"icon-remove\"></i></a></center>";
            }else{
                 $status = "<center><a id=".$id." href=\"javascript:tindaklanjutrawatjalan('$id')\" rel=\"tooltip\" 
                                data-original-title=\"Klik untuk Proses Tindak Lanjut Pasien\"><i class=\"icon-user\"></i></a></center>";
            }
        
        return $status;
    }
    
    public function getPenjaminItems()
    {
        return PenjaminpasienM::model()->findAll('penjamin_aktif=TRUE ORDER BY penjamin_nama ASC');
    }

    public function getLinkPeriksaPasien() {
        $pendaftaran = PendaftaranT::model()->findByPk($this->pendaftaran_id);
        $konsul = KonsulpoliT::model()->findByAttributes(array(
            'pendaftaran_id'=>$this->pendaftaran_id,
            'ruangan_id'=>Yii::app()->user->getState('ruangan_id'),
        ));
        
        
        // if ($this->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) {
        //    return CHtml::link("<i class='icon-form-periksa'></i><br>Periksa Pasien", '#', array("id"=>$this->no_pendaftaran,"rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien", "onclick"=>"myAlert('Pasien sudah dipulangkan.'); return false;"));
        //}
         
        if (!empty($konsul)) { //RSPMC-1645
            return CHtml::link("<i class='icon-form-periksa'></i><br>Periksa Pasien", Yii::app()->controller->createUrl("/tindakan/pemeriksaanPasien",array("pendaftaran_id"=>$this->pendaftaran_id)),array("id"=>$this->no_pendaftaran,"rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien"));
        }
        
         if (!empty($pendaftaran->pasienpulang_id)) {
             // return CHtml::link("<i class='icon-form-periksa'></i><br>Periksa Pasien", '#', array("id"=>$this->no_pendaftaran,"rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien", "onclick"=>"myAlert('Pasien sedang di rawat inap.'); return false;"));
         }
         /*if (empty($pendaftaran->pasien->dokrekammedis_id)){
             return CHtml::link("<i class='icon-form-periksa'></i> ", '#', array("id"=>$this->no_pendaftaran,"rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien", "onclick"=>"myAlert('Berkas Dokumen Rekam Medis belum dibuat.'); return false;"));
         }else{
             $dok = DokrekammedisM::model()->findByAttributes(array('pasien_id'=>$pendaftaran->pasien_id));
 
             if (empty($dok)){
                 return CHtml::link("<i class='icon-form-periksa'></i> ", '#', array("id"=>$this->no_pendaftaran,"rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien", "onclick"=>"myAlert('Berkas Dokumen Rekam Medis belum dibuat.'); return false;"));
             }else{
                 if (empty($this->pengirimanrm_id)){
                     return CHtml::link("<i class='icon-form-periksa'></i> ", '#', array("id"=>$this->no_pendaftaran,"rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien", "onclick"=>"myAlert('Berkas Dokumen Rekam Medis belum dikirim ruangan ini'); return false;"));
                 }else{
                    $kirim = PengirimanrmT::model()->findByPk($this->pengirimanrm_id);
                    
                    if ($kirim->ruanganpenerima_id != $this->ruangan_id){
                        return CHtml::link("<i class='icon-form-periksa'></i> ", '#', array("id"=>$this->no_pendaftaran,"rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien", "onclick"=>"myAlert('Berkas Dokumen Rekam Medis belum dikirim ruangan ini'); return false;"));
                    }else{
                        if (empty($kirim->petugaspenerima_id)){
                            return CHtml::link("<i class='icon-form-periksa'></i> ", '#', array("id"=>$this->no_pendaftaran,"rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien", "onclick"=>"myAlert('Berkas Dokumen Rekam Medis belum diterima'); return false;"));
                        }
                    }
                    //if ()
                }
            }
        }
          * 
          */
        
        
        
        
        
        if ($this->penjamin_id == Params::PENJAMIN_ID_UMUM) {
            
             if (!empty($pendaftaran->karcis_id)) {
                 $tindakan = TindakanpelayananT::model()->findByAttributes(array(
                     'pendaftaran_id'=>$this->pendaftaran_id,
                     'karcis_id'=>$pendaftaran->karcis_id,
                 ));
             } else {
                 if (empty($tindakan)) {
                     $tindakan = TindakanpelayananT::model()->findByAttributes(array(
                         'pendaftaran_id'=>$this->pendaftaran_id,
                         'ruangan_id'=>2,
                     ), array(
                         'condition'=>'karcis_id is not null'
                     ));
                 }
             }
             
             // return $tindakan->tindakanpelayanan_id;
             
             if (!empty($tindakan)) {
                 if (empty($tindakan->tindakansudahbayar_id)) {
                    // return CHtml::link("<i class='icon-form-periksa'></i> ", '#', array("id"=>$this->no_pendaftaran,"rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien", "onclick"=>"myAlert('Pasien belum membayar karcis.'); return false;"));
                 }
             }
        }
        
      
        
        //if (!$this->alihstatus) {
            return CHtml::link("<i class='icon-form-periksa'></i><br>Periksa Pasien", Yii::app()->controller->createUrl("/tindakan/pemeriksaanPasien",array("pendaftaran_id"=>$this->pendaftaran_id, 'pasienmasukpenunjang_id' => $this->pasienmasukpenunjang_id)),array("id"=>$this->no_pendaftaran,"rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien"));
        //} else {
        //    return CHtml::link("<i class='icon-list-alt'></i><br>Periksa Pasien", "javascript:cektindaklanjut()",array("rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien"));
        //}
    }
}