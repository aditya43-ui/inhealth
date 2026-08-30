<?php

class GFRenpengembalianedT extends RenpengembalianedT
{
	public $pegawaimengetahui_nama,$pegawaimenyetujui_nama,$supplier_id;
	public $tgl_awal, $tgl_akhir;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getPegawaimengetahuiLengkap()
    {
        return (isset($this->mengetahui->gelardepan) ? $this->mengetahui->gelardepan : "").' '.$this->mengetahui->nama_pegawai.(isset($this->mengetahui->gelarbelakang_nama) ? ', '.$this->mengetahui->gelardepan : "");
    }
    
    public function getPegawaimenyetujuiLengkap()
    {
        return (isset($this->menyetujui->gelardepan) ? $this->menyetujui->gelardepan : "").' '.$this->menyetujui->nama_pegawai.(isset($this->menyetujui->gelarbelakang_nama) ? ', '.$this->menyetujui->gelardepan : "");
    }
	
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
		$criteria->addBetweenCondition('DATE(tglrenpengembalian)',$this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->renpengembalianed_id)){
			$criteria->addCondition('renpengembalianed_id = '.$this->renpengembalianed_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(norenpengembalian)',strtolower($this->norenpengembalian),true);
		if(!empty($this->mengetahui_id)){
			$criteria->addCondition('mengetahui_id = '.$this->mengetahui_id);
		}
		$criteria->compare('LOWER(tglmengetahui)',strtolower($this->tglmengetahui),true);
		if(!empty($this->menyetujui_id)){
			$criteria->addCondition('menyetujui_id = '.$this->menyetujui_id);
		}
		$criteria->compare('LOWER(tglmenyetujui)',strtolower($this->tglmenyetujui),true);

		$criteria->limit=10;

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
	}
    
}
