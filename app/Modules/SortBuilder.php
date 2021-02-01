<?

namespace App\Modules;


class SortBuilder {
    protected $html;
    protected $params;
    protected $uri;
    protected $wrapperClass = 'select-wrapper';
    protected $formClass = 'select-form';
    protected $selectClass = 'select-select';
    protected $confirmClass = 'select-confirm';
    protected $confirmButtonName = 'Accept';
    protected $method = 'GET';
    protected $availableFields = [];

    public function __construct($uri, $params = [], $availableFields = []) {
        $this->setUri($uri);
        $this->setParams($params);
        $this->setAvailableFields($availableFields);
    }

    public function generate() {
        $fullHTMLString = '';
        $openWrapperTag = '<div class="'. $this->wrapperClass . '">';
        $openFormTag = '<form action="'
            . $this->getUri() . '" method="' . $this->getMethod() .'" class="' . $this->formClass . '">';
        $closeFormTag = '</form>';
        $closeWrapperTag = '</div>';


        foreach ($this->getParams() as $sortField => $param) {
            if (!in_array($sortField, $this->getAvailableFields()) ||empty($param[Sorter::VALUES])) continue;
            $headerFormTag = '<h2>Sort by: ' . $param[Sorter::TITLE] . '</h2>';
            $optionsString = '';
            $select = '<select name="' . $param[Sorter::NAME] . '">';
            $selectClose = '</select>';

            foreach ($param[Sorter::VALUES] as $value) {
                $optionsString .= '<option value="' . $value .'">' . $value .'</option>';
            }
            $fullSelectString = $headerFormTag . $select . $optionsString . $selectClose;
        }

        $fullHTMLString .= $openWrapperTag . $openFormTag;
        $fullHTMLString .= $fullSelectString . $this->getSorterSelect() . $this->getConfirmBtn()
            . $closeFormTag . $closeWrapperTag;

        $this->setHtml($fullHTMLString);
    }

    public function getSorterSelect() {
        $openSelectTag = '<select name="' . Sorter::SORT .'">';
        $closeSelectTag = '</select>';

        $optionsString = '';

        foreach (Sorter::ORDER as $key => $value) {
            $optionsString .= '<option value="'. $key .'">' . $value . '</option>';
        }

        return $openSelectTag . $optionsString . $closeSelectTag;
    }

    public function getConfirmBtn() {
        return '<button type="submit" class="' . $this->confirmClass .'">' . $this->confirmButtonName .'</button>';
    }

    /**
     * @param mixed $params
     */
    public function setParams($params): void {
        $this->params = $params;
    }

    public function getParams() {
        return $this->params;
    }

    public function getHtml() {
        return $this->html;
    }

    public function setHtml($html) {
        $this->html = $html;
    }

    /**
     * @return mixed
     */
    public function getUri() {
        return $this->uri;
    }

    /**
     * @param mixed $uri
     */
    public function setUri($uri): void {
        $this->uri = $uri;
    }


    /**
     * @return array
     */
    public function getAvailableFields(): array {
        return $this->availableFields;
    }

    /**
     * @param array $availableFields
     */
    public function setAvailableFields(array $availableFields): void {
        $this->availableFields = $availableFields;
    }

    /**
     * @return string
     */
    public function getMethod(): string {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method): void {
        $this->method = $method;
    }

}