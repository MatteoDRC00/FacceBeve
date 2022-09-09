<?php

require_once "Smarty/autoloader.php";
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
                    $this->smarty->assign('errorType',"Username già presente");
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

    //Metodi GET della View

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
     * Restituisce il nome del immagine da caricare, contenuto nel array _$_FILES, questo verrà poi passato al metodo upload per controllare la correttezza del file caricato
     * @return array
     */
    public function getNewImgProfilo(): array
    {
        return $_FILES['img']['name'];
    }
}