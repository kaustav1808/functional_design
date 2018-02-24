$("#lightbox").on("click", "a.add", function() {
    console.log('check');
    var new_caption = prompt("Enter a new caption");
    if (new_caption) {
        var parent_id = $(this).data("id"),
            img_title = $(parent_id).data("title"),
            new_caption_tag = "<span class='caption'>" + new_caption + "</span>";

        $(parent_id).attr("data-title", img_title.replace(/<span class='caption'>.*<\/span>/, new_caption_tag));
        $(this).next().next().text(new_caption);
    }
});
// Make an AJAX request to save the data to the database
