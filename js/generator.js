/**
 * Bigup Web: Table of Contents - TOC Generator
 *
 * This script scrapes the article for headings, and builds a table
 * of contents using discovered headings.
 *
 * @package bigup_toc
 * @author Jefferson Real <me@jeffersonreal.com>
 * @copyright Copyright (c) 2021, Jefferson Real
 * @license GPL2+
 * @link https://jeffersonreal.com
 */

;(function($) {
    $(document).ready(function(){
        var $bigup_toc = $(".bigup_toc");
        var $content = $(".base");
        var stopAt = $bigup_toc.data("stopat");
        var hs = [];
        switch(stopAt){
            case "h6":
                hs.push("h6");
            case "h5":
                hs.push("h5");
            case "h4":
                hs.push("h4");
            case "h3":
                hs.push("h3");
            case "h2":
                hs.push("h2");
        }
        hs = hs.join();
        var headings = $content.find(hs);
        if(headings.length === 0){
            return;
        }
        var toc = "";
        toc += '<ul class="bigup_toc_list">';
        headings.each(function() {
            var $this = $(this);
            var tag = $this[0].tagName.toLowerCase();
            var txt = $this.text();
            var slug = slugify(txt);
            $this.attr("data-linked",slug);
            toc += '<li class="bigup_toc_listItem bigup_toc_listItem-'+tag+'">';
            toc += '<a class="bigup_toc_link" href="#" data-linkto="'+slug+'">'+txt+'</a></li>';
        });
        toc += "</ul>";
        $bigup_toc.append(toc);
        $(".bigup_toc ul").on("click", "a", function(e){
            e.preventDefault();
            $([document.documentElement, document.body]).animate({
                scrollTop: $content.find('[data-linked="'+$(this)
                    .attr("data-linkto")+'"]').offset()
                    .top - parseInt($bigup_toc.attr("data-offset"), 10)
            }, 2000);
        });
    });
    function slugify(text){
        return text.toString().toLowerCase()
            .replace(/\s+/g, "-")           // Replace spaces with -
            .replace(/[^\w\-]+/g, "")       // Remove all non-word chars
            .replace(/\-\-+/g, "-")         // Replace multiple - with single -
            .replace(/^-+/, "")             // Trim - from start of text
            .replace(/-+$/, "");            // Trim - from end of text
    }
})(jQuery); 
