<?php

/**
 * Model untuk tabel IdentifikasiresikoT hanya untuk model pelayanan kesehatan masyarakat
 * @author   Yusuf Putra Anugrah <yusufputra@.com>
 * @author   Aida Rahmawati <aidarahmawati@.com>
 * @author Wahyu Wicaksono <wahyuwicaksono.@gmail.com>
 * @category RSST-8455 Improvment Informasi Risk Register
 * @package application.modules.yankesMasyarakat
 * @subpackage models
 */
class YKMIdentifikasiresikoT extends IdentifikasiresikoT {

    public $periode_awal, $periode_akhir, $unitkerja_id, $ruangan_nama;
    public  $from, $ruang_id;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return LaporaninsidenV the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchInformasi() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $ruang = Yii::app()->user->getState('ruangan_id');

        $criteria = new CDbCriteria;

        $criteria->select = "p.periode_awal,p.periode_akhir,t.*,u.namaunitkerja, u.unitkerja_id, r.ruangan_nama";
        $criteria->join = "left join perioderiskregister_m p on t.perioderiskregister_id=p.perioderiskregister_id "
                        . "left join unitkerja_m u on t.unitkerja_id=u.unitkerja_id "
                        . "left join ruangan_m r on t.ruangan_id = r.ruangan_id";
        $criteria->addCondition('t.is_batal = false'); 
        $criteria->compare('t.perioderiskregister_id', $this->perioderiskregister_id);
        $criteria->compare('t.sumber_resiko', $this->sumber_resiko, true);
        $criteria->compare('t.tiperesiko_id', $this->tiperesiko_id);
        $criteria->compare('t.subtiperesiko_id', $this->subtiperesiko_id);        
        $criteria->compare('u.unitkerja_id', $this->unitkerja_id);
        $criteria->compare('t.jenisriskmanajemen', $this->jenisriskmanajemen);
        if($ruang != Params::RUANGAN_ID_KMKP){
            $criteria->compare('t.ruangan_id',$ruang);
        }
        $criteria->order = "t.create_time DESC";
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
