<?php
/**
 * La classe CGestioneEvento viene utilizzata per eseguire le operazioni CRUD sugli eventi di un locale.
 * @author Gruppo 8
 * @package Controller
 */
class CGestioneEvento{

    /**
     * @var CGestioneEvento|null Variabile di classe che mantiene l'istanza della classe.
     */
    private static ?CGestioneEvento $instance = null;

    /**
     * Costruttore della classe.
     */
    private function __construct(){}

    /**
     * Restituisce l'istanza della classe.
     * @return CGestioneEvento|null
     */
    public static function getInstance(): ?CGestioneEvento{
        if(!isset(self::$instance)) {
            self::$instance = new CGestioneEvento();
        }
        return self::$instance;
    }


    /**
     * Funzione che viene richiamata per la creazione di un evento. Si possono avere diverse situazioni:
     * se l'utente non è loggato  viene reindirizzato alla pagina di login perchè solo gli utenti loggati possono interagire con gli eventi.
     * se l'utente è loggato come Proprietario(solo loro possono aggiungere eventi):
     * 1) se il metodo di richiesta HTTP è GET viene visualizzato il form di creazione della ricerca;
     * 2) se il metodo di richiesta HTTP è POST viene richiamata la funzione Creation().
     * 3) se il metodo di richiesta HTTP è diverso da uno dei precedenti -->errore.
     */
    static function creaEvento()
    {
        $sessione = USession::getInstance();
        if ($proprietario = unserialize($sessione->leggi_valore('utente'))) {
            if ($_SERVER['REQUEST_METHOD'] == "GET") {
                $view = new VGestioneAnnunci();
                $proprietario = unserialize($proprietario = unserialize($sessione->leggi_valore('utente')));
                if (get_class(proprietario) == "EProprietario") {
                    $view->showFormCreation($proprietario, null);
                } elseif (get_class($proprietario) == "EUtente") {
                    $view->showFormCreation($proprietario, "errore da definire");
                }
            } elseif ($_SERVER['REQUEST_METHOD'] == "POST") {
                $pm = FPersistentManager::GetIstance();
                $proprietario = unserialize($proprietario = unserialize($sessione->leggi_valore('utente')));
                if (get_class(proprietario) == "EProprietario") {
                    $view = new VGestioneLocale();
                    $nomeEvento = $view->getNomeEvento();
                    $descrizioneEvento = $view->getDescrizioneEvento();
                    $dataEvento = $view->getDataEvento();

                    $Evento = new EEvento($nomeEvento, $descrizioneEvento, $dataEvento); //Poi salvalo nel locale

                    list ($stato, $nome, $type) = static::upload('img'); //mo non mi sta tornando RIP


                } elseif (get_class($proprietario) == "EUtente") {
                    header('Location: /FacceBeve/');
                }
            }
        } else {
            header('Location: /FacceBeve/Utente/Login');
        }
    }


    //Metodi Statici\\
    /**
     * Funzione che si preoccupa di verificare lo stato dell'immagine inserita
     * @param $nome_file
     * @return array , dove $ris è lo stato dell'immagine, $nome è il nome dell'immagine e $type è il MIME type dell'immagine
     */
    static function upload($nome_file): array
    {
        //$ris = "no_img";
        $type = null;
        $nome = null;
        $max_size = 300000;
        $result = is_uploaded_file($_FILES[$nome_file]['tmp_name']); //true se è stato caricato via HTTP POST.
        if (!$result) {
            $ris = "no_img";
        } else {
            $size = $_FILES[$nome_file]['size'];
            //$type = $_FILES[$nome_file]['type'];
            if ($size > $max_size) {
                $ris = "size";
            } else {
                $type = $_FILES[$nome_file]['type'];
                if ($type == 'image/jpeg' || $type == 'image/png' || $type == 'image/jpg') {
                    $nome = $_FILES[$nome_file]['name'];
                    $ris = "ok_img";
                } else {
                    $ris = "type";
                }
            }
        }
        return array($ris, $nome, $type);
    }

}