/* 
 Author: Remy Sharp
 Contact: remy [at] remysharp.com
*/

// attribute support
(function () {

function each(list, fn) {
  var l = list.length;
  for (var i = 0; i < l; i++) {
    if (fn.call(list[i], list[i], i, list) === false) {
      break;
    }
  }
}

// made global by myself to be reused elsewhere
window.addEvent = (function () {
  if (document.addEventListener) {
    return function (el, type, fn) {
      if (el && el.nodeName || el === window) {
        el.addEventListener(type, fn, false);
      } else if (el && el.length) {
        for (var i = 0; i < el.length; i++) {
          addEvent(el[i], type, fn);
        }
      }
    };
  } else {
    return function (el, type, fn) {
      if (el && el.nodeName || el === window) {
        el.attachEvent('on' + type, function () { return fn.call(el, window.event); });
      } else if (el && el.length) {
        for (var i = 0; i < el.length; i++) {
          addEvent(el[i], type, fn);
        }
      }
    };
  }
})();

var i = document.createElement('input'), inputs = document.getElementsByTagName('input');

/** placeholder support */
if (!('placeholder' in i)) {
  // placeholder fix
  each(inputs, function (el) {
    // note - we're using el instead of this across the board because it compresses better
    var lastValue = el.value, placeholder = el.getAttribute('placeholder');
    if (placeholder) {
      var focus = function () {
        if (el.value == placeholder) {
          el.value = '';
          el.style.color = '';
        }
      };

      var blur = function () {
        if (el.value == '') {
          el.value = placeholder;
          el.style.color = '#A29797';
        }
      };

      addEvent(el, 'focus', focus);
      addEvent(el, 'blur', blur);

      // remove the placeholder if the page is reload or the form is submitted
      addEvent(el.form, 'submit', function () { focus.call(el); });
      addEvent(window, 'unload', function () { focus.call(el); });

      // set the default state
      if (el.value == '') {
        blur.call(el);
      }      
    }
  });
}

/** autofocus support (for kicks) */
if (!('autofocus' in i)) {
  // auto focus
  each(inputs, function (el) {
    if (el.getAttribute('autofocus') != null) {
      el.focus();
      return false; // "there can only be one"
    }
  });
}
  

/** details support - typically in it's own script */
// find the first /real/ node
function firstNode(source) {
  var node = null;
  if (source.firstChild.nodeName != "#text") {
    return source.firstChild; 
  } else {
    source = source.firstChild;
    do {
      source = source.nextSibling;
    } while (source && source.nodeName == '#text');

    return source || null;
  }
}

function isSummary(el) {
  var nn = el.nodeName.toUpperCase();
  if (nn == 'DETAILS') {
    return false;
  } else if (nn == 'SUMMARY') {
    return true;
  } else {
    return isSummary(el.parentNode);
  }
}

function toggleDetails(event) {
  // more sigh - need to check the clicked object
  var keypress = event.type == 'keypress',
      target = event.target || event.srcElement;
  if (keypress || isSummary(target)) {
    if (keypress) {
      // if it's a keypress, make sure it was enter or space
      keypress = event.which || event.keyCode;
      // console.log(keypress);
      if (keypress == 32 || keypress == 13) {
        // all's good, go ahead and toggle
      } else {
        return;
      }
    }

    var open = this.getAttribute('open');
    if (open === null) {
      this.setAttribute('open', 'open');
    } else {
      this.removeAttribute('open');
    }
    // this.className = open ? 'open' : ''; // Lame
    // trigger reflow (required in IE)
    setTimeout(function () {
      document.body.className = document.body.className;
    }, 13);
    
    if (keypress) {
      if (event.preventDefault) event.preventDefault();
      return false;
    }
  }
}

var details = document.getElementsByTagName('details'), 
    i = details.length, 
    first = null, 
    label = document.createElement('summary');

label.appendChild(document.createTextNode('Details'));

while (i--) {
  first = firstNode(details[i]);

  if (first != null && first.nodeName.toUpperCase() == 'SUMMARY') {
    // we've found that there's a details label already
  } else {
    // first = label.cloneNode(true); // cloned nodes weren't picking up styles in IE - random
    first = document.createElement('summary');
    first.appendChild(document.createTextNode('Details'));
    if (details[i].firstChild) {
      details[i].insertBefore(first, details[i].firstChild);
    } else {
      details[i].appendChild(first);
    }
  }
  
  first.legend = true;
  first.tabIndex = 0;
}

addEvent(details, 'click', toggleDetails);
addEvent(details, 'keypress', toggleDetails);

})();