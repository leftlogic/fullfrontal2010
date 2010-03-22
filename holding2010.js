// emile.js (c) 2009 Thomas Fuchs
// Licensed under the terms of the MIT license.

(function(emile, container){
  var parseEl = document.createElement('div'),
    props = ('backgroundColor borderBottomColor borderBottomWidth borderLeftColor borderLeftWidth '+
    'borderRightColor borderRightWidth borderSpacing borderTopColor borderTopWidth bottom color fontSize '+
    'fontWeight height left letterSpacing lineHeight marginBottom marginLeft marginRight marginTop maxHeight '+
    'maxWidth minHeight minWidth opacity outlineColor outlineOffset outlineWidth paddingBottom paddingLeft '+
    'paddingRight paddingTop right textIndent top width wordSpacing zIndex').split(' ');

  function interpolate(source,target,pos){ return (source+(target-source)*pos).toFixed(3); }
  function s(str, p, c){ return str.substr(p,c||1); }
  function color(source,target,pos){
    var i = 2, j, c, tmp, v = [], r = [];
    while(j=3,c=arguments[i-1],i--)
      if(s(c,0)=='r') { c = c.match(/\d+/g); while(j--) v.push(~~c[j]); } else {
        if(c.length==4) c='#'+s(c,1)+s(c,1)+s(c,2)+s(c,2)+s(c,3)+s(c,3);
        while(j--) v.push(parseInt(s(c,1+j*2,2), 16)); }
    while(j--) { tmp = ~~(v[j+3]+(v[j]-v[j+3])*pos); r.push(tmp<0?0:tmp>255?255:tmp); }
    return 'rgb('+r.join(',')+')';
  }
  
  function parse(prop){
    var p = parseFloat(prop), q = prop.replace(/^[\-\d\.]+/,'');
    return isNaN(p) ? { v: q, f: color, u: ''} : { v: p, f: interpolate, u: q };
  }
  
  function normalize(style){
    var css, rules = {}, i = props.length, v;
    parseEl.innerHTML = '<div style="'+style+'"></div>';
    css = parseEl.childNodes[0].style;
    while(i--) if(v = css[props[i]]) rules[props[i]] = parse(v);
    return rules;
  }  
  
  container[emile] = function(el, style, opts){
    el = typeof el == 'string' ? document.getElementById(el) : el;
    opts = opts || {};
    var target = normalize(style), comp = el.currentStyle ? el.currentStyle : getComputedStyle(el, null),
      prop, current = {}, start = +new Date, dur = opts.duration||200, finish = start+dur, interval,
      easing = opts.easing || function(pos){ return (-Math.cos(pos*Math.PI)/2) + 0.5; };
    for(prop in target) current[prop] = parse(comp[prop]);
    interval = setInterval(function(){
      var time = +new Date, pos = time>finish ? 1 : (time-start)/dur;
      for(prop in target)
        el.style[prop] = target[prop].f(current[prop].v,target[prop].v,easing(pos)) + target[prop].u;
      if(time>finish) { clearInterval(interval); opts.after && opts.after(); }
    },10);
  }
})('emile', this);


var easing = {
  elastic: function(pos){return -1*Math.pow(4,-8*pos)*Math.sin((pos*6-1)*(2*Math.PI)/2)+1},
  swingFromTo:function(pos){var s=1.70158;return((pos/=0.5)<1)?0.5*(pos*pos*(((s*=(1.525))+1)*pos-s)):0.5*((pos-=2)*pos*(((s*=(1.525))+1)*pos+s)+2)},
  swingFrom:function(pos){var s=1.70158;return pos*pos*((s+1)*pos-s)},
  swingTo:function(pos){var s=1.70158;return(pos-=1)*pos*((s+1)*pos+s)+1},
  bounce:function(pos){if(pos<(1/2.75)){return(7.5625*pos*pos)}else{if(pos<(2/2.75)){return(7.5625*(pos-=(1.5/2.75))*pos+0.75)}else{if(pos<(2.5/2.75)){return(7.5625*(pos-=(2.25/2.75))*pos+0.9375)}else{return(7.5625*(pos-=(2.625/2.75))*pos+0.984375)}}}},
  bouncePast:function(pos){if(pos<(1/2.75)){return(7.5625*pos*pos)}else{if(pos<(2/2.75)){return 2-(7.5625*(pos-=(1.5/2.75))*pos+0.75)}else{if(pos<(2.5/2.75)){return 2-(7.5625*(pos-=(2.25/2.75))*pos+0.9375)}else{return 2-(7.5625*(pos-=(2.625/2.75))*pos+0.984375)}}}},
  easeFromTo:function(pos){if((pos/=0.5)<1){return 0.5*Math.pow(pos,4)}return -0.5*((pos-=2)*Math.pow(pos,3)-2)},
  easeFrom:function(pos){return Math.pow(pos,4)},
  easeTo:function(pos){return Math.pow(pos,0.25)}
};


twitterlib.render = function (tweet) {
  var html = [], screen_name = tweet.user.screen_name;
  html.push('<li>');
  html.push('<strong><a href="http://twitter.com/' + screen_name + '/status/' + tweet.id + '">@' + screen_name + '</a></strong> ');
  html.push('<span class="status">' + this.ify.clean(tweet.text) + '</span>');
  html.push('</li>');

  return html.join('');
};

function shuffle(array) {
  return array.sort(function(){ 
    return .5 - Math.random(); 
  });
}

// getting it locally in case of usage blocking via twitter, but here's a link to all these live on Twitter:
// http://twitter.com/fullfrontalconf/favorites
twitterlib.debug({ favs: 'fullfrontalconf.json?callback=callback' });
setTimeout(function () {
  twitterlib.favs('fullfrontalconf', function (tweets) {
    var html = [], holder = document.getElementById('tweetholder'), comp = holder.currentStyle ? holder.currentStyle : getComputedStyle(holder, null), el = document.getElementById('tweets');

    tweets = shuffle(tweets);

    for (var i = 0; i < tweets.length && i < 3; i++) {
      html.push(twitterlib.render(tweets[i]));
    }

    holder.innerHTML = html.join('');

    emile(el, 'opacity:0;', { duration: 100 });
    emile(el, 'height:' + comp['height'], { 
      duration: 400,
      easing: easing.easeFrom,
      after: function () {
        el.innerHTML = holder.innerHTML;
        emile(el, 'opacity:1', { duration: 200 });
        holder.parentNode.removeChild(holder);
      }
    });
  });  
}, 500);