<?php

class GFMutasioaruanganT extends MutasioaruanganT
{
        public $instalasitujuan_id;
        public $pegawaimengetahui_nama;
		public $jns_periode,$tgl_awal,$tgl_akhir,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
		public $ruangantujuan_nama,$obatalkes_nama,$sumberdana_nama,$harganettosatuan,$hargajualsatuan,$jummutasi,$satuankecil_nama,$totalharga;
		public $data,$jumlah;
		public $is_nobatch_tglkadaluarsa = 0;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MutasioaruanganT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchLaporanMutasiIntern() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $format = new MyFormatter();
       $criteria = new CDbCriteria;
        
        $criteria->join = 'JOIN mutasioadetail_t md ON md.mutasioaruangan_id=t.mutasioaruangan_id 
            JOIN obatalkes_m o ON o.obatalkes_id=md.obatalkes_id 
            JOIN sumberdana_m sd ON md.sumberdana_id=sd.sumberdana_id 
            JOIN satuankecil_m s ON md.satuankecil_id=s.satuankecil_id 
            JOIN ruangan_m r ON r.ruangan_id=t.ruangantujuan_id';
        $criteria->select = 't.mutasioaruangan_id, t.nomutasioa as nomutasioa, o.obatalkes_nama as obatalkes_nama, t.terimamutasi_id, t.tglmutasioa, 
                             md.harganetto as harganettosatuan, md.hargajualsatuan as hargajualsatuan, md.jmlmutasi as jummutasi, md.totalharga as totalharga, r.ruangan_nama as ruangantujuan_nama, s.satuankecil_nama, sd.sumberdana_nama';
        $this->tgl_awal = $format->formatDateTimeForDb($this->tgl_awal);
        $this->tgl_akhir = $format->formatDateTimeForDb($this->tgl_akhir);
        $criteria->addBetweenCondition('date(tglmutasioa)',$this->tgl_awal,$this->tgl_akhir);
        $criteria->compare('LOWER(nomutasioa)', strtolower($this->nomutasioa), true);
        $criteria->compare('ruangantujuan_id', $this->ruangantujuan_id);
        $criteria->compare('ruanganasal_id', Yii::app()->user->getState('ruangan_id'));

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria, 'pagination'=>false,
                ));
    }
	
	public function searchLaporan() {
        
        $criteria = new CDbCriteria;
        
        $criteria->join = 'JOIN mutasioadetail_t md ON md.mutasioaruangan_id=t.mutasioaruangan_id JOIN obatalkes_m o ON o.obatalkes_id=md.obatalkes_id JOIN ruangan_m r ON r.ruangan_id=t.ruangantujuan_id';
        $criteria->select = 't.nomutasioa as nomutasioa, o.obatalkes_nama as obatalkes_nama, t.terimamutasi_id, t.tglmutasioa, 
                             md.harganetto as harganettosatuan, md.hargajualsatuan as hargajualsatuan, md.jmlmutasi as jummutasi, md.totalharga as totalharga, r.ruangan_nama as ruangantujuan_nama';
        
        $criteria->addBetweenCondition('date(tglmutasioa)',$this->tgl_awal,$this->tgl_akhir);
        $criteria->compare('LOWER(nomutasioa)', strtolower($this->nomutasioa), true);
        $criteria->compare('ruanganasal_id', Yii::app()->user->getState('ruangan_id'));
        

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
	
	public function searchLaporanPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

       $criteria = new CDbCriteria;
        
        $criteria->join = 'JOIN mutasioadetail_t md ON md.mutasioaruangan_id=t.mutasioaruangan_id JOIN obatalkes_m o ON o.obatalkes_id=md.obatalkes_id JOIN ruangan_m r ON r.ruangan_id=t.ruangantujuan_id';
        $criteria->select = 't.nomutasioa as nomutasioa, o.obatalkes_nama as obatalkes_nama, t.terimamutasi_id, t.tglmutasioa, 
                             md.harganetto as harganettosatuan, md.hargajualsatuan as hargajualsatuan, md.jmlmutasi as jummutasi, md.totalharga as totalharga, r.ruangan_nama as ruangantujuan_nama';
        $criteria->addBetweenCondition('date(tglmutasioa)',$this->tgl_awal,$this->tgl_akhir);
        $criteria->compare('LOWER(nomutasioa)', strtolower($this->nomutasioa), true);
        $criteria->compare('ruanganasal_id', Yii::app()->user->getState('ruangan_id'));
        

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria, 'pagination'=>false,
                ));
    }
	
	public function searchGrafik()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;
        $criteria->join = 'JOIN mutasioadetail_t md ON md.mutasioaruangan_id=t.mutasioaruangan_id
							JOIN obatalkes_m o ON o.obatalkes_id=md.obatalkes_id 
							JOIN ruangan_m r ON r.ruangan_id=t.ruangantujuan_id';
        $criteria->select = 't.nomutasioa ,count(t.nomutasioa) as jumlah, o.obatalkes_nama, t.terimamutasi_id, t.tglmutasioa, 
                             md.harganetto, md.hargajualsatuan, md.jmlmutasi, md.totalharga, 
							 r.ruangan_nama as data';
		$criteria->group = 't.nomutasioa , o.obatalkes_nama, t.terimamutasi_id, t.tglmutasioa, 
                             md.harganetto, md.hargajualsatuan, md.jmlmutasi, md.totalharga, 
							 r.ruangan_nama';
		$criteria->addBetweenCondition('date(tglmutasioa)',$this->tgl_awal,$this->tgl_akhir);
        $criteria->compare('LOWER(nomutasioa)', strtolower($this->nomutasioa), true);
        $criteria->compare('ruanganasal_id', Yii::app()->user->getState('ruangan_id'));
        

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria, 'pagination'=>false,
                ));
	}

}