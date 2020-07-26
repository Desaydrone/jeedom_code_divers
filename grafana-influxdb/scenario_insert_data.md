```php

// EXEMPLE D'un bloc code dans un scénario pour implémenter une table
// dans influxdb depuis jeedom (sans le plugin-influxdb)

$host		= 'IP_SERVEUR_INFLUXDV'; //c'est l'ip de la machine qui héberge influx
$port		= '8086';
$base		= 'BDD_INFLUXDB_CIBLE';        // nom de la base (il faut qu'elle existe)
$table		= 'TABLE_BDD';        // nom de la table

$c1='Bureau';
$c2='Chambre';
$c3='Cuisine';
$c4='Salon';
$c5='SalledeBain';
$c6='Salon';
$c7='SalleAManger';

//Entête de la réquete
$req_base='curl -i -XPOST "'.$host.':'.$port.'/write?db='.$base.'" --data-binary \''.$table.',';

// RECUPERATION TEMPERATURE
// ID des commandes reperez les ID des commandes 
// et donner un nom dans la table
$cmd = cmd::byId(4109);$input1  = $cmd->execCmd();
$cmd = cmd::byId(4101);$input2  = $cmd->execCmd();
$cmd = cmd::byId(4117);$input3  = $cmd->execCmd();
$cmd = cmd::byId(4091);$input4  = $cmd->execCmd();
$cmd = cmd::byId(3142);$input5  = $cmd->execCmd();
$cmd = cmd::byId(2172);$input6  = $cmd->execCmd();
//$cmd = cmd::byId(2173);$input7  = $cmd->execCmd();


//Definitition du tag
$requete_tag ='valeur=temperature ';

//requête contenant les données à ajouter
$requete=$c1.'='.$input1.','.$c2.'='.$input2.','.$c3.'='.$input3.','.$c4.'='.$input4.','.$c5.'='.$input5.'\' ';

$scenario->setLog(' Requete : '.$req_base.$requete_tag.$requete);
$output0 = shell_exec($req_base.$requete_tag.$requete);
$scenario->setLog('DEBUG RETOUR Temperature: '.$output0);

//RECUPERATION HUMIDITE
// ID des commandes reperez les ID des commandes 
// et donner un nom dans la table
$cmd = cmd::byId(4110);$input1  = $cmd->execCmd();
$cmd = cmd::byId(4102);$input2  = $cmd->execCmd();
$cmd = cmd::byId(4118);$input3  = $cmd->execCmd();
$cmd = cmd::byId(4092);$input4  = $cmd->execCmd();

$requete_tag = 'valeur=humidite ';
$requete = $c1.'='.$input1.','.$c2.'='.$input2.','.$c3.'='.$input3.','.$c4.'='.$input4.'\' ';
$output0 = shell_exec($req_base.$requete_tag.$requete);
$scenario->setLog('DEBUG RETOUR Temperature: '.$output0);

//RECUPERATION Info electrique
// ID des commandes reperez les ID des commandes 
// et donner un nom dans la table
$cmd = cmd::byId(4398);$input1  = $cmd->execCmd();
$cmd = cmd::byId(4401);$input2  = $cmd->execCmd();
$cmd = cmd::byId(4399);$input3  = $cmd->execCmd();

$requete_tag = 'valeur=puissance_electrique ';
$requete = $c4.'='.$input1.'\' ';
$output0 = shell_exec($req_base.$requete_tag.$requete);

$requete_tag = 'valeur=conso_multimedia ';
$requete = $c4.'='.$input2.'\' ';
$output0 = shell_exec($req_base.$requete_tag.$requete);

$requete_tag = 'valeur=conso_luminaire ';
$requete = $c4.'='.$input3.'\' ';
$output0 = shell_exec($req_base.$requete_tag.$requete);
$scenario->setLog('DEBUG RETOUR Temperature: '.$output0);


```
