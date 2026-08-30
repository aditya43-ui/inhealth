<?php
/**
    * @author          Yusuf Putra A <yusufinova@gmail.com>
    * @version         2.0.0
    * @documentation   http://kbase..com
    * @issue           RSST-1660 RSST-3852
    * - Pembuatan Transaksi Edukasi
    * - Pembuatan Informasi Edukasi 
    */

class INEdukasipkrsT  extends EdukasipkrsT
{
    public $bentuk_edukasi,$metode_edukasi;
    
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EdukasipkrsT the static model class
	 */
	public static function model($className = __CLASS__) {
            return parent::model($className);
        }
        
        /**
         * menfabil data instalasi
         * @return object get instalasi data
         */
        public function getInstalasiEd()
        {
            $criteria = new CDbCriteria();
            $criteria->select = "instalasi_id,instalasi_nama";
            $criteria->order = "instalasi_nama";
            $criteria->group = "instalasi_id,instalasi_nama";
            $criteria->addCondition('instalasi_aktif=true');
            return InstalasiM::model()->findAll($criteria);
        }
        
        /**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

        	$criteria->addBetweenCondition('tgledukasi',$this->tgl_awal,$this->tgl_akhir,true); 
                if(!empty($this->ruangan_id)){                    
                $criteria->addCondition('ruangan_id='.$this->ruangan_id);
                }
                 if (!empty($this->instalasi_id)){
                       
                        $criteria->addCondition('instalasi_id='.$this->instalasi_id);
                   }
                   if($this->bentuk_edukasi=="individu"){
                       $criteria->compare('bentukedukasi_individu',true);
                       
                   }else if($this->bentuk_edukasi=="kecil"){
                       $criteria->compare('bentukedukasi_kelompokkecil',true);
                   }else if($this->bentuk_edukasi=="sedang"){
                       $criteria->compare('bentukedukasi_kelompokkecil',true);
                   }else if($this->bentuk_edukasi=="besar"){
                        $criteria->compare('bentukedukasi_kelompokbesar',true);
                   }
                   
                   if($this->metode_edukasi=="ceramah"){
                       $criteria->compare('metode_ceramah',true);
                   }else if($this->metode_edukasi=="demonstrasi"){
                        $criteria->compare('metode_demontrsasi',true);
                   }else if($this->metode_edukasi=="diskusi"){
                        $criteria->compare('metode_diskusi',true);
                   }else if($this->metode_edukasi=="wawancara"){
                        $criteria->compare('metode_wawancara',true);
                   }
                   $criteria->order='tgledukasi DESC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
}

