$batterie = "Batterie"; // Nom de la commande à rechercher
//$excludeEq = array("[Domotique][Mo]"); // Liste des équipements à ignorer (qui contiennent la commande "$batterie")
$excludeEq = array();
$msg = ""; //Message a envoyer sur l'état des batteries
$errEqLogics = array();
$etatBatterie = array(); //Tableau d'information sur la batterie consultée
$cpt_ok=0;
$cpt_w=0;
$cpt_a=0;

$eqLogics = eqLogic::all();


foreach($eqLogics as $eqLogic)
{
  try{
    if (isset($batterie))
    {
      	// si la commande n'existe pas, une exception est levée
    	$cmd = cmd::byString('#' . $eqLogic->getHumanName() . '['. $batterie .']#');
    }
    $allCmds = $eqLogic->getCmd();
    if (count($allCmds) > 0)
    {
      foreach($allCmds as $cmd)
      {  
        if (strpos($cmd->getHumanName(),$batterie) !== false)
        {
          $lenNom = ($lenNom < strlen($eqLogic->getName())) ? strlen($eqLogic->getName())+1 : $lenNom;
        }
      }
      //cho "taille plus grand : " .$lenNom;
      foreach($allCmds as $cmd)
      {  
        if (strpos($cmd->getHumanName(),$batterie) !== false)
        {
          $cmd->execCmd();
          
          $nbspace=str_repeat(' ',($lenNom - strlen($eqLogic->getName())));
          $etatBatterie=$eqLogic->getStatus();
          $nom=$eqLogic->getName();
          if($etatBatterie['batterydanger']==1)
          {
            $msg .= ":red_circle: `".$eqLogic->getName() . $nbspace ." ` - `". $etatBatterie['battery']." %`\n";
            $cpt_w+=1;
          }
          else if($etatBatterie['batterywarning']==1)
          {

            $msg .= ":orange_circle: `".$eqLogic->getName(). $nbspace ." ` - `".$etatBatterie['battery']." %`\n";
            $cpt_a+=1;
          }else
          {
           $cpt_ok+=1; 
          }
        }
      }
    }
  }catch (Exception $e)
  {
    // pas de commande
  }
  
}
$scenario->setData('message', $msg);
$scenario->setData('cpt_ok', $cpt_ok);
$scenario->setData('cpt_w', $cpt_w);
$scenario->setData('cpt_a', $cpt_a);
unset($msg);
unset($cpt_ok);
unset($cpt_w);
unset($cpt_a);
