    function School_Holidays_getschools(e) {
      jQuery.get('../wp-content/plugins/mySchoolHolidays/ajax.php', {text:e.value}, function(data) {
        jQuery(".ds-list").html(data);
        if (data != "") {
          jQuery(".ds-results").show();
          
          jQuery(".ds-result-item").click(function() { 
            var p = jQuery(this);
            p.parent().parent().parent().children("input").val(p.attr("data-url"));
            p.parent().parent().children("input").val(p.attr("data-url2"));
            jQuery(".ds-list").html(" ");
            jQuery(".ds-results").hide();
            jQuery(".ds-input").val(p.attr("data-name"));
          });
        } else {
          jQuery(".ds-results").hide();
        }
      });
    }
