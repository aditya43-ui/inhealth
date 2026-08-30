<?php
/**
 * Digunakan Sebagai Model Laporan Pengujian Darah
 * @author  Andyka Putra<andykaputra@.com>
 * @package application.modules.bankDarah
 * @subpackage models
 **/
class BDLaporanpengujiandarahV extends LaporanpengujiandarahV
{
    public $tgl_awal, $tgl_akhir;
    
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanpengujiandarahV the static model class
	 */
	public static function model($className=__CLASS__)
	{
            return parent::model($className);
	}
        
        /**
         * Digunakan untuk pencarian pada tabel
         * @return \CActiveDataProvider
         */
	public function searchTable(){          	
            $criteria= new CDbCriteria();
            
            $criteria->addBetweenCondition('DATE(tglpengujian)', $this->tgl_awal, $this->tgl_akhir);
            $criteria->order = "DATE(tglpengujian) ASC";
            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
            ));
	
        }
        
        /**
         * Digunakan untuk pencarian ketika cetak
         * @return \CActiveDataProvider
         */
	public function searchPrint(){          	
            $criteria= new CDbCriteria();
            
            $criteria->addBetweenCondition('DATE(tglpengujian)', $this->tgl_awal, $this->tgl_akhir);
            $criteria->order = "DATE(tglpengujian) ASC";
            
            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'pagination'=>false,
            ));
	
        }
}