    jQuery(".ds-result-item").click(function() { 
      var p = jQuery(this);
      jQuery("#id_settings_school").val(p.attr("data-url"));
      jQuery("#url_settings_school").val(p.attr("data-url2"));
      jQuery(".ds-list").html(" ");
      jQuery(".ds-results").hide();
      jQuery(".ds-input").val(p.attr("data-name"));
      jQuery(".shortcode-for-style span").html(p.attr("data-url"));
      
/*
* Update Frames
*/
      var url = "";
      url = "http://myschoolholidays.com/plugin.php?type=4&s="+p.attr("data-url");
      jQuery("#schools-frame-classic").attr("src", url);

      url = "http://myschoolholidays.com/plugin.php?type=3&s="+p.attr("data-url");
      jQuery("#schools-frame-small").attr("src", url);

      url = "http://myschoolholidays.com/plugin.php?type=2&s="+p.attr("data-url");
      jQuery("#schools-frame-large").attr("src", url);
      
      url = "http://myschoolholidays.com/myschool.php?type=wide&s="+p.attr("data-url");
      jQuery("#schools-frame-fullsize").attr("src", url);
      
      url = "http://myschoolholidays.com/myschool.php?s="+p.attr("data-url");
      jQuery("#schools-frame-sidebar").attr("src", url);
    });
