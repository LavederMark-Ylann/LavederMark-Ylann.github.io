<?php

/**
 * Use init.php if you didn't install the package via Composer
 */
require_once 'vendor/autoload.php';

use AlexaCRM\CRMToolkit\Client as OrganizationService;
use AlexaCRM\CRMToolkit\Settings;
use AlexaCRM\CRMToolkit\Entity\EntityReference;
use PHPMailer\PHPMailer\PHPMailer;

// Récupération des données envoyées
$postdata = file_get_contents("php://input");

if (isset($postdata) && !empty($postdata)) {
  // Extraction des données
  $request = json_decode($postdata, true);

  // Validation des données reçues
  /*   if (
    $request['statut'] == '' || $request['batiment'] == '' || $request['age'] == '' ||
    $request['surface'] == '' || $request['habitants'] == '' || $request['adresse'] == '' ||
    $request['codePostal'] == '' || $request['ville'] == '' || $request['pays'] == '' ||
    $request['surfaceToit'] == '' || $request['consommation'] == '' || $request['sourceEnergie'] == '' ||
    $request['prenomNom'] == '' || $request['telephone'] == '' || $request['mail'] == ''
  ) {
    return http_response_code(400);
  } */

  // Nettoyage des données
  $statut = htmlspecialchars($request['statut'], ENT_XML1, 'UTF-8');
  if (isset($request['situation'])) {
    $situation = htmlspecialchars($request['situation'], ENT_XML1, 'UTF-8');
  }
  if (isset($request['projet'])) {
    $projet = htmlspecialchars($request['projet'], ENT_XML1, 'UTF-8');
  }
  if (isset($request['typeBat'])) {
    $typeBat = htmlspecialchars($request['typeBat'], ENT_XML1, 'UTF-8');
  }
  if (isset($request['batiment'])) {
    $batiment = htmlspecialchars($request['batiment'], ENT_XML1, 'UTF-8');
  }
  if (isset($request['age'])) {
    $age = htmlspecialchars($request['age'], ENT_XML1, 'UTF-8');
  }
  if (isset($request['surface'])) {
    $surface = htmlspecialchars($request['surface'], ENT_XML1, 'UTF-8');
  }
  if (isset($request['habitants'])) {
    $habitants = htmlspecialchars($request['habitants'], ENT_XML1, 'UTF-8');
  }
  if (isset($request['adresse'])) {
    $adresse = htmlspecialchars($request['adresse'], ENT_XML1, 'UTF-8');
  }
  if (isset($request['codePostal'])) {
    $codePostal = htmlspecialchars($request['codePostal'], ENT_XML1, 'UTF-8');
  }
  if (isset($request['ville'])) {
    $ville = htmlspecialchars($request['ville'], ENT_XML1, 'UTF-8');
  }
  if (isset($request['pays'])) {
    $pays = htmlspecialchars($request['pays'], ENT_XML1, 'UTF-8');
  }
  if (isset($request['surfaceToit'])) {
    $surfaceToit = htmlspecialchars($request['surfaceToit'], ENT_XML1, 'UTF-8');
  }
  if (isset($request['exposition'])) {
    $exposition = htmlspecialchars($request['exposition'], ENT_XML1, 'UTF-8');
  }
  if (isset($request['inclinaison'])) {
    $inclinaison = htmlspecialchars($request['inclinaison'], ENT_XML1, 'UTF-8');
  }
  if (isset($request['consommation'])) {
    $consommation = htmlspecialchars($request['consommation'], ENT_XML1, 'UTF-8');
  }
  if (isset($request['sourceEnergie'])) {
    $sourceEnergie = htmlspecialchars($request['sourceEnergie'], ENT_XML1, 'UTF-8');
  }
  if (isset($request['chauffage']) && !empty($request['chauffage'])) {
    $chauffage = "";
    foreach ($request['chauffage'] as $value) {
      $chauffage .= htmlspecialchars($value, ENT_XML1, 'UTF-8') . ", ";
    }
  }
  if (isset($request['autresEquipements']) && !empty($request['autresEquipements'])) {
    $autresEquipements = "";
    foreach ($request['autresEquipements'] as $value) {
      $autresEquipements .= htmlspecialchars($value['quantite'] . " " . $value['nom'] . ", ", ENT_XML1, 'UTF-8');
    }
  }


  if (isset($request['situationEntreprise'])) {
    $situationEntreprise = htmlspecialchars($request['situationEntreprise'], ENT_XML1, 'UTF-8');
  }
  if (isset($request['tailleEntreprise'])) {
    $tailleEntreprise = htmlspecialchars($request['tailleEntreprise'], ENT_XML1, 'UTF-8');
  }
  if (isset($request['formeJuridique'])) {
    $formeJuridique = htmlspecialchars($request['formeJuridique'], ENT_XML1, 'UTF-8');
  }
  if (isset($request['machines'])) {
    $machines = htmlspecialchars($request['machines'], ENT_XML1, 'UTF-8');
  }
  if (isset($request['listeMachines'])) {
    $listeMachines = htmlspecialchars($request['listeMachines'], ENT_XML1, 'UTF-8');
  }
  if (isset($request['enseigne'])) {
    $enseigne = htmlspecialchars($request['enseigne'], ENT_XML1, 'UTF-8');
  }


  $prenomNom = htmlspecialchars($request['prenomNom'], ENT_XML1, 'UTF-8');
  $telephone = htmlspecialchars($request['telephone'], ENT_XML1, 'UTF-8');
  $email = htmlspecialchars($request['mail'], ENT_XML1, 'UTF-8');

  // Paramétrage mail
  $mail = new PHPMailer;
  $mail->isSMTP();
  $mail->Host = 'smtp.gmail.com';
  $mail->SMTPAuth = true;
  $mail->Username = '';
  $mail->Password = '';
  $mail->SMTPSecure = 'tls';
  $mail->Port = 587;
  $mail->CharSet = 'UTF-8';

  $mail->setFrom('sendmaildevelopmentaplus@gmail.com', 'Contact site A+');
  $mail->addAddress('jeromeadam.aplusenergies@gmail.com', 'Jérôme ADAM');
  $mail->isHTML(true);

  $mail->Subject = 'ECHEC Formulaire Contact site A+';
  $mail->Body = "";
  $mail->AltBody = "";

  // Paramétrage connexion CRM

  $options = require_once 'vendor/alexacrm/php-crm-toolkit/src/config.php'; // fichier de config
  $serviceSettings = new Settings($options);

  if ($statut == "Particulier") {
    try { // Particulier
      $service = new OrganizationService($serviceSettings);
      $contact = $service->entity('xefi_teleprospection');

      $contact->new_typedenregistrement = 'Contact';
      $contact->new_sourcecontact = 'LP A+';
      $contact->xefi_sourcetelepro = 'LP A+';
      $contact->new_campagne = 'PV';
      $contact->new_canaux = 'Site A+ Energies';
      $contact->new_source = 'Aplusautoconso';
      $contact->new_simulateur = "Oui";
      $contact->new_proprietaire = 'PROPRIÉTAIRE';


      $contact->xefi_name = $prenomNom;
      $array = explode(" ", $prenomNom);
      $contact->xefi_prenom = array_shift($array);
      $contact->xefi_nom = '';
      foreach ($array as $key => $val) {
        $contact->xefi_nom .= $val . ' ';
      }
      $contact->xefi_telportable = $telephone;
      $contact->xefi_mail = $email;
      $mail->Body .= "Informations contact : <br>" . $prenomNom . "<br>" . $telephone . "<br>" . $email . "<br>";
      $mail->AltBody .= "Informations contact : \n" . $prenomNom . "\n" . $telephone . "\n" . $email . "\n";

      $contact->xefi_adresse = $adresse;
      $contact->xefi_ville = $ville;
      $contact->xefi_codepostal = $codePostal;
      $mail->Body .= $adresse . " " . $ville . " " . $codePostal . "<br>";
      $mail->AltBody .= $adresse . " " . $ville . " " . $codePostal . "\n";


      if (isset($autresEquipements)) {
        $contact->xefi_commentaire = "Equipements : " . $autresEquipements;
        $mail->Body .= "Inclinaison du toit : " . $inclinaison . "<br>";
        $mail->AltBody .= "Inclinaison du toit : " . $inclinaison . "\n";
      }

      $contact->xefi_observation = "Maison " . $projet . "\n" . $batiment . "\n" . "Surface habitable : " . $surface . "\n" . "Surface du toit : " . $surfaceToit . "\n";
      $mail->Body    .= "Observations :<br>Maison " . $projet . "<br>" . $batiment . "<br>" . "Surface habitable : " . $surface . "<br>" . "Surface du toit : " . $surfaceToit . "<br>";
      $mail->AltBody .= "Observations :\nMaison " . $projet . "\n" . $batiment . "\n" . "Surface habitable : " . $surface . "\n" . "Surface du toit : " . $surfaceToit . "\n";

      if (isset($inclinaison) && $inclinaison != "Non connu") {
        $contact->xefi_observation .= "Inclinaison du toit : " . $inclinaison . "°\n";
        $mail->Body .= "Inclinaison du toit : " . $inclinaison  . "<br>";
        $mail->AltBody .= "Inclinaison du toit : " . $inclinaison . "\n";
      }

      if ($age == "+2 ans") {
        $contact->new_datemaison = "Plus de 2 ans";
        $mail->Body .= "Plus de 2 ans" . "<br>";
        $mail->AltBody .= "Plus de 2 ans" . "\n";
      } else {
        $contact->new_datemaison = "Moins de 2 ans";
        $mail->Body .= "Moins de 2 ans" . "<br>";
        $mail->AltBody .= "Moins de 2 ans" . "\n";
      }

      $contact->new_nb = $habitants;
      $mail->Body .= $habitants . "habitants" . "<br>";
      $mail->AltBody .= $habitants . "habitants" . "\n";

      if (isset($exposition)) {
        $contact->new_orientationmaison = $exposition;
        $mail->Body .= $exposition . "<br>";
        $mail->AltBody .= $exposition . "\n";
      }

      $contact->xefi_edf = $consommation;
      $mail->Body .= $consommation . "<br>";
      $mail->AltBody .= $consommation . "\n";

      $contact->xefi_gazfioulbois = $sourceEnergie;
      $mail->Body .= "Source principale : " . $sourceEnergie;
      $mail->AltBody .= "Source principale : " . $sourceEnergie;
      if (isset($chauffage)) {
        $contact->xefi_gazfioulbois .= ", " . $chauffage;
        $mail->Body .= ", " . $chauffage;
        $mail->AltBody .= ", " . $chauffage;
      }
    } catch (Exception $e) {
      try {
        for ($i = 0; $i <= 4; $i++) {
          if ($mail->send()) {
            http_response_code(201);
            $reponse = [
              'id' => 2,
              'reponse' => 'Sent'
            ];
            echo json_encode($reponse);
            return;
          }
        }
      } catch (Exception $e) {
        http_response_code(500);
        return;
      }
    }
  } else { // Professionnel
    try {
      $service = new OrganizationService($serviceSettings);
      $contact = $service->entity('new_contactpro');
      $contact->new_campagne = 'PV';
      $contact->new_canaux = 'SITE A+';
      $contact->new_sourceducontact = 'LP A+';

      $contact->ownerid = new EntityReference('systemuser', '87E9B26D-A6BF-E711-80DD-00155D0D092E'); // Mathieu LAUZE
      $contact->new_agence = new EntityReference('site', 'E41048E7-FBD2-E911-810F-00155D085403'); // Agence Pro
      $contact->new_name = $enseigne;
      $contact->new_ntelephone = $telephone;
      $contact->new_mail = $email;
      $contact->new_nomdirigeant = $prenomNom;
      $contact->new_formejuridique = $formeJuridique;
      $contact->new_tailleentreprise = $tailleEntreprise;
      $mail->Body .= "Informations contact : <br>" . $enseigne . "<br>" . $prenomNom . "<br>" . $telephone . "<br>" . $email . "<br>" . $formeJuridique . ' ' . $tailleEntreprise . "<br>";
      $mail->AltBody .= "Informations contact : \n" . $enseigne . "\n" . $prenomNom . "\n" . $telephone . "\n" . $email . "\n" . $formeJuridique . ' ' . $tailleEntreprise . "\n";

      $contact->new_adresse = $adresse;
      $contact->new_ville = $ville;
      $contact->new_codepostal = $codePostal;
      $mail->Body .= $adresse . " " . $ville . " " . $codePostal . "<br>";
      $mail->AltBody .= $adresse . " " . $ville . " " . $codePostal . "\n";

      $contact->new_propritaire = $situationEntreprise;
      $contact->new_observations = $situationEntreprise . " de " . $typeBat . "\n" . "Surface toit estimée : " . $surfaceToit . "\n";
      $mail->Body .= $situationEntreprise . " de " . $typeBat . "<br>" . "Surface toit estimée : " . $surfaceToit . "<br>";
      $mail->AltBody .= $situationEntreprise . " de " . $typeBat . "\n" . "Surface toit estimée : " . $surfaceToit . "\n";

      if (isset($inclinaison) && $inclinaison != "Non connu") {
        $contact->new_observations .= "Inclinaison du toit : " . $inclinaison . "°\n";
        $mail->Body .= "Inclinaison du toit : " . $inclinaison  . "<br>";
        $mail->AltBody .= "Inclinaison du toit : " . $inclinaison . "\n";
      }

      if (isset($exposition)) {
        $contact->new_observations .= $exposition . "\n";
        $mail->Body .= "Exposition " . $exposition . "<br>";
        $mail->AltBody .= "Exposition " . $exposition . "\n";
      }

      if (isset($consommation)) {
        $contact->new_observations .= $consommation . "\n";
        $mail->Body .= "Consommation : " . $consommation . "<br>";
        $mail->AltBody .= "Consommation : " . $consommation . "\n";
      }

      if (isset($machines)) {
        $contact->new_observations .= $machines . "\n";
        $mail->Body .= "Equipements " . $machines . "<br>";
        $mail->AltBody .= "Equipements " . $machines . "\n";
      }

      if (isset($listeMachines)) {
        $contact->new_observations .=  "Autres équipements : " . $listeMachines . "\n";
        $mail->Body .= "Autres équipements : " . $listeMachines . "<br>";
        $mail->AltBody .= "Autres équipements : " . $listeMachines . "\n";
      }
    } catch (Exception $e) {
      try {
        for ($i = 0; $i <= 4; $i++) {
          if ($mail->send()) {
            http_response_code(201);
            $reponse = [
              'id' => 2,
              'reponse' => 'Sent'
            ];
            echo json_encode($reponse);
            return;
          }
        }
      } catch (Exception $e) {
        file_put_contents("error.log", $e);
        http_response_code(422);
        return;
      }
    }
  }

  // Si l'envoi au CRM a réussi, on retourne un message de confirmation. 5 tentatives.

  try {
    for ($i = 0; $i <= 4; $i++) {
      if (($contactId = $contact->create()) != false) {
        $statut == "Propriétaire" ? $mail->Subject = 'Formulaire Contact site A+ réussi' : $mail->Subject = 'Formulaire Contact PRO site A+ réussi';
        for ($i = 0; $i <= 4; $i++) {
          if ($mail->send()) {
            break;
          }
          sleep(rand(0.5, 1));
        }
        http_response_code(201);
        $reponse = [
          'id' => 1,
          'reponse' => 'Created'
        ];
        echo json_encode($reponse);
        return;
      }
      sleep(rand(0.5, 1));
    }
  } catch (Exception $e) {
    // Si échec, envoi des infos sur le mail leads. 5 tentatives.
    try {
      for ($i = 0; $i <= 4; $i++) {
        if ($mail->send()) {
          http_response_code(201);
          $reponse = [
            'id' => 2,
            'reponse' => 'Sent'
          ];
          echo json_encode($reponse);
          return;
        }
      }
    } catch (Exception $e) {
      // Si échec, retour erreur au client.
      http_response_code(422);
    }
  }
}
