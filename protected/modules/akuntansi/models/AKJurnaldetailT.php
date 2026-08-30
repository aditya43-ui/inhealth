<?php

class AKJurnaldetailT extends JurnaldetailT
{
    public $tgl_awal;
    public $tgl_akhir;
    public $is_posting;
    public $jenisjurnal_id;
    public $nobuktijurnal;
    public $noreferensi;
    public $kodejurnal;
	public $kdrekening1,$kdrekening2,$kdrekening3,$kdrekening4,$kdrekening5,$nmrekening5;
	public $rekening1_id,$rekening2_id,$rekening3_id,$rekening4_id,$rekening5_id;
	public $allow_jenisjurnal;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function searchWithJoinPenerimaan()
    {
            $criteria=new CDbCriteria;
            $criteria->compare('LOWER(nobuktijurnal)', strtolower($this->nobuktijurnal), true);
			if(!empty($this->jenisjurnal_id)){
				$criteria->addCondition("jenisjurnal_id = ".$this->jenisjurnal_id);
			}
            $criteria->compare('noreferensi',$this->noreferensi);
            $criteria->compare('LOWER(kodejurnal)', strtolower($this->kodejurnal), true);
            if(isset($this->is_posting))
            {
                if($this->is_posting == 0)
                {
                    $criteria->addCondition('t.jurnalposting_id IS NOT NULL');
                }else if($this->is_posting == 1){
                    $criteria->addCondition('t.jurnalposting_id IS NULL');
                }

            }
            $criteria->addBetweenCondition('DATE(tglbuktijurnal)', $this->tgl_awal, $this->tgl_akhir);
            $criteria->with = array('jurnalPosting', 'jurnalRekening');
            $criteria->order = 'jurnaldetail_id, nourut';
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }

    public function searchWithJoin()
    {
            $criteria=new CDbCriteria;
            $criteria->compare('LOWER(nobuktijurnal)', strtolower($this->nobuktijurnal), true);
			if(!empty($this->jenisjurnal_id)){
				if (is_array($this->jenisjurnal_id)){
					$criteria->addInCondition("jenisjurnal_id",$this->jenisjurnal_id);
				}else{
					$criteria->addCondition("jenisjurnal_id = ".$this->jenisjurnal_id);
				}
			}

			if (isset($this->allow_jenisjurnal)){
				if ($this->allow_jenisjurnal == 'Posting Jurnal Umum'){
					$criteria->addNotInCondition("jenisjurnal_id", Params::notJnsJurnalPostUmum());
				}
			}

            $criteria->compare('noreferensi',$this->noreferensi);
            $criteria->compare('nobuktijurnal',$this->nobuktijurnal);
            $criteria->compare('LOWER(kodejurnal)', strtolower($this->kodejurnal), true);
            if(isset($this->is_posting))
            {
                if($this->is_posting == 0)
                {
                    $criteria->addCondition('t.jurnalposting_id IS NOT NULL');
                }else if($this->is_posting == 1){
                    $criteria->addCondition('t.jurnalposting_id IS NULL');
                }

            }
            $criteria->addBetweenCondition('DATE(tglbuktijurnal)', $this->tgl_awal, $this->tgl_akhir);
            $criteria->with = array('jurnalPosting', 'jurnalRekening');
            $criteria->order = 'kodejurnal ASC, t.nourut ASC';

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false
            ));
    }

    public function searchWithJoinBaru()
    {
            $criteria=new CDbCriteria;
            $criteria->select = "t.jurnaldetail_id, jurek.jurnalrekening_id, jurek.tglbuktijurnal, jurek.nobuktijurnal, jurek.kodejurnal, jurek.urianjurnal, jurek.tglreferensi, jurek.noreferensi, t.rekening1_id, t.rekening2_id, t.rekening3_id, t.rekening4_id, t.rekening5_id, sum(saldodebit) as saldodebit, sum(saldokredit) as saldokredit";
            $criteria->group = "t.jurnaldetail_id, jurek.jurnalrekening_id, jurek.tglbuktijurnal, jurek.nobuktijurnal, jurek.kodejurnal, jurek.urianjurnal, jurek.tglreferensi, jurek.noreferensi, t.rekening1_id, t.rekening2_id, t.rekening3_id, t.rekening4_id, t.rekening5_id, t.nourut";
            $criteria->join = " LEFT JOIN jurnalposting_t jpo ON jpo.jurnalposting_id = t.jurnalposting_id "
                    . "JOIN jurnalrekening_t jurek ON jurek.jurnalrekening_id = t.jurnalrekening_id";

            $criteria->compare('LOWER(jurek.nobuktijurnal)', strtolower($this->nobuktijurnal), true);
			if(!empty($this->jenisjurnal_id)){
				if (is_array($this->jenisjurnal_id)){
					$criteria->addInCondition("jurek.jenisjurnal_id",$this->jenisjurnal_id);
				}else{
					$criteria->addCondition("jurek.jenisjurnal_id = ".$this->jenisjurnal_id);
				}
			}

			if (isset($this->allow_jenisjurnal)){
				if ($this->allow_jenisjurnal == 'Posting Jurnal Umum'){
					$criteria->addNotInCondition("jurek.jenisjurnal_id", Params::notJnsJurnalPostUmum());
				}
			}

            $criteria->compare('jurek.noreferensi',$this->noreferensi);
            $criteria->compare('jurek.nobuktijurnal',$this->nobuktijurnal);
            $criteria->compare('LOWER(jurek.kodejurnal)', strtolower($this->kodejurnal), true);
            if(isset($this->is_posting))
            {
                if($this->is_posting == 0)
                {
                    $criteria->addCondition('t.jurnalposting_id IS NOT NULL');
                }else if($this->is_posting == 1){
                    $criteria->addCondition('t.jurnalposting_id IS NULL');
                }

            }
            $criteria->addBetweenCondition('DATE(jurek.tglbuktijurnal)', $this->tgl_awal, $this->tgl_akhir);
//            $criteria->with = array('jurnalPosting', 'jurnalRekening');
            $criteria->order = 'jurek.kodejurnal ASC, t.nourut ASC';
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }

    public function searchByFilter()
    {
            $criteria=new CDbCriteria;
            $criteria->select = 'jurnalrekening_id, uraiantransaksi';
			if(!empty($this->jurnalrekening_id)){
				$criteria->addCondition("jurnalrekening_id = ".$this->jurnalrekening_id);
			}
            $criteria->group = 'jurnalrekening_id, uraiantransaksi';
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }

    public function getNamaRekDebit()
    {
		$criteria = new CDbCriteria;

		if(!empty($this->rekening5_id)){
			$criteria->addCondition("rekening5_id = ".$this->rekening5_id);
		}
		$result = AKJurnaldetailT::model()->find($criteria);
		if(isset($result->rekening5->nmrekening5))
		{
			$kode_rekening = $result->rekening5->nmrekening5;
		}
		return ($this->saldokredit == 0 ? $kode_rekening : "-") ;
    }

    public function getNamaRekKredit()
    {
		$criteria = new CDbCriteria;

		if(!empty($this->rekening5_id)){
			$criteria->addCondition("rekening5_id = ".$this->rekening5_id);
		}
		$result = AKJurnaldetailT::model()->find($criteria);

		if(isset($result->rekening5->nmrekening5))
		{
			$kode_rekening = $result->rekening5->nmrekening5;
		}

		return ($this->saldodebit == 0 ? $kode_rekening : "-") ;
    }

    public function getRekDebit()
    {
		$criteria=new CDbCriteria;
		if(!empty($this->jurnalrekening_id)){
			$criteria->addCondition("jurnalrekening_id = ".$this->jurnalrekening_id);
		}
		$condition = "saldokredit = 0";
		$criteria->addCondition($condition);
		$result = $this->model()->find($criteria);
		return $result['saldodebit'];
    }

    public function getRekKredit()
    {
		$criteria=new CDbCriteria;
		if(!empty($this->jurnalrekening_id)){
			$criteria->addCondition("jurnalrekening_id = ".$this->jurnalrekening_id);
		}
		$condition = "saldodebit = 0";
		$criteria->addCondition($condition);
		$result = $this->model()->find($criteria);
		return $result['saldokredit'];
    }

    protected function beforeValidate()
    {
        if($this->saldodebit === null || trim($this->saldodebit) == ''){
            $this->setAttribute('saldodebit', 0);
        }

        if($this->saldokredit === null || trim($this->saldokredit) == ''){
            $this->setAttribute('saldokredit', 0);
        }

        return parent::beforeSave();
    }

}
?>
