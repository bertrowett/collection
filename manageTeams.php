<?php

use Collection\HTML\HeadHtml;
use Collection\HTML\PageContents\FooterHtml;
use Collection\HTML\PageContents\HeaderHtml;
use Collection\HTML\PageContents\ManageTeamsHTML;
use Collection\Models\TeamsModel;
use Collection\TeamsFormValidator;

require_once 'database.php';
require_once 'vendor/autoload.php';

$teamsModel = new TeamsModel($db);
$teamsFormValidator = new TeamsFormValidator();
$headHtml = new HeadHtml();
$headerHtml = new HeaderHtml();
$manageTeamsHtml = new ManageTeamsHTML();
$footerHtml = new FooterHtml();

$teams = $teamsModel->getTeams();

// Handle form submission
$formData = $_POST ?? false;

if ($formData !== []) { // Prevent validation attempt on page load
    if (
        $teamsFormValidator->validateTeamsForm(
            $formData,
            $teamsModel
        ) === false
    ) {
        header('Location: manageTeams.php?error=1');
        exit;
    }
}

// Display page
$headHtml->display();
$headerHtml->display();
$manageTeamsHtml->display($teams);
$footerHtml->display();