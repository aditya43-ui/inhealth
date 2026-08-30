<?php

/**
 * This is the model class for table "pembayarklaim_t".
 *
 * The followings are the available columns in table 'pembayarklaim_t':
 * @property integer $pembayarklaim_id
 * @property integer $carabayar_id
 * @property integer $penjamin_id
 * @property string $tglpembayaranklaim
 * @property string $nopembayaranklaim
 * @property double $totalpiutang
 * @property double $totalbayar
 * @property double $telahbayar
 * @property double $totalsisapiutang
 * @property integer $bayarke
 * @property string $pembayaranmelalui
 * @property string $nobuktisetor
 * @property string $alamatpenyetor
 * @property string $namabank
 * @property string $norekbank
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class PembayarklaimT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PembayarklaimT the static model class
	 */
	public $tgl_awal,$tgl_akhir;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pembayarklaim_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('carabayar_id, penjamin_id, tglpembayaranklaim, nopembayaranklaim, totalpiutang, totalbayar, telahbayar, totalsisapiutang, pembayaranmelalui', 'required'),
			array('carabayar_id, penjamin_id, bayarke', 'numerical', 'integerOnly'=>true),
			array('totalpiutang, totalbayar, telahbayar, totalsisapiutang', 'numerical'),
			array('nopembayaranklaim', 'length', 'max'=>50),
			array('pembayaranmelalui, nobuktisetor, namabank, norekbank', 'length', 'max'=>100),
                        array('create_time,update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
			array('alamatpenyetor, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pembayarklaim_id, carabayar_id, penjamin_id, tglpembayaranklaim, nopembayaranklaim, totalpiutang, totalbayar, telahbayar, totalsisapiutang, bayarke, pembayaranmelalui, nobuktisetor, alamatpenyetor, namabank, norekbank, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'carabayar'=>array(self::BELONGS_TO,'CarabayarM','carabayar_id'),
			'penjamin'=>array(self::BELONGS_TO,'PenjaminpasienM','penjamin_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pembayarklaim_id' => 'Pembayaran Klaim',
			'carabayar_id' => 'Jenis Penjamin',
			'penjamin_id' => 'Penjamin',
			'tglpembayaranklaim' => 'Tanggal Pembayaran ',
			'nopembayaranklaim' => 'No. Pembayaran ',
			'totalpiutang' => 'Total Piutang',
			'totalbayar' => 'Total Bayar',
			'telahbayar' => 'Telah Bayar',
			'totalsisapiutang' => 'Total Sisa Piutang',
			'bayarke' => 'Bayar Ke',
			'pembayaranmelalui' => 'Pembayaran Melalui',
			'nobuktisetor' => 'No. Bukti Setor',
			'alamatpenyetor' => 'Alamat Penyetor',
			'namabank' => 'Nama Bank',
			'norekbank' => 'No. Rek. Pengirim',
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

		$criteria->compare('pembayarklaim_id',$this->pembayarklaim_id);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('LOWER(tglpembayaranklaim)',strtolower($this->tglpembayaranklaim),true);
		$criteria->compare('LOWER(nopembayaranklaim)',strtolower($this->nopembayaranklaim),true);
		$criteria->compare('totalpiutang',$this->totalpiutang);
		$criteria->compare('totalbayar',$this->totalbayar);
		$criteria->compare('telahbayar',$this->telahbayar);
		$criteria->compare('totalsisapiutang',$this->totalsisapiutang);
		$criteria->compare('bayarke',$this->bayarke);
		$criteria->compare('LOWER(pembayaranmelalui)',strtolower($this->pembayaranmelalui),true);
		$criteria->compare('LOWER(nobuktisetor)',strtolower($this->nobuktisetor),true);
		$criteria->compare('LOWER(alamatpenyetor)',strtolower($this->alamatpenyetor),true);
		$criteria->compare('LOWER(namabank)',strtolower($this->namabank),true);
		$criteria->compare('LOWER(norekbank)',strtolower($this->norekbank),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pembayarklaim_id',$this->pembayarklaim_id);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('LOWER(tglpembayaranklaim)',strtolower($this->tglpembayaranklaim),true);
		$criteria->compare('LOWER(nopembayaranklaim)',strtolower($this->nopembayaranklaim),true);
		$criteria->compare('totalpiutang',$this->totalpiutang);
		$criteria->compare('totalbayar',$this->totalbayar);
		$criteria->compare('telahbayar',$this->telahbayar);
		$criteria->compare('totalsisapiutang',$this->totalsisapiutang);
		$criteria->compare('bayarke',$this->bayarke);
		$criteria->compare('LOWER(pembayaranmelalui)',strtolower($this->pembayaranmelalui),true);
		$criteria->compare('LOWER(nobuktisetor)',strtolower($this->nobuktisetor),true);
		$criteria->compare('LOWER(alamatpenyetor)',strtolower($this->alamatpenyetor),true);
		$criteria->compare('LOWER(namabank)',strtolower($this->namabank),true);
		$criteria->compare('LOWER(norekbank)',strtolower($this->norekbank),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function getCaraBayarItems()
        {
            return CarabayarM::model()->findAllByAttributes(array('carabayar_aktif'=>true),array('order'=>'carabayar_nourut'));
        }
        
        
        /**
         * Mengambil daftar semua penjamin
         * @return CActiveDataProvider 
         */
        public function getPenjaminItems($carabayar_id=null)
        {
            if(!empty($carabayar_id))
                    return PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$carabayar_id,'penjamin_aktif'=>true),array('order'=>'penjamin_nama'));
            else
                    return array();
                    //return PenjaminpasienM::model()->findAllByAttributes(array('penjamin_aktif'=>true),array('order'=>'penjamin_nama'));
        }
}