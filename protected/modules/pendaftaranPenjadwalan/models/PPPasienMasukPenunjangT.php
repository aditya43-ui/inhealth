<?php
/**
 * This is the model class for table "pasienmasukpenunjang_t".
 *
 * The followings are the available columns in table 'pasienmasukpenunjang_t':
 * @property integer $pasienmasukpenunjang_id
 * @property integer $pasien_id
 * @property integer $jeniskasuspenyakit_id
 * @property integer $pendaftaran_id
 * @property integer $pegawai_id
 * @property integer $kelaspelayanan_id
 * @property integer $ruangan_id
 * @property integer $pasienadmisi_id
 * @property string $no_masukpenunjang
 * @property string $tglmasukpenunjang
 * @property string $no_urutperiksa
 * @property string $kunjungan
 * @property string $statusperiksa
 * @property string $ruanganasal_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class PPPasienMasukPenunjangT extends PasienmasukpenunjangT{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PasienmasukpenunjangT the static model class
     */
    public $is_pilihpenunjang = 0;
    public $is_adakarcis = 0;
    public $tgl_awal,$tgl_akhir;
    public $asalrujukan_id, $rujukandari_id;
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'asalrujukan_id' => 'Asal Rujukan',
            'rujukandari_id' => 'Rujukan Dari',
        ));
    }
    
    public function searchPasienPenunjang()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;

			if(!empty($this->pasienmasukpenunjang_id)){
				$criteria->addCondition("pasienmasukpenunjang_id = ".$this->pasienmasukpenunjang_id); 			
			}
			if(!empty($this->pasien_id)){
				$criteria->addCondition("pasien_id = ".$this->pasien_id); 			
			}
			if(!empty($this->jeniskasuspenyakit_id)){
				$criteria->addCondition("jeniskasuspenyakit_id = ".$this->jeniskasuspenyakit_id); 			
			}
			if(!empty($this->pendaftaran_id)){
				$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id); 			
			}
			if(!empty($this->pegawai_id)){
				$criteria->addCondition("t.pegawai_id = ".$this->pegawai_id); 			
			}
			if(!empty($this->kelaspelayanan_id)){
				$criteria->addCondition("kelaspelayanan_id = ".$this->kelaspelayanan_id); 			
			}
			if(!empty($this->ruangan_id)){
				$criteria->addCondition("t.ruangan_id = ".$this->ruangan_id); 			
			}
			if(!empty($this->pasienadmisi_id)){
				$criteria->addCondition("pasienadmisi_id = ".$this->pasienadmisi_id); 			
			}
			if(!empty($this->ruanganasal_id)){
				$criteria->addCondition("ruanganasal_id = ".$this->ruanganasal_id); 			
			}
            $criteria->compare('LOWER(no_masukpenunjang)',strtolower($this->no_masukpenunjang),true);
//            $criteria->compare('LOWER(tglmasukpenunjang)',strtolower($this->tglmasukpenunjang),true);
            $criteria->compare('LOWER(no_urutperiksa)',strtolower($this->no_urutperiksa),true);
            $criteria->compare('LOWER(kunjungan)',strtolower($this->kunjungan),true);
            $criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
            // $criteria->compare('LOWER(ruanganasal_id)',strtolower($this->ruanganasal_id),true);
            $criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
            $criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
            $criteria->compare('pendaftaran.create_loginpemakai_id',$this->create_loginpemakai_id);
            $criteria->compare('pendaftaran.update_loginpemakai_id',$this->update_loginpemakai_id);
            $criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
            $criteria->compare('LOWER(pasien.nama_pasien)',strtolower($this->nama_pasien),true);
            $criteria->compare('LOWER(pasien.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
            $criteria->compare('pendaftaran.carabayar_id', $this->carabayar_id);
            $criteria->compare('pendaftaran.penjamin_id', $this->penjamin_id);
            $criteria->compare('pendaftaran.statusperiksa', $this->statusperiksa_pendaftaran);
            $criteria->addBetweenCondition('DATE(tglmasukpenunjang)', $this->tgl_awal, $this->tgl_akhir);
            
            $criteria->compare('rujukan.asalrujukan_id', $this->asalrujukan_id);
            $criteria->compare('rujukan.rujukandari_id', $this->rujukandari_id);
            
            $criteria->order = 'tgl_pendaftaran DESC';
            $criteria->with=array('pasien', 'pendaftaran', 'pendaftaran.rujukan');

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }
}
?>
