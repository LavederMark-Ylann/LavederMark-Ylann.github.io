<?php

/**
 * Use init.php if you didn't install the package via Composer
 */
require_once 'vendor/autoload.php';

use AlexaCRM\CRMToolkit\Client as OrganizationService;
use AlexaCRM\CRMToolkit\Settings;
use PHPMailer\PHPMailer\PHPMailer;

// Récupération des données envoyées
$postdata = file_get_contents("php://input");

if (isset($postdata) && !empty($postdata)) {

  // Extraction des données
  $request = json_decode($postdata);

  // Validation des données reçues
  if (
    $request->nom === '' || $request->prenom === '' || $request->adresse === '' ||
    $request->email === '' || $request->telephone === '' || $request->message === '' ||
    $request->ville === '' || $request->codePostal === ''
  ) {
    return http_response_code(422);
  }

  // Nettoyage des données
  $nom = htmlspecialchars($request->nom, ENT_XML1, 'UTF-8');
  $prenom = htmlspecialchars($request->prenom, ENT_XML1, 'UTF-8');
  $adresse = htmlspecialchars($request->adresse, ENT_XML1, 'UTF-8');
  $email = htmlspecialchars($request->email, ENT_XML1, 'UTF-8');
  $telephone = "0" . htmlspecialchars($request->telephone, ENT_XML1, 'UTF-8');
  $message = htmlspecialchars($request->message, ENT_XML1, 'UTF-8');
  $ville = htmlspecialchars($request->ville, ENT_XML1, 'UTF-8');
  $codePostal = htmlspecialchars($request->codePostal, ENT_XML1, 'UTF-8');

  // Paramétrage mail
  $mail = new PHPMailer;
  $mail->isSMTP();
  $mail->Host = 'smtp.gmail.com';
  $mail->SMTPAuth = true;
  $mail->Username = 'sendmaildevelopmentaplus@gmail.com';
  $mail->Password = 'NgXg!i&4@LKs0UzWxy';
  $mail->SMTPSecure = 'tls';
  $mail->Port = 587;

  $mail->setFrom('sendmaildevelopmentaplus@gmail.com', 'Contact site A+');
  //$mail->addAddress('jeromeadam.aplusenergies@gmail.com');
  $mail->addAddress('sendmaildevelopmentaplus@gmail.com');
  $mail->isHTML(true);

  $mail->Subject = 'ECHEC Formulaire Contact site A+';
  $mail->Body    = $nom . " " . $prenom . "<br>" . $adresse . "<br>" . $ville . ' ' . $codePostal . '<br>' . $email . " " . $telephone . "<br><br>Message : " . $message;
  $mail->AltBody = $nom . " " . $prenom . "\n" . $adresse . "\n" . $ville . ' ' . $codePostal . "\n" . $email . " " . $telephone . "\n\nMessage : " . $message;

  // Paramétrage connexion CRM

  $options = require_once 'vendor/alexacrm/php-crm-toolkit/src/config.php';

  $serviceSettings = new Settings($options);
  try {
    $service = new OrganizationService($serviceSettings);
    $contact = $service->entity('xefi_teleprospection');
    $contact->new_typedenregistrement = 'Contact';
    $contact->new_sourcecontact = 'LP A+';
    $contact->xefi_sourcetelepro = 'LP A+';
    $contact->new_campagne = 'PV';
    $contact->new_canaux = 'Site A+ Energies';
    $contact->new_source = 'Aplusautoconso';

    $contact->xefi_commentaire = $message;
    $contact->xefi_adresse = $adresse;
    $contact->new_ville = $ville;
    $contact->new_codepostal = $codePostal;

    $contact->xefi_name = $nom . " " . $prenom;

    $contact->xefi_prenom = $prenom;
    $contact->xefi_nom = $nom;
    $contact->xefi_telportable = $telephone;
    $contact->xefi_mail = $email;

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
        sleep(rand(0.5, 1));
      }
    }
    catch (Exception $e) {
      http_response_code(422);
      return;
    }
  }

  // Si l'envoi au CRM a réussi, on retourne un message de confirmation. 5 tentatives.

  for ($i = 0; $i <= 4; $i++) {
    if (($contactId = $contact->create()) != false) {
      $mail->Subject = 'Formulaire Contact site A+ réussi';
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

  // Si échec, envoi des infos sur le mail leads. 5 tentatives.

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

  // Enfin, si échec, retour erreur.

  http_response_code(422);
}
