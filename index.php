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
<!--

Hello there! \o,

So you're interested in my sauce then? Good for you - many a developer has learnt from 
popping the hood on web pages and sniffing around the source code. Since you've come 
this far already, I thought I'd outline the juicy bits I've left for you in my code:

1. We're using a "version-less" doctype, which switches to HTML5
2. <script> tags go without the type attribute
3. I'm using the latest version of the HTML5 shiv (http://bit.ly/cm2Lrb)
4. I've used HTML5 elements where possible, and in particular, am using the <details>
   element with a sprinkle of JavaScript - which I'll come on to
5. I'm also using the placeholder attribute

So, new sexy HTML5 elements, eh? Yep, no problem. I'm using <details> which is supposed
to be interactive (but not currently native), and I'm using the placeholder attribute 
which is only natively supported in Safari and Chrome. So to make this work across 
browsers, I've added a  sprinkle of JavaScript - it's all sitting in 
http://2010.full-frontal.org/html5.js

In there you'll find patching JavaScript to add support to placeholder and autofocus
and further in the script you'll find the code to support <details>. It's all fairly
new so if you find a bug, let me know via Twitter @rem.

Otherwise, thanks for stopping by, and hopefully you can make it to my conference,
I planning on making it just as awesome as last year!

Cheers,

- Remy.

-->
<link rel="stylesheet" href="holding2010.css" type="text/css" media="screen" />
<link rel="stylesheet" href="print.css" type="text/css" media="print" />
<!--[if lte IE 7]>
<link rel="stylesheet" href="ie.css" type="text/css" media="screen" charset="utf-8" />
<![endif]-->
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
      <!-- from: http://twitter.com/fullfrontalconf/favorites -->
      <ul id="tweets">
        <?php
        $favs = json_decode(file_get_contents('./fullfrontalconf.json'));
        shuffle($favs);
        for ($i = 0; $i < 3; $i++) : $fav = $favs[$i]; ?>
        <li><a href="http://twitter.com/<?=$fav->user->screen_name?>/statuses/<?=$fav->id?>"><strong>@<?=$fav->user->screen_name?></strong><?=$fav->text?></a></li>
        <?php endfor ?>
      </ul>
      <a id="followus" href="http://twitter.com/fullfrontalconf">Follow Us</a>
    </section>
  </div>
  <footer>&copy; 2010 Left Logic Ltd &asymp; Previous years: <a href="http://2009.full-frontal.org">2009</a></footer>
<script src="html5.js"></script>
<script>
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-1656750-20']);
_gaq.push(['_trackPageview']);
(function() {
  var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
  ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
  (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(ga);
})();
</script>
</body>
</html>