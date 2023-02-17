#!/usr/bin/php

<?php
   $cpt = file("text.dat");
   $cpt2 = file("region.conf");
   
   $nbr_p=0;
   $i=0;
   for ($loop = 0; $loop < count($cpt); $loop+=1) {
   
   $conf = file("regions.conf");
   $elem_prem_ligne = explode(',', $conf[$loop]);

   $lines = file("text.dat");
   $parts = explode('|', $lines[$loop]);
   $parts = str_replace("^","\n\t",$parts);
   
   

   $comm = file("comm.dat");
   $com = explode(',', $comm[$loop]);
   $com[8] = str_replace("\n","",$com[8]);
   
   $tableau = file("tableau.dat");
    $res=false;
    while($res==false){
      if (strpos($tableau[$i],"|") !== false){
         $nbr_p++;
         $i++;
         $res=true;
      }
      else{
      $tmp[$i] = $tableau[$i];
      $i++;
      }
   }

   $val_tablo = "";
   foreach($tmp as $elem_quatre_tab){
      $nouv_tab_prem=explode(",",$elem_quatre_tab);
      $var_tablo = $var_tablo . "<tr>\n\t";
      $var_tablo = $var_tablo . "<td># " . $nouv_tab_prem[0] . "</td>\n";
      $var_tablo = $var_tablo . "<td>" . $nouv_tab_prem[1]. "</td>\n";
      $var_tablo = $var_tablo . "<td>" . $nouv_tab_prem[2]. "</td>\n";
      $var_tablo = $var_tablo . "<td>" . $nouv_tab_prem[3]. "</td>\n";
      $var_tablo = $var_tablo . "<td>" . $nouv_tab_prem[4]. "</td>\n";
      if (strpos($nouv_tab_prem[5],"-") !== false){
         $var_tablo = $var_tablo . '<td class="evolutionNegative">' . abs($nouv_tab_prem[5]) . "%</td>\n";
      }
      else{
         $var_tablo = $var_tablo . '<td class="evolutionPositive">' . $nouv_tab_prem[5]. "</td>\n";
      }
      $var_tablo = $var_tablo . "</tr>\n\t";
   }
   unset($tmp);
   $today = date("d-m-Y H:i");
   $handle = fopen("$parts[0].html", "w");
   fwrite($handle,"
<!DOCTYPE html>
<html lang=\"fr\">
<head>
   <meta charset=\"UTF-8\">
   <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
   <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
   <title>$elem_prem_ligne[0]</title>
   <link rel=\"stylesheet\" href=\"style.css\">
</head>
<body>
   <!-- PAGE DE COUVERTURE -->
   <section id=\"pageDeCouverture\">
      <h1>$elem_prem_ligne[0]</h1>
      <h2>$elem_prem_ligne[1] hab.</h2>
      <h2>$elem_prem_ligne[2] km<sup>2</sup></h2>
      <h2>$elem_prem_ligne[3] départements</h2>
      <div>
         <img id=\"logo\" src=\"images/$elem_prem_ligne[4] \" alt=\"logo Bretagne\" title=\"logo Bretagne\">
      </div>
      <div class=\"bottom\"></div>
   </section>

   <!-- PAGE 1 -->
   <section id=\"page1\">
         <h1>Résultats trimestriels 01-2023</h1> <!--<?php ?> PHP Date à calculer -->
         <div class=\"overflow\">
            <h2>$parts[1]</h2>
            <p>$parts[2] </p>

            <h3>$parts[3]</h3>
            <p>$parts[4]  </p>

            <h2>$parts[5]</h2>
            <p>$parts[6] </p>
         </div>

         <table>
            <caption>Tableau comparatif des résultats de ce trimestre et de celui de l'année précédente </caption>
            <tr>
               <th>Produit</th>
               <th>01-2023<br >Ventes</th>
               <th>01-2023<br >CA</th>
               <th>01-2022<br >Ventes</th>
               <th>01-2022<br >CA</th>
               <th>Évolution du CA</th>
            </tr>
            $var_tablo
         </table>

      <div class=\"bottom\">$today</div><!--<?php ?>-->
   </section>

   <!-- PAGE 2 -->
   <section id=\"page2\">
      <h1>Nos meilleurs commerciaux</h1><!-- Penser à modifier-->
      <div id=\"galeriePhotos\">
         <figure>
            <img classe=\"meilleurs_commerciaux\" src=\"photos_commerciaux/$com[0].png\" alt=\"$com[2]\" title=\"\">
            <figcaption><span class=\"nom\">$com[2]</span> <br> $com[1]K€</figcaption>
         </figure>
         <figure>
            <img classe=\"meilleurs_commerciaux\" src=\"photos_commerciaux/$com[3].png\" alt=\"$com[5]\" title=\"\">
            <figcaption><span class=\"nom\">$com[5]</span><br>$com[4]K€</figcaption>
         </figure>
         <figure>
            <img classe=\"meilleurs_commerciaux\" src=\"photos_commerciaux/$com[6].png\" alt=\"$com[8]\" title=\"\">
            <figcaption><span class=\"nom\">$com[8]</span><br>$com[7]K€</figcaption>
         </figure>
      </div>

      <div class=\"bottom\">$today</div><!--<?php ?>-->
   </section>

   <!-- PAGE 3 -->
   <section id=\"page3\">
      <a href=\"https://bigbrain.biz/$parts[0]\">Lien vers le site de la société</a>
      <img src=\"qrcodes/$parts[0].png\" alt=\"QR Code\" title=\"QR Code\">
      <p>
         <em>Crédits</em><br ><br >
         <a href=\"https://fr.wikipedia.org/\">Wikipédia<br >
         <a href=\"https://face.co\">Face Co</a>
      </p>
      <div class=\"bottom\">$today</div><!--<?php ?>-->
   </section>
</body>
</html>
");
unset($var_tablo);
fclose($handle);
fclose($comm);
fclose($conf);
fclose($tableau);
}
?>