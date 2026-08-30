<?php

/**
 * This is the model class for table "distribusidarah_t".
 * The followings are the available columns in table 'distribusidarah_t':
 * @property integer $distribusidarah_id
 * @property integer $petugasdistribusi_id
 * @property integer $petugaskoordinator_id
 * @property integer $instalasi_id
 * @property integer $terimadistribusidarah_id
 * @property integer $ruangan_id
 * @property string $nomor_pengiriman
 * @property integer $jumlah_kantongdarah
 * @property string $tgl_distribusi
 * @property string $shift_distribusi
 * @property string $ketrangan_distribusi
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * 
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 * @package application.models
 * @category model
 */
class DistribusidarahT extends CActiveRecord
{
    public $nama_pegawai, $petugasdistribusi_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DistribusidarahT the static model class
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
		return 'distribusidarah_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('petugasdistribusi_id, petugaskoordinator_id, instalasi_id, terimadistribusidarah_id, ruangan_id, jumlah_kantongdarah', 'numerical', 'integerOnly'=>true),
			array('nomor_pengiriman', 'length', 'max'=>100),
			array('shift_distribusi', 'length', 'max'=>50),
			array('tgl_distribusi, ketrangan_distribusi, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('distribusidarah_id, petugasdistribusi_id, petugaskoordinator_id, instalasi_id, terimadistribusidarah_id, ruangan_id, nomor_pengiriman, jumlah_kantongdarah, tgl_distribusi, shift_distribusi, ketrangan_distribusi, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
			array('petugasdistribusi_id, petugaskoordinator_id, instalasi_id, terimadistribusidarah_id, ruangan_id, jumlah_kantongdarah', 'numerical', 'integerOnly'=>true),
			array('nomor_pengiriman', 'length', 'max'=>100),
			array('shift_distribusi', 'length', 'max'=>50),
			array('tgl_distribusi, ketrangan_distribusi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('distribusidarah_id, petugasdistribusi_id, petugaskoordinator_id, instalasi_id, terimadistribusidarah_id, ruangan_id, nomor_pengiriman, jumlah_kantongdarah, tgl_distribusi, shift_distribusi, ketrangan_distribusi', 'safe', 'on'=>'search'),
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
			'distribusidarah_id' => 'Distribusidarah',
			'petugasdistribusi_id' => 'Petugasdistribusi',
			'petugaskoordinator_id' => 'Petugaskoordinator',
			'petugasdistribusi_id' => 'Petugas Distribusi Pelayanan Donor',
			'petugaskoordinator_id' => 'Koordinator Pelayanan Donor',
			'instalasi_id' => 'Instalasi',
			'terimadistribusidarah_id' => 'Terimadistribusidarah',
			'ruangan_id' => 'Ruangan',
			'nomor_pengiriman' => 'Nomor Pengiriman',
			'jumlah_kantongdarah' => 'Jumlah Kantongdarah',
			'tgl_distribusi' => 'Tgl Distribusi',
			'shift_distribusi' => 'Shift Distribusi',
			'ketrangan_distribusi' => 'Ketrangan Distribusi',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'ketrangan_distribusi' => 'Keterangan Distribusi',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch() {
                $criteria=new CDbCriteria;

		if(!empty($this->distribusidarah_id)){
			$criteria->addCondition('distribusidarah_id = '.$this->distribusidarah_id);
		}
		if(!empty($this->petugasdistribusi_id)){
			$criteria->addCondition('petugasdistribusi_id = '.$this->petugasdistribusi_id);
		}
		if(!empty($this->petugaskoordinator_id)){
			$criteria->addCondition('petugaskoordinator_id = '.$this->petugaskoordinator_id);
		}
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		if(!empty($this->terimadistribusidarah_id)){
			$criteria->addCondition('terimadistribusidarah_id = '.$this->terimadistribusidarah_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(nomor_pengiriman)',strtolower($this->nomor_pengiriman),true);
		if(!empty($this->jumlah_kantongdarah)){
			$criteria->addCondition('jumlah_kantongdarah = '.$this->jumlah_kantongdarah);
		}
                $criteria->compare('distribusidarah_id',$this->distribusidarah_id);
		$criteria->compare('petugasdistribusi_id',$this->petugasdistribusi_id);
		$criteria->compare('petugaskoordinator_id',$this->petugaskoordinator_id);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('terimadistribusidarah_id',$this->terimadistribusidarah_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('nomor_pengiriman',$this->nomor_pengiriman,true);
		$criteria->compare('jumlah_kantongdarah',$this->jumlah_kantongdarah);
		$criteria->compare('tgl_distribusi',$this->tgl_distribusi,true);
		$criteria->compare('shift_distribusi',$this->shift_distribusi,true);
		$criteria->compare('ketrangan_distribusi',$this->ketrangan_distribusi,true);

		return $criteria;
	}
        
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function search()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }

        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function searchDialog()
        {
            
            $criteria=new CDbCriteria();
            $criteria->select = 't.*,p.pegawai_id,p.nama_pegawai';
            $criteria->join ='LEFT JOIN pegawai_m p ON t.petugasdistribusi_id  = p.pegawai_id';
		if(!empty($this->distribusidarah_id)){
			$criteria->addCondition('t.distribusidarah_id = '.$this->distribusidarah_id);
		}
		if(!empty($this->petugasdistribusi_id)){
			$criteria->addCondition('t.petugasdistribusi_id = '.$this->petugasdistribusi_id);
		}
		if(!empty($this->petugaskoordinator_id)){
			$criteria->addCondition('t.petugaskoordinator_id = '.$this->petugaskoordinator_id);
		}
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('t.instalasi_id = '.$this->instalasi_id);
		}
		if(!empty($this->terimadistribusidarah_id)){
			$criteria->addCondition('t.terimadistribusidarah_id = '.$this->terimadistribusidarah_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('t.ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(t.nomor_pengiriman)',strtolower($this->nomor_pengiriman),true);
		if(!empty($this->jumlah_kantongdarah)){
			$criteria->addCondition('t.jumlah_kantongdarah = '.$this->jumlah_kantongdarah);
		}
                $criteria->compare('LOWER(p.nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(t.tgl_distribusi)',strtolower($this->tgl_distribusi),true);
		$criteria->compare('LOWER(t.shift_distribusi)',strtolower($this->shift_distribusi),true);
		$criteria->compare('LOWER(t.ketrangan_distribusi)',strtolower($this->ketrangan_distribusi),true);
		$criteria->compare('LOWER(t.create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(t.update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(t.create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(t.update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(t.create_ruangan)',strtolower($this->create_ruangan),true);
                
                return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
                ));
        }	
    
    /**
     * 
     * Simpan data yang di-submit ke tabel distribusidarah_t dan distribusidarahdet_t.
     * Jika data distribusidarahdet_t disimpan maka akan di-insert ID-nya ke tabel
     * Kantong Darah.
     * 
     * @param  mixed   $post data $_POST
     * @return boolean true jika Transaksi berhasil, false jika tidak.
     */
    public function saveDistribusiDarah($post) {
        $ok = true;
        
        $this->attributes = $post['DistribusidarahT'];
        $this->tgl_distribusi = MyFormatter::formatDateTimeForDB($this->tgl_distribusi);
        $this->nomor_pengiriman = MyGenerator::noDistribusiDarah();
        $this->jumlah_kantongdarah = count($_POST['detail']);
        $this->create_time = date('Y-m-d H:i:s');
        $this->create_loginpemakai_id = Yii::app()->user->id;
        $this->create_ruangan = Yii::app()->user->getState('ruangan_id');
        
        
        if ($this->validate()) {
            $ok = $ok && $this->save();
        } else  {
            $ok = false;
        }
        
        // simpan detail
        foreach ($post['detail'] as $kantongdarah_id => $item) {
            $detail = new DistribusidarahdetT;
            $detail->attributes = $item;
            $detail->distribusidarah_id = $this->distribusidarah_id;
            
            if ($detail->validate()) {
                $ok = $ok && $detail->save();
                KantongdarahT::model()->updateByPk($kantongdarah_id, array(
                    'distribusidarah_id'=>$this->distribusidarah_id,
                    'distribusidarahdet_id'=>$detail->distribusidarahdet_id,
                ));
                
                
                $stok = StokkantongdarahT::model()->findByAttributes(array(
                    'kantongdarah_id'=>$kantongdarah_id,
                ));
                
                if (!empty($stok)) {
                    $stok->distribusidarah_id = $this->distribusidarah_id;
                    $stok->distribusidarahdet_id = $detail->distribusidarahdet_id;
                    $stok->save();
                }
                
            } else {
                $ok = false;
            }
        }
        
        return $ok;
    }
}