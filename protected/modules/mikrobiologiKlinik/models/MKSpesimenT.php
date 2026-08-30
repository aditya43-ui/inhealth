<?php

/**
 * This is the model class for table "spesimen_t".
 *
 * @author Tantowi J <tantowijaya@.com>
 * @author Yusuf Putra Anugrah <yusufputra@.com>
 * @package application.modules.mikrobiologiKlinik
 * @subpackage models
 * @category model
 */
class MKSpesimenT extends SpesimenT {
    
    public $tgl_awal,$tgl_akhir,$samplelab_nama,$jenispemeriksaan_nama,$nama_pasien,$no_rekam_medik,$daftartindakan_nama;
    public $pasien_id, $daftartindakan_id, $tarif_pelayananan, $permintaankepenunjang_id;
    public $status;
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return SpesimenT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CdbCriteria that can return criterias.
     */
    public function searchDaftarSpesimen() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->select="t.*,p.*,s.*,tin.*,daf.*";
        $criteria->join="
        left join penerimaanspesimendet_t tdet on t.penerimaanspesimendet_id=tdet.penerimaanspesimendet_id
        left join penerimaanspesimen_t pn on tdet.penerimaanspesimen_id=pn.penerimaanspesimen_id            
        left join pasien_m p on p.pasien_id=tdet.pasien_id left join samplelab_m s on t.samplelab_id=s.samplelab_id
        left join tindakanpelayanan_t tin on tin.tindakanpelayanan_id=t.tindakanpelayanan_id
        left join daftartindakan_m daf on daf.daftartindakan_id=tin.daftartindakan_id
        ";
        $criteria->addBetweenCondition('DATE(pn.tglterimaspesimen)',$this->tgl_awal,$this->tgl_akhir);
       
        $criteria->compare('LOWER(t.no_spesimen)', strtolower($this->no_spesimen), true);
        $criteria->compare('LOWER(s.samplelab_nama)', strtolower($this->samplelab_nama), true);
        $criteria->compare('LOWER(t.status)', strtolower($this->status), true);
        $criteria->compare('LOWER(daf.daftartindakan_nama)', strtolower($this->jenispemeriksaan_nama), true);
        if(!empty($this->status_pemeriksaan)){
            if($this->status_pemeriksaan == "-"){
                $criteria->addCondition('t.status_pemeriksaan IS NULL');
            }else{
                $criteria->compare('LOWER(t.status_pemeriksaan)', strtolower($this->status_pemeriksaan), true);
            }
        }
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            
        ));
    }
    
    

}
