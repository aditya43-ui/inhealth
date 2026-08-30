<?php
class STDekontaminasiT extends DekontaminasiT
{
	public $pegpetugas_nama,$pegmengetahui_nama;
	public $tgl_awal,$tgl_akhir,$instalasi_id,$ruangan_id;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->addBetweenCondition('DATE(dekontaminasi_tgl)', $this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->dekontaminasi_id)){
			$criteria->addCondition('dekontaminasi_id = '.$this->dekontaminasi_id);
		}
		$criteria->compare('LOWER(dekontaminasi_no)',strtolower($this->dekontaminasi_no),true);
		$criteria->compare('LOWER(dekontaminasi_tgl)',strtolower($this->dekontaminasi_tgl),true);
		$criteria->compare('LOWER(dekontaminasi_ket)',strtolower($this->dekontaminasi_ket),true);
		if(!empty($this->pegmengetahui_id)){
			$criteria->addCondition('pegmengetahui_id = '.$this->pegmengetahui_id);
		}
		if(!empty($this->pegpetugas_id)){
			$criteria->addCondition('pegpetugas_id = '.$this->pegpetugas_id);
		}
		$criteria->compare('issterilisasi',$this->issterilisasi);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('create_ruangan = '.$this->ruangan_id);
		}
		
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
        
        public function cekPembersihan($dekontaminasi_id) {
            $id = '';
            $modPembersihan = STPembersihanT::model()->findByAttributes(array('dekontaminasi_id'=>$dekontaminasi_id));
            if(!empty($modPembersihan)){
                $id = $modPembersihan->no_pembersihan.' - '. MyFormatter::formatDateTimeForUser($modPembersihan->tgl_pembersihan);
            }
            return $id;
        }
}