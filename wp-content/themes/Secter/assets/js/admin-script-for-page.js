jQuery(window).load(function () {
    document.getElementById("page_template").addEventListener("change", function () {
        jQuery('input#publish').click();
    });
});