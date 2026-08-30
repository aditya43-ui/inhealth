<?php

class PPInfoKunjunganV extends InfokunjunganV
{
	
        public $instalasi=array();//untuk menampung variable Instalasi
        public $statusPasien=array(); //untuk menampung variable Status Pasien
        public $rujukan=array(); //untuk menampung variable rujukan non rujukan
        public $tgl_awal; //tanggal Awal Pencarian
        public $tgl_akhir; //tanggal Akhir Pencarian
        public $datangLangsung;// variable ini dipindahkan ke model utama
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

        public function searchRJRD()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

			$criteria=new CDbCriteria;
			echo $this->propinsi_id;
			$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
			$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
			$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
			$criteria->compare('rt',$this->rt);
			$criteria->compare('rw',$this->rw);
			if(!empty($this->carabayar_id)){
				$criteria->addCondition("carabayar_id' = ".$this->carabayar_id);			
			}
			if(!empty($this->penjamin_id)){
				$criteria->addCondition("penjamin_id' = ".$this->penjamin_id);			
			}
			if(!empty($this->instalasi)){
				$criteria->addCondition("instalasi_id' = ".$this->instalasi);			
			}
			if(!empty($this->propinsi_id)){
				$criteria->addCondition("propinsi_id' = ".$this->propinsi_id);			
			}
			if(!empty($this->kabupaten_id)){
				$criteria->addCondition("kabupaten_id' = ".$this->kabupaten_id);			
			}
			if(!empty($this->kecamatan_id)){
				$criteria->addCondition("kecamatan_id' = ".$this->kecamatan_id);			
			}
			if(!empty($this->kelurahan_id)){
				$criteria->addCondition("kelurahan_id' = ".$this->kelurahan_id);			
			}
			$criteria->addBetweenCondition('date(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
                if($this->datangLangsung=='true')
                    { //Jika Memilih Kunjungan Langsung
                        if(($this->byphone=='1')? $this->byphone='TRUE' : $this->byphone='FALSE');
                        if(($this->kunjunganrumah=='1')? $this->kunjunganrumah='TRUE' : $this->kunjunganrumah='FALSE');

                        $criteria->addCondition('(byphone=FALSE AND kunjunganrumah=FALSE)
                                                 OR (byphone='.$this->byphone.') 
                                                 OR (kunjunganrumah='.$this->kunjunganrumah.')');
                        
                        //Dibalikin lagi jadi satu karena kalo tidak dibalikin di viewnya byphone Anda kunjungan rumah
                        //jadi tidak ter cheklist (Hanya Untuk Tampilan lebih User Friendly)
                        if(($this->byphone=='TRUE')? $this->byphone=1 : $this->byphone=0);
                        if(($this->kunjunganrumah=='TRUE')? $this->kunjunganrumah=1 : $this->kunjunganrumah=0);
                    }
                else
                    {
                        if($this->byphone==1)
                           {
                                $criteria->compare('byphone',$this->byphone);
                           }
                        if($this->kunjunganrumah==1)
                           {
                                $criteria->compare('kunjunganrumah',$this->kunjunganrumah);
                           }    
                    }
                
                
                if(empty($this->rujukan) or count((array)$this->rujukan)>1) 
                    {  //Jika User Tidak Memilih Rujukan & Non Rujukan ataupun User memilih Keduanya
                         $criteria->addCondition('rujukan_id IS NOT NULL OR rujukan_id IS NULL');
                    }
                else
                    {   //Jika user Memilih Rujukan atw non rujukan
                         $criteria->addCondition('rujukan_id '.$this->rujukan[0].'');
                    }
                    
                for($i=0; $i<=count((array)$this->statusPasien); $i++)
                    {
                          $criteria->compare('LOWER(statuspasien)',strtolower($this->statusPasien[0]),true);
                    }
		
		$criteria->compare('UPPER(statusperiksa)',  strtoupper($this->statusperiksa),true);
//                echo $this->statusperiksa.$this->tgl_awal.$this->tgl_akhir;

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                ));
        }
        
         public function getPropinsiItems()
            {
                return PropinsiM::model()->findAllByAttributes(array('propinsi_aktif'=>true),array('order'=>'propinsi_nama'));
            }
         public function getJenisKasusPenyakitItems()
            {
                return JeniskasuspenyakitM::model()->findAllByAttributes(array('jeniskasuspenyakit_aktif'=>true),array('order'=>'jeniskasuspenyakit_nama'));
            }
            
         protected function afterFind(){
            foreach($this->metadata->tableSchema->columns as $columnName => $column){

                if (!strlen($this->$columnName)) continue;

                if ($column->dbType == 'date'){                         
                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
                        }elseif ($column->dbType == 'datetime'){
                                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss'));
                        }
            }
            return true;
        }  
        
         protected function beforeValidate ()
            {
                // convert to storage format
                //$this->tglrevisimodul = date ('Y-m-d', strtotime($this->tglrevisimodul));
                $format = new MyFormatter();
                //$this->tglrevisimodul = $format->formatDateTimeForDb($this->tglrevisimodul);
                foreach($this->metadata->tableSchema->columns as $columnName => $column){
                        if ($column->dbType == 'date'){
                                $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                        }elseif ($column->dbType == 'datetime'){
                                $this->$columnName = date('Y-m-d H:i:s', CDateTimeParser::parse($this->$columnName, Yii::app()->locale->dateFormat));
                        }

                }

                return parent::beforeValidate ();
            }    
}