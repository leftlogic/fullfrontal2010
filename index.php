<?php
$file = isset($_GET['request']) && $_GET['request'] ? $_GET['request'] : 'home';
$file = preg_replace('/\.html/', '', $file);
$file = preg_replace('/[^a-z]/', '', $file);

$titles = array(
    'speakers' => '',
    'terms' => 'Terms and Conditions - ',
    'privacy' => 'Privacy - ',
    'travel' => 'Travel Details - '
);

$crazyload = false;

if (preg_match('/rv:1\.(([1-8]|9pre|9a|9b[0-4])\.[0-9.]+).*Gecko/', @$_SERVER['HTTP_USER_AGENT'])) {
    header('Content-type: application/xhtml+xml');
}

if ($file == 'ticketdraw' && $_SERVER['REQUEST_METHOD'] == 'HEAD') {
    // register the user for a ticket draw
    $db = mysql_connect('localhost','fullfrontal','fullfrontal99');

    if ($db) {
        if (mysql_select_db('fullfrontal',$db)) {
          // first check if they have registered this year, if so, update
          $sql = sprintf('select * from ticket_draw where year=' . date('Y', time()) . ' and email="%s" and url="%s"', mysql_real_escape_string($_GET['email']), mysql_real_escape_string($_GET['url']));
          $result = mysql_query($sql, $db);
          
          if (mysql_num_rows($result) > 0) {
              $sql = sprintf('update ticket_draw set last_update = now() where year=' . date('Y', time()) . ' and email="%s" and url="%s"', mysql_real_escape_string($_GET['email']), mysql_real_escape_string($_GET['url']));
          } else {
            $sql = sprintf('insert into ticket_draw (year, last_update, email, url) values (' . date('Y', time()) . ', now(), "%s", "%s")', mysql_real_escape_string($_GET['email']), mysql_real_escape_string($_GET['url']));
          }
          mysql_query($sql, $db);
    	}

    } 
    mysql_close($db);
    

} else {
  
  if (!file_exists('includes/' . $file . '.php')) {
    $file = 'home';
    header("HTTP/1.0 404 Not Found");
    $crazyload = true;
  }
  
  include('includes/header.php');
  include('includes/' . $file . '.php');
  include('includes/footer.php');
}


?>
