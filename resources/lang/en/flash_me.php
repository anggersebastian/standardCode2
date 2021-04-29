<?php
/**
 * @link https://www.onphpid.com/membuat-alert-message-yang-lebih-menarik-di-laravel.html
 */
return [ 
'success' => [ 
    'type' => 'success', 
    'title' => 'Hi...',
    'message' => 'FlashMe is Ready!',
    'options' => [
      'position' => 'topRight', // this is an example option, you can add another option
      'transitionIn' => 'bounceInLeft', 
      'transitionOut' => 'fadeOut'
    ],
 ], 
 'info' => [ 
  'type' => 'info', 
  'title' => 'Hi...', 
  'message' => 'FlashMe is Ready!', 
  'options' => [ 
     'position' => 'topRight', // this is an example option, you can add another option 
     'transitionIn' => 'bounceInLeft', 
     'transitionOut' => 'fadeOut'
   ]
  ], 
  'warning' => [
      'type' => 'warning', 
      'title' => 'Hi...', 
      'message' => 'FlashMe is Ready!', 
      'options' => [ 
          'position' => 'topRight', // this is an example option, you can add another option 
          'transitionIn' => 'bounceInLeft', 
          'transitionOut' => 'fadeOut'
       ]
   ], 
   'error' => [ 
      'type' => 'error', 
      'title' => 'Hi...',
      'message' => 'FlashMe is Ready!', 
      'options' => [
          'position' => 'topRight', // this is an example option, you can add another option 
          'transitionIn' => 'bounceInLeft',
          'transitionOut' => 'fadeOut'
      ]
   ]
];