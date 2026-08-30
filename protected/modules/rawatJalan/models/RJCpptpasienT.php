<?php

class RJCpptpasienT extends CpptpasienT
{
    public $tgl_pendaftaran;
    public $dpjp_nama, $pegawaippa_nama;
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AnamnesaT the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }

    public function searchRiwayat()
    {
        $criteria=new CDbCriteria;
        
        $criteria->compare('ppa_jenis',$this->ppa_jenis);
        
        if(!empty($this->ruangan_id)){
            $criteria->compare('ruangan_id', $this->ruangan_id);
        }
        
        if(!empty($this->pendaftaran_id)){
            $criteria->addCondition('pendaftaran_id ='.$this->pendaftaran_id);
        }
        
        $criteria->compare('pasien_id', $this->pasien_id);

        $criteria->order = 'tanggal_cppt desc';
       
        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'pagination'=>array(
                    'pageSize'=>20
                ),
        ));
    }
     
    
    public function searchCPPT()
	{
		$criteria = new CDbCriteria;

		if (!empty($this->pendaftaran_id)) {
			$criteria->addCondition("pendaftaran_id = " . $this->pendaftaran_id);
		}
        
        if (!empty($this->dpjp_id)) {
			$criteria->addCondition("dpjp_id = " . $this->dpjp_id);
		}
        
        if(!empty($this->pegawaippa_id)){
            $criteria->addCondition("pegawaippa_id = " . $this->pegawaippa_id);
        }

		$criteria->order = 'tanggal_cppt desc'; 

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
        
}