<?php ?>
<div class="use-bootstrap-here">
    <div class="mainWrapper">
        <div class="row">
            <h1 class='span10'><?php _e('WP VISUAL SLIDE-BOX BUILDER', 'wp-visual-slidebox-builder'); ?></h1>
            <a class='span3 pull-right feedback' target='blank' href="http://wpvisualslideboxbuilder.com.com/contact/"><img style='margin-top: -10px;' width='25' src='<?php echo plugins_url() ?>/wp-visual-slidebox-builder/img/thumsup.svg'/> We love your feedback </a>
            <a style='margin-top: -5px;' class='span3 pull-right feedback' target='blank' href="http://wordpress.org/support/view/plugin-reviews/wp-visual-slidebox-builder">***** Rate me!</a>
        </div>
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id))
                    return;
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=1424455527789829";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>
        <div class="container-fluid subWrapper">
            <div class="row-fluid main_container">
                <div class="span6 colorWrapper">
                    <div class="menu-main span12 pull-right">
                        <h5 class="round2 round"><?php _e('MENU', 'wp-visual-slidebox-builder'); ?></h5>
                        <div class="save_box">
                            <div class="span6 main_menu_wrapper">
                                <input placeholder="Name Your Creation" type="text" name="save_name" class="save_name span12"><br>
                                <button class = "btn btn-inverse actionSave"><?php _e('Save', 'wp-visual-slidebox-builder'); ?></button>
                                <button class = "btn btn-default scratch"><?php _e('New', 'wp-visual-slidebox-builder'); ?></button>
                                <button class = "btn btn-warning help-me"><?php _e('Help', 'wp-visual-slidebox-builder'); ?></button>
                            </div>
                            <div class="lins_menu_wrapper span6">
                                <a target='blank' href='http://wpvisualslideboxbuilder.com/forums/' class="links_menu label label-inverse label-normal" href="">
                                    <?php _e('Support', 'wp-visual-slidebox-builder'); ?>
                                </a>
                                <a target='blank' href="http://www.wpvisualslideboxbuilder.com/donate"  class="links_menu label label-inverse label-normal" href="">
                                    <?php _e('Donate', 'wp-visual-slidebox-builder'); ?>
                                </a>
                                <!--                                <a class="links_menu label label-info label-normal share-box">
                                                                    FB-Share
                                                                </a>
                                                                <div style="clear: both"></div>
                                                                <span class="small-txt why-share">
                                                                    Why share?
                                                                </span>-->
                                <div class="shareFB"></div>
                                <div style="clear: both;height: 15px;"></div>
                                <a class="webAddress" target="blank" href="http://www.wpvisualslideboxbuilder.com"><?php _e('www.wpvisualslideboxbuilder.com', 'wp-visual-slidebox-builder'); ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="centerOuterDiv">
                        <div class= "span12 box_html centerDiv">
                            <div id = "square_preview" class = "squareDemo shape box">
                                <span class = "textArea">
                                </span>
                                <div entrance="1" id = "square-lit" class = "squareLitDemo shape">
                                    <a class = "title_2 title_link_out"><h3 class="title">TITLE</h3></a>
                                    <hr class="divLit"/>
                                    <div class = "textAreaWrapper">
                                        <span class = "textArea">
                                             <?php _e('This is a fully customizable box builder plug-in. Display marketing info, images, text etc... as you wish', 'wp-visual-slidebox-builder'); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="span6 funbox sidebar" style="margin-left: 0">
                    <div class = "innerProp">
                        <div class="top">
                            <div class="top_side_1">
                                <div class = "row-fluid">
                                    <h5 class = "round"><?php _e('BOX', 'wp-visual-slidebox-builder'); ?></h5>
                                    <div class = "span6" style='margin: 0; margin-left: 10px;'>
                                        <div class = "section large span12 rCorners">
                                            <span class = "label2 span12 muted"><?php _e('Rounded Corners', 'wp-visual-slidebox-builder'); ?></span>

                                            <div class="row-fluid">
                                                <div class="input-append">
                                                    <input class="span3  displayValue multiple save_RoundCorner_TL" value="" type="text">
                                                    <span class="add-on"><?php _e('px', 'wp-visual-slidebox-builder'); ?></span>
                                                </div>
                                                <div class="input-append">
                                                    <input class="span3  displayValue multiple save_RoundCorner_TR" value="" type="text">
                                                    <span class="add-on"><?php _e('px', 'wp-visual-slidebox-builder'); ?></span>
                                                </div>
                                            </div>
                                            <div class="row-fluid">
                                                <div class="input-append">
                                                    <input class="span3  displayValue multiple save_RoundCorner_BR" value="" type="text">
                                                    <span class="add-on"><?php _e('px', 'wp-visual-slidebox-builder'); ?></span>
                                                </div>
                                                <div class="input-append">
                                                    <input class="span3  displayValue multiple save_RoundCorner_BL" value="" type="text">
                                                    <span class="add-on"><?php _e('px', 'wp-visual-slidebox-builder'); ?></span>
                                                </div>
                                            </div>

                                        </div>
                                        <div class = "section span12">
                                            <div class="pull-left span6 borderWidth">
                                                <span class = "label2 span12 muted"><?php _e('Border', 'wp-visual-slidebox-builder'); ?></span>
                                                <div class="input-append">
                                                    <input class="span3  displayValue save_BorderWidth_1" value="1" type="text">
                                                    <span class="add-on"><?php _e('px', 'wp-visual-slidebox-builder'); ?></span>
                                                </div>
                                            </div>
                                            <div class="pull-left span6">
                                                <span class = "label2 span12 muted" style="margin-bottom: 4px;">Opacity</span>
                                                <button class = "simple btn btn- btn-mini opacity_less">-</button>
                                                <button class = "simple btn btn- btn-mini opacity_add">+</button>
                                                <input type="text" class="displayNone save_Opacity1" value="1" style="display: none;">
                                            </div>
                                            <div class = "span12" style='margin-left: 10px;'>
                                                <div class = "section span6 containerWidth">
                                                    <span class = "label2 span12 muted"><?php _e('Width', 'wp-visual-slidebox-builder'); ?></span>
                                                    <div class="input-append containerWidth">
                                                        <input class = "span4 widthInput displayValue save_Width_1" value="200" placeholder = "ex. 200" type = "text">
                                                        <span class="add-on"><?php _e('px', 'wp-visual-slidebox-builder'); ?></span>
                                                    </div>
                                                </div>
                                                <div class = "section span6 containerHeight">
                                                    <span class = "label2 span12 muted"><?php _e('Height', 'wp-visual-slidebox-builder'); ?></span>
                                                    <div class="input-append containerHeight">
                                                        <input class = "span4 heighInput displayValue save_Height_1" value="200" placeholder = "ex. 200" type = "text">
                                                        <span class="add-on"><?php _e('px', 'wp-visual-slidebox-builder'); ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class = "span6" style='margin: 0'>
                                        <div class = "section span12 bColor">
                                            <span class = "label2 span12 muted"><?php _e('Background', 'wp-visual-slidebox-builder'); ?> <a class="transparent transparentContainer label "><?php _e('TRANSPARENT', 'wp-visual-slidebox-builder'); ?></a></span>
                                            <input class = "span3 colorInput save_BackgroundColor_1" value = "#B9B9B9" placeholder = "ex. #fff" type = "color">
                                            <button class = "setBtn btn btn- btn-mini"><?php _e('SET', 'wp-visual-slidebox-builder'); ?></button>
                                            <button class = "resetBtn btn btn-danger btn-mini"><?php _e('Reset', 'wp-visual-slidebox-builder'); ?></button>

                                        </div>
                                        <div class = "section span12 borderColor">
                                            <span class = "label2 span12 muted"><?php _e('Border', 'wp-visual-slidebox-builder'); ?></span>
                                            <input class = "span3 borderInput save_BorderColor_1" value = "#000" placeholder = "ex. #fff" type = "color">
                                            <button class = "setBtn btn btn- btn-mini"><?php _e('SER', 'wp-visual-slidebox-builder'); ?></button>
                                            <button class = "resetBtn btn btn-danger btn-mini"><?php _e('Reset', 'wp-visual-slidebox-builder'); ?></button>
                                        </div>
                                        <div class = "section span12 fontColor">
                                            <span class = "label2 span12 muted"><?php _e('Font', 'wp-visual-slidebox-builder'); ?>  <a class="transparent italicsContainer label "><?php _e('ITALICS', 'wp-visual-slidebox-builder'); ?></a> <a class="transparent boldContainer label "><?php _e('BOLD', 'wp-visual-slidebox-builder'); ?></a></span>
                                            <input class = "span3 borderInput save_FontColor_1" value = "#000" placeholder = "ex. #fff" type = "color">
                                            <button class = "setBtn btn btn- btn-mini"><?php _e('SET', 'wp-visual-slidebox-builder'); ?></button>
                                            <button class = "resetBtn btn btn-danger btn-mini"><?php _e('Reset', 'wp-visual-slidebox-builder'); ?></button>
                                        </div>
                                        <div class = "section span12 fontColor">
                                            <label for="upload_image" style="margin-top: 20px;">
                                                <input id="upload_image" type="text" size="36" class="hidden" name="ad_image" value="http://" />
                                                <input id="upload_image_button" class="btn" type="button" value="Background Image" style="width: 133px;font-size: 12px;min-height: 36px;" />

                                                <br />
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="top_side_1">
                                    <div class = "span8" style='margin-left: 10px'>
                                        <div class = "section large2 span12">
                                            <div class = "containerText">
                                                <span class = "label2 span12 muted"><?php _e('Text', 'wp-visual-slidebox-builder'); ?></span>
                                                <textarea style="height: 122px;" class = "span12 textInput save_Text_1" maxlength = ""><?php _e('This is a fully customizable box builder plug-in. Display marketing info, images, text etc... as you wish', 'wp-visual-slidebox-builder'); ?></textarea>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="span4" style="margin-left: 0">
                                        <div class="section">
                                            <div class="wrapper" style="margin-top: 55px;">
                                                <div class="row-fluid">
                                                    <button id="qPodU" class="span2 offset3 btn btn setBtn qPod ">/\</button>
                                                </div>
                                                <div class="row-fluid">
                                                    <button id="qPodL" class="span2 offset1 btn btn setBtn qPod "><</button>
                                                    <div class="span2" style="min-height: 10px!important;"></div>
                                                    <button style="margin-left: 3px" id="qPodR" class="span2 offset1 pull-left btn btn setBtn qPod ">></button>
                                                </div>
                                                <div class="row-fluid">
                                                    <button id="qPodD" class="span2 offset3 btn btn setBtn qPod ">\/</button>
                                                </div>
                                            </div>
                                            <div class="span6" style="margin-left: -6px;">
                                                <span class = "label2 span12 muted" style="margin-top: 6px;margin-bottom: -6px;margin-left: 11px!important;"><?php _e('Font Size', 'wp-visual-slidebox-builder'); ?></span>
                                                <div class="input-append" style="margin-left: 12px;margin-top: 7px;">
                                                    <input class = "span4 fontSize1 displayValue" value="14" placeholder = "ex. 10" type = "text">
                                                    <span class="add-on">px</span>
                                                </div>
                                            </div>

                                            <div class="span6" style="margin-left: 0">
                                                <span class = "label2 span12 muted" style="margin-top: 6px;margin-bottom: -6px;margin-left: 11px!important;"><?php _e('Spacing', 'wp-visual-slidebox-builder'); ?></span>
                                                <div class="input-append" style="margin-left: 12px;margin-top: 7px;">
                                                    <input class = "span4 fontSpacing1 displayValue" value="20" placeholder = "ex. 10" type = "text">
                                                    <span class="add-on">px</span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!--                            <div class="shadow_set">
                                                                <div class = "section span3 intensity" style="margin-left: 10px">
                                                                    <span class = "label2 span12 muted" style="margin-bottom: 4px;">Shadow Intensity</span>
                                                                    <button class = "simple btn btn- btn-mini shadow_less_int">-</button>
                                                                    <button class = "simple btn btn- btn-mini shadow_add_int">+</button>
                                                                </div>
                                                                <div class = "section span3 volume" style="margin-left: 10px">
                                                                    <span class = "label2 span12 muted" style="margin-bottom: 4px;">Shadow Volume</span>
                                                                    <button class = "simple btn btn- btn-mini shadow_less_vol">-</button>
                                                                    <button class = "simple btn btn- btn-mini shadow_add_vol">+</button>
                                                                </div>
                                                                <div class = "section span6" style="margin-top: 5px; margin-left: 0; margin-bottom: 7px;">
                                                                    <span class = "label2 span12 muted" style="margin-bottom: 4px;">Shadow Color</span>
                                                                    <input class = "span3 borderInput save_shadow_color" value = "#000" placeholder = "ex. #fff" type = "color">
                                                                    <button class = "setBtn btn btn- btn-mini">SET</button>
                                                                    <button class = "resetBtn btn btn-danger btn-mini">Reset</button>
                                                                    <button class = "toggle_shadow btn btn-inverse btn-mini on" style="margin-top: -11px;">Add Shadow</button>
                                                                </div>
                                                            </div>-->
                                <div style="clear: both"></div>
                                <h5 class = "round"><?php _e('LIT', 'wp-visual-slidebox-builder'); ?></h5>
                                <div class="span6 bottom_side">
                                    <div class = "section large span12 rCorners2">
                                        <span class = "label2 span12 muted"><?php _e('Rounded Corners', 'wp-visual-slidebox-builder'); ?></span>
                                        <div class="row-fluid">
                                            <div class="input-append">
                                                <input class="span3  displayValue save_RoundCorner_1 save_RoundCorner_TL lit_prop" value="" type="text">
                                                <span class="add-on"><?php _e('px', 'wp-visual-slidebox-builder'); ?></span>
                                            </div>
                                            <div class="input-append">
                                                <input class="span3  displayValue save_RoundCorner_1 save_RoundCorner_TR lit_prop" value="" type="text">
                                                <span class="add-on"><?php _e('px', 'wp-visual-slidebox-builder'); ?></span>
                                            </div>
                                        </div>
                                        <div class="row-fluid">
                                            <div class="input-append">
                                                <input class="span3  displayValue save_RoundCorner_1 save_RoundCorner_BR lit_prop" value="" type="text">
                                                <span class="add-on"><?php _e('px', 'wp-visual-slidebox-builder'); ?></span>
                                            </div>
                                            <div class="input-append">
                                                <input class="span3  displayValue save_RoundCorner_1 save_RoundCorner_BL lit_prop" value="" type="text">
                                                <span class="add-on"><?php _e('px', 'wp-visual-slidebox-builder'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="span6 bottom_side" style="margin-left: 0">
                                    <div class = "span12 section">
                                        <div class = "span12 bColorLit">
                                            <span class = "label2 span12 muted"><?php _e('Background', 'wp-visual-slidebox-builder'); ?> <a class="transparent transparentLit label"><?php _e('TRANSPARENT', 'wp-visual-slidebox-builder'); ?></a></span>
                                            <input class = "span3 colorInput save_BackgroundColor_1 lit_prop" value = "#000" placeholder = "ex. #fff" type = "color">
                                            <button class = "setBtn btn btn- btn-mini"><?php _e('SET', 'wp-visual-slidebox-builder'); ?></button>
                                            <button class = "resetBtn btn btn-danger btn-mini"><?php _e('Reset', 'wp-visual-slidebox-builder'); ?></button>
                                        </div>
                                        <div class = "span12 fontColor2">
                                            <span class = "label2 span12 muted"><?php _e('Font', 'wp-visual-slidebox-builder'); ?>  <a class="transparent italicsLit label "><?php _e('ITALICS', 'wp-visual-slidebox-builder'); ?></a> <a class="transparent boldLit label "><?php _e('BOLD', 'wp-visual-slidebox-builder'); ?></a></span>
                                            <input class = "span3 borderInput save_FontColor_1 lit_prop" value="#ffffff" placeholder = "ex. #fff" type="color">
                                            <button class = "setBtn btn btn- btn-mini"><?php _e('SET', 'wp-visual-slidebox-builder'); ?></button>
                                            <button class = "resetBtn btn btn-danger btn-mini"><?php _e('Reset', 'wp-visual-slidebox-builder'); ?></button>
                                        </div>
                                        <div class = "span12 litTitleColor">
                                            <span class = "label2 span12 muted"><?php _e('Title', 'wp-visual-slidebox-builder'); ?>  <a class="transparent italicsTitle label "><?php _e('ITALICS', 'wp-visual-slidebox-builder'); ?></a> <a class="transparent boldTitle label "><?php _e('BOLD', 'wp-visual-slidebox-builder'); ?></a></span>
                                            <input class = "span3 borderInput save_TitleColor_1 lit_prop" value="#ffffff" placeholder = "ex. #fff" type="color">
                                            <button class = "setBtn btn btn- btn-mini"><?php _e('SET', 'wp-visual-slidebox-builder'); ?></button>
                                            <button class = "resetBtn btn btn-danger btn-mini"><?php _e('Reset', 'wp-visual-slidebox-builder'); ?></button>
                                        </div>
                                        <div class = "span12 litDividerColor">
                                            <span class = "label2 span12 muted"><?php _e('Divider COlor', 'wp-visual-slidebox-builder'); ?></span>
                                            <input class = "span3 borderInput save_DividerColor_1 lit_prop" value="#ffffff" placeholder = "ex. #fff" type="color">
                                            <button class = "setBtn btn btn- btn-mini"><?php _e('SET', 'wp-visual-slidebox-builder'); ?></button>
                                            <button class = "resetBtn btn btn-danger btn-mini"><?php _e('Reset', 'wp-visual-slidebox-builder'); ?></button>
                                        </div>
                                        <div class = "span12">
                                            <label for="upload_image2">
                                                <input id="upload_image2" type="text" size="36" class="hidden" name="ad_image" value="http://" />
                                                <input style="width: 133px;font-size: 12px;min-height: 36px;" id="upload_image_button2" class="btn" type="button" value="Background Image" />

                                                <div class="input-append" style="width: 60px;margin-top: 7px;">
                                                    <input class = "span7 bImgaePosX" value="0" placeholder = "X" type = "text">
                                                    <span class="add-on">X</span>
                                                </div>
                                                <div class="input-append" style="width: 60px;margin-top: 7px;">
                                                    <input class = "span7 bImgaePosY" value="0" placeholder = "Y" type = "text">
                                                    <span class="add-on">Y</span>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="span12 section titleFont" style="margin-top: 10px">
                                            <span class = "label2 span12 muted" style="margin-top: 6px;margin-bottom: -6px;margin-left: 11px!important;"><?php _e('Title Font Size', 'wp-visual-slidebox-builder'); ?></span>
                                            <div class="input-append" style="margin-left: 12px;margin-top: 7px;">
                                                <input class = "span4 fontSizeT lit_prop displayValue" value="25" placeholder = "ex. 10" type = "text">
                                                <span class="add-on">px</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bottom bottom_side">
                            <div class = "row-fluid">
                                <div class = "span6" style='margin: 0; margin-left: 10px;'>
                                    <div class = "span12 effectLit animated">
                                        <span class = "label2 span12 muted"><?php _e('Entrance', 'wp-visual-slidebox-builder'); ?></span>
                                        <span class = "label2 span12 muted"><?php _e('Only Valid for slide effect', 'wp-visual-slidebox-builder'); ?></span>
                                        <div class = "entranceOpts"><input class = "entranceOpt" type = "radio" name = "entrance" checked value = "1"> <span class="label transparent"><?php _e('Bottom', 'wp-visual-slidebox-builder'); ?></span></div>
                                        <div class = "entranceOpts"><input class = "entranceOpt" type = "radio" name = "entrance" value = "2"> <span class="label transparent"><?php _e('Top', 'wp-visual-slidebox-builder'); ?></span></div><br>
                                        <div class = "entranceOpts"><input class = "entranceOpt" type = "radio" name = "entrance" value = "3"> <span class="label transparent"><?php _e('Left', 'wp-visual-slidebox-builder'); ?></span></div>
                                        <div class = "entranceOpts"><input class = "entranceOpt" type = "radio" name = "entrance" value = "4"> <span class="label transparent"><?php _e('Right', 'wp-visual-slidebox-builder'); ?></span></div><br>
                                    </div>
                                    <div class="section span12">
                                        <span class = "label2 span12 muted"><?php _e('Entrance Effect', 'wp-visual-slidebox-builder'); ?></span>
                                        <select name="hover_eff" id="hEffect">
                                            <optgroup label="Flipers">
                                                <option in="slide" value="1"><?php _e('Slide', 'wp-visual-slidebox-builder'); ?></option>
                                                <option in="flipInX" out="flipOutX" ><?php _e('Flip Horizontal', 'wp-visual-slidebox-builder'); ?></option>
                                                <option in="flipInY" out="flipOutY"><?php _e('Flip Vertical', 'wp-visual-slidebox-builder'); ?></option>
                                            </optgroup>
                                            <optgroup label="Faders">
                                                <option in="fadeIn" out="fadeOut" ><?php _e('Faded', 'wp-visual-slidebox-builder'); ?></option>
                                                <option in="fadeInUp" out="fadeOutDown"><?php _e('Fade In Up', 'wp-visual-slidebox-builder'); ?></option>
                                                <option in="fadeInDown" out="fadeOutUp"><?php _e('Fade In Down', 'wp-visual-slidebox-builder'); ?></option>
                                                <option in="fadeInLeft" out="fadeOutLeft"><?php _e('Fade In Left', 'wp-visual-slidebox-builder'); ?></option>
                                                <option in="fadeInRight" out="fadeOutRight"><?php _e('Fade In Right', 'wp-visual-slidebox-builder'); ?></option>
                                            </optgroup>
                                            <optgroup label="Bouncers">
                                                <option in="bounceIn" out="bounceOut"><?php _e('Bounce In', 'wp-visual-slidebox-builder'); ?></option>
                                                <option in="bounceInUp" out="bounceOutDown"><?php _e('Bounce In Up', 'wp-visual-slidebox-builder'); ?></option>
                                            </optgroup>
                                            <optgroup label="Rotators">
                                                <option in="rotateInDownRight" out="rotateOutUpRight" ><?php _e('Rotate In Down Right', 'wp-visual-slidebox-builder'); ?></option>
                                                <option in="rotateInDownLeft" out="rotateOutUpLeft"><?php _e('Rotate In Down Left', 'wp-visual-slidebox-builder'); ?></option>
                                                <option in="rotateIn" out="rotateOut"><?php _e('Spin', 'wp-visual-slidebox-builder'); ?></option>
                                            </optgroup>
                                            <optgroup label="Cool Effects">
                                                <option in="lightSpeedIn" out="lightSpeedOut"><?php _e('Fast Entrance', 'wp-visual-slidebox-builder'); ?></option>
                                                <option in="rollIn" out="rollOut"><?php _e('Roll In', 'wp-visual-slidebox-builder'); ?></option>
                                                <option in="tada" out="fadeOut"><?php _e('Tadaa', 'wp-visual-slidebox-builder'); ?></option>
                                                <option in="swing" out="fadeOut" ><?php _e('Swing', 'wp-visual-slidebox-builder'); ?></option>
                                                <option in="flash" out="fadeOut"><?php _e('Flashy', 'wp-visual-slidebox-builder'); ?></option>
                                                <option in="wobble" out="fadeOut"><?php _e('Wobble', 'wp-visual-slidebox-builder'); ?></option>
                                                <option in="pulse" out="fadeOut"><?php _e('Pulse', 'wp-visual-slidebox-builder'); ?></option>
                                                <option in="flipSide" out="fadeOut"><?php _e('Flip Side', 'wp-visual-slidebox-builder'); ?></option>
                                                <option in="swrillIn" out="swrillOut"><?php _e('Swrill In', 'wp-visual-slidebox-builder'); ?></option>
                                                <option in="hiLeft" out="fadeOut"><?php _e('hi! Left', 'wp-visual-slidebox-builder'); ?></option>
                                                <option in="hiRight" out="fadeOut"><?php _e('hi! Right', 'wp-visual-slidebox-builder'); ?></option>
                                                <option in="flipFlap" out="fadeOut"><?php _e('Flip Flap', 'wp-visual-slidebox-builder'); ?></option>
                                                <option in="outIn" out="inOut"><?php _e('Out In', 'wp-visual-slidebox-builder'); ?></option>
                                            </optgroup>
                                        </select>
                                    </div>
                                    <div class = "section span6 opacityLit" style="margin-left: 0">
                                        <span class = "label2 span12 muted" style="margin-bottom: 4px;"><?php _e('Opacity', 'wp-visual-slidebox-builder'); ?></span>
                                        <button class = "simple btn btn- btn-mini opacity_lessLit">-</button>
                                        <button class = "simple btn btn- btn-mini opacity_addLit">+</button>
                                        <input type="text" class="displayNone save_Opacity2 lit_prop" value="1" style="display: none;">
                                    </div>
                                    <div class = "section span6 dLine">
                                        <span class = "label2 span12 muted"><?php _e('Divider', 'wp-visual-slidebox-builder'); ?></span>
                                        <input id="litDivider" type="checkbox" checked>
                                    </div>

                                    <div class="span6 containerTitle" style="margin-left: 0">
                                        <span class = "label2 span12 muted">Title</span>
                                        <input type="text" value="TITLE" class="title span11 lit_prop" style="width: 135px!important;">
                                    </div>
                                    <div class="span5" style="margin-left: 15px">
                                        <div class="wrapper" style="margin-left: 20px;">
                                            <div class="row-fluid">
                                                <button id="qPodU" class="span2 offset3 btn btn setBtn qPod3 ">/\</button>
                                            </div>
                                            <div class="row-fluid">
                                                <button id="qPodL" class="span2 offset1 btn btn setBtn qPod3 "><</button>
                                                <div class="span2" style="min-height: 10px!important;"></div>
                                                <button style="margin-left: 3px" id="qPodR" class="span2 offset1 pull-left btn btn setBtn qPod3 ">></button>
                                            </div>
                                            <div class="row-fluid">
                                                <button id="qPodD" class="span2 offset3 btn btn setBtn qPod3 ">\/</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class = "span8">
                                    <div class="section large2 span12">
                                        <div class = "containerLitText">
                                            <span class = "label2 span12 muted"><?php _e('Text', 'wp-visual-slidebox-builder'); ?></span>
                                            <textarea style="height: 122px;" class = "span12 textInput save_Text_2" maxlength = "">
                                                <?php _e(' This is a fully customizable box builder plug-in. Display marketing info, images, text etc... as you wish', 'wp-visual-slidebox-builder'); ?>
                                               </textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="span4" style="margin-left: 0">
                                    <div class="section">
                                        <div class="wrapper" style="margin-top: 55px;">
                                            <div class="row-fluid">
                                                <button id="qPodU" class="span2 offset3 btn btn setBtn qPod2 ">/\</button>
                                            </div>
                                            <div class="row-fluid">
                                                <button id="qPodL" class="span2 offset1 btn btn setBtn qPod2 "><</button>
                                                <div class="span2" style="min-height: 10px!important;"></div>
                                                <button style="margin-left: 3px" id="qPodR" class="span2 offset1 pull-left btn btn setBtn qPod2 ">></button>
                                            </div>
                                            <div class="row-fluid">
                                                <button id="qPodD" class="span2 offset3 btn btn setBtn qPod2 ">\/</button>
                                            </div>
                                        </div>
                                        <div class="span6" style="margin-left: -6px">
                                            <span class = "label2 span12 muted" style="margin-top: 6px;margin-bottom: -6px;margin-left: 11px!important;"><?php _e('Font Size', 'wp-visual-slidebox-builder'); ?></span>
                                            <div class="input-append" style="margin-left: 12px;margin-top: 7px;">
                                                <input class = "span4 fontSize2 displayValue" value="14" placeholder = "ex. 10" type = "text">
                                                <span class="add-on"><?php _e('px', 'wp-visual-slidebox-builder'); ?></span>
                                            </div>
                                        </div>
                                        <div class="span6" style="margin-left: 0">
                                            <span class = "label2 span12 muted" style="margin-top: 6px;margin-bottom: -6px;margin-left: 11px!important;"><?php _e('Spacing', 'wp-visual-slidebox-builder'); ?></span>
                                            <div class="input-append" style="margin-left: 12px;margin-top: 7px;">
                                                <input class = "span4 fontSpacing2 displayValue" value="20" placeholder = "ex. 10" type = "text">
                                                <span class="add-on"><?php _e('px', 'wp-visual-slidebox-builder'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="span12">
                                    <div class="span10 out_links" style="margin-left: 10px;">
                                        <span class = "label2 span12 muted "><?php _e('Title Link', 'wp-visual-slidebox-builder'); ?></span>
                                        <input style="width: 100%" type="text" class="span12 title_l">
                                        <span class = "label2 span12 muted "><?php _e('Title Class', 'wp-visual-slidebox-builder'); ?></span>
                                        <input style="width: 100%" type="text" class="span12 title_c">
                                        <input id="link_new_window" type="checkbox" class="">
                                        <span class = "label2 span12 muted "><?php _e('Open New Window', 'wp-visual-slidebox-builder'); ?></span>
                                        <span class = "label2 span12 muted "></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid historyContainer">
            <div style="clear: both"></div>
            <hr>
            <h4 class=""><?php _e('History', 'wp-visual-slidebox-builder'); ?></h4>
            <div class="tab-pane" id="history">

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th><?php _e('Menu', 'wp-visual-slidebox-builder'); ?></th>
                            <th><?php _e('Title', 'wp-visual-slidebox-builder'); ?></th>
                            <th><?php _e('Created', 'wp-visual-slidebox-builder'); ?></th>
                            <th><?php _e('Preview', 'wp-visual-slidebox-builder'); ?></th>
                            <th><?php _e('Shortcode', 'wp-visual-slidebox-builder'); ?></th>
                        </tr>
                    </thead>
                    <tbody class="resulst_Boxes">

                    </tbody>
                </table>
            </div>
        </div>
        <div class="modals_container"></div>
    </div>
</div>
