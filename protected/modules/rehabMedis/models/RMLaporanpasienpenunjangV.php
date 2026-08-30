<?php
/**
 * menampung fungsi -fungsi javascript
 * 
 * @package application.modules.rehabMedis
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://piindonesia.co.id>
 */
class RMLaporanpasienpenunjangV extends LaporanpasienpenunjangV {
    public $tgl_awal,$tgl_akhir;
    public $jumlah, $data, $tick;
    
    /**
     * untuk mengenerate fungsi - fungsi yii activeDataprovider
     * @param type $className
     * @return type
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * mengenerate data dalam bentuk tabel
     * @return \CActiveDataProvider
     */
    public function searchTable() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    /** fungsi untuk generate filter / criteria pada model untuk grafik
    * $model adalah model yang akan digunakan untuk grafik
    * $type adalah filter akan digunakan sebagai x-axis('data') atau group('tick'), default type sebagai x-axis('data')
    * $addCols variable untuk column tmbahan, typenya mix, diantaranya untuk order dll,
    */
    public static function criteriaGrafik($model, $type='data'){
        $criteria = new CDbCriteria;
        
        $criteria->select = 'count(t.pendaftaran_id) as jumlah';
        
        if ($_GET['tampilGrafik'] == 'carabayar') {
            if (!empty($model->penjamin_id)) {
                $criteria->select .= ', penjamin_nama as '.$type;
                $criteria->group .= 'penjamin_nama';
            } else if (!empty($model->carabayar_id)) {
                $criteria->select .= ', penjamin_nama as '.$type;
                $criteria->group = 'penjamin_nama';
            } else {
                $criteria->select .= ', carabayar_nama as '.$type;
                $criteria->group = 'carabayar_nama';
            }
        }elseif ($_GET['tampilGrafik'] == 'wilayah') {
            if (!empty($model->kelurahan_id)) {
                $criteria->select .= ', kelurahan_nama as '.$type;
                $criteria->group .= 'kelurahan_nama';
            } else if (!empty($model->kecamatan_id)) {
                $criteria->select .= ', kelurahan_nama as '.$type;
                $criteria->group .= 'kelurahan_nama';
            } else if (!empty($model->kabupaten_id)) {
                $criteria->select .= ', kecamatan_nama as '.$type;
                $criteria->group .= 'kecamatan_nama';
            } else if (!empty($model->propinsi_id)) {
                $criteria->select .= ', kabupaten_nama as '.$type;
                $criteria->group .= 'kabupaten_nama';
            } else {
                $criteria->select .= ', propinsi_nama as '.$type;
                $criteria->group .= 'propinsi_nama';
            }
        }elseif ($_GET['tampilGrafik'] == 'kunjungan') {
            $criteria->select .= ', kunjungan as '.$type;
            $criteria->group .= 'kunjungan';
        }elseif ($_GET['tampilGrafik'] == 'instalasiasal') {
            $criteria->select .= ', instalasiasal_nama as '.$type;
            $criteria->group .= 'instalasiasal_nama';
        }elseif ($_GET['tampilGrafik'] == 'ruanganasal') {
            $criteria->select .= ', ruanganasal_nama as '.$type;
            $criteria->group .= 'ruanganasal_nama';
        }

        return $criteria;
    }
    
    /**
     * pencarian grafik
     * @return \CActiveDataProvider
     */
    public function searchGrafik() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.        
        $criteria = new CDbCriteria; 
        $criteria = $this->criteriaGrafik($this, 'tick');

        $criteria->select .= ', kunjungan as data';
        $criteria->group .= ', kunjungan';
        $criteria->addBetweenCondition('date(tglmasukpenunjang)', $this->tgl_awal, $this->tgl_akhir);
		
        if (!empty($this->instalasiasal_id)){
            if (is_array($this->instalasiasal_id)){
                $criteria->addInCondition('instalasiasal_id',$this->instalasiasal_id);
            }else{
                $criteria->addCondition('instalasiasal_id ='.$this->instalasiasal_id);
            }
        }
		
        if (!empty($this->ruanganasal_id)){
            if (is_array($this->ruanganasal_id)){
                $criteria->addInCondition('ruanganasal_id',$this->ruanganasal_id);
            }else{
                $criteria->addCondition('ruanganasal_id ='.$this->ruanganasal_id);
            }
        }
        
        $ruangan_id = Yii::app()->user->getState('ruangan_id');
        if (!empty($ruangan_id)){
                $criteria->addCondition('ruanganpenunj_id ='.$ruangan_id);
        }
        
		
        
        if (!is_array($this->kunjungan)){
            $this->kunjungan = 0;
        }else{
            $data = array();
            foreach(  $this->kunjungan as $i => $values ){
                                
                if( $values == "KUNJUNGAN ULANG"){
                    $data[]="KUNJUNGAN LAMA";
                } else{
                    $data[]=$values;
                }
            }                                            
            $criteria->addInCondition('kunjungan', $data);
        }
        
        
        if (!empty($this->penjamin_id)){
            if (is_array($this->penjamin_id)){
                $criteria->addInCondition('penjamin_id',$this->penjamin_id);
            }else{
                $criteria->addCondition('penjamin_id ='.$this->penjamin_id);
            }
        }
        
        if (!empty($this->propinsi_id)){
            if (is_array($this->propinsi_id)){
                $criteria->addInCondition('propinsi_id',$this->propinsi_id);
            }else{
                $criteria->addCondition('propinsi_id ='.$this->propinsi_id);
            }                
        }
        
        if (!empty($this->kabupaten_id)){
            if (is_array($this->kabupaten_id)){
                $criteria->addInCondition('kabupaten_id',$this->kabupaten_id);
            }else{
                $criteria->addCondition('kabupaten_id ='.$this->kabupaten_id);
            }                
        }

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    /**
     * mengenerate data dalam bentuk prinout
     * @return \CActiveDataProvider
     */
    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => false
                ));
    }

    /**
     * fungsi pencarian data
     * @return \CDbCriteria
     */
    protected function functionCriteria() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        
        $criteria->addBetweenCondition('date(tglmasukpenunjang)', $this->tgl_awal, $this->tgl_akhir);
		
        if (!empty($this->instalasiasal_id)){
            if (is_array($this->instalasiasal_id)){
                $criteria->addInCondition('instalasiasal_id',$this->instalasiasal_id);
            }else{
                $criteria->addCondition('instalasiasal_id ='.$this->instalasiasal_id);
            }
        }
		
        if (!empty($this->ruanganasal_id)){
            if (is_array($this->ruanganasal_id)){
                $criteria->addInCondition('ruanganasal_id',$this->ruanganasal_id);
            }else{
                $criteria->addCondition('ruanganasal_id ='.$this->ruanganasal_id);
            }
        }
        
        $ruangan_id = Yii::app()->user->getState('ruangan_id');
        if (!empty($ruangan_id)){
                $criteria->addCondition('ruanganpenunj_id ='.$ruangan_id);
        }
        
		
        
        if (!empty($this->kunjungan)){
            if (is_array($this->kunjungan)){
                $data = array();
                foreach(  $this->kunjungan as $i => $values ){

                    if( $values == "KUNJUNGAN ULANG"){
                        $data[]="KUNJUNGAN LAMA";
                    } else{
                        $data[]=$values;
                    }
                }                                            
                $criteria->addInCondition('kunjungan', $data);
            }
        }
        
        
        if (!empty($this->penjamin_id)){
            if (is_array($this->penjamin_id)){
                $criteria->addInCondition('penjamin_id',$this->penjamin_id);
            }else{
                $criteria->addCondition('penjamin_id ='.$this->penjamin_id);
            }
        }
        
        if (!empty($this->propinsi_id)){
            if (is_array($this->propinsi_id)){
                $criteria->addInCondition('propinsi_id',$this->propinsi_id);
            }else{
                $criteria->addCondition('propinsi_id ='.$this->propinsi_id);
            }                
        }
        
        if (!empty($this->kabupaten_id)){
            if (is_array($this->kabupaten_id)){
                $criteria->addInCondition('kabupaten_id',$this->kabupaten_id);
            }else{
                $criteria->addCondition('kabupaten_id ='.$this->kabupaten_id);
            }                
        }
                
        return $criteria;
    }    
    
    /**
     * untuk mengenerate nama class model ini
     * @return system
     */
    public function getNamaModel(){
        return __CLASS__;
    }
}

?>
