<?php

require_once(dirname(__FILE__) . '/../SupraModel.class.php');

//SET THE CONNECTION VARS HERE
$dbuser = 'root';
$dbpassword  = 'root';
$dbname = 'bob_birdfinder';
$dbhost = 'localhost';
$driver = 'mysql';

$connection_args = compact('dbuser','dbname','dbpassword','dbhost','driver');

//EXTEND THE BASE MODEL
class BirdModel extends SupraModel {

    //SET THE TABLE OF THE MODEL AND THE IDENTIFIER
    public function configure() {

        $this->setTable("bird");
    }
}

$BirdModel = new BirdModel($connection_args);

//find all by specific conditions and return array
  $birds = $BirdModel->findBy(array('conditions'=>array("id=195"),'fetchArray'=>false)));

//change the table
  $BirdModel->setTable('bird_taxonomy');

//find one bird
  var_dump($BirdModel->findOneBy(array('conditions'=>"name LIKE '%arizona%'")));
//get the sql query
  var_dump($BirdModel->getQuery());

//change the table again 
  $BirdModel->setTable('bird');

//save a new bird and serialize the colors into the database
  $BirdModel->name = 'toojay';
  $BirdModel->colors = array('black','white');
//returns the id
  $bird_id = $BirdModel->save();

//bind objects!!
  $bird = $BirdModel->findOneBy(array('conditions'=>"name LIKE '%arizona%'"));

  $bird->locations = array('arizona','nevada');

  $BirdModel->bindObject($BirdModel, $bird);

  //its saves all properties and the new bound properties
  $bird_id = $BirdModel->save();

