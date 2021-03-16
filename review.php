<?php 
require 'includes/dbhandler.php';
require 'includes/header.php'; 
require 'includes/review-helper.php';
?>

<main>
    <span id="testAvg"></span>
    
    <span id="review_list"></span>
</main>

<script type="text/javascript">
var rateIndex = -1;
var id = <?php echo $_GET['id'];?>;


$(document).ready(function() {
    reset_star();

    // get reviews
    xhr_getter('display-reviews.php?id=', "review_list");
    //avg();
    xhr_getter('includes/get-ratings.php?id=', "testAvg");

    if (localStorage.getItem('rating') != null) {
        setStars(parseInt(localStorage.getItem('rating')));
    }
    $('.star-rev').on('click', function() {
        rateIndex = parseInt($(this).data('index'));
        localStorage.setItem('rating', rateIndex);
    });
    $('.star-rev').mouseover(function() {
        reset_star();
        var currIndex = parseInt($(this).data('index'));
        setStars(currIndex);

    });
    $('.star-rev').mouseleave(function() {
        reset_star();

        if (rateIndex != -1) {
            setStars(rateIndex);
        }
    });

    function setStars(max) {
        for (var i = 0; i < max; i++) {
            $('.star-rev:eq(' + i + ')').css('color', 'goldenrod');
        }
        document.getElementById('rating').value = parseInt(localStorage.getItem('rating'));
        console.log(id);
    }

    function reset_star() {
        $('.star-rev').css('color', 'grey');
    }


    //Used to interchangeably send GET requests for review display data. 
    function xhr_getter(prefix, element) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            // If the GET request was successful, fill in the span element with the review_list id with reviews
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById(element).innerHTML = this.responseText;
            }
        };
        url = prefix + id;
        xhttp.open("GET", url, true);
        xhttp.send();
    }
});
</script>