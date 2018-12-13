<?php

if (!isset($drush_major_version)) {
  $drush_version_components = explode('.', DRUSH_VERSION);
  $drush_major_version = $drush_version_components[0];
}
// Site stanfordpro, environment dev.
$aliases['dev'] = array(
  'root' => '/var/www/html/stanfordpro.dev/docroot',
  'ac-site' => 'stanfordpro',
  'ac-env' => 'dev',
  'ac-realm' => 'prod',
  'uri' => 'sites-pro-dev.stanford.edu',
  'remote-host' => 'stanfordprodev.ssh.prod.acquia-sites.com',
  'remote-user' => 'stanfordpro.dev',
  'path-aliases' => array(
    '%drush-script' => 'drush' . $drush_major_version,
  ),
);
$aliases['dev.livedev'] = array(
  'parent' => '@stanfordpro.dev',
  'root' => '/mnt/gfs/stanfordpro.dev/livedev/docroot',
);

if (!isset($drush_major_version)) {
  $drush_version_components = explode('.', DRUSH_VERSION);
  $drush_major_version = $drush_version_components[0];
}
// Site stanfordpro, environment prod.
$aliases['prod'] = array(
  'root' => '/var/www/html/stanfordpro.prod/docroot',
  'ac-site' => 'stanfordpro',
  'ac-env' => 'prod',
  'ac-realm' => 'prod',
  'uri' => 'sites-pro.stanford.edu',
  'remote-host' => 'stanfordpro.ssh.prod.acquia-sites.com',
  'remote-user' => 'stanfordpro.prod',
  'path-aliases' => array(
    '%drush-script' => 'drush' . $drush_major_version,
  ),
);
$aliases['prod.livedev'] = array(
  'parent' => '@stanfordpro.prod',
  'root' => '/mnt/gfs/stanfordpro.prod/livedev/docroot',
);

if (!isset($drush_major_version)) {
  $drush_version_components = explode('.', DRUSH_VERSION);
  $drush_major_version = $drush_version_components[0];
}
// Site stanfordpro, environment ra.
$aliases['ra'] = array(
  'root' => '/var/www/html/stanfordpro.ra/docroot',
  'ac-site' => 'stanfordpro',
  'ac-env' => 'ra',
  'ac-realm' => 'prod',
  'uri' => 'sites-pro-ra.stanford.edu',
  'remote-host' => 'stanfordprora.ssh.prod.acquia-sites.com',
  'remote-user' => 'stanfordpro.ra',
  'path-aliases' => array(
    '%drush-script' => 'drush' . $drush_major_version,
  ),
);
$aliases['ra.livedev'] = array(
  'parent' => '@stanfordpro.ra',
  'root' => '/mnt/gfs/stanfordpro.ra/livedev/docroot',
);

if (!isset($drush_major_version)) {
  $drush_version_components = explode('.', DRUSH_VERSION);
  $drush_major_version = $drush_version_components[0];
}
// Site stanfordpro, environment test.
$aliases['test'] = array(
  'root' => '/var/www/html/stanfordpro.test/docroot',
  'ac-site' => 'stanfordpro',
  'ac-env' => 'test',
  'ac-realm' => 'prod',
  'uri' => 'sites-pro-test.stanford.edu',
  'remote-host' => 'stanfordprostg.ssh.prod.acquia-sites.com',
  'remote-user' => 'stanfordpro.test',
  'path-aliases' => array(
    '%drush-script' => 'drush' . $drush_major_version,
  ),
);
$aliases['test.livedev'] = array(
  'parent' => '@stanfordpro.test',
  'root' => '/mnt/gfs/stanfordpro.test/livedev/docroot',
);

////////////////////////////////////////////////////////////////////////////////
// CUSTOM WILDCARDS FOR MULTISITE
////////////////////////////////////////////////////////////////////////////////

// The command from the CLI.
$command = $_SERVER['argv'];
$alias_key = "@stanfordpro";
$stored = [];
$command_aliases = array_filter($command,
  function ($var) use ($alias_key) {
    return preg_match("/$alias_key/i", $var);
  }
);

// If no alias syntax found just return quietly.
if (!count($command_aliases)) {
  return;
}

// Now we have found the alias in the command we need
// to parse it to go to the correct domain if the correct key is in place.
$alias = array_shift($command_aliases);
$parts = explode(".", $alias);

// End if we don't match the key, end.
if ($parts[0] !== $alias_key) {
  return;
}

// If the third part of the alias is not available then we are acting on the
// default site and can return as default is declared above.
if (!isset($parts[2])) {
  return;
}

// Dev/Stage/Prod/ODE
$environment = $parts[1];
// shortname or the first part of the top level domain name.
$site = $parts[2];

// Sanitize for drush rysnc. eg: @alias:%files/
$site = array_shift(explode(":", $site));

// Create the url.
$key = $environment . '.' . $site;

if ($environment !== "prod") {
  $site = $site . "-" . $environment;
}

$aliases[$key] = $aliases[$environment];
$aliases[$key]['uri'] = $site . ".sites-pro.stanford.edu";
