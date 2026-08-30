<?php
/**
 * This is the model class for table "bookingkamar_t".
 *
 * The followings are the available columns in table 'bookingkamar_t':
 * @property integer $bookingkamar_id
 * @property integer $kelaspelayanan_id
 * @property integer $pendaftaran_id
 * @property integer $kamarruangan_id
 * @property integer $pasien_id
 * @property integer $ruangan_id
 * @property integer $pasienadmisi_id
 * @property string $bookingkamar_no
 * @property string $tglbookingkamar
 * @property string $statusbooking
 * @property string $keteranganbooking
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class PPBookingKamarT extends BookingkamarT{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return BookingkamarT the static model class
     */
    public $no_pendaftaran;
    public $pendaftaran_id;
    public $isNoPendaftaran;
    public $ruanganJalanGd;
    public $ruanganInap;
    public $noRekamMedik;
    public $tgl_awal,$tgl_akhir;
    public $prefix_pendaftaran;
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
   public function searchBooking()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
		$criteria->with=array('kelaspelayanan','kamarruangan','pasien','ruangan','pasienadmisi');
                $criteria->join = "LEFT JOIN pendaftaran_t pendaftaran ON pendaftaran.pendaftaran_id = t.pendaftaran_id";
		$criteria->addBetweenCondition('DATE(tgltransaksibooking)', $this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->bookingkamar_id)){
			$criteria->addCondition("t.bookingkamar_id = ".$this->bookingkamar_id); 			
		}
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition("t.kelaspelayanan_id = ".$this->kelaspelayanan_id); 			
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("t.pendaftaran_id = ".$this->pendaftaran_id); 			
		}
		if(!empty($this->kamarruangan_id)){
			$criteria->addCondition("t.kamarruangan_id = ".$this->kamarruangan_id); 			
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition("t.pasien_id = ".$this->pasien_id); 			
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition("t.ruangan_id = ".$this->ruangan_id); 			
		}
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition("t.pasienadmisi_id = ".$this->pasienadmisi_id); 			
		}
		$criteria->compare('LOWER(t.bookingkamar_no)',strtolower($this->bookingkamar_no));
		$criteria->compare('LOWER(t.statusbooking)',strtolower($this->statusbooking));
		$criteria->compare('LOWER(t.keteranganbooking)',strtolower($this->keteranganbooking));
		$criteria->compare('LOWER(t.create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(t.update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition("t.create_loginpemakai_id = ".$this->create_loginpemakai_id); 			
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition("t.update_loginpemakai_id = ".$this->update_loginpemakai_id); 			
		}
		$criteria->compare('LOWER(t.create_ruangan)',strtolower($this->create_ruangan),true);                
		$criteria->compare('LOWER(pendaftaran.no_pendaftaran)',strtolower($this->prefix_pendaftaran.$this->no_pendaftaran),true);
		$criteria->compare('LOWER(t.statuskonfirmasi)',strtolower($this->statuskonfirmasi),true);
		$criteria->compare('LOWER(pasien.no_rekam_medik)', strtolower($this->noRekamMedik));
                $criteria->order = "tgltransaksibooking DESC";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /**
        * untuk nilai grafik kotak Booking kamar
        * @return CActiveDataProvider : jumlah
        */
        public function searchKotakBooking(){
            $criteria = new CDbCriteria;
            $criteria->addBetweenCondition('DATE(create_time)', $this->tgl_awal, $this->tgl_akhir);
            $criteria->select = 'count(pendaftaran_id) as data';
            return new CActiveDataProvider($this, array(
                        'criteria' => $criteria,
                    ));
        }
    
         public function getNamaAlias()
        {
             if(!empty($this->pasien->nama_bin)){
                return $this->pasien->nama_pasien.' Alias '.$this->pasien->nama_bin; 
             }else{
                 return $this->pasien->nama_pasien;
             }
                
        }
        
         public function getStatus($status,$id,$idbooking,$idkamar){
            if($status == "BELUM KONFIRMASI"){
                $status = '<button id="red" class="btn btn-primary" name="yt1" onclick="setStatus(this,\''.$status.'\','.$id.','.$idbooking.','.$idkamar.')">'.$status.'</button>';

            }else if($status == "SUDAH KONFIRMASI"){
                $status = '<button id="green" class="btn btn-danger" name="yt1" onclick="setStatus(this,\''.$status.'\','.$id.','.$idbooking.','.$idkamar.')">'.$status.'</button>';
            }else if($status == "BATAL BOOKING"){
                $status = '<button id="blue" class="btn btn-danger-yellow" name="yt1">'.$status.'</button>';
            }else{
                $status = '<button id="orange" class="btn btn-danger-blue"  name="yt1")">'.$status.'</button>';
            }
            return $status;
        }
    
}
?>
