jQuery(document).ready(function(e) {

    e('#link_new_window').on('change', function() {
        if (e(this).is(':checked')) {
            e('.title_2.title_link_out').attr('target', 'blank');
        } else {
            e('.title_2.title_link_out').attr('target', '');
        }
    });
    function r() {
        e(".box_html.centerDiv").html('<div id="square_preview" class="squareDemo shape box" style="background-color: rgb(185, 185, 185); border-color: rgb(0, 0, 0); width: 200px; height: 200px;"> <span class="textArea" style="height: 150px; width: 180px;">This is a fully customizable box builder plug-in. Display marketing info, images, text etc... as you wish</span> <div entrance="1" id="square-lit" class="squareLitDemo shape" style="height: 200px; width: 200px; top: 160px;"> <a class="title_2 title_link_out"><h3 class="title">TITLE</h3></a> <hr class="divLit"> <div class="textAreaWrapper"> <span class="textArea" style="height: 150px; width: 180px;"> This is a fully customizable box builder plug-in. Display marketing info, images, text etc... as you wish </span> </div> </div> </div>')
    }
    function i() {
        e(".edit").on("click", function() {
            var t = this;
            if (typeof this.id != "undefined") {
                e(".box_html.centerDiv").html("");
                var n = {action: "GET_BOX", id: t.id.replace("edit_", "")};
                e.post(ajaxurl, n, function(t) {
                    e(".box_html.centerDiv").html("");
                    var n = t[0].box_html.replace(/\\/g, "");
                    e(".box_html.centerDiv").html(n);
                    e("html, body").animate({scrollTop: 0}, "slow");
                    e(".top_side_1 .save_RoundCorner_TL").val(t[0].c_rc_1);
                    e(".top_side_1 .save_RoundCorner_TR").val(t[0].c_rc_2);
                    e(".top_side_1 .save_RoundCorner_BL").val(t[0].c_rc_3);
                    e(".top_side_1 .save_RoundCorner_BR").val(t[0].c_rc_4);
                    e(".top_side_1 .save_BackgroundColor_1").val(t[0].c_bg_c);
                    e(".top_side_1 .save_BorderColor_1").val(t[0].c_bd_c);
                    e(".top_side_1 .save_FontColor_1").val(t[0].c_ft_c);
                    e(".top_side_1 .save_BorderWidth_1").val(t[0].c_brd);
                    e(".top_side_1 .save_Opacity1").val(t[0].c_opc);
                    g();
                    e(".top_side_1 .save_Width_1").val(t[0].c_wid);
                    e(".top_side_1 .save_Height_1").val(t[0].c_hei);
                    e(".top_side_1 .save_Text_1").val(t[0].c_txt);
                    e(".top_side_1 .fontSize1").val(t[0].c_txt_fnt_sz);
                    e(".top_side_1 .fontSpacing1").val(t[0].c_txt_spc);
                    if (t[0].l_entr != 1) {
                        e('#hEffect option:contains("' + t[0].l_entr + '")').prop("selected", true);
                        e(".entranceOpts > input").attr("disabled", "disabled")
                    } else {
                        e('#hEffect option:contains("Slide")').prop("selected", true);
                        e(".entranceOpts > input").removeAttr("disabled")
                    }
                    e(".lit_prop.save_RoundCorner_TL").val(t[0].l_rc_1);
                    e(".lit_prop.save_RoundCorner_TR").val(t[0].l_rc_2);
                    e(".lit_prop.save_RoundCorner_BL").val(t[0].l_rc_3);
                    e(".lit_prop.save_RoundCorner_BR").val(t[0].l_rc_4);
                    e(".lit_prop.save_BackgroundColor_1").val(t[0].l_bg_c);
                    e(".lit_prop.save_FontColor_1").val(t[0].l_ft_c);
                    e(".lit_prop.save_TitleColor_1").val(t[0].l_tl_c);
                    e(".lit_prop.save_DividerColor_1").val(t[0].l_dv_c);
                    if (t[0].l_dv == "" || t[0].l_dv == null) {
                        e("#litDivider").removeAttr("checked")
                    } else
                        e("#litDivider").attr("checked", t[0].l_dv);
                    e(".lit_prop.save_Opacity2").val(t[0].l_opc);
                    A();
                    e(".lit_prop.title.span11").val(t[0].l_titl);
                    e(".lit_prop.fontSizeT").val(t[0].l_titl_fnt_sz);
                    e(".save_Text_2").val(t[0].l_txt);
                    e(".fontSize2").val(t[0].l_txt_fnt_sz);
                    e(".fontSpacing2").val(t[0].l_txt_spc);
                    e(".title_l").val(t[0].l_titl_lnk);
                    e(".transparentContainer").addClass(t[0].trans_1);
                    e(".transparentLit").addClass(t[0].trans_2);
                    e(".italicsContainer").addClass(t[0].italics_1);
                    e(".italicsLit").addClass(t[0].italics_2);
                    e(".italicsTitle").addClass(t[0].italics_3);
                    e(".boldContainer").addClass(t[0].boald_1);
                    e(".boldLit").addClass(t[0].boald_2);
                    e(".boldTitle").addClass(t[0].boald_3);
                    h();
                    $LIT = e(".squareLitDemo.shape");
                    $BOX = e(".squareDemo.shape.box");
                    e(".save_name").val(t[0].title)
                })
            }
        });
        e(".remove").on("click", function() {
            P("action", {head: "Are you sure you want to Delte this?", body: 'If you completly delete this, it will also be removed from anywhere it is being used, or you can: <a href="google.com">Delete it but keep it anywhere its being used</a>', action: {pertinent: "Completly Delete", def: "Delete but keep in website", call: "comp_delete", pertinent_id: this.id.replace("del_", "")}})
        })
    }
    function s() {
        e(".containerTitle .title").on("change", function() {
            e("#square-lit .title").html(e(this).val())
        })


    }
    function o(t) {
        if (t.files && t.files[0]) {
            var n = new FileReader;
            n.onload = function(t) {
                e("#square_preview").css({background: "transparent url(" + t.target.result + ") left top no-repeat", "background-size": "100%"})
            };
            n.readAsDataURL(t.files[0])
        }
    }
    function u() {
        var t = 0;
        var n = 0;
        var r = 0;
        var i = 0;
        var s = 0;
        var o = 0;
        e(".qPod").on("click", function() {
            switch (this.id) {
                case"qPodU":
                    t = t + 2;
                    e(".shape.squareDemo > .textArea").css("margin-top", -t);
                    break;
                case"qPodL":
                    n = n + 2;
                    e(".shape.squareDemo > .textArea").css("margin-left", -n);
                    break;
                case"qPodR":
                    n = n - 2;
                    e(".shape.squareDemo > .textArea").css("margin-left", -n);
                    break;
                case"qPodD":
                    t = t - 2;
                    e(".shape.squareDemo > .textArea").css("margin-top", -t);
                    break
            }
        });
        e(".qPod2").on("mouseenter", function() {
            topVal = e(".shape.squareLitDemo").css("top");
            e(".shape.squareLitDemo").css("top", "0")
        });
        e(".qPod2").on("mouseleave", function() {
            e(".shape.squareLitDemo").css("top", topVal)
        });
        e(".qPod2").on("click", function() {
            switch (this.id) {
                case"qPodU":
                    r = r + 2;
                    e(".shape.squareLitDemo > .textAreaWrapper").css("margin-top", -r);
                    break;
                case"qPodL":
                    i = i + 2;
                    e(".shape.squareLitDemo > .textAreaWrapper").css("margin-left", -i);
                    break;
                case"qPodR":
                    i = i - 2;
                    e(".shape.squareLitDemo > .textAreaWrapper").css("margin-left", -i);
                    break;
                case"qPodD":
                    r = r - 2;
                    e(".shape.squareLitDemo > .textAreaWrapper").css("margin-top", -r);
                    break
            }
        });
        e(".qPod3").on("click", function() {
            switch (this.id) {
                case"qPodU":
                    if (s <= 0) {
                        s = 0
                    }
                    s = s - 2;
                    e(".shape.squareLitDemo > a .title").css("padding-top", s);
                    break;
                case"qPodL":
                    o = o + 2;
                    e(".shape.squareLitDemo > a .title").css("margin-left", -o);
                    break;
                case"qPodR":
                    o = o - 2;
                    e(".shape.squareLitDemo > a .title").css("margin-left", -o);
                    break;
                case"qPodD":
                    s = s + 2;
                    e(".shape.squareLitDemo > a .title").css("padding-top", s);
                    break
            }
        })
    }
    function a() {
        e("#litDivider").on("change", function() {
            if (e(this).attr("checked")) {
                e(".divLit").removeClass("hidden")
            } else {
                e(".divLit").addClass("hidden")
            }
        })
    }
    function f() {
        e(".textArea").css("height", e(".shape.squareDemo").height() - 50);
        e(".textArea").css("width", e(".shape.squareDemo").width() - 20);
        if (e(".squareLitDemo").attr("entrance") == 1 || e(".squareLitDemo").attr("entrance") == 2) {
            e(".shape.squareDemo .squareLitDemo").css("height", e(".shape.squareDemo").height());
            e(".shape.squareDemo .squareLitDemo").css("width", e(".shape.squareDemo").width())
        } else if (e(".squareLitDemo").attr("entrance") == 3 || e(".squareLitDemo").attr("entrance") == 4) {
            e(".shape.squareDemo .squareLitDemo").css("height", e(".shape.squareDemo").height());
            e(".shape.squareDemo .squareLitDemo").css("width", e(".shape.squareDemo").width());
            e(".shape.squareDemo .squareLitDemo").css("top", "0")
        } else if (e(".squareLitDemo").attr("entrance") == "effect") {
            e(".shape.squareDemo .squareLitDemo").css("width", e(".shape.squareDemo").width());
            e(".shape.squareDemo .squareLitDemo").css("height", e(".shape.squareDemo").height())
        }
        height_val = e("#square_preview").height();
        width_val = e("#square_preview").width();
        title_val = e("#square_preview h3.title").height();
        e(".squareDemo.shape.box").mouseenter();
        e(".squareDemo.shape.box").mouseleave();
        if (e(".squareDemo.shape.box").width() > 500) {
            e(".main_container").width(1208);
            e(".main_container").width(e(".main_container").width() + e(".squareDemo.shape.box").width() - 200 + "px")
        } else {
            e(".main_container").width(1108)
        }
        if (e(".squareDemo.shape.box").height() > 750) {
            e(".historyContainer").css("margin-top", e(".squareDemo.shape.box").height() - 700 + "px")
        } else {
            e(".historyContainer").css("margin-top", "0")
        }
    }
    function l() {
        e(".shape.squareDemo").css("border-radius", e(".save_RoundCorner_1").val() + "px");
        e(".shape.squareDemo").css("border-width", e(".save_BorderWidth_1").html().replace(" %", "") + "%");
        e(".shape.squareDemo").css("background-color", e(".save_BackgroundColor_1").val());
        e(".shape.squareDemo").css("border-color", e(".save_BorderColor_1").val());
        e(".shape.squareDemo > .textArea").html(e(".save_Text_1").val());
        e(".shape.squareDemo").css("width", e(".save_Width_1").val());
        e(".shape.squareDemo").css("height", e(".save_Height_1").val());
        e(".shape.squareLitDemo").css("background-color", e(".save_BackgroundColor_2").val());
        e(".shape.squareLitDemo > .textArea").html(e(".save_Text_2").val())
    }
    function c() {
        var t = {action: "GET_SAVED_BOXES", data: {}};
        e.post(ajaxurl, t, function(t) {
            e(".resulst_Boxes").html("");
            e.each(t, function(t, n) {
                var r = n.box_html.replace(/\\/g, "");
                var r = r.replace("square", "square_" + n.id);
                var r = r.replace("shape", "shape2");
                var r = r.replace("textArea", "textArea2");
                var r = r.replace("title", "title2");
                var r = r.replace("squareDemo", "squareDemo squareDemo_history ");
                var r = r.replace("squareLitDemo", "squareLitDemo2 squareDemo_history");
                e(".resulst_Boxes").append('<tr><td><button id="del_' + n.id + '" class="btn span12 btn-danger btn-mini remove">Delete</button><button id="edit_' + n.id + '" class="btn btn-warning span12 btn-mini edit">Edit</button></td><td>' + n.title + "</td><td>" + n.date_created + '</td><td class="html_render_' + n.id + '"></td><td>' + n.short_code.replace("test", n.id) + "</td></tr>");
                e(".html_render_" + n.id).html(r)
            });
            p();
            i()
        })
    }
    function h() {
        e("#square_preview").unbind("hover");
        e("#square_preview").hover(function() {
            if (e(this).find(".squareLitDemo").attr("entrance") == 1) {
                e(this).find(".squareLitDemo").animate({top: "0"}, {queue: false, duration: 400})
            } else if (e(this).find(".squareLitDemo").attr("entrance") == 2) {
                e(this).find(".squareLitDemo").animate({top: "0"}, {queue: false, duration: 400})
            } else if (e(this).find(".squareLitDemo").attr("entrance") == 3) {
                e(this).find(".squareLitDemo").animate({right: "0"}, {queue: false, duration: 400})
            } else if (e(this).find(".squareLitDemo").attr("entrance") == 4) {
                e(this).find(".squareLitDemo").animate({right: "0"}, {queue: false, duration: 400})
            } else if (e(this).find(".squareLitDemo").attr("entrance") == "effect") {
                if (!$BOX.hasClass("maskImg")) {
                    $BOX.addClass("maskImg")
                }
                $LIT.removeClass("animated " + $LIT.attr("out")).addClass("animated " + $LIT.attr("in"))
            }
        }, function() {
            if (e(this).find(".squareLitDemo").attr("entrance") == 1) {
                e(this).find(".squareLitDemo").animate({top: height_val - title_val}, {queue: false, duration: 400})
            } else if (e(this).find(".squareLitDemo").attr("entrance") == 2) {
                e(this).find(".squareLitDemo").animate({top: -(height_val - title_val)}, {queue: false, duration: 400})
            } else if (e(this).find(".squareLitDemo").attr("entrance") == 3) {
                e(this).find(".squareLitDemo").animate({right: width_val}, {queue: false, duration: 400})
            } else if (e(this).find(".squareLitDemo").attr("entrance") == 4) {
                e(this).find(".squareLitDemo").animate({right: -width_val}, {queue: false, duration: 400})
            } else if (e(this).find(".squareLitDemo").attr("entrance") == "effect") {
                $LIT.removeClass("animated " + $LIT.attr("in")).addClass("animated " + $LIT.attr("out"))
            }
        })
    }
    function p() {
        e(".squareDemo_history").unbind("hover");
        e(".squareDemo_history").hover(function() {
            if (e(this).find(".squareLitDemo2").attr("entrance") == 1) {
                e(this).find(".squareLitDemo2").animate({top: "0"}, {queue: false, duration: 400})
            } else if (e(this).find(".squareLitDemo2").attr("entrance") == 2) {
                e(this).find(".squareLitDemo2").animate({top: "0"}, {queue: false, duration: 400})
            } else if (e(this).find(".squareLitDemo2").attr("entrance") == 3) {
                e(this).find(".squareLitDemo2").animate({right: "0"}, {queue: false, duration: 400})
            } else if (e(this).find(".squareLitDemo2").attr("entrance") == 4) {
                e(this).find(".squareLitDemo2").animate({right: "0"}, {queue: false, duration: 400})
            } else if (e(this).find(".squareLitDemo2").attr("entrance") == "effect") {
                if (!e(this).find(".squareLitDemo2").hasClass("maskImg")) {
                    e(this).find(".squareLitDemo2").addClass("maskImg")
                }
                e(this).find(".squareLitDemo2").removeClass("animated " + e(this).find(".squareLitDemo2").attr("out")).addClass("animated " + e(this).find(".squareLitDemo2").attr("in"))
            }
        }, function() {
            if (e(this).find(".squareLitDemo2").attr("entrance") == 1) {
                e(this).find(".squareLitDemo2").animate({top: height_val - title_val}, {queue: false, duration: 400})
            } else if (e(this).find(".squareLitDemo2").attr("entrance") == 2) {
                e(this).find(".squareLitDemo2").animate({top: -(height_val - title_val)}, {queue: false, duration: 400})
            } else if (e(this).find(".squareLitDemo2").attr("entrance") == 3) {
                e(this).find(".squareLitDemo2").animate({right: width_val}, {queue: false, duration: 400})
            } else if (e(this).find(".squareLitDemo2").attr("entrance") == 4) {
                e(this).find(".squareLitDemo2").animate({right: -width_val}, {queue: false, duration: 400})
            } else if (e(this).find(".squareLitDemo2").attr("entrance") == "effect") {
                e(this).find(".squareLitDemo2").removeClass("animated " + e(this).find(".squareLitDemo2").attr("in")).addClass("animated " + e(this).find(".squareLitDemo2").attr("out"))
            }
        })
    }
    function d() {
        if (e(".rCorners .input-append .displayValue").val() == "")
            e(".rCorners .input-append .displayValue").val(0);
        var t = e(".rCorners .input-append .displayValue").val();
        var n = 1;
        e(".rCorners .input-append .displayValue.save_RoundCorner_TL").on("change", function() {
            t = e(this).val();
            e(".shape.squareDemo").css("border-top-left-radius", t + "px")
        });
        e(".rCorners .input-append .displayValue.save_RoundCorner_TR").on("change", function() {
            t = e(this).val();
            e(".shape.squareDemo").css("border-top-right-radius", t + "px")
        });
        e(".rCorners .input-append .displayValue.save_RoundCorner_BR").on("change", function() {
            t = e(this).val();
            e(".shape.squareDemo").css("border-bottom-right-radius", t + "px")
        });
        e(".rCorners .input-append .displayValue.save_RoundCorner_BL").on("change", function() {
            t = e(this).val();
            e(".shape.squareDemo").css("border-bottom-left-radius", t + "px")
        })
    }
    function v() {
        if (e(".rCorners2 .input-append .displayValue").val() == "")
            e(".rCorners2 .input-append .displayValue").val(0);
        var t = e(".rCorners2 .input-append .displayValue").val();
        var n = 1;
        e(".rCorners2 .input-append .displayValue.save_RoundCorner_TL").on("change", function() {
            t = e(this).val();
            e(".shape.squareLitDemo").css("border-top-left-radius", t + "px")
        });
        e(".rCorners2 .input-append .displayValue.save_RoundCorner_TR").on("change", function() {
            t = e(this).val();
            e(".shape.squareLitDemo").css("border-top-right-radius", t + "px")
        });
        e(".rCorners2 .input-append .displayValue.save_RoundCorner_BR").on("change", function() {
            t = e(this).val();
            e(".shape.squareLitDemo").css("border-bottom-right-radius", t + "px")
        });
        e(".rCorners2 .input-append .displayValue.save_RoundCorner_BL").on("change", function() {
            t = e(this).val();
            e(".shape.squareLitDemo").css("border-bottom-left-radius", t + "px")
        })
    }
    function m() {
        if (e(".borderWidth .input-append .displayValue").val() == "")
            e(".borderWidth .input-append .displayValue").val(0);
        var t = e(".borderWidth .input-append .displayValue").val();
        var n = 1;
        e(".borderWidth_add").on("click", function() {
            if (t < 100) {
                if (t > 70) {
                    e(".shape.squareDemo > .textArea").css("margin-top", n);
                    n++
                }
                t++;
                e(".borderWidth .input-append .displayValue").val(t);
                e(".shape.squareDemo").css("border-width", t + "px")
            }
        });
        e(".borderWidth_less").on("click", function() {
            if (t > 0) {
                if (t > 70) {
                    e(".shape.squareDemo > .textArea").css("margin-top", n);
                    n--
                }
                t--;
                e(".borderWidth .input-append .displayValue").val(t);
                e(".shape.squareDemo").css("border-width", t + "px")
            }
        });
        e(".borderWidth .input-append .displayValue").on("change", function() {
            t = e(this).val();
            e(".shape.squareDemo").css("border-width", t + "px")
        })
    }
    function g() {
        var t = Number(e(".save_Opacity1").val());
        e(".opacity_add").on("click", function() {
            if (t < 1) {
                t = t + .1;
                e(".opacity > .badge").html(t);
                e(".shape.squareDemo").css("opacity", t)
            }
            e(".save_Opacity1").val(t)
        });
        e(".opacity_less").on("click", function() {
            if (t > 0) {
                t = t - .1;
                e(".opacity > .badge").html(t);
                e(".shape.squareDemo").css("opacity", t)
            }
            e(".save_Opacity1").val(t)
        })
    }
    function y() {
        e(".bColor > .resetBtn").on("click", function() {
            e(".shape.squareDemo").css("background-color", "#B9B9B9");
            e(".bColor > .colorInput").val("#B9B9B9");
            e(".transparentContainer").removeClass("label-inverse")
        });
        e(".bColor > .setBtn").on("click", function() {
            e(".transparentContainer").removeClass("label-inverse");
            e(".shape.squareDemo").css("background-color", e(".bColor > .colorInput").val())
        })
    }
    function b() {
        e(".transparentContainer").on("click", function() {
            if (e(this).hasClass("label-inverse")) {
                e(this).removeClass("label-inverse");
                e(".shape.squareDemo").css("background-color", "#B9B9B9")
            } else {
                e(this).addClass("label-inverse");
                e(".shape.squareDemo").css("background-color", "transparent")
            }
        });
        e(".transparentLit").on("click", function() {
            if (e(this).hasClass("label-inverse")) {
                e(this).removeClass("label-inverse");
                e(".shape.squareLitDemo").css("background-color", "#000000")
            } else {
                e(this).addClass("label-inverse");
                e(".shape.squareLitDemo").css("background-color", "transparent")
            }
        })
    }
    function w() {
        e(".italicsContainer").on("click", function() {
            if (e(this).hasClass("label-inverse")) {
                e(this).removeClass("label-inverse");
                e(".shape.squareDemo > .textArea").css("font-style", "initial")
            } else {
                e(this).addClass("label-inverse");
                e(".shape.squareDemo > .textArea").css("font-style", "italic")
            }
        });
        e(".boldContainer").on("click", function() {
            if (e(this).hasClass("label-inverse")) {
                e(this).removeClass("label-inverse");
                e(".shape.squareDemo > .textArea").css("font-weight", "initial")
            } else {
                e(this).addClass("label-inverse");
                e(".shape.squareDemo > .textArea").css("font-weight", "bold")
            }
        });
        e(".boldLit").on("click", function() {
            if (e(this).hasClass("label-inverse")) {
                e(this).removeClass("label-inverse");
                e(".shape.squareLitDemo > .textAreaWrapper > .textArea").css("font-weight", "initial")
            } else {
                e(this).addClass("label-inverse");
                e(".shape.squareLitDemo > .textAreaWrapper > .textArea").css("font-weight", "bold")
            }
        });
        e(".italicsLit").on("click", function() {
            if (e(this).hasClass("label-inverse")) {
                e(this).removeClass("label-inverse");
                e(".shape.squareLitDemo > .textAreaWrapper > .textArea").css("font-style", "initial")
            } else {
                e(this).addClass("label-inverse");
                e(".shape.squareLitDemo > .textAreaWrapper > .textArea").css("font-style", "italic")
            }
        });
        e(".boldTitle").on("click", function() {
            if (e(this).hasClass("label-inverse")) {
                e(this).removeClass("label-inverse");
                e(".title").css("font-weight", "initial")
            } else {
                e(this).addClass("label-inverse");
                e(".title").css("font-weight", "bold")
            }
        });
        e(".italicsTitle").on("click", function() {
            if (e(this).hasClass("label-inverse")) {
                e(this).removeClass("label-inverse");
                e(".title").css("font-style", "initial")
            } else {
                e(this).addClass("label-inverse");
                e(".title").css("font-style", "italic")
            }
        });
        e(".fontSize1").on("change", function() {
            e(".shape.squareDemo > .textArea").css("font-size", e(this).val() + "px")
        });
        e(".fontSpacing1").on("change", function() {
            e(".shape.squareDemo > .textArea").css("line-height", e(this).val() + "px")
        });
        e(".fontSize2").on("change", function() {
            e(".shape.squareLitDemo > .textAreaWrapper > .textArea").css("font-size", e(this).val() + "px")
        });
        e(".fontSpacing2").on("change", function() {
            e(".shape.squareLitDemo > .textAreaWrapper > .textArea").css("line-height", e(this).val() + "px")
        });
        e(".fontSizeT").on("change", function() {
            e("h3.title").css("font-size", e(this).val() + "px")
        })
    }
    function E() {
        e(".borderColor > .resetBtn").on("click", function() {
            e(".shape.squareDemo").css("border-color", "#5bb75b");
            e(".borderColor > .borderInput").val("#5bb75b")
        });
        e(".borderColor > .setBtn").on("click", function() {
            e(".shape.squareDemo").css("border-color", e(".borderColor >.borderInput").val())
        })
    }
    function S() {
        e(".fontColor > .resetBtn").on("click", function() {
            e(".shape.squareDemo .textArea").css("color", "#000");
            e(".fontColor > .borderInput").val("#000")
        });
        e(".fontColor > .setBtn").on("click", function() {
            e(".shape.squareDemo > .textArea").css("color", e(".fontColor >.borderInput").val())
        })
    }
    function x() {
        e(".fontColor2 > .resetBtn").on("click", function() {
            e(".shape.squareLitDemo > .textAreaWrapper .textArea").css("color", "#fff");
            e(".fontColor2 > .borderInput").val("#ffffff")
        });
        e(".fontColor2 > .setBtn").on("click", function() {
            e(".shape.squareLitDemo > .textAreaWrapper .textArea").css("color", e(".fontColor2 >.borderInput").val())
        })
    }
    function T() {
        e(".litTitleColor > .resetBtn").on("click", function() {
            e(".shape.squareLitDemo > .title").css("color", "#fff");
            e(".litTitleColor > .borderInput").val("#ffffff")
        });
        e(".litTitleColor > .setBtn").on("click", function() {
            e(".shape.squareLitDemo h3.title").css("color", e(".litTitleColor >.borderInput").val())
        })
    }
    function N() {
        e(".litDividerColor > .resetBtn").on("click", function() {
            e(".divLit").css("border-color", "#fff");
            e(".litDividerColor > .borderInput").val("#ffffff")
        });
        e(".litDividerColor > .setBtn").on("click", function() {
            e(".divLit").css("border-color", e(".litDividerColor >.borderInput").val())
        })
    }
    function C() {
        e(".containerText > .textInput").on("change", function() {
            e(".shape.squareDemo > .textArea").height(e("#square_preview").height());
            e(".shape.squareDemo > .textArea").width(e("#square_preview").width() - 20);
            e(".shape.squareDemo > .textArea").html(e(this).val())
        })
    }
    function k() {
        e(".widthInput.displayValue.save_Width_1").on("change", function() {
            e(".shape.squareDemo").width(e(this).val());
            if (e(".squareDemo.shape.box").width() > 500) {
                e(".main_container").width(1208);
                e(".main_container").width(e(".main_container").width() + e(".squareDemo.shape.box").width() - 200 + "px")
            } else {
                e(".main_container").width(1108)
            }
            f()
        })
    }
    function L() {
        e(".heighInput.displayValue.save_Height_1").on("change", function() {
            e(".shape.squareDemo").height(e(this).val());
            if (e(".squareDemo.shape.box").height() > 750) {
                e(".historyContainer").css("margin-top", e(".squareDemo.shape.box").height() - 700 + "px")
            } else {
                e(".historyContainer").css("margin-top", "0")
            }
            f()
        })
    }
    function A() {
        var t = Number(e(".save_Opacity2").val());
        e(".opacity_addLit").on("click", function() {
            if (t < 1) {
                t = t + .1;
                e(".opacityLit > .badge").html(t);
                e(".shape.squareLitDemo").css("opacity", t);
                e(".save_Opacity2").val(t)
            }
        });
        e(".opacity_lessLit").on("click", function() {
            if (t > 0) {
                t = t - .1;
                e(".opacityLit > .badge").html(t);
                e(".shape.squareLitDemo").css("opacity", t);
                e(".save_Opacity2").val(t)
            }
        })
    }
    function O() {
        e(".bColorLit > .resetBtn").on("click", function() {
            e(".shape.squareLitDemo").css("background-color", "#5bb75b");
            e(".transparentLit").removeClass("label-inverse");
            e(".bColorLit .colorInput").val("#5bb75b")
        });
        e(".bColorLit > .setBtn").on("click", function() {
            e(".transparentLit").removeClass("label-inverse");
            e(".shape.squareLitDemo").css("background-color", e(".bColorLit > .colorInput").val())
        })
    }
    function M() {
        e(".containerLitText .textInput").on("change", function() {
            e(".shape.squareLitDemo > .textAreaWrapper .textArea").height(e("#square_preview").height());
            e(".shape.squareLitDemo > .textAreaWrapper .textArea").width(e("#square_preview").width() - 20);
            e(".shape.squareLitDemo > .textAreaWrapper .textArea").html(e(this).val())
        })
    }
    function _() {
        e(".entranceOpt").on("click", function() {
            switch (e(this)[0].value) {
                case"1":
                    e(".shape.squareLitDemo").css({top: height_val - title_val, "margin-left": "0", right: 0, transform: "rotate(0deg)",  "-ms-transform": "rotate(0deg)", "-webkit-transform": "rotate(0deg)", "-webkit-transform-origin": ""});
                    e(".shape.squareLitDemo .textAreaWrapper").css({"padding-right": "14px", transform: "rotate(0deg)", "-ms-transform": "rotate(0deg)", "-webkit-transform": "rotate(0deg)"});
                    e(".shape.squareLitDemo h3.title").css({transform: "rotate(0deg)", "-ms-transform": "rotate(0deg)", "-webkit-transform": "rotate(0deg)"});
                    e("#square_preview .squareLitDemo").attr("entrance", 1);
                    h();
                    break;
                case"2":
                    e(".shape.squareLitDemo").css({top: -(height_val - title_val), right: 0, transform: "rotate(-180deg)", "-ms-transform": "rotate(-180deg)", "-webkit-transform": "rotate(-180deg)", "margin-left": "0", "-webkit-transform-origin": ""});
                    e(".shape.squareLitDemo .textAreaWrapper").css({"margin-top": "32px", transform: "rotate(-180deg)", "-ms-transform": "rotate(-180deg)", "-webkit-transform": "rotate(-180deg)"});
                    e(".shape.squareLitDemo h3.title").css({transform: "rotate(180deg)", "-ms-transform": "rotate(180deg)", "-webkit-transform": "rotate(180deg)"});
                    e("#square_preview .squareLitDemo").attr("entrance", 2);
                    h();
                    break;
                case"3":
                    e(".shape.squareLitDemo").css({top: height_val - title_val, "margin-left": "0", right: 0, transform: "rotate(0deg)", " - ms - transform": "rotate(0deg)", " - webkit - transform": "rotate(0deg)", "-webkit-transform-origin": ""});
                    e(".shape.squareLitDemo .textAreaWrapper").css({"padding-right": "14px", transform: "rotate(0deg)", "-ms-transform": "rotate(0deg)", "-webkit-transform": "rotate(0deg)"});
                    e(".shape.squareLitDemo h3.title").css({transform: "rotate(0deg)", "-ms-transform": "rotate(0deg)", "-webkit-transform": "rotate(0deg)"});
                    e("#square_preview .squareLitDemo").attr("entrance", 3);
                    h();
                    break;
                case"4":
                    e(".shape.squareLitDemo").css({top: height_val - title_val, "margin-left": "0", right: 0, transform: "rotate(0deg)", " - ms - transform": "rotate(0deg)", " - webkit - transform": "rotate(0deg)", "-webkit-transform-origin": ""});
                    e(".shape.squareLitDemo .textAreaWrapper").css({"padding-right": "14px", transform: "rotate(0deg)", "-ms-transform": "rotate(0deg)", "-webkit-transform": "rotate(0deg)"});
                    e(".shape.squareLitDemo h3.title").css({transform: "rotate(0deg)", "-ms-transform": "rotate(0deg)", "-webkit-transform": "rotate(0deg)"});
                    e("#square_preview .squareLitDemo").attr("entrance", 4);
                    h();
                    break
            }
            f()
        })
    }
    function D() {
        e("#hEffect").change(function() {
            if (e("option:selected", this).attr("in") != "slide") {
                var t = e("input:radio[name=entrance]");
                t.filter("[value=1]").prop("checked", true);
                e(".shape.squareLitDemo").css({top: height_val - title_val, "margin-left": "0", right: 0, transform: "rotate(0deg)", " - ms - transform": "rotate(0deg)", " - webkit - transform": "rotate(0deg)", "-webkit-transform-origin": ""});
                e(".shape.squareLitDemo .textAreaWrapper").css({"padding-right": "14px", transform: "rotate(0deg)", "-ms-transform": "rotate(0deg)", "-webkit-transform": "rotate(0deg)"});
                e(".shape.squareLitDemo h3.title").css({transform: "rotate(0deg)", "-ms-transform": "rotate(0deg)", "-webkit-transform": "rotate(0deg)"});
                e("#square_preview .squareLitDemo").attr("entrance", 1);
                e(".entranceOpts > input").attr("disabled", "disabled");
                $LIT.removeClass("animated flipInX flipOutX flipInY flipOutY fadeIn fadeInUp fadeInDown fadeInLeft fadeInRight fadeOut fadeOutUp fadeOutDown fadeOutLeft fadeOutRight bounceIn bounceInDown bounceInUp bounceInLeft bounceInRight bounceOut bounceOutDown bounceOutUp bounceOutLeft bounceOutRight rotateIn rotateInDownLeft rotateInDownRight rotateInUpLeft rotateInUpRight rotateOut rotateOutDownLeft rotateOutDownRight rotateOutUpLeft rotateOutUpRight lightSpeedIn lightSpeedOut rollIn rollOut tada swing flash wobble pulse flipSide swrillIn hiLeft hiRight flipFlap outIn");
                $LIT.css({top: "0"});
                $LIT.attr("entrance", "effect");
                $LIT.attr("in", e("option:selected", this).attr("in"));
                $LIT.attr("out", e("option:selected", this).attr("out"));
                $LIT.addClass("animated " + e("option:selected", this).attr("out"))
            } else {
                e(".entranceOpts > input").removeAttr("disabled");
                $LIT.removeClass("animated flipInX flipOutX flipInY flipOutY fadeIn fadeInUp fadeInDown fadeInLeft fadeInRight fadeOut fadeOutUp fadeOutDown fadeOutLeft fadeOutRight bounceIn bounceInDown bounceInUp bounceInLeft bounceInRight bounceOut bounceOutDown bounceOutUp bounceOutLeft bounceOutRight rotateIn rotateInDownLeft rotateInDownRight rotateInUpLeft rotateInUpRight rotateOut rotateOutDownLeft rotateOutDownRight rotateOutUpLeft rotateOutUpRight lightSpeedIn lightSpeedOut rollIn rollOut tada swing flash wobble pulse flipSide swrillIn hiLeft hiRight flipFlap outIn");
                $LIT.attr("entrance", 1);
                e(".squareLitDemo.shape").mouseenter();
                e(".squareLitDemo.shape").mouseleave()
            }
        })
    }
    function P(e, t) {
        switch (e) {
            case"error":
                F(t);
                break;
            case"success":
                I(t);
                break;
            case"action":
                q(t);
                break
        }
    }
    function H() {
        e(".out_links .title_l").on("change", function() {
            e(".title_link_out").attr("href", e(this).val())
        })
    }
    function B() {
        e(".shadow_set .intensity .shadow_less_int").on("click", function() {
        });
        e(".toggle_shadow").on("click", function() {
            if (e(this).hasClass("on")) {
                e(".squareDemo.shape").css("box-shadow", "0px 0px 10px 0px");
                e(this).removeClass("on btn-inverse").addClass("off btn-danger").html("Remove Shadow")
            } else if (e(this).hasClass("off")) {
                e(".squareDemo.shape").css("box-shadow", "0px 0px 0px 0px");
                e(this).removeClass("off btn-danger").addClass("on btn-inverse").html("Add Shadow")
            }
        })
    }
    function j(t, n) {
        if (t == "overwrite") {
            var r = e("#hEffect option:selected").val();
            var i = "";
            var s = "";
            var o = "";
            var u = "";
            var a = "";
            var f = "";
            var l = "";
            var h = "";
            if (e(".transparentContainer").hasClass("label-inverse")) {
                i = "label-inverse"
            }
            if (e(".transparentLit").hasClass("label-inverse")) {
                s = "label-inverse"
            }
            if (e(".italicsContainer").hasClass("label-inverse")) {
                o = "label-inverse"
            }
            if (e(".italicsLit").hasClass("label-inverse")) {
                u = "label-inverse"
            }
            if (e(".italicsTitle").hasClass("label-inverse")) {
                a = "label-inverse"
            }
            if (e(".boldContainer").hasClass("label-inverse")) {
                f = "label-inverse"
            }
            if (e(".boldLit").hasClass("label-inverse")) {
                l = "label-inverse"
            }
            if (e(".boldTitle").hasClass("label-inverse")) {
                h = "label-inverse"
            }
            var p = {action: "OVERWRITE_BOX", id: n.id, data: {container: {c_rc_1: e(".save_RoundCorner_TL").val(), c_rc_2: e(".save_RoundCorner_TR").val(), c_rc_3: e(".save_RoundCorner_BL").val(), c_rc_4: e(".save_RoundCorner_BR").val(), c_bg_c: e(".save_BackgroundColor_1").val(), c_bd_c: e(".save_BorderColor_1").val(), c_ft_c: e(".save_FontColor_1").val(), c_brd: e(".save_BorderWidth_1").val(), c_opc: e(".save_Opacity1").val(), c_wid: e(".save_Width_1").val(), c_hei: e(".save_Height_1").val(), c_txt: e(".save_Text_1").val(), c_txt_l: "", c_txt_r: "", c_txt_t: "", c_txt_d: "", c_txt_fnt_sz: e(".fontSize1").val(), c_txt_spc: e(".fontSpacing1").val(), background_img: e(".save_Image_1").val(), save_name: e(".save_name").val(), html: e(".box_html").html()}, lit: {l_rc_1: e(".lit_prop.save_RoundCorner_TL").val(), l_rc_2: e(".lit_prop.save_RoundCorner_TR").val(), l_rc_3: e(".lit_prop.save_RoundCorner_BL").val(), l_rc_4: e(".lit_prop.save_RoundCorner_BR").val(), l_bg_c: e(".lit_prop.save_BackgroundColor_1").val(), l_ft_c: e(".lit_prop.save_FontColor_1").val(), l_tl_c: e(".lit_prop.save_TitleColor_1").val(), l_dv_c: e(".lit_prop.save_DividerColor_1").val(), l_dv: e("#litDivider").attr("checked"), l_entr: r, l_opc: e(".lit_prop.save_Opacity2").val(), l_titl: e(".lit_prop.title").val(), l_titl_u: "", l_titl_d: "", l_titl_l: "", l_titl_r: "", l_titl_fnt_sz: e(".lit_prop.fontSizeT").val(), l_txt: e(".save_Text_2").val(), l_txt_l: "", l_txt_r: "", l_txt_t: "", l_txt_d: "", l_txt_fnt_sz: e(".fontSize2").val(), l_txt_spc: e(".fontSpacing2").val(), l_titl_lnk: e(".title_l").val(), background_img_2: e(".save_Image_2").val(), trans_1: i, trans_2: s, italics_1: o, italics_2: u, italics_3: a, boald_1: f, boald_2: l, boald_3: h}}};
            e.post(ajaxurl, p, function(t) {
                if (t.Type == "success") {
                    c();
                    e(".centerOuterDiv").addClass("animated fadeIn");
                    setTimeout(function() {
                        e(".centerOuterDiv").removeClass("animated fadeIn")
                    }, 200)
                }
                if (t.Type == "action") {
                    P(t.Type, {head: t.Heading, body: t.Messege, action: {"default": t.Action.def, pertinent: t.Action.pertinent, pertinent_id: t.Action.pertinent_id}})
                } else {
                    P(t.Type, {head: t.Heading, body: t.Messege})
                }
            })
        } else if (t == "comp_delete") {
            var p = {action: "DELETE_BOX", id: n.id};
            e.post(ajaxurl, p, function() {
                P("success", {head: "Sucessfully Deleted", body: "The item has been sucessfully deleted"});
                c()
            })
        }
    }
    function F(t) {
        var n = t.head;
        var r = t.body;
        e(".modals_container").html('<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> <div class="modal-header label-important"> <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button> <h3 id="myModalLabel">' + n + '</h3> </div> <div class="modal-body"> <p>' + r + '</p> </div> <div class="modal-footer"> <button class="btn btn-inverse" data-dismiss="modal" aria-hidden="true">OK</button></div></div>');
        e("#myModal").modal("show");
        e("#myModal").addClass("in")
    }
    function I(t) {
        var n = t.head;
        var r = t.body;
        e(".modals_container").html('<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> <div class="modal-header label-success"> <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button> <h3 id="myModalLabel">' + n + '</h3> </div> <div class="modal-body"> <p>' + r + '</p> </div> <div class="modal-footer"> <button class="btn btn-inverse" data-dismiss="modal" aria-hidden="true">OK</button></div></div>');
        e("#myModal").modal("show");
        e("#myModal").addClass("in")
    }
    function q(t) {
        var n = t.head;
        var r = t.body;
        e(".modals_container").html('<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> <div class="modal-header label-warning"> <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button> <h3 id="myModalLabel">' + n + '</h3> </div> <div class="modal-body"> <p>' + r + '</p> </div> <div class="modal-footer"> <button class="btn btn-inverse" data-dismiss="modal" aria-hidden="true">Cancel</button><button data-dismiss="modal" aria-hidden="true" id="' + t.action.pertinent_id + '" class="btn btn-warning action_pertinent">' + t.action.pertinent + "</button></div></div>");
        e("#myModal").modal("show");
        e("#myModal").addClass("in");
        e(".action_pertinent").on("click", function() {
            j(t.action.call, this)
        })
    }
    l();
    d();
    v();
    m();
    g();
    y();
    b();
    E();
    w();
    S();
    x();
    T();
    A();
    O();
    C();
    k();
    M();
    L();
    _();
    h();
    c();
    f();
    a();
    u();
    s();
    D();
    N();
    H();
    $LIT = e(".squareLitDemo.shape");
    $BOX = e(".squareDemo.shape.box");
    var t;

    /** bimage pos **/
    e('.bImgaePosX').on('keyup', function(){
        e('#square-lit').css('background-position-x', e(this).val()+'px');
    });


    e('.bImgaePosY').on('keyup', function(){
        e('#square-lit').css('background-position-y', e(this).val()+'px');
    });


    e("#upload_image_button").click(function(n) {
        n.preventDefault();
        if (t) {
            t.open();
            return
        }
        t = wp.media.frames.file_frame = wp.media({title: "Choose Image", button: {text: "Choose Image"}, multiple: false});
        t.on("select", function() {
            attachment = t.state().get("selection").first().toJSON();
            e("#upload_image").val(attachment.url);
            e("#square_preview").css({background: "transparent url(" + e("#upload_image").val() + ") left top no-repeat", "background-size": "100%"})
        });
        t.open()
    });
    var n;
    e("#upload_image_button2").click(function(t) {
        t.preventDefault();
        if (n) {
            n.open();
            return
        }
        n = wp.media.frames.file_frame = wp.media({title: "Choose Image", button: {text: "Choose Image"}, multiple: false});
        n.on("select", function() {
            attachment = n.state().get("selection").first().toJSON();
            e("#upload_image2").val(attachment.url);
            e(".squareLitDemo.shape").css({background: "transparent url(" + e("#upload_image2").val() + ") left top no-repeat", "background-size": "100%"})
        });
        n.open()
    });
    e(".scratch").on("click", function() {
        location.reload()
    });
    e(".actionSave").on("click", function() {
        if (e(".save_name").val() == "" || e(".save_name").val().indexOf(" ") >= 0) {
            P("error", {head: "Invalid Name", body: "Please use a valid name for the item. No spaces allowed"})
        } else {
            var t = e("#hEffect option:selected").val();
            var n = "";
            var r = "";
            var i = "";
            var s = "";
            var o = "";
            var u = "";
            var a = "";
            var f = "";
            if (e(".transparentContainer").hasClass("label-inverse")) {
                n = "label-inverse"
            }
            if (e(".transparentLit").hasClass("label-inverse")) {
                r = "label-inverse"
            }
            if (e(".italicsContainer").hasClass("label-inverse")) {
                i = "label-inverse"
            }
            if (e(".italicsLit").hasClass("label-inverse")) {
                s = "label-inverse"
            }
            if (e(".italicsTitle").hasClass("label-inverse")) {
                o = "label-inverse"
            }
            if (e(".boldContainer").hasClass("label-inverse")) {
                u = "label-inverse"
            }
            if (e(".boldLit").hasClass("label-inverse")) {
                a = "label-inverse"
            }
            if (e(".boldTitle").hasClass("label-inverse")) {
                f = "label-inverse"
            }
            var l = {action: "SAVE", data: {container: {c_rc_1: e(".save_RoundCorner_TL").val(), c_rc_2: e(".save_RoundCorner_TR").val(), c_rc_3: e(".save_RoundCorner_BL").val(), c_rc_4: e(".save_RoundCorner_BR").val(), c_bg_c: e(".save_BackgroundColor_1").val(), c_bd_c: e(".save_BorderColor_1").val(), c_ft_c: e(".save_FontColor_1").val(), c_brd: e(".save_BorderWidth_1").val(), c_opc: e(".save_Opacity1").val(), c_wid: e(".save_Width_1").val(), c_hei: e(".save_Height_1").val(), c_txt: e(".save_Text_1").val(), c_txt_l: "", c_txt_r: "", c_txt_t: "", c_txt_d: "", c_txt_fnt_sz: e(".fontSize1").val(), c_txt_spc: e(".fontSpacing1").val(), background_img: e(".save_Image_1").val(), save_name: e(".save_name").val(), html: e(".box_html").html()}, lit: {l_rc_1: e(".lit_prop.save_RoundCorner_TL").val(), l_rc_2: e(".lit_prop.save_RoundCorner_TR").val(), l_rc_3: e(".lit_prop.save_RoundCorner_BL").val(), l_rc_4: e(".lit_prop.save_RoundCorner_BR").val(), l_bg_c: e(".lit_prop.save_BackgroundColor_1").val(), l_ft_c: e(".lit_prop.save_FontColor_1").val(), l_tl_c: e(".lit_prop.save_TitleColor_1").val(), l_dv_c: e(".lit_prop.save_DividerColor_1").val(), l_dv: e("#litDivider").attr("checked"), l_entr: t, l_opc: e(".lit_prop.save_Opacity2").val(), l_titl: e(".lit_prop.title").val(), l_titl_u: "", l_titl_d: "", l_titl_l: "", l_titl_r: "", l_titl_fnt_sz: e(".lit_prop.fontSizeT").val(), l_txt: e(".save_Text_2").val(), l_txt_l: "", l_txt_r: "", l_txt_t: "", l_txt_d: "", l_txt_fnt_sz: e(".fontSize2").val(), l_txt_spc: e(".fontSpacing2").val(), l_titl_lnk: e(".title_l").val(), background_img_2: e(".save_Image_2").val(), trans_1: n, trans_2: r, italics_1: i, italics_2: s, italics_3: o, boald_1: u, boald_2: a, boald_3: f}}};
            e.post(ajaxurl, l, function(t) {
                if (t.Type == "success") {
                    c();
                    e(".centerOuterDiv").addClass("animated fadeIn");
                    setTimeout(function() {
                        e(".centerOuterDiv").removeClass("animated fadeIn")
                    }, 200)
                }
                if (t.Type == "action") {
                    P(t.Type, {head: t.Heading, body: t.Messege, action: {"default": t.Action.def, pertinent: t.Action.pertinent, call: "overwrite", pertinent_id: t.Action.pertinent_id}})
                } else {
                    P(t.Type, {head: t.Heading, body: t.Messege})
                }
            })
        }
    });
    e(".help-me").on("click", function() {
        e("html, body").animate({scrollTop: 0}, "slow");
        e(".modals_container").html('<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: block;"> <div class="modal-header label-success"> <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button> <h3 id="myModalLabel">Help</h3> </div> <div class="modal-body"> <h4>How to use this plug-in:</h4> <div class="row-fluid"> <div class="span12"> <div class="span12"> <div class="span6"> <div class="arrow-left"></div> <p class="pull-left" style="text-align: left; width: 200px; margin-left: 10px;"> TOP-LEFT-CORNER: Menu - save a slide box or create new one from scratch </p> </div> <div class="span6"> <div class="arrow-right"></div> <p class="pull-right" style="text-align: right; width: 200px; margin-right: 10px;"> TOP-RIGHT-CORNER: Properties - All the properties you can set for the slide box </p> </div> </div> <br> <br> <br> <br> <br> <br> <br> <br> <div class="span12"> <div class="span6"> <div class="arrow-left"></div> <p class="pull-left" style="text-align: left; width: 200px; margin-left: 10px;"> MID-LEFT: Preview - Live preview of your slide box </p> </div> <div class="span6"> <p class="pull-right" style="text-align: right; width: 200px; margin-right: 10px;"> BOTTOM: History - All your saved slide boxes </p> <div style="clear: both"></div> <div class="arrow-down"></div> </div> </div> </div> </div> <div class="row-fluid"> <p>Once you have created and saved a slide box, copy the shortcode from the history table and paste it anywhere in your site (<i>page, post or anywhere you can render HTML</i>)</p> </div> </div> <div class="modal-footer"> <button class="btn" data-dismiss="modal">Close</button> </div></div>');
        e("#myModal").modal("show");
        e("#myModal").addClass("in")
    });
    e(".share-box").on("click", function() {
        if (e(".save_name").val() != "") {
            var t = {action: "SHARE_BOX", save_name: e(".save_name").val()};
            e.post(ajaxurl, t, function(e) {
                var t = "http://www.facebook.com/share.php?u=" + e.page_url.replace("localhost:8888", "wpvisualslideboxbuilder.com");
                window.location.href = t
            })
        } else {
            P("error", {head: "Invalid Name", body: "Must name your slide box before you share it!"})
        }
    });
    e(".why-share").on("click", function() {
        e(".modals_container").html('<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: block;"> <div class="modal-header label-success"> <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button> <h3 id="myModalLabel">Why Share?</h3> </div> <div class="modal-body"> <p>When you share your slide box you are creating an oportunity for others to visit your site; thus generating potential traffic to your site.</p> </div> <div class="modal-footer"> <button class="btn" data-dismiss="modal">Close</button> </div></div>');
        e("#myModal").modal("show");
        e("#myModal").addClass("in")
    })
});