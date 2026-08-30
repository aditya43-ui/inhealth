<?php
/**
 * digunakan untuk menyimpan fung - fungsi javascript unyuk tabulasi menu asesmen awal kebidanan
 * 
 * @package application.modules.laundry
 * @subpackage models
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     1.0.0 
 * @link    <http://piindonesia.co.id>
 */
class LAPenerimaanlinenT extends PenerimaanlinenT{
	public $pegawaimengetahui_nama,$pegawaimenerima_nama;
	public $instalasi_nama,$ruangan_nama;
	public $tgl_awal,$tgl_akhir,$instalasi_id;
        public $pengperawatanlinen_no;
        public $pegmenerima_nama;
        public $pegmengetahui_nama;
        public $namalinen, $jenisperawatanlinen, $pencuciandetail_id, $perawatanlinendetail_id;
	
        /**
         * mengenerate fungsi yii, yang diambil dari CActiveDataprovider
         * @param type $className
         * @return type
         */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
         * fungsi untuk informasi penerimaan linen controller
         * @return \CActiveDataProvider
         */
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->select = "t.penerimaanlinen_id, t.nopenerimaanlinen, t.tglpenerimaanlinen, t.keterangan_penerimaanlinen, t.ruangan_id, penerimaanlinendetail_t.jenisperawatanlinen";
//                $criteria->select = "t.penerimaanlinen_id, t.nopenerimaanlinen, t.tglpenerimaanlinen, t.keterangan_penerimaanlinen, t.ruangan_id, linen_m.namalinen, penerimaanlinendetail_t.jenisperawatanlinen, perawatanlinendetail_t.perawatanlinendetail_id, pencuciandetail_t.pencuciandetail_id";
               $criteria->group = $criteria->select;
                /*RSPMC-906 $criteria->select = "t.penerimaanlinen_id, t.nopenerimaanlinen, t.tglpenerimaanlinen, t.keterangan_penerimaanlinen, t.ruangan_id";
                 $criteria->group = "t.penerimaanlinen_id, t.nopenerimaanlinen, t.tglpenerimaanlinen, t.keterangan_penerimaanlinen, t.ruangan_id";*/
                $criteria->join = "JOIN penerimaanlinendetail_t ON penerimaanlinendetail_t.penerimaanlinen_id = t.penerimaanlinen_id "
                        . " JOIN ruangan_m ON ruangan_m.ruangan_id = t.ruangan_id
                            JOIN instalasi_m ON instalasi_m.instalasi_id = ruangan_m.instalasi_id";
		$criteria->addBetweenCondition('DATE(tglpenerimaanlinen)',$this->tgl_awal, $this->tgl_akhir);
		
                
                $criteria->addCondition("penerimaanlinendetail_t.jenisperawatanlinen != '".Params::JENISPERAWATAN_KEHILANGAN ."'");
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_m.instalasi_id = '.$this->instalasi_id);
		}
                if(!empty($this->ruangan_id)){
			$criteria->addCondition('t.ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(t.nopenerimaanlinen)',strtolower($this->nopenerimaanlinen),true);
                
//		$criteria->addBetweenCondition('DATE(tglpenerimaanlinen)',$this->tgl_awal, $this->tgl_akhir);
//		
//		if(!empty($this->penerimaanlinen_id)){
//			$criteria->addCondition('penerimaanlinen_id = '.$this->penerimaanlinen_id);
//		}
//		if(!empty($this->ruangan_id)){
//			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
//		}
//		if(!empty($this->pengperawatanlinen_id)){
//			$criteria->addCondition('pengperawatanlinen_id = '.$this->pengperawatanlinen_id);
//		}
//		$criteria->compare('LOWER(nopenerimaanlinen)',strtolower($this->nopenerimaanlinen),true);
//		$criteria->compare('LOWER(keterangan_penerimaanlinen)',strtolower($this->keterangan_penerimaanlinen),true);
//		if(!empty($this->pegmenerima_id)){
//			$criteria->addCondition('pegmenerima_id = '.$this->pegmenerima_id);
//		}
//		if(!empty($this->pegmengetahui_id)){
//			$criteria->addCondition('pegmengetahui_id = '.$this->pegmengetahui_id);
//		}
//		if(!empty($this->beratlinen)){
//			$criteria->addCondition('beratlinen = '.$this->beratlinen);
//		}
//		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
//		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
//		if(!empty($this->create_loginpemakai_id)){
//			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
//		}
//		if(!empty($this->update_loginpemakai_id)){
//			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
//		}
//		if(!empty($this->create_ruangan)){
//			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
//		}
               
		$criteria->limit=10;
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
	
        /**
         * fungsi untuk informasi penerimaan linen controller
         * @return \CActiveDataProvider
         */
	public function searchInformasiKehilangan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                 $criteria->select = "t.penerimaanlinen_id, t.nopenerimaanlinen, t.tglpenerimaanlinen, t.keterangan_penerimaanlinen, t.ruangan_id";
                 $criteria->group = "t.penerimaanlinen_id, t.nopenerimaanlinen, t.tglpenerimaanlinen, t.keterangan_penerimaanlinen, t.ruangan_id";
                $criteria->join = "JOIN penerimaanlinendetail_t ON penerimaanlinendetail_t.penerimaanlinen_id = t.penerimaanlinen_id "
                        . " JOIN ruangan_m ON ruangan_m.ruangan_id = t.ruangan_id
                            JOIN instalasi_m ON instalasi_m.instalasi_id = ruangan_m.instalasi_id";
		$criteria->addBetweenCondition('DATE(tglpenerimaanlinen)',$this->tgl_awal, $this->tgl_akhir);
		
                
                $criteria->addCondition("penerimaanlinendetail_t.jenisperawatanlinen = '".Params::JENISPERAWATAN_KEHILANGAN ."'");
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_m.instalasi_id = '.$this->instalasi_id);
		}
                if(!empty($this->ruangan_id)){
			$criteria->addCondition('t.ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(t.nopenerimaanlinen)',strtolower($this->nopenerimaanlinen),true);
		$criteria->limit=10;
                
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
        
        public function checkperawatanLinen($penerimaanlinen_id)
	{
            $check = false;
            $modPerawatanlinendetailT = PerawatanlinendetailT::model()->findAllByAttributes(array('penerimaanlinen_id'=>$penerimaanlinen_id));
            $modPenerimaanLinendet = PenerimaanlinendetailT::model()->findAllByAttributes(array('penerimaanlinen_id'=>$penerimaanlinen_id));
            if(count((array)$modPerawatanlinendetailT) == count((array)$modPenerimaanLinendet)){
                $check = true;
            }
            
            return $check;
        }
        
        public function checkpencucianLinen($penerimaanlinen_id)
	{
            $check = false;
            $modPencucianlinendetailT = PencuciandetailT::model()->findAllByAttributes(array('penerimaanlinen_id'=>$penerimaanlinen_id));
            $modPenerimaanLinendet = PenerimaanlinendetailT::model()->findAllByAttributes(array('penerimaanlinen_id'=>$penerimaanlinen_id));
            if(count((array)$modPencucianlinendetailT) == count((array)$modPenerimaanLinendet)){
                $check = true;
            }
            return $check;
        }
}