<?php

namespace View;

class Template
{
    private $_tmpltFile = '';

    public function __construct($tmpltFile)
    {
        $this->_tmpltFile = $tmpltFile;
    }

    public function renderTemplate(array $data)
    {
        extract($data);

        ob_start();

        require_once ABS_PATH . 'template/header.phtml';
        require_once ABS_PATH . 'template/navbar.phtml';
        require_once ABS_PATH . 'template/' . $this->_tmpltFile;
        $htmlResponse = ob_get_contents();
        require_once ABS_PATH . 'template/footer.phtml';

        ob_end_clean();

        return $htmlResponse;
    }
}
