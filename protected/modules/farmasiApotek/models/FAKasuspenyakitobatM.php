<?php

class FAKasuspenyakitobatM extends KasuspenyakitobatM
{
	public $jeniskasuspenyakit_nama,$obatalkes_kode,$obatalkes_nama;
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchKasusPenyakit()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
//		$criteria->with = array('obatalkes', 'jeniskasuspenyakit');
                
                $criteria->select = 'obatalkes.*,t.*,jeniskasuspenyakit.*';
		if(!empty($this->jeniskasuspenyakit_id)){
			$criteria->addCondition("t.jeniskasuspenyakit_id = ".$this->jeniskasuspenyakit_id);						
		}
		if(!empty($this->obatalkes_id)){
			$criteria->addCondition("t.obatalkes_id = ".$this->obatalkes_id);						
		}
		$criteria->compare('LOWER(obatalkes.obatalkes_kode)',strtolower($this->obatalkes_kode),true);
		$criteria->compare('LOWER(obatalkes.obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		$criteria->compare('LOWER(jeniskasuspenyakit.jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
                $criteria->order = 't.jeniskasuspenyakit_id, t.obatalkes_id';
                $criteria->join = 'LEFT JOIN obatalkes_m obatalkes ON t.obatalkes_id = obatalkes.obatalkes_id '
                                . '  LEFT JOIN jeniskasuspenyakit_m jeniskasuspenyakit ON t.jeniskasuspenyakit_id = jeniskasuspenyakit.jeniskasuspenyakit_id';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
                
	public function searchPrint()
	{
			// Warning: Please modify the following code to remove attributes that
			// should not be searched.

			$criteria=new CDbCriteria;
			$criteria->select = 'obatalkes.*,t.*,jeniskasuspenyakit.*';
			if(!empty($this->jeniskasuspenyakit_id)){
				$criteria->addCondition("t.jeniskasuspenyakit_id = ".$this->jeniskasuspenyakit_id);						
			}
			if(!empty($this->obatalkes_id)){
				$criteria->addCondition("t.obatalkes_id = ".$this->obatalkes_id);						
			}
			$criteria->compare('LOWER(obatalkes.obatalkes_kode)',strtolower($this->obatalkes_kode),true);
			$criteria->compare('LOWER(obatalkes.obatalkes_nama)',strtolower($this->obatalkes_nama),true);
			$criteria->compare('LOWER(jeniskasuspenyakit.jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
			$criteria->order = 't.jeniskasuspenyakit_id, t.obatalkes_id';
			$criteria->join = 'LEFT JOIN obatalkes_m obatalkes ON t.obatalkes_id = obatalkes.obatalkes_id '
					. '  LEFT JOIN jeniskasuspenyakit_m jeniskasuspenyakit ON t.jeniskasuspenyakit_id = jeniskasuspenyakit.jeniskasuspenyakit_id';
			$criteria->limit=-1; 

			return new CActiveDataProvider($this, array(
					'criteria'=>$criteria,
					'pagination'=>false,
			));
	}
	
	 public function getJeniskasuspenyakitItems() {
        return JeniskasuspenyakitM::model()->findAll('jeniskasuspenyakit_aktif=TRUE ORDER BY jeniskasuspenyakit_nama');
    }

}