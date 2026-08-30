<?php
/**
 * - Digunakan untuk mengekstend model LappenyadapandarahV
 * @author  Andyka <andykaputra@.com>
 * @website	   <.com>
 */

class BDLappenyadapandarahV extends LappenyadapandarahV
{       
        public $tgl_awal, $tgl_akhir, $jns_periode, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir, $data, $jumlah;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LappenyadapandarahV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchTable(){          	
            $criteria=new CDbCriteria;
            
            $criteria->addBetweenCondition('DATE(tglmulaiobservasi)', $this->tgl_awal, $this->tgl_akhir);
//            $criteria->limit = 2;
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
	
        }
        
        public function searchGrafik() {
        $criteria = new CDbCriteria();
        $criteria->select = "count(pendonor_id) as jumlah";
        
        if ($this->is_batalpenyadapan == 0) {
            $criteria->select .= ", DATE(tglmulaiobservasi) as data ";
            $criteria->addBetweenCondition('DATE(tglmulaiobservasi)', $this->tgl_awal, $this->tgl_akhir);
            $criteria->compare("is_batalpenyadapan",isset($this->is_batalpenyadapan)?$this->is_batalpenyadapan:false);
            $criteria->group .= " DATE(tglmulaiobservasi)";
        } else {
            $criteria->select .= ", DATE(tglmulaiobservasi) as data ";
            $criteria->addBetweenCondition('DATE(tglmulaiobservasi)', $this->tgl_awal, $this->tgl_akhir);
            $criteria->compare("is_batalpenyadapan",isset($this->is_batalpenyadapan)?$this->is_batalpenyadapan:false);
            $criteria->group .= " DATE(tglmulaiobservasi)";
        }

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
}