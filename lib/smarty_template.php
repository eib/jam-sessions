<?php
require_once('smarty/smarty/libs/Smarty.class.php');
require_once('server.php');
#require_once('smarty_cache_resource_pdo.php');
#require_once('db.php');

class SmartyTemplate {
    public $template_name;
    public $smarty;

    public function __construct($template_name) {
        $this->template_name = $template_name;
        $this->smarty = self::createSmarty();
    }

    public function assignAll($data = NULL) {
        if ($data) {
            foreach ($data as $key => $value) {
                $this->smarty->assign($key, $value);
            }
        }
        return $this;
    }

    public function evaluate($data = NULL) {
        $this->assignAll($data);
        ob_start();
        $this->smarty->display($this->template_name);
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

    public static function createSmarty() {
        $root_dir = Server::getRootDir();
        $smarty_dir = $root_dir . DIRECTORY_SEPARATOR . 'smarty';

        $smarty = new Smarty();
        $smarty->setTemplateDir("$smarty_dir/templates");
        $smarty->setConfigDir("$smarty_dir/config");

        mkdirp("$smarty_dir/compiled_templates");
        $smarty->setCompileDir("$smarty_dir/compiled_templates");

        # Caching
        mkdirp("$smarty_dir/cache");
        $smarty->setCacheDir("$smarty_dir/cache");
        #$smarty->setCachingType('pdo');
        #$db = DB::connect();
        #$smarty->registerCacheResource('pdo', new Smarty_CacheResource_Pdo($db, 'smarty_cache'));

        return $smarty;
    }
}
