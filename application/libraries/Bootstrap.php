<?php
defined('BASEPATH') OR exit('No direct script access allowed');

  class Bootstrap
  {

    /**
     *  Opens an HTML div tag with bootstrap class
     *
     *  @param   $class   string/array    loads the tag with the class specified
     */
    public function class_tag($class)
    {
      echo '<div class="';
      if(is_array($class))
      {
        foreach($class as $cl)
        {
          echo $cl." ";
        }
      }
      else {
        echo $class;
      }
      echo '">';
    }

    public function close_tag()
    {
      echo '</div>';
    }

  }
