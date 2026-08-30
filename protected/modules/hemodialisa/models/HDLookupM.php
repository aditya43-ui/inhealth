<?php

/**
 * Model yang digunakan untuk mengambil data tabel lookup_m, hanya untuk di modul sistem administrator
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @author Tantowi J <tantowijaya@.com>
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.sistemAdministrator
 * @subpackage models  
 */
class HDLookupM extends LookupM {
    public $lookup_name;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return LookupM the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Pencarian master data lookup 
     * @return \CActiveDataProvider
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        
//        $criteria->addCondition('lookup_type = "lantai_ruangan_hd"');
        $criteria->compare('lookup_id', $this->lookup_id);
        $criteria->compare('lookup_type', 'lantai_ruangan_hd', true);
        $criteria->compare('lookup_name', $this->lookup_name, true);
        $criteria->compare('lookup_value', $this->lookup_value, true);
        $criteria->compare('lookup_urutan', $this->lookup_urutan);
        $criteria->compare('lookup_kode', $this->lookup_kode, true);
        //$criteria->compare('lookup_aktif',$this->lookup_aktif);
        $criteria->compare('lookup_aktif', isset($this->lookup_aktif) ? $this->lookup_aktif : true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Print master lookup
     * @return \CActiveDataProvider
     */
    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
		$lookup_type = 'lantai_ruangan_hd';
        $criteria = new CDbCriteria;

        if (!empty($this->lookup_id)) {
            $criteria->addCondition('lookup_id =' . $this->lookup_id);
        }
        if (!empty($lookup_type)) {
            $criteria->compare('LOWER(lookup_type)', strtolower($lookup_type), true);
        }
        $criteria->compare('lookup_type', strtolower($lookup_type), true);
        $criteria->compare('LOWER(lookup_name)', strtolower($this->lookup_name), true);
        $criteria->compare('LOWER(lookup_value)', strtolower($this->lookup_value), true);
        $criteria->compare('lookup_urutan', $this->lookup_urutan);
        $criteria->compare('LOWER(lookup_kode)', strtolower($this->lookup_kode), true);
        //$criteria->compare('lookup_aktif',$this->lookup_aktif);
        $criteria->compare('lookup_aktif', isset($this->lookup_aktif) ? $this->lookup_aktif : true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false
        ));
    }

    /**
     * Pencarian data lookup berdasarkan tipe
     * @param type $lookup_type
     * @return \CActiveDataProvider
     */
    public function searchLookup($lookup_type = null) {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        
        if (!empty($this->lookup_id)) {
            $criteria->addCondition('lookup_id =' . $this->lookup_id);
        }
        if (!empty($lookup_type)) {
            if(is_array($lookup_type)){
             $criteria->addInCondition ('lookup_type', $lookup_type);
            }else{
               $criteria->compare('LOWER(lookup_type)', strtolower($lookup_type), true);
            }
        }
        $criteria->compare('lookup_type', $this->lookup_type, true);
        $criteria->compare('LOWER(lookup_name)', strtolower($this->lookup_name), true);
        $criteria->compare('LOWER(lookup_value)', strtolower($this->lookup_value), true);
        $criteria->compare('lookup_urutan', $this->lookup_urutan);
        $criteria->compare('LOWER(lookup_kode)', strtolower($this->lookup_kode), true);
        //$criteria->compare('lookup_aktif',$this->lookup_aktif);
        $criteria->compare('lookup_aktif', isset($this->lookup_aktif) ? $this->lookup_aktif : true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false
        ));
    }

    /**
     * Pencarian Master lookup RS
     * @param type $lookup_type
     * @return \CActiveDataProvider
     */
    public function searchLookupMasterRS($lookup_type = null) {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        if (!empty($this->lookup_id)) {
            $criteria->addCondition('lookup_id  = ' . $this->lookup_id);
        }
        $criteria->compare('lookup_aktif', $this->lookup_aktif);
        $criteria->compare('LOWER(lookup_type)', strtolower($lookup_type), true);
        $criteria->compare('LOWER(lookup_name)', strtolower($this->lookup_name), true);
        $criteria->compare('LOWER(lookup_value)', strtolower($this->lookup_value), true);
        $criteria->compare('LOWER(lookup_urutan)', strtolower($this->lookup_urutan), true);
        $criteria->compare('LOWER(lookup_kode)', strtolower($this->lookup_kode), true);
        $criteria->compare('lookup_aktif', isset($this->lookup_aktif) ? $this->lookup_aktif : true);
        //$criteria->compare('lookup_aktif',$this->lookup_aktif);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Get data lookup kelas rumah sakit
     * @param type $pemilik
     * @return type
     */
    public static function getItemsKelasRS($pemilik = null) {

        $data = array();
        $criteria = new CDbCriteria();
        $criteria->addCondition("lookup_type = 'kelas_rumahsakit'");
        $criteria->addCondition("lookup_value = " . "'$pemilik'");
        $criteria->order = "lookup_urutan";
        $criteria->addCondition("lookup_aktif IS TRUE");

        $models = self::model()->findAll($criteria);
        if (count($models) > 0) {
            foreach ($models as $model)
                $data[$model->lookup_name] = ucwords(strtolower($model->lookup_name));
        } else {
            $data[""] = null;
        }

        return $data;
    }

    /**
     * Get data lookup dengan lookup_type = 'jnspelayanan'
     * @return type
     */
    public static function getItemsList() {
        $criteria = new CDbCriteria();
        $criteria->addCondition("lookup_aktif = TRUE");
        $criteria->addCondition("lookup_type = 'jnspelayanan'");
        $criteria->order = "lookup_name";

        return self::model()->findAll($criteria);
    }

    /**
     * untuk master pemeriksaan lab - kelompok pemeriksaan
     * @return \CActiveDataProvider
     */
    public function searchKelompokPemeriksaanLab() {

        $criteria = new CDbCriteria;

        if (!empty($this->lookup_id)) {
            $criteria->addCondition('lookup_id = ' . $this->lookup_id);
        }
        $criteria->compare('lookup_type', "jenispemeriksaanlab_kelompok");
        $criteria->compare('lookup_name', $this->lookup_name, true);
        $criteria->compare('lookup_value', $this->lookup_value, true);
        $criteria->compare('lookup_urutan', $this->lookup_urutan);
        $criteria->compare('lookup_kode', $this->lookup_kode, true);
        //$criteria->compare('lookup_aktif',$this->lookup_aktif);
        $criteria->compare('lookup_aktif', isset($this->lookup_aktif) ? $this->lookup_aktif : true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * menampilkan lookup type satuanhasillab
     * @return \CActiveDataProvider
     */
    public function searchSatuanHasilLab() {

        $criteria = new CDbCriteria;

        if (!empty($this->lookup_id)) {
            $criteria->addCondition('lookup_id = ' . $this->lookup_id);
        }
        $criteria->compare('lookup_type', "satuanhasillab");
        //$criteria->compare('LOWER(lookup_type)',strtolower($this->satuanhasillab),true);
        //$criteria->compare('lookup_name',$this->lookup_name);
        $criteria->compare('LOWER(lookup_name)', strtolower($this->lookup_name), true);
        //$criteria->compare('lookup_value',$this->lookup_value);
        $criteria->compare('LOWER(lookup_value)', strtolower($this->lookup_value), true);
        //$criteria->compare('lookup_urutan',$this->lookup_urutan);
        if (!empty($this->lookup_urutan)) {
            $criteria->addCondition('lookup_urutan = ' . $this->lookup_urutan);
        }
        //$criteria->compare('lookup_kode',$this->lookup_kode);
        $criteria->compare('LOWER(lookup_kode)', strtolower($this->lookup_kode), true);
        //$criteria->compare('lookup_aktif',$this->lookup_aktif);
        $criteria->compare('lookup_aktif', isset($this->lookup_aktif) ? $this->lookup_aktif : true);
        $criteria->limit = -1;
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
                //'pagination'=>false,
        ));
    }

    /**
     * Print master satuan hasil lab
     * @return \CActiveDataProvider
     */
    public function searchPrintSatuanHasilLab() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        if (!empty($this->lookup_id)) {
            $criteria->addCondition('lookup_id = ' . $this->lookup_id);
        }
        $criteria->compare('lookup_type', "satuanhasillab");
        //$criteria->compare('LOWER(lookup_type)',strtolower($this->satuanhasillab),true);
        //$criteria->compare('lookup_name',$this->lookup_name);
        $criteria->compare('LOWER(lookup_name)', strtolower($this->lookup_name), true);
        //$criteria->compare('lookup_value',$this->lookup_value);
        $criteria->compare('LOWER(lookup_value)', strtolower($this->lookup_value), true);
        //$criteria->compare('lookup_urutan',$this->lookup_urutan);
        if (!empty($this->lookup_urutan)) {
            $criteria->addCondition('lookup_urutan = ' . $this->lookup_urutan);
        }
        //$criteria->compare('lookup_kode',$this->lookup_kode);
        $criteria->compare('LOWER(lookup_kode)', strtolower($this->lookup_kode), true);
        //$criteria->compare('lookup_aktif',$this->lookup_aktif);
        $criteria->compare('lookup_aktif', isset($this->lookup_aktif) ? $this->lookup_aktif : true);
        $criteria->limit = -1;
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    /**
     * lookup type statusperiksahasil
     * @return \CActiveDataProvider
     */
    public function searchStatusPeriksaHasil() {

        $criteria = new CDbCriteria;

        if (!empty($this->lookup_id)) {
            $criteria->addCondition('lookup_id = ' . $this->lookup_id);
        }
        $criteria->compare('lookup_type', "statusperiksahasil");
        $criteria->compare('lookup_name', $this->lookup_name);
        $criteria->compare('lookup_value', $this->lookup_value);
        $criteria->compare('lookup_urutan', $this->lookup_urutan);
        $criteria->compare('lookup_kode', $this->lookup_kode);
        $criteria->compare('lookup_aktif', $this->lookup_aktif);
        $criteria->compare('lookup_aktif',isset($this->lookup_aktif)?$this->lookup_aktif:true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Pencarian master lookup
     * @return \CActiveDataProvider
     */
    public function searchAdmin()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $lookup_type = 'satuanbarang';
        $criteria=new CDbCriteria;

        if(!empty($this->lookup_id)){
            $criteria->addCondition("lookup_id = ".$this->lookup_id);			
        }
        $criteria->compare('LOWER(lookup_name)',strtolower($this->lookup_name),true);
        $criteria->compare('LOWER(lookup_value)',strtolower($this->lookup_value),true);
        $criteria->compare('LOWER(lookup_type)',strtolower($lookup_type),true);
        $criteria->compare('lookup_urutan',$this->lookup_urutan);
        $criteria->compare('LOWER(lookup_kode)',strtolower($this->lookup_kode),true);
        $criteria->compare('lookup_aktif',isset($this->lookup_aktif)?$this->lookup_aktif:true);
        //$criteria->order = 'lookup_type, lookup_urutan';

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,

        ));
    }	
	
    /**
     * Pencarian master jenis kelompok
     * @return \CActiveDataProvider
     */
    public function searchJenisKelompok()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $lookup_type = 'jnskelompok';
        $criteria=new CDbCriteria;

        if(!empty($this->lookup_id)){
            $criteria->addCondition("lookup_id = ".$this->lookup_id);			
        }
        $criteria->compare('LOWER(lookup_name)',strtolower($this->lookup_name),true);
        $criteria->compare('LOWER(lookup_value)',strtolower($this->lookup_value),true);
        $criteria->compare('LOWER(lookup_type)',strtolower($lookup_type),true);
        $criteria->compare('lookup_urutan',$this->lookup_urutan);
        $criteria->compare('LOWER(lookup_kode)',strtolower($this->lookup_kode),true);
        $criteria->compare('lookup_aktif',isset($this->lookup_aktif)?$this->lookup_aktif:true);
        //$criteria->order = 'lookup_type, lookup_urutan';

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,

        ));
    }	
	
    /**
     * Print master jenis kelompok
     * @return \CActiveDataProvider
     */
    public function searchJenisKelompokPrint()
    {            
        $lookup_type = 'jnskelompok';
        $criteria=new CDbCriteria;

        if(!empty($this->lookup_id)){
            $criteria->addCondition("lookup_id = ".$this->lookup_id);			
        }

        $criteria->compare('LOWER(lookup_name)',strtolower($this->lookup_name),true);
        $criteria->compare('LOWER(lookup_value)',strtolower($this->lookup_value),true);
        $criteria->compare('LOWER(lookup_type)',strtolower($lookup_type),true);
        $criteria->compare('lookup_urutan',$this->lookup_urutan);
        $criteria->compare('LOWER(lookup_kode)',strtolower($this->lookup_kode),true);
        $criteria->compare('lookup_aktif',isset($this->lookup_aktif)?$this->lookup_aktif:true);
        //$criteria->order = 'lookup_type, lookup_urutan';
        $criteria->limit = -1;

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>false
        ));
    }	
    
    /**
     * digunakan untuk menampilkan data lookup saja
     * @return \CActiveDataProvider
     */
    public function searchLookupType(){
        $criteria=new CDbCriteria;
        $criteria->group = " lookup_type ";
        $criteria->select = $criteria->group;
        $criteria->compare('LOWER(lookup_type)',strtolower($this->lookup_type));        
        $criteria->order = 'lookup_type ASC';
        $criteria->limit = -1;
        return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,                        
        ));
    }

    /**
     * Print Master Kadar Obat
     * @return \CActiveDataProvider
     */
    public function searchPrintKadarObat() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria = new CDbCriteria;

        if (!empty($this->lookup_id)) {
            $criteria->addCondition('lookup_id =' . $this->lookup_id);
        }
        $criteria->compare('LOWER(lookup_type)',strtolower($this->lookup_type));    
        $criteria->compare('LOWER(lookup_name)', strtolower($this->lookup_name), true);
        $criteria->compare('LOWER(lookup_value)', strtolower($this->lookup_value), true);
        $criteria->compare('lookup_urutan', $this->lookup_urutan);
        $criteria->compare('LOWER(lookup_kode)', strtolower($this->lookup_kode), true);
        $criteria->compare('lookup_aktif', isset($this->lookup_aktif) ? $this->lookup_aktif : true);
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false
        ));
    }
    
}
