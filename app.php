<?php

function array2html ($array) {
    $html = '<table>';
 
    if (is_array($array)) {
        foreach($array as $k => $v) {
            $html .= "<tr><td><b>$k</b></td><td>";
            if (is_array($v)) {
                $html .= array2html($v);
            } else {
                $html .= $v;
            }
            $html .= '</td></tr>';
        }
    }
    
    $html .= '</table>';
    return $html;
}

?>
