(function( $ ) {
    let carLmt = 50;
    let readMoreTxt = " ... More";
    let readLessTxt = "Less";

    $(".review_comments").each(function() {

        let allstr = $(this).text();
        if (allstr.length > carLmt) {
            let firstSet = allstr.substring(0, carLmt);
            let secdHalf = allstr.substring(carLmt, allstr.length);
            let strtoadd = firstSet + "<span class='SecSec'>" + secdHalf + "</span><span class='readMore'  title='Click to Show More'>" + readMoreTxt + "</span><span class='readLess' title='Click to Show Less'>" + readLessTxt + "</span>";
            $(this).html(strtoadd);
        }

    });

    $(document).on("click", ".readMore,.readLess", function() {
        $(this).closest(".review_comments ").toggleClass("column-review_comments showmorecontent");
    });

})( jQuery );