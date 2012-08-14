<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
	
?>
<div id="direction"><a href="index.php">Αρχική</a>&nbsp;&gt;&gt;&nbsp;Σχετικά με το Project</div>
<div class="content">
	<div class="block about">
		<div class="block bold about-title">
			CodeScar Library Project
		</div>
		<div class="block bold" style="text-align: right;">
	    	<a href="http://codescar.eu">http://codescar.eu</a><br />
	    	<a href="http://projects.codescar.eu/Library/">http://projects.codescar.eu/Library/</a>
		</div>
    	<div class="version block">
			<div class="center">Version 1.0(beta)<br />(r144, 13/03/2012)<br />
					Visual addons, EAM ready.
			</div>
			<div>Adds:
				<ul>
					<li>User Restigration (not done)</li>
					<li>Search &amp; advanced search</li>
					<li>Book categories</li>
					<li>Favorite button (not done)</li>
					<li>Availability icons of books</li>
				</ul>
			</div>
			<div>Fixes:
				<ul>
					<li>Colors &amp; templating reworked</li>
					<li>Book viewing inprovement</li>
					<li>JavaScript functionality improved</li>
					<li>Many smaller fixes</li>
				</ul>
			</div>
		</div>
    	<div class="version hidden">
			<div class="center">Version 0.4(beta)<br />(r65, 26/12/2011)<br />
					Working on...
			</div>
			<div>Adds:
				<ul>
					<li>Help content written (maybe will add more)</li>
					<li>Option to delete a request for users</li>
					<li>Message Fuction work part1</li>
				</ul>
			</div>
			<div>Fixes:
				<ul>
					<li>Improvements in admin panel</li>
					<li>Some fixes in control panel</li>
					<li>Book listing fix</li>
				</ul>
			</div>
		</div>
		<div class="block about-info" >
			Το Codescar Library είναι ένα σύστημα online διαχείρισης μιας βιβλιοθήκης. Πλέον μπορείτε 
			και εσείς να το εγκαταστήστε και να διαχειριστείτε την δική σας βιβλιοθήκη online.
			<br /><br /><br />
			<?php //TODO make those buttons work !not a high priority!
					// previous will work with jqeury ui and will show the previous version which is hidden
					// download must be each associated with the correct version
			?>
			<a href="#"><button type="button" class="right box link" style="width: 170px;">Προηγούμενη Έκδοση</button></a>
			<a href="#"><button type="button" class="left box link" style="width: 90px;">Κατέβασμα</button></a>
		</div>
		<!-- Version 0.1(alpha), (r34, 10/11/2011) <br />
    	Version 0.2(alpha), (r56, 18/12/2011) <br />
    	Version 0.3(beta) , (r58, 19/12/2011) <br />  -->
	</div>
	<div class="developers block" ><div class="dev-name">Developer Team:</div>
		<div class="dev" style="background-color: orange;"><p class="dev-name">lion2486</p>
        	<label for="email">E-Mail: </label><a class="right" href="mailto:info@lion2486.eu">info@lion2486.eu</a><br />
        	<label for="website">WebSite: </label><a class="right" href="http://lion2486.eu">www.lion2486.eu</a>
        	<?php //TODO correct your email and website info ?>
		</div>
		<div class="dev" style="background-color: chocolate;"><p class="dev-name">Sudavar</p>
    		<label for="email">E-Mail: </label><a class="right" href="mailto:sudavar@codescar.eu">sudavar@codescar.eu</a><br />
    		<label for="website">WebSite: </label><a class="right" href="http://efepa.gr">www.efepa.gr</a>
		</div>
		<div class="bold" >Care to join? <br />Send us an <a href="mailto:info@codescar.eu">email</a> :)</div>
	</div>
</div>