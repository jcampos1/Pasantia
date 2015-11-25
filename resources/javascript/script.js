(function($) {
	$.fn.equalHeights = function() {
		var max = 0;
		this.each(function() {
			if($(this).height() > max) {
				max = $(this).height();
			}
		});
		return this.each(function() {
			$(this).height(max);
		});
	}
	

	// menubar sticky maken
	var $menuBar = $('.menubar');
	var $mainNavBar = $('.mainnavbar');
	var $pageWrap = $('.page-wrap');
	var offset = $menuBar.offset();
	var sticky_navigation_offset_top = offset ? offset.top : 0;
	var sticky_navigation = function(){
		var scroll_top = $(window).scrollTop(); // our current vertical position from the top
		if (scroll_top > sticky_navigation_offset_top && $(window).width() >= 960) { 
			$menuBar.css({ 'position': 'fixed', 'top':0, 'left':0 });
			$mainNavBar.removeClass('fixednav');
			$mainNavBar.addClass('fixednav');
			$pageWrap.css({ 'margin-top' : '50px' });
		} else {
			$menuBar.css({ 'position': 'relative' }); 
			$pageWrap.css({ 'margin-top' : '0' });
			$mainNavBar.removeClass('fixednav');
		}   
	};
	sticky_navigation();
	$(window).scroll(function() {
		 sticky_navigation();
	});
	
	// Dropdown menu's
	if($('.dropdownify').length != 0) {
		$('.dropdownify').each(function(){
			$(this).children($('.dropdowntitle')).click(function(e){
				console.log($(this).next('.dropdownblock'));
				$(this).next('.dropdownblock').show();
				$(this).parent().addClass('opened');
				e.stopPropagation();
			});
		});
		 $("html").click(function() {
			 $('.dropdownify.opened').children('.dropdownblock').hide()
			 $('.dropdownify.opened').removeClass('opened');
		 });
	}
})(jQuery);

$(function() {
	if($(window).width() >= 768) {
		$('.equal1').equalHeights();
		$('.equal2').equalHeights();
		$('.equal3').equalHeights();
	}
});

function initCategoriesUpdate(options) {

	var $container = $('.categoriecontainer');
	var $inputContainer = $('.inputs', $container);
	var counter = $inputContainer.children(".item").length;
	
	var updateRemoveButtons = function () {
		$remove = $('.inputs > .row', $container);
		if ($remove.length > 2) {
			$remove.find(".remove").show();
		}
		else {
			$remove.find(".remove").hide();
		}
	}
		
	var imageUpload = function() {
		var $this = $(this);
		var fileuploadOptions = options.fileupload;
		fileuploadOptions.$filesContainer = $('.filescontainer', $(this));
		initFileupload($this, fileuploadOptions);
	};
	
	$('.add', $container).click(function(e) {
		e.preventDefault();
		counter++;
		
		var toAppend = $.parseHTML(options.inputTemplate.replace(/{n}/g, counter));
		
		$inputContainer.append(toAppend);
		
		$(toAppend).find('.input-image').each(imageUpload);
		$(toAppend).find('.richtextfield textarea').tinymce(tinyMCE.activeEditor.settings);
		updateRemoveButtons();
	});
	
	$container.on('click', '.remove', function (e) {
		e.preventDefault();
		
		var message = $(this).parent().find('.remove-message');
		if (message.length) {
			message.removeClass('hide');
			return;
		}
		
		$(this).closest('div.item').remove();
		updateRemoveButtons();
	});
	
	updateRemoveButtons();
	$('.input-image').each(imageUpload);
	//$('.tinymce').each(tinyMCE);
}

function initCategoriesSliders() {
	/*var getSorted = function() {
		var sliders = $('.slide-indicator');
		
		return sorted = $(sliders.toArray().sort(function (a, b) {
			return b.value - a.value; // Note this is sorting in reverse order
		}));		
	};
	
	var updateSliders = function() {
		
		var sliders = getSliders();
		var sorted = getSorted();
		var last = 100;
		
		for (var i = 0; i < sorted.length; i++) {
			
			var slider = sliders.eq(i);
			var value = sorted.eq(i).val();
			
			slider.slider('option', 'min', value);
			slider.slider('option', 'max', last);
			last = value;
		}
	};
	
	var getSliders = function() {
		return getSorted().next('.ui-slider');
	};
		
	var last = 100;
	getSorted().each(function() {
		var element = $(this);
		
		var slider = $("<div>").insertAfter(this).slider({range: true,
			min: 0,
			max: 100,
			values: [ this.value, last ],
			slide: function( event, ui ) {
				var idx = sorted.index(element);

				if (!higher.length) {
					// Geen hogere
				}
				else {
					higher.val(ui.values[1]).change();
				}
				element.val(ui.values[0]).change();
			}
		});
				
		last = this.value;
	});*/
};


function initVATFields(options)
{
	var vat = document.getElementById( options.model + '_vat_number' ).parentNode;
	var country = document.getElementById( options.model + '_country' );
	var company = document.getElementById( options.model + '_company_name' );
	
	var euList = [
		'BE', 'BG', 'CZ', 'DK', 'DE', 'EE', 'IE', 'EL', 'ES', 'FR',
		'HR', 'IT', 'CY', 'LV', 'LT', 'LU', 'HU', 'MT', 'NL', 'AT',
		'PL', 'PT', 'RO', 'SI', 'SK', 'FI', 'SE', 'UK'
	];
	
	var updateVatFieldVisiblity = function() {
		var eu = (euList.indexOf(country.value) !== -1);
		vat.style.display = (eu && company.value) ? 'block' : 'none';
	};
	
	$(country).change(updateVatFieldVisiblity);
	$(company).change(updateVatFieldVisiblity);
	
	updateVatFieldVisiblity();
}

function initPublishPage(settings) {
	$("textarea, input").on('focus', function() {
		this.select();
	});
	
	$("#crmselector").on('change', function() {
		
		var adapter = $(this).val();
		if (adapter) {
			adapter = ", " + adapter;
		}
		
		var newVal = settings.code.replace(/{adapter}/, adapter);
		$("#embedcode").val(newVal);
		
	});
	
	$(settings.old.toggle).on('click', function(ev) {
		ev.preventDefault();
		
		$(this).hide();
		$(settings.old.container).removeClass('hidden');
	});
}



function initAssessmentQuestion(template, options) {
	var $container = $('#assessmentquestionmodel, #editassessmentquestionformmodel');
	
	var newOptions = '';
	$container.on('click', '.tinyadd', function(e) {
		e.preventDefault();
		var replaced = template
			.replace(/{n}/g, $(this).data('n')).replace(/{id}/g, Math.random().toString(36).substring(7))
			.replace("</select>", newOptions + "</select>");		
		$(this).parents('.categories:first').find('.items').append(replaced);
	});
	$container.on('click', '.remove', function(e) {
		e.preventDefault();
		$(this).parents('.row:first').remove();
	});
	
	var $dialog = $('form.createcategoryform');
	
	// Geen jQuery UI ingeladen (Kan gebeuren als dit niet relevant is)
	if (!$dialog.dialog) {
		$dialog.hide();
	}
	else {
		$dialog.dialog({
			autoOpen: false,
			modal: true,
			draggable: false,
			width: 'auto', // overcomes width:'auto' and maxWidth bug
	        height: 'auto',
	        maxWidth: 600,
	        modal: true
		});
		$('.createcategory').on('click', function(e) {
			e.preventDefault();
			var html = '<ul>';
			$('.categoryselect:first option:not(:first)').each(function() {
				html += '<li>' + $(this).html() + '</li>';
			});
			html += '</ul>';
			$('.dialogcategories').html(html);
			$dialog.dialog( "option", "title", $(this).attr('title'));
			$dialog.dialog('open');
			$('.ui-dialog-content').height(($('.ui-dialog').innerHeight() - 90) + 'px');
			
			var offset = $('.ui-dialog-content input[type="submit"]').offset();
			if (offset) {
				$('.ui-dialog-content').animate({
			        scrollTop: offset.top
			    }, 1000);
			}
		});
		
		$dialog.submit(function(e) {
			e.preventDefault();
			$dialog.addClass('loading');
			$.getJSON($dialog.attr('action'), {
				title: $('[name="title"]', $dialog).val(),
				content: $('[name="content"]', $dialog).val()
			}, function(result) {
				if (result.success) {
					$('.categoryselect').append(result.option);
					newOptions+=result.option;
					$('input[type=text]', $dialog).val('');
					$('[name="content"]', $dialog).html('')
					$dialog.dialog('close');
					$dialog.removeClass('loading');
				}
			});
		});
	}
}

function initQuestions(options) {
	var $spans = $('.radiocontainer span.ir');
	var $fieldsContainer = $('.fieldscontainer');
	var $inputs = $('.fieldscontainer > div');
	var $corrAm = $("#QuizMultipleChoiseQuestionTypeModel_correct_amount");
	var _updateCorrect = function() {};
	
	for (i = 0; i < options.fields.length; ++i) {
		var field = options.fields[i];
		var rx = new RegExp('{' + field + '}', 'g');
		for (j = 0; j < options.templates.length; ++j) {
			options.templates[j] = options.templates[j].replace(rx, '<span class="tmp_'+field+'"></span>');
		}
	}
	for (i = 0; i < options.templates.length; i++) {
		options.templates[i] = options.templates[i].replace(/{[A-Za-z0-9]+}/g, '');
	}

	var getAnswers = function(fn) {
		return $(".createanswers input, .createanswers textarea").filter(function() {
			return /answer/.test(this.id);
		}).slice(4).map(function() {
			$closest = $(this).closest('.answer');
			return $closest.length ? $closest[0] : this;
		}).add(".moreanswerfield");
	};
	
	$('.radiocontainer .questiontype input:radio').change(function() {
		$spans.removeClass('active');
		$('span.ir', $(this).parent()).addClass('active');
		$fieldsContainer.append($inputs);
		$('fieldset.createanswers').remove();
		
		$fieldsContainer.after(options.templates[$(this).val()]);
		for (i = 0; i < options.fields.length; ++i) {
			var field = options.fields[i];
			$('span.tmp_' + field).replaceWith($('[data-field="'+field+'"]', $fieldsContainer));
		}
		
		$('.question_image canvas').each(function() {
			$(this).width($(this).parents('.question_image').outerWidth());
			$(this).height($(this).parents('.question_image').outerHeight());
		});
		
		$questionsField = $('fieldset:not(.radiocontainer)');
		if (!options.allowImages && this.value > 0) {
			$(".upgradecta").show();
			$questionsField.find('.fileinput-button').addClass('disabled');
			$("#QuestionModel_question").attr('disabled', 'disabled');
			$questionsField.find('input').attr('disabled', 'disabled');
			$questionsField.find('input, textarea, select').attr('disabled', 'disabled');
		}
		else {
			$(".upgradecta").hide();
			$questionsField.find('.fileinput-button').removeClass('disabled'); // In principe niet nodig
			$("#QuestionModel_question").attr('disabled', false);
			$questionsField.find('input, textarea, select').attr('disabled', false);
		}
		
		_updateCorrect();
		
		// Meerdere vragen....
		if ($("#QuestionModel_answer_5, #AssessmentQuestionModel_answer_5, #ExamQuestionModel_answer_5").val() == '') {
			getAnswers().hide();
			$("#moreAnswers").show();
		}
		else {
			$("#moreAnswers").hide();
		}
	}).filter(':checked').trigger('change');

	if ($corrAm.length)
	{
		_updateCorrect = function() {
			var _val = +$corrAm.val(); // We need is as Number
			var qs = $("#answers").children("div");
			var h2 = $("#wrongAnswersHeader");
			qs.eq(_val - 1).after(h2);
		
			var getLabel = function(index, length) {
				length = length || 4;
				if (index >= _val) {
					return (_val === length-1) ? options.wrongText : options.wrongText + " " + ((index - _val) + 1);
				}
				else {
					return (_val === 1) ? options.correctText : options.correctText + " " + (index + 1);
				}
			};
		
			// Do labels..
			
			var ll = $(".title-label");
			ll.each(function(index) {
				$(this).text(getLabel(index, ll.length));
			});
			var ll = $("input").filter(function() {
				return /answer/.test(this.id);
			});
			ll.each(function(index) {
				$(this).attr('placeholder', getLabel(index, ll.length));
			});
		};
	}
	$corrAm.change(_updateCorrect);
	_updateCorrect();
	
	// Delegated event omdat die telkens opnieuw getekend wordt.
	$(".createanswers").parent().on('click', "#moreAnswers", function (ev) {
		ev.preventDefault();
		getAnswers().show();
		$(this).hide();
	});
	
	initImageUpload(options);
}

function initAssessmentOptionsQuestion(options) {
	var addButton = $("#addOption");
	var container = $("#optioncontainer");
		
	var getOptionCount = function() {
		var numbers = $.map(container.children('.answer'), function (item) {
			return +$(item).data('index');
		});
		
		if (!numbers.length) {
			return 1;
		}
		return Math.max.apply(Math, numbers) + 1;
	};
	
	var getCategoryCount = function(categories) {
		var numbers = $.map(categories.children('.category-score'), function(item) {
			return +$(item).data('index');
		});
		
		if (!numbers.length) {
			return 1;
		}
		return Math.max.apply(Math, numbers) + 1;
	};
	
	var addItem = function(addCategory) {
		var i = getOptionCount();
		
		var newInstance = $($.parseHTML(options.templates.option.replace(/\{i\}/g, i)));
		newInstance.data('index', i);
		
		if (addCategory) {
			addCategoryOption(newInstance);
		}
		
		container.append(newInstance);
		return newInstance;
	};
	
	var addCategoryOption = function(category) {
		var container = $(category).find('.categories');
		var i = category.data('index');
		var j = getCategoryCount(container);
		
		var newInstance = $($.parseHTML(options.templates.categories.replace(/\{i\}/g, i).replace(/\{j\}/g, j)));
		newInstance.data('index', j);
		
		container.append(newInstance);
		return newInstance;
	};
	
	container.on('click', '.remove', function(ev) {
		ev.preventDefault();
		
		var category = $(this).closest('.category-score');
		
		if (category.length) {
			category.remove();
		}
		else {
			$(this).closest('.answer').remove();
		}
	});
	
	container.on('click', '.category-add', function(ev) {
		ev.preventDefault();
		addCategoryOption( $(this).closest('.answer') );
	});
	
	addButton.on('click', function(ev) {
		ev.preventDefault();
		addItem(true);
	});
	
	var searchInput = function(context, name) {
		var filter = function() {
			return (this.name.indexOf('[' + name + ']') !== -1);
		};
		
		// If the context is what we need itself
		if (context[0].name && filter.call(context[0])) {
			return context;
		}
		
		return $(context).find('input[name], select[name], textarea[name]').filter(filter);
	};
	
	if (!options.items.length) {
		options.items = [{
			answer: '',
			id: 0,
			categories: [],
			scores: []
		}];
	}
	
	for (var i = 0; i < options.items.length; i++) {
		var newItem = addItem(false);
		var catData = options.items[i];
		
		searchInput(newItem, 'answer').val(catData.answer);
		searchInput(newItem, 'id').val(catData.id);
		
		var to = Math.min(catData.scores.length, catData.categories.length);
		for (var j = 0; j < to; j++) {
			var catItem = addCategoryOption(newItem);
			searchInput(catItem, 'categories').val(catData.categories[j]);
			searchInput(catItem, 'scores').val(catData.scores[j]);
		}
		
		if (to === 0) {
			addCategoryOption(newItem);
		}
	}
};

function initCourseUploadElement(options) {
	initFileupload($('.uploadfield'), {
		$filesContainer: $('.filescontainer'),
		fileupload: {
			disableImagePreview: true
		},
		uploadUrl: options.uploadUrl
	});
}

/**
 * 
 * @todo: refactor to make it more readable
 * @param $object
 * @param options
 */
function initFileupload($object, options) {
	var $this = $object;
	var $fileInput = $this.find('input[type=file]');
	var $hiddenInput = $this.find('input[type=hidden]');
	var $form = $this.closest('form');
	var $deletBtn = $this.find(".img-delete");
	var type ='_' + $fileInput.attr('name').match(/\[([^\]]+)\]/)[1];

	var $filesContainer = options.$filesContainer == undefined ? $('#files' + type) : options.$filesContainer;
	fileuploadOptions = {
		dropZone: $this,
		dataType: 'json',
		url: options.uploadUrl,
		autoUpload: true,
		acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
		maxFileSize: 5000000, // 5 MB
		// Enable image resizing, except for Android and Opera,
		// which actually support image resizing, but fail to
		// send Blob objects via XHR requests:
		disableImageResize: /Android(?!.*Chrome)|Opera/
			.test(window.navigator.userAgent),
		previewCrop: true,
		previewThumbnail: false,
		multipart: true,
		singleFileUploads: true,
		maxNumberOfFiles: 1,
		limitMultiFileUploads: 1,
		filesContainer: $filesContainer,
		replaceFileInput: false
	};
	if (options.fileupload !== undefined)
		$.extend(fileuploadOptions, options.fileupload);
	
	$fileInput.fileupload(fileuploadOptions).on('fileuploadadd', function (e, data) {
		disableForm($form);
		$fileInput.fileupload('option', 'previewMaxWidth', $filesContainer.parent().width());
		$fileInput.fileupload('option', 'previewMaxHeight', $filesContainer.parent().height());
		
		$filesContainer.empty();
		data.context = $('<div/>').appendTo($filesContainer);
		$.each(data.files, function (index, file) {
			//.context;
			var node = $('<p/>').append($('<span/>'));
			if (!index) {
				node.append('<br>');
			}
			node.appendTo(data.context);
		});
	}).on('fileuploadprocessalways', function (e, data) {
		$fileInput.val('');
		var index = data.index,
		file = data.files[index],
		node = $(data.context.children()[index]);
		if (file.preview) {
			node.prepend('<br>').prepend(file.preview);
		}
		if (file.error) {
			node.append('<br>').append($('<span class="text-danger"/>').text(file.error));
		}
		if (index + 1 === data.files.length) {
			data.context.find('button').text('Upload').prop('disabled', !!data.files.error);
		}
	}).on('fileuploaddone', function(e, data) {
		enableForm($form);
		if (!data.result[0]) {
			return;
		}
		if (data.result[0].error) {
			var error = $('<span class="errorMessage">').text(data.result[0].error);
			$fileInput.parent().after(error);
			$hiddenInput.val('');
			$fileInput.val('');
			return;
		}
		else {
			$('.errorMessage', $object).remove();
		}
		
		if (data.result[0].content) {
			$filesContainer.html(data.result[0].content);
		}
		
		if (data.result[0].update) {
			for (var key in data.result[0].update) {
				$(key).html(data.result[0].update[key]);
			}
		}
			
		$hiddenInput.val(data.result[0].filename).trigger('change');
		$deletBtn.show();
	});
	
	$deletBtn.on('click', function(ev) {
		ev.preventDefault();
		$hiddenInput.val('').trigger('change');
		$filesContainer.empty();
		$deletBtn.hide();
		if ($deletBtn.data('delete-url')) {
			$.getJSON($deletBtn.data('delete-url'), function(data) {
				if (data.update) {
					for (var key in data.update) {
						//console.log($(key).size());
						$(key).html(data.update[key]);
					}			
				}
			});
		}
	});	
}

/**
 * Schakelt een formulier uit.
 * 
 * @param {jQuery} $form
 */
function disableForm($form) {
	var disabledTimes = ($form.data('disabledTimes') || 0) + 1;
	if (disabledTimes <= 0) {
		disabledTimes = 1;
	}
	$form.data('disabledTimes', disabledTimes);
	
	if (disabledTimes >= 1) {
		$form.find('input[type=submit], button[type=submit]').addClass('disabled');
		$form.on('submit', stopEvent);
	}
	return disabledTimes;
}


/**
 * Schakelt een formulier in.
 *  
 * @param {jQuery} $form
 */
function enableForm($form) {
	var disabledTimes = ($form.data('disabledTimes') || 0) - 1;
	$form.data('disabledTimes', disabledTimes);
	
	if (disabledTimes > 0) {
		return disabledTimes;
	}
	
	$form.find('input[type=submit], button[type=submit]').removeClass('disabled');
	$form.off('submit', stopEvent);
	return disabledTimes;
}

/**
 * 
 * @param ev
 */
function stopEvent(ev) {
	ev.preventDefault();
	ev.stopPropagation();
}

function initImageUpload(options) {
	if($('html').hasClass('oldie')) {
		return;
	}
		
	$('.input-image').each(function() {
		var $this = $(this);
		var $fileInput = $this.find('input[type=file]');
		initFileupload($this, {
			uploadUrl: options.baseUrl + '/index.php?r=manage' + options.type + '/uploadImage&fieldName=' + encodeURIComponent($fileInput.attr('name'))
		});
	});
}

function initSortableQuestionsIndex(options) {
	var $container = $("table.items tbody");
	$container.sortable({
		helper: function(e, ui) {
            ui.children().each(function() {
                $(this).width($(this).width());
            });
            return ui;
        },
        update: function() {
        	var data = $container.sortable('serialize', {key: 'items[]', attribute: 'class'});
        	$.ajax({
        		url: options.url,
        		type: 'post',
        		data: data,
        		success: function() {
        			var number = 1;
        			$('tr td:first-child', $container).each(function() {
        				$(this).html(number++);
        			});
        		},
        		error: function() {
        			alert(options.error);
        		}
        	})
        }
	});
}

// Do note that this is called by aswell as the quiz as exam statistics 
function initStatsPage(okTxt, cancelTxt) {
	var $dialog = $("#confirm-cleanup");
	var $link = $("#confirm-cleanup-link");
	
	var buttons = {};
	buttons[okTxt] = function() {
		$form = $('#RankingSelectionForm');
		$form.attr('action', $link[0].href).submit();
		
		//location.href = $link.attr('href');
		$( this ).dialog( "close" );
	};
	buttons[cancelTxt] = function() {
		$( this ).dialog( "close" );
	};
	
	$dialog.dialog({
		resizable: false,
		height:140,
		autoOpen: false,
		modal: true,
		buttons: buttons
	});
	
	$link.on('click', function(ev) {
		ev.preventDefault();
		$dialog.dialog('open');
	});
}

function initQuizSettingsUpdate(options) {
	$(".colorpickercontainer input").spectrum(options.spectrum);
	
	if (options.settingGroups) {
		$("#tabs").tabs();
		$("#tabs").on("focus", "input", function(ev) {
			var before = $(this).closest(".contentbox").parent().prevAll("div").length;
			$( "#tabs" ).tabs( "option", "active", before );
		});
	}
	
	if (options.image) {
		initImageUpload(options.image);
	}
	
	// Make quiz_settings_functional
	var box = $("#QuizModel_enable_challenge_a_friend");
	if (box.length) {
		var fields = $("#QuizModel_challenge_a_friend_message, #QuizModel_challenge_a_friend_subject").parent();
		
		var _updateField = function() {
			fields[box[0].checked ? 'show' : 'hide']();
		};
		box.on('change', _updateField);
		_updateField();
	};
	
	$("#QuizModel_share_facebook, #AssessmentModel_share_facebook, #ExamModel_share_facebook").change(function() {
		var func = this.checked ? 'show' : 'hide';
		$(".share_facebook_image")[ func ]();
	}).change();
	
	$(".extrasettingintro").each(function() {
		var intro = $(this);
		var related = intro.next('.extrasettings');
		var checkbox = intro.find('.checkboxfield input');
		
		checkbox.prop('checked', !!related.find('input, textarea').filter(function() {
			return !!this.value;
		}).length );
	
		checkbox.on('change', function() {
			related[ this.checked ? 'show' : 'hide' ]();
		}).trigger('change');
	});
	
	// Tab met foutmelding activeren
	var error = $("#tabs .errorMessage:not(.hide)").eq(0);
	if (error.length) {
		var index = error.closest(".ui-tabs-panel").prevAll(".ui-tabs-panel").length;
		$("#tabs").tabs( "option", "active", index);
	}
	
	var colorMap = {
		backgroundColor: options.modelName + '_color_background',
		lightColor:      options.modelName + '_color_light_color',
		primaryColor:    options.modelName + '_color_primary_color',
		primaryText:     options.modelName + '_color_primary_text',
		subColor:        options.modelName + '_color_sub_color'
	};
	
	$("#" + options.modelName + "_stylesheet").on('change', function() {
		var defaults = options.defaultColors[this.value];
		
		for (var key in defaults) {
			if (!(key in colorMap)) {
				continue;
			}
			
			console.log(defaults[key]);
			
			var field = document.getElementById(colorMap[key]);
			$(field).spectrum('set', defaults[key]);
		}
	});
}

function initSettingsPlayerInfo(options) {
	var playField = $("#QuizModel_account_askfields");
	var playGroups = ['profile', 'player', 'player'];
	var playInitVal = playGroups[playField.val()];
	var warning = $("#accountRankingWarning");
	
	warning.hide();
	playField.change(function() {
		warning[ playGroups[playField.val()] != playInitVal ? 'show' : 'hide']();
	});
	
	$("#" + options.model + "_account_requirement").change(function() {
		var fn = this.value != 1 ? 'show' : 'hide';
		$(".extrainfocontainer")[fn]();
	}).change();
	
	$(".requiredplayerinfo select").change(function() {
		var classNames = options.classMap[this.value];
		this.parentNode.className = 'selectfield ' + classNames;
	}).change();
};

function initSettingsMoreFields(containers) {
	$(containers).each(function() {
		
		var container = $(this);
		var fields = container.children('div');
		var button = container.find('.button');
		
		// Search for the index of the last invisible field
		for (var i = fields.length-1; i > 0; i--) {
			var field = fields.eq(i);
			if (field.find('input').filter(function() { return !!this.value} ).length)
				break;
		}
		var index = i+1;
		
		// Hide all fields starting with index
		for (var i = index; i < fields.length; i++) {
			fields.eq(i).hide();
		}
		
		var fnBtnHide = function() {
			if (index == fields.length) {
				button.hide();
			}
		}
		
		button.on('click', function(ev) {
			ev.preventDefault();
			fields.eq(index).show();
			index++;
			fnBtnHide();
		});
		fnBtnHide();
		
	});
};

function initSettingsRequirements(options) {
};

function initBehaviorConfig(model, behavior) {
	var $enableCheckBox = $("#" + model + "_behavior_" + behavior + "_enable");
	var $settingsContainer = $("#config_" + behavior + "_container");
	
	$enableCheckBox.on('change', function() {
		$settingsContainer[ this.checked ? 'show' : 'hide' ]();
	});
	
	$enableCheckBox.change(); // Force state sync
};

function initQuestionsOveriew(options) {
	
	$("#gridcontainer").hide();
	
	// Voorkom form submit on enter
	$("#gridcontainer").on('keypress', '.filters input', function(ev) {
		if (ev.which == '13') {
			ev.preventDefault();
		}
	});
	
	$("#gridcontainer").on('change', "#selectallcheckboxhierboven", function() {
		$("#gridcontainer tbody input:not([disabled])").prop('checked', this.checked);
	});
	
	var curQuiz = false;
	$("#QuestionsOverviewForm_quiz").change(function() {
		updateQuizSelections(this.value); 
	});
	
	function updateQuizSelections(currentId) {
		var sCur = currentId + '';
		
		if (sCur) {
			$("#gridcontainer").show();
			$("#gridcontainer").addClass('showgrid');
		}
		
		$("#gridcontainer tbody tr").each(function() {
			var $me = $(this);
			var $input = $me.find('input');
			
			// om een vage reden geeft jquery data automatisch
			// nummers (primitive) wanneer voldoet aan /[0-9]/.
			var quizzes = String($me.data('quizzes'));
			
			if (quizzes.split(/,/).indexOf(sCur) !== -1) {
				$me.addClass('incurrentquiz');
				$input.prop('checked', true).prop('disabled', true);
			}
			else {
				$me.removeClass('incurrentquiz');
				$input.prop('checked', false).prop('disabled', false);
			}
			
		});
	}
	
	$("#gridcontainer").on('click', '.showfullinfo', function(ev) {
		ev.preventDefault();
		
		var row =$(this).closest('tr');
		var url = options.questionUrl.replace( /%7Bid%7D/g, row.data('id')) // '%7Bid%7D' === encodeURIComponent('{id'}) 
	
		// Maak nieuwe div -> laad ajax request -> toon als dialog
		$("<div>").load(url, function() {
			$(this).dialog({
				resizable: false,
           // height: 400,
            	width: 600,
            	autoOpen: true,
            	modal: true,
            	title: options.dialogTitle
			});
		});
		
	});
	
	// Trigger select box change (als gecached, of via terug pagina)
	$("#QuestionsOverviewForm_quiz").change();
};

function initExamSettingsUpdate() {
	var $time = $('#ExamModel_time').parent();
	$('#ExamModel_time_limit').change(function() {
		if ($(this).val() == 0) {
			$time.hide();
		}
		else {
			$time.show();
		}
	}).trigger('change');
	
	var $numberOfAttempts = $('#ExamModel_number_of_attempts').parent();
	$('#ExamModel_type').change(function() {
		if ($(this).val() == 3) {
			$numberOfAttempts.show();
		}
		else {
			$numberOfAttempts.hide();
		}
	}).trigger('change');	
}

function initExamQuestionIndex(options) {
	if (options.allowRecycle) {
		var $dialog = $("#import-dialog").hide().dialog({
			modal:true,
			autoOpen:false,
			resizable: false,
			'max-height' : '500px',
			width: '600px',
			title: options.title
		});
		$dialog.parent().css('max-width', '600px');
		
		$(".importquestion").on('click', function(ev) {
			ev.preventDefault();
			$.ajax({
				url: this.href,
				success: function(data) {
					$dialog.html(data).dialog('open');
					
				}
			});
		});
	}
};

function initUpdateAssessmentQuestionDescription() {
	var $description = $('#desc_fields');
	$('#AssessmentQuestionModel_show_description').change(function() {
		if ($(this).val() == 0) {
			$description.hide();
		}
		else {
			$description.show();
		}
	}).change();
}

function initRounds(options) {
		
	var localeOptions = {
		nl : {
			'dateFormat':'dd-mm-yy',
			'hourGrid':6,
			'minuteGrid':15,
			'timeFormat':'hh:mm',
			'changeMonth':true,
			'changeYear':true,
			'timeOnlyTitle':'Kies de tijd',
			'timeText':'Tijd',
			'hourText':'Uur','closeText':'Ok',
			'minuteText':'Minuut',
			'secondText':'Seconde'
		},
		en : {
			'dateFormat':'dd-mm-yy',
			'hourGrid':6,
			'minuteGrid':15,
			'timeFormat':'hh:mm',
			'changeMonth':true,
			'changeYear':true,
			'timeOnlyTitle':'Choose Time',
			'timeText':'Time',
			'hourText':'Hour',
			'closeText':'Ok',
			'minuteText':'Minute',
			'secondText':'Second'
		}
	};
	
	var _initPickers = function() {
		$(".datepicker").datetimepicker($.extend({showMonthAfterYear:false}, $.datepicker.regional[options.lang], localeOptions[options.lang]));
	};
	
	_initPickers();
	
	$(".row.inputs").on('click', '.remove:not(.disabled)', function (e) {
		e.preventDefault();
		$(this).parents('div.row:first').remove();
	});
	
	$(".button.add:not(.disabled)").on('click', function() {
		var translate = {
			'{idx}' :  $(".row.inputs > div").length
		};
		
		$(".row.inputs").append(options.inputTemplate.replace(/\{[a-zA-Z_]+}/g, function(a) {
			return translate[a] || '';
		}));
		_initPickers();
	});
	
}

function initUserManagement()
{
	$("#tabs").tabs();
	$('.csv-import').hide();
	$('.import-user').hide();
	
	$('.show-test-email').on('click', function(e){
		e.preventDefault();
		$('.buttons-container').hide(200);
		$('.test-email').show(200);
	});
	
	$('.show-csv-import').on('click', function(e){
		e.preventDefault();
		$('.csv-import').show(200);
		$('.import-buttons').hide(200);
	});

	$('.show-import-user').on('click', function(e){
		e.preventDefault();
		$('.import-user').show(200);
		$('.import-buttons').hide(200);
	});
	
	$('.cancel-import').on('click', function(e){
		e.preventDefault();
		$('.csv-import').hide(200);
		$('.import-user').hide(200);
		$('.import-buttons').show(200);
	});
	
}

function initCourseElementIndex(options) {
	$(".showsubtypes").click(function(e) {
		e.preventDefault();
		$(this).hide();
		$(".subtypes").show();
	});
	$(".subtypes .cancel").click(function(e){ 
		e.preventDefault();
		$(".subtypes").hide();
		$(".showsubtypes").show();
	});	
	
	$('[data-confirm]').click(function(e) {
		if (!confirm($(this).data('confirm'))) {
			e.preventDefault();
		}
	});
	
	$container = $(".courselist");
	$container.sortable({
		items: "li:not(.unsortable)",
		placeholder: "ui-sortable-placeholder",
		axis: "y",
        update: function() {
        	var data = $container.sortable('serialize');
        	$.ajax({
        		url: options.updateSortUrl,
        		type: 'post',
        		data: data,
        		success: function() {
        			var number = 1;
        			$('li.courseitem span.step', $container).each(function() {
        				$(this).html(number++);
        			});
        		},
        		error: function() {
        			alert(options.error);
        		}
        	})
        }		
	});
	$(".courselist").disableSelection();	
}

function initPageLeave(message) {
	window.onbeforeunload = function(){
		if ($('form:first input[type=\"text\"][value!=\"\"], form:first textarea[value!=\"\"]').size() == 0) {
			return;
		}
		return message;
	}
	$('form').submit(function(){
		window.onbeforeunload = null;
	});
	$('.previewaction .button, .facebbutton').click(function(){
		window.onbeforeunload = null;
	});	
}


function tinyMceCustom(ed) {
	tinymce.PluginManager.add('qwmedia', function(editor, url) {
		var urlPatterns = [
			{regex: /youtu\.be\/([\w\-.]+)/, type: 'iframe', w: 425, h: 350, url: '//www.youtube.com/embed/$1'},
			{regex: /youtube\.com(.+)v=([^&]+)/, type: 'iframe', w: 425, h: 350, url: '//www.youtube.com/embed/$2'},
			{regex: /vimeo\.com\/([0-9]+)/, type: 'iframe', w: 425, h: 350, url: '//player.vimeo.com/video/$1?title=0&byline=0&portrait=0&color=8dc7dc'},
			{regex: /vimeo\.com\/(.*)\/([0-9]+)/, type: "iframe", w: 425, h: 350, url: "//player.vimeo.com/video/$2?title=0&amp;byline=0"},
			{regex: /maps\.google\.([a-z]{2,3})\/maps\/(.+)msid=(.+)/, type: 'iframe', w: 425, h: 350, url: '//maps.google.com/maps/ms?msid=$2&output=embed"'}
		];

		var embedChange = (tinymce.Env.ie && tinymce.Env.ie <= 8) ? 'onChange' : 'onInput';

		function guessMime(url) {
			if (url.indexOf('.mp3') != -1) {
				return 'audio/mpeg';
			}

			if (url.indexOf('.wav') != -1) {
				return 'audio/wav';
			}

			if (url.indexOf('.mp4') != -1) {
				return 'video/mp4';
			}

			if (url.indexOf('.webm') != -1) {
				return 'video/webm';
			}

			if (url.indexOf('.ogg') != -1) {
				return 'video/ogg';
			}

			if (url.indexOf('.swf') != -1) {
				return 'application/x-shockwave-flash';
			}

			return '';
		}

		function getVideoScriptMatch(src) {
			var prefixes = editor.settings.media_scripts;

			if (prefixes) {
				for (var i = 0; i < prefixes.length; i++) {
					if (src.indexOf(prefixes[i].filter) !== -1) {
						return prefixes[i];
					}
				}
			}
		}

		function showDialog() {
			var win, width, height, data;

			var generalFormItems = [
				{
					name: 'source1',
					type: 'filepicker',
					filetype: 'media',
					size: 40,
					autofocus: true,
					label: 'Source',
					onchange: function(e) {
						tinymce.each(e.meta, function(value, key) {
							win.find('#' + key).value(value);
						});
					}
				}
			];

			function recalcSize(e) {
				var widthCtrl, heightCtrl, newWidth, newHeight;

				widthCtrl = win.find('#width')[0];
				heightCtrl = win.find('#height')[0];

				newWidth = widthCtrl.value();
				newHeight = heightCtrl.value();

				if (win.find('#constrain')[0].checked() && width && height && newWidth && newHeight) {
					if (e.control == widthCtrl) {
						newHeight = Math.round((newWidth / width) * newHeight);
						heightCtrl.value(newHeight);
					} else {
						newWidth = Math.round((newHeight / height) * newWidth);
						widthCtrl.value(newWidth);
					}
				}

				width = newWidth;
				height = newHeight;
			}

			if (editor.settings.media_alt_source !== false) {
				generalFormItems.push({name: 'source2', type: 'filepicker', filetype: 'media', size: 40, label: 'Alternative source'});
			}

			if (editor.settings.media_poster !== false) {
				generalFormItems.push({name: 'poster', type: 'filepicker', filetype: 'image', size: 40, label: 'Poster'});
			}

			if (editor.settings.media_dimensions !== false) {
				generalFormItems.push({
					type: 'container',
					label: 'Dimensions',
					layout: 'flex',
					align: 'center',
					spacing: 5,
					items: [
						{name: 'width', type: 'textbox', maxLength: 3, size: 3, onchange: recalcSize},
						{type: 'label', text: 'x'},
						{name: 'height', type: 'textbox', maxLength: 3, size: 3, onchange: recalcSize},
						{name: 'constrain', type: 'checkbox', checked: true, text: 'Constrain proportions'}
					]
				});
			}

			data = getData(editor.selection.getNode());
			width = data.width;
			height = data.height;

			var embedTextBox = {
				id: 'mcemediasource',
				type: 'textbox',
				flex: 1,
				name: 'embed',
				value: getSource(),
				multiline: true,
				label: 'Source',
				minWidth: 300,
				minHeight: 100
			};

			function updateValueOnChange() {
				data = htmlToData(this.value());
				this.parent().parent().fromJSON(data);
			}

			embedTextBox[embedChange] = updateValueOnChange;

			win = editor.windowManager.open({
				title: 'Insert/edit video',
				data: data,
				body: {
					title: 'Embed',
					type: "panel",
					layout: 'flex',
					direction: 'column',
					align: 'stretch',
					padding: 10,
					spacing: 10,
					onShowTab: function() {
						this.find('#embed').value(dataToHtml(this.parent().toJSON()));
					},
					items: [
						{
							type: 'label',
							text: 'Paste your embed code below:',
							forId: 'mcemediasource'
						},
						embedTextBox
					]
				},
				onSubmit: function() {
					var beforeObjects, afterObjects, i, y;

					beforeObjects = editor.dom.select('img[data-mce-object]');
					editor.insertContent(dataToHtml(this.toJSON()));
					afterObjects = editor.dom.select('img[data-mce-object]');

					// Find new image placeholder so we can select it
					for (i = 0; i < beforeObjects.length; i++) {
						for (y = afterObjects.length - 1; y >= 0; y--) {
							if (beforeObjects[i] == afterObjects[y]) {
								afterObjects.splice(y, 1);
							}
						}
					}

					editor.selection.select(afterObjects[0]);
					editor.nodeChanged();
				}
			});
		}

		function getSource() {
			var elm = editor.selection.getNode();

			if (elm.getAttribute('data-mce-object')) {
				return editor.selection.getContent();
			}
		}

		function dataToHtml(data) {
			var html = '';

			if (!data.source1) {
				tinymce.extend(data, htmlToData(data.embed));
				if (!data.source1) {
					return '';
				}
			}

			if (!data.source2) {
				data.source2 = '';
			}

			if (!data.poster) {
				data.poster = '';
			}

			data.source1 = editor.convertURL(data.source1, "source");
			data.source2 = editor.convertURL(data.source2, "source");
			data.source1mime = guessMime(data.source1);
			data.source2mime = guessMime(data.source2);
			data.poster = editor.convertURL(data.poster, "poster");
			data.flashPlayerUrl = editor.convertURL(url + '/moxieplayer.swf', "movie");

			tinymce.each(urlPatterns, function(pattern) {
				var match, i, url;

				if ((match = pattern.regex.exec(data.source1))) {
					url = pattern.url;

					for (i = 0; match[i]; i++) {
						/*jshint loopfunc:true*/
						/*eslint no-loop-func:0 */
						url = url.replace('$' + i, function() {
							return match[i];
						});
					}

					data.source1 = url;
					data.type = pattern.type;
					data.width = data.width || pattern.w;
					data.height = data.height || pattern.h;
				}
			});

			if (data.embed) {
				html = updateHtml(data.embed, data, true);
			} else {
				var videoScript = getVideoScriptMatch(data.source1);
				if (videoScript) {
					data.type = 'script';
					data.width = videoScript.width;
					data.height = videoScript.height;
				}

				data.width = data.width || 300;
				data.height = data.height || 150;

				tinymce.each(data, function(value, key) {
					data[key] = editor.dom.encode(value);
				});

				if (data.type == "iframe") {
					html += '<iframe src="' + data.source1 + '" width="' + data.width + '" height="' + data.height + '"></iframe>';
				} else if (data.source1mime == "application/x-shockwave-flash") {
					html += '<object data="' + data.source1 + '" width="' + data.width + '" height="' + data.height + '" type="application/x-shockwave-flash">';

					if (data.poster) {
						html += '<img src="' + data.poster + '" width="' + data.width + '" height="' + data.height + '" />';
					}

					html += '</object>';
				} else if (data.source1mime.indexOf('audio') != -1) {
					if (editor.settings.audio_template_callback) {
						html = editor.settings.audio_template_callback(data);
					} else {
						html += (
							'<audio controls="controls" src="' + data.source1 + '">' +
								(data.source2 ? '\n<source src="' + data.source2 + '"' + (data.source2mime ? ' type="' + data.source2mime + '"' : '') + ' />\n' : '') +
							'</audio>'
						);
					}
				} else if (data.type == "script") {
					html += '<script src="' + data.source1 + '"></script>';
				} else {
					if (editor.settings.video_template_callback) {
						html = editor.settings.video_template_callback(data);
					} else {
						html = (
							'<video width="' + data.width + '" height="' + data.height + '"' + (data.poster ? ' poster="' + data.poster + '"' : '') + ' controls="controls">\n' +
								'<source src="' + data.source1 + '"' + (data.source1mime ? ' type="' + data.source1mime + '"' : '') + ' />\n' +
								(data.source2 ? '<source src="' + data.source2 + '"' + (data.source2mime ? ' type="' + data.source2mime + '"' : '') + ' />\n' : '') +
							'</video>'
						);
					}
				}
			}

			return html;
		}

		function htmlToData(html) {
			var data = {};

			new tinymce.html.SaxParser({
				validate: false,
				allow_conditional_comments: true,
				special: 'script,noscript',
				start: function(name, attrs) {
					if (!data.source1 && name == "param") {
						data.source1 = attrs.map.movie;
					}

					if (name == "iframe" || name == "object" || name == "embed" || name == "video" || name == "audio") {
						if (!data.type) {
							data.type = name;
						}

						data = tinymce.extend(attrs.map, data);
					}

					if (name == "script") {
						var videoScript = getVideoScriptMatch(attrs.map.src);
						if (!videoScript) {
							return;
						}

						data = {
							type: "script",
							source1: attrs.map.src,
							width: videoScript.width,
							height: videoScript.height
						};
					}

					if (name == "source") {
						if (!data.source1) {
							data.source1 = attrs.map.src;
						} else if (!data.source2) {
							data.source2 = attrs.map.src;
						}
					}

					if (name == "img" && !data.poster) {
						data.poster = attrs.map.src;
					}
				}
			}).parse(html);

			data.source1 = data.source1 || data.src || data.data;
			data.source2 = data.source2 || '';
			data.poster = data.poster || '';

			return data;
		}

		function getData(element) {
			if (element.getAttribute('data-mce-object')) {
				return htmlToData(editor.serializer.serialize(element, {selection: true}));
			}

			return {};
		}

		function sanitize(html) {
			if (editor.settings.media_filter_html === false) {
				return html;
			}

			var writer = new tinymce.html.Writer();

			new tinymce.html.SaxParser({
				validate: false,
				allow_conditional_comments: false,
				special: 'script,noscript',

				comment: function(text) {
					writer.comment(text);
				},

				cdata: function(text) {
					writer.cdata(text);
				},

				text: function(text, raw) {
					writer.text(text, raw);
				},

				start: function(name, attrs, empty) {
					if (name == 'script' || name == 'noscript') {
						return;
					}

					for (var i = 0; i < attrs.length; i++) {
						if (attrs[i].name.indexOf('on') === 0) {
							return;
						}
					}

					writer.start(name, attrs, empty);
				},

				end: function(name) {
					if (name == 'script' || name == 'noscript') {
						return;
					}

					writer.end(name);
				}
			}, new tinymce.html.Schema({})).parse(html);

			return writer.getContent();
		}

		function updateHtml(html, data, updateAll) {
			var writer = new tinymce.html.Writer();
			var sourceCount = 0, hasImage;

			function setAttributes(attrs, updatedAttrs) {
				var name, i, value, attr;

				for (name in updatedAttrs) {
					value = "" + updatedAttrs[name];

					if (attrs.map[name]) {
						i = attrs.length;
						while (i--) {
							attr = attrs[i];

							if (attr.name == name) {
								if (value) {
									attrs.map[name] = value;
									attr.value = value;
								} else {
									delete attrs.map[name];
									attrs.splice(i, 1);
								}
							}
						}
					} else if (value) {
						attrs.push({
							name: name,
							value: value
						});

						attrs.map[name] = value;
					}
				}
			}

			new tinymce.html.SaxParser({
				validate: false,
				allow_conditional_comments: true,
				special: 'script,noscript',

				comment: function(text) {
					writer.comment(text);
				},

				cdata: function(text) {
					writer.cdata(text);
				},

				text: function(text, raw) {
					writer.text(text, raw);
				},

				start: function(name, attrs, empty) {
					switch (name) {
						case "video":
						case "object":
						case "embed":
						case "img":
						case "iframe":
							setAttributes(attrs, {
								width: data.width,
								height: data.height
							});
							break;
					}

					if (updateAll) {
						switch (name) {
							case "video":
								setAttributes(attrs, {
									poster: data.poster,
									src: ""
								});

								if (data.source2) {
									setAttributes(attrs, {
										src: ""
									});
								}
								break;

							case "iframe":
								setAttributes(attrs, {
									src: data.source1
								});
								break;

							case "source":
								sourceCount++;

								if (sourceCount <= 2) {
									setAttributes(attrs, {
										src: data["source" + sourceCount],
										type: data["source" + sourceCount + "mime"]
									});

									if (!data["source" + sourceCount]) {
										return;
									}
								}
								break;

							case "img":
								if (!data.poster) {
									return;
								}

								hasImage = true;
								break;
						}
					}

					writer.start(name, attrs, empty);
				},

				end: function(name) {
					if (name == "video" && updateAll) {
						for (var index = 1; index <= 2; index++) {
							if (data["source" + index]) {
								var attrs = [];
								attrs.map = {};

								if (sourceCount < index) {
									setAttributes(attrs, {
										src: data["source" + index],
										type: data["source" + index + "mime"]
									});

									writer.start("source", attrs, true);
								}
							}
						}
					}

					if (data.poster && name == "object" && updateAll && !hasImage) {
						var imgAttrs = [];
						imgAttrs.map = {};

						setAttributes(imgAttrs, {
							src: data.poster,
							width: data.width,
							height: data.height
						});

						writer.start("img", imgAttrs, true);
					}

					writer.end(name);
				}
			}, new tinymce.html.Schema({})).parse(html);

			return writer.getContent();
		}

		editor.on('ResolveName', function(e) {
			var name;

			if (e.target.nodeType == 1 && (name = e.target.getAttribute("data-mce-object"))) {
				e.name = name;
			}
		});

		editor.on('preInit', function() {
			// Make sure that any messy HTML is retained inside these
			var specialElements = editor.schema.getSpecialElements();
			tinymce.each('video audio iframe object'.split(' '), function(name) {
				specialElements[name] = new RegExp('<\/' + name + '[^>]*>', 'gi');
			});

			// Allow elements
			//editor.schema.addValidElements('object[id|style|width|height|classid|codebase|*],embed[id|style|width|height|type|src|*],video[*],audio[*]');

			// Set allowFullscreen attribs as boolean
			var boolAttrs = editor.schema.getBoolAttrs();
			tinymce.each('webkitallowfullscreen mozallowfullscreen allowfullscreen'.split(' '), function(name) {
				boolAttrs[name] = {};
			});

			// Converts iframe, video etc into placeholder images
			editor.parser.addNodeFilter('iframe,video,audio,object,embed,script', function(nodes, name) {
				var i = nodes.length, ai, node, placeHolder, attrName, attrValue, attribs, innerHtml;
				var videoScript;

				while (i--) {
					node = nodes[i];
					if (!node.parent) {
						continue;
					}

					if (node.name == 'script') {
						videoScript = getVideoScriptMatch(node.attr('src'));
						if (!videoScript) {
							continue;
						}
					}

					placeHolder = new tinymce.html.Node('img', 1);
					placeHolder.shortEnded = true;

					if (videoScript) {
						if (videoScript.width) {
							node.attr('width', videoScript.width.toString());
						}

						if (videoScript.height) {
							node.attr('height', videoScript.height.toString());
						}
					}

					// Prefix all attributes except width, height and style since we
					// will add these to the placeholder
					attribs = node.attributes;
					ai = attribs.length;
					while (ai--) {
						attrName = attribs[ai].name;
						attrValue = attribs[ai].value;

						if (attrName !== "width" && attrName !== "height" && attrName !== "style") {
							if (attrName == "data" || attrName == "src") {
								attrValue = editor.convertURL(attrValue, attrName);
							}

							placeHolder.attr('data-mce-p-' + attrName, attrValue);
						}
					}

					// Place the inner HTML contents inside an escaped attribute
					// This enables us to copy/paste the fake object
					innerHtml = node.firstChild && node.firstChild.value;
					if (innerHtml) {
						placeHolder.attr("data-mce-html", escape(innerHtml));
						placeHolder.firstChild = null;
					}

					placeHolder.attr({
						width: node.attr('width') || "300",
						height: node.attr('height') || (name == "audio" ? "30" : "150"),
						style: node.attr('style'),
						src: tinymce.Env.transparentSrc,
						"data-mce-object": name,
						"class": "mce-object mce-object-" + name
					});

					node.replace(placeHolder);
				}
			});

			// Replaces placeholder images with real elements for video, object, iframe etc
			editor.serializer.addAttributeFilter('data-mce-object', function(nodes, name) {
				var i = nodes.length, node, realElm, ai, attribs, innerHtml, innerNode, realElmName;

				while (i--) {
					node = nodes[i];
					if (!node.parent) {
						continue;
					}

					realElmName = node.attr(name);
					realElm = new tinymce.html.Node(realElmName, 1);

					// Add width/height to everything but audio
					if (realElmName != "audio" && realElmName != "script") {
						realElm.attr({
							width: node.attr('width'),
							height: node.attr('height')
						});
					}

					realElm.attr({
						style: node.attr('style')
					});

					// Unprefix all placeholder attributes
					attribs = node.attributes;
					ai = attribs.length;
					while (ai--) {
						var attrName = attribs[ai].name;

						if (attrName.indexOf('data-mce-p-') === 0) {
							realElm.attr(attrName.substr(11), attribs[ai].value);
						}
					}

					if (realElmName == "script") {
						realElm.attr('type', 'text/javascript');
					}

					// Inject innerhtml
					innerHtml = node.attr('data-mce-html');
					if (innerHtml) {
						innerNode = new tinymce.html.Node('#text', 3);
						innerNode.raw = true;
						innerNode.value = sanitize(unescape(innerHtml));
						realElm.append(innerNode);
					}

					node.replace(realElm);
				}
			});
		});

		editor.on('ObjectSelected', function(e) {
			var objectType = e.target.getAttribute('data-mce-object');

			if (objectType == "audio" || objectType == "script") {
				e.preventDefault();
			}
		});

		editor.on('objectResized', function(e) {
			var target = e.target, html;

			if (target.getAttribute('data-mce-object')) {
				html = target.getAttribute('data-mce-html');
				if (html) {
					html = unescape(html);
					target.setAttribute('data-mce-html', escape(
						updateHtml(html, {
							width: e.width,
							height: e.height
						})
					));
				}
			}
		});

		editor.addButton('media', {
			tooltip: 'Insert/edit video',
			onclick: showDialog,
			stateSelector: ['img[data-mce-object=video]', 'img[data-mce-object=iframe]']
		});

		editor.addMenuItem('media', {
			icon: 'media',
			text: 'Insert video',
			onclick: showDialog,
			context: 'insert',
			prependToContext: true
		});
	});

}