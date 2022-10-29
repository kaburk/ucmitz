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

namespace BcContentLink\Controller\Admin;

use BaserCore\Controller\Admin\BcAdminAppController;
use BcContentLink\Service\ContentLinksService;
use BcContentLink\Service\ContentLinksServiceInterface;
use Cake\ORM\Exception\PersistenceFailedException;
use BaserCore\Annotation\NoTodo;
use BaserCore\Annotation\Checked;
use BaserCore\Annotation\UnitTest;

/**
 * Class ContentLinksController
 *
 * リンク コントローラー
 */
class ContentLinksController extends BcAdminAppController
{

    /**
     * initialize
     * @throws \Exception
     * @checked
     * @noTodo
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('BaserCore.BcAdminContents', ['entityVarName' => 'contentLink']);
    }

    /**
     * コンテンツを更新する
     *
     * @param ContentLinksService $service
     * @param int $id
     * @return void
     * @checked
     * @noTodo
     */
    public function edit(ContentLinksServiceInterface $service, $id)
    {
        $contentLink = $service->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            try {
                $contentLink = $service->update($contentLink, $this->request->getData());
                $this->BcMessage->setSuccess(sprintf(__d('baser', "リンク「%s」を更新しました。"), $contentLink->content->title));
                return $this->redirect(['action' => 'edit', $id]);
            } catch (PersistenceFailedException $e) {
                $contentLink = $e->getEntity();
                $this->BcMessage->setError(
                    __d('baser', '入力エラーです。内容を修正してください。')
                );
            }  catch (\Exception $e) {
                $this->BcMessage->setError(
                    __d('baser', '入力エラーです。内容を修正してください。' . $e->getMessage())
                );
            }
        }
        $this->set(compact('contentLink'));
    }
}
