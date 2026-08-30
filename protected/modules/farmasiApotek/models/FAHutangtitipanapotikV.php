<?php

class FAHutangtitipanapotikV extends HutangtitipanapotikV
{
        public $tgl_awal, $tgl_akhir;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=new CDbCriteria;

		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);						
		}
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran);
		//$criteria->compare('LOWER(pasien_id)',strtolower($this->pasien_id),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik);
		if(!empty($this->jenisobatalkes_id)){
			$criteria->addCondition("jenisobatalkes_id = ".$this->jenisobatalkes_id);						
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition("pasien_id = ".$this->pasien_id);						
		}
		$criteria->compare('LOWER(instalasiasal_nama)',strtolower($this->instalasiasal_nama),true);
		$criteria->compare('LOWER(ruanganasal_nama)',strtolower($this->ruanganasal_nama),true);
	
		$criteria->compare('kso',$this->kso);
		$criteria->compare('netto',$this->netto);
                $criteria->group='tgl_pendaftaran,no_pendaftaran,pendaftaran_id,no_rekam_medik,pasien_id,namadepan,nama_pasien,instalasiasal_nama,ruanganasal_nama,kso';
//               $criteria->select=$criteria->group.',sum(jmlbayar_oa) as jmlbayar_oa, max(kso) as kso,sum(netto) as netto';
                  $criteria->select=$criteria->group;
                $criteria->order = 'tgl_pendaftaran, ruanganasal_nama,  nama_pasien ';
		
                return $criteria;
               
		
	}
        
        public function searchLaporan(){
            $criteria = $this->criteriaSearch();
            $criteria->addBetweenCondition('DATE(tgl_pendaftaran)',$this->tgl_awal, $this->tgl_akhir);
     //         $criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
            //$criteria->compare('create_ruangan',Yii::app()->user->getState('ruangan_id'));
           // $criteria->order = 'nama_pegawai, namaperujuk ASC';
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
          
        }
        
        public function searchPrintLaporan(){
            $criteria = $this->criteriaSearch();
            $criteria->addBetweenCondition('DATE(tgl_pendaftaran)',$this->tgl_awal, $this->tgl_akhir);
            $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
          
        }
        
         public function getSumJenisObat($groups = array(), $nama_kolom = null){
            $format = new MyFormatter();
//            $criteria=new CDbCriteria();
            $criteria = $this->criteriaSearch();
            
//            $criteria->group = 'pasien_id';
            foreach($groups AS $i => $group){
                if($group == 'jml'){
                  //  $criteria->group .= ', pendaftaran_id';
                    $criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran);
                    
                }
            }
              $criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran);
            if($nama_kolom == 'Alkes'){
                $criteria->addCondition('jenisobatalkes_id = 1' );
            }else if($nama_kolom == 'Gas'){
                $criteria->addCondition('jenisobatalkes_id = 11');
            }else if($nama_kolom == 'Obat'){
                $criteria->addNotInCondition('jenisobatalkes_id', array('11','1'));
              //  $criteria->addCondition('jenisobatalkes_id <> 11 and jenisobatalkes_id <> 1');
            }
            else if($nama_kolom == 'Bruto'){
                $criteria->select=$criteria->group.',sum(jmlbayar_oa) as jmlbayar_oa';
                // $criteria->addBetweenCondition('tgl_pendaftaran',$this->tgl_awal, $this->tgl_akhir);
                $modKirim = FAHutangtitipanapotikV::model()->findAll($criteria);
                $criteria->addBetweenCondition('DATE(tgl_pendaftaran)',$this->tgl_awal, $this->tgl_akhir);
                $totKirim = 0;
                foreach($modKirim as $key=>$kirim){
                    $totKirim += $kirim->jmlbayar_oa;
                }
                return $totKirim;
            }
            else if($nama_kolom == 'Netto'){
                $criteria->select=$criteria->group.',sum(netto) as netto';
              //   $criteria->addBetweenCondition('tgl_pendaftaran',$this->tgl_awal, $this->tgl_akhir);
                $modKirim = FAHutangtitipanapotikV::model()->findAll($criteria);
                $totKirim = 0;
                foreach($modKirim as $key=>$kirim){
                    $totKirim += $kirim->netto;
                }
                return $totKirim;
            }
            
            else if($nama_kolom == 'kso'){
                $criteria->select=$criteria->group.',max(kso) as kso';
                $modKirim = FAHutangtitipanapotikV::model()->findAll($criteria);
                $totKirim = 0;
                foreach($modKirim as $key=>$kirim){
                    $totKirim += $kirim->kso;
                }
                return $totKirim;
            }
            
//            if(isset($_GET['FAHutangtitipanapotikV'])){
//                $tgl_awal = $format->formatDateTimeForDb($_GET['FAHutangtitipanapotikV']['tgl_awal']);
//                $tgl_akhir = $format->formatDateTimeForDb($_GET['FAHutangtitipanapotikV']['tgl_akhir']);
//                //  $model->tgl_awal=$format->formatDateTimeForDb($_GET['FAHutangtitipanapotikV']['tgl_awal']);
//                 //   $model->tgl_akhir=$format->formatDateTimeForDb($_GET['FAHutangtitipanapotikV']['tgl_akhir']);
//                $jenisdiet_nama =$_GET['FAHutangtitipanapotikV']['nama_pasien'];
//                $criteria->addBetweenCondition('tgl_pendaftaran',$tgl_awal,$tgl_akhir);
//                $criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien));
//            }
         $criteria->select = $criteria->group.', sum(jmlbayar_oa) AS jmlbayar_oa';
            $modKirim = FAHutangtitipanapotikV::model()->findAll($criteria);
            $totKirim = 0;
            foreach($modKirim as $key=>$kirim){
                $totKirim += $kirim->jmlbayar_oa;
            }
            return $totKirim;
        }
        
}