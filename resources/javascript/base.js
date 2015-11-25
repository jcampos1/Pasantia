function hslToRgb(h, s, l) {
	var m1, m2, hue;
	var r, g, b
	//s /=100;
	//l /= 100;
	if (s == 0)
		r = g = b = (l * 255);
	else {
		if (l <= 0.5)
			m2 = l * (s + 1);
		else
			m2 = l + s - l * s;
		m1 = l * 2 - m2;
		hue = h / 360;
		r = HueToRgb(m1, m2, hue + 1/3);
		g = HueToRgb(m1, m2, hue);
		b = HueToRgb(m1, m2, hue - 1/3);
	}
	return [Math.round(r), Math.round(g), Math.round(b)];
}
function HueToRgb(m1, m2, hue) {
	var v;
	if (hue < 0)
		hue += 1;
	else if (hue > 1)
		hue -= 1;

	if (6 * hue < 1)
		v = m1 + (m2 - m1) * hue * 6;
	else if (2 * hue < 1)
		v = m2;
	else if (3 * hue < 2)
		v = m1 + (m2 - m1) * (2/3 - hue) * 6;
	else
		v = m1;

	return 255 * v;
}

/**
 * RemainigTime class
 * 
 * Handles the formatting of the remaining time
 */
function RemainingTime(time) {
	this.time = time;
};
RemainingTime.minute = 60000;
RemainingTime.second = 1000;
RemainingTime.format = function(time) {
	var obj = new RemainingTime(time);
	return obj.toString();
};

RemainingTime.prototype.getSeconds = function() {
	return Math.ceil( (this.time % RemainingTime.minute) / RemainingTime.second);
};
RemainingTime.prototype.getMinutes = function() {
	return Math.floor(this.time / RemainingTime.minute);
};
RemainingTime.prototype.toString = function() {
	var minutes = this.getMinutes();
	if (minutes > 0)
		return this.getMinutes() + "m "  + this.getSeconds() + "s";	
	return this.getSeconds() + "s";
};

/**
 * 
 * 
 */
function notifyParent(data)
{
	if (!('QuizData' in window) || !('postMessage' in window) || !('JSON' in window)) {
		return;
	}
	
	data = data || {};
	
	var sendData = {
		width: $("body").width(),
		height: $("body").height(),
		type: QuizData[0],
		id: QuizData[1]
	};
	
	$.extend(sendData, data);

	
	// Interferes with other such as twitter
	// top.postMessage(sendData, '*');	
	top.postMessage(JSON.stringify(sendData), '*');
}


function initRankingForm(checkEmailUrl) {
	var $tabs = $('.scoreform');
	var newTabIndex = $('.ui-tabs-nav li').size() == 2 ? 0 : 1;
	$tabs.tabs({
		select: function(event, ui) {
			$('#player1 input[type="password"]').val('');
			$('#player1 .createpw').hide();
			if (ui.index == newTabIndex) {
				$('#player1 fieldset:first').show();
			}
			else if (ui.index == newTabIndex + 1) {
				$('#player0').hide();
				$('#firsttab').hide();
				$('.ui-tabs-nav li:last').show();
			}
			
			var $login = $('#loginbutton');
			var $forgot = $('#forgotpasswordbutton');
			$login.show();
			$forgot.hide();
			$login.insertBefore($forgot);	
			$('#RankingFormModel_login_password').parent().show();
			$('#RankingFormModel_login_password').val('');
		}
	});
	$('input[type="email"]').change(function() {
		$('input[type="email"]').val($(this).val());
	});
	var $email = $('#RankingFormModel_email');
	
	
	$email.blur(function() {
		if ($(this).val() != '' && $(this).is(':visible')) {
			$.get(checkEmailUrl + $(this).val(), function(response) {
				if (response) {
					$tabs.tabs('select', newTabIndex + 1);
					$('#RankingFormModel_password').focus();
					$email.data('new', 0);
				}
				else {
					$email.data('new', 1);
					if ($email.parent().hasClass('success') && $email.parent().next().hasClass('success')) {
						showPw();
					}
				}
			});			
		}
	});
	$('input[name="new"]').click(function() {
		$email.blur();
	});
	
	$('#forgotpw').click(function() {
		$(this).parents('div:first').hide();
		$('#RankingFormModel_login_password').val('');
		var $login = $('#loginbutton');
		var $forgot = $('#forgotpasswordbutton');
		$forgot.show();
		$login.hide();
		$forgot.insertBefore($login);
		return false;
	});
	
	$('#changeuser').click(function() {
		$tabs.tabs('select', newTabIndex + 1);
		return false;
	});
}

function showPw() {
	$(".createpw").show();
	$('#player1').find("fieldset:first").hide();
	$('#player1 input[type="password"]').val('');
}

function initLogin() {
	$('#forgotpw').click(function(event) {
		$(this).closest('form').hide();
		event.preventDefault();
		$('#forgotpwcontainer').removeClass('hidden');
	});
}

function initCountdown() {
	var counter = 5;
	var $timeProgress = $('.progress > .bar');
	$timeProgress.css('width', '0%');

	var interval = setInterval(function() {
	    counter--;
	    $('.counter').toggleClass('blink');
	    $('.counter').text(counter);
	    
		
	    if (counter == 0) {
	    	$('h1').text($('h1').data('gogogo'));
	    	window.location += '&countdown=true';
	    	clearInterval(interval);
	    	return;
	    	
	    }
	}, 1000);	
	
	var barProgress = counter * 40;
	var barTotal = barProgress;
	var barInterval = setInterval(function() {
		if (barProgress > 0) {
			--barProgress;
			
			var progress = ((barTotal-barProgress) / barTotal) * 100;
			$timeProgress.css('width', progress + '%');
			
			var h = (89 - 2) * (progress/100) + 2;
			var colors = hslToRgb(h, 1, 0.64);
			$timeProgress.parent().css('background-color', 'rgb('+colors.join(',')+')');			
		}
		
	}, 25);
}

function initRankingTabs() {
	var $tabs = $( "#rankingtabs" );
	$tabs.tabs();
	
	// Progressive enhancement
	if ('onhashchange' in window) {
		$(window).on('hashchange', function() {
			 // Gebruik maken van trucje dat hash een # heeft en id selectors daarmee beginnen
			var tab = $(location.hash).prevAll('.ui-tabs-panel').length;
			$tabs.tabs('option', 'active', tab);
		});
	}
	else {
		$tabs.on('click', '.tinytabs a', function(ev) {
			ev.preventDefault();	
			var hash = /#.*/.exec(this.href)[0];
			var tab = $(hash).prevAll('.ui-tabs-panel').length;
			$tabs.tabs('option', 'active', tab);
		});
	}
}
function initRankingAccordion() {
	$(".teamtab").tabs({
		//animate: false,
		//heightStyle: "content",
	});
};

function initRankingNodigUit() {
	$('a.friends').click(function(e) {
		e.preventDefault();
		$('.challengefriends').show().insertAfter($(this).parents('.scoreactions:first'));
	});
}

function initRankingLoader(options) {
	$button = $("#rankingSelectButton");
	$list = $("#rankingSelectList");
	$container = $("#rankingContainer");
	
	$button.on('click', function() {
		$container.load(options.url + '&round=' + $list.val() )
	});
}

function initRankingFilters() {
	$(".ranking-filter").each(function() {
		
		$this = $(this);
		var inputs = $this.find('select, input:not([type=submit]):not([type=button]), textarea');
		var baseUrl = $this.data('url');
		var replace = $this.next('table').wrap(document.createElement('div')).parent();
		
		$this.find('button,input[type=submit],input[type=button]').on('click', function() {
			var url = baseUrl;
			inputs.each(function() {
				url += '&' + encodeURIComponent(this.name) + "=" + encodeURIComponent(this.value);	
			});
			replace.load(url);
		});
	});
};

function owlyBlink(){
    var randSeconds = Math.ceil(Math.random()*5)+2; // max 7 sec, min 3 sec
    var randDelay = randSeconds*300;
    var speed=300; // transition speed going form opacity 1 to 0.2 or 0.2 to 1
  
    var owly = $('.owly');
  	setTimeout(function(){
	      owly.toggleClass('active');
	      owlyBlink();
	},randDelay);
}

(function($) {
	$.fn.quiz = function(options) {
		this.data('quiz', new Quiz(this, options));
		return this;
	}
	$.fn.assessment = function(options) {
		this.data('quiz', new Assessment(this, options));
		return this;
	}
	$.fn.exam = function(options) {
		this.data('quiz', new Exam(this, options));
		return this;
	}	
})(jQuery);


/* Simple JavaScript Inheritance
 * By John Resig http://ejohn.org/
 * MIT Licensed.
 */
// Inspired by base2 and Prototype
(function(){
  var initializing = false, fnTest = /xyz/.test(function(){xyz;}) ? /\b_super\b/ : /.*/;
 
  // The base Class implementation (does nothing)
  this.Class = function(){};
 
  // Create a new Class that inherits from this class
  Class.extend = function(prop) {
    var _super = this.prototype;
   
    // Instantiate a base class (but only create the instance,
    // don't run the init constructor)
    initializing = true;
    var prototype = new this();
    initializing = false;
   
    // Copy the properties over onto the new prototype
    for (var name in prop) {
      // Check if we're overwriting an existing function
      prototype[name] = typeof prop[name] == "function" &&
        typeof _super[name] == "function" && fnTest.test(prop[name]) ?
        (function(name, fn){
          return function() {
            var tmp = this._super;
           
            // Add a new ._super() method that is the same method
            // but on the super-class
            this._super = _super[name];
           
            // The method only need to be bound temporarily, so we
            // remove it when we're done executing
            var ret = fn.apply(this, arguments);        
            this._super = tmp;
           
            return ret;
          };
        })(name, prop[name]) :
        prop[name];
    }
   
    // The dummy class constructor
    function Class() {
      // All construction is actually done in the init method
      if ( !initializing && this.init )
        this.init.apply(this, arguments);
    }
   
    // Populate our constructed prototype object
    Class.prototype = prototype;
   
    // Enforce the constructor to be what we expect
    Class.prototype.constructor = Class;
 
    // And make this class extendable
    Class.extend = arguments.callee;
   
    return Class;
  };
})();


var AbstractQuiz = Class.extend({
	init: function($container, options) {

		this.options = options;

		////
		this.$container = $container;
		this.$form = $(options.selectors.questionForm, this.$container);
		this.$questionNumber = $(options.selectors.questionNumber);
		this.options = options;
		
		this.$questionNumber.html(options.labels.question.replace(/{number}/, options.questionNumber));
		this.questionNumber = options.questionNumber;
		this.validateData = false;
		
		var quiz = this;
		
		this.$form
			.on('mouseenter', '.answers li', function() {
				$(this).addClass('hover');
			})
			.on('mouseleave', '.answers li', function() {
				$(this).removeClass('hover');		
			});	
				
		this.$form.on('submit', function(ev) {
			ev.preventDefault();
			quiz.answer(null);
		});
		
		this.$form.on('change', 'input', function(event) {
			if ($container.hasClass('loading')) {
				event.preventDefault();
				return;
			}

			if (this.type === "radio" || this.type === "checkbox") {
				$(this).closest('li')[this.checked ? 'addClass' : 'removeClass']('pressed');
			}
		});
		
		this.$form.on('change', '.autosubmit', function() {
			if (!$container.hasClass('loading')) {
				quiz.answer(null);
			}
		});
		
		this.$form.on('change', function() {
			quiz.validate();
		});
		
		// Fix IE behavior that click on a label apparently dont work
		// IE8 -> label in any case
		// IE9+ -> label img, doesnt work.
		this.$form.on('click', 'label', function(ev) {
		
			var input;
			if (this.getAttribute("for")) {
				input =	document.getElementById(this.getAttribute("for"));
			}
			else {
				input = this.getElementsByTagName("input")[0]; // ($(this).find("input")[0];
			}
			
			// When it's not a radio or checkbox, focus normal input.
			if (!input.type || (input.type !== "radio" && input.type !== "checkbox")) {
				input.focus();
				return;
			}
			
			// Do not trigger event when we actually click the input itself.
			if (input && ev.target === input) {
				return;
			}
		
			// When radio and checked, we should do nothing
			if (input.type === "radio" && input.checked) {
				ev.preventDefault();
				return;
			}		
			
			input.checked = !input.checked;
			$(input).change(); // Trigger change event, manually
			// prevent from double triggering
			ev.preventDefault();
		});
		
		// Ping server every 5min to keep the session alive
		window.setInterval(function keepAlive() {
			quiz.keepAlive();
		}, 300000);
		
		// Laat huidige exec stack aflopen om custom js implementaties te laden...
		var me = this;
		if ('setImmediate' in window)
			window.setImmediate(function() { me.nextQuestion(); });
		else
			window.setTimeout(function() { me.nextQuestion(); }, 0);
	},
	nextQuestion: function() {
		if(this.options['mobile']) {
			$('.ribbon').removeClass('wrong correct');
		}
		this.$container.addClass('loading');
		$.ajax({
			dataType: 'json',
			url: this.options.questionUrl,
			context: this
		}).then(this.validateResponse).then(this.updateQuestion, this.quizError);
	},
	updateQuestion: function(data) {
		this.$form.html(data.question);
		
		if (typeof $.fn.scrollintoview === "function") {
			this.$form.find("h1").scrollintoview();
		}
		
		// Plaatjes fixen
		$(this.$form).imagesLoaded().always( function() {
			notifyParent();
		});
		  
		this.$questionNumber.html(this.options.labels.question.replace(/{number}/, data.number));
		this.validateData = data.validate || false;
		
		this.$container.removeClass('loading');
		var toFocus = this.$form.find('.focusme');
		
		if (toFocus.length) { 
			toFocus[0].focus();
		}
		// @todo: Find out what causes this very strange behavior that it doesnt work
		$(".loading").removeClass("loading");
		
		this.questionNumber = data.number;
		
		notifyParent({
			"status": "question",
			"number":  data.number
		});
	},
	answer: function($radio) {
		
		if (!this.validate()) {
			return false;
		}
		
		this.$container.addClass('loading');
		this.$selectedAnswer = $radio;
		$.ajax({
			type: "POST",
			url: this.$form.attr('action'),
			data: this.$form.serialize(),
			context: this,
			dataType: 'json'
		})
		.then(this.validateResponse)
		.then(this.updateAnswer, this.quizError);
	},
	validateResponse: function(data) {
		if (!data || typeof data !== "object") {
			return (new $.Deferred()).rejectWith(this);
		}
		return (new $.Deferred()).resolveWith(this, [data]);
	},
	updateAnswer: function(data) {
		if (this.$selectedAnswer) {
			this.$selectedAnswer.closest('li').find('.question-progress').html(data.questionProgress);
		}
		
		if (data.reloadQuestion) {
			this.nextQuestion();
			return;
		}
		
		// When using input type of questions
		if (typeof data.correct !== "undefined") {
			$focus = this.$form.find('.focusme');
			if (data.correct) {
				$focus.removeClass('wrong').addClass('correct');
			}
			else {
				$focus.removeClass('correct').addClass('wrong');
			}
		}
		
		// Show the correct answer
		if (typeof data.correctAnswer !== "undefined") {
			this.showCorrect(data.correctAnswer);
		}
		
		if (data.feedback) {
			this.feedback(data.feedback);
		}
		else {
			this.afterUpdateAnswer(data);
		}
		
	},
	showCorrect: function(correctAnswer)
	{
		$correct = this.$form.find("#correctAnswer");
		
		if ($correct.length) {
			$correct.find("span").text(correctAnswer);
			$correct.removeClass('hidden');
		}
		else
		{
			correctAnswer = ($.isArray(correctAnswer)) ? correctAnswer : [correctAnswer];
			
			$li = this.$form.find("li");
			for (var i = 0; i < correctAnswer.length; i++) {
				$li.eq(correctAnswer[i]).addClass('correct');
			}
		}
	},
	feedback: function(feedback)
	{
		var me = this;
		this.$form.html(feedback);
		this.$container.removeClass('loading');
		
		$('.continue', this.$form).click(function(e) {
			e.preventDefault();
			me.afterUpdateAnswer();
		});
		$('.loadinline', this.$form).click(function(e) {
			e.preventDefault();
			$.ajax({
				url: this.href, 
				dataType: 'json'
			}).then(function(data) {
				me.updateAnswer(data);
			});
		});
		
		// Work with images
		window.notifyParent();
		$(this.$form).imagesLoaded().always( function() {
			notifyParent();
		});
	},
	afterUpdateAnswer: function(data) {
		var quiz = this;
		data = data || {hasEnded: false};
		
		if (data.hasEnded) {
			setTimeout(function() {
				location = quiz.options.rankingUrl;
			}, 1000);
		}
		else {
			if (typeof data.askNext == "undefined" || data.askNext)
			{
				setTimeout(function() {
					quiz.nextQuestion.call(quiz);
				}, 1000);
			}
			else {
				this.$container.removeClass('loading');	
			}
		}
	},
	keepAlive: function() {
		$.get(this.options.keepAliveUrl);
	},
	quizError: function() {
		// Just escape from the page
		location = this.options.rankingUrl;
	},
	validate: function() {

		var answers = $.grep(this.$form.serializeArray(), function(element) {
			return element.name === 'answer[]';
		});
		
		// Update givenAnswers
		if (answers.length === 0) {
			return false;
		}
		
		if (this.validateData) {
			
			// Make the validation function really a function
			if (typeof this.validateData['function'] !== "function") {
				// "function(value, messages, attribute) {".length === 38
				var fnBody = this.validateData['function'].substring(38, this.validateData['function'].length - 1)
				
				// Zie ook
				// https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Function
				var callback = new Function('value', 'messages', 'attribute', fnBody);
				
				this.validateData['function'] = callback;
			}
			
			var messages = [];
			this.validateData['function'].call(this, answers[0].value, messages, 'answer');
			
			if (messages.length) {
				this._setValidationError(messages[0]);
				return false;
			}
		}
		
		this._setValidationError(false);
		return true;
	},
	// Zet de validate message op error (als error is leeg verberg de message)
	_setValidationError: function(error) {
		if (!this.validateData) {
			return true;
		}
		if (error) {
			$(".answerinput").addClass('error');
			$("#" + this.validateData.errorID).html(error).show();
			return false;
		}
		else {
			$(".answerinput").removeClass('error');
			$("#" + this.validateData.errorID).hide();
			return true;
		}
	}
});

var Assessment = AbstractQuiz.extend({
	init: function($container, options) {
		this._super($container, options);
		this.$progress = $(options.selectors.progress);
		style = 'width:' + (100 / options.questionCount) + '%;';
		for (var i = 0; i < options.questionCount; ++i) {
			$('<div></div>', {
				style: style,
				'class': i < options.questionNumber - 1 ? 'complete' : null
			}).appendTo(this.$progress);
		}
	},
	updateQuestion: function(data) {
		var index = (data.number-2);
		if (index >= 0) {
			$('div:eq('+index+')', this.$progress).addClass('complete');
		}
		this._super(data);
	},
	updateAnswer: function(data) {
		if (this.$selectedAnswer) {
			this.$selectedAnswer.parents('li:first').addClass('pressed');
		}
		
		if (data.bestAnswer) {
			$('li:eq('+(data.bestAnswer-1)+')', this.$form).addClass('correct');
		}
		if (data.description) {
			var quiz = this;
			setTimeout(function() {
				
				var description = quiz.options.descriptionTemplate.replace(/\{([a-z_0-9]+)\}/ig, function(match, field) {
					return data[field] || '';
				});
				
				var header = $(quiz.$form).find('header');
				header.nextAll().remove();
				header.after(description);
				
				$('a', quiz.$form).click(function(e) {
					e.preventDefault();
					if (data.hasEnded) {
						location = quiz.options.rankingUrl;
					}
					else {
						quiz.nextQuestion.call(quiz);
					}
				});
			}, 1000);			
		}
		else {
			this._super(data);
		}
		
	}
});

var Quiz = AbstractQuiz.extend({
	init: function($container, options) {
		this._super($container, options);
		
		this.$timeLeftover = $(options.selectors.timeLeftover);
		this.$timeProgress = $(options.selectors.timeProgress);
		this.$score = $(options.selectors.score);
		this.$timeColor = $(options.selectors.timeColor);
		this.$scoreChange = $(options.selectors.scoreChange);
		this.$timeChange = $(options.selectors.timeChange);
		var quiz = this;
		this.timer = $.timer(function(data) {
			quiz.updateTimer.call(quiz, data);
		}, 50, false);

		this.$score.html(options.score);
		this.updateTimer(options.timeRemaining);

		if(!this.options['mobile'] && self==top) {
			$(window).on('blur', function(){
				$(".gameisrunning").show();
			});
			$(".gameisrunning").click(function(e){
				e.preventDefault();
				quiz.nextQuestion();
				$(this).hide();
			});
		}		
	},
	updateQuestion: function(data) {
		this._super(data);
		this.updateTimer(data.time);
		if (!this.timer.isActive) {
			this.timer.play();
		}
	},
	updateTimer: function(timeRemaining) {
		if (timeRemaining === undefined) {
			timeRemaining = this.$timeLeftover.data('value') - this.timer.intervalTime;
		}
		
		if (timeRemaining <= 0) {
			location = this.options.rankingUrl;
			this.timer.stop();
			return;
		}
		
		var progress = (timeRemaining / this.options.startTime) * 100;

		this.$timeLeftover.data('value', timeRemaining);
		var date = new RemainingTime(timeRemaining);
		var showLeftover = date.getSeconds() + 's';
		if (date.getMinutes()) {
			showLeftover = date.getMinutes() + 'm ' + showLeftover;
		}
		this.$timeLeftover.html(RemainingTime.format(timeRemaining));
		this.$timeProgress.css('width', progress + '%');
		
		var h = (89 - 2) * (progress/100) + 2;
		var colors = hslToRgb(h, 1, 0.64);
		this.$timeColor.css('background-color', 'rgb('+colors.join(',')+')');
	},
	updateAnswer: function(data) {
		this.updateTimer(data.time);
		this.$score.html(data.score);
		if (data.timeBonusAdded > 0) {
			this.$timeChange.html('+ ' + data.timeBonusAdded + 's');
		}
		else {
			this.$timeChange.html('');
		}
		if (data.scoreAdded > 0) {
			this.$scoreChange.html('+ ' + data.scoreAdded);
			if(this.options['mobile'])
				$('.ribbon').addClass('correct');
		}
		else {
			this.$scoreChange.html('');
			if(this.options['mobile'])
				$('.ribbon').addClass('wrong');
		}				
		
		if (this.$selectedAnswer) {
			this.$selectedAnswer.parents('li:first').addClass(data.correct ? 'correct' : 'wrong');
		}
		
		if (this.timer.isActive) {
			this.timer.stop();
		}
		this._super(data);
	}	
});


var Exam = AbstractQuiz.extend({
	init: function($container, options) {
		var exam = this;
		this._super($container, options);
		this.$prev = $(options.selectors.prevQuestion, $container);
		this.$next = $(options.selectors.nextQuestion, $container);
		this.$pointsContainer = $(options.selectors.pointsContainer);
		
		// Initialize properties
		this.givenAnswers = [];
		
		$questionIndex = this.$questionIndex = $(options.selectors.questionIndex, $container);
		
		if (!options.allowNavigation) {
			this.$prev.remove();
			this.$next.remove();
		}
		else {
			
			this.$prev.hide().click(function(e) {
				e.preventDefault();
				exam.jumpToQuestion(exam.questionNumber - 1);
			});
			this.$next.hide().click(function(e) {
				e.preventDefault();
				exam.jumpToQuestion(exam.questionNumber + 1);
			});
			
			$('span:lt('+options.lastQuestionNumber+')', $questionIndex).wrapInner(function() {
				return '<a href="#" class="jump"></a>';
			}).removeClass("disabled");
			
		}
		
		if (options.timer) {
			this.$timeLeftover = $(options.selectors.timeLeftover, $container);
			this.$timeContainer = $(options.selectors.timeContainer, $container);
			this.$timeContainer.addClass(options.timer.type);

			this.timer = $.timer(function(data) {
				exam.updateTimer.call(exam, data);
			}, 50, false);
			
			$(window).on('focus', function() {
				exam.nextQuestion();
			});
			
			this.updateTimer(options.timer.timeRemaining);
		}

		this.$questionIndex.on('click', 'a', function(e) {
			e.preventDefault();
			exam.jumpToQuestion(parseInt($(this).html(), 10));
		});
	},
	jumpToQuestion: function(number) {
		$.ajax({
			dataType: 'json',
			url: this.options.jumpToQuestionUrl,
			data: {
				index: number - 1
			},
			success: function(response) {
				if (response.success) {
					this.nextQuestion();
				}
				
			},
			context: this
		});		
	},
	answer: function($radio) {
		if ($radio) {
			if (!this.options.allowFeedback) {
				$radio.parents('li:first').addClass('pressed');
			}
			
			$radio.parents('li:first').addClass('pressed');
		}
		this._super($radio);
	},
	updateQuestion: function(data) {
		this._super(data);
		
		this.givenAnswers = [];
		
		this.$pointsContainer.html(data.points);
		if (this.options.allowNavigation) {
			$('span:lt('+data.number+')', $questionIndex).filter('.disabled').wrapInner(function() {
				return '<a href="#" class="jump"></a>';
			}).removeClass("disabled");
			
			if (data.lastNumber > data.number) {
				this.$next.show();
			}
			else {
				this.$next.hide();
			}
			if (data.number > 1) {
				this.$prev.show();
			}
			else {
				this.$prev.hide();
			}			
		}
		
		this.updateTimer(data.time);
		if (this.timer != undefined && !this.timer.isActive) {
			this.timer.play();
		}		
	},
	updateAnswer: function(data) {
		this._super(data);
		this.updateTimer(data.time);
				
		var $span = $('span:eq('+(data.number-1)+')', $questionIndex);
		$span.addClass('answered');
		if (data.correct != undefined) {
			if (data.correct) {
				$span.removeClass('incorrect').addClass('correct');
			}
			else {
				$span.removeClass('correct').addClass('incorrect');
			}
			
			if (this.$selectedAnswer) {
				this.$selectedAnswer.parents('li:first').addClass(data.correct ? 'correct' : 'wrong');
			}
		}
		
		if (this.timer != undefined && this.timer.isActive) {
			this.timer.stop();
		}		
	},
	updateTimer: function(timeRemaining) {
		if (this.timer != undefined) {
			if (timeRemaining === undefined) {
				timeRemaining = this.$timeLeftover.data('value') - this.timer.intervalTime;
			}
			
			if (timeRemaining <= 0 && this.timer.isActive) {
				switch (this.options.timer.type) {
				case 'exam':
					location = this.options.rankingUrl;
					this.timer.stop();
					return;
				case 'question':
					this.nextQuestion();
					this.timer.stop();
					return;
				}
			}
			this.$timeLeftover.data('value', timeRemaining);
			var progress = (timeRemaining / this.options.timer.startTime) * 100;
			progress = Math.round(progress / 12.5);
			
			this.$timeContainer.removeClass().addClass('time_' + progress);
			this.$timeLeftover.html(RemainingTime.format(timeRemaining));			
		}
	}
});



$(function onQuizLoad(){
	if(self!=top) {
		$('html').addClass('iniframe');
	}
	
	notifyParent();
	
	$('.fblogin,.facebbutton').click(function(e) {
		e.preventDefault();
		var url = $(this).attr('href');
		FB.login(function(response) {
			if (response.status == 'connected') {
				window.location = url;
			}
		}, { scope: 'email'});	
	});
	
	// do the cookie check!
	var hasSession = /\bPHPSESSID\=[A-Za-z0-9]+\b/.test(document.cookie);
	if (!hasSession && !/[&?]safari\=/.test(location.search) && !/[&?]PHPSESSID=/.test(location.search)) {
		// There is no session
		var newLocation = location.href + (/\?/.test(location.href) ? '&' : '?') + 'safari=1';
		location.replace(newLocation);
		SessionCheck.reject();
	}
	else
	{
		SessionCheck.resolve();
	}
});

var SessionCheck = $.Deferred();

// Push also an update when images are loaded
$(window).load(function() {
	notifyParent();
});