<?php

class RJDaftarpasienrjV extends DaftarpasienrjV
{
    public $tgl_awal;
    public $tgl_akhir;
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PasienM the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;

            $criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
			if(!empty($this->pendaftaran_id)){
				$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);		
			}
            $criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
            $criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
			if(!empty($this->pegawai_id)){
				$criteria->addCondition("pegawai_id = ".$this->pegawai_id);		
			}
            $criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
            $criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
            $criteria->compare('no_urutantri',$this->no_urutantri);
            $criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
			if(!empty($this->penjamin_id)){
				$criteria->addCondition("penjamin_id = ".$this->penjamin_id);		
			}
            $criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
			if(!empty($this->jeniskasuspenyakit_id)){
				$criteria->addCondition("jeniskasuspenyakit_id = ".$this->jeniskasuspenyakit_id);		
			}
            $criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
			if(!empty($this->pasien_id)){
				$criteria->addCondition("pasien_id = ".$this->pasien_id);		
			}
            $criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
            $criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
            $criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
            $criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
            $criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
            $criteria->compare('rt',$this->rt);
            $criteria->compare('rw',$this->rw);
            $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
            $criteria->order = 'tgl_pendaftaran,no_urutantri';

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }
}
?>
