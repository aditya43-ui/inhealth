<?php


class KPInformasipinjamanpegawaiV extends InformasipinjamanpegawaiV
{

	public $tgl_awal,$tgl_akhir,$tgl_awal_jatuhtempo,$tgl_akhir_jatuhtempo,$ceklis,$ceklistglpinjam;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasipinjamanpegawaiV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function searchTabel()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria=new CDbCriteria;
        $criteria->compare('LOWER(nopinjam)',strtolower($this->nopinjam),true);
        $criteria->compare('LOWER(nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
        $criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai),true);
        if($this->ceklis){
            $criteria->addBetweenCondition('DATE(tgljatuhtempo)', $this->tgl_awal_jatuhtempo, $this->tgl_akhir_jatuhtempo);
        }
        if($this->ceklistglpinjam){
            $criteria->addBetweenCondition('DATE(tglpinjampeg)', $this->tgl_awal, $this->tgl_akhir);
        }
        
        $criteria->limit=10;
        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }

    public function searchLaporan()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria=new CDbCriteria;
        $criteria->compare('LOWER(nopinjam)',strtolower($this->nopinjam),true);
        $criteria->compare('LOWER(nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
        $criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai),true);
        if($this->ceklistglpinjam){
            $criteria->compare('DATE(tglpinjampeg)', strtolower($this->tglpinjampeg));
        }
        if($this->ceklis){
            $criteria->compare('DATE(tgljatuhtempo)', strtolower($this->tgljatuhtempo));
        }
        
        $criteria->limit=10;

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }

    public function searchPrint()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria=new CDbCriteria;
        $criteria->compare('LOWER(nopinjam)',strtolower($this->nopinjam),true);
        $criteria->compare('LOWER(nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
        $criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai),true);
        if($this->ceklistglpinjam){
            $criteria->compare('DATE(tglpinjampeg)', strtolower($this->tglpinjampeg));
        }
        if($this->ceklis){
            $criteria->compare('DATE(tgljatuhtempo)', strtolower($this->tgljatuhtempo));
        }
        
        $criteria->limit=-1;

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'pagination'=>false
        ));
    }
}