<?php

class GFStokObatAlkesT extends StokobatalkesT
{
        public $hjaresep,$hjanonresep,$marginresep,$marginnonresep,$hpp,$qtystok;
        /**
         * Returns the static model of the specified AR class.
         * @param string $className active record class name.
         * @return StokobatalkesT the static model class
         */
        public static function model($className=__CLASS__)
        {
                return parent::model($className);
        }
        
        public function search()
        {
                return new CActiveDataProvider($this, array(
                        'criteria'=>$this->criteria(),
                                                'pagination'=>array(
                                                    'pageSize'=>10,
                                                )
                ));
        }
        
        public function searchPrint()
        {
                return new CActiveDataProvider($this, array(
                        'criteria'=>$this->criteria(),
                        'pagination'=>false,
                ));
        }
        
        
         public function getCategoryItems()
        {
            return JenisobatalkesM::model()->findAll('jenisobatalkes_aktif=TRUE AND jenisobatalkes_farmasi=TRUE ORDER BY jenisobatalkes_nama');
        }
        
        public function getSubCategoryItems()
        {
            return SubjenisM::model()->findAll();
        }
        public function Criteria()
        {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

            $criteria=new CDbCriteria;

            $criteria->with=array('obatalkes');
            $criteria->join = 'LEFT JOIN obatalkes_m ON obatalkes_m.obatalkes_id=stokobatalkes_t.obatalkes_id';
            $criteria->select = 'obatalkes_m.obatalkes_kode, obatalkes_m.hargajual, stock_name, SUM(qtystok_current) AS qty, tglstok_in';
            $criteria->group = 'stock_code, hargajual, stock_name,tglstok_in';
			if(!empty($this->category_id)){
				$criteria->addCondition('category_id = '.$this->category_id);
			}
            $criteria->addCondition('ruangan_id = '.Yii::app()->user->ruangan_id);
            $criteria->addBetweenCondition('tglstok_in',$this->tgl_awal, $this->tgl_akhir);

            return $criteria;
        }
                
         public function getQtystock_in()
         {
             $criteria=$this->criteria();
             $criteria->select = 'SUM(qtystok_in)';
             return $this->commandBuilder->createFindCommand($this->getTableSchema(),$criteria)->queryScalar();
         }
                
         public function getTotalqtystok_in()
        {
            $criteria=$this->Criteria();
            $criteria->select = 'SUM(qtystok_in)';
            return $this->commandBuilder->createFindCommand($this->getTableSchema(),$criteria)->queryScalar();
        }
        
        public function getTotalhargajual()
        {
            $criteria=$this->criteria();
            $criteria->select = 'SUM(hargajual)';
            return $this->commandBuilder->createFindCommand($this->getTableSchema(),$criteria)->queryScalar();
        }
        
        public function getTotalharga()
        {
            $criteria=$this->criteria();
            $criteria->select = '(SUM(hargajual) * SUM(qtystok_in)) AS totalharga';
            return $this->commandBuilder->createFindCommand($this->getTableSchema(),$criteria)->queryScalar();
        }
        
        public function searchGrafik()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

			$criteria=new CDbCriteria;
			$criteria->select = 'count(stock_code) as jumlah, stock_name as data';
			$criteria->group = 'stock_name';
			$criteria->addBetweenCondition('tglstok_in', $this->tgl_awal, $this->tgl_akhir);
			if(!empty($this->category_id)){
				$criteria->addCondition('category_id = '.$this->category_id);
			}
			$criteria->compare('LOWER(category_name)',strtolower($this->category_name),true);
			if(!empty($this->subcategory_id)){
				$criteria->addCondition('subcategory_id = '.$this->subcategory_id);
			}
			$criteria->compare('LOWER(subcategory_code)',strtolower($this->subcategory_code),true);
			$criteria->compare('LOWER(subcategory_name)',strtolower($this->subcategory_name),true);
			$criteria->compare('LOWER(stock_code)',strtolower($this->stock_code),true);
			if(!empty($this->satuanbesar_id)){
				$criteria->addCondition('satuanbesar_id = '.$this->satuanbesar_id);
			}
			$criteria->compare('LOWER(satuanbesar_nama)',strtolower($this->satuanbesar_nama),true);
			if(!empty($this->satuankecil_id)){
				$criteria->addCondition('satuankecil_id = '.$this->satuankecil_id);
			}
			$criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);
			$criteria->compare('LOWER(stock_name)',strtolower($this->stock_name),true);
			$criteria->compare('jmldalamkemasan',$this->jmldalamkemasan);
			$criteria->compare('hargajual',$this->hargajual);
			$criteria->compare('discount',$this->discount);
			$criteria->compare('minimalstok',$this->minimalstok);
			$criteria->compare('LOWER(barang_barcode)',strtolower($this->barang_barcode),true);
			$criteria->compare('ppn_persen',$this->ppn_persen);
			$criteria->compare('qtystok_in',$this->qtystok_in);
			$criteria->compare('qtystok_out',$this->qtystok_out);
			$criteria->compare('qtystok_current',$this->qtystok_current);
			$criteria->compare('LOWER(ruangan_id)',strtolower($this->ruangan_id),true);
			$criteria->compare('LOWER(tglstok_in)',strtolower($this->tglstok_in),true);
			$criteria->addBetweenCondition('tglstok_in',$this->tgl_awal, $this->tgl_akhir);
			// Klo limit lebih kecil dari nol itu berarti ga ada limit 
		   // $criteria->limit=-1; 

			return new CActiveDataProvider($this, array(
					'criteria'=>$criteria,
			));
        }
}