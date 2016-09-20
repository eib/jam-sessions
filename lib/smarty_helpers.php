<?php

function smarty_function_let($params, &$smarty) {
    foreach ($params as $key => $value) {
        $smarty->assign($key, $value);
    }
}
