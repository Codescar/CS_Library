function pop_up(page)
{
	window.open(page,"popup","width=600,height=600,scrollbars=yes,toolbar=no,directories=no,hotkeys=no,location=no,menubar=no,resizable=no,titlebar=no,scroll=yes");
}
$(document).ready(loaded);
function loaded(){
	
	$('.request-book').click(function (){
		return confirm("Είσαι σίγουρος ότι ο χρήστης έχει παραλάβει το βιβλίο;", "Επιβεβαίωση");
	});
	$('.return-book').click(function (){
		return confirm("Είσαι σίγουρος ότι ο χρήστης έχει επιστρέψει το βιβλίο;", "Επιβεβαίωση");
	});
}