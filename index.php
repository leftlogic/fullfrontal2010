<?php
$thanks = false;
$error = false;
$email = '';

function validEmail($e) {
  return (preg_match("/^([_a-z0-9-\+]+(\.[_a-z0-9-\+]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3}))$/", $e));  
}

if (isset($_POST['email']) && $_POST['email'] && validEmail($_POST['email'])) {
  $email = $_POST['email'];
  $fp = fopen('emails.txt', 'a+');
  fwrite($fp, $email . "\n");
  fclose($fp);
  $thanks = true;
} else if (isset($_POST['email'])) {
  $error = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset=utf-8 />
<title>Full Frontal - JavaScript Conference - 12th November 2010</title>
<link rel="stylesheet" href="holding2010.css" type="text/css" media="screen" />
<script>
// enable elements for styling in IE
/*@cc_on'abbr article aside audio canvas details figcaption figure footer header hgroup mark menu meter nav output progress section summary time video'.replace(/\w+/g,function(n){document.createElement(n)})@*/
</script>
</head>
<body class="vevent">
  <div id="content">
    <header class="summary">
      <h1><a title="One day JavaScript conference" class="url" href="http://2010.full-frontal.org/">Full Frontal</a></h1>
      <h2>JavaScript Conference <time datetime="2010-11-12T09:00">12th November 2010</time></h2>
      <h3>the <em>JavaScript Conference</em> with nothing concealed or held back</h3>
    </header>
    <section class="action" id="mailinglist">
      <h1>Join our mailing list</h1>
      <form action="" method="post">
        <fieldset>
          <label for="email">Email</label>
          <input type="email" placeholder="Enter your email address" value="<?=$email?>" name="email" id="email" /><input type="submit" class="button" value="Subscribe" />
          <?php if ($thanks) : ?>
          <p id="thanks">Thanks for submitting your email address - we'll be in touch as soon as the tickets go on sale!</p>
          <?php elseif ($error) : ?>
          <p class="err">There was an error when trying to save your email address. Can you check it and try again?</p>
          <?php endif ?>
          <p>You&rsquo;ll find out when tickets go on sale and we&rsquo;ll update you with the latest event information &mdash; including confirming speakers as they happen.</p>
        </fieldset>
      </form>
    </section>
    <section id="subitems">
      <details id="wanttospeak">
        <summary>
          <h1>Want to speak?</h1><p>Submit your abstract</p>
        </summary>
        <p>If you&rsquo;re interested in speaking at our second event, <a href="mailto:events@leftlogic.com?subject=Speaker%20Proposal">drop us an email</a> with your talk title, description and a bit about yourself.</p>
      </details>
      <details id="wanttosponsor">
        <summary>
          <h1>Want to sponsor?</h1><p>Get in touch</p>              
        </summary>
        <p>Interested in sponsoring the Full Frontal JavaScript Conference? <a href="mailto:events@leftlogic.com">Get in touch</a> to discuss the opportunities available.</p>
      </details>
    </section>        
    <div class="clear"></div>
    <section class="tweets">
      <h1>What people are saying</h1>
      <ul id="tweets">
        <?php
        $favs = json_decode(preg_replace('/^callback\((.*?)\)$/', '$1', file_get_contents('./fullfrontalconf.json')));
        shuffle($favs);
        for ($i = 0; $i < 3; $i++) : $fav = $favs[$i]; ?>
        <li><strong><a href="http://twitter.com/<?=$fav->user->screen_name?>/statuses/<?=$fav->id?>">@<?=$fav->user->screen_name?></a></strong><?=$fav->text?></li>
        <?php endfor ?>
      </ul>
      <a id="followus" href="http://twitter.com/fullfrontalconf">Follow Us</a>
    </section>
  </div>
  <footer>&copy; 2010 Left Logic Ltd &asymp; Previous years: <a href="http://2009.full-frontal.org">2009</a></footer>
<script src="twitterlib.min.js"></script>
<script src="html5.js"></script>
<script src="holding2010.js"></script>
</body>
</html>