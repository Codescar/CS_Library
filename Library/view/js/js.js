function pop_up(page)
{
	window.open(page,"popup","width=600,height=600,scrollbars=yes,toolbar=no,directories=no,hotkeys=no,location=no,menubar=no,resizable=no,titlebar=no,scroll=yes");
}

//TODO make those actions work and not only show a pop up
function loaded(){
	$('.request-book').click(function (){
		return confirm("Να καταχωρυθεί το αίτημα δανεισμού;", "Επιβεβαίωση");
	});
	$('.lend-book').click(function (){
		return confirm("Είσαι σίγουρος ότι ο χρήστης έχει παραλάβει το βιβλίο;", "Επιβεβαίωση");
	});
	$('.return-book').click(function (){
		return confirm("Είσαι σίγουρος ότι ο χρήστης έχει επιστρέψει το βιβλίο;", "Επιβεβαίωση");
	});
	$('.cansel-request').click(function (){
		return confirm("Είσαι σίγουρος ότι θέλεις να ακυρώσεις αυτό το αίτημά σου;", "Επιβεβαίωση");
	});
	$('.delete-request').click(function (){
		return confirm("Είσαι σίγουρος ότι θέλεις να διαγράψεις το αίτημά;", "Επιβεβαίωση");
	});
	$('.delete-option').click(function (){
		return confirm("Είσαι σίγουρος ότι θέλεις να διαγράψεις την ρύθμιση;", "Επιβεβαίωση");
	});
	$('.delete-user').click(function (){
		return confirm("Είσαι σίγουρος ότι θέλεις να διαγράψεις τον χρήστη;", "Επιβεβαίωση");
	});
	$('.delete-announce').click(function (){
		return confirm("Είσαι σίγουρος ότι θέλεις να διαγράψεις αυτή την ανακοίνωση;", "Επιβεβαίωση");
	});
	$('.delete-book').click(function (){
		return confirm("Είσαι σίγουρος ότι θέλεις να διαγράψεις το βιβλίο;", "Επιβεβαίωση");
	});	
	$('.must-login').click(function (){
		alert('Πρέπει να συνδεθείτε πρώτα');
	});
	$('.renewal').click(function (){
		return confirm("Να κρατήσει ο χρήστης το βιβλίο για μερικές μέρες ακόμα;", "Επιβεβαίωση");
	});
	$('.fav-add').click(function (){
		return confirm("Είσαι σίγουρος ότι θέλεις να το προσθέσεις στα αγαπημένα σου;", "Επιβεβαίωση");
	});
	$('.fav-remove').click(function (){
		return confirm("Είσαι σίγουρος ότι θέλεις να το αφαιρέσεις από τα αγαπημένα σου;", "Επιβεβαίωση");
	});
	$('.enable-maintenance').click(function(){
		return confirm("Είσαι σίγουρος πως θες να ενεργοποιήσεις την κατάσταση συντήρησης? Κατά την διάρκεια της η σελίδα δεν θα είναι διαθέσιμη στους χρήστες", "Επιβεβαίωση");
	});
	$('.disable-maintenance').click(function(){
		return confirm("Να απενεργοποιηθεί η κατάσταση συντήρησης?", "Επιβεβαίωση");
	});
	$('.category-select').click(function(){
		$('#category-more').attr('value', 'category');
	});
}

$(document).ready(loaded);

function showPictureUtil()
{
    $("#PictureUtil").dialog({ 
        modal: true, 
        overlay: { 
            opacity: 0.7, 
            background: "black"
        },
        width: "60%"	  
    });
}

function check_no_image(){
	$('#no-image').attr('checked', 'checked');
	
}

function check_with_image(){
	$('#with-image').attr('checked', 'checked');
	
}