<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Api\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\Json\Json;

class ProductsController extends AbstractRestfulController
{
    protected $_config;
    protected $_doctrine;

    public function __construct(EntityManagerInterface $doctrine, array $config)
    {
        $this->_config = $config;
        $this->_doctrine = $doctrine;
    }

    public function getList()
    {

        $repository = $this->_doctrine->getRepository('Api\Models\Product');

        $result = array();
        $products = $repository->findAll();

        foreach ($products as $product) {
            $result[] = $product->toArray();
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

        $repository = $this->_doctrine->getRepository('Api\Models\Product');
        $product = $repository->find($id);
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

        $repository = $this->_doctrine->getRepository('Api\Models\Product');
        $product = $repository->find($id);

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

        $repository = $this->_doctrine->getRepository('Api\Models\Product');
        $product = $repository->find($id);

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
