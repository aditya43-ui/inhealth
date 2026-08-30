<?php
class FAAntrianFarmasiT extends AntrianfarmasiT
{
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
         * menampilkan antrian yang belum diinputkan ke penjualan resep
         */
        public function searchDialogKarcis()
        {
            $criteria = new CDbCriteria();
            $criteria->join = "LEFT JOIN penjualanresep_t ON penjualanresep_t.antrianfarmasi_id = t.antrianfarmasi_id";
            $criteria->select = "*,t.antrianfarmasi_id, penjualanresep_t.penjualanresep_id AS penjualanresep_id";
            $criteria->addCondition("penjualanresep_id IS NULL");
            $criteria->compare("DATE(tglambilantrian)", date("Y-m-d"));
			if(!empty($this->racikan_id)){
				$criteria->addCondition("racikan_id = ".$this->racikan_id);						
			}
            $criteria->compare('LOWER(noantrian)',strtolower($this->noantrian),true);
            $criteria->compare('panggilantrian',$this->panggilantrian);
            $criteria->compare('antrianlewat',$this->antrianlewat);
            $criteria->limit=5;
            if(!isset($_GET[get_class($this)."_sort"])){
                $criteria->order = 'tglambilantrian ASC';
            }
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    //'pagination'=>array('pageSize'=>5),
            ));
        }
        /**
         * menampilkan racikan_m
         * @return array
         */
        public function getListRacikans($racikan_id = null){
            $criteria = new CDbCriteria();
            $criteria->compare ("racikan_id",$racikan_id);
            $criteria->addCondition ("racikan_aktif = TRUE");
            $modRacikans = RacikanM::model()->findAll($criteria);
            $data = array();
            if(count((array)$modRacikans) > 0){
                foreach($modRacikans AS $i=>$racikan){
                    $data[$racikan->racikan_id] = $racikan->racikan_nama." (".$racikan->racikan_singkatan.")";
                } 
            }
            return $data;
        }
        /**
         * menampilkan string racikan singkatan
         * @return string
         */
        public function getRacikanSingkatan(){
            if(!empty($this->racikan_id))
                return $this->racikan->racikan_singkatan;
            else
                return "";
        }

}