<?php
class GFInformasirencanakebutuhanfarmasiV extends InformasirencanakebutuhanfarmasiV
{
        public $tgl_awal,$tgl_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RencanakebutuhanfarmasiV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
		$criteria->addBetweenCondition('DATE(tglperencanaan)',$this->tgl_awal,$this->tgl_akhir,true);
		$criteria->compare('LOWER(noperencnaan)',strtolower($this->noperencnaan),true);
		$criteria->compare('LOWER(statusrencana)',strtolower($this->statusrencana),true);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->pegawaimengetahui_id)){
			$criteria->addCondition('pegawaimengetahui_id = '.$this->pegawaimengetahui_id);
		}
		if(!empty($this->pegawaimenyetujui_id)){
			$criteria->addCondition('pegawaimenyetujui_id = '.$this->pegawaimenyetujui_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
    public function getPegawaimengetahuiLengkap()
    {
        return (isset($this->pegawaimengetahui_gelardepan) ? $this->pegawaimengetahui_gelardepan : "").' '.$this->pegawaimengetahui_nama.(isset($this->pegawaimengetahui_gelarbelakang) ? ', '.$this->pegawaimengetahui_gelardepan : "");
    }
    
    public function getPegawaimenyetujuiLengkap()
    {
        return (isset($this->pegawaimenyetujui_gelardepan) ? $this->pegawaimenyetujui_gelardepan : "").' '.$this->pegawaimenyetujui_nama.(isset($this->pegawaimenyetujui_gelarbelakang) ? ', '.$this->pegawaimenyetujui_gelardepan : "");
    }

}
?>