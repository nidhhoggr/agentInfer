<?php
interface Selection {

    public function find($args);

    public function findBy($args);

    public function findOneBy($args);

    public function getQuery();
}
