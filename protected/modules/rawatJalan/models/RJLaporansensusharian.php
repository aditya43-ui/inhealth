<?php
/**
 * model ini digunakan untuk mengakses view laporansensuharianrj_v, pada modul rawat jalan
 * 
 * @package application.modules.rawatJalan
 * @subpackage models
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0 
 * @link    <http://piindonesia.co.id>
 */
class RJLaporansensusharian extends LaporansensuharianrjV {

    public $data;
    public $jumlah;
    public $tick;
    public $tgl_awal;
    public $tgl_akhir;
    public $jns_periode;
    public $bln_awal;
    public $bln_akhir;
    public $thn_awal;
    public $thn_akhir;
    
    /**
     * 
     * @param type $className
     * @return type
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * pencarian pada laporan sensus harian
     * @return \CActiveDataProvider
     */
    public function searchTable() {        

        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }


    /** fungsi untuk generate filter / criteria pada model untuk grafik
    * $model adalah model yang akan digunakan untuk grafik
    * $type adalah filter akan digunakan sebagai x-axis('data') atau group('tick'), default type sebagai x-axis('data')
    * $addCols variable untuk column tmbahan, typenya mix, diantaranya untuk order dll,
    */
    public static function criteriaGrafik($model, $type='data', $addCols = array()){
        $criteria = new CDbCriteria;
        $criteria->select = 'count(pendaftaran_id) as jumlah';
        $filter = isset($_GET['filter'])?$_GET['filter']:null;
        if ( $filter == 'carabayar') {
            if (!empty($model->penjamin_id)) {
                $criteria->select .= ', penjamin_nama as '.$type;
                $criteria->group .= 'penjamin_nama';
            } else if (!empty($model->carabayar_id)) {
                $criteria->select .= ', penjamin_nama as '.$type;
                $criteria->group = 'penjamin_nama';
            } else {
                $criteria->select .= ', carabayar_nama as '.$type;
                $criteria->group = 'carabayar_nama';
            }
        } else if ( $filter == 'wilayah') {
            if (!empty($model->kelurahan_id)) {
                $criteria->select .= ', kelurahan_nama as '.$type;
                $criteria->group .= 'kelurahan_nama';
            } else if (!empty($model->kecamatan_id)) {
                $criteria->select .= ', kelurahan_nama as '.$type;
                $criteria->group .= 'kelurahan_nama';
            } else if (!empty($model->kabupaten_id)) {
                $criteria->select .= ', kecamatan_nama as '.$type;
                $criteria->group .= 'kecamatan_nama';
            } else if (!empty($model->propinsi_id)) {
                $criteria->select .= ', kabupaten_nama as '.$type;
                $criteria->group .= 'kabupaten_nama';
            } else {
                $criteria->select .= ', propinsi_nama as '.$type;
                $criteria->group .= 'propinsi_nama';
            }
        }

        if (!isset($_GET['filter'])){
            $criteria->select .= ', propinsi_nama as '.$type;
            $criteria->group .= 'propinsi_nama';
        }

        if (is_array($addCols) && count((array)$addCols) > 0){
            foreach ($addCols as $i => $v){
                $criteria->group .= ','.$v;
                $criteria->select .= ','.$v.' as '.$i;
            }       
        }

        return $criteria;
    }
        
    /**
     * laod data grafik, sesuai pencariannya
     * @return \CActiveDataProvider
     */
    public function searchGrafik() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria = $this->criteriaGrafik($this, 'tick');
        if (!empty($criteria->group) &&(!empty($this->pilihanx))){
            $criteria->group .=',';
        }
        if ($this->pilihanx == 'pengunjung') {
            $criteria->select .= ', statuspasien as data';
            $criteria->group .= ' statuspasien';
        } else if ($this->pilihanx == 'kunjungan') {
            $criteria->select .= ', kunjungan as data';
            $criteria->group .= ' kunjungan';
        }
        else if ($this->pilihanx == 'rujukan'){
            $criteria->select .= ', statusmasuk as data';
            $criteria->group .= ' statusmasuk';
        }
        
        if (empty($this->pilihanx)){
            $criteria = $this->criteriaGrafik($this, 'data');
        }

        $criteria->addBetweenCondition('date(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
        if(!empty($this->propinsi_id)){
                    if (is_array($this->propinsi_id)){
			$criteria->addInCondition("propinsi_id", $this->propinsi_id);		
                    }
		}
        
		if(!empty($this->kabupaten_id)){
                    if (is_array($this->kabupaten_id)){
			$criteria->addInCondition("kabupaten_id", $this->kabupaten_id);		
                    }
		}
        $criteria->compare('LOWER(kabupaten_nama)', strtolower($this->kabupaten_nama), true);
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id);		
		}
        $criteria->compare('LOWER(kelurahan_nama)', strtolower($this->kelurahan_nama), true);
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id);		
		}
        $criteria->compare('LOWER(kecamatan_nama)', strtolower($this->kecamatan_nama), true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);		
		}
		if(!empty($this->carabayar_id)){
			$criteria->addInCondition("carabayar_id", $this->carabayar_id);		
		}
        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
		if(!empty($this->penjamin_id)){
			$criteria->addInCondition("penjamin_id", $this->penjamin_id);		
		}
        $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
        
        $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
//        $criteria->order = 'tgl_pendaftaran DESC';

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    
    /**
     * load data agar ditmapilkan dalam bentuk prinout
     * @return \CActiveDataProvider
     */
    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        
        
        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => false,
                ));
    }

    /**
     * load pencarian utama
     * @return \CDbCriteria
     */
    protected function functionCriteria() {
        $criteria = new CDbCriteria();
        
        $criteria->select = 'namadepan, nama_pasien, nama_bin, no_rekam_medik, umur, jeniskelamin, alamat_pasien, kunjungan, statuspasien, diagnosa_nama, carabayar_nama, carabayar_id, penjamin_nama, penjamin_id, pendaftaran_id, ruangan_id, diagnosa_id, diagnosa_nama';
        $criteria->group = 'namadepan, nama_pasien, nama_bin, no_rekam_medik, umur, jeniskelamin, alamat_pasien, kunjungan, statuspasien, diagnosa_nama, carabayar_nama, carabayar_id, penjamin_nama, penjamin_id, pendaftaran_id, ruangan_id, diagnosa_id, diagnosa_nama';
        
        $criteria->addBetweenCondition('date(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
        if(!empty($this->propinsi_id)){
            if (is_array($this->propinsi_id)){
                $criteria->addInCondition("propinsi_id",$this->propinsi_id);		
            }else{
                $criteria->addCondition("propinsi_id = ".$this->propinsi_id);		
            }
        }
        
        if(!empty($this->kabupaten_id)){
            if (is_array($this->kabupaten_id)){
                $criteria->addInCondition("kabupaten_id",$this->kabupaten_id);		
            }else{
                $criteria->addCondition("kabupaten_id = ".$this->kabupaten_id);		
            }
        }
        
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id);		
		}
        $criteria->compare('LOWER(kelurahan_nama)', strtolower($this->kelurahan_nama), true);
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id);		
		}
        $criteria->compare('LOWER(kecamatan_nama)', strtolower($this->kecamatan_nama), true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);		
		}
        if(!empty($this->carabayar_id)){
            if (is_array($this->carabayar_id)){
                $criteria->addInCondition("carabayar_id",$this->carabayar_id);		
            }else{
                $criteria->addCondition("carabayar_id = ".$this->carabayar_id);		
            }
        }
        
        if(!empty($this->penjamin_id)){
            if (is_array($this->penjamin_id)){
                $criteria->addInCondition("penjamin_id",$this->penjamin_id);		
            }else{
                $criteria->addCondition("penjamin_id = ".$this->penjamin_id);		
            }
        }
        $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
        
        $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
        
        return $criteria;
    }

    /**
     * load nama model
     * @return system
     */
    public function getNamaModel() {
        return __CLASS__;
    }

    /**
     * load status pasien
     * @return string
     */
    public static function statusPasien() {
        $status = array('baru' => 'PENGUNJUNG BARU',
            'lama' => 'PENGUNJUNG LAMA');
        return $status;
    }

    /**
     * load data kunjungan
     * @return string
     */
    public static function statusKunjungan() {
        $status = array('baru' => 'KUNJUNGAN BARU',
            'lama' => 'KUNJUNGAN LAMA');
        return $status;
    }

    /**
     * load data status
     * @return string
     */
    public static function berdasarkanStatus() {
        $status = array('pengunjung' => 'Berdasarkan Pengunjung',
            'kunjungan' => 'Berdasarkan Kunjungan');
        return $status;
    }

}