<?php

/**
 * Class VUtente si occupa
 */
class VUtente
{
    /**
     * @var Smarty
     */
    private $smarty;

    /**
     * Funzione che inizializza e configura smarty.
     */
    public function __construct() {
        $this->smarty = StartSmarty::configuration();
    }

    /**
     * Funzione che si occupa di gestire la visualizzazione della form di login
     * @throws SmartyException
     */
    public function showFormLogin(){
        if (isset($_POST['username']))
            $this->smarty->assign('email',$_POST['conveyor']);
        $this->smarty->display('login.tpl');
    }

    /**
     * Funzione che si occupa di gestire la visualizzazione della homepage dopo il login ( se Ã¨ andato a buon fine)
     * @param $array elenco di Anunci da visualizzare
     * @throws SmartyException
     */
    public function loginOk($array) {
        $this->smarty->assign('immagine', "/FillSpaceWEB/Smarty/immagini/truck.png");
        $this->smarty->assign('userlogged',"loggato");
        $this->smarty->assign('array', $array);
        $this->smarty->assign('toSearch', 'trasporti');
        $this->smarty->display('home.tpl');
    }
    
    /**
     * Funzione che si occupa di gestire la visualizzazione degli errori in fase login
     * @throws SmartyException
     */
    public function loginError() {
        $this->smarty->assign('error',"errore");
        $this->smarty->display('login.tpl');
    }

    /**
     * Funzione che si occupa di gestire la visualizzazione del profilo cliente
     * @param $user informazioni sull' utente da visualizzare
     * @param $ann elenco di annunci pubblicati dall'utente
     * @param $img immagine dell'utente
     * @throws SmartyException
     */
    public function profileCli($user,$ann,$img) {
        list($type,$pic64) = $this->setImage($img, 'user');
        $this->smarty->assign('type', $type);
        $this->smarty->assign('pic64', $pic64);
        $this->smarty->assign('userlogged',"loggato");
        $this->smarty->assign('nome',$user->getName());
        $this->smarty->assign('cognome',$user->getSurname());
        $this->smarty->assign('email',$user->getEmail());
        $this->smarty->assign('array',$ann);
        $this->smarty->display('profilo_cliente_privato.tpl');
    }

    /**
     * Funzione che si occupa di gestire la visualizzazione del profilo trasportatore
     * @param $user informazioni sull' utente da visualizzare
     * @param $ann elenco di annunci pubblicati dall'utente
     * @param $img immagine dell'utente
     * @param $imgMezzo immagine del mezzo
     * @param $imgrec elenco di immagini degli utenti per le recensioni
     * @param $rec elenco di recensioni
     * @throws SmartyException
     */
    public function profileTrasp($user,$ann,$img,$imgMezzo,$imgrec,$rec) {
        if (count($rec) == 0)
            $this->smarty->assign('media_voto', 0);
        else
            $this->smarty->assign('media_voto', $user->averageMark());
        list($typeR,$pic64rec) = $this->SetImageRecensione($imgrec);
        if ($typeR == null && $pic64rec == null)
            $this->smarty->assign('immagine', "/FillSpaceWEB/Smarty/immagini/user.png");
        if (isset($imgrec)) {
            if (is_array($imgrec)) {
                $this->smarty->assign('typeR', $typeR);
                $this->smarty->assign('pic64rec', $pic64rec);
                $this->smarty->assign('n_recensioni', count($imgrec) - 1);
            }
            else {
                $t[] = $typeR;
                $im[] = $pic64rec;
                $this->smarty->assign('typeR', $t);
                $this->smarty->assign('pic64rec', $im);
                $this->smarty->assign('n_recensioni', 0);
            }
        }
        else
            $this->smarty->assign('n_recensioni', 0);
        $rec = $user->getReview();
        list($type,$pic64) = $this->setImage($img, 'user');
        $this->smarty->assign('type', $type);
        $this->smarty->assign('pic64prof', $pic64);
        list($typeM,$pic64mezzo) = $this->setImage($imgMezzo, 'mezzo');
        $this->smarty->assign('typeM', $typeM);
        $this->smarty->assign('pic64mezzo', $pic64mezzo);
        $this->smarty->assign('user', $user);
        $this->smarty->assign('userlogged',"loggato");
        $this->smarty->assign('ann',$ann);
        $this->smarty->assign('rec', $rec);
        $this->smarty->display('profilo_trasp_privato.tpl');
    }

    /**
     * Funzione che si occupa di gestire la visualizzazione della form di registrazione del cliente
     * @throws SmartyException
     */
    public function registra_cliente() {
        $this->smarty->display('registraz_cliente.tpl');
    }

    /**
     * Funzione che si occupa di gestire la visualizzazione della form di registrazione del trasportatore
     * @throws SmartyException
     */
    public function registra_trasportatore() {
        $this->smarty->display('registraz_trasp.tpl');
    }

    /**
     * Funzione che si occupa di gestire la visualizzazione degli errori nella form di registrazione per il trasportatore
     * @param $email tipo di errore derivante dall'email inserita
     * @param $mezzo tipo di errore derivante dall'immagine inserita
     * @param $error tipo di errore da visualizzare nella form
     * @throws SmartyException
     */
    public function registrazioneTrasError ($email, $mezzo, $error) {
        if ($email)
            $this->smarty->assign('errorEmail',"errore");
        if ($mezzo)
            $this->smarty->assign('errorTarga',"errore");
        switch ($error) {
            case "typeimg" :
                $this->smarty->assign('errorType',"errore");
                break;
            case "typeimgM" :
                $this->smarty->assign('errorTypeM',"errore");
                break;
            case "size" :
                $this->smarty->assign('errorSize',"errore");
                break;
            case "sizeM" :
                $this->smarty->assign('errorSizeM',"errore");
                break;
        }
        $this->smarty->display('registraz_trasp.tpl');
    }

    /**
     * Funzione che si occupa di gestire la visualizzazione degli errori nella form di registrazione per il cliente
     * @param $error tipo di errore da visualizzare
     * @throws SmartyException
     */
    public function registrazioneCliError ($error) {
        switch ($error) {
            case "email":
                $this->smarty->assign('errorEmail',"errore");
                break;
            case "typeimg" :
                $this->smarty->assign('errorType',"errore");
                break;
            case "size" :
                $this->smarty->assign('errorSize',"errore");
                break;
        }
        $this->smarty->display('registraz_cliente.tpl');
    }

    /**
     * Funzione che si occupa del supporto per le immagini
     * @param $image immagine da analizzare
     * @param $tipo variabile che indirizza al tipo di file di default da settare nel caso in cui $image = null
     * @return array contenente informazioni sul tipo e i dati che costituiscono un immagine (possono essere anche degli array)
     */
    public function setImage($image, $tipo) {
        if (isset($image)) {
            $pic64 = base64_encode($image->getData());
            $type = $image->getType();
        }
        elseif ($tipo == 'user') {
            $data = file_get_contents( $_SERVER['DOCUMENT_ROOT'] . '/FillSpaceWEB/Smarty/immagini/user.png');
            $pic64= base64_encode($data);
            $type = "image/png";
        }
        else {
            $data = file_get_contents( $_SERVER['DOCUMENT_ROOT'] . '/FillSpaceWEB/Smarty/immagini/truck2.png');
            $pic64= base64_encode($data);
            $type = "image/png";
        }
        return array($type, $pic64);
    }

    /**
     * Funzione di supporto per gestire le immagini presenti nell'elenco delle recensioni
     * @param $imgrec elenco di immagini degli utenti presenti nelle recensioni
     * @return array
     */

    public function SetImageRecensione ($imgrec) {
        $type = null;
        $pic64 = null;
        if (is_array($imgrec)) {
            foreach ($imgrec as $item) {
                if (isset($item)) {
                    $pic64[] = base64_encode($item->getData());
                    $type[] = $item->getType();
                } else {
                    $data = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/FillSpaceWEB/Smarty/immagini/user.png');
                    $pic64[] = base64_encode($data);
                    $type[] = "image/png";
                }
            }
        }
        elseif (isset($imgrec)) {
            $pic64 = base64_encode($imgrec->getData());
            $type = $imgrec->getType();
        }
        return array($type, $pic64);
    }


    /**
     * Funzione che si occupa di gestire la visualizzazione del profilo pubblico di un trasportatore
     * @param $user informazioni sull'utente da visitare
     * @param $img immagine dell'utente da visitare
     * @param $cont possibilitÃ  di contattare o meno il cliente
     * @throws SmartyException
     */
    public function profilopubblico_cli($user,$img,$cont) {
        list($type,$pic64) = $this->setImage($img, 'user');
        $this->smarty->assign('type', $type);
        $this->smarty->assign('pic64', $pic64);
        if ($cont == "no")
            $this->smarty->assign('contatta', $cont);
        if(CUtente::isLogged())
            $this->smarty->assign('userlogged',"loggato");
        $this->smarty->assign('nome',$user->getName());
        $this->smarty->assign('cognome',$user->getSurname());
        $this->smarty->assign('email',$user->getEmail());
        $this->smarty->display('profilo_cliente_pubblico.tpl');
    }

    /**
     * Funzione che si occupa di gestire la visualizzazione del profilo pubblico di un trasportatore
     * @param $user informazioni sull'utente da visitare
     * @param $emailvisitato email dell'utente visitato
     * @param $img immagine dell'utente da visitare
     * @param $imgMezzo immagine del mezzo dell'utente visitato
     * @param $imgrec immagini degli utenti che hanno scritto delle recensioni
     * @param $rec elenco delle recensioni dell'utente visitato
     * @param $cont possibilitÃ  di contattare o meno il cliente
     * @throws SmartyException
     */
    public function profilopubblico_tra($user, $emailvisitato, $img,$imgMezzo,$imgrec,$rec,$cont) {
        if (count($rec) == 0)
            $this->smarty->assign('media_voto', 0);
        else
            $this->smarty->assign('media_voto', $user->averageMark());
        list($typeR,$pic64rec) = $this->SetImageRecensione($imgrec);
        if ($cont == "no")
            $this->smarty->assign('contatta', $cont);
        if ($typeR == null && $pic64rec == null)
            $this->smarty->assign('immagine', "/FillSpaceWEB/Smarty/immagini/user.png");
        if (isset($imgrec)) {
            if (is_array($imgrec)) {
                $this->smarty->assign('typeR', $typeR);
                $this->smarty->assign('pic64rec', $pic64rec);
                $this->smarty->assign('n_recensioni', count($imgrec) - 1);
            }
            else {
                $t[] = $typeR;
                $im[] = $pic64rec;
                $this->smarty->assign('typeR', $t);
                $this->smarty->assign('pic64rec', $im);
                $this->smarty->assign('n_recensioni', 0);
            }
        }
        else
            $this->smarty->assign('n_recensioni', 0);
        $this->smarty->assign('rec',$rec);
        list($type,$pic64) = $this->setImage($img, 'user');
        $this->smarty->assign('type', $type);
        $this->smarty->assign('pic64', $pic64);
        list($typeM,$pic64mezzo) = $this->setImage($imgMezzo, 'mezzo');
        $this->smarty->assign('typeM', $typeM);
        $this->smarty->assign('pic64mezzo', $pic64mezzo);
        $mezzo = $user->getVehicle();
        if(CUtente::isLogged())
            $this->smarty->assign('userlogged',"loggato");
        $this->smarty->assign('email',$emailvisitato);
        $this->smarty->assign('nome',$user->getName());
        $this->smarty->assign('email',$user->getEmail());
        $this->smarty->assign('cognome',$user->getSurname());
        $this->smarty->assign('company',$user->getCompany());
        $this->smarty->assign('piva',$user->getPiva());
        $this->smarty->assign('model',$mezzo->getModel());
        $this->smarty->assign('plate',$mezzo->getPlate());
        $this->smarty->assign('dim',$mezzo->getSize());
        $this->smarty->assign('full_load',$mezzo->getFullLoad());
        $this->smarty->display('profilo_trasp_pubblico.tpl');
    }

    /**
     * Funzione che si occupa di gestire la visualizzazione della form di modifica per il cliente
     * @param $user informazioni sull'utente che desidera mdificare i suoi dati
     * @param $img immagine dell'utente
     * @param $error tipo di errore nel caso in cui le modifiche siano sbagliate
     * @throws SmartyException
     */
    public function formmodificacli($user,$img,$error) {
        switch ($error) {
            case "errorEmail" :
                $this->smarty->assign('errorEmail', "errore");
                break;
            case "errorPassw":
                $this->smarty->assign('errorPassw', "errore");
                break;
            case "errorSize" :
                $this->smarty->assign('errorSize', "errore");
                break;
            case "errorType" :
                $this->smarty->assign('errorType', "errore");
                break;
        }
        if (isset($img)) {
            $pic64 = base64_encode($img->getData());
        }
        else {
            $data = file_get_contents( $_SERVER['DOCUMENT_ROOT'] . '/FillSpaceWEB/Smarty/immagini/user.png');
            $pic64 = base64_encode($data);
        }
        $this->smarty->assign('userlogged',"loggato");
        $this->smarty->assign('pic64',$pic64);
        $this->smarty->assign('name',$user->getName());
        $this->smarty->assign('surname',$user->getSurname());
        $this->smarty->assign('email',$user->getEmail());
        $this->smarty->assign('name',$user->getName());
        $this->smarty->display('modifica_prof_cliente.tpl');
    }

    /**
     * Funzione che si occupa di gestire la visualizzazione della form di modifica per il trasportatore
     * @param $user informazioni sull'utente
     * @param $mezzo informazioni sul mezzo
     * @param $imgutente immagine dell'utente
     * @param $imgmezzo immagine del mezzo
     * @param $error tipo di errore
     * @throws SmartyException
     */
    public function formmodificatrasp($user,$mezzo,$imgutente,$imgmezzo,$error) {
        switch ($error) {
            case "errorEmail" :
                $this->smarty->assign('errorKey', "errore");
                $this->smarty->assign('key', "Email");
                break;
            case "errorPiva" :
                $this->smarty->assign('errorKey', "errore");
                $this->smarty->assign('key', "Piva");
                break;
            case "errorTarga" :
                $this->smarty->assign('errorKey', "errore");
                $this->smarty->assign('key', "Targa");
                break;
            case "errorPassw":
                $this->smarty->assign('errorPassw', "errore");
                break;
            case "errorSize" :
                $this->smarty->assign('errorSize', "errore");
                break;
            case "errorSizeM" :
                $this->smarty->assign('errorSizeM', "errore");
                break;
            case "errorTypeM" :
                $this->smarty->assign('errorTypeM', "errore");
                break;
            case "errorType" :
                $this->smarty->assign('errorType', "errore");
                break;
        }
        if (isset($imgmezzo)) {
            $pic64M = base64_encode($imgmezzo->getData());
            $this->smarty->assign('typeM', $imgmezzo->getType());
        }
        else {
            $data = file_get_contents( $_SERVER['DOCUMENT_ROOT'] . '/FillSpaceWEB/Smarty/immagini/truck.png');
            $pic64M = base64_encode($data);
            $this->smarty->assign('typeM', "image/png");
        }
        if (isset($imgutente)) {
            $pic64 = base64_encode($imgutente->getData());
            $this->smarty->assign('type', $imgutente->getType());
        }
        else {
            $data = file_get_contents( $_SERVER['DOCUMENT_ROOT'] . '/FillSpaceWEB/Smarty/immagini/user.png');
            $pic64 = base64_encode($data);
            $this->smarty->assign('type', "image/png");
        }
        $this->smarty->assign('userlogged',"loggato");
        $this->smarty->assign('pic64',$pic64);
        $this->smarty->assign('pic64M',$pic64M);
        $this->smarty->assign('name',$user->getName());
        $this->smarty->assign('surname',$user->getSurname());
        $this->smarty->assign('email',$user->getEmail());
        $this->smarty->assign('company',$user->getCompany());
        $this->smarty->assign('piva',$user->getPiva());
        $this->smarty->assign('mezzo',$mezzo);
        $this->smarty->display('modifica_prof_trasp.tpl');
    }



}