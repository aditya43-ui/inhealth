<?php

/**
 * This is the model class for table "bukubesar_t".
 *
 * The followings are the available columns in table 'bukubesar_t':
 * @property integer $bukubesar_id
 * @property integer $rekening3_id
 * @property integer $rekening4_id
 * @property integer $rekening2_id
 * @property integer $rekening5_id
 * @property integer $rekening1_id
 * @property string $tglbukubesar
 * @property string $uraiantransaksi
 * @property double $saldodebit
 * @property double $saldokredit
 * @property double $saldoakhirberjalan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property string $no_referensi
 * @property integer $periodeposting_id
 *
 * The followings are the available model relations:
 * @property LaporanlabarugidetailR[] $laporanlabarugidetailRs
 * @property JurnalrekeningT[] $jurnalrekeningTs
 * @property JurnalpostingT[] $jurnalpostingTs
 * @property LaporanperubahanmodaldetailR[] $laporanperubahanmodaldetailRs
 * @property PeriodepostingM $periodeposting
 * @property Rekening1M $rekening1
 * @property Rekening2M $rekening2
 * @property Rekening3M $rekening3
 * @property Rekening4M $rekening4
 * @property Rekening5M $rekening5
 */
class AKBukubesarT extends BukubesarT
{
	public $rekperiode_id;
        
        public $tgl_awal, $tgl_akhir, $kdrekening5, $jenisjurnal_nama, $urianjurnal, $kodejurnal;
        public $checkodd;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BukubesarT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchLaporanOrafin(){
            $criteria=new CDbCriteria;
            $criteria->select = "t.bukubesar_id, t.tglbukubesar, t.saldodebit, t.saldokredit, t.update_time, t.no_referensi, t.jurnalposting_id, rekening5_m.kdrekening5, rekening5_m.nmrekening5,jurnalrekening_t.urianjurnal, jenisjurnal_m.jenisjurnal_nama, jurnalrekening_t.kodejurnal";
            $criteria->join = " JOIN rekening5_m ON rekening5_m.rekening5_id = t.rekening5_id"
                    . " LEFT JOIN jurnalposting_t ON jurnalposting_t.jurnalposting_id=t.jurnalposting_id"
                    . " LEFT JOIN jurnaldetail_t ON jurnaldetail_t.jurnaldetail_id = jurnalposting_t.jurnaldetail_id"
                    . " LEFT JOIN jurnalrekening_t ON jurnalrekening_t.jurnalrekening_id = jurnaldetail_t.jurnalrekening_id"
                    . " LEFT JOIN jenisjurnal_m ON jenisjurnal_m.jenisjurnal_id = jurnalrekening_t.jenisjurnal_id";
            
            $criteria->addBetweenCondition('DATE(t.tglbukubesar)', $this->tgl_awal, $this->tgl_akhir);
            $criteria->order = 'jurnalrekening_t.nobuktijurnal,jurnaldetail_t.nourut';
           return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
        }
        
        public function searchLaporanOrafinPrint(){
            $criteria=new CDbCriteria;
            $criteria->select = "t.bukubesar_id, t.tglbukubesar, t.saldodebit, t.saldokredit, t.update_time, t.no_referensi, t.jurnalposting_id, rekening5_m.kdrekening5, rekening5_m.nmrekening5,jurnalrekening_t.urianjurnal, jenisjurnal_m.jenisjurnal_nama, jurnalrekening_t.kodejurnal";
            $criteria->join = " JOIN rekening5_m ON rekening5_m.rekening5_id = t.rekening5_id"
                    . " LEFT JOIN jurnalposting_t ON jurnalposting_t.jurnalposting_id=t.jurnalposting_id"
                    . " LEFT JOIN jurnaldetail_t ON jurnaldetail_t.jurnaldetail_id = jurnalposting_t.jurnaldetail_id"
                    . " LEFT JOIN jurnalrekening_t ON jurnalrekening_t.jurnalrekening_id = jurnaldetail_t.jurnalrekening_id"
                    . " LEFT JOIN jenisjurnal_m ON jenisjurnal_m.jenisjurnal_id = jurnalrekening_t.jenisjurnal_id";
            
            $criteria->addBetweenCondition('DATE(t.tglbukubesar)', $this->tgl_awal, $this->tgl_akhir);
            $criteria->order = 'jurnalrekening_t.nobuktijurnal,jurnaldetail_t.nourut';
            
           return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
                                'pagination'=>false
		));
        }
}