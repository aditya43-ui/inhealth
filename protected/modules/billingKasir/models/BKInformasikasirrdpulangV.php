<?php

/**
 * This is the model class for table "infokunjunganrd_v".
 *
 * The followings are the available columns in table 'infokunjunganrd_v':
 * @property integer $pendaftaran_id
 * @property string $tgl_pendaftaran
 * @property string $no_pendaftaran
 * @property string $statusperiksa
 * @property string $statusmasuk
 * @property string $no_rekam_medik
 * @property string $nama_pasien
 * @property string $alamat_pasien
 * @property integer $propinsi_id
 * @property string $propinsi_nama
 * @property integer $kabupaten_id
 * @property string $kabupaten_nama
 * @property integer $kecamatan_id
 * @property string $kecamatan_nama
 * @property integer $kelurahan_id
 * @property string $kelurahan_nama
 * @property integer $instalasi_id
 * @property string $ruangan_nama
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property integer $rujukan_id
 */
class BKInformasikasirrdpulangV extends InformasikasirrdpulangV
{
        public $statusBayar;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfokunjunganrdV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchRD()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
                
                $tb = "case when n.total_belum is null then 0 else n.total_belum end";
                $tt = "case when n.total_tindakan is null then 0 else n.total_tindakan end";
                $ob = "case when o.total_oa_belum is null then 0 else o.total_oa_belum end";
                $ot = "case when o.total_oa is null then 0 else o.total_oa end";
                
                $criteria->select = "t.*, "
                        . "${tb} as total_belum,
                            ${tt} as total_tindakan,
                            ${ob} as total_oa_belum,
                            ${ot} as total_oa";
                
                $criteria->join = "left join 
                (select 
                p.pendaftaran_id, 
                sum(case when p.tindakansudahbayar_id is null then 1 else 0 end) as total_belum,
                count(p.tindakanpelayanan_id) as total_tindakan

                from tindakanpelayanan_t p
                group by p.pendaftaran_id
                ) n on n.pendaftaran_id = t.pendaftaran_id

                left join 
                (select 
                p.pendaftaran_id, 
                sum(case when p.oasudahbayar_id is null then 1 else 0 end) as total_oa_belum,
                count(p.obatalkespasien_id) as total_oa

                from obatalkespasien_t p
                group by p.pendaftaran_id
                ) o on o.pendaftaran_id = t.pendaftaran_id
                
                left join pendaftaran_t pp on pp.pendaftaran_id = t.pendaftaran_id
                ";
                
                
                
		$criteria->addBetweenCondition('date(t.tgl_pendaftaran)',$this->tgl_awal,$this->tgl_akhir,true);
//                $criteria->addCondition('t.pembayaranpelayanan_id IS NULL');
		// $criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
                if(!empty($this->statusperiksa)){
                    $criteria->compare('LOWER(t.statusperiksa)',strtolower($this->statusperiksa),true);
                }else{
                    $criteria->addCondition("t.statusperiksa = '".Params::STATUSPERIKSA_SUDAH_DIPERIKSA."'");
                }
		$criteria->compare('LOWER(t.statusmasuk)',strtolower($this->statusmasuk),true);
		$criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(t.nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(t.alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('LOWER(t.no_identitas_pasien)',strtolower($this->no_identitas_pasien),true);

		if(!empty($this->propinsi_id)){
			$criteria->addCondition('t.propinsi_id = '.$this->propinsi_id);
		}
		$criteria->compare('LOWER(t.propinsi_nama)',strtolower($this->propinsi_nama),true);
		if(!empty($this->kabupaten_id)){
			$criteria->addCondition('t.kabupaten_id = '.$this->kabupaten_id);
		}
		$criteria->compare('LOWER(t.kabupaten_nama)',strtolower($this->kabupaten_nama),true);
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition('t.kecamatan_id = '.$this->kecamatan_id);
		}
		$criteria->compare('LOWER(t.kecamatan_nama)',strtolower($this->kecamatan_nama),true);
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition('t.kelurahan_id = '.$this->kelurahan_id);
		}
		$criteria->compare('LOWER(t.kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('t.instalasi_id = '.$this->instalasi_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('t.ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(t.ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition('t.carabayar_id = '.$this->carabayar_id);
		}
		$criteria->compare('LOWER(t.carabayar_nama)',strtolower($this->carabayar_nama),true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition('t.penjamin_id = '.$this->penjamin_id);
		}
		$criteria->compare('LOWER(t.penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('LOWER(t.nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(t.jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
   		$criteria->order = 't.tgl_pendaftaran DESC';
                
                
                $criteria->addCondition("t.statusperiksa <> 'BATAL PERIKSA' ");
                if ($this->statusBayar == "BELUM LUNAS") {
                    $criteria->addCondition("(${tb}) > 0 or (${ob}) > 0 or (${tt}) = 0");
                } else if ($this->statusBayar == "LUNAS") {
                    $criteria->addCondition("(${tb}) = 0 and (${ob}) = 0 and (${tt}) > 0");
                }
                
                $criteria->addCondition('pp.pasienadmisi_id is null');
                $criteria->addCOndition('t.alihstatus = false');
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria
		));
	}
        
        public function getTanggalDaftarPulang() {
            $format = new MyFormatter();
            $this->tgl_pendaftaran = $format->formatDateTimeForUser($this->tgl_pendaftaran);
            $this->tglpasienpulang = $format->formatDateTimeForUser($this->tglpasienpulang);
            return $this->tgl_pendaftaran." / <br/> ".$this->tglpasienpulang;
        }

	public function getRuanganItems($instalasi_id=null)
        {
            if($instalasi_id==null){
            return RuanganM::model()->findAllByAttributes(array(),array('order'=>'ruangan_nama'));
            }else{
            return RuanganM::model()->findAllByAttributes(array('instalasi_id'=>$instalasi_id),array('order'=>'ruangan_nama'));   
            }
        }
}