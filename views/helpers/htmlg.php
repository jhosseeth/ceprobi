<?php
/**
 * Custom Html Helper
 *
 * @author  Geneller Naranjo
 * @version 1.0.0
 */
App::import('Helper', 'Html');
class HtmlgHelper extends HtmlHelper {
 
    function field($label, $name, $inline = true, $params=array()) {
        $label = __($label,true);
        if(!$inline) echo "<div class='break-line'></div>";
        if(!empty($params)) {
            $name = $this->link($name, $params);
        }
        $p = <<<PFIELD
<p><strong>$label: </strong>$name</p>
PFIELD;
        return $p;
    }
}
?>