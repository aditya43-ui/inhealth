<?php

class KUInfostokobatalkesruanganV extends InfostokobatalkesruanganV{
    public $tick,$data,$jumlah,$totalharga,$qtyinnetto,$qtyoutnetto,$qtycurrentnetto,$isGroupObat;
    public $tgl_awal,$tgl_akhir;
    public $jns_periode,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
    public $harganetto_oa;
    public $jenisobatalkes_kode;
    public $jnskelompok, $lookup_name;
    public $status, $stok;
	public $hpp_obat;
	public $subtotal;
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
  
                
	public function searchGrafik()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                    
                $filter = isset($_REQUEST['filter'])?$_REQUEST['filter']:null;
                if ($filter == 'jenis'){
                    $criteria->select = "(SUM(qtystok_in) - SUM(qtystok_out)) as jumlah, ( CASE WHEN jenisobatalkes_nama = '' THEN 'Jenis Obat Tidak Diketahui' ELSE jenisobatalkes_nama END) as data";
                    $criteria->group = 'jenisobatalkes_nama';
                }elseif ($filter == 'kategori'){
                    $criteria->select = "(SUM(qtystok_in) - SUM(qtystok_out)) as jumlah, ( CASE WHEN obatalkes_kategori = '' THEN 'Kategori Obat Tidak Diketahui' ELSE obatalkes_kategori END) as data";
                    $criteria->group = 'obatalkes_kategori';
                }elseif ($filter == 'golongan'){
                    $criteria->select = "(SUM(qtystok_in) - SUM(qtystok_out)) as jumlah, ( CASE WHEN obatalkes_golongan = '' THEN 'Golongan Obat Tidak Diketahui' ELSE obatalkes_golongan END) as data";
                    $criteria->group = 'obatalkes_golongan';
                }else{
                    $criteria->select = "(SUM(qtystok_in) - SUM(qtystok_out)) as jumlah, ( CASE WHEN jenisobatalkes_nama = '' THEN 'Jenis Obat Tidak Diketahui' ELSE jenisobatalkes_nama END) as data";
                    $criteria->group = 'jenisobatalkes_nama';
                }
                
                
		if (!empty($this->jenisobatalkes_id)){
                    $criteria->addInCondition(" jenisobatalkes_id ", $this->jenisobatalkes_id);
                }
                if (!empty($this->obatalkes_kategori)){
                    $criteria->addInCondition(" obatalkes_kategori ", $this->obatalkes_kategori);
                }

                if (!empty($this->obatalkes_golongan)){
                    $criteria->addInCondition(" obatalkes_golongan ", $this->obatalkes_golongan);
                }


                //$criteria->addCondition('ruangan_id = '.Yii::app()->user->ruangan_id);

                if($this->qtystok_in == true){
                    $criteria->addCondition("qtystok_in = 0 ");          
                }

                if($this->qtystok_out == true){
                    $criteria->addCondition('qtystok_out = 0');

                }
		//$criteria->compare('LOWER(ruangan_id)',strtolower($this->ruangan_id),true);
				
				if (!empty($this->instalasi_id)){
				if (is_array($this->instalasi_id)){
					$criteria->addInCondition("instalasi_id", $this->instalasi_id);
				}else{
					$criteria->addCondition("instalasi_id = ".$this->instalasi_id);
				}
			}
            
			if (!empty($this->ruangan_id)){
				if (is_array($this->ruangan_id)){
					$criteria->addInCondition("ruangan_id", $this->ruangan_id);
				}else{
					$criteria->addCondition("ruangan_id = ".$this->ruangan_id);
				}
			}
				

                $criteria->order = "jumlah DESC";

                return new CActiveDataProvider($this, array(
                        'criteria'=>$this->criteria(),
                        'criteria'=>$criteria,
                ));
        }
		
	public function search()
	{
          
		return new CActiveDataProvider($this, array(
                    'criteria'=>$this->Criteria(),
                    'pagination'=>array(
                        'pageSize'=>10,
                    ),
                    'sort'=>array(
                        'defaultOrder'=>'obatalkes_nama asc',
                    )
		));
	}
        
        public function searchPrint()
        {
                return new CActiveDataProvider($this, array(
                        'criteria'=>$this->criteria(),
                        'pagination'=>false,
                        'sort'=>array(
                            'defaultOrder'=>'obatalkes_nama asc',
                        )
                ));
        }
         public function Criteria()
        {
            $criteria=new CDbCriteria;

            $criteria->select = 'l.lookup_name, t.obatalkes_kategori, t.obatalkes_golongan,t.satuankecil_nama,t.jenisobatalkes_nama, t.obatalkes_kode,  t.obatalkes_nama, SUM(t.qtystok_in) AS qty_in, SUM(t.qtystok_out) AS qty_out, 
                                (SUM(t.qtystok_in) - SUM(t.qtystok_out)) AS qty_current, oa.hpp AS hpp_obat, ((SUM(t.qtystok_in) - SUM(t.qtystok_out)) * oa.hpp) as subtotal ';
            $criteria->group = 'l.lookup_name, t.obatalkes_kategori, t.obatalkes_golongan,t.satuankecil_nama,t.obatalkes_kode,  t.obatalkes_nama,t.jenisobatalkes_nama, oa.hpp';//hargajual,
			
            $criteria->join =	  " JOIN obatalkes_m oa ON t.obatalkes_id = oa.obatalkes_id "
                                . " LEFT JOIN lookup_m l ON oa.jnskelompok = l.lookup_value ";
            
            if (!empty($this->jenisobatalkes_id)){
                $criteria->addInCondition(" t.jenisobatalkes_id ", $this->jenisobatalkes_id);
            }
            if (!empty($this->obatalkes_kategori)){
                $criteria->addInCondition(" t.obatalkes_kategori ", $this->obatalkes_kategori);
            }
            
            if (!empty($this->obatalkes_golongan)){
                $criteria->addInCondition(" t.obatalkes_golongan ", $this->obatalkes_golongan);
            }
			
			if (!empty($this->instalasi_id)){
				if (is_array($this->instalasi_id)){
					$criteria->addInCondition("instalasi_id", $this->instalasi_id);
				}else{
					$criteria->addCondition("instalasi_id = ".$this->instalasi_id);
				}
			}
            
			if (!empty($this->ruangan_id)){
				if (is_array($this->ruangan_id)){
					$criteria->addInCondition("ruangan_id", $this->ruangan_id);
				}else{
					$criteria->addCondition("ruangan_id = ".$this->ruangan_id);
				}
			}
            
            //$criteria->addCondition('t.ruangan_id = '.Yii::app()->user->ruangan_id);
            
            if($this->qtystok_in == true){
                $criteria->addCondition("t.qtystok_in = 0 ");          
            }
            
            if($this->qtystok_out == true){
                $criteria->addCondition('t.qtystok_out = 0');
                
            }
            
            return $criteria;
        }
                				
}

?>
