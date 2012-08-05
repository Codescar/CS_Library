function pop_up(page)
{
	window.open(page,"popup","width=600,height=600,scrollbars=yes,toolbar=no,directories=no,hotkeys=no,location=no,menubar=no,resizable=no,titlebar=no,scroll=yes");
}

function loaded(){
	
	$('.request-book').click(function (){
		return confirm("Είσαι σίγουρος ότι ο χρήστης έχει παραλάβει το βιβλίο;", "Επιβεβαίωση");
	});
	$('.return-book').click(function (){
		return confirm("Είσαι σίγουρος ότι ο χρήστης έχει επιστρέψει το βιβλίο;", "Επιβεβαίωση");
	});
	$('.cansel-request').click(function (){
		return confirm("Είσαι σίγουρος ότι Θέλεις να ακυρώσεις αυτό το αίτημά σου;", "Επιβεβαίωση");
	});
	$('.delete-announce').click(function (){
		return confirm("Είσαι σίγουρος ότι Θέλεις να διαγράψεις αυτή την ανακοίνωση;", "Επιβεβαίωση");
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
    })
}

function check_no_image(){
	$('#no-image').attr('checked', 'checked');
	
}

function check_with_image(){
	$('#with-image').attr('checked', 'checked');
	
}