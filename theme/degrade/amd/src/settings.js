define([
    "jquery",
], function($) {
    return theme = {

        theme : function() {

            theme.id_s_theme_degrade_theme = $("#id_s_theme_degrade_theme");
            theme.id_s_theme_degrade_customcss = $("#id_s_theme_degrade_customcss");

            $(".seletor-de-theme").click(function() {
                var themename = $(this).attr("data-name");
                theme._theme_select(themename);
            });
            theme.id_s_theme_degrade_theme.change(function() {
                var themename = theme.id_s_theme_degrade_theme.val();
                theme._theme_select(themename);
            });
        },

        _theme_select : function(themename) {

            console.log("theme-_theme_select: " + themename);

            theme.id_s_theme_degrade_theme.val(themename);

            var themeDivSelected = $("#theme-" + themename);

            var atualcss = theme.id_s_theme_degrade_customcss.val();
            if (atualcss.length < 5) {
                var cssroot_start = themeDivSelected.attr("data-css");
                theme.id_s_theme_degrade_customcss.val(cssroot_start);

                return;
            }

            var falhou_cores = 0;
            themeDivSelected.find("span").each(function() {
                var colorElement = $(this);
                var name = colorElement.attr("data-name");
                var color = colorElement.attr("data-color");

                if (atualcss.indexOf(name) >= 0) {
                    console.log(atualcss);
                    atualcss = atualcss.replace(new RegExp(name + ": .*?;", "i"), name + ": " + color + ";");
                    console.log(atualcss);
                } else {
                    falhou_cores++;
                }
            });

            console.log(falhou_cores);
            if (falhou_cores == 0) {
                theme.id_s_theme_degrade_customcss.val(atualcss);
            } else {
                atualcss = atualcss.replace(/root\s?\{.*?\}/s, "");
                atualcss = atualcss.trim();

                var cssroot = themeDivSelected.attr("data-css");
                theme.id_s_theme_degrade_customcss.val(cssroot + "\n" + atualcss);
            }


        },

        numslides          : function() {
            var theme_degrade_slideshow_numslides = $("#id_s_theme_degrade_slideshow_numslides");

            theme_degrade_slideshow_numslides.change(function() {
                theme._numslides_changue(theme_degrade_slideshow_numslides.val());
            });

            theme._numslides_changue(theme_degrade_slideshow_numslides.val());
        },
        _numslides_changue : function(numslides) {
            for (var i = 0; i <= 9; i++) {
                if (numslides >= i) {
                    $("#admin-slideshow_info_" + i).parent().show();
                    $("#admin-slideshow_image_" + i).show();
                    $("#admin-slideshow_text_" + i).show();
                    $("#admin-slideshow_url_" + i).show();
                } else {
                    $("#admin-slideshow_info_" + i).parent().hide();
                    $("#admin-slideshow_image_" + i).hide();
                    $("#admin-slideshow_text_" + i).hide();
                    $("#admin-slideshow_url_" + i).hide();
                }
            }
        }
    };
});



