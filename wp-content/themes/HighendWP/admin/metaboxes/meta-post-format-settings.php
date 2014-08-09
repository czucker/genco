<?php
return array(
  array (
    'type'      => 'group',
      'repeating' => false,
      'length'    => 1,
      'name'      => 'hb_video_post_format',
      'title'     => __('Video Post Format', 'hbthemes'),
      'fields'    => array(
        array(
            'type' => 'textarea',
            'name' => 'hb_video_format_link',
            'label' => __('Video Link', 'hbthemes'),
            'default' => '',
            'description' => __('Enter a URL of your video here.','hbthemes'),
        ),
      ),       
  ),
  array (
    'type'      => 'group',
      'repeating' => false,
      'length'    => 1,
      'name'      => 'hb_audio_post_format',
      'title'     => __('Audio Post Format', 'hbthemes'),
      'fields'    => array(
        array(
            'type' => 'textarea',
            'name' => 'hb_audio_soundcloud_link',
            'label' => __('SoundCloud Link.', 'hbthemes'),
            'default' => '',
        ),
        array(
            'type' => 'upload',
            'name' => 'hb_audio_ogg_link',
            'label' => __('OGG Audio Link', 'hbthemes'),
            'default' => '',
        ),
        array(
            'type' => 'upload',
            'name' => 'hb_audio_mp3_link',
            'label' => __('MP3 Audio Link', 'hbthemes'),
            'default' => '',
        ),
      ),       
   ),
  array (
    'type'      => 'group',
      'repeating' => false,
      'length'    => 1,
      'name'      => 'hb_link_post_format',
      'title'     => __('Link Post Format', 'hbthemes'),
      'fields'    => array(
        array(
            'type' => 'textarea',
            'name' => 'hb_link_format_link',
            'label' => __('Link this post to: ', 'hbthemes'),
            'default' => '',
        ),
      ),       
   ),
  array (
    'type'      => 'group',
      'repeating' => false,
      'length'    => 1,
      'name'      => 'hb_quote_post_format',
      'title'     => __('Quote Post Format', 'hbthemes'),
      'fields'    => array(
        array(
            'type' => 'textarea',
            'name' => 'hb_quote_format_author',
            'label' => __('Author of this post ', 'hbthemes'),
            'default' => '',
        ),
      ),       
   ),
);