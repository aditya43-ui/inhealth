<?php

/**
 * This is the model class for table "informasijurnaltransaksi_v".
 *
 * The followings are the available columns in table 'informasijurnaltransaksi_v':
 * @property integer $jenisjurnal_id
 * @property string $jenisjurnal_nama
 * @property integer $rekperiod_id
 * @property string $tglbuktijurnal
 * @property string $nobuktijurnal
 * @property string $kodejurnal
 * @property string $noreferensi
 * @property string $tglreferensi
 * @property integer $nobku
 * @property string $urianjurnal
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $jurnalposting_id
 * @property string $tgljurnalpost
 * @property string $keterangan
 * @property integer $rekening1_id
 * @property string $kdrekening1
 * @property string $nmrekening1
 * @property integer $rekening2_id
 * @property string $kdrekening2
 * @property string $nmrekening2
 * @property integer $rekening3_id
 * @property string $kdrekening3
 * @property string $nmrekening3
 * @property integer $rekening4_id
 * @property string $kdrekening4
 * @property string $nmrekening4
 * @property integer $rekening5_id
 * @property string $kdrekening5
 * @property string $nmrekening5
 * @property integer $tiperekening_id
 * @property string $nourut
 * @property string $uraiantransaksi
 * @property double $saldodebit
 * @property double $saldokredit
 * @property boolean $koreksi
 * @property string $catatan
 */
class InformasijurnaltransaksiV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasijurnaltransaksiV the static model class
	 */
        public $jurnaldetail_id;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'informasijurnaltransaksi_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenisjurnal_id, rekperiod_id, nobku, jurnalposting_id, rekening1_id, rekening2_id, rekening3_id, rekening4_id, rekening5_id, tiperekening_id', 'numerical', 'integerOnly'=>true),
			array('saldodebit, saldokredit', 'numerical'),
			array('jenisjurnal_nama, nmrekening1, uraiantransaksi', 'length', 'max'=>100),
			array('nobuktijurnal', 'length', 'max'=>50),
			array('kodejurnal', 'length', 'max'=>20),
			array('kdrekening1, kdrekening2, kdrekening3, kdrekening4, kdrekening5', 'length', 'max'=>5),
			array('nmrekening2', 'length', 'max'=>200),
			array('nmrekening3', 'length', 'max'=>300),
			array('nmrekening4', 'length', 'max'=>400),
			array('nmrekening5', 'length', 'max'=>500),
			array('nourut', 'length', 'max'=>3),
			array('tglbuktijurnal, noreferensi, tglreferensi, urianjurnal, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tgljurnalpost, keterangan, koreksi, catatan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tgl_awal, tgl_akhir, jenisjurnal_id, jenisjurnal_nama, rekperiod_id, tglbuktijurnal, nobuktijurnal, kodejurnal, noreferensi, tglreferensi, nobku, urianjurnal, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, jurnalposting_id, tgljurnalpost, keterangan, rekening1_id, kdrekening1, nmrekening1, rekening2_id, kdrekening2, nmrekening2, rekening3_id, kdrekening3, nmrekening3, rekening4_id, kdrekening4, nmrekening4, rekening5_id, kdrekening5, nmrekening5, tiperekening_id, nourut, uraiantransaksi, saldodebit, saldokredit, koreksi, catatan', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'jenisjurnal_id' => 'Jenisjurnal',
			'jenisjurnal_nama' => 'Jenisjurnal Nama',
			'rekperiod_id' => 'Rekperiod',
			'tglbuktijurnal' => 'Tglbuktijurnal',
			'nobuktijurnal' => 'No. Bukti Jurnal',
			'kodejurnal' => 'Kode Jurnal',
			'noreferensi' => 'Noreferensi',
			'tglreferensi' => 'Tglreferensi',
			'nobku' => 'Nobku',
			'urianjurnal' => 'Urianjurnal',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'jurnalposting_id' => 'Jurnalposting',
			'tgljurnalpost' => 'Tgljurnalpost',
			'keterangan' => 'Keterangan',
			'rekening1_id' => 'Rekening1',
			'kdrekening1' => 'Kdrekening1',
			'nmrekening1' => 'Nmrekening1',
			'rekening2_id' => 'Rekening2',
			'kdrekening2' => 'Kdrekening2',
			'nmrekening2' => 'Nmrekening2',
			'rekening3_id' => 'Rekening3',
			'kdrekening3' => 'Kdrekening3',
			'nmrekening3' => 'Nmrekening3',
			'rekening4_id' => 'Rekening4',
			'kdrekening4' => 'Kdrekening4',
			'nmrekening4' => 'Nmrekening4',
			'rekening5_id' => 'Rekening5',
			'kdrekening5' => 'Kdrekening5',
			'nmrekening5' => 'Nmrekening5',
			'tiperekening_id' => 'Tiperekening',
			'nourut' => 'Nourut',
			'uraiantransaksi' => 'Uraiantransaksi',
			'saldodebit' => 'Saldodebit',
			'saldokredit' => 'Saldokredit',
			'koreksi' => 'Koreksi',
			'catatan' => 'Catatan',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('jenisjurnal_id',$this->jenisjurnal_id);
		$criteria->compare('LOWER(jenisjurnal_nama)',strtolower($this->jenisjurnal_nama),true);
		$criteria->compare('rekperiod_id',$this->rekperiod_id);
		$criteria->compare('LOWER(tglbuktijurnal)',strtolower($this->tglbuktijurnal),true);
		$criteria->compare('LOWER(nobuktijurnal)',strtolower($this->nobuktijurnal),true);
		$criteria->compare('LOWER(kodejurnal)',strtolower($this->kodejurnal),true);
		$criteria->compare('LOWER(noreferensi)',strtolower($this->noreferensi),true);
		$criteria->compare('LOWER(tglreferensi)',strtolower($this->tglreferensi),true);
		$criteria->compare('nobku',$this->nobku);
		$criteria->compare('LOWER(urianjurnal)',strtolower($this->urianjurnal),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('jurnalposting_id',$this->jurnalposting_id);
		$criteria->compare('LOWER(tgljurnalpost)',strtolower($this->tgljurnalpost),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
		$criteria->compare('rekening1_id',$this->rekening1_id);
		$criteria->compare('LOWER(kdrekening1)',strtolower($this->kdrekening1),true);
		$criteria->compare('LOWER(nmrekening1)',strtolower($this->nmrekening1),true);
		$criteria->compare('rekening2_id',$this->rekening2_id);
		$criteria->compare('LOWER(kdrekening2)',strtolower($this->kdrekening2),true);
		$criteria->compare('LOWER(nmrekening2)',strtolower($this->nmrekening2),true);
		$criteria->compare('rekening3_id',$this->rekening3_id);
		$criteria->compare('LOWER(kdrekening3)',strtolower($this->kdrekening3),true);
		$criteria->compare('LOWER(nmrekening3)',strtolower($this->nmrekening3),true);
		$criteria->compare('rekening4_id',$this->rekening4_id);
		$criteria->compare('LOWER(kdrekening4)',strtolower($this->kdrekening4),true);
		$criteria->compare('LOWER(nmrekening4)',strtolower($this->nmrekening4),true);
		$criteria->compare('rekening5_id',$this->rekening5_id);
		$criteria->compare('LOWER(kdrekening5)',strtolower($this->kdrekening5),true);
		$criteria->compare('LOWER(nmrekening5)',strtolower($this->nmrekening5),true);
		$criteria->compare('tiperekening_id',$this->tiperekening_id);
		$criteria->compare('LOWER(nourut)',strtolower($this->nourut),true);
		$criteria->compare('LOWER(uraiantransaksi)',strtolower($this->uraiantransaksi),true);
		$criteria->compare('saldodebit',$this->saldodebit);
		$criteria->compare('saldokredit',$this->saldokredit);
		$criteria->compare('koreksi',$this->koreksi);
		$criteria->compare('LOWER(catatan)',strtolower($this->catatan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('jenisjurnal_id',$this->jenisjurnal_id);
		$criteria->compare('LOWER(jenisjurnal_nama)',strtolower($this->jenisjurnal_nama),true);
		$criteria->compare('rekperiod_id',$this->rekperiod_id);
		$criteria->compare('LOWER(tglbuktijurnal)',strtolower($this->tglbuktijurnal),true);
		$criteria->compare('LOWER(nobuktijurnal)',strtolower($this->nobuktijurnal),true);
		$criteria->compare('LOWER(kodejurnal)',strtolower($this->kodejurnal),true);
		$criteria->compare('LOWER(noreferensi)',strtolower($this->noreferensi),true);
		$criteria->compare('LOWER(tglreferensi)',strtolower($this->tglreferensi),true);
		$criteria->compare('nobku',$this->nobku);
		$criteria->compare('LOWER(urianjurnal)',strtolower($this->urianjurnal),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('jurnalposting_id',$this->jurnalposting_id);
		$criteria->compare('LOWER(tgljurnalpost)',strtolower($this->tgljurnalpost),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
		$criteria->compare('rekening1_id',$this->rekening1_id);
		$criteria->compare('LOWER(kdrekening1)',strtolower($this->kdrekening1),true);
		$criteria->compare('LOWER(nmrekening1)',strtolower($this->nmrekening1),true);
		$criteria->compare('rekening2_id',$this->rekening2_id);
		$criteria->compare('LOWER(kdrekening2)',strtolower($this->kdrekening2),true);
		$criteria->compare('LOWER(nmrekening2)',strtolower($this->nmrekening2),true);
		$criteria->compare('rekening3_id',$this->rekening3_id);
		$criteria->compare('LOWER(kdrekening3)',strtolower($this->kdrekening3),true);
		$criteria->compare('LOWER(nmrekening3)',strtolower($this->nmrekening3),true);
		$criteria->compare('rekening4_id',$this->rekening4_id);
		$criteria->compare('LOWER(kdrekening4)',strtolower($this->kdrekening4),true);
		$criteria->compare('LOWER(nmrekening4)',strtolower($this->nmrekening4),true);
		$criteria->compare('rekening5_id',$this->rekening5_id);
		$criteria->compare('LOWER(kdrekening5)',strtolower($this->kdrekening5),true);
		$criteria->compare('LOWER(nmrekening5)',strtolower($this->nmrekening5),true);
		$criteria->compare('tiperekening_id',$this->tiperekening_id);
		$criteria->compare('LOWER(nourut)',strtolower($this->nourut),true);
		$criteria->compare('LOWER(uraiantransaksi)',strtolower($this->uraiantransaksi),true);
		$criteria->compare('saldodebit',$this->saldodebit);
		$criteria->compare('saldokredit',$this->saldokredit);
		$criteria->compare('koreksi',$this->koreksi);
		$criteria->compare('LOWER(catatan)',strtolower($this->catatan),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}