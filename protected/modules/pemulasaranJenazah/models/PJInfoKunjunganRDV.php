<?php

class PJInfoKunjunganRDV extends InfokunjunganrdV
{
         public $ceklis = false;
         public $tgl_awal,$tgl_akhir;
         public $pasienmasukpenunjang_id;
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
                $criteria->group = 't.pendaftaran_id,t.tgl_pendaftaran,t.no_pendaftaran,t.no_rekam_medik,t.nama_pasien,t.nama_bin,t.carabayar_nama,t.penjamin_nama,t.nama_pegawai,'
                        . '         t.transportasi,t.caramasuk_nama,t.asalrujukan_nama,t.jeniskasuspenyakit_nama,t.alamat_pasien,t.statusperiksa';
                $criteria->select = $criteria->group;
		$criteria->compare('LOWER(t.tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(t.statusperiksa)',strtolower($this->statusperiksa),true);
		$criteria->compare('LOWER(t.statusmasuk)',strtolower($this->statusmasuk),true);
		$criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(t.nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(t.alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('t.propinsi_id',$this->propinsi_id);
		$criteria->compare('LOWER(t.propinsi_nama)',strtolower($this->propinsi_nama),true);
		$criteria->compare('t.kabupaten_id',$this->kabupaten_id);
		$criteria->compare('LOWER(t.kabupaten_nama)',strtolower($this->kabupaten_nama),true);
		$criteria->compare('t.kecamatan_id',$this->kecamatan_id);
                
                if($this->ceklis) {
                    $criteria->addBetweenCondition('DATE(t.tgl_pendaftaran)',$this->tgl_awal,$this->tgl_akhir);
                }
                
		$criteria->compare('LOWER(t.kecamatan_nama)',strtolower($this->kecamatan_nama),true);
		$criteria->compare('t.kelurahan_id',$this->kelurahan_id);
		$criteria->compare('t.LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		$criteria->compare('t.instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(t.ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('t.carabayar_id',$this->carabayar_id);
		$criteria->compare('LOWER(t.carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('t.penjamin_id',$this->penjamin_id);
		$criteria->compare('LOWER(t.penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('LOWER(t.nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(t.jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		$criteria->compare('t.rujukan_id',$this->rujukan_id);                
		$criteria->addCondition('t.pasienpulang_id is null');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        protected function afterFind(){
            foreach($this->metadata->tableSchema->columns as $columnName => $column){

                if (!strlen($this->$columnName)) continue;

                if ($column->dbType == 'date') {                         
                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
                        } elseif ($column->dbType == 'timestamp without time zone') {
                                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss','medium',null));
                        }
            }
            return true;
        }
        
        
        function getNamaPasienNamaBin()
        {
            return $this->nama_pasien.' bin '.$this->nama_bin;
        }
        
        
        public function getInsatalasiRuangan()
        {
               
            return $this->instalasi_nama.' / '.$this->ruangan_nama;
        }

	
}