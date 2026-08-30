<?php
class LAPerawatanlinenT extends PerawatanlinenT
{
	public $pegmengetahui_nama,$pegperawat_nama;
	public $tgl_awal,$tgl_akhir,$instalasi_id,$ruangan_id;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PerawatanlinenT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->select = "t.perawatanlinen_id, t.noperawatan, t.tglperawatanlinen, t.keterangan_perawatan, t.iskirimkeluar, t.tglkirimkeluar, t.alasankirimkeluar, t.ketkirimkeluar, t.tgl_kembali";
                 $criteria->group =  $criteria->select;
//                $criteria->join = " LEFT JOIN penyimpananlinendet_t ON penyimpananlinendet_t.perawatanlinen_id = t.perawatanlinen_id";
                
		$criteria->addBetweenCondition('DATE(t.tglperawatanlinen)', $this->tgl_awal, $this->tgl_akhir,true);
		if(!empty($this->perawatanlinen_id)){
			$criteria->addCondition('t.perawatanlinen_id = '.$this->perawatanlinen_id);
		}
		$criteria->compare('LOWER(t.noperawatan)',strtolower($this->noperawatan),true);
//		$criteria->compare('LOWER(tglperawatanlinen)',strtolower($this->tglperawatanlinen),true);
		$criteria->compare('LOWER(t.keterangan_perawatan)',strtolower($this->keterangan_perawatan),true);
		if(!empty($this->pegperawatan_id)){
			$criteria->addCondition('t.pegperawatan_id = '.$this->pegperawatan_id);
		}
		if(!empty($this->pegmengetahui)){
			$criteria->addCondition('t.pegmengetahui = '.$this->pegmengetahui);
		}
		$criteria->compare('LOWER(t.create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(t.update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('t.create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->udpate_loginpemakai_id)){
			$criteria->addCondition('t.udpate_loginpemakai_id = '.$this->udpate_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('t.create_ruangan = '.$this->create_ruangan);
		}
		
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
	
	public function getRuanganIns($perawatanlinen_id, $ins) {
		$ruanganIns = '';
		$modPerDetail = PenerimaanpencucianlinenV::model()->findByAttributes(array('perawatanlinen_id'=>$perawatanlinen_id));
		if(!empty($modPerDetail)){
			if($ins == 'ruangan'){
				$ruanganIns = $modPerDetail->ruangan_nama;
			}
			else{
				$ruanganIns = $modPerDetail->instalasi_nama;
			}
		}
		
		return $ruanganIns;
	}
	
        public function checkpenyimpananLinen($perawatanlinen_id)
	{
            $check = false;
            $modPerawatanLinenDetailT = PerawatanlinendetailT::model()->findAllByAttributes(array('perawatanlinen_id'=>$perawatanlinen_id));
            $modPenyimpananLinendet = PenyimpananlinendetT::model()->findAllByAttributes(array('perawatanlinen_id'=>$perawatanlinen_id));
            if(count((array)$modPerawatanLinenDetailT) == count((array)$modPenyimpananLinendet)){
                $check = true;
            }
            return $check;
        }
        
         public function checkstatusLinenRS($perawatanlinen_id)
	{
            $check = false;
            $noCheck = 0;
            $modPerawatan = PerawatanlinenT::model()->findByPK($perawatanlinen_id);
             
            $modPerawatanLinenDetailT = PerawatanlinendetailT::model()->findAllByAttributes(array('perawatanlinen_id'=>$perawatanlinen_id));
            
            if(count((array)$modPerawatanLinenDetailT)>0){
                foreach ($modPerawatanLinenDetailT as $data){
                    if($data->statusperawatanlinen == "SELESAI"){
                        $noCheck += 1;
                    }else{
                        if($noCheck > 0){
                            $noCheck -= 1;
                        }
                    }
                }
            }
            
            if(count((array)$modPerawatanLinenDetailT) == $noCheck){
                if($modPerawatan->iskirimkeluar==true){
                     $check = true;
                }
            }
            return $check;
        }
}