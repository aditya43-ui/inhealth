<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class FALaporanlembarresepluarV extends LaporanlembarresepluarV {

        public $tgl_awal, $tgl_akhir, $tick, $data, $jumlah;

        public static function model($className = __CLASS__) {
            parent::model($className);
        }
    
	public function attributeLabels()
	{
		return array(
			'penjualanresep_id' => 'Penjualanresep',
			'tglresep' => 'Tglresep',
			'noresep' => 'Noresep',
			'totharganetto' => 'Totharganetto',
			'totalhargajual' => 'Totalhargajual',
			'totaltarifservice' => 'Totaltarifservice',
			'biayaadministrasi' => 'Biaya Administrasi',
			'biayakonseling' => 'Biayakonseling',
			'instalasiasal_nama' => 'Instalasiasal Nama',
			'ruanganasal_nama' => 'Ruanganasal Nama',
			'r' => 'R',
			'rke' => 'Rke',
			'ruangan_id' => 'Ruangan',
			'pendaftaran_id' => 'Pendaftaran',
			'pegawai_id' => 'Pegawai',
			'carabayar_nama' => 'Carabayar Nama',
			'penjamin_nama' => 'Penjamin Nama',
			'carabayar_id' => 'Jenis Penjamin',
			'penjamin_id' => 'Penjamin',
			'jenispenjualan' => 'Jenispenjualan',
			'tglpenjualan' => 'Tglpenjualan',
			'qty_oa' => 'Jumlah Oa',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function criteriaLaporan()
	{
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
                
                $criteria->group = 'noresep, tglresep';
                $criteria->select = $criteria->group.', SUM(totalhargajual) as totalhargajual';
                $criteria->order = 'noresep, tglresep, totalhargajual';
                $this->tgl_awal = MyFormatter::formatDateTimeForDb($this->tgl_awal);
                $this->tgl_akhir = MyFormatter::formatDateTimeForDb($this->tgl_akhir);
                $criteria->addBetweenCondition('DATE(tglresep)',$this->tgl_awal, $this->tgl_akhir);

                            return $criteria;
	}
        
        public function searchLaporan()
        {
        return new CActiveDataProvider($this, array(
                'criteria'=>$this->criteriaLaporan(),
                                        'pagination'=>array(
                                            'pageSize'=>10,
                                        )
        ));
        }

        public function searchLaporanPrint()
        {
        return new CActiveDataProvider($this, array(
                'criteria'=>$this->criteriaLaporan(),
                                        'pagination'=>false,
        ));
        }

        public function sumTotalhargajual($noresep)
        {
            $sql = Yii::app()->db->createCommand(
                    "SELECT SUM(totalhargajual) AS totalharga
                     FROM laporanlembarresepluar_v
                     WHERE noresep='$noresep'"
            )->queryAll();
            $totalharga = $sql[0]['totalharga'];
            return $totalharga;
        }

        public function totalhargaPerR($noresep)
        {
            $data = LaporanlembarresepluarV::model()->findAll("noresep='$noresep'");
            foreach ($data as $value) {
                $tr .= $value['totalhargajual'].' / '.$value['rke'].'<br/>';
            }
            return $tr;
        }

        public function jumlahResep($noresep)
        {
//                    $sql = Yii::app()->db->createCommand(
//                            "SELECT COUNT(penjualanresep_id) AS jumlah
//                             FROM laporanlembarresepluar_v
//                             WHERE noresep='$noresep'"
//                    )->queryAll();
//                    $jumlahresep = $sql[0]['jumlah'];
            $sql = Yii::app()->db->createCommand(
                    "SELECT SUM(qty_oa) AS jumlah
                     FROM laporanlembarresepluar_v
                     WHERE noresep='$noresep'"
            )->queryAll();
            $jumlahresep = $sql[0]['jumlah'];
            return $jumlahresep;
        }

        public function searchGrafik()
        {
                $criteria = new CDbCriteria;
                $criteria->select = 'noresep AS data, COUNT(penjualanresep_id) AS jumlah';
                $criteria->group = 'noresep';

                return  new CActiveDataProvider($this, array(
                            'criteria'=>$criteria,
                ));
        }

        public static function getItemR($noresep)
        {
            $command = Yii::app()->db->createCommand("SELECT SUM(rke) AS jumalhr FROM laporanlembarresepluar_v WHERE noresep='$noresep'")->queryAll();
            return $command[0]['jumalhr'];
        }

        public static function getQty($noresep)
        {
            $command = Yii::app()->db->createCommand("SELECT SUM(qty_oa) AS totalqty FROM laporanlembarresepluar_v WHERE noresep='$noresep'")->queryAll();
            return $command[0]['totalqty'];
        }

        public function getTotalhargajual()
        {
            $this->tgl_awal = MyFormatter::formatDateTimeForDb($this->tgl_awal);
            $this->tgl_akhir = MyFormatter::formatDateTimeForDb($this->tgl_akhir);
            $command = Yii::app()->db->createCommand("SELECT SUM(totalhargajual) AS totalhargajual FROM laporanlembarresepluar_v WHERE DATE(tglresep) BETWEEN '$this->tgl_awal' AND '$this->tgl_akhir'")->queryAll();
            return $command[0]['totalhargajual'];
        }

        public function getTotalR()
        {
            $this->tgl_awal = MyFormatter::formatDateTimeForDb($this->tgl_awal);
            $this->tgl_akhir = MyFormatter::formatDateTimeForDb($this->tgl_akhir);
            $command = Yii::app()->db->createCommand("SELECT SUM(rke) AS totalr FROM laporanlembarresepluar_v WHERE DATE(tglresep) BETWEEN '$this->tgl_awal' AND '$this->tgl_akhir'")->queryAll();
            return $command[0]['totalr'];
        }

        public function getTotalQty()
        {
            $this->tgl_awal = MyFormatter::formatDateTimeForDb($this->tgl_awal);
            $this->tgl_akhir = MyFormatter::formatDateTimeForDb($this->tgl_akhir);
            $command = Yii::app()->db->createCommand("SELECT SUM(qty_oa) AS totalqty FROM laporanlembarresepluar_v WHERE DATE(tglresep) BETWEEN '$this->tgl_awal' AND '$this->tgl_akhir'")->queryAll();
            return $command[0]['totalqty'];
        }

        public function getTotalJumlahresep()
        {
            $this->tgl_awal = MyFormatter::formatDateTimeForDb($this->tgl_awal);
            $this->tgl_akhir = MyFormatter::formatDateTimeForDb($this->tgl_akhir);
            $command = Yii::app()->db->createCommand("SELECT COUNT(noresep) AS jmlhresep FROM laporanlembarresepluar_v WHERE DATE(tglresep) BETWEEN '$this->tgl_awal' AND '$this->tgl_akhir' GROUP BY noresep")->queryAll();
            if (isset($command[0]['jmlhresep'])){
                return $command[0]['jmlhresep'];
            }
        }
}

?>
