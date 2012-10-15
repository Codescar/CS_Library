
    <script type="text/javascript">

    // This is the first thing we add ------------------------------------------
    $(document).ready(function() {
      
        $('.rate_widget').each(function(i) {
            var widget = this;
            var out_data = {
                widget_id : $(widget).attr('id'),
                fetch: 1
            };
            $.post(
                'index.php?method=ajax',
                out_data,
                function(INFO) {
                    $(widget).data( 'fsr', INFO );
                    set_votes(widget);
                },
                'json'
            );
        });

        $('.ratings_stars').hover(
            // Handles the mouseover
            function() {
                $(this).prevAll().andSelf().addClass('ratings_over');
                $(this).nextAll().removeClass('ratings_vote'); 
            },
            // Handles the mouseout
            function() {
                $(this).prevAll().andSelf().removeClass('ratings_over');
                // can't use 'this' because it wont contain the updated data
                set_votes($(this).parent());
            }
        );
        
        
        // This actually records the vote
        $('.ratings_stars').bind('click', function() {
            var star = this;
            var widget = $(this).parent();
            
            var clicked_data = {
                clicked_on : $(star).attr('class'),
                widget_id : $(star).parent().attr('id')
            };
            <?php 
            global $user;
            if($user->is_logged_in()){
            ?>
            $.post(
                'index.php?method=ajax',
                clicked_data,
                function(INFO) {
                    widget.data( 'fsr', INFO );
                    set_votes(widget);
                },
                'json'
            ); 
            <?php } else { ?>
			alert("Θα πρέπει να έχεις σνδεθεί με το λογαριασμό σου για να ψηφίσεις!");
            <?php } ?>
        });
        
    });

    function set_votes(widget) {

        var avg = $(widget).data('fsr').whole_avg;
        var votes = $(widget).data('fsr').number_votes;
        var exact = $(widget).data('fsr').dec_avg;
        
        //alert('object whole_avg = ' + avg + '\nvotes: ' + votes + '\nexact: ' + exact);
        window.console && console.log('and now in set_votes, it thinks the fsr is ' + $(widget).data('fsr').number_votes);
   
        $(widget).find('.star_' + avg).prevAll().andSelf().addClass('ratings_vote');
        $(widget).find('.star_' + avg).nextAll().removeClass('ratings_vote'); 
        $(widget).find('.total_votes').text( votes + ' votes recorded (' + exact + ' rating)' );
    }
    // END FIRST THING
    </script>
    
    <style type="text/css">
        .rate_widget {
            border:     1px solid #CCC;
            overflow:   visible;
            padding:    10px;
            position:   relative;
            width:      180px;
            height:     32px;
        }
        .ratings_stars {
            background: url('view/images/ratings/star_empty.png') no-repeat;
            float:      left;
            height:     28px;
            padding:    2px;
            width:      32px;
        }
        .ratings_vote {
            background: url('view/images/ratings/star_full.png') no-repeat;
        }
        .ratings_over {
            background: url('view/images/ratings/star_highlight.png') no-repeat;
        }
        .total_votes {
            background: #eaeaea;
            top: 58px;
            left: 0;
            padding: 5px;
            position:   absolute;  
        } 
        .movie_choice {
            font: 10px verdana, sans-serif;
            margin: 0 auto 40px auto;
            width: 180px;
        }
        h1 {
            text-align: center;
            width: 400px;
            margin: 20px auto;
        }
    </style>
<div id="<?php echo $args[0]; ?>" class="rate_widget">
	<div class="star_1 ratings_stars"></div>
	<div class="star_2 ratings_stars"></div>
	<div class="star_3 ratings_stars"></div>
	<div class="star_4 ratings_stars"></div>
	<div class="star_5 ratings_stars"></div>
	<div class="total_votes">vote data</div>
</div>

