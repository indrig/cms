<?php
namespace Indrig\Table;

use Indrig\Table\Element\AbstractElement,
    Indrig\Table\Element\Header,
    Indrig\Table\Adapter\AdapterInterface,
    Zend\Http\Request,
    Zend\Http\Response;

class Table extends AbstractElement
{
    const RENDER_HTML = 0;
    const RENDER_JSON = 1;
    protected $headers = array();
    protected $id;
    protected static $auto_id = 0;
    protected $renderType  = null;

    /**
     * @var \Indrig\Table\Adapter\AdapterInterface
     */
    protected $adapter  = null;
    protected $data     = array();

    /**
     * @var Request
     */
    protected $request  = null;
    /**
     * @param null|string $name
     * @param null|Header|array $headerOrElement
     * @return $this
     */
    public function addHeader($name = null, $headerOrElement = null)
    {
        if(is_array($headerOrElement))
        {
            $header = new Header($name, $headerOrElement);
            $this->headers[$name] = $header;
            return $this;
        }

        if($headerOrElement instanceof Header)
        {
            $this->headers[$name] = $headerOrElement;
            return $this;
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }


    public function setId($id)
    {
        $this->id = $id;
        return $id;
    }

    public function getId()
    {
        if(!$this->id)
        {
            $this->id = 'table'.++self::$auto_id;
        }
        return $this->id;
    }

    public function setOptions($options)
    {
        if(isset($options['id']))
        {
            $this->setId($options['id']);
            unset($options['id']);
        }

        parent::setOptions($options);
    }

    /**
     * @param AdapterInterface $adapter
     * @return $this
     */
    public function setAdapter(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
        return $this;
    }

    /**
     * @return AdapterInterface|null
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    public function getData()
    {
        if($this->data)
            return $this->data;

        $request = $this->getRequest();
        if($request)
        {
            $this->getAdapter()->setCurrentPageNumber(intval($request->getQuery('page')));
            $this->getAdapter()->setItemCountPerPage(intval($request->getQuery('per_page', $this->getAdapter()->getItemCountPerPage())));
        }
        return ($this->data = $this->getAdapter()->getData());
    }


    public function getRequest()
    {
        return $this->request;
    }

    public function setRequest($request)
    {
        $this->request = $request;
        $this->getRenderType();
        return $this;
    }

    public function setRenderType($renderType)
    {
        $this->renderType = $renderType;
        return $this;
    }

    public function getRenderType()
    {

        if($this->renderType === null)
        {
            $request = $this->getRequest();
            if($request === null)
            {
                return ($this->renderType = self::RENDER_HTML);
            }

            /**
             *  @var \Zend\Http\Header\Accept $accept
             */
            $accept = $this->getRequest()->getHeader('Accept');
            /**
             * @var \Zend\Http\Header\Accept\FieldValuePart\AcceptFieldValuePart $part
             */
            $acceptPrioritized = $accept->getPrioritized();
            foreach($acceptPrioritized as $part)
            {
                switch($part->getFormat())
                {
                    case 'json':
                        return ($this->renderType = self::RENDER_JSON);
                }
            }
            return ($this->renderType = self::RENDER_HTML);
            /*{
                return self::RENDER_JSON;
            }
            else
            {

            }*/
            //var_dump($acceptPrioritized);
           // exit;

        }
        return $this->renderType;
    }

    public function isCustomRender()
    {
        $renderType = $this->getRenderType();
        return $renderType !== null && $renderType !== self::RENDER_HTML;
    }

    public function customRender(Response $response)
    {
        $type = $this->getRenderType();
        /**
         * @var \Zend\Paginator\Paginator $data
         */
        $data = $this->getData();
        $a = array();

        $keys = array_keys($this->getHeaders());
        foreach($data as $v)
        {
            $tmp = array();
            foreach($keys as $key)
            {
                $tmp[] = $v->$key;
            }
            $a[] = $tmp;
        }

        return $response->setContent(json_encode(array(
            'data'              => $a,
            'total'             => $this->getAdapter()->getTotalItemCount(),
            'page'              => $this->getAdapter()->getCurrentPageNumber(),
            'per_page'          =>$this->getAdapter()->getItemCountPerPage(),

        )));
    }
}