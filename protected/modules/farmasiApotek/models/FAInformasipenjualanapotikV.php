<?php

class FAInformasipenjualanapotikV extends InformasipenjualanapotikV
{
        public $tgl_awal;
        public $tgl_akhir;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
        public function searchInfoJualResep()
        {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

                $criteria->select = array('jenispenjualan','no_rekam_medik','namadepan','nama_pasien','nama_bin','tanggal_lahir',
                                          'noresep','totharganetto','totalhargajual','instalasiasal_nama','ruanganasal_nama','reseptur_id',
                                          'no_pendaftaran','tglpenjualan');
                $criteria->group = 'jenispenjualan, no_rekam_medik, namadepan, nama_pasien, nama_bin, tanggal_lahir, noresep, totharganetto,
                                    totalhargajual, instalasiasal_nama, ruanganasal_nama, reseptur_id, no_pendaftaran, tglpenjualan';
                $criteria->order = 'reseptur_id';
                $criteria->addBetweenCondition('DATE(tglpenjualan)',  $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(jenispenjualan)',strtolower($this->jenispenjualan),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(noresep)',strtolower($this->noresep),true);
		$criteria->compare('totharganetto',$this->totharganetto);
		$criteria->compare('totalhargajual',$this->totalhargajual);
		$criteria->compare('LOWER(instalasiasal_nama)',strtolower($this->instalasiasal_nama),true);
		$criteria->compare('LOWER(ruanganasal_nama)',strtolower($this->ruanganasal_nama),true);
		if(!empty($this->reseptur_id)){
			$criteria->addCondition("reseptur_id = ".$this->reseptur_id);						
		}
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition("pasienadmisi_id = ".$this->pasienadmisi_id);						
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);						
		}
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
        }
        
        public function getNoRekamMedisNoPendaftaran()
        {
            return $this->no_rekam_medik.' '.$this->no_pendaftaran;
        }
        
        public function getNamapasien()
        {
            return $this->namadepan.' '.$this->nama_pasien;
        }
        
        public function getInstalasiRuanganAsal()
        {
            return $this->instalasiasal_nama.' '.$this->ruanganasal_nama;
        }

                
        protected function afterFind(){
            foreach($this->metadata->tableSchema->columns as $columnName => $column){

                if (!strlen($this->$columnName)) continue;

                if ($column->dbType == 'date'){                         
                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
                } elseif ($column->dbType == 'timestamp without time zone'){
                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss','medium',null));
                } elseif ($column->dbType == 'double precision') {
//                    $format = new CNumberFormatter('id');
//                    $this->$columnName = $format->format('#,##0', $this->$columnName);
                }
            }
            return true;
        }
}