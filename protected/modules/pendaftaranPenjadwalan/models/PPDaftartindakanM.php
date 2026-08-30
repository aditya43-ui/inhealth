<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PPDaftartindakanM
 *
 * @author sujana
 */
class PPDaftartindakanM extends DaftartindakanM {
    
    public $instalasi_id;
    public $ruangan_id;
    public $kelaspelayanan_id;
    
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    //'ruangan'=>array(self::BELONGS_TO,'RuanganM','ruangan_id'),
                    //'daftartindakan' => array(self::BELONGS_TO, 'PPDaftartindakanM', 'daftartindakan_id'),
                    'tariftindakan' => array(self::HAS_ONE, 'PPTariftindakanM', 'daftartindakan_id'),
                    'tariftindakancari' => array(self::HAS_MANY, 'PPTariftindakanM', 'daftartindakan_id'),
                    'kelompoktindakan' => array(self::BELONGS_TO, 'KelompoktindakanM', 'kelompoktindakan_id'),
                    'kategoritindakan' => array(self::BELONGS_TO, 'KategoritindakanM', 'kategoritindakan_id'),
                    'tindakanruangan'=> array(self::HAS_MANY, 'TindakanruanganM', 'daftartindakan_id'),

		);
	}
    
    public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->jenistarif_id)){
			$criteria->addCondition("jenistarif_id = ".$this->jenistarif_id); 			
		}
		$criteria->compare('daftartindakan.daftartindakan_nama',$this->daftartindakan_id, true);
		if(!empty($this->komponentarif_id)){
			$criteria->addCondition("komponentarif.komponentarif_id = ".$this->komponentarif_id); 			
		}
		if(!empty($this->perdatarif_id)){
			$criteria->addCondition("perdatarif_id = ".$this->perdatarif_id); 			
		}
		$criteria->compare('harga_tariftindakan',$this->harga_tariftindakan);
		$criteria->compare('persendiskon_tind',$this->persendiskon_tind);
		$criteria->compare('hargadiskon_tind',$this->hargadiskon_tind);
		$criteria->compare('persencyto_tind',$this->persencyto_tind);
		$criteria->compare('persencyto_tind',$this->persencyto_tind);
		$criteria->with=array('perdatarif','jenistarif','komponentarif','daftartindakan,tariftindakan');
		$criteria->compare('jenistarif.jenistarif_nama',$this->jenistarif->jenistarif_nama);
		$criteria->compare('komponentarif.komponentarif_nama',$this->komponentarif->komponentarif_nama);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchInfoTarif()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->ruangan_id)){
			$criteria->addCondition("ruangan_id = ".$this->ruangan_id); 			
		}
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition("kelaspelayanan_id = ".$this->kelaspelayanan_id); 			
		}
//                $criteria->with=array('tindakanruangan','tariftindakan');


		 return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getInstalasiItems()
        {
            return InstalasipelayananV::model()->findAll('instalasi_aktif=TRUE  ORDER BY instalasi_nama');
        }
        
        public function getRuanganItems()
        {
            return RuanganM::model()->findAll('ruangan_aktif=TRUE  ORDER BY ruangan_nama');
        }
        
        public function getKelasPelayananItems()
        {
            return KelaspelayananM::model()->findAll('kelaspelayanan_aktif=TRUE  ORDER BY urutankelas');
        }
}

?>
