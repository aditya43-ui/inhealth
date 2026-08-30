<?php

/**
 * This is the model class for table "pengajuanapprovalsep_t".
 *
 * The followings are the available columns in table 'pengajuanapprovalsep_t':
 * @property integer $pengajuanapprovalsep_id
 * @property integer $pendaftaran_id
 * @property string $no_kartu_bpjs
 * @property string $namapeserta_bpjs
 * @property string $jenispeserta_bpjs_kode
 * @property string $jenispeserta_bpjs_nama
 * @property string $tgl_sep
 * @property string $kode_ppk_pelayanan
 * @property string $nama_ppk_pelayanan
 * @property string $jenis_pelayanan
 * @property string $kelas_tanggungan
 * @property string $asal_rujukan
 * @property string $no_rujukan
 * @property string $kode_ppk_rujukan
 * @property string $nama_ppk_rujukan
 * @property string $tgl_rujukan
 * @property integer $jenisrujukan
 * @property string $diagnosa_awal
 * @property string $diagnosa_awal_nama
 * @property string $politujuan
 * @property string $politujuan_nama
 * @property boolean $poli_eksekutif
 * @property boolean $cob
 * @property boolean $lakalantas
 * @property string $penjamin
 * @property string $lokasilakalantas
 * @property string $no_telepon_pasien
 * @property string $userpembuat_bpjs
 * @property string $catatan
 * @property string $create_time
 * @property integer $create_loginpemakai_id
 * @property boolean $is_approval
 * @property integer $sep_id
 * @property string $user_approval_bpjs
 *
 * The followings are the available model relations:
 * @property PendaftaranT $pendaftaran
 * @property SepT $sep
 */
class ARPengajuanapprovalsepT extends PengajuanapprovalsepT
{
        public $tgl_awal,$tgl_akhir,$no_pendaftaran,$carabayar_id,$penjamin_id,$no_sep,$hakkelas_kode, $tanggal_pengajuan;
                
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengajuanapprovalsepT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->join = 'LEFT JOIN pendaftaran_t p on p.pendaftaran_id = t.pendaftaran_id';
                $criteria->addCondition("DATE(t.tgl_sep) BETWEEN '".$this->tgl_awal."' AND '".$this->tgl_akhir."' OR DATE(t.create_time) BETWEEN '".$this->tgl_awal."' AND '".$this->tgl_akhir."'");
		if(!empty($this->pengajuanapprovalsep_id)){
			$criteria->addCondition('t.pengajuanapprovalsep_id = '.$this->pengajuanapprovalsep_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('t,pendaftaran_id = '.$this->pendaftaran_id);
		}

		if(!empty($this->no_pendaftaran)){
			$criteria->addCondition('p.no_pendaftaran ILIKE \'%'.$this->no_pendaftaran . '%\'');
		}

		$criteria->compare('LOWER(t.no_kartu_bpjs)',strtolower($this->no_kartu_bpjs),true);
		$criteria->compare('LOWER(t.namapeserta_bpjs)',strtolower($this->namapeserta_bpjs),true);
		$criteria->compare('LOWER(t.jenispeserta_bpjs_kode)',strtolower($this->jenispeserta_bpjs_kode),true);
		$criteria->compare('LOWER(t.jenispeserta_bpjs_nama)',strtolower($this->jenispeserta_bpjs_nama),true);
		$criteria->compare('LOWER(t.tanggal_pengajuan)',strtolower($this->tanggal_pengajuan),true);
		$criteria->compare('LOWER(t.tgl_sep)',strtolower($this->tgl_sep),true);
		$criteria->compare('LOWER(t.kode_ppk_pelayanan)',strtolower($this->kode_ppk_pelayanan),true);
		$criteria->compare('LOWER(t.nama_ppk_pelayanan)',strtolower($this->nama_ppk_pelayanan),true);
		$criteria->compare('LOWER(t.jenis_pelayanan)',strtolower($this->jenis_pelayanan),true);
		$criteria->compare('LOWER(t.jnspengajuan_approvalsep)',$this->jnspengajuan_approvalsep,true);
		$criteria->compare('LOWER(t.kelas_tanggungan)',strtolower($this->kelas_tanggungan),true);
		$criteria->compare('LOWER(t.asal_rujukan)',strtolower($this->asal_rujukan),true);
		$criteria->compare('LOWER(t.no_rujukan)',strtolower($this->no_rujukan),true);
		$criteria->compare('LOWER(t.kode_ppk_rujukan)',strtolower($this->kode_ppk_rujukan),true);
		$criteria->compare('LOWER(t.nama_ppk_rujukan)',strtolower($this->nama_ppk_rujukan),true);
		$criteria->compare('LOWER(t.tgl_rujukan)',strtolower($this->tgl_rujukan),true);
		if(!empty($this->jenisrujukan)){
			$criteria->addCondition('t.jenisrujukan = '.$this->jenisrujukan);
		}
		$criteria->compare('LOWER(t.diagnosa_awal)',strtolower($this->diagnosa_awal),true);
		$criteria->compare('LOWER(t.diagnosa_awal_nama)',strtolower($this->diagnosa_awal_nama),true);
		$criteria->compare('LOWER(t.politujuan)',strtolower($this->politujuan),true);
		$criteria->compare('LOWER(t.politujuan_nama)',strtolower($this->politujuan_nama),true);
		$criteria->compare('t.poli_eksekutif',$this->poli_eksekutif);
		$criteria->compare('t.cob',$this->cob);
		$criteria->compare('t.lakalantas',$this->lakalantas);
		$criteria->compare('LOWER(t.penjamin)',strtolower($this->penjamin),true);
		$criteria->compare('LOWER(t.lokasilakalantas)',strtolower($this->lokasilakalantas),true);
		$criteria->compare('LOWER(t.no_telepon_pasien)',strtolower($this->no_telepon_pasien),true);
		$criteria->compare('LOWER(t.userpembuat_bpjs)',strtolower($this->userpembuat_bpjs),true);
		$criteria->compare('LOWER(t.catatan)',strtolower($this->catatan),true);
		$criteria->compare('LOWER(t.create_time)',strtolower($this->create_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('t.create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		$criteria->compare('t.is_approval',$this->is_approval);
		if(!empty($this->sep_id)){
			$criteria->addCondition('t.sep_id = '.$this->sep_id);
		}
		$criteria->compare('LOWER(t.user_approval_bpjs)',strtolower($this->user_approval_bpjs),true);

		return $criteria;
	}
        
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function search()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }


        public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
        
        /**
	 * Mengambil daftar semua kelaspelayanan
	 * @return CActiveDataProvider 
	 */
	public function getKelasTanggunganItems()
	{
		return KelaspelayananM::model()->findAllByAttributes(array('kelaspelayanan_aktif'=>true),array('order'=>'urutankelas'));
	}
	
	/**
	* Mengambil daftar semua carabayar
	* @return CActiveDataProvider 
	*/
	public function getCaraBayarItems()
	{
		return CarabayarM::model()->findAllByAttributes(array('carabayar_aktif'=>true),array('order'=>'carabayar_nourut'));
	}
	/**
	* Mengambil daftar semua penjamin
	* @return CActiveDataProvider 
	*/
	public function getPenjaminItems($carabayar_id=null)
	{
		if(!empty($carabayar_id))
			return PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$carabayar_id,'penjamin_aktif'=>true),array('order'=>'penjamin_nama'));
		else
			return array();
	}
}