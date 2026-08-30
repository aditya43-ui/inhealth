<?php

class GFInformasistokobatalkesV extends InformasistokobatalkesV
{
    public $kemasanbesar;
    public $discount;
    public $tglkadaluarsa;
    public $tglkadaluarsa_awal;
    public $tglkadaluarsa_akhir;
    public $jenisstokopname; //utk switch model
	public $ruanganpemesan_id, $harganetto; // untuk switch model
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasistokobatalkesV the static model class
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
               // $criteria->select = "obatalkes_id,obatalkes_nama";
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->jenisobatalkes_id)){
			$criteria->addCondition('jenisobatalkes_id = '.$this->jenisobatalkes_id);
		}
		$criteria->compare('LOWER(jenisobatalkes_kode)',strtolower($this->jenisobatalkes_kode),true);
		$criteria->compare('LOWER(jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
		$criteria->compare('jenisobatalkes_farmasi',$this->jenisobatalkes_farmasi);
		if(!empty($this->obatalkes_id)){
			$criteria->addCondition('obatalkes_id = '.$this->obatalkes_id);
		}
		$criteria->compare('LOWER(obatalkes_barcode)',strtolower($this->obatalkes_barcode),true);
		$criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
		$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes_namalain)',strtolower($this->obatalkes_namalain),true);
		$criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
		$criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
		$criteria->compare('LOWER(obatalkes_kadarobat)',strtolower($this->obatalkes_kadarobat),true);
		if(!empty($this->satuankecil_id)){
			$criteria->addCondition('satuankecil_id = '.$this->satuankecil_id);
		}
		$criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);
		$criteria->compare('hpp_max',$this->hpp_max);
		$criteria->compare('hpp_min',$this->hpp_min);
		$criteria->compare('hpp_avg',$this->hpp_avg);
		$criteria->compare('hargajual_max',$this->hargajual_max);
		$criteria->compare('hargajual_min',$this->hargajual_min);
		$criteria->compare('hargajual_avg',$this->hargajual_avg);
		$criteria->compare('qtystok',$this->qtystok);
               // $criteria->group = "obatalkes_id, obatalkes_nama";
		return $criteria;
	}


        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function searchInformasi()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }

        public function searchDataObat()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;
                $criteria->select = "obatalkes_id,obatalkes_nama,obatalkes_golongan,obatalkes_kategori,jenisobatalkes_nama,obatalkes_kode,satuankecil_nama";
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->jenisobatalkes_id)){
			$criteria->addCondition('jenisobatalkes_id = '.$this->jenisobatalkes_id);
		}
		$criteria->compare('LOWER(jenisobatalkes_kode)',strtolower($this->jenisobatalkes_kode),true);
		$criteria->compare('LOWER(jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
		$criteria->compare('jenisobatalkes_farmasi',$this->jenisobatalkes_farmasi);
		if(!empty($this->obatalkes_id)){
			$criteria->addCondition('obatalkes_id = '.$this->obatalkes_id);
		}
		$criteria->compare('LOWER(obatalkes_barcode)',strtolower($this->obatalkes_barcode),true);
		$criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
		$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes_namalain)',strtolower($this->obatalkes_namalain),true);
		$criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
		$criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
		$criteria->compare('LOWER(obatalkes_kadarobat)',strtolower($this->obatalkes_kadarobat),true);
		if(!empty($this->satuankecil_id)){
			$criteria->addCondition('satuankecil_id = '.$this->satuankecil_id);
		}
		$criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);
		$criteria->compare('hpp_max',$this->hpp_max);
		$criteria->compare('hpp_min',$this->hpp_min);
		$criteria->compare('hpp_avg',$this->hpp_avg);
		$criteria->compare('hargajual_max',$this->hargajual_max);
		$criteria->compare('hargajual_min',$this->hargajual_min);
		$criteria->compare('hargajual_avg',$this->hargajual_avg);
		$criteria->compare('qtystok',$this->qtystok);
                $criteria->group = 'obatalkes_id, obatalkes_nama,obatalkes_golongan,obatalkes_kategori, jenisobatalkes_nama,obatalkes_kode,satuankecil_nama';

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
		 * untuk formulir stock opname
		 * @return \CActiveDataProvider
		 * ada 3 data (model):
		 * - penyesuaian
		 * - stok awal
		 * - dari formulir
		*/
		public function searchObatStokOpname()
		{
			$model = $this;
			$criteria=new CDbCriteria;
			$criteria->limit = 250; //RTN-1095 //RND-9703 Reduce limit from 1000 to 50
			if(!Yii::app()->request->isAjaxRequest){//data hanya muncul setelah melakukan pencarian
				$criteria->limit = 0;
			}
			if(isset($_GET['formuliropname_id'])){
				$model = new GFFormstokopnameR;
				$criteria->addCondition('formuliropname_id = '.$_GET['formuliropname_id']);
				$criteria->addCondition('stokopnamedet_id IS NULL');
				$criteria->limit = -1;
			}else if(isset($_GET['stokopname_id'])){
				$model = new GFStokopnamedetT;
				$criteria->addCondition('stokopname_id = '.$_GET['stokopname_id']);
				$criteria->limit = -1;
			}else{
				if(!empty($this->obatalkes_id)){
					$criteria->addCondition('t.obatalkes_id = '.$this->obatalkes_id);
				}
				if(!empty($this->jenisobatalkes_id)){
					$criteria->addCondition('t.jenisobatalkes_id = '.$this->jenisobatalkes_id);
				}
				$criteria->compare('LOWER(t.obatalkes_barcode)',strtolower($this->obatalkes_barcode));
				$criteria->compare('LOWER(t.obatalkes_kode)',strtolower($this->obatalkes_kode),true);
				//$criteria->compare('LOWER(t.obatalkes_nama)',strtolower($this->obatalkes_nama),true);
                $criteria->addCondition("t.obatalkes_nama ILIKE '%".$this->obatalkes_nama."%' ");
				$criteria->compare('LOWER(t.obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
				$criteria->compare('LOWER(t.obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
				if($this->jenisstokopname == Params::JENISSTOKOPNAME_PENYESUAIAN){
					$criteria->addCondition('t.ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
                                        $criteria->group = "t.instalasi_id, t.instalasi_nama, t.ruangan_id, t.ruangan_nama, jo.jenisobatalkes_id, jo.jenisobatalkes_kode, t.jenisobatalkes_nama, t.jenisobatalkes_farmasi, t.obatalkes_id,"
                                                . "t.obatalkes_barcode, t.obatalkes_kode, t.obatalkes_nama, t.obatalkes_namalain, t.obatalkes_golongan, t.obatalkes_kategori,"
                                                . "t.obatalkes_kadarobat, t.asalbarang_id, t.asalbarang_nama, "//t.satuankecil_id, t.satuankecil_nama,
                                                . "o.harganetto, o.hargajual, o.hpp";
					$criteria->select = $criteria->group.", sum(t.qtystok) as qtystok";

                                        $criteria->join = "join obatalkes_m o on o.obatalkes_id = t.obatalkes_id"
                                                . " LEFT JOIN jenisobatalkes_m jo ON jo.jenisobatalkes_id = o.jenisobatalkes_id";

                                        $criteria->addCondition('o.obatalkes_aktif = true');

                                        $model = $this;
				}else{
					$model = new GFObatalkesM;
                                        $criteria->select = "t.*, o.hpp, jo.jenisobatalkes_id, jo.jenisobatalkes_nama";
                                        $criteria->join = " left join obatalkes_m o on o.obatalkes_id = t.obatalkes_id"
                                                . " LEFT JOIN jenisobatalkes_m jo ON jo.jenisobatalkes_id = o.jenisobatalkes_id"
                                                . " left join informasistokobatalkes_v i on "
                                                . "i.obatalkes_id = t.obatalkes_id and i.ruangan_id = ".Yii::app()->user->getState('ruangan_id');
                                        $criteria->addCondition("i.obatalkes_id is null");
                                        $criteria->addCondition('t.obatalkes_aktif = true');
                                        //$criteria->addCondition('i.ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
                                }
                                $criteria->order = 't.obatalkes_nama';
			}

                        // var_dump($criteria); die;

			return new CActiveDataProvider($model, array(
					'criteria'=>$criteria,
					'pagination'=>false,
			));
		}

//	public function criteriaSearchDataObat()
//	{
//		// Warning: Please modify the following code to remove attributes that
//		// should not be searched.
//		$criteria=new CDbCriteria;
//		if(is_array($this->obatalkes_id)){ //jika menampilkan banyak obatalkes_id
//			$pilihObat = array();
//			$i = 0;
//			foreach($this->obatalkes_id as $idObat){
//				$pilihObat[$i] = "obatalkes_id = '".$idObat."' "; //multiple conditions
//				$i++;
//			}
//			$criteria->condition = implode(' OR ',$pilihObat);
//		}else{
//			if(!empty($this->obatalkes_id)){
//				$criteria->addCondition('obatalkes_id = '.$this->obatalkes_id);
//			}
//
//		if(!empty($this->obatalkes_id)){
//			$criteria->addCondition('obatalkes_id = '.$this->obatalkes_id);
//		}
//		if(!empty($this->jenisobatalkes_id)){
//			$criteria->addCondition('jenisobatalkes_id = '.$this->jenisobatalkes_id);
//		}
//		$criteria->compare('LOWER(jenisobatalkes_kode)',strtolower($this->jenisobatalkes_kode),true);
//		$criteria->compare('LOWER(jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
//		$criteria->compare('LOWER(obatalkes_barcode)',strtolower($this->obatalkes_barcode),true);
//		$criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
//		$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
//		$criteria->compare('LOWER(obatalkes_namalain)',strtolower($this->obatalkes_namalain),true);
//		$criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
//		$criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
//		$criteria->compare('LOWER(obatalkes_kadarobat)',strtolower($this->obatalkes_kadarobat),true);
//		if(!empty($this->satuankecil_id)){
//			$criteria->addCondition('satuankecil_id = '.$this->satuankecil_id);
//		}
//		$criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);
//		$criteria->compare('hpp_max',$this->hpp_max);
//		$criteria->compare('hpp_min',$this->hpp_min);
//		$criteria->compare('hpp_avg',$this->hpp_avg);
//		$criteria->compare('hargajual_max',$this->hargajual_max);
//		$criteria->compare('hargajual_min',$this->hargajual_min);
//		$criteria->compare('hargajual_avg',$this->hargajual_avg);
//		$criteria->compare('qtystok',$this->qtystok);
//		$criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
//            }
//			$criteria->limit = 1000; //RTN-1095
//            if(!isset($_GET['GFInformasistokobatalkesV'])){
//                $criteria->limit = 0;
//            }
//            return $criteria;
//        }
//
//        public function searchDataObat()
//        {
//            return new CActiveDataProvider($this, array(
//                    'criteria'=>$this->criteriaSearchDataObat(),
//                    'pagination'=>false,
//            ));
//        }

//	public function searchDataObatAfter()
//	{
//		$criteria=new CDbCriteria;
//		if(is_array($this->obatalkes_id)){ //jika menampilkan banyak obatalkes_id
//			$pilihObat = array();
//			$i = 0;
//			foreach($this->obatalkes_id as $idObat){
//				$pilihObat[$i] = "obatalkes_id = '".$idObat."' "; //multiple conditions
//				$i++;
//			}
//			$criteria->condition = implode(' OR ',$pilihObat);
//		}else{
//			if(!empty($this->obatalkes_id)){
//				$criteria->addCondition('obatalkes_id = '.$this->obatalkes_id);
//			}
//			if(!empty($this->obatalkes_id)){
//				$criteria->addCondition('obatalkes_id = '.$this->obatalkes_id);
//			}
//			if(!empty($this->jenisobatalkes_id)){
//				$criteria->addCondition('jenisobatalkes_id = '.$this->jenisobatalkes_id);
//			}
//			$criteria->compare('LOWER(jenisobatalkes_kode)',strtolower($this->jenisobatalkes_kode),true);
//			$criteria->compare('LOWER(jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
//			$criteria->compare('LOWER(obatalkes_barcode)',strtolower($this->obatalkes_barcode),true);
//			$criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
//			$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
//			$criteria->compare('LOWER(obatalkes_namalain)',strtolower($this->obatalkes_namalain),true);
//			$criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
//			$criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
//			$criteria->compare('LOWER(obatalkes_kadarobat)',strtolower($this->obatalkes_kadarobat),true);
//			if(!empty($this->satuankecil_id)){
//				$criteria->addCondition('satuankecil_id = '.$this->satuankecil_id);
//			}
//			$criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);
//			$criteria->compare('hpp_max',$this->hpp_max);
//			$criteria->compare('hpp_min',$this->hpp_min);
//			$criteria->compare('hpp_avg',$this->hpp_avg);
//			$criteria->compare('hargajual_max',$this->hargajual_max);
//			$criteria->compare('hargajual_min',$this->hargajual_min);
//			$criteria->compare('hargajual_avg',$this->hargajual_avg);
//			$criteria->compare('qtystok',$this->qtystok);
//		}
//		$criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
//
//		$criteria->limit = 1000; //RTN-1095
//		return new CActiveDataProvider($this, array(
//				'criteria'=>$criteria,
//				'pagination'=>false,
//		));
//	}

	public function getStokObatRuanganPemesan(){ // menampilkan stok obat berdasarkan ruangan pemesan
		if(isset($_GET['pesanobatalkes_id'])){
			$modInfoOa = GFInformasipesanobatalkesV::model()->findByAttributes(array('pesanobatalkes_id'=>$_GET['pesanobatalkes_id']));
			return StokobatalkesT::getJumlahStok($this->obatalkes_id,$modInfoOa->ruanganpemesan_id);
		}else{
			return StokobatalkesT::getJumlahStok($this->obatalkes_id,Yii::app()->user->getState('ruangan_id'));
		}
	}

}
