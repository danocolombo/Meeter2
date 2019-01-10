$(document)
		.ready(
				function() {
					// Function to change form action.
					$("#db")
							.change(
									function() {
										var selected = $(this).children(
												":selected").text();
										switch (selected) {
										case "Google$(document).ready(function() {
// Function to change form action.
$("#db").change(function() {
var selected = $(this).children(":selected").text();
switch (selected) {
case "My-Sql":
$("#myform").attr('action', 'http://google.com');
alert("Form Action is Changed to 'mysql.html'n Press Submit to Confirm");
break;
case "Oracle":
$("#myform").attr('action', 'http://yahoo.com');
alert("Form Action is Changed to 'oracle.html'n Press Submit to Confirm");
break;
case "MS-Access":
$("#myform").attr('action', http://bing.com');
alert("Form Action is Changed to 'msaccess.html'n Press Submit to Confirm");
break;
default:
$("#myform").attr('action', '#');
}
});
// Function For Back Button
$(".back").click(function() {
parent.history.back();
return false;
});
});":
											$("#myform").attr('action',
													'http://google.com');
											alert("Form Action is Changed to 'mysql.html'n Press Submit to Confirm");
											break;
										case "Yahoo":
											$("#myform").attr('action',
													'http://yahoo.com');
											alert("Form Action is Changed to 'oracle.html'n Press Submit to Confirm");
											break;
										case "Bings":
											$("#myform").attr('action',
													'http://bing.com');
											alert("Form Action is Changed to 'msaccess.html'n Press Submit to Confirm");
											break;
										default:
											$("#myform").attr('action', '#');
										}
									});
					// Function For Back Button
					$(".back").click(function() {
						parent.history.back();
						return false;
					});
				});