<?php

/**
 * This is the model class for table "returbayarpelayanan_t".
 *
 * The followings are the available columns in table 'returbayarpelayanan_t':
 * @property integer $returbayarpelayanan_id
 * @property integer $tandabuktikeluar_id
 * @property integer $tandabuktibayar_id
 * @property integer $ruangan_id
 * @property string $tglreturpelayanan
 * @property string $noreturbayar
 * @property double $totaloaretur
 * @property double $totaltindakanretur
 * @property double $totalbiayaretur
 * @property double $biayaadministrasi
 * @property string $keteranganretur
 * @property integer $user_nm_otorisasi
 * @property integer $user_id_otorisasi
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class BKLaporanreturpelayananV extends LaporanreturpelayananV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ReturbayarpelayananT the static model class
	 */
    public $jumlah, $tick, $data;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
     public function getNamaModel() {
            return __CLASS__;
        }

    public function searchGrafik() {

        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteria();
        
        $criteria->select = 'count(pasien_id) as jumlah, ruanganakhir_nama as data';
        $criteria->group = 'ruanganakhir_nama';

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
        $criteria = new CDbCriteria();
        if(!empty($this->ruangan_id)){
                        if (is_array($this->ruangan_id)) {
                            $criteria->addInCondition('ruanganakhir_id', $this->ruangan_id);
                        } else {
                            $criteria->addCondition('ruanganakhir_id = '.$this->ruangan_id);
                        }
		}
        $criteria->addBetweenCondition('tglreturpelayanan', $this->tgl_awal, $this->tgl_akhir);

        return $criteria;
    }    
}