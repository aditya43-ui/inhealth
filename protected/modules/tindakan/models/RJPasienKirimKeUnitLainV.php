<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class RJPasienKirimKeUnitLainV extends PasienkirimkeunitlainV
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KelompokmenuK the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
        /**
         * menampilkan dialog kunjungan
         */
        public function searchDialogKunjungan()
        {
			// Warning: Please modify the following code to remove attributes that
			// should not be searched.
			$criteria=new CDbCriteria;
			$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
			$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
			$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
			$criteria->compare('LOWER(instalasiasal_nama)',strtolower($this->instalasiasal_nama),true);
			$criteria->compare('LOWER(ruanganasal_nama)',strtolower($this->ruanganasal_nama),true);
			if(!empty($this->carabayar_id)){
				$criteria->addCondition("carabayar_id = ".$this->carabayar_id);					
			}
			if(!empty($this->penjamin_id)){
				$criteria->addCondition("penjamin_id = ".$this->penjamin_id);					
			}
			$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
			if(!empty($this->ruangan_id)){
				$criteria->addCondition("ruangan_id = ".$this->ruangan_id);					
			}
			$criteria->compare('LOWER(nama_pegawai)',($this->nama_pegawai));
			$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
			$criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
			$criteria->order = 'tgl_pendaftaran DESC';
			$criteria->limit = 10;
			return new CActiveDataProvider($this, array(
					'criteria'=>$criteria,
					'pagination'=>false,
			));
        }
}
?>
