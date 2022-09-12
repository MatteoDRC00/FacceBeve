<?php

require_once "Smarty/libs/autoloader.php";
require_once "StartSmarty.php";

class VProfilo{

    /**
     * Oggetto _Smarty_ per la compilazione e visualizzazione dei template.
     * @var Smarty
     */
    private Smarty $smarty;

    /**
     * Costruttore di classe. Crea l'oggetto ed esegue la configurazione dell'attributo _$smarty_.
     */
    public function __construct()
    {
        $this->smarty = StartSmarty::configuration();
    }


    /**
     * Funzione che si occupa di gestire la visualizzazione del profilo utente/proprietario
     * @param $tente informazioni sull' utente da visualizzare
     * @param $locali elenco di locali gestiti dal proprietario, vale null se è il profilo di un utente normale
     * @throws SmartyException

    public function profilo($utente,$locali) {
        //encode con base64 del img profilo
        list($type,$pic64) = $this->setImage($utente->getImgProfilo(), get_class($utente));
        $this->smarty->assign('type', $type);
        $this->smarty->assign('pic64', $pic64);
        $this->smarty->assign('userlogged',"loggato");
        $this->smarty->assign('nome',$utente->getNome());
        $this->smarty->assign('cognome',$utente->getCognome());
        $this->smarty->assign('username',$utente->getUsername());
        $this->smarty->assign('email',$utente->getEmail());
        //EUtente o EProprietario
        $this->smarty->assign('classe', get_class($utente));
        //Se Utente locali->suoi preferiti, se invece Proprietario locali->suoi gestiti
        if($locali==null){
            $this->smarty->assign('array',$utente->getLocalipreferiti());
            $this->smarty->display('areaPersonaleUtente.tpl');
        }else{
            $this->smarty->assign('array',$locali);
            $this->smarty->display('areaPersonaleProprietario.tpl');
        }
    }
     */


    /**
     * Funzione che permette di visualizzare il profilo del Utente prelevando le informazioni dall'oggetto, assegna i parametri al template, assegna il messaggio di errore e mostra la pagina.
     * @param $utente informazioni sull' utente da visualizzare
     * @param $locali elenco di locali gestiti dal proprietario, vale null se è il profilo di un utente normale
     * @param $error errore, se preswente, ottenuto nella modifica del profilo
     * @throws SmartyException
     */
    public function profilo($utente,$locali, $error) {
        //encode con base64 del img profilo
        list($type,$pic64) = $this->setImage($utente->getImgProfilo(), get_class($utente));
        if ($utente->getImgProfilo() !== null) {
            $pic64 = base64_encode($utente->getImgProfilo()->getImmagine());
        }
        else {
            $data = file_get_contents( $_SERVER['DOCUMENT_ROOT'] . '/FacceBeve/template/img/user.png');
            $pic64 = base64_encode($data);
        }
        $this->smarty->assign('type', $type);
        $this->smarty->assign('pic64', $pic64);
        $this->smarty->assign('userlogged',"loggato");
        $this->smarty->assign('nome',$utente->getNome());
        $this->smarty->assign('cognome',$utente->getCognome());
        $this->smarty->assign('username',$utente->getUsername());
        $this->smarty->assign('email',$utente->getEmail());
        //EUtente o EProprietario
        $this->smarty->assign('classe', get_class($utente));
        //Gestione del errore
        if(isset($error)){

            switch($error){
                case ("password_old"):{
                    $this->smarty->assign('errorPwOld',"Hai inserito la password precedente");
                    break;
                }
                case ("password_error"):{
                    $this->smarty->assign('errorPw',"La vecchia password non corrisponde");
                    break;
                }
                case ("size"):{
                    $this->smarty->assign('errorSize',"Dimensione immagine non supportata");
                    break;
                }
                case ("type"):{
                    $this->smarty->assign('errorType',"Formato immagine non supportato");
                    break;
                }
                case ("username"):{
                    $this->smarty->assign('errorUsername',"Username già presente");
                    break;
                }
            }
        }
        //Se Utente locali->suoi preferiti, se invece Proprietario locali->suoi gestiti
        if($locali==null){
            $this->smarty->assign('array',$utente->getLocalipreferiti());
            $this->smarty->display('areaPersonaleUtente.tpl');
        }else{
            $this->smarty->assign('array',$locali);
            $this->smarty->display('areaPersonaleProprietario.tpl');
        }
    }

    /**
     * Funzione che si occupa di gestire la visualizzazione della form di modifica del profilo di un Utente
     * @param $user informazioni sull'utente che desidera mdificare i suoi dati
     * @param $img immagine dell'utente
     * @param $error tipo di errore nel caso in cui le modifiche siano sbagliate
     * @throws SmartyException

    public function formModificaUtente($user,$img,$error) {
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
            $pic64 = base64_encode($img->getImmagine());
        }
        else {
            $data = file_get_contents( $_SERVER['DOCUMENT_ROOT'] . '/FacceBeve/Smarty/immagini/user.png');
            $pic64 = base64_encode($data);
        }
        $this->smarty->assign('userlogged',"loggato");
        $this->smarty->assign('pic64',$pic64);
        $this->smarty->assign('name',$user->getName());
        $this->smarty->assign('surname',$user->getSurname());
        $this->smarty->assign('email',$user->getEmail());
        $this->smarty->assign('name',$user->getName());
        $this->smarty->display('areaPersonaleUtente.tpl');
    } */

    /**
     * Funzione che si occupa di gestire la visualizzazione della form di modifica del profilo di un Proprietario
     * @param $user informazioni sull'utente che desidera modificare i suoi dati
     * @param $img immagine del proprietario
     * @param $error tipo di errore nel caso in cui le modifiche siano sbagliate
     * @throws SmartyException

    public function formModificaUProprietario($user,$img,$error) {
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
            $pic64 = base64_encode($img->getImmagine());
        }
        else {
            $data = file_get_contents( $_SERVER['DOCUMENT_ROOT'] . '/FacceBeve/Smarty/immagini/user.png');
            $pic64 = base64_encode($data);
        }
        $this->smarty->assign('userlogged',"loggato");
        $this->smarty->assign('pic64',$pic64);
        $this->smarty->assign('name',$user->getName());
        $this->smarty->assign('surname',$user->getSurname());
        $this->smarty->assign('email',$user->getEmail());
        $this->smarty->assign('name',$user->getName());
        $this->smarty->display('areaPersonaleProprietario.tpl');
    } */

    //Metodi GET\\

    /**
     * Metodo che restituisce la email inserita nel campo "Nuova EMail", utilizzata nella modifica del profilo, e prelevata dal vettore $_FILES
     * @return string
     */
    public function getEmailNuova(): string
    {
        return $_POST['emailnuova'];
    }

    /**
     * Metodo che restituisce la username inserita nel campo "Nuova Username", utilizzata nella modifica del profilo, e prelevata dal vettore $_FILES
     * @return string
     */
    public function getUsernameNuova(): string
    {
        return $_POST['usernamenuova'];
    }

    /**
     * Metodo che restituisce la password inserita nel campo "Nuova Password", utilizzata nella modifica del profilo, e prelevata dal vettore $_FILES
     * @return string
     */
    public function getPasswordNuova(): string
    {
        return $_POST['passwordnuova'];
    }

    /**
     * Metodo che restituisce la password inserita nel campo "Password precedente", utilizzata nella modifica del profilo per la validazione della password, e prelevata dal vettore $_FILES
     * @return string
     */
    public function getPasswordVecchia(): string
    {
        return $_POST['passwordvecchia'];
    }


    /**
     * Restituisce un array contenente le informazioni sul immagine da caricare, contenuto nel array _$_FILES, questo verrà poi passato al metodo upload per controllare la correttezza del file caricato
     * @return array
     */
    public function getNewImgProfilo(): array
    {
        $type = $_FILES['img_profilo']['type'];
        $nome = $_FILES['img_profilo']['name'];
        $file = $_FILES['img_profilo']['tmp_name'];
        $dimensione = $_FILES['img_profilo']['size'];
        $arrayImg = array($nome,$type, $file, $dimensione);
        return $arrayImg;
    }

    public function mostraProfiloUtente(EUtente $utente, $locali_preferiti){
        $pic64 = $utente->getImgProfilo()->getImmagine();
        $type = $utente->getImgProfilo()->getType();

        $this->smarty->assign("pic64",$pic64);
        $this->smarty->assign("type",$type);
        $this->smarty->assign("utente",$utente);
        $this->smarty->assign("locali_preferiti",$locali_preferiti);

        $this->smarty->display('areaPersonaleUtente.tpl');
    }

    public function mostraProfiloProprietario(){
        $this->smarty->display('areaPersonaleProprieratio.tpl');
    }

}