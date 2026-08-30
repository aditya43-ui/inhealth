<?php
/**
* - digunakan untuk memanggil view Laporanpembebasantarif_v, hanya untuk modul keuangan
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/

class KULaporanpembebasantarifV extends LaporanpembebasantarifV {

    public $jumlah, $tick, $data, $jns_periode, $tgl_awal, $tgl_akhir, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir;
    public $dokter_nama;
	public $instalasi_id;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchGrafik() {

        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteria();
        
        $criteria->select = 'sum(jmlpembebasan) as jumlah, i.instalasi_nama as data';
        $criteria->group = 'instalasi_nama';

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    public function searchTable() {

        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    
    public function searchPrint() {

        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination'=>false,
                ));
    }

    protected function functionCriteria() {
        $format = new MyFormatter();
        
        $criteria = new CDbCriteria();
        if(!empty($this->pegawai_id)){
                $criteria->addInCondition('pegawai_id',$this->pegawai_id);
        }
		
		if (is_array($this->nama_pegawai)){
			$criteria->addInCondition("nama_pegawai" , $this->nama_pegawai);
		}
        //$criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), TRUE);
        //$criteria->compare('ruangan_id', $this->ruangan_id);
        //$criteria->compare('create_ruangan', $this->ruangan_id);
		$criteria->join =	" JOIN ruangan_m r ON t.create_ruangan = r.ruangan_id "
						.	" JOIN instalasi_m i ON i.instalasi_id = r.instalasi_id ";

		if (!empty($this->instalasi_id)){
			$criteria->addInCondition("r.instalasi_id", $this->instalasi_id);
		}else{
			$criteria->addInCondition("r.instalasi_id", Params::getArrayInstalasiBiayaPelayanan());
		}
		
		if (!empty($this->ruangan_id)){
			if (is_array($this->ruangan_id)){
				$criteria->addInCondition("r.ruangan_id", $this->ruangan_id);
			}else{
				$criteria->addCondition("r.ruangan_id =". $this->ruangan_id);
			}
		}else{
			
		}
		
        //var_dump($this->tgl_akhir);
        $criteria->addBetweenCondition('DATE(tglpembebasan)', $format->formatDateTimeForDb(date("Y-m-d", strtotime($this->tgl_awal))).' 00:00:00', $format->formatDateTimeForDb(date("Y-m-d", strtotime($this->tgl_akhir))).' 23:59:59');

        return $criteria;
    }
      
}