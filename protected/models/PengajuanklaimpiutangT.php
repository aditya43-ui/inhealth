<?php

/**
 * This is the model class for table "pengajuanklaimpiutang_t".
 *
 * The followings are the available columns in table 'pengajuanklaimpiutang_t':
 * @property integer $pengajuanklaimpiutang_id
 * @property integer $carabayar_id
 * @property integer $penjamin_id
 * @property string $tglpengajuanklaimanklaim
 * @property string $nopengajuanklaimanklaim
 * @property double $totalpiutang
 * @property double $totalsisapiutang
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 *
 * The followings are the available model relations:
 * @property PengajuanklaimdetailT[] $pengajuanklaimdetailTs
 * @property PembayarklaimT[] $pembayarklaimTs
 * @property CarabayarM $carabayar
 * @property PenjaminpasienM $penjamin
 */
class PengajuanklaimpiutangT extends CActiveRecord
{
	public $carabayar_nama, $penjamin_nama, $tlhdibayar, $tgl_awal, $tgl_akhir, $checklist;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengajuanklaimpiutangT the static model class
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
		return 'pengajuanklaimpiutang_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('totalbayar, totaldiskon, carabayar_id, penjamin_id, tglpengajuanklaimanklaim, nopengajuanklaimanklaim', 'required'),
			array('carabayar_id, penjamin_id, tandabuktikeluar_id', 'numerical', 'integerOnly'=>true),
			array('totalpiutang, totalsisapiutang', 'numerical'),
			array('nopengajuanklaimanklaim, noinvoice', 'length', 'max'=>50),
			array('kiriminvoice_nama', 'length', 'max'=>100),
			array('create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, kiriminvoice_ket, kiriminvoice_tgl', 'safe'),
                        array('create_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pengajuanklaimpiutang_id, carabayar_id, penjamin_id, tglpengajuanklaimanklaim, nopengajuanklaimanklaim, totalpiutang, totalsisapiutang, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, noinvoice, kiriminvoice_nama, kiriminvoice_ket, kiriminvoice_tgl, tandabuktikeluar_id', 'safe', 'on'=>'search'),
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
			'pengajuanklaimdetailTs' => array(self::HAS_MANY, 'PengajuanklaimdetailT', 'pengajuanklaimpiutang_id'),
			'pembayarklaimTs' => array(self::HAS_MANY, 'PembayarklaimT', 'pengajuanklaimpiutang_id'),
			'carabayar' => array(self::BELONGS_TO, 'CarabayarM', 'carabayar_id'),
			'penjamin' => array(self::BELONGS_TO, 'PenjaminpasienM', 'penjamin_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pengajuanklaimpiutang_id' => 'Pengajuanklaimpiutang',
			'carabayar_id' => 'Jenis Penjamin',
			'penjamin_id' => 'Penjamin',
			'tglpengajuanklaimanklaim' => 'Tglpengajuanklaimanklaim',
			'nopengajuanklaimanklaim' => 'Nopengajuanklaimanklaim',
			'totalpiutang' => 'Totalpiutang',
			'totalsisapiutang' => 'Totalsisapiutang',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria->compare('t.pengajuanklaimpiutang_id',$this->pengajuanklaimpiutang_id);
		$criteria->compare('t.carabayar_id',$this->carabayar_id);
		$criteria->compare('t.penjamin_id',$this->penjamin_id);
		$criteria->compare('t.tglpengajuanklaimanklaim',$this->tglpengajuanklaimanklaim,true);
		$criteria->compare('t.nopengajuanklaimanklaim',$this->nopengajuanklaimanklaim,true);
		$criteria->compare('t.totalpiutang',$this->totalpiutang);
		$criteria->compare('t.totalsisapiutang',$this->totalsisapiutang);
		$criteria->compare('t.create_time',$this->create_time,true);
		$criteria->compare('t.update_time',$this->update_time,true);
		$criteria->compare('t.create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('t.update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('t.create_ruangan',$this->create_ruangan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
