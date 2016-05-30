<?php

class up2FieldsGetListProcessor extends modObjectGetListProcessor
{
    public $classKey = 'up2Fields';
    public $defaultSortField = 'rank';
    public $defaultSortDirection = 'asc';
    public $permission = '';

    /** {@inheritDoc} */
    public function initialize()
    {
        if (!$this->modx->hasPermission($this->permission)) {
            return $this->modx->lexicon('access_denied');
        }

        return parent::initialize();
    }

    /** {@inheritDoc} */
    public function prepareQueryBeforeCount(xPDOQuery $c)
    {

        $c->leftJoin('up2TypeField', 'up2TypeField', '`up2Fields`.`type` = `up2TypeField`.`id`');
        $columns = $this->modx->getSelectColumns('up2Fields', 'up2Fields', '', array(), true);
        $c->select($columns . ', `up2TypeField`.`name` as `type_name`');

        if ($active = $this->getProperty('active')) {
            $c->where(array('active' => $active));
        }
        if ($tab = $this->getProperty('tab')) {
            $c->where(array('tab:=' => $tab));
        }
        if ($this->getProperty('combo')) {
            $c->select('id,name');
            $c->where(array('active' => 1));
        }

        return $c;
    }

    /** {@inheritDoc} */
    public function getData()
    {
        $data = array();
        $limit = intval($this->getProperty('limit'));
        $start = intval($this->getProperty('start'));
        /* query for chunks */
        $c = $this->modx->newQuery($this->classKey);
        $c = $this->prepareQueryBeforeCount($c);
        $data['total'] = $this->modx->getCount($this->classKey, $c);
        $c = $this->prepareQueryAfterCount($c);
        $sortClassKey = $this->getSortClassKey();
        $sortKey = $this->modx->getSelectColumns($sortClassKey, $this->getProperty('sortAlias', $sortClassKey), '',
            array($this->getProperty('sort')));
        if (empty($sortKey)) {
            $sortKey = $this->getProperty('sort');
        }
        $c->sortby($sortKey, $this->getProperty('dir'));
        if ($limit > 0) {
            $c->limit($limit, $start);
        }
        if ($c->prepare() && $c->stmt->execute()) {
            $data['results'] = $c->stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $data;
    }

    /** {@inheritDoc} */
    public function iterate(array $data)
    {
        $list = array();
        $list = $this->beforeIteration($list);
        $this->currentIndex = 0;
        /** @var xPDOObject|modAccessibleObject $object */
        foreach ($data['results'] as $array) {
            $list[] = $this->prepareArray($array);
            $this->currentIndex++;
        }
        $list = $this->afterIteration($list);

        return $list;
    }

    /** {@inheritDoc} */
    public function prepareArray(array $data)
    {
        $data['required'] = (int)$data['required'];
        $data['readonly'] = (int)$data['readonly'];
        $data['editable'] = (int)$data['editable'];
        $data['active'] = (int)$data['active'];

        return $data;
    }
}

return 'up2FieldsGetListProcessor';