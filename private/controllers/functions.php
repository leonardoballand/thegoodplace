<?php

/**
 * CONFIGURATION
 */

define("TO", "webforce3php@gmail.com");
define("SUBJECT_CONTACT", "TheGoodPlace - Vous avez un nouveau message !");
define("SUBJECT_ANNONCE", "TheGoodPlace - Votre annonce me plaît beaucoup...");

/**
 * DEBUG
 */

function debug($array) {
    echo '<pre>';
    var_dump($array);
    echo '</pre>';
}

/**
 * Vérifie si une clé existe dans les paramètres de requête (GET/POST)
 */
    function checkInput($inputName)
    {
        // on vérifie si la clé est bien présente, et si la valeur n'est pas vide
        if (isset($_REQUEST[$inputName]) && !empty($_REQUEST[$inputName])) {
            $res = $_REQUEST[$inputName]; // on assigne à $res la valeur de l'input
        } else {
            $res = ''; // sinon on assigne à $res une chaine vide
        }

        // on nettoie la valeur de la clé
        $res = strip_tags($res);
        $res = trim($res);

        // on retourne la valeur
        return $res;
    }

    function checkFile($inputName)
    {
        // on vérifie si la clé est bien présente dans $_FILES, et si on a pas d'erreurs
        if (isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] == 0 ) {
            return $_FILES; // on retourne le tableau $_FILES
        }

        // on retourne une valeur vide
        return '';
    }

    /**
     * Vérifie si une clé existe dans les paramètres de $_COOKIE
     */
    function checkCookie($cookieName)
    {
        if (isset($_COOKIE[$cookieName]) && !empty($_COOKIE[$cookieName])) {
            $res = $_COOKIE[$cookieName]; // on assigne à $res la valeur de l'input
        } else {
            $res = ''; // sinon on assigne à $res une chaine vide
        }

        // on nettoie la valeur de la clé
        $res = strip_tags($res);
        $res = trim($res);

        // on retourne la valeur
        return $res;
    }

    /**
     * Affiche les messages d'erreur deformulaire
     */
    function displayFeedback()
    {
        if (isset($GLOBALS['feedback'])) {
            echo $GLOBALS['feedback']; 
        }
    }


/**
 * GESTION SESSIONS ET COOKIES
 */

    /**
     * On initialise la session quand 
     * l'utilisateur est connecté
     * en stockant dans $_SESSION
     * son id
     */
    function initSession($user)
    {
        $_SESSION['userid'] = $user['id']; // on stocke l'id de l'utilisateur
        $_SESSION['name'] = $user['name']; // on stocke le nom de l'utilisateur
        $_SESSION['email'] = $user['email']; // on stocke l'email de l'utilisateur
        $_SESSION['user_level'] = $user['user_level']; // on stocke le niveau d'administration de l'utilisateur
        $_SESSION['isLogged'] = true; // on sert sert de cette valeur pour vérifier que l'utilisateur est bien connecté
    }

    /**
     * On persiste la session
     * en créant un cookie avec setcookie()
     * puis on sauvegarde l'id de la session et l'ip de l'utilisateur
     * dans la BDD
     */
    function persistSession()
    {
        $userID = $_SESSION['userid']; // on récupère l'id utilisateur
        $sessionID = session_id(); // on récupère l'id de la session
        $sessionIP = $_SERVER['REMOTE_ADDR']; // on récupère l'ip du client

        // on créé un cookie avec l'id de la session, il expirera dans 30 jours (86400 = 1 jour)
        setcookie("thegoodplace_SESSIONID", $sessionID, time() + (86400 * 30), "/");
        
        // on va stocker en base l'id de la session + l'ip du visiteur
        $dbh = new PDO(DSN, USER, PASSWORD, DBOPTIONS);
        $sth = $dbh->prepare("UPDATE users SET sessionID = :sessionID, sessionIP = :sessionIP WHERE id = $userID;");

        $sth->execute(array(
            ':sessionID' => $sessionID,
            ':sessionIP' => $sessionIP
        ));
    }

    
/**
 * RESTRICTION D'ACCèS
 */

    /**
     * On protège nos pages
     */
    function protectPage()
    {
        $cookie = checkCookie('thegoodplace_SESSIONID'); // on vérifie si on a un cookie
        
        // var_dump($cookie);

        if (!isset($_SESSION['isLogged']) && $cookie == '') {
            // Si user pas connecté et pas de cookie,
            // on redirige vers la page connexion
            header('Location: connexion.php');
            exit;
        } else if (!isset($_SESSION['isLogged']) && $cookie != '') {
            // Si user pas connecté mais qu'il a un cookie
            // on restaure la session
            restoreSession($cookie);
        }
    }

    /**
     * Restaure la session de l'utilisateur
     * @param String - Session ID
     */
    function restoreSession($sessionID)
    {
        // On compare la session id et l'ip avec celles de la base
        $dbh = new PDO(DSN, USER, PASSWORD, DBOPTIONS);
        $sth = $dbh->prepare("SELECT id, sessionID, sessionIP FROM users WHERE sessionID = ? LIMIT 1;");
        $sth->execute(array($sessionID));

        $user = $sth->fetch();
        
        // On vérifie que l'ip et l'id de la session match
        if ($user['sessionID'] == $sessionID
        && $user['sessionIP'] == $_SERVER['REMOTE_ADDR']) {
            
            // On restaure la session avec session_id(id_de_la_session)
            session_id($sessionID);
            $_SESSION['isLogged'] = true;
        }
    }

    /**
     * Pour vérifier que l'utilisateur est connecté
     * @return Bool true - Si connecté
     * @return Bool false - Si pas connecté
     */
    function isLogged()
    {
        if (isset($_SESSION['isLogged'])) {
            return true;
        } 

        return false;
    }

    function isAdmin()
    {
        if (isset($_SESSION['user_level']) && $_SESSION['user_level'] > 3 ) {
            return true;
        }

        // Refactoring possible
        // if (isset($_SESSION['user_level'])) {
        //      return $_SESSION['user_level'] > 3;
        // }
    }

    function isCurrentUser()
    {
        // verifier que l'élement posté appartient à l'utilisateur
        // true / false
    }

    /**
     * Génère un token unique pour validation compte utilisateur
     * @return String - Identifiant unique
     * Affiche le hash MD5 - http://php.net/manual/fr/function.md5.php
     * Génère un identifiant unique - http://php.net/manual/fr/function.uniqid.php
     * Génère une valeur aléatoire - http://php.net/manual/fr/function.rand.php
     */
    function generateToken()
    {
        // A la place de stocker en mémoire le résultat et de le retourner
        // $token = md5(uniqid(rand()));
        // return $token;

        // On retourne directement le résultat
        return md5(uniqid(rand()));
    }

/**
 * RECUPERER INFOS USER
 */

    /**
     * Récupérer l'id de l'utilisateur
     * @return String - Id de l'utilisateur
     * @return String - Chaîne de caractère vide si pas de user id
     */
    function getUserID()
    {
        if (isset($_SESSION['userid'])) {
            return $_SESSION['userid'];
        }

        return '';
    }

/**
 * ENVOI D'EMAIL
 */

 function sendEmail($name, $email, $message)
 {
    // 4. Préparer l'email (formatage et préparation des données)
    $message = "
        Message reçu de $name \r\n
        Son email est $email \r\n
        Voici son message $message
    ";
    
    // 5. Envoyer l'email
    // destinaire $to
    // sujet $subject
    // message $message
    // options headers
    if (mail(TO, SUBJECT_CONTACT, $message)) {
        return true;
    } else {
        return false;
    }
    // on utilise la fonction PHP mail()
    // http://php.net/manual/fr/function.mail.php
 }

 function sendEmailHTML($fromName, $emailFrom, $emailTo, $message)
 {
    // on prépare le message HTML
    // headers pour HTML dans les exemples de la doc http://php.net/manual/fr/function.mail.php
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers = "Content-Type: text/html; charset=utf-8" . "\r\n";

    $message = '
    <html>
    <head>
        <title>' . SUBJECT_ANNONCE . '</title>
    </head>
    <body>
        <header>
            <img src="https://image.ibb.co/d8eL07/t_l_chargement.png" alt="logo" />
            <h1>TheGoodPlace</h1>
        </header>
        <div>
            <h5>Vous avez un nouveau message</h5>
            <p>' . $message . '</p>
            <small>Envoyé par <a href="mailto:'. $emailFrom . '">' . $fromName . '</a></small>
        </div>
    </body>
    </html>
    ';
    // on envoit l'email
    // et on retourne le résultat (true/false)
    if(mail($emailTo, SUBJECT_ANNONCE, $message, $headers)) {
        return true;
    } else {
        return false;
    }
 }

 function sendValidationEmail($emailTo, $validationToken)
 {
     var_dump($emailTo);
     var_dump($validationToken);
    // on prépare le message HTML
    // headers pour HTML dans les exemples de la doc http://php.net/manual/fr/function.mail.php
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers = "Content-Type: text/html; charset=utf-8" . "\r\n";

    $message = '
    <html>
    <head>
        <title>Activez votre compte TheGoodPlace</title>
    </head>
    <body>
        <header>
            <img src="https://image.ibb.co/d8eL07/t_l_chargement.png" alt="logo" />
            <h1>TheGoodPlace</h1>
        </header>
        <div style="text-align:center;">
            <h5>Merci d\'activer votre compte</h5>
            <p>
                <a href="localhost/goodplace/validation.php?email=' . $emailTo . '&token=' . $validationToken . '">Activer mon compte</a>
            </p>
        </div>
    </body>
    </html>
    ';
    // on envoit l'email
    // et on retourne le résultat (true/false)

    if(mail($emailTo, 'Activez votre compte TheGoodPlace', $message, $headers)) {
        return true;
    } else {
        return false;
    }
 }

/**
 * DATE HELPERS
 */

 /**
  * Pour savoir si la date fournie est aujourd'hui
  * @param Date - format DATETIME
  * @return Bool - true/false
  */
 function isToday($datetime)
 {
    $today = new DateTime();
    $date = new DateTime(date('Y-m-d', strtotime($datetime)));
    $interval = date_diff($today, $date); // http://php.net/manual/fr/function.date-diff.php

    if ($interval->format('%R%a') == -0) {
        return true;
    }
    
    return false;
 }

 /**
  * Retourne une classe bootstrap spéciale pour colorer du texte en fonction d'un statut
  * @param String - Status ['envoyé', 'erreur', 'en attente']
  * @return String - Classe bootstrap ['text-success', 'text-danger', 'text-muted']
  */
 function getClassStatus($status)
 {
     switch($status) {
         case 'envoyé':
            $statusColor = 'text-success';
            break;
         case 'erreur':
            $statusColor = 'text-danger';
            break;
         case 'en attente':
            $statusColor = 'text-muted';
            break;
     }

     return $statusColor;
 }

?>