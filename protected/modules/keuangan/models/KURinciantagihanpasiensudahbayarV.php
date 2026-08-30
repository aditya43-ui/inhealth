<?php
/**
* - digunakan untuk memanggil view informasipasiensudahbayar_v, hanya untuk modul keuangan
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/

class KURinciantagihanpasiensudahbayarV extends RinciantagihapasiensudahbayarV
{
    public $tgl_awal;
    public $tgl_akhir;
	public $carabayar_id;
	public $penjamin_id;
	public $totalpendapatan;
	public $data;
	public $jumlah;
	public $nopembayaran;
	public $tglpembayaran;
    public $jns_periode;
	public $bln_awal;
	public $bln_akhir;
	public $thn_awal;
	public $thn_akhir;
    
    
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
	
	public function searchTable(){
		$criteria = $this->criteriaSearch();
		$criteria->select = " pp.tglpembayaran, pp.nopembayaran, t.no_rekam_medik, t.nama_pasien, t.carabayar_nama, t.penjamin_nama,t.kelaspelayanan_nama, sum(t.tarif_tindakan) as totalpendapatan , t.ruangan_nama ";
		$criteria->group = " pp.tglpembayaran, pp.nopembayaran, t.no_rekam_medik, t.nama_pasien, t.carabayar_nama, t.penjamin_nama,t.kelaspelayanan_nama, t.ruangan_nama  ";
		$criteria->order = " pp.tglpembayaran ASC ";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function searchTablePrint(){
		$criteria = $this->criteriaSearch();
		$criteria->select = " pp.tglpembayaran, pp.nopembayaran, t.no_rekam_medik, t.nama_pasien, t.carabayar_nama, t.penjamin_nama,t.kelaspelayanan_nama, sum(t.tarif_tindakan) as totalpendapatan , t.ruangan_nama ";
		$criteria->group = " pp.tglpembayaran, pp.nopembayaran, t.no_rekam_medik, t.nama_pasien, t.carabayar_nama, t.penjamin_nama,t.kelaspelayanan_nama, t.ruangan_nama  ";
		$criteria->order = " pp.tglpembayaran ASC ";
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false
		));
	}
	
	public function searchTableIns(){
		$criteria = $this->criteriaSearch();
		$criteria->select = " pp.tglpembayaran, pp.nopembayaran, t.no_rekam_medik, t.nama_pasien, t.carabayar_nama, t.penjamin_nama,t.kelaspelayanan_nama, sum(t.tarif_tindakan) as totalpendapatan , t.instalasi_nama ";
		$criteria->group = " pp.tglpembayaran, pp.nopembayaran, t.no_rekam_medik, t.nama_pasien, t.carabayar_nama, t.penjamin_nama,t.kelaspelayanan_nama, t.instalasi_nama  ";
		$criteria->order = " pp.tglpembayaran ASC ";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function searchTableInsPrint(){
		$criteria = $this->criteriaSearch();
		$criteria->select = " pp.tglpembayaran, pp.nopembayaran, t.no_rekam_medik, t.nama_pasien, t.carabayar_nama, t.penjamin_nama,t.kelaspelayanan_nama, sum(t.tarif_tindakan) as totalpendapatan , t.instalasi_nama ";
		$criteria->group = " pp.tglpembayaran, pp.nopembayaran, t.no_rekam_medik, t.nama_pasien, t.carabayar_nama, t.penjamin_nama,t.kelaspelayanan_nama, t.instalasi_nama  ";
		$criteria->order = " pp.tglpembayaran ASC ";
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false
		));
	}
	
	public function searchGrafik(){
		$criteria = $this->criteriaSearch();
		$criteria->select = " sum(t.tarif_tindakan) as jumlah, t.ruangan_nama as data";		
		$criteria->group = "data";
		$criteria->order = " jumlah DESC ";
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false
		));
	}
	
	public function searchGrafikIns(){
		$criteria = $this->criteriaSearch();
		$criteria->select = " sum(t.tarif_tindakan) as jumlah, t.instalasi_nama as data";		
		$criteria->group = "data";
		$criteria->order = " jumlah DESC ";
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false
		));
	}
	
	public function criteriaSearch(){
		
		$criteria = new CDbCriteria();
		$criteria->join = "	JOIN pembayaranpelayanan_t pp ON pp.pembayaranpelayanan_id = t.pembayaranpelayanan_id ";
		$criteria->addBetweenCondition('DATE(pp.tglpembayaran)', $this->tgl_awal, $this->tgl_akhir);	
		
		if (is_array($this->penjamin_id)){
            $criteria->addInCondition('t.penjamin_id', $this->penjamin_id);
        }else{
            //$criteria->addCondition('penjamin_id is null');
        }
		
		if (is_array($this->carabayar_id)){
            $criteria->addInCondition('t.carabayar_id', $this->carabayar_id);
        }else{
            //$criteria->addCondition('penjamin_id is null');
        }
        if (is_array($this->kelaspelayanan_id)){
            $criteria->addInCondition('t.kelaspelayanan_id', $this->kelaspelayanan_id);
        }else{
            //$criteria->addCondition('kelaspelayanan_id is null');
        }
		
		if (is_array($this->instalasi_id)){
            $criteria->addInCondition('t.instalasi_id', $this->instalasi_id);
        }else{
          //$criteria->addInCondition('t.instalasi_id', Params::getArrayInstalasiBiayaPelayanan());
        }
		
		if (is_array($this->ruangan_id)){
            $criteria->addInCondition('t.ruangan_id', $this->ruangan_id);
        }else{
           
        }
		
		
		
		return $criteria;
	}
	
	 public function getCaraBayarItems()
	{
		return CarabayarM::model()->findAll('carabayar_aktif=TRUE ORDER BY carabayar_nama ASC') ;
	}
	
	 public function getCaraBayarPenjamin()
        {
                return $this->carabayar_nama.' / <br/> '.$this->penjamin_nama;
        }
}

?>
