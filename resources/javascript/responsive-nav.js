// navs reponsive
var $mobile_main_menu = $(".mainnav nav").clone();
$mobile_main_menu.attr( "id", "mobilemainmenu" );
$mobile_main_menu.mmenu({
	"autoHeight": true,
	"offCanvas": {
		"position" : "right",
		"zposition": "front"
    },
    "extensions": [
       "border-full",
       null,
       "pageshadow"
    ]
});
var APIm = $("#mobilemainmenu").data( "mmenu" );
$("#show-main-navigation").click(function() {
	APIm.open();
});
var $mobile_lang_switch = $('.langswitch').clone();
$mobile_lang_switch.insertBefore('#mobilemainmenu .menu');

var $mobile_quizmaster_menu = $(".dashtabs .subnav nav").clone();
$mobile_quizmaster_menu.attr( "id", "mobilequizmastermenu" );
$mobile_quizmaster_menu.mmenu({
	"offCanvas": {
        "position": "left"
    },
    "extensions": [
       "border-full",
       null,
       "pageshadow"
    ]
});
var APIq = $("#mobilequizmastermenu").data( "mmenu" );
$("#show-quizmaster-navigation").click(function() {
	APIq.open();
});