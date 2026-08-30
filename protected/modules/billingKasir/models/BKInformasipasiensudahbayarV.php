<?php

class BKInformasipasiensudahbayarV extends InformasipasiensudahbayarV
{
    public $tgl_awal;
    public $tgl_akhir;
    public $tgl_bkm_awal;
    public $tgl_bkm_akhir;
    public $ceklis;
    public $pendaftaran;
	public $ruanganakhir_id;
	public $instalasiakhir_id;
	public $instalasiakhir_nama;
	public $ruanganakhir_nama;
   
    

    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }

    public function searchInformasi()
    {
		$criteria=new CDbCriteria;
		if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
			$criteria->addBetweenCondition('date(t.tglpembayaran)',$this->tgl_awal,$this->tgl_akhir);
		}
		$criteria->select = " t.* , rakhir.ruangan_id as ruanganakhir_id, iakhir.instalasi_id as instalasiakhir_id, rakhir.ruangan_nama as ruanganakhir_nama, iakhir.instalasi_nama as instalasiakhir_nama";
		$criteria->join = " JOIN ruangan_m rakhir ON rakhir.ruangan_id = t.ruangan_id 
							JOIN instalasi_m iakhir ON iakhir.instalasi_id = rakhir.instalasi_id 
                            join pembayaranpelayanan_t pp on pp.pembayaranpelayanan_id = t.pembayaranpelayanan_id and pp.orderbatalpembayaranpelayanan_id is null";
		if(!empty($this->pembayaranpelayanan_id)){
			$criteria->addCondition('t.pembayaranpelayanan_id = '.$this->pembayaranpelayanan_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('t.pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition('t.pasienadmisi_id = '.$this->pasienadmisi_id);
		}
		$criteria->compare('LOWER(t.nobuktibayar)',strtolower($this->nobuktibayar),true);
		$criteria->compare('LOWER(t.instalasi)',strtolower($this->instalasi),true);
		$criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(t.nopembayaran)',strtolower($this->nopembayaran),true);
		$criteria->compare('LOWER(t.no_identitas_pasien)',strtolower($this->no_identitas_pasien),true);
		if(!empty($this->no_rekam_medik)){
			if(is_array($this->no_rekam_medik)){
				$criteria->addInCondition('t.no_rekam_medik',$this->no_rekam_medik);

			}else{
				$criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);

			}
		}
		// $criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(t.nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(t.carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('LOWER(t.penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('t.totalbiayapelayanan',$this->totalbiayapelayanan);
		$criteria->compare('t.totalsubsidiasuransi',$this->totalsubsidiasuransi);
		$criteria->compare('t.totalsubsidipemerintah',$this->totalsubsidipemerintah);
		$criteria->compare('t.totalsubsidirs',$this->totalsubsidirs);
		$criteria->compare('t.totaliurbiaya',$this->totaliurbiaya);
		$criteria->compare('t.totaldiscount',$this->totaldiscount);
		$criteria->compare('t.totalpembebasan',$this->totalpembebasan);
		$criteria->compare('t.totalbayartindakan',$this->totalbayartindakan);
        $criteria->compare('t.petugasadministrasi_id',$this->petugasadministrasi_id);
        $criteria->compare('t.kelaspelayanan_id',$this->kelaspelayanan_id);
        $criteria->compare('t.kelastanggungan_id',$this->kelastanggungan_id);
        $criteria->compare('t.kamarruangan_id',$this->kamarruangan_id);
		if(!empty($this->tandabuktibayar_id)){
			$criteria->addCondition('t.tandabuktibayar_id = '.$this->tandabuktibayar_id);
		}
		if(!empty($this->returbayarpelayanan_id)){
			$criteria->addCondition('t.returbayarpelayanan_id = '.$this->returbayarpelayanan_id);
		}
		if(!empty($this->closingkasir_id)){
                    if ($this->closingkasir_id == 1):
                        $criteria->addCondition('t.closingkasir_id is not null ');                                        
                    elseif ($this->closingkasir_id == 2):
                        $criteria->addCondition('t.closingkasir_id is null ');
                    endif;
		}
              //  else
              //  {
                  //  $criteria->addCondition('closingkasir_id = '.$this->closingkasir_id);
              //  }
		$criteria->compare('LOWER(t.ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->ruanganakhir_id)){
			$criteria->addCondition('rakhir.ruangan_id = '.$this->ruanganakhir_id);
		}
		if(!empty($this->instalasiakhir_id)){
			$criteria->addCondition('iakhir.instalasi_id = '.$this->instalasiakhir_id);
		}
		//$criteria->addCondition('ruangankasir_id = '.Yii::app()->user->getState('ruangan_id'));
		$criteria->compare('LOWER(t.ruangankasir_nama)',strtolower($this->ruangankasir_nama),true);
		$criteria->order = "t.tglbuktibayar DESC"; 
                
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
    }
    public function getRuanganItems()
        {
          return RuanganM::model()->findAllByAttributes(array('ruangan_aktif'=>'TRUE','instalasi_id'=>array(Params::INSTALASI_ID_RJ, Params::INSTALASI_ID_RI, Params::INSTALASI_ID_RD, Params::INSTALASI_ID_LAB, Params::INSTALASI_ID_RAD, Params::INSTALASI_ID_REHAB)),array('order'=>'ruangan_nama'));
            
        }
	
	public function actionCekLoginBatalBayar($task='BatalBayar') 
		{
			if(Yii::app()->request->isAjaxRequest){
				$username = $_POST['username'];
				$password = $_POST['password'];
				$idRuangan = Yii::app()->user->getState('ruangan_id');

				$user = LoginpemakaiK::model()->findByAttributes(array('nama_pemakai' => $username,
																	   'loginpemakai_aktif' =>TRUE));
				if ($user === null) {
					$data['error'] = "Login Pemakai salah!";
					$data['cssError'] = 'username';
					$data['status'] = 'Gagal Login';
				} else {
					// cek password
					if ($user->katakunci_pemakai !== $user->encrypt($password)) {
						$data['error'] = 'password salah!';
						$data['cssError'] = 'password';
						$data['status'] = 'Gagal Login';
					} else {
						// cek ruangan
						$ruangan_user = RuanganpemakaiK::model()->findByAttributes(array('loginpemakai_id'=>$user->loginpemakai_id,
																						 'ruangan_id'=> $idRuangan));
						if($ruangan_user===null) {
							$data['error'] = 'ruangan salah!';
							$data['status'] = 'Gagal Login';
						} else {
							$data['error'] = '';
							$cek = $this->checkAccess(array('loginpemakai_id'=>$user->loginpemakai_id)); //dari MyAuthController
							if($cek){
								$data['status'] = 'success';
								$data['userid'] = $user->loginpemakai_id;
								$data['username'] = $user->nama_pemakai;
							} else {
								$data['status'] = 'Anda tidak memiliki hak melakukan proses ini!';
							}
						}
					}
				}

				echo json_encode($data);
				Yii::app()->end();
			}
		}                       
        
        public function getNamaSapaan($no_rekam_medik)
        {
            $sapaan = PasienM::model()->findAllByAttributes(array('no_rekam_medik'=>$no_rekam_medik));
            
            $data = "";
            if($sapaan == null):
                $data = "";
            else:
                foreach($sapaan as $sapaan):
                    $data =  $sapaan->namadepan;
                endforeach;
            endif;
                        
            return $data;
        }
        
        
}