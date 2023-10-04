<?php
/*************************************************************************************/
/*      This file is part of the TheliaHybridAuth package.                           */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace TheliaHybridAuth\Hook;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Thelia\Core\Event\Hook\HookRenderBlockEvent;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;
use Thelia\Core\Template\Assets\AssetResolverInterface;
use Thelia\Core\Template\TemplateDefinition;
use Thelia\Core\Translation\Translator;
use TheliaHybridAuth\TheliaHybridAuth;
use TheliaSmarty\Template\SmartyParser;

/**
 * Class FrontHook
 * @package TheliaHybridAuth\Hook
 * @author Tom Pradat <tpradat@openstudio.fr>
 */
class FrontHook extends BaseHook
{
    public function __construct(
        SmartyParser $parser = null,
        AssetResolverInterface $resolver = null,
        EventDispatcherInterface $eventDispatcher = null,
        protected RequestStack $requestStack
    ) {
        parent::__construct($parser, $resolver, $eventDispatcher);
    }

    // Register
    public function onRegisterTop(HookRenderEvent $event)
    {
        // we don't display register buttons when the user is registering with a provider
        if (strcmp($this->requestStack->getCurrentRequest()->get('_route'), 'hybridauth.register.get') !== 0
            && strcmp($this->requestStack->getCurrentRequest()->get('_route'), 'hybridauth.register.post') !== 0) {
            $event->add($this->render('hybrid-auth-register-buttons.html'));
        }
    }

    // Login
    public function onLoginFormTop(HookRenderEvent $event)
    {
        $event->add($this->render('hybrid-auth-login-buttons.html'));
    }

    public function onLoginMainBottom(HookRenderEvent $event)
    {
        $event->add($this->render('hybrid-auth-login-dialog.html'));
    }

    public function onLoginJavascriptInitialization(HookRenderEvent $event)
    {
        $event->add($this->render('hybrid-auth-login-dialog-js.html'));
    }

    // Account
    public function onAccountAdditional(HookRenderBlockEvent $event)
    {
        $event->add(array(
            "type" => TemplateDefinition::FRONT_OFFICE,
            "id" => 'socials',
            "code" => 'account.additional',
            "title" => Translator::getInstance()->trans(
                'social networks associated',
                array(),
                TheliaHybridAuth::DOMAIN_NAME
            ),
            "content" => $this->render('providers-list-account.html')
        ));
    }

    public function onAccountAfterJavascriptInclude(HookRenderEvent $event)
    {
        $event->add($this->render('providers-list-account-js.html'));
    }

    public function onMainStylesheet(HookRenderEvent $event)
    {
        $event->add($this->addCSS('assets/css/zocial.css'));
        $event->add($this->addCSS('assets/css/style.css'));
    }

    public function onMainJavascriptInitialization(HookRenderEvent $event)
    {
        $event->add($this->render('js-login-buttons.html'));
    }
}
