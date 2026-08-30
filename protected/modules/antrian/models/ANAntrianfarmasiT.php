<?php

class ANAntrianfarmasiT extends AntrianfarmasiT
{
	public $racikan_nama; //untuk pencarian
    public $noresep;
    public $url_referrer = "";
    public $is_tambah;
    
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AntrianfarmasiT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function criteriaSearch(){
            $criteria = new CDbCriteria();
            $criteria->compare("DATE(tglambilantrian)", date("Y-m-d"));
            return $criteria;
        }
        
        public function searchKarcisTerakhir()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->compare('racikan_id',$this->racikan_id);
            $criteria->compare('LOWER(noantrian)',strtolower($this->noantrian),true);
            $criteria->compare('panggilantrian',$this->panggilantrian);
            $criteria->compare('antrianlewat',$this->antrianlewat);
            $criteria->compare('modelantrian_id', $this->modelantrian_id);
            if(!isset($_GET[get_class($this)."_sort"])){
                $criteria->order = 'tglambilantrian DESC';
            }
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>array('pageSize'=>5),
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
}