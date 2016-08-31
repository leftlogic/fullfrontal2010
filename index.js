const express = require('express');
const app = express();
const port = process.env.PORT || 9000;
const hbs = require('hbs');
const tweets = require(__dirname + '/fullfrontalconf.json').filter(_ => {
  return _.created_at.indexOf('2009') !== -1;
});

hbs.registerPartials(__dirname + '/views/partials');

hbs.registerHelper('linkify', string => {
  // note - this order is important, i.e. links at the top, then anything else
  const replaceWith = [
    '<a href="$1">$1</a>',
    '$1<a href="http://search.twitter.com/search?q=$2">$2</a>',
    '$1@<a href="http://twitter.com/$3">$3</a>',
  ];

  return [/([A-Za-z]+:\/\/[A-Za-z0-9-_]+\.[A-Za-z0-9-_:%&\?\/.=]+)/ig,
          /(^|[^\w])(#[\d\w\-]+)/ig,
          /(^|[^\w])(@([\d\w\-]+))/ig].reduce((acc, re, i) => {
            return acc.replace(re, replaceWith[i]);
          }, string);
});

// data
const data = {
  speakers: 'Speakers',
  terms: 'Terms and Conditions',
  venue: 'Venue Details',
  schedule: 'Schedule',
  workshops: 'Workshops',
  sponsors: 'Sponsorship',
};

app.set('views', __dirname + '/views');
app.set('view engine' ,'hbs');

Object.keys(data).forEach(name => {
  app.get(`/${name}`, (req, res) => res.render(name, { name, title: data[name] }));
});

app.get('/', (req, res) => {
  res.render('home', {
    name: 'home',
    tweet: tweets.sort(() => Math.random() < 0.5).slice(0, 3),
  });
});

app.use(express.static(__dirname, + '/public'));

if (module.parent) {
  module.exports = app;
} else {
  app.listen(port, () => {
    console.log(`Express server listening on http://localhost:${port}`);
  });
}

