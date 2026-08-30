<?php

class BKLaporanclosingkasirV extends LaporanclosingkasirV
{
        public $tgl_awal, $tgl_akhir, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir, $jns_periode, $ruanganKasir = array();
        public $jumlah, $data, $tick; //untuk grafik
        public $cekPeg;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanclosingkasirV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
         * Digunakan di:
         * - Biling Kasir - Laporan - Laporan Closing Kasir
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
        protected function functionCriteria(){
            $criteria=new CDbCriteria;
			//$this->tgl_awal = MyFormatter::formatDateTimeForDb($this->tgl_awal);
			//$this->tgl_akhir = MyFormatter::formatDateTimeForDb($this->tgl_akhir);
            if(!empty($this->tgl_awal) && !empty($this->tgl_akhir)){
                $criteria->addBetweenCondition('date(tglclosingkasir)',$this->tgl_awal,$this->tgl_akhir);
            }
			if(!empty($this->closingkasir_id)){
				$criteria->addCondition('closingkasir_id = '.$this->closingkasir_id);
			}
			if(!empty($this->shift_id)){
				$criteria->addInCondition('shift_id', $this->shift_id);
			}
            $criteria->compare('shift_nama',$this->shift_nama,true);
			if(!empty($this->pegawai_id)){
				$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
			}
            $criteria->compare('nama_pegawai',$this->nama_pegawai,true);
			if(!empty($this->setorbank_id)){
				$criteria->addCondition('setorbank_id = '.$this->setorbank_id);
			}
            $criteria->compare('nostruksetor',$this->nostruksetor,true);
            $criteria->compare('tgldisetor',$this->tgldisetor,true);
            $criteria->compare('namabank',$this->namabank,true);
            $criteria->compare('norekening',$this->norekening,true);
            $criteria->compare('jumlahsetoran',$this->jumlahsetoran);
            $criteria->compare('closingdari',$this->closingdari,true);
            $criteria->compare('sampaidengan',$this->sampaidengan,true);
            $criteria->compare('closingsaldoawal',$this->closingsaldoawal);
            $criteria->compare('terimauangmuka',$this->terimauangmuka);
            $criteria->compare('terimauangpelayanan',$this->terimauangpelayanan);
            $criteria->compare('totalpengeluaran',$this->totalpengeluaran);
            $criteria->compare('totalsetoran',$this->totalsetoran);
            $criteria->compare('keterangan_closing',$this->keterangan_closing,true);
            $criteria->compare('jmluanglogam',$this->jmluanglogam);
            $criteria->compare('jmluangkertas',$this->jmluangkertas);
            $criteria->compare('jmltransaksi',$this->jmltransaksi);
            $criteria->compare('piutang',$this->piutang);
            $criteria->compare('nilaiclosingtrans',$this->nilaiclosingtrans);
            $criteria->compare('create_time',$this->create_time,true);
            $criteria->compare('update_time',$this->update_time,true);
			if(!empty($this->create_loginpemakai_id)){
				$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
			}
			if(!empty($this->update_loginpemakai_id)){
				$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
			}
          //  if (!empty($this->create_ruangan)){
                
            //    $criteria->addInCondition('create_ruangan', $this->create_ruangan);
           // }else{
             //  $criteria->addCondition('create_ruangan IS NULL');
           // }
            return $criteria;
        }
        
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
                $criteria = new CDbCriteria;
                $criteria = $this->functionCriteria();
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        public function searchTable()
        {
            $criteria = new CDbCriteria;
            $criteria = $this->functionCriteria();
            return new CActiveDataProvider($this,
                array(
                    'criteria' => $criteria,
                )
            );
        }
        public function searchPrint()
        {
            $criteria = new CDbCriteria;
            $criteria = $this->functionCriteria();
            $criteria->limit = -1;
            return new CActiveDataProvider($this,
                array(
                    'criteria' => $criteria,
                    'pagination' => false,
                )
            );
        }
        public function searchGrafik() {
            $criteria = new CDbCriteria;
            $criteria = $this->functionCriteria();

            $criteria->select = 'count(closingkasir_id) as jumlah, shift_nama as data';
            $criteria->select .= ', shift_nama as tick';
            $criteria->group = 'shift_nama';

            return new CActiveDataProvider($this, array(
                        'criteria' => $criteria,
                    ));
        }
        public function getShiftItems(){
            $modShift = ShiftM::model()->findAllByAttributes(array('shift_aktif'=>true), array('order'=>'shift_jamawal'));
            return $modShift;
        }
}