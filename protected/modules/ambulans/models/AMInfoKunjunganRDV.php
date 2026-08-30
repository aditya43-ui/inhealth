<?php

class AMInfoKunjunganRDV extends InfokunjunganrdV
{
         public $ceklis = false;
         public $tgl_awal,$tgl_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfokunjunganrdV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchRD()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
		$criteria->compare('LOWER(statusmasuk)',strtolower($this->statusmasuk),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('propinsi_id',$this->propinsi_id);
		$criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
		$criteria->compare('kabupaten_id',$this->kabupaten_id);
		$criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
		$criteria->compare('kecamatan_id',$this->kecamatan_id);
                
                if($this->ceklis) {
                    $criteria->addBetweenCondition('DATE(tgl_pendaftaran)',$this->tgl_awal,$this->tgl_akhir);
                }
                
		$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
		$criteria->compare('kelurahan_id',$this->kelurahan_id);
		$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		$criteria->compare('rujukan_id',$this->rujukan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        protected function afterFind(){
            foreach($this->metadata->tableSchema->columns as $columnName => $column){

                if (!strlen($this->$columnName)) continue;

                if ($column->dbType == 'date') {                         
                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
                        } elseif ($column->dbType == 'timestamp without time zone') {
                                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss','medium',null));
                        }
            }
            return true;
        }
        
        
        function getNamaPasienNamaBin()
        {
        	if(!empty($this->nama_bin))	{
            	return $this->nama_pasien.' alias '.$this->nama_bin;
            }else{
            	return $this->nama_pasien;
            }
        }
        
        
        public function getInsatalasiRuangan()
        {
               
            return $this->instalasi_nama.' / '.$this->ruangan_nama;
        }
        
        public function getStatus($status, $id)
    {
        $pendaftaran = PendaftaranT::model()->findByPk($id);
        $selisih = time() - strtotime($pendaftaran->tgl_pendaftaran);
        $selisih_waktuperiksa = time() - strtotime($pendaftaran->waktumulaiperiksa);
        $pulang = PasienpulangT::model()->findByAttributes(array(
            'pendaftaran_id'=>$id, 
            'pasienbatalpulang_id' => null,
        ));


        if (!empty($pulang)) {  
            $format = new MyFormatter();
            $tgl_pulang = $format->formatDateTimeForDb($pulang->tglpasienpulang);
            $selisih = time() - strtotime($tgl_pulang);
        }
        
        // untuk antrian di ambil dari tgl pendaftaran sampe tanggal antrian
        if ($selisih < 60) {
            $selisih = $selisih."d";
        } elseif ($selisih < 3600) {
            $selisih = floor($selisih/60)."m";
        } elseif ($selisih < (3600 * 24)) {
            $selisih = floor($selisih/3600)."j";
        } else {
            $selisih = floor($selisih/(3600 * 24))."h";
        }
        // end
   
        // untuk antrian di ambil dari tgl pendaftaran sampe tanggal antrian
        if ($selisih_waktuperiksa < 60) {
            $selisih_waktuperiksa = $selisih_waktuperiksa."d";
        } elseif ($selisih_waktuperiksa < 3600) {
            $selisih_waktuperiksa = floor($selisih_waktuperiksa/60)."m";
        } elseif ($selisih_waktuperiksa < (3600 * 24)) {
            $selisih_waktuperiksa = floor($selisih_waktuperiksa/3600)."j";
        } else {
            $selisih_waktuperiksa = floor($selisih_waktuperiksa/(3600 * 24))."h";
        }
        //end
        
        $status = trim($status);
        if ($status == "SEDANG PERIKSA") {
            $badge = '<span class="badge badge-info pull-right badge-status">'.$selisih_waktuperiksa.'</span>';
            $status = '<button id="red" class="btn btn-gold nohover btn-status" name="yt1">'.$status.'</button>';
            $status = '<div class="button-status">'.$badge.$status.'</div>';
        } elseif ($status == "ANTRIAN") {
            $badge = '<span class="badge badge-info pull-right badge-status">'.$selisih.'</span>';
            $status = '<button id="green" class="btn btn-black nohover btn-status" name="yt1">'.$status.'</button>';
            $status = '<div class="button-status">'.$badge.$status.'</div>';
        } elseif ($status == "SUDAH PULANG") {
            $status = '<button id="blue" class="btn btn-green nohover btn-status" name="yt1" >'.$status.'</button>';
        } elseif ($status == "SUDAH DI PERIKSA") {
            $status = '<button id="orange" class="btn btn-blue nohover btn-status"  name="yt1">'.$status.'</button>';
        } elseif ($status == "SEDANG DIRAWAT INAP") {
            $admisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id'=>$id));
            $selisih = ceil((time() - strtotime($admisi->tgladmisi)) / (3600 * 24))."h";
            $badge = '<span class="badge badge-info pull-right badge-status">'.$selisih.'</span>';
            $status = '<button id="orange" class="btn btn-purple nohover btn-status"  name="yt1">'.$status.'</button>';
            $status = '<div class="button-status">'.$badge.$status.'</div>';
        } elseif ($status == "MENUNGGU ADMISI PASIEN") {
            $badge = '<span class="badge badge-info pull-right badge-status">'.$selisih.'</span>';
            $status = '<button id="orange" class="btn btn-orange nohover btn-status"  name="yt1">'.$status.'</button>';
            $status = '<div class="button-status">'.$badge.$status.'</div>';
        } else {
            $status = '<button id="orange" class="btn btn-blue nohover btn-status"  name="yt1">'.$status.'</button>';
        }
        return $status;
    }
	
}