<?php

require_once '../vendors/limonade.php';

// Open the database.
$database_file = '../database.sqlite';
$db = new PDO('sqlite:' . $database_file);

// Set configuration settings.
function configure() {
    option('views_dir', '../views');
    option('base_uri', '/');
}

// Define the get routes.
dispatch_get('/', 'get_index');
dispatch_get('/list', 'get_list');
dispatch_get('/revert', 'get_revert');
dispatch_get('^/login(?:\?.*)*', 'get_login');

// Define the post routes.
dispatch_post('/submit', 'post_submit');
dispatch_post('/revert', 'post_revert');
dispatch_post('/login', 'post_login');

// Define the functions.
function get_index() {
    global $db;

    // Calculate numbers.
    $num_survivors = $db->query('SELECT count(*) FROM players WHERE status=' . $db->quote('survivor'))->fetchColumn();
    $num_zombies = $db->query('SELECT count(*) FROM players WHERE status=' . $db->quote('zombie'))->fetchColumn();

    // Set message
    $message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
    $_SESSION['message'] = '';

    // Set variables.
    set('num_survivors', $num_survivors);
    set('num_zombies', $num_zombies);
    set('message', $message);

    // Render and return the HTML.
    return html('index.html.php');
}

function get_list() {
    global $db;

    // Check authentication.
    $keys = explode(' ', file_get_contents('../authentication'));
    if (!isset($_SESSION['token']) || $_SESSION['token'] != $keys[1]) {
        redirect_to('/login', array('redirect' => '/list'));
    }

    // Calculate numbers.
    $num_survivors = $db->query('SELECT count(*) FROM players WHERE status=' . $db->quote('survivor'))->fetchColumn();
    $num_zombies = $db->query('SELECT count(*) FROM players WHERE status=' . $db->quote('zombie'))->fetchColumn();

    // Get all players.
    $players = $db->query("SELECT * FROM players")->fetchAll();

    // Set variables.
    set('num_survivors', $num_survivors);
    set('num_zombies', $num_zombies);
    set('players', $players);

    return html('list.html.php');
}

function get_revert() {
    // Check authentication.
    $keys = explode(' ', file_get_contents('../authentication'));
    if (!isset($_SESSION['token']) || $_SESSION['token'] != $keys[1]) {
        redirect_to('/login', array('redirect' => '/revert'));
    }

    // Extract variables.
    $message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
    $_SESSION['message'] = '';

    // Set variables.
    set('message', $message);

    return html('revert.html.php');
}

function get_login() {
    // Extract variables.
    $redirect = isset($_REQUEST['redirect']) ? $_REQUEST['redirect'] : '';
    $message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
    $_SESSION['message'] = '';

    // Set variables.
    set('redirect', $redirect);
    set('message', $message);

    return html('login.html.php');
}

function post_submit() {
    global $db;

    // Query database.
    $rows = $db->query('SELECT * FROM players where number=' . $db->quote($_POST['player_id']))->fetchAll();

    // Check there is only one player.
    if (sizeof($rows) != 1) {
        $_SESSION['message'] = 'invalid';
        redirect_to('/');
    } else {
        $player = $rows[0];
    }

    // Update database only if not infected.
    if ($player['status'] == 'survivor') {
        $db->query('UPDATE players SET status = ' . $db->quote('zombie') . ' WHERE number = ' . $db->quote($_POST['player_id']));
        $_SESSION['message'] = 'infected';
    } else if ($player['status'] == 'zombie') {
        $_SESSION['message'] = 'already';
    }

    redirect_to('/');
}

function post_revert() {
    global $db;

    // Check authentication.
    $keys = explode(' ', file_get_contents('../authentication'));
    if (!isset($_SESSION['token']) || $_SESSION['token'] != $keys[1]) {
        redirect_to('/login', array('redirect' => '/revert'));
    }

    // Query database.
    $rows = $db->query('SELECT * FROM players where number=' . $db->quote($_POST['player_id']))->fetchAll();

    // Check there is only one player.
    if (sizeof($rows) != 1) {
        $_SESSION['message'] = 'invalid';
        redirect_to('/revert');
    } else {
        $player = $rows[0];
    }

    // Update database only if infected.
    if ($player['status'] == 'zombie') {
        $db->query('UPDATE players SET status = ' . $db->quote('survivor') . ' WHERE number = ' . $db->quote($_POST['player_id']));
        $_SESSION['message'] = 'reverted';
    } else if ($player['status'] == 'survivor') {
        $_SESSION['message'] = 'already';
    }

    redirect_to('/revert');
}

function post_login() {
    $keys = explode(' ', file_get_contents('../authentication'));

    if ($_POST['password'] == $keys[0]) {
        $_SESSION['token'] = $keys[1];
        redirect_to($_POST['redirect']);
    } else {
        $_SESSION['message'] = 'failed';
        redirect_to('/login', array('redirect' => $_POST['redirect']));
    }
}

// Run the app.
run();

// Close the database.
$db = null;

?>