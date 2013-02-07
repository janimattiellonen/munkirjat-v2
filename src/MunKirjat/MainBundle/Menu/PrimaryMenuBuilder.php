<?php
namespace MunKirjat\MainBundle\Menu;

use Knp\Menu\FactoryInterface,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\DependencyInjection\ContainerAware,
    Symfony\Component\Security\Core\SecurityContext,
    Symfony\Bundle\FrameworkBundle\Translation\Translator;

class PrimaryMenuBuilder extends ContainerAware
{
    /**
     * @var FactoryInterface
     */
    protected $factory;

    /**
     * @var SecurityContext
     */
    protected $securityContext;

    /**
     * @var Translator
     */
    protected $translator;

    /**
     * @param FactoryInterface $factory
     * @param SecurityContext $securityContext
     * @param Translator $translator
     */
    public function __construct(FactoryInterface $factory, SecurityContext $securityContext, Translator $translator)
    {
        $this->factory          = $factory;
        $this->securityContext  = $securityContext;
        $this->translator       = $translator;
    }

    /**
     * @param Request $request
     * @return \Knp\Menu\ItemInterface
     */
    public function createMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');
        $menu->setCurrentUri($request->getRequestUri() );

        $menu->addChild($this->translator->trans('menu.frontpage'), array('route' => 'munkirjat_book_test') );
        $menu->addChild($this->translator->trans('menu.about'), array('route' => 'munkirjat_book_test') );
        $menu->addChild($this->translator->trans('menu.list-authors'), array('route' => 'munkirjat_book_test') );
        $menu->addChild($this->translator->trans('menu.list-genres'), array('route' => 'munkirjat_book_test') );
        $menu->addChild($this->translator->trans('menu.statistics'), array('route' => 'munkirjat_book_test') );

        if($this->securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED') )
        {
            $menu->addChild($this->translator->trans('menu.add-new-book'), array('route' => 'munkirjat_book_test') );
            $menu->addChild($this->translator->trans('menu.add-new-author'), array('route' => 'munkirjat_book_test') );
            $menu->addChild($this->translator->trans('menu.add-new-genre'), array('route' => 'munkirjat_book_test') );
            $menu->addChild($this->translator->trans('menu.logout'), array('route' => 'munkirjat_book_test') );
        }
        else
        {
            $menu->addChild($this->translator->trans('menu.login'), array('route' => 'fos_user_security_login') );
        }

        return $menu;
    }
}
