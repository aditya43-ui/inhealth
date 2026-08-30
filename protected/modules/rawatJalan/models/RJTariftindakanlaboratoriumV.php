<?php
/**
*       - digunakan untuk menyimpaan fungsi model dan memanggil view tariftindakanlaboratorium_v, yang digunakan hanya untuk modul kepegawaian saja
*       @author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
*       @website	<piindonesia.co.id>
*/

class RJTariftindakanlaboratoriumV extends TariftindakanlaboratoriumV
{	

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        public function searchInformasi(){          	
            $criteria=new CDbCriteria;
            $criteria->addBetweenCondition('DATE(poinpegawai_tgl)', $this->tgl_awal, $this->tgl_akhir);
            $criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai),true);            

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
	
        }
}