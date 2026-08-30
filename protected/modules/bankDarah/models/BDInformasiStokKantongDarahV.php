<?php
/**
 * Model untuk Stok Kantong Darah di modul bank darah
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.bankDarah
 * @subpackage models
 **/
class BDInformasiStokKantongDarahV extends InfostokkantongdarahV
{
    public $tgl_awal, $tgl_akhir;
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KarcisV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
  
        
         public function searchLaporan() {
            $criteria = new CDbCriteria;
            $criteria->select = "TRIM(gol_darah) as gol_darah, tgl_kadaluarsa, tglpencatatan,"
                    . "singkatan_komp";
                   // . "count(jmlkantongdarah) as jmlkantongdarah,"
                 //   . "count(u.rilis) as rilis";
            $criteria->group = "TRIM(gol_darah), singkatan_komp, tgl_kadaluarsa, tglpencatatan";
            $criteria->order = " singkatan_komp ASC, TRIM(gol_darah) ASC";
            $criteria->addCondition("gol_darah is not null");
             $criteria->addBetweenCondition('DATE(tgl_kadaluarsa)', $this->tgl_awal, $this->tgl_akhir);
            $criteria->compare('singkatan_komp', $this->singkatan_komp);
            $criteria->compare('gol_darah', $this->gol_darah);
         
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    public function searchPrintLaporan() {
            $criteria = new CDbCriteria;
            $criteria->select = "TRIM(gol_darah) as gol_darah, tgl_kadaluarsa, tglpencatatan,"
                    . "singkatan_komp";
                   // . "count(jmlkantongdarah) as jmlkantongdarah,"
                 //   . "count(u.rilis) as rilis";
            $criteria->group = "TRIM(gol_darah), singkatan_komp, tgl_kadaluarsa, tglpencatatan";
            $criteria->order = " singkatan_komp ASC, TRIM(gol_darah) ASC";
            $criteria->addCondition("gol_darah is not null");
             $criteria->addBetweenCondition('DATE(tgl_kadaluarsa)', $this->tgl_awal, $this->tgl_akhir);
            $criteria->compare('singkatan_komp', $this->singkatan_komp);
            $criteria->compare('gol_darah', $this->gol_darah);
         
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination'=>false
        ));
    }
    
    public function getStokKantongDarahLaporan($singkatan_komp , $gol_darah, $tgl_kadaluarsa){
        $criteria = new CDbCriteria;
        $criteria->select = 'count(t.jmlkantongdarah) as jmlkantongdarah , komponen.singkatan_komp ,t.gol_darah, t.tgl_kadaluarsa';
        $criteria->join = ' LEFT JOIN komponendarah_m as komponen ON t.komponendarah_id = komponen.komponendarah_id';
        $criteria->group = 'komponen.singkatan_komp,t.gol_darah, t.tgl_kadaluarsa';
        $criteria->addCondition("t.ujikompatibilitas_id is null");
        $criteria->addCondition("komponen.singkatan_komp ='".$singkatan_komp."'");
        $criteria->addCondition("t.gol_darah ='".$gol_darah."'");
        $criteria->addCondition("t.tgl_kadaluarsa ='".$tgl_kadaluarsa."'");
        
        $model = InfostokkantongdarahV::model()->find($criteria);
        if(!empty($model)){
            $total = $model->jmlkantongdarah;
        }else{
            $total = 0;
        }
        return $total;
    }
    
    public function getStokDarahSiapLaporan($singkatan_komp,$gol_darah, $tgl_kadaluarsa){
        $criteria = new CDbCriteria;
        $criteria->select = 'count(t.jmlkantongdarah) as jmlkantongdarah , komponen.singkatan_komp , t.golongan_darah, kantongdrh.tgl_kadaluarsa';
        $criteria->join = 'LEFT JOIN ujikompatibilitas_t as uji ON t.ujikompatibilitas_id = uji.ujikompatibilitas_id '
                        . 'LEFT JOIN kantongdarah_t as kantongdrh ON kantongdrh.kantongdarah_id = t.kantongdarah_id '
                        //. 'LEFT JOIN penyerahandarah_t as penyerahan ON penyiapan.penyiapandarah_id = penyerahan.penyiapandarah_id '
                        . 'LEFT JOIN komponendarah_m as komponen ON t.komponendarah_id = komponen.komponendarah_id';
        $criteria->group = 'komponen.singkatan_komp,t.golongan_darah, kantongdrh.tgl_kadaluarsa';
        $criteria->addCondition("t.ujikompatibilitas_id is not null");
        //$criteria->addCondition("penyiapan.penyiapandarah_id is not null");
        //$criteria->addCondition("penyerahan.penyerahandarah_id is null");
        $criteria->addCondition("komponen.singkatan_komp ='".$singkatan_komp."'");
        $criteria->addCondition("t.golongan_darah ='".$gol_darah."'");
        $criteria->addCondition("kantongdrh.tgl_kadaluarsa ='".$tgl_kadaluarsa."'");
        $model = StokkantongdarahT::model()->find($criteria);
        if(!empty($model)){
            $total = $model->jmlkantongdarah;
        }else{
            $total = 0;
        }
        return $total;
    }
    
    public function getStokDarahKeluarLaporan($singkatan_komp,$gol_darah, $tgl_kadaluarsa){
        $criteria = new CDbCriteria();
        $criteria->select = 'count(t.jmlkantongdarah) as jmlkantongdarah , komponen.singkatan_komp , t.golongan_darah, kantongdrh.tgl_kadaluarsa';
        $criteria->join = 'LEFT JOIN ujikompatibilitas_t as uji ON t.ujikompatibilitas_id = uji.ujikompatibilitas_id '
                        . 'LEFT JOIN penyiapandarah_t as penyiapan ON uji.ujikompatibilitas_id = penyiapan.ujikompatibilitas_id '
                        . 'LEFT JOIN penyerahandarah_t as penyerahan ON penyiapan.penyiapandarah_id = penyerahan.penyiapandarah_id '
                        . 'LEFT JOIN komponendarah_m as komponen ON t.komponendarah_id = komponen.komponendarah_id '
                . 'LEFT JOIN kantongdarah_t as kantongdrh ON kantongdrh.kantongdarah_id = t.kantongdarah_id';
        $criteria->group = 'komponen.singkatan_komp,t.golongan_darah, kantongdrh.tgl_kadaluarsa';
        $criteria->addCondition('t.ujikompatibilitas_id is not null');
        $criteria->addCondition('penyiapan.penyiapandarah_id is not null');
        $criteria->addCondition('penyerahan.penyerahandarah_id is not null');
        $criteria->addCondition("komponen.singkatan_komp ='".$singkatan_komp."'");
        $criteria->addCondition("t.golongan_darah ='".$gol_darah."'");
        $criteria->addCondition("kantongdrh.tgl_kadaluarsa ='".$tgl_kadaluarsa."'");
        $model = StokkantongdarahT::model()->find($criteria);
        if(!empty($model)){
            $total = $model->jmlkantongdarah;
        }else{
            $total =0;
        }
        return $total;
    }
}