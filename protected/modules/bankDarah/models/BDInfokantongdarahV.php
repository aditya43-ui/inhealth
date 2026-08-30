<?php
/**
 * Digunakan untuk mengakses halaman Master Evaluasi
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.bankDarah
 * @subpackage models
 */
class BDInfokantongdarahV extends InfokantongdarahV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfostokkantongdarahV the static model class
	 */
        public $skrining, $wb, $pc, $ffp, $pcr, $tc, $nomorbarcode_sample_imltd;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
         * pencarian sample darah
         * @return \CActiveDataProvider
         */
        public function searchSampelDarah()
	{		
            $cri = new CDbCriteria; 
            $cri->select = " t.*, terima.tglterimakantong, "
                        . "  k.nomorbarcode_sample_imltd, "
                        . "  terdet.sampel_konfirmasi, terdet.sampel_imltd ";
            $cri->join =  " JOIN terimakantongdarah_t terima ON t.terimakantongdarah_id =  terima.terimakantongdarah_id "
                        . " JOIN kantongdarah_t k ON k.kantongdarah_id = t.kantongdarah_id "
                        . " JOIN terimakantongdet_t terdet ON terdet.kantongdarah_id = t.kantongdarah_id ";
            $cri->compare("LOWER(t.no_identitas)", strtolower($this->no_identitas),true);
            $cri->compare("LOWER(t.no_formulir)", strtolower($this->no_formulir),true);
            $cri->compare("LOWER(t.nomorbarcode_utama)", strtolower($this->nomorbarcode_utama),true);
            $cri->compare("LOWER(t.nomorbarcode_sample)", strtolower($this->nomorbarcode_sample),true);
            $cri->compare("LOWER(k.nomorbarcode_sample_imltd)", strtolower($this->nomorbarcode_sample_imltd),true);
            
            $cri->addBetweenCondition("DATE(terima.tglterimakantong)", $this->tgl_awal, $this->tgl_akhir);            
            $cri->addCondition(" terdet.sampel_konfirmasi = TRUE OR terdet.sampel_imltd = TRUE ");
            $cri->addCondition('k.nomorbarcode_sample is not null ');//and nomorbarcode_sample_imltd is not null
            if (!empty($this->gol_darah)){
                $cri->addCondition(" t.gol_darah = '".$this->gol_darah."' ");
            }
            
            if (!empty($this->rhesus)){
                $cri->addCondition(" t.rhesus = '".$this->rhesus."' ");
            }
            
            if (!empty($this->jeniskantongdarah_id)){
                $cri->addCondition(" t.jeniskantongdarah_id = '".$this->jeniskantongdarah_id."' ");
            }
                        
            $kantong = InfokantongdarahV::model()->findAll($cri);
            
            $res = array();

            foreach ($kantong as $det){
                $res[$det->nomorbarcode_sample]['tglterimakantong'] = $det->tglterimakantong;
                $res[$det->nomorbarcode_sample]['no_identitas'] = $det->no_identitas;
                $res[$det->nomorbarcode_sample]['no_formulir'] = $det->no_formulir;
                $res[$det->nomorbarcode_sample]['nomorbarcode_utama'] = $det->nomorbarcode_utama;
                $res[$det->nomorbarcode_sample]['nomorbarcode_sample'] = $det->nomorbarcode_sample;
                $res[$det->nomorbarcode_sample]['nomorbarcode_imltd'] = $det->nomorbarcode_sample_imltd;
                $res[$det->nomorbarcode_sample]['sampel_imltd'] = $det->sampel_imltd;
                $res[$det->nomorbarcode_sample]['sampel_konfirmasi'] = $det->sampel_konfirmasi;
                $res[$det->nomorbarcode_sample]['gol_darah'] = $det->gol_darah;
                $res[$det->nomorbarcode_sample]['rhesus'] = $det->rhesus;
                $res[$det->nomorbarcode_sample]['nama_jenis'] = $det->nama_jenis;
                $res[$det->nomorbarcode_sample]['jeniskantongdarah_id'] = $det->jeniskantongdarah_id;
                $res[$det->nomorbarcode_sample]['det'][$det->kantongdarah_id]['komponendarah_id'] = $det->komponendarah_id;                
                $res[$det->nomorbarcode_sample]['det'][$det->kantongdarah_id]['no_kantongdarah'] = $det->no_kantongdarah;                                
            }
            
            $data = array();
            
            $i = 0;
            foreach($res as $a => $val){
                $data[$i] = $val;
                $data[$i] = $val;
                $i++;
            }

            return new CArrayDataProvider($data, array(
                'keyField'=>'nomorbarcode_sample',			
                'id'=>'data_laporan',
                'totalItemCount'=>count($data),
                'pagination' => array(
                    'pageSize' => 10,
                    'pageVar' => 'page'
                ),	
                'sort' => array('defaultOrder' =>'tglterimakantong DESC')
            ));        
	}
        
        /**
         * pencarian sample darah, pada transaksi konfirmasi golongan darah
         * @return \CActiveDataProvider
         */
        public function searchSampelDarahForKonfirmasiGolDarah()
	{		
            $cri = new CDbCriteria; 
            $cri->select = " t.*, terima.tglterimakantong, r_kirim.ruangan_nama as ruangankirim_nama, r_kirim.ruangan_id as ruangankirim_id, r_terima.ruangan_nama as ruanganterima_nama, r_terima.ruangan_id as ruanganterima_id ";
            $cri->join =    "   JOIN terimakantongdarah_t terima ON t.terimakantongdarah_id =  terima.terimakantongdarah_id "
                        .   "   JOIN terimakantongdet_t det ON det.kantongdarah_id = t.kantongdarah_id "
                        .   "   JOIN kirimkantongdarah_t kirim ON kirim.kirimkantongdarah_id = terima.kirimkantongdarah_id "
                        .   "   JOIN ruangan_m r_kirim ON r_kirim.ruangan_id = kirim.ruangankirim_id  "
                        .   "   JOIN ruangan_m r_terima ON r_terima.ruangan_id = terima.ruanganterima_id "
                        .   "   LEFT JOIN pengujiandarah_t uji ON (uji.nomorbarcode_sample = t.nomorbarcode_sample) AND pengujian_ke = 1";            
            $cri->addCondition(" uji.pengujiandarah_id is null ");
            $cri->compare("LOWER(t.no_identitas)", strtolower($this->no_identitas),true);
            $cri->compare("LOWER(t.no_formulir)", strtolower($this->no_formulir),true);
            $cri->compare("LOWER(t.nomorbarcode_utama)", strtolower($this->nomorbarcode_utama),true);
            $cri->compare("LOWER(t.nomorbarcode_sample)", strtolower($this->nomorbarcode_sample),true);
                                    
            if (!empty($this->gol_darah)){
                $cri->addCondition(" t.gol_darah = '".$this->gol_darah."' ");
            }
            
            if (!empty($this->rhesus)){
                $cri->addCondition(" t.rhesus = '".$this->rhesus."' ");
            }
            
            if (!empty($this->jeniskantongdarah_id)){
                $cri->addCondition(" t.jeniskantongdarah_id = '".$this->jeniskantongdarah_id."' ");
            }
                        
            $kantong = InfokantongdarahV::model()->findAll($cri);
            
            $res = array();

            foreach ($kantong as $det){                
                $res[$det->nomorbarcode_sample]['tglterimakantong'] = $det->tglterimakantong;
                $res[$det->nomorbarcode_sample]['no_identitas'] = $det->no_identitas;
                $res[$det->nomorbarcode_sample]['no_formulir'] = $det->no_formulir;
                $res[$det->nomorbarcode_sample]['nomorbarcode_utama'] = $det->nomorbarcode_utama;
                $res[$det->nomorbarcode_sample]['nomorbarcode_sample'] = $det->nomorbarcode_sample;
                $res[$det->nomorbarcode_sample]['gol_darah'] = $det->gol_darah;
                $res[$det->nomorbarcode_sample]['rhesus'] = $det->rhesus;
                $res[$det->nomorbarcode_sample]['nama_jenis'] = $det->nama_jenis;
                $res[$det->nomorbarcode_sample]['jeniskantongdarah_id'] = $det->jeniskantongdarah_id;
                $res[$det->nomorbarcode_sample]['ruangankirim_nama'] = $det->ruangankirim_nama;
                $res[$det->nomorbarcode_sample]['ruangankirim_id'] = $det->ruangankirim_id;
                $res[$det->nomorbarcode_sample]['ruanganterima_nama'] = $det->ruanganterima_nama;
                $res[$det->nomorbarcode_sample]['ruanganterima_id'] = $det->ruanganterima_id;
                $res[$det->nomorbarcode_sample]['pendonor_id'] = $det->pendonor_id;
                $res[$det->nomorbarcode_sample]['det'][$det->kantongdarah_id]['komponendarah_id'] = $det->komponendarah_id;                
                $res[$det->nomorbarcode_sample]['det'][$det->kantongdarah_id]['no_kantongdarah'] = $det->no_kantongdarah;                                
            }
            
            $data = array();
            
            $i = 0;
            foreach($res as $a => $val){
                $data[$i] = $val;
                $data[$i] = $val;
                $i++;
            }

            return new CArrayDataProvider($data, array(
                'keyField'=>'nomorbarcode_sample',			
                'id'=>'data_laporan',
                'totalItemCount'=>count($data),
                'pagination' => array(
                    'pageSize' => 10,
                    'pageVar' => 'page'
                ),	
                'sort' => array('defaultOrder' =>'tglterimakantong DESC')
            ));        
	}
        
        /**
         * Model untuk menampilkan data pada halaman informasi kantong darah
         * @author Andyka Putra <andykaputra@.com>
         * @return \CActiveDataProvider
         */
        public function searchInformasiKantongDarah(){          	
            $criteria=new CDbCriteria;

            $criteria->select = "t.*, d.tglterimakantong";
            $criteria->join = " JOIN infoterimakantongdarah_v d on t.kantongdarah_id = d.kantongdarah_id "
                            . " JOIN terimakantongdet_t trmdet ON trmdet.terimakantongdet_id = d.terimakantongdet_id ";

            
            $criteria->addBetweenCondition('DATE(d.tglterimakantong)', $this->tgl_awal, $this->tgl_akhir);
            $criteria->compare('lower(t.rhesus)',strtolower($this->rhesus),true);
            $criteria->addCondition(" trmdet.sampel_utama = true AND t.batalkantongdarah_id IS NULL ");
            if (!empty($this->jeniskantongdarah_id)){
                $criteria->addCondition(" t.jeniskantongdarah_id = '".$this->jeniskantongdarah_id."' ");
            }

            $criteria->compare('lower(t.gol_darah)',strtolower($this->gol_darah),true);
            $criteria->compare('lower(t.no_kantongdarah)',strtolower($this->no_kantongdarah),true);
            $criteria->compare('lower(t.statuspelulusan)',strtolower($this->statuspelulusan),true);
            $criteria->compare('lower(t.nomorbarcode_utama)',strtolower($this->nomorbarcode_utama),true);


            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));

        }
}