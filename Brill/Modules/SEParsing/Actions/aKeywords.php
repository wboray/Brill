<?php
/**
 * Description of Keywords
 *
 * @author almaz
 */
require_once MODULES_PATH . 'SEParsing/Views/vKeywords.php';
require_once MODULES_PATH . 'SEParsing/DB/Stmt.php';

class aKeywords extends Action {
    protected $defaultAct = 'view';

    public function act_Add($context) {}

    public function act_View($context) {
       // $nav = $request->getNav();

       // обработка данных
        // выбор нужного вью
        // и получение небходимыъ данных для него (аторизация и прочее)

        $context->set('useParentTpl', true);

        $request = RegistryRequest::instance();
        $get = $request->is ('GET') ? $request->get('GET') : array();
        #if (isset($get['id']) && (string)($keyword_id = (int) $get['id']) == (string) $get['id']) {
        if (isset($get['id'])) {
            $sql = Stmt::getSql('URLS_AND_POS_FOR_KEYWORD', array('keyword_id' => $get['id']));
            $tbl = new oTable(DBExt::selectToTable($sql. ' order by pos_dot DESC'));
            $context->set('table', $tbl);
            $tbl->viewColumns('name', 'pos', 'url', 'pos_dot');
            
            //$tbl->sort('url');
            //$tbl->jsonBuild();

            $tbl->setNamesColumns(array(
                'name'=>'Сайт',
                'pos' =>'Позиция',
                'pos_dot' => 'Позиция с точкой',
                'url' => 'Адрес'));
            $tbl->addMap('url', 'urldecode');
            $context->set('h1', 'Статистика по ключевому слову');
            $context->set('title', 'Ключевики');
        } else {
            $sql = Stmt::getSql('ALL_KEYWORDS');
            $tbl = new oTable(DBExt::selectToTable($sql. ' order by name ASC'));
            $tbl->viewColumns('name', 'yandex', 'set', 'thematic');
            $tbl->addRulesView('thematic', '<a href="newindex.php?view=keywords&thematic_id=#t_id#">#thematic#</a>');
            
            $context->set('h1', 'Все ключевые слова');
            $context->set('title', 'Ключевики');

            $tbl->setNamesColumns(array(
                'name'=>'Ключевое слово',
                'yandex'=>'Яндекс',
                'set'=>'Сет слов',
                'thematic'=>'Тематика',
            ));
            $tbl->addRulesView('name', '<a href="newindex.php?view=sites&keyword_id=#id#">#name#</a>');
            $tbl->addRulesView('set', '<a href="newindex.php?view=sites&set_id=#s_id#">#set#</a>');
        }

        $context->set('table', $tbl);
        $context->set('tpl', 'keywords_list.php');

    }



    /*
     * Отдаем родителю нашу вьюшку
     */
    protected function initView() {

        return new vKeywords(RegistryContext::instance());
     }

}
