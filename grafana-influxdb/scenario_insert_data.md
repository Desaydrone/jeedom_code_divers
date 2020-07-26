```php

// EXEMPLE D'un bloc code dans un scénario pour implémenter une table
// dans influxdb depuis jeedom (sans le plugin-influxdb)

$host		= 'IP_SERVEUR_INFLUXDB'; //c'est l'ip de la machine qui héberge influx
$port		= '8086';
$base		= 'BDD_INLUFXDB';        // nom de la base (il faut qu'elle existe)
$table		= 'TABLE_DANS_LA_BDD';        // nom de la table

//Entête de la réquete
$req='curl -i -XPOST "'.$host.':'.$port.'/write?db='.$base.'" --data-binary \''.$table.',';

// RECUPERATION TEMPERATURE
// ID des commandes reperez les ID des commandes 
// et donner un nom dans la table
$cmd = cmd::byId(4109);$input1  = $cmd->execCmd();$c1='Bureau';
$cmd = cmd::byId(4101);$input2  = $cmd->execCmd();$c2='Chambre';
$cmd = cmd::byId(4117);$input3  = $cmd->execCmd();$c3='Cuisine';
$cmd = cmd::byId(4091);$input4  = $cmd->execCmd();$c4='Salon';
$cmd = cmd::byId(3142);$input5  = $cmd->execCmd();$c5='SalledeBain';
$cmd = cmd::byId(2172);$input6  = $cmd->execCmd();$c6='Salon';
//$cmd = cmd::byId(2173);$input7  = $cmd->execCmd();$c7='SalleAManger';


$req2='valeur=temperature '.$c1.'='.$input1.','.$c2.'='.$input2.','.$c3.'='.$input3.','.$c4.'='.$input4.','.$c5.'='.$input5.'\' ';

$scenario->setLog(' Requete : '.$req.$req2);
$output0 = shell_exec($req.$req2);
$scenario->setLog('DEBUG RETOUR Temperature: '.$output0);

//RECUPERATION HUMIDITE
// ID des commandes reperez les ID des commandes 
// et donner un nom dans la table
$cmd = cmd::byId(4110);$input1  = $cmd->execCmd();
$cmd = cmd::byId(4102);$input2  = $cmd->execCmd();
$cmd = cmd::byId(4118);$input3  = $cmd->execCmd();
$cmd = cmd::byId(4092);$input4  = $cmd->execCmd();

$req2 = 'valeur=humidite '.$c1.'='.$input1.','.$c2.'='.$input2.','.$c3.'='.$input3.','.$c4.'='.$input4.'\' ';
$output0 = shell_exec($req.$req2);
$scenario->setLog('DEBUG RETOUR Temperature: '.$output0);

//RECUPERATION Info electrique
// ID des commandes reperez les ID des commandes 
// et donner un nom dans la table
$cmd = cmd::byId(4398);$input1  = $cmd->execCmd();
$cmd = cmd::byId(4401);$input2  = $cmd->execCmd();
$cmd = cmd::byId(4399);$input3  = $cmd->execCmd();


$req2='valeur=puissance_electrique '.$c4.'='.$input1.'\' ';
$output0 = shell_exec($req.$req2);
$req2 = 'valeur=conso_multimedia '.$c4.'='.$input2.'\' ';
$output0 = shell_exec($req.$req2);
$req2 = 'valeur=conso_luminaire '.$c4.'='.$input3.'\' ';
$output0 = shell_exec($req.$req2);

```
