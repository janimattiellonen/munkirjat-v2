<?php
namespace MunKirjat\BookBundle\Twig\Extensions;

use MunKirjat\BookBundle\Service\BookService;

use \Twig_Environment;
use \Twig_Extension;

class Book extends Twig_Extension
{
    /**
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * @var \MunKirjat\BookBundle\Service\BookService
     */
    protected $bookService;

    /**
     * @param \Twig_Environment $twig
     * @param \MunKirjat\BookBundle\Service\BookService $bookService
     */
    public function __construct(Twig_Environment $twig, BookService $bookService)
    {
        $this->twig         = $twig;
        $this->bookService  = $bookService;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            'munkirjat_latestReadBook' => new \Twig_Function_Method(
                $this, 'latestReadBook', array('is_safe' => array('html') )
            ),
        );
    }

    /**
     * @return string
     */
    public function latestReadBook()
    {
        return $this->twig->render('MunKirjatBookBundle:Twig:latest-read-book.html.twig', array(
            'book' => $this->bookService->getLatestReadBook(),
        ) );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'book_book';
    }
}
