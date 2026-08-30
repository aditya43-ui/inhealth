<?php

/**
 * This is the model class for table "informasiumurpiutangpenjamin_v".
 *
 * The followings are the available columns in table 'informasiumurpiutangpenjamin_v':
 * @property integer $pengajuanklaimpiutang_id
 * @property string $tglpengajuanklaimanklaim
 * @property string $nopengajuanklaimanklaim
 * @property double $totalpiutang
 * @property integer $lama_piutang
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $nama_pasien
 * @property string $namadepan
 * @property double $totalsisapiutang
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 */
class InformasiumurpiutangpenjaminV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasiumurpiutangpenjaminV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'informasiumurpiutangpenjamin_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pengajuanklaimpiutang_id, lama_piutang, pasien_id, penjamin_id, carabayar_id, pembayarklaim_id', 'numerical', 'integerOnly'=>true),
			array('totalpiutang, totalsisapiutang, totalbayar', 'numerical'),
			array('nopengajuanklaimanklaim, nama_pasien, penjamin_nama, carabayar_nama', 'length', 'max'=>50),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('namadepan', 'length', 'max'=>20),
			array('tglpengajuanklaimanklaim', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pengajuanklaimpiutang_id, tglpengajuanklaimanklaim, nopengajuanklaimanklaim, totalpiutang, lama_piutang, pasien_id, no_rekam_medik, nama_pasien, namadepan, totalsisapiutang, penjamin_id, penjamin_nama, carabayar_id, carabayar_nama, pembayarklaim_id, totalbayar', 'safe', 'on'=>'search'),
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
			'pengajuanklaimpiutang_id' => 'Pengajuanklaimpiutang',
			'tglpengajuanklaimanklaim' => 'Tanggal Pengajuan Klaim',
			'nopengajuanklaimanklaim' => 'No. Pengajuan Klaim',
			'totalpiutang' => 'Totalpiutang',
			'lama_piutang' => 'Lama Piutang',
			'pasien_id' => 'Pasien',
			'no_rekam_medik' => 'No. Rekam Medik',
			'nama_pasien' => 'Nama Pasien',
			'namadepan' => 'Namadepan',
			'totalsisapiutang' => 'Totalsisapiutang',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin Nama',
			'carabayar_id' => 'Jenis Penjamin',
			'carabayar_nama' => 'Carabayar Nama',
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

		$criteria->compare('pengajuanklaimpiutang_id',$this->pengajuanklaimpiutang_id);
		$criteria->compare('tglpengajuanklaimanklaim',$this->tglpengajuanklaimanklaim,true);
		$criteria->compare('nopengajuanklaimanklaim',$this->nopengajuanklaimanklaim,true);
		$criteria->compare('totalpiutang',$this->totalpiutang);
		$criteria->compare('lama_piutang',$this->lama_piutang);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('namadepan',$this->namadepan,true);
		$criteria->compare('totalsisapiutang',$this->totalsisapiutang);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('penjamin_nama',$this->penjamin_nama,true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('carabayar_nama',$this->carabayar_nama,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}