#!/usr/bin/php
<?php
$scandir = scandir("./");
$fichier = fopen("comm.dat","w");
$fichier_t = fopen("tableau.dat", "w");
$new_file = fopen("text.dat", "w");
foreach($scandir as $fic){
   if(preg_match("#\.(txt)$#",strtolower($fic))){
       
    $nom_fichier_i = file($fic);
    // Ouvrez le fichier "text.dat" en mode "a" (ajout)
    $handle = fopen("text.dat", "a");
    $deb = 0;
    foreach ($nom_fichier_i as $nom)
    {
        $nom = str_replace("   ","",$nom);
        $nom = str_replace("  ","",$nom);
        $nom = str_replace("\n","|",$nom);
        if (strpos(strtoupper($nom),"CODE=") !== false)
        {
             $nom = str_replace(" ","",$nom);
             $nom = str_ireplace("CODE=","",$nom);
             fwrite($handle,strtoupper("$nom"));
        }
        if (strpos(strtoupper($nom),"TITRE=") !== false)
        {
          $nom = str_replace("|","",$nom);
          $nom = str_ireplace("SOUS_TITRE=","^",$nom);
          $nom = str_ireplace("TITRE=","",$nom);

          fwrite($handle,"$nom");
          if (strpos(strtoupper($nom),"SOUS_TITRE=") !== false)
          {  
            echo("$nom\n");
            $nom = str_replace("|","",$nom);
            fwrite($handle,"");
          }
          else
          { 
            fwrite($handle,"");
          }
        }
        
        if(strpos(strtoupper($nom),"FIN_TEXTE") !== false)
        {
          fwrite($handle,"|");
          $deb = 0; 
        }
        if($deb === 1)
        {  
          $nom = str_replace("|","",$nom);
          fwrite($handle,"$nom");
        }
        if (strpos(strtoupper($nom),"BUT_TEXTE") !== false)
        {  
          $deb = 1;
          fwrite($handle,"|");
        }
    }
    fwrite($handle,"\n");
    // Fermez le fichier
    fclose($handle);


       /********************************************* */
 
       $nom_fichier_tab = file($fic);
       foreach ($nom_fichier_tab as $nom){
           if (strpos($nom,"Prod #") !== false){
               //$nom = str_replace("\n","|",$nom);
               $tabTemp=explode('#', $nom);
					$tabTemp2=explode(',', $tabTemp[1]);
					$caEvo=(($tabTemp2[4]-$tabTemp2[2])/$tabTemp2[2])*100;
					$caEvo=round($caEvo, 2);
					$tabTemp[1] = rtrim($tabTemp[1]);
					$tabTemp[1] .= ",$caEvo%\n";
					fwrite($fichier_t, $tabTemp[1]);
           }   
       }
       fwrite($fichier_t, "|\n");
 
 
 
 
       /********************************************* */
      
       $nom_fichier = file($fic);
       $fichier = fopen("laLigne.dat","w");
       foreach ($nom_fichier as $nom){
           if (strpos(strtoupper($nom),"MEILLEURS") !== false){
               $reste = explode(":",$nom);
               fwrite($fichier,$reste[1]);
           }   
       }
       $lines = file("laLigne.dat");
       $salaire = fopen("salaire.dat","w");
       $code_Prenom = fopen("CodePrenom.dat","w");
       foreach ($lines as $a_line) {// pour chaque ligne, cle=indice et a_line=valeurs
           $a_line = rtrim($a_line);
           $parts = explode(",",$a_line);//parts= tablo des elem separer par ,
           foreach($parts as $personne){
               $info_arr = explode("=",$personne);
               $info_pers = $info_arr[0];
               $info_salaire = $info_arr[1];
               $salaire_fin = explode("K",$info_salaire);
               $res=$salaire_fin[0];
               fwrite($salaire,"$res,");
           }
       }
       $prenom = fopen("prenom.dat","w");
       foreach ($lines as $a_line) {// pour chaque ligne, cle=indice et a_line=valeurs
           $a_line = rtrim($a_line);
           $parts = explode(",",$a_line);//parts= tablo des elem separer par ,
           foreach($parts as $personne){
               $info_arr = explode("/",$personne);
               $info_pers = $info_arr[0];
               $info_salaire = $info_arr[1];
               $salaire_fin = explode("=",$info_salaire);
               $res=$salaire_fin[0];
               fwrite($prenom,"$res,");
               fwrite($code_Prenom,"$info_pers,");
           }
       }
       $string = fopen("salaire.dat","r");
       $o = fgets($string);
       $chiffre = explode(",",$o);//parts= tablo des elem separer par ,
       $i = count($chiffre);
       $elem2 = fopen("prenom.dat","r");
       $l = fgets($elem2);
       $lesPrenom = explode(",",$l);
 
       $elem3 = fopen("CodePrenom.dat","r");
       $l = fgets($elem3);
       $lesCodes = explode(",",$l);
       $salaire1=0;
       $pren1="r";
       $code1="r";
       $salaire2=0;
       $pren2="r";
       $code2="r";
       $salaire3=0;
       $pren3="r";
       $code3="r";
       for ($boucle = 0; $boucle < $i; $boucle++){
           if($salaire1<$chiffre[$boucle]){
 
               $salaireTmp=$salaire1;
               $nomTmp=$pren1;
               $codeTmp=$code1;
 
               $salaire1=$chiffre[$boucle];
               $pren1=$lesPrenom[$boucle];
               $code1=$lesCodes[$boucle];
 
               $salaireTmp2=$salaire2;
               $nomTmp2=$pren2;
               $codeTmp2=$code2;
 
               $salaire2=$salaireTmp;
               $pren2=$nomTmp;
               $code2=$codeTmp;
 
               $salaire3=$salaireTmp2;
               $pren3=$nomTmp2;
               $code3=$codeTmp2;
 
           }
           else if ($salaire2<$chiffre[$boucle]){
 
               $salaireTmp2=$salaire2;
               $nomTmp2=$pren2;
               $codeTmp2=$code2;
 
               $salaire2=$chiffre[$boucle];
               $pren2=$lesPrenom[$boucle];
               $code2=$lesCodes[$boucle];
 
               $salaire3=$salaireTmp2;
               $pren3=$nomTmp2;
               $code3=$codeTmp2;
 
           }
           else if($salaire3<$chiffre[$boucle]){
               $salaire3=$chiffre[$boucle];
               $pren3=$lesPrenom[$boucle];
               $code3=$lesCodes[$boucle];
           }
       }
       $fichier = fopen("comm.dat","a");
       $code1=strtolower($code1);
       $code2=strtolower($code2);
       $code3=strtolower($code3);
       fwrite($fichier,"$code1,$salaire1,$pren1,$code2,$salaire2,$pren2,$code3,$salaire3,$pren3\n");
   }
}
fclose($fichier);
fclose($fichier_t);

unlink("laLigne.dat");
unlink("prenom.dat");
unlink("salaire.dat");
unlink("CodePrenom.dat");
 
 
?>