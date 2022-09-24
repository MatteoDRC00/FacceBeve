<?php
require_once "autoload.php";
require_once "utility/USession.php";

/**
 * La classe CGestioneLocale viene utilizzata per eseguire le operazioni CRUD sul locale con tutte le relative informazioni (orario, immagini, …).
 * @author Gruppo 8
 * @package Controller
 */
class CGestioneLocale
{
    /**
     * @var CGestioneLocale|null Variabile di classe che mantiene l'istanza della classe.
     */
    public static ?CGestioneLocale $instance = null;

    /**
     * Costruttore della classe.
     */
    private function __construct()
    {
    }

    /**
     * Restituisce l'istanza della classe.
     * @return CAccesso|null
     */
    public static function getInstance(): ?CGestioneLocale
    {
        if (!isset(self::$instance)) {
            self::$instance = new CGestioneLocale();
        }
        return self::$instance;
    }

    public function mostraFormCreaLocale()
    {
        $sessione = new USession();
        if ($sessione->isLogged() && $sessione->leggi_valore("tipo_utente") == "EProprietario") {
            $view = new VGestioneLocale();
            $pm = FPersistentManager::getInstance();
            $categorie = $pm->getCategorie();
            $view->showFormCreaLocale($categorie);
        } else {
            header("Location: /Ricerca/mostraHome");
        }
    }

    public function mostraGestioneLocale($id_locale)
    {
        $sessione = new USession();
        $username = $sessione->leggi_valore("utente");
        $tipo = $sessione->leggi_valore("tipo_utente");
        $pm = FPersistentManager::getInstance();
        $view = new VGestioneLocale();
        $locale = $pm->load("id", $id_locale, "FLocale");

        if ($sessione->isLogged() && $tipo == "EProprietario") {
            $categorie = $pm->getCategorie();
            $eventi = $pm->getEventiByLocale($locale[0]->getId());
            $immagini = $pm->getImmaginiByLocale($id_locale);

            $view->showFormModificaLocale($locale[0], $categorie, $eventi, $immagini);
        }
    }


    /**
     * @return void
     */
    public function creaLocale()
    {
        $sessione = new USession();
        $pm = FPersistentManager::getInstance();
        $username = $sessione->leggi_valore('utente');
        $tipo = $sessione->leggi_valore("tipo_utente");


        $proprietario = $pm->load("username", $username, "FProprietario");


        if ($sessione->isLogged() && $tipo == "EProprietario") {

            $view = new VGestioneLocale();
            $nomeLocale = $view->getNomeLocale();
            $descrizione = $view->getDescrizioneLocale();
            $numTelefono = $view->getNumTelefono();

            $indirizzo = $view->getIndirizzo();
            $numeroCivico = $view->getNumeroCivico();
            $citta = $view->getCitta();
            $CAP = $view->getCAP();
            $localizzazioneLocale = new ELocalizzazione($indirizzo, $numeroCivico, $citta, $CAP);
            $id_Localizzazione = $pm->store($localizzazioneLocale);
            $localizzazioneLocale->setId($id_Localizzazione);

            $locale = new ELocale($nomeLocale, $descrizione, $numTelefono, $proprietario, $localizzazioneLocale);
            $id_locale = $pm->store($locale);
            $locale->setId($id_locale);

            $generi = $view->getCategorie();

            $categorie = array();

            foreach ($generi as $genere) {
                $pm->storeEsterne("Locale_Categorie", "ID_Locale", "ID_Categoria", $id_locale, $genere);
                $categorie = $pm->load("genere", $genere, "FCategoria");
            }
            $locale->setCategoria($categorie);

            $orario_apertura = $view->getOrarioApertura();
            $orario_chiusura = $view->getOrarioChiusura();
            $chiuso = $view->getOrarioClose();


            $giorni_chiusi = array(0, 0, 0, 0, 0, 0, 0);

            for ($i = 0; $i < count($chiuso); $i++) {
                $giorni_chiusi[$chiuso[$i]] = 1;
            }

            $o = array();

            for ($i = 0; $i < 7; $i++) {
                if ($i == 0)
                    $giorno = "Lunedì";
                elseif ($i == 1)
                    $giorno = "Martedì";
                elseif ($i == 2)
                    $giorno = "Mercoledì";
                elseif ($i == 3)
                    $giorno = "Giovedì";
                elseif ($i == 4)
                    $giorno = "Venerdì";
                elseif ($i == 5)
                    $giorno = "Sabato";
                elseif ($i == 6)
                    $giorno = "Domenica";

                if ($giorni_chiusi[$i] == 0) {
                    if ($orario_apertura[$i] != null && $orario_chiusura[$i] != null) {
                        $orario = new EOrario($giorno, $orario_apertura[$i], $orario_chiusura[$i]);
                        $id = $pm->store($orario);
                        $orario->setId($id);
                        $o[] = $orario;
                        $pm->storeEsterne("Locale_Orari", "ID_Locale", "ID_Orario", $id_locale, $id);
                    } else {
                        $message = "Inserire entrambi i campi degli orari ";
                        echo "<script type='text/javascript'>
                            alert('$message');
                            window.location.replace('/GestioneLocale/mostraFormCreaLocale');
                            </script>";
                    }
                } else {
                    $orario = new EOrario($giorno, "Chiuso", "Chiuso");
                    $id = $pm->store($orario);
                    $orario->setId($id);
                    $o[] = $orario;
                    $pm->storeEsterne("Locale_Orari", "ID_Locale", "ID_Orario", $id_locale, $id);
                }
            }

            $locale->setOrario($o);

            $img = $view->getImgLocale();
            if (!empty($img)) {
                $img_locale = new EImmagine($img[0], $img[1], $img[2], $img[3]);
                $id = $pm->store($img_locale);
                $img_locale->setId($id);
                $pm->storeEsterne("Locale_Immagini", "ID_Locale", "ID_Immagine", $id_locale, $id);
            }
            header('Location: /Profilo/mostraProfilo');
        } else {
            header('Location: /Ricerca/mostraHome');
        }
    }

    /**
     * Funzione che gestisce la modifica del nome del Locale. Preleva il nuovo nome dalla View e procede alla modifica.
     * @return void
     * @throws SmartyException
     */
    public function modificaNomeLocale($id_locale)
    {
        $sessione = new USession();
        $username = $sessione->leggi_valore("utente");
        $tipo = $sessione->leggi_valore("tipo_utente");
        $pm = FPersistentManager::getInstance();
        $view = new VGestioneLocale();

        $locale = $pm->load("id", $id_locale, "FLocale");

        if ($sessione->isLogged() && $tipo == "EProprietario") {
            $nomeNuovo = $view->getNomeLocale();
            $pm->update("FLocale", "nome", $nomeNuovo, "id", $id_locale);
            $locale[0]->setNome($nomeNuovo);
            header("Location: /GestioneLocale/mostraGestioneLocale/" . $id_locale);
        } else {
            header('Location: /Ricerca/mostraHome');
        }
    }

    /**
     * Funzione che gestisce la modifica della descrizione del Locale. Preleva la nuova descrizione dalla View e procede alla modifica.
     * @return void
     * @throws SmartyException
     */
    public function modificaDescrizioneLocale($id_locale)
    {
        $sessione = new USession();
        $username = $sessione->leggi_valore("utente");
        $tipo = $sessione->leggi_valore("tipo_utente");
        $pm = FPersistentManager::getInstance();
        $view = new VGestioneLocale();
        $locale = $pm->load("id", $id_locale, "FLocale");

        if ($sessione->isLogged() && $tipo == "EProprietario") {
            $newDescrizione = $view->getDescrizioneLocale();
            $pm->update("FLocale", "descrizione", $newDescrizione, "id", $id_locale);
            $locale[0]->setDescrizione($newDescrizione);
            header("Location: /GestioneLocale/mostraGestioneLocale/" . $id_locale);
        } else {
            header('Location: /Ricerca/mostraHome');
        }
    }

    /**
     * Funzione che gestisce la modifica il numero di telefono del Locale. Preleva il nuovo numero di telefono dalla View e procede alla modifica.
     * @return void
     * @throws SmartyException
     */
    public function modificaNumTelefonoLocale($id_locale)
    {
        $sessione = new USession();
        $username = $sessione->leggi_valore("utente");
        $tipo = $sessione->leggi_valore("tipo_utente");
        $pm = FPersistentManager::getInstance();
        $view = new VGestioneLocale();
        $locale = $pm->load("id", $id_locale, "FLocale");

        if ($sessione->isLogged() && $tipo == "EProprietario") {
            $numeroTelefono = $view->getNumTelefono();
            $pm->update("FLocale", "numtelefono", $numeroTelefono, "id", $id_locale);
            $locale[0]->setNumTelefono($numeroTelefono);
            header("Location: /GestioneLocale/mostraGestioneLocale/" . $id_locale);
        } else {
            header('Location: /Ricerca/mostraHome');
        }
    }

    /**
     * @param $id_locale
     * @return void
     */
    public function modificaCategorieLocale($id_locale)
    {
        $sessione = new USession();
        $username = $sessione->leggi_valore("utente");
        $tipo = $sessione->leggi_valore("tipo_utente");
        $pm = FPersistentManager::getInstance();
        $view = new VGestioneLocale();
        $locale = $pm->load("id", $id_locale, "FLocale");

        if ($sessione->isLogged() && $tipo == "EProprietario") {
            $generi = $view->getCategorie();
            $pm->deleteEsterne("Locale_Categorie", "ID_Locale", $id_locale);
            foreach ($generi as $genere) {
                $categoria = $pm->load("genere", $genere, "FCategoria");
                $pm->storeEsterne("Locale_Categorie", "ID_Locale", "ID_Categoria", $id_locale, $genere);
                $categorie = array_merge($categoria);
            }
            $locale->setCategoria($categorie);

            header("Location: /GestioneLocale/mostraGestioneLocale/" . $id_locale);
        } else {
            header('Location: /Ricerca/mostraHome');
        }
    }

    /**
     * @param $id_locale
     * @return void
     */
    public function modificaLocalizzazioneLocale($id_locale)
    {
        $sessione = new USession();
        $username = $sessione->leggi_valore("utente");
        $tipo = $sessione->leggi_valore("tipo_utente");
        $pm = FPersistentManager::getInstance();
        $view = new VGestioneLocale();
        $locale = $pm->load("id", $id_locale, "FLocale");

        if ($sessione->isLogged() && $tipo == "EProprietario") {

            $id_localizzazione = $locale[0]->getLocalizzazione()->getId();

            $indirizzo = $view->getIndirizzo();
            $pm->update("FLocalizzazione", "indirizzo", $indirizzo, "id", $id_localizzazione);

            $numCivico = $view->getNumeroCivico();
            $pm->update("FLocalizzazione", "numCivico", $numCivico, "id", $id_localizzazione);

            $citta = $view->getCitta();
            $pm->update("FLocalizzazione", "citta", $citta, "id", $id_localizzazione);

            $cap = $view->getCAP();
            $pm->update("FLocalizzazione", "CAP", $cap, "id", $id_localizzazione);

            $localizzazioneNuova = new ELocalizzazione($indirizzo, $numCivico, $citta, $cap);
            $localizzazioneNuova->setId($id_localizzazione);

            $locale[0]->setLocalizzazione($localizzazioneNuova);
            header("Location: /GestioneLocale/mostraGestioneLocale/" . $id_locale);
        } else {
            header('Location: /Ricerca/mostraHome');
        }
    }

    /**
     * Funzione che gestisce la modifica dell'orario del locale. Preleva il nuovo orario dalla View e procede alla modifica.
     * @return void
     * @throws SmartyException
     */
    public function modificaOrarioLocale($id_locale)
    {
        $sessione = new USession();
        $username = $sessione->leggi_valore("utente");
        $tipo = $sessione->leggi_valore("tipo_utente");
        $pm = FPersistentManager::getInstance();
        $view = new VGestioneLocale();
        $locale = $pm->load("id", $id_locale, "FLocale");

        if ($sessione->isLogged() && $tipo == "EProprietario") {

            $pm->deleteEsterne("Locali_Orari", "ID_Locale", $id_locale);

            $orario_apertura = $view->getOrarioApertura();
            $orario_chiusura = $view->getOrarioChiusura();
            $chiuso = $view->getOrarioClose();

            $giorni_chiusi = array(0, 0, 0, 0, 0, 0, 0);

            for ($i = 0; $i < count($chiuso); $i++) {
                $giorni_chiusi[$chiuso[$i]] = 1;
            }

            $o = array();

            for ($i = 0; $i < 7; $i++) {
                if ($i == 0)
                    $giorno = "Lunedì";
                elseif ($i == 1)
                    $giorno = "Martedì";
                elseif ($i == 2)
                    $giorno = "Mercoledì";
                elseif ($i == 3)
                    $giorno = "Giovedì";
                elseif ($i == 4)
                    $giorno = "Venerdì";
                elseif ($i == 5)
                    $giorno = "Sabato";
                elseif ($i == 6)
                    $giorno = "Domenica";

                if ($giorni_chiusi[$i] == 0) {
                    if ($orario_apertura[$i] != null && $orario_chiusura[$i] != null) {
                        $orario = new EOrario($giorno, $orario_apertura[$i], $orario_chiusura[$i]);
                        $id = $pm->store($orario);
                        $orario->setId($id);
                        $o[] = $orario;
                        $pm->storeEsterne("Locale_Orari", "ID_Locale", "ID_Orario", $id_locale, $id);
                    } else {
                        $message = "Inserire entrambi i campi degli orari ";
                        echo "<script type='text/javascript'>
                            alert('$message');
                            window.location.replace('/GestioneLocale/mostraFormCreaLocale');
                            </script>";
                    }
                } else {
                    $orario = new EOrario($giorno, "Chiuso", "Chiuso");
                    $id = $pm->store($orario);
                    $orario->setId($id);
                    $o[] = $orario;
                    $pm->storeEsterne("Locale_Orari", "ID_Locale", "ID_Orario", $id_locale, $id);
                }
            }
            $locale->setOrario($o);
            header("Location: /GestioneLocale/mostraGestioneLocale/" . $id_locale);
        } else {
            header('Location: /Ricerca/mostraHome');
        }
    }


    /**
     * Gestisce la modifica dell'immagine del locale. Preleva la nuova immagine dalla view e procede alla modifica.
     * @return void
     * @throws SmartyException
     */
    public function addImmagineLocale($id_locale)
    {
        $sessione = new USession();
        $username = $sessione->leggi_valore("utente");
        $tipo = $sessione->leggi_valore("tipo_utente");
        $pm = FPersistentManager::getInstance();
        $view = new VGestioneLocale();
        $locale = $pm->load("id", $id_locale, "FLocale");

        if ($sessione->isLogged() && $tipo == "EProprietario") {
            $img = $view->getImgLocale();
            if (!empty($img)) {
                $img_locale = new EImmagine($img[0], $img[1], $img[2], $img[3]);
                $id = $pm->store($img_locale);
                $img_locale->setId($id);
                $pm->storeEsterne("Locale_Immagini", "ID_Locale", "ID_Immagine", $id_locale, $id);
                $locale[0]->addImg($img_locale);
            }
            header("Location: /GestioneLocale/mostraGestioneLocale/" . $id_locale);
        } else {
            header('Location: /Ricerca/mostraHome');
        }
    }

    /**
     * @param $id_immagine
     * @return void
     */
    public function eliminaImmagineLocale($id_immagine)
    {
        $sessione = new USession();
        $username = $sessione->leggi_valore("utente");
        $tipo = $sessione->leggi_valore("tipo_utente");
        $pm = FPersistentManager::getInstance();

        if ($sessione->isLogged() && $tipo == "EProprietario") {
            $pm->deleteEsterne("Locale_Immagini", "ID_Immagine", $id_immagine);
            $pm->delete("id", $id_immagine, "FImmagine");
            header("Location: /Profilo/mostraProfilo/");
        } else {
            header('Location: /Ricerca/mostraHome');
        }
    }

    public function eliminaLocale($id_locale)
    {
        $sessione = new USession();
        $pm = FPersistentManager::getInstance();
        $username = $sessione->leggi_valore('utente');
        $tipo = $sessione->leggi_valore("tipo_utente");

        $locale = $pm->load("id", $id_locale, "FLocale");

        if ($sessione->isLogged() && $tipo == "EProprietario") {
            $pm->deleteLocaleEvento($id_locale);
            $pm->deleteCategorieLocale($id_locale);
            $pm->deleteOrariLocale($id_locale);
            $pm->deleteUtenteLocale($id_locale);

            $pm->delete("id", $locale[0]->getLocalizzazione()->getId(), "FLocalizzazione");
            $pm->delete("id", $id_locale, "FLocale");
            header("Location: /Profilo/mostraProfilo");
        } else {
            header("Location: /Ricerca/mostraHome");
        }
    }

}