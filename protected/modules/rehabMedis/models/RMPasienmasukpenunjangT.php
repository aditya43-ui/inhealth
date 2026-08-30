<?php
/**
 * model utama untuk mengakses tabel pasienmasukpenunjang_t, hanya untuk di modul rehab medis
 * 
 * @package application.modules.rehabMedis
 * @subpackage models
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0 
 * @link    <http://piindonesia.co.id>
 */
class RMPasienmasukpenunjangT extends PasienmasukpenunjangT{
    
    public $is_adakarcis = 0;
    public $pasienmasukpenunjang;
    public $no_pendaftaran;
    public $namadepan;
    public $nama_pegawai;
    public $nama_ppds;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PasienmasukpenunjangT the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    protected function beforeValidate ()
    {
        // convert to storage format
        //$this->tglrevisimodul = date ('Y-m-d', strtotime($this->tglrevisimodul));
        $format = new MyFormatter();
        foreach($this->metadata->tableSchema->columns as $columnName => $column){
                if ($column->dbType == 'date'){
                        $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                }elseif ($column->dbType == 'timestamp without time zone'){
                        //$this->$columnName = date('Y-m-d H:i:s', CDateTimeParser::parse($this->$columnName, Yii::app()->locale->dateFormat));
                        $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                }
        }

        return parent::beforeValidate ();
    }
	
	public function searchDashboardRM() {
		$criteria = new CDbCriteria();
		$criteria->select = 't.tglmasukpenunjang,t.no_masukpenunjang, pasien_m.no_rekam_medik,pendaftaran_t.no_pendaftaran,pasien_m.nama_pasien,pendaftaran_t.umur,pasien_m.jeniskelamin';
		$criteria->join = 'JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id=t.pendaftaran_id
JOIN pasien_m ON pasien_m.pasien_id=t.pasien_id
JOIN ruangan_m ON ruangan_m.ruangan_id=t.ruangan_id
JOIN instalasi_m ON instalasi_m.instalasi_id=ruangan_m.instalasi_id';
		$criteria->addCondition('instalasi_m.instalasi_id=8');
		$criteria->group = 'pendaftaran_t.no_pendaftaran,t.tglmasukpenunjang, t.no_masukpenunjang, pasien_m.no_rekam_medik,pasien_m.nama_pasien,pendaftaran_t.umur,pasien_m.jeniskelamin';
		$criteria->order = 't.tglmasukpenunjang DESC';
		$criteria->limit = 10;
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
		
	}
}
?>
