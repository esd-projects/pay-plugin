<?php
/**
 * File: PayPlugin.php
 * User: 4213509@qq.com
 * Date: 2019-06-17
 * Time: ${Time}
 **/

namespace ESD\Plugins\Pay;


use ESD\Core\Context\Context;
use ESD\Core\PlugIn\AbstractPlugin;
use ESD\Plugins\Pay\Config\PayConfig;

class PayPlugin extends AbstractPlugin
{

    /**
     * @var PayConfig|null
     */
    protected $payConfig;

    /**
     * ActorPlugin constructor.
     * @param PayConfig|null $payConfig
     * @throws \ReflectionException
     */
    public function __construct(?PayConfig $payConfig = null)
    {
        parent::__construct();
        if ($payConfig == null) {
            $payConfig = new PayConfig();
        }
        $this->payConfig = $payConfig;
    }


    /**
     * @return string
     */
    public function getName(): string
    {
        // TODO: Implement getName() method.
        return 'Pay';
    }

    /**
     * 初始化
     * @param Context $context
     * @return mixed
     * @throws \ESD\Core\Plugins\Config\ConfigException
     */
    public function beforeServerStart(Context $context)
    {
        $this->payConfig->merge();
    }

    /**
     * 在进程启动前
     * @param Context $context
     * @return mixed
     */
    public function beforeProcessStart(Context $context)
    {
        $this->ready();
    }
}