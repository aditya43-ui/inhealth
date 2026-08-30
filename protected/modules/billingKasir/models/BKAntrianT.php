<?php
class BKAntrianT extends AntrianT
{
    public $namaLoket;
    
    public function criteriaSearch(){
        $criteria = new CDbCriteria();
        $criteria->compare("DATE(tglantrian)", date("Y-m-d"));
        return $criteria;
    }
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AntrianT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchKarcisTerakhir()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->compare('ruangan_id',Yii::app()->user->getState('ruangan_id'));
            $criteria->compare('LOWER(noantrian)',strtolower($this->noantrian),true);
            $criteria->compare('panggil_flaq',$this->panggil_flaq);
            
            $criteria->compare('DATE(tglantrian)',date('Y-m-d H:i:s'));
            $criteria->limit=5;
            if(!isset($_GET[get_class($this)."_sort"])){
                $criteria->order = 'tglantrian DESC';
            }
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>array('pageSize'=>3),
            ));
        }

	/**
     * menampilkan racikan_m
     * @return array
     */
    public function getListRuangans($ruangan_id = null){
        $criteria = new CDbCriteria();
        if(!empty($ruangan_id)){
        	$criteria->addCondition("ruangan_id=".$ruangan_id);
        }
        $criteria->addCondition("instalasi_id=".Params::INSTALASI_ID_KASIR);
        $criteria->addCondition ("ruangan_aktif = TRUE");
        $modRuangans = RuanganM::model()->findAll($criteria);
        $data = array();
        if (count((array)$modRuangans) > 0){
            foreach($modRuangans AS $i=>$ruangan){
                $data[$ruangan->ruangan_id] = $ruangan->ruangan_nama." (".$ruangan->ruangan_singkatan.")";
            } 
        }
        return $data;
    }

    public function getAntrianBerikut()
    {
        $last = AntrianT::model()->findByAttributes(array(
            'modelantrian_id'=>$this->modelantrian_id,
        ), array(
            'condition'=>'pendaftaran_id is not null',
            'order'=>'antrian_id desc',
        ));
        $criteria = $this->criteriaSearch();
        $criteria->addCondition("antrian_id > ".$this->antrian_id);
        if (!empty($last)) {
            $criteria->addCondition('antrian_id > '.$last->antrian_id);
        }
        $criteria->addCondition("pendaftaran_id IS NULL");
        if(!empty($this->modelantrian_id)){$criteria->addCondition("modelantrian_id = ".$this->modelantrian_id); }
        $criteria->order = "modelantrian_id ASC, antrian_id ASC";
        $criteria->limit = 1;

        $record=self::model()->find($criteria);

        if($record!==null)
            return $record;
        return null;
    }
    /**
     * menentukan antrian sebelumnya
     * @return null
     */
   public function getAntrianSebelum()
    {
        $last = AntrianT::model()->findByAttributes(array(
            'modelantrian_id'=>$this->modelantrian_id,
        ), array(
            'condition'=>'pendaftaran_id is not null',
            'order'=>'antrian_id desc',
        ));
       
        $criteria = $this->criteriaSearch();
        if (!empty($last)) {
            $criteria->addCondition('antrian_id > '.$last->antrian_id);
        }
        $criteria->addCondition("antrian_id < ".$this->antrian_id);
        $criteria->addCondition("pendaftaran_id IS NULL");
        $criteria->addCondition("modelantrian_id = ".$this->modelantrian_id);
        $criteria->order = "modelantrian_id DESC, antrian_id DESC";
        $criteria->limit = 1;

        $record=self::model()->find($criteria);
        if($record!==null)
            return $record;
        return null;
    }
    
    /**
     * menampilkan loket antrian (loket_m)
     */
    public function getLokets($loket_id = null){
        $data = array();
        $criteria = new CDbCriteria();
        if (!empty($loket_id)){
        $criteria->addCondition("loket_id = ".$loket_id);
        }
        $criteria->addCondition("iskasir = TRUE");
        $criteria->addCondition("loket_aktif = TRUE");
        $criteria->order = "loket_nourut ASC";
        $modLokets = LoketM::model()->findAll($criteria);
        if (count((array)$modLokets) > 0){
            return $modLokets;
        }else{
            return array();
        }
    }
    
    public function getNamaLoketAntrian($id_nama_loket = null) {
        if(!empty($id_nama_loket)){
            $listLoket = LoketM::model()->findAllByAttributes(array('modelantrian_id'=>$id_nama_loket, 'ispendaftaran'=>TRUE, 'loket_aktif'=>TRUE), array('order'=>'loket_nama ASC'));
        }
        else{
            $listLoket = array();
        }
        return $listLoket;
    }
}