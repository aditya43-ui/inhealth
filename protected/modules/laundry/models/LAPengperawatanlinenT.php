<?php

class LAPengperawatanlinenT extends PengperawatanlinenT {
	public $pegawaimengetahui_nama,$pegawaimengajukan_nama;
	public $tgl_awal,$tgl_akhir;
	public $instalasi_id;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->addBetweenCondition('DATE(tglpengperawatanlinen)',$this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->pengperawatanlinen_id)){
			$criteria->addCondition('pengperawatanlinen_id = '.$this->pengperawatanlinen_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(pengperawatanlinen_no)',strtolower($this->pengperawatanlinen_no),true);
		$criteria->compare('LOWER(keterangan_pengperawatanlinen)',strtolower($this->keterangan_pengperawatanlinen),true);
		if(!empty($this->mengajukan_id)){
			$criteria->addCondition('mengajukan_id = '.$this->mengajukan_id);
		}
		if(!empty($this->mengetahui_id)){
			$criteria->addCondition('mengetahui_id = '.$this->mengetahui_id);
		}
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
		}
		$criteria->limit=10;
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
        
    /**
     * pencarian data pengajuan perawatan linen
     * @return \CActiveDataProvider
     */
    public function searchFilter()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;
        $criteria->join = "LEFT JOIN penerimaanlinen_t AS p ON p.pengperawatanlinen_id = t.pengperawatanlinen_id";
        $criteria->addCondition('p.penerimaanlinen_id IS NULL');
        $criteria->limit=10;
        return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
        ));
    }

    
	
	public function getSudahTerima($pengperawatanlinen_id){
		$modPenerimaan = LAPenerimaanlinenT::model()->findByAttributes(array('pengperawatanlinen_id'=>$pengperawatanlinen_id));
		return $modPenerimaan;
	}
}