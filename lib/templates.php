<?php
require_once('smarty_template.php');

class Templates {

    public static function get($template_name) {
        return new SmartyTemplate($template_name);
    }

    public static function evaluate($template_name, $data = []) {
        $template = self::get($template_name);
        $template->assignAll($data);
        return $template->evaluate();
    }

    public static function display($template_name, $data = []) {
        print self::evaluate($template_name, $data);
    }
}