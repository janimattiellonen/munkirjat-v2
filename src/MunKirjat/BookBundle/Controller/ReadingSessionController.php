<?php
namespace MunKirjat\BookBundle\Controller;

use MunKirjat\Component\Controller\Controller;

class ReadingSessionController extends Controller
{
    public function newSessionAction()
    {
        $book = $this->getBookService()->getCurrentlyReadBook(false);

        if (!$book) {
            return $this->createJsonFailureResponse(['message' => 'No book started']);
        }

        $readingSession = $this->getBookService()->startNewReadingSession($book);

        return $this->getJsonResponse([
            'id' => $readingSession->getId(),
            'hasOpenSession' => true,
            'startingDate' => $readingSession->getStartingDate()->format('d.m.Y'),
            'startingTime' => $readingSession->getStartingDate()->format('H:i'),
            'startingPage' => $readingSession->getStartingPage(),
            'endingDate' => '',
            'endingTime' => '',
            'endingPage' => '',
        ]);
    }

    public function getSessionInfoAction()
    {
        $currentlyReadBook = $this->getBookService()->getCurrentlyReadBook(false);

        $hasOpenReadingSession = false;

        if ($currentlyReadBook) {
            if ($currentlyReadBook->hasOpenReadingSession()) {
                $hasOpenReadingSession = true;
            }

            $session = $currentlyReadBook->getCurrentReadingSession();

            $data = [
                'title' => $currentlyReadBook->getTitle(),
                'authors' => $currentlyReadBook->getAuthorsAsString(),
                'hasOpenSession' => $hasOpenReadingSession,
            ];

            if ($session) {

                $endingDate = $session->getEndingDate();

                $additionalData = [
                    'startingDate' => $session->getStartingDate()->format('d.m.Y'),
                    'startingTime' => $session->getStartingDate()->format('H:i'),
                    'startingPage' => $session->getStartingPage(),
                    'endingDate' => isset($endingDate) ? $endingDate->format('d.m.Y') : '',
                    'endingTime' => isset($endingDate) ? $endingDate->format('H:i') : '',
                    'endingPage' => $session->getEndingPage(),
                ];

                if($hasOpenReadingSession) {
                    $additionalData['id'] = $session->getId();
                }

                $data += $additionalData;
            }

            return $this->getJsonResponse($data);
        }

        return $this->getJsonResponse([]);
    }

    public function endSessionAction($id)
    {
        $currentlyReadBook = $this->getBookService()->getCurrentlyReadBook(false);

        $date = $this->getRequest()->request->get('endingDate');
        $time = $this->getRequest()->request->get('endingTime');
        $endingPage = $this->getRequest()->request->get('endingPage');
        $endingDate = \DateTime::createFromFormat('d.m.Y H:i', "$date $time");

        $this->getBookService()->endReadingSession($currentlyReadBook, $endingDate, $endingPage);

        return $this->getJsonResponse([$this->getRequest()->request->all()]);
    }
}
