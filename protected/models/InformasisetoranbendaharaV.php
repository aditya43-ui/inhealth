<?php

/**
 * This is the model class for table "informasisetoranbendahara_v".
 *
 * The followings are the available columns in table 'informasisetoranbendahara_v':
 * @property integer $setoranbdhara_id
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $pegawai_id
 * @property string $nama_pegawai
 * @property integer $setorbank_id
 * @property string $nostruksetor
 * @property string $tgldisetor
 * @property string $namabank
 * @property string $atasnama
 * @property string $norekening
 * @property double $jumlahsetoran
 * @property integer $ygmenyetor_id
 * @property string $nama_ygmenyetor
 * @property string $nosetoranbdhara
 * @property string $tglsetoranbdhara
 * @property integer $mengetahui_id
 * @property string $nama_mengetahui
 */
class InformasisetoranbendaharaV extends CActiveRecord
{
    public $tgl_awal, $tgl_akhir;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasisetoranbendaharaV the static model class
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
		return 'informasisetoranbendahara_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('setoranbdhara_id, ruangan_id, pegawai_id, setorbank_id, ygmenyetor_id, mengetahui_id', 'numerical', 'integerOnly'=>true),
			array('jumlahsetoran', 'numerical'),
			array('ruangan_nama, nama_pegawai, nama_ygmenyetor, nosetoranbdhara, nama_mengetahui', 'length', 'max'=>50),
			array('nostruksetor, namabank, atasnama, norekening', 'length', 'max'=>100),
			array('tgl_awal, tgl_akhir, tgldisetor, tglsetoranbdhara', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tgl_awal, tgl_akhir, setoranbdhara_id, ruangan_id, ruangan_nama, pegawai_id, nama_pegawai, setorbank_id, nostruksetor, tgldisetor, namabank, atasnama, norekening, jumlahsetoran, ygmenyetor_id, nama_ygmenyetor, nosetoranbdhara, tglsetoranbdhara, mengetahui_id, nama_mengetahui', 'safe', 'on'=>'search'),
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
			'setoranbdhara_id' => 'Setoranbdhara',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan',
			'pegawai_id' => 'Penyetor',
			'nama_pegawai' => 'Penyetor',
			'setorbank_id' => 'Bank',
			'nostruksetor' => 'No. Struk',
			'tgldisetor' => 'Tgl. Disetor',
			'namabank' => 'Bank',
			'atasnama' => 'Atas Nama',
			'norekening' => 'No. Rekening',
			'jumlahsetoran' => 'Jumlah Setoran',
			'ygmenyetor_id' => 'Penyetor',
			'nama_ygmenyetor' => 'Penyetor',
			'nosetoranbdhara' => 'No. Setoran',
			'tglsetoranbdhara' => 'Tgl. Setoran',
			'mengetahui_id' => 'Mengetahui',
			'nama_mengetahui' => 'Mengetahui',
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
                
		$criteria->compare('setoranbdhara_id',$this->setoranbdhara_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('setorbank_id',$this->setorbank_id);
		$criteria->compare('lower(nostruksetor)',strtolower($this->nostruksetor),true);
		$criteria->compare('tgldisetor',$this->tgldisetor,true);
		$criteria->compare('namabank',$this->namabank,true);
		$criteria->compare('atasnama',$this->atasnama,true);
		$criteria->compare('lower(norekening)',strtolower($this->norekening),true);
		$criteria->compare('jumlahsetoran',$this->jumlahsetoran);
		$criteria->compare('ygmenyetor_id',$this->ygmenyetor_id);
		$criteria->compare('nama_ygmenyetor',$this->nama_ygmenyetor,true);
		$criteria->compare('lower(nosetoranbdhara)',strtolower($this->nosetoranbdhara),true);
		//$criteria->compare('tglsetoranbdhara',$this->tglsetoranbdhara,true);
		$criteria->compare('mengetahui_id',$this->mengetahui_id);
		$criteria->compare('nama_mengetahui',$this->nama_mengetahui,true);
                 
                 
                if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
                            $criteria->addBetweenCondition('DATE(tglsetoranbdhara)', $this->tgl_awal, $this->tgl_akhir);
                        }
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function searchInformasi() {
       
        $prov = $this->search();
        
        return $prov;
    }
}