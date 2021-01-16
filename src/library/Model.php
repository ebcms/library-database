<?php

declare(strict_types=1);

namespace Ebcms\Database;

abstract class Model
{

    protected $db;

    public function __construct(
        Db $db
    ) {
        $this->db = $db;
    }

    public function db(): Db
    {
        return $this->db;
    }

    public function get($field = '*', $where = null)
    {
        return $this->db->slave()->get($this->getTable(), $field, $where);
    }

    public function has($where = null)
    {
        return $this->db->slave()->has($this->getTable(), $where);
    }

    public function select($field = '*', $where = null)
    {
        return $this->db->slave()->select($this->getTable(), $field, $where);
    }

    public function insert(array $data = [])
    {
        return $this->db->master()->insert($this->getTable(), $data);
    }

    public function update(array $data, $where = null)
    {
        return $this->db->master()->update($this->getTable(), $data, $where);
    }

    public function delete($where)
    {
        return $this->db->master()->delete($this->getTable(), $where);
    }

    public function replace($column, $where = null)
    {
        $this->db->master()->replace($this->getTable(), $column, $where);
    }

    public function id()
    {
        return (int) $this->db->master()->id();
    }

    public function rand($field = null, $where = null)
    {
        return $this->db->slave()->rand($this->getTable(), $field, $where);
    }

    public function count($where = null)
    {
        return $this->db->slave()->count($this->getTable(), $where);
    }

    public function max($column = null, $where = null)
    {
        return $this->db->slave()->max($this->getTable(), $column, $where);
    }

    public function min($column = null, $where = null)
    {
        return $this->db->slave()->min($this->getTable(), $column, $where);
    }

    public function avg($column = null, $where = null)
    {
        return $this->db->slave()->avg($this->getTable(), $column, $where);
    }

    public function sum($column = null, $where = null)
    {
        return $this->db->slave()->sum($this->getTable(), $column, $where);
    }

    abstract public function getTable(): string;
}
