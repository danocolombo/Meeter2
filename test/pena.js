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
										case "Google":
											$("#myform").attr('action',
													'http://google.com');
											alert("Going to use Google. Press Submit to visit");
											break;
										case "Yahoo":
											$("#myform").attr('action',
													'http://yahoo.com');
											alert("Going to use Yahoo. Press Submit to vist");
											break;
										case "Bing":
											$("#myform").attr('action',
													'http://bing.com');
											alert("Going to use Bing. Press Submit to Confirm");
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