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

    //Metodi GET\\

    /**
     * Metodo che restituisce la email inserita nel campo "Nuova EMail", utilizzata nella modifica del profilo, e prelevata dal vettore $_FILES
     * @return string
     */
    public function getNewEmail(): string
    {
        return $_POST['newemail'];
    }


    /**
     * Metodo che restituisce la username inserita nel campo "Nuova Username", utilizzata nella modifica del profilo, e prelevata dal vettore $_FILES
     * @return string
     */
    public function getNewUsername(): string
    {
        return $_POST['newusername'];
    }

    /**
     * Metodo che restituisce la password inserita nel campo "Nuova Password", utilizzata nella modifica del profilo, e prelevata dal vettore $_FILES
     * @return string
     */
    public function getNewPassword(): string
    {
        return $_POST['newpassword'];
    }

    /**
     * Metodo che restituisce la password inserita nel campo "Password precedente", utilizzata nella modifica del profilo per la validazione della password, e prelevata dal vettore $_FILES
     * @return string
     */
    public function getPassword(): string
    {
        return $_POST['password'];
    }


    /**
     * Restituisce un array contenente le informazioni sul immagine da caricare, contenuto nel array _$_FILES, questo verrà poi passato al metodo upload per controllare la correttezza del file caricato
     * @return array
     */
    public function getNewImgProfilo(): array
    {
        if($_FILES['newimg_profilo']['type'] == "" || $_FILES['newimg_profilo']['name'] == "" || $_FILES['newimg_profilo']['tmp_name'] == "" || $_FILES['newimg_profilo']['size'] == ""){
            $arrayImg = array();
        }else{
            $type = $_FILES['newimg_profilo']['type'];
            $nome = $_FILES['newimg_profilo']['name'];
            $file = $_FILES['newimg_profilo']['tmp_name'];
            $size = $_FILES['newimg_profilo']['size'];
            $arrayImg = array($nome, $size, $type, file_get_contents($file));
        }
        return $arrayImg;
    }

    public function mostraProfiloUtente(EUtente $utente, $locali_preferiti){
        $username = $utente->getUsername();
        $nome = $utente->getNome();
        $cognome = $utente->getCognome();
        $email = $utente->getEmail();
        $img_profilo = $utente->getImgProfilo();
        if($img_profilo != null){
            $pic64 = $img_profilo->getImmagine();
            $type = $img_profilo->getType();
        }else{
            $pic64 = "";
            $type = "";
        }

        $this->smarty->assign("username",$username);
        $this->smarty->assign("nome",$nome);
        $this->smarty->assign("cognome",$cognome);
        $this->smarty->assign("email",$email);
        $this->smarty->assign("pic64",$pic64);
        $this->smarty->assign("type",$type);
        $this->smarty->assign("locali_preferiti",$locali_preferiti);

        $this->smarty->display('areaPersonaleUtente.tpl');
    }

    public function mostraProfiloProprietario(EProprietario $proprietario,$locali){
        $username = $proprietario->getUsername();
        $nome = $proprietario->getNome();
        $cognome = $proprietario->getCognome();
        $email = $proprietario->getEmail();
        $img_profilo = $proprietario->getImgProfilo();
        if($img_profilo != null){
            $pic64 = $img_profilo->getImmagine();
            $type = $img_profilo->getType();
        }else{
            $pic64 = "";
            $type = "";
        }

        $this->smarty->assign("username",$username);
        $this->smarty->assign("nome",$nome);
        $this->smarty->assign("cognome",$cognome);
        $this->smarty->assign("email",$email);
        $this->smarty->assign("pic64",$pic64);
        $this->smarty->assign("type",$type);
        $this->smarty->assign("locali",$locali);

        $this->smarty->display('areaPersonaleProprietario.tpl');
    }

    public function errore($tipo,$message,$user){
        $pm = FPersistentManager::getInstance();

        $this->smarty->assign("tipo",$tipo);
        $this->smarty->assign("message",$message);

        $username = $user->getUsername();
        $nome = $user->getNome();
        $cognome = $user->getCognome();
        $email = $user->getEmail();
        $img_profilo = $user->getImgProfilo();
        if($img_profilo != null){
            $pic64 = $img_profilo->getImmagine();
            $type = $img_profilo->getType();
        }else{
            $pic64 = "";
            $type = "";
        }
        $this->smarty->assign("username",$username);
        $this->smarty->assign("nome",$nome);
        $this->smarty->assign("cognome",$cognome);
        $this->smarty->assign("email",$email);
        $this->smarty->assign("pic64",$pic64);
        $this->smarty->assign("type",$type);

        if(get_class($user) =="EUtente"){
            $locali_preferiti = $pm->getLocaliPreferiti($username);
            $this->smarty->assign("locali_preferiti",$locali_preferiti);
            $this->smarty->display('areaPersonaleUtente.tpl');
        }elseif (get_class($user)=="EProprietario"){
            $locali = $pm->load("proprietario", $username, "FLocale");
            $this->smarty->assign("locali",$locali);
            $this->smarty->display('areaPersonaleProprietario.tpl');
        }
    }

}