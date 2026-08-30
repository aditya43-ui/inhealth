<?php
class GFInformasimutasioaruanganV extends InformasimutasioaruanganV
{
	public $tgl_awal;
        public $tgl_akhir;
        public $status_terima;
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasimutasioaruanganV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchInformasiMutasiMasuk()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
//                KENAPA HARUS DI GROUP ??
//                $criteria->group = 'mutasioaruangan_id,terimamutasi_id,tglmutasioa,nomutasioa,'
//                        . 'nomutasioa,ruanganasalmutasi_nama,statuspesan,'
//                        . 'pegawaimutasi_gelardepan,pegawaimutasi_nama,pegawaimutasi_gelarbelakang,'
//                        . 'pegawaimengetahuimutasi_gelardepan,pegawaimengetahuimutasi_nama,pegawaimengetahuimutasi_gelarbelakang';
//                $criteria->select = $criteria->group;
                
                $criteria->addCondition('ruangantujuanmutasi_id = '.Yii::app()->user->getState('ruangan_id'));
                $criteria->addBetweenCondition('DATE(tglmutasioa)',$this->tgl_awal,$this->tgl_akhir);
                $criteria->compare('LOWER(nomutasioa)',strtolower($this->nomutasioa),true);
				if(!empty($this->instalasiasalmutasi_id)){
					$criteria->addCondition('instalasiasalmutasi_id = '.$this->instalasiasalmutasi_id);
				}
				if(!empty($this->ruanganasalmutasi_id)){
					$criteria->addCondition('ruanganasalmutasi_id = '.$this->ruanganasalmutasi_id);
				}
                if ($this->status_terima == 1) {
                    $criteria->addCondition('terimamutasi_id is null');
                } else if ($this->status_terima == 2) {
                    $criteria->addCondition('terimamutasi_id is not null');
                }
                $criteria->compare('pegawaipenerima_id', $this->pegawaipenerima_id);
                $criteria->compare('LOWER(statuspesan)',strtolower($this->statuspesan),true);
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder'=>'tglmutasioa desc',
            ),
		));
	}
        
        public function searchInformasiMutasiKeluar()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
//                $criteria->group = 'mutasioaruangan_id,tglmutasioa,nomutasioa,'
//                        . 'nomutasioa,ruangantujuanmutasi_nama,statuspesan,'
//                        . 'pegawaimutasi_gelardepan,pegawaimutasi_nama,pegawaimutasi_gelarbelakang,'
//                        . 'pegawaimengetahuimutasi_gelardepan,pegawaimengetahuimutasi_nama,pegawaimengetahuimutasi_gelarbelakang';
//                $criteria->select = $criteria->group;
                
                $criteria->addCondition('ruanganasalmutasi_id = '.Yii::app()->user->getState('ruangan_id'));
                $criteria->addBetweenCondition('DATE(tglmutasioa)',$this->tgl_awal,$this->tgl_akhir);
                $criteria->compare('LOWER(nomutasioa)',strtolower($this->nomutasioa),true);
				if(!empty($this->instalasitujuanmutasi_id)){
					$criteria->addCondition('instalasitujuanmutasi_id = '.$this->instalasitujuanmutasi_id);
				}
				if(!empty($this->ruangantujuanmutasi_id)){
					$criteria->addCondition('ruangantujuanmutasi_id = '.$this->ruangantujuanmutasi_id);
				}
                $criteria->compare('LOWER(statuspesan)',strtolower($this->statuspesan),true);
                if ($this->status_terima == 1) {
                    $criteria->addCondition('terimamutasi_id is null');
                } else if ($this->status_terima == 2) {
                    $criteria->addCondition('terimamutasi_id is not null');
                }
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder'=>'tglmutasioa desc',
            ),
		));
	}
        
        public function getPegawaiMutasiLengkap()
        {
            return (isset($this->pegawaimutasi_gelardepan) ? $this->pegawaimutasi_gelardepan : "").' '.$this->pegawaimutasi_nama.(isset($this->pegawaimutasi_gelarbelakang) ? ', '.$this->pegawaimutasi_gelarbelakang : "");
        }

        public function getPegawaiMengetahuiLengkap()
        {
            return (isset($this->pegawaimengetahuimutasi_gelardepan) ? $this->pegawaimengetahuimutasi_gelardepan : "").' '.$this->pegawaimengetahuimutasi_nama.(isset($this->pegawaimengetahuimutasi_gelarbelakang) ? ', '.$this->pegawaimengetahuimutasi_gelarbelakang : "");
        }
        
        public function getPegawaiPenerimaLengkap()
        {
            return (isset($this->pegawaipenerima_gelardepan) ? $this->pegawaipenerima_gelardepan : "").' '.$this->pegawaipenerima_nama.(isset($this->pegawaipenerima_gelarbelakang) ? ', '.$this->pegawaipenerima_gelarbelakang : "");
        }
		
	/**
	* kriteria pencarian untuk dashboard
	* @return \CActiveDataProvider
	*/
	public function searchDashboard()
	{
	   // Warning: Please modify the following code to remove attributes that
	   // should not be searched.

	   $criteria=new CDbCriteria;
	   $criteria->compare('DATE(tglmutasioa)', date("Y-m-d"));
	   $criteria->order = 'tglmutasioa DESC';
	   $criteria->limit = 10;
	   return new CActiveDataProvider($this, array(
		   'criteria'=>$criteria,
		   'pagination'=>false
	   ));
	}
	
	public function getPegawaiMutasi(){
		return $this->pegawaimutasi_gelardepan." ".$this->pegawaimutasi_nama." ".$this->pegawaimutasi_gelarbelakang;
	}
}