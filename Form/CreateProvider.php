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

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints;
use Thelia\Core\Translation\Translator;
use TheliaHybridAuth\TheliaHybridAuth;

/**
 * Class CreateProvider
 * @package TheliaHybridAuth\Form
 * @author Tom Pradat <tpradat@openstudio.fr>
 */
class CreateProvider extends BaseProvider
{
    public function buildForm()
    {
        $this->formBuilder
            ->add('name', TextType::class, [
                'required' => true,
                'label' => Translator::getInstance()->trans('Name', [], TheliaHybridAuth::DOMAIN_NAME),
                'label_attr' => [
                    'for' => 'name'
                ],
                "constraints" => [
                    new Constraints\NotBlank()
                ],
            ])
            ->add('id', TextType::class, [
                'required' => true,
                'label' => 'Id',
                'label_attr' => [
                    'for' => 'id'
                ],
                "constraints" => [
                    new Constraints\NotBlank()
                ],
            ])
            ->add('secret', TextType::class, [
                'required' => true,
                'label' => Translator::getInstance()->trans('Secret', [], TheliaHybridAuth::DOMAIN_NAME),
                'label_attr' => [
                    'for' => 'secret'
                ],
                "constraints" => [
                    new Constraints\NotBlank()
                ],
            ])
            ->add('scope', TextType::class, [
                'label' => Translator::getInstance()->trans('Scope', [], TheliaHybridAuth::DOMAIN_NAME),
                'label_attr' => [
                    'for' => 'scope'
                ]
            ])
        ;
    }

    public static function getName(): string
    {
        return 'create_provider';
    }
}
