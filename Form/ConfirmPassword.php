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

use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;
use TheliaHybridAuth\TheliaHybridAuth;

/**
 * Class ConfirmPassword
 * @package TheliaHybridAuth\Form
 * @author Tom Pradat <tpradat@openstudio.fr>
 */
class ConfirmPassword extends BaseForm
{
    public function buildForm()
    {
        $this->formBuilder
            ->add('password', PasswordType::class, [
                'constraints' => [
                    new Constraints\NotBlank([
                        'groups' => ['existing_customer'],
                    ]),
                ],
                'label' => Translator::getInstance()->trans(
                    'Please enter your password',
                    [],
                    TheliaHybridAuth::DOMAIN_NAME
                ),
                'label_attr' => [
                    'for' => 'password',
                ],
                'required'    => false,
            ]);
    }

    public static function getName(): string
    {
        return 'hybridauth_confirm_password';
    }
}
