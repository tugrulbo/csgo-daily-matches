<?php
include('simple_html_dom.php');

$url ="https://liquipedia.net/counterstrike/Liquipedia:Matches";

$html = file_get_html($url);
$matches = array();
$team_left_data = array();
$team_right_data = array();
$team_left = array();
$team_right = array();
$date = array();
$old_date = array();
$old_vs = array();
$vs = array();

//siteden bütün maç verilerini çeker
foreach($html->find('div[@id="mw-content-text"]') as $div){


    foreach($div->find('td[class=team-left]') as $left){
        $team_left_data['team_left_name'] = $left->find('.team-template-text',0)->plaintext;
        $team_left_data['team_left_logo'] = $left->find('img',0)->src;
        $team_left[]=$team_left_data;
       
    }

    foreach($div->find('tbody') as $vs1){
        $old_vs['vs'] = $vs1->find('.versus',0)->plaintext;
        $vs[]=$old_vs;
    }

    foreach($div->find('tbody') as $date1){
        $old_date['date'] = $date1->find('.timer-object',0)->plaintext;
        $date[] = $old_date;
    }

    foreach($div->find('td[class=team-right]') as $right){
        $team_right_data['team_right_name'] = $right->find('.team-template-text',0)->plaintext;
        $team_right_data['team_right_logo'] = $right->find('img',0)->src;
        $team_right[]=$team_right_data;
    }
}


$count = count($team_left);


$i =0;
while($i<$count){
    
    $matches[] = array(
        'team_left' => $team_left[$i]["team_left_name"],
        'team_left_logo' => $team_left[$i]["team_left_logo"],
        'vs' => $vs[$i]['vs'],
        'date' => $date[$i]["date"],
        'team_right' => $team_right[$i]["team_right_name"],
        'team_right_logo' => $team_right[$i]["team_right_logo"]
    );

    $i +=1;
}

$json = json_encode($matches);
echo $json;