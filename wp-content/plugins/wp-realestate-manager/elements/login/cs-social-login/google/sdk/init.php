<?php
echo '9999999999999';
die;
require_once plugin_dir_url( __FILE__ ) . 'apiClient.php';
require_once plugin_dir_url( __FILE__ ) . 'contrib/apiOauth2Service.php';
global $wp_rem_theme_options;

$client = new apiClient();
$client->setClientId($wp_rem_theme_options['wp_rem_google_client_id']);
$client->setClientSecret($wp_rem_theme_options['wp_rem_google_client_secret']);
$client->setDeveloperKey($wp_rem_theme_options['wp_rem_google_api_key']);
$client->setRedirectUri(wp_rem_google_login_url());
$client->setApprovalPrompt('auto');

$oauth2 = new apiOauth2Service($client);
