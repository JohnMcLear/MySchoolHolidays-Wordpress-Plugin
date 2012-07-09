<?php

$stringformat = '<li class="ds-result-item active" id="ds-result-item-9"><div><span><img class="searchFlag" src="/images/flags/gb.png">Bath and <em>Nort</em>h East Somerset</span></div></li>';

if (strlen($_GET['text']) >= 4) {
  $data = file_get_contents('http://myschoolholidays.com/api/searchForSchoolOrDistrict?q='.urlencode($_GET['text']));
  $data = json_decode($data);
  $i = 0;
  if (count($data->results) > 0) {
    foreach($data->results as $key => $r){
      $i++;
      $r->name = preg_replace("/".preg_quote($_GET['text'], "/")."/i", "<em>$0</em>", $r->name);
      echo '<li class="ds-result-item" id="ds-result-item-'.$key.'" data-url="'.$r->id.'" data-url2="'.$r->fullUrl.'" data-name="'.strip_tags($r->name).'"><div><span><img class="searchFlag" src="http://myschoolholidays.com/images/flags/'.$r->countryCode.'.png">'.$r->name.'</span></div></li>';
      if ($i >= 10) break;
    }
  }
}

