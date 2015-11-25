$('body')
	.on('click', '.ua-track,[data-ua-click],.button:not(input)', function(event) {	
		trackEvent($(this).text(), $(this));
	})
	.on('blur', '.ua-track-blur,[data-ua-blur]', function(event) {	
		trackEvent('blur', $(this));
	})
	.on('blur', '.ua-track-complete,[data-ua-complete]', function(event) {	
		if($.trim($(this).val()) != '') {
			trackEvent('complete', $(this));
		}
	})
	.on('focus', '.ua-track-focus,[data-ua-focus]', function(event) {	
		trackEvent('focus', $(this));
	})
	.on('change', '.ua-track-change,[data-ua-change]', function(event) {	
		trackEvent('change', $(this));
	})
	.on('mouseover', '.ua-track-mousover,[data-ua-mousover]', function(event) {	
		trackEvent('mouseover', $(this));
	})
	.on('submit', '[data-ua-submit],form', function(event) {
		trackEvent($(this).data('clicked') || 'submit', $(this));
	})
	.on('click', 'input[type="submit"]', function(event) {
		$(this).parents('form').data('clicked', $(this).val());
	})
	.on('click', 'a:not(.ua-track,[data-ua-click],.button:not(input))', function(event) {
		var prefix = isExternal($(this).attr('href')) ? 'Externe link - ' : 'Interne link - ';
		trackEvent(prefix + $(this).text().substring(0, 40), $(this));
	})
;	

function isExternal(url) {
    var domain = function(url) {
        return url.replace('http://','').replace('https://','').split('/')[0];
    };

    return domain(location.href) !== domain(url);
}

function createSelector($element) {
	var elements = [];
	if ($element.attr('id')) {
		return '#' + $element.attr('id');
	}
	else if ($element.attr('class')) {
		elements.push($element.prop('tagName').toLowerCase() + '.' + $element.attr("class").replace(/ /g, '.'));
	}
	var done = false;
	$element.parents('[class]:not(html,body),[id]').each(function() {
		if (!done) {
			if ($(this).attr('id')) {
				elements.push($(this).prop('tagName').toLowerCase() + '#' + $(this).attr("id"));
				done = true;
			}
			else {
				elements.push($(this).prop('tagName').toLowerCase() + '.' + $(this).attr("class").replace(/ /g, '.'));
			}			
		}
	});
	elements.reverse();	
	return elements.join(' ');	
}


function trackEvent(event_type, $element)
{
	if(typeof ga !== 'function')
	{
		log('Google Analytics is not initialized.');
		return false;
	}		
	
	var category = $element.data('ua-category') || window.location.pathname;
	var action = $element.data('ua-action') || event_type;

	var label = $element.data('ua-label') || null; // optional 
	if(!label) {
		if ($element.hasClass('button') && $element.prop('tagName') != 'INPUT') {
			var index = $('.button').index($element) + 1;
			label = 'Button ' + index + ' - ' + createSelector($element);			
		}
		else if ($element.prop('tagName') == 'FORM') {
			var index = $('form').index($element) + 1;
			label = 'Form' + index + ' - ' + createSelector($element);;				
		}
		else if ($element.prop('tagName') == 'A') {
			label = createSelector($element);
			log(label);
		}
	}		
	var value = $element.data('ua-value') || null; // optional
	ga('send', 'event', category, action, label, value);
}	
function log(message)
{
	if(typeof console === 'object')
	{
		console.log(message);
	}
}