<?php
/**
 * @author          YusufPutraAnugrah<yusufputra@.com>
 * @version         2.0.0
 * @documentation   http://kbase..com
 * @issue           RSST-1579
 * Pembuatan laporan konfirmasi golongan darah 
 */
class BDLaporanPengujianDarah extends PengujiandarahT
{
        public $instalasi_id,$instalasi_nama,$ruangan_id,$runagan_nama,$petugaspengujian_nama,$tgl_awal,$tgl_akhir,$tanggal,$no_kantong_darah,$goldar_awal,$rhesus_awal,$goldar_akhir,$rhesus_akhir,$keterangan;
	
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LapseleksidonordarahV the static model class
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
            $criteria->join="join kantongdarah_t p on t.nomorbarcode_sample = p.nomorbarcode_sample "
                          . "join pendonor_m s on s.pendonor_id = p.pendonor_id";
            $criteria->select="DATE(t.tglpengujian) as tanggal,p.no_kantongdarah as no_kantong_darah,s.gol_darah as goldar_awal,s.rhesus as rhesus_awal,t.gol_darah as goldar_akhir,t.rhesus as rhesus_akhir,t.hasil_uji as keterangan";

            $criteria->addBetweenCondition('DATE(tglpengujian)', $this->tgl_awal, $this->tgl_akhir);
            
            if(!empty($this->asalruangan_id)){
               
                $criteria->addCondition('asalruangan_id='.$this->asalruangan_id);
            }
             $criteria->group = "tanggal,no_kantong_darah,goldar_awal,rhesus_awal,goldar_akhir,rhesus_akhir,keterangan";
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
	
        }
        
        /**
         * Digunakan untuk pencarian pada print
         * @return \CActiveDataProvider
         */
        public function searchPrint(){          	
            $criteria= new CDbCriteria();
            $criteria->join="join kantongdarah_t p on t.nomorbarcode_sample = p.nomorbarcode_sample "
                          . "join pendonor_m s on s.pendonor_id = p.pendonor_id";
            $criteria->select="DATE(t.tglpengujian) as tanggal,p.no_kantongdarah as no_kantong_darah,s.gol_darah as goldar_awal,s.rhesus as rhesus_awal,t.gol_darah as goldar_akhir,t.rhesus as rhesus_akhir,t.hasil_uji as keterangan";

            $criteria->addBetweenCondition('DATE(tglpengujian)', $this->tgl_awal, $this->tgl_akhir);
            
            if(!empty($this->asalruangan_id)){
               
                $criteria->addCondition('asalruangan_id='.$this->asalruangan_id);
            }
             $criteria->group = "tanggal,no_kantong_darah,goldar_awal,rhesus_awal,goldar_akhir,rhesus_akhir,keterangan";
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
	
        }
        
       
}