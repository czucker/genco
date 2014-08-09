<?php return array(
  array(
    'type' => 'select',
    'name' => 'hb_contact_background',
    'label' => __('Background', 'hbthemes'),
    'description' => __('Choose between a map or an image background, located behind the contact form. Map location will be pulled from Highend Options > Map Settings', 'hbthemes'),
    'items' => array(
      array(
        'value' => 'map',
        'label' => __('Google Map', 'hbthemes'),
      ),
      array(
        'value' => 'image',
        'label' => __('Image', 'hbthemes'),
      ),
    ),
  ),
  array(
    'type' => 'upload',
    'name' => 'hb_contact_background_image',
    'label' => __('Upload Image', 'hbthemes'),
    'description' => __('Upload an image which will be shown behind the contact form. ', 'hbthemes'),
    'dependency' => array(
      'field' => 'hb_contact_background',
      'function' => 'hb_contact_image_background',
    ),
  ),

  array(
    'type' => 'textbox',
    'name' => 'hb_contact_title',
    'label' => __('Contact Box Title', 'hbthemes'),
    'description' => __('Enter the contact box title.', 'hbthemes'),
    'default' => 'Contact Information',
  ),

  array(
    'type' => 'textarea',
    'name' => 'hb_contact_content',
    'label' => __('Contact Box Content', 'hbthemes'),
    'description' => __('Enter the contact box content.', 'hbthemes'),
    'default' => '',
  ),

  array(
    'type'      => 'group',
    'repeating' => true,
    'name'      => 'hb_contact_details',
    'title'     => __('Contact Detail', 'hbthemes'),
    'description' => __('Enter you contact details, such as address, phone, email, website etc.', 'hbthemes'),
    'fields'    => array(
        array(
            'type'        => 'fontawesome',
            'name'        => 'hb_contact_detail_icon',
            'label'       => __('Icon', 'hbthemes'),
            'description' => __('Icon which describes your contact details.', 'hbthemes'),
        ),
        array(
          'type' => 'textbox',
          'name' => 'hb_contact_detail_content',
          'label' => __('Detail Content', 'hbthemes'),
          'description' => __('Enter the detail content. Example for address: 2046 Avenue 191', 'hbthemes'),
          'default' => '',
        ),
    ),
  ),

  array(
    'type' => 'textbox',
    'name' => 'hb_contact_form_title',
    'label' => __('Contact Form Title', 'hbthemes'),
    'description' => __('Enter the contact form title.', 'hbthemes'),
    'default' => 'Send us a message',
  ),

  array(
    'type' => 'toggle',
    'name' => 'hb_contact_box_enable_animation',
    'label' => __('Contact Box Animation', 'hbthemes'),
    'default' => false,
    'description' => __('Enable entrance animation of the contact form box.', 'hbthemes'),
  ),
  array(
    'type' => 'select',
    'name' => 'hb_contact_box_animation',
    'label' => __('Choose Animation', 'hbthemes'),
    'description' => __('Select an entrance animation for the contact form box.','hbthemes'),
    'items' => array(
      array(
        'value' => '',
        'label' => __('None', 'hbthemes'),
      ),
      array(
        'value' => 'bounce-up',
        'label' => __('Bounce Up', 'hbthemes'),
      ),
      array(
        'value' => 'bottom-to-top',
        'label' => __('Bottom To Top', 'hbthemes'),
      ),
      array(
        'value' => 'top-to-bottom',
        'label' => __('Top To Bottom', 'hbthemes'),
      ),
      array(
        'value' => 'left-to-right',
        'label' => __('Left To Right', 'hbthemes'),
      ),
      array(
        'value' => 'right-to-left',
        'label' => __('Right To Left', 'hbthemes'),
      ),
      array(
        'value' => 'scale-up',
        'label' => __('Scale Up', 'hbthemes'),
      ),
      array(
        'value' => 'fade-in',
        'label' => __('Fade In', 'hbthemes'),
      ),
    ),
    'dependency' => array(
      'field' => 'hb_contact_box_enable_animation',
      'function' => 'vp_dep_boolean',
    ),
  ),
); ?>