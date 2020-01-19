<?php
/**
* Организация постраничной навигации (пагинации)
*/
abstract class Pager
{
    protected $view;
    protected $parameters;
    protected $counter_param;
    protected $links_count;
    protected $items_per_page;
    
    public function __construct(
        View $view,
        $items_per_page = 10,
        $links_count = 3,
        $get_params = null,
        $counter_param = 'page')
    {
        $this->view = $view;
        $this->parameters = $get_params;
        $this->counter_param = $counter_param;
        $this->items_per_page = $items_per_page;
        $this->links_count = $links_count;
    }
    
    abstract public function getItemsCount();
    
    abstract public function getItems();
    
    public function getVisibleLinkCount()
    {
        return $this->links_count;
    }
    
    public function getParameters()
    {
        return $this->parameters;
    }
    
    public function getCounterParam()
    {
        return $this->counter_param;
    }
    
    public function getItemsPerPage()
    {
        return $this->items_per_page;
    }
    
    public function getCurrentPagePath()
    {
        return $_SERVER['PHP_SELF'];
    }
    
    public function getCurrentPage()
    {
        if(isset($_GET[$this->getCounterParam()])) {
            return intval($_GET[$this->getCounterParam()]);
        } else {
            return 1;
        }
    }
    
    public function getPagesCount()
    {
        // Количество позиций
        $total = $this->getItemsCount();
        // Вычисляем количество страниц
        $result = ceil($total / $this->getItemsPerPage());
        return $result;
    }
    
    public function render()
    {
        return $this->view->render($this);
    }
    
    public function __toString()
    {
        return $this->render();
    }
}

abstract class View
{
    protected $pager;
    
    public function link($title, $current_page = 1)
    {
        return "<li class='page-item'> <a class='page-link ajax' href='{$this->pager->getCurrentPagePath()}?".
        "{$this->pager->getCounterParam()}={$current_page}".
        "{$this->pager->getParameters()}'>{$title}</a> </li>";
    }
    
    abstract public function render(Pager $pager);
}

class PagesList extends View
{
    public function render(Pager $pager) 
    {
        // Объект постраничной навигации
        $this->pager = $pager;
        // Строка для возвращаемого результата
        $return_page = '<nav class="mt-2"> <ul class="pagination pagination-sm justify-content-center">';
        // Текущий номер страницы
        $current_page = $this->pager->getCurrentPage();
        // Общее количество страниц
        $total_pages = $this->pager->getPagesCount();
        // Ссылка на первую страницу
        if($current_page != 1) {
            $return_page .= $this->link(/*'&laquo;'*/1, 1)." ";
        }
        // Выводим ссылку "Назад", если это не первая страница
        if($current_page != 1) {
            $return_page .= $this->link('&lsaquo;', $current_page - 1)." ";
        }
        // Выводим предыдущие элементы
        if($current_page > $this->pager->getVisibleLinkCount() + 1) {
            $init = $current_page - $this->pager->getVisibleLinkCount();
            for($i = $init; $i < $current_page; $i++) {
                $return_page .= $this->link($i, $i)." ";
            }
        } else {
            for($i = 1; $i < $current_page; $i++) {
                $return_page .= $this->link($i, $i)." ";
            }
        }
        // Выводим текущий элемент
        $return_page .= "<li class='page-item active'> <a class='page-link ajax'>".$i."</a> </li>";
        // Выводим следующие элементы
        if($current_page + $this->pager->getVisibleLinkCount() < $total_pages)
        {
            $cond = $current_page + $this->pager->getVisibleLinkCount();
            for($i = $current_page + 1; $i <= $cond; $i++) {
                $return_page .= $this->link($i, $i)." ";
            }
        } else {
            for($i = $current_page + 1; $i <= $total_pages; $i++) {
                $return_page .= $this->link($i, $i)." ";
            }
        }
        // Выводим ссылку вперед, если это не последняя страница
        if($current_page != $total_pages) {
            $return_page .= " ".$this->link('&rsaquo;', $current_page + 1);
        }
        // Ссылка на последнюю страницу
        if($current_page != $total_pages) {
            $return_page .= " ".$this->link(/*'&raquo;'*/$total_pages, $total_pages);
        }
        $return_page.="</ul></nav>";
        return $return_page;
    }
}

class PdoPager extends Pager
{
    protected $pdo;
    protected $tablename;
    protected $where;
    protected $params;
    protected $order;
    
    public function __construct(
        View $view,
        $pdo,
        $tablename,
        $where = "",
        $params = [],
        $order = "",
        $items_per_page = 10,
        $links_count = 3,
        $get_params = null,
        $counter_param = 'page')
    {
    $this->pdo = $pdo;
    $this->tablename = $tablename;
    $this->where = $where;
    $this->params = $params;
    $this->order = $order;
    // Инициализируем переменные через конструктор базового класса
    parent::__construct(
        $view,
        $items_per_page,
        $links_count,
        $get_params,
        $counter_param);
    }
    
    public function getItemsCount()
    {
        // Формируем запрос на получение
        // общего количества записей в таблице
        $query = "SELECT COUNT(*) AS total
        FROM {$this->tablename}
        {$this->where}";
        $tot = $this->pdo->prepare($query);
        $tot->execute($this->params);
        return $tot->fetch()['total'];
    }
    
    public function getItems()
    {
        // Текущая страница
        $current_page = $this->getCurrentPage();
        // Общее количество страниц
        $total_pages = $this->getPagesCount();
        // Проверяем, попадает ли запрашиваемый номер
        // страницы в интервал от минимального до максимального
        if($current_page <= 0 || $current_page > $total_pages) {
            return 0;
        }
        // Извлекаем позиции текущей страницы
        $arr = [];
        // Номер, начиная с которого следует
        // выбирать строки файла
        $first = ($current_page - 1) * $this->getItemsPerPage();
        // Извлекаем позиции для текущей страницы
        $query = "SELECT * FROM {$this->tablename}
        {$this->where}
        {$this->order}
        LIMIT $first, {$this->getItemsPerPage()}";
        $tbl = $this->pdo->prepare($query);
        $tbl->execute($this->params);
        return $results = $tbl->fetchAll();
    }
}
?>