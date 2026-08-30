<?php

class AGLaporanrealisasianggaranpengeluaranV extends LaporanrealisasianggaranpengeluaranV {
	public $tgl_awal,$tgl_akhir,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'rencanggaranpeng_id' => 'Rencanggaranpeng',
			'rencanggaranpeng_no' => 'No. Anggaran Pengeluaran',
			'konfiganggaran_id' => 'Konfig Anggaran',
			'deskripsiperiode' => 'Deskripsi Periode',
			'rencanggaranpeng_tgl' => 'Tgl. Anggaran Pengeluaran',
			'unitkerja_id' => 'Unit Kerja',
			'namaunitkerja' => 'Unit Kerja',
			'total_nilairencpeng' => 'Total Nilai Rencana Pengaluaran',
			'rencanggaranpengdet_id' => 'Rencanggaranpengdet',
			'apprrencanggaran_id' => 'Apprrencanggaran',
			'nilaiygdisetujui' => 'Nilai Yang Disetujui',
		);
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchLaporan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('rencanggaranpeng_id',$this->rencanggaranpeng_id);
		$criteria->compare('rencanggaranpeng_no',$this->rencanggaranpeng_no,true);
		$criteria->compare('konfiganggaran_id',$this->konfiganggaran_id);
		$criteria->compare('deskripsiperiode',$this->deskripsiperiode,true);
		$criteria->addBetweenCondition('rencanggaranpeng_tgl', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('unitkerja_id',$this->unitkerja_id);
		$criteria->compare('namaunitkerja',$this->namaunitkerja,true);
		$criteria->compare('total_nilairencpeng',$this->total_nilairencpeng);
		$criteria->compare('rencanggaranpengdet_id',$this->rencanggaranpengdet_id);
		$criteria->compare('apprrencanggaran_id',$this->apprrencanggaran_id);
		$criteria->compare('nilaiygdisetujui',$this->nilaiygdisetujui);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
