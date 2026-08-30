<?php

/**
 * This is the model class for table "pemeriksaankultur_t".
 *
 * The followings are the available columns in table 'pemeriksaankultur_t':
 * @property integer $pemeriksaankultur_id
 * @property integer $pegawai_id
 * @property integer $dpjp_id
 * @property integer $perawat_id
 * @property string $tgl_pemeriksaan
 * @property integer $daftartindakan_id
 * @property integer $tindakanpelayanan_id
 * @property integer $pasien_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $pasienadmisi_id
 * @property integer $pendaftaran_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property string $daftartindakan_nama
 * @property string $sel_epitel_kultur
 * @property string $sel_radang_kultur
 * @property string $mikroorganisme
 * @property string $ziehlnielsen_kultur
 * @property string $koh_kultur
 * @property string $niesser_kultur
 * @property string $negatif_kultur
 * @property string $spora_kultur
 * @property string $giemsa_kultur
 * @property string $mikroorganisme_ket
 * @property string $biakan_kultur
 * @property string $biakan_kultur_ket
 * @property string $saran_kultur
 * @property string $amoxycilin
 * @property string $clavulanic
 * @property string $ampicillin
 * @property string $sulbactam
 * @property string $benzylpenicillin
 * @property string $piperacillin
 * @property string $cloxacillin
 * @property string $fosfomycin
 * @property string $gentamicin
 * @property string $netilmicin
 * @property string $amikacin
 * @property string $ciprofloxacin
 * @property string $ofloxacin
 * @property string $levofloxacin
 * @property string $moxifloxacin
 * @property string $tetracycline
 * @property string $doxycycline
 * @property string $cefepime
 * @property string $cefpirome
 * @property string $cefoperazone
 * @property string $cefoperazone_sulbactam
 * @property string $cefditoren
 * @property string $cefadroxil
 * @property string $cefotaxim
 * @property string $ceftriaxone
 * @property string $cefuroxime
 * @property string $cefradine
 * @property string $cefalexin
 * @property string $cefazoline
 * @property string $cefixime
 * @property string $ceftazidime
 * @property string $ceftizoxime
 * @property string $meropenem
 * @property string $imipenem
 * @property string $doripenem
 * @property string $ertapenem
 * @property string $metronidazole
 * @property string $erythromycin
 * @property string $lincomycin
 * @property string $clindamycin
 * @property string $czithromycin
 * @property string $clarithromycin
 * @property string $tobramycin
 * @property string $chloramphenicol
 * @property string $nalidixid
 * @property string $nitrofurantoin
 * @property string $colistine
 * @property string $trimoxazole
 * @property string $vancomycin
 * @property string $linezolid
 * @property string $tigecycline
 * @property string $rifampicin
 * @property string $fluconazole
 * @property string $voriconazole
 * @property string $micafungin
 * @property string $amphothericin
 * @property string $caspofungin
 * @property string $flucytosine
 * @property string $no_lab
 */
class PemeriksaankulturT extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $jenis_pemeriksaan;

	public function tableName()
	{
		return 'pemeriksaankultur_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, pasienmasukpenunjang_id, pendaftaran_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pemeriksaankultur_id, pegawai_id, dpjp_id, perawat_id, daftartindakan_id, tindakanpelayanan_id, pasien_id, pasienmasukpenunjang_id, pasienadmisi_id, pendaftaran_id', 'numerical', 'integerOnly'=>true),
			array('sel_epitel_kultur, sel_radang_kultur, mikroorganisme, ziehlnielsen_kultur, koh_kultur, niesser_kultur, negatif_kultur, spora_kultur, giemsa_kultur, biakan_kultur', 'length', 'max'=>100),
			array('mikroorganisme_ket, biakan_kultur_ket', 'length', 'max'=>255),
			array('amoxycilin, clavulanic, ampicillin, sulbactam, benzylpenicillin, piperacillin, cloxacillin, fosfomycin, gentamicin, netilmicin, amikacin, ciprofloxacin, ofloxacin, levofloxacin, moxifloxacin, tetracycline, doxycycline, cefepime, cefpirome, cefoperazone, cefoperazone_sulbactam, cefditoren, cefadroxil, cefotaxim, ceftriaxone, cefuroxime, cefradine, cefalexin, cefazoline, cefixime, ceftazidime, ceftizoxime, meropenem, imipenem, doripenem, ertapenem, metronidazole, erythromycin, lincomycin, clindamycin, czithromycin, clarithromycin, tobramycin, chloramphenicol, nalidixid, nitrofurantoin, colistine, trimoxazole, vancomycin, linezolid, tigecycline, rifampicin, fluconazole, voriconazole, micafungin, amphothericin, caspofungin, flucytosine', 'length', 'max'=>5),
			array('no_lab', 'length', 'max'=>30),
			array('tgl_pemeriksaan, update_time, update_loginpemakai_id, daftartindakan_nama, saran_kultur', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pemeriksaankultur_id, pegawai_id, dpjp_id, perawat_id, tgl_pemeriksaan, daftartindakan_id, tindakanpelayanan_id, pasien_id, pasienmasukpenunjang_id, pasienadmisi_id, pendaftaran_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, daftartindakan_nama, sel_epitel_kultur, sel_radang_kultur, mikroorganisme, ziehlnielsen_kultur, koh_kultur, niesser_kultur, negatif_kultur, spora_kultur, giemsa_kultur, mikroorganisme_ket, biakan_kultur, biakan_kultur_ket, saran_kultur, amoxycilin, clavulanic, ampicillin, sulbactam, benzylpenicillin, piperacillin, cloxacillin, fosfomycin, gentamicin, netilmicin, amikacin, ciprofloxacin, ofloxacin, levofloxacin, moxifloxacin, tetracycline, doxycycline, cefepime, cefpirome, cefoperazone, cefoperazone_sulbactam, cefditoren, cefadroxil, cefotaxim, ceftriaxone, cefuroxime, cefradine, cefalexin, cefazoline, cefixime, ceftazidime, ceftizoxime, meropenem, imipenem, doripenem, ertapenem, metronidazole, erythromycin, lincomycin, clindamycin, czithromycin, clarithromycin, tobramycin, chloramphenicol, nalidixid, nitrofurantoin, colistine, trimoxazole, vancomycin, linezolid, tigecycline, rifampicin, fluconazole, voriconazole, micafungin, amphothericin, caspofungin, flucytosine, no_lab', 'safe', 'on'=>'search'),
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
			'pegawai'=>array(self::BELONGS_TO, 'PegawaiM','pegawai_id'),
			'perawat'=>array(self::BELONGS_TO, 'PegawaiM','perawat_id'),
			'dpjp'=>array(self::BELONGS_TO, 'PegawaiM','dpjp_id'),
			'tindakanpelayanan'=>array(self::BELONGS_TO, 'TindakanpelayananT','tindakanpelayanan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pemeriksaankultur_id' => 'pemeriksaankultur_id',
			'pegawai_id' => 'Pegawai',
			'dpjp_id' => 'Dpjp',
			'perawat_id' => 'Perawat',
			'tgl_pemeriksaan' => 'Tgl Pemeriksaan',
			'daftartindakan_id' => 'Daftartindakan',
			'tindakanpelayanan_id' => 'Tindakanpelayanan',
			'pasien_id' => 'Pasien',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pendaftaran_id' => 'Pendaftaran',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'daftartindakan_nama' => 'Daftartindakan Nama',
			'sel_epitel_kultur' => 'Sel Epitel Kultur',
			'sel_radang_kultur' => 'Sel Radang Kultur',
			'mikroorganisme' => 'Mikroorganisme',
			'ziehlnielsen_kultur' => 'Ziehlnielsen Kultur',
			'koh_kultur' => 'Koh Kultur',
			'niesser_kultur' => 'Niesser Kultur',
			'negatif_kultur' => 'Negatif Kultur',
			'spora_kultur' => 'Spora Kultur',
			'giemsa_kultur' => 'Giemsa Kultur',
			'mikroorganisme_ket' => 'Mikroorganisme Ket',
			'biakan_kultur' => 'Biakan Kultur',
			'biakan_kultur_ket' => 'Biakan Kultur Ket',
			'saran_kultur' => 'Saran Kultur',
			'amoxycilin' => 'Amoxycilin',
			'clavulanic' => 'Clavulanic',
			'ampicillin' => 'Ampicillin',
			'sulbactam' => 'Sulbactam',
			'benzylpenicillin' => 'Benzylpenicillin',
			'piperacillin' => 'Piperacillin',
			'cloxacillin' => 'Cloxacillin',
			'fosfomycin' => 'Fosfomycin',
			'gentamicin' => 'Gentamicin',
			'netilmicin' => 'Netilmicin',
			'amikacin' => 'Amikacin',
			'ciprofloxacin' => 'Ciprofloxacin',
			'ofloxacin' => 'Ofloxacin',
			'levofloxacin' => 'Levofloxacin',
			'moxifloxacin' => 'Moxifloxacin',
			'tetracycline' => 'Tetracycline',
			'doxycycline' => 'Doxycycline',
			'cefepime' => 'Cefepime',
			'cefpirome' => 'Cefpirome',
			'cefoperazone' => 'Cefoperazone',
			'cefoperazone_sulbactam' => 'Cefoperazone Sulbactam',
			'cefditoren' => 'Cefditoren',
			'cefadroxil' => 'Cefadroxil',
			'cefotaxim' => 'Cefotaxim',
			'ceftriaxone' => 'Ceftriaxone',
			'cefuroxime' => 'Cefuroxime',
			'cefradine' => 'Cefradine',
			'cefalexin' => 'Cefalexin',
			'cefazoline' => 'Cefazoline',
			'cefixime' => 'Cefixime',
			'ceftazidime' => 'Ceftazidime',
			'ceftizoxime' => 'Ceftizoxime',
			'meropenem' => 'Meropenem',
			'imipenem' => 'Imipenem',
			'doripenem' => 'Doripenem',
			'ertapenem' => 'Ertapenem',
			'metronidazole' => 'Metronidazole',
			'erythromycin' => 'Erythromycin',
			'lincomycin' => 'Lincomycin',
			'clindamycin' => 'Clindamycin',
			'czithromycin' => 'Czithromycin',
			'clarithromycin' => 'Clarithromycin',
			'tobramycin' => 'Tobramycin',
			'chloramphenicol' => 'Chloramphenicol',
			'nalidixid' => 'Nalidixid',
			'nitrofurantoin' => 'Nitrofurantoin',
			'colistine' => 'Colistine',
			'trimoxazole' => 'Trimoxazole',
			'vancomycin' => 'Vancomycin',
			'linezolid' => 'Linezolid',
			'tigecycline' => 'Tigecycline',
			'rifampicin' => 'Rifampicin',
			'fluconazole' => 'Fluconazole',
			'voriconazole' => 'Voriconazole',
			'micafungin' => 'Micafungin',
			'amphothericin' => 'Amphothericin',
			'caspofungin' => 'Caspofungin',
			'flucytosine' => 'Flucytosine',
			'no_lab' => 'No Lab',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('pemeriksaankultur_id',$this->pemeriksaankultur_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('dpjp_id',$this->dpjp_id);
		$criteria->compare('perawat_id',$this->perawat_id);
		$criteria->compare('tgl_pemeriksaan',$this->tgl_pemeriksaan,true);
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('tindakanpelayanan_id',$this->tindakanpelayanan_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('daftartindakan_nama',$this->daftartindakan_nama,true);
		$criteria->compare('sel_epitel_kultur',$this->sel_epitel_kultur,true);
		$criteria->compare('sel_radang_kultur',$this->sel_radang_kultur,true);
		$criteria->compare('mikroorganisme',$this->mikroorganisme,true);
		$criteria->compare('ziehlnielsen_kultur',$this->ziehlnielsen_kultur,true);
		$criteria->compare('koh_kultur',$this->koh_kultur,true);
		$criteria->compare('niesser_kultur',$this->niesser_kultur,true);
		$criteria->compare('negatif_kultur',$this->negatif_kultur,true);
		$criteria->compare('spora_kultur',$this->spora_kultur,true);
		$criteria->compare('giemsa_kultur',$this->giemsa_kultur,true);
		$criteria->compare('mikroorganisme_ket',$this->mikroorganisme_ket,true);
		$criteria->compare('biakan_kultur',$this->biakan_kultur,true);
		$criteria->compare('biakan_kultur_ket',$this->biakan_kultur_ket,true);
		$criteria->compare('saran_kultur',$this->saran_kultur,true);
		$criteria->compare('amoxycilin',$this->amoxycilin,true);
		$criteria->compare('clavulanic',$this->clavulanic,true);
		$criteria->compare('ampicillin',$this->ampicillin,true);
		$criteria->compare('sulbactam',$this->sulbactam,true);
		$criteria->compare('benzylpenicillin',$this->benzylpenicillin,true);
		$criteria->compare('piperacillin',$this->piperacillin,true);
		$criteria->compare('cloxacillin',$this->cloxacillin,true);
		$criteria->compare('fosfomycin',$this->fosfomycin,true);
		$criteria->compare('gentamicin',$this->gentamicin,true);
		$criteria->compare('netilmicin',$this->netilmicin,true);
		$criteria->compare('amikacin',$this->amikacin,true);
		$criteria->compare('ciprofloxacin',$this->ciprofloxacin,true);
		$criteria->compare('ofloxacin',$this->ofloxacin,true);
		$criteria->compare('levofloxacin',$this->levofloxacin,true);
		$criteria->compare('moxifloxacin',$this->moxifloxacin,true);
		$criteria->compare('tetracycline',$this->tetracycline,true);
		$criteria->compare('doxycycline',$this->doxycycline,true);
		$criteria->compare('cefepime',$this->cefepime,true);
		$criteria->compare('cefpirome',$this->cefpirome,true);
		$criteria->compare('cefoperazone',$this->cefoperazone,true);
		$criteria->compare('cefoperazone_sulbactam',$this->cefoperazone_sulbactam,true);
		$criteria->compare('cefditoren',$this->cefditoren,true);
		$criteria->compare('cefadroxil',$this->cefadroxil,true);
		$criteria->compare('cefotaxim',$this->cefotaxim,true);
		$criteria->compare('ceftriaxone',$this->ceftriaxone,true);
		$criteria->compare('cefuroxime',$this->cefuroxime,true);
		$criteria->compare('cefradine',$this->cefradine,true);
		$criteria->compare('cefalexin',$this->cefalexin,true);
		$criteria->compare('cefazoline',$this->cefazoline,true);
		$criteria->compare('cefixime',$this->cefixime,true);
		$criteria->compare('ceftazidime',$this->ceftazidime,true);
		$criteria->compare('ceftizoxime',$this->ceftizoxime,true);
		$criteria->compare('meropenem',$this->meropenem,true);
		$criteria->compare('imipenem',$this->imipenem,true);
		$criteria->compare('doripenem',$this->doripenem,true);
		$criteria->compare('ertapenem',$this->ertapenem,true);
		$criteria->compare('metronidazole',$this->metronidazole,true);
		$criteria->compare('erythromycin',$this->erythromycin,true);
		$criteria->compare('lincomycin',$this->lincomycin,true);
		$criteria->compare('clindamycin',$this->clindamycin,true);
		$criteria->compare('czithromycin',$this->czithromycin,true);
		$criteria->compare('clarithromycin',$this->clarithromycin,true);
		$criteria->compare('tobramycin',$this->tobramycin,true);
		$criteria->compare('chloramphenicol',$this->chloramphenicol,true);
		$criteria->compare('nalidixid',$this->nalidixid,true);
		$criteria->compare('nitrofurantoin',$this->nitrofurantoin,true);
		$criteria->compare('colistine',$this->colistine,true);
		$criteria->compare('trimoxazole',$this->trimoxazole,true);
		$criteria->compare('vancomycin',$this->vancomycin,true);
		$criteria->compare('linezolid',$this->linezolid,true);
		$criteria->compare('tigecycline',$this->tigecycline,true);
		$criteria->compare('rifampicin',$this->rifampicin,true);
		$criteria->compare('fluconazole',$this->fluconazole,true);
		$criteria->compare('voriconazole',$this->voriconazole,true);
		$criteria->compare('micafungin',$this->micafungin,true);
		$criteria->compare('amphothericin',$this->amphothericin,true);
		$criteria->compare('caspofungin',$this->caspofungin,true);
		$criteria->compare('flucytosine',$this->flucytosine,true);
		$criteria->compare('no_lab',$this->no_lab,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PemeriksaankulturT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
