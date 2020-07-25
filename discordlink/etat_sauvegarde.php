//======= Liste des fichiers sauvegarder sur partage samba

// On ajoute le contenu du fichier samba.repo.php dans notre page actuelle afin de pouvoir utiliser son code
require_once('/var/www/html/core/repo/samba.repo.php');
$backup = new repo_samba; // On créé une instance de la classe repo_samba nommée $backup
$backupsliste = $backup->backup_list(); //listeBackup(); // On appelle la fonction listeBackup de l’instance $backup de la classe repo_samba
$listingBackup = ""; // On vide la variable $listingBackup


//Ensuite on parcoure chaque élément du tableau $backupsliste afin de rajouter un retour à la ligne à la fin de chaque élément du tableau.
// Le but étant d’obtenir un affiche plaisant sur telegram
foreach($backupsliste as $backupname){
$listingBackup .= $backupname . "\n" ; // \n permet de rajouter un retour à la ligne
}
// On affecte le contenu de $listingBackup à la variable listeBackup que l’on appellera dans le message telegram ci-dessous
$scenario->setData('listeBackup',$listingBackup);

// ==== Fin partage samba


// ==== Script de transfert de fichier dans le cloud vie le plugin Cloudsync Pro
// Search pattern in log, return backup_error_code [0|1] Code fourni par zaibakker de community

$scenario->setData('backup_error_code', 0);
$log = '/var/www/html/log/cloudsyncpro';
$date_format = date('Y-m-d');
$pattern = "#\[$date_format.*Errors \([1-9][0-9]*\).*#";

$content_log = (file_get_contents($log));
preg_match_all($pattern, $content_log, $out, PREG_PATTERN_ORDER); // A RegEx grep in PHP
$error_array = $out[0]; // $out[0] contains the content matched by the RegEx
foreach($error_array as &$log_entry) {
    $scenario->setData('backup_error_code', 1);
    $scenario->setData('backup_error_output', $log_entry);
	$scenario->setLog("ALERT: Error found in log:" .$log_entry);
}

//==== Fin du script
