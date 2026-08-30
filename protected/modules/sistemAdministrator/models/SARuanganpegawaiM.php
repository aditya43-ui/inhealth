<?php


class SARuanganpegawaiM extends RuanganpegawaiM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DiagnosaM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchTabel()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
       	$sessionruangan = Yii::app()->user->ruangan_id;
	
		$criteria=new CDbCriteria;
                                $criteria->with = array('ruangan','pegawai');
                                $criteria->order = 'pegawai.nama_pegawai';
        
              //  if (Yii::app()->controller->module->id !=='sistemAdministrator') {
                    $criteria->compare('t.ruangan_id',$sessionruangan);
              //  }
                $criteria->compare('LOWER(pegawai.nama_pegawai)',strtolower($this->nama_pegawai),true);
                $criteria->compare('LOWER(ruangan.ruangan_nama)',strtolower($this->ruangan_nama),true);
//		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('t.pegawai_id',$this->pegawai_id);
        
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=10; 

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                       // 'pagination'=>false,
		));
	}

	public function searchTabelRuang()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
       	$sessionruangan = Yii::app()->user->ruangan_id;
	
		$criteria=new CDbCriteria;
                                $criteria->with = array('ruangan','pegawai');
                                $criteria->order = 'pegawai.nama_pegawai';
        
              //  if (Yii::app()->controller->module->id !=='sistemAdministrator') {
                    $criteria->compare('t.ruangan_id',$this->ruangan_id);
              //  }
                $criteria->compare('LOWER(pegawai.nama_pegawai)',strtolower($this->nama_pegawai),true);
                $criteria->compare('LOWER(ruangan.ruangan_nama)',strtolower($this->ruangan_nama),true);
//		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('t.pegawai_id',$this->pegawai_id);
        
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=10; 

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                       // 'pagination'=>false,
		));
	}


	public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $sessionruangan = Yii::app()->user->ruangan_id;
	
		$criteria=new CDbCriteria;
                                $criteria->with = array('ruangan','pegawai');
                                 $criteria->order = 'pegawai.nama_pegawai';
        
              //  if (Yii::app()->controller->module->id !=='sistemAdministrator') {
                    $criteria->compare('t.ruangan_id', Yii::app()->user->getState('ruangan_id'));
               // }
                $criteria->compare('LOWER(pegawai.nama_pegawai)',strtolower($this->nama_pegawai),true);
                $criteria->compare('LOWER(ruangan.ruangan_nama)',strtolower($this->ruangan_nama),true);
//		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('t.pegawai_id',$this->pegawai_id);
        
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
        }
}