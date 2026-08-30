<?php
/**
 * controller utama menu - menu laporan
 * @package application.modules.rehabMedis
 * @subpackage models
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0 
 * @link    <http://piindonesia.co.id>
 */
class RMLaporanbiayapelayanan extends LaporanbiayapelayananV{
    
    /**
     * filter tabel
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
    
    /**
     * untuk mengenerate grafik, sesuai dengan pencarian dana data yang di grub sebagai label utamanya
     * @return \CActiveDataProvider
     */
    public function searchGrafik() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

            
        $criteria=new CDbCriteria;
        //$criteria->addBetweenCondition('date(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->select = 'count(pendaftaran_id) as jumlah, kelaspelayanan_nama as data';        
        if (!empty($this->penjamin_id)){
            $criteria->addInCondition('penjamin_id', $this->penjamin_id);
        }else{
            //$criteria->addCondition('penjamin_id is null');
        }
        if (!empty($this->kelaspelayanan_id)){
            $criteria->addInCondition('kelaspelayanan_id', $this->kelaspelayanan_id);
        }else{
            //$criteria->addCondition('kelaspelayanan_id is null');
        }

        $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));        
        $criteria->group = 'kelaspelayanan_nama';
                        
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));

    }
    
    /**
     * untuk mengenerate hasil data sesuai prinout
     * @return \CActiveDataProvider
     */
    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        
        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination'=>false,
                ));
    }
    
    /**
     * filter utama pencarian data, khusus criteria yang ada relasi ke action ini saja
     * @return \CDbCriteria
     */
    protected function functionCriteria(){
        $criteria = new CDbCriteria();
        
        $criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
        $criteria->select = 'pendaftaran_id, ruangan_id, tgl_pendaftaran, no_rekam_medik, nama_pasien, nama_bin, jeniskelamin, umur, no_pendaftaran, jeniskasuspenyakit_nama, kelaspelayanan_nama, kelaspelayanan_id, carabayar_nama, penjamin_nama, penjamin_id, carabayar_id, sum(tarif_tindakan) as total, sum(iurbiaya_tindakan) as iurbiaya';
        $criteria->group = 'pendaftaran_id, ruangan_id, tgl_pendaftaran, no_rekam_medik, nama_pasien, nama_bin, jeniskelamin, umur, no_pendaftaran, jeniskasuspenyakit_nama, kelaspelayanan_nama, kelaspelayanan_id, carabayar_nama, penjamin_nama, penjamin_id, carabayar_id';

        if (!empty($this->penjamin_id)){
            if (is_array($this->penjamin_id)){
                $criteria->addInCondition('penjamin_id', $this->penjamin_id);
            }
        }
        
        if (!empty($this->kelaspelayanan_id)){
            if (is_array($this->kelaspelayanan_id)){
                $criteria->addInCondition('kelaspelayanan_id', $this->kelaspelayanan_id);
            }
        }
        
        if (!empty($this->carabayar_id)){
            if (is_array($this->carabayar_id)){
                $criteria->addInCondition('carabayar_id', $this->carabayar_id);
            }
        }
        
        $criteria->addCondition(" ruangan_id =".Yii::app()->user->getState('ruangan_id'));
		

        
        return $criteria;
    }
    
    /**
     * menegenrate fungsi - fungsi yii cActiveDataProvider
     * @return system
     */
    public function getNamaModel(){
        return __CLASS__;
    }
}

?>
