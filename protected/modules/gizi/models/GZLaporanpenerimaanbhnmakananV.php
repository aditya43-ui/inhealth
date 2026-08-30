<?php

class GZLaporanpenerimaanbhnmakananV extends LaporanpenerimaanbhnmakananV
{       

  public $data, $tick, $jumlah, $type;
    
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
	public function criteriaSearch()
	{
		
		$criteria=new CDbCriteria();
                
    $filter  = isset($_GET['filter'])?$_GET['filter']:null;
    $filter1 = isset($_GET['filter1'])?$_GET['filter1']:null;
    $filter2 = isset($_GET['filter2'])?$_GET['filter2']:null;
    $filter3 = isset($_GET['filter3'])?$_GET['filter3']:null;                
               
		$criteria->addBetweenCondition('tglterimabahan',$this->tgl_awal,$this->tgl_akhir);
              
      if ($filter == 'supplier')
      {
        if (!empty($this->supplier_id))
        {
            if(is_array($this->supplier_id)){
                $criteria->addInCondition('supplier_id', $this->supplier_id);
            }
        }else{
            $criteria->addCondition('supplier_id is null');
        }
      }
      
      if ($filter1 == 'golbahanmakanan')
      {
        if(is_array($this->golbahanmakanan_id)){
            $criteria->addInCondition('golbahanmakanan_id', $this->golbahanmakanan_id);
        }else{
            $criteria->addCondition('golbahanmakanan_id is null');
        }
      }
      
      if ($filter2 == 'jenisbahanmakanan')
      {
        if(is_array($this->jenisbahanmakanan)){
            $criteria->addInCondition('jenisbahanmakanan', $this->jenisbahanmakanan);
        }else{
            $criteria->addCondition('jenisbahanmakanan is null');
        }     
      }
      
      if ($filter3 == 'kelbahanmakanan')
      {
        if(is_array($this->kelbahanmakanan)){
            $criteria->addInCondition('kelbahanmakanan', $this->kelbahanmakanan);
        }else{
            $criteria->addCondition('kelbahanmakanan is null');
        }            
      }
       // if (!empty($this->ruangan_id)){
       //    $criteria->addCondition('ruangan_id = '.$this->ruangan_id);
       // }
                 
		return $criteria;
	}
        
	public function searchTable()
	{
		$criteria=$this->criteriaSearch();
        $criteria->order = "tglterimabahan ASC";
        $criteria->limit = 10;
                        
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
  public function searchPrint()
	{
		$criteria=$this->criteriaSearch();
      $criteria->order = "tglterimabahan ASC";
      $criteria->limit = -1;
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
      'pagination' => false,   
		));
	}
        
        
  public static function criteriaGrafik($model, $type='data', $addCols = array()){

    $criteria = new CDbCriteria;
    
    $filter = isset($_GET['filter'])?$_GET['filter']:null;
    $filter1 = isset($_GET['filter1'])?$_GET['filter1']:null;
    $filter2 = isset($_GET['filter2'])?$_GET['filter2']:null;
    $filter3 = isset($_GET['filter3'])?$_GET['filter3']:null;
    
    if ( $filter == 'supplier') {
        if (!empty($model->supplier_id)) {
            $criteria->select = 'count(terimabahanmakan_id) as jumlah, supplier_nama as '.$type;
            $criteria->group = 'supplier_nama';
        } 
    }        
    if($filter1 == 'golbahanmakanan'){
        if (!empty($model->golbahanmakanan_id)) {
            
            $criteria->select = 'count(terimabahanmakan_id) as jumlah, golbahanmakanan_nama as '.$type;
            $criteria->group = 'golbahanmakanan_nama';
        }
    }
    if($filter2 == 'jenisbahanmakanan'){
        if (!empty($model->jenisbahanmakanan)) {
            $criteria->select = 'count(terimabahanmakan_id) as jumlah, jenisbahanmakanan as '.$type;
            $criteria->group = 'jenisbahanmakanan';
        }
    }
    if($filter3 == 'kelbahanmakanan'){
        if (!empty($model->kelbahanmakanan)) {
            $criteria->select = 'count(terimabahanmakan_id) as jumlah, kelbahanmakanan as '.$type;
            $criteria->group = 'kelbahanmakanan';
        }
    }
    if ($filter == null && $filter1 == null && $filter2 == null && $filter3 == null){
        $criteria->select = 'count(terimabahanmakan_id) as jumlah, supplier_nama as '.$type;
        $criteria->group = 'supplier_nama';
    }        
    if (count((array)$addCols) > 0){
        if (is_array($addCols)){
            foreach ($addCols as $i => $v){
                $criteria->group .= ','.$v;
                $criteria->select .= ','.$v.' as '.$i;
            }
        }            
    }
                                 
    return $criteria;
  }
        
  public function searchGrafik()
  {
    $filter = isset($_GET['filter'])?$_GET['filter']:null;
    $filter1 = isset($_GET['filter1'])?$_GET['filter1']:null;
    $filter2 = isset($_GET['filter2'])?$_GET['filter2']:null;
    $filter3 = isset($_GET['filter3'])?$_GET['filter3']:null;

    $criteria = $this->criteriaGrafik($this, 'data');
    
    $criteria->addBetweenCondition('tglterimabahan',$this->tgl_awal,$this->tgl_akhir);
    if ($filter == 'supplier')
    {
        if (!empty($this->supplier_id))
        {
            if(is_array($this->supplier_id)){
                $criteria->addInCondition('supplier_id', $this->supplier_id);
            }
        }else{
            $criteria->addCondition('supplier_id is null');
        }
    }
    if ($filter1 == 'golbahanmakanan')
    {
        if(is_array($this->golbahanmakanan_id)){
            $criteria->addInCondition('golbahanmakanan_id', $this->golbahanmakanan_id);
        }else{
            $criteria->addCondition('golbahanmakanan_id is null');
        }
    }
    if ($filter2 == 'jenisbahanmakanan')
    {
      if(is_array($this->jenisbahanmakanan)){
          $criteria->addInCondition('jenisbahanmakanan', $this->jenisbahanmakanan);
      }else{
          $criteria->compare('LOWER(jenisbahanmakanan)',strtolower($this->jenisbahanmakanan),TRUE);
      }     
    }
    if ($filter3 == 'kelbahanmakanan')
    {
      if(is_array($this->kelbahanmakanan)){
          $criteria->addInCondition('kelbahanmakanan', $this->kelbahanmakanan);
      }else{
          $criteria->compare('LOWER(kelbahanmakanan)',strtolower($this->kelbahanmakanan),TRUE);
      }            
    }
    
    return new CActiveDataProvider($this, array(
      'criteria'=>$criteria,
    ));
  }        	
        
  public function getNamaLengkap()
  {
    return $this->gelardepan.' '.$this->nama_pegawai.' '.$this->gelarbelakang_nama;
  }
        
  public function getNamaModel(){
    return __CLASS__;
  }
        
        
}