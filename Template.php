<?php

class Template
{

    private $dir_tmpl; // Директория с tpl-файлами
    private $data = array(); // Данные для вывода

    public function __construct($dir_tmpl)
    {
        $this->dir_tmpl = $dir_tmpl;
    }

    /* Метод для добавления новых значений в данные для вывода */

    public function set($name, $value)
    {
        $this->data[$name] = $value;
    }

    /* Метод для удаления значений из данных для вывода */

    public function delete($name)
    {
        unset($this->data[$name]);
    }

    /* обращение к несуществующему свойству */

    public function __get($name)
    {
        if (isset($this->data[$name]))
            return $this->data[$name];
        return "";
    }

    /* Вывод tpl-файла, в который подставляются все данные для вывода */

    public function display($template)
    {
        $template = $this->dir_tmpl . $template . ".tpl";
        ob_start();
        $a = $this->data['menu']['avatar'];
        include ($template);
    }

}
