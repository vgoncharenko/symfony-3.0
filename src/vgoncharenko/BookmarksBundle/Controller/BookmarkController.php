<?php

namespace vgoncharenko\BookmarksBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use vgoncharenko\BookmarksBundle\Entity\Bookmark;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class BookmarkController extends Controller
{
    /**
     * Bookmark entity object name.
     */
    const BOOKMARK_ENTITY = 'vgoncharenkoBookmarksBundle:Bookmark';

    /**
     * Return list of bookmarks.
     *
     * @Route("/bookmarks/{limit}", defaults={"limit" = 10}, requirements={
     *     "limit": "\d+"
     * })
     * @Method({"GET"})
     */
    public function getBookmarks($limit)
    {
        $bookmarks = $this->getDoctrine()
            ->getRepository(self::BOOKMARK_ENTITY)
            ->findBy([], null, $limit);

        if (!$bookmarks) {
            throw $this->createNotFoundException();
        }

        return $this->prepareResponse($bookmarks);
    }

    /**
     * Return bookmark by URL.
     *
     * @Route("/bookmark/{url}", requirements={
     *     "limit": "\s+"
     * })
     * @Method({"GET"})
     */
    public function getBookmarkByUrl($url)
    {
        $bookmark = $this->getDoctrine()
            ->getRepository(self::BOOKMARK_ENTITY)
            ->findOneBy(['url' => $url]);

        if (!$bookmark) {
            throw $this->createNotFoundException();
        }

        return $this->prepareResponse($bookmark);
    }

    /**
     * Add bookmark.
     *
     * @Route("/bookmark")
     * @Method({"POST"})
     */
    public function bookmark(Request $request)
    {
        $url = $request->request->get('url');

        if ($url === null) {
            throw $this->createNotFoundException();
        }

        /** @var Bookmark $bookmark */
        $bookmark = $this->getDoctrine()
            ->getRepository(self::BOOKMARK_ENTITY)
            ->findOneBy(['url' => $url]);

        if (!$bookmark) {
            $em = $this->getDoctrine()->getManager();
            $bookmark = new Bookmark();
            $bookmark->setUrl($url);
            $bookmark->setCreatedAt(new \DateTime());

            $em->persist($bookmark);
            $em->flush();
        }

        return new JsonResponse(['uid' => $bookmark->getUid()]);
    }

    /**
     * Prepare response.
     *
     * @param $entity
     * @return mixed
     */
    protected function prepareResponse($entity)
    {
        $serializer = $this->get('serializer');
        $json = $serializer->serialize($entity, 'json');

        return $this->render('vgoncharenkoBookmarksBundle:Default:index.html.twig', ['json' => $json]);
    }
}
