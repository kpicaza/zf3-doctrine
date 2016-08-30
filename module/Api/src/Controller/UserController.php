<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Api\Controller;

use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\Json\Json;
use Api\Module;

class UserController
    extends AbstractRestfulController
{

    protected $_table;
    protected $_config;
    protected $_doctrine;

    public function __construct(\Doctrine\ORM\EntityManager $doctrine)
    {

        $this->_config = Module::getConfig();
        $this->_doctrine = $doctrine;
    }

    public function getList()
    {

        $products = $this->_doctrine->getRepository('Api\Models\Product');

        $result = array();
        $users = $products->findAll();

        foreach ($users as $user) {
            $result[] = $user->toArray();
        }

        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine(
            'Content-Type', 'application/json'
        );
        $response->setContent(Json::encode($result));

        return $response;

    }

    public function get($id)
    {

        $products = $this->_doctrine->getRepository('Api\Models\Product');
        $product = $products->find($id);
        $result = $product->toArray();

        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine(
            'Content-Type', 'application/json'
        );
        $response->setContent(Json::encode($result));

        return $response;

    }

    public function create($data)
    {

        $model = new \Api\Models\Product();
        $model->setName($data['name']);

        $this->_doctrine->persist($model);
        $this->_doctrine->flush();

        $result = array(
            'id' => $model->getId()
        );

        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine(
            'Content-Type', 'application/json'
        );
        $response->setContent(Json::encode($result));

        return $response;

    }

    public function update($id, $data)
    {

        $products = $this->_doctrine->getRepository('Api\Models\Product');
        $product = $products->find($id);

        $product->setName($data['name']);

        $this->_doctrine->persist($product);
        $this->_doctrine->flush();

        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine(
            'Content-Type', 'application/json'
        );
        $response->setContent(Json::encode(array()));

        return $response;

    }

    public function replaceList($data)
    {
        return $this->_methodNotAllowed();
    }

    public function delete($id)
    {

        $products = $this->_doctrine->getRepository('Api\Models\Product');
        $product = $products->find($id);

        $this->_doctrine->remove($product);
        $this->_doctrine->flush();

        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine(
            'Content-Type', 'application/json'
        );
        $response->setContent(Json::encode(array()));

        return $response;

    }

    public function deleteList($data)
    {
        return $this->_methodNotAllowed();
    }

    protected function _methodNotAllowed()
    {

        $this->response->getHeaders()->addHeaderLine(
            'Content-Type', 'application/json'
        );

        $this->response->setContent(
            Json::encode(array('content' => 'Method Not Allowed'))
        );

        $this->response->setStatusCode(405);

        return $this->response;

    }

}
