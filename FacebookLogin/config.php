<?php

require_once 'vendor/autoload.php';

if (!session_id())
{
    session_start();
}

// Call Facebook API

$facebook = new \Facebook\Facebook([
  'app_id'      => '2501976136742781',
  'app_secret'     => '91cee33e50836ac1bd79ebfed82f7858',
  'default_graph_version'  => 'v2.10'
]);

?>