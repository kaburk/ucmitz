<?php
/**
 * baserCMS :  Based Website Development Project <https://basercms.net>
 * Copyright (c) baserCMS User Community <https://basercms.net/community/>
 *
 * @copyright     Copyright (c) baserCMS User Community
 * @link          https://basercms.net baserCMS Project
 * @since         5.0.0
 * @license       http://basercms.net/license/index.html MIT License
 */

namespace BaserCore\Controller\Component;
use Cake\Controller\Component;

/**
 * Class BcMessageComponent
 * 表示面へのメッセージをコントロールする為のコンポーネント
 * @package BaserCore\Controller\Component
 */
class BcMessageComponent extends Component {

    /**
     * @var FlashComponent FlashComponent
     */
    // public $Flash;
    public $components = ['Flash'];

    /**
     * Initialize
     *
     * @param Controller $controller Controller with components to initialize
     * @return void
     */
    public function initialize(array $config): void
    {
        // Todo: BcException 未定義
        // if(!isset($controller->Flash)) {
        //    throw new BcException(__d('baser', 'BcMessageComponent を利用するには、コントローラーで FlashComponent の利用設定が必要です。'));
        // }
        // $this->Flash = $controller->Flash;
    }

    /**
     * メッセージをセットする
     *
     * @param string $message メッセージ
     * @param bool $alert 警告かどうか
     * @param bool $saveDblog Dblogに保存するか
     * @param bool $setFlash flash message に保存するか
     */
    public function set($message, $alert = false, $saveDblog = false, $setFlash = true, $class = null)
    {
        if (!$class) {
            $class = 'notice-message';
            if ($alert) {
                $class = 'alert-message';
            }
        }
        if ($setFlash) {
            $this->Flash->set($message, [
                'element' => 'default',
                'params' => ['class' => $class]
            ]);
        }
        // TODO: DbLogの仕組み
        // if ($saveDblog) {
        //     $AppModel = ClassRegistry::init('AppModel');
        //     $AppModel->saveDblog($message);
        // }
    }

    /**
     * 成功メッセージをセットする
     *
     * @param $message
     * @param bool $log DBログに保存するかどうか（初期値 : true）
     */
    public function setSuccess($message, $log = true, $setFlash = true)
    {
        $this->set($message, false, $log, $setFlash);
    }

    /**
     * 失敗メッセージをセットする
     *
     * @param $message
     * @param bool $log DBログに保存するかどうか（初期値 : false）
     */
    public function setError($message, $log = false, $setFlash = true)
    {
        $this->set($message, true, $log, $setFlash, 'alert-message');
    }

    /**
     * 警告メッセージをセットする
     *
     * @param $message
     * @param bool $log DBログに保存するかどうか（初期値 : false）
     */
    public function setWarning($message, $log = false, $setFlash = true)
    {
        $this->set($message, true, $log, $setFlash, 'warning-message');
    }

    /**
     * インフォメーションメッセージをセットする
     *
     * @param $message
     * @param bool $log DBログに保存するかどうか（初期値 : false）
     */
    public function setInfo($message, $log = false, $setFlash = true)
    {
        $this->set($message, false, $log, $setFlash, 'info-message');
    }

}
