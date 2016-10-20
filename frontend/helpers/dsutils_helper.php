<?php

    function generateLogInfo(){
        $bt = debug_backtrace();
        $caller = array_shift($bt);
        return $caller;
    }



    /* Create urls from strings */
    function slugify( $text )
    {
      // replace non letter or digits by -
      $text = preg_replace('~[^\pL\d]+~u', '-', $text);

      // transliterate
      $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

      // remove unwanted characters
      $text = preg_replace('~[^-\w]+~', '', $text);

      // trim
      $text = trim($text, '-');

      // remove duplicate -
      $text = preg_replace('~-+~', '-', $text);

      // lowercase
      $text = strtolower($text);

      if (empty($text))
      {
        return 'n-a';
      }

      return $text;
    }


    /* Generate tour url */
    function tourLink( $name, $id ){

        $link = slugify( $name );
        $link .= '-t' . $id;

        return site_url( 'tours/' . $link);

    }


    /* Get tour ID from url */
    function tourFromURL( $url ){

        if( !is_numeric($url) ){
            $end = end((explode('-t', rtrim($url, '/'))));
            return $end;
        }else{
            return $url;
        }

    }


    /* Create private tour url */
    function privateTourUrl( $tour ){

        $link = tourLink( $tour->name, $tour->ID );
        $hashtoken = md5( $tour->ID . $tour->city_ID . 'priv' . $tour->profile_ID );

        $privateUrl = $link . '?tk=' . $hashtoken;

        return $privateUrl;
    }


    /* Validate token */
    function validateToken( $tour, $token ){
        $hashtoken = md5( $tour->ID . $tour->city_ID . 'priv' . $tour->profile_ID );

        if( $hashtoken == $token )
            return true;
        else
            return false;
    }


    /* Date to readable format */
    function easyDateString( $inputdate ){
        $test = explode('-', $inputdate);
        $month = $test[0];
        $day = $test[1];
        $year = $test[2];
        $date = new DateTime($year.'-'.$month.'-'.$day);
        return $date->format('F j, Y');
    }

    /* Date to readable format from datetime */
    function easyDatetime( $inputdate ){;
        $date = new DateTime( $inputdate );
        return $date->format('F j, Y');
    }




?>
