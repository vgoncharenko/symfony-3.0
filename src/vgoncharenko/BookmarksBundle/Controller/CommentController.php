<?php

namespace vgoncharenko\BookmarksBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use vgoncharenko\BookmarksBundle\Entity\Comment;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class CommentController extends Controller
{
    /**
     * Bookmark entity object name.
     */
    const COMMENT_ENTITY = 'vgoncharenkoBookmarksBundle:Comment';

    /**
     * Add comment.
     *
     * @Route("/comment/add/{bookmark_uid}", requirements={
     *     "bookmark_uid": "\d+"
     * })
     * @Method({"POST"})
     */
    public function add($bookmark_uid, Request $request)
    {
        $text = $request->request->get('text');
        $ip = $request->getClientIp();

        $bookmark = $this->getDoctrine()
            ->getRepository(BookmarkController::BOOKMARK_ENTITY)
            ->findOneBy(['uid' => $bookmark_uid]);

        if ($text === null || $bookmark === null) {
            throw $this->createNotFoundException();
        }

        $em = $this->getDoctrine()->getManager();
        $comment = new Comment();
        $comment->setText($text);
        $comment->setBookmark($bookmark);
        $comment->setIp($ip);
        $comment->setCreatedAt(new \DateTime());

        $em->persist($comment);
        $em->flush();

        return new JsonResponse(['uid' => $comment->getUid()]);
    }

    /**
     * Update comment.
     *
     * @Route("/comment/{uid}", requirements={
     *     "uid": "\d+"
     * })
     * @Method({"POST"})
     */
    public function comment($uid, Request $request)
    {
        $text = $request->request->get('text');

        /** @var Comment $comment */
        $comment = $this->getDoctrine()
            ->getRepository(self::COMMENT_ENTITY)
            ->findOneBy(['uid' => $uid]);

        if ($comment === null || $text === null) {
            throw $this->createNotFoundException();
        }

        if ($this->isCommentEditable($comment, $request)) {
            $em = $this->getDoctrine()->getManager();
            $comment->setText($text);

            $em->persist($comment);
            $em->flush();
        }

        return new JsonResponse(['uid' => $comment->getUid()]);
    }

    /**
     * Delete comment.
     *
     * @Route("/comment/{uid}", requirements={
     *     "uid": "\d+"
     * })
     * @Method({"DELETE"})
     */
    public function delete($uid, Request $request)
    {
        /** @var Comment $comment */
        $comment = $this->getDoctrine()
            ->getRepository(self::COMMENT_ENTITY)
            ->findOneBy(['uid' => $uid]);

        if (!$comment) {
            throw $this->createNotFoundException();
        }

        if ($this->isCommentEditable($comment, $request)) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($comment);
            $em->flush();
        }

        return $this->render('vgoncharenkoBookmarksBundle:Default:comment_delete.html.twig');
    }

    /**
     * Check if comment is editable.
     *
     * @param Comment $comment
     * @param Request $request
     * @return bool
     */
    private function isCommentEditable(Comment $comment, Request $request)
    {
        return $comment->getIp() === $request->getClientIp()
            && new \DateTime('-1 hour') < $comment->getCreatedAt();
    }
}
