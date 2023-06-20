<?php

declare(strict_types=1);

namespace MyApp\Tasks;

use Phalcon\Cli\Task;

class CurrentTask extends Task
{
    public function mainAction()
    {
        echo 'This is the default task and the default action' . PHP_EOL;
        $collection = $this->mongo->order;
        $data = $collection->find();
        foreach ($data as  $value) {
            # code...
            print_r($value);
        }

        echo 'This is the default task and the default action' . PHP_EOL;
        $filter  = [];
        $options = ['sort' => ['rating' => 1]];

        $collection_new = $this->mongo->product;

        $cursor = $collection_new->find($filter, $options);
        foreach ($cursor as $doc) {
            print_r($doc);
        }
        die;
    }
    public function orderAction($pid, $pname, $price)
    {
        $collection = $this->mongo->order;

        $data = $collection->insertOne(["pid" => $pid, "name" => $pname, "price" => $price]);
        print_r($data->getInsertedCount());
        echo 'Order placed ' . PHP_EOL;
        die;
    }
    public function productAction($pid, $pname, $price)
    {
        $collection = $this->mongo->product;

        $data = $collection->insertOne(["pid" => $pid, "name" => $pname, "price" => $price, "rating" => 0]);
        print_r($data->getInsertedCount());
        echo 'Inserted product ' . PHP_EOL;
        die;
    }
    public function ratingAction($pid)
    {

        echo 'Enter ratings for particular product from 0-5 ' . PHP_EOL;
        $r = (int)readline('Enter a no.: ');
        $collection_new = $this->mongo->product;
        $data = $collection_new->updateOne(["pid" => $pid], ['$set' => ["rating" => $r]]);
        print_r($data->getmodifiedCount());
        echo 'Modified ratings for particular product ' . PHP_EOL;
    }
}
