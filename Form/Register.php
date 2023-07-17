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

namespace TheliaHybridAuth\Form;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Thelia\Core\Translation\Translator;
use Thelia\Form\CustomerCreateForm;
use Symfony\Component\Validator\Constraints;
use Thelia\Model\ConfigQuery;
use TheliaHybridAuth\TheliaHybridAuth;

/**
 * Class Register
 * @package TheliaHybridAuth\Form
 * @author Tom Pradat <tpradat@openstudio.fr>
 */
class Register extends CustomerCreateForm
{
    public static function getName(): string
    {
        return 'register_hybrid_auth';
    }

    public function buildForm(): void
    {
        parent::buildForm();

        // override 'password' and 'password_confirm' to change type to hidden
        $this->formBuilder
            ->add('password', HiddenType::class, [
                'constraints' => [
                    new Constraints\NotBlank(),
                    new Constraints\Length(['min' => ConfigQuery::read('password.length', 4)]),
                ],
                'label' => Translator::getInstance()->trans('Password', [], TheliaHybridAuth::DOMAIN_NAME),
                'label_attr' => [
                    'for' => 'password',
                ],
            ])
            ->add('password_confirm', HiddenType::class, [
                'constraints' => [
                    new Constraints\NotBlank(),
                    new Constraints\Length(['min' => ConfigQuery::read('password.length', 4)]),
                    new Constraints\Callback(['methods' => [
                        [$this, 'verifyPasswordField'],
                    ]]),
                ],
                'label' => Translator::getInstance()->trans(
                    'Password confirmation',
                    [],
                    TheliaHybridAuth::DOMAIN_NAME
                ),
                'label_attr' => [
                    'for' => 'password_confirmation',
                ],
            ])
            ->add('provider', HiddenType::class, [])
        ;
    }
}
