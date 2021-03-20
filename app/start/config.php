<?php

ini_set("display_errors", "1");

/**
 * Database
 */
define("DB_CONFIG", [
    "NAME" => "rnp",
    "HOST" => "localhost",
    "USER" => "root",
    "PASS" => ""
]);

/**
 * URL
 */
define("CONF_URL_TEST", "http://www.localhost/sisgesesc"); //development
define("CONF_URL_BASE", "http://www.localhost/sisgesesc"); // Production

define("CONF_SITE_NAME", "Sistema de Gestão");
define('CONF_SITE_TITLE', 'Sistema de Gestão Escolar');
define("CONF_SITE_ADDR_STREET", "Rua Comandante Soared de Andre");
define("CONF_SITE_ADDR_NUMBER", "Prédio 29");
define("CONF_SITE_ADDR_COMPLEMENT", '');
define('CONF_SITE_ADDR_CITY', 'Beira');
define("CONF_SITE_ADDR_STATE", "Esturro");
define("CONF_SITE_ADDR_ZIPCODE", "2301");



/**
 * Password
 */
define("CONF_PASSWD_MIN_LEN", 8);
define("CONF_PASSWD_MAX_LEN", 40);
define("CONF_PASSWD_ALGO", PASSWORD_DEFAULT);
define("CONF_PASSWD_OPTION", ["cost" => 10]);

/**
 * VIEW
 */
define("CONF_VIEW_PATH", __DIR__ . "/../../public/views");
define("CONF_VIEW_THEME", "default");
define("CONF_VIEW_EXT", "php");

/**
 * UPLOAD
 */
define("CONF_UPLOAD_DIR", "upload");
define("CONF_UPLOAD_IMAGE_DIR", "images");
define("CONF_UPLOAD_FILE_DIR", "files");
define("CONF_UPLOAD_MEDIA_DIR", "medias");

/**
 * IMAGES
 */
define("CONF_IMAGE_CACHE", CONF_UPLOAD_DIR . "/" . CONF_UPLOAD_IMAGE_DIR . "/cache");
define("CONF_IMAGE_SIZE", 2000);
define("CONF_IMAGE_QUALITY", ["jpg" => 75, "png" => 5]);


/**
 * MAIL
 */

