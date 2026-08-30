<?php
class SAOrganigramM extends OrganigramM
{
	public $tgl_awal,$tgl_akhir;
	public $nama_pegawai;
	public $jabatan_nama;
	public $atasan; //organigram asal
        public $pegawai_id;
        public $jabatan_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrganigramM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchTable()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$format = new MyFormatter;
		$criteria = new CDbCriteria();
		//$criteria->with = array('pegawai','organigramasal');
		$criteria->join = " LEFT JOIN organigram_m o ON o.organigram_id = t.organigramasal_id  "
						. " LEFT JOIN pegawai_m po ON po.pegawai_id = o.pegawai_id "
						. "	LEFT JOIN pegawai_m p ON p.pegawai_id = t.pegawai_id ";
		$criteria->compare('LOWER(t.organigram_kode)',  strtolower($this->organigram_kode), true);
		$criteria->compare('LOWER(t.organigram_unitkerja)',  strtolower($this->organigram_unitkerja), true);
		$criteria->compare('t.organigram_formasi', $this->organigram_formasi);
		//$criteria->compare('LOWER(t.organigramasal.pegawai.nama_pegawai)',  strtolower($this->atasan), true);
		//$criteria->compare('LOWER(t.organigramasal.organigram_unitkerja)',  strtolower($this->atasan), true, "OR");
		$criteria->compare('LOWER(p.nama_pegawai)',  strtolower($this->nama_pegawai), true);
		$criteria->compare('LOWER(po.nama_pegawai)',  strtolower($this->atasan), true);
		$criteria->compare('t.jabatan_id',  $this->jabatan_id);                
		$criteria->compare('LOWER(t.organigram_pelaksanakerja)',  strtolower($this->organigram_pelaksanakerja), true);
		$criteria->compare('DATE(t.organigram_periode)',$format->formatDateTimeForDb($this->organigram_periode));
		$criteria->compare('DATE(t.organigram_sampaidengan)',$format->formatDateTimeForDb($this->organigram_sampaidengan));
                $criteria->compare('(t.organigram_aktif)', $this->organigram_aktif);
		$criteria->limit = 10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
                                 'sort' => array(
                                        'attributes' => array(
                                              'nama_pegawai' => array(
                                                    'ASC' => 'pegawai.nama_pegawai ASC',
                                                    'DESC' => 'pegawai.nama_pegawai DESC',
                                                ),
                            ),
                        ),
		));
	}
        
         public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

           // Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$format = new MyFormatter;
		$criteria = new CDbCriteria();
		$criteria->with = array('pegawai','organigramasal');
		$criteria->compare('LOWER(t.organigram_kode)',  strtolower($this->organigram_kode), true);
		$criteria->compare('LOWER(t.organigram_unitkerja)',  strtolower($this->organigram_unitkerja), true);
		$criteria->compare('t.organigram_formasi', $this->organigram_formasi, true);
		$criteria->compare('LOWER(t.organigramasal.pegawai.nama_pegawai)',  strtolower($this->atasan), true);
		$criteria->compare('LOWER(t.organigramasal.organigram_unitkerja)',  strtolower($this->atasan), true, "OR");
		$criteria->compare('LOWER(pegawai.nama_pegawai)',  strtolower($this->nama_pegawai), true);
		$criteria->compare('t.jabatan_id',  $this->jabatan_id);                
		$criteria->compare('LOWER(t.organigram_pelaksanakerja)',  strtolower($this->organigram_pelaksanakerja), true);
		$criteria->compare('DATE(t.organigram_periode)',$format->formatDateTimeForDb($this->organigram_periode));
		$criteria->compare('DATE(t.organigram_sampaidengan)',$format->formatDateTimeForDb($this->organigram_sampaidengan));
                //$criteria->compare('(t.organigram_aktif)', $this->organigram_aktif);
		$criteria->limit = -1;
                
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
        
        public function getJabatan()
        {
            return isset($this->jabatan_id)?$this->jabatan->jabatan_nama:"-";
        }
}