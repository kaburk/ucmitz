<?php
/**
 * baserCMS :  Based Website Development Project <https://basercms.net>
 * Copyright (c) NPO baser foundation <https://baserfoundation.org/>
 *
 * @copyright     Copyright (c) NPO baser foundation
 * @link          https://basercms.net baserCMS Project
 * @since         5.0.0
 * @license       https://basercms.net/license/index.html MIT License
 */

namespace BcContentLink\Service;

use BcContentLink\Model\Table\ContentLinksTable;
use Cake\Datasource\EntityInterface;
use Cake\ORM\TableRegistry;
use BaserCore\Annotation\NoTodo;
use BaserCore\Annotation\Checked;
use BaserCore\Annotation\UnitTest;

/**
 * ContentLinksService
 * @property ContentLinksTable $ContentLinks
 */
class ContentLinksService implements ContentLinksServiceInterface
{

    /**
     * Constructor
     * @checked
     * @noTodo
     */
    public function __construct()
    {
        $this->ContentLinks = TableRegistry::getTableLocator()->get('BcContentLink.ContentLinks');
    }

    /**
     * 単一データ取得
     * @param int $id
     * @return EntityInterface
     * @checked
     * @noTodo
     */
    public function get($id, $options = [])
    {
        $options = array_merge([
            'status' => ''
        ], $options);
        $conditions = [];
        if($options['status'] === 'publish') {
            $conditions = $this->ContentLinks->Contents->getConditionAllowPublish();
        }
        return $this->ContentLinks->get($id, [
            'contain' => ['Contents' => ['Sites']],
            'conditions' => $conditions
        ]);
    }

    /**
     * 新規登録
     * @param array $postData
     * @return \Cake\Datasource\EntityInterface
     * @checked
     * @noTodo
     */
    public function create(array $postData)
    {
        $entity = $this->ContentLinks->newEntity(['url' => '']);
        $entity = $this->ContentLinks->patchEntity($entity, $postData);
        return $this->ContentLinks->saveOrFail($entity);
    }

    /**
     * リンクを更新する
     * @param EntityInterface $target
     * @param array $postData
     * @return EntityInterface
     * @throws \Cake\ORM\Exception\PersistenceFailedException
     * @checked
     * @noTodo
     */
    public function update(EntityInterface $target, array $postData): ?EntityInterface
    {
        $entity = $this->ContentLinks->patchEntity($target, $postData);
        return $this->ContentLinks->saveOrFail($entity);
    }

}
