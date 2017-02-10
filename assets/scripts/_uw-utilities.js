// via http://gomakethings.com/ditching-jquery/#waiting-until-the-dom-is-ready
var uw_utils_f = {
  ready: function ( fn ) {

    // Sanity check
    if ( typeof fn !== 'function' ) return;

    // If document is already loaded, run method
    if ( document.readyState === 'complete'  ) {
      return fn();
    }

    // Otherwise, wait until document is loaded
    document.addEventListener( 'DOMContentLoaded', fn, false );

  },

  // toggle boolean element attribute
  toggleBooleanAttr: function (el, attr) {
    var current_value, new_value;
    if (el.hasAttribute(attr)) {
      current_value = el.getAttribute(attr);
      new_value = current_value == "true" ? false : true;
      el.setAttribute(attr,new_value);
    }
  },

  getSiblings: function (el) {
    var siblings = [];
    var sibling = el.parentNode.firstChild;
    for ( ; sibling; sibling = sibling.nextSibling ) {
      if ( sibling.nodeType === 1 && sibling !== el ) {
        siblings.push( sibling );
      }
    }
    return siblings;
  }
}
module.exports.ready = uw_utils_f.ready;
module.exports.toggleBooleanAttr = uw_utils_f.toggleBooleanAttr;
module.exports.getSiblings = uw_utils_f.getSiblings;
