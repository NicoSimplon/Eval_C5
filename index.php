<?php
   $connect = pg_connect("host=localhost port=5432 dbname=fais_pas_lpoireau user=admin password=admin");
   // condition pour tester la connection à la base de donnée
   // if($connect == true){
   //    echo "connecté";
   // }
   // else {
   //    echo "impossible de se connecter";
   // }


   //requêtes

   $requeteSto = pg_query("SELECT pro_nom, sum(st) 
                        FROM (SELECT pro_leg,pro_nom, -sto_qte as st
                        FROM stock
                        INNER JOIN produit ON pro_id=spro_id
                        WHERE sto_pert = True
                        UNION
                        SELECT pro_leg, pro_nom, sto_qte as st
                        FROM stock
                        INNER JOIN produit ON pro_id=spro_id
                        WHERE sto_pert = False
                        UNION 
                        SELECT pro_leg, pro_nom, -con_qte as st
                        FROM contenu
                        INNER JOIN produit ON cpro_id = pro_id) as s
                        GROUP BY pro_leg,pro_nom
                        ORDER BY  pro_leg,pro_nom;");

   $requeteFru = pg_query("SELECT pro_nom, sum(st) 
                        FROM (SELECT pro_leg,pro_nom, -sto_qte as st
                        FROM stock
                        INNER JOIN produit ON pro_id=spro_id
                        WHERE sto_pert = True
                        UNION
                        SELECT pro_leg, pro_nom, sto_qte as st
                        FROM stock
                        INNER JOIN produit ON pro_id=spro_id
                        WHERE sto_pert = False
                        UNION 
                        SELECT pro_leg, pro_nom, -con_qte as st
                        FROM contenu
                        INNER JOIN produit ON cpro_id = pro_id) as s
                        WHERE pro_leg = False
                        GROUP BY pro_leg,pro_nom
                        ORDER BY  pro_leg,pro_nom;");

   $requeteLeg = pg_query("SELECT pro_nom, sum(st) 
                        FROM (SELECT pro_leg,pro_nom, -sto_qte as st
                        FROM stock
                        INNER JOIN produit ON pro_id=spro_id
                        WHERE sto_pert = True
                        UNION
                        SELECT pro_leg, pro_nom, sto_qte as st
                        FROM stock
                        INNER JOIN produit ON pro_id=spro_id
                        WHERE sto_pert = False
                        UNION 
                        SELECT pro_leg, pro_nom, -con_qte as st
                        FROM contenu
                        INNER JOIN produit ON cpro_id = pro_id) as s
                        WHERE pro_leg = True
                        GROUP BY pro_leg,pro_nom
                        ORDER BY  pro_leg,pro_nom;");

   $requeteCom = pg_query("SELECT com_nom FROM commune;");

   $produits = "SELECT pro_nom FROM produit";

   $requetePro = pg_query($produits);
   $requetePro2 = pg_query($produits);
   $requetePro3 = pg_query($produits);
   $requetePro4 = pg_query($produits);
   $requetePro5 = pg_query($produits);
   $requetePro6 = pg_query($produits);
   $requetePro7 = pg_query($produits);
   $requetePro8 = pg_query($produits);
   $requetePro9 = pg_query($produits);
   $requetePro10 = pg_query($produits);

   // $requeteClas1 = pg_query("SELECT com_nom FROM commune;");

?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
      crossorigin="anonymous">
   <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
   <link rel="stylesheet" href="style.css">
   <title>Document</title>
</head>

<body>
   <!-- Menu -->
   <section class="navbar-top container-fluid">
      <div class="row">
         <div class="col-md-12 menu-logo">
            <img class="logo" src="/img/logo.png" alt="Logo de FaisPasLPoireau">
         </div>
      </div>
   </section>
   <!-- Fin menu  -->


   <!-- ///////// Listes à gauche /////////////////-->
   
   <section class="div-left">
      <div class="table-items col-md-3 stock">
      
      <h5><i class="fa fa-print fa-1x"></i>&nbsp;Stock</h5>         
      
         <!-- Boutons pour sélectionner quel tableau afficher -->
         <ul class="nav nav-tabs">
            <li class="nav-item">
               <a class="nav-link active" data-toggle="tab" href="#home">Tous</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" data-toggle="tab" href="#menu1">Fruits</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" data-toggle="tab" href="#menu2">Légumes</a>
            </li>
         </ul>
         <!-- Tableaux -->
         <div class="tab-content">
            <!-- Tableau Tous -->
            <div class="tab-pane active table-responsive" id="home">
               <table class="table">
                  <thead>
                     <tr>
                        <th id="name-column">Nom</th>
                        <th>Qté</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php 
                        $affichageSto=" ";
                        
                        while ($sto = pg_fetch_array($requeteSto)) {
                           $affichageSto.='<tr>
                                             <td>'.$sto[pro_nom].'</td>
                                             <td>'.$sto[sum].'</td>
                                          </tr>';
                        }

                        echo $affichageSto;

                        if ($sto[sum] <= 5) {

                           echo '<script type="text/javascript"> alert("Il faut se réapprovisionner.");</script>';

                        }

                     ?>
                  </tbody>
               </table>
            </div>
            <!-- Tableau Fruits -->
            <div class="tab-pane table-responsive" id="menu1">
               <table class="table">
                  <thead>
                     <tr>
                        <th id="name-column">Nom</th>
                        <th>Qté</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php 
                        $affichageFru=" ";

                        while ($fru = pg_fetch_array($requeteFru)) {
                           $affichageFru.='<tr>
                                             <td>'.$fru[pro_nom].'</td>
                                             <td>'.$fru[sum].'</td>
                                          </tr>';
                        }

                        echo $affichageFru;
                     ?>
                  </tbody>
               </table>
            </div>
            <!-- Tableau Légumes -->
            <div class="tab-pane table-responsive" id="menu2">
               <table class="table">
                  <thead>
                     <tr>
                        <th id="name-column">Nom</th>
                        <th>Qté</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php 
                        $affichageLeg=" ";

                        while ($leg = pg_fetch_array($requeteLeg)) {
                           $affichageLeg.='<tr>
                                             <td>'.$leg[pro_nom].'</td>
                                             <td>'.$leg[sum].'</td>
                                          </tr>';
                        }

                        echo $affichageLeg;
                     ?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
      <!-- ///////// FIN Listes à gauche /////////////////-->


      <!-- ///////// DIVs colonne nouvelle vente et colonne ajouter/supprimer/géomarketing  /////////////////-->
      <div class="col-md-9">
         <div class="row">

            <!-- Nouvelle vente -->
            <div class="col-md-7">
               <div class="container new-sale">
                  <h5>Nouvelle vente</h5>
                  <!-- formulaire -->
                  <form action="">

                     <div class="row">
                        <div class="col-md-3">
                           <div class="form-group">
                              <label for="time">Heure</label>
                              <input type="number" class="form-control" id="" placeholder="00:00" disabled>
                           </div>
                        </div>
                        <div class="col-md-9">
                           <div class="form-group">
                              <label for="villes">Ville</label>
                              <!-- Menu déroulant -->
                              <select class="form-control" name="" id="">
                                 <?php 
                                    $affichageCom = " ";

                                    while($com = pg_fetch_array($requeteCom)){
                                       $affichageCom .= '<option value="">'.$com[com_nom].'</option>';
                                    }

                                    echo $affichageCom;

                                 ?>
                              </select>
                           </div>
                        </div>
                     </div>

                     <div class="row">
                        <div class="col-md-3">
                           <div class="form-group">
                              <label for="quantityToAdd">Quantité</label>
                              <input type="number" name="qte_vente1" class="form-control" id="" placeholder="">
                           </div>
                        </div>
                        <div class="col-md-9">
                           <div class="form-group">
                              <label for="itemToAdd">Fruit/Légume</label>
                              <!-- Menu déroulant -->
                              <select class="form-control" name="prodnom1" id="">
                                 <?php 
                                    $affichagePro = " ";

                                    while($pro = pg_fetch_array($requetePro)){
                                       $affichagePro .= '<option value="">'.$pro[pro_nom].'</option>';
                                    }

                                    echo $affichagePro;

                                 ?>
                              </select>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-3">
                           <div class="form-group">
                              <input type="number" name="qte_vente2"class="form-control" id="" placeholder="">
                           </div>
                        </div>
                        <div class="col-md-9">
                           <div class="form-group">
                              <!-- Menu déroulant -->
                              <select class="form-control" name="prodnom2" id="">
                                 <?php 
                                    $affichagePro2 = " ";

                                    while($pro = pg_fetch_array($requetePro2)){
                                       $affichagePro2 .= '<option value="">'.$pro[pro_nom].'</option>';
                                    }

                                    echo $affichagePro2;

                                 ?>
                              </select>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-3">
                           <div class="form-group">
                              <input type="number" name="qte_vente3" class="form-control" id="" placeholder="">
                           </div>
                        </div>
                        <div class="col-md-9">
                           <div class="form-group">
                              <!-- Menu déroulant -->
                              <select class="form-control" name="prodnom3" id="">
                                 <?php 
                                    $affichagePro3 = " ";

                                    while($pro = pg_fetch_array($requetePro3)){
                                       $affichagePro3 .= '<option value="">'.$pro[pro_nom].'</option>';
                                    }

                                    echo $affichagePro3;

                                 ?>
                              </select>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-3">
                           <div class="form-group">
                              <input type="number" name="qte_vente4" class="form-control" id="" placeholder="">
                           </div>
                        </div>
                        <div class="col-md-9">
                           <div class="form-group">
                              <!-- Menu déroulant -->
                              <select class="form-control" name="prodnom4" id="">
                                 <?php 
                                    $affichagePro4 = " ";

                                    while($pro = pg_fetch_array($requetePro4)){
                                       $affichagePro4 .= '<option value="">'.$pro[pro_nom].'</option>';
                                    }

                                    echo $affichagePro4;

                                 ?>
                              </select>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-3">
                           <div class="form-group">
                              <input type="number" name="qte_vente5" class="form-control" id="" placeholder="">
                           </div>
                        </div>
                        <div class="col-md-9">
                           <div class="form-group">
                              <!-- Menu déroulant -->
                              <select class="form-control" name="prodnom5" id="">
                                 <?php 
                                    $affichagePro5 = " ";

                                    while($pro = pg_fetch_array($requetePro5)){
                                       $affichagePro5 .= '<option value="">'.$pro[pro_nom].'</option>';
                                    }

                                    echo $affichagePro5;

                                 ?>
                              </select>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-3">
                           <div class="form-group">
                              <input type="number" name="qte_vente6" class="form-control" id="" placeholder="">
                           </div>
                        </div>
                        <div class="col-md-9">
                           <div class="form-group">
                              <!-- Menu déroulant -->
                              <select class="form-control" name="prodnom6" id="">
                                 <?php 
                                    $affichagePro6 = " ";

                                    while($pro = pg_fetch_array($requetePro6)){
                                       $affichagePro6 .= '<option value="">'.$pro[pro_nom].'</option>';
                                    }

                                    echo $affichagePro6;

                                 ?>
                              </select>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-3">
                           <div class="form-group">
                              <input type="number" name="qte_vente7" class="form-control" id="" placeholder="">
                           </div>
                        </div>
                        <div class="col-md-9">
                           <div class="form-group">
                              <!-- Menu déroulant -->
                              <select class="form-control" name="prodnom7" id="">
                                 <?php 
                                    $affichagePro7 = " ";

                                    while($pro = pg_fetch_array($requetePro7)){
                                       $affichagePro7 .= '<option value="">'.$pro[pro_nom].'</option>';
                                    }

                                    echo $affichagePro7;

                                 ?>
                              </select>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-3">
                           <div class="form-group">
                              <input type="number" name="qte_vente8" class="form-control" id="" placeholder="">
                           </div>
                        </div>
                        <div class="col-md-9">
                           <div class="form-group">
                              <!-- Menu déroulant -->
                              <select class="form-control" name="prodnom8" id="">
                                 <?php 
                                    $affichagePro8 = " ";

                                    while($pro = pg_fetch_array($requetePro8)){
                                       $affichagePro8 .= '<option value="">'.$pro[pro_nom].'</option>';
                                    }

                                    echo $affichagePro8;

                                 ?>
                              </select>
                           </div>
                        </div>
                     </div>
                     <br>
                     <div class="action-buttons">
                        <button class="btn btn-danger" type="submit">Annuler</button>
                        <button class="btn btn-success" type="submit">Valider</button>
                     </div>

                  </form>
               </div>
            </div>

            <!-- Ajouter/Supprimer/Géomarketing -->
            <div class="col-md-5 right-panel">

               <!-- Ajouter - Nouvelle entrée dans le stock -->
               <h5>Nouvelle entrée dans le stock</h5>
               <!-- formulaire -->
               <form method="post" action="">
                  <div class="container">
                     <div class="row">

                        <div class="col-md-4">
                           <div class="form-group">
                              <label for="quantityToAdd">Quantité</label>
                              <input type="number" class="form-control" id="" placeholder="" name="qtepro">
                           </div>
                        </div>
                        <div class="col-md-8">
                           <div class="form-group">
                              <label for="itemToAdd">Fruit/Légume</label>
                              <!-- Menu déroulant -->
                              <select class="form-control" name="prodAjt" id="">
                                 <?php 
                                    $affichagePro9 = " ";

                                    while($pro = pg_fetch_array($requetePro9)){
                                       $affichagePro9 .= '<option value="">'.$pro[pro_nom].'</option>';
                                    }

                                    echo $affichagePro9;

                                    if(isset($_POST['ajoutProd'])){
                                       $pronom = $_POST['prodAjt'];

                                       $qte = $_POST['qtepro'];

                                       $ajout = "UPDATE stock SET sto_qte = sto_qte + ".$qte." WHERE spro_id = (SELECT pro_id FROM produit WHERE pro_nom = '".$pronom."')";
                                        
                                       pg_query($ajout);
                                    }

                                 ?>
                              </select>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="action-buttons">
                     <button type="submit" class="btn btn-success" name="ajoutProd">Ajouter</button>
                  </div>
               </form>

               <!-- Supprimer - Quantité perdue/jetée -->
               <h5>Quantité perdue/jetée</h5>
               <!-- formulaire -->
               <form method="post" action="">
                  <div class="container">
                     <div class="row">

                        <div class="col-md-4">
                           <div class="form-group">
                              <label for="quantityToRemove">Quantité</label>
                              <input type="number" class="form-control" id="" placeholder="" name="qte_jetee">
                           </div>
                        </div>
                        <div class="col-md-8">
                           <div class="form-group">
                              <label for="itemToRemove">Fruit/Légume</label>
                              <!-- Menu déroulant -->
                              <select class="form-control" name="pro_jetee" id="">
                                 <?php 
                                    $affichagePro10 = " ";

                                    while($pro = pg_fetch_array($requetePro10)){
                                       $affichagePro10 .= '<option value="">'.$pro[pro_nom].'</option>';
                                    }

                                    echo $affichagePro10;

                                    if(isset($_POST['sup'])){
                                       $pronomje = $_POST['pro_jetee'];

                                       $qteje = $_POST['qte_jetee'];

                                       $jeter = "UPDATE stock SET sto_qte = sto_qte - ".$qteje." WHERE spro_id = (SELECT pro_id FROM produit WHERE pro_nom = '".$pronomje."');";
                                        
                                       pg_query($jeter);
                                    }

                                 ?>
                              </select>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="action-buttons">
                     <button type="submit" name="sup" class="btn btn-danger">Supprimer</button>
                  </div>
               </form>

               <!-- Geomarketing -->
               <div class="row">
                  <div class="col-md-9 geo-title">
                     <h5>
                        <i class="fa fa-print fa-1x icon-menu">&nbsp;</i>Géomarketing</h5>

                  </div>
                  <div class="col-md-3 geo">


                  </div>
               </div>
               <table class="table">
                  <thead>
                     <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nom</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <th scope="row">1</th>
                        <!-- <?php
                           $affichageClass = " ";

                           while($class = pg_fetch_array($requeteClas1)){
                              $affichageClass.='<th>'.$class[com_nom].'</th>';
                           }

                           echo $affichageClass;
                        ?> -->
                     </tr>

                  </tbody>
               </table>
            </div>
         </div>
      </div>
      <!-- ///////// FIN DIVs colonne nouvelle vente et colonne ajouter/supprimer/géomarketing  /////////////////-->

   </section>



   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
      crossorigin="anonymous"></script>
</body>

</html>