<?php
class KPPesangonpegT extends PesangonpegT
{
    public $no_temp, $pemotong, $pph21, $ptkp, $kode_objekpajakpes;
    
    public static function model($className = __CLASS__) {
            return parent::model($className);
        }
        
        public function search()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.
            if(!empty($this->periodegaji)){
                $this->periodegaji = MyFormatter::formatMonthForDB($this->periodegaji);
            }

            $criteria=$this->criteriaSearch();
			$criteria->with = 'pegawai';
			if(!empty($this->nomorindukpegawai)){
				$criteria->compare("LOWER(pegawai.nomorindukpegawai)",strtolower($this->nomorindukpegawai),true);
			}
			if(!empty($this->nama_pegawai)){
				$criteria->compare("LOWER(pegawai.nama_pegawai)",strtolower($this->nama_pegawai),true);
			}
            
			if(!empty($this->kelompokpegawai_id)){
				$criteria->compare("pegawai.kelompokpegawai_id",$this->kelompokpegawai_id);
			}
            
			if(!empty($this->jabatan_id)){
				$criteria->compare("pegawai.jabatan_id",$this->jabatan_id);
			}
			
//			$criteria->compare('LOWER(pegawai.kategoripegawaiasal)', strtolower($this->kategoripegawaiasal));
            
            $criteria->addCondition("(case when periodegaji is null then tglpesangon else periodegaji end)::date between '". 
                $this->periodegaji."-01' and '".date('Y-m-t', strtotime($this->periodegaji.'-01'))."'");
            

            if ($this->status == 1) {
                $criteria->addCondition('pengeluaranumum_id is null');
            } else if ($this->status == 2) {
                $criteria->addCondition('pengeluaranumum_id is not null');
            }
            
            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'sort'=>array(
                    'defaultOrder'=>'tglpesangon',
                ),
            ));
        }
}
