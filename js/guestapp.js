//=============================================================================
//= UI Function
//=============================================================================
function toggleNotes(self) {
	// If visible = true, we want to show the items
	self.siblings('.ga-subrating-holder').children('.ga-subrating.ga-note-hidden').toggle();
	self.siblings(".ga-show-global").toggle();
	self.siblings(".ga-hide-global").toggle();
	self.toggle();
}

function toggleSubNotes(self, id, popup) {
	popup = false; // DEBUG
	if (!popup) {
		// If visible = true, we want to show the items
		self.parent().siblings(".ga-comment-short").toggle();
		self.parent().siblings(".ga-comment-short").children(".ga-show-all").toggle();

		self.parent().siblings(".ga-comment-full").toggle();
		self.parent().siblings('.ga-comment-full').children(".ga-hide-all").toggle();
		self.parent().siblings(".ga-subrating").toggle();

		self.parent().toggle();
		self.toggle();
	}
	else {
		var text = jQuery(".ga-review-" + id).parent().parent().html()
		var w = window.open();
		jQuery(w.document.body).html(text);
	}
}

//=============================================================================
//= Various helpers, because jQuery might not be present
//=============================================================================

function toggle(el, value) {
	el.style.display = value;
}

function forEach(selector, fn) {
	var elements = document.querySelectorAll(selector);
	for (var i = 0; i < elements.length; i++) {
		fn(elements[i]);
	}
}

//=============================================================================
//= Settings UI functions
//=============================================================================

function getShortcode() {
	var out = "[guestapp ";
	var fr = document.getElementById('lang-check-fr').checked;
	var en = document.getElementById('lang-check-en').checked;
	var de = document.getElementById('lang-check-de').checked;
	var es = document.getElementById('lang-check-es').checked;
	var nl = document.getElementById('lang-check-nl').checked;
	var amount = document.getElementById('review-qty').value;
	var noshow = document.getElementById('noshow-averages').checked;
	var compact = document.getElementById('compact-widget').checked;
	var normal = document.getElementById('normal').checked;
	var color = document.getElementById('colorpicker').value;
	var note = document.getElementById('note-visualisation').value;
	

	if (amount != 0) {	
		out += "qty=" + amount + " ";
	}

	if (fr && en && de && es && nl) {
		// Every language ticked
		// No need to insert a lang param
	}
	else if (fr || en || de || es || nl) {
		out += "lang=" + (fr ? "fr," : "")
					   + (en ? "en," : "")
					   + (es ? "es," : "")
					   + (de ? "de," : "")
					   + (nl ? "nl," : "");
		// Remove the trailing comma
		out = out.substring(0, out.length - 1);
		out += " ";
	}

	if (noshow) {
		out += "noavg=true ";
	}

	if (compact) {
		out += "compact=true "
	}

	out += "color=" + color + " ";
	out += "note=" + note + " ";

	out += "]";

	send_to_editor(out);
}

function getPreview() {
	var pluginRoot = jQuery("#plugin_url").html();
	var color  = document.getElementById('colorpicker').value;
	var noshow = document.getElementById('noshow-averages').checked;
	var compact = document.getElementById('compact-widget').checked;
	var note = document.getElementById('note-visualisation').value;

	var isCompact = compact ? "compact-" : "";
	var isNoShow = noshow ? "noaverage-" : "";
	var display = note  ? "note-" : 
				  stars ? "stars-" : 
				  both ? "both-" : '';

	var imageSrc = pluginRoot + "../images/preview-" + 
				   isCompact + 
				   isNoShow + 
				   note + "-" + 
				   color + ".png";

	console.log("setting to " + imageSrc);

	jQuery("#guestapp-widget-preview").attr('src', imageSrc);
}

jQuery(document).ready(function() {
	jQuery('.ga-review-perfectable').perfectScrollbar();

	jQuery('#lang-check-all').click(function() {
		jQuery('.lang-selector').prop('disabled', jQuery(this).prop('checked'));
		jQuery('.lang-selector').prop('checked', jQuery(this).prop('checked'));	
	});

	jQuery('#review-qty, #noshow-averages, #compact-widget, #colorpicker, #normal, #note-visualisation').change(function() {
		getPreview();
	});

	jQuery(".toggle-box").click(function() {
		jQuery(this).children('.toggle-box-content').toggle();
	});

	jQuery('.uuid-input').each(function() {
		jQuery(this).attr("value", guid());
	});
});

jQuery(function(){
	jQuery('.ga-review-container').each(function() {
		if (jQuery(this).prop('id').indexOf('ga-slider') > -1) {
			jQuery(this).liquidSlider({
			   	//autoSlide: true,
			   	//autoSlideInterval: 4000,
				pauseOnHover: true,
				dynamicTabs: false,
				hoverArrows: false,
				dynamicArrows: false,
				slideEaseDuration: 500,
				autoHeight: false,
				crossLinks: true
	   		});
		}
	});
});

// Generates an Unique ID, padded with a number increasing with the amount of uses
// This is used for the widget settings uniqueid, otherwise, each unique id would be the same
var guid = (function() {
  delta = 0;
  function s4() {
  	delta++;
    return Math.floor((1 + Math.random()) * 0x10000)
               .toString(16)
               .substring(1);
  }
  return function() {
  	console.log(delta);
    return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
           s4() + '-' + s4() + s4() + s4() + delta.toString();
  };
})();