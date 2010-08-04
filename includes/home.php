<section id="speakers">
  <h2><span>The one day JavaScript conference featuring these fine people</span></h2>
  <ul>
    <li class="speaker1">
      <a href="speakers#alex">
        <h3>Alex Russell</h3>
        <img src="/images/speakers/alex_home.jpg" width="137" height="230" alt="Alex Russell" title="Alex Russell, photo by Eugene Lazutkin" />
      </a>
    </li>
    <li class="speaker2">
      <a href="speakers#brian">
        <h3>Brian LeRoux</h3>
        <img src="/images/speakers/brian_home.jpg" width="137" height="230" alt="Brian LeRoux" title="Brian LeRoux" />
      </a>
    </li>
    <li class="speaker3">
      <a href="speakers#dan">
        <h3>Dan Webb</h3>
        <img src="/images/speakers/dan_home.jpg" width="137" height="230" alt="Dan Webb" title="Dan Webb" />
      </a>
    </li>
    <li class="speaker4">
      <a href="speakers#seb">
        <h3>Seb Lee-Delisle</h3>
        <img src="/images/speakers/seb_home.jpg" width="137" height="230" alt="Seb Lee-Delisle" title="Seb Lee-Delisle" />
      </a>
    </li>
    <li class="speaker5">
      <a href="speakers#jan">
        <h3>Jan Lehnardt</h3>
        <img src="/images/speakers/jan_home.jpg" width="137" height="230" alt="Jan Lehnardt" />
      </a>
    </li>
    <li class="speaker6">
      <a href="speakers#paul">
        <h3>Paul Bakaus</h3>
        <img src="/images/speakers/paul_home.jpg" width="137" height="230" alt="Paul Bakaus" />
      </a>
    </li>
    <li class="speaker7">
      <a href="speakers#paulr">
        <h3>Paul Rouget</h3>
        <img src="/images/speakers/paulr_home.jpg" width="137" height="230" alt="Paul Rouget" />
      </a>
    </li>
  </ul>
</section>

<section id="stayInTouch">
  <h2><span>Stay in touch</span></h2>
  <p>Full Frontal 2010 is taking place in Brighton, UK at the Duke of York's cinema again.</p>
  <p>Make sure to follow us on Twitter to find out when tickets go on sale and the latest event information &ndash; including confirming speakers as they happen.</p>
  <ul id="socialIcons">
    <li class="twitterIcon">
      <span></span>
      Follow <a href="http://twitter.com/fullfrontalconf">@fullfrontalconf</a> on Twitter
    </li>
    <li class="hashIcon">
      <span></span>
      Use the <a href="http://search.twitter.com/search?q=%23fullfrontalconf">#fullfrontalconf</a> tag
    </li>
    <li class="emailIcon">
      <span></span>
      <a href="mailto:events@leftlogic.com">Email us</a> to become a sponsor
    </li>
  </ul>
</section>

<section id="whatTheySaid">
  <h2><span>What they said</span></h2>
  <ul id="tweets">
<?php
function linkify($text) {
  // note - this order is important, i.e. links at the top, then anything else
  $matches = array(
    '/([A-Za-z]+:\/\/[A-Za-z0-9-_]+\.[A-Za-z0-9-_:%&\?\/.=]+)/',
    '/(^|[^\w])(#[\d\w\-]+)/',
    '/(^|[^\w])(@([\d\w\-]+))/'
  );
  
  $replacements = array(
    '<a href="$1">$1</a>',
    '$1<a href="http://search.twitter.com/search?q=$2">$2</a>',
    '$1@<a href="http://twitter.com/$3">$3</a>'
  );
  
  return preg_replace($matches, $replacements, $text);
}


$favs = json_decode(file_get_contents('./fullfrontalconf.json'));
shuffle($favs);
for ($i = 0; $i < 3; $i++) : $fav = $favs[$i]; ?>

<li class="box">
  <a href="http://twitter.com/<?=$fav->user->screen_name?>/statuses/<?=$fav->id?>"><img src="<?=$fav->user->profile_image_url?>" width="48" height="48" alt="<?=$fav->user->screen_name?>" title="<?=$fav->user->screen_name?>" /></a>
  <quote><cite><a href="http://twitter.com/<?=$fav->user->screen_name?>"><?=$fav->user->screen_name?></a></cite> <?=linkify(htmlentities($fav->text))?></quote>
  <div></div>
</li>
<?php endfor ?>
  </ul>
</section>

<section id="whereAndWhen">
  <h2><span>Where and when?</span></h2>
  <section id="venue">
    <a href="venue" id="map">
      <h3>Duke of York's, Brighton</h3>
      <p>9am to 6pm 12th November 2010</p>
      <div><span></span></div>
    </a>
  </section>
</section>

<div class="schedule">
<?php include('includes/schedule.php'); ?>
</div>